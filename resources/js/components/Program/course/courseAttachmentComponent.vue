<template>
  <file-drag-drop-instant
    v-bind:uploadURL="'/course/attachment/upload/' + course_code"
    v-bind:fetchURL="'/course/attachment/fetch/' + course_code"
    v-bind:deleteURL="'/course/attachment/delete/'"
    v-bind:previewURL="'/course/attachment/preview/'"
    v-bind:fileTypeValidate="['jpeg', 'jpg', 'png', 'pdf', 'docx', 'JPG']"
    v-bind:fileSizeValidate="10000000"
    :renamefilenameURL="'/course/attachment/rename/'"
  ></file-drag-drop-instant>
</template>
<script>
import FileDragDropInstant from "./../../globals/FileDragDropInstantComponent.vue";
export default {
//   props: ["updateHistory"],
  components: {
    FileDragDropInstant,
  },
  data() {
    return {
      course_code: window.course_code,
    };
  },
  watch: {
    // updateHistory: function (newVal, oldVal) {
    //   if (newVal) {
    //     // this.$chilren[0].getPaymentHistory();
    //     this.$children[0].fetchAttachments();
    //     // console.log();
    //     // console.log(this.$parent);
    //   }
    // },
  },
};
</script>