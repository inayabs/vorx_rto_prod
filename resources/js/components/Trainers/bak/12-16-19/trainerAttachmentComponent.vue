<template>
    <file-drag-drop-instant 
      v-bind:uploadURL="'/trainer/attachment/upload/'+trainer_id"
      v-bind:fetchURL="'/trainer/attachment/fetch/'+trainer_id"
      v-bind:deleteURL="'/trainer/attachment/delete'"
      v-bind:previewURL="'/trainer/attachment/preview/'"
      v-bind:fileTypeValidate="['jpeg','jpg','png','pdf','docx','JPG']"
      v-bind:fileSizeValidate="10000000"
    ></file-drag-drop-instant>
</template>
 
<script>

  // import FileDragDrop from './../attachments/FileDragDropComponent.vue'
  import FileDragDropInstant from './../globals/FileDragDropInstantComponent.vue'

  export default {
    components: {
     FileDragDropInstant,
    },
    mounted() {},
    data () {
      return {
        trainer_id: window.trainer_id
      }
    },
    methods: {
      
    },
  }
</script> 
