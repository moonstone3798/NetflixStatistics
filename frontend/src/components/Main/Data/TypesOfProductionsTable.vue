<script setup>
import { getProductionTypes } from "@/services/ProductionTypeService";
import { ref, onMounted } from "vue";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
const types = ref([]);
onMounted(async () => {
  const response = await getProductionTypes();
  if (response.status === "success") {
    types.value = response.data;
  }
});
</script>
<template>
  <div class="flex justify-between items-center">
    <h1 class="netflix-h2">Tipos de producciones</h1>
    <button class="button-netflix max-w-40">Crear tipo</button>
  </div>
  <br />
  <div class="w-full flex justify-center items-center">
    <div>
      <table class="netflix-table">
        <thead class="netflix-table-header">
          <tr class="netflix-table-tr">
            <th class="netflix-table-header-th">Id</th>
            <th class="netflix-table-header-th">Tipo</th>
            <th class="netflix-table-header-th">Acciones</th>
          </tr>
        </thead>
        <tbody class="netflix-table-body">
          <tr
            class="netflix-table-tr"
            v-for="type in types"
            :key="type.id_tipo_produccion"
          >
            <td class="netflix-table-body-td">{{ type.id_tipo_produccion }}</td>
            <td class="netflix-table-body-td">{{ type.nombre }}</td>
            <td
              class="netflix-table-body-td flex items-center justify-center gap-x-4"
              colspan="2"
            >
              <PencilIcon class="w-6 cursor-pointer h-6" />
              <TrashIcon class="w-6 cursor-pointer h-6" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
