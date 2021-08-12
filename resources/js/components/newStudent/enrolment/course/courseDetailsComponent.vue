<template>
  <div>
    <div class="btn-group float-right" v-if="this.course != null">
      <button
        type="button"
        class="btn btn-success dropdown-toggle dropdown-toggle-split"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
        v-if="demoUser == false"
      >
        View
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" @click="generate_invoice()" target="_blank">
          <i class="far fa-file-pdf text-danger"></i>&nbsp; Generate Invoice
        </a>
        <a
          class="dropdown-item"
          v-if="courseFeeType == 'FF'"
          @click="generate_payment_plan()"
          target="_blank"
        >
          <i class="far fa-file-pdf text-danger"></i>&nbsp; Payment Plan
        </a>
        <a
          class="dropdown-item"
          @click="generate_training_plan()"
          target="_blank"
        >
          <i class="far fa-file-pdf text-danger"></i>&nbsp; Training Plan
        </a>
      </div>
    </div>
    <dynamic-form
      v-on="$listeners"
      v-bind:form-settings='makeForm'
      v-bind:form-values='getValues' 
      @fundingType="fundingtype($event)"
      v-bind:save-form='store_url'
    ></dynamic-form>
    <br />
    <div class="subjects-wrapper" v-if="!isHidden">
      <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' my-3'">
        <h6>
          Subject List
          <span class="badge">
            (
            <i
              >Must not be empty. Kindly select course and location in Course
              Details section accordingly.</i
            >
            )
          </span>
        </h6>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <table class="autofill">
              <tbody>
                <tr>
                  <td colspan="3" class="text-right">
                    <span
                      style="
                        margin-top: 30px;
                        margin-right: 10px;
                        display: block;
                      "
                    >
                      <b>Auto-fill Inputs:</b>
                    </span>
                  </td>
                  <td width="15%">
                    <label for style="margin: 0">Start Date:</label>
                    <date-picker
                      :popover="{ placement: 'bottom', visibility: 'click' }"
                      v-model="modifyAllDatesStart"
                      mode="single"
                      locale="en"
                      :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                    ></date-picker>
                  </td>
                  <td width="15%">
                    <label for style="margin: 0">End Date:</label>
                    <date-picker
                      v-if="
                        this.modifyAllDatesStart == [] ||
                        this.modifyAllDatesStart == ''
                      "
                      :popover="{ placement: 'bottom', visibility: 'click' }"
                      v-model="modifyAllDatesEnd"
                      mode="single"
                      locale="en"
                      :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                      :min-date="this.modifyAllDatesStart == null ? '' : ''"
                    ></date-picker>
                    <date-picker
                      v-else
                      :popover="{ placement: 'bottom', visibility: 'click' }"
                      v-model="modifyAllDatesEnd"
                      mode="single"
                      locale="en"
                      :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                      :min-date="
                        this.modifyAllDatesStart == null
                          ? ''
                          : this.modifyAllDatesStart
                      "
                    ></date-picker>
                  </td>
                  <td width="16%">
                    <label for style="margin: 0">Delivery Location:</label>
                    <select
                      v-model="modifyAll"
                      @change="modifyDlvrLoc"
                      class="form-control"
                    >
                      <option value selected></option>
                      <option
                        v-for="(opt, optKy) in slct_training_dlvr_loc"
                        v-bind:key="optKy"
                        v-bind:value="opt"
                      >
                        {{ optKy }}
                      </option>
                    </select>
                  </td>
                  <td width="16%">
                    <label for style="margin: 0">Delivery Mode:</label>
                    <select
                      v-model="modifyAllMode"
                      @change="modifyDlvrMode"
                      class="form-control"
                    >
                      <option value selected></option>
                      <option
                        v-for="(opt, optKy) in slct_dlvr_mode"
                        v-bind:key="optKy"
                        v-bind:value="optKy"
                      >
                        {{ opt }}
                      </option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 no-padding">
        <table :class="'table header-' + app_color" id="dataTable" width="100%">
          <thead>
            <tr>
              <th
                :class="'table-header-' + app_color"
                style="width: 5% !important"
              >
                #
              </th>
              <th :class="'table-header-' + app_color">Code</th>
              <th :class="'table-header-' + app_color">Description</th>
              <!-- <th :class="'table-header-'+app_color" style="width:7%!important">Subject Type</th> -->
              <th :class="'table-header-' + app_color">Start</th>
              <th :class="'table-header-' + app_color">End Date</th>
              <th :class="'table-header-' + app_color">
                Training Delivery Location
              </th>
              <th :class="'table-header-' + app_color">Delivery Mode</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(subject, index) in subjectList"
              :key="index"
              style="font-size: 12px"
            >
              <td>{{ index + 1 }}</td>
              <td width="10%">{{ subject.subject_code }}</td>
              <td width="20%">{{ subject.description }}</td>
              <!-- <td>{{ subject.unit_type | capitalize}}</td> -->
              <td width="15%">
                <!-- <date-picker
                  style="font-size:12px"
                  :popover="{ placement: 'bottom', visibility: 'click' }"
                  v-model="subject.dates"
                  mode="range"
                  locale="en"
                  :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
                ></date-picker>-->
                <date-picker
                  style="font-size: 12px"
                  :popover="{ placement: 'bottom', visibility: 'click' }"
                  v-model="subject.dates.start"
                  mode="single"
                  locale="en"
                  :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                ></date-picker>
              </td>
              <td width="15%">
                <!-- <date-picker
                  style="font-size:12px"
                  :popover="{ placement: 'bottom', visibility: 'click' }"
                  v-model="subject.dates"
                  mode="range"
                  locale="en"
                  :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
                ></date-picker>-->
                <date-picker
                  style="font-size: 12px"
                  :popover="{ placement: 'bottom', visibility: 'click' }"
                  v-model="subject.dates.end"
                  mode="single"
                  locale="en"
                  :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                  :min-date="
                    subject.dates.start !== null || subject.dates.start !== ''
                      ? subject.dates.start
                      : ''
                  "
                ></date-picker>
              </td>
              <td width="15%">
                <div class="form-group">
                  <select
                    class="form-control"
                    style="font-size: 12px"
                    v-model="subject.train_org_loc_id"
                  >
                    <option value></option>
                    <option
                      v-for="(opt, optKy) in slct_training_dlvr_loc"
                      v-bind:key="optKy"
                      v-bind:value="opt"
                    >
                      {{ optKy }}
                    </option>
                  </select>
                </div>
              </td>
              <td width="15%">
                <div class="form-group">
                  <select
                    class="form-control"
                    style="font-size: 12px"
                    v-model="subject.delivery_mode_id"
                  >
                    <option value></option>
                    <option
                      v-for="(opt, optKy) in slct_dlvr_mode"
                      v-bind:key="optKy"
                      v-bind:value="optKy"
                    >
                      {{ opt }}
                    </option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="7" class="text-center" v-if="subjectList != null">
                {{ subjectList.length }} Subjects found
              </td>
            </tr>
            <tr>
              <td colspan="7" class="text-center" v-if="subjectList == null">
                No Subject found
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <br />
    <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' my-3'">
      <h6>Unit of Competency</h6>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right">
      <div class="row">
        <div class="col-lg-12">
          <div class="form-group">
            <label for="uc_description">Description</label>
            <input
              id="uc_description"
              name="uc_description"
              value
              autofocus="autofocus"
              class="form-control"
              type="text"
              v-model="getValues.uc_description"
            />
            <!-- <span v-if="errors.uc_description" :class="['badge badge-danger']">{{ errors.uc_description[0] }}</span> -->
          </div>
        </div>
        <div class="col-md-12 no-padding">
          <table
            :class="'table header-' + app_color"
            id="dataTable"
            width="100%"
          >
            <thead>
              <tr>
                <th
                  :class="'table-header-' + app_color"
                  style="width: 5% !important"
                >
                  #
                </th>
                <th :class="'table-header-' + app_color">Code</th>
                <th :class="'table-header-' + app_color">Description</th>
                <!-- <th :class="'table-header-'+app_color" style="width:7%!important">Subject Type</th> -->
                <th :class="'table-header-' + app_color">Start</th>
                <th :class="'table-header-' + app_color">End Date</th>
                <th :class="'table-header-' + app_color">
                  Training Delivery Location
                </th>
                <th :class="'table-header-' + app_color">Delivery Mode</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(eu, index) in getValues.courseExtraUnits"
                :key="index"
                style="font-size: 12px"
              >
                <td width="5%">{{ index + 1 }}</td>
                <td width="10%">{{ eu.subject_code }}</td>
                <td width="20%">{{ eu.description }}</td>
                <!-- <td width="10%">{{ eu.unit_type | capitalize}}</td> -->
                <td width="15%">
                  <!-- <date-picker
                    style="font-size:12px"
                    :popover="{ placement: 'bottom', visibility: 'click' }"
                    v-model="eu.dates"
                    mode="range"
                    locale="en"
                    :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
                  ></date-picker>-->
                  <date-picker
                    style="font-size: 12px"
                    :popover="{ placement: 'bottom', visibility: 'click' }"
                    v-model="eu.dates.start"
                    mode="single"
                    locale="en"
                    :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                  ></date-picker>
                </td>
                <td width="15%">
                  <!-- <date-picker
                    style="font-size:12px"
                    :popover="{ placement: 'bottom', visibility: 'click' }"
                    v-model="eu.dates"
                    mode="range"
                    locale="en"
                    :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
                  ></date-picker>-->
                  <date-picker
                    style="font-size: 12px"
                    :popover="{ placement: 'bottom', visibility: 'click' }"
                    v-model="eu.dates.end"
                    mode="single"
                    locale="en"
                    :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                    :min-date="
                      eu.dates.start !== null || eu.dates.start !== ''
                        ? eu.dates.start
                        : ''
                    "
                  ></date-picker>
                </td>
                <td width="15%">
                  <div class="form-group">
                    <select
                      class="form-control"
                      style="font-size: 12px"
                      v-model="eu.train_org_loc_id"
                    >
                      <option value></option>
                      <option
                        v-for="(opt, optKy) in slct_training_dlvr_loc"
                        v-bind:key="optKy"
                        v-bind:value="opt"
                      >
                        {{ optKy }}
                      </option>
                    </select>
                  </div>
                </td>
                <td width="15%">
                  <div class="form-group">
                    <select
                      class="form-control"
                      style="font-size: 12px"
                      v-model="eu.delivery_mode_id"
                    >
                      <option value></option>
                      <option
                        v-for="(opt, optKy) in slct_dlvr_mode"
                        v-bind:key="optKy"
                        v-bind:value="optKy"
                      >
                        {{ opt }}
                      </option>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <td>#</td>
                <td colspan="5">
                  <div class="form-group formunits">
                    <!-- <label for="units">Select Units:</label> -->
                    <multiselect
                      v-model="getValues.courseExtraUnits"
                      :options="server_slct_unit_opt"
                      :multiple="true"
                      :group-select="false"
                      placeholder="Type to search"
                      :close-on-select="false"
                      :custom-label="codeDescription"
                      track-by="subject_code"
                      label="description"
                      :options-limit="300"
                      :limit-text="limitText"
                      :loading="isLoading"
                      @search-change="asyncFind"
                      :class="
                        'multiselect-color-' +
                        app_color[
                          (errors && errors.course_units ? 'border-danger' : '',
                          { unitsclass: true })
                        ]
                      "
                    >
                      <span slot="noResult"
                        >Oops! No units found. Consider changing the search
                        query.</span
                      >
                      <!-- group-values="unit-details" 
                            group-label="unit-type"  
                      :limit="3"-->
                    </multiselect>
                    <div
                      v-if="errors && errors.course_units"
                      class="badge badge-danger"
                    >
                      {{ errors.course_units[0] }}
                    </div>
                  </div>
                </td>
                <!-- <td width="20%">
                  <date-picker
                    style="font-size:12px"
                    :popover="{ placement: 'bottom', visibility: 'click' }"
                    mode="range"
                    locale="en"
                    :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
                  ></date-picker>
                </td>-->
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dynamicForm from "../../../../components/globals/form/new/DynamicFormComponent.vue";
import moment from "moment";
import { mapGetters, mapMutations } from "vuex";
export default {
  components: {
    dynamicForm,
  },
  props: ['funded_course', "course", "subjects", "extraUnits", "extraUnitsval","process_id"],
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  },
    // computed : {
    //         course_details(){
    //           return this.course;
    //         }
    //     },
  data() {
    return {
      demoUser: window.demoUser,
      app_color: app_color,
      student_id: window.student_id,
      subjectList: this.subjects,
      // SELECT OPTIONS
      slct_training_dlvr_loc: window.slct_training_dlvr_loc,
      slct_dlvr_mode: window.slct_dlvr_mode,
      extraUnitList: this.extraUnits,
      slct_units: window.slct_units,
      slct_units_val: this.extraUnitsval,
      timetable: [],

      train_org_dlvr_loc_id: "",
      csrfToken: "",
      class_details: {},
      store_url: `/student/domestic/${window.student}/course-update`,
      getValues: this.course || {
        eligibility: "",
        course_code: "",
        location: "",
        start_date: null,
        end_date: null,
        course_fee_type: "",
        course_fee: "",
        status_id: "1",
        aiss_date: "",
        class: "0",
        remarks: "",
        courseSubjects: [],
        courseExtraUnits: [],
        outcome_id_national: "",
        funding_source_national: "",
        commence_prg_identifier: "",
        training_contract_id: "",
        client_id_apprenticeships: "",
        study_reason_id: "",
        specific_funding_id: "",
        funding_source_state_training_authority: "",
        purchasing_contract_id: "",
        purchasing_contract_schedule_id: "",
        associated_course_id: "",
        predominant_delivery_mode: "",
        full_time_leaning_option: "",
        uc_description: "",
        funding_type: "",
        process_id: typeof this.process_id === 'undefined' || this.process_id === 0 ? null : this.process_id,
      },
      makeForm: [
        {
          FormTitle: "Course Details",
          FormBody: [
            {
              type: "select",
              lable: "Course",
              name: "course_code",
              items: window.slct_course,
              // col_size: 12,
              value: "",
              avetmiss: "required",
              disabled: false,
            },
            {
              type: "select",
              lable: "Location",
              name: "location",
              items: window.slct_state,
              value: "",
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "Class",
              name: "class",
              items: window.slct_class,
              // items: {
              //         '0' : 'None',
              // },
              value: "0",
            },
            {
              type: "select",
              lable: "Eligibility",
              name: "eligibility",
              items: {
                E: "Eligible",
                NE: "Not Eligible",
              },
              value: "",
            },

            {
              type: "datepicker",
              lable: "Start Date",
              name: "start_date",
              value: "",
              avetmiss: "required",
              disabled: "",
              // disabledDates: [],
            },
            {
              type: "datepicker",
              lable: "End Date",
              name: "end_date",
              value: "",
              avetmiss: "required",
              disabled: "",
              // disabledDates: [],
            },
            {
              type: "select",
              lable: "Course Fee Type",
              name: "course_fee_type",
              items: "",
              value: "",
            },
            {
              type: "text",
              lable: "Course Fee",
              name: "course_fee",
              value: "",
            },
            {
              type: "select",
              lable: "Status",
              name: "status_id",
              items: window.slct_offer_lttr_statuses,
              value: "",
            },
            {
              type: "datepicker",
              lable: "AISS",
              name: "aiss_date",
              value: "",
            },
            {
              type: "select",
              lable: "Agent",
              name: "agent_id",
              items: window.agents,
              value: "",
            },
            {
              type: "textbox",
              lable: "Remarks",
              name: "remarks",
              value: "",
              col_size: 12,
            },
          ],
        },
        {
          FormTitle: "Enrolment Details",
          FormBody: [
            // {
            //   type: "select",
            //   lable: "Outcome Status",
            //   name: "outcome_id_national",
            //   items: window.slct_outcome_status,
            //   value: "",
            //   avetmiss : 'required'
            // },
            {
              type: "select",
              lable: "Funding Type",
              name: "funding_type",
              items: window.slc_funding_type,
              value: "",
            },
            {
              type: "select",
              lable: "Funding Source National",
              name: "funding_source_national",
              items: window.slct_funding_source_national,
              value: "",
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "Commencing Course",
              name: "commence_prg_identifier",
              items: window.slct_com_course,
              value: "",
              avetmiss: "required",
            },
            {
              type: "text",
              lable: "Training Contract",
              name: "training_contract_id",
              value: "",
              disabled: "",
            },
            {
              type: "text",
              lable: "Client ID Apprenticeships",
              name: "client_id_apprenticeships",
              value: "",
              disabled: "",
            },
            {
              type: "select",
              lable: "Study Reason",
              name: "study_reason_id",
              items: window.slct_study_reason,
              value: "",
            },
            {
              type: "select",
              lable: "Specific Funding",
              name: "specific_funding_id",
              items: window.slct_specific_fund,
              value: "",
            },
            {
              type: "select",
              lable: "Funding Source State",
              name: "funding_source_state_training_authority",
              items: window.slct_funding_source_state,
              value: "",
            },
            {
              type: "text",
              lable: "Purchasing Contract",
              name: "purchasing_contract_id",
              value: "",
            },
            {
              type: "text",
              lable: "Purchasing Contract Schedule",
              name: "purchasing_contract_schedule_id",
              value: "",
            },
            {
              type: "text",
              lable: "Associated Course",
              name: "associated_course_id",
              value: "",
            },
            {
              type: "select",
              lable: "Predominant Delivery Mode",
              name: "predominant_delivery_mode",
              items: window.slct_predom_dlvr_mode,
              value: "",
            },
            {
              type: "text",
              lable: "Full-time Learning Option",
              name: "full_time_leaning_option",
              value: "",
            },
          ],
        },
      ],
      errors: [],
      // isHidden: true,
      modifyAll: "",
      modifyAllMode: "",
      modifyAllDatesStart: [],
      modifyAllDatesEnd: [],
      courseFeeType: "",
      server_slct_unit_opt: [],
      isLoading: false,
      isHidden: false,
      isDisabledDate: [],
      loadData: 1,
    };
  },
  created() {
    // console.log(this.process_id);
    this.fetchData();
    // this.getValues.process_id = typeof this.process_id !== 'undefined' ? this.process_id : null;
  },

  methods: {
    updateCourse() {
      let vm = this;
      // this.$emit("courseUpdate", "updated");
      // console.log('wew')
      // const promise = new Promise((resolve, reject) => {
      //   try {
      //     vm.$emit("courseUpdate", "updated");
      //   } catch (error) {
      //     reject('error updating');
      //   }
      // });
      // promise.then((res) => {
      //   console.log('test');
      //   vm.fetchData();
      // });
    },
    generate_invoice() {
      window.open(
        `/student/domestic/invoice/${window.student}/${this.getValues.course_code}`,
        "_blank"
      );
    },
    generate_payment_plan() {
      window.open(
        `/student/domestic/payment-plan/${window.student}/${this.getValues.course_code}`,
        "_blank"
      );
    },
    generate_training_plan() {
      window.open(
        `/training_plan/${this.student_id}/${this.getValues.id}`,
        "_blank"
      );
    },

    // fetchUnitOption() {
    //   axios
    //     .get("/api/unit_options/list")
    //     .then(res => {
    //       console.log(res);
    //       this.server_slct_unit_opt = res.data;
    //       console.log(this.server_slct_unit_opt);
    //     })
    //     .catch(err => {
    //       console.log(err);
    //     });
    // },
    limitText(count) {
      return `and ${count} other units`;
    },
    asyncFind(search) {
      let vm = this;
      vm.isLoading = true;
      axios
        .get("/unit_options/" + search)
        .then((res) => {
          console.log(res);
          vm.server_slct_unit_opt = res.data;
          vm.isLoading = false;
        })
        .catch((err) => {
          console.log(err);
        })
        .then(function () {
          // always executed
          // alert(af.selectedStudent);
          vm.isLoading = false;
        });
    },
    codeDescription({ subject_code, description, unit_type }) {
      // let unit = '';
      // if(unit_type != ''){
      //   unit = `${subject_code} — ${description} [${unit_type}]`;
      // }else{
      //   unit = `${subject_code} — ${description}`;
      // }
      // return unit;

      return `${subject_code} — ${description}`;
    },
    fetchData() {
      if (this.getValues.class != "") {
        if (this.getValues.class !== 0) {
          this.getTimetable(this.getValues.class);
        }
      }
      if (
        this.getValues.course_code == "" ||
        this.getValues.course_code == null
      ) {
        this.makeForm[0].FormBody[0].disabled = "";
      } else {
        this.makeForm[0].FormBody[0].disabled = "disabled";
      }

      if (this.getValues.funding_type != null) {
        this.fundingtype(
          this.getValues.funding_type.traineeship_apprenticeship
        );
      }
      // this.fundingtype(this.getValues.funding_type.traineeship_apprenticeship);

      if (this.funded_course != null) {
        let vm = this;
        vm.courseFeeType = vm.getValues.course_fee_type;
        // get class and location by course
        if (vm.getValues.course_code != null) {
          this.getOptionsbyCourse(
            vm.getValues.course_code,
            vm.getValues.location
          );
        }
        // get  Funding Source State by location
        if (vm.getValues.location != null) {
          this.fundingSourceState(vm.getValues.location);
        }

        if (vm.getValues.course_code == "@@@@") {
          vm.isHidden = true;
        } else {
          vm.isHidden = false;
        }

        if (
          this.getValues.start_date != null &&
          this.getValues.end_date != null
        ) {
          let s_date = new Date(this.getValues.start_date);
          let e_date = new Date(this.getValues.end_date);
          // return s_date.toLocaleDateString(['en-US'], {month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'})  //if you want, you can change locale date string
          this.getValues.start_date = moment(s_date)._d;
          this.getValues.end_date = moment(e_date)._d;
        } else {
          this.getValues.start_date = null;
          this.getValues.end_date = null;
        }

        if (this.getValues.aiss_date != null) {
          this.getValues.aiss_date = moment(this.getValues.aiss_date)._d;
        }

        if (this.getValues.eligibility == "E") {
          this.makeForm[0].FormBody[6].items = {
            C: "Concessional",
            NC: "Government Funded",
            FF: "Fee for Service",
          };
        } else if (this.getValues.eligibility == "NE") {
          this.makeForm[0].FormBody[6].items = {
            NC: "Government Funded",
            FF: "Fee for Service",
          };
        }
      } else {
        this.makeForm[0].FormBody[0].disabled = "";
      }

      if (this.subjects != null) {
        this.subjectList.forEach((e1) => {
          if (e1.dates.start_date != null && e1.dates.end_date != null) {
            let s_date = new Date(e1.dates.start_date);
            let e_date = new Date(e1.dates.end_date);
            e1.dates = {
              start: moment(s_date)._d,
              end: moment(e_date)._d,
            };
          } else {
            e1.dates = {
              start: null,
              end: null,
            };
          }
        });
        this.filterTimetableRotating(this.getValues.start_date);
      }

      if (this.extraUnits != null) {
        this.getValues.courseExtraUnits.forEach((e1) => {
          if (e1.dates.start_date != null && e1.dates.end_date != null) {
            let s_date = new Date(e1.dates.start_date);
            let e_date = new Date(e1.dates.end_date);
            e1.dates = {
              start: moment(s_date)._d,
              end: moment(e_date)._d,
            };
          } else {
            e1.dates = {
              start: null,
              end: null,
            };
          }
        });
      }

      // })
      // .catch(err => console.log(err));
    },
    getTimetable(id) {
      if (id != 0) {
        if (id != null) {
          axios
            .get(`/student/getClassTimetable/${id}/${this.getValues.location}`)
            .then((res) => {
              this.timetable = res.data;
              this.timetable.forEach((e1) => {
                if (e1.dates.start != null && e1.dates.end != null) {
                  let s_date = new Date(e1.dates.start);
                  let e_date = new Date(e1.dates.end);
                  e1.dates = {
                    start: moment(s_date)._d,
                    end: moment(e_date)._d,
                  };
                }
              });
            });
        }
      }
    },
    getOptionsbyCourse(course_code, location) {
      let vm = this;
      let code = null;
      let loc = null;
      if (course_code == "") {
        code = null;
      } else {
        code = course_code;
      }
      let filters = {
        code: code,
        location: location,
      };
      let str = JSON.stringify(filters);
      if (code !== null) {
        fetch(`/student/getOptions/${str}/${code}`)
          .then((res) => res.json())
          .then((res) => {
            //get state/location
            if (code == "@@@@") {
              this.makeForm[0].FormBody[1].items = window.slct_state;
            } else {
              this.makeForm[0].FormBody[1].items = res.slct_state;
            }

            if (location !== "") {
              //get select class items
              if (res.slct_class.length == 0) {
                this.makeForm[0].FormBody[2].items = { 0: "None" };
              } else {
                this.makeForm[0].FormBody[2].items = res.slct_class;
              }
            }
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    fundingSourceState(location) {
      let vm = this;
      let loc = null;
      if (location == "") {
        loc = null;
      } else {
        loc = location;
      }
      if (loc !== null) {
        fetch(`/student/options/getFundingSourceState/${location}`)
          .then((res) => res.json())
          .then((res) => {
            // console.log(res);
            vm.makeForm[1].FormBody[7].items = res.slct_funding_source_state;
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    getDisabledDate(date_val) {
      // console.log(date_val);
      let obj = {
        // from: date_val,
        to: date_val,
      };
      this.isDisabledDate.push(obj);
      // console.log(this.isDisabledDate);
      return this.isDisabledDate;
    },
    getCourseFee() {
      let vm = this;
      let filters = {
        course_code: vm.getValues.course_code,
        location: vm.getValues.location,
        student_id: vm.student_id,
        class: vm.getValues.class,
        course_fee_type: vm.getValues.course_fee_type,
      };
      // Hide/show subjectList
      if (vm.getValues.course_code == "@@@@") {
        // console.log(filters.course_code);
        vm.isHidden = true;
      } else {
        vm.isHidden = false;
      }

      if (
        filters.course_code != null &&
        filters.location != null &&
        filters.course_fee_type != null
      ) {
        // loading details
        if (this.loadData == 1) {
          swal.fire({
            title: "Loading Details...",
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
              swal.showLoading();
            },
          });
        }

        //get class and location by course
        this.getOptionsbyCourse(filters.course_code, filters.location);
        //get Funding Source State by location
        this.fundingSourceState(filters.location);

        // get course subjects and fees
        let str = JSON.stringify(filters);
        let code = vm.getValues.course_code;
        fetch(`/student/getCourseFee/${str}/${code}`)
          .then((res) => res.json())
          .then((res) => {
            let vm = this;
            this.class_details = res.class_details;
            // Subject Lists
            if (
              res.course_subjects != null &&
              res.course_completion.length == 0
            ) {
              // console.log("hi");
              this.subjectList = res.course_subjects;
              // console.log(this.subjectList);
              if (this.subjectList.length > 0) {
                this.subjectList.forEach((e1) => {
                  // console.log(e1);
                  if (e1.dates.start != null && e1.dates.end != null) {
                    e1.dates = {
                      start: moment(e1.dates.start)._d,
                      end: moment(e1.dates.end)._d,
                    };
                  } else {
                    e1.dates = {
                      start: null,
                      end: null,
                    };
                  }
                });
              }
              this.timetable = res.course_subjects;
              this.getValues.courseSubjects = this.subjectList;
            } else if (
              res.course_subjects != null &&
              res.course_completion.length != 0
            ) {
              this.subjectList = res.course_subjects;
              this.timetable = res.course_subjects;
              if (this.subjectList.length > 0) {
                this.subjectList.forEach((e1) => {
                  // console.log(e1);
                  if (e1.dates.start != null && e1.dates.end != null) {
                    e1.dates = {
                      start: moment(e1.dates.start)._d,
                      end: moment(e1.dates.end)._d,
                    };
                  } else {
                    e1.dates = {
                      start: null,
                      end: null,
                    };
                  }
                });
              }
              if (this.subjectList.length > 0) {
                this.filterTimetableRotating(
                  this.subjectList[0]["dates"]["start"]
                );
              }
              this.getValues.courseSubjects = this.subjectList;
            }

            // get start/end date if the selected class is 'straight'
            if (res.class_details != null && res.student_course == null) {
              // let oldD = this.getValues.start_date;
              // console.log(res.class_details);
              if (
                filters.course_code == res.class_details.course_code &&
                res.class_details.time_table_type == "Straight"
              ) {
                // console.log('yea, get dates');
                if (
                  res.class_details.start_date != null &&
                  res.class_details.end_date != null
                ) {
                  // console.log('yo');
                  this.getValues.start_date = moment(
                    res.class_details.start_date
                  )._d;
                  this.getValues.end_date = moment(
                    res.class_details.end_date
                  )._d;
                  // set disabled dates
                  this.makeForm[0].FormBody[4].disabled = "disabled";
                  this.makeForm[0].FormBody[5].disabled = "disabled";
                }
              } else {
                // console.log('no, remove dates');
                if (this.getValues.class != 0) {
                  this.getValues.start_date = "Invalid Date";
                  this.getValues.end_date = null;
                  this.makeForm[0].FormBody[4].disabled = "";
                  this.makeForm[0].FormBody[5].disabled = "";
                }
              }
            } else {
              if (this.getValues.class != 0) {
                this.getValues.start_date = "Invalid Date";
                this.getValues.end_date = null;
                this.makeForm[0].FormBody[4].disabled = "";
                this.makeForm[0].FormBody[5].disabled = "";
              }
              // get old start/end date if course already exist with the same location
              if (res.student_course != null) {
                if (res.student_course.location == filters.location) {
                  this.getValues.start_date = moment(
                    res.student_course.start_date
                  )._d;
                  this.getValues.end_date = moment(
                    res.student_course.end_date
                  )._d;
                }
              }
            }

            // Get Course Fees
            if (res.data != null) {
              if (filters.course_fee_type == "C") {
                this.getValues.course_fee = res.data.concessional_fee;
              } else if (filters.course_fee_type == "NC") {
                this.getValues.course_fee = res.data.non_concessional_fee;
              } else {
                this.getValues.course_fee = res.data.full_fee;
              }
            } else {
              this.getValues.course_fee = "";
            }

            // close loading
            if (vm.loadData == 1) {
              swal.close();
            }
            vm.loadData = 1;
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    // saveExtraUnits(){
    //     axios.post(`/student/domestic/${window.student}/extra_units`, this.unit_details)
    //             .then(response => {
    //                 console.log(response);
    //                 if (response.data.status == "errors") {
    //                     this.errors = response.data.errors;
    //                 } else {
    //                     this.errors = [];
    //                     // this.unit_details.units = '';
    //                     this.success = true;
    //                     Toast.fire({
    //                         type: 'success',
    //                         title: 'Data is saved successfully',
    //                     });
    //                     // this.$parent.$children[4].fetchComSetting();
    //                     // this.$parent.$children[1].unitList = this.unit_details.units;
    //                 }
    //             })
    //             .catch(error => {
    //                 Toast.fire({
    //                     type: "error",
    //                     title: "Fail to add Data"
    //                 });
    //                 console.log(error);
    //             });
    // },
    // editExtraUnits (id) {
    //     // console.log(id);
    //     let i  = this.unitList.map(item => item.id).indexOf(id);
    //     console.log(i);
    //     let selectedUnits;
    //     this.unitList.forEach(element => {
    //         if(element.id == id){
    //             selectedUnits = element;
    //         }
    //     });
    //     // console.log(selectedUnits);
    //     let units = selectedUnits.units.trim().split(',');
    //     let viewUnits = [];

    //      units.forEach(e2=>{
    //         this.slct_units.forEach(element=>{
    //              if(element.code ==(e2.trim()) ){
    //                 //  console.log(element.code);
    //                 console.log(element);
    //                 viewUnits.push({
    //                 id : element.id,
    //                 code : element.code,
    //                 value : element.code+' '+'-'+' '+element.description ,
    //                 description  :  element.description
    //                 })
    //             }
    //         })
    //         })
    //     this.unit_details.student_id = window.student_id
    //     this.unit_details.id = id
    //     this.unit_details.units = viewUnits;
    // },
    saveChanges() {
      // @ dynamic form
    },
    eligible_checker(option) {
      console.log(option);
      if (option == "E") {
        this.makeForm[0].FormBody[6].items = {
          C: "Concessional",
          NC: "Government Funded",
          FF: "Fee for Service",
        };
      } else {
        this.makeForm[0].FormBody[6].items = {
          NC: "Government Funded",
          FF: "Fee for Service",
        };
      }
    },

    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
      };
      this.units.push(tag);
      this.slct_units.push(tag);
    },
    modifyDlvrLoc() {
      let vm = this;
      if (vm.subjectList != null) {
        vm.subjectList.forEach((element) => {
          element.train_org_loc_id = vm.modifyAll;
        });
      }
    },
    fundingtype(data) {
      if (data == 1) {
        this.makeForm[1].FormBody[3].disabled = "disabled";
        this.makeForm[1].FormBody[4].disabled = "disabled";
      }
    },
    modifyDlvrMode() {
      let vm = this;
      if (vm.subjectList != null) {
        vm.subjectList.forEach((element) => {
          element.delivery_mode_id = vm.modifyAllMode;
        });
      }
    },
    getNewDates(dates, option) {
      let vm = this;
      if (option == "start") {
        if (vm.subjectList != null) {
          vm.subjectList.forEach((element) => {
            if (dates != null) {
              // console.log("hello");
              // let s_date = new Date(dates.start);
              element.dates.start = dates;
            } else {
              element.dates.start = null;
            }
          });
        }
      } else {
        if (vm.subjectList != null) {
          vm.subjectList.forEach((element) => {
            if (dates != null) {
              // console.log("hello");
              element.dates.end = dates;
            } else {
              element.dates.end = null;
            }
          });
        }
      }
    },
    filterTimetableRotating(start_date) {
      let vm = this;
      let newSubjectList = [];
      let subjectListChecker = [];

      if (vm.class_details != null && Object.keys(vm.class_details).length !== 0) {
        if (vm.class_details.time_table_type == "Rotating") {
          // axios
          // console.log(vm);
          // console.log(start_date);
          // axios.get('course-dates/fetch/'+start_date+'/'+)

          // console.log(moment(start_date).format("YYYY-MM-DD"));
          // console.log(this.subjectList);
          if (typeof this.subjectList !== "undefined") {
            if (this.timetable.length > 0 && vm.subjectList.length == 0) {
              console.log('wew')
              vm.timetable.forEach((element) => {
                if (typeof element.dates !== "undefined") {
                  if (element.dates != null) {
                    if (moment(element.dates.start).isSameOrAfter(start_date)) {
                      if (
                        subjectListChecker.indexOf(element.subject_code) == -1
                      ) {
                        newSubjectList.push(element);
                        subjectListChecker.push(element.subject_code);
                        vm.getValues.end_date = element.dates.end;
                      }
                    }
                  }
                }
              });
            } else {
              console.log('dri.a')
              if (vm.subjectList.length > 0) {
                // console.log(vm.subjectList);
                if (this.timetable.length > 0) {
                  vm.timetable.forEach((element) => {
                    if (typeof element.dates !== "undefined") {
                      if (element.dates != null) {
                        // console.log(start_date);
                        let date_start = moment(start_date).format(
                          "YYYY-MM-DD"
                        );
                        if (
                          moment(element.dates.start).isSameOrAfter(start_date)
                        ) {
                          if (
                            subjectListChecker.indexOf(element.subject_code) ==
                            -1
                          ) {
                            newSubjectList.push(element);
                            subjectListChecker.push(element.subject_code);
                            vm.getValues.end_date = element.dates.end;
                          }
                        }
                      }
                    }
                  });
                } else {
                  //mao ni dahilan
                  newSubjectList = vm.subjects;
                  // vm.subjectList.forEach((element) => {
                  //   if (typeof element.dates !== "undefined") {
                  //     if (element.dates != null) {
                  //       newSubjectList.push(element);
                  //     }
                  //   }
                  // });
                }
              } else {
                vm.subjectList = vm.subjects;
                vm.subjectList.forEach((element) => {
                  if (typeof element.dates !== "undefined") {
                    if (element.dates != null) {
                      if (
                        moment(element.dates.start).isSameOrAfter(start_date)
                      ) {
                        if (
                          subjectListChecker.indexOf(element.subject_code) == -1
                        ) {
                          newSubjectList.push(element);
                          subjectListChecker.push(element.subject_code);
                        }
                      }
                    }
                  }
                });
              }
            }

            // console.log(this.subjectList);
            vm.subjectList = newSubjectList;
            vm.getValues.courseSubjects = vm.subjectList;
          }
        }
      }
    },
  },
  watch: {
    "getValues.eligibility": function (newVal) {
      this.eligible_checker(newVal);
    },
    "getValues.course_code": function (newVal) {
      this.getValues.course_code = newVal;
      this.getCourseFee();
    },
    "getValues.location": function (newVal) {
      this.getValues.location = newVal;
      this.getCourseFee();
    },
    "getValues.course_fee_type": function (newVal) {
      this.getValues.course_fee_type = newVal;
      this.getCourseFee();
    },
    "getValues.class": function (newVal) {
      this.getValues.class = newVal;
      if (this.getValues.class != 0) {
        this.getCourseFee();
      }
    },
    "getValues.process_id": function (newVal) {
      console.log(newVal);
      console.log(this.process_id);
    },
    "getValues.start_date": function (newVal) {
      //trigger only if class was selected
      // if (this.getValues.class != 0) {
      //   this.filterTimetableRotating(newVal);
      // }
      if(typeof this.getValues.class !== 'undefined'){
        let vm = this;
        fetch('/generate-time-table/'+moment(newVal).format("YYYY-MM-DD")+'/'+this.getValues.class+'/'+this.course.id)
        .then((res) => res.json())
        .then((res) => {
          // console.log(res);
          // console.log(vm.getValues.end_date);
          if(typeof res.course_end_date !== 'undefined') {
            vm.getValues.end_date = moment(res.course_end_date).add(1,'day')._d;
            if(typeof vm.subjectList !== 'undefined' && vm.subjectList.length > 0) {
              vm.subjectList.forEach(el => {
                res.units.forEach(e => {
                  if(el.subject_code == e.course_unit_code) {
                    el.dates.start = moment(e.start_date)._d
                    el.dates.end = moment(e.end_date)._d
                  }
                })
              })
            }
          }
        })
        .catch((err) => {
          console.log(err);
        })
      }
    },
    modifyAllDatesStart: function (newVal) {
      this.getNewDates(newVal, "start");
    },
    modifyAllDatesEnd: function (newVal) {
      this.getNewDates(newVal, "end");
    },
    course: function (newVal) {
      // console.log(newVal);
    },
  },
  filters: {
    capitalize: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
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

table tbody tr td input.vc-text-base {
  font-size: 12px !important;
}

.formunits {
  counter-reset: my-awesome-counter;
}

.formunits .unitsclass .multiselect__tags-wrap {
  display: inline-grid;
}

.formunits .unitsclass .multiselect__tags-wrap .multiselect__tag:before {
  counter-increment: my-awesome-counter;
  content: counter(my-awesome-counter) ". ";
  color: #024b67;
  font-weight: bold;
}

th {
  border-left: 0.5px solid #fff !important;
}

.autofill tbody tr td label {
  font-size: 11px;
}

.autofill tbody tr td {
  padding: 3px;
}

.btn-group .dropdown-menu .dropdown-item:hover {
  cursor: pointer;
}
</style>
