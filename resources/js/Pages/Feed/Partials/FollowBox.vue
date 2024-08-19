<script setup>
import { useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import { ref } from 'vue';
import UserFollowCard from '@/Components/UserFollowCard.vue';

const toast = useToast();
const props = defineProps({
    suggestedFollowers: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    user_id: null,
});

const followedUsers = ref(new Set());

function followUser(user_id, handle) {
    if (followedUsers.value.has(user_id)) {
        return; // Prevent spam clicking :)
    }
    
    form.user_id = user_id;
    form.post(route('user.follow'), {
        preserveScroll: true,
        onSuccess: () => {
            followedUsers.value.add(user_id);
            form.user_id = null;
            toast.info(`@${handle} followed successfully`,{
                timeout: 1500,
            });
        },
        onError: () => {
            form.user_id = null;
        },
    });
}

</script>
<template>
    <div class="w-full bg-white rounded-lg shadow-sm py-2 px-4">
        <h1 class="font-semibold text-lg mt-2">Who to follow</h1>
        <div class="mt-4 flex flex-col space-y-2 py-2">
            <UserFollowCard 
                v-for="follower in suggestedFollowers"
                :key="follower.id" 
                v-bind="follower" 
                @follow="followUser" 
                :user_id="follower.id"
                :handle="follower.handle"
                :first_name="follower.first_name"
                :last_name="follower.last_name"
                :avatar="follower.avatar"
                :is_followed="followedUsers.has(follower.id)"
            />
        </div>
    </div>
</template>