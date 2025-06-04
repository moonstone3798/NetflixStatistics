<script setup>
import { ref, onMounted } from "vue";
const props = defineProps({
  title: {
    type: String,
    required: true,
  },
});
const showTransition = ref(false);
onMounted(() => {
  showTransition.value = true;
});
</script>
<template>
  <div class="flex flex-col items-center justify-center h-full">
    <Transition
      enter-active-class="transition-all duration-500 ease-in-out"
      enter-from-class="scale-75 opacity-0"
      enter-to-class="scale-100 opacity-100"
    >
      <div
        v-if="showTransition"
        class="w-full z-20 md:max-w-md max-w-80 flex justify-center md:px-16 px-4 md:py-12 py-6 bg-netflix-blackWithOpacity rounded-[4px] shadow-md"
      >
        <div class="md:max-w-80 max-w-60 w-full">
          <h1 class="text-2xl text-white font-medium leading-10 mb-6">
            {{ props.title }}
          </h1>
          <slot name="content"></slot>
        </div></div
    ></Transition>
  </div>
</template>
