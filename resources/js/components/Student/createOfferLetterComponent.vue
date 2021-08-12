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
      <h4 :class="'modal-header-'+app_color">Add Student Info</h4>
      <form @submit.prevent="saveStudent">
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label for="studentPrefix">Prefix</label>
              <select
                id="studentPrefix"
                name="prefix"
                v-model="student.prefix"
                class="form-control"
              >
                <option value="Mr.">Mr.</option>
                <option value="Ms.">Ms.</option>
                <option value="Mrs.">Mrs.</option>
              </select>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label for="studentFirstname">First Name</label>
              <input
                type="text"
                name="firstname"
                id="studentFirstname"
                v-model="student.firstname"
                class="form-control"
              />
              <span
                v-if="student.errors.firstname"
                class="badge badge-danger"
                role="alert"
              >{{ student.errors.firstname[0] }}</span>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label for="studentMiddlename">Middle Name</label>
              <input
                type="text"
                name="middlename"
                id="studentMiddlename"
                v-model="student.middlename"
                class="form-control"
              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="studentLastname">Last Name</label>
              <input
                type="text"
                id="studentLastname"
                name="lastname"
                v-model="student.lastname"
                class="form-control"
              />
              <span
                v-if="student.errors.lastname"
                class="badge badge-danger"
                role="alert"
              >{{ student.errors.lastname[0] }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="studentDOB">Date Of Birth</label>
              <date-picker
                v-model="student.date_of_birth"
                :max-date="new Date()"
                :masks="{L:'DD/MM/YYYY'}"
              ></date-picker>
              <span
                v-if="student.errors.date_of_birth"
                class="badge badge-danger"
                role="alert"
              >{{ student.errors.date_of_birth[0] }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="studentLastname">Student Type</label>
              <select v-model="student.student_type" name="student_type" class="form-control">
                <option value="1">International</option>
                <option value="2">Domestic</option>
              </select>
              <span
                v-if="student.errors.student_type"
                class="badge badge-danger"
                role="alert"
              >{{ student.errors.student_type[0] }}</span>
            </div>
          </div>
        </div>

        <button type="submit" :class="'btn btn-'+app_color">Save</button>
      </form>
    </div>
  </modal>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      app_color:app_color,
      student: {
        prefix: "",
        firstname: "",
        middlename: "",
        lastname: "",
        date_of_birth: "",
        student_type: "",
        errors: []
      }
    };
  },

  methods: {
    saveStudent(e) {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      swal.fire({
          title: 'Please wait...',
          // html: '',// add html attribute if you want or remove
          allowOutsideClick: false,
          onBeforeOpen: () => {
             swal.showLoading()
          },
        });       
      this.student.date_of_birth = moment(this.student.date_of_birth).format(
        "YYYY-MM-DD"
      );

      // console.log(this.student);
      axios
        .post("/student", this.student)
        .then(response => {
          // console.log(response);
          let vm = this;
          if (response.data.status == "errors") {
            vm.student.errors = response.data.errors;
            Toast.fire({
              type: "error",
              title: "Fail to add student"
            });
          } else if(response.data.status == 'exist'){
            swal.fire({
              title: "Opss.. was not saved successfully.",
              html: `${this.student.firstname} ${this.student.lastname} has already data.`,
              type: "error",
              timer: 5000,
              showConfirmButton: false,
            });
            // this.student = {};
            this.student.prefix = "";
            this.student.firstname = "";
            this.student.lastname = "";
            this.student.middlename = "";
            this.student.date_of_birth = "";
            this.student.student_type = "";
            this.$modal.hide("size-modal");
          } else {
            this.student.prefix = "";
            this.student.firstname = "";
            this.student.lastname = "";
            this.student.middlename = "";
            this.student.date_of_birth = "";
            this.student.student_type = "";
            // alert('Student Added');

            // this.$set("errors", []);
            Toast.fire({
              type: "success",
              title: "Added Successfuly"
            });

            // this.$parent.fetchStudents();
            this.$parent.$refs.studentList.refresh();
            this.$modal.hide("size-modal");
          }
        })
        .catch(error => {
          Toast.fire({
            type: "error",
            title: "Fail to add student"
          });

          console.log(error);
          // if (error.response.status == 422) {
          //   this.student.errors = error.response.data.errors;
          // } else {
          //   console.log(errors);
          // }
        });
    },
    beforeOpen(e) {
      // this.fetchCourses();
    },
    beforeClose(e) {},
    opened(e) {
      // e.ref should not be undefined here
      // console.log('opened', e)
      // console.log('ref', e.ref)
    },
    closed(e) {
      console.log("closed", e);
    }
  }
};
</script>

<style>
.v--modal-overlay .v--modal-box {
  overflow: visible !important;
}
.vc-text-base {
  display: block;
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #6e707e;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #d1d3e2;
  border-radius: 0.35rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
</style>