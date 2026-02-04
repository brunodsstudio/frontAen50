<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import DashboardSidebar from '@/Components/DashboardSidebar.vue';
import DashboardAppBar from '@/Components/DashboardAppBar.vue';
import DashboardFooter from '@/Components/DashboardFooter.vue';
</script>

<template>
  <v-app>
     <!-- Navigation Drawer -->
    <DashboardSidebar v-model="drawer" />

    <!-- App Bar -->
    <DashboardAppBar 
      title="My Application"
      :breadcrumbs="['Dashboard', 'Eventos']"
      @toggle-drawer="drawer = !drawer"
    />

    <v-main>
      <slot />
    </v-main>

   <DashboardFooter />
  </v-app>
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