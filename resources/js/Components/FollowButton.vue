<script setup>
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
const toast = useToast();

const props = defineProps({
  user_id: {
    type: Number,
    required: true,
  },
  is_followed: {
    type: Boolean,
    required: true,
  },
  is_styled: {
    type: Boolean,
    default: true,
  },
});

const form = useForm({
  user_id: props.user_id,
});

function followUser() {
  if (!props.is_followed) {
    form.post(
      route('user.follow', {
        user: props.user_id,
      }),
      {
        preserveScroll: true,
        onSuccess: () => {
          toast.info('User followed successfully', {
            timeout: 1500,
          });
        },
        onError: () => {
          toast.error('User follow failed', {
            timeout: 1500,
          });
        },
      }
    );
  }
}

function unfollowUser() {
  if (props.is_followed) {
    form.delete(
      route('user.unfollow', {
        user: props.user_id,
      }),
      {
        preserveScroll: true,
        onSuccess: () => {
          toast.info('User unfollowed successfully', {
            timeout: 1500,
          });
        },
        onError: () => {
          toast.error('User unfollow failed', {
            timeout: 1500,
          });
        },
      }
    );
  }
}
</script>

<template>
  <button
    @click="props.is_followed ? unfollowUser() : followUser()"
    :class="[
      form.processing ? 'cursor-not-allowed opacity-50' : '',
      'flex items-center space-x-2 py-2 transition-colors duration-200',
      props.is_styled
        ? props.is_followed
          ? 'rounded-full bg-gray-300 px-3 text-gray-700 hover:bg-gray-400'
          : 'rounded-full bg-maroon-500 px-3 text-white hover:bg-maroon-600'
        : 'font-semibold text-maroon-500 hover:text-maroon-600',
    ]"
    :disabled="form.processing"
  >
    <i
      v-show="form.processing"
      class="pi pi-spinner me-1 animate-spin"
      style="font-size: 0.9em"
    ></i>
    {{ props.is_followed ? 'Unfollow' : 'Follow' }}
  </button>
</template>

<style scoped>
/* Add any custom styles here */
</style>
