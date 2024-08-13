<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import PostBox from '@/Components/PostBox.vue';
import SharePost from '@/Components/SharePost.vue';
const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
    followRecommendations: {
        type: Array,
        required: true,
    }
});
const showShareModal = ref(false);
const postToShare = ref(null);

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
        <div class="mx-10 md:max-w-7xl sm:px-10 md:px-72">
            <div class="py-5 space-y-5">
                <template v-for="post in posts.data" :key="post.id">
                    <PostBox 
                        @sharePost="sharePost"
                        :post="post"
                    />
                </template>
            </div>
        </div>
        <Modal
            maxWidth="md"
            :show="showShareModal" 
            @close="closeShareModal">
                <SharePost :post="postToShare" />
        </Modal>
    </AuthenticatedLayout>
</template>
