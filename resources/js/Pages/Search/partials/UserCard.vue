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
    <div class="w-full p-2 my-3 border rounded-lg bg-white shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4 w-4/5">
                <a :href="route('users.show', handle)" class="flex-shrink-0">
                    <img 
                        :src="avatar ? '/storage/' + avatar : '/public/default-avatar.jpg'" 
                        :alt="`${first_name} ${last_name}'s avatar`"
                        class="w-16 h-16 rounded-full object-cover"
                    >
                </a>
                <div class="flex flex-col">
                    <a :href="route('users.show', handle)" class="hover:underline">
                        <h1 class="font-semibold text-lg">{{ first_name }} {{ last_name }}</h1>
                    </a>
                    <a :href="route('users.show', handle)" class="hover:underline">
                        <p class="text-gray-500 text-sm">@{{ handle }}</p>
                    </a>
                    <p v-if="quote" class="text-gray-600 text-sm italic mt-2 max-w-md">
                        {{ quote }}
                    </p>
                </div>
            </div>
            <a 
                :href="route('users.show', handle)"
                class="inline-block text-white py-2 px-2 bg-maroon-500 hover:bg-maroon-600 rounded-full transition duration-300 ease-in-out text-sm font-medium"
            >
                Visit Profile
            </a>
        </div>
    </div>
</template>