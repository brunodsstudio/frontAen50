<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

const props = defineProps({
  materiaId: {
    type: [String, Number],
    required: true,
  },
  apiUrl: {
    type: String,
    required: true,
  },
  materiaTitle: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['saved']);

const showDialog = ref(false);
const file = ref(null);
const imageUrl = ref('');
const baseName = ref('');
const preset = ref('free');
const resizePreset = ref('1920x1080');
const customWidth = ref(1920);
const customHeight = ref(1080);
const watermarkText = ref('');
const watermarkOpacity = ref(0.4);
const saving = ref(false);

const cropperRef = ref(null);
const history = ref([]);
const historyIndex = ref(-1);

const aspectRatio = computed(() => {
  if (preset.value === '1920x1080') return 1920 / 1080;
  if (preset.value === '372x209') return 372 / 209;
  return null;
});

// Função para normalizar o título da matéria (remove acentos, espaços e caracteres especiais)
const normalizeTitle = (title) => {
  if (!title) return '';
  
  // Remove acentos
  const normalized = title
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '');
  
  // Converte para lowercase e substitui espaços e caracteres especiais por hífen
  return normalized
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, ''); // Remove hífens do início e fim
};

const open = () => {
  showDialog.value = true;
  
  // Define o baseName automaticamente com o título da matéria normalizado
  if (props.materiaTitle && !baseName.value) {
    baseName.value = normalizeTitle(props.materiaTitle);
  }
};

const close = () => {
  showDialog.value = false;
};

const onFileChange = (event) => {
  const selected = event.target.files?.[0];
  if (!selected) return;
  file.value = selected;
  imageUrl.value = URL.createObjectURL(selected);
  history.value = [imageUrl.value];
  historyIndex.value = 0;
};

const clearImage = () => {
  if (imageUrl.value) {
    URL.revokeObjectURL(imageUrl.value);
  }
  file.value = null;
  imageUrl.value = '';
  history.value = [];
  historyIndex.value = -1;
};

const pushHistory = (url) => {
  if (historyIndex.value < history.value.length - 1) {
    history.value = history.value.slice(0, historyIndex.value + 1);
  }
  history.value.push(url);
  historyIndex.value = history.value.length - 1;
  imageUrl.value = url;
};

const undo = () => {
  if (historyIndex.value > 0) {
    historyIndex.value -= 1;
    imageUrl.value = history.value[historyIndex.value];
  }
};

const redo = () => {
  if (historyIndex.value < history.value.length - 1) {
    historyIndex.value += 1;
    imageUrl.value = history.value[historyIndex.value];
  }
};

const loadImage = (src) =>
  new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = () => resolve(img);
    img.onerror = reject;
    img.src = src;
  });

const canvasToUrl = (canvas) => canvas.toDataURL('image/png');

const urlToPngBlob = async (src, quality = 0.85) => {
  const img = await loadImage(src);
  const canvas = document.createElement('canvas');
  
  // Limitar dimensões máximas para evitar imagens muito grandes
  const maxDimension = 2560;
  let { width, height } = img;
  
  if (width > maxDimension || height > maxDimension) {
    if (width > height) {
      height = (height / width) * maxDimension;
      width = maxDimension;
    } else {
      width = (width / height) * maxDimension;
      height = maxDimension;
    }
  }
  
  canvas.width = width;
  canvas.height = height;
  const ctx = canvas.getContext('2d');
  ctx.drawImage(img, 0, 0, width, height);
  
  // Usar JPEG com compressão para imagens grandes
  const dataUrl = canvas.toDataURL('image/jpeg', quality);
  return dataUrlToBlob(dataUrl);
};

const applyCrop = () => {
  const result = cropperRef.value?.getResult();
  const canvas = result?.canvas;
  if (!canvas) {
    alert('Defina a área de recorte.');
    return;
  }
  pushHistory(canvasToUrl(canvas));
};

const applyFlip = async (direction) => {
  if (!imageUrl.value) return;
  const img = await loadImage(imageUrl.value);
  const canvas = document.createElement('canvas');
  canvas.width = img.width;
  canvas.height = img.height;
  const ctx = canvas.getContext('2d');
  ctx.save();
  if (direction === 'x') {
    ctx.translate(canvas.width, 0);
    ctx.scale(-1, 1);
  } else {
    ctx.translate(0, canvas.height);
    ctx.scale(1, -1);
  }
  ctx.drawImage(img, 0, 0);
  ctx.restore();
  pushHistory(canvasToUrl(canvas));
};

const applyResize = async () => {
  if (!imageUrl.value) return;
  let width = 1920;
  let height = 1080;
  if (resizePreset.value === '372x209') {
    width = 372;
    height = 209;
  } else if (resizePreset.value === 'custom') {
    width = Number(customWidth.value) || 1920;
    height = Number(customHeight.value) || 1080;
  }

  const img = await loadImage(imageUrl.value);
  const canvas = document.createElement('canvas');
  canvas.width = width;
  canvas.height = height;
  const ctx = canvas.getContext('2d');
  ctx.drawImage(img, 0, 0, width, height);
  pushHistory(canvasToUrl(canvas));
};

const applyWatermark = async () => {
  if (!imageUrl.value) return;
  if (!watermarkText.value?.trim()) {
    alert('Informe o texto da marca d\'água.');
    return;
  }
  const img = await loadImage(imageUrl.value);
  const canvas = document.createElement('canvas');
  canvas.width = img.width;
  canvas.height = img.height;
  const ctx = canvas.getContext('2d');
  ctx.drawImage(img, 0, 0);
  ctx.fillStyle = `rgba(255, 255, 255, ${watermarkOpacity.value})`;
  ctx.font = '24px Arial';
  ctx.textAlign = 'right';
  ctx.textBaseline = 'bottom';
  ctx.fillText(watermarkText.value, canvas.width - 10, canvas.height - 10);
  pushHistory(canvasToUrl(canvas));
};

const dataUrlToBlob = async (dataUrl) => {
  const res = await fetch(dataUrl);
  const blob = await res.blob();
  // Detecta o tipo MIME correto do dataUrl
  const mimeType = dataUrl.split(',')[0].match(/:(.*?);/)?.[1] || 'image/png';
  return new Blob([blob], { type: mimeType });
};

const save = async () => {
  if (!file.value) {
    alert('Selecione uma imagem.');
    return;
  }
  if (!baseName.value?.trim()) {
    alert('Informe o nome base (vchr_ImgLink).');
    return;
  }

  if (!imageUrl.value) {
    alert('Aplique ao menos uma ação ou selecione a imagem.');
    return;
  }

  saving.value = true;
  try {
    const formData = new FormData();
    const blob = await urlToPngBlob(imageUrl.value, 0.85);
    formData.append('image', blob, `${baseName.value.trim()}.jpg`);
    formData.append('base_name', baseName.value.trim());
    formData.append('watermark_text', '');
    formData.append('watermark_opacity', '0');

    const response = await axios.post(
      `${props.apiUrl}/materias/${props.materiaId}/images/featured-editor`,
      formData
    );

    alert(response.data?.message || 'Imagens geradas com sucesso.');
    emit('saved', response.data?.images || []);
    close();
  } catch (error) {
    console.error('Erro ao gerar imagens:', error);
    const details = error.response?.data?.errors || error.response?.data?.error;
    if (details) {
      alert(`Erro ao gerar imagens: ${JSON.stringify(details)}`);
    } else {
      alert('Erro ao gerar imagens.');
    }
  } finally {
    saving.value = false;
  }
};
</script>

<template>
  <div>
    <v-btn color="primary" variant="outlined" @click="open">
      <v-icon start>mdi-image-edit</v-icon>
      Editor de Imagem Destacada
    </v-btn>

    <v-dialog v-model="showDialog" max-width="1200">
      <v-card>
        <v-card-title class="d-flex align-center bg-primary text-white">
          <v-icon class="me-2">mdi-image-edit</v-icon>
          <span>Editor de Imagem Destacada</span>
          <v-spacer></v-spacer>
          <v-btn icon variant="text" @click="close">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>

        <v-card-text>
          <v-row>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="baseName"
                label="Nome base (vchr_ImgLink)"
                variant="outlined"
                hint="Ex: minha-materia-2026-02-06"
                persistent-hint
              ></v-text-field>

              <v-select
                v-model="preset"
                label="Preset de recorte"
                variant="outlined"
                :items="[
                  { title: 'Livre', value: 'free' },
                  { title: '1920 x 1080', value: '1920x1080' },
                  { title: '372 x 209', value: '372x209' }
                ]"
                item-title="title"
                item-value="value"
                class="mt-2"
              ></v-select>

              <v-select
                v-model="resizePreset"
                label="Preset de resize"
                variant="outlined"
                :items="[
                  { title: '1920 x 1080', value: '1920x1080' },
                  { title: '372 x 209', value: '372x209' },
                  { title: 'Personalizado', value: 'custom' }
                ]"
                item-title="title"
                item-value="value"
                class="mt-2"
              ></v-select>

              <v-row v-if="resizePreset === 'custom'" class="mt-2">
                <v-col cols="6">
                  <v-text-field
                    v-model="customWidth"
                    label="Largura"
                    type="number"
                    variant="outlined"
                  ></v-text-field>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="customHeight"
                    label="Altura"
                    type="number"
                    variant="outlined"
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-text-field
                v-model="watermarkText"
                label="Marca d’água (texto)"
                variant="outlined"
                class="mt-2"
              ></v-text-field>

              <v-slider
                v-model="watermarkOpacity"
                label="Opacidade da marca d’água"
                min="0"
                max="1"
                step="0.1"
                class="mt-2"
              ></v-slider>

              <div class="d-flex flex-wrap gap-2 mt-2">
                <v-tooltip text="Recortar imagem" location="top">
                  <template v-slot:activator="{ props: tooltipProps }">
                    <v-btn v-bind="tooltipProps" icon variant="outlined" @click="applyCrop">
                      <v-icon>mdi-crop</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>

                <v-tooltip text="Espelhar horizontalmente" location="top">
                  <template v-slot:activator="{ props: tooltipProps }">
                    <v-btn v-bind="tooltipProps" icon variant="outlined" @click="applyFlip('x')">
                      <v-icon>mdi-flip-horizontal</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>

                <v-tooltip text="Espelhar verticalmente" location="top">
                  <template v-slot:activator="{ props: tooltipProps }">
                    <v-btn v-bind="tooltipProps" icon variant="outlined" @click="applyFlip('y')">
                      <v-icon>mdi-flip-vertical</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>

                <v-tooltip text="Redimensionar imagem" location="top">
                  <template v-slot:activator="{ props: tooltipProps }">
                    <v-btn v-bind="tooltipProps" icon variant="outlined" @click="applyResize">
                      <v-icon>mdi-resize</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>

                <v-tooltip text="Adicionar marca d'água" location="top">
                  <template v-slot:activator="{ props: tooltipProps }">
                    <v-btn v-bind="tooltipProps" icon variant="outlined" @click="applyWatermark">
                      <v-icon>mdi-watermark</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>
              </div>

              <div class="d-flex flex-wrap gap-2 mt-2">
                <v-tooltip text="Desfazer" location="top">
                  <template v-slot:activator="{ props: tooltipProps }">
                    <v-btn v-bind="tooltipProps" icon variant="outlined" :disabled="historyIndex <= 0" @click="undo">
                      <v-icon>mdi-undo</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>

                <v-tooltip text="Refazer" location="top">
                  <template v-slot:activator="{ props: tooltipProps }">
                    <v-btn v-bind="tooltipProps" icon variant="outlined" :disabled="historyIndex >= history.length - 1" @click="redo">
                      <v-icon>mdi-redo</v-icon>
                    </v-btn>
                  </template>
                </v-tooltip>
              </div>

              <div class="mt-4">
                <v-btn color="primary" @click="$refs.fileInput.click()">
                  <v-icon start>mdi-upload</v-icon>
                  Selecionar Imagem
                </v-btn>
                <input
                  ref="fileInput"
                  type="file"
                  accept="image/jpeg,image/png"
                  style="display: none"
                  @change="onFileChange"
                />
                <v-btn class="ms-2" variant="text" @click="clearImage">
                  Limpar
                </v-btn>
              </div>

              <v-alert
                type="info"
                variant="tonal"
                class="mt-4"
                density="compact"
              >
                As imagens serão salvas em /public/image/materias e registradas na tabela tb_aen_images.
              </v-alert>
            </v-col>

            <v-col cols="12" md="8">
              <div v-if="imageUrl" class="cropper-wrapper">
                <Cropper
                  ref="cropperRef"
                  :key="imageUrl"
                  :src="imageUrl"
                  :stencil-props="{ aspectRatio }"
                  :image-restriction="'stencil'"
                />
              </div>
              <v-alert v-else type="warning" variant="tonal" density="compact">
                Selecione uma imagem para iniciar o recorte.
              </v-alert>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-actions class="pa-4">
          <v-spacer></v-spacer>
          <v-btn color="grey" variant="outlined" @click="close">
            Cancelar
          </v-btn>
          <v-btn color="primary" :loading="saving" @click="save">
            Salvar Imagens
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<style scoped>
.cropper-wrapper {
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  overflow: hidden;
  min-height: 420px;
  background: #f9fafb;
}

</style>
