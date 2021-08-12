<template>
  <div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="package">Package Type</label>
          <select
            :disabled="edit"
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
          <label for="shore_type">Student Location</label>
          <select
            :disabled="edit"
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
            :disabled="edit"
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
            >
              {{ pack.name }}
            </option>
          </select>
          <select
            v-else
            id="package"
            :disabled="edit"
            @change="getPackage()"
            v-model="package_name"
            class="form-control"
          >
            <option
              v-for="(pack, index) in packages"
              :key="pack.id"
              :value="index"
            >
              {{ pack.detail.name }} ( {{ pack.location }} )
            </option>
          </select>
        </div>
      </div>
      <div class="col-md-12">
        <table :class="'table header-' + app_color">
          <thead :class="'header-' + app_color">
            <tr>
              <th :class="'table-header-' + app_color">CRICOS Course Code</th>
              <th :class="'table-header-' + app_color">
                Course Code / Course Name
              </th>
              <th :class="'table-header-' + app_color">Duration (weeks)</th>
              <th :class="'table-header-' + app_color">Tuition Fees</th>
              <th :class="'table-header-' + app_color">Material Fees</th>
              <th :class="'table-header-' + app_color">Course Start Date</th>
              <th :class="'table-header-' + app_color">Course End Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="selected_package.length == 0">
              <td colspan="7" align="center">NO PACKAGE SELECTED YET</td>
            </tr>
            <tr
              v-else
              v-for="(spack, index) in selected_package"
              :key="spack.id"
            >
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
                  :masks="{ L: 'DD/MM/YYYY' }"
                  v-model="spack.course_start._d"
                  locale="en"
                ></date-picker>
              </td>
              <td>
                <date-picker
                  :popover="{ placement: 'bottom', visibility: 'click' }"
                  :disabled-dates="{ weekdays: [1, 7] }"
                  :masks="{ L: 'DD/MM/YYYY' }"
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
        <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
          <h6>Remarks |</h6>
        </div>
        <div class="clearfix"></div>
        <textarea
          cols="30"
          v-model="remarks"
          rows="5"
          class="form-control"
        ></textarea>
      </div>
      <div class="col-md-12 mt-5">
        <!-- <div class="horizontal-line-wrapper mt-3 mb-2">
                        <h6>Course Fee Package Structure</h6>
        </div>-->
        <div class="clearfix"></div>
        <table :class="'table table-bordered header-' + app_color">
          <thead :class="'header-' + app_color">
            <th colspan="2" :class="'table-header-' + app_color">
              Course Fee Package Structure
            </th>
          </thead>
          <tbody>
            <tr>
              <td width="80%">
                Tuition fee {{ course_package_structure.course_name }}
              </td>
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
              <td width="80%">
                Course Material Fees (Textbooks, workbook, AUD 300.00 each)
              </td>
              <td width="20%">
                <input
                  type="text"
                  class="form-control text-right"
                  v-model="course_package_structure.material_fee"
                />
              </td>
            </tr>
            <tr>
              <td width="80%">
                Total Course Fee (inclusive of above application fee + material
                fee)
              </td>
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
              <td :class="'horizontal-line-wrapper-' + app_color" width="80%">
                Total Course fee Due:
              </td>
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
              <td :class="'horizontal-line-wrapper-' + app_color" width="80%">
                Payment required for Acceptance for the issuance of eCOE: (50%
                of the first course tuition fee + application fee+ material fee)
              </td>
              <td width="20%">
                <input
                  type="text"
                  v-model="course_package_structure.downpayment"
                  class="form-control text-right"
                />
              </td>
            </tr>
            <tr>
              <td :class="'horizontal-line-wrapper-' + app_color" width="80%">
                Payment Due  for Acceptance for the issuance of eCOE 
              </td>
               <date-picker
                  :popover="{ placement: 'bottom', visibility: 'click' }"
                  :masks="{ L: 'DD/MM/YYYY' }"
                  v-model="course_package_structure.payment_due"
                  locale="en"
                >
                <template v-slot="{ inputValue, inputEvents }">
                  <input
                    class="form-control p5 border rounded focus:outline-none focus:border-blue-300"
                    :value="inputValue"
                    v-on="inputEvents"
                  />
                </template>
                </date-picker>
            </tr>
            <tr>
              <td :class="'horizontal-line-wrapper-' + app_color" width="80%">
                Discount
              </td>
              <td width="20%">
                <input
                  type="text"
                  @change="updateInitial"
                  v-model="course_package_structure.discounted_amount"
                  class="form-control text-right"
                />
                <!-- <select
                  id="package"
                  v-model="course_package_structure.discount_id"
                  class="form-control"
                >
                  <option value="">None</option>
                  <option
                    v-for="(pack, index) in offer_discounts"
                    :key="pack.id"
                    :value="pack.id"
                  >
                    {{ pack.name }} - ( {{ pack.amount }} )
                  </option>
                </select> -->
              </td>
            </tr>

            <tr>
              <td :class="'horizontal-line-wrapper-' + app_color" width="80%">
                Initial Payment
                <a
                  class="btn btn-sm btn-success"
                  v-if="typeof initial_payment_receipt.id !== 'undefined'"
                  @click="viewIPR"
                  title="View Initial Payment Receipt Attachment"
                >
                  <i class="fas fa-eye"></i>
                </a>
                <a
                  class="btn btn-sm btn-warning"
                  v-else
                  title="Upload Initial Payment Receipt"
                  @click="getManualUpload()"
                >
                  <i class="fas fa-upload"></i>
                </a>
                <input
                  type="file"
                  :id="'files' + PRFileID"
                  ref="files"
                  hidden="hidden"
                  v-on:change="handleFileUploads()"
                />
              </td>
              <td width="20%">
                <input
                  type="text"
                  @change="updateInitial"
                  v-model="course_package_structure.initial_payment_amount"
                  class="form-control text-right"
                />
              </td>
            </tr>
            <tr>
              <td :class="'horizontal-line-wrapper-' + app_color" width="80%">
                Balance due (rest amount to be paid in monthly installments
                after commencement of the first course)
              </td>
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
              <td :class="'horizontal-line-wrapper-' + app_color" width="80%">
                Number of Installments
              </td>
              <td width="20%">
                <input
                  type="text"
                  @change="updateInitial"
                  v-model="course_package_structure.weekly_payment"
                  class="form-control text-right"
                />
              </td>
            </tr>
            <tr>
              <td colspan="2" width="100%">
                Notes:
                <ul>
                  <li>
                    There is a partial payment for Confirmation of Enrolment
                    (CoE) which is payable in advance or as directed by the
                    {{ org.training_organisation_name }}.
                  </li>
                  <li>
                    All fees are in Australian dollars and are subject to change
                    without notice.
                  </li>
                  <li>
                    The balance due amount may be paid via Direct Debit based on
                    agreed monthly payment plan, copy of the Student Payment
                    Schedule of Course Fees attached.
                  </li>
                  <li>
                    Late payment of fees may result in:
                    <ul>
                      <li>
                        The possibility of
                        {{ org.training_organisation_name }} reporting you to
                        the Department of Home Affairs (DHA) and cancelling your
                        enrolment.
                      </li>
                    </ul>
                  </li>
                  <li>
                    You will be informed about any changes done related to your
                    course well in advance according to the
                    {{ org.training_organisation_name }} policies and
                    procedures.
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import momentB from "moment-business-days";
export default {
  data() {
    return {
      package_type: "",
      app_color: app_color,
      shore_type: "",
      package_name: "",
      packages: [],
      package_id: "",
      non_package_id: "",
      remarks: "",
      edit: false,
      org: window.app_settings,
      selected_package: [],
      initial_payment_receipt: {},
      PRFileID: null,

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
        balance_due: 0,
        payment_due: null,
        weekly_payment: 0,
        discounted_amount: 0,
        initial_payment_amount: 0,
      },
    };
  },
  created() {
    // console.log(this.$parent.$vnode.key);
    this.fetchInitialPayment();
    
  },
  mounted() {
    if (this.$parent.$vnode.componentOptions.tag == "offer-letter") {
      this.edit = true;
      let index = this.$parent.$attrs.index;
      // console.log(this.$store.getters.enrolment[index].offer_letter);
      let ol = this.$store.getters.enrolment[index].offer_letter
      let course =   ol.course_details[0];

      if(course.package_id == null){
         this.packages = window.offer_non_package;
         this.packages.map((element,index)=>{
           if(element.id == course.course_matrix_id){
             console.log(course);
             this.filterPackageCourse(element ,course.course_start_date , course.course_end_date);
             this.package_name = index;
             this.course_package_structure.course_name = element.detail.name
             
           }
         })
      }else{
         this.packages = window.offer_package;
         this.packages.map((element,index)=>{
           if(element.id == course.package_id){
            //  console.log(element);
             this.filterPackageCourse(element);
             this.package_name = index;
             this.course_package_structure.course_name = element.name             
           }
         })
      }


      this.course_package_structure.discounted_amount = ol.fees.discounted_amount
      this.course_package_structure.downpayment = ol.fees.payment_required
      this.course_package_structure.initial_payment_amount = ol.fees.initial_payment_amount
      this.course_package_structure.payment_due = ol.fees.payment_due
      this.course_package_structure.weekly_payment = course.weekly_payment
      



      
      if(ol.shore_type == 'International'){
        this.shore_type = 'OFFSHORE';
      }else{
        this.shore_type = 'ONSHORE';
      }
      if(ol.package_type != 'Non-Package'){
        this.package_type = 1;
      }else{
        this.package_type = 2;
      }
    }
  },
  methods: {
    handleFileUploads() {
      // console.log(this.$refs.files.files);
      if (this.$refs.files.files.length == 0) {
        return false;
      }
      let file = this.$refs.files.files[0];
      let vm = this;

      swal.fire({
        title: "Uploading Initial Receipt...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });

      let formData = new FormData();

      formData.append("files", file);
      formData.append("offer_letter_id", vm.PRFileID);

      axios
        .post("/offer-letter/inital-payment-receipt/upload", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(function (res) {
          // console.log(res);
          if (res.data.status == "success") {
            swal.fire(
              "Success!",
              "Initial Payment Receipt uploaded successfully.",
              "success"
            );
            vm.fetchInitialPayment();
          }
        })
        .catch(function (err) {
          console.log(err);
          // Toast.fire({
          //     position: 'top-end',
          //     type: 'error', title: 'Attachment was not saved',
          // })
        });

      // console.log(files);
    },
    getManualUpload() {
      const realFileBtn = document.getElementById("files" + this.PRFileID);
      realFileBtn.click();
    },
    viewIPR() {
      window.open(
        "/storage/enrolment/" +
          this.initial_payment_receipt.process_id +
          "/" +
          this.initial_payment_receipt.hash_name +
          "." +
          this.initial_payment_receipt.ext,
        "_blank"
      );
    },
    fetchInitialPayment() {
      let vm = this;
      vm.PRFileID = this.$parent.$vnode.key;
      axios
        .get(`/offer-letter/inital-payment-reciept/${this.$parent.$vnode.key}`)
        .then((res) => {
          // console.log(res.data);
          vm.initial_payment_receipt =
            typeof res.data.id !== "undefined" ? res.data : {};
          swal.close();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    fetchPackage() {
      swal.fire({
        title: "Loading Details...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      if(this.package_type == 1){
        this.packages = window.offer_package;
      }else{
        this.packages = window.offer_non_package;
      }
      swal.close();
    },
    updateInitial() {
      let offerData = this.$parent.offerData;
      if (
        parseInt(this.course_package_structure.initial_payment_amount) !=
        parseInt(offerData.fees.initial_payment_amount)
      ) {
        // console.log(this.course_package_structure.initial_payment_amount);
        this.$parent.update = true;
      } else if (
        parseFloat(this.course_package_structure.discounted_amount) !=
        parseFloat(offerData.fees.discounted_amount)
      ) {
        this.$parent.update = true;
      } else if (
        parseFloat(this.course_package_structure.weekly_payment) !=
        parseFloat(offerData.fees.weekly_payment)
      ) {
        this.$parent.update = true;
      } else {
        this.$parent.update = false;
      }
    },
    clearPackage() {
      this.packages = [];
      this.shore_type = "";
      this.package_name = "";
      this.selected_package = [];
      this.package_id = "";
      this.non_package_id = "";
      this.course_package_structure = {
        course_name: "",
        tuition_fee: 0,
        application_fee: 0,
        material_fee: 0,
        total_course_fee: 0,
        oshc: 0,
        total_course_fee_due: 0,
        downpayment: 0,
        balance_due: 0,
        initial_payment_amount: 0,
      };
    },
    getPackage() {
      // console.log(this.package_name);
      this.filterPackageCourse(this.packages[this.package_name]);
    },
    filterPackageCourse(_package,start = null ,end = null) {
      let data = [];
      if (this.package_type == 1) {
        var course_start = "";
        let vm = this;
        $.each(_package.detail, function (key, val) {
          vm.package_id = val.course_package_id;
          vm.non_package_id = "";
          var p = {
            id: val.course.course_code,
            code: val.course.course_code,
            course_matrix_id: val.course_matrix_id,
            criscos: val.course.cricos_code,
            code_name: `${val.course.course_code} - ${val.course.detail.name}`,
            duration: val.course.wk_duration_package,
            max_duration: val.course.wk_duration_package,
            tuition:
              vm.shore_type == "OFFSHORE"
                ? val.course.offshore_tuition_package
                : val.course.onshore_tuition_package,
            material: val.course.material_fees,
            max_tuition:
              vm.shore_type == "OFFSHORE"
                ? val.course.offshore_tuition_package
                : val.course.onshore_tuition_package,
            application_fee: val.course.enrolment_fee,
            course_start: "",
            course_end: "",
          };
          data.push(p);
        });
        this.selected_package = data;
        this.compute_package_duration();
      } else {
        this.package_id = "";
        this.non_package_id = _package.id;
        var p = {
          id: _package.course_code,
          code: _package.course_code,
          course_matrix_id: _package.id,
          criscos: _package.cricos_code,
          code_name: `${_package.course_code} - ${_package.detail.name}`,
          duration: _package.wk_duration,
          max_duration: _package.wk_duration,
          tuition:
            this.shore_type == "OFFSHORE"
              ? _package.offshore_tuition_individual
              : _package.onshore_tuition_individual,
          material: _package.material_fees,
          max_tuition:
            this.shore_type == "OFFSHORE"
              ? _package.offshore_tuition_individual
              : _package.onshore_tuition_individual,
          course_start:
            start == null
              ? moment()
              : moment(
                  moment(start).format("YYYY-MM-DD")
                ),
          course_end:
           end == null
              ? moment().add(_package.wk_duration, "w")
              : moment(
                  moment(start)
                    .format("YYYY-MM-DD")
                ).add(_package.wk_duration, "w"),
          application_fee: _package.enrolment_fee,
        };
        data.push(p);
        this.selected_package = data;
        this.compute_package_duration();
      }
    },
    compute_package_duration(index) {
      var data = this.selected_package;
      var vm = this;
      if (index == null) {
        $.each(data, function (key, val) {
          if (key == 0) {
            if (
              data[key].course_start == null ||
              data[key].course_start == ""
            ) {
              if (moment().weekday() == 6 || moment().weekday() == 7) {
                data[key].course_start = moment().add(1, "w").weekday(1);
                if (
                  moment().add(val.duration, "w").weekday() == 6 ||
                  moment().add(val.duration, "w").weekday() == 7
                ) {
                  data[key].course_end = moment()
                    .add(val.duration + 1, "w")
                    .weekday(1);
                } else {
                  data[key].course_end = moment().add(val.duration, "w");
                }
              } else {
                data[key].course_start = moment();
                data[key].course_end = moment().add(val.duration, "w");
              }
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
    },
  },
  computed: {
    total_course_fee: function () {
      return (this.course_package_structure.total_course_fee_due = Math.round(
        this.course_package_structure.total_course_fee -
          this.course_package_structure.oshc
      ).toFixed(2));
    },
    balance_due: function () {
      // if()
      if (this.course_package_structure.discounted_amount != 0) {
        let vm = this;
        let amount = this.course_package_structure.discounted_amount;
        // console.log(amount);
        let finalamount = 0;
        if (this.course_package_structure.initial_payment_amount == 0) {
          finalamount = Math.round(
            this.course_package_structure.total_course_fee_due -
              this.course_package_structure.downpayment -
              amount
          ).toFixed(2);
          if (finalamount > 0) {
            vm.course_package_structure.balance_due = finalamount;
            return finalamount;
          } else {
            let subra =
              this.course_package_structure.downpayment - Math.abs(finalamount);
            vm.course_package_structure.downpayment = subra;

            return 0;
          }
        } else {
          finalamount = Math.round(
            this.course_package_structure.total_course_fee_due -
              this.course_package_structure.initial_payment_amount -
              amount
          ).toFixed(2);
          if (finalamount > 0) {
            vm.course_package_structure.balance_due = finalamount;
            return finalamount;
          } else {
            vm.course_package_structure.balance_due = 0;
            return 0;
          }
        }
      } else {
        if (this.course_package_structure.initial_payment_amount == 0) {
          return (this.course_package_structure.balance_due = Math.round(
            this.course_package_structure.total_course_fee_due -
              this.course_package_structure.downpayment
          ).toFixed(2));
        } else {
          return (this.course_package_structure.balance_due = Math.round(
            this.course_package_structure.total_course_fee_due -
              this.course_package_structure.initial_payment_amount
          ).toFixed(2));
        }
      }
    },
  },
  // watch: {
  //   "course_package_structure.discount_id": function (val) {
  //     let vm = this;
  //     // console.log(vm.balance_due);
  //     if (val !== "") {
  //       vm.offer_discounts.map(function (item) {
  //         if (item.id == val) {
  //           console.log(item.amount);
  //           let amount = item.amount;
  //         }
  //       });
  //     }
  //   },
  // },
};
</script>