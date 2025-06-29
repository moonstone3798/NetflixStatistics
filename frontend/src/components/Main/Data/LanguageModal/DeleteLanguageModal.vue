<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { deleteLanguage } from "@/services/LanguagesService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showDeleteModal: {
    type: Boolean,
    default: false,
  },
  language: { type: Object, default: null, required: false },
});

const emit = defineEmits(["deleteLanguage", "close"]);

const saveDeleteLanguage = async () => {
  const response = await deleteLanguage({ id: props.language.id_idioma });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Reparto eliminado correctamente",
      icon: "success",
    });
    emit("close");
    emit("deleteLanguage", {
      id_idioma: props.language.id_idioma,
      idioma: props.language.idioma,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al eliminar el idioma",
      icon: "error",
    });
    emit("close");
  }
};
</script>
<template>
  <Modal
    v-if="showDeleteModal"
    title="Eliminar idioma"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDeleteLanguage()"
  >
    <div class="mb-4">
      <p class="text-white">
        ¿Estás seguro de que deseas eliminar este idioma
        {{ props.language.idioma }}?
      </p>
    </div>
  </Modal>
</template>
