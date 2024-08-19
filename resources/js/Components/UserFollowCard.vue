<script setup>
import { ref } from 'vue';

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

const emit = defineEmits(['follow']);

const isFollowed = ref(props.is_followed);

function followUser() {
    if (!isFollowed.value) {
        emit('follow', props.user_id,props.handle);
        isFollowed.value = true;
    }
}
</script>
<template>
    <div class="w-full py-2 px-4 border rounded-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img :src="`/storage/avatars/`+avatar" alt="avatar" class="w-12 h-12 rounded-full">
                <div class="ml-2">
                    <h1 class="font-semibold text-md">{{ first_name }} {{ last_name }}</h1>
                    <p class="text-gray-500">@{{ handle }}</p>
                </div>
            </div>
            <button
                @click="followUser"
                :class="[
                    'transition-colors duration-200 px-4 py-2 rounded-full ml-auto',
                    isFollowed ? 'bg-gray-300 text-gray-700' : 'bg-blue-500 hover:bg-blue-600 text-white'
                ]"
                :disabled="isFollowed"
            >
                {{ isFollowed ? 'Followed' : 'Follow' }}
            </button>
        </div>
    </div>
</template>