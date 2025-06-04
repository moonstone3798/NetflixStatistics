<script setup>
import NetflixIcon from "../../../../public/Icon/NetflixIcon.vue";
import { useRouter } from "vue-router";
const router = useRouter();
const props = defineProps({
  withButton: {
    type: Boolean,
    default: false,
    required: false,
  },
});
const redirectToLogin = () => {
  router.push({
    name: "Login",
  });
};
</script>
<template>
  <nav
    class="w-5/6 py-7 flex md:justify-between items-center flex-col md:flex-row gap-y-4 md:gap-y-0"
  >
    <router-link to="/">
      <NetflixIcon class="opacity-100" />
    </router-link>
    <button
      v-if="props.withButton"
      @click="redirectToLogin()"
      class="button-netflix max-w-32"
    >
      Iniciar sesión
    </button>
  </nav>
</template>
