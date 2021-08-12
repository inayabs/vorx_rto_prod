<template>
  <modal
    :name="`size-modal-${course}`"
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

      <div class="row">
        <div class="col-md-12">
          <form @submit.prevent="updateDates">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <date-picker v-model="change_date" :masks="{L:'DD/MM/YYYY'}"></date-picker>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Change Date</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-12">
          <form @submit.prevent="savePayment">
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
                    <a class="btn btn-success" @click="editPayment(index)">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-danger" @click="deletePayment(index)">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2">
                    <input v-model="payments.amount" type="text" class="form-control" />
                    <span
                      v-if="payments.errors.amount"
                      class="badge badge-danger"
                      role="alert"
                    >{{ payments.errors.amount[0] }}</span>
                  </td>
                  <td>
                    <date-picker
                      v-model="payments.date_paid"
                      :max-date="new Date()"
                      :masks="{L:'DD/MM/YYYY'}"
                    ></date-picker>
                    <span
                      v-if="payments.errors.date_paid"
                      class="badge badge-danger"
                      role="alert"
                    >{{ payments.errors.date_paid[0] }}</span>
                  </td>
                  <td>
                    <input v-model="payments.notes" type="text" class="form-control" />
                  </td>
                  <td>
                    <!-- <input v-model="payments.payment_status" type="text" class="form-control" /> -->
                    <select v-model="payments.payment_status" class="form-control">
                      <option value></option>
                      <option
                        v-for="pstatus in payment_status"
                        :key="pstatus.id"
                        :value="pstatus.id"
                      >{{ pstatus.description }}</option>
                      <span
                        v-if="payments.errors.payment_status"
                        class="badge badge-danger"
                        role="alert"
                      >{{ payments.errors.payment_status[0] }}</span>
                    </select>
                  </td>
                  <td>
                    <input v-model="payments.pre_deducted_comm" type="text" class="form-control" />
                  </td>
                  <td>
                    <select v-model="payments.comm_release_status" class="form-control">
                      <option value></option>
                      <option
                        v-for="cstatus in comm_status"
                        :key="cstatus.id"
                        :value="cstatus.id"
                      >{{ cstatus.description }}</option>
                    </select>
                    <span
                      v-if="payments.errors.comm_release_status"
                      class="badge badge-danger"
                      role="alert"
                    >{{ payments.errors.comm_release_status[0] }}</span>
                  </td>
                  <td>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </form>
        </div>
      </div>
    </div>
  </modal>
</template>
<script>
import moment from "moment";
import { mapActions } from "vuex";
export default {
  props: ["course"],

  data() {
    return {
      details: [],
      payment_status: window.payment_status,
      comm_status: window.comm_status,
      template: "",
      change_date: "",
      old_amount: "",
      ol_status: "",
      payments: {
        payment_id: "",
        payment_template: "",
        amount: "",
        date_paid: "",
        notes: "",
        payment_status: "",
        pre_deducted_comm: "",
        comm_release_status: "",
        errors: []
      },
      edit: false
    };
  },
  methods: {
    ...mapActions(["updateCredits"]),
    savePayment(e) {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      if (this.edit) {
        this.$store.dispatch("editCredits", {
          credits: this.old_amount,
          status: this.old_status
        });

        axios
          .post(
            "/offer-letter/course-detail/payment-detail/update",
            this.payments
          )
          .then(response => {
            if (response.data.status == "errors") {
              this.payments.errors = response.data.errors;
            } else if (response.data.status == "message_errors") {
              Toast.fire({
                type: "error",
                title: response.data.message
              });
            } else {
              Toast.fire({
                type: "success",
                title: "Updated Successfuly"
              });
              this.$store.dispatch("updateCredits", {
                credits: this.payments.amount,
                status: this.payments.payment_status
              });

              this.fetchDetails(this.payments.payment_template);
              this.$parent.$parent.$parent.fetchStudentOfferLetter();
              // this.payments.payment_template = "";

              this.payments.amount = "";
              this.payments.date_paid = "";
              this.payments.notes = "";
              this.payments.payment_status = "";
              this.payments.pre_deducted_comm = "";
              this.payments.comm_release_status = "";
              this.payments.errors = [];
              this.old_amount = "";
              this.payment_id = "";
              this.edit = false;
              // this.$modal.hide("size-modal");
            }
          })
          .catch(err => {
            console.log(err);
          });
      } else {
        if (
          this.payments.amount > this.$store.state.payment_credit &&
          this.payments.payment_status == 0
        ) {
          Toast.fire({
            type: "error",
            title: `Credit Limit ( $ ${this.$store.state.payment_credit} )`
          });
        } else {
          axios
            .post("/offer-letter/course-detail/payment-detail", this.payments)
            .then(response => {
              if (response.data.status == "errors") {
                this.payments.errors = response.data.errors;
              } else if (response.data.status == "message_errors") {
                Toast.fire({
                  type: "error",
                  title: response.data.message
                });
              } else {
                Toast.fire({
                  type: "success",
                  title: "Added Successfuly"
                });
                this.$store.dispatch("updateCredits", {
                  credits: this.payments.amount,
                  status: this.payments.payment_status
                });

                this.fetchDetails(this.payments.payment_template);
                this.$parent.$parent.$parent.fetchStudentOfferLetter();
                // this.payments.payment_template = "";

                this.payments.amount = "";
                this.payments.date_paid = "";
                this.payments.notes = "";
                this.payments.payment_status = "";
                this.payments.pre_deducted_comm = "";
                this.payments.comm_release_status = "";
                this.payments.errors = [];
                // this.$modal.hide("size-modal");
              }
            })
            .catch(err => {
              console.log(err);
            });
        }
      }
    },
    deletePayment(detail) {
      let vm = this;
      let editable = vm.details[detail];
      let _id = editable.id;
      vm.old_amount = editable.amount;
      vm.old_status = editable.payment_status_id;
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      swal
        .fire({
          title: "Are you sure ?",
          text: "You wont be able to revert this!",
          type: "warning",
          width: "25%",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            axios
              .delete(`/offer-letter/course-detail/payment-detail/${_id}`)
              .then(response => {
                // console.log(response);
                if (response.data.status == "success") {
                  Toast.fire({
                    type: "success",
                    title: "You deleted successfuly"
                  });
                  this.$store.dispatch("editCredits", {
                    credits: this.old_amount,
                    status: this.old_status
                  });
                  vm.fetchDetails(this.payments.payment_template);
                  this.$parent.$parent.$parent.fetchStudentOfferLetter();
                  this.old_amount = "";
                  this.old_status = "";
                } else {
                  Toast.fire({
                    type: "error",
                    title: response.data.message
                  });
                }
              })
              .catch(error => {
                Toast.fire({
                  type: "error",
                  title: "Deletion failed"
                });
              });
          }
        });
    },
    editPayment(detail) {
      let vm = this;
      let editable = vm.details[detail];
      vm.edit = true;
      console.log(editable);

      this.old_amount = editable.amount;
      this.old_status = editable.payment_status_id;
      vm.payments.amount = editable.amount;
      vm.payments.payment_id = editable.id;
      vm.payments.date_paid = moment(editable.date_paid, "DD-MM-YYYY")._d;
      vm.payments.notes = editable.notes;
      vm.payments.payment_status = editable.payment_status_id;
      vm.payments.pre_deducted_comm = editable.pre_deducted_amount;
      vm.payments.comm_release_status = editable.agent_comm_status_id;
    },
    updateDates() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      let data = {
        due_date: this.change_date,
        template_id: this.payments.payment_template
      };
      axios
        .post("/offer-letter/payment/change_date", data)
        .then(response => {
          this.fetchDetails(this.payments.payment_template);
          this.$parent.$parent.$parent.fetchStudentOfferLetter();
          Toast.fire({
            type: "success",
            title: "Updated Successfuly"
          });
          this.$modal.hide("size-modal");
        })
        .catch(err => {
          console.log(err);
        });
    },
    fetchDetails(detail) {
      let vm = this;
      axios
        .get(`/offer-letter/course-detail/payment-detail/${detail}`)
        .then(response => {
          this.details = response.data.reverse();
        })
        .catch(error => {
          console.log(error);
        });
    },
    beforeOpen(e) {
      let vm = this;
      console.log(e);
      vm.fetchDetails(e.params.payment_detail);
      vm.payments.payment_template = e.params.payment_detail;
    },
    beforeClose(e) {
      this.payments.errors = [];
      this.change_date = "";
    },
    opened(e) {
      // e.ref should not be undefined here
      // console.log('opened', e)
      // console.log('ref', e.ref)
    },
    closed(e) {
      console.log("closed", e);
    }
  }
};
</script>