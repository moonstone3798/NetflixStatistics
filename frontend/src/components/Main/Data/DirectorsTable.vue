<script setup>
import { getDirectors } from "@/services/DirectorsService";
import { ref, onMounted } from "vue";
const directors = ref([]);
onMounted(async () => {
  const response = await getDirectors();
  if (response.status === "success") {
    directors.value = response.data;
    console.log("directors.value", directors.value);
    console.log("response.data", response.data);
  }
});
</script>
<template>
  <h1 class="netflix-h2">Directores</h1>
  <br />
  <div class="w-full flex justify-center items-center">
    <table class="netflix-table">
      <thead class="netflix-table-header">
        <tr>
          <th class="netflix-table-header-th">#</th>
          <th class="netflix-table-header-th">Nombre</th>
          <th class="netflix-table-header-th">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="director in directors" :key="director.id_director">
          <td class="netflix-table-body">{{ director.id_director }}</td>
          <td class="netflix-table-body">{{ director.nombre }}</td>
          <td class="netflix-table-body"></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
