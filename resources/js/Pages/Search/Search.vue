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

watch(() => props.users, (newUsers) => {
    if (newUsers.current_page > 1) {
        users.value = {
            ...newUsers,
            data: [...users.value.data, ...newUsers.data]
        };
    } else {
        users.value = newUsers;
    }
}, { deep: true });

watch(() => props.posts, (newPosts) => {
    if (newPosts.current_page > 1) {
        posts.value = {
            ...newPosts,
            data: [...posts.value.data, ...newPosts.data]
        };
    } else {
        posts.value = newPosts;
    }
}, { deep: true });

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
        <Head :title="`Search: `+props.search" />
        <div class="flex flex-col justify-center mx-auto max-w-6xl py-10">
            <h1 class="text-3xl font-semibold font-customSerif text-maroon-500">Search results for: {{ search }}</h1>
            <div class="flex flex-col items-center py-10">
                <div class="bg-white rounded-lg shadow-md p-4 w-1/2">
                    <h2 class="text-xl font-semibold text-gray-900">Users</h2>
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <div v-if="users.data.length > 0">
                            <UserCard
                                v-for="user in users.data" :key="user.id"
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
                    <div
                        v-if="users.next_page_url" 
                        class="flex justify-end mt-4 me-2">
                        <button 
                            @click="fetchMoreUsers"
                            class="text-sm text-gray-500 font-semibold hover:underline">
                            load more
                        </button>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 w-1/2 mt-5">
                    <h2 class="text-xl font-semibold text-gray-900">Posts</h2>
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <div v-if="posts.data.length > 0">
                            <PostCard
                                class="my-3"
                                v-for="post in posts.data" :key="post.id"
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
                    <div
                        v-if="posts.next_page_url" 
                        class="flex justify-end mt-4 me-2">
                        <button 
                            @click="fetchMorePosts"
                            class="text-sm text-gray-500 font-semibold hover:underline">
                            load more
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>