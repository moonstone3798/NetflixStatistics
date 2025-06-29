<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { deleteDirector } from "@/services/DirectorsService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showDeleteModal: {
    type: Boolean,
    default: false,
  },
  director: { type: Object, default: null, required: false },
});

const emit = defineEmits(["deletedirector", "close"]);

const saveDeletedirector = async () => {
  const response = await deleteDirector({ id: props.director.id_director });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Director eliminado correctamente",
      icon: "success",
    });
    emit("close");
    emit("deletedirector", {
      id_director: props.director.id_director,
      nombre: props.director.nombre,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al eliminar al director",
      icon: "error",
    });
    emit("close");
  }
};
</script>
<template>
  <Modal
    v-if="showDeleteModal"
    title="Eliminar director"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDeletedirector()"
  >
    <div class="mb-4">
      <p class="text-white">
        ¿Estás seguro de que deseas eliminar este director
        {{ props.director.nombre }}?
      </p>
    </div>
  </Modal>
</template>
