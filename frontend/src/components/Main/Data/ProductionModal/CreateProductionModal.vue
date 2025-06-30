<script setup>
import Modal from "@/components/Generic/Modal/Modal.vue";
import { addProduction, editProduction } from "@/services/ProductionsService";
import { getProductionTypes } from "@/services/ProductionTypeService";
import { onMounted, ref } from "vue";
import { useMessage } from "@/composables/useMessage";
import { getNumericData } from "@/services/NumericDataService";
import { getLanguages } from "@/services/LanguagesService";
const { showAlert } = useMessage();

const props = defineProps({
  showEditCreateModal: {
    type: Boolean,
    default: false,
  },
  production: { type: Object, default: null, required: false },
});
const tiposProduccion = ref([]);
const Languages = ref([]);
const datosExtras = ref([]);
const tipo_produccion = ref(null);
const id_datos_extras = ref(null);
const titulo = ref("");
const fecha_ingreso = ref("");
const anio_realizacion = ref("");
const duracion = ref("");
const descripcion = ref("");
const id_idioma = ref(null);
const idIdiomasError = ref(null);
const tipoProduccionError = ref(null);
const tituloError = ref(null);
const fechaIngresoError = ref(null);
const anioRealizacionError = ref(null);
const duracionError = ref(null);
const descripcionError = ref(null);
const idDatosExtrasError = ref(null);
const emit = defineEmits(["editProduction", "close", "addProduction"]);
const createProduction = async () => {
  const response = await addProduction({
    tipo_produccion: tipo_produccion.value,
    titulo: titulo.value,
    fecha_ingreso: fecha_ingreso.value,
    anio_realizacion: anio_realizacion.value,
    duracion: duracion.value,
    descripcion: descripcion.value,
    id_datos_extras: id_datos_extras.value,
    id_idioma: id_idioma.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "producción creada correctamente",
      icon: "success",
    });
    emit("close");
    emit("addProduction", {
      id_produccion: response.data.id_insertado,
      tipo_produccion: tiposProduccion.value.find(
        (tipo) => tipo.id_tipo_produccion === tipo_produccion.value
      )?.nombre,
      titulo: titulo.value,
      fecha_ingreso: fecha_ingreso.value,
      anio_realizacion: anio_realizacion.value,
      duracion: duracion.value,
      descripcion: descripcion.value,
      popularidad: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.popularidad,
      votos: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.votos,
      rating: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.rating,
      promedio_votos: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.promedio_votos,
      presupuesto: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.presupuesto,
      ganancia: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.ganancia,
      id_datos_extras: id_datos_extras.value,
      id_idioma: id_idioma.value,
      id_tipo_produccion: tipo_produccion.value,
      idioma: Languages.value.find(
        (language) => language.id_idioma === id_idioma.value
      )?.idioma,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: response.data,
      icon: "error",
    });
    emit("close");
  }
};
const updateProduction = async () => {
  const response = await editProduction({
    id: props.production.id_produccion,
    id_tipo_produccion: tipo_produccion.value,
    titulo: titulo.value,
    fecha_ingreso: fecha_ingreso.value,
    anio_realizacion: anio_realizacion.value,
    duracion: duracion.value,
    descripcion: descripcion.value,
    id_datos_extras: id_datos_extras.value,
    id_idioma: id_idioma.value,
  });
  if (response.status === "success") {
    showAlert({
      title: "¡Éxito!",
      text: "producción actualizada correctamente",
      icon: "success",
    });
    emit("close");
    emit("editProduction", {
      id_produccion: props.production.id_produccion,
      tipo_produccion: tiposProduccion.value.find(
        (tipo) => tipo.id_tipo_produccion === tipo_produccion.value
      )?.nombre,
      titulo: titulo.value,
      fecha_ingreso: fecha_ingreso.value,
      anio_realizacion: anio_realizacion.value,
      duracion: duracion.value,
      descripcion: descripcion.value,
      popularidad: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.popularidad,
      votos: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.votos,
      rating: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.rating,
      promedio_votos: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.promedio_votos,
      presupuesto: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.presupuesto,
      ganancia: datosExtras.value.find(
        (dato) => dato.id_dato_extra === id_datos_extras.value
      )?.ganancia,
      id_datos_extras: id_datos_extras.value,
      id_idioma: id_idioma.value,
      id_tipo_produccion: tipo_produccion.value,
      idioma: Languages.value.find(
        (language) => language.id_idioma === id_idioma.value
      )?.idioma,
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al actualizar la producción",
      icon: "error",
    });
    emit("close");
  }
};
const validateErrors = () => {
  tipoProduccionError.value = null;
  tituloError.value = null;
  fechaIngresoError.value = null;
  anioRealizacionError.value = null;
  duracionError.value = null;
  descripcionError.value = null;

  if (tipo_produccion.value.length === 0) {
    tipoProduccionError.value = "El tipo de producción es obligatorio";
    return false;
  }
  if (titulo.value.length === 0) {
    tituloError.value = "El título es obligatorio";
    return false;
  }
  if (fecha_ingreso.value.length === 0) {
    fechaIngresoError.value = "La fecha de ingreso es obligatoria";
    return false;
  }
  if (anio_realizacion.value.length === 0) {
    anioRealizacionError.value = "El año de realización es obligatorio";
    return false;
  }
  if (duracion.value.length === 0) {
    duracionError.value = "La duración es obligatoria";
    return false;
  }
  if (descripcion.value.length === 0) {
    descripcionError.value = "La descripción es obligatoria";
    return false;
  }
  return true;
};
const saveProduction = async () => {
  if (validateErrors()) {
    props.production ? updateProduction() : createProduction();
  }
};

onMounted(async () => {
  const response = await getProductionTypes();
  if (response.status === "success") {
    tiposProduccion.value = response.data;
  }
  const response2 = await getNumericData();
  if (response2.status === "success") {
    datosExtras.value = response2.data;
  }
  const response3 = await getLanguages();
  if (response3.status === "success") {
    Languages.value = response3.data;
  }
  if (props.production) {
    tipo_produccion.value = tiposProduccion.value.find(
      (tipo) => tipo.nombre === props.production.tipo_produccion
    )?.id_tipo_produccion;
    titulo.value = props.production.titulo;
    fecha_ingreso.value = props.production.fecha_ingreso;
    anio_realizacion.value = props.production.anio_realizacion;
    duracion.value = props.production.duracion;
    descripcion.value = props.production.descripcion;
    id_idioma.value = Languages.value.find(
      (language) => language.idioma === props.production.idioma
    )?.id_idioma;
    id_datos_extras.value = datosExtras.value.find(
      (dato) =>
        dato.popularidad === props.production.popularidad &&
        dato.votos === props.production.votos &&
        dato.rating === props.production.rating &&
        dato.promedio_votos === props.production.promedio_votos &&
        dato.presupuesto === props.production.presupuesto &&
        dato.ganancia === props.production.ganancia
    )?.id_dato_extra;
  } else {
    tipo_produccion.value = null;
    titulo.value = "";
    fecha_ingreso.value = "";
    anio_realizacion.value = "";
    duracion.value = "";
    descripcion.value = "";
    id_idioma.value = null;
    id_datos_extras.value = null;
  }
});
</script>
<template>
  <Modal
    v-if="showEditCreateModal"
    :title="props.production ? 'Editar Producción' : 'Crear Producción'"
    @close="emit('close')"
    buttonText="confirmar"
    @submit="saveProduction()"
  >
    <div class="mb-4">
      <select
        v-model="tipo_produccion"
        id="tipo_produccion"
        required
        class="input-netflix input-netflix:focus"
      >
        <option :value="null" selected>Tipo de producción</option>
        <option
          v-for="tipo in tiposProduccion"
          :key="tipo.id_tipo_produccion"
          :value="tipo.id_tipo_produccion"
        >
          {{ tipo.nombre }}
        </option>
      </select>
      <p v-if="tipoProduccionError" class="text-netflix-red text-sm mt-1">
        {{ tipoProduccionError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="titulo"
        placeholder="Título"
        id="titulo"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="tituloError" class="text-netflix-red text-sm mt-1">
        {{ tituloError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="fecha_ingreso"
        placeholder="Fecha de Ingreso"
        id="fecha_ingreso"
        required
        type="date"
        class="input-netflix input-netflix:focus"
      />
      <p v-if="fechaIngresoError" class="text-netflix-red text-sm mt-1">
        {{ fechaIngresoError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="anio_realizacion"
        placeholder="Año de Realización"
        id="anio_realizacion"
        type="number"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="anioRealizacionError" class="text-netflix-red text-sm mt-1">
        {{ anioRealizacionError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="duracion"
        placeholder="Duración"
        id="duracion"
        type="number"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="duracionError" class="text-netflix-red text-sm mt-1">
        {{ duracionError }}
      </p>
    </div>
    <div class="mb-4">
      <input
        v-model="descripcion"
        placeholder="Descripción"
        id="descripcion"
        required
        class="input-netflix input-netflix:focus"
      />
      <p v-if="descripcionError" class="text-netflix-red text-sm mt-1">
        {{ descripcionError }}
      </p>
    </div>
    <div class="mb-4">
      <select
        v-model="id_datos_extras"
        id="id_datos_extras"
        required
        class="input-netflix input-netflix:focus"
      >
        <option :value="null" selected>Datos numéricos</option>
        <option
          v-for="dato in datosExtras"
          :key="dato.id_dato_extra"
          :value="dato.id_dato_extra"
        >
          Popularidad: {{ dato.popularidad }} - Votos:{{ dato.votos }} -
          Raiting: {{ dato.rating }} - Promedio de votos
          {{ dato.promedio_votos }} - Presupuesto: {{ dato.presupuesto }} -
          Ganancia: {{ dato.ganancia }}
        </option>
      </select>
      <p v-if="idDatosExtrasError" class="text-netflix-red text-sm mt-1">
        {{ idDatosExtrasError }}
      </p>
    </div>
    <div class="mb-4">
      <select
        v-model="id_idioma"
        id="id_idioma"
        required
        class="input-netflix input-netflix:focus"
      >
        <option :value="null" selected>Idiomas</option>
        <option
          v-for="language in Languages"
          :key="language.id_idioma"
          :value="language.id_idioma"
        >
          {{ language.idioma }}
        </option>
      </select>
      <p v-if="idIdiomasError" class="text-netflix-red text-sm mt-1">
        {{ idIdiomasError }}
      </p>
    </div>
  </Modal>
</template>
