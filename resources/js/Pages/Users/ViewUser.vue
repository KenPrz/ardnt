<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed, provide } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import Edit from '@/Pages/Profile/Edit.vue';
import Tabbar from '@/Components/Tabbar.vue';
import UserPosts from './partials/UserPosts.vue';
import FollowerList from './partials/FollowersList.vue';
import FollowingList from './partials/FollowingList.vue';
import FollowButton from '@/Components/FollowButton.vue';
import Modal from '@/Components/Modal.vue';
import CreatePost from '@/Components/CreatePost.vue';

// Props
const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  posts: {
    type: Object,
    required: true,
  },
  followers: {
    type: Object,
    required: true,
  },
  following: {
    type: Object,
    required: true,
  },
  themes: {
    type: Array,
  },
});

provide('themes', props.themes);

const isEditing = ref(false);
const showCreatePostModal = ref(false);

function createPost() {
  showCreatePostModal.value = true;
}
function closeCreatePostModal() {
  showCreatePostModal.value = false;
}
// Tabs setup
const tabs = [
  { label: 'Posts', name: 'tab1' },
  { label: 'Followers', name: 'tab2' },
  { label: 'Following', name: 'tab3' },
];

// Computed properties
const hasQuote = computed(() => !!props.user.quote);
const hasSocials = computed(() => {
  const socials = props.user.socials;
  return socials.website || socials.twitter || socials.instagram || socials.facebook || socials.linkedin || socials.medium;
});

// Methods
const cleanUrl = (url) => {
  let cleanedUrl = url || '';
  cleanedUrl = cleanedUrl.replace(/(^\w+:|^)\/\//, '');
  if (cleanedUrl.length > 20) {
    cleanedUrl = cleanedUrl.substring(0, 20) + '...';
  }
  return cleanedUrl.trim();
};

const openModal = () => {
  isEditing.value = true;
};

const closeModal = () => {
  isEditing.value = false;
};
</script>

<template>

  <Head :title="user.handle" />
  <AuthenticatedLayout>
    <div class="w-full flex justify-center">
      <div class="max-w-4xl">
        <section class="flex flex-col items-center md:flex-row my-3 py-5 space-x-6">
          <div class="flex flex-col items-center space-y-3 w-1/3">
            <div class="flex flex-col items-center space-y-3 w-1/3">
              <div class="relative h-2/3 w-auto">
                <ImageUpload v-if="user.id == $page.props.auth.user.id" :current-avatar="user.avatar" />
                <img v-else-if="user.avatar" 
                  class="md:min-w-[15rem] md:min-h-[15rem]
                    md:max-w-[15rem] md:max-h-[15rem]
                    max-w-[10rem] max-h-[10rem]
                    min-w-[10rem] min-h-[10rem]
                    rounded-full object-cover" 
                    :src="'/storage/' + user.avatar"
                  :alt="user.first_name" />
                <i v-if="user.email_verified_at"
                  class="absolute pi pi-verified text-maroon-500 text-2xl md:text-3xl font-semibold bottom-1 right-4 md:right-6 md:bottom-3 bg-white rounded-full">
                </i>
              </div>
            </div>

            <div class="flex" v-if="user.socials.website">
              <a class="flex items-center space-x-2 mb-2 md:mb-0" :href="user.socials.website" target="_blank">
                <i class="pi pi-link" style="font-size: 1.2em; color:#a02334;"></i>
                <span class="text-maroon-500 hover:text-maroon-500 truncate">{{ cleanUrl(user.socials.website) }}</span>
              </a>
            </div>
          </div>
          <div class="flex flex-col w-2/3 justify-center md:justify-start">
            <h1 class="text-center md:text-start text-4xl md:text-6xl font-customSerif text-maroon-500">
              {{ user.first_name + ' ' + user.last_name }}
            </h1>
            <a :href="route('users.show', user.handle)">
              <h2 class="text-center md:text-start text-md text-gray-500">@{{ user.handle }}</h2>
            </a>
            <div class="min-h-[1rem] md:min-h-[2rem] flex items-center justify-center md:justify-start">
              <p v-if="hasQuote" class="text-center md:text-start text-md text-sm md:text-lg text-gray-700 italic">
                "{{ user.quote }}"
                <span v-if="user.id == $page.props.auth.user.id">
                  <button>
                    <i class="pi pi-pencil" style="font-size: .8em;"></i>
                  </button>
                </span>
              </p>
            </div>
            <div
              class="flex flex-col md:flex-row w-full md:w-4/5 justify-center md:justify-between space-y-2 space-x-2  md:space-y-0">
              <div class="flex justify-center md:justify-start space-x-2">
                <div>
                  <div class="flex space-x-1">
                    <p class="text-sm text-gray-700">{{ posts.count }}</p>
                    <p class="text-sm text-gray-500">Posts</p>
                  </div>
                </div>
                <div>
                  <div class="flex space-x-1">
                    <p class="text-sm text-gray-700">{{ following.count }}</p>
                    <p class="text-sm text-gray-500">Following</p>
                  </div>
                </div>
                <div>
                  <div class="flex space-x-1">
                    <p class="text-sm text-gray-700">{{ followers.count }}</p>
                    <p class="text-sm text-gray-500">Followers</p>
                  </div>
                </div>
              </div>
              <div v-if="hasSocials" class="flex justify-center md:justify-end space-x-4">
                <a :href="'https://twitter.com/' + user.socials.twitter" target="_blank" v-if="user.socials.twitter">
                  <i class="pi pi-twitter" style="font-size: 1.1em; color:black;"></i>
                </a>
                <a :href="'https://www.instagram.com/' + user.socials.instagram" target="_blank"
                  v-if="user.socials.instagram">
                  <i class="pi pi-instagram" style="font-size: 1.1em; color:black;"></i>
                </a>
                <a :href="'https://www.facebook.com/' + user.socials.facebook" target="_blank"
                  v-if="user.socials.facebook">
                  <i class="pi pi-facebook" style="font-size: 1.1em; color:black;"></i>
                </a>
                <a :href="'https://www.linkedin.com/in/' + user.socials.linkedin" target="_blank"
                  v-if="user.socials.linkedin">
                  <i class="pi pi-linkedin" style="font-size: 1.1em; color:black;"></i>
                </a>
                <a :href="'https://medium.com/@' + user.socials.medium" target="_blank" v-if="user.socials.medium">
                  <span class="bg-black rounded-lg text-white px-[3px]">M</span>
                </a>
              </div>
            </div>
            <div class="w-full flex justify-center md:justify-start mt-3">
              <FollowButton v-if="user.id != $page.props.auth.user.id" :is_followed="user.is_followed_by_me"
                :user_id="user.id" :is_styled="false" />
              <button v-else @click="openModal" @close="closeModal"
                class="flex items-center space-x-2 text-maroon-500 font-semibold">
                <i class="pi pi-cog" style="font-size: 1em;"></i>
                <span>Edit Profile</span>
              </button>
              <Modal maxWidth="2xl" :show="isEditing" @close="closeModal">
                <Edit :user="user" />
              </Modal>
            </div>
          </div>
        </section>
        <section class="w-full flex justify-center" v-if="user.id == $page.props.auth.user.id">
          <div class="w-full flex justify-between items-center py-3 mx-10">
            <Modal maxWidth="2xl" :show="showCreatePostModal" @close="closeCreatePostModal">
              <CreatePost @close="closeCreatePostModal" :themes="themes" />
            </Modal>
            <button @click="createPost" class="w-full flex justify-between items-center 
                  mx-10 md:mx-20 py-5 px-5 bg-maroon-400 rounded-xl hover:bg-maroon-500
                  transition-colors duration-200">
              <span class="font-semibold text-white">Create Post</span>
              <i class="pi pi-pencil" style="font-size: 1.2em; color: white;"></i>
            </button>
          </div>
        </section>
        <div class="mx-5 md:mx-auto mt-8 w-full">
          <Tabbar :tabs="tabs">
            <template v-slot:tab1>
              <!-- User Posts Section -->
              <section v-if="posts.data.data.length === 0" class="flex flex-col justify-center mx-10 md:mx-20">
                <div class="flex flex-col items-center space-y-2">
                  <h1 class="text-2xl font-semibold text-maroon-500">No posts yet</h1>
                  <p class="text-maroon-400">When you create posts, they will appear here.</p>
                </div>
              </section>
              <section v-if="posts.data.data.length > 0" class="flex flex-col justify-center mx-10 md:mx-20">
                <UserPosts :posts="posts.data.data" />
                <div class="px-4">
                  <Pagination :first_page_url="posts.data.first_page_url" :from="posts.data.from"
                    :last_page="posts.data.last_page" :last_page_url="posts.data.last_page_url"
                    :links="posts.data.links" />
                </div>
              </section>
            </template>
            <template v-slot:tab2>
              <!-- User's Follower Section -->
              <section class="flex flex-col justify-center mx-10 md:mx-20">
                <FollowerList :followers="followers" />
              </section>
            </template>
            <template v-slot:tab3>
              <!-- User's Following Section -->
              <section class="flex flex-col justify-center mx-10 md:mx-20">
                <FollowingList :followings="following" />
              </section>
            </template>
          </Tabbar>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>