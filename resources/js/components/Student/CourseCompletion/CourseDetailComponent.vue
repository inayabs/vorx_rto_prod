<template>
  <div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 mb-3 mt-3" v-if="soa_num == undefined">CERT / SOA # : ( LATEST )</div>
        <div class="col-md-6 mb-3 mt-3" v-else>CERT / SOA # : ( {{soa_num}} )</div>
        <div class="col-md-6 text-right mb-3 mt-3">
          <button
            v-if="edit_status && soa_num != undefined"
            class="btn btn-success mt-2"
            @click="getLatest()"
          >
            <i class="far fa-save"></i> Cancel Changes
          </button>

          <!-- SEND -->
          <div class="btn-group mt-2" v-if="add_on.indexOf('automation.course_progress') != -1">
            <button
              type="button"
              class="btn btn-warning dropdown-toggle dropdown-toggle-split"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              v-if="demoUser == false"
            >
              Send
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a
                class="dropdown-item"
                @click="sendReport(course_units.student, course_units.course_completion, 'Progress Report')"
                target="_blank"
              >
                <i class="fas fa-clipboard text-success"></i>&nbsp; Progress Report
              </a>
              <!-- <a
                class="dropdown-item"
                @click="sendReport(course_units.student, course_units.course_completion, 'Completion Report')"
                target="_blank"
              >
                <i class="fas fa-clipboard text-success"></i>&nbsp; Completion Report
              </a>-->
            </div>
          </div>
          <!-- VIEW -->
          <div class="btn-group mt-2" v-if="add_on.indexOf('automation.course_progress') != -1">
            <button
              type="button"
              class="btn btn-info dropdown-toggle dropdown-toggle-split"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              v-if="demoUser == false"
            >
              View
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" @click="progressReport()" target="_blank">
                <i class="fas fa-clipboard text-success"></i>&nbsp; Progress Report
              </a>
              <!-- <a class="dropdown-item" @click="completionReport()" target="_blank">
                <i class="fas fa-clipboard text-success"></i>&nbsp; Completion Report
              </a> -->
            </div>
          </div>

          <!-- <button class="btn btn-success mt-2" @click="progressReport(course)">
            <i class="fas fa-clipboard"></i> Completion Report
          </button>-->
          <button class="btn btn-primary mt-2" @click="generateCert">
            <i class="far fa-save"></i> Generate Certificates
          </button>
          <button class="btn btn-info mt-2" @click="useProposed">
            <i class="far fa-calendar"></i> Use Proposed Date
          </button>
          <button  :disabled="roles == 'Staff'? true : false "  class="btn btn-success mt-2" @click="saveChanges">
            <i class="far fa-save"></i> Save Changes
          </button>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2 offset-md-4 mb-2">
          <label for>Start Date</label>
          <date-picker
            :popover="{ placement: 'bottom', visibility: 'click' }"
            mode="single"
            locale="en"
            v-model="modifyDateStart"
            :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
          ></date-picker>
        </div>
        <div class="col-md-2 mb-2">
          <label for>End Date</label>
          <date-picker
            :popover="{ placement: 'bottom', visibility: 'click' }"
            mode="single"
            locale="en"
            v-model="modifyDateEnd"
            :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
          ></date-picker>
        </div>
        <div class="col-md-4 mb-2">
          <label for>Status</label>
          <select v-model="modifyAll" @change="modifyStatus" class="form-control">
            <option value selected></option>
            <option
              v-for="(status) in statuses"
              :key="status.id"
              :value="status.id"
            >{{ status.status }}</option>
          </select>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
      <table class="table" id="dataTable" width="100%">
        <thead>
          <tr>
            <th v-bind:class="'text-center background-'+app_color" style="width:5%!important">#</th>
            <th v-bind:class="'text-center background-'+app_color">Code</th>
            <th v-bind:class="'text-center background-'+app_color">Description</th>
            <!-- <th
              v-bind:class="'text-center background-'+app_color"
              style="width:7%!important"
            >Unit Type</th>-->
            <th v-bind:class="'text-center background-'+app_color">Actual Start</th>
            <th v-bind:class="'text-center background-'+app_color">Actual End Date</th>
            <th v-bind:class="'text-center background-'+app_color">Status</th>
            <th v-bind:class="'text-center background-'+app_color" style="width:5%!important">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(units, index) in course_units.units" :key="index">
            <td width="5%">{{ index +1 }}</td>
            <td width="10%">{{ units.code }}</td>
            <td width="25%">{{ units.description }}</td>
            <!-- <td class="text-center">{{ units.unit_type | capitalize }}</td> -->
            <td width="17%">
              <!-- <date-picker
                :popover="{ placement: 'bottom', visibility: 'click' }"
                mode="range"
                locale="en"
                v-model="units.dates"
                :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
              ></date-picker>-->

              <date-picker
                :popover="{ placement: 'bottom', visibility: 'click' }"
                mode="single"
                locale="en"
                v-model="units.dates.start"
                :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
              ></date-picker>
            </td>
            <td width="17%">
              <!-- <date-picker
                :popover="{ placement: 'bottom', visibility: 'click' }"
                mode="range"
                locale="en"
                v-model="units.dates"
                :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
              ></date-picker>-->
              <date-picker
                :popover="{ placement: 'bottom', visibility: 'click' }"
                mode="single"
                locale="en"
                v-model="units.dates.end"
                :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
              ></date-picker>
            </td>
            <td width="17%">
              <select v-model="units.status" class="form-control">
                <option
                  v-for="(status) in statuses"
                  :key="status.id"
                  :value="status.id"
                >{{ status.status }}</option>
              </select>
            </td>
            <td width="5%" style=" text-align: center;">
              <button
                class="btn btn-danger"
                @click="destroy_single(course_units.course_completion.id,units.code,index)"
                type="submit"
              >-</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import moment from "moment";

export default {
  props: [
    "units",
    "completions",
    "course",
    "edit_id",
    "edit_status",
    "soa_num",
  ],
  data() {
    return {
      modifyDateStart: "",
      modifyDateEnd: "",
      app_color: app_color,
      add_on: add_on,
      demoUser: false,
      student_detail: window.student,
      course_units: {
        units: this.units,
        student:  window.student.id != undefined ?window.student.id : window.student_id,
        course: this.course,
        course_completion: this.completions,
      },
      baseProspect: "",
      modifyAll: "",
      statuses: window.statuses,
      roles : null,
    };
  },
  created() {
    this.checkCompletion();
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
    sendReport(student, course, type) {
      let vm = this;
      // console.log(vm.student_detail);
      swal
        .fire({
          title: "Send " + type + " to " + vm.student_detail.name + "?",
          // text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Send!",
        })
        .then((result) => {
          if (result.value) {
            swal.fire({
              title: "Sending progress report..",
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                swal.showLoading();
              },
            });

            if (vm.student_detail.email.length < 1) {
              swal.fire(
                "Opps..",
                "No email address assigned to " + vm.student_detail.name,
                "error"
              );
              return false;
            }

            axios
              .post("/report/send/course-progress", {
                student_id: student,
                course: course,
                type: type,
                email: vm.student_detail.email,
              })
              .then((res) => {
                // console.log(res);
                if (res.data.status == "success") {
                  swal.fire("Success", type + " successfully sent.", "success");
                } else {
                  swal.fire("Opps..", res.data.message, "error");
                }
              })
              .catch((err) => {
                // console.log(err);
                swal.fire("Opps..", "There seems to be a problem.", "error");
              });
            // swal.fire(
            //   'Success',
            //   'Progress report successfully sent.',
            //   'success'
            // )
          }
        });
    },
    progressReport() {
      if(window.student.id == undefined){
        window.open(
          `/certificate_issuance/generate/progress_report/${window.student_id}/${this.completions.id}`,
          // `/course_completion/confirmation_report/${window.student.id}/${this.course}`,
          "_blank"
        );
      }else{
        window.open(
          `/certificate_issuance/generate/progress_report/${window.student.id}/${this.completions.id}`,
          // `/course_completion/confirmation_report/${window.student.id}/${this.course}`,
          "_blank"
        );
      }
    },
    completionReport() {
      window.open(
        // `/certificate_issuance/generate/progress_report/${window.student.id}/${this.course}`,
        `/course_completion/confirmation_report/${window.student.id}/${this.course}`,
        "_blank"
      );
    },
    getLatest() {
      let vm = this;
      vm.$emit("updateData", "success");
      vm.$emit("generate", "success");
    },
    destroy_single(id, code, index) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          let vm = this;
          if (result.value === true) {
            axios({
              method: "delete",
              url: `/course_completion/student/delete/detail/${id}/${code}`,
            })
              .then((res) => {
                // let i = this.fullfee_course[index].payment_details.map(item => item).indexOf(payment_detail_id) // find index of your object
                console.log(res);
                if (res.data.status == "success") {
                  Toast.fire({
                    type: "success",
                    title: "Data is deleted successfully",
                    position: "top-end",
                  });
                  vm.units[index].dates = "";
                  vm.units[index].status = "";
                  // vm.$emit("updateData", "success");
                } else {
                  Toast.fire({
                    type: "error",
                    title: res.data.message,
                    position: "top-end",
                  });
                }
              })
              .catch((err) => console.log(err));
          }
        });
    },
    saveChanges() {
      let vm = this;
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
      });
      loadingSwal.fire({
        type: "info",
        title: "Please Wait ...",
      });
      let data = this.course_units;
      data.units.forEach((e1) => {
        if (e1.dates.start != null) {
          e1.dates.start = moment(e1.dates.start).format("YYYY-MM-DD");
          console.log(e1.dates.start);
        }
        if (e1.dates.end != null) {
          e1.dates.end = moment(e1.dates.end).format("YYYY-MM-DD");
        }
      });
      if (this.edit_status) {
        axios
          .put(`/course_completion/update/units/${vm.edit_id}`, data)
          .then((response) => {
            if (response.data.status == "success") {
              Toast.fire({
                type: "success",
                title: response.data.message,
              });
              vm.$emit("updateData", "success");
              vm.$emit("generate", "success");
              this.editCompletion = false;
            } else {
              Toast.fire({
                type: "error",
                title: response.data.message,
              });
            }
          })
          .catch((err) => {
            console.log(err);
          });
        this.editCompletion = false;
      } else {
        axios
          .post("/course_completion", data)
          .then((response) => {
            if (response.data.status == "success") {
              Toast.fire({
                type: "success",
                title: response.data.message,
              });
              vm.$emit("generate", "success");
              vm.$emit("updateData", "success");
            } else {
              Toast.fire({
                type: "error",
                title: response.data.messsage,
              });
            }
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    useProposed() {
      let completion = this.course_units.course_completion;
      let units = this.course_units.units;
      console.log(completion);
      if (completion != null) {
        let details = completion.details;
        details.forEach((e1) =>
          units.forEach((e2) => {
            // console.log(e1.course_unit_code + " " + e2.code);
            if (e1.course_unit_code == e2.code) {
              if (e1.start_date != null && e1.end_date != null) {
                e2.dates = {
                  start: moment(e1.start_date)._d,
                  end: moment(e1.end_date)._d,
                };
              } else {
                e2.dates = {
                  start: null,
                  end: null,
                };
              }
              e2.status = e1.completion_status_id;
            }
          })
        );
      }
    },
    generateCert() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
      });
      loadingSwal.fire({
        type: "info",
        title: "Please Wait ...",
      });
      let vm = this;
      let data = vm.course_units;
      data.units.forEach((e1) => {
        if (e1.dates.actual_start != null) {
          e1.dates.start = moment(e1.dates.actual_start).format("YYYY-MM-DD");
        }
        if (e1.dates.actual_start != null) {
          e1.dates.end = moment(e1.dates.actual_start).format("YYYY-MM-DD");
        }
      });
      axios
        .post("/certificate_issuance", data)
        .then((response) => {
          if (response.data.status == "success") {
            Toast.fire({
              type: "success",
              title: response.data.message,
            });
            vm.$emit("generate", "success");
            vm.$emit("updateData", "success");
          } else {
            Toast.fire({
              type: "error",
              title: response.data.message,
            });
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    checkCompletion() {
      let completion = this.course_units.course_completion;
      let units = this.course_units.units;
      if (completion != null) {
        let details = completion.details;
        details.forEach((e1) =>
          units.forEach((e2) => {
            // console.log(e1.course_unit_code + " " + e2.code);
            if (e1.course_unit_code == e2.code) {
              if (e1.actual_start != null && e1.actual_end != null) {
                e2.dates = {
                  start: moment(e1.actual_start)._d,
                  end: moment(e1.actual_end)._d,
                };
              } else {
                e2.dates = {
                  start: "",
                  end: "",
                };
              }
              e2.status = e1.completion_status_id;
            }
          })
        );
      }
    },
    getUnits() {
      if (this.soa_num != undefined) {
        axios
          .get(`/course_prospectus/${this.course_units.course}`)
          .then((response) => {
            this.baseProspect = response.data;
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    editCheckCompletion() {
      let newUnits = [];
      let units = this.units;
      let _baseUnits = this.baseProspect;

      _baseUnits.forEach((e1) => {
        let checker = 0;
        units.forEach((e2) => {
          if (e1.code == e2.code) {
            // console.log("sulod");
            newUnits.push({
              code: e2.code,
              description: e2.description,
              unit_type: e2.unit_type,
              dates: e2.dates,
              status: e2.status,
            });
            checker = 1;
          }
        });
        if (checker == 0) {
          newUnits.push({
            code: e1.code,
            description: e1.description,
            unit_type: e1.unit_type,
            dates: {
              start: "",
              end: "",
            },
            status: e1.status,
          });
        }
      });

      this.course_units.units = newUnits;
    },
    modifyDate(type) {
      let vm = this;
      let units = vm.course_units;
      if (type == "start") {
        if (vm.modifyDateStart != "") {
          units.units.forEach((element) => {
            element.dates.start = vm.modifyDateStart;
          });
        }
      } else {
        if (vm.modifyDateEnd != "") {
          units.units.forEach((element) => {
            element.dates.end = vm.modifyDateEnd;
          });
        }
      }
    },
    modifyStatus() {
      let vm = this;
      vm.course_units.units.forEach((element) => {
        element.status = vm.modifyAll;
      });
      // console.log(this.modifyAll);
    },
  },
  filters: {
    capitalize: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    },
  },
  watch: {
    completions: function (newVal) {
      this.course_units.course_completion = newVal;
      this.checkCompletion();
    },
    baseProspect: function (newVal) {
      this.editCheckCompletion();
    },
    edit_id: function (newVal, oldVal) {
      if (newVal != "") {
        this.getUnits();
        this.editCompletion = true;
      }
    },
    units: function (newVal) {
      console.log(newVal);
    },
    modifyDateStart: function (newVal, oldVal) {
      if (newVal != "") {
        this.course_units.units.forEach((element) => {
          element.dates.start = this.modifyDateStart;
        });
      }
    },
    modifyDateEnd: function (newVal, oldVal) {
      if (newVal != "") {
        this.course_units.units.forEach((element) => {
          element.dates.end = this.modifyDateEnd;
        });
      }
    },
    // edit_status: function(newVal) {
    //   if (newVal) {
    //     this.getUnits();
    //     this.editCompletion = true;
    //   } else {
    //     this.checkCompletion();
    //   }
    // }
  },
};
</script>

<style scoped>
.dropdown-item {
  cursor: pointer !important;
}
</style>