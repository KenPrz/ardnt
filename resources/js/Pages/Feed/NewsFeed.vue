<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import PostBox from '@/Components/PostBox.vue';
import SharePost from '@/Components/SharePost.vue';
import CreatePost from '@/Components/CreatePost.vue';
const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
    followRecommendations: {
        type: Array,
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
        <Modal
            maxWidth="md"
            :show="showShareModal" 
            @close="closeShareModal">
                <SharePost :post="postToShare" />
        </Modal>
        <Modal
            maxWidth="2xl"
            :show="showCreatePostModal"
            @close="closeCreatePostModal">
                <CreatePost 
                    :themes="themes"
                />
        </Modal>
        <div class="mx-10 md:max-w-7xl sm:max-w-5xl sm:px-16 lg:px-48 xl:px-64 mt-10">
            <div class="flex justify-between items-center py-3">
                <button @click="createPost"
                        class="w-full flex justify-between items-center 
                        py-5 px-5 bg-gray-300 rounded-xl hover:bg-gray-400
                        transition-colors duration-200">
                    <span class="font-semibold">Create Post</span>
                    <i class="pi pi-pencil" style="font-size: 1.2em;"></i>
                </button>
            </div>
            <div class="py-3 space-y-5">
                <template v-for="post in posts.data" :key="post.id">
                    <PostBox 
                        @sharePost="sharePost"
                        :post="post"
                    />
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
