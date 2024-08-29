<script setup>
import { Head } from '@inertiajs/vue3';
import { provide } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ViewPost from './ViewPost.vue';
const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
  themes: {
    type: Array,
    required: true,
  },
});
provide('themes', props.themes);
</script>
<template>
  <AuthenticatedLayout>
    <Head :title="post.title" />
    <div class="mx-auto w-full max-w-xl px-4 py-10">
      <ViewPost
        class="w-full overflow-hidden rounded-lg bg-white shadow-lg"
        :post="post"
        :originalPost="post.originalPost"
      />
    </div>
  </AuthenticatedLayout>
</template>
