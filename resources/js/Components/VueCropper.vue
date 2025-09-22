<template>
  <div class="cropper-container">
    <input type="file" accept="image/*" @change="setImage" />

    <div class="cropper-wrapper">
      <vue-cropper
        ref="cropperRef"
        :src="imgSrc"
        :ready="handleCropperReady"
        :img-style="{ 'width': '100%', 'height': '100%' }"
      />
    </div>

    <button @click="cropImage">Crop Image</button>

    <div v-if="croppedImgSrc" class="preview-container">
      <h3>Cropped Image</h3>
      <img :src="croppedImgSrc" alt="Cropped" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';

// Declare a ref to access the cropper instance
const cropperRef = ref(null);
const imgSrc = ref('');
const croppedImgSrc = ref('');

// Handler for file input change
const setImage = (e) => {
  const file = e.target.files[0];
  if (file && file.type.includes('image')) {
    const reader = new FileReader();
    reader.onload = (event) => {
      imgSrc.value = event.target.result;
      // Replace the image in the cropper
      if (cropperRef.value) {
        cropperRef.value.replace(event.target.result);
      }
    };
    reader.readAsDataURL(file);
  }
};

// Handle cropper ready event
const handleCropperReady = () => {
  console.log('Cropper is ready!');
};

// Method to get the cropped image
const cropImage = () => {
  if (cropperRef.value) {
    croppedImgSrc.value = cropperRef.value.getCroppedCanvas().toDataURL();
  }
};
</script>

<style scoped>
.cropper-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}
.cropper-wrapper {
  width: 500px;
  height: 500px;
  border: 1px solid #ccc;
}
.preview-container {
  margin-top: 20px;
}
.preview-container img {
  max-width: 100%;
  border: 1px solid #ccc;
}
</style>
