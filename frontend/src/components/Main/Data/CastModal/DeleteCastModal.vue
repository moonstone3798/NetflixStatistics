<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { deleteCast } from "@/services/CastService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showDeleteModal: {
    type: Boolean,
    default: false,
  },
  cast: { type: Object, default: null, required: false },
});

const emit = defineEmits(["deleteCast", "close"]);

const saveDeleteCast = async () => {
  const response = await deleteCast({ id: props.cast.id_reparto });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Reparto eliminado correctamente",
      icon: "success",
    });
    emit("close");
    emit("deleteCast", {
      id_reparto: props.cast.id_reparto,
      nombre: props.cast.nombre,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al eliminar el reparto",
      icon: "error",
    });
    emit("close");
  }
};
</script>
<template>
  <Modal
    v-if="showDeleteModal"
    title="Eliminar reparto"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDeleteCast()"
  >
    <div class="mb-4">
      <p class="text-white">
        ¿Estás seguro de que deseas eliminar este reparto
        {{ props.cast.nombre }}?
      </p>
    </div>
  </Modal>
</template>
