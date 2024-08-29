<script setup>
import 'vue-advanced-cropper/dist/style.css';
import { ref, watch } from 'vue';
import { Cropper } from 'vue-advanced-cropper';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import Modal from '@/Components/Modal.vue';
const toast = useToast();
const props = defineProps({
  currentAvatar: {
    type: String,
    nullable: true,
  },
});

const emit = defineEmits(['update:avatar']);

const showModal = ref(false);
const imageUrl = ref(null);
const cropperRef = ref(null);

const form = useForm({
  avatar: null,
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
    },
  });
};

watch(
  () => form.avatar,
  (newValue) => {
    if (newValue) {
      uploadImage();
    }
  }
);
</script>

<template>
  <div>
    <div class="group relative">
      <img
        :src="
          currentAvatar
            ? '/storage/' + currentAvatar
            : '/public/default-avatar.jpg'
        "
        alt="Profile"
        class="max-h-[10rem] min-h-[10rem] min-w-[10rem] max-w-[10rem] rounded-full object-cover md:max-h-[15rem] md:min-h-[15rem] md:min-w-[15rem] md:max-w-[15rem]"
      />

      <div
        class="absolute inset-0 flex items-center justify-center rounded-full bg-black bg-opacity-50 opacity-0 transition-opacity group-hover:opacity-100"
      >
        <button @click="openModal" class="font-semibold text-white">
          Change Photo
        </button>
      </div>
    </div>

    <Modal :show="showModal" @close="closeModal">
      <div class="p-6">
        <h2 class="mb-4 text-lg font-semibold">Update Profile Picture</h2>
        <input
          type="file"
          @change="onFileChange"
          accept="image/*"
          class="mb-4"
        />
        <div v-if="imageUrl" class="mb-4">
          <Cropper
            ref="cropperRef"
            :src="imageUrl"
            :stencil-props="{
              aspectRatio: 1,
            }"
            class="h-64"
          />
        </div>
        <div class="flex justify-end space-x-2">
          <button @click="closeModal" class="rounded bg-gray-200 px-4 py-2">
            Cancel
          </button>
          <button
            @click="cropImage"
            class="rounded bg-maroon-500 px-4 py-2 text-white"
          >
            Crop & Save
          </button>
        </div>
      </div>
    </Modal>
  </div>
</template>
