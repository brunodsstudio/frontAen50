<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(['update:modelValue']);

const drawer = ref(props.modelValue);

const toggleDrawer = () => {
  drawer.value = !drawer.value;
  emit('update:modelValue', drawer.value);
};
</script>

<template>
  <v-navigation-drawer v-model="drawer" app>
    <v-list>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h6">
            <Link href="/">
              <ApplicationLogo class="h-10 w-10 fill-current text-gray-500" />
            </Link>
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list-item link :href="route('dashboard')">
        <v-list-item-icon>
          <i class="fas fa-tachometer-alt"></i>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Dashboard</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item link href="/dashboard/eventos" :active="$page.component === 'Eventos'">
        <v-list-item-icon>
          <i class="fas fa-calendar-star"></i>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Eventos</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item link href="/dashboard/materias">
        <v-list-item-icon>
          <i class="fas fa-newspaper"></i>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Matérias</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item link href="/dashboard/galeria">
        <v-list-item-icon>
          <i class="fas fa-images"></i>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Galeria</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item link href="/dashboard/tags">
        <v-list-item-icon>
          <i class="fas fa-tags"></i>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Tags</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list-item link href="/dashboard/configuracoes">
        <v-list-item-icon>
          <i class="fas fa-cog"></i>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Configurações</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<style scoped>
.v-list-item-icon i {
  font-size: 20px;
  color: #666;
}

.v-list-item--active .v-list-item-icon i {
  color: #1976d2;
}
</style>
