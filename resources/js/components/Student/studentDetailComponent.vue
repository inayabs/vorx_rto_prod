<template>
  <div>
    <toolbar-actions
      
      v-bind:back-url="`/student`"
    ></toolbar-actions>
    <!-- <div class="row mb-2 d-flex justify-content-between">
      <div class="col-md-6">
        <a href="/student" class="btn btn-primary btn-sm text-primary text-light">
          <i class="fas fa-long-arrow-alt-left"></i> Back
        </a>
      </div>
    </div>-->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-6">
            <h6 :class="'m-0 font-weight-bold text-' + app_color">
              Student Detail
              <span>
                ( {{ id }} - {{ student.firstname }} {{ student.middlename }}
                {{ student.lastname }} )
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
                class="col-sm-11 col-form-label col-form-label-sm text-right inline-block"
                >Report to Avetmiss</label
              >
              <div class="col-sm-1 px-0 inline-block">
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
                :class="'nav-item nav-link-' + app_color + ' active'"
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
                v-if="offerletterData.length > 0"
                :class="'nav-item nav-link-' + app_color"
                id="nav-course-tab"
                data-toggle="tab"
                href="#nav-courses"
                role="tab"
                aria-controls="nav-course"
                aria-selected="false"
                >Courses</a
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
                :class="'nav-item nav-link-' + app_color"
                id="nav-notes-tab"
                data-toggle="tab"
                href="#nav-notes"
                role="tab"
                aria-controls="nav-notes"
                aria-selected="false"
                >Notes</a
              >
              <a
                v-if="offerletterData.length > 0"
                :class="'nav-item nav-link-' + app_color"
                id="nav-completion-tab"
                data-toggle="tab"
                href="#nav-completion"
                role="tab"
                aria-controls="nav-completion"
                aria-selected="false"
                >Payments</a
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
                v-if="offerletterData.length > 0"
                :class="'nav-item nav-link-' + app_color"
                id="nav-attachment-tab"
                data-toggle="tab"
                href="#nav-attachment"
                role="tab"
                aria-controls="nav-attachment"
                aria-selected="false"
                >Attachments</a
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
              <a
                :class="'nav-item nav-link-'+app_color"
                id="nav-checklist-tab"
                data-toggle="tab"
                href="#nav-completion_course"
                role="tab"
                aria-controls="nav-completion_course"
                aria-selected="false"
              >Course Progress</a>
            </div>
          </nav>

          <div class="tab-content" id="nav-tabContent">
            <div
              class="tab-pane fade show active"
              id="nav-info"
              role="tabpanel"
              aria-labelledby="nav-info-tab"
            >
              <student-info ref="studentInfo" :student="student"></student-info>
            </div>
            <div
              v-if="offerletterData.length == 0"
              class="tab-pane fade"
              id="nav-offer-letter"
              role="tabpanel"
              aria-labelledby="nav-offer-letter-tab"
            >
              <!-- <offer-letter :types="type" :countries="country" :states="state"></offer-letter> -->
              <div id="accordion">
                <newOffer
                  :types="type"
                  :countries="country"
                  :states="state"
                  :agents="agent"
                ></newOffer>
              </div>
            </div>
            <div
              v-else
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
                  v-for="datas in offerletterData"
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
              class="tab-pane fade"
              id="nav-notes"
              role="tabpanel"
              aria-labelledby="nav-notes-tab"
            >
              <!-- <notes :types="type" :countries="country" :states="state"></notes> -->
              <div id="accordion">
                <student-notes></student-notes>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="nav-completion"
              role="tabpanel"
              aria-labelledby="nav-completion-tab"
            >
              <!-- <course-info></course-info> -->
              <div id="accordionExample" v-if="offerletterData.length > 0">
                <!-- <online-cash></online-cash> -->
                
                <payment
                  v-for="data in offerletterData"
                  :refs="reference"
                  :offerid="data.id"
                  :fees="data.fees"
                  :offerData="data.course_details"
                  :detail="data"
                  :key="data.id"
                  :updateHistory="updateHistory"
                ></payment>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="nav-courses"
              role="tabpanel"
              aria-labelledby="nav-course-tab"
            >
              <!-- <course-info></course-info> -->
              <div id="accordionExample" v-if="offerletterData.length > 0">
                <!-- <online-cash></online-cash> -->
                <course-details
                  v-for="data in offerletterData"
                  :courses="data.course_details"
                  :refs="reference"
                  :offerid="data.id"
                  :offer="data.student_details"
                  :key="data.id"
                ></course-details>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="classes"
              role="tabpanel"
              aria-labelledby="classes-tab"
            >
              <div>
                <domclass ref="updatedoms" :updateDom="updateDom"></domclass>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="nav-avetmiss"
              role="tabpanel"
              aria-labelledby="nav-attachment-tab"
            >
              <!-- <avetmiss-details></avetmiss-details> -->
            </div>
            <div
              class="tab-pane fade"
              id="nav-attachment"
              role="tabpanel"
              aria-labelledby="nav-attachment-tab"
            >
              <student-attachment
                :updateHistory="updateHistory"
              ></student-attachment>
            </div>

            <!-- workbook -->
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

            <!-- ptr -->
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
             <div
                      class="tab-pane fade"
                      id="nav-completion_course"
                      role="tabpanel"
                      aria-labelledby="nav-checklist-tab"
                    >
                    <completion ref="completion"></completion>
                    <!-- <check-list :checknumber="id" :cl="checklist"></check-list>  -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import onlineCash from "./offerLetter/payments/onlinecashComponent.vue";
import StudentInfo from "./studentDetailInfoComponent.vue";
import StudentAttachment from "./attachments/StudentAttachmentComponent.vue";
// import OfferLetter from "./studentDetailOfferLetterComponent.vue";
import OfferLetter from "./offerLetter/offerLetterComponent.vue";
import newOffer from "./offerLetter/offerLetterNewComponent";
import payment from "./offerLetter/paymentComponent.vue";
import StudentNotes from "./StudentNotesComponent.vue";
// import checkList from "./offerLetter/offerLetterChecklistComponent.vue";
import moment from "moment";
import ToolbarActions from "./../../components/globals/ToolbarActionsComponent.vue";
import WarningHistory from "./warningLetterHistoryComponent.vue";
import CourseDetails from "./coursesComponent.vue";
import AvetmissDetails from "./domestic/avetmissDetailsComponent.vue";
import Workbook from "./workbookComponent.vue";
import Ptr from "./offerLetter/ptrComponent.vue";
import DomClass from "./domestic/domClassComponent.vue";
import completion from "../Student/CourseCompletion/CourseCompletionDetailsComponent";

export default {
  components: {
    StudentInfo,
    OfferLetter,
    newOffer,
    payment,
    onlineCash,
    StudentAttachment,
    StudentNotes,
    ToolbarActions,
    WarningHistory,
    CourseDetails,
    AvetmissDetails,
    DomClass,
    Workbook,
    Ptr,
    completion, 
    // checkList
  },
   props : ['urole'],
  created() {
    this.fetchStudent();
  },
  data() {
    return {
      report_avetmiss: window.report_avetmiss,
      is_test: window.is_test,
      id: window.student_id,
      app_color: app_color,
      app_settings: app_settings,
      updateHistory: false,
      completion_url: `/course_completion/student/${window.student_id}`,
      student: {
        prefix: "",
        firstname: "",
        middlename: "",
        lastname: "",
        gender: "",
        date_of_birth: "",
      },
      englishTestData: {},
      type: [],
      country: [],
      state: [],
      agent: [],
      reference: {},
      offerletterData: [],
      checklist: [],
      credits: 0,
      wh_List: [],
      firstLoad: 1,
      ptr: window.ptr,
      updateDom: false,
      course_data: false,
      payment_data: false,
    };
  },
  methods: {
    isTest(){
      axios.get(`/testdriven/${this.id}`).then((res)=>{
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
      let update_changes = 1;

      if(this.report_avetmiss == false) {
        swal
        .fire({
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
            vm.x();
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
          url: `/student/details/report-avetmiss/${this.id}/${this.report_avetmiss}`,
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
    ptrUp() {
      this.updateHistory = !this.updateHistory;
    },
    updatePayment(updateHistory) {
      this.updateHistory = updateHistory;
      // this.firstLoad = 0;
      this.fetchStudentOfferLetter();
    },
    fetchStudent() {
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

      axios
        .get(`/student/${window.student}/info`)
        .then((response) => {
          const data = response.data.student;
          this.student.prefix = data.party.person.prefix;
          this.student.firstname = data.party.person.firstname;
          this.student.middlename = data.party.person.middlename;
          this.student.lastname = data.party.person.lastname;
          this.student.gender = data.party.person.gender;
          this.englishTestData = data.englist_test;
          this.student.date_of_birth = moment(
            data.party.person.date_of_birth
          )._d;
          this.student.student_id =
            data.student_id == null ? `ETI${window.student}` : data.student_id;

          this.type = response.data.type;
          this.country = response.data.country;
          this.state = response.data.state;
          this.agent = response.data.agent;
          this.wh_List = response.data.emailTrail;
          // this.checklist =
          //   data.checklist.checklist != null
          //     ? JSON.parse(data.checklist.checklist)
          //     : [];

          this.fetchStudentOfferLetter();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchStudentOfferLetter() {
      const offerletterData = [];

      axios
        .get("/offer-letter/" + window.student_id)
        .then((res) => {
          this.offerletterData = res.data;
          this.reference = this.offerletterData[0];
          if (this.firstLoad == 1) {
            // if(this.course_data == true && this.payment_data == true){
              swal.close();
            // }
          }
        this.firstLoad = 1;
        })
        .catch((err) => {
          console.log(err);
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

<style scoped>
.nav {
    display: flex;
    flex-wrap: nowrap;
    padding-left: 0;
    overflow-x: auto;
    overflow-y: auto;
    white-space: nowrap;
    margin-bottom: 0;
    list-style: none;
}
/* width */
.nav::-webkit-scrollbar {
  width: 3px;
}

/* Track */
.nav::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
.nav::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
.nav::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
</style>