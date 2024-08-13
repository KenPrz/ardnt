<script setup>
import { useForm } from '@inertiajs/vue3';
import { formToJSON } from 'axios';
const props = defineProps({
    post: {
        type: Object,
        required: true,
    }
});
const form = useForm({
    'post_id': props.post.id,
    'content': '',
});

function sharePost() {
    form.post(route('post.share', form.data), {
        onSuccess: () => {
            // console.log('shared');
        },
    });
}
</script>

<template>
    <div>
        <div class="flex flex-col rounded-lg shadow-lg overflow-hidden w-full bg-white">
            <!-- Post Image -->
            <div class="w-full h-48">
                <img class="object-cover w-full h-full rounded-t-lg" :src="post.cover_image" :alt="post.title" />
            </div>
            <!-- Post Content -->
            <div class="p-4">
                <!-- Title -->
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    {{ post.title }}
                </h2>

                <!-- Post Meta -->
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <span>By @{{ post.user.handle }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
                </div>

                <!-- Excerpt -->
                <p class="text-gray-700 mb-4 line-clamp-3">
                    {{ post.content }}
                </p>
            </div>
        </div>
    </div>
</template>
<style scoped></style>