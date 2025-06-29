<script setup>
import { getCountries } from "@/services/CountriesService";
import { ref, onMounted } from "vue";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
import CreateCountryModal from "./CountryModal/CreateCountryModal.vue";
import DeleteCountryModal from "./CountryModal/DeleteCountryModal.vue";
const countries = ref([]);
const countrySelected = ref(null);
const showEditCreateModal = ref(false);
const showDeleteModal = ref(false);
const handleShowModal = (action) => {
  if (action === "createEdit") {
    showEditCreateModal.value = !showEditCreateModal.value;
  } else if (action === "delete") {
    showDeleteModal.value = !showDeleteModal.value;
  }
};
const pushCountry = (country) => {
  countries.value.push(country);
};
const selectCountry = (country, action) => {
  countrySelected.value = country;
  action === "delete"
    ? (showDeleteModal.value = true)
    : (showEditCreateModal.value = true);
};
const updateCountry = (country) => {
  const countrySearch = countries.value.find(
    (c) => c.id_pais === country.id_pais
  );
  countrySearch.nombre = country.nombre;
};
const deleteCountry = (country) => {
  countries.value = countries.value.filter(
    (c) => c.id_pais !== country.id_pais
  );
};
onMounted(async () => {
  const response = await getCountries();
  if (response.status === "success") {
    countries.value = response.data;
  }
});
</script>
<template>
  <div class="flex justify-between items-center">
    <h1 class="netflix-h2">Países</h1>
    <button
      class="button-netflix max-w-40"
      @click="handleShowModal('createEdit')"
    >
      Crear país
    </button>
  </div>
  <br />
  <div class="w-full flex justify-center items-center">
    <div>
      <table class="netflix-table">
        <thead class="netflix-table-header">
          <tr class="netflix-table-tr">
            <th class="netflix-table-header-th">Id</th>
            <th class="netflix-table-header-th">País</th>
            <th class="netflix-table-header-th">Acciones</th>
          </tr>
        </thead>
        <tbody class="netflix-table-body">
          <tr
            class="netflix-table-tr"
            v-for="country in countries"
            :key="country.id_pais"
          >
            <td class="netflix-table-body-td">{{ country.id_pais }}</td>
            <td class="netflix-table-body-td">{{ country.nombre }}</td>
            <td
              class="netflix-table-body-td flex items-center justify-center gap-x-4"
              colspan="2"
            >
              <PencilIcon
                class="w-6 cursor-pointer h-6"
                @click="selectCountry(country, 'edit')"
              />
              <TrashIcon
                class="w-6 cursor-pointer h-6"
                @click="selectCountry(country, 'delete')"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <CreateCountryModal
    v-if="showEditCreateModal"
    @editCountry="updateCountry"
    @close="handleShowModal('createEdit')"
    @addCountry="pushCountry"
    :country="countrySelected"
    :showEditCreateModal="showEditCreateModal"
  />
  <DeleteCountryModal
    v-if="showDeleteModal"
    @deleteCountry="deleteCountry"
    @close="handleShowModal('delete')"
    :country="countrySelected"
    :showDeleteModal="showDeleteModal"
  />
</template>
