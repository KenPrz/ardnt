<script setup>
import CommentCard from './CommentCard.vue';
import CommentCreate from './CommentCreate.vue';
    const props = defineProps({
        post_id: {
            type: Number,
            required: true,
        },
        comments: {
            type: Array,
            required: true,
        }
    });
</script>
<template>
    <div class="flex flex-col space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
        </div>
        <div class="flex flex-col space-y-3 max-h-48 overflow-y-auto">
            <p v-if="props.comments.length === 0" class="text-gray-500 text-sm">No comments yet</p>
            <template v-else>
                <CommentCard 
                    v-for="comment in props.comments" 
                    :key="comment.id"
                    :comment="comment" 
                />
            </template>
        </div>
        <div class="flex w-full">
            <CommentCreate 
                :post_id="props.post_id"
            />
        </div>
    </div>
</template>