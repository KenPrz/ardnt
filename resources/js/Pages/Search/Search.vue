<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserCard from './partials/UserCard.vue';
import PostCard from './partials/PostCard.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  users: {
    type: Object,
    required: true,
  },
  posts: {
    type: Object,
    required: true,
  },
  search: {
    type: String,
    required: true,
  },
});

const users = ref(props.users);
const posts = ref(props.posts);

watch(
  () => props.users,
  (newUsers) => {
    if (newUsers.current_page > 1) {
      users.value = {
        ...newUsers,
        data: [...users.value.data, ...newUsers.data],
      };
    } else {
      users.value = newUsers;
    }
  },
  { deep: true }
);

watch(
  () => props.posts,
  (newPosts) => {
    if (newPosts.current_page > 1) {
      posts.value = {
        ...newPosts,
        data: [...posts.value.data, ...newPosts.data],
      };
    } else {
      posts.value = newPosts;
    }
  },
  { deep: true }
);

function fetchMoreUsers() {
  router.visit(users.value.next_page_url, {
    preserveState: true,
    preserveScroll: true,
    only: ['users'],
  });
}

function fetchMorePosts() {
  router.visit(posts.value.next_page_url, {
    preserveState: true,
    preserveScroll: true,
    only: ['posts'],
  });
}
</script>

<template>
  <AuthenticatedLayout>
    <Head :title="`Search: ` + props.search" />
    <div class="mx-auto flex max-w-6xl flex-col justify-center py-10">
      <h1 class="font-customSerif text-3xl font-semibold text-maroon-500">
        Search results for: {{ search }}
      </h1>
      <div class="flex flex-col items-center py-10">
        <div class="w-1/2 rounded-lg bg-white p-4 shadow-md">
          <h2 class="text-xl font-semibold text-gray-900">Users</h2>
          <div class="mt-4 grid grid-cols-1 gap-4">
            <div v-if="users.data.length > 0">
              <UserCard
                v-for="user in users.data"
                :key="user.id"
                :user_id="user.id"
                :handle="user.handle"
                :first_name="user.first_name"
                :last_name="user.last_name"
                :avatar="user.avatar"
                :quote="user.quote"
              />
            </div>
            <div v-else>
              <p class="text-gray-500">No users found</p>
            </div>
          </div>
          <div v-if="users.next_page_url" class="me-2 mt-4 flex justify-end">
            <button
              @click="fetchMoreUsers"
              class="text-sm font-semibold text-gray-500 hover:underline"
            >
              load more
            </button>
          </div>
        </div>
        <div class="mt-5 w-1/2 rounded-lg bg-white p-4 shadow-md">
          <h2 class="text-xl font-semibold text-gray-900">Posts</h2>
          <div class="mt-4 grid grid-cols-1 gap-4">
            <div v-if="posts.data.length > 0">
              <PostCard
                class="my-3"
                v-for="post in posts.data"
                :key="post.id"
                :id="post.id"
                :title="post.title"
                :content="post.content"
                :user_handle="post.handle"
                :created_at="post.created_at"
              />
            </div>
            <div v-else>
              <p class="text-gray-500">No posts found</p>
            </div>
          </div>
          <div v-if="posts.next_page_url" class="me-2 mt-4 flex justify-end">
            <button
              @click="fetchMorePosts"
              class="text-sm font-semibold text-gray-500 hover:underline"
            >
              load more
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
