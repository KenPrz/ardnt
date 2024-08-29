<script setup>
import { computed } from 'vue';
import getRelativeTime from '@/custom-js/dateTimeCalc';
const props = defineProps({
  originalPost: {
    type: Object,
    nullable: true,
  },
  postSharer: {
    type: Object,
    required: true,
  },
});
const hasImage = computed(() => !!props.originalPost.cover_image);
</script>
<template>
  <div v-if="originalPost">
    <h1
      v-show="hasImage"
      class="mb-2 font-customSerif text-xl font-semibold text-maroon-500"
    >
      {{ originalPost.title }}
    </h1>
    <div class="border-l-4 bg-gray-50 py-2 pe-1 ps-2">
      <h1
        v-show="!hasImage"
        class="mb-2 font-customSerif text-xl font-semibold text-maroon-500"
      >
        {{ originalPost.title }}
      </h1>
      <!-- Post Image -->
      <div v-if="originalPost.cover_image" class="h-72 w-full">
        <a :href="route('posts.show', originalPost.id)">
          <img
            class="h-full w-full rounded-t-lg object-cover hover:cursor-pointer"
            :src="'/storage/' + originalPost.cover_image"
            :alt="originalPost.title"
          />
        </a>
      </div>
      <div class="flex items-center space-x-2 text-gray-600">
        <a :href="route('users.show', originalPost.user.handle)">
          <span class="hover:underline">@{{ originalPost.user.handle }}</span>
        </a>
        <span class="mx-1">•</span>
        <a :href="route('posts.show', originalPost.id)">
          <span class="text-xs hover:underline">{{
            getRelativeTime(originalPost.created_at)
          }}</span>
        </a>
      </div>
      <div class="mt-2">
        <div class="mb-4 text-gray-700" v-html="originalPost.content"></div>
      </div>
    </div>
  </div>
  <div v-else class="rounded-lg bg-gray-100 p-2 py-10">
    <h1 class="text-md text-center font-semibold text-gray-500">
      Content Not available <span class="font-bold">:(</span>
    </h1>
  </div>
</template>

<style scoped></style>
