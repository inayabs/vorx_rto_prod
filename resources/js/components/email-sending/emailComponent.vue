<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Email</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-sending-tab" data-toggle="tab" href="#nav-sending" role="tab" aria-controls="nav-sending" aria-selected="true">Sending</a>
                                <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-templates-tab" data-toggle="tab" href="#nav-templates" role="tab" aria-controls="nav-templates" aria-selected="false">Templates</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-sending" role="tabpanel" aria-labelledby="nav-sending-tab">
                                <email-sending></email-sending>
                            </div>
                            <div class="tab-pane fade" id="nav-templates" role="tabpanel" aria-labelledby="nav-templates-tab">
                                <email-templates></email-templates>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EmailSending from "./emailSendingComponent.vue";
import EmailTemplates from "./emailTemplateComponent.vue";

export default {
  components: {
    EmailSending, EmailTemplates,
  },
  data() {
    return {
        app_color: app_color,
    };
  }
}
</script>