<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { addLanguage, editLanguage } from "@/services/LanguagesService";
import { onMounted, ref } from "vue";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();

const props = defineProps({
  showEditCreateModal: {
    type: Boolean,
    default: false,
  },
  language: { type: Object, default: null, required: false },
});
const languageName = ref("");
const languageNameError = ref(null);
const emit = defineEmits(["editLanguage", "close", "addLanguage"]);
const createLanguage = async () => {
  const response = await addLanguage({ idioma: languageName.value });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Idioma creado correctamente",
      icon: "success",
    });
    emit("close");
    emit("addLanguage", {
      id_idioma: response.data.id_insertado,
      idioma: languageName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al crear el idioma",
      icon: "error",
    });
    emit("close");
  }
};
const updateLanguage = async () => {
  const response = await editLanguage({
    id: props.language.id_idioma,
    idioma: languageName.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Idioma actualizado correctamente",
      icon: "success",
    });
    emit("close");
    emit("editLanguage", {
      id_idioma: props.language.id_idioma,
      idioma: languageName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al actualizar el idioma",
      icon: "error",
    });
    emit("close");
  }
};
const validateName = () => {
  languageNameError.value = null;
  if (languageName.value.length === 0) {
    languageNameError.value = "El nombre del idioma es obligatorio";
    return false;
  }
  return true;
};
const saveLanguage = async () => {
  if (validateName()) {
    props.language ? updateLanguage() : createLanguage();
  }
};

onMounted(() => {
  if (props.language) {
    languageName.value = props.language.idioma;
  } else {
    languageName.value = "";
  }
});
</script>
<template>
  <Modal
    v-if="showEditCreateModal"
    :title="props.language ? 'Editar Idioma' : 'Crear Idioma'"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveLanguage()"
  >
    <div class="mb-4">
      <input
        v-model="languageName"
        placeholder="Nombre del idioma"
        id="languageName"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="languageNameError" class="text-netflix-red text-sm mt-1">
        {{ languageNameError }}
      </p>
    </div>
  </Modal>
</template>
