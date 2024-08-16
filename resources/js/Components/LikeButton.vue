<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
  post_id: {
    type: Number,
    required: true,
  },
  is_liked_by_user: {
    type: Boolean,
    required: true,
  },
  likes_count: {
    type: Number,
    required: true,
  },
});
const form = useForm({
  post_id: props.post_id,
});

const likePost = throttleHandler(() => {
  form.post(route('post.like', form.data), {
    preserveScroll: true,
    onSuccess: () => {
      // console.log('liked');
    },
  });
}, 1000);

const unlikePost = throttleHandler(() => {
  form.delete(route('post.unlike', form.data), {
    preserveScroll: true,
    onSuccess: () => {
      // console.log('unliked');
    },
  });
}, 1000);

function throttleHandler(fn, delay) {
  let lastCall = 0;
  return function (...args) {
    const now = new Date().getTime();
    if (now - lastCall < delay) {
      return;
    }
    lastCall = now;
    return fn(...args);
  };
}
</script>
<template>
  <div>
    <transition name="fade" @before-enter="beforeEnter" @enter="enter" @leave="leave">
      <div class="flex space-x-2 items-center justify-center">
        <button :disabled="form.processing" v-if="props.is_liked_by_user" @click="unlikePost()" id="unlike-button"
          class="text-maroon-600 hover:text-maroon-800 font-semibold text-sm">
          <i class="pi pi-heart-fill" style="font-size: 1.2em; color: red; padding-top: 5px"></i>
        </button>
        <button :disabled="form.processing" v-else @click="likePost()" id="like-button"
          class="text-maroon-600 hover:text-maroon-800 font-semibold text-sm">
          <i class="pi pi-heart" style="font-size: 1.2em; padding-top: 5px;"></i>
        </button>
        <span class="text-sm font-light">{{ likes_count }}</span>
      </div>
    </transition>
  </div>
</template>
<script>
export default {
  props: {
    is_liked_by_user: Boolean
  },
  methods: {
    beforeEnter(el) {
      el.style.opacity = 0;
    },
    enter(el, done) {
      el.offsetHeight;
      el.style.transition = 'opacity 0.5s';
      el.style.opacity = 1;
      done();
    },
    leave(el, done) {
      el.style.transition = 'opacity 0.5s';
      el.style.opacity = 0;
      done();
    }
  }
}
</script>

<style scoped>
/* Transition classes */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active in <2.1.8 */
  {
  opacity: 0;
}
</style>