
<script setup>
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
    });
    
    const emit = defineEmits(['follow']);

    function followUser() {
        emit('follow', props.user_id);
    }
</script>
<template>
    <div class="w-full py-2 px-4 border rounded-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img :src="avatar" alt="avatar" class="w-12 h-12 rounded-full">
                <div class="ml-2">
                    <h1 class="font-semibold text-md">{{ first_name }} {{ last_name }}</h1>
                    <p class="text-gray-500">@{{ handle }}</p>
                </div>
            </div>
            <button
                @click="followUser"
                class="bg-blue-500 hover:bg-blue-600 transition-colors duration-200 text-white px-4 py-2 rounded-full ml-auto">
                Follow
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>