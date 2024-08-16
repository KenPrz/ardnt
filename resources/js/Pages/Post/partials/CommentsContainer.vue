<script setup>
import CommentCard from './CommentCard.vue';
    const props = defineProps({
        comments: {
            type: Object,
            required: true,
        }
    });
</script>
<template>
    <div class="flex flex-col space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
        </div>
        <div class="flex flex-col space-y-3 border-b max-h-48 overflow-y-auto">
            <CommentCard v-for="comment in props.comments" 
                :key="comment.id" 
                :comment="comment" 
            />
        </div>
    </div>
</template>