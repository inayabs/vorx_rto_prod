
<template>
  <div>
    <div class="form-padding-left-right">
      <div class="row">
        <div class="col-md-12">
          <div id="accordion">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                  <button
                    class="btn btn-link"
                    data-toggle="collapse"
                    data-target="#collapseOne"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >Course Name Here</button>
                </h5>
              </div>

              <div
                id="collapseOne"
                class="collapse show"
                aria-labelledby="headingOne"
                data-parent="#accordion"
              >
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-12 pull-right text-right">
                      <button class="btn btn-success" @click="saveChanges()">
                        <i class="far fa-save"></i> Save Changes
                      </button>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="clearfix mb-2"></div>
                  <!-- student info start  -->
                  <div class="horizontal-line-wrapper mb-2">
                    <h6>Student Information</h6>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input
                          type="text"
                          v-model="student_id"
                          class="form-control"
                          id="student_id"
                        />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="student_type">Student Type</label>
                        <!-- <input type="text" class="form-control" id="student_type" /> -->
                        <select
                          name="student_type"
                          v-model="student_type"
                          id="student_type"
                          class="form-control"
                        >
                          <option
                            v-for="type in types"
                            :key="type.id"
                            :value="type.id"
                          >{{ type.type}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="agency_name">Agent</label>
                        <input type="text" v-model="agent" class="form-control" id="agent" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="country_of_birth">Country of Birth</label>
                        <select
                          name="country_of_birth"
                          v-model="country_of_birth"
                          id="country_of_birth"
                          class="form-control"
                        >
                          <option value></option>
                          <option
                            v-for="country in countries"
                            :key="country.identifier"
                            :value="country.identifier"
                          >{{ country.full_name}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="issue_date">Date Issued</label>
                        <date-picker v-model="issue_date" locale="en"></date-picker>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="reference_id">Reference Id</label>
                        <input type="text" v-model="reference_id" class="form-control" />
                      </div>
                    </div>
                    <!-- <div class="col-md-6">
                      <div class="form-group">
                        <label for="agent">Agent</label>
                        <input type="text" v class="form-control" />
                      </div>
                    </div>-->
                  </div>
                  <!-- student info end  -->
                  <div class="clearfix mb-5"></div>
                  <!-- address / contact info start  -->
                  <div class="horizontal-line-wrapper mb-2">
                    <h6>Address / Contact Information</h6>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email_personal">Email Personal</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="email_personal"
                          id="email_personal"
                        />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input type="text" class="form-control" v-model="telephone" id="telephone" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" class="form-control" v-model="mobile" id="mobile" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="current_address">Current Address</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="current_address"
                          id="current_address"
                        />
                      </div>
                    </div>
                    <!-- <div class="col-md-6">
                      <div class="form-group">
                        <label for="current_address">Current Address</label>
                        <input type="text" class="form-control" id="current_address" />
                      </div>
                    </div>-->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="home_address">Home Address</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="home_address"
                          id="home_address"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="country">Country</label>
                        <select name="country" id="country" v-model="country" class="form-control">
                          <option value></option>
                          <option
                            v-for="country in countries"
                            :key="country.identifier"
                            :value="country.identifier"
                          >{{ country.full_name}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="state_province">State Province</label>
                        <select
                          name="state_province"
                          id="state_province"
                          v-model="state_province"
                          class="form-control"
                        >
                          <option value></option>
                          <option
                            v-for="state in states"
                            :key="state.id"
                            :value="state.id"
                          >({{ state.state_key }}){{ state.state_name}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" class="form-control" v-model="postcode" id="postcode" />
                      </div>
                    </div>
                  </div>
                  <!-- student info end  -->
                  <div class="clearfix mb-5"></div>
                  <!-- passport info start  -->
                  <div class="horizontal-line-wrapper mb-2">
                    <h6>Passport Information</h6>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="passport_number">Passport Number</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="passport_num"
                          id="passport_number"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="passport_number">
                          Expiry Date
                          <span style="font-size: 74%;opacity: 73%;">( MM/DD/YYYY )</span>
                        </label>
                        <date-picker v-model="expiry_date" locale="en"></date-picker>
                      </div>
                    </div>
                  </div>
                  <!-- passport info end  -->
                  <div class="clearfix mb-5"></div>
                  <!-- package info start  -->
                  <div class="horizontal-line-wrapper mb-2">
                    <h6>Package Information</h6>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="package">Package Type</label>
                        <select
                          @change="clearPackage()"
                          id="package_type"
                          v-model="package_type"
                          class="form-control"
                        >
                          <option value></option>
                          <option value="1">Package</option>
                          <option value="2">Non-Package</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="shore_type">Shore Type</label>
                        <select
                          @change="fetchPackage"
                          name
                          id="shore_type"
                          v-model="shore_type"
                          class="form-control"
                        >
                          <option value></option>
                          <option value="ONSHORE">ONSHORE</option>
                          <option value="OFFSHORE">OFFSHORE</option>
                        </select>
                        <!-- <input type="text" class="form-control" id="shore_type" /> -->
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="package">Package</label>
                        <select
                          @change="getPackage()"
                          v-if="package_type == 1"
                          id="package"
                          v-model="package_name"
                          class="form-control"
                        >
                          <option
                            v-for="(pack, index) in packages"
                            :key="pack.id"
                            :value="index"
                          >{{ pack.name }}</option>
                        </select>
                        <select
                          v-else
                          id="package"
                          @change="getPackage()"
                          v-model="package_name"
                          class="form-control"
                        >
                          <option
                            v-for="(pack, index) in packages"
                            :key="pack.id"
                            :value="index"
                          >{{ pack.detail.name }} ( {{pack.location}} )</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>CRICOS Course Code</th>
                            <th>Course Code / Course Name</th>
                            <th>Duration (weeks)</th>
                            <th>Tuition Fees</th>
                            <th>Material Fees</th>
                            <th>Course Start Date</th>
                            <th>Course End Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-if="selected_package.length == 0 ">
                            <td colspan="7" align="center">NO PACKAGE SELECTED YET</td>
                          </tr>
                          <tr v-else v-for="(spack , index) in selected_package" :key="spack.id">
                            <td>{{ spack.criscos }}</td>
                            <td>{{ spack.code_name }}</td>
                            <td>
                              <input
                                type="number"
                                class="form-control"
                                :max="spack.max_duration"
                                @change="compute_package_duration(index)"
                                v-model="spack.duration"
                              />
                            </td>
                            <td>
                              <input class="form-control" v-model="spack.tuition" />
                            </td>
                            <td>
                              <input
                                @input="compute_package_structure(index)"
                                class="form-control"
                                v-model="spack.material"
                              />
                            </td>
                            <td>
                              <date-picker
                                @input="compute_package_duration_date(index)"
                                :disabled-dates="{ weekdays: [1, 7] }"
                                v-model="spack.course_start._d"
                                locale="en"
                              ></date-picker>
                            </td>
                            <td>
                              <date-picker
                                :popover="{ placement: 'bottom', visibility: 'click' }"
                                :disabled-dates="{ weekdays: [1, 7] }"
                                v-model="spack.course_end._d"
                                locale="en"
                              ></date-picker>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 mt-5">
                      <div class="horizontal-line-wrapper mb-2">
                        <h6>Remarks</h6>
                      </div>
                      <div class="clearfix"></div>
                      <textarea cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12">
                      <!-- <div class="horizontal-line-wrapper mt-3 mb-2">
                        <h6>Course Fee Package Structure</h6>
                      </div>-->
                      <div class="clearfix"></div>
                      <table class="table table-bordered">
                        <thead>
                          <th colspan="2">Course Fee Package Structure</th>
                        </thead>
                        <tbody>
                          <tr>
                            <td width="80%">Tuition fee {{course_package_structure.course_name}}</td>
                            <td width="20%">
                              <input
                                type="text"
                                readonly="true"
                                class="form-control text-right"
                                v-model="course_package_structure.tuition_fee"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td width="80%">Application Fee (non-refundable)</td>
                            <td width="20%">
                              <input
                                type="text"
                                class="form-control text-right"
                                v-model="course_package_structure.application_fee"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td
                              width="80%"
                            >Course Material Fees (Textbooks, workbook, AUD 300.00 each)</td>
                            <td width="20%">
                              <input
                                type="text"
                                class="form-control text-right"
                                v-model="course_package_structure.material_fee"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td
                              width="80%"
                            >Total Course Fee (inclusive of above application fee + material fee)</td>
                            <td width="20%">
                              <input
                                type="text"
                                readonly="true"
                                class="form-control text-right"
                                v-model="course_package_structure.total_course_fee"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td width="80%">OSHC: (The student arranged for his OSHC)</td>
                            <td width="20%">
                              <input
                                type="text"
                                class="form-control text-right"
                                v-model="course_package_structure.oshc"
                              />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-12">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <td class="horizontal-line-wrapper" width="80%">Total Course fee Due:</td>
                            <td width="20%">
                              <input
                                readonly="true"
                                :value="total_course_fee"
                                type="text"
                                class="form-control text-right"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td
                              class="horizontal-line-wrapper"
                              width="80%"
                            >Payment required for Acceptance for the issuance of eCOE: (50% of the first course tuition fee + application fee+ material fee)</td>
                            <td width="20%">
                              <input
                                type="text"
                                v-model="course_package_structure.downpayment"
                                class="form-control text-right"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td
                              class="horizontal-line-wrapper"
                              width="80%"
                            >Balance due (rest amount to be paid in monthly installments after commencement of the first course)</td>
                            <td width="20%">
                              <input
                                readonly="true"
                                :value="balance_due"
                                type="text"
                                class="form-control text-right"
                              />
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" width="100%">
                              Notes:
                              <ul>
                                <li>There is a partial payment for Confirmation of Enrolment (CoE) which is payable in advance or as directed by the ETI.</li>
                                <li>All fees are in Australian dollars and are subject to change without notice.</li>
                                <li>The balance due amount may be paid via Direct Debit based on agreed monthly payment plan, copy of the Student Payment Schedule of Course Fees attached.</li>
                                <li>
                                  Late payment of fees may result in:
                                  <ul>
                                    <li>The possibility of ETI reporting you to the Department of Home Affairs (DHA) and cancelling your enrolment.</li>
                                  </ul>
                                </li>
                                <li>You will be informed about any changes done related to your course well in advance according to the ETI policies and procedures.</li>
                              </ul>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- package info end  -->
                  <div class="clearfix mb-5"></div>
                  <!-- checklist info start  -->
                  <div class="horizontal-line-wrapper mb-2">
                    <h6>Check List Information</h6>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="package">Package</label>
                        <input type="text" class="form-control" id="package" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="shore_type">Shore Type</label>
                        <input type="text" class="form-control" id="shore_type" />
                      </div>
                    </div>
                  </div>
                  <!-- checklist info end  -->
                </div>
              </div>
            </div>
            <!-- end of 1st acccourdion -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import momentB from "moment-business-days";
export default {
  created() {
    this.student_id = `ETI${window.student}`;
  },
  props: ["types", "countries", "states"],
  data() {
    return {
      // student info
      student_id: "",
      student_type: "",
      country_of_birth: "",
      issue_date: "",
      reference_id: "",
      agent: "",

      // address/contact info
      email_personal: "",
      telephone: "",
      mobile: "",
      current_address: "",
      home_address: "",
      country: "",
      state_province: "",
      postcode: "",
      // passport info
      passport_num: "",
      expiry_date: "",
      // package info
      package_type: "",
      shore_type: "",
      package_name: "",
      packages: [],
      selected_package: [],

      //Course Fee Package Structure
      course_package_structure: {
        course_name: "",
        tuition_fee: 0,
        application_fee: 0,
        material_fee: 0,
        total_course_fee: 0,
        oshc: 0,
        total_course_fee_due: 0,
        downpayment: 0,
        balance_due: 0
      }
    };
  },
  methods: {
    fetchPackage() {
      axios
        .get(`/offer-letter/package/${this.package_type}/${this.shore_type}`)
        .then(res => {
          // console.log(res.data);
          this.packages = res.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    clearPackage() {
      this.packages = [];
      this.shore_type = "";
      this.package_name = "";
      this.selected_package = [];
    },
    getPackage() {
      // console.log(this.package_name);
      this.filterPackageCourse(this.packages[this.package_name]);
    },
    filterPackageCourse(_package) {
      let data = [];
      if (this.package_type == 1) {
        var course_start = "";
        let vm = this;
        $.each(_package.detail, function(key, val) {
          var p = {
            id: val.course.course_code,
            criscos: val.course.cricos_code,
            code_name: `${val.course.course_code} - ${val.course.detail.name}`,
            duration: val.course.wk_duration,
            max_duration: val.course.wk_duration,
            tuition:
              this.shore_type == "ONSHORE"
                ? val.course.os_tuition_package
                : val.course.oh_tuition_package,
            material: val.course.material_fees,
            max_tuition:
              this.shore_type == "ONSHORE"
                ? val.course.os_tuition_package
                : val.course.oh_tuition_package,
            application_fee: val.course.enrolment_fee,
            course_start: "",
            course_end: ""
          };
          data.push(p);
        });
        this.selected_package = data;
        this.compute_package_duration();
      } else {
        console.log(_package);

        var p = {
          id: _package.course_code,
          criscos: _package.cricos_code,
          code_name: `${_package.course_code} - ${_package.detail.name}`,
          duration: _package.wk_duration,
          max_duration: _package.wk_duration,
          tuition:
            this.shore_type == "ONSHORE"
              ? _package.os_tuition_individual
              : _package.oh_tuition_individual,
          material: _package.material_fees,
          max_tuition:
            this.shore_type == "ONSHORE"
              ? _package.os_tuition_individual
              : _package.oh_tuition_individual,
          course_start:
            data[data.length - 1] == null
              ? moment()
              : moment(
                  data[data.length - 1].course_end.format("YYYY-MM-DD")
                ).add(1, "d"),
          course_end:
            data[data.length - 1] == null
              ? moment().add(_package.wk_duration, "w")
              : moment(
                  data[data.length - 1].course_end
                    .add(1, "d")
                    .format("YYYY-MM-DD")
                ).add(_package.wk_duration, "w"),
          application_fee: _package.enrolment_fee
        };
        data.push(p);
        this.selected_package = data;
      }
    },
    compute_package_duration(index) {
      var data = this.selected_package;
      var vm = this;
      if (index == null) {
        $.each(data, function(key, val) {
          if (key == 0) {
            if (data[key].course_start == "") {
              data[key].course_start = moment();
              data[key].course_end = moment().add(val.duration, "w");
            } else {
              data[key].course_end = moment().add(val.duration, "w");
            }
          } else { 
            data[key].course_start = momentB(
              data[key - 1].course_end.format("YYYY-MM-DD")
            ).businessAdd(1);
            data[key].course_end = moment(
              data[key].course_start.format("YYYY-MM-DD")
            ).add(val.duration, "w");
          }
        });
        vm.compute_package_structure(0);
      } else {
        for (let i = index; i < data.length; i++) {
          if (data[i].duration > data[i].max_duration) {
            data[i].duration = data[i].max_duration;
          }
          if (i == 0) {
            data[i].course_end = moment(
              data[i].course_start.format("YYYY-MM-DD")
            ).add(data[i].duration, "w");
            data[i].tuition = Math.round(
              (parseInt(data[i].max_tuition) / parseInt(data[i].max_duration)) *
                parseInt(data[i].duration)
            );
            vm.compute_package_structure(i);
          } else {
            data[i].course_start = momentB(
              data[i - 1].course_end.format("YYYY-MM-DD")
            ).businessAdd(1);
            data[i].course_end = moment(
              data[i].course_start.format("YYYY-MM-DD")
            ).add(data[i].duration, "w");
            data[i].tuition = Math.round(
              (parseInt(data[i].max_tuition) / parseInt(data[i].max_duration)) *
                parseInt(data[i].duration)
            );
          }
        }
      }
    },
    compute_package_duration_date(e) {
      var data = this.selected_package;
      for (let i = e; i < data.length; i++) {
        if (i == 0) {
          data[i].course_end = moment(
            data[i].course_start.format("YYYY-MM-DD")
          ).add(data[i].duration, "w");
        } else if (i == e) {
          data[i].course_end = moment(
            data[i].course_start.format("YYYY-MM-DD")
          ).add(data[i].duration, "w");
        } else {
          data[i].course_end = moment(
            data[i].course_start.format("YYYY-MM-DD")
          ).add(data[i].duration, "w");
          data[i].course_start = momentB(
            data[i - 1].course_end.format("YYYY-MM-DD")
          ).businessAdd(1);
        }
      }
    },
    compute_package_structure(e) {
      if (e == 0) {
        var data = this.selected_package[0];
        this.course_package_structure.course_name = data.code_name;
        this.course_package_structure.tuition_fee = Math.round(
          data.tuition
        ).toFixed(2);
        this.course_package_structure.material_fee = Math.round(
          data.material
        ).toFixed(2);
        this.course_package_structure.application_fee = Math.round(
          data.application_fee
        ).toFixed(2);
        this.course_package_structure.total_course_fee = Math.round(
          parseInt(data.material) +
            parseInt(data.tuition) +
            parseInt(data.application_fee)
        ).toFixed(2);
      }
    }
  },
  computed: {
    total_course_fee: function() {
      return (this.course_package_structure.total_course_fee_due = Math.round(
        this.course_package_structure.total_course_fee -
          this.course_package_structure.oshc
      ).toFixed(2));
    },
    balance_due: function() {
      return (this.course_package_structure.balance_due = Math.round(
        this.course_package_structure.total_course_fee_due -
          this.course_package_structure.downpayment
      ).toFixed(2));
    }
  }
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
/* .vc-text-base {
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
} */
.table-bordered td {
  border: 1px solid rgb(187, 187, 187);
  border: 1px solid rgb(187, 187, 187);
  border-right-color: rgb(187, 187, 187) !important;
  border-left-color: rgb(187, 187, 187) !important;
}
</style>