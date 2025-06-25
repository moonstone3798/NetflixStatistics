<script setup>
import { getCasts } from "@/services/CastService";
import { ref, onMounted } from "vue";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
import CastCreateModal from "./CastModal/CastCreateModal.vue";
const casts = ref([]);
onMounted(async () => {
  const response = await getCasts();
  if (response.status === "success") {
    casts.value = response.data;
  }
});
</script>
<template>
  <div class="flex justify-between items-center">
    <h1 class="netflix-h2">Repartos</h1>
    <CastCreateModal />
  </div>
  <br />
  <div class="w-full flex justify-center items-center">
    <div>
      <table class="netflix-table">
        <thead class="netflix-table-header">
          <tr class="netflix-table-tr">
            <th class="netflix-table-header-th">Id</th>
            <th class="netflix-table-header-th">Reparto</th>
            <th class="netflix-table-header-th" colspan="2">Acciones</th>
          </tr>
        </thead>
        <tbody class="netflix-table-body">
          <tr
            v-for="cast in casts"
            :key="cast.id_reparto"
            class="netflix-table-tr"
          >
            <td class="netflix-table-body-td">{{ cast.id_reparto }}</td>
            <td class="netflix-table-body-td">{{ cast.nombre }}</td>
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
