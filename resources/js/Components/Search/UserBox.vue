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
        handle:{
            type: String,
            required: true,
        },
        avatar: {
            type: String,
            required: true,
        },
    })
</script>
<template>
    <a 
        :href="route('users.show', handle)"
        class="flex items-center space-x-2 w-full py-2 px-4 border rounded-lg bg-white hover:bg-slate-200">
        <img :src="avatar ? '/storage/' + avatar : '/public/default-avatar.jpg'" alt="avatar" class="w-12 h-12 rounded-full">
        <div>
            <h1 class="font-semibold text-sm">{{ first_name }} {{ last_name }}</h1>
            <p class="text-gray-500 text-xs">@{{ handle }}</p>
        </div>
    </a>
</template>

<style scoped>

</style>