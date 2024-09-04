<script setup>
import { ref } from 'vue';
import LikeButton from '@/Components/LikeButton.vue';
import SharePost from './SharePost.vue';
import EditPost from '@/Pages/Post/EditPost.vue';
import Modal from '@/Components/Modal.vue';
import CommentsContainer from './partials/CommentsContainer.vue';
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

const showEditPostModal = ref(false);
function editPost() {
  showEditPostModal.value = true;
}
function closeEditPostModal() {
  showEditPostModal.value = false;
}

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
}, 0.8);
function toggleComments() {
  isCommentsOpen.value = !isCommentsOpen.value;
}
</script>

<template>
  <div class="flex w-full flex-col overflow-hidden rounded-lg shadow-lg">
    <!-- Post Image -->
    <div v-if="post.cover_image" class="w-full">
      <img
        class="h-72 w-full rounded-t-lg object-cover"
        :src="'/storage/' + post.cover_image"
        :alt="post.title"
      />
    </div>
    <!-- Post Content -->
    <div class="p-4">
      <!-- Title -->
      <h2 class="font-customSerif text-2xl font-semibold text-maroon-600">
        {{ post.title }}
      </h2>
      <a
        v-if="post.theme"
        :href="route('search.index', post.theme.name)"
        class="mb-3 text-sm font-thin italic hover:underline"
      >
        #{{ post.theme.name }}
      </a>
      <!-- Post Meta -->
      <div class="mb-3 mt-2 flex items-center text-sm text-gray-500">
        <a
          :href="route('users.show', post.user.handle)"
          class="hover:underline"
        >
          <span>@{{ post.user.handle }}</span>
        </a>
        <span class="mx-2">•</span>
        <span>{{ new Date(post.created_at).toLocaleDateString() }}</span>
        <span class="mx-2">•</span>
        <i
          v-if="post.is_public"
          class="pi pi-globe"
          style="font-size: 0.8em"
        ></i>
        <i v-else class="pi pi-lock" style="font-size: 0.8em"></i>
      </div>

      <!-- Excerpt -->
      <div class="mb-4 text-gray-700" v-html="props.post.content"></div>

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
            @click="toggleComments"
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
          <!-- Modal for sharing post -->
          <Modal
            maxWidth="xl"
            :show="showSharePostModal"
            @close="closeSharePostModal"
          >
            <SharePost
              :post_to_share="post.original_post ? post.original_post : post"
              :user="$page.props.auth.user"
            />
          </Modal>
          <button
            @click="editPost(post)"
            v-if="$page.props.auth.user.id == post.user_id"
            class="flex items-center text-sm text-gray-500"
          >
            <i class="pi pi-pencil" style="font-size: 1.2em"></i>
          </button>
          <!-- Modal for editing post -->
          <Modal maxWidth="xl" :show="showEditPostModal" @close="closeEditPostModal">
            <EditPost :post="post" @close="closeEditPostModal"/>
          </Modal>
        </div>
      </div>
      <div class="mt-4 flex flex-col">
        <!-- Comments Container -->
        <transition name="fade">
          <div v-if="isCommentsOpen" class="flex flex-col space-y-2">
            <CommentsContainer
              :post_id="props.post.id"
              :comments="props.post.comments"
            />
          </div>
        </transition>
      </div>
    </div>
  </div>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition:
    opacity 0.5s ease,
    max-height 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  max-height: 0;
}

.fade-enter-to,
.fade-leave-from {
  opacity: 1;
  max-height: 1000px; /* Adjust according to your content */
  overflow: hidden;
}
</style>
