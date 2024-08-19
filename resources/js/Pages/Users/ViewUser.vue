<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    function cleanUrl(url) {
        return url.replace(/(^\w+:|^)\/\//, '');
    }
</script>
<template>
    <Head title="Dashboard" />
        <AuthenticatedLayout>
        <div class="w-full flex justify-center">
            <div class="max-w-6xl">
                <div class="flex">
                    <div class="flex flex-col items-center space-y-3 w-1/3">
                        <div class="h-2/3 w-auto">
                            <img
                                class="object-cover w-full h-full rounded-full"
                                :src="'/storage/avatars/' + user.avatar"
                                :alt="user.first_name"
                            />
                        </div>
                        <div class="flex">
                            <a class="flex items-center space-x-2" :href="user.website" target="_blank">
                                <i class="pi pi-link" style="font-size: 1.2em; color:#a02334;"></i>
                                <span class="text-maroon-500 hover:text-maroon-500 truncate">{{ cleanUrl(user.website) }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col w-2/3 justify-start">
                        <!-- Name -->
                         <h1 class="text-6xl font-customSerif text-maroon-500">{{ user.first_name+' '+user.last_name}}</h1>
                         <!-- Handle -->
                        <a :href="route('users.show',user.id)">
                            <h2 class="text-md text-gray-500">@{{ user.handle }}</h2>
                        </a>
                        <!-- Quote -->
                        <p class="text-lg text-gray-700 italic">"{{ user.quote }}"
                            <span>
                                <button>
                                    <i class="pi pi-pencil" style="font-size: .8em;"></i>
                                </button>
                            </span>
                        </p>
                        <div class="flex w-full justify-between mt-1">
                            <div class="flex space-x-2">
                                <div>
                                    <a class="flex space-x-1" :href="route('users.posts',user.id)">
                                        <p class="text-sm text-gray-700">{{ posts.count }}</p>
                                        <p class="text-sm text-gray-500">Posts</p>
                                    </a>
                                </div>
                                <div>
                                    <a class="flex space-x-1" :href="route('users.following',user.id)">
                                        <p class="text-sm text-gray-700">{{ following.count }}</p>
                                        <p class="text-sm text-gray-500">Following</p>
                                    </a>
                                </div>
                                <div>
                                    <a class="flex space-x-1" :href="route('users.followers',user.id)">
                                        <p class="text-sm text-gray-700">{{ followers.count }}</p>
                                        <p class="text-sm text-gray-500">Followers</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>