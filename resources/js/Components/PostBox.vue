<script setup>
import LikeButton from '@/Components/LikeButton.vue';
import { defineEmits } from 'vue';

const emit = defineEmits(['sharePost']);

function sharePost(post) {
    emit('sharePost', post);
}
    const props = defineProps({
        post: {
            type: Object,
            required: true,
        }
    });
</script>

<template>
    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden w-full bg-white mb-5">
        <!-- Post Image -->
        <div class="w-full h-72">
            <img 
                class="object-cover w-full h-full rounded-t-lg"
                :src="post.cover_image"
                :alt="post.title"
            />
        </div>
        <!-- Post Content -->
        <div class="p-4">
            <!-- Title -->
            <h2 class="text-2xl font-customSerif font-semibold text-maroon-600 mb-2">
                {{ post.title }}
            </h2>
            <!-- Post Meta -->
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <a href="google.com" class="hover:underline"> 
                    <!-- route('user.profile', post.user.id) -->
                    <span>@{{ post.user.handle }}</span>
                </a>
                <span class="mx-2">•</span>
                <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
                <span class="mx-2">•</span>
                <i v-if="post.is_public" class="pi pi-globe" style="font-size: .8em;"></i>
                <i v-else class="pi pi-lock" style="font-size: .8em;"></i>
            </div>
            
            <!-- Excerpt -->
            <p class="text-gray-700 mb-4 line-clamp-3">
                <div v-html="props.post.content"></div>
            </p>
            <!-- Interaction Buttons -->
            <div class="flex items-center justify-between">
                <div class="flex space-x-2">
                    <LikeButton 
                        :post_id="post.id"
                        :is_liked_by_user="post.is_liked_by_user" 
                    />
                </div>
                <div class="flex space-x-2 items-center justify-center me-2">
                    <button class="text-gray-500 text-sm text-md">
                        {{ post.comment_count }} <i class="pi pi-comment" style="font-size: 1.2em;"></i>
                    </button>
                    <button @click="sharePost(post)" class="text-gray-500 text-sm">
                        <i class="pi pi-share-alt" style="font-size: 1.2em;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
