<template>
  <modal
    :name="`size-modal-${this.payment_template}`"
    transition="nice-modal-fade"
    classes="demo-modal-class"
    :min-width="900"
    :min-height="200"
    :pivot-y="0.1"
    :adaptive="true"
    :scrollable="true"
    :reset="true"
    width="90%"
    height="auto"
    @before-open="beforeOpen"
    @opened="opened"
    @closed="closed"
    @before-close="beforeClose"
  >
    <div class="size-modal-content">
      <h4>Payment Details</h4>
      <form @submit.prevent="savePayment">
        <div class="row">
          <div class="col-md-12">
            <table class="table mt-2">
              <thead>
                <tr>
                  <th style="text-align:center!important">#</th>
                  <th style="text-align:center!important">Amount Paid</th>
                  <th style="text-align:center!important">Date Paid</th>
                  <th style="text-align:center!important">Notes</th>
                  <th style="text-align:center!important">Status</th>
                  <th style="text-align:center!important">Pre-Deducted Commission</th>
                  <th style="text-align:center!important">Commision Release Status</th>
                  <th style="text-align:center!important">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(detail, index) in details" :key="detail.id">
                  <td width="5%">{{ index + 1}}</td>
                  <td width="10%">${{ detail.amount }}</td>
                  <td width="15%">{{ detail.date_paid }}</td>
                  <td width="15%">{{ detail.notes}}</td>
                  <td width="15%">{{ detail.payment_status_id == 0 ? 'OK' : 'REFUNDED' }}</td>
                  <td width="15%">{{ detail.pre_deducted_amount }}</td>
                  <td
                    width="15%"
                  >{{ detail.agent_comm_status_id == null ? 'NO STATUS' : detail.commission_status.description }}</td>
                  <td>
                    <button class="btn btn-success">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
  </modal>
</template>
<script>
export default {
  props: ["payment_template"],
  data() {
    return {
      details: [],
      payment_status: window.payment_status,
      comm_status: window.comm_status,

      payments: {
        payment_template: "",
        amount: "",
        date_paid: "",
        notes: "",
        payment_status: "",
        pre_deducted_comm: "",
        comm_release_status: "",
        errors: []
      }
    };
  },
  methods: {
    fetchDetails(detail) {
      let vm = this;
      axios
        .get(`/offer-letter/course-detail/payment-detail/${detail}`)
        .then(response => {
          this.details = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    beforeOpen(e) {
      let vm = this;
      vm.fetchDetails(e.params.payment_detail);
      vm.payments.payment_template = e.params.payment_detail;
    },
    beforeClose(e) {
      this.payments.errors = [];
    },
    opened(e) {
      // e.ref should not be undefined here
      // console.log('opened', e)
      // console.log('ref', e.ref)
    },
    closed(e) {}
  }
};
</script>