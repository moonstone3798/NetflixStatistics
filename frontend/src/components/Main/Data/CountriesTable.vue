<script setup>
import { getCountries } from "@/services/CountriesService";
import { ref, onMounted } from "vue";
const countries = ref([]);
onMounted(async () => {
  const response = await getCountries();
  if (response.status === "success") {
    countries.value = response.data;
  }
});
</script>
<template>
  <h1 class="netflix-h2">Países</h1>
  <br />
  <div class="w-full flex justify-center items-center">
    <table class="netflix-table">
      <thead class="netflix-table-header">
        <tr>
          <th class="netflix-table-header-th">#</th>
          <th class="netflix-table-header-th">País</th>
          <th class="netflix-table-header-th">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="country in countries" :key="country.id_pais">
          <td class="netflix-table-body">{{ country.id_pais }}</td>
          <td class="netflix-table-body">{{ country.nombre }}</td>
          <td class="netflix-table-body"></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
