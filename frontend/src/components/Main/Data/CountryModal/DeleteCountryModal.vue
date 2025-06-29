<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { deleteCountry } from "@/services/CountriesService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showDeleteModal: {
    type: Boolean,
    default: false,
  },
  country: { type: Object, default: null, required: false },
});

const emit = defineEmits(["deleteCountry", "close"]);

const saveDeleteCountry = async () => {
  const response = await deleteCountry({ id: props.country.id_pais });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "País eliminado correctamente",
      icon: "success",
    });
    emit("close");
    emit("deleteCountry", {
      id_pais: props.country.id_pais,
      nombre: props.country.nombre,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al eliminar el país",
      icon: "error",
    });
    emit("close");
  }
};
</script>
<template>
  <Modal
    v-if="showDeleteModal"
    title="Eliminar país"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDeleteCountry()"
  >
    <div class="mb-4">
      <p class="text-white">
        ¿Estás seguro de que deseas eliminar este país
        {{ props.country.nombre }}?
      </p>
    </div>
  </Modal>
</template>
