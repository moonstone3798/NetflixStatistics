<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { addDirector, editDirector } from "@/services/DirectorsService";
import { onMounted, ref } from "vue";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();

const props = defineProps({
  showEditCreateModal: {
    type: Boolean,
    default: false,
  },
  director: { type: Object, default: null, required: false },
});
const directorName = ref("");
const directorNameError = ref(null);
const emit = defineEmits(["editDirector", "close", "addDirector"]);
const createDirector = async () => {
  const response = await addDirector({ nombre: directorName.value });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Director creado correctamente",
      icon: "success",
    });
    emit("close");
    emit("addDirector", {
      id_director: response.data.id_insertado,
      nombre: directorName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al crear el director",
      icon: "error",
    });
    emit("close");
  }
};
const updateDirector = async () => {
  const response = await editDirector({
    id: props.director.id_director,
    nombre: directorName.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Director actualizado correctamente",
      icon: "success",
    });
    emit("close");
    emit("editDirector", {
      id_director: props.director.id_director,
      nombre: directorName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al actualizar el director",
      icon: "error",
    });
    emit("close");
  }
};
const validateName = () => {
  directorNameError.value = null;
  if (directorName.value.length === 0) {
    directorNameError.value = "El nombre del director es obligatorio";
    return false;
  }
  return true;
};
const saveDirector = async () => {
  if (validateName()) {
    props.director ? updateDirector() : createDirector();
  }
};

onMounted(() => {
  if (props.director) {
    directorName.value = props.director.nombre;
  } else {
    directorName.value = "";
  }
});
</script>
<template>
  <Modal
    v-if="showEditCreateModal"
    :title="props.director ? 'Editar Director' : 'Crear Director'"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveDirector()"
  >
    <div class="mb-4">
      <input
        v-model="directorName"
        placeholder="Nombre del director"
        id="directorName"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="directorNameError" class="text-netflix-red text-sm mt-1">
        {{ directorNameError }}
      </p>
    </div>
  </Modal>
</template>
