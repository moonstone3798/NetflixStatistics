<script setup>
import MainLayout from "@/components/layouts/MainLayout.vue";
import AuthLayout from "@/components/layouts/AuthLayout.vue";
import HomeLayout from "@/components/layouts/HomeLayout.vue";
import { useRoute } from "vue-router";
const route = useRoute();
const layouts = {
  MainLayout,
  HomeLayout,
  AuthLayout,
};
</script>
<template>
  <component :is="layouts[route.meta.layout] || HomeLayout" />
</template>
