<script setup>
import { computed } from 'vue';
import getRelativeTime from '@/custom-js/dateTimeCalc';
const props = defineProps({
    originalPost: {
        type: Object,
        required: true,
    },
    postSharer: {
        type: Object,
        required: true,
    },
});
const hasImage = computed(() => !!props.originalPost.cover_image);
</script>
<template>
    <h1 v-show="hasImage" class="text-xl font-semibold font-customSerif text-maroon-500 mb-2">
        {{ originalPost.title }}
    </h1>
    <div class="border-l-4 ps-2 bg-gray-50 py-2 pe-1">
        <h1 v-show="!hasImage" class="text-xl font-semibold font-customSerif text-maroon-500 mb-2">
            {{ originalPost.title }}
        </h1>
        <!-- Post Image -->
        <div v-if="originalPost.cover_image" class="w-full h-72">
            <a :href="route('posts.show',originalPost.id)">
                <img class="object-cover w-full h-full rounded-t-lg hover:cursor-pointer"
                    :src="'/storage/' + originalPost.cover_image" :alt="originalPost.title" />
            </a>
        </div>
        <div class="flex text-gray-600 space-x-2 items-center">
            <a :href="route('users.show',originalPost.user.handle)">
                <span class=" hover:underline">@{{ originalPost.user.handle }}</span>
            </a>
            <span class="mx-1">•</span>
            <a :href="route('posts.show',originalPost.id)">
                <span class="text-xs hover:underline">{{ getRelativeTime(originalPost.created_at) }}</span>
            </a>
        </div>
        <div class="mt-2">
            <p class="text-gray-700 mb-4">
            <div v-html="originalPost.content"></div>
            </p>
        </div>
    </div>
</template>


<style scoped></style>