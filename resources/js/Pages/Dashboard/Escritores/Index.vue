<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { Head, router } from '@inertiajs/vue3';
import DashboardSidebar from '@/Components/DashboardSidebar.vue';
import DashboardAppBar from '@/Components/DashboardAppBar.vue';
import DashboardFooter from '@/Components/DashboardFooter.vue';

const drawer = ref(true);
const loading = ref(false);
const writers = ref([]);
const search = ref('');
const page = ref(1);
const perPage = ref(10);
const totalItems = ref(0);

const API_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:3001/api';

const headers = [
  { title: 'ID', key: 'int_Id', sortable: true },
  { title: 'Nome', key: 'vchr_Nome', sortable: true },
  { title: 'Nick', key: 'vchr_Nick', sortable: true },
  { title: 'Cargo', key: 'vchr_Cargo', sortable: true },
  { title: 'Status', key: 'bool_Enable', sortable: true },
  { title: 'Criado em', key: 'created_at', sortable: true },
  { title: 'Ações', key: 'actions', sortable: false, align: 'end' },
];

const filteredWriters = computed(() => {
  if (!search.value) return writers.value;
  
  const searchLower = search.value.toLowerCase();
  return writers.value.filter(writer => 
    writer.vchr_Nome?.toLowerCase().includes(searchLower) ||
    writer.vchr_Nick?.toLowerCase().includes(searchLower) ||
    writer.vchr_Cargo?.toLowerCase().includes(searchLower)
  );
});

const fetchWriters = async () => {
  loading.value = true;
  try {
    const response = await axios.get(`${API_URL}/writers`, {
      params: {
        page: page.value,
        perPage: perPage.value,
      }
    });
    
    console.log('Response data:', response.data);
    
    // O backend retorna WritersResource::collection($writers->items())
    // que é um array direto
    if (Array.isArray(response.data)) {
      writers.value = response.data;
      totalItems.value = response.data.length;
    } else if (response.data.data && Array.isArray(response.data.data)) {
      writers.value = response.data.data;
      totalItems.value = response.data.total || response.data.data.length;
    } else {
      console.error('Formato de resposta inesperado:', response.data);
      writers.value = [];
    }
    
    console.log('Writers loaded:', writers.value.length);
  } catch (error) {
    console.error('Erro ao buscar escritores:', error);
    console.error('Error details:', error.response?.data);
    alert('Erro ao carregar escritores');
  } finally {
    loading.value = false;
  }
};

const criar = () => {
  router.visit('/dashboard/escritores/criar');
};

const editar = (item) => {
  router.visit(`/dashboard/escritores/editar/${item.int_Id}`);
};

const excluir = async (item) => {
  if (!confirm(`Tem certeza que deseja excluir o escritor "${item.vchr_Nome}"?`)) {
    return;
  }

  try {
    await axios.delete(`${API_URL}/writers/${item.int_Id}`);
    alert('Escritor excluído com sucesso!');
    fetchWriters();
  } catch (error) {
    console.error('Erro ao excluir escritor:', error);
    alert('Erro ao excluir escritor');
  }
};

const toggleStatus = async (item) => {
  try {
    await axios.put(`${API_URL}/writers/${item.int_Id}`, {
      ...item,
      bool_Enable: !item.bool_Enable
    });
    fetchWriters();
  } catch (error) {
    console.error('Erro ao alterar status:', error);
    alert('Erro ao alterar status');
  }
};

const formatDate = (date) => {
  if (!date) return '-';
  return new Date(date).toLocaleDateString('pt-BR');
};

onMounted(() => {
  fetchWriters();
});
</script>

<template>
  <Head title="Gerenciar Escritores" />

  <v-app>
    <DashboardSidebar v-model="drawer" />

    <DashboardAppBar 
      title="Gerenciar Escritores"
      :breadcrumbs="['Dashboard', 'Escritores']"
      @toggle-drawer="drawer = !drawer"
    />

    <v-main>
      <v-container fluid>
        <v-card elevation="2">
          <v-card-title class="d-flex align-center pa-4">
            <v-icon class="me-2" color="primary">mdi-account-multiple</v-icon>
            <span class="text-h5">Escritores</span>
            <v-spacer></v-spacer>
            <v-btn color="primary" prepend-icon="mdi-plus" @click="criar">
              Novo Escritor
            </v-btn>
          </v-card-title>

          <v-divider></v-divider>

          <v-card-text>
            <v-row class="mb-4">
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="search"
                  prepend-inner-icon="mdi-magnify"
                  label="Buscar escritores"
                  variant="outlined"
                  density="compact"
                  hide-details
                  clearable
                ></v-text-field>
              </v-col>
            </v-row>

            <v-data-table
              :headers="headers"
              :items="filteredWriters"
              :loading="loading"
              :items-per-page="perPage"
              loading-text="Carregando escritores..."
              no-data-text="Nenhum escritor encontrado"
              class="elevation-1"
            >
              <template v-slot:item.vchr_Nome="{ item }">
                <div class="d-flex align-center py-2">
                  <v-avatar size="40" class="me-3" color="primary">
                    <v-img 
                      v-if="item.vchr_LinkFoto" 
                      :src="`/imagens/${item.vchr_LinkFoto}`"
                      cover
                    ></v-img>
                    <span v-else class="text-h6">{{ item.vchr_Nome.charAt(0).toUpperCase() }}</span>
                  </v-avatar>
                  <div>
                    <div class="font-weight-medium">{{ item.vchr_Nome }}</div>
                    <div v-if="item.vchr_LinkInta" class="text-caption text-grey">
                      <v-icon size="small">mdi-instagram</v-icon>
                      {{ item.vchr_LinkInta }}
                    </div>
                  </div>
                </div>
              </template>

              <template v-slot:item.vchr_Nick="{ item }">
                <v-chip size="small" color="purple" variant="tonal">
                  {{ item.vchr_Nick }}
                </v-chip>
              </template>

              <template v-slot:item.vchr_Cargo="{ item }">
                <span class="text-grey">{{ item.vchr_Cargo || '-' }}</span>
              </template>

              <template v-slot:item.bool_Enable="{ item }">
                <v-chip 
                  :color="item.bool_Enable ? 'success' : 'error'"
                  size="small"
                  @click="toggleStatus(item)"
                  style="cursor: pointer;"
                >
                  <v-icon start size="small">
                    {{ item.bool_Enable ? 'mdi-check-circle' : 'mdi-close-circle' }}
                  </v-icon>
                  {{ item.bool_Enable ? 'Ativo' : 'Inativo' }}
                </v-chip>
              </template>

              <template v-slot:item.created_at="{ item }">
                <span class="text-caption">{{ formatDate(item.created_at) }}</span>
              </template>

              <template v-slot:item.actions="{ item }">
                <div class="d-flex gap-1">
                  <v-tooltip text="Editar" location="top">
                    <template v-slot:activator="{ props }">
                      <v-btn
                        v-bind="props"
                        icon="mdi-pencil"
                        size="small"
                        variant="text"
                        color="primary"
                        @click="editar(item)"
                      ></v-btn>
                    </template>
                  </v-tooltip>

                  <v-tooltip text="Excluir" location="top">
                    <template v-slot:activator="{ props }">
                      <v-btn
                        v-bind="props"
                        icon="mdi-delete"
                        size="small"
                        variant="text"
                        color="error"
                        @click="excluir(item)"
                      ></v-btn>
                    </template>
                  </v-tooltip>
                </div>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-container>
    </v-main>

    <DashboardFooter />
  </v-app>
</template>

<style scoped>
.v-data-table {
  border: 1px solid #e0e0e0;
}
</style>
