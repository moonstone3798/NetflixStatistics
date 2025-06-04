import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/Auth/Login.vue";
import Register from "@/views/Auth/Register.vue";
import Home from "@/views/Auth/Home.vue";
import AboutUs from "@/views/Main/AboutUs/AboutUs.vue";
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
  {
    path: "/",
    name: "Home",
    component: Home,
    meta: { layout: "HomeLayout", requiresAuth: false, bg: "bg-home-img" },
  },
  {
    path: "/aboutUs",
    name: "AboutUs",
    component: AboutUs,
    meta: { layout: "MainLayout", requiresAuth: false },
  },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
