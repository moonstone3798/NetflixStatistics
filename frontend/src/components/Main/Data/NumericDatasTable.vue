<script setup>
import { ref, onMounted } from "vue";
import { getNumericData } from "@/services/NumericDataService";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
import CreateNumericDataModal from "./NumericDataModal/CreateNumericDataModal.vue";
import DeleteNumericDataModal from "./NumericDataModal/DeleteNumericDataModal.vue";
const numericData = ref([]);
const numericDataSelected = ref(null);
const showEditCreateModal = ref(false);
const showDeleteModal = ref(false);
const handleShowModal = (action) => {
  if (action === "createEdit") {
    showEditCreateModal.value = !showEditCreateModal.value;
  } else if (action === "delete") {
    showDeleteModal.value = !showDeleteModal.value;
  }
};
const pushNumericData = (data) => {
  numericData.value.push(data);
};
const selectData = (data, action) => {
  numericDataSelected.value = data;
  action === "delete"
    ? (showDeleteModal.value = true)
    : (showEditCreateModal.value = true);
};
const UpdateNumericData = (data) => {
  const numericDataSearch = numericData.value.find(
    (n) => n.id_dato_extra === data.id_dato_extra
  );
  numericDataSearch.popularidad = data.popularidad;
  numericDataSearch.votos = data.votos;
  numericDataSearch.rating = data.rating;
  numericDataSearch.promedio_votos = data.promedio_votos;
  numericDataSearch.presupuesto = data.presupuesto;
  numericDataSearch.ganancia = data.ganancia;
};
const deleteNumericData = (data) => {
  numericData.value = numericData.value.filter(
    (n) => n.id_dato_extra !== data.id_dato_extra
  );
};
onMounted(async () => {
  const response = await getNumericData();
  if (response.status === "success") {
    numericData.value = response.data;
  }
});
</script>
<template>
  <div class="flex justify-between items-center">
    <h1 class="netflix-h2">Datos numéricos</h1>
    <button
      class="button-netflix max-w-56"
      @click="handleShowModal('createEdit')"
    >
      Crear dato numérico
    </button>
  </div>
  <br />
  <div class="w-full flex justify-center items-center">
    <div>
      <table class="netflix-table">
        <thead class="netflix-table-header">
          <tr class="netflix-table-tr">
            <th class="netflix-table-header-th">Id</th>
            <th class="netflix-table-header-th">Popularidad</th>
            <th class="netflix-table-header-th">Votos</th>
            <th class="netflix-table-header-th">Rating</th>
            <th class="netflix-table-header-th">Promedio de votos</th>
            <th class="netflix-table-header-th">Presupuesto</th>
            <th class="netflix-table-header-th">Ganancia</th>
            <th class="netflix-table-header-th">Acciones</th>
          </tr>
        </thead>
        <tbody class="netflix-table-body">
          <tr
            class="netflix-table-tr"
            v-for="ndata in numericData"
            :key="ndata.id_dato_extra"
          >
            <td class="netflix-table-body-td">{{ ndata.id_dato_extra }}</td>
            <td class="netflix-table-body-td">{{ ndata.popularidad }}</td>
            <td class="netflix-table-body-td">{{ ndata.votos }}</td>
            <td class="netflix-table-body-td">{{ ndata.rating }}</td>
            <td class="netflix-table-body-td">{{ ndata.promedio_votos }}</td>
            <td class="netflix-table-body-td">{{ ndata.presupuesto }}</td>
            <td class="netflix-table-body-td">{{ ndata.ganancia }}</td>
            <td
              class="netflix-table-body-td flex items-center justify-center gap-x-4"
              colspan="2"
            >
              <PencilIcon
                class="w-6 cursor-pointer h-6"
                @click="selectData(ndata, 'edit')"
              />
              <TrashIcon
                class="w-6 cursor-pointer h-6"
                @click="selectData(ndata, 'delete')"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <CreateNumericDataModal
    v-if="showEditCreateModal"
    @editNumericData="UpdateNumericData"
    @close="handleShowModal('createEdit')"
    @addNumericData="pushNumericData"
    :ndata="numericDataSelected"
    :showEditCreateModal="showEditCreateModal"
  />
  <DeleteNumericDataModal
    v-if="showDeleteModal"
    @deleteNumericData="deleteNumericData"
    @close="handleShowModal('delete')"
    :ndata="numericDataSelected"
    :showDeleteModal="showDeleteModal"
  />
</template>
