<script setup>
import { getCasts } from "@/services/CastService";
import { ref, onMounted } from "vue";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
import CastCreateModal from "./CastModal/CastCreateModal.vue";
import DeleteCastModal from "./CastModal/DeleteCastModal.vue";
const casts = ref([]);
const castSelected = ref(null);
const showEditCreateModal = ref(false);
const showDeleteModal = ref(false);
const handleShowModal = (action) => {
  if (action === "createEdit") {
    showEditCreateModal.value = !showEditCreateModal.value;
  } else if (action === "delete") {
    showDeleteModal.value = !showDeleteModal.value;
  }
};
const pushCast = (cast) => {
  casts.value.push(cast);
};
const selectCast = (cast, action) => {
  castSelected.value = cast;
  action === "delete"
    ? (showDeleteModal.value = true)
    : (showEditCreateModal.value = true);
};
const UpdateCast = (cast) => {
  const castSearch = casts.value.find((c) => c.id_reparto === cast.id_reparto);
  castSearch.nombre = cast.nombre;
};
const deleteCast = (cast) => {
  console.log("Eliminando reparto", cast);
  casts.value = casts.value.filter((c) => c.id_reparto !== cast.id_reparto);
};
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
    <button
      class="button-netflix max-w-40"
      @click="handleShowModal('createEdit')"
    >
      Crear reparto
    </button>
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
              <PencilIcon
                class="w-6 cursor-pointer h-6"
                @click="selectCast(cast, 'edit')"
              />
              <TrashIcon
                class="w-6 cursor-pointer h-6"
                @click="selectCast(cast, 'delete')"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <CastCreateModal
    v-if="showEditCreateModal"
    @editCast="UpdateCast"
    @close="handleShowModal('createEdit')"
    @addCast="pushCast"
    :cast="castSelected"
    :showEditCreateModal="showEditCreateModal"
  />
  <DeleteCastModal
    v-if="showDeleteModal"
    @deleteCast="deleteCast"
    @close="handleShowModal('delete')"
    :cast="castSelected"
    :showDeleteModal="showDeleteModal"
  />
</template>
