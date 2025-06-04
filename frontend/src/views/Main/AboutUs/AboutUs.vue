<script setup>
import MessageIcon from "../../../../public/Icon/MessageIcon.vue";
</script>
<template>
  <div class="w-full max-w-[66%]">
    <h1 class="text-white font-bold text-3xl leading-10 mb-4">
      Sobre Nosotros
    </h1>
    <p class="text-white font-normal text-lg mb-9">
      Para el segundo trabajo práctico de la materia, se nos ha solicitado que
      elijamos 3 datasets diferentes para poder a partir del manejo de las
      herramientas Tableau y Power bi, analizar sus datos, y experimentar cómo
      sería trabajar para una empresa que a partir del análisis de datos toma
      decisiones que afectan a su negocio, por ejemplo a sus ventas. Nosotros,
      el grupo 4, hemos elegido 3 datasets: netflix, spotify y uno de mundiales
      de fútbol. Y hemos hecho a partir de ellos una serie de gráficos con ambas
      herramientas. Luego se nos ha solicitado que a partir de lo trabajado
      elijamos una sola de aquellas herramientas y un solo dataset para, a
      partir del mismo, hacer más preguntas, con gráficos que puedan aportar
      valor para la empresa. Al ofrecernos esta posibilidad hemos optado por la
      herramienta Power bi porque nos resultó más didáctica y más intuitiva, con
      una curva de aprendizaje menor a la de Tableau, con la cual tuvimos que
      estar un tiempo extra para poder llegar a los gráficos deseados. Y además
      elegimos netflix dado que es uno de los servicios de streaming más
      utilizados en la actualidad, el cual cuenta con tanto series como
      películas, y está vigente desde hace años. Por lo tanto, esperamos obtener
      de su dataset una gran cantidad de datos para analizar y a partir de ellos
      obtener información.
    </p>
    <h2 class="text-white font-bold text-2xl leading-7 mb-3">Contacto</h2>
    <p class="text-white font-normal text-lg">
      Si tiene alguna pregunta, feedback, o sugerencia, por favor no dude en
      comunicarse con nosotros.
    </p>
    <div class="py-2 flex items-center gap-x-4">
      <div
        class="bg-netflix-red rounded-lg p-2 flex items-center justify-center"
      >
        <MessageIcon />
      </div>
      <a href="mailto:support@netflixPPII.com" class="text-white"
        >Email: support@netflixPPII.com</a
      >
    </div>
  </div>
</template>
