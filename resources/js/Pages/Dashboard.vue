<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PostBox from '@/Components/PostBox.vue';
const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
    followRecommendations: {
        type: Array,
        required: true,
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="mx-10 md:max-w-7xl sm:px-10 md:px-72">
            <div class="py-5 space-y-5">
                <template v-for="post in posts.data" :key="post.id">
                    <PostBox :post="post" />
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
