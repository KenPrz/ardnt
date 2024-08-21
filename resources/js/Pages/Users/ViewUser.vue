<script setup>
  import { Head } from '@inertiajs/vue3';
  import {ref} from 'vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import Pagination from '@/Components/Pagination.vue';
  import Edit from '@/Pages/Profile/Edit.vue';
  import Tabbar from '@/Components/Tabbar.vue';
  import UserPosts from './partials/UserPosts.vue';
  import FollowerList from './partials/FollowersList.vue';
  import FollowingList from './partials/FollowingList.vue';
  import FollowButton from '@/Components/FollowButton.vue';  
  import Modal from '@/Components/Modal.vue';
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
  });
  const isEditing = ref(false);
  // Tabs setup
  const tabs = [
    { label: 'Posts', name: 'tab1' },
    { label: 'Followers', name: 'tab2' },
    { label: 'Following', name: 'tab3' },
  ];
  // Methods
  const cleanUrl = (url) => {
    let cleanedUrl = url || '';
    cleanedUrl = cleanedUrl.replace(/(^\w+:|^)\/\//, '');
    if (cleanedUrl.length > 20) {
      cleanedUrl = cleanedUrl.substring(0, 20) + '...';
    }
    return cleanedUrl.trim();
  };
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
      <Modal
        v-if="user.id == $page.props.auth.user.id"
        :show="isEditing"
        @close="showModal = false"
      >
      <!-- Edit Profile -->
        <Edit />
      </Modal>
      <div class="w-full flex justify-center">
        <!-- User Posts -->
        <div class="max-w-4xl">
          <section class="flex flex-col items-center md:flex-row my-3 py-5 space-x-6">
            <div class="flex flex-col items-center space-y-3 w-1/3">
              <div class="h-2/3 w-auto">
                <img
                  class="object-cover w-full h-full rounded-full"
                  :src="'/storage/avatars/' + user.avatar"
                  :alt="user.first_name"
                />
              </div>
              <div class="flex">
                <a class="flex items-center space-x-2 mb-2 md:mb-0" :href="user.website" target="_blank">
                  <i class="pi pi-link" style="font-size: 1.2em; color:#a02334;"></i>
                  <span class="text-maroon-500 hover:text-maroon-500 truncate">{{ cleanUrl(user.socials.website) }}</span>
                </a>
              </div>
            </div>
            <div class="flex flex-col w-2/3 justify-center md:justify-start">
              <!-- Name -->
              <h1 class="text-center md:text-start text-4xl md:text-6xl font-customSerif text-maroon-500">
                {{ user.first_name + ' ' + user.last_name }}
              </h1>
              <!-- Handle -->
              <a :href="route('users.show', user.id)">
                <h2 class="text-center md:text-start text-md text-gray-500">@{{ user.handle }}</h2>
              </a>
              <!-- Quote -->
              <p class="text-center md:text-start text-md text-sm md:text-lg text-gray-700 italic">
                "{{ user.quote }}"
                <span v-if="user.id == $page.props.auth.user.id">
                  <button>
                    <i class="pi pi-pencil" style="font-size: .8em;"></i>
                  </button>
                </span>
              </p>
              <div class="flex flex-col md:flex-row w-full md:w-4/5 justify-center md:justify-between mt-3 space-y-2">
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
                <div class="flex justify-center md:justify-end space-x-4">
                  <!-- Socials Section -->
                  <a :href="'https://twitter.com/' + user.socials.twitter" target="_blank" v-if="user.socials.twitter">
                    <i class="pi pi-twitter" style="font-size: 1.1em; color:black;"></i>
                  </a>
                  <a :href="'https://www.instagram.com/' + user.socials.instagram" target="_blank" v-if="user.socials.instagram">
                    <i class="pi pi-instagram" style="font-size: 1.1em; color:black;"></i>
                  </a>
                  <a :href="'https://www.facebook.com/' + user.socials.facebook" target="_blank" v-if="user.socials.facebook">
                    <i class="pi pi-facebook" style="font-size: 1.1em; color:black;"></i>
                  </a>
                  <a :href="'https://www.linkedin.com/in/' + user.socials.linkedin" target="_blank" v-if="user.socials.linkedin">
                    <i class="pi pi-linkedin" style="font-size: 1.1em; color:black;"></i>
                  </a>
                  <a :href="'https://medium.com/@' + user.socials.medium" target="_blank" v-if="user.socials.medium">
                    <i class="pi pi-medium" style="font-size: 1.1em; color:black;"></i>
                  </a>
                </div>
              </div>
              <div class="w-full flex-col">
                <FollowButton 
                  v-if="user.id != $page.props.auth.user.id"
                  :is_followed="user.is_followed_by_me" 
                  :user_id="user.id"
                  :is_styled="false"
                />
                <button v-else
                  @click="isEditing = true"
                  @close="isEditing = false"
                  class="flex items-center space-x-2 text-maroon-500
                  font-semibold">
                  <i class="pi pi-cog" style="font-size: 1em;"></i>
                  <span>Edit Profile</span>
                </button>
              </div>
            </div>
          </section>
          <div class="container mx-auto mt-8">
            <Tabbar :tabs="tabs">
              <template v-slot:tab1>
                <!-- User Posts Section -->
                <section class="flex flex-col justify-center mx-10 md:mx-20">
                  <UserPosts :posts="posts.data.data" />
                  <div class="px-4">
                    <Pagination :first_page_url="posts.data.first_page_url" :from="posts.data.from"
                      :last_page="posts.data.last_page" :last_page_url="posts.data.last_page_url" :links="posts.data.links" />
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
  /* Add any necessary scoped styles here */
  </style>
  