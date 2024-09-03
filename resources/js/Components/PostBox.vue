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
  },
});

// Reactive variables for modal and comments
const showViewPostModal = ref(false);
const showEditPostModal = ref(false);
const showSharePostModal = ref(false);
const openComments = ref(false);

// Function to open the modal and control comment state
function viewPost(showComments) {
  openComments.value = showComments; // Set the boolean value directly
  showViewPostModal.value = true; // Open the modal
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
  <div
    class="mb-5 flex w-full flex-col overflow-hidden rounded-lg bg-white shadow-lg"
  >
    <!-- Post Image -->
    <div v-if="post.cover_image" class="h-72 w-full">
      <img
        @click="viewPost(false)"
        class="h-full w-full rounded-t-lg object-cover hover:cursor-pointer"
        :src="'/storage/' + post.cover_image"
        :alt="post.title"
      />
    </div>
    <!-- Post Content -->
    <div class="p-4">
      <div class="mb-2 flex flex-col">
        <!-- Title -->
        <h2 class="font-customSerif text-2xl font-semibold text-maroon-600">
          {{ post.title }}
        </h2>
        <!-- Theme -->
        <a v-if="post.theme"
          :href="route('search.index', post.theme.name)"
          class="text-sm text-gray-600 hover:underline">#{{ post.theme.name }}</a>
      </div>
      <!-- Post Meta -->
      <div class="mb-4 flex items-center text-sm text-gray-500">
        <a
          :href="route('users.show', post.user.handle)"
          :class="[
            post.is_shared ? 'mb-1 text-sm italic' : '',
            'hover:underline',
          ]"
        >
          <span>@{{ post.user.handle }}</span
          ><span v-if="post.is_shared"> shared this post</span>
        </a>
        <span class="mx-2">•</span>
        <a :href="route('posts.show', post.id)">
          <span class="text-xs hover:underline">{{
            getRelativeTime(post.created_at)
          }}</span>
        </a>
        <span class="mx-2">•</span>
        <i
          v-if="post.is_public"
          class="pi pi-globe"
          style="font-size: 0.9em"
        ></i>
        <i v-else class="pi pi-users" style="font-size: 0.9em"></i>
      </div>

      <!-- Excerpt -->
      <div
        :class="[post.cover_image ? 'line-clamp-3' : '', 'mb-4 text-gray-700']"
        v-html="post.content"
      ></div>
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
        <div class="me-2 flex items-center justify-center space-x-2">
          <!-- Comments Button -->
          <button
            @click="viewPost(true)"
            class="flex items-center space-x-1 text-sm text-gray-500"
          >
            <i class="pi pi-comment" style="font-size: 1.2em"></i>
            <span>{{ post.comments_count }}</span>
          </button>
          <!-- Share Button -->
          <button
            @click="sharePost(post)"
            class="flex items-center text-sm text-gray-500"
          >
            <i class="pi pi-share-alt" style="font-size: 1.2em"></i>
          </button>

          <!-- Edit Button -->
          <button
            @click="editPost(post)"
            v-if="$page.props.auth.user.id == post.user_id"
            class="flex items-center text-sm text-gray-500"
          >
            <i class="pi pi-pencil" style="font-size: 1.2em"></i>
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
      :post="post"
    />
  </Modal>

  <!-- Modal for editing post -->
  <Modal maxWidth="xl" :show="showEditPostModal" @close="closeEditPostModal">
    <EditPost :post="post" />
  </Modal>

  <!-- Modal for sharing post -->
  <Modal maxWidth="xl" :show="showSharePostModal" @close="closeSharePostModal">
    <SharePost
      :post_to_share="
        post.original_post
          ? post.original_post // If post is a shared post, share the original post
          : post
      "
      :user="$page.props.auth.user"
    />
  </Modal>
</template>
