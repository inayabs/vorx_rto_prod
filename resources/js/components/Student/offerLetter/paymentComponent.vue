<template>
  <div>
    <div class="card">
      <div class="card-header" :id="`headingOne${offerid}`">
        <h2 class="mb-0">
          <button
            v-if="offerid == refs.id"
            class="btn btn-link"
            type="button"
            data-toggle="collapse"
            :data-target="`#collapseOne${offerid}`"
            aria-expanded="true"
            :aria-controls="`collapsefOne${offerid}`"
          >
            Offer Letter {{ offerData[0]["course_code"] }} ( NEW APPLICATION )
          </button>
          <button
            v-else
            class="btn btn-link"
            type="button"
            data-toggle="collapse"
            :data-target="`#collapseOne${offerid}`"
            aria-expanded="false"
            :aria-controls="`collapseOne${offerid}`"
          >
            Offer Letter {{ offerData[0]["course_code"] }}
          </button>
        </h2>
      </div>

      <div
        :id="`collapseOne${offerid}`"
        :class="{ collapse: true, show: offerid == refs.id }"
        :aria-labelledby="`headingOne${offerid}`"
        data-parent="#accordionExample"
      >
        <div class="card-body">
          <div class="row mb-0">
            <!-- <div class="col-md-12 pull-right mb-2 text-right">
              <button
                v-if="fees['initial_payment_amount'] == null || fees['initial_payment_amount'] == '0.00'"
                class="btn btn-success"
                @click="saveFees()"
              >
                <i class="far fa-save"></i> Save Changes
              </button>
            </div>-->
            <!--  <div class="col-md-12">
              <div class="horizontal-line-wrapper mb-3">
                <h6>{{ offerData[0]['course_code'] }} Initial Payment Section</h6>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="courseInfo">Payment Required:</label>
                <input type="text" :value="fees['payment_required']" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="courseInfo">Amount Paid:</label>
                <input
                  type="number"
                  v-model="fee.initial_payment_amount"
                  :min="maxpayment"
                  :max="maxpayment"
                  @change="checkFee"
                  @blur="checkFee"
                  class="form-control"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="courseInfo">Date Paid:</label>
                <date-picker v-model="fee.initial_payment_date_paid" :max-date="new Date()"></date-picker>
              </div>
            </div>-->
          </div>
          <!-- <hr /> -->
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li
              v-for="(detail, index) in offerData"
              :key="detail.id"
              class="nav-item"
            >
              <a
                v-bind:class="[
                  index == 0 ? 'active' : true,
                  'nav-item nav-link-' + app_color + ' act',
                ]"
                :id="`${detail.course_code}-tab-${index}`"
                data-toggle="tab"
                :href="`#${detail.course_code}-${detail.id}`"
                role="tab"
                aria-controls="home"
                aria-selected="true"
                >{{ detail.course_code }} ( {{ detail.status_id | status }} )</a
              >
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <payment-detail
              v-for="(detail, index) in offerData"
              :key="detail.id"
              :class="{ 'tab-pane fade mb-3': true, 'show active': index == 0 }"
              role="tabpanel"
              :course="detail.course_code"
              :id="`${detail.course_code}-${detail.id}`"
              :payment_details="detail.funded_course.payment_details"
              :payment_sched="detail.funded_course.payment_sched" 
              :course_fee="detail.tuition_fees" 
              :detail="detail" 
            ></payment-detail>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState, mapActions, mapGetters } from "vuex";
import moment from "moment";
import paymentDetail from "./../domestic/payments/newPaymentDetailCourseComponent";
// import paymentDetail from "./paymentDetailComponent.vue";
export default {
  components: {
    paymentDetail,
  },
  created() {},
  data() {
    return {
      app_color: app_color,
      fee: {
        initial_payment_amount: this.fees["initial_payment_amount"],
        initial_payment_date_paid:
          this.fees["initial_payment_date_paid"] != null
            ? moment(this.fees["initial_payment_date_paid"])._d
            : "",
        id: this.fees["id"],
      },
      initial_payment_amount: this.fees["initial_payment_amount"],
    };
  },

  props: [
    "offerData",
    "offerid",
    "refs",
    "fees",
    "credits",
    "balance_due",
    "updateHistory",
  ],
  methods: {
    // ...mapActions(["updateCredits"]),
    updateCredit() {
      if (
        this.fee.initial_payment_amount != 0 ||
        this.fee.initial_payment_amount != null
      ) {
        // this.updateCredits(this.fee.initial_payment_amount);
      }
    },
    saveFees() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      let credits = this.$store.state.payment_credit;
      if (credits > 0) {
        axios
          .put(`/offer-letter/fees/${this.fee.id}`, this.fee)
          .then((response) => {
            if (response.data.status == "success") {
              Toast.fire({
                type: "success",
                title: "Added Initial Payment Successfuly",
              });
              // this.updateCredits(this.fee.initial_payment_amount);
            } else {
              Toast.fire({
                type: "error",
                title: response.data.message,
              });
            }
            console.log(response);
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        Toast.fire({
          type: "error",
          title: `CHECK CREDITS`,
        });
      }
    },
    checkFee(e) {
      if (parseInt(e.target.value) != parseInt(this.fees.payment_required)) {
        return (this.fee.initial_payment_amount = parseInt(
          this.fees.payment_required
        ));
      }
      return (this.fee.initial_payment_amount = parseInt(
        this.fees.payment_required
      ));
    },
  },
  computed: {
    // ...mapState(["payment_credit"]),
    // ...mapGetters(["getPaymentCount"]),
    maxpayment: function () {
      return parseInt(this.fees.payment_required);
    },
    balanceddue: function () {
      let balance = 0;
      balance =
        parseFloat(this.fees.application_fee) +
        parseFloat(this.fees.materials_fee) +
        parseFloat(this.fees.course_tuition_fee) -
        parseFloat(this.fees.discounted_amount);
      return balance;
    },
  },
  filters: {
    status: function (e) {
      let stud_status = window.offer_status;
      let status = "";
      stud_status.forEach((element) => {
        if (element.id == e) {
          status = element.description;
        }
      });

      return status;
    },
  },
  watch: {
    // getPaymentCount: function (value) {
    //   if (value > 0) {
    //     if (
    //       this.fee.initial_payment_amount != null ||
    //       this.fee.initial_payment_amount != "0.00"
    //     ) {
    //       this.updateCredit(this.fee.initial_payment_amount);
    //     }
    //   }
    //   // console.log(value);
    // },
    updateHistory: function (newVal, oldVal) {
      if (newVal) {
        // this.$chilren[0].getPaymentHistory();
        this.$children[0].getTemplate();
        // console.log();
        // console.log(this.$parent);
      }
    },
  },
};
</script>