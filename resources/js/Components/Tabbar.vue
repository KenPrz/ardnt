<template>
  <div class="font-sans">
    <div class="mx-32 flex justify-around border-gray-700">
      <button
        v-for="(tab, index) in tabs"
        :key="index"
        @click="setActiveTab(index)"
        class="min-w-24 px-4 py-2 text-lg font-medium leading-5 transition duration-300 ease-in-out focus:outline-none"
        :class="[
          activeTab === index
            ? 'border-b border-maroon-500 text-maroon-500'
            : 'text-gray-700',
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
        return value.every(
          (tab) => typeof tab.label === 'string' && typeof tab.name === 'string'
        );
      },
    },
  },
  data() {
    return {
      activeTab: 0,
    };
  },
  methods: {
    setActiveTab(index) {
      this.activeTab = index;
    },
  },
};
</script>
