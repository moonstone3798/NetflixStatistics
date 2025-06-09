<script setup>
import ChevronIcon from "../../../public/Icon/ChevronIcon.vue";
</script>
<template>
  <div class="md:max-w-[61%] w-full">
    <h1 class="text-white font-bold text-5xl leading-[62px] mb-4 text-center">
      Trabajo Práctico PPI
    </h1>
    <h4 class="text-white font-normal text-2xl leading-[30px] mb-6 text-center">
      Análisis del catálogo de la plataforma NETFLIX y representación de datos
      mediante gráficos.
    </h4>
    <div class="w-full max-w-[65%] justify-self-center">
      <h5 class="text-white font-normal text-xl mb-4 text-center">
        ¿Todo listo? Ingresa tu email para registrarte.
      </h5>
      <div
        class="flex md:justify-center md:gap-x-2 flex-col md:flex-row items-center gap-y-2 md:gap-y-0"
      >
        <input
          type="text"
          class="input-netflix"
          placeholder="Dirección de Email"
        />
        <button
          class="button-netflix md:max-w-[37%] flex items-center justify-center gap-x-4 h-14 mt-1 px-2"
        >
          <span class="text-2xl">Crear Cuenta</span>
          <ChevronIcon />
        </button>
      </div>
    </div>
  </div>
</template>
