<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { Head, router } from '@inertiajs/vue3';
import DashboardSidebar from '@/Components/DashboardSidebar.vue';
import DashboardAppBar from '@/Components/DashboardAppBar.vue';
import DashboardFooter from '@/Components/DashboardFooter.vue';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import '@ckeditor/ckeditor5-build-classic/build/translations/pt-br';

const ckeditor = Ckeditor;

const props = defineProps({
  id: {
    type: [String, Number],
    default: null
  }
});

const drawer = ref(true);
const loading = ref(false);
const saving = ref(false);
const uploadingAvatar = ref(false);
const cargos = ref([]);
const avatarFile = ref(null);
const avatarPreview = ref('');

const formData = ref({
  vchr_Nome: '',
  vchr_Nick: '',
  long_Card: '',
  bool_Enable: true,
  vchr_LinkFoto: '',
  vchr_LinkInta: '',
  vchr_Cargo: '',
});

const errors = ref({});

const API_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:3001/api';

const isEditMode = computed(() => !!props.id);
const pageTitle = computed(() => isEditMode.value ? 'Editar Escritor' : 'Novo Escritor');

// Configuração do CKEditor
const editor = ClassicEditor;
const editorConfig = {
  language: 'pt-br',
  toolbar: [
    'heading', '|',
    'bold', 'italic', 'underline', '|',
    'link', 'bulletedList', 'numberedList', '|',
    'blockQuote', 'insertTable', '|',
    'undo', 'redo'
  ],
  heading: {
    options: [
      { model: 'paragraph', title: 'Parágrafo', class: 'ck-heading_paragraph' },
      { model: 'heading1', view: 'h1', title: 'Título 1', class: 'ck-heading_heading1' },
      { model: 'heading2', view: 'h2', title: 'Título 2', class: 'ck-heading_heading2' },
      { model: 'heading3', view: 'h3', title: 'Título 3', class: 'ck-heading_heading3' }
    ]
  }
};

const fetchCargos = async () => {
  try {
    const response = await axios.get(`${API_URL}/writers`);
    const allWriters = Array.isArray(response.data) ? response.data : (response.data.data || []);
    
    // Extrair cargos únicos
    const uniqueCargos = [...new Set(allWriters
      .map(w => w.vchr_Cargo)
      .filter(c => c && c.trim() !== '')
    )];
    
    cargos.value = uniqueCargos.sort();
  } catch (error) {
    console.error('Erro ao buscar cargos:', error);
  }
};

const fetchWriter = async () => {
  if (!props.id) return;
  
  loading.value = true;
  try {
    const response = await axios.get(`${API_URL}/writers/${props.id}`);
    const writer = response.data.data || response.data;
    
    formData.value = {
      vchr_Nome: writer.vchr_Nome || '',
      vchr_Nick: writer.vchr_Nick || '',
      long_Card: writer.long_Card || '',
      bool_Enable: writer.bool_Enable ?? true,
      vchr_LinkFoto: writer.vchr_LinkFoto || '',
      vchr_LinkInta: writer.vchr_LinkInta || '',
      vchr_Cargo: writer.vchr_Cargo || '',
    };
    
    if (writer.vchr_LinkFoto) {
      avatarPreview.value = `/imagens/${writer.vchr_LinkFoto}`;
    }
  } catch (error) {
    console.error('Erro ao buscar escritor:', error);
    alert('Erro ao carregar dados do escritor');
  } finally {
    loading.value = false;
  }
};

const onFileChange = (event) => {
  const file = event.target.files?.[0];
  if (!file) return;
  
  avatarFile.value = file;
  avatarPreview.value = URL.createObjectURL(file);
};

const uploadAvatar = async () => {
  if (!avatarFile.value) return null;
  
  uploadingAvatar.value = true;
  try {
    const formDataUpload = new FormData();
    formDataUpload.append('avatar', avatarFile.value);
    
    // Ajuste aqui conforme seu endpoint de upload
    const response = await axios.post(`${API_URL}/upload/avatar`, formDataUpload, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    
    return response.data.filename || response.data.path;
  } catch (error) {
    console.error('Erro ao fazer upload do avatar:', error);
    // Se não houver endpoint específico, gerar nome baseado no nick
    const timestamp = Date.now();
    const ext = avatarFile.value.name.split('.').pop();
    return `${formData.value.vchr_Nick || 'avatar'}_${timestamp}.${ext}`;
  } finally {
    uploadingAvatar.value = false;
  }
};

const validate = () => {
  errors.value = {};
  
  if (!formData.value.vchr_Nome?.trim()) {
    errors.value.vchr_Nome = 'Nome é obrigatório';
  }
  
  if (!formData.value.vchr_Nick?.trim()) {
    errors.value.vchr_Nick = 'Nick é obrigatório';
  } else if (formData.value.vchr_Nick.length < 4 || formData.value.vchr_Nick.length > 50) {
    errors.value.vchr_Nick = 'Nick deve ter entre 4 e 50 caracteres';
  } else if (!/^[a-zA-Z0-9_-]+$/.test(formData.value.vchr_Nick)) {
    errors.value.vchr_Nick = 'Nick deve conter apenas letras, números, hífen ou underline';
  }
  
  return Object.keys(errors.value).length === 0;
};

const salvar = async () => {
  if (!validate()) {
    alert('Por favor, corrija os erros no formulário');
    return;
  }
  
  saving.value = true;
  
  try {
    let avatarFilename = formData.value.vchr_LinkFoto;
    
    // Upload do avatar se houver arquivo novo
    if (avatarFile.value) {
      const uploaded = await uploadAvatar();
      if (uploaded) {
        avatarFilename = uploaded;
      }
    }
    
    const dataToSend = {
      ...formData.value,
      vchr_LinkFoto: avatarFilename,
    };
    
    if (isEditMode.value) {
      await axios.put(`${API_URL}/writers/${props.id}`, dataToSend);
      alert('Escritor atualizado com sucesso!');
    } else {
      const response = await axios.post(`${API_URL}/writers`, dataToSend);
      alert('Escritor criado com sucesso!');
      const newId = response.data.data?.int_Id || response.data.int_Id;
      if (newId) {
        router.visit(`/dashboard/escritores/editar/${newId}`);
      }
    }
  } catch (error) {
    console.error('Erro ao salvar escritor:', error);
    const errorMsg = error.response?.data?.message || error.response?.data?.error || 'Erro ao salvar escritor';
    alert(errorMsg);
  } finally {
    saving.value = false;
  }
};

const voltar = () => {
  router.visit('/dashboard/escritores');
};

onMounted(() => {
  fetchCargos();
  if (props.id) {
    fetchWriter();
  }
});
</script>

<template>
  <Head :title="pageTitle" />

  <v-app>
    <DashboardSidebar v-model="drawer" />

    <DashboardAppBar 
      :title="pageTitle"
      :breadcrumbs="['Dashboard', 'Escritores', isEditMode ? 'Editar' : 'Criar']"
      @toggle-drawer="drawer = !drawer"
    />

    <v-main>
      <v-container fluid>
        <v-card elevation="2">
          <v-card-title class="d-flex align-center bg-primary text-white pa-4">
            <v-btn
              icon="mdi-arrow-left"
              variant="text"
              @click="voltar"
              class="me-2"
            ></v-btn>
            <v-icon class="me-2">mdi-account-edit</v-icon>
            <span>{{ pageTitle }}</span>
            <v-spacer></v-spacer>
            <v-btn
              color="white"
              variant="outlined"
              prepend-icon="mdi-content-save"
              :loading="saving"
              @click="salvar"
            >
              {{ isEditMode ? 'Atualizar' : 'Criar' }}
            </v-btn>
          </v-card-title>

          <v-divider></v-divider>

          <v-card-text class="pa-6">
            <v-row>
              <!-- Coluna Principal -->
              <v-col cols="12" md="8">
                <v-row>
                  <!-- Nome -->
                  <v-col cols="12">
                    <v-text-field
                      v-model="formData.vchr_Nome"
                      label="Nome Completo *"
                      variant="outlined"
                      :error-messages="errors.vchr_Nome"
                      prepend-inner-icon="mdi-account"
                      counter="100"
                    ></v-text-field>
                  </v-col>

                  <!-- Nick -->
                  <v-col cols="12" md="6">
                    <v-text-field
                      v-model="formData.vchr_Nick"
                      label="Nick/Apelido *"
                      variant="outlined"
                      :error-messages="errors.vchr_Nick"
                      prepend-inner-icon="mdi-at"
                      counter="50"
                      hint="Mínimo 4 caracteres (A-Z, 0-9, -, _)"
                      persistent-hint
                    ></v-text-field>
                  </v-col>

                  <!-- Cargo -->
                  <v-col cols="12" md="6">
                    <v-combobox
                      v-model="formData.vchr_Cargo"
                      label="Cargo/Função"
                      variant="outlined"
                      :items="cargos"
                      prepend-inner-icon="mdi-briefcase"
                      clearable
                      hint="Digite ou selecione um cargo existente"
                      persistent-hint
                    ></v-combobox>
                  </v-col>

                  <!-- Instagram -->
                  <v-col cols="12" md="6">
                    <v-text-field
                      v-model="formData.vchr_LinkInta"
                      label="Link Instagram"
                      variant="outlined"
                      prepend-inner-icon="mdi-instagram"
                      placeholder="@usuario"
                      counter="50"
                    ></v-text-field>
                  </v-col>

                  <!-- Status -->
                  <v-col cols="12" md="6">
                    <v-switch
                      v-model="formData.bool_Enable"
                      label="Escritor Ativo"
                      color="success"
                      hint="Define se o escritor está ativo no sistema"
                      persistent-hint
                    ></v-switch>
                  </v-col>

                  <!-- Biografia com CKEditor -->
                  <v-col cols="12">
                    <v-card variant="outlined">
                      <v-card-title class="bg-grey-lighten-4">
                        <v-icon class="me-2">mdi-text-box</v-icon>
                        Biografia (Long Card)
                      </v-card-title>
                      <v-card-text class="pa-4">
                        <div class="ck-editor-wrapper">
                          <ckeditor
                            v-model="formData.long_Card"
                            :editor="editor"
                            :config="editorConfig"
                          ></ckeditor>
                        </div>
                        <div class="text-caption text-grey mt-2">
                          Biografia completa do escritor com formatação HTML
                        </div>
                      </v-card-text>
                    </v-card>
                  </v-col>
                </v-row>
              </v-col>

              <!-- Coluna Lateral - Avatar -->
              <v-col cols="12" md="4">
                <v-card variant="outlined" class="sticky-card">
                  <v-card-title class="bg-purple-lighten-5">
                    <v-icon class="me-2">mdi-camera</v-icon>
                    Avatar do Escritor
                  </v-card-title>
                  <v-card-text class="pa-4 text-center">
                    <!-- Preview do Avatar -->
                    <v-avatar 
                      size="200" 
                      class="mb-4 elevation-4"
                      color="grey-lighten-3"
                    >
                      <v-img 
                        v-if="avatarPreview" 
                        :src="avatarPreview"
                        cover
                      ></v-img>
                      <v-icon v-else size="100" color="grey">mdi-account</v-icon>
                    </v-avatar>

                    <!-- Botão de Upload -->
                    <v-btn
                      color="primary"
                      block
                      prepend-icon="mdi-upload"
                      @click="$refs.fileInput.click()"
                      :loading="uploadingAvatar"
                    >
                      Selecionar Avatar
                    </v-btn>
                    
                    <input
                      ref="fileInput"
                      type="file"
                      accept="image/jpeg,image/png,image/jpg"
                      style="display: none"
                      @change="onFileChange"
                    />

                    <div v-if="formData.vchr_LinkFoto" class="mt-3">
                      <v-text-field
                        v-model="formData.vchr_LinkFoto"
                        label="Nome do arquivo"
                        variant="outlined"
                        density="compact"
                        readonly
                        hint="Arquivo atual no servidor"
                        persistent-hint
                      ></v-text-field>
                    </div>

                    <v-alert
                      type="info"
                      variant="tonal"
                      density="compact"
                      class="mt-4 text-left"
                    >
                      <div class="text-caption">
                        <strong>Formato:</strong> imagens.{foto}.jpg<br>
                        <strong>Recomendado:</strong> 500x500px<br>
                        <strong>Tipos:</strong> JPG, PNG
                      </div>
                    </v-alert>
                  </v-card-text>
                </v-card>

                <!-- Info de Data (apenas em edição) -->
                <v-card v-if="isEditMode" variant="outlined" class="mt-4">
                  <v-card-title class="bg-blue-lighten-5">
                    <v-icon class="me-2">mdi-information</v-icon>
                    Informações
                  </v-card-title>
                  <v-card-text class="pa-4">
                    <div class="text-caption">
                      <strong>ID:</strong> {{ props.id }}<br>
                      <strong>Criado em:</strong> {{ new Date().toLocaleDateString('pt-BR') }}
                    </div>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions class="pa-4">
            <v-btn
              variant="outlined"
              prepend-icon="mdi-arrow-left"
              @click="voltar"
            >
              Voltar
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
              color="primary"
              prepend-icon="mdi-content-save"
              :loading="saving"
              @click="salvar"
            >
              {{ isEditMode ? 'Atualizar Escritor' : 'Criar Escritor' }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-container>
    </v-main>

    <DashboardFooter />
  </v-app>
</template>

<style scoped>
.ck-editor-wrapper {
  border: 1px solid #e0e0e0;
  border-radius: 4px;
}

.ck-editor-wrapper :deep(.ck-editor__editable) {
  min-height: 300px;
}

.sticky-card {
  position: sticky;
  top: 80px;
}
</style>
