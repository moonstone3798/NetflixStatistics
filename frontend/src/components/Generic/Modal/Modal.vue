<script setup>
import CloseIcon from "../../../../public/Icon/CloseIcon.vue";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  showModal: {
    type: Boolean,
    default: false,
  },
  buttonText: {
    type: String,
    required: true,
  },
});
const emit = defineEmits(["close", "submit"]);
</script>
<template>
  <div class="w-full justify-center items-center bg-netflix-blackWithOpacity">
    <div
      class="overflow-y-auto flex jus overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
    >
      <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-black rounded-lg shadow-sm">
          <div
            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t"
          >
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              {{ props.title }}
            </h3>
            <button
              type="button"
              class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="authentication-modal"
              @click="emit('close')"
            >
              <CloseIcon class="w-4 h-4" />
            </button>
          </div>
          <div class="p-4 md:p-5">
            <div class="min-h-40 flex justify-center items-center w-full">
              <div class="w-full">
                <slot />
              </div>
            </div>
            <button
              type="submit"
              class="button-netflix"
              @click="emit('submit')"
            >
              {{ props.buttonText }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
