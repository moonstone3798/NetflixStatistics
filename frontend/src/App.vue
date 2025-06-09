<script setup>
import MainLayout from "@/components/layouts/MainLayout.vue";
import AuthLayout from "@/components/layouts/AuthLayout.vue";
import WelcomeLayout from "@/components/layouts/WelcomeLayout.vue";
import { useRoute } from "vue-router";
const route = useRoute();
const layouts = {
  MainLayout,
  WelcomeLayout,
  AuthLayout,
};
</script>
<template>
  <component :is="layouts[route.meta.layout] || WelcomeLayout" />
</template>
