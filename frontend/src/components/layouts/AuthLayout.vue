<script setup>
import AuthNav from "../Auth/Nav/AuthNav.vue";
import { useRoute } from "vue-router";
const route = useRoute();
</script>
<template>
  <body
    class="w-full bg-black h-screen relative bg-cover"
    :class="route.meta.bg"
  >
    <header class="flex justify-center"><AuthNav /></header>
    <main>
      <router-view />
    </main>
  </body>
</template>
