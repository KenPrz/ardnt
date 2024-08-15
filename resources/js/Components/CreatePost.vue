<script setup>
import { ref, watch, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Editor from '@/Components/Editor.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const emit = defineEmits(['close']);
const blogContent = ref('Write something amazing...');
const props = defineProps({
    themes: {
        type: Array,
        required: true,
    }
});

const form = useForm({
    'title': '',
    'content': '',
    'theme': '',
    'cover_image': null,
    'is_public': false,
    'is_shared': false,
    'shared_post_id': null,
});

const previewImage = ref(null);

watch(() => form.cover_image, (newFile) => {
    if (newFile) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.value = e.target.result;
        };
        reader.readAsDataURL(newFile);
    } else {
        previewImage.value = null;
    }
});

const handleFileChange = (event) => {
    form.cover_image = event.target.files[0];
};

const removeFile = () => {
    form.cover_image = null;
};

function submitPost() {
    form.content = blogContent.value;
    form.post(route('posts.store'),
        {
            preserveScroll: true,
            onSuccess: (data) => {
                form.reset();
                console.log('Post created successfully: ', data);
                emit('close');
            }
        });
}
</script>

<template>
    <div class="flex flex-col w-full p-5">
        <div class="flex justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Create Post</h2>
        </div>
        <div class="flex flex-col mt-5">
            <input
                v-if="!previewImage"
                type="file"
                class="w-full p-3 border border-gray-300 rounded-lg"
                @change="handleFileChange"
            />
            <div v-if="previewImage" class="mt-4 relative">
                <img :src="previewImage" alt="Image preview" class="w-full h-auto rounded-lg border border-gray-300">
                <button @click="removeFile" 
                    class="absolute top-0 right-0 bg-red-500">
                        <i class="pi pi-times" 
                            style="font-size: 1.2em; color: black;"></i>
                </button>
            </div>
            <div>
                <InputError :message="form.errors.cover_image" />
            </div>
        </div>
        <div class="mt-5 w-full">
            <div class="py-2">
                <label for="title">Title</label>
                <TextInput class="w-full" v-model="form.title" label="Title" />
            </div>
            <Editor v-model="blogContent" >
                <div class="flex space-x-4 justify-center items-center mb-3">
                    <div class="flex flex-col justify-center items-center">
                        <div class="flex items-center">
                            <label for="visibility" class="mr-2">Public</label>
                            <Checkbox name="visibility" v-model:checked="form.is_public" />
                        </div>
                        <div>
                            <InputError :message="form.errors.is_public" />
                        </div>
                    </div>
                    <div class="flex flex-col w-w-3/4">
                        <select
                            v-model="form.theme"
                            class=" border border-gray-300 rounded-lg"
                        >
                            <option value="" disabled>Select a theme</option>
                            <option v-for="theme in themes" :key="theme.id" :value="theme.id">
                                {{ theme.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.theme" />
                    </div>
                </div>
            </Editor>
            <InputError :message="form.errors.content" />
        </div>
        <div class="mt-5">
            <button @click="submitPost" class="w-full p-3 bg-blue-500 text-white rounded-lg">
                Create Post
            </button>
        </div>
    </div>
</template>

<style scoped>
input[type="file"] {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    border-radius: 0.375rem;
    padding: 0.75rem;
    cursor: pointer;
}

input[type="file"]::-webkit-file-upload-button {
    visibility: hidden;
}

input[type="file"]::before {
    content: 'Choose a file';
    display: inline-block;
    background: #007bff;
    color: white;
    border: 1px solid #007bff;
    border-radius: 0.375rem;
    padding: 0.5rem 1rem;
    text-align: center;
    font-size: 1rem;
    line-height: 1.5;
    cursor: pointer;
}

img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
}
</style>
