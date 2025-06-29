<script setup>
import { getGenres } from "@/services/GenresService";
import { ref, onMounted } from "vue";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
import CreateGenresModal from "./GenresModal/CreateGenresModal.vue";
import DeleteGenreModal from "./GenresModal/DeleteGenreModal.vue";
const genres = ref([]);
const genreSelected = ref(null);
const showEditCreateModal = ref(false);
const showDeleteModal = ref(false);
const handleShowModal = (action) => {
  if (action === "createEdit") {
    showEditCreateModal.value = !showEditCreateModal.value;
  } else if (action === "delete") {
    showDeleteModal.value = !showDeleteModal.value;
  }
};
const pushGenre = (genre) => {
  genres.value.push(genre);
};
const selectGenre = (genre, action) => {
  genreSelected.value = genre;
  action === "delete"
    ? (showDeleteModal.value = true)
    : (showEditCreateModal.value = true);
};
const updateGenre = (genre) => {
  const genreSearch = genres.value.find((c) => c.id_genero === genre.id_genero);
  genreSearch.nombre = genre.nombre;
};
const deleteGenre = (genre) => {
  genres.value = genres.value.filter((c) => c.id_genero !== genre.id_genero);
};
onMounted(async () => {
  const response = await getGenres();
  if (response.status === "success") {
    genres.value = response.data;
  }
});
</script>
<template>
  <div class="flex justify-between items-center">
    <h1 class="netflix-h2">Géneros</h1>
    <button
      class="button-netflix max-w-40"
      @click="handleShowModal('createEdit')"
    >
      Crear género
    </button>
  </div>
  <br />
  <div class="w-full flex justify-center items-center">
    <div>
      <table class="netflix-table">
        <thead class="netflix-table-header">
          <tr class="netflix-table-tr">
            <th class="netflix-table-header-th">Id</th>
            <th class="netflix-table-header-th">Género</th>
            <th class="netflix-table-header-th" colspan="2">Acciones</th>
          </tr>
        </thead>
        <tbody class="netflix-table-body">
          <tr
            class="netflix-table-tr"
            v-for="genre in genres"
            :key="genre.id_genero"
          >
            <td class="netflix-table-body-td">{{ genre.id_genero }}</td>
            <td class="netflix-table-body-td">{{ genre.nombre }}</td>
            <td
              class="netflix-table-body-td flex items-center justify-center gap-x-4"
              colspan="2"
            >
              <PencilIcon
                class="w-6 cursor-pointer h-6"
                @click="selectGenre(genre, 'edit')"
              />
              <TrashIcon
                class="w-6 cursor-pointer h-6"
                @click="selectGenre(genre, 'delete')"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <CreateGenresModal
    v-if="showEditCreateModal"
    @editGenre="updateGenre"
    @close="handleShowModal('createEdit')"
    @addGenre="pushGenre"
    :genre="genreSelected"
    :showEditCreateModal="showEditCreateModal"
  />
  <DeleteGenreModal
    v-if="showDeleteModal"
    @deleteGenre="deleteGenre"
    @close="handleShowModal('delete')"
    :genre="genreSelected"
    :showDeleteModal="showDeleteModal"
  />
</template>
