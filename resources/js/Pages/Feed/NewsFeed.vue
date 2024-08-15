<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import PostBox from '@/Components/PostBox.vue';
import FollowBox from './Partials/FollowBox.vue';
import SharePost from '@/Components/SharePost.vue';
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
const showShareModal = ref(false);
const showCreatePostModal = ref(false);
const postToShare = ref(null);


function createPost() {
    showCreatePostModal.value = true;
}
function closeCreatePostModal() {
    showCreatePostModal.value = false;
}
function sharePost(post) {
    postToShare.value = post;
    showShareModal.value = true;
}

function closeShareModal() {
    postToShare.value = null;
    showShareModal.value = false;
}
</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <Modal maxWidth="md" :show="showShareModal" @close="closeShareModal">
            <SharePost :post="postToShare" />
        </Modal>
        <Modal maxWidth="2xl" :show="showCreatePostModal" @close="closeCreatePostModal">
            <CreatePost
                @close="closeCreatePostModal"
                :themes="themes"
            />
        </Modal>
        <div class="mx-auto w-full max-w-xl px-4">
            <div class="flex flex-col w-full">
                <div class="flex justify-between items-center py-3">
                    <button @click="createPost" class="w-full flex justify-between items-center 
                        py-5 px-5 bg-maroon-400 rounded-xl hover:bg-maroon-500
                        transition-colors duration-200">
                        <span class="font-semibold text-white">Create Post</span>
                        <i class="pi pi-pencil" style="font-size: 1.2em; color: white;"></i>
                    </button>
                </div>
                <div class="flex-col 2xl:flex py-3 space-y-5">
                    <div class="2xl:w-3/12 2xl:absolute 2xl:right-16 mt-5">
                        <FollowBox v-show="followRecommendations != 0" :suggestedFollowers="followRecommendations" />
                    </div>
                    <div class="w-full">
                        <template v-for="post in posts.data" :key="post.id">
                            <PostBox @sharePost="sharePost" :post="post" />
                        </template>
                        <div class="px-4">
                            <Pagination :first_page_url="posts.first_page_url" :from="posts.from"
                                :last_page="posts.last_page" :last_page_url="posts.last_page_url"
                                :links="posts.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
