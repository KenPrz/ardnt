<template>
    <div class="font-sans">
      <div class="flex justify-around mx-32 border-gray-700">
        <button
          v-for="(tab, index) in tabs"
          :key="index"
          @click="setActiveTab(index)"
          class="min-w-24 px-4 py-2 font-medium text-lg leading-5 focus:outline-none transition duration-300 ease-in-out"
          :class="[
            activeTab === index
              ? 'text-maroon-500 border-b border-maroon-500'
              : 'text-gray-700'
          ]"
        >
          {{ tab.label }}
        </button>
      </div>
      <div class="p-4">
        <slot :name="tabs[activeTab].name"></slot>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Tabbar',
    props: {
      tabs: {
        type: Array,
        required: true,
        validator: (value) => {
          return value.every(tab => typeof tab.label === 'string' && typeof tab.name === 'string');
        }
      }
    },
    data() {
      return {
        activeTab: 0
      };
    },
    methods: {
      setActiveTab(index) {
        this.activeTab = index;
      }
    }
  };
  </script>
  