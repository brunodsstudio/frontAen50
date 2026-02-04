<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import DashboardSidebar from '@/Components/DashboardSidebar.vue';
import DashboardAppBar from '@/Components/DashboardAppBar.vue';
import DashboardFooter from '@/Components/DashboardFooter.vue';

// Estados
const drawer = ref(true);
const eventos = ref([]);
const tipos_atracao = ref([]);
const tipos_concurso = ref([]);
const loading = ref(false);
const dialog = ref(false);
const dialogView = ref(false);
const dialogDelete = ref(false);
const search = ref('');
const itemToDelete = ref(null);
const editedIndex = ref(-1);

const defaultItem = {
  nome: '',
  descricao: '',
  realizacao: '',
  link_foto: '',
  link_logo: '',
  link_site: '',
  link_instagram: '',
  link_video: '',
  link_x: '',
  link_tiktok: ''
};

const editedItem = ref({ ...defaultItem });
const viewItem = ref(null);

const formTitle = computed(() => {
  return editedIndex.value === -1 ? 'Novo Evento' : 'Editar Evento';
});

const headers = [
  { title: 'ID', key: 'id', sortable: true, align: 'start' },
  { title: 'Nome', key: 'nome', sortable: true, align: 'start' },
  { title: 'Realização', key: 'realizacao', sortable: true, align: 'start' },
  { title: 'Ações', key: 'actions', sortable: false, align: 'center', width: '150px' }
];

const statusOptions = [
  { value: 'rascunho', title: 'Rascunho' },
  { value: 'publicado', title: 'Publicado' },
  { value: 'cancelado', title: 'Cancelado' }
];

const ufOptions = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

// API Base URL
const API_URL = 'http://localhost:3001/api/events';

// Axios interceptor para adicionar token JWT
axios.interceptors.request.use(config => {
  const token = localStorage.getItem('jwt_token');
  if (token && ['post', 'delete', 'patch', 'put'].includes(config.method)) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Métodos
const fetchEventos = async () => {
  loading.value = true;
  try {
    const response = await axios.get(API_URL);
    // A API retorna um array diretamente, não um objeto com data
    eventos.value = Array.isArray(response.data) ? response.data : (response.data.data || []);
    console.log('Eventos carregados:', eventos.value);
  } catch (error) {
    console.error('Erro ao buscar eventos:', error);
    alert('Erro ao carregar eventos: ' + (error.response?.data?.message || error.message));
  } finally {
    loading.value = false;
  }
};

const fetchTiposAtracao = async () => {
  try {
    const response = await axios.get(`${API_URL}/atracoes`);
    tipos_atracao.value = Array.isArray(response.data) ? response.data : (response.data.data || []);
  } catch (error) {
    console.error('Erro ao buscar tipos de atração:', error);
  }
};

const fetchTiposConcurso = async () => {
  try {
    const response = await axios.get(`${API_URL}/concursos`);
    tipos_concurso.value = Array.isArray(response.data) ? response.data : (response.data.data || []);
  } catch (error) {
    console.error('Erro ao buscar tipos de concurso:', error);
  }
};

const editItem = (item) => {
  editedIndex.value = eventos.value.indexOf(item);
  editedItem.value = {
    ...item,
    agendas: item.agendas || [],
    atracoes_ids: item.atracoes?.map(a => a.id) || [],
    concursos_ids: item.concursos?.map(c => c.id) || []
  };
  dialog.value = true;
};

const deleteItem = (item) => {
  itemToDelete.value = item;
  dialogDelete.value = true;
};

const deleteItemConfirm = async () => {
  if (itemToDelete.value) {
    try {
      await axios.delete(`${API_URL}/${itemToDelete.value.id}`);
      await fetchEventos();
      closeDelete();
    } catch (error) {
      console.error('Erro ao deletar evento:', error);
      alert('Erro ao deletar evento');
    }
  }
};

const close = () => {
  dialog.value = false;
  setTimeout(() => {
    editedItem.value = { ...defaultItem };
    editedIndex.value = -1;
  }, 300);
};

const closeDelete = () => {
  dialogDelete.value = false;
  setTimeout(() => {
    itemToDelete.value = null;
  }, 300);
};

const save = async () => {
  try {
    const payload = { ...editedItem.value };
    
    if (editedIndex.value > -1) {
      // Editar
      await axios.patch(`${API_URL}/${payload.id}`, payload);
    } else {
      // Criar
      await axios.post(API_URL, payload);
    }
    
    await fetchEventos();
    close();
  } catch (error) {
    console.error('Erro ao salvar evento:', error);
    alert('Erro ao salvar evento');
  }
};

const viewItemDetails = (item) => {
  viewItem.value = item;
  dialogView.value = true;
};

const closeView = () => {
  dialogView.value = false;
  viewItem.value = null;
};

const addAgenda = () => {
  if (!editedItem.value.agendas) {
    editedItem.value.agendas = [];
  }
  editedItem.value.agendas.push({
    data_hora: '',
    titulo: '',
    descricao: ''
  });
};

const removeAgenda = (index) => {
  editedItem.value.agendas.splice(index, 1);
};

onMounted(() => {
  fetchEventos();
  fetchTiposAtracao();
  fetchTiposConcurso();
});
</script>

<template>
  <Head title="Eventos GEEK" />

  <v-app>
    <!-- Navigation Drawer -->
    <DashboardSidebar v-model="drawer" />

    <!-- App Bar -->
    <DashboardAppBar 
      title="My Application"
      :breadcrumbs="['Dashboard', 'Eventos']"
      @toggle-drawer="drawer = !drawer"
    />

    <!-- Main Content -->
    <v-main>
      <v-container fluid>
        <v-card>
        <v-card-title class="d-flex align-center pe-2">
          <v-icon icon="mdi-calendar-star" class="me-2"></v-icon>
          Eventos GEEK
          
          <v-spacer></v-spacer>

          <v-text-field
            v-model="search"
            density="compact"
            label="Buscar"
            prepend-inner-icon="mdi-magnify"
            variant="solo-filled"
            flat
            hide-details
            single-line
            class="me-2"
            style="max-width: 300px"
          ></v-text-field>

          <v-btn
            color="primary"
            prepend-icon="mdi-plus"
            @click="dialog = true"
          >
            Novo Evento
          </v-btn>
        </v-card-title>

        <v-divider></v-divider>

        <v-data-table
          :headers="headers"
          :items="eventos"
          :search="search"
          :loading="loading"
          loading-text="Carregando eventos..."
          items-per-page="10"
        >
          <template v-slot:item.status="{ item }">
            <v-chip
              :color="item.status === 'publicado' ? 'success' : item.status === 'cancelado' ? 'error' : 'warning'"
              size="small"
            >
              {{ item.status }}
            </v-chip>
          </template>

          <template #item.actions="{ item }">
            <div class="d-flex justify-center align-center action-buttons">
              <v-btn
                size="small"
                variant="flat"
                color="blue-lighten-1"
                @click="viewItemDetails(item)"
                class="mx-1"
              >
                <i class="fas fa-eye"></i>
              </v-btn>
              
              <v-btn
                size="small"
                variant="flat"
                color="green-lighten-1"
                @click="editItem(item)"
                class="mx-1"
              >
                <i class="fas fa-edit"></i>
              </v-btn>
              
              <v-btn
                size="small"
                variant="flat"
                color="red-lighten-1"
                @click="deleteItem(item)"
                class="mx-1"
              >
                <i class="fas fa-trash-alt"></i>
              </v-btn>
            </div>
          </template>
        </v-data-table>
      </v-card>

      <!-- Dialog de Formulário -->
      <v-dialog v-model="dialog" max-width="900px" persistent>
        <v-card>
          <v-card-title>
            <span class="text-h5">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-form>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    v-model="editedItem.nome"
                    label="Nome*"
                    required
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-textarea
                    v-model="editedItem.descricao"
                    label="Descrição"
                    rows="3"
                  ></v-textarea>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.cidade"
                    label="Cidade*"
                    required
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-select
                    v-model="editedItem.uf"
                    :items="ufOptions"
                    label="UF*"
                    required
                  ></v-select>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.local"
                    label="Local"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.endereco"
                    label="Endereço"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.data_inicio"
                    label="Data Início*"
                    type="date"
                    required
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.data_fim"
                    label="Data Fim"
                    type="date"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.hora_inicio"
                    label="Hora Início"
                    type="time"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.hora_fim"
                    label="Hora Fim"
                    type="time"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                  <v-text-field
                    v-model.number="editedItem.capacidade_maxima"
                    label="Capacidade Máxima"
                    type="number"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                  <v-switch
                    v-model="editedItem.is_gratuito"
                    label="Gratuito"
                    color="primary"
                  ></v-switch>
                </v-col>

                <v-col cols="12" md="4">
                  <v-select
                    v-model="editedItem.status"
                    :items="statusOptions"
                    label="Status*"
                    required
                  ></v-select>
                </v-col>

                <v-col cols="12" md="6" v-if="!editedItem.is_gratuito">
                  <v-text-field
                    v-model.number="editedItem.preco_min"
                    label="Preço Mínimo"
                    type="number"
                    step="0.01"
                    prefix="R$"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6" v-if="!editedItem.is_gratuito">
                  <v-text-field
                    v-model.number="editedItem.preco_max"
                    label="Preço Máximo"
                    type="number"
                    step="0.01"
                    prefix="R$"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.organizador"
                    label="Organizador"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.contato_email"
                    label="Email de Contato"
                    type="email"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.contato_telefone"
                    label="Telefone de Contato"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editedItem.site_url"
                    label="Site URL"
                    type="url"
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    v-model="editedItem.imagem_capa"
                    label="URL da Imagem de Capa"
                    type="url"
                  ></v-text-field>
                </v-col>

                <!-- Atrações -->
                <v-col cols="12">
                  <v-select
                    v-model="editedItem.atracoes_ids"
                    :items="tipos_atracao"
                    item-title="nome"
                    item-value="id"
                    label="Atrações"
                    multiple
                    chips
                  >
                    <template v-slot:chip="{ item, props }">
                      <v-chip v-bind="props" closable>
                        {{ item.title }}
                      </v-chip>
                    </template>
                  </v-select>
                </v-col>

                <!-- Concursos -->
                <v-col cols="12">
                  <v-select
                    v-model="editedItem.concursos_ids"
                    :items="tipos_concurso"
                    item-title="nome"
                    item-value="id"
                    label="Concursos"
                    multiple
                    chips
                  >
                    <template v-slot:chip="{ item, props }">
                      <v-chip v-bind="props" closable>
                        {{ item.title }}
                      </v-chip>
                    </template>
                  </v-select>
                </v-col>

                <!-- Agendas -->
                <v-col cols="12">
                  <v-divider class="mb-4"></v-divider>
                  <div class="d-flex justify-space-between align-center mb-2">
                    <h3>Agendas</h3>
                    <v-btn
                      color="primary"
                      size="small"
                      prepend-icon="mdi-plus"
                      @click="addAgenda"
                    >
                      Adicionar Agenda
                    </v-btn>
                  </div>

                  <v-card
                    v-for="(agenda, index) in editedItem.agendas"
                    :key="index"
                    class="mb-3"
                    variant="outlined"
                  >
                    <v-card-text>
                      <v-row>
                        <v-col cols="12" md="4">
                          <v-text-field
                            v-model="agenda.data_hora"
                            label="Data/Hora"
                            type="datetime-local"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="8">
                          <v-text-field
                            v-model="agenda.titulo"
                            label="Título"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                          <v-textarea
                            v-model="agenda.descricao"
                            label="Descrição"
                            rows="2"
                          ></v-textarea>
                        </v-col>
                        <v-col cols="12" class="text-right">
                          <v-btn
                            color="error"
                            size="small"
                            @click="removeAgenda(index)"
                          >
                            Remover
                          </v-btn>
                        </v-col>
                      </v-row>
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey" variant="text" @click="close">
              Cancelar
            </v-btn>
            <v-btn color="primary" variant="elevated" @click="save">
              Salvar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Dialog de Visualização -->
      <v-dialog v-model="dialogView" max-width="800px">
        <v-card v-if="viewItem">
          <v-card-title class="text-h5">
            {{ viewItem.titulo }}
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="12" v-if="viewItem.imagem_capa">
                <v-img
                  :src="viewItem.imagem_capa"
                  height="200"
                  cover
                ></v-img>
              </v-col>

              <v-col cols="12" md="6">
                <strong>Cidade:</strong> {{ viewItem.cidade }} - {{ viewItem.uf }}
              </v-col>
              <v-col cols="12" md="6">
                <strong>Status:</strong>
                <v-chip
                  :color="viewItem.status === 'publicado' ? 'success' : viewItem.status === 'cancelado' ? 'error' : 'warning'"
                  size="small"
                  class="ml-2"
                >
                  {{ viewItem.status }}
                </v-chip>
              </v-col>

              <v-col cols="12">
                <strong>Descrição:</strong>
                <p>{{ viewItem.descricao }}</p>
              </v-col>

              <v-col cols="12" md="6">
                <strong>Data Início:</strong> {{ viewItem.data_inicio }}
              </v-col>
              <v-col cols="12" md="6">
                <strong>Data Fim:</strong> {{ viewItem.data_fim || 'N/A' }}
              </v-col>

              <v-col cols="12" md="6" v-if="viewItem.hora_inicio">
                <strong>Horário:</strong> {{ viewItem.hora_inicio }} - {{ viewItem.hora_fim || 'N/A' }}
              </v-col>

              <v-col cols="12" md="6" v-if="viewItem.local">
                <strong>Local:</strong> {{ viewItem.local }}
              </v-col>

              <v-col cols="12" v-if="viewItem.atracoes && viewItem.atracoes.length">
                <strong>Atrações:</strong>
                <v-chip
                  v-for="atracao in viewItem.atracoes"
                  :key="atracao.id"
                  class="ma-1"
                  size="small"
                >
                  {{ atracao.nome }}
                </v-chip>
              </v-col>

              <v-col cols="12" v-if="viewItem.concursos && viewItem.concursos.length">
                <strong>Concursos:</strong>
                <v-chip
                  v-for="concurso in viewItem.concursos"
                  :key="concurso.id"
                  class="ma-1"
                  size="small"
                  color="secondary"
                >
                  {{ concurso.nome }}
                </v-chip>
              </v-col>

              <v-col cols="12" v-if="viewItem.agendas && viewItem.agendas.length">
                <strong>Agendas:</strong>
                <v-timeline density="compact" class="mt-2">
                  <v-timeline-item
                    v-for="agenda in viewItem.agendas"
                    :key="agenda.id"
                    dot-color="primary"
                    size="small"
                  >
                    <div>
                      <strong>{{ agenda.titulo }}</strong>
                      <div class="text-caption">{{ agenda.data_hora }}</div>
                      <p class="text-body-2">{{ agenda.descricao }}</p>
                    </div>
                  </v-timeline-item>
                </v-timeline>
              </v-col>
            </v-row>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" variant="text" @click="closeView">
              Fechar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Dialog de Confirmação de Delete -->
      <v-dialog v-model="dialogDelete" max-width="500px">
        <v-card>
          <v-card-title class="text-h5">Confirmar Exclusão</v-card-title>
          <v-card-text>
            Tem certeza que deseja excluir este evento?
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

.action-buttons .v-btn i {
  color: white;
  font-size: 14px;
}

.action-buttons .v-btn:hover {
  opacity: 0.8;
}
</style>
