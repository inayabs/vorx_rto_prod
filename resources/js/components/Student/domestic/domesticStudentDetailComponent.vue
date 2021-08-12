<template>
  <div>
    <toolbar-actions
      v-bind:back-url="`/student`"
      v-bind:warning-letter="`/student/warning-letters/${student_id}`"
    ></toolbar-actions>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-6">
            <h6 :class="'m-0 font-weight-bold text-' + app_color">
              Student Details 
              <!-- <button @click="checkernatkin" >eee</button> -->
              <span>
                ( {{ student_id }} - {{ student_info.firstname }}
                {{ student_info.middlename }} {{ student_info.lastname }} )
                <a
                  :href="this.completion_url"
                  :class="
                    'btn btn-' +
                    app_color +
                    ' text-' +
                    app_color +
                    ' btn-sm text-light'
                  "
                  style="padding: 0px 6px"
                >
                  <i class="fas fa-award fa-sm"></i>
                </a>
              </span>
            </h6>
          </div>
          <div class="col-md-6">
            <div class="form-group row mb-0">
              <label v-if="urole == 'Super-Admin'"
                for="rta"
                class="col-sm-11 col-form-label col-form-label-sm text-right inline-block"
                >Test Student</label
              >
              <div  v-if="urole == 'Super-Admin'" class="col-sm-1 px-0 inline-block">
                <div class="custom-control custom-switch my-0">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    @change="isTest"
                    v-model="is_test"
                    id="is_test"
                  />
                  <label
                    class="custom-control-label"
                    for="is_test"
                  ></label>
                </div>
              </div>
              <label
                for="rta"
                class="col-sm-11 col-form-label col-form-label-sm text-right"
                >Report to Avetmiss</label
              >
              <div class="col-sm-1 px-0">
                <div class="custom-control custom-switch my-0">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    @change="isReport"
                    v-model="report_avetmiss"
                    id="report_avetmiss"
                  />
                  <label
                    class="custom-control-label"
                    for="report_avetmiss"
                  ></label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div>
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a
                v-bind:class="'nav-item nav-link-' + app_color + ' active'"
                id="nav-info-tab"
                data-toggle="tab"
                href="#nav-info"
                role="tab"
                aria-controls="nav-info"
                aria-selected="true"
                >Info</a
              >
              <a
                :class="'nav-item nav-link-' + app_color"
                id="nav-offer-letter-tab"
                data-toggle="tab"
                href="#nav-offer-letter"
                role="tab"
                aria-controls="nav-offer-letter"
                aria-selected="false"
                >Offer Letter</a
              >
              <a
                v-bind:class="'nav-item nav-link-' + app_color"
                id="course-tab"
                data-toggle="tab"
                href="#course"
                role="tab"
                aria-controls="course"
                aria-selected="true"
                >Course</a
              >
              <a
                v-bind:class="'nav-item nav-link-' + app_color"
                id="course-tab"
                data-toggle="tab"
                href="#classes"
                role="tab"
                aria-controls="courses"
                aria-selected="true"
                >Classes</a
              >
              <a
                v-if="course_list.length > 0"
                v-bind:class="'nav-item nav-link-' + app_color"
                id="payments-tab"
                data-toggle="tab"
                href="#payments"
                role="tab"
                aria-controls="payments"
                aria-selected="true"
                >Payments</a
              >
              <a
                v-bind:class="'nav-item nav-link-' + app_color"
                id="avetmiss-tab"
                data-toggle="tab"
                href="#avetmiss"
                role="tab"
                aria-controls="avetmiss"
                aria-selected="true"
                >AVETMISS</a
              >
              <a
                v-bind:class="'nav-item nav-link-' + app_color"
                id="course-progress-tab"
                data-toggle="tab"
                href="#course_progress"
                role="tab"
                aria-controls="course_progress"
                aria-selected="true"
                >Course Progress</a
              >
              <a
                v-bind:class="'nav-item nav-link-' + app_color"
                id="nav-notes-tab"
                data-toggle="tab"
                href="#nav-notes"
                role="tab"
                aria-controls="nav-notes"
                aria-selected="true"
                >Notes</a
              >
              <a
                v-bind:class="'nav-item nav-link-' + app_color"
                id="attachments-tab"
                data-toggle="tab"
                href="#attachments"
                role="tab"
                aria-controls="attachments"
                aria-selected="true"
                >Attachments</a
              >
              <a
                v-if="this.add_on('aiss-attachments') == 1"
                v-bind:class="'nav-item nav-link-' + app_color"
                id="aiss-attachments-tab"
                data-toggle="tab"
                href="#aiss-attachments"
                role="tab"
                aria-controls="aiss-attachments"
                aria-selected="true"
                >AISS Attachments</a
              >
              <a
                v-bind:class="'nav-item nav-link-' + app_color"
                id="workbook-tab"
                data-toggle="tab"
                href="#workbook"
                role="tab"
                aria-controls="workbook"
                aria-selected="true"
                >Workbook</a
              >
              <a
                v-if="ptr != ''"
                v-bind:class="'nav-item nav-link-' + app_color"
                id="ptr-tab"
                data-toggle="tab"
                href="#ptr"
                role="tab"
                aria-controls="ptr"
                aria-selected="true"
                >Pre-training Review</a
              >
              <a
                v-if="
                  wh_List.length > 0 && this.add_on('email-warning.fees') == 1
                "
                v-bind:class="'nav-item nav-link-' + app_color"
                id="warning-tab"
                data-toggle="tab"
                href="#warning"
                role="tab"
                aria-controls="warning"
                aria-selected="true"
                >Warning Letter History</a
              >
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div
              class="tab-pane fade show active"
              id="nav-info"
              role="tabpanel"
              aria-labelledby="nav-info-tab"
            >
              <div>
                <info-tab :student="student"></info-tab>
              </div>
            </div>

            <div
              class="tab-pane fade"
              id="nav-offer-letter"
              role="tabpanel"
              aria-labelledby="nav-offer-letter-tab"
            >
              <div id="accordion">
                <newOffer
                  :offerData="reference"
                  :types="type"
                  :countries="country"
                  :states="state"
                  :agents="agent"
                ></newOffer>
                <offer-letter
                  v-for="datas in offerData"
                  :key="datas.id"
                  :types="type"
                  :refs="reference"
                  :offerData="datas"
                  :countries="country"
                  @checkpaymentHistory="updatePayment($event)"
                  :states="state"
                  :agents="agent"
                ></offer-letter>
              </div>
            </div>

            <div
              class="tab-pane fade show"
              id="course"
              role="tabpanel"
              aria-labelledby="course-tab"
            >
              <div class="accordion" id="accordionExample">
                <div class="card buddoy">
                  <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                      <button
                        class="btn btn-link collapsed"
                        type="button"
                        data-toggle="collapse"
                        data-target="#collapseTwo"
                        aria-expanded="false"
                        aria-controls="collapseTwo"
                      >
                        Add New Course
                      </button>
                    </h2>
                  </div>
                  <div
                    id="collapseTwo"
                    class="collapse"
                    aria-labelledby="headingTwo"
                    data-parent="#accordionExample"
                  >
                    <div class="card-body">
                      <course-details
                        @updateCourse="updateParent($event)"
                        @courseUpdate="updateDoms($event)"
                      ></course-details>
                    </div>
                  </div>
                </div>
                <div
                  class="card buddoy"
                  v-for="course in course_list"
                  :key="course.id"
                >
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
                          {{ course.course_code | courseName }}</span
                        >
                        <span
                          class="badge"
                          :class="`status_${course.status_id}`"
                          >{{ course.status_id | status }}</span
                        >
                      </button>
                      <button
                        @click="deleteCourse(course.id)"
                        class="btn btn-danger float-right"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </h2>
                  </div>
                  <div
                    :id="`course_${course.id}`"
                    class="collapse"
                    :aria-labelledby="`#course_${course.id}_heading`"
                    data-parent="#accordionExample"
                  >
                    <!-- :class="{'show' : index == 0 , 'collapse' : index != 0}" -->
                    <div class="card-body">
                      <course-details
                        :course="course"
                        :subjects="course.courseSubjects"
                        :extraUnits="course.courseExtraUnits"
                        :extraUnitsval="course.slct_extraUnits_val"
                      ></course-details>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="classes"
              role="tabpanel"
              aria-labelledby="classes-tab"
            >
              <div>
                <domclass :updateDom="updateDom"></domclass>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="payments"
              role="tabpanel"
              aria-labelledby="payments-tab"
            >
              <div>
                <payment-details
                  :updateHistory="updateHistory"
                ></payment-details>
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="avetmiss"
              role="tabpanel"
              aria-labelledby="avetmiss-tab"
            >
              <div>
                <avetmiss-details></avetmiss-details>
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="course_progress"
              role="tabpanel"
              aria-labelledby="course-progress"
            >
              <div>
                <completion refs="checkCompletion"></completion>
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="nav-notes"
              role="tabpanel"
              aria-labelledby="nav-notes-tab"
            >
              <div>
                <student-notes></student-notes>
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="attachments"
              role="tabpanel"
              aria-labelledby="attachments-tab"
            >
              <div>
                <student-attachment
                  :updateHistory="updateHistory"
                ></student-attachment>
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="aiss-attachments"
              role="tabpanel"
              aria-labelledby="aiss-attachments-tab"
            >
              <div>
                <student-aiss-attachment></student-aiss-attachment>
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="workbook"
              role="tabpanel"
              aria-labelledby="workbook-tab"
            >
              <div>
                <workbook></workbook>
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="ptr"
              role="tabpanel"
              aria-labelledby="ptr-tab"
            >
              <div id="accordion">
                <ol-ptr :ptr="ptr" @ptrUpdate="ptrUp($event)" />
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="warning"
              role="tabpanel"
              aria-labelledby="warning-tab"
            >
              <div>
                <warning-history :warning="wh_List"></warning-history>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.buddoy {
  overflow: visible !important;
}
</style>

<script>
import ToolbarActions from "../../../components/globals/ToolbarActionsComponent.vue";
import InfoTab from "./infoTabComponent.vue";
import AvetmissDetails from "./avetmissDetailsComponent.vue";
import StudentAttachment from "../attachments/StudentAttachmentComponent.vue";
import StudentAissAttachment from "../aiss-attachments/StudentAISSAttachmentComponent.vue";
import CourseDetails from "./courseDetailsComponent.vue";
import PaymentDetails from "./payments/paymentDetailsComponent.vue";
// import StudentNotes from "../StudentNotesComponent.vue";
import StudentNotes from "../notes/notesComponent.vue";
import Workbook from "../workbookComponent.vue";
import WarningHistory from "../warningLetterHistoryComponent.vue";
import DomClass from "./domClassComponent.vue";
import moment from "moment";
import OfferLetter from "../offerLetter/offerLetterComponent.vue";
import newOffer from "../offerLetter/offerLetterNewComponent";
import completion from "../CourseCompletion/CourseCompletionDetailsComponent";
export default {
  components: {
    ToolbarActions,
    InfoTab,
    AvetmissDetails,
    StudentAttachment,
    StudentAissAttachment,
    CourseDetails,
    PaymentDetails,
    StudentNotes,
    Workbook,
    WarningHistory,
    DomClass,
    OfferLetter,
    newOffer,
    completion,
  },
    props : ['urole'],
  // getWarningHistory(){
  //   axios({
  //     method: "get",
  //     url: `/student/warning-letters/${student_id}`
  //   })
  //   .then(res => {
  //     console.log(res);
  //       let vm = this;
  //       vm.warningHistoryList = res.data.warningHistory;
  //       console.log(vm.warningHistoryList);
  //   })
  //   .catch(err => console.log(err));
  // },
  data() {
    return {
      student: {
        prefix: "",
        firstname: "",
        middlename: "",
        lastname: "",
        gender: "",
        date_of_birth: "",
      },
      report_avetmiss: window.report_avetmiss,
      is_test: window.is_test,
      student_info: window.student_info,
      completion_url: `/course_completion/student/${student_id}`,
      offerData: window.offerData,
      type: [],
      country: [],
      updateDom: false,
      state: [],
      agent: [],
      reference: {},
      course_list: [],
      student_id: window.student_id,
      country: [],
      state: [],
      agent: [],
      isHidden: true,
      app_color: app_color,
      app_settings: app_settings,
      wh_List: [],
      updateHistory: false,
      firstLoad: 1,
      ptr: window.ptr,
      // course_item: '',
      // course_fee_type: ''
    };
  },
  created() {
    this.fetchData();
    
  },
  methods: {
    checkernatkin(){
      let vm = this;
      vm.$children.find(child => {
        if(child.$attrs.refs == 'checkCompletion'){
          child.fetchData();
        }

      })
    },
    isTest(){
      axios.get(`/testdriven/${window.student_id}`).then((res)=>{
          if(res.data.status == 'success'){
             Toast.fire({
              type: "success",
              title: "Student status is updated",
              position: "top-end",
            });
          }else{
             Toast.fire({
              type: "error",
              title: "Something Went Wrong",
              position: "top-end",
            });
          }
      })
    },
    isReport() {
      // console.log(this.report_avetmiss);
      let update_changes = 1;

      if(this.report_avetmiss == false) {
        swal.fire({
          title: "Are you sure?",
          text: "this student will not be included in the reporting!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes!",
        })
        .then((result) => {
          let vm = this;
          if (result.value == true) {
            vm.updateReport();
          }else{
            vm.report_avetmiss = true;
          }
        });
      }else{
        this.updateReport();
      }
      
    },
    updateReport() {
      axios({
          method: "get",
          url: `/student/details/report-avetmiss/${window.student_id}/${this.report_avetmiss}`,
        })
        .then((res) => {
          let vm = this;
          console.log(res.data.status);
          if(res.data.status == 'success') {
            Toast.fire({
              type: "success",
              title: "Report status is updated",
              position: "bottom-end",
            });
          }else if (res.data.status == 'error') {
            let errors = res.data.errors
            let html = '<ul style="margin-left: 10% !important;">';
            vm.report_avetmiss = res.data.value == 1 ? true : false;
            if(typeof errors.data !== 'undefined'){
              errors.data.forEach(v => {
                  html += '<li style="text-align:left !important; color: #ff5757 !important;">'+v+'</li>';
              })
            }

            if(typeof errors.courses !== 'undefined'){
              for (var key in errors.courses) {
                  if (errors.courses.hasOwnProperty(key)) {
                      // console.log(key + " -> " + errors.courses[key]);
                      if(key == '@@@@') {
                        html += '<li style="text-align:left !important; color: #ff5757 !important;"><b>Unit of Competency:</b><ul>';
                      }else{
                        html += '<li style="text-align:left !important; color: #ff5757 !important;"><b>'+key+':</b><ul>';
                      }
                      errors.courses[key].forEach(vv => {
                        html += '<li style="text-align:left !important; color: #ff5757 !important;">'+vv+'</li>';
                      })
                      html += '</ul>';
                  }
              }
            }

            html += '</ul>';
      
            swal.fire({
              type: "error",
              title: "Update required fields for Avetmiss",
              html: html,
            });

          }else if (res.data.status == 'warning') {
            // accepted but has errors in other courses
          }
        })
        .catch((err) => console.log(err));
    },
    fetchData() {
      if (this.firstLoad == 1) {
        swal.fire({
          title: "Loading Student Details...",
          // html: '',// add html attribute if you want or remove
          allowOutsideClick: false,
          onBeforeOpen: () => {
            swal.showLoading();
          },
        });
      }

      axios({
        method: "get",
        url: `/student/getCourse/${window.student_id}`,
      })
        .then((res) => {
          let vm = this;
          vm.wh_List = res.data.warningLetterList.reverse();
          vm.course_list = res.data.course_details.reverse();
          // vm.course_list.forEach(function(el, item) {
          //   if (el.course_fee_type == "FF") {
          //     vm.isHidden = false;
          //   }
          // });
          if (vm.firstLoad == 1) {
            swal.close();
          }
          vm.firstLoad = 1;
        })
        .catch((err) => console.log(err));
      axios
        .get(`/student/${window.student}/info`)
        .then((response) => {
          this.country = response.data.country;
          this.state = response.data.state;
          this.agent = response.data.agent;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    // getWarningHistory(){
    //   axios({
    //     method: "get",
    //     url: `/student/warning-letters/${student_id}`
    //   })
    //   .then(res => {
    //     console.log(res);
    //       let vm = this;
    //       vm.warningHistoryList = res.data.warningHistory;
    //       console.log(vm.warningHistoryList);
    //   })
    //   .catch(err => console.log(err));
    // },
    updatePayment(updateHistory) {
      this.updateHistory = updateHistory;
      this.firstLoad = 0;
    },
    updateParent($event) {
      console.log($event);
      if ($event == "updated") {
        this.firstLoad = 0;
        this.fetchData();
        this.checkernatkin();
        this.updateHistory = true;
        // console.log("ka updated vah");
      }
    },
    updateDoms($event) {
      // console.log(this);
      // this.fetchData();
      // this.$children[4].fetchData();
      this.$children[5].getStudentAttendance();
      // console.log(this.$children[2].getStudentAttendance());
    },
    deleteCourse(id) {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });

      swal
        .fire({
          title: "Are you sure ?",
          text: "You wont be able to revert this!",
          type: "warning",
          width: "40%",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete(`/student/domestic/${id}`)
              .then((response) => {
                // console.log(response);
                if (response.data.status == "success") {
                  this.firstLoad = 0;
                  this.fetchData();
                  // this.updateDoms();
                  this.$children[4].getStudentAttendance();
                  Toast.fire({
                    position: "top-end",
                    type: "success",
                    title: response.data.message,
                  });
                } else {
                  Toast.fire({
                    position: "top-end",
                    type: "error",
                    title: response.data.message,
                  });
                }
              })
              .catch((error) => {
                Toast.fire({
                  position: "top-end",
                  type: "error",
                  title: "Deletion failed",
                });
              });
          }
        });
    },
    add_on(value) {
      // console.log(this.app_settings.add_on);
      let y = 0;
      if (this.app_settings.add_on != null) {
        let x = this.app_settings.add_on.split(",");
        x.forEach((element) => {
          if (element == value) {
            y = 1;
          }
        });
      }
      // return 1 if value matches element
      return y;
    },
  },
  filters: {
    status: function (e) {
      let status = "";
      let student_status = window.student_status;
      student_status.forEach((element) => {
        if (element.id == e) {
          status = element.description;
        }
      });
      return status;
    },
    courseName: function (e) {
      let courseName = "";
      let courses = window.courses;
      courses.forEach((element) => {
        if (element.code == e) {
          courseName = element.name;
        }
      });
      return courseName;
    },
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
.card .card-header span.status_1 {
  color: #fff !important;
  background-color: #343a40 !important;
}
.card .card-header span.status_2,
.card .card-header span.status_3 {
  color: #fff !important;
  background-color: #007bff !important;
}
.card .card-header span.status_4 {
  color: #fff !important;
  background-color: #28a745 !important;
}
.card .card-header span.status_5 {
  color: #fff !important;
  background-color: #dc3545 !important;
}
.card .card-header span.status_6,
.card .card-header span.status_7,
.card .card-header span.status_8,
.card .card-header span.status_9 {
  color: #fff !important;
  background-color: #ffc107 !important;
}
</style>

<style scoped>
.nav {
    display: flex;
    flex-wrap: nowrap;
    padding-left: 0;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    margin-bottom: 0;
    list-style: none;
}
</style>
