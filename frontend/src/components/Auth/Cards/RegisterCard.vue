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
        <button @click="handleLogin" class="button-netflix">Crear</button>
      </form>
    </template></Card
  >
</template>
