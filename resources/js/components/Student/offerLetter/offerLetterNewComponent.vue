<template>
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button
          class="btn btn-link"
          data-toggle="collapse"
          data-target="#collapseOne"
          aria-expanded="true"
          aria-controls="collapseOne"
        >Add New Offer Letter</button>
      </h5>
    </div>
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-12 pull-right text-right">
            <button class="btn btn-success" :disabled="roles == 'Staff'? true : false " v-if="offerData != null" @click="useReference()">
              <i class="far fa-save"></i> Use Reference
            </button>
            <button class="btn btn-success" :disabled="roles == 'Staff'? true : false " @click="saveChanges()">
              <i class="far fa-save"></i> Save Changes
            </button>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="clearfix mb-2"></div>
        <!-- student info start  -->
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
          <h6>Student Information</h6>
        </div>
        <student-info v-bind="$props"></student-info>
        <div class="clearfix mb-5"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
          <h6>Address / Contact Information</h6>
        </div>
        <address-contact-info v-bind="$props"></address-contact-info>
        <div class="clearfix mb-5"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
          <h6>Passport / Visa Information</h6>
        </div>
        <passport-info></passport-info>
        <div class="clearfix mb-5"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
          <h6>Package Information</h6>
        </div>
        <package-info></package-info>
        <div class="clearfix mb-5"></div>
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
export default {
  components: {
    studentInfo,
    addressContactInfo,
    passportInfo,
    packageInfo,
  },
  props: ["types", "countries", "states", "agents", "offerData"],

  data() {
    return {
      app_color: app_color,
      offerDatas: [],
      roles : null,
    };
  },
  created() {
    if(this.$root.$refs.studentbase != undefined){
            this.roles = this.$root.$refs.studentbase.urole;
            }
  },
  mounted() {
    if(this.$root.$refs.studentbase != undefined){
            this.roles = this.$root.$refs.studentbase.urole;
            }
  },
  methods: {
    saveChanges() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
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
        .post("/offer-letter", JSON.stringify(this.offerDatas), {
          headers: {
            "content-type": "application/json",
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            Toast.fire({
              type: "success",
              title: "Created Successfuly",
            });
            this.$parent.firstLoad = 0;
            this.$parent.fetchStudentOfferLetter();
            $("#collapseOne").removeClass("show");
            this.clearData();
          } else {
            Toast.fire({
              type: "error",
              title: `${res.data.message}`,
            });
          }
          // console.log(res);
        })
        .catch((err) => {
          // console.log(err.response.data.message);
          let emessage = err.response.data;
          let errors = "";
          // console.log(emessage);
          for (var element in emessage.errors) {
            // console.log();
            errors += `<li class="display-block text-danger" style="display:table;font-size:14px;">${emessage.errors[element]}</li>`;
          }
          // console.log(errors);
          swal.fire({
            title: "ERRORS",
            type: "error",
            html: `<ul class="display-block">${errors}</ul>`,
            showConfirmButton: true,
          });
        });
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
            issue_date: value.issue_date,
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
            (p.expiry_date = moment(value.expiry_date).format("YYYY-MM-DD"));
        } else {
          p.package_structure = value.course_package_structure;
          (p.courseInfo = {}), (p.courseInfo.package_id = value.package_id);
          (p.remarks = value.remarks),
            (p.courseInfo.non_package_id = value.non_package_id),
            (p.courseInfo.package_type = value.package_type),
            (p.courseInfo.shore_type = value.shore_type),
            (p.courseInfo.selected_package = value.selected_package);
          p.courseInfo.selected_package.forEach((elem) => {
            elem.course_start = moment(elem.course_start).format("YYYY-MM-DD");
            elem.course_end = moment(elem.course_end).format("YYYY-MM-DD");
          });
        }
      });
      return p;
    },
    useReference() {
      let vm = this;
      let data = vm.offerData;
      $.each(this.$children, function (k, v) {
        if (v.$vnode.componentOptions.tag == "student-info") {
          v.student_type = window.student_type;
          v.agent = data.agent_id;
          v.country_of_birth = data.student_details.country_birth;
          v.issue_date = moment(data.issued_date)._d;
          v.reference_id = data.id;
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
        }
      });
    },
    clearData() {
      $.each(this.$children, function (k, v) {
        if (v.$vnode.componentOptions.tag == "student-info") {
          v.student_type = "";
          v.agent = "";
          v.country_of_birth = "";
          v.issue_date = "";
          v.reference_id = "";
        } else if (v.$vnode.componentOptions.tag == "address-contact-info") {
          v.email_personal = "";
          v.telephone = "";
          v.mobile = "";
          v.current_address = "";
          v.home_address = "";
          v.country = "";
          v.state_province = "";
          v.postcode = "";
        } else if (v.$vnode.componentOptions.tag == "passport-info") {
          v.passport_num = "";
          v.visa_num = "";
          v.expiry_date = "";
        } else {
          v.package_type = "";
          v.shore_type = "";
          v.packages = [];
          v.package_name = "";

          v.course_package_structure.course_name = "";
          v.course_package_structure.application_fee = 0;
          v.course_package_structure.balance_due = 0;

          v.course_package_structure.downpayment = 0;
          v.course_package_structure.material_fee = 0;
          v.course_package_structure.oshc = 0;
          v.course_package_structure.total_course_fee = 0;
          v.course_package_structure.total_course_fee_due = 0;
          v.course_package_structure.tuition_fee = 0;
          v.remarks = "";
          v.selected_package = [];
        }
      });
    },
  },
};
</script>