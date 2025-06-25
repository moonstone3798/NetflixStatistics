<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { ref } from "vue";
const showModal = ref(false);
const handleShowModal = () => {
  showModal.value = !showModal.value;
};
const form = ref({
  castName: "",
  castNameError: null,
});
</script>
<template>
  <button class="button-netflix max-w-40" @click="handleShowModal()">
    Crear reparto
  </button>
  <Modal
    v-if="showModal"
    title="Crear Reparto"
    @close="handleShowModal()"
    buttonText="confirmar"
    @submit="handleShowModal()"
  >
    <div class="mb-4">
      <input
        v-model="form.castName"
        placeholder="Nombre del reparto"
        id="castName"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="form.castNameError" class="text-netflix-red text-sm mt-1">
        {{ form.castNameError }}
      </p>
    </div>
  </Modal>
</template>
