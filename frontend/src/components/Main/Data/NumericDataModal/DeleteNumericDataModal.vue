<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { deleteNumericData } from "@/services/NumericDataService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showDeleteModal: {
    type: Boolean,
    default: false,
  },
  ndata: { type: Object, default: null, required: false },
});

const emit = defineEmits(["deleteNumericData", "close"]);

const saveDeleteData = async () => {
  const response = await deleteNumericData({ id: props.ndata.id_dato_extra });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Dato numérico eliminado correctamente",
      icon: "success",
    });
    emit("close");
    emit("deleteNumericData", {
      id_dato_extra: props.ndata.id_dato_extra,
      popularidad: props.ndata.popularidad,
      votos: props.ndata.votos,
      rating: props.ndata.rating,
      promedio_votos: props.ndata.promedio_votos,
      presupuesto: props.ndata.presupuesto,
      ganancia: props.ndata.ganancia,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al eliminar el dato numérico",
      icon: "error",
    });
    emit("close");
  }
};
</script>
<template>
  <Modal
    v-if="showDeleteModal"
    title="Eliminar dato numérico"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDeleteData()"
  >
    <div class="mb-4">
      <p class="text-white">
        ¿Estás seguro de que deseas eliminar este dato numérico
        {{ props.ndata.id_dato_extra }}?
      </p>
    </div>
  </Modal>
</template>
