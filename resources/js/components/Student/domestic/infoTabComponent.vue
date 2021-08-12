<template>
  <div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="personal-info-tab" data-toggle="tab" href="#personal-info" role="tab" aria-controls="personal-info" aria-selected="true">Personal Information</a>
                <a v-bind:class="'nav-item nav-link-'+app_color" id="contact-details-tab" data-toggle="tab" href="#contact-details" role="tab" aria-controls="contact-details" aria-selected="true">Contact Details</a>
                <a v-bind:class="'nav-item nav-link-'+app_color" id="visa-details-tab" data-toggle="tab" href="#visa-details" role="tab" aria-controls="visa-details" aria-selected="true">Visa Details</a>
                <a v-if="add_on.indexOf('student-portal') != -1" v-bind:class="'nav-item nav-link-'+app_color" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Logins</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
                <div>
                    <personal-info :student="student"></personal-info>
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
            <div v-if="add_on.indexOf('student-portal') != -1" class="tab-pane fade show" id="login" role="tabpanel" aria-labelledby="login-tab">
                <div>
                    <login></login>
                </div>
            </div>
        </div>
  </div>
</template>
<script>
import PersonalInfo from "./personalInfoComponent.vue";
import ContactDetails from "./contactDetailsComponent.vue";
import VisaDetails from "./visaDetailsComponent.vue";
import Login from "./loginComponent.vue";
export default {
    props : ['student'],
    components: {
        PersonalInfo,
        ContactDetails,
        VisaDetails,
        Login
    },
    data() {
    return {
      app_color: app_color,
      add_on: add_on,
    };
  }
}
</script>