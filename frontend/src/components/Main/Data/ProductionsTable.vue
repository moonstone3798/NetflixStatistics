<script setup>
import { getProductions } from "@/services/ProductionsService";
import { ref, onMounted } from "vue";
import PencilIcon from "../../../../public/Icon/PencilIcon.vue";
import TrashIcon from "../../../../public/Icon/TrashIcon.vue";
import CreateProductionModal from "./ProductionModal/CreateProductionModal.vue";
import DeleteProductionModal from "./ProductionModal/DeleteProductionModal.vue";
const productions = ref([]);
const productionSelected = ref(null);
const showEditCreateModal = ref(false);
const showDeleteModal = ref(false);
const handleShowModal = (action) => {
  if (action === "createEdit") {
    showEditCreateModal.value = !showEditCreateModal.value;
  } else if (action === "delete") {
    showDeleteModal.value = !showDeleteModal.value;
  }
};
const pushProduction = (production) => {
  productions.value.push(production);
};
const selectProduction = (production, action) => {
  productionSelected.value = production;
  action === "delete"
    ? (showDeleteModal.value = true)
    : (showEditCreateModal.value = true);
};
const updateProduction = (production) => {
  const productionSearch = productions.value.find(
    (c) => c.id_produccion === production.id_produccion
  );
  Object.assign(productionSearch, production);
};
const deleteProduction = (production) => {
  productions.value = productions.value.filter(
    (c) => c.id_produccion !== production.id_produccion
  );
};
onMounted(async () => {
  const response = await getProductions();
  if (response.status === "success") {
    productions.value = response.data;
  }
});
</script>
<template>
  <div class="flex justify-between items-center">
    <h1 class="netflix-h2">Producciones</h1>
    <button
      class="button-netflix max-w-40"
      @click="handleShowModal('createEdit')"
    >
      Crear producción
    </button>
  </div>
  <br />
  <div class="w-full flex justify-center items-center">
    <div>
      <table class="netflix-table">
        <thead class="netflix-table-header">
          <tr class="netflix-table-tr">
            <th class="netflix-table-header-th">Id</th>
            <th class="netflix-table-header-th">Título</th>
            <th class="netflix-table-header-th">Tipo</th>
            <th class="netflix-table-header-th">Fecha de ingreso</th>
            <th class="netflix-table-header-th">Año de realización</th>
            <th class="netflix-table-header-th">Duración</th>
            <th class="netflix-table-header-th">Descripción</th>
            <th class="netflix-table-header-th">Datos numéricos</th>
            <th class="netflix-table-header-th">Idiomas</th>
            <th class="netflix-table-header-th">Acciones</th>
          </tr>
        </thead>
        <tbody class="netflix-table-body">
          <tr
            class="netflix-table-tr"
            v-for="production in productions"
            :key="production.id_produccion"
          >
            <td class="netflix-table-body-td">
              {{ production.id_produccion }}
            </td>
            <td class="netflix-table-body-td">{{ production.titulo }}</td>
            <td class="netflix-table-body-td">
              {{ production.tipo_produccion }}
            </td>
            <td class="netflix-table-body-td">
              {{ production.fecha_ingreso }}
            </td>
            <td class="netflix-table-body-td">
              {{ production.anio_realizacion }}
            </td>
            <td class="netflix-table-body-td">{{ production.duracion }}</td>
            <td class="netflix-table-body-td">{{ production.descripcion }}</td>
            <td class="netflix-table-body-td">
              - Popularidad: {{ production.popularidad }} <br />
              - Votos: {{ production.votos }} <br />
              - Raiting: {{ production.rating }} <br />
              - Promedio de votos: {{ production.promedio_votos }} <br />
              -Presupuesto: {{ production.presupuesto }} <br />
              - Ganancia: {{ production.ganancia }}
            </td>
            <td class="netflix-table-body-td">{{ production.idioma }}</td>
            <td
              class="netflix-table-body-td flex items-center justify-center gap-x-4"
              colspan="2"
            >
              <PencilIcon
                class="w-6 cursor-pointer h-6"
                @click="selectProduction(production, 'edit')"
              />
              <TrashIcon
                class="w-6 cursor-pointer h-6"
                @click="selectProduction(production, 'delete')"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <CreateProductionModal
    v-if="showEditCreateModal"
    @editProduction="updateProduction"
    @close="handleShowModal('createEdit')"
    @addProduction="pushProduction"
    :production="productionSelected"
    :showEditCreateModal="showEditCreateModal"
  />
  <DeleteProductionModal
    v-if="showDeleteModal"
    @deleteProduction="deleteProduction"
    @close="handleShowModal('delete')"
    :production="productionSelected"
    :showDeleteModal="showDeleteModal"
  />
</template>
