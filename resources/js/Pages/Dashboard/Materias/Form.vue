<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';
import { Head, router, usePage } from '@inertiajs/vue3';
import DashboardSidebar from '@/Components/DashboardSidebar.vue';
import DashboardAppBar from '@/Components/DashboardAppBar.vue';
import DashboardFooter from '@/Components/DashboardFooter.vue';
import FeaturedImageEditor from '@/Components/FeaturedImageEditor.vue';
import { useMateriaState } from '@/Composables/useMateriaState';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import '@ckeditor/ckeditor5-build-classic/build/translations/pt-br';

const ckeditor = Ckeditor;

// Props
const props = defineProps({
  id: {
    type: [String, Number],
    default: null
  }
});

// Estados
const drawer = ref(true);
const loading = ref(false);
const saving = ref(false);
const areas = ref([]);
const tags = ref([]);
const selectedTags = ref([]);
const activeTab = ref('conteudo');
const showHtmlDialog = ref(false);
const htmlCode = ref('');

// CKEditor
const editor = ClassicEditor;
const editorData = ref('');
const editorConfig = {
  toolbar: {
    items: [
      'heading', '|',
      'bold', 'italic', '|',
      'link', 'bulletedList', 'numberedList', '|',
      'blockQuote', 'insertTable', '|',
      'undo', 'redo'
    ]
  },
  language: {
    ui: 'pt-br',
    content: 'pt-br',
  },
  table: {
    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
  },
  link: {
    defaultProtocol: 'https://'
  }
};

// Estado da matéria
const { setMateriaId, setMateriaDados, getMateriaId } = useMateriaState();

// Formulário
const formData = ref({
  vchr_titulo: '',
  vchr_subtitulo: '',
  vchr_autor: '',
  int_id_area: null,
  txt_corpo: '',
  txt_lead: '',
  bool_onLine: false,
  bool_home: false,
  dt_publicacao: '',
  // Campos SEO
  seo_title: '',
  seo_description: '',
  seo_keywords: '',
  seo_slug: '',
  seo_canonical_url: '',
  seo_og_title: '',
  seo_og_description: '',
  seo_og_image: '',
  seo_og_type: 'article',
  // Imagem destacada (referência)
  int_id_imagem_destaque: null
});

// Validação
const errors = ref({});

const isEditMode = computed(() => !!props.id);
const pageTitle = computed(() => isEditMode.value ? 'Editar Matéria' : 'Nova Matéria');

// API Base URL
const API_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:3001/api';

// Métodos
const fetchAreas = async () => {
  try {
    const response = await axios.get(`${API_URL}/areas?perPage=100`);
    areas.value = response.data.data || response.data;
  } catch (error) {
    console.error('Erro ao buscar áreas:', error);
  }
};

const fetchTags = async () => {
  try {
    const response = await axios.get(`${API_URL}/materias/tags/summary`);
    // O endpoint summary retorna array de objetos {tag, count}
    const tagsData = response.data.data || response.data;
    if (Array.isArray(tagsData)) {
      tags.value = tagsData.map(item => ({
        id: item.tag,
        txt_nome: item.tag
      }));
    }
  } catch (error) {
    console.error('Erro ao buscar tags:', error);
    // Define lista vazia em caso de erro
    tags.value = [];
  }
};

const fetchMateria = async () => {
  if (!props.id) return;
  
  loading.value = true;
  try {
    const response = await axios.get(`${API_URL}/materias/${props.id}`);
    const materia = response.data.data || response.data;
    
    // Mapeamento de campos da API para o formulário
    formData.value.vchr_titulo = materia.title || materia.vchr_titulo || '';
    formData.value.vchr_subtitulo = materia.lide || materia.vchr_subtitulo || '';
    formData.value.vchr_autor = materia.author || materia.vchr_autor || '';
    formData.value.int_id_area = materia.area_id || materia.int_id_area || null;
    formData.value.txt_lead = materia.txt_lead || '';
    formData.value.bool_onLine = materia.on_line === 1 || materia.bool_onLine || false;
    formData.value.bool_home = materia.home === 1 || materia.bool_home || false;
    formData.value.dt_publicacao = materia.created_at || materia.dt_publicacao || '';
    
    // Campos SEO
    formData.value.seo_title = materia.seo_title || '';
    formData.value.seo_description = materia.seo_description || '';
    formData.value.seo_keywords = materia.seo_keywords || '';
    formData.value.seo_slug = materia.link_titulo || materia.seo_slug || '';
    formData.value.seo_canonical_url = materia.seo_canonical_url || '';
    formData.value.seo_og_title = materia.og_title || materia.seo_og_title || '';
    formData.value.seo_og_description = materia.og_description || materia.seo_og_description || '';
    formData.value.seo_og_image = materia.og_image || materia.seo_og_image || '';
    
    // Decodificar corpo se estiver em BASE64
    const corpo = materia.content || materia.txt_corpo;
    if (corpo) {
      try {
        const decoded = atob(corpo);
        editorData.value = decodeURIComponent(escape(decoded));
      } catch {
        editorData.value = corpo;
      }
    }
    
    // Tags - verifica se é array antes de mapear
    if (materia.tags) {
      if (Array.isArray(materia.tags)) {
        selectedTags.value = materia.tags.map(t => t.id || t);
      } else if (typeof materia.tags === 'string') {
        // Se tags for string separada por vírgulas
        selectedTags.value = materia.tags
          .split(',')
          .map(t => t.trim())
          .filter(t => t.length > 0);
      }
    }
    
    setMateriaDados(materia);
  } catch (error) {
    console.error('Erro ao buscar matéria:', error);
    alert('Erro ao carregar matéria');
  } finally {
    loading.value = false;
  }
};

const validateForm = () => {
  errors.value = {};
  
  if (!formData.value.vchr_titulo?.trim()) {
    errors.value.vchr_titulo = 'Título é obrigatório';
  }
  
  if (!formData.value.int_id_area) {
    errors.value.int_id_area = 'Categoria é obrigatória';
  }
  
  if (!editorData.value?.trim()) {
    errors.value.txt_corpo = 'Conteúdo é obrigatório';
  }
  
  // Validações de SEO
  if (formData.value.seo_description && formData.value.seo_description.length > 160) {
    errors.value.seo_description = 'Meta Description deve ter no máximo 160 caracteres';
  }
  
  if (formData.value.seo_title && formData.value.seo_title.length > 60) {
    errors.value.seo_title = 'Meta Title deve ter no máximo 60 caracteres';
  }

  
  return Object.keys(errors.value).length === 0;
};

const save = async () => {
  if (!validateForm()) {
    alert('Por favor, corrija os erros no formulário');
    return;
  }
  
  saving.value = true;
  
  try {
    // Codificar corpo em BASE64
    const corpoBase64 = btoa(unescape(encodeURIComponent(editorData.value)));
    
    const payload = {
      ...formData.value,
      vchr_conteudo: corpoBase64,
      tags: Array.isArray(selectedTags.value) ? selectedTags.value.join(', ') : selectedTags.value
    };
    
    let response;
    if (isEditMode.value) {
      response = await axios.put(`${API_URL}/materias/${props.id}`, payload);
    } else {
      response = await axios.post(`${API_URL}/materias`, payload);
    }
    
    const savedMateria = response.data.data || response.data;
    
    // Memorizar ID da matéria
    setMateriaId(savedMateria.id);
    setMateriaDados(savedMateria);
    
    alert(`Matéria ${isEditMode.value ? 'atualizada' : 'criada'} com sucesso!`);
    
    // Se for criação, redirecionar para edição
    if (!isEditMode.value) {
      router.visit(`/dashboard/materias/editar/${savedMateria.id}`);
    }
  } catch (error) {
    console.error('Erro ao salvar matéria:', error);
    alert('Erro ao salvar matéria: ' + (error.response?.data?.message || error.message));
  } finally {
    saving.value = false;
  }
};

const cancel = () => {
  router.visit('/dashboard/materias');
};

const openHtmlEditor = () => {
  htmlCode.value = editorData.value;
  showHtmlDialog.value = true;
};

const applyHtmlChanges = () => {
  editorData.value = htmlCode.value;
  showHtmlDialog.value = false;
};

const closeHtmlDialog = () => {
  showHtmlDialog.value = false;
};

const openImagesDialog = () => {
  const materiaId = getMateriaId();
  if (materiaId) {
    router.visit(`/dashboard/materias/${materiaId}/imagens`);
  } else {
    alert('Salve a matéria antes de gerenciar imagens');
  }
};

// Auto-gerar slug do título
watch(() => formData.value.vchr_titulo, (newTitle) => {
  if (!formData.value.seo_slug && newTitle) {
    formData.value.seo_slug = newTitle
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/[^\w\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
      .trim();
  }
});

// Auto-preencher meta title se vazio
watch(() => formData.value.vchr_titulo, (newTitle) => {
  if (!formData.value.seo_title && newTitle) {
    formData.value.seo_title = newTitle.substring(0, 60);
  }
});

// Auto-preencher og:title se vazio
watch(() => formData.value.seo_title, (newSeoTitle) => {
  if (!formData.value.seo_og_title && newSeoTitle) {
    formData.value.seo_og_title = newSeoTitle;
  }
});

onMounted(() => {
  fetchAreas();
 // fetchTags();
  if (props.id) {
    fetchMateria();
  }
});
</script>

<template>
  <Head :title="pageTitle" />

  <v-app>
    <!-- Navigation Drawer -->
    <DashboardSidebar v-model="drawer" />

    <!-- App Bar -->
    <DashboardAppBar 
      :title="pageTitle"
      :breadcrumbs="['Dashboard', 'Matérias', isEditMode ? 'Editar' : 'Criar']"
      @toggle-drawer="drawer = !drawer"
    />

    <!-- Main Content -->
    <v-main>
      <v-container fluid>
        <v-form @submit.prevent="save">
          <!-- Barra de Ações Horizontal -->
          <v-card class="mb-4" elevation="2">
            <v-card-text class="py-3">
              <v-row align="center">
                <v-col cols="12" md="8">
                  <div class="d-flex align-center">
                    <v-icon class="me-2" color="primary">mdi-file-document-edit</v-icon>
                    <span class="text-h6">{{ isEditMode ? 'Editando Matéria' : 'Nova Matéria' }}</span>
                  </div>
                </v-col>
                <v-col cols="12" md="4" class="text-md-end">
                  <v-btn
                    color="grey"
                    variant="outlined"
                    class="me-2"
                    @click="cancel"
                    :disabled="saving"
                  >
                    <v-icon start>mdi-close</v-icon>
                    Cancelar
                  </v-btn>
                  <v-btn
                    color="primary"
                    :loading="saving"
                    @click="save"
                  >
                    <v-icon start>mdi-content-save</v-icon>
                    {{ isEditMode ? 'Atualizar' : 'Criar' }}
                  </v-btn>
                  <v-btn
                    v-if="isEditMode || getMateriaId()"
                    color="purple"
                    variant="outlined"
                    class="ms-2"
                    @click="openImagesDialog"
                  >
                    <v-icon start>mdi-image-multiple</v-icon>
                    Imagens
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>

          <!-- Tabs -->
          <v-card elevation="2">
            <v-tabs
              v-model="activeTab"
              bg-color="primary"
              dark
            >
              <v-tab value="conteudo">
                <v-icon start>mdi-text-box</v-icon>
                Conteúdo da Matéria
              </v-tab>
              <v-tab value="seo">
                <v-icon start>mdi-search-web</v-icon>
                Otimização SEO
              </v-tab>
              <v-tab value="configuracoes">
                <v-icon start>mdi-cog</v-icon>
                Configurações
              </v-tab>
            </v-tabs>

            <v-window v-model="activeTab">
              <!-- Tab 1: Conteúdo da Matéria -->
              <v-window-item value="conteudo">
                <v-card-text>
                  <v-row>
                    <v-col cols="12" md="12">
                      <!-- Título -->
                      <v-text-field
                        v-model="formData.vchr_titulo"
                        label="Título *"
                        variant="outlined"
                        :error-messages="errors.vchr_titulo"
                        class="mb-4"
                        counter="200"
                      ></v-text-field>

                      <!-- Subtítulo -->
                      <v-text-field
                        v-model="formData.vchr_subtitulo"
                        label="Subtítulo"
                        variant="outlined"
                        class="mb-4"
                        counter="250"
                      ></v-text-field>

                      <!-- Lead/Resumo -->
                      <v-textarea
                        v-model="formData.txt_lead"
                        label="Lead/Resumo"
                        variant="outlined"
                        rows="3"
                        class="mb-4"
                        hint="Breve resumo da matéria que aparecerá em listagens"
                      ></v-textarea>

                      <!-- Editor CKEditor -->
                      <div class="mb-4">
                        <div class="d-flex justify-space-between align-center mb-2">
                          <label class="text-subtitle-2">Corpo da Matéria *</label>
                          <v-btn
                            size="small"
                            variant="outlined"
                            color="primary"
                            @click="openHtmlEditor"
                          >
                            <v-icon start size="small">mdi-code-tags</v-icon>
                            Ver/Editar HTML
                          </v-btn>
                        </div>
                        <div class="ck-editor-wrapper">
                          <ckeditor
                            v-model="editorData"
                            :editor="editor"
                            :config="editorConfig"
                          ></ckeditor>
                        </div>
                        <div v-if="errors.txt_corpo" class="text-error text-caption mt-1">
                          {{ errors.conteudo}}
                        </div>
                        <div class="text-caption text-grey mt-2">
                          <v-icon size="small">mdi-information</v-icon>
                          O conteúdo será salvo em formato BASE64. Imagens do corpo devem ser linkadas (não em BASE64).
                        </div>
                      </div>
                    </v-col>

                    <!-- Coluna Lateral - Imagem Destacada -->
                    <v-col cols="12" md="4">
                      <v-card v-if="isEditMode">
                        <v-card-title class="bg-purple-lighten-5">
                          <v-icon class="me-2">mdi-image</v-icon>
                          Imagem Destacada
                        </v-card-title>
                        <v-card-text>
                          <div class="text-caption text-grey mb-2">
                            As imagens destacadas são gerenciadas na tabela tb_aen_images.
                            Use o botão "Gerenciar Imagens" após salvar a matéria.
                          </div>
                          <div class="mb-3">
                            <FeaturedImageEditor
                              :materia-id="props.id"
                              :api-url="API_URL"
                              @saved="fetchMateria"
                            />
                          </div>
                          <v-text-field
                            v-model="formData.int_id_imagem_destaque"
                            label="ID da Imagem Destacada"
                            variant="outlined"
                            type="number"
                            hint="ID da imagem na tabela tb_aen_images"
                            persistent-hint
                          ></v-text-field>
                        </v-card-text>
                      </v-card>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-window-item>

              <!-- Tab 2: Otimização SEO -->
              <v-window-item value="seo">
                <v-card-text>
                  <v-row>
                    <!-- Meta Title -->
                    <v-col cols="12">
                      <v-text-field
                        v-model="formData.seo_title"
                        label="Meta Title (Título SEO)"
                        variant="outlined"
                        :error-messages="errors.seo_title"
                        counter="60"
                        hint="Título que aparece nos resultados de busca (máx. 60 caracteres)"
                      ></v-text-field>
                    </v-col>

                    <!-- Meta Description -->
                    <v-col cols="12">
                      <v-textarea
                        v-model="formData.seo_description"
                        label="Meta Description (Descrição SEO)"
                        variant="outlined"
                        :error-messages="errors.seo_description"
                        rows="3"
                        counter="160"
                        hint="Descrição que aparece nos resultados de busca (máx. 160 caracteres)"
                      ></v-textarea>
                    </v-col>

                    <!-- Meta Keywords -->
                    <v-col cols="12">
                      <v-text-field
                        v-model="formData.seo_keywords"
                        label="Meta Keywords (Palavras-chave)"
                        variant="outlined"
                        hint="Palavras-chave separadas por vírgula"
                      ></v-text-field>
                    </v-col>

                    <!-- Slug -->
                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="formData.seo_slug"
                        label="Slug (URL Amigável)"
                        variant="outlined"
                        prefix="/"
                        hint="Gerado automaticamente do título"
                      ></v-text-field>
                    </v-col>

                    <!-- Canonical URL -->
                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="formData.seo_canonical_url"
                        label="Canonical URL"
                        variant="outlined"
                        hint="URL canônica (deixe vazio para usar a URL atual)"
                      ></v-text-field>
                    </v-col>

                    <!-- Open Graph Title -->
                    <v-col cols="12">
                      <v-text-field
                        v-model="formData.seo_og_title"
                        label="Open Graph Title (Título para Redes Sociais)"
                        variant="outlined"
                        hint="Título ao compartilhar em redes sociais"
                      ></v-text-field>
                    </v-col>

                    <!-- Open Graph Description -->
                    <v-col cols="12">
                      <v-textarea
                        v-model="formData.seo_og_description"
                        label="Open Graph Description (Descrição para Redes Sociais)"
                        variant="outlined"
                        rows="2"
                        hint="Descrição ao compartilhar em redes sociais"
                      ></v-textarea>
                    </v-col>

                    <!-- Open Graph Image -->
                    <v-col cols="12" md="8">
                      <v-text-field
                        v-model="formData.seo_og_image"
                        label="Open Graph Image (URL da Imagem Social)"
                        variant="outlined"
                        hint="URL da imagem para compartilhamento em redes sociais"
                      ></v-text-field>
                    </v-col>

                    <!-- Open Graph Type -->
                    <v-col cols="12" md="4">
                      <v-select
                        v-model="formData.seo_og_type"
                        :items="['article', 'website', 'blog']"
                        label="Open Graph Type"
                        variant="outlined"
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-window-item>

              <!-- Tab 3: Configurações -->
              <v-window-item value="configuracoes">
                <v-card-text>
                  <v-row>
                    <!-- Autor -->
                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="formData.vchr_autor"
                        label="Autor"
                        variant="outlined"
                      ></v-text-field>
                    </v-col>

                    <!-- Categoria/Área -->
                    <v-col cols="12" md="6">
                      <v-select
                        v-model="formData.int_id_area"
                        :items="areas"
                        item-title="nome"
                        item-value="id"
                        label="Categoria *"
                        variant="outlined"
                        :error-messages="errors.int_id_area"
                      ></v-select>
                    </v-col>

                    <!-- Tags -->
                    <v-col cols="12">
                      <v-select
                        v-model="selectedTags"
                        :items="tags"
                        item-title="txt_nome"
                        item-value="id"
                        label="Tags"
                        variant="outlined"
                        multiple
                        chips
                        closable-chips
                      ></v-select>
                    </v-col>

                    <!-- Data de Publicação -->
                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="formData.dt_publicacao"
                        label="Data de Publicação"
                        type="datetime-local"
                        variant="outlined"
                      ></v-text-field>
                    </v-col>

                    <!-- Status Online -->
                    <v-col cols="12" md="6">
                      <v-switch
                        v-model="formData.bool_onLine"
                        color="success"
                        label="Publicar Online"
                        hint="Ao ativar, a matéria ficará visível no site"
                        persistent-hint
                      ></v-switch>
                    </v-col>

                    <!-- Mostrar na Home -->
                    <v-col cols="12" md="6">
                      <v-switch
                        v-model="formData.bool_home"
                        color="primary"
                        label="Mostra na home"
                        hint="Ao ativar, a matéria será exibida na página inicial"
                        persistent-hint
                      ></v-switch>
                    </v-col>

                    <!-- Editor de Imagem Destacada -->
                    <v-col cols="12" v-if="isEditMode">
                      <v-card variant="outlined" class="pa-4">
                        <div class="d-flex align-center justify-space-between flex-wrap gap-2">
                          <div class="text-subtitle-1 d-flex align-center">
                            <v-icon class="me-2">mdi-image-edit</v-icon>
                            Editor de Imagem Destacada
                          </div>
                          <FeaturedImageEditor
                            :materia-id="props.id"
                            :api-url="API_URL"
                            @saved="fetchMateria"
                          />
                        </div>
                        <div class="text-caption text-grey mt-2">
                          Disponível somente na edição, após a matéria ter um ID.
                        </div>
                      </v-card>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-window-item>
            </v-window>
          </v-card>
        </v-form>
      </v-container>
    </v-main>

    <!-- Footer -->
    <DashboardFooter />

    <!-- Modal de Edição de HTML -->
    <v-dialog v-model="showHtmlDialog" max-width="1200px" persistent>
      <v-card>
        <v-card-title class="d-flex align-center bg-primary text-white">
          <v-icon class="me-2">mdi-code-tags</v-icon>
          <span>Editar Código HTML</span>
          <v-spacer></v-spacer>
          <v-btn icon variant="text" @click="closeHtmlDialog">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        
        <v-card-text class="pa-0">
          <v-textarea
            v-model="htmlCode"
            variant="solo"
            rows="20"
            auto-grow
            class="html-editor"
            placeholder="Cole ou edite o código HTML aqui..."
            hide-details
          ></v-textarea>
        </v-card-text>

        <v-card-actions class="pa-4">
          <v-spacer></v-spacer>
          <v-btn
            color="grey"
            variant="outlined"
            @click="closeHtmlDialog"
          >
            <v-icon start>mdi-close</v-icon>
            Cancelar
          </v-btn>
          <v-btn
            color="primary"
            @click="applyHtmlChanges"
          >
            <v-icon start>mdi-check</v-icon>
            Aplicar Alterações
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<style scoped>
.ck-editor-wrapper {
  border: 1px solid #ccc;
  border-radius: 4px;
}

.ck-editor-wrapper :deep(.ck-editor__editable) {
  min-height: 400px;
}

.text-error {
  color: #d32f2f;
}

.html-editor :deep(textarea) {
  font-family: 'Courier New', Courier, monospace;
  font-size: 13px;
  line-height: 1.5;
}
</style>
