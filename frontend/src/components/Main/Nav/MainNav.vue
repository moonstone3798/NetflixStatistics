<script setup>
import NIcon from "../../../../public/Icon/NIcon.vue";
import Avatar from "../../Generic/Avatar/Avatar.vue";
const props = defineProps({
  withButton: {
    type: Boolean,
    default: false,
    required: false,
  },
});
const userInfo = JSON.parse(localStorage.getItem("userInfo"));
</script>
<template>
  <nav
    class="w-[95%] py-3.5 flex md:justify-between items-center flex-col md:flex-row gap-y-4 md:gap-y-0"
  >
    <router-link to="/home">
      <NIcon class="opacity-100 max-" />
    </router-link>
    <div class="flex items-center gap-x-5">
      <ul class="text-white gap-x-9 flex items-center justify-between">
        <li v-if="userInfo.is_admin == 1">
          <router-link to="/home">Home</router-link>
        </li>
        <li v-if="userInfo.is_admin == 1">
          <router-link to="/data">Datos</router-link>
        </li>
        <li v-else-if="userInfo.is_admin == 0">
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
