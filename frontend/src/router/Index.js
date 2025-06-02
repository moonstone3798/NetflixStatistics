import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/Auth/Login.vue";

const routes = [
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: { layout: "AuthLayout", requiresAuth: false },
  },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
