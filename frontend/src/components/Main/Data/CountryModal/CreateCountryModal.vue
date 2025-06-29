<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { addCountry, editCountry } from "@/services/CountriesService";
import { onMounted, ref } from "vue";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();

const props = defineProps({
  showEditCreateModal: {
    type: Boolean,
    default: false,
  },
  country: { type: Object, default: null, required: false },
});
const countryName = ref("");
const countryNameError = ref(null);
const emit = defineEmits(["editCountry", "close", "addCountry"]);
const createCountry = async () => {
  const response = await addCountry({ nombre: countryName.value });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "País creado correctamente",
      icon: "success",
    });
    emit("close");
    emit("addCountry", {
      id_pais: response.data.id_insertado,
      nombre: countryName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al crear el país",
      icon: "error",
    });
    emit("close");
  }
};
const updateCountry = async () => {
  const response = await editCountry({
    id: props.country.id_pais,
    nombre: countryName.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "País actualizado correctamente",
      icon: "success",
    });
    emit("close");
    emit("editCountry", {
      id_pais: props.country.id_pais,
      nombre: countryName.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al actualizar el país",
      icon: "error",
    });
    emit("close");
  }
};
const validateName = () => {
  countryNameError.value = null;
  if (countryName.value.length === 0) {
    countryNameError.value = "El nombre del país es obligatorio";
    return false;
  }
  return true;
};
const saveCountry = async () => {
  if (validateName()) {
    props.country ? updateCountry() : createCountry();
  }
};

onMounted(() => {
  if (props.country) {
    countryName.value = props.country.nombre;
  } else {
    countryName.value = "";
  }
});
</script>
<template>
  <Modal
    v-if="showEditCreateModal"
    :title="props.country ? 'Editar País' : 'Crear País'"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveCountry()"
  >
    <div class="mb-4">
      <input
        v-model="countryName"
        placeholder="Nombre del país"
        id="countryName"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="countryNameError" class="text-netflix-red text-sm mt-1">
        {{ countryNameError }}
      </p>
    </div>
  </Modal>
</template>
