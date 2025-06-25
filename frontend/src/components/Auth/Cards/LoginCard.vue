<script setup>
import { reactive } from "vue";
import { useRouter } from "vue-router";
import { useUser } from "@/composables/useUser";
import Card from "@/components/Generic/Card/Card.vue";
import { login } from "@/services/UserService";
import Swal from "sweetalert2";
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
const handleLogin = async () => {
  if (validateData()) {
    return;
  }
  const response = await login({
    email: form.email,
    password: form.password,
  });
  if (response.status === "success") {
    if (response.data.status === "error") {
      Swal.fire({
        title: "¡Error!",
        text: response.data.message,
        icon: "error",
        showConfirmButton: false,
        timer: 2500,
        background: "#050505",
        color: "#f1f1f1",
        iconColor: "#E50914",
        customClass: {
          popup: "swal2-dark swal-rounded",
        },
      });
    } else {
      router.push("/home");
      localStorage.setItem("userInfo", JSON.stringify(response.data.data));
      Swal.fire({
        title: "¡Éxito!",
        text: response.data.message,
        icon: "success",
        showConfirmButton: false,
        timer: 2500,
        background: "#050505",
        color: "#f1f1f1",
        iconColor: "#0bde35",
        customClass: {
          popup: "swal2-dark swal-rounded",
        },
      });
    }
  } else {
    Swal.fire({
      title: "¡Error!",
      text: "Error en la llamada de login",
      icon: "error",
      showConfirmButton: false,
      timer: 2500,
      background: "#050505",
      color: "#f1f1f1",
      iconColor: "#E50914",
      customClass: {
        popup: "swal2-dark swal-rounded",
      },
    });
  }
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
        <button type="submit" class="button-netflix">Ingresar</button>
      </form>
      <router-link to="/resetPassword" class="text-white hover:underline">
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
