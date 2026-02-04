<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Head, router } from '@inertiajs/vue3';
import DashboardSidebar from '@/Components/DashboardSidebar.vue';
import DashboardAppBar from '@/Components/DashboardAppBar.vue';
import DashboardFooter from '@/Components/DashboardFooter.vue';

const props = defineProps({
  id: {
    type: [String, Number],
    required: true
  }
});

const drawer = ref(true);
const loading = ref(false);
const materia = ref(null);
const imagensDestacadas = ref([]);
const imagensS3 = ref([]);
const uploadingDestacada = ref(false);

// API Base URL
const API_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:3001/api';

const fetchMateria = async () => {
  loading.value = true;
  try {
    const response = await axios.get(`${API_URL}/materias/${props.id}`);
    materia.value = response.data.data || response.data;
  } catch (error) {
    console.error('Erro ao buscar matéria:', error);
  } finally {
    loading.value = false;
  }
};

const fetchImagensDestacadas = async () => {
  try {
    // Buscar imagens destacadas da tb_aen_images relacionadas à matéria
    const response = await axios.get(`${API_URL}/materias/${props.id}/imagens-destacadas`);
    imagensDestacadas.value = response.data.data || response.data || [];
  } catch (error) {
    console.error('Erro ao buscar imagens destacadas:', error);
    imagensDestacadas.value = [];
  }
};

const fetchImagensS3 = async () => {
  try {
    // Buscar imagens da pasta S3 da matéria
    const response = await axios.get(`${API_URL}/materias/${props.id}/imagens-s3`);
    imagensS3.value = response.data.data || response.data || [];
  } catch (error) {
    console.error('Erro ao buscar imagens S3:', error);
    imagensS3.value = [];
  }
};

const uploadImagemDestacada = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  uploadingDestacada.value = true;
  const formData = new FormData();
  formData.append('imagem', file);
  formData.append('id_materia', props.id);

  try {
    await axios.post(`${API_URL}/materias/${props.id}/upload-imagem-destacada`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    
    await fetchImagensDestacadas();
    alert('Imagem destacada enviada com sucesso!');
  } catch (error) {
    console.error('Erro ao fazer upload:', error);
    alert('Erro ao fazer upload da imagem');
  } finally {
    uploadingDestacada.value = false;
  }
};

const deleteImagemDestacada = async (idImagem) => {
  if (!confirm('Tem certeza que deseja excluir esta imagem?')) return;

  try {
    await axios.delete(`${API_URL}/imagens/${idImagem}`);
    await fetchImagensDestacadas();
    alert('Imagem excluída com sucesso!');
  } catch (error) {
    console.error('Erro ao excluir imagem:', error);
    alert('Erro ao excluir imagem');
  }
};

const setImagemDestaque = async (idImagem) => {
  try {
    await axios.patch(`${API_URL}/materias/${props.id}`, {
      int_id_imagem_destaque: idImagem
    });
    
    await fetchMateria();
    alert('Imagem de destaque definida!');
  } catch (error) {
    console.error('Erro ao definir imagem de destaque:', error);
    alert('Erro ao definir imagem de destaque');
  }
};

const voltar = () => {
  router.visit('/dashboard/materias');
};

onMounted(() => {
  fetchMateria();
  fetchImagensDestacadas();
  fetchImagensS3();
});
</script>

<template>
  <Head title="Gerenciar Imagens" />

  <v-app>
    <DashboardSidebar v-model="drawer" />

    <DashboardAppBar 
      title="Gerenciar Imagens da Matéria"
      :breadcrumbs="['Dashboard', 'Matérias', 'Imagens']"
      @toggle-drawer="drawer = !drawer"
    />

    <v-main>
      <v-container fluid>
        <!-- Header -->
        <v-card class="mb-4">
          <v-card-title class="bg-grey-lighten-4">
            <v-btn
              icon="mdi-arrow-left"
              variant="text"
              @click="voltar"
              class="me-2"
            ></v-btn>
            <span v-if="materia">{{ materia.vchr_titulo }}</span>
            <v-spacer></v-spacer>
            <v-chip v-if="materia?.int_id_imagem_destaque" color="success" size="small">
              <v-icon start size="small">mdi-check-circle</v-icon>
              Imagem de destaque definida
            </v-chip>
          </v-card-title>
        </v-card>

        <v-row>
          <!-- Imagens Destacadas (tb_aen_images) -->
          <v-col cols="12" md="6">
            <v-card>
              <v-card-title class="bg-purple-lighten-5">
                <v-icon class="me-2">mdi-image-area</v-icon>
                Imagens Destacadas
                <v-spacer></v-spacer>
                <v-btn
                  color="primary"
                  size="small"
                  @click="$refs.fileInput.click()"
                  :loading="uploadingDestacada"
                >
                  <v-icon start>mdi-upload</v-icon>
                  Upload
                </v-btn>
                <input
                  ref="fileInput"
                  type="file"
                  accept="image/*"
                  style="display: none"
                  @change="uploadImagemDestacada"
                />
              </v-card-title>
              <v-card-text>
                <div class="text-caption text-grey mb-4">
                  Armazenadas em /public/imagens/materias e registradas em tb_aen_images
                </div>

                <div v-if="loading" class="text-center pa-4">
                  <v-progress-circular indeterminate color="primary"></v-progress-circular>
                </div>

                <v-row v-else-if="imagensDestacadas.length">
                  <v-col
                    v-for="img in imagensDestacadas"
                    :key="img.id"
                    cols="12"
                    sm="6"
                  >
                    <v-card variant="outlined">
                      <v-img
                        :src="`/imagens/materias/${img.vchr_caminho}`"
                        height="200"
                        cover
                      ></v-img>
                      <v-card-actions>
                        <v-btn
                          size="small"
                          color="green"
                          variant="text"
                          @click="setImagemDestaque(img.id)"
                        >
                          <v-icon start size="small">mdi-star</v-icon>
                          Definir Destaque
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                          size="small"
                          color="red"
                          variant="text"
                          icon="mdi-delete"
                          @click="deleteImagemDestacada(img.id)"
                        ></v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-col>
                </v-row>

                <div v-else class="text-center pa-8 text-grey">
                  <v-icon size="64" color="grey-lighten-2">mdi-image-off</v-icon>
                  <p class="mt-2">Nenhuma imagem destacada</p>
                </div>
              </v-card-text>
            </v-card>
          </v-col>

          <!-- Imagens S3 (Corpo da Matéria) -->
          <v-col cols="12" md="6">
            <v-card>
              <v-card-title class="bg-blue-lighten-5">
                <v-icon class="me-2">mdi-aws</v-icon>
                Imagens do Corpo (S3)
              </v-card-title>
              <v-card-text>
                <div class="text-caption text-grey mb-4">
                  Armazenadas na pasta S3 da AWS associada à matéria
                </div>

                <div v-if="loading" class="text-center pa-4">
                  <v-progress-circular indeterminate color="primary"></v-progress-circular>
                </div>

                <v-row v-else-if="imagensS3.length">
                  <v-col
                    v-for="(img, index) in imagensS3"
                    :key="index"
                    cols="12"
                    sm="6"
                  >
                    <v-card variant="outlined">
                      <v-img
                        :src="img.url"
                        height="200"
                        cover
                      ></v-img>
                      <v-card-subtitle class="text-caption">
                        {{ img.nome }}
                      </v-card-subtitle>
                      <v-card-actions>
                        <v-btn
                          size="small"
                          variant="text"
                          @click="navigator.clipboard.writeText(img.url)"
                        >
                          <v-icon start size="small">mdi-content-copy</v-icon>
                          Copiar URL
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-col>
                </v-row>

                <div v-else class="text-center pa-8 text-grey">
                  <v-icon size="64" color="grey-lighten-2">mdi-cloud-off-outline</v-icon>
                  <p class="mt-2">Nenhuma imagem no S3</p>
                  <p class="text-caption">As imagens do corpo são gerenciadas automaticamente</p>
                </div>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>

        <!-- Informações Adicionais -->
        <v-card class="mt-4">
          <v-card-title class="bg-grey-lighten-4">
            <v-icon class="me-2">mdi-information</v-icon>
            Informações
          </v-card-title>
          <v-card-text>
            <v-alert type="info" variant="tonal" class="mb-3">
              <strong>Imagens Destacadas:</strong> São armazenadas localmente em /public/imagens/materias 
              e registradas na tabela tb_aen_images. Use para imagem de capa e thumbnails.
            </v-alert>
            <v-alert type="info" variant="tonal">
              <strong>Imagens do Corpo:</strong> São armazenadas no S3 da AWS e linkadas no conteúdo HTML. 
              Não são salvas em BASE64 para otimizar o tamanho do banco de dados.
            </v-alert>
          </v-card-text>
        </v-card>
      </v-container>
    </v-main>

    <DashboardFooter />
  </v-app>
</template>

<style scoped>
.v-card-title {
  display: flex;
  align-items: center;
}
</style>
