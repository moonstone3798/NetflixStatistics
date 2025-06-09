<script setup>
import { ref } from "vue";
import Dropzone from "dropzone-vue3";

const myVueDropzone = ref(null);

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
</script>

<template>
  <div class="max-w-[67%] w-full">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-white font-bold">Diseñar tu gráfico</h2>
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
</template>
