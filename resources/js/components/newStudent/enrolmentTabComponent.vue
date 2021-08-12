<template>
  <div>
    <div class="accordion-enrolment" id="enrolment">
    <div v-for="(enrolment,index) in enrolments" :key="enrolment.process_id" class="card">
        <div class="card-header" :id="`heading_${enrolment.process_id}`">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" :data-target="`#enrolment${enrolment.process_id}`" :aria-expanded=" index == 0 ?  'true': 'false'" :aria-controls="`enrolment${enrolment.process_id}`">
             Enrolment # {{ index + 1 }}  (  {{ enrolment.process_id }} )
            </button>
        </h5>
        </div>

        <div :id="`enrolment${enrolment.process_id}`" :class="{'collapse': true,'show':  index == 0}" aria-labelledby="headingOne" data-parent="#enrolment">
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a
                    v-bind:class="'nav-item nav-link-' + app_color + ' active'"
                    id="nav-offerletter-tab"
                    data-toggle="tab"
                    :href="'#nav-offerletter-'+index"
                    role="tab"
                    aria-controls="nav-offerletter"
                    aria-selected="true"
                    >Offer Letter</a
                >
                <a
                    :class="'nav-item nav-link-' + app_color"
                    id="nav-courses-tab"
                    data-toggle="tab"
                    :href="'#nav-courses-'+index"
                    role="tab"
                    aria-controls="nav-courses"
                    aria-selected="false"
                    >Courses</a
                >
                <a
                    :class="'nav-item nav-link-' + app_color"
                    id="nav-ptr-tab"
                    data-toggle="tab"
                    :href="'#nav-ptr-'+index"
                    role="tab"
                    aria-controls="nav-ptr"
                    aria-selected="false"
                    >PTR</a
                >
                </div>
            </nav>
            <div class="tab-content enrolments" id="nav-tabContent">
                <div
                class="tab-pane fade show active"
                :id="'nav-offerletter-'+index"
                role="tabpanel"
                aria-labelledby="nav-offerletter-tab"
                >
                <div>
                    <offer-letter :index="index"></offer-letter>
                </div>
                </div>
                <div
                class="tab-pane courses fade show"
                :id="'nav-courses-'+index"
                role="tabpanel"
                aria-labelledby="nav-courses-tab"
                >
                <div>
                    <course :process_id="enrolment.process_id" :funded_course="enrolment.funded_course"></course>
                </div>
                </div>
                <div
                class="tab-pane fade show"
                :id="'nav-ptr-'+index"
                role="tabpanel"
                aria-labelledby="nav-ptr-tab"
                >
                <div>
                    <ptr :index="index"/>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" :id="`heading_no_enrolment`">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" :data-target="`#no_enrolment`" aria-expanded="true" :aria-controls="`no_enrolment`">
             Courses
            </button>
        </h5>
        </div>
        <div :id="`no_enrolment`" class="collapse show" aria-labelledby="headingTwo" data-parent="#enrolment">
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a
                    v-bind:class="'nav-item nav-link-' + app_color + ' active'"
                    id="nav-offerletter-noep-tab"
                    data-toggle="tab"
                    href="#nav-offerletter-noep"
                    role="tab"
                    aria-controls="nav-offerletter-noep"
                    aria-selected="true"
                    >Offer Letter</a
                >
                <a
                    :class="'nav-item nav-link-' + app_color"
                    id="nav-courses-noep-tab"
                    data-toggle="tab"
                    href="#nav-courses-noep"
                    role="tab"
                    aria-controls="nav-courses-noep"
                    aria-selected="false"
                    >Courses</a
                >
                </div>
            </nav>
            <div class="tab-content enrolments" id="nav-tabContent">
                <div
                class="tab-pane fade show active"
                id="nav-offerletter-noep"
                role="tabpanel"
                aria-labelledby="nav-offerletter-noep-tab"
                >
                <div>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ratione, qui nam nobis hic fugiat deserunt pariatur eligendi vitae dolorem error obcaecati fuga non illo officiis? Animi aperiam odio molestiae fugit!
                </div>
                </div>
                <div
                class="tab-pane courses fade show"
                id="nav-courses-noep"
                role="tabpanel"
                aria-labelledby="nav-courses-noep-tab"
                >
                <div>
                    <course :process_id="0" :funded_course="funded_course"></course>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    </div>
  </div>
</template>

<script>
import offerLetter from './enrolment/offerletter/offerLetterComponent.vue'
import course from './enrolment/course/courseComponent.vue'
import ptr from './enrolment/ptr/ptrComponent.vue'

export default {
  components : {offerLetter,course,ptr},
  data() {
    return {
      app_color: app_color,
    };
  },
  computed: {
    enrolments(){
        return  this.$store.getters.enrolment
    },
    funded_course(){
        return this.$store.getters.funded_course;
    }
  },
};
</script>

<style scoped>
   .courses.tab-pane{
        padding:0!important;
    }
    .accordion-enrolment .card:first-child, .accordion-course .card:first-child{
        border:0!important;
    }
    .card .card-body{
        padding: 10px 3px!important;
    }
</style>