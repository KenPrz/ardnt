<script setup>
    const props = defineProps({
        user: {
            type: Object,
            required: true,
        },
        posts: {
            type: Array,
            required: true,
        },
        followers: {
            type: Object,
            required: true,
        },
        following: {
            type: Object,
            required: true,
        },
    });
</script>
<template>
    <div>
        {{props.user}}
        {{props.posts}}
        {{props.followers}}
        {{props.following}}
    </div>
</template>

<style scoped>

</style>