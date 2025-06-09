<script setup>
import AuthNav from "../Auth/Nav/AuthNav.vue";
import { useRoute } from "vue-router";
const route = useRoute();
</script>

<template>
  <div class="w-full min-h-screen relative bg-cover" :class="route.meta.bg">
    <div
      class="bg-netflix-blackWithOpacity min-h-screen w-full flex flex-col md:gap-y-0 gap-y-20"
    >
      <header class="flex justify-center">
        <AuthNav withButton />
      </header>
      <main class="flex-1 h-full flex justify-center items-center">
        <router-view />
      </main>
      <footer class="mt-auto">
        <div class="w-full md:max-w-[37%] pl-6">
          <h2 class="text-white font-bold text-5xl leading-[62px] mb-4">
            Grupo Nº4
          </h2>
          <h3
            class="text-white font-normal text-2xl leading-[30px] md:mb-6 mb-3"
          >
            García Ferré Pablo, Llanos Milagros Belén, Perrone Gastón Ariel,
            Adad Jorge Nadir, Pitz Brian
          </h3>
        </div>
      </footer>
    </div>
  </div>
</template>
