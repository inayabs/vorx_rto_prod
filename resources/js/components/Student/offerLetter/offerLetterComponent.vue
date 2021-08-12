<template>
  <div>
    <div class="card">
      <div class="card-header" :id="'heading' + offerData.id">
        <h5 class="mb-0">
          <button
            v-if="offerData.id == refs.id"
            class="btn btn-link d-inline-block"
            data-toggle="collapse"
            :data-target="'#course' + offerData.id"
            aria-expanded="false"
            :aria-controls="offerData.id"
          >
            Offer Letter ({{ offerData.course_details[0].course_code }}) NEW
            APPLICATION
          </button>
          <button
            v-else
            class="btn btn-link d-inline-block"
            data-toggle="collapse"
            :data-target="'#course' + offerData.id"
            aria-expanded="false"
            :aria-controls="offerData.id"
          >
            Offer Letter ({{ offerData.course_details[0].course_code }})
          </button>
          <div class="d-inline-block float-right">
            <button
              :disabled="roles == 'Staff'? true : false "
              @click="sendEnrolmentEmail(offerData.id)"
              class="btn btn-warning"
            >
              <i class="fas fa-envelope"></i>
            </button>
            <a
              target="_blank"
              :href="`/offer-letter/pdf/preview/${offerData.id}`"
              class="btn btn-info"
            >
              <i class="fas fa-file-pdf"></i>
            </a>
            <button
             :disabled="roles == 'Staff'? true : false "
              @click="deleteOfferLetter(offerData.id)"
              class="btn btn-danger"
            >
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </h5>
      </div>
      <div
        :id="'course' + offerData.id"
        class="collapse"
        :aria-labelledby="'heading' + offerData.id"
        data-parent="#accordion"
      >
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
              <!-- <a :href="`/offer-letter/${offerData.id}/offer_create_pdf`"> -->
                <button :disabled="roles == 'Staff'? true : false " class="btn btn-success" @click="createdPDF()">
                  <i class="fas fa-pdf"></i> Create Offer Letter PDF
                </button>
              <!-- </a> -->
              <button :disabled="roles == 'Staff'? true : false " class="btn btn-success" @click="saveChanges()">
                <i class="far fa-save"></i> Update Changes
              </button>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="clearfix mb-2"></div>
          <!-- student info start  -->
          <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
            <h6>Student Information</h6>
          </div>
          <student-info v-bind="$props"></student-info>
          <div class="clearfix mb-5"></div>
          <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
            <h6>Address / Contact Information</h6>
          </div>
          <address-contact-info v-bind="$props"></address-contact-info>
          <div class="clearfix mb-5"></div>
          <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
            <h6>Passport / Visa Information</h6>
          </div>
          <passport-info></passport-info>
          <div class="clearfix mb-5"></div>

          <div class="clearfix mb-5"></div>
          <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
            <h6>Package Information</h6>
          </div>
          <package-info></package-info>
          <div class="clearfix mb-5"></div>
          <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
            <h6>Confrimation of Enrolment (COE) Verification</h6>
          </div>
          <coe-verify></coe-verify>
          <!-- <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
            <h6>Checklist Information</h6>
          </div>
          <checklist-info :checknumber="offerData.id"></checklist-info>
          <div class="clearfix mb-5"></div>-->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import studentInfo from "./offerLetterStudentInfoComponent.vue";
import addressContactInfo from "./offerLetterAddressContactInfoComponent.vue";
import passportInfo from "./offerLetterPassportInfoComponent.vue";
import packageInfo from "./offerLetterPackageComponent.vue";
import coeVerify from "./offerLetterCOEComponent.vue";
// import checklistInfo from "./offerLetterChecklistComponent.vue";
export default {
  components: {
    studentInfo,
    addressContactInfo,
    passportInfo,
    packageInfo,
    coeVerify,
    // checklistInfo
  },
  props: ["types", "countries", "states", "agents", "offerData", "refs"],

  data() {
    return {
      offerDatas: [],
      app_color: app_color,
      update: false,
      roles : null
    };
  },
  created(){
     if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  mounted() {
    this.alignData();
  },
  methods: {
    createdPDF(){
      swal
          .fire({
            title: "Are you sure ?",
            text:
              "Creating new Offer Letter will delete the EXISTING.",
            type: "warning",
            width: "25%",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Continue!",
          })
          .then((result) => {
            if (result.value) {
              swal.fire({
                title: "Please wait...",
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                  swal.showLoading();
                },
              });
              this.offerDatas = this.fetchAllData();
              axios
                .get(
                  "/offer-letter/" + this.offerData.id+ "/offer_create_pdf"
                )
                .then((res) => {
                  if (res.data.status == "success") {
                    swal.fire({
                      type: "success",
                      title: "Update Successfuly",
                    });
                    // this.$emit("checkpaymentHistory", true);
                    // this.update = false;
                  } else {
                    swal.fire({
                      type: "error",
                      title: "Failed to create offer letter pdf",
                    });
                  }
                  // console.log(res);
                })
                .catch((err) => {
                  swal.fire({
                    type: "error",
                    title: "Failed to create offer letter pdf",
                  });
                });
            }
          });
    },
    saveChanges() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
      });

      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });

      if (this.update) {
        swal
          .fire({
            title: "Are you sure ?",
            text:
              "Updating Initial Payment or Weekly Payment or Discount will create new offer letter acceptance and agreement and DELETE existing payment schedule",
            type: "warning",
            width: "25%",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Continue!",
          })
          .then((result) => {
            if (result.value) {
              swal.fire({
                title: "Please wait...",
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                  swal.showLoading();
                },
              });
              this.offerDatas = this.fetchAllData();
              axios
                .put(
                  "/offer-letter/" + this.offerData.id,
                  JSON.stringify(this.offerDatas),
                  {
                    headers: {
                      "content-type": "application/json",
                    },
                  }
                )
                .then((res) => {
                  if (res.data.status == "success") {
                    swal.fire({
                      type: "success",
                      title: "Update Successfuly",
                    });
                    this.$emit("checkpaymentHistory", true);
                    this.update = false;
                  } else {
                    swal.fire({
                      type: "error",
                      title: "Failed to Update student",
                    });
                  }
                  // console.log(res);
                })
                .catch((err) => {
                  swal.fire({
                    type: "error",
                    title: "Failed to Update student",
                  });
                });
            }
          });
      } else {
        this.$emit("checkpaymentHistory", false);
        this.offerDatas = this.fetchAllData();
        axios
          .put(
            "/offer-letter/" + this.offerData.id,
            JSON.stringify(this.offerDatas),
            {
              headers: {
                "content-type": "application/json",
              },
            }
          )
          .then((res) => {
            if (res.data.status == "success") {
              Toast.fire({
                type: "success",
                title: "Update Successfuly",
              });
            } else {
              Toast.fire({
                type: "error",
                title: "Failed to Update student",
              });
            }
            // console.log(res);
          })
          .catch((err) => {
            Toast.fire({
              type: "error",
              title: "Failed to Update student",
            });
          });
      }
    },
    fetchAllData() {
      this.offerDatas = [];
      let data = [];
      let p = {};
      $.each(this.$children, function (key, value) {
        if (value.$vnode.componentOptions.tag == "student-info") {
          p = {
            party_id: window.student,
            student_id: value.student_id,
            student_type: value.student_type,
            country_of_birth: value.country_of_birth,
            issued_date:
              value.issue_date != ""
                ? moment(value.issue_date)
                : value.issue_date,
            reference_id: value.reference_id,
            agent: value.agent,
          };
        } else if (
          value.$vnode.componentOptions.tag == "address-contact-info"
        ) {
          (p.email_personal = value.email_personal),
            (p.telephone = value.telephone),
            (p.mobile = value.mobile),
            (p.current_address = value.current_address),
            (p.home_address = value.home_address),
            (p.country = value.country),
            (p.state_province = value.state_province),
            (p.postcode = value.postcode);
        } else if (value.$vnode.componentOptions.tag == "passport-info") {
          (p.passport_num = value.passport_num),
            (p.visa_num = value.visa_num),
            (p.expiry_date =
              value.expiry_date != ""
                ? moment(value.expiry_date)
                : value.expiry_date);
        } else if (value.$vnode.componentOptions.tag == "package-info") {
          p.package_structure = value.course_package_structure;
          p.courseInfo = {};
          p.courseInfo.package_id = value.package_id;
          p.remarks = value.remarks;
          p.courseInfo.non_package_id = value.non_package_id;
          p.courseInfo.package_type = value.package_type;
          p.courseInfo.shore_type = value.shore_type;
          let selected_package = [];
     
          value.selected_package.forEach((element) => {
            selected_package.push({
              application_fee: element.application_fee,
              code: element.code,
              code_name: element.code_name,
              course_matrix_id: element.course_matrix_id,
              criscos: element.criscos,
              duration: element.duration,
              max_duration: element.max_duration,
              id: element.id,
              material: element.material,
              tuition: element.tuition,
              max_tuiton: element.max_tuiton,
              course_start: element.course_start,
              course_end: element.course_end,
            });
          });
          p.courseInfo.selected_package = selected_package;
        }
      });
      return p;
    },
    alignData() {
      let data = this.offerData;
      let weekp = "";
      $.each(this.$children, function (k, v) {
        if (v.$vnode.componentOptions.tag == "student-info") {
          v.student_type = window.student_type;
          v.agent = data.agent_id;
          v.country_of_birth = data.student_details.country_birth;
          v.issue_date = moment(data.issued_date)._d;
          v.reference_id = data.reference_id;
        } else if (v.$vnode.componentOptions.tag == "address-contact-info") {
          v.email_personal = data.student_details.email_personal;
          v.telephone = data.student_details.telephone;
          v.mobile = data.student_details.mobile;
          v.current_address = data.student_details.current_address;
          v.home_address = data.student_details.home_address;
          v.country = data.student_details.country;
          v.state_province = data.student_details.state_province;
          v.postcode = data.student_details.postcode;
        } else if (v.$vnode.componentOptions.tag == "passport-info") {
          v.passport_num = data.student_details.passport_no;
          v.visa_num = data.student_details.visa_no;
          v.expiry_date = moment(data.student_details.passport_exp_date)._d;
        } else if (v.$vnode.componentOptions.tag == "package-info") {
          if (
            data.package_type == "Package" ||
            data.package_type == "package"
          ) {
            if (data.course_details[0].package != null) {
              v.course_package_structure.course_name =
                data.course_details[0].package.detail[0].course.detail.name;
              v.package_type = 1;

              v.packages.push(data.course_details[0].package);
              v.package_name = 0;
            }
            v.shore_type = data.shore_type;

            v.course_package_structure.application_fee =
              data.fees.application_fee;
            v.course_package_structure.balance_due = data.fees.balance_due;

            v.course_package_structure.downpayment = data.fees.payment_required;
            v.course_package_structure.payment_due = data.fees.payment_due != null ? moment(data.fees.payment_due)._d : ''; 
            v.course_package_structure.material_fee = data.fees.materials_fee;
            v.course_package_structure.discounted_amount =
              data.fees.discounted_amount;
            // v.course_package_structure.weekly_payment weekp =
            //   data.fees.weekly_payment;
            v.course_package_structure.installment_amount =
              data.fees.installment_desired_amount;
            v.course_package_structure.installment_start_date = data.fees.installment_start_date != '' ?
              moment(data.fees.installment_start_date)._d : '';
            v.course_package_structure.weekly_interval =
              data.fees.installment_interval;

            v.course_package_structure.oshc = data.fees.oshc;
            v.course_package_structure.total_course_fee =
              data.fees.total_course_fee;
            v.course_package_structure.total_course_fee_due =
              data.fees.total_course_fee_due;
            v.course_package_structure.tuition_fee =
              data.fees.course_tuition_fee;
            v.course_package_structure.initial_payment_amount =
              data.fees.initial_payment_amount;
            v.remarks = data.remarks;

            $.each(data.course_details, function (i, details) {
              let p = {
                code: details.course_code,
                code_name:
                  details.course_code +
                  " - " +
                  details.package.detail[i].course.detail.name,
                course_end: moment(details.course_end_date),
                course_matrix_id: details.package.detail[i].course.id,
                course_start: moment(details.course_start_date),
                criscos: details.cricos_code,
                duration: details.week_duration,
                id: details.course_code,
                material: details.material_fees,
                tuition: details.tuition_fees,
                max_duration: details.max_week_duration,
                max_tuition: details.max_tuition_fee,
              };
              if (i == 0) {
                p.application_fee = data.fees.application_fee;
              }
              v.course_package_structure.weekly_payment =
                details.weekly_payment;
              v.selected_package.push(p);
            });
          } else {

            v.course_package_structure.course_name =
              data.course_details[0].course_matrix.detail.name;
            v.package_type = 2;
            v.shore_type = data.shore_type;
            v.packages.push(data.course_details[0].course_matrix);
            v.package_name = 0;

            v.course_package_structure.application_fee =
              data.fees.application_fee;
            v.course_package_structure.balance_due = data.fees.balance_due;

            v.course_package_structure.downpayment = data.fees.payment_required;
            v.course_package_structure.payment_due = data.fees.payment_due != null ? moment(data.fees.payment_due)._d : ''; 
            v.course_package_structure.material_fee = data.fees.materials_fee;
            v.course_package_structure.oshc = data.fees.oshc;
            v.course_package_structure.discounted_amount =
              data.fees.discounted_amount;

            v.course_package_structure.installment_amount =
              data.fees.installment_desired_amount;
            v.course_package_structure.installment_start_date = data.fees.installment_start_date != '' ?
              moment(data.fees.installment_start_date)._d : '';
            v.course_package_structure.weekly_interval =
              data.fees.installment_interval;

            v.course_package_structure.weekly_payment =
              data.fees.weekly_payment;
            v.course_package_structure.total_course_fee =
              data.fees.total_course_fee;
            v.course_package_structure.total_course_fee_due =
              data.fees.total_course_fee_due;
            v.course_package_structure.tuition_fee =
              data.fees.course_tuition_fee;
            v.course_package_structure.initial_payment_amount =
              data.fees.initial_payment_amount;
            v.remarks = data.remarks;
            console.log(data.course_details);

            $.each(data.course_details, function (i, details) {
              let p = {
                code: details.course_code,
                code_name:
                  details.course_code +
                  " - " +
                  details.course_matrix.detail.name,
                course_end: moment(details.course_end_date),
                course_matrix_id: details.course_matrix.id,
                course_start: moment(details.course_start_date),
                criscos: details.cricos_code,
                duration: details.week_duration,
                id: details.course_code,
                material: details.material_fees,
                tuition: details.tuition_fees,
                max_duration: details.max_week_duration,
                max_tuition: details.max_tuition_fee,
              };
              if (i == 0) {
                p.application_fee = data.fees.application_fee;
              }
              v.course_package_structure.weekly_payment =
                details.weekly_payment;
              v.selected_package.push(p);
            });
          }
        }
      });
    },
    deleteOfferLetter(offer) {
      // console.log(this.$parent.$children[4]);
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
          width: "25%",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.value) {
            swal.fire({
              title: "Please wait...",
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                swal.showLoading();
              },
            });
            axios
              .delete(`/offer-letter/${offer}`)
              .then((response) => {
                // console.log(response);
                if (response.data.status == "success") {
                  this.$parent.firstLoad = 0;
                  this.$parent.fetchStudentOfferLetter();
                  Toast.fire({
                    type: "success",
                    title: "You deleted successfuly",
                  });
                  this.$parent.$children[4].getStudentAttendance();
                } else {
                  Toast.fire({
                    type: "error",
                    title: response.data.message,
                  });
                }
              })
              .catch((error) => {
                Toast.fire({
                  type: "error",
                  title: "Deletion failed",
                });
              });
          }
        });
    },
    sendEnrolmentEmail(offer) {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      swal
        .fire({
          title: "Are you sure ?",
          text: "Resend enrolment verification email",
          type: "warning",
          width: "50%",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, send it!",
        })
        .then((result) => {
          if (result.value) {
            swal.fire({
              title: "Please wait...",
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                swal.showLoading();
              },
            });
            axios
              .get(`/offer-letter/enrolment-email/${offer}`)
              .then((response) => {
                console.log(response);
                if (response.data.status == "success") {
                  Toast.fire({
                    type: "success",
                    title: "You emailed successfuly",
                  });
                } else {
                  Toast.fire({
                    type: "error",
                    title: response.message,
                  });
                }
              })
              .catch((error) => {
                console.log(error);
              });
          }
        });
    },
  },
};
</script>