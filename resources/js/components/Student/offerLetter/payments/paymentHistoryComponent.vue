<template>
  <div>
    <v-client-table :data="paymentHistory" :columns="columns" :options="options">
      <div slot="afterLimit" class="ml-2">
        <div class="btn-group">
          <button class="btn btn-success">Total Paid : $ {{ paymentHistoryCredits }}</button>
        </div>
      </div>
      <div slot="id" slot-scope="{index}">{{ index }}</div>
      <tfoot slot="afterBody">
        <tr>
          <td colspan="4" align="right">Total :</td>
          <td colspan="1">$ {{ paymentHistoryCredits }}</td>
        </tr>
      </tfoot>
    </v-client-table>
    <!-- <table class="table responsive">
      <thead>
        <tr>
          <th>#</th>
          <th class="text-center">Date</th>
          <th class="text-center">Description</th>
          <th class="text-center">Tender Type</th>
          <th class="text-center">Amount</th>
        </tr>
      </thead>
      <tbody v-if="paymentHistory.length > 0">
        <tr v-for="(history, index) in paymentHistory" :key="history.id">
          <td width="5%">{{ index + 1}}</td>
          <td class="text-center">{{ history.date_paid }}</td>
          <td class="text-center">{{ history.description }}</td>
          <td class="text-center">{{ history.type}}</td>
          <td class="text-center">{{ history.amount }}</td>
        </tr>
      </tbody>
      <tbody v-else>
        <td class="text-center" colspan="5">NOTHING TO DO HERE</td>
      </tbody>
      <tfoot>
        <tr>
          <td align="right" colspan="4">Total</td>
          <td class="text-center">{{ paymentHistoryCredits }}</td>
        </tr>
      </tfoot>
    </table>-->
  </div>
</template>
<script>
// import { mapMutations, mapGetters } from "vuex";
export default {
  props: ["messageson"],
  data() {
    return {
      paymentHistory: [],
      columns: ["id", "date_paid", "description", "type", "amount"],
      options: {
        initialPage: 1,
        perPage: 10,
        highlightMatches: true,
        sortIcon: {
          base: "fas",
          up: "fa-sort-amount-up",
          down: "fa-sort-amount-down",
          is: "fa-sort"
        },
        headings: {
          id: "#",
          date_paid: "Date Paid",
          description: "Description",
          type: "Type",
          amount: "Amount"
        },
        sortable: ["id", "name", "type"],
        rowClassCallback(row) {
          return (row.id = row.id);
        },
        columnClasses: { id: "class-is" },
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords"
        }
      },
      payment_credits: 0
    };
  },
  created() {
    this.getPaymentHistory();
  },
  computed: {
    // ...mapGetters(["paymentHistoryCredits"])
    // payment_credit() {
    //   let vm = this;
    //   let amount = vm.$store.state.payment_credit;
    //   return `$${amount.toFixed(2)}`;
    // }
  },
  methods: {
    // ...mapMutations(["ADD_CREDIT_HISTORY"]),
    getPaymentHistory() {
      console.log();
      axios
        .get(`/offer-letter/paymenthistory/${window.student_id}`)
        .then(response => {
          this.paymentHistory = response.data.reverse();
          // if (this.$store.getters.getPaymentCount == 0) {
          //   // this.ADD_CREDIT_HISTORY(this.paymentHistory);
          // }
        })
        .catch(err => {});
    }
  },
  watch: {
    messageson: function(newVal, oldVal) {
      if (newVal == "success") {
        this.getPaymentHistory();
        this.$parent.messageson = "";
      }
    }
  }
};
</script>