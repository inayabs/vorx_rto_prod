<template>
  <file-drag-drop-instant
    v-bind:uploadURL="'/student/attachment/upload/' + student_id"
    v-bind:fetchURL="'/student/attachment/fetch/' + student_id"
    v-bind:deleteURL="'/student/attachment/delete/'"
    v-bind:previewURL="'/student/attachment/preview/'"
    v-bind:fileTypeValidate="['jpeg', 'jpg', 'png', 'pdf', 'PDF', 'docx', 'JPG']"
    v-bind:fileSizeValidate="10000000"
    :renamefilenameURL="'/student/attachment/rename/'"
  ></file-drag-drop-instant>
</template>
<script>
import FileDragDropInstant from "./../../globals/FileDragDropInstantComponent.vue";
export default {
  props: ["updateHistory"],
  components: {
    FileDragDropInstant,
  },
  data() {
    return {
      student_id: window.student_id,
    };
  },
  watch: {
    updateHistory: function (newVal, oldVal) {
      if (newVal) {
        // this.$chilren[0].getPaymentHistory();
        this.$children[0].fetchAttachments();
        // console.log();
        // console.log(this.$parent);
      }
    },
  },
};
</script>