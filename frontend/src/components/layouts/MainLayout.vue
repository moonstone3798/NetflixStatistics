<script setup>
import MainNav from "../Main/Nav/MainNav.vue";
</script>
<template>
  <body class="w-full min-h-screen relative bg-cover flex flex-col bg-black">
    <header class="flex justify-center border-b"><MainNav /></header>
    <main class="flex-1 flex items-center justify-center w-full">
      <router-view />
    </main>
  </body>
</template>
