<script setup>
import { markRaw, onMounted, ref } from "vue";
import SideBar from "../../../components/Main/Nav/SideBar.vue";
import { useRouter } from "vue-router";
import DirectorsTable from "@/components/Main/Data/DirectorsTable.vue";
import GenresTable from "@/components/Main/Data/GenresTable.vue";
import LanguagesTable from "@/components/Main/Data/LanguagesTable.vue";
import CountriesTable from "@/components/Main/Data/CountriesTable.vue";
import CastsTable from "@/components/Main/Data/CastsTable.vue";
import TypesOfProductionsTable from "@/components/Main/Data/TypesOfProductionsTable.vue";
import NumericDatasTable from "../../../components/Main/Data/NumericDatasTable.vue";
import ProductionsTable from "../../../components/Main/Data/ProductionsTable.vue";
const router = useRouter();
const sections = [
  {
    id: "Directores",
    component: markRaw(DirectorsTable),
  },
  {
    id: "Géneros",
    component: markRaw(GenresTable),
  },
  {
    id: "Idiomas",
    component: markRaw(LanguagesTable),
  },
  {
    id: "Países",
    component: markRaw(CountriesTable),
  },
  {
    id: "Repartos",
    component: markRaw(CastsTable),
  },
  {
    id: "Tipo de producciones",
    component: markRaw(TypesOfProductionsTable),
  },
  {
    id: "Datos numéricos",
    component: markRaw(NumericDatasTable),
  },
  { id: "Producciones", component: markRaw(ProductionsTable) },
];

const sectionSelected = ref(null);
const redirectToWelcome = () => {
  router.push({
    name: "Welcome",
  });
};
const selectComponent = (id) => {
  const found = sections.find((section) => section.id === id);
  sectionSelected.value = found?.component || redirectToWelcome();
};

onMounted(() => {
  selectComponent("Directores");
});
</script>

<template>
  <div class="max-w-[90%] w-full flex gap-x-20">
    <SideBar @section-selected="selectComponent" />
    <div class="w-full">
      <component :is="sectionSelected" v-if="sectionSelected" />
      <p v-else>No se encontró la sección</p>
    </div>
  </div>
</template>
