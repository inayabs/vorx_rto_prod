<template>
    <div>
      <div class="row mb-2 d-flex justify-content-between">
            <div class="col-md-6">
                <a href="/course" v-bind:class="'btn btn-'+app_color+' btn-sm text-primary text-light'"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
            </div>
        </div>
      <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Course</h6>
            </div>
            <div class="card-body">
                <div>
                    <nav>
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Info</a>
                          <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-units-tab" data-toggle="tab" href="#nav-units" role="tab" aria-controls="nav-units" aria-selected="true">Units</a>
                          <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-matrix-tab" data-toggle="tab" href="#nav-matrix" role="tab" aria-controls="nav-matrix" aria-selected="false">Course Structure and Fees(International)</a>
                          <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-funded-matrix-tab" data-toggle="tab" href="#nav-funded-matrix" role="tab" aria-controls="nav-funded-matrix" aria-selected="false">Course Structure and Fees(Domestic)</a>
                          <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-prospectus-tab" data-toggle="tab" href="#nav-prospectus" role="tab" aria-controls="nav-prospectus" aria-selected="false">Training Delivery Location</a>
                          <a v-bind:class="'nav-item nav-link-'+app_color" id="nav-attachment-tab" data-toggle="tab" href="#nav-attachment" role="tab" aria-controls="nav-attachment" aria-selected="false">Attachments</a>
                      </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                      <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                          <course-info></course-info>
                      </div>
                      <div class="tab-pane fade" id="nav-units" role="tabpanel" aria-labelledby="nav-units-tab">
                          <course-units></course-units>
                      </div>
                      <div class="tab-pane fade" id="nav-matrix" role="tabpanel" aria-labelledby="nav-matrix-tab">
                          <course-matrix></course-matrix>
                      </div>
                      <div class="tab-pane fade" id="nav-funded-matrix" role="tabpanel" aria-labelledby="nav-funded-matrix-tab">
                          <funded-course-matrix></funded-course-matrix>
                      </div>
                      <div class="tab-pane fade" id="nav-prospectus" role="tabpanel" aria-labelledby="nav-prospectus-tab">
                          <course-prospectus></course-prospectus>
                      </div>
                      <div class="tab-pane fade" id="nav-attachment" role="tabpanel" aria-labelledby="nav-attachment-tab">
                          <course-attachment></course-attachment>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>
<script>
import CourseInfo from "./courseDetailInfoComponent.vue";
import CourseMatrix from "./courseDetailMatrixComponent.vue";
import CourseProspectus from "./courseDetailProspectusComponent.vue";
import FundedCourseMatrix from "./fundedCourseMatrixComponent.vue";
import CourseUnits from "./courseUnitsComponent.vue";
import CourseAttachment from "./courseAttachmentComponent.vue"


export default {
  components: {
    CourseInfo, CourseMatrix, CourseProspectus, FundedCourseMatrix, CourseUnits, CourseAttachment
  },
  data() {
    return {
      course_id: window.course_id,
      app_color: app_color,
    };
  }
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