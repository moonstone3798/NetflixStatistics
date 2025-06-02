<script setup>
import { reactive } from "vue";

const form = reactive({
  email: "",
  password: "",
});

const handleLogin = () => {
  console.log("Logging in with:", form);
};
</script>
<template>
  <div class="flex flex-col items-center justify-center min-h-screen">
    <div
      class="w-full md:max-w-md max-w-80 flex justify-center md:px-16 px-4 md:py-12 py-6 bg-netflix-blackWithOpacity rounded-[4px] shadow-md"
    >
      <div class="md:max-w-80 max-w-60 w-full">
        <h1 class="text-2xl text-white font-medium leading-10 mb-6">
          Iniciar Sesión
        </h1>
        <form @submit.prevent="handleLogin">
          <div class="mb-4">
            <input
              v-model="email"
              type="email"
              id="email"
              required
              class="mt-1 block w-full px-3 py-2 border-none rounded-md shadow-sm bg-netflix-blackWithOpacity focus:border focus:outline-none focus:ring-white focus:border-white text-white focus:bg-netflix-blackWithOpacity"
            />
          </div>
          <div class="mb-4">
            <input
              v-model="password"
              type="password"
              id="password"
              required
              class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-white focus:border-white"
            />
          </div>
          <button
            type="submit"
            class="w-full py-2 px-4 bg-netflix-red text-white font-semibold rounded-md hover:bg-netflix-redHover focus:bg-netflix-redDark transition duration-150 ease-in-out"
          >
            Ingresar
          </button>
        </form>
        <router-link to="/reset-password" class="text-white hover:underline">
          <p class="mt-4 text-center text-sm text-white">
            ¿Olvidaste tu Contraseña?
          </p>
        </router-link>
        <div class="flex items-center gap-x-3 mt-20">
          <input type="checkbox" id="rememberMe" class="" />
          <label for="rememberMe" class="text-white">Recordarme</label>
        </div>
        <div class="flex items-center gap-x-1 mt-4 text-white">
          <p class="font-normal">¿Nuevo?</p>
          <router-link to="/register" class="hover:underline font-medium"
            >Crear una cuenta.</router-link
          >
        </div>
      </div>
    </div>
  </div>
</template>
