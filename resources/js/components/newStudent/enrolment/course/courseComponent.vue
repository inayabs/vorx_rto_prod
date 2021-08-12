<template>
  <div>
      <div class="accordion" id="accordionExample">
        <div v-if="roles != 'Staff'" class="card buddoy">
                  <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                      <button
                        class="btn btn-link collapsed"
                        type="button"
                        data-toggle="collapse"
                        :data-target="`#addCourse_${process_id}`"
                        aria-expanded="false"
                        :aria-controls="`addCourse_${process_id}`"
                      >
                        Add New Course
                      </button>
                    </h2>
                  </div>
                  <div
                    :id="`addCourse_${process_id}`"
                    class="collapse"
                    aria-labelledby="headingTwo"
                    data-parent="#accordionExample"
                  >
                    <div class="card-body">
                      <course-details :process_id="process_id"></course-details>
                      <!-- <course-details
                        @updateCourse="updateParent($event)"
                        @courseUpdate="updateDoms($event)"
                      ></course-details> -->
                    </div>
                  </div>
                </div>
                <div class="card buddoy" v-for="(course,index) in funded_course"
                  :key="course.id">
                  <div class="card-header" :id="`course_${course.id}_heading`">
                    <h2 class="mb-0">
                      <button
                        class="btn btn-link"
                        type="button"
                        data-toggle="collapse"
                        :data-target="`#course_${course.id}`"
                        aria-expanded="false"
                        :arial-controls="`course_${course.id}`"
                      >
                        <!-- :aria-expanded="index == 0 ? 'true' : 'false'" -->
                        <span v-if="course.course_code == '@@@@'"
                          >Unit of Competency
                          <span v-if="course.uc_description != null">
                            - {{ course.uc_description }}</span
                          ></span
                        >
                        <span v-else
                          >{{ course.course_code }} -
                          {{ course.course.name }}</span
                        >
                        <span
                          class="badge"
                          :class="`status_${course.status_id}`"
                          >{{ course.status.description }}</span
                        >
                      </button>
                      <button
                        :disabled="roles == 'Staff'? true : false "
                        @click="deleteCourse(course.id)"
                        class="btn btn-danger float-right"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </h2>
                  </div>
                  <div
                    :id="`course_${course.id}`"
                    class="collapse show"
                    :aria-labelledby="`#course_${course.id}_heading`"
                    data-parent="#accordionExample"
                  >
                    <!-- :class="{'show' : index == 0 , 'collapse' : index != 0}" -->
                    <div class="card-body">
                           <!-- COURSE DETAILS (Tabs)-->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a
                                    v-bind:class="'nav-item nav-link-' + app_color + ' active'"
                                    :id="`nav-course-info-tab-${course.id}`"
                                    data-toggle="tab"
                                    :href="`#nav-course-info-${course.id}`"
                                    role="tab"
                                    aria-controls="nav-course-info"
                                    aria-selected="true"
                                    >Course Details</a
                                >
                                <a
                                    :class="'nav-item nav-link-' + app_color"
                                    :id="`nav-payments-tab-${course.id}`"
                                    data-toggle="tab"
                                    :href="`#nav-payments-${course.id}`"
                                    role="tab"
                                    aria-controls="nav-payments"
                                    aria-selected="false"
                                    >Payments</a
                                >
                                <a
                                    :class="'nav-item nav-link-' + app_color"
                                    :id="`nav-completion-tab-${course.id}`"
                                    data-toggle="tab"
                                    :href="`#nav-completion-${course.id}`"
                                    role="tab"
                                    aria-controls="nav-completion"
                                    aria-selected="false"
                                    >Completion</a>
                                 <a
                                    :class="'nav-item nav-link-' + app_color"
                                    :id="`nav-certificate-tab-${course.id}`"
                                    data-toggle="tab"
                                    :href="`#nav-certificate-${course.id}`"
                                    role="tab"
                                    aria-controls="nav-certificate"
                                    aria-selected="false"
                                    >Certificate</a>
                                    <a
                                    :class="'nav-item nav-link-' + app_color"
                                    :id="`nav-attendance-tab-${course.id}`"
                                    data-toggle="tab"
                                    :href="`#nav-attendance-${course.id}`"
                                    role="tab"
                                    aria-controls="nav-attendance"
                                    aria-selected="false"
                                    >Attendance</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div
                                class="tab-pane fade show active"
                                :id="`nav-course-info-${course.id}`"
                                role="tabpanel"
                                aria-labelledby="nav-course-info-tab"
                                >
                                <div>
                                    <course-details
                                      :funded_course="funded_course"
                                      :course="course_details"
                                      :subjects="course_details.courseSubjects"
                                      :extraUnits="course_details.courseExtraUnits"
                                      :process_id="process_id"
                                    ></course-details>
                                </div>
                                </div>
                                <div
                                class="tab-pane fade show"
                                :id="`nav-payments-${course.id}`"
                                role="tabpanel"
                                aria-labelledby="nav-payments-tab"
                                >
                                <div>
                                    <payment-details :detail="course"></payment-details>
                                </div>
                                </div>
                                <div
                                class="tab-pane fade show"
                                :id="`nav-completion-${course.id}`"
                                role="tabpanel"
                                aria-labelledby="nav-completion-tab"
                                >
                                <div>
                                  <completion @updateData="updateCertList($event)" :completionData="completionData" :completion="course_details.completion" ></completion>
                                </div>
                                </div>
                                <div
                                class="tab-pane fade show"
                                :id="`nav-certificate-${course.id}`"
                                role="tabpanel"
                                aria-labelledby="nav-certificate-tab"
                                >
                                <div>
                                    <certificate  @updateData="updateCertList($event)" @editCompletion="EditCompletion($event)" :course="course.id" :certificate="course_details.completion.certificate" ></certificate>
                                </div>
                                </div>
                                <div
                                class="tab-pane fade show"
                                :id="`nav-attendance-${course.id}`"
                                role="tabpanel"
                                aria-labelledby="nav-attendance-tab"
                                >
                                <div>
                                    <attendance :attendance="funded_course[index].attendance"/>
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

import moment from 'moment';
import { mapGetters, mapMutations } from "vuex";
import courseDetails from '../../enrolment/course/courseDetailsComponent.vue';
import paymentDetails from '../../enrolment/course/paymentDetailsComponent.vue';
import completion from '../../enrolment/course/completionComponent.vue';
import certificate from '../../enrolment/course/certificateComponent.vue';
import attendance from '../../enrolment/course/attendanceComponent.vue';

export default {
  components : {courseDetails,paymentDetails,completion,certificate,attendance},
  data() {
    return {
      app_color : app_color,
      completionData :{},
      roles: null,
    };
  },
  // created() {
  //     // console.log(this.$store.getters.enrolment[this.index].process_id);
  //     // console.log(this.index);
  //     console.log(this.process_id);
  //     console.log(this.funded_course.process_id);
  // },
  props:['process_id','funded_course'],
  computed : {
            student_type(){
                return this.$store.getters.student_type;
            },
            attendance(){
                // return this.$store.getters.attendance;
            },
            course_details(){
              return this.getCourseDetails();
            }
        },
  mounted(){
    if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  methods: {
    getCourseDetails: function() {
              // console.log(this.funded_course);
              let vm = this;
              let course_details = {};
              let cd = {};
              let att = this.attendance;
              let class_id = 0;

              if(vm.funded_course.length >= 1){

                vm.funded_course.map((element, key) => {
                  cd = element;
                })

                // get class_id
                // console.log('dara');
                // console.log(att);
                // if(att.length >= 1){
                //   att.map((element, key) => {
                //     if(cd.course_code == element.course_code){
                //       class_id = element.class_id
                //     }
                //   })
                // }

                let arr_subjects = [];
                let arr_extraUnits = [];
                let course_com = [];

                if(cd.offer_letter_course_detail_id != null){
                  // student_course_id by offer_letter_course_detail_id (course_completion)
                  if(this.student_type.id == cd.course_completion_by_ol.student_type){
                    course_com = cd.course_completion_by_ol;
                  }
                }else{
                  // student_course_id by funded course id (course_completion)
                  course_com = cd.course_completion;
                }
                // console.log(course_com);
                if(course_com != null){
                  let com_details = course_com.completion.details;
                  if(com_details.length > 0){

                    let dates = [];
                    // console.log(com_details);
                    com_details.map((el, key) => {
                      if (el.start_date != null && el.end_date != null) {
                          dates = {
                              start_date: moment(el.start_date)._d,
                              end_date:  moment(el.end_date)._d
                        };
                      }

                      if(el.extra_unit == 0){
                        // console.log('asaas');
                        arr_subjects.push({
                          subject_code:      el.course_unit_code,
                          description:       el.unit.description,
                          unit_type:         el.unit.unit_type,
                          dates:             dates,
                          train_org_loc_id:  el.train_org_loc_id,
                          delivery_mode_id:  el.delivery_mode_id,
                          order:             el.order,
                        })
                      }else{
                        // console.log('yo');
                        let utype = '';
                          if (el.unit.unit_type != null) {
                              utype =  el.unit.unit_type;
                          }
                          arr_extraUnits.push({
                            subject_code:      el.course_unit_code,
                            description:       el.unit.description,
                            unit_type:         utype,
                            dates:             dates,
                            train_org_loc_id:  el.train_org_loc_id,
                            delivery_mode_id:  el.delivery_mode_id,
                            order:             el.order,
                        })
                      }


                    })
                  }
                  // this.getCourseUnitDesc()
                }

                arr_subjects = this.sortByOrder(arr_subjects);
                arr_extraUnits = this.sortByOrder(arr_extraUnits);

                course_details  = {
                  //Course Details
                  id                : cd.id,
                  student_id        : cd.student_id,
                  process_id        : cd.process_id !== null ? cd.process_id : null,
                  course_code       : cd.course_code,
                  name              : cd.course != null ? cd.course.name : 'Unit of Competency',
                  eligibility       : cd.eligibility,
                  location          : cd.location,
                  start_date        : moment(cd.start_date)._d,
                  end_date          : moment(cd.end_date)._d,
                  course_fee        : cd.course_fee,
                  course_fee_type   : cd.course_fee_type,
                  status_id        : cd.status_id,
                  agent_id         : cd.agent_id,
                  aiss_date        :  moment(cd.aiss_date)._d,
                  class             : class_id,
                  remarks           : cd.remarks,
                  uc_description:      cd.uc_description,
                  // Subject List
                  courseSubjects:     arr_subjects,
                  courseExtraUnits:        arr_extraUnits,
                  // Enrolment Details
                  outcome_id_national :                       cd.detail.outcome_id_national !== null ? cd.detail.outcome_id_national : '',
                  funding_source_national :                   cd.detail.funding_source_national !== null ? cd.detail.funding_source_national : '',
                  commence_prg_identifier:                    cd.detail.commence_prg_identifier !== null ? cd.detail.commence_prg_identifier : '',
                  training_contract_id:                       cd.detail.training_contract_id !== null ? cd.detail.training_contract_id : '',
                  client_id_apprenticeships:                  cd.detail.client_id_apprenticeships !== null ? cd.detail.client_id_apprenticeships : '',
                  study_reason_id:                            cd.detail.study_reason_id !== null ? cd.detail.study_reason_id : '',
                  specific_funding_id:                        cd.detail.specific_funding_id !== null ? cd.detail.specific_funding_id : '',
                  funding_type:                               cd.detail.funding_type !== null ? cd.detail.funding_type : '',
                  funding_source_state_training_authority:     cd.detail.funding_source_state_training_authority !== null ? cd.detail.funding_source_state_training_authority : '',
                  purchasing_contract_id:                      cd.detail.purchasing_contract_id !== null ? cd.detail.purchasing_contract_id : '',
                  purchasing_contract_schedule_id:             cd.detail.purchasing_contract_schedule_id !== null ? cd.detail.purchasing_contract_schedule_id : '',
                  associated_course_id:                        cd.detail.associated_course_id !== null ? cd.detail.associated_course_id : '',
                  predominant_delivery_mode:                   cd.detail.predominant_delivery_mode !== null ? cd.detail.predominant_delivery_mode : '',
                  full_time_leaning_option:                    cd.detail.full_time_leaning_option !== null ? cd.detail.full_time_leaning_option : '',
                  completion:                                  course_com.completion
                  }

              }
              return course_details;
    },
    updateCertList(event){
      console.log(event);
      if(event.status == 'success'){
        this.course_details.completion.certificate.details.push(event.data);
        // console.log(this.course_details.completion);
      }else{
        let nArr = [];
        this.course_details.completion.certificate.details.filter(element =>{
          if(element.id != event.data){
            nArr.push(element)
          }
        })
        this.course_details.completion.certificate.details = nArr;
      }
    },
    EditCompletion(event){
      console.log(event)
      this.completionData = event;
    },
    sortByOrder: function(arr) {
      // Set slice() to avoid to generate an infinite loop! eh?
      return arr.slice().sort(function(a, b) {
        return a.order - b.order;
      });
    }
  }
};
</script>
