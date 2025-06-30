<script setup>
import { ref } from "vue";
import NIcon from "../../../../public/Icon/NIcon.vue";
import Avatar from "../../Generic/Avatar/Avatar.vue";
import { useRouter } from "vue-router";
const props = defineProps({
  withButton: {
    type: Boolean,
    default: false,
    required: false,
  },
});
const router = useRouter();
const userInfo = JSON.parse(localStorage.getItem("userInfo"));
const showDropdown = ref(false);
const handleShowModal = () => {
  showDropdown.value = !showDropdown.value;
};
const logout = () => {
  localStorage.removeItem("userInfo");
  router.push("/login");
};
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
        <li>
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
      <div class="relative flex justify-end">
        <Avatar @click="handleShowModal" class="cursor-pointer" />
        <div
          v-if="showDropdown"
          class="z-10 absolute top-full right-0 mt-3 bg-netflix-darkGray divide-y divide-netflix-gray rounded-lg shadow-sm w-44"
        >
          <ul
            class="text-sm text-gray-200"
            aria-labelledby="dropdownDefaultButton"
          >
            <li
              class="flex px-2 items-center gap-x-2 py-2 border border-netflix-gray"
            >
              <Avatar /> {{ userInfo.nombre }} {{ userInfo.apellido }}
            </li>
            <li
              class="text-center px-2 cursor-pointer hover:bg-netflix-redHover py-4"
              @click="logout"
            >
              Cerrar Sesión
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>
