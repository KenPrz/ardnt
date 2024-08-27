<script setup>
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import Editor from '@/Components/Editor.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import OriginalPostContainer from '@/Components/OriginalPostContainer.vue';
import { inject } from 'vue';

const toast = useToast();
const themes = inject('themes');
const emit = defineEmits(['close']);
const props = defineProps({
    post_to_share: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    'title': null,
    'content': '',
    'theme': '',
    'cover_image': null,
    'is_public': false,
    'is_shared': true,
    'shared_post_id': props.post_to_share.id,
});

function sharePost() {
    form.post(route('posts.share'), {
        onSuccess: () => {
            toast.success('Post shared successfully!');
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
    <div class="flex flex-col rounded-lg overflow-hidden w-full bg-white shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Share Post</h2>
        </div>
        
        <!-- Content Editor -->
        <div class="p-6 space-y-4">
            <div>
                <div class="flex justify-end items-center space-x-3">
                    <label for="theme" class="text-sm text-gray-600">{{ form.is_public ? 'Public' : 'Private' }}</label>
                    <Checkbox 
                        :disabled="form.processing"
                        :checked="form.is_public"
                        v-model="form.is_public" id="is_shared" class="mr-2" />
                    <InputError :message="form.errors.is_shared" />
                </div>
                <div :class="{ 'pointer-events-none': form.processing }">
                    <Editor v-model="form.content" >
                        <!-- Theme Selector -->
                        <div class="w-3/4 mb-2">
                            <select :disabled="form.processing" v-model="form.theme" id="theme" class="w-full border border-gray-300 rounded-lg p-2">
                                <option value="" disabled>Select a theme</option>
                                <option v-for="theme in themes" :key="theme.id" :value="theme.id">
                                    {{ theme.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.theme" class="mt-2" />
                        </div>
                    </Editor>
                    <InputError :message="form.errors.content" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Original Post -->
        <div class="p-6 bg-gray-50">
            <OriginalPostContainer :originalPost="post_to_share" :postSharer="user" />
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end p-6 border-t bg-gray-50">
            <button 
                @click="sharePost" 
                :disabled="form.processing"
                :class="[form.processing ? 'bg-maroon-300':'bg-maroon-500 hover:bg-maroon-600','transition-colors duration-200 text-white w-full p-3 rounded-xl']"
            >
                <i v-show="form.processing" class="animate-spin pi pi-spinner me-1" style="font-size: .9em;"></i>
                <span v-if="form.processing">Sharing</span>
                <span v-else>Share</span>
                <span>Post</span>
            </button>
        </div>
    </div>
</template>

<style scoped>
/* You can add custom styles here if needed */
</style>
