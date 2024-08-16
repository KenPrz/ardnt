<script setup>
const props = defineProps({
    comment: {
        type: Object,
        required: true,
    }
});

function getRelativeTime(dateString) {
    const now = new Date();
    const commentDate = new Date(dateString);
    const diffInSeconds = Math.floor((now - commentDate) / 1000);
    
    if (diffInSeconds < 60) return `${diffInSeconds} seconds ago`;
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`;
    if (diffInSeconds < 2419200) return `${Math.floor(diffInSeconds / 604800)} weeks ago`;
    if (diffInSeconds < 29030400) return `${Math.floor(diffInSeconds / 2419200)} months ago`;

    return `${Math.floor(diffInSeconds / 29030400)} years ago`;
}
</script>

<template>
    <div class="flex items-start space-x-4 p-3 border rounded-lg shadow-sm bg-white me-2">
        <!-- User Avatar -->
        <img
            :src="props.comment.user.avatar"
            :alt="`${props.comment.user.first_name} ${props.comment.user.last_name}`"
            class="w-12 h-12 rounded-full object-cover"
        />

        <!-- Comment Content -->
        <div class="flex-1">
            <!-- User Info -->
            <div class="w-full flex items-center space-x-2">
                <div class="flex items-center">
                    <a class="hover:underline" :href="route('users.show', props.comment.user.id)">
                        <span class="text-gray-500">@{{ props.comment.user.handle }}</span>
                    </a>
                </div>
                <span>•</span>
                <!-- Timestamp -->
                <div class="text-xs text-gray-500">
                    {{ getRelativeTime(props.comment.created_at) }}
                    <span v-if="props.comment.is_edited" class="text-gray-400">(Edited)</span>
                </div>
            </div>
            <!-- Comment Text -->
            <p class="text-gray-700 mb-2 text-sm">
                {{ props.comment.content }}
            </p>
        </div>
    </div>
</template>

<style scoped>
/* Optional styling for the comment card */
</style>
