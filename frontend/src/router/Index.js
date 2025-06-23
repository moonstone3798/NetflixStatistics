import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/Auth/Login.vue";
import Register from "@/views/Auth/Register.vue";
import ResetPassword from "@/views/Auth/ResetPassword.vue";
import Welcome from "@/views/Auth/Welcome.vue";
import AboutUs from "@/views/Main/AboutUs/AboutUs.vue";
import Home from "@/views/Main/Home/Home.vue";
import MyGraphics from "@/views/Main/MyGraphics/MyGraphics.vue";
import Data from "@/views/Main/Data/Data.vue";
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
    path: "/resetPassword",
    name: "ResetPassword",
    component: ResetPassword,
    meta: {
      layout: "AuthLayout",
      requiresAuth: false,
      bg: "bg-reset-password-img",
    },
  },
  {
    path: "/",
    name: "Welcome",
    component: Welcome,
    meta: {
      layout: "WelcomeLayout",
      requiresAuth: false,
      bg: "bg-welcome-img",
    },
  },
  {
    path: "/home",
    name: "Home",
    component: Home,
    meta: { layout: "MainLayout", requiresAuth: false },
  },
  {
    path: "/data",
    name: "Data",
    component: Data,
    meta: { layout: "MainLayout", requiresAuth: false },
  },
  {
    path: "/aboutUs",
    name: "AboutUs",
    component: AboutUs,
    meta: { layout: "MainLayout", requiresAuth: false },
  },
  {
    path: "/myGraphics",
    name: "MyGraphics",
    component: MyGraphics,
    meta: { layout: "MainLayout", requiresAuth: false },
  },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
