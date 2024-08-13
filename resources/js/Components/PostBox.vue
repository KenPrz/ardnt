<script setup>
import LikeButton from '@/Components/LikeButton.vue';
    const props = defineProps({
        post: {
            type: Object,
            required: true,
        }
    });
</script>

<template>
    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden w-full bg-white">
        <!-- Post Image -->
        <div class="w-full h-48">
            <img 
                class="object-cover w-full h-full rounded-t-lg"
                :src="post.cover_image" 
                :alt="post.title"
            />
        </div>
        
        <!-- Post Content -->
        <div class="p-4">
            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                {{ post.title }}
            </h2>
            
            <!-- Post Meta -->
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <span>By {{ post.author_name }}</span>
                <span class="mx-2">•</span>
                <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
            </div>
            
            <!-- Excerpt -->
            <p class="text-gray-700 mb-4 line-clamp-3">
                {{ post.excerpt }}
            </p>
            
            <!-- Interaction Buttons -->
            <div class="flex items-center justify-between">
                <LikeButton :post_id="post.id" />
                <span class="text-gray-500 text-sm">
                    {{ post.comment_count }} comments
                </span>
            </div>
        </div>
    </div>
</template>
