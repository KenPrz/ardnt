<script setup>
import UserFollowCard from '@/Components/UserFollowCard.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";

const toast = useToast();

    const props = defineProps({
        followers: {
            type: Object,
            required: true
        }
    });

    const form = useForm({
        user_id: null,
    });

    function followUser(user_id, handle) {
        form.user_id = user_id;
        form.post(route('user.follow'), {
            preserveScroll: true,
            onSuccess: () => {
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
<div class="md:mx-32 mt-5">
        <div class="flex flex-col -space-y-1 ">
            <span class="text-center text-md font-semibold text-maroon-500">{{ followers.data.length === 0 ? 'No followers yet :(' : '' }}</span>
            <div class="py-2" v-for="follower in followers.data" :key="follower.id">
                <UserFollowCard
                    @follow="followUser" 
                    :user_id="follower.id"
                    :handle="follower.handle"
                    :first_name="follower.first_name"
                    :last_name="follower.last_name"
                    :avatar="follower.avatar"
                    :is_followed="follower.is_followed_by_me"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>