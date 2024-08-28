
<script setup>
import getRelativeTime from '@/custom-js/dateTimeCalc';
    const props = defineProps({
        id: {
            type: Number,
            required: true,
        },
        title: {
            type: String,
            nullable: true,
        },
        content: {
            type: String,
            nullable: true,
        },
        user_handle: {
            type: String,
            required: true,
        },
        created_at: {
            type: String,
            required: true,
        },
    })
</script>
<template>
    <div class="w-full py-2 px-4 border rounded-lg bg-white">
        <div class="flex flex-col">
            <div class="w-full">
                <h1 class="font-semibold text-md">{{ title }}</h1>
                <p class="text-gray-500 text-xs">
                    <a :href="route('posts.show',id)">
                        <span>@{{ user_handle }}</span>
                    </a>
                    <span class="mx-1">•</span>
                    <span>{{ getRelativeTime(created_at) }}</span>
                </p>
                <div class="line-clamp-3">
                    <p v-html="content"></p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>