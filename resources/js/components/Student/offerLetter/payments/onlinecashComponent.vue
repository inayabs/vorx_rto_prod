<template>
  <div class="row">
    <div class="col-md-12 mb-3 mt-3">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a
            class="nav-item nav-link active"
            id="nav-history-tab"
            data-toggle="tab"
            href="#nav-history"
            role="tab"
            aria-controls="nav-history"
            aria-selected="true"
          >History</a>
          <a
            class="nav-item nav-link"
            id="nav-Cash-tab"
            data-toggle="tab"
            href="#nav-Cash"
            role="tab"
            aria-controls="nav-Cash"
            aria-selected="false"
          >Cash</a>
          <a
            class="nav-item nav-link"
            id="nav-Online-tab"
            data-toggle="tab"
            href="#nav-Online"
            role="tab"
            aria-controls="nav-Online"
            aria-selected="false"
          >Online</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div
          class="tab-pane fade show active"
          id="nav-history"
          role="tabpanel"
          aria-labelledby="nav-history-tab"
        >
          <div class="row">
            <div class="col-md-12">
              <!-- <payment-history :messageson="messageson" @cashmade="updateHistory($event)"></payment-history> -->
              <payment-history :messageson="messageson"></payment-history>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="nav-Cash" role="tabpanel" aria-labelledby="nav-Cash-tab">
          <div class="row">
            <div class="col-md-12">
              <cash-payment @cashmade="updateHistory($event)"></cash-payment>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="nav-Online" role="tabpanel" aria-labelledby="nav-Online-tab">
          <div class="row">
            <div class="col-md-12">
              <online-payment @cashmade="updateHistory($event)"></online-payment>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import onlinePayment from "./onlineComponent.vue";
import paymentHistory from "./paymentHistoryComponent.vue";
import cashPayment from "./cashComponent.vue";
export default {
  data() {
    return {
      messageson: ""
    };
  },
  components: {
    paymentHistory,
    cashPayment,
    onlinePayment
  },
  methods: {
    updateHistory(message) {
      this.messageson = message;
    }
  }
};
</script>