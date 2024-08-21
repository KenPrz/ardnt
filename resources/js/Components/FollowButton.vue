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
        form.post(route('user.follow', { user: props.user_id }), {
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
        });
    }
}

function unfollowUser() {
    if (props.is_followed) {
        form.delete(route('user.unfollow', { user: props.user_id }), {
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
        });
    }
}
</script>

<template>
    <button
        @click="props.is_followed ? unfollowUser() : followUser()"
        :class="[
            'transition-colors duration-200 py-2 ml-auto',
            props.is_styled
                ? props.is_followed
                    ? 'bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-full px-4'
                    : 'bg-maroon-500 hover:bg-maroon-600 text-white rounded-full px-4'
                : 'text-maroon-500 hover:text-maroon-600 font-semibold',
        ]"
        :disabled="form.processing"
    >
        {{ props.is_followed ? 'Unfollow' : 'Follow' }}
    </button>
</template>

<style scoped>
/* Add any custom styles here */
</style>
