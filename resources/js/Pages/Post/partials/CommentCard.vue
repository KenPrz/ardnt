<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';

import getRelativeTime from '@/custom-js/dateTimeCalc';

const toast = useToast();

const props = defineProps({
  comment: {
    type: Object,
    required: true,
  },
});

const showOptions = ref(false);
const isEditing = ref(false);
const showDeleteModal = ref(false);

const commentData = useForm({
  user_id: props.comment.user.id,
  comment_id: props.comment.id,
  content: props.comment.content,
});

function toggleOptions() {
  showOptions.value = !showOptions.value;
}

function toggleEditing() {
  isEditing.value = !isEditing.value;
  commentData.content = props.comment.content;
}

function submitEdit() {
  commentData.put(route('comments.update'), {
    preserveScroll: true,
    onSuccess: () => {
      isEditing.value = false;
      toggleOptions();
    },
  });
}

function closeOptions() {
  showOptions.value = false;
  isEditing.value = false;
  commentData.content = props.comment.content;
}

function openDeleteModal() {
  showDeleteModal.value = true;
}

function closeDeleteModal() {
  showDeleteModal.value = false;
}

function deleteComment() {
  commentData.delete(route('comments.destroy', props.comment.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeDeleteModal();
      closeOptions();
      toast.success('Comment deleted successfully');
    },
  });
}
</script>

<template>
  <Modal :show="showDeleteModal" @close="closeDeleteModal">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">Delete Comment</h2>
      <p class="mt-1 text-sm text-gray-600">
        Are you sure you want to delete this comment?
      </p>
      <div class="mt-6 flex justify-end">
        <button
          @click="closeDeleteModal"
          type="button"
          class="rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25"
        >
          Cancel
        </button>
        <button
          @click="deleteComment"
          type="button"
          class="ml-3 rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
        >
          Delete
        </button>
      </div>
    </div>
  </Modal>

  <div
    class="me-2 flex items-start space-x-2 rounded-lg border bg-white p-3 shadow-sm"
  >
    <!-- User Avatar -->
    <a :href="route('users.show', props.comment.user.handle)">
      <img
        :src="
          comment.user.avatar
            ? '/storage/' + comment.user.avatar
            : '/public/default-avatar.jpg'
        "
        :alt="`${props.comment.user.first_name} ${props.comment.user.last_name}`"
        class="h-12 w-12 rounded-full object-cover"
      />
    </a>
    <!-- Comment Content -->
    <div class="flex-1">
      <!-- User Info -->
      <div class="flex w-full items-center justify-between">
        <div class="flex items-center space-x-2">
          <div class="flex items-center">
            <a
              class="hover:underline"
              :href="route('users.show', props.comment.user.handle)"
            >
              <span class="text-gray-500"
                >@{{ props.comment.user.handle }}</span
              >
            </a>
          </div>
          <span>•</span>
          <!-- Timestamp -->
          <div class="text-xs text-gray-500">
            {{ getRelativeTime(props.comment.created_at) }}
            <span v-if="props.comment.is_edited" class="text-gray-400"
              >(Edited)</span
            >
          </div>
        </div>
        <button
          @click="toggleOptions"
          v-if="!showOptions && comment.user_id === $page.props.auth.user.id"
        >
          •••
        </button>
        <div v-if="showOptions" class="flex items-center space-x-2">
          <button @click="toggleEditing">
            <i
              class="pi pi-pen-to-square"
              style="font-size: 0.9em; color: green"
            ></i>
          </button>
          <button @click="openDeleteModal">
            <i class="pi pi-trash" style="font-size: 0.9em; color: red"></i>
          </button>
          <button @click="closeOptions">
            <i
              class="pi pi-times-circle"
              style="font-size: 0.9em; color: blue"
            ></i>
          </button>
        </div>
      </div>
      <!-- Comment Text -->
      <p v-if="!isEditing" class="mb-2 text-sm text-gray-700">
        {{ props.comment.content }}
      </p>
      <!-- Edit Comment -->
      <div v-if="isEditing" class="my-2 flex w-full flex-col">
        <textarea
          id="textArea"
          v-model="commentData.content"
          class="w-full rounded-lg border border-gray-300 p-2"
        ></textarea>
        <div class="me-2 mt-2 flex justify-end space-x-2">
          <button
            @click="submitEdit"
            :disabled="commentData.processing"
            class="text-xs text-blue-500 hover:underline"
          >
            Save
          </button>
          <button
            @click="closeOptions"
            :disabled="commentData.processing"
            class="text-xs text-blue-500 hover:underline"
          >
            Cancel
          </button>
        </div>
      </div>
      <p v-if="commentData.recentlySuccessful" class="text-sm text-green-600">
        Saved.
      </p>
      <InputError :message="commentData.errors.content" class="mt-2" />
    </div>
  </div>
</template>

<style scoped>
#textArea {
  min-height: 100px;
  font-size: 0.9rem;
}
</style>
