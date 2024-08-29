<script setup>
import { ref, watch, onMounted, onUnmounted, nextTick } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import UserBox from './UserBox.vue';
import PostCard from './PostCard.vue';

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
});

const form = useForm({
  search: '',
});

const emit = defineEmits(['close']);

const searchQuery = ref('');
const results = ref({ users: [], posts: [] });
const isLoading = ref(false);
const error = ref(null);
let debounceTimer = null;
const searchInput = ref(null);

const closeOnEscape = (e) => {
  if (e.key === 'Escape' && props.isOpen) {
    closeDrawer();
  }
};

const searchOnEnter = (e) => {
  if (e.key === 'Enter') {
    performFullSearch();
  }
};

function performFullSearch() {
  if (searchQuery.value.trim() !== '') {
    form.get(route('search.index', searchQuery.value), {
      preserveScroll: true,
      onSuccess: () => {
        searchQuery.value = '';
        closeDrawer();
      },
    });
    closeDrawer();
  }
}

onMounted(() => {
  document.addEventListener('keydown', closeOnEscape);
  document.addEventListener('keydown', searchOnEnter);
});

onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape);
  document.removeEventListener('keydown', searchOnEnter);
});

const debounce = (callback, delay) => {
  return (...args) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => callback(...args), delay);
  };
};

const performAsyncSearch = async (query) => {
  if (query.trim() === '') {
    results.value = { users: [], posts: [] };
    return;
  }

  isLoading.value = true;
  error.value = null;

  try {
    const response = await fetch(route('search', { search: query }));
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
    results.value = data;
  } catch (err) {
    console.error('Search error:', err);
    error.value = 'An error occurred while searching. Please try again.';
  } finally {
    isLoading.value = false;
  }
};

const debouncedSearch = debounce(performAsyncSearch, 300);

watch(searchQuery, (newQuery) => {
  debouncedSearch(newQuery);
});

const closeDrawer = () => {
  emit('close');
};

watch(
  () => props.isOpen,
  (newIsOpen) => {
    if (newIsOpen) {
      nextTick(() => {
        searchInput.value?.focus();
      });
    }
  }
);
</script>

<template>
  <div
    class="fixed inset-0 z-50 overflow-hidden"
    :class="{ 'pointer-events-none': !isOpen }"
  >
    <div class="absolute inset-0 overflow-hidden" @click="closeDrawer">
      <div
        class="absolute inset-0 bg-gray-400 bg-opacity-75 transition-opacity duration-300"
        :class="{
          'opacity-0': !isOpen,
          'opacity-100': isOpen,
        }"
      ></div>
    </div>

    <div class="fixed inset-y-0 left-0 flex max-w-full">
      <div
        class="w-screen max-w-md transform bg-white shadow-xl transition duration-300 ease-in-out"
        :class="{
          '-translate-x-full': !isOpen,
          'translate-x-0': isOpen,
        }"
      >
        <div class="flex h-full flex-col">
          <div class="border-b border-gray-200 bg-gray-50 px-4 py-6 sm:px-6">
            <div class="flex items-center justify-between">
              <h2 class="text-xl font-semibold text-gray-900">Search</h2>
              <button
                class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-maroon-500"
                @click="closeDrawer"
              >
                <i class="pi pi-times h-6 w-6"></i>
              </button>
            </div>
            <div class="mt-6 flex">
              <input
                type="text"
                v-model="searchQuery"
                ref="searchInput"
                placeholder="Search..."
                class="flex-grow rounded-l-md border border-gray-300 px-4 py-2 shadow-sm transition duration-150 ease-in-out focus:border-maroon-500 focus:outline-none focus:ring-1 focus:ring-maroon-500"
              />
              <button
                @click="performFullSearch"
                class="rounded-r-md bg-maroon-600 px-4 py-2 text-white hover:bg-maroon-700 focus:outline-none focus:ring-maroon-500"
              >
                Search
              </button>
            </div>
          </div>
          <div class="flex-1 overflow-y-auto">
            <div v-if="isLoading" class="px-4 py-4 sm:px-6">
              <p class="text-sm text-gray-500">Searching...</p>
            </div>
            <div v-else-if="error" class="px-4 py-4 sm:px-6">
              <p class="text-sm text-red-500">
                {{ error }}
              </p>
            </div>
            <div
              v-else-if="results.users.length > 0 || results.posts.length > 0"
              class="px-4 sm:px-6"
            >
              <div v-if="results.users.length > 0">
                <div class="mb-3 mt-6 flex items-center justify-between">
                  <h3 class="text-lg font-medium text-gray-900">Users</h3>
                  <button
                    v-if="searchQuery"
                    @click="performFullSearch"
                    class="text-sm font-medium text-maroon-600 hover:text-maroon-500"
                  >
                    See all
                  </button>
                </div>
                <ul class="divide-y divide-gray-200">
                  <li v-for="user in results.users" :key="user.id" class="py-4">
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
                <div class="mb-3 mt-8 flex items-center justify-between">
                  <h3 class="text-lg font-medium text-gray-900">Posts</h3>
                  <button
                    v-if="searchQuery"
                    @click="performFullSearch"
                    class="text-sm font-medium text-maroon-600 hover:text-maroon-500"
                  >
                    See all
                  </button>
                </div>
                <ul class="divide-y divide-gray-200">
                  <li v-for="post in results.posts" :key="post.id" class="py-4">
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
            <div v-else-if="searchQuery" class="px-4 py-4 sm:px-6">
              <p class="text-sm text-gray-500">No results found</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
