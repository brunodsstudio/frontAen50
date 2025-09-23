<template>
  <div id="app">
    <h1>Image Cropper Example</h1>
    <ImageCropper @cropped="handleCroppedImage" />
    <div v-if="finalImage" class="result-container">
      <h3>Final Cropped Image:</h3>
      <img :src="finalImage" alt="Final cropped image" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ImageCropper from '@/Components/VueCropper2.vue';

const finalImage = ref(null);

const handleCroppedImage = (dataUrl) => {
  finalImage.value = dataUrl;
  console.log('Cropped image data:', dataUrl);
  // Here you can send the dataUrl to your server or perform other actions
};
</script>

<style>

</style>