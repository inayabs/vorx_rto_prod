<template>
<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-primary-'+app_color">Student Profile</h6>
        </div>
        <div class="card-body">
            <div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="personal-info-tab" data-toggle="tab" href="#personal-info" role="tab" aria-controls="personal-info" aria-selected="true">Personal Information</a>
                        <a v-bind:class="'nav-item nav-link-'+app_color" id="contact-details-tab" data-toggle="tab" href="#contact-details" role="tab" aria-controls="contact-details" aria-selected="true">Contact Details</a>
                        <a v-bind:class="'nav-item nav-link-'+app_color" id="visa-details-tab" data-toggle="tab" href="#visa-details" role="tab" aria-controls="visa-details" aria-selected="true">Visa Details</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
                        <div>
                            <personal-info></personal-info>
                            <!-- <personal-info :student="student"></personal-info> -->
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="contact-details" role="tabpanel" aria-labelledby="contact-details-tab">
                        <div>
                            <contact-details></contact-details>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="visa-details" role="tabpanel" aria-labelledby="visa-details-tab">
                        <div>
                            <visa-details></visa-details>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import PersonalInfo from "./personalInfoComponent.vue";
import VisaDetails from "./visaDetailsComponent.vue";
import ContactDetails from "./contactDetailsComponent.vue";

export default {
    components: {
        PersonalInfo,
        VisaDetails,
        ContactDetails,
    },
    data() {
        return {
            app_color: app_color,
            add_on: add_on,
            // app_settings: app_settings,
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            
        },
        saveChanges() {
            // @ dynamic form
        }

    }
}
</script>
