<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    comment: {
        type: Object,
        required: true,
    }
});
const showOptions = ref(false);
const isEditMode = ref(false);
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
const commentData = useForm({
    post_id: props.comment.post_id,
    content: props.comment.content,
});

function toggleOptions() {
    showOptions.value = !showOptions.value;
    isEditMode.value = false;
}
function submitEdit() {
    commentData.put(route('comments.update', props.comment.id), {
        preserveScroll: true,
        onSuccess: () => {
            isEditMode.value = false;
        },
    });
}

function deleteComment() {
    if (confirm('Are you sure you want to delete this comment?')) {
        commentData.delete(route('comments.destroy', props.comment.id), {
            preserveScroll: true,
        });
    }
}

</script>

<template>
    <div class="flex items-start space-x-2 p-3 border rounded-lg shadow-sm bg-white me-2">
        <!-- User Avatar -->
         <a :href="route('users.show',props.comment.user.id)">
            <img
                :src="props.comment.user.avatar"
                :alt="`${props.comment.user.first_name} ${props.comment.user.last_name}`"
                class="w-12 h-12 rounded-full object-cover"
            />
        </a>
        <!-- Comment Content -->
        <div class="flex-1">
            <!-- User Info -->
            <div class="w-full flex items-center justify-between">
                <div class="flex items-center space-x-2">
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
                <button @click="toggleOptions" v-show="!showOptions">•••</button>
                <div v-show="showOptions" class="flex items-center space-x-2">
                    <button @click="isEditMode = true">
                        <i class="pi pi-pen-to-square" style="font-size: .9em; color: green;"></i>
                    </button>
                    <button @click="deleteComment">
                        <i class="pi pi-trash" style="font-size: .9em; color: red;"></i>
                    </button>
                    <button @click="showOptions=false">
                        <i class="pi pi-times-circle" style="font-size: .9em; color: blue;"></i>
                    </button>
                </div>
            </div>
            <!-- Comment Text -->
            <p v-show="!isEditMode" class="text-gray-700 mb-2 text-sm">
                {{ props.comment.content }}
            </p>
            <!-- Edit Comment -->
             <!-- To Do : Add condition to check if user is the owner of the comment to activate this button -->
            <div v-show="isEditMode" class="flex w-full space-x-2">
                <input
                    v-model="commentData.content"
                    type="text"
                    class="w-full border border-gray-300 rounded-lg p-2"
                />
                <button
                    @click="submitEdit"
                    :disabled="commentData.processing"
                    class="bg-maroon-600 text-white px-4 py-2 rounded-lg"
                >
                    Save
                </button>
            </div>
        </div>
    </div>
</template>