<template>
  <a-file-drag-drop-instant
    v-bind:uploadURL="'/student/aiss-attachment/upload/'+student_id"
    v-bind:fetchURL="'/student/aiss-attachment/fetch/'+student_id"
    v-bind:deleteURL="'/student/aiss-attachment/delete/'"
    v-bind:previewURL="'/student/aiss-attachment/preview/'"
    v-bind:fileTypeValidate="['jpeg','jpg','png','pdf','docx','JPG']"
    v-bind:fileSizeValidate="10000000"
    :renamefilenameURL="'/student/aiss-attachment/rename/'"
  ></a-file-drag-drop-instant>
  <!-- <div>test</div> -->
</template>
<script>
import AFileDragDropInstant from "./../../globals/FileDragDropInstantComponent.vue";
export default {
  components: {
    AFileDragDropInstant
  },
  data() {
    return {
      student_id: window.student_id
    };
  }
};
</script>