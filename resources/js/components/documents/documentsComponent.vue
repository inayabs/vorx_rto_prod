<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Documents</h6>
            </div>
            <div class="card-body">
                <div>
                    <!-- <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-3'">
                        <h6>Documents</h6>
                    </div> -->
                    <file-drag-drop-instant
                        :uploadURL="'/documents/upload'"
                        :fetchURL="'/documents/fetch'"
                        :deleteURL="'/documents/delete/'"
                        :previewURL="'/documents/preview/'"
                        :updateURL="'/documents/update/'"
                        :fileTypeValidate="['pdf', 'zip', 'doc', 'docx', 'csv', 'xls', 'xlsx', 'txt']"
                        :fileSizeValidate="5000000"
                        :fileDetails="true"
                        :versioning="false"
                        :updateFileBtn="true"
                    >
                    </file-drag-drop-instant>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FileDragDropInstant from './../globals/FileDragDropInstantComponent.vue'
export default {
    components: {
        FileDragDropInstant
    },
    data () {
        return {
            app_color: app_color,
        }
    }
}
</script>
