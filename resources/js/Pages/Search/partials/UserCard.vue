<script setup>
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
    nullable: true,
  },
  quote: {
    type: String,
    nullable: true,
  },
});
</script>

<template>
  <div class="my-3 w-full rounded-lg border bg-white p-2 shadow-sm">
    <div
      class="flex flex-col items-start justify-between space-y-4 sm:flex-row sm:items-center sm:space-y-0"
    >
      <div class="flex w-4/5 items-center space-x-4">
        <a :href="route('users.show', handle)" class="flex-shrink-0">
          <img
            :src="avatar ? '/storage/' + avatar : '/public/default-avatar.jpg'"
            :alt="`${first_name} ${last_name}'s avatar`"
            class="h-16 w-16 rounded-full object-cover"
          />
        </a>
        <div class="flex flex-col">
          <a :href="route('users.show', handle)" class="hover:underline">
            <h1 class="text-lg font-semibold">
              {{ first_name }} {{ last_name }}
            </h1>
          </a>
          <a :href="route('users.show', handle)" class="hover:underline">
            <p class="text-sm text-gray-500">@{{ handle }}</p>
          </a>
          <p v-if="quote" class="mt-2 max-w-md text-sm italic text-gray-600">
            {{ quote }}
          </p>
        </div>
      </div>
      <a
        :href="route('users.show', handle)"
        class="inline-block rounded-full bg-maroon-500 px-2 py-2 text-sm font-medium text-white transition duration-300 ease-in-out hover:bg-maroon-600"
      >
        Visit Profile
      </a>
    </div>
  </div>
</template>
