<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, provide } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import PostBox from '@/Components/PostBox.vue';
import FollowBox from './Partials/FollowBox.vue';
import CreatePost from '@/Components/CreatePost.vue';
const props = defineProps({
  posts: {
    type: Object,
    required: true,
  },
  followRecommendations: {
    type: Object,
    required: true,
  },
  themes: {
    type: Array,
    required: true,
  },
});

provide('themes', props.themes);

// modal state
const showShareModal = ref(false);
const showCreatePostModal = ref(false);

// modal data
const postToShare = ref(null);

function createPost() {
  showCreatePostModal.value = true;
}
function closeCreatePostModal() {
  showCreatePostModal.value = false;
}

function closeShareModal() {
  postToShare.value = null;
  showShareModal.value = false;
}
</script>

<template>
  <Head title="Feed" />
  <AuthenticatedLayout>
    <Modal
      maxWidth="2xl"
      :show="showCreatePostModal"
      @close="closeCreatePostModal"
    >
      <CreatePost @close="closeCreatePostModal" :themes="themes" />
    </Modal>
    <div class="mx-auto w-full max-w-xl px-4">
      <div class="flex w-full flex-col">
        <div class="flex items-center justify-between py-3">
          <button
            @click="createPost"
            class="flex w-full items-center justify-between rounded-xl bg-maroon-400 px-5 py-5 transition-colors duration-200 hover:bg-maroon-500"
          >
            <span class="font-semibold text-white">Create Post</span>
            <i class="pi pi-pencil" style="font-size: 1.2em; color: white"></i>
          </button>
        </div>
        <div class="flex-col space-y-5 py-3 2xl:flex">
          <div class="mt-5 2xl:absolute 2xl:right-16 2xl:w-3/12">
            <FollowBox
              v-show="followRecommendations != 0"
              :suggestedFollowers="followRecommendations"
            />
          </div>
          <div class="w-full">
            <template v-for="post in posts.data" :key="post.id">
              <PostBox :post="post" />
            </template>
            <div class="px-4">
              <Pagination
                :first_page_url="posts.first_page_url"
                :from="posts.from"
                :last_page="posts.last_page"
                :last_page_url="posts.last_page_url"
                :links="posts.links"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
