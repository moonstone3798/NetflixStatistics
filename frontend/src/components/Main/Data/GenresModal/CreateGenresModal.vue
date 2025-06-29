<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { addGenre, editGenre } from "@/services/GenresService";
import { onMounted, ref } from "vue";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();

const props = defineProps({
  showEditCreateModal: {
    type: Boolean,
    default: false,
  },
  genre: { type: Object, default: null, required: false },
});
const genreName = ref("");
const genreNameError = ref(null);
const emit = defineEmits(["editGenre", "close", "addGenre"]);
const createGenre = async () => {
  const response = await addGenre({ nombre: genreName.value });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Género creado correctamente",
      icon: "success",
    });
    emit("close");
    emit("addGenre", {
      id_genero: response.data.id_insertado,
      nombre: genreName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al crear el género",
      icon: "error",
    });
    emit("close");
  }
};
const updateGenre = async () => {
  const response = await editGenre({
    id: props.genre.id_genero,
    nombre: genreName.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Género actualizado correctamente",
      icon: "success",
    });
    emit("close");
    emit("editGenre", {
      id_genero: props.genre.id_genero,
      nombre: genreName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al actualizar el género",
      icon: "error",
    });
    emit("close");
  }
};
const validateName = () => {
  genreNameError.value = null;
  if (genreName.value.length === 0) {
    genreNameError.value = "El nombre del género es obligatorio";
    return false;
  }
  return true;
};
const saveGenre = async () => {
  if (validateName()) {
    props.genre ? updateGenre() : createGenre();
  }
};

onMounted(() => {
  if (props.genre) {
    genreName.value = props.genre.nombre;
  } else {
    genreName.value = "";
  }
});
</script>
<template>
  <Modal
    v-if="showEditCreateModal"
    :title="props.genre ? 'Editar Género' : 'Crear Género'"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveGenre()"
  >
    <div class="mb-4">
      <input
        v-model="genreName"
        placeholder="Nombre del género"
        id="genreName"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="genreNameError" class="text-netflix-red text-sm mt-1">
        {{ genreNameError }}
      </p>
    </div>
  </Modal>
</template>
