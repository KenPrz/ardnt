<script setup>
const emit = defineEmits(['toggleSearch']);
const handleClick = () => {
  emit('toggleSearch');
};
</script>

<template>
  <button
    @click="handleClick"
    class="rounded-md p-2 text-gray-400 hover:text-white"
  >
    <i class="pi pi-search"></i>
  </button>
</template>
