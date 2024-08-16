<script setup>
import { ref } from 'vue';
import LikeButton from '@/Components/LikeButton.vue';
import Modal from '@/Components/Modal.vue';
import ViewPost from '@/Pages/Post/ViewPost.vue';

const emit = defineEmits(['sharePost']);

function sharePost(post) {
    emit('sharePost', post);
}

const props = defineProps({
    post: {
        type: Object,
        required: true,
    }
});

// Reactive variables for modal and comments
const showViewPostModal = ref(false);
const openComments = ref(false);

// Function to open the modal and control comment state
function viewPost(showComments) {
    openComments.value = showComments; // Set the boolean value directly
    showViewPostModal.value = true;    // Open the modal
}

// Function to close the modal
function closeViewPostModal() {
    showViewPostModal.value = false;
}
</script>

<template>
    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden w-full bg-white mb-5">
        <!-- Post Image -->
        <div class="w-full h-72">
            <img 
                @click="viewPost(false)"
                class="object-cover w-full h-full rounded-t-lg hover:cursor-pointer"
                :src="post.cover_image"
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
                <a :href="route('users.show', post.user.id)" class="hover:underline">
                    <span>@{{ post.user.handle }}</span>
                </a>
                <span class="mx-2">•</span>
                <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
                <span class="mx-2">•</span>
                <i v-if="post.is_public" class="pi pi-globe" style="font-size: .8em;"></i>
                <i v-else class="pi pi-lock" style="font-size: .8em;"></i>
            </div>
            
            <!-- Excerpt -->
            <p class="text-gray-700 mb-4 line-clamp-3">
                <div v-html="post.content"></div>
            </p>
            
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
                    <button @click="sharePost(post)" class="text-gray-500 text-sm flex items-center">
                        <i class="pi pi-share-alt" style="font-size: 1.2em;"></i>
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
</template>
