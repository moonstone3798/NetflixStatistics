<script setup>
import { ref } from "vue";
const sectionSelected = ref(1);

const sections = [
  {
    id: 1,
    name: "Directores",
  },
  {
    id: 2,
    name: "Géneros",
  },
  {
    id: 3,
    name: "Idiomas",
  },
  {
    id: 4,
    name: "Países",
  },
  {
    id: 5,
    name: "Repartos",
  },
  {
    id: 6,
    name: "Tipo de producciones",
  },
  {
    id: 7,
    name: "Datos numéricos",
  },
  {
    id: 8,
    name: "Producciones",
  },
];
const emit = defineEmits(["sectionSelected"]);
const selectSection = (section) => {
  emit("sectionSelected", section.name);
  sectionSelected.value = section.id;
};
</script>
<template>
  <nav class="w-[20%]">
    <ul class="text-white flex flex-col gap-y-2">
      <li v-for="section in sections" :key="section.id">
        <div
          :to="section.route"
          class="flex items-center cursor-pointer gap-x-3 hover:bg-netflix-redHover px-3 py-2 rounded-netflix-20"
          :class="section.id === sectionSelected && 'bg-netflix-redSelected'"
          @click="selectSection(section)"
        >
          <p>{{ section.name }}</p>
        </div>
      </li>
    </ul>
  </nav>
</template>
