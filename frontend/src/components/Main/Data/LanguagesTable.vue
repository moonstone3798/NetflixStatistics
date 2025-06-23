<script setup>
import { getLanguages } from "@/services/LanguagesService";
import { ref, onMounted } from "vue";
const languages = ref([]);
onMounted(async () => {
  const response = await getLanguages();
  if (response.status === "success") {
    languages.value = response.data;
  }
});
</script>
<template>
  <h1 class="netflix-h2">Idiomas</h1>
  <br />
  <div class="w-full flex justify-center items-center">
    <table class="netflix-table">
      <thead class="netflix-table-header">
        <tr>
          <th class="netflix-table-header-th">#</th>
          <th class="netflix-table-header-th">Idioma</th>
          <th class="netflix-table-header-th">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="language in languages" :key="language.id_idioma">
          <td class="netflix-table-body">{{ language.id_idioma }}</td>
          <td class="netflix-table-body">{{ language.idioma }}</td>
          <td class="netflix-table-body"></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
