<script setup>
    import InputError from '@/Components/InputError.vue';
    import { useForm } from '@inertiajs/vue3';
    import { useToast } from 'vue-toastification';
    const toast = useToast();
    const props = defineProps({
        post_id: {
            type: Number,
            required: true,
        },
    })
    const form = useForm({
        post_id: props.post_id,
        content: '',
    });

    function submitComment() {
        form.post(route('comments.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
            },
        });
    }
</script>
<template>
    <div class="w-full flex flex-col items-start py-2">
        <div class="flex w-full space-x-2">
            <input
                v-model="form.content"
                type="text"
                class="w-full border border-gray-300 rounded-lg p-2"
                placeholder="Write a comment..."
                @keyup.enter="submitComment"
            />
            <button
                @click="submitComment"
                :disabled="form.processing"
                class="bg-maroon-600 text-white px-4 py-2 rounded-lg"
            >
                Comment
            </button>
        </div>
        <InputError :message="form.errors.content" class="mt-1" />
    </div>
</template>