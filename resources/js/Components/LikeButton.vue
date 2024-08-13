
<script setup>
import { useForm } from '@inertiajs/vue3';
    const props = defineProps({
        post_id: {
            type: Number,
            required: true,
        }
    });
    const form = useForm({
        post_id: props.post_id,
    });
    const likePost = () => {
        
        form.post(route('post.like', form.data), {
            onSuccess: () => {
                console.log('Post liked');
                alert('Post liked');
            },
        });
    }
</script>
<template>
    <div>
        <button @click="likePost()" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
            Like
        </button>
    </div>
</template>

<style scoped>

</style>