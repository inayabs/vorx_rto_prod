<template>
  <div>
    <div class="row mb-3">
      <div class="col-md-12 pull-right text-right">
        <button class="btn btn-success" @click="callApi(apiBaseUrl)">
          <i class="far fa-save"></i> Submit
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">USI Creation</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usi">Application ID</label>
                  <input
                    type="text"
                    v-model="usiForm.application.applicationId"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="usi">Personal Details *</label>
                  <div class="row p-2 mt-2">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">First Name *</label>
                        <input
                          type="text"
                          v-model="usiForm.application.personalDetails.firstName"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Family Name *</label>
                        <input
                          type="text"
                          v-model="usiForm.application.personalDetails.familyName"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="usi">Single Name</label>
                        <input
                          type="text"
                          v-model="usiForm.application.personalDetails.singleName"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Date Of Birth (DD/MM/YYYY) *</label>
                      </div>
                      <date-picker
                        v-model="usiForm.application.personalDetails.dateOfBirth"
                        :max-date="new Date()"
                        :masks="{L:'DD/MM/YYYY'}"
                      ></date-picker>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Gender *</label>
                        <multiselect
                          v-model="usiForm.application.personalDetails.gender"
                          placeholder="Select Gender"
                          :options="gender"
                          :multiple="false"
                        ></multiselect>
                        <!-- <input type="text" class="form-control" /> -->
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Country Of Birth Code</label>
                        <!-- <input type="text" class="form-control" /> -->
                        <multiselect
                          v-model="CountryOfBirthCodeSelected"
                          placeholder="Select Country of birth code"
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
                        <label for="usi">Town / City Of Birth</label>
                        <input
                          type="text"
                          v-model="usiForm.application.personalDetails.townCityOfBirth"
                          class="form-control"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label
                    for="usi"
                    data-toggle="tooltip"
                    title="Allows the organisation to override the DVS identity verification check."
                  >DVS Check Requried</label>
                  <input
                    v-model="usiForm.application.dvscheckRequired"
                    type="checkbox"
                    @change="clearData"
                    class="form-control"
                  />
                </div>
                <div v-if="usiForm.application.dvscheckRequired" class="row p-2 mt-2">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="usi">DVS Document Type</label>
                      <select
                        v-model="usiForm.application.dvsdocument.type"
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
                    <div
                      v-if="usiForm.application.dvsdocument.type == 'birthCertificateDocument'"
                      class="row"
                    >
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
                            v-model="usiForm.application.dvsdocument.registrationNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Registration State *</label>
                          <multiselect
                            v-model="usiForm.application.dvsdocument.registrationState"
                            placeholder="Select State"
                            :options="states"
                            :multiple="false"
                          ></multiselect>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">
                            Registration Date (DD/MM/YYYY)
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
                          <date-picker
                            v-model="usiForm.application.dvsdocument.registrationDate"
                            :max-date="new Date()"
                            :masks="{L:'DD/MM/YYYY'}"
                          ></date-picker>
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
                            v-model="usiForm.application.dvsdocument.registrationYear"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">
                            Date Printed (DD/MM/YYYY)
                            <a
                              data-toggle="tooltip"
                              :class="'a-'+app_color"
                              title="Mandatory for: SA, ACT, NT"
                              data-placement="right"
                            >
                              <i class="fas fa-info-circle"></i>
                            </a>
                          </label>
                          <date-picker
                            v-model="usiForm.application.dvsdocument.datePrinted"
                            :max-date="new Date()"
                            :masks="{input:['YYYY/MM/DD']}"
                          ></date-picker>
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
                            v-model="usiForm.application.dvsdocument.certificateNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- birth doc END -->
                    <!-- Certificate of Registration by Descent Document Type -->
                    <div
                      v-else-if="usiForm.application.dvsdocument.type == 'certificateOfRegistrationByDescentDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Acquisition Date (DD/MM/YYYY) *</label>
                          <date-picker
                            v-model="usiForm.application.dvsdocument.acquisitionDate"
                            :max-date="new Date()"
                            :masks="{L:'DD/MM/YYYY'}"
                          ></date-picker>
                        </div>
                      </div>
                    </div>
                    <!-- Certificate of Registration by Descent Document Type END -->
                    <!-- Citizenship Certificate Document Type (Australian) -->
                    <div
                      v-else-if="usiForm.application.dvsdocument.type == 'citizenshipCertificateDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Stock Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.stockNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Acquisition Date (YYYY-MM-DD) *</label>
                          <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.acquisitionDate"
                            class="form-control"
                          />
                          <date-picker
                            v-model="usiForm.application.dvsdocument.acquisitionDate"
                            :max-date="new Date()"
                            :masks="{L:'DD/MM/YYYY'}"
                          ></date-picker>
                        </div>
                      </div>
                    </div>
                    <!-- Citizenship Certificate Document Type (Australian) END -->
                    <!-- Drivers Licence Document Type (Australian) -->
                    <div
                      v-else-if="usiForm.application.dvsdocument.type == 'driversLicenceDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">License Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.licenceNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">State *</label>
                          <!-- <select
                            class="form-control"
                            v-model="usiForm.application.dvsdocument.State"
                          >
                            <option
                              v-for="(state, index) in states"
                              :key="index"
                              :value="state"
                            >{{ state }}</option>
                          </select>-->
                          <multiselect
                            v-model="usiForm.application.dvsdocument.state"
                            placeholder="Select State"
                            :options="states"
                            :multiple="false"
                          ></multiselect>
                        </div>
                      </div>
                    </div>
                    <!-- Drivers Licence Document Type (Australian) END -->
                    <!-- Medicare Document Type -->
                    <div
                      v-else-if="usiForm.application.dvsdocument.type == 'medicareDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Medicare Card Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.medicareCardNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Individual Ref Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.individualRefNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Expiry Date (YYYY-MM) *</label>
                           <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.expiryDate"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Card Colour *</label>
                          <select
                            v-model="usiForm.application.dvsdocument.cardColour"
                            class="form-control"
                          >
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
                            v-model="usiForm.application.dvsdocument.nameLine1"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Medicare Document Type END -->
                    <!-- Passport Document Type (Australian) -->
                    <div
                      v-else-if="usiForm.application.dvsdocument.type == 'passportDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Document Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.documentNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Passport Document Type (Australian) END -->
                    <!-- Visa Document Type -->
                    <div
                      v-else-if="usiForm.application.dvsdocument.type == 'visaDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Passport Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.passportNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Visa Document Type END -->
                    <!-- ImmiCard Document Type -->
                    <div
                      v-else-if="usiForm.application.dvsdocument.type == 'immiCardDocument'"
                      class="row"
                    >
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="usi">Immi Card Number *</label>
                          <input
                            type="text"
                            v-model="usiForm.application.dvsdocument.immiCardNumber"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- ImmiCard Document Type END -->
                  </div>
                </div>
                <div v-else class="row p-2 mt-2">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="usi">Non DVS Document Type</label>
                      <select
                        v-model="usiForm.application.nonDvsDocumentTypeId"
                        @change="changeType"
                        class="form-control"
                      >
                        <option
                          v-for="(doc, index) in nonDvsDocument"
                          :key="index"
                          :value="doc.id"
                        >{{ doc.documentType }}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr />
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
                          v-model="usiForm.application.contactDetails.emailAddress"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Phone Number : (Home)</label>
                        <input
                          type="text"
                          v-model="usiForm.application.contactDetails.phone.home"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Phone Number : (mobile)</label>
                        <input
                          type="text"
                          v-model="usiForm.application.contactDetails.phone.mobile"
                          class="form-control"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr />
            <div class="clearfix"></div>
            <div
              v-if="usiForm.application.contactDetails.countryOfResidenceCode !='1101'"
              class="row"
            >
              <div class="col-md-12">
                <div class="form-group">
                  <label for="usi">International Address</label>
                  <textarea
                    v-model="usiForm.application.contactDetails.internationalAddress"
                    class="form-control"
                  />
                </div>
              </div>
            </div>
            <div v-else class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="usi">National Address</label>
                  <div class="row p-2 mt-2">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Address 1 *</label>
                        <input
                          type="text"
                          v-model="usiForm.application.contactDetails.nationalAddress.address1"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Address 2</label>
                        <input
                          type="text"
                          v-model="usiForm.application.contactDetails.nationalAddress.address2"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Suburb / Town / City *</label>
                        <input
                          type="text"
                          v-model="usiForm.application.contactDetails.nationalAddress.suburbTownCity"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">State *</label>
                        <!-- <input
                          type="text"
                          v-model="usiForm.application.contactDetails.nationalAddress.state"
                          class="form-control"
                        />-->
                        <multiselect
                          v-model="usiForm.application.contactDetails.nationalAddress.state"
                          placeholder="Select State"
                          :options="states"
                          :multiple="false"
                        ></multiselect>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="usi">Post Code</label>
                        <input
                          type="text"
                          v-model="usiForm.application.contactDetails.nationalAddress.postCode"
                          class="form-control"
                        />
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
import moment from "moment";
export default {
  props: ["training_org"],
  data() {
    return {
      app_color: app_color,
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
      usiForm: {
        application: {
          applicationId: "",
          contactDetails: {
            countryOfResidenceCode: "",
            phone: {},
            nationalAddress: {}
          },
          dvscheckRequired: true,
          dvsdocument: {},
          nonDvsDocumentTypeId: "",
          nonDvsDocumentTypeOther: "",
          personalDetails: {
            firstName: "",
            familyName: "",
            dateOfBirth: "",
            singleName: "",
            gender: "",
            isPreferredName: true,
            townCityOfBirth: ""
          },
          userReference: `${this.training_org.training_organisation_id}Creation${this.training_org.student_id_prefix}`
        },
        orgCode: this.training_org.training_organisation_id
        // orgCode: "VA1803"
      },
      apiBaseUrl: "https://usiapi.vorx.com.au:8443/api/"
      // apiBaseUrl: "http://localhost:8080/api/"
    };
  },
  created() {
    this.getCountries();
    this.getNonDvsDoc();
    this.usiForm.application.applicationId = this.randomString(
      20,
      "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
    );
  },
  methods: {
    getAuth() {
      let apiUser = "admin";
      let apiPass = "nimda321";
      let basicAuth;
      basicAuth = "Basic " + btoa(apiUser + ":" + apiPass);
      return basicAuth;
    },
    getNonDvsDoc() {
      let vm = this;
      let endPoint = this.apiBaseUrl;
      axios
        .post(
          `${endPoint}nondvsdoctypes`,
          { orgCode: this.usiForm.orgCode },
          {
            headers: {
              Authorization: vm.getAuth()
            }
          }
        )
        .then(response => {
          // console.log(response.data);
          vm.nonDvsDocument =
            response.data.nonDvsDocumentTypes.nonDvsDocumentType;
        })
        .catch(error => {
          console.log(error);
        });
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
    randomString(length, chars) {
      var result = "";
      for (var i = length; i > 0; --i)
        result += chars[Math.floor(Math.random() * chars.length)];
      return result;
    },
    cleanObject() {
      let Usi_Form = {};
      let applicationContactDetails = {};
      let document = {};
      Usi_Form.orgCode = this.usiForm.orgCode;
      Usi_Form.application = {};
      Usi_Form.application.applicationId = this.usiForm.application.applicationId;
      Usi_Form.application.dvscheckRequired = this.usiForm.application.dvscheckRequired;
      Usi_Form.application.userReference = this.usiForm.application.userReference;
      Usi_Form.application.contactDetails = {};
      if (
        this.usiForm.application.contactDetails.countryOfResidenceCode ===
        "1101"
      ) {
        applicationContactDetails = {
          countryOfResidenceCode: this.usiForm.application.contactDetails
            .countryOfResidenceCode,
          emailAddress: this.usiForm.application.contactDetails.emailAddress,
          nationalAddress: this.usiForm.application.contactDetails
            .nationalAddress,
          phone: this.usiForm.application.contactDetails.phone
        };
      } else {
        applicationContactDetails = {
          countryOfResidenceCode: this.usiForm.application.contactDetails
            .countryOfResidenceCode,
          emailAddress: this.usiForm.application.contactDetails.emailAddress,
          internationalAddress: this.usiForm.application.contactDetails
            .internationalAddress,
          phone: this.usiForm.application.contactDetails.phone
        };
      }

      Usi_Form.application.contactDetails = applicationContactDetails;
      Usi_Form.application.personalDetails = this.usiForm.application.personalDetails;
      if (Usi_Form.application.personalDetails.singleName == "") {
        delete Usi_Form.application.personalDetails.singleName;
      } else {
        delete Usi_Form.application.personalDetails.firstName;
        delete Usi_Form.application.personalDetails.familyName;
      }

      Usi_Form.application.personalDetails.dateOfBirth = moment(
        Usi_Form.application.personalDetails.dateOfBirth
      ).format("YYYY-MM-DD");
      if (this.usiForm.application.dvscheckRequired) {
        // console.log(this.usiForm.application.dvsdocument);

        Usi_Form.application.dvsdocument = this.usiForm.application.dvsdocument;
        for (var dvs in Usi_Form.application.dvsdocument) {
          if (
            dvs == "registrationDate" ||
            dvs == "datePrinted" ||
            dvs == "acquisitionDate"
          ) {
            Usi_Form.application.dvsdocument[dvs] = moment(
              Usi_Form.application.dvsdocument[dvs]
            ).format("YYYY-MM-DD");
          }
        }
      } else {
        Usi_Form.application.nonDvsDocumentTypeId = this.usiForm.application.nonDvsDocumentTypeId;
        // Usi_Form.application.nonDvsDocumentTypeOther = this.usiForm.application.nonDvsDocumentTypeOther;
      }

      return Usi_Form;
    },
    callApi(endPoint) {
      let vm = this;
      let toast = swal.fire({
        position: "top-end",
        title: "Please wait",
        showConfirmButton: false,
        onBeforeOpen: () => {
          swal.showLoading();
        }
      });
      // console.log(vm.usiForm);

      // this.$set(usi_form,)
      // if (
      //   (vm.usiForm.application.personalDetails.firstName === "" &&
      //     vm.usiForm.application.personalDetails.familyName === "") ||
      //   vm.usiForm.application.personalDetails.singleName === ""
      // ) {
      // swal.fire({
      //   type: "error",
      //   title: "Oops...",
      //   html: `<span>Please fill up all required fields</span>`
      // });
      // } else {
      let newForm = vm.cleanObject();
      // console.log(newForm);
      axios
        .post(`${endPoint}create`, newForm, {
          headers: {
            Authorization: vm.getAuth()
          }
        })
        .then(response => {
          if (response.data.hasOwnProperty("errorInfo")) {
            let em = response.data.errorInfo;
            let rmessage = "";
            em.forEach(element => {
              rmessage += "<li>" + element.message + "</li>";
            });

            swal.fire({
              type: "error",
              title: "Oops...",
              html: `<ul>${rmessage}</ul>`
            });
          } else if (response.data.hasOwnProperty("code")) {
            let em = response.data.message;
            swal.fire({
              type: "error",
              title: response.data.title,
              html: em
            });
          } else if (response.data.application.hasOwnProperty("errors")) {
            if (response.data.application.result == "Failure") {
              let em = response.data.application.errors;
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
                  <span>Date Processed : ${moment(
                    response.data.application.processedDate
                  ).format("DD/MM/YYYY")}</span>
                  <div class="clearfix"></div>
                  <span>Identity Document Verified: ${
                    response.data.application.identityDocumentVerified
                  }</span>
                  <div class="clearfix"></div>
                    <span>ERRORS : </span>
                    <ul>${rmessage}</ul>
                  <div class="clearfix"></div>
                  <span>Result : ${response.data.application.result}</span>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div> `
              });
            } else {
              swal.fire({
                title: "<strong>USI Result</strong>",
                type: "info",
                html: `<div class="info-message-wrapper">
              <div class="row">
                <div class="col-md-6 offset-md-3 text-left">
                  <span>Date Processed : ${moment(
                    response.data.application.processedDate
                  ).format("DD/MM/YYYY")}</span>
                  <div class="clearfix"></div>
                  <span>Identity Document Verified: ${
                    response.data.application.identityDocumentVerified
                  }</span>
                  <div class="clearfix"></div>
                    <span>USI : ${response.data.application.usi}</span>
                  <div class="clearfix"></div>
                  <span>Result : ${response.data.application.result}</span>
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
              vm.usiForm.application = {
                applicationId: this.randomString(
                  20,
                  "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
                ),
                contactDetails: {
                  countryOfResidenceCode: "",
                  phone: {},
                  nationalAddress: {}
                },
                dvscheckRequired: true,
                dvsdocument: {},
                nonDvsDocumentType: "",
                personalDetails: {
                  firstName: "",
                  familyName: "",
                  dateOfBirth: "",
                  gender: "",
                  isPreferredName: true,
                  townCityOfBirth: ""
                },
                userReference: `${this.training_org.training_organisation_id}Creation${this.training_org.student_id_prefix}`
              };
            }
            vm.CountryOfBirthCodeSelected = "";
            vm.CountryOfResidenceCodeSelected = "";
          }
        })
        .catch(error => {
          swal.fire({
            type: "error",
            title: "Opps ,Something Went Wrong."
          });
        });
      // }
    },
    clearData() {
      // console.log(this.usiForm.application.dvscheckRequired);
      if (this.usiForm.application.dvscheckRequired) {
        this.usiForm.application.nondvsdocument = {};
        this.usiForm.application.nonDvsDocumentTypeOther = "";
        this.usiForm.application.nonDvsDocumentTypeOther = "";
      } else {
        this.usiForm.application.dvsdocument = {};
      }
    },
    changeType() {
      if (this.usiForm.application.dvscheckRequired) {
        let doc = this.usiForm.application.dvsdocument;
        let oldtype = this.usiForm.application.dvsdocument.type;
        if (Object.keys(doc).length > 1) {
          this.usiForm.application.dvsdocument = { type: oldtype };
          // this.usiForm.application.dvsdocument.type = oldtype;
        }
      } else {
      }

      // console.log(Object.keys(doc).length);
    }
  },
  watch: {
    CountryOfResidenceCodeSelected(newValues) {
      if (newValues !== null) {
        this.usiForm.application.contactDetails.countryOfResidenceCode =
          newValues.countryCode;
      } else {
        this.usiForm.application.contactDetails.countryOfResidenceCode = "";
      }
    },
    CountryOfBirthCodeSelected(newValues) {
      if (newValues !== null) {
        this.usiForm.application.personalDetails.countryOfBirthCode =
          newValues.countryCode;
      } else {
        this.usiForm.application.personalDetails.countryOfBirthCode = "";
      }
    }
  }
};
</script>