<script setup>
import FollowButton from '@/Components/FollowButton.vue';

const props = defineProps({
  user_id: {
    type: Number,
    required: true,
  },
  handle: {
    type: String,
    required: true,
  },
  first_name: {
    type: String,
    required: true,
  },
  last_name: {
    type: String,
    required: true,
  },
  avatar: {
    type: String,
    required: true,
  },
  is_followed: {
    type: Boolean,
    default: false,
  },
});
</script>
<template>
  <div class="w-full rounded-lg border bg-white px-4 py-2">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <a :href="route('users.show', handle)">
          <img
            :src="`/storage/` + avatar"
            alt="avatar"
            class="h-12 w-12 rounded-full"
          />
        </a>
        <div class="ml-2">
          <a :href="route('users.show', handle)">
            <h1 class="text-md font-semibold">
              {{ first_name }} {{ last_name }}
            </h1>
          </a>
          <a :href="route('users.show', handle)">
            <p class="text-gray-500">@{{ handle }}</p>
          </a>
        </div>
      </div>
      <FollowButton :user_id="user_id" :is_followed="is_followed" />
    </div>
  </div>
</template>
