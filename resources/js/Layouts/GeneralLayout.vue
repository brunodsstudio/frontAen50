<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
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
                <li>
                  <a href="javascript:;" class="flex items-center justify-between text-yellow-500 text-sm lg:text-base font-medium hover:text-indigo-700 transition-all duration-500 mb-2 lg:mr-6 md:mb-0 md:mr-3">Home</a>
                </li>
                <li>
                  <a href="javascript:;" class="flex items-center justify-between text-yellow-500  text-sm lg:text-base font-medium hover:text-indigo-700 transition-all duration-500 mb-2 lg:mr-6 md:mb-0 md:mr-3">About us</a>
                </li>
                <li>
                  <a href="javascript:;" class="flex items-center justify-between text-yellow-500  text-sm lg:text-base font-medium hover:text-indigo-700 transition-all duration-500 mb-2 lg:mr-6 md:mb-0 md:mr-3">product</a>
                </li>
                <li>
                  <a href="javascript:;" class="flex items-center justify-between text-yellow-500  text-sm lg:text-base font-medium hover:text-indigo-700 transition-all duration-500 mb-2 lg:mr-6 md:mb-0 md:mr-3">Features</a>
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

<script>
export default {
  data() {
    return {
      drawer: true, // Controls the visibility of the navigation drawer
    };
  },
};
</script>

<style scoped>
/* Optional styling for your components */
</style>