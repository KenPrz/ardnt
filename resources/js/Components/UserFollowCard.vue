<script setup>
import FollowButton from '@/Components/FollowButton.vue';

const props = defineProps({
    user_id: {
        type: Number,
        required: true,
    },
    handle: {
        type: String,
        required: true,
    },
    first_name: {
        type: String,
        required: true,
    },
    last_name: {
        type: String,
        required: true,
    },
    avatar: {
        type: String,
        required: true,
    },
    is_followed: {
        type: Boolean,
        default: false,
    },
});
</script>
<template>
    <div class="w-full py-2 px-4 border rounded-lg bg-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a :href="route('users.show',handle)">
                    <img :src="`/storage/avatars/`+avatar" alt="avatar" class="w-12 h-12 rounded-full">
                </a>
                <div class="ml-2">
                    <a :href="route('users.show',handle)">
                        <h1 class="font-semibold text-md">{{ first_name }} {{ last_name }}</h1>
                    </a>
                    <a :href="route('users.show',handle)">
                        <p class="text-gray-500">@{{ handle }}</p>
                    </a>
                </div>
            </div>
            <FollowButton 
                :user_id="user_id"
                :is_followed="is_followed" />
        </div>
    </div>
</template>