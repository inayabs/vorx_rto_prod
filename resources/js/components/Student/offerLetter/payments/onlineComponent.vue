<template>
  <div>
    <form @submit.prevent class="form-group">
      <div class="row">
        <div class="col-md-12 pull-right mb-3 text-right">
          <button class="btn btn-success" @click="saveChanges()">
            <i class="far fa-save"></i> Save Changes
          </button>
        </div>
        <div class="col-md-6">
          <label for>Transaction</label>
          <input type="text" v-model="onlinePayment.trxn_id" class="form-control" />
        </div>
        <div class="col-md-6">
          <label for>Amount</label>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text">AUD</div>
            </div>
            <input
              type="text"
              v-model="onlinePayment.amount"
              class="form-control"
              id="inlineFormInputGroup"
            />
          </div>
        </div>
        <div class="col-md-6">
          <label for>Card Number</label>
          <input type="text" v-model="onlinePayment.card_number" class="form-control" />
        </div>
        <div class="col-md-2">
          <label for>Expiry Date ( Month ):</label>
          <select class="form-control" v-model="onlinePayment.month">
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for>Expiry Date ( Year ):</label>
          <input
            type="number"
            @change="minYear"
            v-model="onlinePayment.year"
            :min="minyear"
            class="form-control"
          />
        </div>
        <div class="col-md-2">
          <label for>Secure Code ( CVV ):</label>
          <input
            type="text"
            v-model="onlinePayment.ccv"
            minlength="3"
            maxlength="3"
            class="form-control"
          />
        </div>
        <div class="col-md-6">
          <label for>Name on Card</label>
          <input type="text" v-model="onlinePayment.name_card" class="form-control" />
        </div>
        <div class="col-md-6">
          <label for>Remarks</label>
          <input type="text" v-model="onlinePayment.remarks" class="form-control" />
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { mapMutations, mapActions } from "vuex";
export default {
  data() {
    return {
      onlinePayment: {
        trxn_id: "",
        student_id: window.student_id,
        card_number: "",
        month: "",
        year: "",
        amount: "",
        payment_method: "",
        ccv: "",
        name_card: "",
        remarks: "",
        errors: []
      }
    };
  },
  created() {
    this.getTrxn();
  },
  computed: {
    minyear: value => {
      var d = new Date();
      return d.getFullYear();
    }
  },
  methods: {
    // ...mapMutations(["ADD_CREDITS"]),
    getTrxn() {
      axios
        .get("/offer-letter/payment/trnx")
        .then(response => {
          this.onlinePayment.trxn_id = `ETI-${response.data}`;
        })
        .catch(err => {
          console.log(response);
        });
    },
    minYear(value) {
      let vm = this;
      let year = value.target.value;
      let yearbase = new Date().getFullYear();
      if (year < yearbase) {
        vm.onlinePayment.year = yearbase;
      }
    },
    saveChanges() {
      let vm = this;
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false
      });
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      loadingSwal.fire({
        type: "info",
        title: "Please Wait ..."
      });
      axios
        .post("/offer-letter/payment/trnx/online", this.onlinePayment)
        .then(response => {
          if (response.data.status == "success") {
            vm.$emit("cashmade", "success");
            let payment = {
              amount: this.onlinePayment.amount,
              status: response.data.response_code
            };

            // this.ADD_CREDITS(payment);
            // this.createCredits(payment);

            Toast.fire({
              type: "success",
              title: "Added Successfuly"
            });
            vm.getTrxn();
            vm.onlinePayment.trxn_id = "";
            vm.onlinePayment.amount = "";
            vm.onlinePayment.card_number = "";
            vm.onlinePayment.month = "";
            vm.onlinePayment.year = "";
            vm.onlinePayment.payment_method = "";
            vm.onlinePayment.ccv = "";
            vm.onlinePayment.name_card = "";
            vm.onlinePayment.remarks = "";
          } else {
            vm.$emit("cashmade", "success");
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