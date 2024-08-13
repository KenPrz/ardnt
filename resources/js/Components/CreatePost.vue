<script setup>
import { ref, watch, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

const props = defineProps({
    themes: {
        type: Array,
        required: true,
    }
});

const form = useForm({
    'theme': '',
    'content': '',
    'is_public': false,
    'cover_image': null,
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
</script>

<template>
    <div class="flex flex-col w-full p-5">
        <div class="flex justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Create Post</h2>
        </div>
        <div class="mt-5">
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
        </div>
        <div class="mt-5">
            <textarea
                v-model="form.content"
                class="w-full h-32 p-3 border border-gray-300 rounded-lg"
                placeholder="What's on your mind?"
            ></textarea>
        </div>
        <div class="mt-5">
            <select
                v-model="form.theme"
                class="w-full p-3 border border-gray-300 rounded-lg"
            >
                <option value="" disabled>Select a theme</option>
                <option v-for="theme in themes" :key="theme.id" :value="theme.id">
                    {{ theme.name }}
                </option>
            </select>
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

button {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid #ddd;
}
</style>
