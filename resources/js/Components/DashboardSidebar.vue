<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(['update:modelValue']);

const drawer = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});

const toggleDrawer = () => {
  drawer.value = !drawer.value;
};
</script>

<template>
  <v-navigation-drawer v-model="drawer" app>
    <v-list>
      <v-list-item>
        <v-list-item-title class="text-h6">
          <ApplicationLogo @click.prevent="toggleDrawer" class="h-10 w-10 fill-current text-gray-500" />
        </v-list-item-title>
      </v-list-item>

      <v-divider></v-divider>

      <v-list-item link :href="route('dashboard')">
        <template v-slot:prepend>
          <i class="fas fa-tachometer-alt"></i>
        </template>
        <v-list-item-title>Dashboard</v-list-item-title>
      </v-list-item>

      <v-list-item link href="/dashboard/eventos" :active="$page.component === 'Eventos'">
        <template v-slot:prepend>
          <i class="fas fa-calendar-star"></i>
        </template>
        <v-list-item-title>Eventos</v-list-item-title>
      </v-list-item>

      <v-list-item link href="/dashboard/materias">
        <template v-slot:prepend>
          <i class="fas fa-newspaper"></i>
        </template>
        <v-list-item-title>Matérias</v-list-item-title>
      </v-list-item>

      <v-list-item link href="/dashboard/escritores">
        <template v-slot:prepend>
          <i class="fas fa-user-edit"></i>
        </template>
        <v-list-item-title>Escritores</v-list-item-title>
      </v-list-item>

      <v-list-item link href="/dashboard/galeria">
        <template v-slot:prepend>
          <i class="fas fa-images"></i>
        </template>
        <v-list-item-title>Galeria</v-list-item-title>
      </v-list-item>

      <v-list-item link href="/dashboard/tags">
        <template v-slot:prepend>
          <i class="fas fa-tags"></i>
        </template>
        <v-list-item-title>Tags</v-list-item-title>
      </v-list-item>

      <v-divider></v-divider>

      <v-list-item link href="/dashboard/configuracoes">
        <template v-slot:prepend>
          <i class="fas fa-cog"></i>
        </template>
        <v-list-item-title>Configurações</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<style scoped>
.v-list-item {
  align-items: center;
}

:deep(.v-list-item__prepend) {
  margin-inline-end: 12px;
}

:deep(.v-list-item__prepend i) {
  font-size: 20px;
  color: #666;
}

:deep(.v-list-item--active .v-list-item__prepend i) {
  color: #1976d2;
}
</style>
