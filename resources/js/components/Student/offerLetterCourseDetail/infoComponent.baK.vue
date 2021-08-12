<template >
  <div>
    <add-payment :payment_template="payment_template"></add-payment>
    <div class="row mt-2 mb-3">
      <div class="col-md-12 mb-3 text-right mb-3">
        
        <div class="form-group" style="display:inline-block">
          
          <select @change="updateStatus" v-model="student_status" class="form-control" name id>
            <option
              v-for="(status) in statuses"
              :key="status.id"
              :value="status.id"
            >{{ status.description }}</option>
          </select>
        </div>
        <div style="display:inline-block;width:250px;">
          <multiselect v-model="selected_class" 
          :options="availClasses" 
          :custom-label="getClassInfo"
          placeholder="Select one" 
          label="getClassInfo" 
          track-by="id"
          ></multiselect>
        </div>
        <!-- <button @click="resetPayment" class="btn btn-warning" style="display:inline-block">
          <i class="fas fa-recycle"></i> Reset Payment Schedule
        </button>-->
        <button @click="viewTrainingPlan" class="btn btn-info" style="display:inline-block">
          <i class="fas fa-plan"></i> View Training Plan
        </button>
        <a
          :href="`/offer-letter/pdf/course_detail/${detail.id}`"
          target="_blank"
          class="btn btn-success"
          style="display:inline-block"
        >
          <i class="fas fa-file-pdf"></i> View PDF
        </a>
      </div>
      <div class="col-md-8">
        <h4>{{ detail.name }} ( {{ detail.student_id }} )</h4>
        <p class="mb-0">{{ detail.email }}</p>
        <p class="mb-2">{{ detail.address }}</p>
        <p
          class="mb-0"
        >{{ detail.shore_type }} : {{ detail.course_code }} ( {{detail.duration}} weeks )</p>
        <p class="mb-0">Course : {{ detail.course_name }}</p>
        <p>From {{ detail.course_start_date }} to {{ detail.course_end_date }}</p>
        <p class="mb-0">Course Fee : ${{ detail.course_tuition.toLocaleString() }}</p>
        <p>Initial Payment : ${{ detail.initial_payment.toLocaleString() }}</p>
        <p>Agent : {{ detail.agent }}</p>
      </div>
      <div class="col-md-4">
        <h5>Account Summary</h5>
        <div class="row">
          <div class="col-md-6">Balance Due :</div>
          <div class="col-md-6">
            <p class="float-right">${{ detail.balance }}</p>
          </div>
          <div class="col-md-6">Total Amount Payed</div>
          <div class="col-md-6">
            <p class="float-right">${{ amount_paid }}</p>
          </div>
          <!-- <div class="col-md-6">Payment Due</div>
          <div class="col-md-6">
            <p class="float-right">${{ detail.balance }}</p>
          </div>-->

          <div class="col-md-9">
            <h4>Remaining Balance</h4>
          </div>
          <div class="col-md-3">
            <h4 class="float-right">${{ balance }}</h4>
          </div>
        </div>
      </div>
      <div class="col-md-12 mt-5 mb-3">
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
          <h6>Payments</h6>
        </div>
        <p>
          <button
            :class="'btn btn-'+app_color"
            type="button"
            data-toggle="collapse"
            data-target="#paymentdues"
            aria-expanded="false"
            aria-controls="paymentdues"
          >Payment Dues</button>
          <!-- <button
            :class="'btn btn-'+app_color"
            type="button"
            data-toggle="collapse"
            data-target="#collapseExample1"
            aria-expanded="false"
            aria-controls="collapseExampl1"
          >Payment Reminder</button>-->
        </p>
        <div class="collapse mb-2" id="paymentdues">
          <div class="card card-body">
            <table :class="'table responsive header-'+app_color" style="z-index:1">
              <thead>
                <tr>
                  <th :class="'text-center table-header-'+app_color">#</th>
                  <th :class="'text-center table-header-'+app_color">Due Date</th>
                  <th :class="'text-center table-header-'+app_color">Payable Amount</th>
                  <th :class="'text-center table-header-'+app_color">Amount Paid</th>
                  <th :class="'text-center table-header-'+app_color">Pre-Deducted Commision</th>
                  <th :class="'text-center table-header-'+app_color">Date Paid</th>
                  <!-- <th style="text-align:center!important">Comission Release Status</th>
                  <th style="text-align:center!important">Status</th>-->
                </tr>
              </thead>
              <tbody>
                <tr v-if="detail.payments.length == 0">
                  <td align="center" colspan="8">NOTHING TO DO HERE</td>
                </tr>
                <tr
                  v-else
                  v-for="(payment, index) in detail.payments"
                  :key="payment.id"
                  @click="viewMore(payment.id)"
                >
                  <td>{{ index+1 }}</td>
                  <td align="center">{{ payment.due_date }}</td>
                  <td align="right">{{ payment.payable_amount }}</td>
                  <td align="right">{{ payment.amount_paid }}</td>
                  <td align="right">{{ payment.prededucted }}</td>

                  <td align="center">{{ payment.date_paid }}</td>
                  <!-- <td></td>
                  <td></td>-->
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" align="center">Total</td>
                  <td align="right">{{ payableTotal }}</td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="collapse mb-2" id="collapseExample1">
          <div
            class="card card-body"
          >Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import addPayment from "./addPaymentComponent.vue";
export default {
  components: {
    addPayment,
  },
  props: ["detail"],
  mounted() {
    // console.log(this.detail);
    this.getClasses();
  },
  data() {
    return {
      statuses: window.offer_status,
      student_status: this.detail.status_id,
      payment_template: "",
      app_color: app_color,
      availClasses : [],
      selected_class:''
    };
  },
  methods: {
    getClassInfo({desc,course_code}){
      return `${desc} - ${course_code}`;
    },
    getClasses(){
        axios.get('/student/intl/get_avail_classes/'+this.$props.detail.course_code).then(
          response=>{
            this.availClasses = response.data;
          }
        );
    },
    viewMore(payment) {
      let vm = this;
      vm.payment_template = payment;
      vm.$modal.show(`size-modal-${payment}`, { payment_detail: payment });
    },
    viewTrainingPlan() {
      window.location.href = `/training_plan/${this.detail.student_id}/${this.detail.id}`;
    },
    resetPayment() {
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
      });
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      let payments = this.detail.payments;
      console.log(payments);
      if (payments.length > 0) {
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
            loadingSwal.fire({
              type: "info",
              title: "Please Wait ...",
            });
            if (result.value) {
              let id = this.detail.id;
              axios
                .delete(`/offer-letter/payment/reset/${id}`)
                .then((response) => {
                  if (response.data.status == "success") {
                    Toast.fire({
                      type: "success",
                      title: "Updated Successfuly",
                    });
                    this.$parent.getData();
                  } else {
                    Toast.fire({
                      type: "error",
                      title: response.data.message,
                    });
                  }
                })
                .catch((err) => {
                  Toast.fire({
                    type: "error",
                    title: err,
                  });
                });
              // swal.fire("Deleted!", "The Payment has been deleted.", "success");
            }
          });
      } else {
        loadingSwal.fire({
          type: "info",
          title: "Please Wait ...",
        });
        let id = this.detail.id;
        axios
          .delete(`/offer-letter/payment/reset/${id}`)
          .then((response) => {
            if (response.data.status == "success") {
              Toast.fire({
                type: "success",
                title: "Updated Successfuly",
              });
              this.$parent.getData();
            } else {
              Toast.fire({
                type: "error",
                title: response.data.message,
              });
            }
          })
          .catch((err) => {
            Toast.fire({
              type: "error",
              title: err,
            });
          });
      }
    },
    updateStatus(e) {
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
      });
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      let data = {
        status: e.target.value,
      };
      loadingSwal.fire({
        type: "info",
        title: "Please Wait ...",
      });
      axios
        .put(
          `/offer-letter/course-detail/change-status/${this.detail.id}`,
          data
        )
        .then((response) => {
          if (response.data.status == "success") {
            Toast.fire({
              type: "success",
              title: "Updated Successfuly",
            });
            this.$parent.getData();
          } else {
            Toast.fire({
              type: "error",
              title: response.data.message,
            });
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  computed: {
    balance: function () {
      let vm = this;
      let balance = parseInt(vm.detail.balance.replace(/,/g, "", 10));
      vm.detail.payments.forEach((element) => {
        balance = balance - element.amount_paid;
      });
      balance = balance.toFixed(2);
      return balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    amount_paid: function () {
      let vm = this;
      let paid = 0;
      vm.detail.payments.forEach((element) => {
        paid = paid + parseInt(element.amount_paid);
      });
      paid = paid.toFixed(2);
      return paid.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    payableTotal: function () {
      let vm = this;
      let payableTotal = 0;
      vm.detail.payments.forEach((element) => {
        let payable = element.payable_amount;
        payable = payable.split(",").join("");
        payableTotal = payableTotal + parseInt(payable);
      });
      payableTotal = payableTotal.toFixed(2);
      return payableTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
  },
};
</script>