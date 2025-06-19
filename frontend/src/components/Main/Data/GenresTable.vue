<script setup>
import { getGenres } from "@/services/GenresService";
import { ref, onMounted } from "vue";
const genres = ref([]);
onMounted(async () => {
  const response = await getGenres();
  if (response.status === "success") {
    genres.value = response.data;
  }
});
</script>
<template>
  <h1 class="netflix-h2">Géneros</h1>
  <br />
  <div class="w-full flex justify-center items-center">
    <table class="netflix-table">
      <thead class="netflix-table-header">
        <tr>
          <th class="netflix-table-header-th">#</th>
          <th class="netflix-table-header-th">Género</th>
          <th class="netflix-table-header-th">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="genre in genres" :key="genre.id_genero">
          <td class="netflix-table-body">{{ genre.id_genero }}</td>
          <td class="netflix-table-body">{{ genre.nombre }}</td>
          <td class="netflix-table-body"></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
