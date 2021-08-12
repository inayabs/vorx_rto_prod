<template>
  <div>
    <table class="table responsive-table">
      <thead>
        <tr>
          <th v-bind:class="'background-'+app_color">#</th>
          <th v-bind:class="'background-'+app_color">Course</th>
          <th v-bind:class="'background-'+app_color">Certificate #</th>
          <!-- <th v-bind:class="'background-'+app_color">Manual #</th> -->
          <th v-bind:class="'background-'+app_color">Released Date</th>
          <!-- <th v-bind:class="'background-'+app_color">Released</th> -->
          <!-- <th v-bind:class="'background-'+app_color">Reissued Date</th> -->
          <!-- <th v-bind:class="'background-'+app_color">Reissued</th> -->
          <!-- <th v-bind:class="'background-'+app_color">Created</th> -->
          <!-- <th v-bind:class="'background-'+app_color">Completion Date</th> -->
          <!-- <th v-bind:class="'background-'+app_color">Enrolment Date</th> -->
          <th v-bind:class="'background-'+app_color">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(certificate, index) in certificates" :key="certificate.id">
          <td width="5%">{{ index+1 }}</td>
          <td>{{ certificate.course | course }}</td>
          <td>{{ certificate.soa_number }}</td>
          <!-- <td>
            <input
              v-if="!certificate.soa_number.includes('SOA')"
              type="text"
              class="form-control"
              v-model="certificate.soa_number"
            />
          </td>-->
          <td>
            <date-picker v-model="certificate.release_date" :masks="{L:'DD/MM/YYYY'}"></date-picker>
          </td>
          <!-- <td width="5%">{{ certificate.release | release}}</td> -->
          <!-- <td>
            <date-picker v-model="certificate.reissued_date" :masks="{L:'DD/MM/YYYY'}"></date-picker>
          </td>-->
          <!-- <td width="5%">{{ certificate.reissue | reissued}}</td> -->
          <!-- <td>{{ certificate.created_at | dateFormat}}</td> -->
          <!-- <td>
            <date-picker
              v-if="!certificate.soa_number.includes('SOA')"
              v-model="certificate.completion_date"
              :masks="{L:'DD/MM/YYYY'}"
            ></date-picker>
          </td>-->
          <!-- <td>
            <date-picker
              v-if="!certificate.soa_number.includes('SOA')"
              v-model="certificate.enrolment_date"
              :masks="{L:'DD/MM/YYYY'}"
            ></date-picker>
          </td>-->
          <td>
            <div class="btn-group" role="group">
              <button
                v-bind:class="'btn btn-'+app_color+' dropdown-toggle btn-sm'"
                type="button"
                id="dropdownMenu1"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >Action</button>
              <ul
                class="dropdown-menu dropdown-menu-right multi-level"
                role="menu"
                aria-labelledby="dropdownMenu"
              >
                <li>
                  <a
                    class="dropdown-item"
                    href="javascript:void(0)"
                    @click="viewCertificate(certificate.id)"
                  >
                    <i class="fas fa-eye"></i> View
                  </a>
                </li>
                <li>
                  <a v-if="roles != 'Staff'"
                    class="dropdown-item"
                    href="javascript:void(0)"
                    @click="sendCertificate(certificate.id)"
                  >
                    <i class="fas fa-envelope"></i> Send <span v-if="certificate.sent === 1" class="float-right"><i class="fa fa-check text-success"></i></span>
                  </a>
                </li>
                <li>
                  <a v-if="roles != 'Staff'"
                    class="dropdown-item"
                    href="javascript:void(0)"
                    @click="editCompletion(certificates[index])"
                  >
                    <i class="fas fa-edit"></i> Edit Completion
                  </a>
                </li>
                <li>
                  <a v-if="roles != 'Staff'"
                    class="dropdown-item"
                    href="javascript:void(0)"
                    @click="editCertificate(index)"
                  >
                    <i class="fas fa-save"></i> Save Certificate
                  </a>
                </li>
                <li>
                  <a v-if="roles != 'Staff'"
                    class="dropdown-item"
                    href="javascript:void(0)"
                    @click="trashCertofocate(certificate.id)"
                  >
                    <i class="fas fa-trash"></i> Delete
                  </a>
                </li>
              </ul>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import moment from "moment";
export default {
  props: ["generate"],
  created() {
    this.fetchCertificates();
     if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  mounted() {
     if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  data() {
    return {
      app_color: app_color,
      roles: null,
      certificates: []
    };
  },
  methods: {
    sendCertificate(id){
       const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
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
          confirmButtonText: "Yes, send!"
        })
        .then(result => {
          if (result.value) {
             loadingSwal.fire({
                type: "info",
                title: "Please Wait ...",
              });
            axios
              .get(`/certificate_issuance/send/${id}`)
              .then(res => {
                Toast.fire({
                  type: "success",
                  title: res.data.message
                });
                this.fetchCertificates();
              })
              .catch(err => {
                Toast.fire({
                  type: "error",
                  title: err.data.message
                });
              });
          }
        });
    },
    editExtraUnitCompletion(extra) {
      let vm = this;
      $(`#nav-extra-list-tab`).tab("show");
      $(`#unit_${extra.extra_unit_id}`).collapse("toggle");
      vm.$emit("editExtraCompletion", {
        id: extra.id,
        unit_id: extra.extra_unit_id,
        units: extra.units,
        soa_number: extra.soa_number
      });
    },
    editCompletion(completion) {
      let vm = this;
      // console.log(completion)
      vm.$emit("editCompletion", {
        course: completion.course,
        units: completion.units,
        edit: true,
        id: completion.id,
        soa_number: completion.soa_number
      });
      $(`#nav-${completion.course}-i-tab`).tab("show");
    },
    fetchCertificates() {
      if(window.student.id != undefined){
        axios
        .get(`/certficate_issuance/list/${window.student.id}`)
        .then(response => {
          let data = response.data;
          // console.log(data);
          data.forEach(element => {
            if (element.release_date != null) {
              element.release_date = moment(element.release_date)._d;
            }

            if (element.reissued_date != null) {
              element.reissued_date = moment(element.reissued_date)._d;
            }

            if (element.completion_date != "") {
              // console.log(element.completion_date);
              element.completion_date = moment(element.completion_date)._d;
            }
            if (element.enrolment_date !== "") {
              // console.log(element.completion_date);
              element.enrolment_date = moment(element.enrolment_date)._d;
            }

            // console.log(element);
          });

          this.certificates = response.data.reverse();
        })
        .catch(err => {
          console.log(err);
        });
      }else{
        axios
        .get(`/certficate_issuance/list/${window.student_id}`)
        .then(response => {
          let data = response.data;
          // console.log(data);
          data.forEach(element => {
            if (element.release_date != null) {
              element.release_date = moment(element.release_date)._d;
            }

            if (element.reissued_date != null) {
              element.reissued_date = moment(element.reissued_date)._d;
            }

            if (element.completion_date != "") {
              // console.log(element.completion_date);
              element.completion_date = moment(element.completion_date)._d;
            }
            if (element.enrolment_date !== "") {
              // console.log(element.completion_date);
              element.enrolment_date = moment(element.enrolment_date)._d;
            }

            // console.log(element);
          });

          this.certificates = response.data.reverse();
        })
        .catch(err => {
          console.log(err);
        });
      }
      
    },
    viewCertificate(certificate) {
      window.open(`/certificate_issuance/preview/${certificate}`, "_blank");
      // console.log(certificate);
    },
    editCertificate(certificate) {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      let cert = this.certificates[certificate].id;
      let data = this.certificates[certificate];
      // console.log(data.reissued_date);
      if (data.release_date != null) {
        // console.log("sulod");
        data.release_date = moment(data.release_date).format("YYYY-MM-DD");
      }
      if (data.reissued_date != null) {
        console.log("sulod");
        data.reissued_date = moment(data.reissued_date).format("YYYY-MM-DD");
      }
      // console.log(data);
      axios
        .put(`/certificate_issuance/${cert}`, data)
        .then(res => {
          Toast.fire({
            type: "success",
            title: res.data.message
          });
          this.fetchCertificates();
        })
        .catch(err => {
          Toast.fire({
            type: "error",
            title: err.data.message
          });
        });
      // console.log(data);
      // console.log(this.certificates[certificate]);
      // console.log(certificate);
    },
    trashCertofocate(certificate) {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
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
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            axios
              .delete(`/certificate_issuance/${certificate}`)
              .then(res => {
                Toast.fire({
                  type: "success",
                  title: res.data.message
                });
                this.fetchCertificates();
              })
              .catch(err => {
                Toast.fire({
                  type: "error",
                  title: err.data.message
                });
              });
          }
        });
    }
  },
  watch: {
    generate: function(newVal, oldVal) {
      if (newVal == "success") {
        this.fetchCertificates();
        this.$parent.generate = "";
      }
    }
  },
  filters: {
    dateFormat(data) {
      if (data != "") {
        return moment(data).format("DD/MM/YYYY");
      } else {
        return "";
      }
    },
    course(data) {
      if (data == "1111") {
        return "Short Course";
      } else if (data == "@@@@") {
        return "Unit of Competency";
      } else {
        return data;
      }
    },
    release(data) {
      if (data == 1) {
        return "No";
      } else {
        return "Yes";
      }
    },
    reissued(data) {
      if (data == 1) {
        return "No";
      } else {
        return "Yes";
      }
    }
  }
};
</script>

<style scoped>
th {
  border-left: 0.5px solid #ffff !important;
}
</style>