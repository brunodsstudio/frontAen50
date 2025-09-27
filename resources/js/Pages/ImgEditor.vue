<template>
  <div id="app">
    <h1>Image Cropper Example</h1>
    <ImageCropper @cropped="handleCroppedImage" />
    <div v-if="finalImage" class="result-container">
      <h3>Final Cropped Image:</h3>
      <img :src="finalImage" alt="Final cropped image" />
    </div>

    <div class="accordion" id="myAccordion">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Accordion Item #1
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#myAccordion">
      <div class="accordion-body">
        This is the content of the first accordion item. It is shown by default.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Accordion Item #2
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#myAccordion">
      <div class="accordion-body">
        This is the content of the second accordion item. It is hidden by default.
      </div>
    </div>
  </div>
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