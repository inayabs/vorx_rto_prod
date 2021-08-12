<template>
  <div>
    <nav>
      <div class="nav nav-tabs" id="info-nav-tab" role="tablist">
        <a
          v-bind:class="'nav-item nav-link-' + app_color + ' active'"
          id="nav-personal-tab"
          data-toggle="tab"
          href="#nav-personal"
          role="tab"
          aria-controls="nav-personal"
          aria-selected="true"
          >Personal</a
        >
        <a
          :class="'nav-item nav-link-' + app_color"
          id="nav-contact-tab"
          data-toggle="tab"
          href="#nav-contact"
          role="tab"
          aria-controls="nav-contact"
          aria-selected="false"
          >Contact Details</a
        >
        <a
          :class="'nav-item nav-link-' + app_color"
          id="nav-visa-tab"
          data-toggle="tab"
          href="#nav-visa"
          role="tab"
          aria-controls="nav-visa"
          aria-selected="false"
          >Visa Details</a
        >
        <a
          :class="'nav-item nav-link-' + app_color"
          id="nav-avetmiss-tab"
          data-toggle="tab"
          href="#nav-avetmiss"
          role="tab"
          aria-controls="nav-avetmiss"
          aria-selected="false"
          >Avetmiss</a
        >
        <a
          :class="'nav-item nav-link-' + app_color"
          id="nav-login-tab"
          data-toggle="tab"
          href="#nav-login"
          role="tab"
          aria-controls="nav-login"
          aria-selected="false"
          >Logins</a
        >
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div
        class="tab-pane fade show active"
        id="nav-personal"
        role="tabpanel"
        aria-labelledby="nav-personal-tab"
      >
        <div>
          <personal-tab></personal-tab>
        </div>
      </div>
      <div
        class="tab-pane fade show"
        id="nav-contact"
        role="tabpanel"
        aria-labelledby="contact-tab"
      >
        <div>
          <contact-tab></contact-tab>
        </div>
      </div>
      <div
        class="tab-pane fade show"
        id="nav-visa"
        role="tabpanel"
        aria-labelledby="visa-tab"
      >
        <div>
          <visa-tab></visa-tab>
        </div>
      </div>
      <div
        class="tab-pane fade show"
        id="nav-avetmiss"
        role="tabpanel"
        aria-labelledby="avetmiss-tab"
      >
        <div>
          <avetmiss-tab></avetmiss-tab>
        </div>
      </div>
      <div
        class="tab-pane fade show"
        id="nav-login"
        role="tabpanel"
        aria-labelledby="login-tab"
      >
        <div>
          <login-tab></login-tab>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import personalTab from "./info/personalComponent.vue";
import contactTab from "./info/contactComponent.vue";
import visaTab from "./info/visaComponent.vue";
import loginTab from "./info/loginsComponent.vue";
import avetmissTab from "./info/avetmissComponent.vue";
export default {
  components: { personalTab, contactTab, visaTab, loginTab, avetmissTab },
  data() {
    return {
      app_color: app_color,
    };
  },
};
</script>

<style>
</style>