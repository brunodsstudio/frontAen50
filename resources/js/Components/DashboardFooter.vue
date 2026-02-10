<script setup>
const currentYear = new Date().getFullYear();
</script>

<template>
  <v-footer app color="primary" dark>
    <span class="white--text">&copy; {{ currentYear }} A Era Nerd - Dashboard</span>
  </v-footer>
</template>
