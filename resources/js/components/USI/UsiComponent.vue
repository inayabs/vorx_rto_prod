<template>
  <div>
    <div class="row mb-2 d-flex justify-content-between">
      <div class="col-md-6">
        <a href="/" :class="'btn btn-'+app_color+' btn-sm text-primary text-light'">
          <i class="fas fa-long-arrow-alt-left"></i> Back
        </a>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">USI Verify</h6>
          </div>
          <div class="card-body">
            <div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="usi">USI</label>
                    <input type="text" v-model="usiForm.usi" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" v-model="usiForm.firstName" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="firstname">Family Name</label>
                        <input type="text" v-model="usiForm.familyName" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="firstname">Single Name</label>
                        <input type="text" v-model="usiForm.singleName" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="firstname">Date Of Birth</label>
                    <date-picker
                      v-model="usiForm.dateOfBirth"
                      :max-date="new Date()"
                      :masks="{L:'DD/MM/YYYY'}"
                    ></date-picker>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <button type="submit" @click="callApi(apiBaseUrl)" class="btn btn-success">Verify</button>
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
import moment from "moment";
export default {
  props: ["training_org"],
  data() {
    return {
      app_color: app_color,
      usiForm: {
        usi: "",
        firstName: "",
        familyName: "",
        singleName: "",
        dateOfBirth: "",
        orgCode: this.training_org.training_organisation_id
        // orgCode: "VA1803"
      },
      apiBaseUrl: "https://usiapi.vorx.com.au:8443/api/"
      // apiBaseUrl: "http://localhost:8080/api/"
    };
  },
  methods: {
    getAuth() {
      let apiUser = "admin";
      let apiPass = "nimda321";
      let basicAuth;
      basicAuth = "Basic " + btoa(apiUser + ":" + apiPass);
      return basicAuth;
    },
    callApi(endPoint) {
      let vm = this;

      let toast = swal.fire({
        position: "top-end",
        title: "Please wait",
        showConfirmButton: false,
        timer: 30000
      });

      if (vm.usiForm.dateOfBirth != "") {
        vm.usiForm.dateOfBirth = moment(vm.usiForm.dateOfBirth).format(
          "YYYY-MM-DD"
        );
      }
      if (vm.usiForm.firstName == "" && vm.usiForm.familyName == "") {
        delete vm.usiForm.firstName;
        delete vm.usiForm.familyName;
      } else {
        delete vm.usiForm.singleName;
      }

      console.log(vm.usiForm);
      axios
        .post(`${endPoint}verify`, vm.usiForm, {
          headers: {
            Authorization: vm.getAuth()
          }
        })
        .then(response => {
          toast.dismiss === swal.DismissReason.timer;
          if (response.data.hasOwnProperty("errorInfo")) {
            console.log(response.data.errorInfo);
            let em = response.data.errorInfo;
            let rmessage = "";
            em.forEach(element => {
              rmessage += "<li>" + element.message + "</li>";
            });

            swal.fire({
              type: "error",
              title: "Oops...",
              html: `<ul>${rmessage}</ul>`,
              footer: "<a href>Why do I have this issue?</a>"
            });
          } else if (response.data.hasOwnProperty("code")) {
            let em = response.data.message;
            swal.fire({
              type: "error",
              title: "Oops...",
              html: em,
              footer: "<a href>Why do I have this issue?</a>"
            });
          } else {
            // console.log(response.data);
            swal.fire({
              title: "<strong>USI Result</strong>",
              type: "info",
              html: `<div class="info-message-wrapper">
              <div class="row">
                <div class="col-md-6 offset-md-3 text-left">
                  <span>First Name : ${response.data.firstName}</span>
                  <div class="clearfix"></div>
                  <span>Family Name : ${response.data.familyName}</span>
                  <div class="clearfix"></div>
                  <span>Single Name : ${response.data.singleName}</span>
                  <div class="clearfix"></div>
                    <span>Date of Birth : ${response.data.dateOfBirth}</span>
                  <div class="clearfix"></div>
                  <span>USI Status : ${response.data.usistatus}</span>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>`,
              showCloseButton: false,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
              confirmButtonAriaLabel: "Thumbs up, great!"
            });
          }
          // console.log(response)
        })
        .catch(err => {
          if (vm.usiForm.dateOfBirth != "") {
            vm.usiForm.dateOfBirth = moment(vm.usiForm.dateOfBirth)._d;
          }
          swal.fire({
            type: "error",
            title: "Oops...",
            html: `<ul>${err.response.data.message}</ul>`,
            footer: "<a href>Why do I have this issue?</a>"
          });
        });
    }
  }
};
</script>