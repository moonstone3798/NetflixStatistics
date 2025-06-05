<script setup>
import AuthNav from "../Auth/Nav/AuthNav.vue";
import { useRoute } from "vue-router";
const route = useRoute();
</script>
<template>
  <body class="w-full min-h-screen relative bg-cover" :class="route.meta.bg">
    <div class="bg-netflix-blackWithOpacity min-h-screen w-full flex flex-col">
      <header class="flex justify-center"><AuthNav /></header>
      <main class="flex-1">
        <router-view />
      </main>
    </div>
  </body>
</template>
