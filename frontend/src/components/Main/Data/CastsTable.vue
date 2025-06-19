<script setup>
import { getCasts } from "@/services/CastService";
import { ref, onMounted } from "vue";
const casts = ref([]);
onMounted(async () => {
  const response = await getCasts();
  if (response.status === "success") {
    casts.value = response.data;
  }
});
</script>
<template>
  <h1 class="netflix-h2">Repartos</h1>
  <br />
  <div class="w-full flex justify-center items-center">
    <table class="netflix-table">
      <thead class="netflix-table-header">
        <tr>
          <th class="netflix-table-header-th">#</th>
          <th class="netflix-table-header-th">Reparto</th>
          <th class="netflix-table-header-th">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cast in casts" :key="cast.id_reparto">
          <td class="netflix-table-body">{{ cast.id_reparto }}</td>
          <td class="netflix-table-body">{{ cast.nombre }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
