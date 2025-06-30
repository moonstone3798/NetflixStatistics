<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { deleteProductionType } from "@/services/ProductionTypeService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showDeleteModal: {
    type: Boolean,
    default: false,
  },
  type: { type: Object, default: null, required: false },
});

const emit = defineEmits(["deleteType", "close"]);

const saveDeleteType = async () => {
  const response = await deleteProductionType({
    id: props.type.id_tipo_produccion,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Tipo de producción eliminado correctamente",
      icon: "success",
    });
    emit("close");
    emit("deleteType", {
      id_tipo_produccion: props.type.id_tipo_produccion,
      nombre: props.type.nombre,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al eliminar el tipo de producción",
      icon: "error",
    });
    emit("close");
  }
};
</script>
<template>
  <Modal
    v-if="showDeleteModal"
    title="Eliminar tipo de producción"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDeleteType()"
  >
    <div class="mb-4">
      <p class="text-white">
        ¿Estás seguro de que deseas eliminar este tipo de producción
        {{ props.type.nombre }}?
      </p>
    </div>
  </Modal>
</template>
