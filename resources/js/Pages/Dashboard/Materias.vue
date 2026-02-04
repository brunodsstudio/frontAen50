<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { Head, router } from '@inertiajs/vue3';
import DashboardSidebar from '@/Components/DashboardSidebar.vue';
import DashboardAppBar from '@/Components/DashboardAppBar.vue';
import DashboardFooter from '@/Components/DashboardFooter.vue';

// Estados
const drawer = ref(true);
const materias = ref([]);
const loading = ref(false);
const search = ref('');
const filterStatus = ref(null);
const filterAutor = ref('');
const autores = ref([]);
const page = ref(1);
const perPage = ref(10);
const totalItems = ref(0);
const dialogDelete = ref(false);
const itemToDelete = ref(null);

const headers = [
  { title: 'ID', key: 'id', sortable: true, align: 'start', width: '80' },
  { title: 'Título', key: 'vchr_titulo', sortable: true, align: 'start' },
  { title: 'Autor', key: 'vchr_autor', sortable: true, align: 'start', width: '150' },
  { title: 'Categoria', key: 'area_nome', sortable: true, align: 'start', width: '120' },
  { title: 'Data', key: 'created_at', sortable: true, align: 'start', width: '150' },
  { title: 'Status', key: 'bool_onLine', sortable: true, align: 'center', width: '100' },
  { title: 'Ações', key: 'actions', sortable: false, align: 'center', width: '200' }
];

// API Base URL
const API_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:3001/api';

const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value));

// Métodos
const fetchMaterias = async () => {
  loading.value = true;
  try {
    const params = {
      page: page.value,
      perPage: perPage.value,
    };

    if (search.value) params.search = search.value;
    if (filterStatus.value !== null) params.onLine = filterStatus.value;
    if (filterAutor.value) params.autor = filterAutor.value;

    const response = await axios.get(`${API_URL}/materias`, { params });
    
    materias.value = response.data.data || response.data;
    totalItems.value = response.data.total || materias.value.length;
  } catch (error) {
    console.error('Erro ao buscar matérias:', error);
  } finally {
    loading.value = false;
  }
};

const fetchAutores = async () => {
  try {
    // Endpoint de autores pode não existir, usar as matérias para extrair autores únicos
    const response = await axios.get(`${API_URL}/materias?perPage=1000`);
    const materias = Array.isArray(response.data) ? response.data : (response.data.data || []);
    
    // Extrair autores únicos
    const autoresUnicos = [...new Set(materias.map(m => m.vchr_autor).filter(Boolean))];
    autores.value = autoresUnicos.map(autor => ({ vchr_autor: autor }));
  } catch (error) {
    console.error('Erro ao buscar autores:', error);
    autores.value = [];
  }
};

const createMateria = () => {
  router.visit('/dashboard/materias/criar');
};

const editMateria = (item) => {
  router.visit(`/dashboard/materias/editar/${item.id}`);
};

const openImagesDialog = (item) => {
  router.visit(`/dashboard/materias/${item.id}/imagens`);
};

const toggleOnline = async (item) => {
  try {
    const newStatus = !item.bool_onLine;
    await axios.patch(`${API_URL}/materias/${item.id}`, {
      bool_onLine: newStatus
    });
    
    item.bool_onLine = newStatus;
  } catch (error) {
    console.error('Erro ao alterar status:', error);
    alert('Erro ao alterar status da matéria');
  }
};

const deleteItem = (item) => {
  itemToDelete.value = item;
  dialogDelete.value = true;
};

const deleteItemConfirm = async () => {
  if (itemToDelete.value) {
    try {
      await axios.delete(`${API_URL}/materias/${itemToDelete.value.id}`);
      await fetchMaterias();
      closeDelete();
    } catch (error) {
      console.error('Erro ao deletar matéria:', error);
      alert('Erro ao deletar matéria');
    }
  }
};

const closeDelete = () => {
  dialogDelete.value = false;
  setTimeout(() => {
    itemToDelete.value = null;
  }, 300);
};

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return date.toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  });
};

const clearFilters = () => {
  search.value = '';
  filterStatus.value = null;
  filterAutor.value = '';
  page.value = 1;
  fetchMaterias();
};

const changePage = (newPage) => {
  page.value = newPage;
  fetchMaterias();
};

const changePerPage = () => {
  page.value = 1;
  fetchMaterias();
};

// Debounce para busca
let searchTimeout;
const debounceSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    page.value = 1;
    fetchMaterias();
  }, 500);
};

onMounted(() => {
  fetchMaterias();
  fetchAutores();
});
</script>

<template>
  <Head title="Matérias" />

  <v-app>
    <!-- Navigation Drawer -->
    <DashboardSidebar v-model="drawer" />

    <!-- App Bar -->
    <DashboardAppBar 
      title="Gerenciamento de Matérias"
      :breadcrumbs="['Dashboard', 'Matérias']"
      @toggle-drawer="drawer = !drawer"
    />

    <!-- Main Content -->
    <v-main>
      <v-container fluid>
        <v-card>
          <v-card-title class="d-flex align-center pe-2">
            <v-icon icon="mdi-newspaper" class="me-2"></v-icon>
            Matérias
            
            <v-spacer></v-spacer>

            <v-btn
              color="primary"
              prepend-icon="mdi-plus"
              @click="createMateria"
            >
              Nova Matéria
            </v-btn>
          </v-card-title>

          <v-divider></v-divider>

          <!-- Filtros -->
          <v-card-text>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="search"
                  density="compact"
                  label="Buscar por título"
                  prepend-inner-icon="mdi-magnify"
                  variant="outlined"
                  hide-details
                  @input="debounceSearch"
                ></v-text-field>
              </v-col>

              <v-col cols="12" md="3">
                <v-select
                  v-model="filterAutor"
                  :items="autores"
                  item-title="vchr_autor"
                  item-value="vchr_autor"
                  label="Filtrar por autor"
                  density="compact"
                  variant="outlined"
                  hide-details
                  clearable
                  @update:model-value="fetchMaterias"
                ></v-select>
              </v-col>

              <v-col cols="12" md="3">
                <v-select
                  v-model="filterStatus"
                  :items="[
                    { title: 'Online', value: true },
                    { title: 'Offline', value: false }
                  ]"
                  label="Filtrar por status"
                  density="compact"
                  variant="outlined"
                  hide-details
                  clearable
                  @update:model-value="fetchMaterias"
                ></v-select>
              </v-col>

              <v-col cols="12" md="2">
                <v-btn
                  color="grey"
                  variant="outlined"
                  block
                  @click="clearFilters"
                >
                  <v-icon start>mdi-filter-off</v-icon>
                  Limpar
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>

          <v-divider></v-divider>

          <!-- Loading -->
          <div v-if="loading" class="text-center pa-8">
            <v-progress-circular
              indeterminate
              color="primary"
              size="64"
            ></v-progress-circular>
          </div>

          <!-- Tabela de Matérias -->
          <v-data-table
            v-else
            :headers="headers"
            :items="materias"
            :items-per-page="perPage"
            hide-default-footer
            class="elevation-0"
          >
            <template v-slot:item.vchr_titulo="{ item }">
              <div class="text-truncate" style="max-width: 400px;">
                {{ item.vchr_titulo }}
              </div>
            </template>

            <template v-slot:item.created_at="{ item }">
              {{ formatDate(item.created_at) }}
            </template>

            <template v-slot:item.bool_onLine="{ item }">
              <v-chip
                :color="item.bool_onLine ? 'success' : 'error'"
                size="small"
                variant="flat"
              >
                {{ item.bool_onLine ? 'Online' : 'Offline' }}
              </v-chip>
            </template>

            <template #item.actions="{ item }">
              <div class="d-flex justify-center align-center action-buttons">
                <v-tooltip text="Editar">
                  <template v-slot:activator="{ props }">
                    <v-btn
                      v-bind="props"
                      size="small"
                      variant="flat"
                      color="blue-lighten-1"
                      @click="editMateria(item)"
                      class="me-2"
                    >
                      <v-icon size="small">mdi-pencil</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>

                <v-tooltip :text="item.bool_onLine ? 'Colocar Offline' : 'Colocar Online'">
                  <template v-slot:activator="{ props }">
                    <v-btn
                      v-bind="props"
                      size="small"
                      variant="flat"
                      :color="item.bool_onLine ? 'orange-lighten-1' : 'green-lighten-1'"
                      @click="toggleOnline(item)"
                      class="me-2"
                    >
                      <v-icon size="small">
                        {{ item.bool_onLine ? 'mdi-eye-off' : 'mdi-eye' }}
                      </v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>

                <v-tooltip text="Gerenciar Imagens">
                  <template v-slot:activator="{ props }">
                    <v-btn
                      v-bind="props"
                      size="small"
                      variant="flat"
                      color="purple-lighten-1"
                      @click="openImagesDialog(item)"
                      class="me-2"
                    >
                      <v-icon size="small">mdi-image-multiple</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>

                <v-tooltip text="Excluir">
                  <template v-slot:activator="{ props }">
                    <v-btn
                      v-bind="props"
                      size="small"
                      variant="flat"
                      color="red-lighten-1"
                      @click="deleteItem(item)"
                      class="me-2"
                    >
                      <v-icon size="small">mdi-delete</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>
              </div>
            </template>

            <template v-slot:no-data>
              <div class="text-center pa-8">
                <v-icon size="64" color="grey-lighten-1">mdi-newspaper-remove</v-icon>
                <p class="text-h6 mt-4 text-grey">Nenhuma matéria encontrada</p>
              </div>
            </template>
          </v-data-table>

          <!-- Paginação -->
          <v-divider></v-divider>
          <v-card-text>
            <v-row align="center" justify="space-between">
              <v-col cols="auto">
                <div class="text-body-2 text-grey">
                  Mostrando {{ (page - 1) * perPage + 1 }} até {{ Math.min(page * perPage, totalItems) }} de {{ totalItems }} itens
                </div>
              </v-col>
              <v-col cols="auto">
                <v-row align="center" class="ga-2">
                  <v-col cols="auto">
                    <v-select
                      v-model="perPage"
                      :items="[10, 25, 50, 100]"
                      label="Itens por página"
                      density="compact"
                      variant="outlined"
                      hide-details
                      style="width: 150px"
                      @update:model-value="changePerPage"
                    ></v-select>
                  </v-col>
                  <v-col cols="auto">
                    <v-btn
                      icon="mdi-chevron-left"
                      size="small"
                      variant="outlined"
                      :disabled="page === 1"
                      @click="changePage(page - 1)"
                    ></v-btn>
                  </v-col>
                  <v-col cols="auto">
                    <span class="text-body-2">Página {{ page }} de {{ totalPages }}</span>
                  </v-col>
                  <v-col cols="auto">
                    <v-btn
                      icon="mdi-chevron-right"
                      size="small"
                      variant="outlined"
                      :disabled="page >= totalPages"
                      @click="changePage(page + 1)"
                    ></v-btn>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>

        <!-- Dialog de Confirmação de Delete -->
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Confirmar Exclusão</v-card-title>
            <v-card-text>
              Tem certeza que deseja excluir a matéria "{{ itemToDelete?.vchr_titulo }}"?
              Esta ação não pode ser desfeita.
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="grey" variant="text" @click="closeDelete">Cancelar</v-btn>
              <v-btn color="error" variant="elevated" @click="deleteItemConfirm">Excluir</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-container>
    </v-main>

    <!-- Footer -->
    <DashboardFooter />
  </v-app>
</template>

<style scoped>
.v-card-title {
  background-color: #f5f5f5;
}

.action-buttons .v-btn {
  min-width: 36px !important;
  height: 36px !important;
}

.action-buttons :deep(.v-btn .v-icon) {
  color: #ffffff !important;
  opacity: 1 !important;
}

.action-buttons :deep(.v-btn i) {
  color: #ffffff !important;
  opacity: 1 !important;
}
</style>
