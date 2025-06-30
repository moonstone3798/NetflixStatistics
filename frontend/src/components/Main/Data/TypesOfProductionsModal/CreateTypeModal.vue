<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import {
  addProductionType,
  editProductionType,
} from "@/services/ProductionTypeService";
import { onMounted, ref } from "vue";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const props = defineProps({
  showEditCreateModal: {
    type: Boolean,
    default: false,
  },
  type: { type: Object, default: null, required: false },
});
const typeName = ref("");
const typeNameError = ref(null);
const emit = defineEmits(["editType", "close", "addType"]);
const createType = async () => {
  const response = await addProductionType({ nombre: typeName.value });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Tipo de producción creado correctamente",
      icon: "success",
    });
    emit("close");
    emit("addType", {
      id_tipo_produccion: response.data.id_insertado,
      nombre: typeName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al crear el tipo de producción",
      icon: "error",
    });
    emit("close");
  }
};
const updateType = async () => {
  const response = await editProductionType({
    id: props.type.id_tipo_produccion,
    nombre: typeName.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Tipo de producción actualizado correctamente",
      icon: "success",
    });
    emit("close");
    emit("editType", {
      id_tipo_produccion: props.type.id_tipo_produccion,
      nombre: typeName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al actualizar el tipo de producción",
      icon: "error",
    });
    emit("close");
  }
};
const validateName = () => {
  typeNameError.value = null;
  if (typeName.value.length === 0) {
    typeNameError.value = "El nombre del tipo de producción es obligatorio";
    return false;
  }
  return true;
};
const saveType = async () => {
  if (validateName()) {
    props.type ? updateType() : createType();
  }
};

onMounted(() => {
  if (props.type) {
    typeName.value = props.type.nombre;
  } else {
    typeName.value = "";
  }
});
</script>
<template>
  <Modal
    v-if="showEditCreateModal"
    :title="
      props.type ? 'Editar Tipo de producción' : 'Crear Tipo de producción'
    "
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveType()"
  >
    <div class="mb-4">
      <input
        v-model="typeName"
        placeholder="Nombre del tipo de producción"
        id="typeName"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="typeNameError" class="text-netflix-red text-sm mt-1">
        {{ typeNameError }}
      </p>
    </div>
  </Modal>
</template>
