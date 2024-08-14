<template>
    <div class="flex items-center justify-center space-x-4">
        <template v-for="link in pagination.links" :key="link.url ?? ''">
            <template v-if="link.url">
                <Link
                    preserve-scroll
                    :href="link.url"
                    v-html="link.label"
                    class="px-4 py-2 rounded-md text-black border-gray-200 border-2 hover:bg-gray-200 transition-colors duration-200"
                    :class="{ '!bg-main-500 text-white': link.active }"
                />
            </template>
            <template v-else>
                <span
                    v-html="link.label"
                    class="px-4 py-2 rounded-md text-gray-300 border-gray-200 border-2"
                />
            </template>
        </template>
    </div>    
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
    const pagination = defineProps({
        links: Array,
        first_page_url: String,
        from: Number,
        last_page: Number,
        last_page_url: String,
    })
</script>

<style scoped>

</style>