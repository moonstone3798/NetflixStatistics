<script setup>
import { ref } from "vue";
import Dropzone from "dropzone-vue3";
import { onMounted } from "vue";
import Chart from "primevue/chart";
import { getGraphicTypes } from "@/services/GraphicTypesService";
import { getQueries, processQuery } from "@/services/QueriesService";
import { addView } from "@/services/ViewService";
import { useMessage } from "@/composables/useMessage";
const { showAlert } = useMessage();
const myVueDropzone = ref(null);
const userInfo = JSON.parse(localStorage.getItem("userInfo"));
const graphics = ref([]);
const title = ref("");
const queries = ref([]);
const titleError = ref(null);
const graphicSelected = ref(null);
const querySelected = ref(null);
const dropzoneOptions = {
  url: "../",
  maxFilesize: 0.5,
  thumbnailWidth: 150,
  accept: ".csv",
  headers: {
    "My-Awesome-Header": "header value",
  },
  dictDefaultMessage: "Arrastra tu archivo CSV aquí o haz clic para subir",
};

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: "top",
    },
    title: {
      display: true,
      text: title.value,
    },
  },
});
const chartData = ref(null);
const process = async () => {
  if (querySelected.value && querySelected.value !== "null") {
    const response = await processQuery({
      query: querySelected.value.query,
    });
    if (response.status === "success") {
      chartData.value = {
        labels: response.data.labels,
        datasets: [
          {
            label: response.data.title,
            data: response.data.data,
            backgroundColor: [
              "#E50914",
              "#000000",
              "#141414",
              "#E50A14",
              "#EB3942",
              "#C11119",
              "#5C3D3D",
              "#2E1F1F",
              "#808080",
              "#BCBCBC",
              "#BDBCBB",
              "#E8D1D1",
            ],
          },
        ],
      };
    }
  }
};
const saveGraphic = async () => {
  console.log(graphicSelected.value);
  const response = await addView({
    nombre: title.value,
    id_tipo: graphicSelected.value.id_tipo,
    id_query: querySelected.value.id_query,
    id_usuario: userInfo.id_usuario,
  });
  if (response.status === "success") {
    title.value = "";
    graphicSelected.value = null;
    querySelected.value = null;
    chartData.value = null;
    titleError.value = null;
    showAlert({
      title: "¡Éxito!",
      text: "gráfico creado correctamente",
      icon: "success",
    });
  } else {
    showAlert({
      title: "¡Error!",
      text: "Error al guardar el gráfico",
      icon: "error",
    });
  }
};
onMounted(async () => {
  if (userInfo.is_admin == 0) {
    const response = await getGraphicTypes();
    if (response.status === "success") {
      graphics.value = response.data;
    }
    const response2 = await getQueries();
    if (response2.status === "success") {
      queries.value = response2.data;
    }
  }
});
</script>
<template>
  <div v-if="userInfo.is_admin == 1" class="flex flex-col w-[63%]">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-white font-bold">Agregar nuevos datos</h2>
      <a href="../../../../public/csv/plantilla.csv">
        <button class="button-netflix max-w-48">Descargar plantilla</button></a
      >
    </div>
    <Dropzone
      ref="myVueDropzone"
      :options="dropzoneOptions"
      class="dropzone w-full text-white font-bold rounded-xl border-dashed border-2 border-netflix-brown cursor-pointer bg-black p-4 hover:bg-netflix-blackWithOpacity"
    />
  </div>
  <div v-else class="w-[63%]">
    <div class="flex justify-between">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-white text-2xl font-bold">Agregar nuevo gráfico</h2>
          <input
            v-model="title"
            placeholder="Título del gráfico"
            id="title"
            required
            class="input-netflix input-netflix:focus"
          />
          <p v-if="titleError" class="text-netflix-red text-sm mt-1">
            {{ titleError }}
          </p>
          <h3 class="text-white text-xl font-normal mt-4">Consulta</h3>
          <select
            v-model="querySelected"
            @change="process"
            class="input-netflix input-netflix:focus"
          >
            <option value="null">Seleccione una consulta</option>
            <option
              v-for="query in queries"
              :key="query.id_query"
              :value="query"
            >
              {{ query.nombre }}
            </option>
          </select>
          <h3 class="text-white text-xl font-normal mt-4">Tipo de gráfico</h3>
          <select
            v-model="graphicSelected"
            class="input-netflix input-netflix:focus"
          >
            <option :value="null">Seleccione tipo de gráfico</option>
            <option
              v-for="graphic in graphics"
              :key="graphic.id_tipo"
              :value="graphic"
            >
              {{ graphic.nombre_grafico }}
            </option>
          </select>
        </div>
      </div>
      <Chart
        v-if="graphicSelected && title && querySelected"
        :type="graphicSelected.codigo_grafico"
        :data="chartData"
        :options="chartOptions"
        class="w-[530px] bg-white"
      />
    </div>
    <button
      v-if="graphicSelected && querySelected && title"
      type="submit"
      class="button-netflix max-w-24"
      @click="saveGraphic"
    >
      Guardar
    </button>
  </div>
</template>
