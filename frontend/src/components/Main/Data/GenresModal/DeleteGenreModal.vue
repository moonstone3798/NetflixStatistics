<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { deleteGenre } from "@/services/GenresService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showDeleteModal: {
    type: Boolean,
    default: false,
  },
  genre: { type: Object, default: null, required: false },
});

const emit = defineEmits(["deleteGenre", "close"]);

const saveDeleteGenre = async () => {
  const response = await deleteGenre({ id: props.genre.id_genero });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Reparto eliminado correctamente",
      icon: "success",
    });
    emit("close");
    emit("deleteGenre", {
      id_genero: props.genre.id_genero,
      nombre: props.genre.nombre,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al eliminar el género",
      icon: "error",
    });
    emit("close");
  }
};
</script>
<template>
  <Modal
    v-if="showDeleteModal"
    title="Eliminar género"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDeleteGenre()"
  >
    <div class="mb-4">
      <p class="text-white">
        ¿Estás seguro de que deseas eliminar este género
        {{ props.genre.nombre }}?
      </p>
    </div>
  </Modal>
</template>
