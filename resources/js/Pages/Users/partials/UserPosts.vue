<script setup>
import PostBox from '@/Components/PostBox.vue';
import Pagination from '@/Components/Pagination.vue';
const props = defineProps({
  posts: {
    type: Array,
    required: true,
  },
});
</script>
<template>
  <div class="my-5 flex justify-center md:mx-20" v-for="post in posts">
    <PostBox :post="post" />
  </div>
</template>

<style scoped></style>
