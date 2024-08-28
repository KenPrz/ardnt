<script setup>
import { ref, computed } from 'vue';
import OriginalPostContainer from './OriginalPostContainer.vue';
import LikeButton from '@/Components/LikeButton.vue';
import Modal from '@/Components/Modal.vue';
import ViewPost from '@/Pages/Post/ViewPost.vue';
import EditPost from '@/Pages/Post/EditPost.vue';
import SharePost from '@/Pages/Post/SharePost.vue';
import getRelativeTime from '@/custom-js/dateTimeCalc';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    }
});

// Reactive variables for modal and comments
const showViewPostModal = ref(false);
const showEditPostModal = ref(false);
const showSharePostModal = ref(false);
const openComments = ref(false);

// Function to open the modal and control comment state
function viewPost(showComments) {
    openComments.value = showComments; // Set the boolean value directly
    showViewPostModal.value = true;    // Open the modal
}

function editPost() {
    showEditPostModal.value = true;
}

function sharePost() {
    showSharePostModal.value = true;
}

// Function to close the modal
function closeViewPostModal() {
    showViewPostModal.value = false;
}

function closeEditPostModal() {
    showEditPostModal.value = false;
}

function closeSharePostModal() {
    showSharePostModal.value = false;
}
</script>
<template>
    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden w-full bg-white mb-5">
        <!-- Post Image -->
        <div v-if="post.cover_image" class="w-full h-72">
            <img 
                @click="viewPost(false)"
                class="object-cover w-full h-full rounded-t-lg hover:cursor-pointer"
                :src="'/storage/' + post.cover_image"
                :alt="post.title"
            />
        </div>
        <!-- Post Content -->
        <div class="p-4">
            <div class="flex flex-col mb-2">
                <!-- Title -->
                <h2 class="text-2xl font-customSerif font-semibold text-maroon-600">
                    {{ post.title }}
                </h2>
                <!-- Theme -->
                <span class="text-sm text-gray-600">#{{ post.theme.name }}</span>
            </div>
            <!-- Post Meta -->
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <a :href="route('users.show', post.user.handle)" 
                    :class="[post.is_shared ? 'text-sm italic mb-1':'','hover:underline']">
                    <span>@{{ post.user.handle  }}</span><span v-if="post.is_shared"> shared this post</span>
                </a>
                <span class="mx-2">•</span>
                <a :href="route('posts.show',post.id)">
                    <span class="text-xs hover:underline">{{ getRelativeTime(post.created_at) }}</span>
                </a>
                <span class="mx-2">•</span>
                <i v-if="post.is_public" class="pi pi-globe" style="font-size: .9em;"></i>
                <i v-else class="pi pi-users" style="font-size: .9em;"></i>
            </div>
            
            <!-- Excerpt -->
            <p :class="[post.cover_image ? 'line-clamp-3' : '', 'text-gray-700 mb-4']">
                <div v-html="post.content"></div>
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
                        @click="viewPost(true)"
                        class="text-gray-500 text-sm flex items-center space-x-1">
                        <i class="pi pi-comment" style="font-size: 1.2em;"></i>
                        <span>{{ post.comments_count }}</span>
                    </button>
                    
                    <!-- Share Button -->
                    <button 
                        v-if="post.original_post"
                        @click="sharePost(post)" 
                        class="text-gray-500 text-sm flex items-center">
                            <i class="pi pi-share-alt" style="font-size: 1.2em;"></i>
                    </button>

                    <!-- Edit Button -->
                    <button 
                        @click="editPost(post)"
                        v-if="$page.props.auth.user.id == post.user_id" class="text-gray-500 text-sm flex items-center">
                        <i class="pi pi-pencil" style="font-size: 1.2em;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for viewing post -->
    <Modal maxWidth="xl" :show="showViewPostModal" @close="closeViewPostModal">
        <ViewPost
            @sharePost="sharePost"
            :openComments="openComments"
            :post="post" />
    </Modal>

    <!-- Modal for editing post -->
    <Modal maxWidth="xl" :show="showEditPostModal" @close="closeEditPostModal">
        <EditPost :post="post" />
    </Modal>

    <!-- Modal for sharing post -->
    <Modal maxWidth="xl" :show="showSharePostModal" @close="closeSharePostModal">
        <SharePost
            :post_to_share="post.original_post 
                ? post.original_post // If post is a shared post, share the original post
                : post" 
            :user="$page.props.auth.user"
        />
    </Modal>
</template>
