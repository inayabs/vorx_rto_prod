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
            <h6 :class="'m-0 font-weight-bold text-'+app_color">USI Update Personal Details</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for>USI *</label>
                  <input type="text" v-model="usiForm.usi" class="form-control" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for>To be Updated</label>
                  <multiselect
                    v-model="usiForm.personalDetailsModifier"
                    placeholder="Select details to be Updated"
                    :options="option"
                    :multiple="false"
                  ></multiselect>
                </div>
              </div>
              <div class="col-md-6" v-if="usiForm.personalDetailsModifier">
                <div class="form-group">
                  <label for>{{ usiForm.personalDetailsModifier | caps }} *</label>

                  <multiselect
                    v-if="usiForm.personalDetailsModifier == 'CountryOfBirthCode'"
                    v-model="CountryOfBirthCodeSelected"
                    placeholder="Select Country of birth code"
                    label="name"
                    track-by="countryCode"
                    return="countryCode"
                    :options="CountryOfResidenceCode"
                    :multiple="false"
                  ></multiselect>
                  <input
                    v-else-if="usiForm.personalDetailsModifier !== 'Gender'"
                    type="text"
                    v-model="usiForm.personalDetailsUpdate[personalDetailsModifierHandler]"
                    class="form-control"
                  />
                  <multiselect
                    v-else
                    v-model="usiForm.personalDetailsUpdate[personalDetailsModifierHandler]"
                    placeholder="Select Gender"
                    :options="gender"
                    :multiple="false"
                  ></multiselect>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    for="usi"
                    data-toggle="tooltip"
                    title="Allows the organisation to override the DVS identity verification check."
                  >DVS Check Requried</label>
                  <input v-model="usiForm.dvscheckRequired" type="checkbox" class="form-control" />
                </div>
              </div>
              <div class="col-md-12">
                <div v-if="usiForm.dvscheckRequired" class="row p-2 mt-2">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="usi">DVS Document Type</label>
                      <select
                        v-model="usiForm.dvsdocument.type"
                        @change="changeType"
                        class="form-control"
                      >
                        <option
                          v-for="(doc, index) in DVSDocumentType"
                          :key="index"
                          :value="doc.value"
                        >{{ doc.name }}</option>
                      </select>
                    </div>
                    <!-- birth doc -->
                    <div v-if="usiForm.dvsdocument.type == 'birthCertificateDocument'" class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">
                            Registration Number
                            <a
                              data-toggle="tooltip"
                              :class="'a-'+app_color"
                              title=" NSW, VIC, WA, SA, ACT, NT,
• QLD if Registration Date on or after 2 July 1996,
• TAS if Registration Date on or after 1 Nov 1999
Valid Values: Must not exceed 10 characters
 • NSW (1 to 7 characters) - Numeric only
 • VIC (1 to 10 characters) - Numeric only
 • QLD (1 to 10 characters) - Numeric and non-mandatory
 • WA* (7 characters) - Numeric only
 • SA (1 to 10 characters) - Alphanumeric
 • TAS (1 to 5 characters) - Numeric and non-mandatory
 • NT (1 to 10 characters) - Numeric only
 • ACT (1 to 10 characters) - Numeric only"
                              data-placement="right"
                            >
                              <i class="fas fa-info-circle"></i>
                            </a>
                          </label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.registrationNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Registration State *</label>
                          <!-- <select
                            v-model="usiForm.dvsdocument.registrationState"
                            class="form-control"
                          >
                            <option
                              v-for="(state, index) in states"
                              :key="index"
                              :value="state"
                            >{{ state }}</option>
                          </select>-->
                          <multiselect
                            v-model="usiForm.dvsdocument.registrationState"
                            placeholder="Select State"
                            :options="states"
                            :multiple="false"
                          ></multiselect>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">
                            Registration Date (YYYY-MM-DD)
                            <a
                              data-toggle="tooltip"
                              :class="'a-'+app_color"
                              title=" Mandatory for:
• QLD and TAS"
                              data-placement="right"
                            >
                              <i class="fas fa-info-circle"></i>
                            </a>
                          </label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.registrationDate"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">
                            Registration Year (YYYY)
                            <a
                              data-toggle="tooltip"
                              :class="'a-'+app_color"
                              title=" Mandatory for:
• NSW, VIC and WA
• TAS if Registration Date on or after 1 Nov 1999"
                              data-placement="right"
                            >
                              <i class="fas fa-info-circle"></i>
                            </a>
                          </label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.registrationYear"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">
                            Date Printed (YYYY-MM-DD)
                            <a
                              data-toggle="tooltip"
                              :class="'a-'+app_color"
                              title="Mandatory for: SA, ACT, NT"
                              data-placement="right"
                            >
                              <i class="fas fa-info-circle"></i>
                            </a>
                          </label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.datePrinted"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">
                            Certificate Number
                            <a
                              data-toggle="tooltip"
                              :class="'a-'+app_color"
                              title="Mandatory for:
                            • SA if Date Printed on or after 1 Nov 1999
                            • ACT if Date Printed on or after 1 May 2002
                            • NT if Date Printed on or after 12 July 1999"
                              data-placement="right"
                            >
                              <i class="fas fa-info-circle"></i>
                            </a>
                          </label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.certificateNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- birth doc END -->
                    <!-- Certificate of Registration by Descent Document Type -->
                    <div
                      v-else-if="usiForm.dvsdocument.type == 'certificateOfRegistrationByDescentDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Acquisition Date (YYYY-MM-DD) *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.acquisitionDate"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Certificate of Registration by Descent Document Type END -->
                    <!-- Citizenship Certificate Document Type (Australian) -->
                    <div
                      v-else-if="usiForm.dvsdocument.type == 'citizenshipCertificateDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Stock Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.stockNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Acquisition Date (YYYY-MM-DD) *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.acquisitionDate"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Citizenship Certificate Document Type (Australian) END -->
                    <!-- Drivers Licence Document Type (Australian) -->
                    <div
                      v-else-if="usiForm.dvsdocument.type == 'driversLicenceDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">License Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.licenceNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">State *</label>
                          <!-- <select
                            class="form-control"
                            v-model="usiForm.dvsdocument.State"
                          >
                            <option
                              v-for="(state, index) in states"
                              :key="index"
                              :value="state"
                            >{{ state }}</option>
                          </select>-->
                          <multiselect
                            v-model="usiForm.dvsdocument.state"
                            placeholder="Select State"
                            :options="states"
                            :multiple="false"
                          ></multiselect>
                        </div>
                      </div>
                    </div>
                    <!-- Drivers Licence Document Type (Australian) END -->
                    <!-- Medicare Document Type -->
                    <div v-else-if="usiForm.dvsdocument.type == 'medicareDocument'" class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Medicare Card Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.medicareCardNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Individual Ref Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.individualRefNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Expiry Date (YYYY-MM-DD) *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.expiryDate"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Card Colour *</label>
                          <select v-model="usiForm.dvsdocument.cardColour" class="form-control">
                            <option value></option>
                            <option
                              v-for="(color, index) in CardColour"
                              :key="index"
                              :value="color"
                            >{{ color }}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Name Line1 *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.nameLine1"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Medicare Document Type END -->
                    <!-- Passport Document Type (Australian) -->
                    <div v-else-if="usiForm.dvsdocument.type == 'passportDocument'" class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Document Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.documentNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Passport Document Type (Australian) END -->
                    <!-- Visa Document Type -->
                    <div v-else-if="usiForm.dvsdocument.type == 'visaDocument'" class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Passport Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.passportNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Visa Document Type END -->
                    <!-- ImmiCard Document Type -->
                    <div v-else-if="usiForm.dvsdocument.type == 'immiCardDocument'" class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Immi Card Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.dvsdocument.immiCardNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- ImmiCard Document Type END -->
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
      app_color: app_color,
      // apiBaseUrl: "http://localhost:8080/api/",
      apiBaseUrl: "https://usiapi.vorx.com.au:8443/api/",
      states: window.state,
      gender: ["M", "F"],
      CountryOfBirthCodeSelected: {},
      CountryOfResidenceCode: [],
      nonDvsDocument: [],
      CountryOfResidenceCodeSelected: {},
      CardColour: ["Green", "Blue", "Yellow"],
      DVSDocumentType: [
        {
          name: "Birth Certificate Document Type (Australian)",
          value: "birthCertificateDocument"
        },
        {
          name: "Certificate of Registration by Descent Document",
          value: "certificateOfRegistrationByDescentDocument"
        },
        {
          name: "Citizenship Certificate Document Type (Australian)",
          value: "citizenshipCertificateDocument"
        },
        {
          name: "Drivers Licence Document Type (Australian)",
          value: "driversLicenceDocument"
        },
        {
          name: "Medicare Document Type",
          value: "medicareDocument"
        },
        {
          name: "Passport Document Type (Australian)",
          value: "passportDocument"
        },
        {
          name: "Visa Document Type",
          value: "visaDocument"
        },
        {
          name: "ImmiCard Document Type",
          value: "immiCardDocument"
        }
      ],
      option: [
        "FirstName",
        "MiddleName",
        "FamilyName",
        "SingleName",
        "DateOfBirth",
        "CountryOfBirthCode",
        "TownCityOfBirth",
        "Gender"
      ],
      personalDetailsModifierHandler: "",
      usiForm: {
        dvscheckRequired: true,
        dvsdocument: {},
        personalDetailsModifier: "",
        usi: "",
        nonDvsDocumentTypeId: "",
        nonDvsDocumentTypeOther: "",
        personalDetailsUpdate: {},
        orgCode: this.training_org.training_organisation_id
        // orgCode: "VA1803"
      }
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
    changeType() {
      if (this.usiForm.dvscheckRequired) {
        let doc = this.usiForm.dvsdocument;
        let oldtype = this.usiForm.dvsdocument.type;
        if (Object.keys(doc).length > 1) {
          this.usiForm.dvsdocument = { type: oldtype };
          // this.usiForm.dvsdocument.type = oldtype;
        }
      } else {
      }
      // 1995-05-05
      // UK6Y3APRPX
      // console.log(Object.keys(doc).length);
    },
    getCountries() {
      let vm = this;
      let endPoint = this.apiBaseUrl;
      axios
        .post(
          `${endPoint}countries`,
          { orgCode: this.usiForm.orgCode },
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
      let usidatas = {};
      usidatas.usi = this.usiForm.usi;
      usidatas.dvscheckRequired = this.usiForm.dvscheckRequired;
      usidatas.personalDetailsModifier = this.usiForm.personalDetailsModifier;
      usidatas.personalDetailsModifier = this.usiForm.personalDetailsModifier;
      usidatas.orgCode = this.usiForm.orgCode;
      usidatas.personalDetailsUpdate = this.usiForm.personalDetailsUpdate;
      usidatas.userReference = `${this.training_org.training_organisation_id}Update${this.training_org.student_id_prefix}`;
      if (this.usiForm.dvscheckRequired) {
        usidatas.dvsdocument = this.usiForm.dvsdocument;
      } else {
        usidatas.nonDvsDocumentTypeId = this.usiForm.nonDvsDocumentTypeId;
        usidatas.nonDvsDocumentTypeOther = this.usiForm.nonDvsDocumentTypeOther;
      }

      return usidatas;
    },
    submitDetails() {
      let datas = this.cleanObject();
      let toast = swal.fire({
        position: "top-end",
        title: "Please wait",
        showConfirmButton: false,
        onBeforeOpen: () => {
          swal.showLoading();
        }
      });
      axios
        .post(`${this.apiBaseUrl}update/personaldetails`, datas, {
          headers: {
            Authorization: this.getAuth()
          }
        })
        .then(response => {
          // console.log(response);
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
                  <div class="clearfix"></div>
                  <span>Identity Document Verified: ${response.data.identityDocumentVerified}</span>
                  <div class="clearfix"></div>
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
                  <span>Identity Document Verified: ${response.data.identityDocumentVerified}</span>
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
            html: `span${error.response.data.message}</span>`,
            footer: "<a href>Why do I have this issue?</a>"
          });
        });
    }
  },
  watch: {
    "usiForm.personalDetailsModifier": function(newValue, oldValue) {
      if (oldValue) {
        this.usiForm.personalDetailsUpdate = {};
      }
      this.personalDetailsModifierHandler = newValue;
    },
    personalDetailsModifierHandler: function() {
      this.personalDetailsModifierHandler =
        this.personalDetailsModifierHandler.charAt(0).toLowerCase() +
        this.personalDetailsModifierHandler.slice(1);
    },
    CountryOfBirthCodeSelected(newValues) {
      if (newValues !== null) {
        this.usiForm.personalDetailsUpdate.countryOfBirthCode =
          newValues.countryCode;
      }
    }
  },
  filters: {
    caps: function(value) {
      if (value !== "") {
        let nVal = "";
        nVal = value.charAt(0).toUpperCase() + value.slice(1);

        return nVal.match(/[A-Z][a-z]+|[0-9]+/g).join(" ");
      }
    },
    lower: function(value) {
      let nVal = "";
      nVal = value.charAt(0).toLowerCase() + value.slice(1);
      return nVal;
    }
  }
};
</script>