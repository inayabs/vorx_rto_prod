<template>
    <file-drag-drop-instant 
      v-bind:uploadURL="'/agent/attachment/upload/'+agent_id"
      v-bind:fetchURL="'/agent/attachment/fetch/'+agent_id"
      v-bind:deleteURL="'/agent/attachment/delete/'"
      v-bind:previewURL="'/agent/attachment/preview/'"
      v-bind:fileTypeValidate="['jpeg','jpg','png', 'pdf']"
      v-bind:fileSizeValidate="5000000"
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
        agent_id: window.agent.id
      }
    },
    methods: {
      
    },
  }
</script> 
