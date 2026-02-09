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
    <v-app-bar-nav-icon class="drawer-toggle" variant="plain" @click="toggleDrawer">
      <v-icon class="drawer-toggle-icon">mdi-menu</v-icon>
    </v-app-bar-nav-icon>
    <v-toolbar-title class="app-bar-title">
      <span>{{ title }}</span>
    </v-toolbar-title> 
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

.app-bar-title {
  display: flex;
  align-items: center;
  gap: 8px;
}

.app-bar-logo {
  width: 28px;
  height: 28px;
  fill: currentColor;
}

.drawer-toggle {
  color: #fff;
  opacity: 1;
}

:deep(.drawer-toggle .v-icon),
.drawer-toggle-icon {
  color: #fff;
  opacity: 1;
}
</style>
