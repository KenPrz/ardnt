<script setup>
import { ref } from 'vue';
import LikeButton from '@/Components/LikeButton.vue';
import SharePost from './SharePost.vue';
import Modal from '@/Components/Modal.vue';
import CommentsContainer from './partials/CommentsContainer.vue'; // Adjust import as needed
import OriginalPostContainer from '@/Components/OriginalPostContainer.vue';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    openComments: {
        type: Boolean,
        required: false,
        default: false,
    },
});
const isCommentsOpen = ref(false);
const showSharePostModal = ref(false);
function sharePost() {
    showSharePostModal.value = true;
}
function closeSharePostModal() {
    showSharePostModal.value = false;
}
setTimeout(() => {
    isCommentsOpen.value = props.openComments;
}, .800);
function toggleComments() {
    isCommentsOpen.value = !isCommentsOpen.value;
}
</script>

<template>
    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden w-full">
        <!-- Post Image -->
        <div v-if="post.cover_image" class="w-full">
            <img 
                class="object-cover w-full h-72 rounded-t-lg"
                :src="'/storage/' + post.cover_image"
                :alt="post.title"
            />

        </div>
        <!-- Post Content -->
        <div class="p-4">
            <!-- Title -->
            <h2 class="text-2xl font-customSerif font-semibold text-maroon-600 mb-2">
                {{ post.title }}
            </h2>
            <!-- Post Meta -->
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <a :href="route('users.show', post.user.handle)" class="hover:underline">
                    <span>@{{ post.user.handle }}</span>
                </a>
                <span class="mx-2">•</span>
                <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
                <span class="mx-2">•</span>
                <i v-if="post.is_public" class="pi pi-globe" style="font-size: .8em;"></i>
                <i v-else class="pi pi-lock" style="font-size: .8em;"></i>
            </div>
            
            <!-- Excerpt -->
            <p class="text-gray-700 mb-4">
                <div v-html="props.post.content"></div>
            </p>

            <div v-if="post.is_shared" class="py-2">
                <OriginalPostContainer 
                    :originalPost="post.original_post"
                    :postSharer="post.user"
                />
            </div>
            <!-- Interaction Buttons -->
            <div class="flex items-center justify-between">
                <div class="flex space-x-2">
                    <LikeButton
                        :likes_count="post.liked_by_users_count"
                        :post_id="post.id"
                        :is_liked_by_user="post.is_liked_by_user"
                    />
                </div>
                <div class="flex items-center justify-center space-x-2 me-2">
                    <!-- Comments Button -->
                    <button
                        @click="toggleComments"
                        class="text-gray-500 text-sm flex items-center space-x-1">
                        <i class="pi pi-comment" style="font-size: 1.2em;"></i>
                        <span>{{ post.comments_count }}</span>
                    </button>
                    <!-- Share Button -->
                    <button @click="sharePost(post)" class="text-gray-500 text-sm flex items-center">
                        <i class="pi pi-share-alt" style="font-size: 1.2em;"></i>
                    </button>
                    <!-- Modal for sharing post -->
                    <Modal maxWidth="xl" :show="showSharePostModal" @close="closeSharePostModal">
                        <SharePost
                            :post_to_share="post.original_post 
                                ? post.original_post
                                : post"
                            :user="$page.props.auth.user"
                        />
                    </Modal>
                </div>
            </div>
            <div class="flex flex-col mt-4">
                <!-- Comments Container -->
                <transition name="fade">
                    <div v-if="isCommentsOpen" class="flex flex-col space-y-2">
                        <CommentsContainer
                            :post_id="props.post.id"
                            :comments="props.post.comments" />
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>
<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease, max-height 0.5s ease;
}

.fade-enter-from, .fade-leave-to {
  opacity: 0;
  max-height: 0;
}

.fade-enter-to, .fade-leave-from {
  opacity: 1;
  max-height: 1000px; /* Adjust according to your content */
  overflow: hidden;
}
</style>