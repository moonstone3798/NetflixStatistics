<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { addNumericData, editNumericData } from "@/services/NumericDataService";
import { onMounted, ref } from "vue";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();

const props = defineProps({
  showEditCreateModal: {
    type: Boolean,
    default: false,
  },
  ndata: { type: Object, default: null, required: false },
});
const popularidad = ref("");
const votos = ref("");
const rating = ref("");
const promedio_votos = ref("");
const presupuesto = ref("");
const ganancia = ref("");
const popularidadError = ref(null);
const votosError = ref(null);
const ratingError = ref(null);
const promedioVotosError = ref(null);
const presupuestoError = ref(null);
const gananciaError = ref(null);
const emit = defineEmits(["editNumericData", "close", "addNumericData"]);
const createNdata = async () => {
  const response = await addNumericData({
    popularidad: popularidad.value,
    votos: votos.value,
    rating: rating.value,
    promedio_votos: promedio_votos.value,
    presupuesto: presupuesto.value,
    ganancia: ganancia.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Dato numérico creado correctamente",
      icon: "success",
    });
    emit("close");
    emit("addNumericData", {
      id_dato_extra: response.data.id_insertado,
      popularidad: popularidad.value,
      votos: votos.value,
      rating: rating.value,
      promedio_votos: promedio_votos.value,
      presupuesto: presupuesto.value,
      ganancia: ganancia.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al crear el dato numérico",
      icon: "error",
    });
    emit("close");
  }
};
const updateNdata = async () => {
  const response = await editNumericData({
    id: props.ndata.id_dato_extra,
    popularidad: popularidad.value,
    votos: votos.value,
    rating: rating.value,
    promedio_votos: promedio_votos.value,
    presupuesto: presupuesto.value,
    ganancia: ganancia.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "Dato numérico actualizado correctamente",
      icon: "success",
    });
    emit("close");
    emit("editNumericData", {
      id_dato_extra: props.ndata.id_dato_extra,
      popularidad: popularidad.value,
      votos: votos.value,
      rating: rating.value,
      promedio_votos: promedio_votos.value,
      presupuesto: presupuesto.value,
      ganancia: ganancia.value,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al actualizar el dato numérico",
      icon: "error",
    });
    emit("close");
  }
};
const validateErrors = () => {
  popularidadError.value = null;
  votosError.value = null;
  ratingError.value = null;
  promedioVotosError.value = null;
  presupuestoError.value = null;
  gananciaError.value = null;

  if (popularidad.value.length === 0) {
    popularidadError.value = "La popularidad es obligatoria";
    return false;
  }
  if (votos.value.length === 0) {
    votosError.value = "Los votos son obligatorios";
    return false;
  }
  if (rating.value.length === 0) {
    ratingError.value = "El rating es obligatorio";
    return false;
  }
  if (promedio_votos.value.length === 0) {
    promedioVotosError.value = "El promedio de votos es obligatorio";
    return false;
  }
  if (presupuesto.value.length === 0) {
    presupuestoError.value = "El presupuesto es obligatorio";
    return false;
  }
  if (ganancia.value.length === 0) {
    gananciaError.value = "La ganancia es obligatoria";
    return false;
  }
  return true;
};
const saveNdata = async () => {
  if (validateErrors()) {
    props.ndata ? updateNdata() : createNdata();
  }
};

onMounted(() => {
  if (props.ndata) {
    popularidad.value = props.ndata.popularidad;
    votos.value = props.ndata.votos;
    rating.value = props.ndata.rating;
    promedio_votos.value = props.ndata.promedio_votos;
    presupuesto.value = props.ndata.presupuesto;
    ganancia.value = props.ndata.ganancia;
  } else {
    popularidad.value = "";
    votos.value = "";
    rating.value = "";
    promedio_votos.value = "";
    presupuesto.value = "";
    ganancia.value = "";
  }
});
</script>
<template>
  <Modal
    v-if="showEditCreateModal"
    :title="props.ndata ? 'Editar Dato numérico' : 'Crear Dato numérico'"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveNdata()"
  >
    <div class="mb-4">
      <input
        v-model="popularidad"
        placeholder="Popularidad"
        id="popularidad"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="popularidadError" class="text-netflix-red text-sm mt-1">
        {{ popularidadError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="votos"
        placeholder="Votos"
        id="votos"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="votosError" class="text-netflix-red text-sm mt-1">
        {{ votosError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="rating"
        placeholder="Rating"
        id="rating"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="ratingError" class="text-netflix-red text-sm mt-1">
        {{ ratingError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="promedio_votos"
        placeholder="Promedio de Votos"
        id="promedio_votos"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="promedioVotosError" class="text-netflix-red text-sm mt-1">
        {{ promedioVotosError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="presupuesto"
        placeholder="Presupuesto"
        id="presupuesto"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="presupuestoError" class="text-netflix-red text-sm mt-1">
        {{ presupuestoError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="ganancia"
        placeholder="Ganancia"
        id="ganancia"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="gananciaError" class="text-netflix-red text-sm mt-1">
        {{ gananciaError }}
      </p>
    </div>
  </Modal>
</template>
