<script setup>
import { ref, inject, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import Editor from '@/Components/Editor.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import OriginalPostContainer from '@/Components/OriginalPostContainer.vue';

const emit = defineEmits(['close']);
const toast = useToast();
const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const themes = inject('themes');
const showDeleteModal = ref(false); // State to manage modal visibility

const form = useForm({
    id: props.post.id,
    title: props.post.title,
    content: props.post.content,
    theme: props.post.theme.id,
    cover_image: props.post.cover_image,
    is_public: props.post.is_public,
    is_shared: props.post.is_shared,
    shared_post_id: props.post.shared_post_id,
});

function updatePost() {
    form.put(route('posts.update'), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Post updated successfully');
            setTimeout(() => {
                emit('close');
            }, 500);
        },
        onError: (error) => {
            console.log(error);
        },
    });
}

function deletePost() {
    form.delete(route('posts.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Post deleted successfully');
            setTimeout(() => {
                emit('close');
            }, 500);
        },
        onError: (error) => {
            console.log(error);
        },
    });
}
</script>

<template>
    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden w-full bg-white">
        <!-- Post Image -->
        <div v-if="post.cover_image" class="w-full">
            <img class="object-cover w-full h-72 rounded-t-lg" :src="'/storage/' + post.cover_image" :alt="post.title" />
        </div>
        <!-- Post Content -->
        <div class="p-6">
            <!-- Title -->
            <div v-if="!post.is_shared" class="w-full mb-4">
                <TextInput
                    :disabled="form.processing"
                    v-model="form.title"
                    label="Title"
                    type="text"
                    name="title"
                    :errors="form.errors.title"
                    class="w-full"
                />
            </div>
            <!-- Post Meta -->
            <div class="mb-4 text-sm text-gray-500">
                <div class="flex items-center space-x-3 mb-4">
                    <Checkbox
                        :disabled="form.processing"
                        :checked="form.is_public"
                        v-model="form.is_public"
                        name="is_public"
                        label="Public"
                        :errors="form.errors.is_public"
                    />
                    <span>{{ form.is_public ? 'Public' : 'Private' }}</span>
                </div>
                <div>
                    <label for="theme" class="block mb-2 text-sm font-medium text-gray-700">Theme</label>
                    <select
                        :disabled="form.processing"
                        v-model="form.theme"
                        id="theme"
                        class="w-full border border-gray-300 rounded-lg p-2"
                    >
                        <option value="" disabled>Select a theme</option>
                        <option v-for="theme in themes" :key="theme.id" :value="theme.id">
                            {{ theme.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.theme" />
                </div>
            </div>

            <!-- Excerpt -->
            <div class="mb-4 text-gray-700" :class="{ 'pointer-events-none': form.processing }">
                <Editor v-model="form.content">
                    <button @click="showDeleteModal = true" class="me-2" :disabled="form.processing">
                        <i class="pi pi-trash" style="font-size: 1em; color: red;"></i>
                    </button>
                </Editor>
                <InputError :message="form.errors.content" />
            </div>

            <!-- Shared Post -->
            <div v-if="post.is_shared" class="py-2">
                <OriginalPostContainer :originalPost="post.original_post" :postSharer="post.user" />
            </div>
        </div>
        <!-- Update Button -->
        <div class="flex items-center p-6">
            <button
                :disabled="form.processing"
                @click="updatePost"
                :class="[form.processing ? 'bg-maroon-300':'bg-maroon-500 hover:bg-maroon-600','transition-colors duration-200 text-white w-full p-3 rounded-xl']"
            >
                <i v-show="form.processing" class="animate-spin pi pi-spinner me-1" style="font-size: .9em;"></i>
                <span v-if="form.processing">Updating</span>
                <span v-else>Update</span> Post
            </button>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <Modal maxWidth="md" :show="showDeleteModal" @close="showDeleteModal = false">
        <template #default>
            <div class="p-6">
                <h2 class="text-lg font-semibold">Confirm Delete</h2>
                <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete this post? This action cannot be undone.</p>
                <div class="mt-4 flex justify-end">
                    <button @click="showDeleteModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded mr-2">Cancel</button>
                    <button @click="deletePost" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                </div>
            </div>
        </template>
    </Modal>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease, max-height 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    max-height: 0;
}

.fade-enter-to,
.fade-leave-from {
    opacity: 1;
    max-height: 1000px;
    overflow: hidden;
}
</style>
