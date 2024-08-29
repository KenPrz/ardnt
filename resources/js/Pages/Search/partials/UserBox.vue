<script setup>
const props = defineProps({
  id: {
    type: Number,
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
  handle: {
    type: String,
    required: true,
  },
  avatar: {
    type: String,
    nullable: true,
  },
});
</script>
<template>
  <a
    :href="route('users.show', handle)"
    class="flex w-full items-center space-x-2 rounded-lg border bg-white px-4 py-2 hover:bg-slate-200"
  >
    <img
      :src="avatar ? '/storage/' + avatar : '/public/default-avatar.jpg'"
      alt="avatar"
      class="h-12 w-12 rounded-full"
    />
    <div>
      <h1 class="text-sm font-semibold">{{ first_name }} {{ last_name }}</h1>
      <p class="text-xs text-gray-500">@{{ handle }}</p>
    </div>
  </a>
</template>

<style scoped></style>
