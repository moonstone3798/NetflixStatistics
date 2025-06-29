<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { addCast, editCast } from "@/services/CastService";
import { onMounted, ref } from "vue";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();

const props = defineProps({
  showEditCreateModal: {
    type: Boolean,
    default: false,
  },
  cast: { type: Object, default: null, required: false },
});
const castName = ref("");
const castNameError = ref(null);
const emit = defineEmits(["editCast", "close", "addCast"]);
const createCast = async () => {
  const response = await addCast({ nombre: castName.value });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Reparto creado correctamente",
      icon: "success",
    });
    emit("close");
    emit("addCast", {
      id_reparto: response.data.id_insertado,
      nombre: castName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al crear el reparto",
      icon: "error",
    });
    emit("close");
  }
};
const updateCast = async () => {
  const response = await editCast({
    id: props.cast.id_reparto,
    nombre: castName.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Reparto actualizado correctamente",
      icon: "success",
    });
    emit("close");
    emit("editCast", {
      id_reparto: props.cast.id_reparto,
      nombre: castName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al actualizar el reparto",
      icon: "error",
    });
    emit("close");
  }
};
const validateName = () => {
  castNameError.value = null;
  if (castName.value.length === 0) {
    castNameError.value = "El nombre del reparto es obligatorio";
    return false;
  }
  return true;
};
const saveCast = async () => {
  if (validateName()) {
    props.cast ? updateCast() : createCast();
  }
};

onMounted(() => {
  if (props.cast) {
    castName.value = props.cast.nombre;
  } else {
    castName.value = "";
  }
});
</script>
<template>
  <Modal
    v-if="showEditCreateModal"
    :title="props.cast ? 'Editar Reparto' : 'Crear Reparto'"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveCast()"
  >
    <div class="mb-4">
      <input
        v-model="castName"
        placeholder="Nombre del reparto"
        id="castName"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="castNameError" class="text-netflix-red text-sm mt-1">
        {{ castNameError }}
      </p>
    </div>
  </Modal>
</template>
