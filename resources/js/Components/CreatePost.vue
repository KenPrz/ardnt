<script setup>
import { ref, watch, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import Editor from '@/Components/Editor.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const toast = useToast();
const emit = defineEmits(['close']);

const blogContent = ref('Write something amazing...');
const props = defineProps({
  themes: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  title: '',
  content: '',
  theme: '',
  cover_image: null,
  is_public: false,
  is_shared: false,
  shared_post_id: null,
});

const previewImage = ref(null);

watch(
  () => form.cover_image,
  (newFile) => {
    if (newFile) {
      const reader = new FileReader();
      reader.onload = (e) => {
        previewImage.value = e.target.result;
      };
      reader.readAsDataURL(newFile);
    } else {
      previewImage.value = null;
    }
  }
);

const handleFileChange = (event) => {
  form.cover_image = event.target.files[0];
};

const removeFile = () => {
  form.cover_image = null;
};

function submitPost() {
  form.content = blogContent.value;
  form.post(route('posts.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      toast.success('Post created successfully');
      emit('close');
    },
    onError: () => {
      toast.error('Failed to create post');
    },
  });
}
</script>

<template>
  <div class="flex w-full flex-col p-5">
    <div class="flex justify-between">
      <h2 class="text-lg font-semibold text-gray-800">Create Post</h2>
    </div>
    <div class="mt-5 flex flex-col">
      <input
        v-if="!previewImage"
        type="file"
        class="w-full rounded-lg border border-gray-300 p-3"
        @change="handleFileChange"
      />
      <div v-if="previewImage" class="relative mt-4">
        <img
          :src="previewImage"
          alt="Image preview"
          class="h-auto w-full rounded-lg border border-gray-300"
        />
        <button @click="removeFile" class="absolute right-0 top-0 bg-red-500">
          <i class="pi pi-times" style="font-size: 1.2em; color: black"></i>
        </button>
      </div>
      <div>
        <InputError :message="form.errors.cover_image" />
      </div>
    </div>
    <div class="mt-5 w-full">
      <div class="py-2">
        <label for="title">Title</label>
        <TextInput class="w-full" v-model="form.title" label="Title" />
        <InputError :message="form.errors.title" />
      </div>
      <Editor v-model="blogContent">
        <div class="mb-3 flex items-center justify-center space-x-4">
          <div class="flex flex-col items-center justify-center">
            <div class="flex items-center">
              <label for="visibility" class="mr-2">Public</label>
              <Checkbox name="visibility" v-model:checked="form.is_public" />
            </div>
            <div>
              <InputError :message="form.errors.is_public" />
            </div>
          </div>
          <div class="w-w-3/4 flex flex-col">
            <select
              v-model="form.theme"
              class="rounded-lg border border-gray-300"
            >
              <option value="" disabled>Select a theme</option>
              <option
                  :value="null"
                >
                  None
              </option>
              <option v-for="theme in themes" :key="theme.id" :value="theme.id">
                {{ theme.name }}
              </option>
            </select>
            <InputError :message="form.errors.theme" />
          </div>
        </div>
      </Editor>
      <InputError :message="form.errors.content" />
    </div>
    <div class="mt-5">
      <button
        @click="submitPost"
        :disabled="form.processing"
        :class="{
          'w-full rounded-lg bg-maroon-500 p-3 text-white transition-colors duration-200 hover:bg-maroon-600':
            !form.processing,
          'w-full cursor-not-allowed rounded-lg bg-gray-400 p-3 text-gray-700':
            form.processing,
        }"
      >
        Create Post
      </button>
    </div>
  </div>
</template>

<style scoped>
input[type='file'] {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  border-radius: 0.375rem;
  padding: 0.75rem;
  cursor: pointer;
}

input[type='file']::-webkit-file-upload-button {
  visibility: hidden;
}

input[type='file']::before {
  content: 'Choose a file';
  display: inline-block;
  background: #a02334;
  color: white;
  border: 1px solid #a02334;
  border-radius: 0.375rem;
  padding: 0.5rem 1rem;
  text-align: center;
  font-size: 1rem;
  line-height: 1.5;
  cursor: pointer;
}

img {
  max-width: 100%;
  height: auto;
  border-radius: 0.375rem;
}
</style>
