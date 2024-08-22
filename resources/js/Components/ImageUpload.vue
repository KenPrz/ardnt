<script setup>
import 'vue-advanced-cropper/dist/style.css';
import { ref, watch } from 'vue';
import { Cropper } from 'vue-advanced-cropper';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
const toast = useToast();
const props = defineProps({
  currentAvatar: {
    type: String,
    required: true
  }
});

const emit = defineEmits(['update:avatar']);

const showModal = ref(false);
const imageUrl = ref(null);
const cropperRef = ref(null);

const form = useForm({
  avatar: null
});

const openModal = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  imageUrl.value = null;
};

const onFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      imageUrl.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const cropImage = () => {
  const { coordinates, canvas } = cropperRef.value.getResult();
  canvas.toBlob((blob) => {
    form.avatar = blob;
    closeModal();
  }, 'image/jpeg');
};

const uploadImage = () => {
  form.post(route('profile.avatar.store'), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success('Profile picture updated successfully');
    },
    onError: () => {
      toast.error(form.errors.avatar);
    }
  });
};

watch(() => form.avatar, (newValue) => {
  if (newValue) {
    uploadImage();
  }
});
</script>

<template>
  <div>
    <div class="relative group">
      <img :src="'/storage/'+currentAvatar" alt="Profile" 
        class="md:min-w-[15rem] md:min-h-[15rem]
               md:max-w-[15rem] md:max-h-[15rem]
               max-w-[10rem] max-h-[10rem]
               min-w-[10rem] min-h-[10rem]
               rounded-full object-cover" 
            />
      <div
        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
      >
        <button @click="openModal" class="text-white font-semibold">
          Change Photo
        </button>
      </div>
    </div>

    <Modal :show="showModal" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Update Profile Picture</h2>
        <input type="file" @change="onFileChange" accept="image/*" class="mb-4" />
        <div v-if="imageUrl" class="mb-4">
          <Cropper
            ref="cropperRef"
            :src="imageUrl"
            :stencil-props="{
              aspectRatio: 1
            }"
            class="h-64"
          />
        </div>
        <div class="flex justify-end space-x-2">
          <button @click="closeModal" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
          <button @click="cropImage" class="px-4 py-2 bg-maroon-500 text-white rounded">Crop & Save</button>
        </div>
      </div>
    </Modal>
  </div>
</template>