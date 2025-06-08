<script setup>
import NIcon from "../../../../public/Icon/NIcon.vue";
import { useRouter } from "vue-router";
import Avatar from "../../Generic/Avatar/Avatar.vue";
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
    class="w-[95%] py-3.5 flex md:justify-between items-center flex-col md:flex-row gap-y-4 md:gap-y-0"
  >
    <router-link to="/dashboard">
      <NIcon class="opacity-100 max-" />
    </router-link>
    <div class="flex items-center gap-x-5">
      <ul class="text-white gap-x-9 flex items-center justify-between">
        <li>
          <router-link to="/dashboard">Home</router-link>
        </li>
        <li>
          <router-link to="/myGraphics">Mis Gráficos</router-link>
        </li>
        <li>
          <router-link to="/aboutUs">Nosotros</router-link>
        </li>
      </ul>
      <Avatar />
    </div>
  </nav>
</template>
