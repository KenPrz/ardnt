<script setup>
import { ref, watch } from 'vue';
import UserBox from './UserBox.vue';
import PostCard from './PostCard.vue';

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(['close']);

const searchQuery = ref('');
const results = ref({ users: [], posts: [] });
const isLoading = ref(false);
const error = ref(null);
let debounceTimer = null;

const debounce = (callback, delay) => {
  return (...args) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => callback(...args), delay);
  };
};

const performSearch = async (query) => {
  if (query.trim() === '') {
    results.value = { users: [], posts: [] };
    return;
  }

  isLoading.value = true;
  error.value = null;

  try {
    // Use Ziggy's route() function to generate the URL
    const response = await fetch(route('search', { search: query }));
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
    results.value = data;
    console.log(data);
    
  } catch (err) {
    console.error('Search error:', err);
    error.value = 'An error occurred while searching. Please try again.';
  } finally {
    isLoading.value = false;
  }
};

const debouncedSearch = debounce(performSearch, 300);

watch(searchQuery, (newQuery) => {
  debouncedSearch(newQuery);
});

const closeDrawer = () => {
  emit('close');
};
</script>

<template>
  <div
    class="fixed inset-0 overflow-hidden z-50"
    :class="{ 'pointer-events-none': !isOpen }"
  >
    <div
      class="absolute inset-0 overflow-hidden"
      @click="closeDrawer"
    >
      <div
        class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        :class="{ 'opacity-0': !isOpen, 'opacity-100': isOpen }"
      ></div>
    </div>

    <div class="fixed inset-y-0 left-0 max-w-full flex">
      <div
        class="w-screen max-w-md transform transition ease-in-out duration-300"
        :class="{ '-translate-x-full': !isOpen, 'translate-x-0': isOpen }"
      >
        <div class="h-full flex flex-col bg-white shadow-xl">
          <div class="px-4 py-6 sm:px-6">
            <div class="flex items-start justify-between">
              <h2 class="text-lg font-medium text-gray-900">Search</h2>
              <button
                class="ml-3 text-gray-400 hover:text-gray-500"
                @click="closeDrawer"
              >
                Close
              </button>
            </div>
            <div class="mt-6">
              <input
                type="text"
                v-model="searchQuery"
                placeholder="Search..."
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              />
            </div>
          </div>
          <div class="flex-1 overflow-y-auto">
            <div v-if="isLoading" class="px-4 sm:px-6 py-4">
              <p class="text-sm text-gray-500">Searching...</p>
            </div>
            <div v-else-if="error" class="px-4 sm:px-6 py-4">
              <p class="text-sm text-red-500">{{ error }}</p>
            </div>
            <div v-else-if="results.users.length > 0 || results.posts.length > 0" class="px-4 sm:px-6">
              <div v-if="results.users.length > 0">
                <h3 class="text-sm font-medium text-gray-500 mt-4">Users</h3>
                <ul class="mt-2 divide-y divide-gray-200">
                  <li v-for="user in results.users" :key="user.id" class="py-3">
                    <UserBox
                      :id="user.id"
                      :first_name="user.first_name"
                      :last_name="user.last_name"
                      :handle="user.handle"
                      :avatar="user.avatar"
                    />
                  </li>
                </ul>
              </div>
              <div v-if="results.posts.length > 0">
                <h3 class="text-sm font-medium text-gray-500 mt-4">Posts</h3>
                <ul class="mt-2 divide-y divide-gray-200">
                  <li v-for="post in results.posts" :key="post.id" class="py-3">
                    <PostCard
                      :id="post.id"
                      :title="post.title"
                      :content="post.content"
                      :user_handle="post.handle"
                      :created_at="post.created_at"
                    />
                  </li>
                </ul>
              </div>
            </div>
            <div v-else-if="searchQuery" class="px-4 sm:px-6 py-4">
              <p class="text-sm text-gray-500">No results found</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>