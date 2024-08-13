<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    post_id: {
        type: Number,
        required: true,
    },
    is_liked_by_user: {
        type: Boolean,
        required: true,
    },
});
const form = useForm({
    post_id: props.post_id,
});

const likePost = throttleHandler(() => {
    form.post(route('post.like', form.data), {
        preserveScroll: true,
        onSuccess: () => {
            // console.log('liked');
        },
    });
}, 1000);

const unlikePost = throttleHandler(() => {
    form.delete(route('post.unlike', form.data), {
        preserveScroll: true,
        onSuccess: () => {
            // console.log('unliked');
        },
    });
}, 1000);

function throttleHandler(fn, delay) {
    let lastCall = 0;
    return function (...args) {
        const now = new Date().getTime();
        if (now - lastCall < delay) {
            return;
        }
        lastCall = now;
        return fn(...args);
    };
}
</script>
<template>
    <div>
        <button v-if="!props.is_liked_by_user" @click="unlikePost()"
            class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
            Unlike
        </button>
        <button v-else @click="likePost()" class="text-blue-600 hover:text-red-800 font-semibold text-sm">
            Like
        </button>
    </div>
</template>