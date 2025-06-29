<script setup>
import { getDirectors } from "@/services/DirectorsService";
import { ref, onMounted } from "vue";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
import CreateDirectorModal from "./DirectorModal/CreateDirectorModal.vue";
import DeleteDirectorModal from "./DirectorModal/DeleteDirectorModal.vue";
const directors = ref([]);
const directorSelected = ref(null);
const showEditCreateModal = ref(false);
const showDeleteModal = ref(false);
const handleShowModal = (action) => {
  if (action === "createEdit") {
    showEditCreateModal.value = !showEditCreateModal.value;
  } else if (action === "delete") {
    showDeleteModal.value = !showDeleteModal.value;
  }
};
const pushDirector = (director) => {
  directors.value.push(director);
};
const selectDirector = (director, action) => {
  directorSelected.value = director;
  action === "delete"
    ? (showDeleteModal.value = true)
    : (showEditCreateModal.value = true);
};
const updateDirector = (director) => {
  const directorSearch = directors.value.find(
    (c) => c.id_director === director.id_director
  );
  directorSearch.nombre = director.nombre;
};
const deleteDirector = (director) => {
  directors.value = directors.value.filter(
    (c) => c.id_director !== director.id_director
  );
};
onMounted(async () => {
  const response = await getDirectors();
  if (response.status === "success") {
    directors.value = response.data;
  }
});
</script>
<template>
  <div class="flex justify-between items-center">
    <h1 class="netflix-h2">Directores</h1>
    <button
      class="button-netflix max-w-40"
      @click="handleShowModal('createEdit')"
    >
      Crear director
    </button>
  </div>
  <br />
  <div class="w-full flex justify-center items-center">
    <div>
      <table class="netflix-table">
        <thead class="netflix-table-header">
          <tr class="netflix-table-tr">
            <th class="netflix-table-header-th">Id</th>
            <th class="netflix-table-header-th">Nombre</th>
            <th class="netflix-table-header-th" colspan="2">Acciones</th>
          </tr>
        </thead>
        <tbody class="netflix-table-body">
          <tr
            class="netflix-table-tr"
            v-for="director in directors"
            :key="director.id_director"
          >
            <td class="netflix-table-body-td">{{ director.id_director }}</td>
            <td class="netflix-table-body-td">{{ director.nombre }}</td>
            <td
              class="netflix-table-body-td flex items-center justify-center gap-x-4"
              colspan="2"
            >
              <PencilIcon
                class="w-6 cursor-pointer h-6"
                @click="selectDirector(director, 'edit')"
              />
              <TrashIcon
                class="w-6 cursor-pointer h-6"
                @click="selectDirector(director, 'delete')"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <CreateDirectorModal
    v-if="showEditCreateModal"
    @editDirector="updateDirector"
    @close="handleShowModal('createEdit')"
    @addDirector="pushDirector"
    :director="directorSelected"
    :showEditCreateModal="showEditCreateModal"
  />
  <DeleteDirectorModal
    v-if="showDeleteModal"
    @deleteDirector="deleteDirector"
    @close="handleShowModal('delete')"
    :director="directorSelected"
    :showDeleteModal="showDeleteModal"
  />
</template>
