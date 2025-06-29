<script setup>
import { getLanguages } from "@/services/LanguagesService";
import { ref, onMounted } from "vue";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
import CreateLanguageModal from "./LanguageModal/CreateLanguageModal.vue";
import DeleteLanguageModal from "./LanguageModal/DeleteLanguageModal.vue";
const languages = ref([]);
const languageSelected = ref(null);
const showEditCreateModal = ref(false);
const showDeleteModal = ref(false);
const handleShowModal = (action) => {
  if (action === "createEdit") {
    showEditCreateModal.value = !showEditCreateModal.value;
  } else if (action === "delete") {
    showDeleteModal.value = !showDeleteModal.value;
  }
};
const pushLanguage = (language) => {
  languages.value.push(language);
};
const selectLanguage = (language, action) => {
  languageSelected.value = language;
  action === "delete"
    ? (showDeleteModal.value = true)
    : (showEditCreateModal.value = true);
};
const updateLanguage = (language) => {
  const languageSearch = languages.value.find(
    (c) => c.id_idioma === language.id_idioma
  );
  languageSearch.idioma = language.idioma;
};
const deleteLanguage = (language) => {
  languages.value = languages.value.filter(
    (c) => c.id_idioma !== language.id_idioma
  );
};
onMounted(async () => {
  const response = await getLanguages();
  if (response.status === "success") {
    languages.value = response.data;
  }
});
</script>
<template>
  <div class="flex justify-between items-center">
    <h1 class="netflix-h2">Idiomas</h1>
    <button
      class="button-netflix max-w-40"
      @click="handleShowModal('createEdit')"
    >
      Crear idioma
    </button>
  </div>
  <br />
  <div class="w-full flex justify-center items-center">
    <div>
      <table class="netflix-table">
        <thead class="netflix-table-header">
          <tr class="netflix-table-tr">
            <th class="netflix-table-header-th">Id</th>
            <th class="netflix-table-header-th">Idioma</th>
            <th class="netflix-table-header-th">Acciones</th>
          </tr>
        </thead>
        <tbody class="netflix-table-body">
          <tr
            class="netflix-table-tr"
            v-for="language in languages"
            :key="language.id_idioma"
          >
            <td class="netflix-table-body-td">{{ language.id_idioma }}</td>
            <td class="netflix-table-body-td">{{ language.idioma }}</td>
            <td
              class="netflix-table-body-td flex items-center justify-center gap-x-4"
              colspan="2"
            >
              <PencilIcon
                class="w-6 cursor-pointer h-6"
                @click="selectLanguage(language, 'edit')"
              />
              <TrashIcon
                class="w-6 cursor-pointer h-6"
                @click="selectLanguage(language, 'delete')"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <CreateLanguageModal
    v-if="showEditCreateModal"
    @editLanguage="updateLanguage"
    @close="handleShowModal('createEdit')"
    @addLanguage="pushLanguage"
    :language="languageSelected"
    :showEditCreateModal="showEditCreateModal"
  />
  <DeleteLanguageModal
    v-if="showDeleteModal"
    @deleteLanguage="deleteLanguage"
    @close="handleShowModal('delete')"
    :language="languageSelected"
    :showDeleteModal="showDeleteModal"
  />
</template>
