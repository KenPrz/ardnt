<script setup>
import { useToast } from 'vue-toastification';
import UserFollowCard from '@/Components/UserFollowCard.vue';
const props = defineProps({
  suggestedFollowers: {
    type: Object,
    required: true,
  },
});
</script>
<template>
  <div class="w-full rounded-lg bg-white px-4 py-2 shadow-sm">
    <h1 class="mt-2 text-lg font-semibold">Who to follow</h1>
    <div class="mt-4 flex flex-col space-y-2 py-2">
      <UserFollowCard
        v-for="follower in suggestedFollowers"
        :key="follower.id"
        v-bind="follower"
        :user_id="follower.id"
        :handle="follower.handle"
        :first_name="follower.first_name"
        :last_name="follower.last_name"
        :avatar="follower.avatar"
      />
    </div>
  </div>
</template>
