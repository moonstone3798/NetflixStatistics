<script setup>
import Card from "@/components/Generic/Card/Card.vue";
import { ref } from "vue";
import { useUser } from "@/composables/useUser";
const { emailValidations } = useUser();
const email = ref(null);
const emailError = ref(null);
const validateEmail = () => {
  emailError.value = null;
  emailError.value = emailValidations.find((v) =>
    v.condition(email.value)
  )?.message;
};
</script>
<template>
  <Card title="Actualizar la contraseña">
    <template #content>
      <p class="text-white font-normal leading-10 text-xl mb-9">
        Te enviaremos un email con instruciones para recuperar tu contraseña
      </p>
      <div class="mb-4">
        <input
          v-model="email"
          placeholder="Email"
          id="email"
          required
          class="input-netflix input-netflix:focus"
        />
        <p v-if="emailError" class="text-netflix-red text-sm mt-1">
          {{ emailError }}
        </p>
      </div>
      <button class="button-netflix"></button
    ></template>
  </Card>
</template>
