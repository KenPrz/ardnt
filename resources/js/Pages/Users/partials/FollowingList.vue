<script setup>
import UserFollowCard from '@/Components/UserFollowCard.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
const toast = useToast();
    const props = defineProps({
        followings: {
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
        <div class="flex flex-col -space-y-1">
            <div class="py-2" v-for="following in followings.data" :key="following.id">
                <UserFollowCard
                    @follow="followUser" 
                    :user_id="following.id"
                    :handle="following.handle"
                    :first_name="following.first_name"
                    :last_name="following.last_name"
                    :avatar="following.avatar"
                    :is_followed="following.is_followed_by_me"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>