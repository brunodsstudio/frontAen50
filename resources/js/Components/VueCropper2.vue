<template>
  <div>
    <!-- File input -->
    <input type="file" @change="handleFileChange" accept="image/*">

    <!-- Cropper container -->
    <div v-if="imgSrc" class="cropper-container">
      <VueCropper
        ref="cropperRef"
        :src="imgSrc"
        :alt="altText"
        :aspectRatio="1"
        :guides="true"
        :viewMode="1"
        :zoomable="true"
      ></VueCropper>
      <button @click="cropImage">Crop Image</button>
    </div>

    <!-- Cropped image preview -->
    <div v-if="croppedImage" class="preview-container">
      <img :src="croppedImage" alt="Cropped image preview" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import VueCropper from 'vue-cropperjs';
//import 'cropperjs/dist/cropper.css';

// Component props
const props = defineProps({
  altText: {
    type: String,
    default: 'Source Image'
  }
});

const emit = defineEmits(['cropped']);

// State variables
const cropperRef = ref(null);
const imgSrc = ref(null);
const croppedImage = ref(null);

// Handle file input
const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (event) => {
      imgSrc.value = event.target.result;
    };
    reader.readAsDataURL(file);
  }
};

// Crop the image
const cropImage = () => {
  if (cropperRef.value) {
    // Get the cropped image data URL
    const result = cropperRef.value.getCroppedCanvas().toDataURL();
    croppedImage.value = result;
    emit('cropped', result);
  }
};
</script>

<style scoped>
.cropper-container {
  max-width: 800px;
  margin: 20px 0;
}
.preview-container {
  margin-top: 20px;
}
.preview-container img {
  max-width: 100%;
}
</style>