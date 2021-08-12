<template>
<div>
    <nav>
        <div class="nav nav-tabs" id="info-nav-tab" role="tablist">
            <a v-bind:class="'nav-item nav-link-' + app_color + ' active'" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="true">Notes</a>
            <a :class="'nav-item nav-link-' + app_color" id="nav-attachments-tab" data-toggle="tab" href="#nav-attachments" role="tab" aria-controls="nav-attachments" aria-selected="false">Attachments</a>
            <a :class="'nav-item nav-link-' + app_color" id="nav-aiss-attachments-tab" data-toggle="tab" href="#nav-aiss-attachments" role="tab" aria-controls="nav-aiss-attachments" aria-selected="false">AISS Attachments</a>
            <a v-if="warning_history.length > 0" :class="'nav-item nav-link-' + app_color" id="nav-warning-history-tab" data-toggle="tab" href="#nav-warning-history" role="tab" aria-controls="nav-warning-history" aria-selected="false">Warning Letter History</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
            <div>
                <notes-tab></notes-tab>
            </div>
        </div>
        <div class="tab-pane fade show" id="nav-attachments" role="tabpanel" aria-labelledby="attachments-tab">
            <div>
                <attachments-tab></attachments-tab>
            </div>
        </div>
        <div class="tab-pane fade show" id="nav-aiss-attachments" role="tabpanel" aria-labelledby="aiss-attachments-tab">
            <div>
                <aissattachments-tab></aissattachments-tab>
            </div>
        </div>
        <div v-if="warning_history.length > 0" class="tab-pane fade show" id="nav-warning-history" role="tabpanel" aria-labelledby="aiss-attachments-tab">
            <div>
                <warninghistory-tab :warning="warning_history"></warninghistory-tab>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import notesTab from "./others/StudentNotesComponent.vue";
import attachmentsTab from "./others/StudentAttachmentComponent.vue";
import aissattachmentsTab from "./others/StudentAISSAttachmentComponent.vue";
import warninghistoryTab from "./others/warningLetterHistoryComponent.vue";

export default {
    components: {
        notesTab,
        attachmentsTab,
        aissattachmentsTab,
        warninghistoryTab
    },
    data() {
        return {
            app_color: app_color,
        };
    },
    computed: {
        warning_history() {
            return this.$store.getters.warning_history;
        }
    },
};
</script>

<style>
</style>
