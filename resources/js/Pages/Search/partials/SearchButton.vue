<script setup>
const emit = defineEmits(['toggleSearch']);
const handleClick = () => {
  emit('toggleSearch');
};
</script>

<template>
  <button
    @click="handleClick"
    class="rounded-md p-2 text-gray-400 hover:text-white flex items-center justify-center space-x-2"
  >
<i class="pi pi-search"></i> <span class="text-xs text-white">ctrl + k</span> 
  </button>
</template>
