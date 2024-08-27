<script setup>
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
</script>
<template>
    <div class="border-l-4 ps-2 bg-gray-50 py-2 pe-1">
        <!-- Post Image -->
        <div v-if="originalPost.cover_image" class="w-full h-72">
            <img class="object-cover w-full h-full rounded-t-lg hover:cursor-pointer"
                :src="'/storage/' + originalPost.cover_image" :alt="originalPost.title" />
        </div>
        <div class="flex">
            <span class="text-gray-600">@{{ originalPost.user.handle }}</span>
        </div>
        <div class="mt-2">
            <p class="text-gray-700 mb-4">
            <div v-html="originalPost.content"></div>
            </p>
        </div>
    </div>
</template>


<style scoped></style>