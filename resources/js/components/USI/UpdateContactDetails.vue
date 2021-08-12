<template>
  <div>
    <div class="row mb-3">
      <div class="col-md-12 pull-right text-right">
        <button class="btn btn-success" @click="submitDetails">
          <i class="far fa-save"></i> Submit
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">USI Update Contact Details</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for>USI</label>
                  <input type="text" v-model="usi" class="form-control" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="usi">Contact Details *</label>
                  <div class="row p-2 mt-2">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Country Of Residence Code *</label>
                        <multiselect
                          v-model="CountryOfResidenceCodeSelected"
                          placeholder="Select area code"
                          label="name"
                          track-by="countryCode"
                          return="countryCode"
                          :options="CountryOfResidenceCode"
                          :multiple="false"
                        ></multiselect>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Email Address</label>
                        <input
                          type="text"
                          v-model="contactDetails.emailAddress"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Phone Number : (Home)</label>
                        <input type="text" v-model="phone.home" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Phone Number : (mobile)</label>
                        <input type="text" v-model="phone.mobile" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="usi">National Address</label>
                  <div class="row p-2 mt-2">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Address 1</label>
                        <input type="text" v-model="nationalAddress.address1" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Address 2</label>
                        <input type="text" v-model="nationalAddress.address2" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Suburb / Town / City</label>
                        <input
                          type="text"
                          v-model="nationalAddress.suburbTownCity"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">State</label>
                        <input type="text" v-model="nationalAddress.state" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Post Code</label>
                        <input type="text" v-model="nationalAddress.postCode" class="form-control" />
                      </div>
                    </div>
                  </div>
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
export default {
  props: ["training_org"],
  data() {
    return {
      CountryOfResidenceCodeSelected: {},
      usi: "",
      CountryOfResidenceCode: [],
      contactDetails: {},
      phone: {},
      internationalAddress: "",
      nationalAddress: {},
      app_color: app_color,
      orgCode: this.training_org.training_organisation_id,
      //   orgCode: "VA1803",
      //   apiBaseUrl: "http://localhost:8080/api/"
      apiBaseUrl: "https://usiapi.vorx.com.au:8443/api/"
    };
  },

  created() {
    this.getCountries();
  },
  methods: {
    getAuth() {
      let apiUser = "admin";
      let apiPass = "nimda321";
      let basicAuth;
      basicAuth = "Basic " + btoa(apiUser + ":" + apiPass);
      return basicAuth;
    },
    isEmpty(obj) {
      for (var key in obj) {
        if (obj.hasOwnProperty(key)) return false;
      }
      return true;
    },
    getCountries() {
      let vm = this;
      let endPoint = this.apiBaseUrl;
      axios
        .post(
          `${endPoint}countries`,
          { orgCode: this.orgCode },
          {
            headers: {
              Authorization: vm.getAuth()
            }
          }
        )
        .then(response => {
          // console.log(response.data);
          vm.CountryOfResidenceCode = response.data.countries.countryDetails;
        })
        .catch(error => {
          console.log(error);
        });
    },
    cleanObject() {
      let usi = {};
      let _updateUSIContactDetails = {};
      usi.usi = this.usi;
      usi.orgCode = this.orgCode;
      usi.userReference = `${this.training_org.training_organisation_id}Update${this.training_org.student_id_prefix}`;
      //   usi.updateUSIContactDetails = this.contactDetails;
      if (!this.isEmpty(this.CountryOfResidenceCodeSelected)) {
        if (!this.isEmpty(this.contactDetails)) {
          _updateUSIContactDetails = this.contactDetails;
        }
        _updateUSIContactDetails.countryOfResidenceCode = this.CountryOfResidenceCodeSelected.countryCode;

        if (this.CountryOfResidenceCodeSelected.countryCode == "1101") {
          if (!this.isEmpty(this.phone)) {
            _updateUSIContactDetails.phone = this.phone;
          }
          if (!this.isEmpty(this.nationalAddress)) {
            _updateUSIContactDetails.nationalAddress = this.nationalAddress;
          }
          if (!this.isEmpty(this.contactDetails)) {
            _updateUSIContactDetails = this.contactDetails;
          }
        } else {
          if (!this.isEmpty(this.phone)) {
            _updateUSIContactDetails.phone = this.phone;
          }
          if (!this.isEmpty(this.nationalAddress)) {
            _updateUSIContactDetails.internationalAddress = this.internationalAddress;
          }
        }
        usi.contactDetailsUpdate = _updateUSIContactDetails;
      }
      return usi;
    },
    submitDetails() {
      let toast = swal.fire({
        position: "top-end",
        title: "Please wait",
        showConfirmButton: false,
        onBeforeOpen: () => {
          swal.showLoading();
        }
      });
      let datas = this.cleanObject();
      axios
        .post(`${this.apiBaseUrl}update/contactdetails`, datas, {
          headers: {
            Authorization: this.getAuth()
          }
        })
        .then(response => {
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
              title: response.data.title,
              html: em,
              footer: "<a href>Why do I have this issue?</a>"
            });
          } else if (response.data.hasOwnProperty("errors")) {
            if (response.data.result == "Failure") {
              let em = response.data.errors;
              let rmessage = "";
              em.error.forEach(element => {
                rmessage +=
                  "<li> Code : " +
                  element.code +
                  " Message : " +
                  element.message +
                  "</li>";
              });
              swal.fire({
                type: "error",
                title: "Oops...",
                html: `<div class="info-message-wrapper">
              <div class="row">
                <div class="col-md-12 text-left">
                    <span>ERRORS : </span>
                    <ul>${rmessage}</ul>
                  <div class="clearfix"></div>
                  <span>Result : ${response.data.result}</span>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div> `,
                footer: "<a href>Why do I have this issue?</a>"
              });
            }
          } else {
            swal.fire({
              title: "<strong>Update Personal Details</strong>",
              type: "info",
              html: `<div class="info-message-wrapper">
              <div class="row">
                <div class="col-md-6 offset-md-3 text-left">
                  <div class="clearfix"></div>
                  <span>Result : ${response.data.result}</span>
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
        })
        .catch(error => {
          swal.fire({
            type: "error",
            title: "Something Went Wrong",
            html: `<span>${error.response.data.message}</span>`,
            footer: "<a href>Why do I have this issue?</a>"
          });
        });
    }
  }
};
</script>
