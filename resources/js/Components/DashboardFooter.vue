<script setup>
const currentYear = new Date().getFullYear();
</script>

<template>
  <v-footer app color="primary" dark>
    <span class="white--text">&copy; {{ currentYear }} My Application</span>
  </v-footer>
</template>
