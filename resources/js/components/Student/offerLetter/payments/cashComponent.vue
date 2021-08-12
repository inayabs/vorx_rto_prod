<template>
  <div>
    <div class="row">
      <div class="col-md-12 pull-right mb-3 text-right">
        <button class="btn btn-success" @click="saveChanges()">
          <i class="far fa-save"></i> Save Changes
        </button>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for>Transaction #</label>
          <input v-model="cashPayment.trxn_id" type="text" class="form-control" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for>Payment Date</label>
          <date-picker v-model="cashPayment.payment_date" :max-date="new Date()"></date-picker>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for>Amount</label>
          <input v-model="cashPayment.amount" type="text" class="form-control" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for>Initial Payment</label>
          <div class="custom-control custom-switch my-2">
            <input
              type="checkbox"
              v-model="cashPayment.initial_payment"
              class="custom-control-input"
              id="customSwitch1"
            />
            <label class="custom-control-label" for="customSwitch1"></label>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for>Payment Method</label>
          <select v-model="cashPayment.payment_method" class="form-control">
            <option
              v-for="(method) in payment_method"
              :key="method.id"
              :value="method.id"
            >{{ method.method }}</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for>Remarks</label>
          <input type="text" v-model="cashPayment.remarks" class="form-control" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapMutations, mapActions } from "vuex";
export default {
  data() {
    return {
      cashPayment: {
        trxn_id: "",
        student_id: window.student_id,
        payment_date: "",
        amount: "",
        initial_payment: "",
        payment_method: "",
        remarks: "",
        errors: []
      },
      payment_method: window.payment_methods
    };
  },
  mounted() {
    this.getTrxn();
  },
  methods: {
    // ...mapMutations(["ADD_CREDITS"]),
    // ...mapActions(["createCredits"]),
    getTrxn() {
      axios
        .get("/offer-letter/payment/trnx")
        .then(response => {
          this.cashPayment.trxn_id = `ECR-${response.data}`;
        })
        .catch(err => {
          console.log(response);
        });
    },
    saveChanges() {
      let vm = this;
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false
      });
      loadingSwal.fire({
        type: "info",
        title: "Please Wait ..."
      });
      // console.log(this.cashPayment);
      axios
        .post("/offer-letter/payment/trnx", this.cashPayment)
        .then(response => {
          if (response.data.status == "success") {
            let payment = {
              amount: this.cashPayment.amount,
              status: "08"
            };
            // this.ADD_CREDITS(payment);
            // this.createCredits(payment);
            vm.$emit("cashmade", "success");
            Toast.fire({
              type: "success",
              title: "Added Successfuly"
            });
            vm.getTrxn();
            vm.cashPayment.payment_date = "";
            vm.cashPayment.payment_date = "";
            vm.cashPayment.amount = "";
            vm.cashPayment.initial_payment = "";
            vm.cashPayment.payment_method = "";
            vm.cashPayment.remarks = "";
            vm.cashPayment.errors = [];
          } else {
            Toast.fire({
              type: "error",
              title: response.data.message
            });
            vm.getTrxn();
          }
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>