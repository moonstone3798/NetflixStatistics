<script setup>
import { ref } from "vue";
import Dropzone from "dropzone-vue3";
import { onMounted } from "vue";
import Chart from "primevue/chart";
import { getGraphicTypes } from "@/services/GraphicTypesService";
import { getQueries, processQuery } from "@/services/QueriesService";
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
const chartData = ref({
  labels: ["Enero", "Febrero", "Marzo"],
  datasets: [
    {
      label: "Ventas",
      data: [65, 59, 80],
      backgroundColor: ["#C11119", "#000000", "#BDBCBB"],
    },
  ],
});

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: "top",
    },
    title: {
      display: true,
      text: "Ejemplo de gráfico",
    },
  },
});
const process = async () => {
  if (querySelected.value && querySelected.value !== "null") {
    const response = await processQuery({
      query: querySelected.value,
    });
    if (response.status === "success") {
      console.log(response.data);
      // chartData.value = response.data;
    }
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
  <div v-else class="flex w-[63%] justify-between">
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
            :value="query.query"
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
            :key="graphic.codigo_grafico"
            :value="graphic.codigo_grafico"
          >
            {{ graphic.nombre_grafico }}
          </option>
        </select>
      </div>
    </div>
    <Chart
      v-if="graphicSelected"
      :type="graphicSelected"
      :data="chartData"
      :options="chartOptions"
      class="w-[530px] bg-white"
    />
  </div>
  <button
    v-if="graphicSelected && querySelected && title"
    type="submit"
    class="button-netflix max-w-24"
    @click=""
  >
    Guardar
  </button>
</template>
