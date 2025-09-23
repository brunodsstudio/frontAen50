<script setup>
import { onMounted, ref } from 'vue'; // Correct import for onMounted
import Cropper from 'cropperjs';
import GeneralLayout from '@/Layouts/GeneralLayout.vue';


onMounted(() => {
        const myImage = document.getElementById('imagem');
        console.log(myImage);
        const cropper = new Cropper(myImage, {
        aspectRatio: 16 / 9,
        crop(event) {
            console.log(event.detail.x);
            console.log(event.detail.y);
            console.log(event.detail.width);
            console.log(event.detail.height);
            console.log(event.detail.rotate);
            console.log(event.detail.scaleX);
            console.log(event.detail.scaleY);
        },
        });
});

</script>

<script>
export default {
  data() {
    return {
     // drawer: Cropper.getCropperSelection(), 
    };
  },
};
</script>

<template>
   <GeneralLayout>
    <div>
      <h1>Image Editor</h1>
      <img id="imagem" src="images/fallout.jpg" alt="Picture">
    </div>

    <cropper-canvas background>
        <cropper-image src="images/fallout.jpg" alt="Picture" rotatable scalable skewable translatable></cropper-image>
        <cropper-shade hidden></cropper-shade>
        <cropper-handle action="select" plain></cropper-handle>
        <cropper-selection initial-coverage="0.5" movable resizable>
            <cropper-grid role="grid" covered></cropper-grid>
            <cropper-crosshair centered></cropper-crosshair>
            <cropper-handle action="move" theme-color="rgba(0, 0, 0, 0.50)"></cropper-handle>
            <cropper-handle action="n-resize"></cropper-handle>
            <cropper-handle action="e-resize"></cropper-handle>
            <cropper-handle action="s-resize"></cropper-handle>
            <cropper-handle action="w-resize"></cropper-handle>
            <cropper-handle action="ne-resize"></cropper-handle>
            <cropper-handle action="nw-resize"></cropper-handle>
            <cropper-handle action="se-resize"></cropper-handle>
            <cropper-handle action="sw-resize"></cropper-handle>
        </cropper-selection>
    </cropper-canvas>
   </GeneralLayout>

</template>