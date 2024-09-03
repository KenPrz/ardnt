<script setup>
import { ref, inject, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import Editor from '@/Components/Editor.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import OriginalPostContainer from '@/Components/OriginalPostContainer.vue';

const emit = defineEmits(['close']);
const toast = useToast();
const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
});

const themes = inject('themes');
const showDeleteModal = ref(false); // State to manage modal visibility

const form = useForm({
  id: props.post.id,
  title: props.post.title,
  content: props.post.content,
  theme: props.post.theme_id ?? null,
  cover_image: props.post.cover_image,
  is_public: props.post.is_public,
  is_shared: props.post.is_shared,
  shared_post_id: props.post.shared_post_id,
});

function updatePost() {
  form.put(route('posts.update', form.id), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success('Post updated successfully');
      setTimeout(() => {
        emit('close');
      }, 500);
    },
    onError: (error) => {
      console.log(error);
    },
  });
}

function deletePost() {
  form.delete(route('posts.destroy', form.id), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success('Post deleted successfully');
      setTimeout(() => {
        emit('close');
      }, 500);
    },
    onError: (error) => {
      console.log(error);
    },
  });
}
</script>

<template>
  <div
    class="flex w-full flex-col overflow-hidden rounded-lg bg-white shadow-lg"
  >
    <!-- Post Image -->
    <div v-if="post.cover_image" class="w-full">
      <img
        class="h-72 w-full rounded-t-lg object-cover"
        :src="'/storage/' + post.cover_image"
        :alt="post.title"
      />
    </div>
    <!-- Post Content -->
    <div class="p-6">
      <!-- Title -->
      <div v-if="!post.is_shared" class="mb-4 w-full">
        <TextInput
          :disabled="form.processing"
          v-model="form.title"
          label="Title"
          type="text"
          name="title"
          :errors="form.errors.title"
          class="w-full"
        />
        <InputError :message="form.errors.title" />
      </div>
      <!-- Post Meta -->
      <div class="mb-4 text-sm text-gray-500">
        <div class="mb-4 flex items-center space-x-3">
          <Checkbox
            :disabled="form.processing"
            :checked="form.is_public"
            v-model="form.is_public"
            name="is_public"
            label="Public"
            :errors="form.errors.is_public"
          />
          <span>{{ form.is_public ? 'Public' : 'Private' }}</span>
        </div>
        <InputError :message="form.errors.is_public" />
        <div>
          <label
            for="theme"
            class="mb-2 block text-sm font-medium text-gray-700"
            >Theme</label
          >
          <select
            :disabled="form.processing"
            v-model="form.theme"
            id="theme"
            class="w-full rounded-lg border border-gray-300 p-2"
          >
            <option value="" disabled>Select a theme</option>
            <option :value="null">None</option>
            <option v-for="theme in themes" :key="theme.id" :value="theme.id">
              {{ theme.name }}
            </option>
          </select>
          <InputError :message="form.errors.theme" />
        </div>
      </div>

      <!-- Excerpt -->
      <div
        class="mb-4 text-gray-700"
        :class="{
          'pointer-events-none': form.processing,
        }"
      >
        <Editor v-model="form.content">
          <button
            @click="showDeleteModal = true"
            class="me-2"
            :disabled="form.processing"
          >
            <i class="pi pi-trash" style="font-size: 1em; color: red"></i>
          </button>
        </Editor>
        <InputError :message="form.errors.content" />
      </div>

      <!-- Shared Post -->
      <div v-if="post.is_shared" class="py-2">
        <OriginalPostContainer
          :originalPost="post.original_post"
          :postSharer="post.user"
        />
      </div>
    </div>
    <!-- Update Button -->
    <div class="flex items-center p-6">
      <button
        :disabled="form.processing"
        @click="updatePost"
        :class="[
          form.processing
            ? 'bg-maroon-300'
            : 'bg-maroon-500 hover:bg-maroon-600',
          'w-full rounded-xl p-3 text-white transition-colors duration-200',
        ]"
      >
        <i
          v-show="form.processing"
          class="pi pi-spinner me-1 animate-spin"
          style="font-size: 0.9em"
        ></i>
        <span v-if="form.processing">Updating</span>
        <span v-else>Update</span> Post
      </button>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <Modal maxWidth="md" :show="showDeleteModal" @close="showDeleteModal = false">
    <template #default>
      <div class="p-6">
        <h2 class="text-lg font-semibold">Confirm Delete</h2>
        <p class="mt-2 text-sm text-gray-600">
          Are you sure you want to delete this post? This action cannot be
          undone.
        </p>
        <div class="mt-4 flex justify-end">
          <button
            @click="showDeleteModal = false"
            class="mr-2 rounded bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400"
          >
            Cancel
          </button>
          <button
            @click="deletePost, emit('close')"
            class="rounded bg-red-500 px-4 py-2 text-white hover:bg-red-600"
          >
            Delete
          </button>
        </div>
      </div>
    </template>
  </Modal>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition:
    opacity 0.5s ease,
    max-height 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  max-height: 0;
}

.fade-enter-to,
.fade-leave-from {
  opacity: 1;
  max-height: 1000px;
  overflow: hidden;
}
</style>
