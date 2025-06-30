<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { deleteProduction } from "@/services/ProductionsService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showDeleteModal: {
    type: Boolean,
    default: false,
  },
  production: { type: Object, default: null, required: false },
});

const emit = defineEmits(["deleteProduction", "close"]);

const saveDeleteProduction = async () => {
  const response = await deleteProduction({
    id: props.production.id_produccion,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Producción eliminada correctamente",
      icon: "success",
    });
    emit("close");
    emit("deleteProduction", {
      id_produccion: props.production.id_produccion,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al eliminar la producción",
      icon: "error",
    });
    emit("close");
  }
};
</script>
<template>
  <Modal
    v-if="showDeleteModal"
    title="Eliminar producción"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDeleteProduction()"
  >
    <div class="mb-4">
      <p class="text-white">
        ¿Estás seguro de que deseas eliminar esta producción
        {{ props.production.titulo }}?
      </p>
    </div>
  </Modal>
</template>
