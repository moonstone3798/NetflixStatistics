<script setup>
import { reactive } from "vue";
import { useRouter } from "vue-router";
import { useUser } from "@/composables/useUser";
import Card from "@/components/Generic/Card/Card.vue";
const { passwordValidations, emailValidations } = useUser();
const router = useRouter();
const form = reactive({
  email: null,
  password: null,
});
const errors = reactive({
  email: null,
  password: null,
});

const validateData = () => {
  errors.email = null;
  errors.password = null;
  errors.password = passwordValidations.find((v) =>
    v.condition(form.password)
  )?.message;
  errors.email = emailValidations.find((v) => v.condition(form.email))?.message;
  if (errors.email || errors.password) {
    return true;
  }
};
const handleLogin = () => {
  if (validateData()) {
    return;
  }
  router.push({
    name: "Home",
    params: {
      email: form.email,
      password: form.password,
      isAdmin: form.isAdmin,
    },
  });
};
</script>
<template>
  <Card title="Iniciar Sesión">
    <template #content>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <input
            v-model="form.email"
            placeholder="Email"
            id="email"
            required
            class="input-netflix input-netflix:focus"
          />
          <p v-if="errors.email" class="text-netflix-red text-sm mt-1">
            {{ errors.email }}
          </p>
        </div>
        <div class="mb-4">
          <input
            v-model="form.password"
            type="password"
            placeholder="Contraseña"
            id="password"
            required
            class="input-netflix input-netflix:focus"
          />
          <p v-if="errors.password" class="text-netflix-red text-sm mt-1">
            {{ errors.password }}
          </p>
        </div>
        <button
          @click="handleLogin"
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
      <div class="flex items-center gap-x-1 mt-20 text-white">
        <p class="font-normal">¿Nuevo?</p>
        <router-link to="/register" class="hover:underline font-medium"
          >Crear una cuenta.</router-link
        >
      </div></template
    ></Card
  >
</template>
