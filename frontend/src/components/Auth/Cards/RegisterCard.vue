<script setup>
import { reactive } from "vue";
import { useRouter } from "vue-router";
import { useUser } from "@/composables/useUser";
import Card from "@/components/Generic/Card/Card.vue";
import { register } from "@/services/UserService";
import Swal from "sweetalert2";
const {
  passwordValidations,
  emailValidations,
  repeatPasswordValidations,
  nameValidations,
  lastNameValidations,
} = useUser();
const router = useRouter();
const form = reactive({
  email: null,
  password: null,
  name: null,
  lastName: null,
  repeatPassword: null,
  isAdmin: false,
});
const errors = reactive({
  email: null,
  password: null,
  name: null,
  lastName: null,
  repeatPassword: null,
});
const formFields = [
  {
    id: "name",
    placeholder: "Nombre",
    type: "text",
  },
  { id: "lastName", placeholder: "Apellido", type: "text" },
  {
    id: "email",
    placeholder: "Email",
    type: "email",
  },
  {
    id: "password",
    placeholder: "Contraseña",
    type: "password",
  },
  {
    id: "repeatPassword",
    placeholder: "Repetir Contraseña",
    type: "password",
  },
];
const validateData = () => {
  errors.email = null;
  errors.password = null;
  errors.name = null;
  errors.lastName = null;
  errors.repeatPassword = null;
  errors.password = passwordValidations.find((v) =>
    v.condition(form.password)
  )?.message;
  errors.email = emailValidations.find((v) => v.condition(form.email))?.message;
  errors.repeatPassword = repeatPasswordValidations.find((v) =>
    v.condition(form.password, form.repeatPassword)
  )?.message;
  errors.name = nameValidations.find((v) => v.condition(form.name))?.message;
  errors.lastName = lastNameValidations.find((v) =>
    v.condition(form.lastName)
  )?.message;
  if (
    errors.email ||
    errors.password ||
    errors.repeatPassword ||
    errors.name ||
    errors.lastName
  ) {
    return true;
  }
  return false;
};
const handleLogin = async () => {
  if (validateData()) {
    return;
  }
  const response = await register({
    name: form.name,
    lastName: form.lastName,
    email: form.email,
    password: form.password,
    isAdmin: form.isAdmin === true ? 1 : 0,
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
      localStorage.setItem(
        "userInfo",
        JSON.stringify({
          nombre: form.name,
          apellido: form.lastName,
          email: form.email,
          password: form.password,
          is_admin: form.isAdmin === true ? 1 : 0,
          id_usuario: response.data.id_usuario,
        })
      );
      router.push("/home");
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
      text: "Error en la llamada de registro",
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
  <Card title="Crear Cuenta">
    <template #content>
      <form @submit.prevent="handleLogin">
        <div class="mb-4" v-for="field in formFields" :key="field.id">
          <input
            v-model="form[field.id]"
            :placeholder="field.placeholder"
            :id="field.id"
            :type="field.type"
            required
            class="input-netflix input-netflix:focus"
          />
          <p v-if="errors[field.id]" class="text-netflix-red text-sm mt-1">
            {{ errors[field.id] }}
          </p>
        </div>
        <div class="flex items-center gap-x-2 mb-4">
          <input
            type="checkbox"
            name="isAdmin"
            id="isAdmin"
            class="bg-netflix-blackWithOpacity appearance-none checked:appearance-auto border-2 rounded-[4px] w-4 h-4 border-netflix-gray200 checked:accent-white checked:bg-netflix-gray"
            v-model="form.isAdmin"
          />
          <label for="isAdmin" class="text-netflix-gray100"
            >Registrarse Como Administrador</label
          >
        </div>
        <button type="submit" class="button-netflix">Crear</button>
        <div class="flex items-center gap-x-1 mt-4 text-white">
          <p class="font-normal">¿Tenes una cuenta?</p>
          <router-link to="/login" class="hover:underline font-medium"
            >Inicia sesión</router-link
          >
        </div>
      </form>
    </template></Card
  >
</template>
