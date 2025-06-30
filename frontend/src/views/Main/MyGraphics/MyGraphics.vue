<script setup>
import { ref, onMounted } from "vue";
import { getViews } from "@/services/ViewService";
const graphics = ref([]);
const bgImages = [
  "../../../../public/img/graficos/grafico1.png",
  "../../../../public/img/graficos/grafico2.png",
  "../../../../public/img/graficos/grafico3.png",
  "../../../../public/img/graficos/grafico4.png",
  "../../../../public/img/graficos/grafico5.png",
  "../../../../public/img/graficos/grafico6.png",
];
onMounted(async () => {
  const userInfo = JSON.parse(localStorage.getItem("userInfo"));
  const response = await getViews({
    id: userInfo.id_usuario,
  });
  if (response.status === "success") {
    graphics.value = response.data;
  }
});
</script>
<template>
  <div class="w-full max-w-[66%] min-h-[86vh]">
    <h1 class="text-white font-bold text-4xl leading-10 my-4">Mis Gráficos</h1>
    <div class="flex justify-center items-center">
      <img
        v-if="graphics.length === 0"
        src="../../../../public/img/meme.jpg"
        alt=""
        class="h-48 mt-8"
      />
      <div class="w-full grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
        <div
          v-for="(graphic, index) in graphics"
          :key="graphic.id"
          class="p-4 rounded shadow"
        >
          <img :src="bgImages[index]" alt="" class="h-32 mt-8 mb-3 mx-auto" />
          <p class="text-white text-center">{{ graphic.nombre }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
