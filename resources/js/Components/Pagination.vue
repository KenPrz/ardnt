<template>
  <nav class="flex items-center justify-center space-x-2 mx-5" aria-label="Pagination">
    <template v-for="link in pagination.links" :key="link.url ?? ''">
      <Link
        v-if="link.url"
        :href="link.url"
        v-html="link.label"
        class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
        :class="[
          link.active
            ? 'bg-gray-900 text-white'
            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'
        ]"
        preserve-scroll
        @click="scrollToTop"
      />
      <span
        v-else
        v-html="link.label"
        class="px-3 py-2 text-sm font-medium text-gray-300 rounded-md"
      />
    </template>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const pagination = defineProps({
  links: Array,
  first_page_url: String,
  from: Number,
  last_page: Number,
  last_page_url: String,
});

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
};
</script>
