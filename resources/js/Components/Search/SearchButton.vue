<script setup>

const emit = defineEmits(['toggleSearch']);
const handleClick = () => {
  emit('toggleSearch');
};
</script>

<template>
  <button
    @click="handleClick"
    class="p-2 rounded-md text-gray-400 hover:text-white"
  >
    <i class="pi pi-search"></i>
  </button>
</template>