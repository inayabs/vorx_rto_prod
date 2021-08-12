<template>
  <div>
    <ul class="nav nav-tabs" id="ffTab" role="tablist">
      <li v-for="(ff, index) in course_payments" :key="ff.id">
        <a
          v-bind:class="[
            index == 0 ? 'active' : true,
            'nav-item nav-link-' + app_color + ' act',
          ]"
          :id="`nav-${[
            ff.course_code == '@@@@' ? 'unit-competency' : ff.course_code,
          ]}-tab`"
          data-toggle="tab"
          :href="`#nav-${[
            ff.course_code == '@@@@' ? 'unit-competency' : ff.course_code,
          ]}`"
          role="tab"
          :aria-controls="`nav-${[
            ff.course_code == '@@@@' ? 'unit-competency' : ff.course_code,
          ]}`"
          aria-selected="true"
        >
          <span v-if="ff.course_code == '@@@@'">Unit of Competency</span>
          <span v-else>{{ ff.course_code }}</span>
        </a>
      </li>
    </ul>
    <div class="tab-content" id="ffTabContent">
      <!-- <div class="tab-pane fade mb-3" id="payments" role="tabpanel" aria-labelledby="payments-tab"></div> -->
      <div
        v-for="(ff, index) in course_payments"
        :key="ff.id"
        :class="{ 'tab-pane fade mb-3': true, 'active show': index == 0 }"
        :id="`nav-${[
          ff.course_code == '@@@@' ? 'unit-competency' : ff.course_code,
        ]}`"
        role="tabpanel"
        :aria-labelledby="`${[
          ff.course_code == '@@@@' ? 'unit-competency' : ff.course_code,
        ]}-tab`"
      >
        <course-details 
          :payment_sched="ff.payment_sched" 
          :payment_details="ff.payment_details" 
          :course_fee="ff.course_fee" 
          :detail="ff">
        </course-details>
        <!-- <h2 class="float-right">Balance: <b>$<span>{{ ff.course_fee }}</span>.00</b></h2> -->
        <!-- <h4 class="float-left"><b>Payment History</b></h4> -->
        <!-- <h4 class="float-right">
          Remaining Balance:
          <b>
            $
            <span>{{ getBalanceFee(index) }}</span>
          </b>
        </h4>
        <div class="clearfix" style="height:10px;"></div>
        <form @submit.prevent>
          <!-- <table
            :class="'table table-bordered payment-table header-'+app_color"
            id="dataTable"
            width="100%"
            cellspacing="0"
          >
            <thead>
              <tr>
                <th :class="'text-center table-header-'+app_color">#</th>
                <th :class="'text-center table-header-'+app_color">Amount</th>
                <th :class="'text-center table-header-'+app_color">Payment Date</th>
                <th :class="'text-center table-header-'+app_color">Notes</th>
                <th :class="'text-center table-header-'+app_color">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(pd, item) in ff.payment_details" :key="pd.id">
                <td class="text-center" width="5%">{{ pd.id }}</td>
                <td class="text-right" width="20%">
                  <span>{{ pd.amount }}</span>
                </td>
                <td class="text-center" width="20%">{{ formatDate(pd.payment_date) }}</td>
                <td class="text-left" width="40%">{{ pd.note }}</td>
                <td class="text-center" width="10%">
                  <div class="btn-group" slot="actions">
                    <a
                      href="javascript:void(0)"
                      class="btn btn-primary btn-sm"
                      @click="editPayment(index, item, pd.id)"
                    >
                      <i class="fas fa-edit"></i>
                    </a>
                    <a
                      href="javascript:void(0)"
                      class="btn btn-danger btn-sm text-white"
                      @click="remove(index, item, pd.id)"
                    >
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-center" width="5%">#</td>
                <td class="text-center" width="20%">
                  <input
                    v-model="payment_details.amount"
                    v-on:keyup="onKeyUp"
                    type="text"
                    class="form-control"
                    value
                  />
                  <span
                    v-if="payment_details.errors.amount"
                    class="badge badge-danger"
                    role="alert"
                  >{{ payment_details.errors.amount[0] }}</span>
                </td>
                <td class="text-center" width="20%">
                  <date-picker
                    :popover="{ placement: 'bottom', visibility: 'click' }"
                    v-model="payment_details.payment_date"
                    v-on:keyup="onKeyUp"
                    mode="single"
                    locale="en"
                    :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
                  ></date-picker>
                  <span
                    v-if="payment_details.errors.payment_date"
                    class="badge badge-danger"
                    role="alert"
                  >{{ payment_details.errors.payment_date[0] }}</span>
                </td>
                <td class="text-center" width="40%">
                  <textarea
                    v-model="payment_details.note"
                    v-on:keyup="onKeyUp"
                    id="note"
                    class="form-control"
                    value
                  ></textarea>
                  <span
                    v-if="payment_details.errors.note"
                    class="badge badge-danger"
                    role="alert"
                  >{{ payment_details.errors.note[0] }}</span>
                </td>
                <td class="text-center" width="10%">
                  <div class="btn-group" slot="actions">
                    <a
                      href="javascript:void(0)"
                      @click="savePayment(index, ff.id)"
                      class="btn btn-success btn-sm"
                    >
                      <i class="fas fa-plus"></i> Add
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4">
                  <h4 class="float-right">
                    Total:
                    <b>
                      $
                      <span>{{ getTotalAmount(index) }}</span>.00
                    </b>
                  </h4>
                </td>
              </tr>
            </tfoot>
          </table>
        </form>-->
        <div class="clearfix"></div>

        <br />
        <div class="clearfix"></div>
        <div v-if="demoUser == false">
          <div v-for="(ci, item) in invoice" :key="item">
            <!-- ci.student_id == ff.student_id && -->
            <div
              class="row"
              v-if="
                ci.course_code == ff.course_code &&
                ci.student_id == ff.student_id
              "
            >
              <div class="col-md-12">
                <div
                  v-bind:class="
                    'horizontal-line-wrapper-' + app_color + ' my-3'
                  "
                >
                  <h6>Invoice Details</h6>
                </div>
              </div>
              <div class="col-md-3">
                <!-- {{ci.course_code}}{{ff.course_code}} -->
                <div class="form-group">
                  <label for style="margin: 0">Date</label>
                  <date-picker
                    :popover="{ placement: 'bottom', visibility: 'click' }"
                    v-model="ci.date"
                    mode="single"
                    locale="en"
                    :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                  ></date-picker>
                  <span
                    v-if="errors.date"
                    class="badge badge-danger"
                    role="alert"
                    >{{ errors.date[0] }}</span
                  >
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for style="margin: 0">Due Date</label>
                  <date-picker
                    :popover="{ placement: 'bottom', visibility: 'click' }"
                    v-model="ci.due_date"
                    mode="single"
                    locale="en"
                    :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
                  ></date-picker>
                  <span
                    v-if="errors.due_date"
                    class="badge badge-danger"
                    role="alert"
                    >{{ errors.due_date[0] }}</span
                  >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for style="margin: 0">Invoice Number</label>
                  <!-- <input v-model="ci.invoice_number" v-on:keyup="onKeyUp" type="text" class="form-control" value=""/>  -->
                  <div class="input-group mb-3">
                    <input
                      v-model="ci.invoice_number"
                      type="text"
                      class="form-control"
                      aria-describedby="basic-addon2"
                    />
                    <div class="input-group-append">
                      <button
                       :disabled="roles == 'Staff'? true : false "
                        class="btn btn-outline-secondary"
                        type="button"
                        @click="generateInvoiceNum(ci.course_code)"
                      >
                        Refresh
                      </button>
                    </div>
                  </div>
                  <span
                    v-if="errors.invoice_number"
                    class="badge badge-danger"
                    role="alert"
                    >{{ errors.invoice_number[0] }}</span
                  >
                </div>
              </div>
              <div class="col-md-2">
                <div class="clearfix" style="height: 23px"></div>
                <div class="form-group">
                  <button
                   :disabled="roles == 'Staff'? true : false "
                    class="btn btn-success btn-sm"
                    @click="updateInvoice(ff.course_code)"
                    style="padding: 8px 10px"
                  >
                    <i class="far fa-save"></i> Update Invoice
                  </button>
                  <!-- <a
                            type="button"
                            class="btn btn-success btn-md"
                            @click="generate_invoice(ff.course_code)"
                            target="_blank"
                            v-if="demoUser == false"
                        >
                            <i class="far fa-file-pdf text-danger"></i> View Invoice
                  </a>-->
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-3" v-if="app_settings.training_organisation_id === '6074'"> 
                <a v-if="ff.payment_details.length > 0"
                   :disabled="roles == 'Staff'? true : false "
                    class="btn btn-success btn-md"
                    @click="generate_receipt(ff.course_code)"
                    style="padding: 8px 30px"
                  >
                   <i class="far fa-file-pdf"></i> Generate Receipt
                  </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import courseDetails from "../payments/newPaymentDetailCourseComponent.vue";
import moment from "moment";
export default {
  props: ["messageson", "updateHistory"],
  components: { courseDetails },
  data() {
    return {
      demoUser: window.demoUser,
      roles : null,
      stud_info: {},
      course_payments: [],
      // course_invoice: [],
      payment_details: {
        id: "",
        note: "",
        payment_date: "",
        amount: "",
        course_id: "",
        errors: [],
      },
      invoice: {
        course_code: "",
        date: "",
        due_date: "",
        invoice_number: "",
      },
      errors: [],
      app_color: app_color,
      app_settings: window.app_settings,
      // totalAmount: '',
      // balanceFee: '',
    };
  },

  computed: {
    // totalAmount() {
    //     let vm = this;
    //     let sumAmount = [];
    //     var total = [];
    //         for (var prop in vm.course_payments) {
    //             if ( vm.course_payments.hasOwnProperty(prop) ) {
    //                 var sum = vm.course_payments[prop].payment_details.map((q)=>q.amount).reduce(function(total, q) {
    //                                     return total + q}, 0);
    //                 total.push(sum);
    //             }
    //         }
    //         return total;
    //     }
  },
  created() {
    this.fetchData();
      if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  mounted() {
      if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  methods: {
    generate_receipt(course_code) {
      window.open(
        `/student/domestic/payment-receipt/${window.student}/${course_code}`,
        "_blank"
      );
    },
    fetchData() {
      axios({
        method: "get",
        url: `/student/domestic/${window.student}/payment-details`,
      })
        .then((res) => {
          let vm = this;
          vm.stud_info = res.data.student;
          vm.course_payments = res.data.course_payments;
          vm.invoice = res.data.course_invoice;
          vm.invoice.forEach((ci) => {
            // console.log(ci);
            if (ci.date != null) {
              ci.date = moment(ci.date)._d;
            }
            if (ci.due_date != null) {
              ci.due_date = moment(ci.due_date)._d;
            }
            // console.log(ci.date);
          });
        })
        .catch((err) => console.log(err));
    },
    updateInvoice(course_code) {
      let vm = this;
      let _date = null;
      let _due_date = null;
      let _invoice_num = null;

      vm.invoice.forEach((ci) => {
        if (
          vm.stud_info.student_id == ci.student_id &&
          course_code == ci.course_code
        ) {
          _invoice_num = ci.invoice_number;

          if (ci.date != null) {
            if (ci.date != "undefined") {
              _date = moment(ci.date).format("YYYY-MM-DD");
            }
          } else {
            _date = null;
          }
          if (_date == "Invalid date") {
            // console.log('dsfds');
            _date = "";
          }
          if (ci.due_date != null) {
            if (ci.due_date != "undefined") {
              _due_date = moment(ci.due_date).format("YYYY-MM-DD");
            }
          } else {
            _due_date = null;
          }
          if (_due_date == "Invalid date") {
            // console.log('yooo');
            _due_date = "";
          }
        }
        // console.log(ci.date);
      });

      // console.log(_date);

      let inputs = {
        date: _date,
        due_date: _due_date,
        invoice_number: _invoice_num,
        course_code: course_code,
        student_id: vm.stud_info.student_id,
      };
      console.log(inputs);

      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes!",
        })
        .then((result) => {
          if (result.value) {
            swal.fire({
              title: "Updating Invoice...",
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                swal.showLoading();
              },
            });

            axios
              .post(`/student/domestic/invoice-update`, {
                inputs: inputs,
              })
              .then((res) => {
                // console.log(res);
                if (res.data.status == "updated") {
                  // console.log(pages);
                  // console.log(this.inputs);
                  this.errors = [];
                  // this.invoice = {};
                  swal.fire({
                    title: "Invoice updated successfully",
                    type: "success",
                    timer: 3000,
                    showConfirmButton: false,
                  });
                  // window.location.href = `/student/domestic/${window.student}/${course_code}`, "_blank";
                  window.open(
                    `/student/domestic/invoice/${window.student}/${course_code}`,
                    "_blank"
                  );
                } else if (res.data.status == "errors") {
                  // console.log(res.data.errors);
                  this.errors = res.data.errors;
                  Toast.fire({
                    type: "error",
                    title: "Opss.. failed to update Invoice",
                    position: "top-end",
                  });
                } else {
                  Toast.fire({
                    type: "error",
                    title: "Opss.. failed to update Invoice",
                    position: "top-end",
                  });
                }
              })
              .catch((err) => console.log(err));
          }
        });
    },
    // fetchData(page_url) {
    //   page_url = page_url || `/student/domestic/${window.student}/payment-details`;
    //   fetch(page_url)
    //     .then(res => res.json())
    //     .then(res => {
    //         console.log(res);
    //         let vm = this;
    //         vm.course_payments = res.data.course_payments;
    //     })
    //     .catch(err => console.log(err));
    // },

    generateInvoiceNum(course_code) {
      let vm = this;
      //generate 6 digits random number
      let randomChar = "";
      let permittedChars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      let length = 12;

      for (var i = 0; i < length; i++) {
        // let randomNum = Math.floor(Math.random() * 900000) + 100000;
        randomChar += permittedChars.charAt(
          Math.floor(Math.random() * permittedChars.length)
        );
      }
      // console.log(randomChar);
      vm.invoice.forEach((ci) => {
        if (
          vm.stud_info.student_id == ci.student_id &&
          course_code == ci.course_code
        ) {
          ci.invoice_number = randomChar;
        }
      });
      // return `00${randomNum}`;
    },

    getTotalAmount(index) {
      let vm = this;
      var sum = vm.course_payments[index].payment_details
        .map((q) => parseInt(q.amount))
        .reduce(function (total, q) {
          return total + q;
        }, 0);
      return sum;
    },
    getBalanceFee(index) {
      let vm = this;
      let cf = vm.course_payments[index].course_fee;

      if (vm.course_payments[index].payment_details.length == 0) {
        var bal = cf;
      } else {
        var bal = cf - this.getTotalAmount(index);
        bal = bal + ".00";
      }
      return bal;
    },
    savePayment(index, course_id) {
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      let vm = this;
      
      vm.payment_details.course_id = course_id;
      if (vm.payment_details.payment_date != null) {
        vm.payment_details.payment_date = moment(
          vm.payment_details.payment_date
        ).format("YYYY-MM-DD");
      }
      // console.log(vm.payment_details.payment_date);
      axios
        .post(
          `/student/domestic/${window.student}/payment-store`,
          this.payment_details
        )
        .then((response) => {
          if (response.data.status == "errors") {
            this.payment_details.errors = response.data.errors;
            Toast.fire({
              type: "error",
              title: "Opss.. failed to add payment",
              position: "top-end",
            });
          } else if (response.data.status == "success") {
            this.payment_details.errors = [];
            this.payment_details.note = "";
            this.payment_details.payment_date = "";
            this.payment_details.amount = "";
            this.payment_details.course_id = "";
            this.success = true;
            Toast.fire({
              type: "success",
              title: "Data is saved successfully",
              position: "top-end",
            });
            this.fetchData();
          }
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editPayment(index, item, payment_detail_id) {
      let vm = this;
      vm.payment_details.id = this.course_payments[index].payment_details[
        item
      ].id;
      vm.payment_details.note = this.course_payments[index].payment_details[
        item
      ].note;
      vm.payment_details.payment_date = moment(
        this.course_payments[index].payment_details[item].payment_date,
        "YYYY-MM-DD"
      )._d;
      vm.payment_details.amount = this.course_payments[index].payment_details[
        item
      ].amount;
    },
    remove(index, item, payment_detail_id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          let vm = this;
          if (result.value === true) {
            axios({
              method: "delete",
              url: `/student/domestic/${window.student}/delete/${payment_detail_id}`,
            })
              .then((res) => {
                // let i = this.course_payments[index].payment_details.map(item => item).indexOf(payment_detail_id) // find index of your object
                this.course_payments[index].payment_details.splice(item, 1);
                if (res.data.status == "success") {
                  Toast.fire({
                    type: "success",
                    title: "Data is deleted successfully",
                    position: "top-end",
                  });
                } else {
                  Toast.fire({
                    type: "error",
                    title: "Opss.. data was not deleted",
                    position: "top-end",
                  });
                }
              })
              .catch((err) => console.log(err));
          }
        });
    },
    onKeyUp() {
      // console.log(this.payment_details.errors);
      this.payment_details.errors = [];
    },
    formatDate(value) {
      if (value) {
        return moment(String(value)).format("DD/MM/YYYY");
      }
    },
  },
  watch: {
    updateHistory: function (val) {
      if (val) {
        // this.$chilren[0].getPaymentHistory();
        this.fetchData();
        // console.log();
        // console.log(this.$parent);
      }
    },
  },
};
</script>
<style >
table.payment-table {
  border-bottom: 0;
}
#ffTab .nav-link.active {
  padding: 8px 1rem;
}
#ffTab .nav-link {
  padding: 8px 1rem;
}
</style>