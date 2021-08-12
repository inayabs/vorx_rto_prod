<template>
  <modal
    name="size-modal"
    transition="nice-modal-fade"
    classes="demo-modal-class"
    :min-width="200"
    :min-height="200"
    :pivot-y="0.1"
    :adaptive="true"
    :scrollable="true"
    :reset="true"
    width="50%"
    height="auto"
    @before-open="beforeOpen"
    @opened="opened"
    @closed="closed"
    @before-close="beforeClose"
  >
    <div class="size-modal-content">
      <h4 :class="'background-' + app_color">Verify Enrolment Application</h4>
      <div
        v-for="(verify_form, index) in verify_forms"
        :key="index"
        class="row m-2"
      >
        <div class="col-md-12">
          <hr v-if="index != 0" />
          <div class="form-group">
            <label for="course_startDate">
              {{ verify_form.name }}
              <span v-if="verify_form.course_code == '@@@@'"
                >( {{ units.join(", ") }} )</span
              >
            </label>
          </div>
        </div>
        <div v-if="verify_form.course_code == '@@@@'" class="col-md-12">
          <div class="form-group">
            <label for="course_startDate"
              >Unit of Competency discription *</label
            >
            <input
              type="text"
              v-model="verify_form.uc_description"
              class="form-control"
            />
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="course_startDate">Class</label>
            <select
              v-model="verify_form.class"
              @change="getstartend(index)"
              id
              class="form-control"
            >
              <option
                v-for="opt in classlist[index]"
                :key="opt.id"
                :value="opt"
              >
                {{ opt.desc }} - ( {{ opt.time_table_type }} )
              </option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="funding">Student Type</label>
            <select name="funding" v-model="student_type" class="form-control">
              <option></option>
              <option
                v-for="(opt, index) in student_type_op"
                :key="index"
                :value="index"
              >
                {{ opt }}
              </option>
            </select>
          </div>
        </div>
        <div v-if="student_type == 2" class="col-md-6">
          <div class="form-group">
            <label for="funding">Add Offer Letter</label>
            <select
              name="funding"
              v-model="add_offer_letter"
              class="form-control"
            >
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="course_startDate">Mode of Study</label>
            <select v-model="verify_form.delivery_mode" id class="form-control">
              <option v-for="opt in delivery_mode" :key="opt.id" :value="opt">
                {{ opt.description }}
                <span v-if="opt.alt_description != null"
                  >- ( {{ opt.alt_description }} )</span
                >
              </option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="course_startDate">Delivery Location</label>
            <select v-model="verify_form.delivery_loc" id class="form-control">
              <option v-for="opt in delivery_loc" :key="opt.id" :value="opt">
                {{ opt.addr_location }}, {{ opt.state.shortname }}
                {{ opt.postcode }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="funding">Shore Type</label>
            <select
              name="funding"
              @change="getFee(id, index)"
              v-model="verify_form.shore_type"
              class="form-control"
            >
              <option></option>
              <option
                v-for="(opt, index) in shore_type_op"
                :key="index"
                :value="opt"
              >
                {{ opt }}
              </option>
            </select>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="course_startDate">Course Start Date *</label>
            <date-picker
              locale="en"
              :masks="{ L: 'DD/MM/YYYY' }"
              v-model="verify_form.start_date"
            ></date-picker>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="course_startDate">Course End Date *</label>
            <date-picker
              locale="en"
              :masks="{ L: 'DD/MM/YYYY' }"
              :input="getDate(index)"
              v-model="verify_form.end_date"
            ></date-picker>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="course_startDate">Eligibility *</label>
            <select
              v-model="verify_form.eligibility"
              @change="eligible_checker(verify_form.eligibility, index)"
              id
              class="form-control"
            >
              <option></option>
              <option value="E">Eligible</option>
              <option value="NE">Not Eligible</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="status">Status</label>
            <select
              name="status"
              v-model="verify_form.status_id"
              class="form-control"
            >
              <option value="1">Not Studying</option>
              <option value="3">Studying (Domestic)</option>
              <option value="2">Studying (Int)</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="status">Course Fee Type *</label>
            <select
              name="status"
              v-model="verify_form.course_fee_type"
              class="form-control"
            >
              <option v-for="(opt, ix) in option[index]" :key="ix" :value="ix">
                {{ opt }}
              </option>
            </select>
          </div>
        </div>
        <!-- <div class="col-md-6">
          <div class="form-group">
            <label for="status">Course Fee *</label>
            <input
              type="text"
              v-if="student_type == '1' || add_offer_letter == '1'"
              readonly
              v-model="verify_form.course_fee"
              class="form-control course_fee"
            />
            <input
              type="text"
              v-else
              v-model="verify_form.course_fee"
              class="form-control course_fee"
            />
          </div>
        </div> -->
        
        <div class="col-md-6">
          <div class="form-group">
            <label for="funding">Funding Type</label>
            <select
              name="funding"
              v-model="verify_form.funding_type"
              class="form-control"
            >
              <option></option>
              <option v-for="(opt, i) in funding_type" :key="i" :value="i">
                {{ opt }}
              </option>
            </select>
          </div>
        </div>
        <div
            v-if="student_type == '1' || add_offer_letter == '1'"
            class="col-md-12"
        >
          <div class="form-group">
            <label for="funding">Fees and Payments</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="status">Course Tuition Fee *</label>
            <input
              type="text"
              v-if="student_type == '1' || add_offer_letter == '1'"
              v-model="verify_form.course_fee"
              class="form-control course_fee"
            />
            <input
              type="text"
              v-else
              v-model="verify_form.course_fee"
              class="form-control course_fee"
            />
          </div>
        </div>
        
        <!-- <div v-if="student_type == '1' || add_offer_letter == '1'"> -->
          <div class="col-md-6" v-if="student_type == '1' || add_offer_letter == '1'">
            <div class="form-group">
              <label for="status">Application Fee *</label>
              <input type="text" class="form-control " v-model="verify_form.application_fees" >
            </div>
          </div>
          <div class="col-md-6" v-if="student_type == '1' || add_offer_letter == '1'">
            <div class="form-group">
              <label for="status">Material Fee *</label>
              <input type="text" class="form-control " v-model="verify_form.material_fees" >
            </div>
          </div>
          <div
          v-if="student_type == '1' || add_offer_letter == '1'"
          class="col-md-6"
        >
          <div class="form-group">
            <label for="status">Discount Amount </label>
            <input
              type="text"
              v-model="verify_form.discounted_amount"
              class="form-control"
            />
          </div>
        </div>
        <div
          v-if="student_type == '1' || add_offer_letter == '1'"
          class="col-md-6"
        >
          <div class="form-group">
            <label for="status">Payment Required </label>
            <input
              type="text"
              v-model="verify_form.payment_required"
              class="form-control"
            />
          </div>
        </div>
        <div
          v-if="student_type == '1' || add_offer_letter == '1'"
          class="col-md-6"
        >
          <div class="form-group">
            <label for="status">Payment Due <br><span class="">( leave blank if default 3 days )</span></label>
            <date-picker
              locale="en"
              :masks="{ L: 'DD/MM/YYYY' }"
              v-model="verify_form.payment_due"
            ></date-picker>
          </div>
        </div>
        <!-- </div> -->

      </div>
      <div class="row">
        <div class="col-md-12 pull-right text-right">
          <button class="btn btn-success" @click="verify">
            <i class="far fa-save"></i> Verify Enrolment Changes
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>
<style scoped>
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}
</style>
<script>
import moment from "moment";
export default {
  props: ["app_name"],
  data() {
    return {
      app_color: app_color,
      verify_forms: [],
      // verify_form: {
      //   course: "",
      //   start_date: "",
      //   end_date: "",
      //   eligibility: "",
      //   status: "",
      //   course_fee_type: "",
      //   course_fee: "",
      //   funding_type: ""
      // },
      classlist: [],
      delivery_mode: window.delivery_mode,
      delivery_loc: window.delivery_loc,
      units: [],
      option: [],
      funding_type: [],
      disabled: "",
      student_type: "",
      student_type_op: {
        1: "International",
        2: "Domestic",
      },
      shore_type_op: ["OnShore", "OffShore"],
      id: "",
      add_offer_letter: 0,
    };
  },
  methods: {
    beforeOpen(e) {
      let vm = this;
      vm.id = e.params.id;
      let ef = e.params.enrolment_form;

      let courses = [];
      console.log(e);
      if (typeof ef.course !== "undefined") {
        if (ef.course !== null) {
          courses.push({
            course_code: ef.course.code,
            name: ef.course.name,
            start_date: "",
            end_date: "",
            eligibility: "",
            status_id: "",
            course_fee_type: "",
            course_fee: "",
            funding_type: "",
            uc_description: "",
            payment_due : ''
          });
        }
      }

      if (typeof ef.units !== "undefined") {
        if(ef.units.length > 0 ){
          courses.push({
            course_code: "@@@@",
            name: "Units of Competency",
            start_date: "",
            end_date: "",
            eligibility: "",
            status_id: "",
            course_fee_type: "",
            course_fee: "",
            funding_type: "",
            uc_description: "",
          });
          vm.units = [];
          ef.units.forEach((element) => {
            vm.units.push(element.code);
          });
        }
      }
      vm.verify_forms = courses;
      vm.student_type = e.params.student_type;
      axios.get(`/enrolment-application/funding_type/${ef.addr_suburb.id}`).then((res) => {
        vm.funding_type = res.data;
      });
      axios
        .get(`/enrolment-application/class/list/${ef.addr_suburb.id}`)
        .then((res) => {
          let class_ = [];
          class_.push(res.data);
          vm.classlist = class_;
        });
    },
    getDate(index) {
      if (this.verify_forms[index].end_date !== "") {
        // console.log(this.verify_forms[index].start_date);

        if(typeof this.verify_forms[index].class !== 'undefined' && typeof this.verify_forms[index].class.id !== 'undefined' && ['',null].indexOf(this.verify_forms[index].class.id) == -1){
          // insert auto change course dates
          let vm = this;
          let csd = moment(this.verify_forms[index].start_date).format(
            "YYYY-MM-DD"
          );
          // console.log(csd);
          // console.log(this);
          axios
            .get(
              "course-dates/fetch/" +
                csd +
                "/" +
                vm.verify_forms[index].class.id +
                "/" +
                0
            )
            .then(function (res) {
              console.log(res.data);
              vm.verify_forms[index].end_date = moment(
                res.data.course_end_date
              )._d;
            })
            .catch(function (err) {
              console.log(err);
            });   
        }

      }
    },

    getstartend(index) {
      let vm = this;
      // console.log(start);
      console.log(index);
      let time_table = "";
      let subjectListChecker = [];
      if (this.verify_forms[index].class.time_table != null) {
        time_table = this.verify_forms[index].class.time_table.time_table;
      }

      let start = this.verify_forms[index].class.start_date;
      let end = this.verify_forms[index].class.end_date;
      if (time_table.length > 0) {
        time_table.forEach((element) => {
          if (typeof element.unit !== "undefined") {
            if (typeof element.dates !== "undefined") {
              if (element.dates != null) {
                if (moment(element.dates.start).isSameOrAfter(start)) {
                  if (subjectListChecker.indexOf(element.unit.code) == -1) {
                    subjectListChecker.push(element.unit.code);
                    vm.verify_forms[index].end_date = moment(
                      element.dates.end
                    )._d;
                  }
                }
              }
            }
          }
        });
      }
      this.verify_forms[index].start_date = moment(start)._d;
    },
    beforeClose(e) {},
    opened(e) {
      // e.ref should not be undefined here
      // console.log('opened', e)
      // console.log('ref', e.ref)
    },
    closed(e) {
      // console.log("closed", e);
    },
    eligible_checker(option, key) {
      // console.log(option);
      if (option == "E") {
        this.option[key] = {
          C: "Concessional",
          NC: "Government Funded",
          FF: "Fee for Service",
        };
      } else {
        this.option[key] = {
          NC: "Government Funded",
          FF: "Fee for Service",
        };
      }
    },
    validate() {
      let check = false;
      this.verify_forms.forEach((element) => {
        if (
          element.start_date != "" &&
          element.end_date != "" &&
          element.course_fee != "" &&
          element.course_fee != ""
        ) {
          check = true;
        } else {
          check = false;
        }
      });
      // console.log(check);
      return check;
    },
    newCourseFee(index) {
      let vm = this;
      let new_fee =
        vm.verify_forms[index].original_fee -
        vm.verify_forms[index].discount_amount;
      vm.verify_forms[index].course_fee = new_fee;
    },
    verify() {
      if (this.validate()) {
        this.verify_forms.forEach((element) => {
          if (element.start_date != "") {
            element.start_date = moment(element.start_date).format(
              "YYYY-MM-DD"
            );
          }
          if (element.end_date != "") {
            element.end_date = moment(element.end_date).format("YYYY-MM-DD");
          }
        });

        let toast = swal.fire({
          position: "top-end",
          title: "Please wait",
          showConfirmButton: false,
          onBeforeOpen: () => {
            swal.showLoading();
          },
        });

        if (this.student_type == "2") {
          axios
            .post(`/enrolment-application`, {
              courses: this.verify_forms,
              id: this.id,
              units: this.units,
              add_offer_letter: this.add_offer_letter,
            })
            .then((res) => {
              if (res.data.status == "success") {
                Toast.fire({
                  type: "success",
                  position: "top-end",
                  title: res.data.message,
                });
                this.$parent.$refs.studentList.refresh();
              } else if (res.data.status == "exist") {
                swal
                  .fire({
                    title: "Student Already exist",
                    text: "Do you want to link ?",
                    type: "warning",
                    width: "25%",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "No!",
                    
                    confirmButtonText: "Yes!",
                  })
                  .then((result) => {
                    if (result.value) {
                      axios
                        .post(`/enrolment-application/link`, {
                          courses: this.verify_forms,
                          id: this.id,
                          units: this.units,
                        })
                        .then((res) => {
                          if (res.data.status == "success") {
                            Toast.fire({
                              type: "success",
                              position: "top-end",
                              title: res.data.message,
                            });

                            this.$parent.$refs.studentList.refresh();
                          } else {
                            swal.fire({
                              type: "error",
                              title: "Oops...",
                              html: `ERROR`,
                            });
                          }
                        });
                    }
                    if (result.dismiss == "cancel") {
                      axios
                        .post(`/enrolment-application/link_new`, {
                          courses: this.verify_forms,
                          id: this.id,
                          units: this.units,
                        })
                        .then((res) => {
                          if (res.data.status == "success") {
                            Toast.fire({
                              type: "success",
                              position: "top-end",
                              title: res.data.message,
                            });

                            this.$parent.$refs.studentList.refresh();
                          } else {
                            swal.fire({
                              type: "error",
                              title: "Oops...",
                              html: `ERROR`,
                            });
                          }
                        });
                    }
                  })
                  .catch((err) => {
                    console.log(err);
                  });
              } else {
              }
              this.$parent.$refs.studentList.refresh();
              this.$parent.$modal.hide("size-modal");
            })
            .catch((err) => {
              // swal.fire({
              //   type: "error",
              //   title: "Oops...",
              //   html: `Something went wrong....`
              // });
              console.log(err);
            });
        } else {
          axios
            .post(`/enrolment-application/international`, {
              courses: this.verify_forms,
              id: this.id,
              units: this.units,
              weekly_amount: this.weekly_amount,
            })
            .then((res) => {
              if (res.data.status == "success") {
                Toast.fire({
                  type: "success",
                  position: "top-end",
                  title: res.data.message,
                });
                this.$parent.$refs.studentList.refresh();
              } else if (res.data.status == "exist") {
                swal
                  .fire({
                    title: "Student Already exist",
                    text: "Do you want to link ?",
                    type: "warning",
                    width: "25%",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "No!",
                    confirmButtonText: "Yes!",
                  })
                  .then((result) => {
                    if (result.value) {
                      axios
                        .post(`/enrolment-application/link`, {
                          courses: this.verify_forms,
                          id: this.id,
                          units: this.units,
                        })
                        .then((res) => {
                          if (res.data.status == "success") {
                            Toast.fire({
                              type: "success",
                              position: "top-end",
                              title: res.data.message,
                            });

                            this.$parent.$refs.studentList.refresh();
                          } else {
                            swal.fire({
                              type: "error",
                              title: "Oops...",
                              html: `ERROR`,
                            });
                          }
                        });
                    }
                    if (result.dismiss == "cancel") {
                      axios
                        .post(`/enrolment-application/link_new`, {
                          courses: this.verify_forms,
                          id: this.id,
                          units: this.units,
                        })
                        .then((res) => {
                          if (res.data.status == "success") {
                            Toast.fire({
                              type: "success",
                              position: "top-end",
                              title: res.data.message,
                            });

                            this.$parent.$refs.studentList.refresh();
                          } else {
                            swal.fire({
                              type: "error",
                              title: "Oops...",
                              html: `ERROR`,
                            });
                          }
                        });
                    }
                  })
                  .catch((err) => {
                    console.log(err);
                  });
              } else {
              }
              this.$parent.$refs.studentList.refresh();
              this.$parent.$modal.hide("size-modal");
            })
            .catch((err) => {
              // swal.fire({
              //   type: "error",
              //   title: "Oops...",
              //   html: `Something went wrong....`
              // });
              console.log(err);
            });
        }
      } else {
        swal.fire({
          type: "error",
          title: "Oops...",
          html: `Please fill up required fields`,
        });
      }

      //   console.log(this.verify_form);
    },
    getFee(id, index) {
      let vm = this;
      console.log(vm.student_type);
      if (vm.student_type == "1" || vm.add_offer_letter == "1") {
        axios
          .get(`enrolment-application/international/course_matrix/${id}`)
          .then((response) => {
            let data = response.data;
            let fee = "";
            if (vm.verify_forms[index].shore_type == "OnShore") {
              vm.verify_forms[index].course_fee = parseInt(data.onshore_tuition_individual)
              vm.verify_forms[index].material_fees = parseInt(data.material_fees)
              vm.verify_forms[index].application_fees = parseInt(data.enrolment_fee)
                // parseInt(data.material_fees) +
                // parseInt(data.enrolment_fee);
            } else {
              vm.verify_forms[index].course_fee = parseInt(data.offshore_tuition_individual)
              vm.verify_forms[index].material_fees = parseInt(data.material_fees)
              vm.verify_forms[index].application_fees = parseInt(data.enrolment_fee)
                // parseInt(data.material_fees) +
                // parseInt(data.enrolment_fee);
            }
            vm.verify_forms[index].original_fee =
              vm.verify_forms[index].course_fee;
            vm.verify_forms[index].course_fee_type = "FF";
            vm.verify_forms[index].eligibility = "NE";
            vm.option[index] = {
              NC: "Government Funded",
              FF: "Fee for Service",
            };
          });
      } else {
        $(".course_fee").attr("disabled", false);
      }
    },
  },
  watch: {
    // verify_form : function (data) {
    //   console.log(data.course_);
    // }
  },
};
</script>
