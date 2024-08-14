<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import UserFollowCard from '@/Components/UserFollowCard.vue';

const props = defineProps({
    suggestedFollowers: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    user_id: null,
});

function followUser(user_id) {
    form.user_id = user_id;
    form.post(route('user.follow'), {
        preserveScroll: true,
        onSuccess: () => {
            form.user_id = null;
        },
        onError: () => {
            form.user_id = null;
        },
    });
}

</script>
<template>
    <div class="w-full bg-white rounded-lg shadow-sm py-2 px-4">
        <h1 class="font-semibold text-lg">Who to follow</h1>
        <div class="mt-4 flex flex-col space-y-2">
            <UserFollowCard 
                v-for="follower in suggestedFollowers"
                :key="follower.id" v-bind="follower" 
                @follow="followUser" 
                :user_id="follower.user_id"
                :handle = "follower.handle"
                :name = "follower.name"
                :avatar = "follower.avatar"    
            />
        </div>
    </div>
</template>

<style scoped>

</style>