import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/Auth/Login.vue";
import Register from "@/views/Auth/Register.vue";
const routes = [
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: { layout: "AuthLayout", requiresAuth: false, bg: "bg-login-img" },
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
    meta: { layout: "AuthLayout", requiresAuth: false, bg: "bg-register-img" },
  },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
