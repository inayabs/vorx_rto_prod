<template>
  <div>
    <div class="row mb-3">
      <div   class="col-md-12 pull-right text-right">
        <button  class="btn btn-success" :disabled="roles == 'Staff'? true : false " @click="saveChanges()">
          <i class="far fa-save"></i> Save Changes
        </button>
      </div>
    </div>
    <div v-for="(form, key) in this.formSettings" :key="key" :class="toType(form.FormWrapper) !== 'undefined' ? form.FormWrapper : ''" :hidden="toType(form.isHidden) !== 'undefined' ? form.isHidden : false">
      <div v-if="form.FormTitle !== 'none'" v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
        <h6>{{form.FormTitle}}</h6>
      </div>
      <div class="clearfix"></div>
      <div class="form-padding-left-right">
        <div class="row">
          <div
            v-for="(itm, k) in form.FormBody"
            :key="k"
            v-bind:class="toType(itm['col_size']) !== 'undefined' ? 'col-md-'+itm['col_size'] : 'col-md-6'"
          >
            <div v-if="itm['type'] === 'text'">
              <!-- text -->

              <div class="form-group">
                <label for="company_name">
                  {{itm['lable']}}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-'+app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                  <span
                    style="font-size: 74%;opacity: 73%;"
                    v-if="itm['name'] === 'addr_postal_delivery_box'"
                  >
                    (
                    <i>If different from above</i> )
                  </span>
                </label>
                <div v-if="itm['name'] == 'unique_student_id'" class="input-group mb-3">
                  <input
                    type="text"
                    class="form-control"
                    v-bind:name="itm['name']"
                    v-bind:id="itm['name']"
                    v-model="inputs[itm['name']]"
                    aria-describedby="basic-addon2"
                  />

                  <div class="input-group-append">
                    <button
                      v-if="inputs['verified']"
                      class="btn btn-success btn-outline-secondary"
                      @click="verifyUsiData"
                      type="button"
                    >Verified</button>
                    <button
                      v-else
                      class="btn btn-outline-secondary"
                      @click="verifyUsiData"
                      type="button"
                    >Verify</button>
                  </div>
                </div>
                <input
                  v-else
                  class="form-control"
                  v-bind:name="itm['name']"
                  type="text"
                  v-bind:id="itm['name']"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                />
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                >{{ errors[itm['name']][0]}}</span>
              </div>
            </div>
            <div v-else-if="itm['type'] === 'hr'">
              <hr>
            </div>
            <div v-else-if="itm['type'] === 'select'">
              <!-- selectbox -->
              <div v-if="itm['name'] === 'funding_type'" class="form-group">
                <label v-bind:for="itm['name']">{{itm['lable']}}</label>
                <select
                  name="agent_type"
                  class="form-control"
                  @change="autofillFields(inputs[itm['name']])"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                >
                  <option value></option>
                  <option
                    v-for="opt in itm['items']"
                    v-bind:key="opt.id"
                    v-bind:value="opt"
                  >{{opt.name}}</option>
                  <label class="custom-control-label" v-bind:for="itm['name']"></label>
                </select>
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                >{{ errors[itm['name']][0]}}</span>
              </div>
              <div v-else-if="itm['name'] === 'language_id'" class="form-group">
                <label v-bind:for="itm['name']">
                  {{itm['lable']}}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-'+app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <select
                  name="agent_type"
                  class="form-control"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                >
                  <option
                    v-for="(opt, optKy) in itm['items']"
                    v-bind:key="opt"
                    v-bind:value="opt"
                  >{{optKy}}</option>
                  <label class="custom-control-label" v-bind:for="itm['name']"></label>
                </select>
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                >{{ errors[itm['name']][0]}}</span>
              </div>
              <div v-else-if="itm['name'] === 'funding_source_state_training_authority'" class="form-group">
                <label v-bind:for="itm['name']">
                  {{itm['lable']}}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-'+app_color"
                    title="Avetmiss required if reported to state!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <select
                  name="agent_type"
                  class="form-control"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                >
                  <option :value="itm['name'] === 'class' ? 0 : ''"></option>
                  <option
                    v-for="(opt, optKy) in itm['items']"
                    v-bind:key="optKy"
                    v-bind:value="optKy"
                  >{{opt}}</option>
                  <label class="custom-control-label" v-bind:for="itm['name']"></label>
                </select>
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                >{{ errors[itm['name']][0]}}</span>
              </div>
              <div v-else class="form-group">
                <label v-bind:for="itm['name']">
                  {{itm['lable']}}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-'+app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <select
                  name="agent_type"
                  class="form-control"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                >
                  <option :value="itm['name'] === 'class' ? 0 : ''"></option>
                  <option
                    v-for="(opt, optKy) in itm['items']"
                    v-bind:key="optKy"
                    v-bind:value="optKy"
                  >{{opt}}</option>
                  <label class="custom-control-label" v-bind:for="itm['name']"></label>
                </select>
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                >{{ errors[itm['name']][0]}}</span>
              </div>
            </div>
            <div v-else-if="itm['type'] === 'checkbox'">
              <!-- checkbox -->
              <div class="form-group">
                <label v-bind:for="itm['name']">{{itm['lable']}}</label>
                <div class="custom-control custom-switch my-2">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    v-bind:id="itm['name']"
                    v-model="inputs[itm['name']]"
                  />
                  <label class="custom-control-label" v-bind:for="itm['name']"></label>
                </div>
              </div>
            </div>
            <div v-else-if="itm['type'] === 'radio'">
              <!-- radiobox -->
            </div>
            <div v-else-if="itm['type'] === 'email'">
              <!-- emailbox -->
              <div class="form-group">
                <label for="company_name">{{itm['lable']}}</label>
                <input
                  class="form-control"
                  v-bind:name="itm['name']"
                  type="email"
                  v-bind:id="itm['name']"
                  v-model="inputs[itm['name']]"
                />
              </div>
            </div>
            <div v-else-if="itm['type'] === 'password'">
              <!-- passwordbox -->
              <div class="form-group">
                <label for="company_name">{{itm['lable']}}</label>
                <input
                  class="form-control"
                  v-bind:name="itm['name']"
                  type="password"
                  v-bind:id="itm['name']"
                  v-model="inputs[itm['name']]"
                />
              </div>
            </div>
            <div v-else-if="itm['type'] === 'textbox'">
              <!-- textbox -->
              <div class="form-group">
                <label v-bind:for="itm['name']">{{itm['lable']}}</label>
                <textarea
                  class="form-control"
                  v-bind:name="itm['name']"
                  v-bind:id="itm['name']"
                  v-model="inputs[itm['name']]"
                ></textarea>
              </div>
            </div>
            <div v-else-if="itm['type'] === 'multiselect'">
              <!-- multiselect -->
              <div class="form-group">
                <label v-bind:for="itm['name']">
                  {{itm['lable']}}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-'+app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <multiselect
                  v-model="inputs[itm['name']]"
                  :options="itm['selections']"
                  :multiple="true"
                  placeholder="Type to search"
                  :close-on-select="false"
                  track-by="id"
                  label="value"
                >
                  <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                </multiselect>
              </div>
            </div>
            <div v-else-if="itm['type'] === 'singleselect'">
              <!-- multiselect -->
              <div class="form-group">
                <label v-bind:for="itm['name']">
                  {{itm['lable']}}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-'+app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <multiselect
                  v-model="inputs[itm['name']]"
                  :options="itm['selections']"
                  :multiple="false"
                  :disabled="itm['disabled']"
                  placeholder="Type to search"
                  :close-on-select="true"
                  track-by="id"
                  label="value"
                >
                  <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                </multiselect>
              </div>
            </div>
            <div v-if="itm['type'] === 'datepicker'">
              <div class="form-group">
                <label>
                  {{itm['lable']}}
                  <span style="font-size: 74%;opacity: 73%;">( DD/MM/YYYY )</span>
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-'+app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <date-picker
                  v-if="inputs[itm['name']] === inputs.end_date"
                  locale="en"
                  :masks="{L:'DD/MM/YYYY'}"
                  v-bind:value="inputs[itm['value']]"
                  v-model="inputs[itm['name']]"
                  v-bind:name="itm['name']"
                  v-bind:id="itm['name']"
                  :min-date="inputs.start_date != '' || inputs.start_date != null ? inputs.start_date : ''"
                  :disabled-dates="getDisabledDate"
                ></date-picker>
                <date-picker
                  v-else-if="inputs[itm['name']] === inputs.start_date"
                  locale="en"
                  :masks="{L:'DD/MM/YYYY'}"
                  v-bind:value="inputs[itm['value']]"
                  v-model="inputs[itm['name']]"
                  v-bind:name="itm['name']"
                  v-bind:id="itm['name']"
                  :disabled-dates="getDisabledDate"
                ></date-picker>
                <date-picker
                  v-else
                  locale="en"
                  :masks="{L:'DD/MM/YYYY'}"
                  v-bind:value="inputs[itm['value']]"
                  v-model="inputs[itm['name']]"
                  v-bind:name="itm['name']"
                  v-bind:id="itm['name']"
                ></date-picker>

                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                >{{ errors[itm['name']][0]}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</template>


<script>
import FormTitle from "./FormTitleComponent.vue";
import moment from "moment";
export default {
  name : 'dynamic_form',
  components: {
    FormTitle,
  },
  props: {
    formSettings: Array,
    formValues: Object,
    saveForm: String,
  },
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  },
  data() {
    return {
      inputs: this.formValues,
      app_color: app_color,
      csrfToken: "",
      rowCount: 1,
      roles : null,
      errors: [],
    };
  },
  created() {
    this.fetchData();
    if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
    // console.log(this.isDisabledDate);
    // console.log(this.inputs);
    // console.log(this.formValues);
    // this.inputs = this.formValues;
  },
  mounted(){
    if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  methods: {
    toType(obj) {
        return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
    },
    getDisabledDate(date) {
      let vm = this;
      const today = new Date();
      let x = false;
      vm.formSettings.forEach((element) => {
        if (element.FormTitle == "Course Details") {
          element.FormBody.map((e, key) => {
            // console.log(e.name);
            if (e.name == "start_date" || e.name == "end_date") {
              if (e.disabled == "disabled") {
                today.setHours(0, 0, 0, 0);
                // // with today plus 7 days
                // // console.log(moment(date.id)._d < today || moment(date.id)._d > new Date(today.getTime() + 7 * 24 * 3600 * 1000));
                x =
                  moment(date.id)._d <= today ||
                  moment(date.id)._d > new Date(today.getTime());
              }
            }
          });
        }
      });
      // console.log(x);
      return x;
    },
    getAuth() {
      let apiUser = "admin";
      let apiPass = "nimda321";
      let basicAuth;
      basicAuth = "Basic " + btoa(apiUser + ":" + apiPass);
      return basicAuth;
    },
    verifyUsiData() {
      let vm = this;
      console.log(vm.$parent.$refs);

      let studentInfo = vm.$parent.$parent;
      let avetmiss_info = vm.formValues;
      console.log(studentInfo.student_info);
      console.log()
      let apiBaseUrl = "https://usiapi.vorx.com.au:8443/api/";
      let usiForm = {
        usi: "",
        dateOfBirth: "",
        orgCode: window.app_settings.training_organisation_id,
      };
      // console.log(avetmiss_info);

      if (avetmiss_info.unique_student_id == "") {
        swal.fire({
          title: "Opss.. Unique Student ID must not be empty",
          type: "error",
          timer: 3000,
          showConfirmButton: false,
        });
      } else {
        usiForm.usi = avetmiss_info.unique_student_id;
        if(studentInfo.student_info == undefined){
           if (studentInfo.student.lastname == null) {
              usiForm.singleName = studentInfo.student.firstname;
            } else {
              usiForm.firstName = studentInfo.student.firstname;
              usiForm.familyName = studentInfo.student.lastname;
            }
            usiForm.dateOfBirth = moment(
              studentInfo.student.date_of_birth
            ).format("YYYY-MM-DD");
        }else{
          if (studentInfo.student_info.lastname == null) {
            usiForm.singleName = studentInfo.student_info.firstname;
          } else {
            usiForm.firstName = studentInfo.student_info.firstname;
            usiForm.familyName = studentInfo.student_info.lastname;
          }
          usiForm.dateOfBirth = moment(
            studentInfo.student_info.date_of_birth
          ).format("YYYY-MM-DD");

        }

        let toast = swal.fire({
          position: "top-end",
          title: "Please wait",
          showConfirmButton: false,
          timer: 30000,
        });

        axios
          .post(`${apiBaseUrl}verify`, usiForm, {
            baseURL: window.location.host,
            headers: {
              Authorization: vm.getAuth(),
            },
          })
          .then((response) => {
            toast.dismiss === swal.DismissReason.timer;
            if (response.data.hasOwnProperty("errorInfo")) {
              console.log(response.data.errorInfo);
              let em = response.data.errorInfo;
              let rmessage = "";
              em.forEach((element) => {
                rmessage += "<li>" + element.message + "</li>";
              });

              swal.fire({
                type: "error",
                title: "Oops...",
                html: `<ul>${rmessage}</ul>`,
              });
            } else if (response.data.hasOwnProperty("code")) {
              let em = response.data.message;
              swal.fire({
                type: "error",
                title: "Oops...",
                html: em,
                footer: "<a href>Why do I have this issue?</a>",
              });
            } else {
              if (
                (response.data.firstName == "MATCH" &&
                  response.data.familyName == "MATCH" &&
                  response.data.dateOfBirth == "MATCH" &&
                  response.data.usistatus == "Valid") ||
                (response.data.singleName == "MATCH" &&
                  response.data.dateOfBirth == "MATCH" &&
                  response.data.usistatus == "Valid")
              ) {
                let sid = studentInfo.student_info == undefined ? studentInfo.student.student_id : studentInfo.student_id
                axios
                  .get(
                    `/usi/verify/success/${sid}/${usiForm.usi}`
                  )
                  .then((response) => {
                    vm.inputs["verified"] = 1;
                    // console.log(response);
                  })
                  .catch((err) => {
                    // console.log(err);
                  });
              }
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
                confirmButtonAriaLabel: "Thumbs up, great!",
              });
            }
            // console.log(response)
          })
          .catch((err) => {
            // if (usiForm.dateOfBirth != "") {
            //   usiForm.dateOfBirth = moment(vm.usiForm.dateOfBirth)._d;
            // }
            swal.fire({
              type: "error",
              title: "Oops...",
              html: `<ul>${err.response.data.message}</ul>`,
            });
          });
      }
    },

    fetchData() {
      // console.log(this.formSettings[0].FormBody[0]);
      // console.log(this.inputs);
      // // console.log(course_id);
      // axios({
      //     method: 'get',
      //     url: '/agent/show/info/'+ this.agent_id
      // })
      // .then(res => {
      //     this.agent = res.data;
      // })
      // .catch(err => console.log(err));
    },
    autofillFields(data) {
      let vm = this;
      let inputs = this.inputs;
      inputs.purchasing_contract_id = data.purchasing_contract;
      inputs.purchasing_contract_schedule_id = data.purchasing_schedule;
      inputs.specific_funding_id = data.specific_funding_code;
      inputs.funding_source_national = data.national_funding_code;
      inputs.funding_source_state_training_authority = data.state_funding_code;
      inputs.training_contract_id = data.training_contract;

      if (data.traineeship_apprenticeship == 1) {
        vm.$emit("getData", data.traineeship_apprenticeship);
      }
    },
    saveChanges() {
      let inputs = this.inputs;
      // console.log(inputs);
      // unformatted date value
      let _dob = null;
      let _sd = null;
      let _ed = null;
      let _id = null;
      let _exd = null;
      let _exd_vt = null;
      let _aiss = null;

      if (inputs.date_of_birth != null) {
        _dob = inputs.date_of_birth; // unformatted value
        inputs.date_of_birth = moment(inputs.date_of_birth).format(
          "YYYY-MM-DD"
        );
      } else {
        inputs.date_of_birth = null;
      }
      if (inputs.start_date != null) {
        _sd = inputs.start_date; // unformatted value
        inputs.start_date = moment(inputs.start_date).format("YYYY-MM-DD");
      } else {
        inputs.start_date = null;
      }
      if (inputs.end_date != null) {
        _ed = inputs.end_date; // unformatted value
        inputs.end_date = moment(inputs.end_date).format("YYYY-MM-DD");
      } else {
        inputs.end_date = null;
      }

      if (inputs.issue_date != null) {
        _id = inputs.issue_date; // unformatted value
        inputs.issue_date = moment(inputs.issue_date).format("YYYY-MM-DD");
      } else {
        inputs.issue_date = null;
      }
      if (inputs.expiry_date != null) {
        _exd = inputs.expiry_date; // unformatted value
        inputs.expiry_date = moment(inputs.expiry_date).format("YYYY-MM-DD");
      } else {
        inputs.expiry_date = null;
      }
      if (inputs.expiry_date_visa_type != null) {
        _exd_vt = inputs.expiry_date_visa_type; // unformatted value
        inputs.expiry_date_visa_type = moment(
          inputs.expiry_date_visa_type
        ).format("YYYY-MM-DD");
      } else {
        inputs.expiry_date_visa_type = null;
      }

      //AISS DATE
      if (inputs.aiss_date != null) {
        _aiss = inputs.aiss_date; // unformatted value
        inputs.aiss_date = moment(inputs.aiss_date).format("YYYY-MM-DD");
      } else {
        inputs.aiss_date = null;
      }

      // console.log(inputs);

      // Range mode start/end Date (Course details- Domestic)
      if (inputs.courseSubjects != null) {
        inputs.courseSubjects.forEach((element) => {
          // console.log("hello");
          let _dates = null;
          // if (element.dates != null) {
          //   if (element.dates != "") {
          //     // console.log("sulod");
          //     _dates = {
          //       start: moment(element.dates.start).format("YYYY-MM-DD"),
          //       end: moment(element.dates.end).format("YYYY-MM-DD")
          //     };
          //   }
          // }
          if (element.dates != null) {
            if (element.dates != "") {
              // console.log("sulod");
              _dates = {
                start:
                  element.dates.start != null
                    ? moment(element.dates.start).format("YYYY-MM-DD")
                    : null,
                end:
                  element.dates.end != null
                    ? moment(element.dates.end).format("YYYY-MM-DD")
                    : null,
              };
            }
          }

          element.dates = _dates;
        });
      }
      // Range mode start/end Date (Extra Units - Domestic)
      if (inputs.courseExtraUnits != null) {
        inputs.courseExtraUnits.forEach((element) => {
          // console.log("hello");
          let _dates = null;
          if (element.dates != null) {
            if (element.dates != "") {
              // console.log("sulod");
              _dates = {
                start: moment(element.dates.start).format("YYYY-MM-DD"),
                end: moment(element.dates.end).format("YYYY-MM-DD"),
              };
            }
          }
          element.dates = _dates;
        });
      }
      //  console.log(inputs.courseSubjects);

      // alert(this.csrfToken);

      // console.log(this.inputs);

      // loading
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });

      axios
        .post(this.saveForm, {
          inputs: inputs,
          _token: this.csrfToken,
        })
        .then((res) => {
          this.$emit("getResponseData", res.data);
          if (res.data.status == "updated") {
            // UPDATE ONLY DATA
            swal.fire({
              title: "Changes saved successfully",
              type: "success",
              timer: 3000,
              showConfirmButton: false,
            });

            if (inputs.date_of_birth != null) {
              inputs.date_of_birth = moment(inputs.date_of_birth)._d;
            } else {
              inputs.date_of_birth = null;
            }
            if (inputs.start_date != null) {
              inputs.start_date = moment(inputs.start_date)._d;
            } else {
              inputs.start_date = null;
            }
            if (inputs.end_date != null) {
              inputs.end_date = moment(inputs.end_date)._d;
            } else {
              inputs.end_date = null;
            }
            // AISS DATE
            if (inputs.aiss_date != null) {
              inputs.aiss_date = moment(inputs.aiss_date)._d;
            } else {
              inputs.aiss_date = null;
            }
            // Range mode start/end Date (Course details- Domestic)
            if (inputs.courseSubjects != null) {
              inputs.courseSubjects.forEach((element) => {
                // console.log("hello");
                let _dates = null;
                if (element.dates != null) {
                  if (element.dates != "") {
                    // console.log("sulod");
                    _dates = {
                      start: moment(element.dates.start)._d,
                      end: moment(element.dates.end)._d,
                    };
                  }
                }

                element.dates = _dates;
              });
            }
            // Range mode start/end Date (Extra Units - Domestic)
            if (inputs.courseExtraUnits != null) {
              inputs.courseExtraUnits.forEach((element) => {
                // console.log("hello");
                let _dates = null;
                if (element.dates != null) {
                  if (element.dates != "") {
                    // console.log("sulod");
                    _dates = {
                      start: moment(element.dates.start)._d,
                      end: moment(element.dates.end)._d,
                    };
                  }
                }
                element.dates = _dates;
              });
            }
            // dates in Visa Details - DOMESTIC
            if (inputs.issue_date != null) {
              inputs.issue_date = moment(inputs.issue_date)._d;
            } else {
              inputs.issue_date = null;
            }
            if (inputs.expiry_date != null) {
              inputs.expiry_date = moment(inputs.expiry_date)._d;
            } else {
              inputs.expiry_date = null;
            }
            if (inputs.expiry_date_visa_type != null) {
              inputs.expiry_date_visa_type = moment(
                inputs.expiry_date_visa_type
              )._d;
            } else {
              inputs.expiry_date_visa_type = null;
            }

            this.errors = [];
            // this.$parent.$parent.updateDoms();
            // this.$parent.$parent.updateDoms();
            this.$parent.$parent.$parent.updateDom = !this.$parent.$parent.$parent.updateDom;
            this.$parent.$emit("courseUpdate", "updated");
            this.$emit("updateCourse", "updated");
            this.agent = res.data.agent;
          } else if (res.data.status == "success") {
            // ADD NEW DATA
            this.inputs = [];
            this.$parent.subjectList = [];
            this.$parent.extraUnitList = [];
            this.$parent.getValues.courseSubjects = [];
            this.$parent.getValues.courseExtraUnits = [];
            this.$parent.modifyAll = "";
            this.$parent.modifyAllMode = "";
            this.$parent.modifyAllDates = [];

            swal.fire({
              title: "Data saved successfully",
              type: "success",
              timer: 3000,
              showConfirmButton: false,
            });
            this.errors = [];
            this.$emit("updateCourse", "updated");
            this.agent = res.data.agent;
          } else if (res.data.status == "errors") {
            // dates
            if (inputs.date_of_birth != null) {
              inputs.date_of_birth = moment(_dob)._d;
              if (inputs.date_of_birth != "") {
                inputs.date_of_birth = moment(_dob)._d;
              }
            } else {
              inputs.date_of_birth = null;
            }

            if (inputs.start_date != null) {
              inputs.start_date = moment(_sd)._d;
              if (inputs.start_date != "") {
                inputs.start_date = moment(_sd)._d;
              }
            } else {
              inputs.start_date = null;
            }

            if (inputs.end_date != null) {
              inputs.end_date = moment(_ed)._d;
              if (inputs.end_date != "") {
                inputs.end_date = moment(_ed)._d;
              }
            } else {
              inputs.end_date = null;
            }
            // AISS DATE
            if (inputs.aiss_date != null) {
              inputs.aiss_date = moment(_aiss)._d;
              if (inputs.aiss_date != "") {
                inputs.aiss_date = moment(_aiss)._d;
              }
            } else {
              inputs.aiss_date = null;
            }
            // Range mode start/end Date (Course details- Domestic)
            if (inputs.courseSubjects != null) {
              inputs.courseSubjects.forEach((element) => {
                // console.log("hello");
                let _dates = null;
                if (element.dates != null) {
                  if (element.dates != "") {
                    // console.log("sulod");
                    _dates = {
                      start: moment(element.dates.start)._d,
                      end: moment(element.dates.end)._d,
                    };
                  }
                }

                element.dates = _dates;
              });
            }
            // Range mode start/end Date (Extra Units - Domestic)
            if (inputs.courseExtraUnits != null) {
              inputs.courseExtraUnits.forEach((element) => {
                // console.log("hello");
                let _dates = null;
                if (element.dates != null) {
                  if (element.dates != "") {
                    // console.log("sulod");
                    _dates = {
                      start: moment(element.dates.start)._d,
                      end: moment(element.dates.end)._d,
                    };
                  }
                }
                element.dates = _dates;
              });
            }
            // dates in Visa Details - DOMESTIC
            if (inputs.issue_date != null) {
              inputs.issue_date = moment(inputs.issue_date)._d;
            } else {
              inputs.issue_date = null;
            }
            if (inputs.expiry_date != null) {
              inputs.expiry_date = moment(inputs.expiry_date)._d;
            } else {
              inputs.expiry_date = null;
            }
            if (inputs.expiry_date_visa_type != null) {
              inputs.expiry_date_visa_type = moment(
                inputs.expiry_date_visa_type
              )._d;
            } else {
              inputs.expiry_date_visa_type = null;
            }

            this.errors = res.data.errors;
            swal.fire({
              title: "Opss.. was not saved successfully",
              type: "error",
              timer: 3000,
              showConfirmButton: false,
            });

            if (inputs.course_code == "@@@@") {
              if (this.errors.courseExtraUnits.length == 1) {
                swal.fire({
                  title: "Opss...",
                  text:
                    "Fill-in all required fields and kindly add Extra Units.",
                  type: "error",
                  timer: 10000,
                  showConfirmButton: true,
                });
              }
            } else {
              if (this.errors.courseSubjects.length == 1) {
                swal.fire({
                  title: "Opss...",
                  text:
                    "Fill-in all required fields. And kindly select course and location in Course Details section accordingly.",
                  type: "error",
                  timer: 10000,
                  showConfirmButton: true,
                });
              }
            }
          } else {
            this.errors = [];

            // dates
            if (inputs.date_of_birth != null) {
              inputs.date_of_birth = moment(_dob)._d;
              if (inputs.date_of_birth != "") {
                inputs.date_of_birth = moment(_dob)._d;
              }
            } else {
              inputs.date_of_birth = null;
            }

            if (inputs.start_date != null) {
              inputs.start_date = moment(_sd)._d;
              if (inputs.start_date != "") {
                inputs.start_date = moment(_sd)._d;
              }
            } else {
              inputs.start_date = null;
            }

            if (inputs.end_date != null) {
              inputs.end_date = moment(_ed)._d;
              if (inputs.end_date != "") {
                inputs.end_date = moment(_ed)._d;
              }
            } else {
              inputs.end_date = null;
            }
            // AISS DATE
            if (inputs.aiss_date != null) {
              inputs.aiss_date = moment(_aiss)._d;
              if (inputs.aiss_date != "") {
                inputs.aiss_date = moment(_aiss)._d;
              }
            } else {
              inputs.aiss_date = null;
            }
            // Range mode start/end Date (Course details- Domestic)
            if (inputs.courseSubjects != null) {
              inputs.courseSubjects.forEach((element) => {
                // console.log("hello");
                let _dates = null;
                if (element.dates != null) {
                  if (element.dates != "") {
                    // console.log("sulod");
                    _dates = {
                      start: moment(element.dates.start)._d,
                      end: moment(element.dates.end)._d,
                    };
                  }
                }

                element.dates = _dates;
              });
            }
            // Range mode start/end Date (Extra Units - Domestic)
            if (inputs.courseExtraUnits != null) {
              inputs.courseExtraUnits.forEach((element) => {
                // console.log("hello");
                let _dates = null;
                if (element.dates != null) {
                  if (element.dates != "") {
                    // console.log("sulod");
                    _dates = {
                      start: moment(element.dates.start)._d,
                      end: moment(element.dates.end)._d,
                    };
                  }
                }
                element.dates = _dates;
              });
            }
            // dates in Visa Details - DOMESTIC
            if (inputs.issue_date != null) {
              inputs.issue_date = moment(inputs.issue_date)._d;
            } else {
              inputs.issue_date = null;
            }
            if (inputs.expiry_date != null) {
              inputs.expiry_date = moment(inputs.expiry_date)._d;
            } else {
              inputs.expiry_date = null;
            }
            if (inputs.expiry_date_visa_type != null) {
              inputs.expiry_date_visa_type = moment(
                inputs.expiry_date_visa_type
              )._d;
            } else {
              inputs.expiry_date_visa_type = null;
            }

            this.errors = res.data.errors;
            swal.fire({
              title: "Opss.. was not saved successfully",
              type: "error",
              timer: 3000,
              showConfirmButton: false,
            });
          }
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>

<style>
.tab-pane {
  border: 1px solid #e0dfdf;
  border-top: none;
  padding: 1.3rem;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
  background-color: #ffffff;
}
</style>