<script setup>
const props = defineProps({
  title: {
    type: String,
    default: 'My Application'
  },
  breadcrumbs: {
    type: Array,
    default: () => ['Dashboard']
  }
});

const emit = defineEmits(['toggle-drawer']);

const toggleDrawer = () => {
  emit('toggle-drawer');
};
</script>

<template>
  <v-app-bar app color="primary" dark>
    <v-app-bar-nav-icon @click="toggleDrawer"></v-app-bar-nav-icon>
    <v-toolbar-title>{{ title }}</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-breadcrumbs :items="breadcrumbs" class="pa-0">
      <template v-slot:divider>
        <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
      </template>
    </v-breadcrumbs>
  </v-app-bar>
</template>

<style scoped>
.v-breadcrumbs {
  color: white;
}
</style>
