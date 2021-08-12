<template>
    <div>
      <div class="row mb-2 d-flex justify-content-between">
            <div class="col-md-6">
                <!-- <a href="/course" v-bind:class="'btn btn-'+app_color+' btn-sm text-primary text-light'"><i class="fas fa-long-arrow-alt-left"></i> Back</a> -->
            </div>
        </div>
      <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Course Setup Wizard</h6>
            </div>
            <div class="card-body">
                <div>
                    <nav>
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Course</a>
                          <a v-bind:class="'nav-item disabled nav-link-'+app_color" id="nav-units-tab" data-toggle="tab" href="#nav-units" role="tab" aria-controls="nav-units" aria-selected="true">Units</a>
                          <a v-bind:class="'nav-item disabled nav-link-'+app_color" id="nav-prospectus-tab" data-toggle="tab" href="#nav-prospectus" role="tab" aria-controls="nav-prospectus" aria-selected="false">Course Delivery Location</a>
                          <a v-bind:class="'nav-item disabled nav-link-'+app_color" id="nav-matrix-tab" data-toggle="tab" href="#nav-matrix" role="tab" aria-controls="nav-matrix" aria-selected="false">Course Structure and Fees</a>
                          <!-- <a v-bind:class="'nav-item disabled nav-link-'+app_color" id="nav-package-tab" data-toggle="tab" href="#nav-package" role="tab" aria-controls="nav-package" aria-selected="false">Course Package</a> -->
                          <a v-bind:class="'nav-item disabled nav-link-'+app_color" id="nav-class-tab" data-toggle="tab" href="#nav-class" role="tab" aria-controls="nav-class" aria-selected="false">Class</a>
                      </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                      <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                          <course-info></course-info>
                      </div>
                      <div class="tab-pane fade" id="nav-units" role="tabpanel" aria-labelledby="nav-units-tab">
                          <course-units></course-units>
                      </div>
                      <div class="tab-pane fade" id="nav-prospectus" role="tabpanel" aria-labelledby="nav-prospectus-tab">
                          <course-prospectus></course-prospectus>
                      </div>
                      <div class="tab-pane fade" id="nav-matrix" role="tabpanel" aria-labelledby="nav-matrix-tab">
                          <course-matrix></course-matrix>
                      </div>
                      <!-- <div class="tab-pane fade" id="nav-package" role="tabpanel" aria-labelledby="nav-package-tab">
                          <course-package></course-package>
                      </div> -->
                      <div class="tab-pane fade" id="nav-class" role="tabpanel" aria-labelledby="nav-class-tab">
                          <course-class></course-class>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import Vue from 'vue'
import Vuex from 'vuex'

const store = new Vuex.Store({
  state : {
    // for course tab
    course: {},
    course_opt: {},
    // for units tab
    units: [],
    unit_opt: {
          assessment_method: window.am,
          unit_field_educ : window.unit_educ_field,
          training_methods : window.training_methods,
    },
    // for prospectus tab
    course_prospectus: [],
    course_locations: [],
    prospectus_opt: {
      slct_state : window.slct_state,
      slct_option_state : window.slct_option_state,
      slct_training_dlvr_loc: window.slct_training_dlvr_loc,
      org_name: window.org_name,
      delivery_loc: window.delivery_loc,
    },

    // for structure and fees
    structure_fees: [],

    // for course package
    course_package: [],
    cur_course_package: window.course_package,

    // for class
    classes: [],
    class_opt: {
      trainers : window.trainers,
    }
  },
  mutations: {

  },
  actions: {
    
  },
  getters: {

  }
});

import CourseInfo from "./courseInfoComponent.vue";
import CourseMatrix from "./courseMatrixComponent.vue";
import CourseProspectus from "./courseProspectusComponent.vue";
import CourseUnits from "./courseUnitsComponent.vue";
import CoursePackage from "./coursePackageComponent.vue";
import CourseClass from "./classComponent.vue";



export default {
  store,
  components: {
    CourseInfo, 
    CourseMatrix, 
    CourseProspectus, 
    CourseUnits,
    CoursePackage,
    CourseClass,
  },
  data() {
    return {
      course_id: window.course_id,
      app_color: app_color,
    };
  },
  created() {
    // console.log(store.state);
  },
};
</script>
<style>
.tab-pane {
  border: 1px solid #e0dfdf;
  border-top: none;
  padding: 1.3rem;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
  background-color: #ffffff;
}
</style>