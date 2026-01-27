<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import { onMounted } from 'vue';

const categoriasMenu = ref([]);
const apiUrl = import.meta.env.VITE_API_URL || 'http://127.0.0.1:3001/api';

const fetchCategorias = async () => {
    try {

        const response = await axios.get(`${apiUrl}/areas?page=1&perPage=20`);
        const areas = response.data;
        
        if (areas && areas.length > 0) {
            // Filtrar: excluir type="pasta" e menu=0
            const filtradas = areas.filter(area => {
                console.log(`Área ${area.nome}: type=${area.type}, menu=${area.menu}`);
                return area.type !== 'pasta' && area.menu !== 0;
            });
            console.log('Categorias filtradas:', filtradas);
            categoriasMenu.value = filtradas;
        }
    } catch (error) {
        console.error('Erro ao carregar categorias:', error);
        categoriasMenu.value = [];
    }
};

onMounted(() => {
    fetchCategorias();
});
</script>

<template>
 <!-- Top Header Start -->
        <header class="text-white">
        <div class="container text-center">
            <div class="header_img"> </div>
        </div>
    </header>
        <!-- Top Header End -->


        <!-- Header Start -->
        <div class="header">
             <nav class="absolute top-0 border-solid border-gray-200 w-full border-b py-3 bg-darkred z-50 bg-inherit">
        <div class="container mx-auto" style="height: 20px !important;">
          <div class="w-full flex flex-col lg:flex-row w-full">
            <div class="flex justify-between lg:flex-row w-full">
              <ul class="flex items-center mx-auto gap-2">
                <li v-for="categoria in categoriasMenu" :key="categoria.id"
                class="flex items-center justify-between text-yellow-500 text-sm lg:text-base font-medium hover:text-indigo-700 transition-all duration-500 mb-2 lg:mr-6 md:mb-0 md:mr-3">
                                                            <span class="fa-li"><i class="far fa-arrow-alt-circle-right"></i></span>
                                                            <Link :href="`/categoria/${categoria.id}`" class="aMenu">{{ categoria.nome }}</Link>
                                                        </li>

               
              </ul>
            </div>
          </div>
        </div>
      </nav>
                                                  
        </div>
        <!-- Header End -->

                                         
<slot/>
</template>



<style scoped>
/* Optional styling for your components */
</style>