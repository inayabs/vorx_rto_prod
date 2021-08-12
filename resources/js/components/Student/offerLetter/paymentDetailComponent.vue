<template>
  <div>
    <!-- <add-payment :course="course"></add-payment> -->
    <div class="col-md-12 pull-right mb-2 text-right">
      <!-- <button
        @click="resetPayment"
        class="btn btn-warning"
        style="display: inline-block"
      >
        <i class="fas fa-recycle"></i> Reset Payment Schedule
      </button> -->
      <button class="btn btn-success">
        Remaining Balance : $ {{ balance() }}
      </button>
    </div>
  
    <table
      :class="'table table-bordered payment-table header-' + app_color"
      id="dataTable"
      width="100%"
      cellspacing="0"
    >
      <thead>
        <tr>
          <th :class="'text-center table-header-' + app_color">#</th>
          <th :class="'text-center table-header-' + app_color">Notes</th>
          <th :class="'text-center table-header-' + app_color">Date Paid</th>
          <th :class="'text-center table-header-' + app_color">Amount Paid</th>
          <th :class="'text-center table-header-' + app_color">
            Pre-Deducted Commision
          </th>
          <th :class="'text-center table-header-' + app_color">
            Commision Release Status
          </th>
          <th :class="'text-center table-header-' + app_color">Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- <tr v-if="details.length == 0">
          <td></td>
        </tr>-->
        <tr v-for="(payment, index) in details" :key="payment.id">
          <td width="5%" class="text-center">{{ index + 1 }}</td>
          <td class="text-center">{{ payment.note }}</td>
          <td class="text-center">{{ payment.payment_date | getDate }}</td>
          <td class="text-center">{{ payment.amount }}</td>
          <td class="text-center">{{ payment.pre_deduc_comm }}</td>
          <td class="text-center">
            {{ payment.comm_release_status | getStatus }}
          </td>
          <td width="10%" class="text-center">
            <div class="btn-group" slot="actions">
            <!-- <div class="dropdown"> -->
              <button class="btn btn-primary btn-sm dropdown-toggle" type="button" :id="'dropdownMenuButton-'+payment.id" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
              </button>
              <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="'dropdownMenuButton-'+payment.id">
                <a v-if="roles != 'Staff'" href="javascript:void(0)" class="dropdown-item" title="Edit Payment" @click="editPayment(index, payment.id)">
                  <i class="fas fa-edit"></i> Edit
                </a>
                <a  href="javascript:void(0)" class="dropdown-item" title="Attachment"  @click="attachfile($event,index)">
                  <i class="fa fa-paperclip"></i> Attachment
                </a>
                <input accept="image/*" ref="fileInput" @change="UploadFile(index,$event)" type="file" style="display:none" />
                <a v-if="payment.attachment != null " target="_blank" :href="`/payment_attachment/${payment.attachment.id}`" class="dropdown-item" title="View Attachment" click="viewFile(payment.attachment)">
                  <i class="fa fa-eye"></i> View Attachment
                </a>
                <a @click="viewPaymentReceipt(payment.id)" target="_blank" class="dropdown-item" title="View Payment Receipt" v-if="app_settings.training_organisation_id === '45633'">
                  <i class="fa fa-envelope-open"></i> View Payment Receipt
                </a>
                <a  @click="sendPaymentReceipt(payment.id)" class="dropdown-item" title="Send Payment Receipt" v-if="app_settings.training_organisation_id === '45633'">
                  <i class="fa fa-paper-plane"></i> Send Payment Receipt<span v-if="payment.sent_receipt === 1" class="float-right"><i class="fa fa-check text-success"></i></span>
                </a>
                <a v-if="roles != 'Staff'"
                  href="javascript:void(0)"
                  class="dropdown-item"
                  title="Delete Payment"
                  @click="remove(index, payment.id)"
                >
                  <i class="fas fa-trash"></i> Delete
                </a>
              </div>
            <!-- </div> -->
          </div>
            <!-- <div class="btn-group" slot="actions">
              <div class="btn-group" slot="actions">
              <button class="btn btn-info" @click="attachfile($event,index)"><i class="fas fa-paperclip"> </i></button>
              <a v-if="payment.attachment != null " target="_blank" :href="`/payment_attachment/${payment.attachment.id}`" class="btn btn-warning" @click="viewFile(payment.attachment)"><i class="fas fa-eye"> </i></a>
              <input accept="image/*" ref="fileInput" @change="UploadFile(index,$event)" type="file" style="display:none" />
                <a
                  href="javascript:void(0)"
                  class="btn btn-primary btn-sm"
                  @click="editPayment(index, payment.id)"
                >
                  <i class="fas fa-edit"></i>
                </a>
                <a
                  href="javascript:void(0)"
                  class="btn btn-danger btn-sm text-white"
                  @click="remove(index, payment.id)"
                >
                  <i class="fas fa-trash"></i>
                </a>
              </div>
            </div> -->
          </td>
        </tr>
        <tr>
          <td class="text-center">#</td>
          <td class="text-center">
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
              >{{ payment_details.errors.note[0] }}</span
            >
          </td>
          <td class="text-center">
            <date-picker
              v-model="payment_details.payment_date"
              v-on:keyup="onKeyUp"
              :max-date="new Date()"
            ></date-picker>
            <span
              v-if="payment_details.errors.payment_date"
              class="badge badge-danger"
              role="alert"
              >{{ payment_details.errors.payment_date[0] }}</span
            >
          </td>
          <td class="text-center">
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
              >{{ payment_details.errors.amount[0] }}</span
            >
          </td>
          <td class="text-center">
            <input
              v-model="payment_details.pre_deduc_comm"
              v-on:keyup="onKeyUp"
              type="text"
              class="form-control"
              value
            />
            <span
              v-if="payment_details.errors.pre_deduc_comm"
              class="badge badge-danger"
              role="alert"
              >{{ payment_details.errors.pre_deduc_comm[0] }}</span
            >
          </td>
          <td class="text-center">
            <select
              v-model="payment_details.comm_release_status"
              class="form-control"
            >
              <option value></option>
              <option
                v-for="cstatus in comm_status"
                :key="cstatus.id"
                :value="cstatus.id"
              >
                {{ cstatus.description }}
              </option>
            </select>
            <span
              v-if="payment_details.errors.comm_release_status"
              class="badge badge-danger"
              role="alert"
              >{{ payment_details.errors.comm_release_status[0] }}</span
            >
          </td>
          <td class="text-center">
            <div class="btn-group" slot="actions">
              <a v-if="roles == 'Staff'"
                href="javascript:void(0)" 
                class="btn btn-success btn-sm"
              >
                <span v-if="payment_details.edit == true"> Update </span>
                <span v-else><i class="fas fa-plus"></i> Add </span>
              </a>
              <a v-else
                href="javascript:void(0)"
                
                @click="savePayment()"
                class="btn btn-success btn-sm"
              >
                <span v-if="payment_details.edit == true"> Update </span>
                <span v-else><i class="fas fa-plus"></i> Add </span>
              </a>
            </div>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" align="center">Total</td>
          <td align="right">$ {{ totalPaid() }}</td>
          <td></td>
          <td></td>
        </tr>
      </tfoot>
    </table>

    <div class="clearfix mb-5"></div>
    <hr />
    <table :class="'table table-bordered payment-table header-' + app_color">
      <thead>
        <tr>
          <th :class="'table-header-' + app_color">#</th>
          <th :class="'table-header-' + app_color">Due Date</th>
          <th :class="'table-header-' + app_color">Amount</th>
          <th :class="'table-header-' + app_color">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(detail, index) in payment_template" :key="detail.id">
          <td>{{ index + 1 }}</td>
          <td class="text-center">
            <span v-if="typeof edit_due_date['payment_'+detail.id] === 'undefined'">
              {{ detail.due_date | getDate }}
            </span>
            <span v-else>
              <date-picker
                v-model="edit_due_date['payment_'+detail.id].due_date"
                v-on:keyup="onKeyUp"
                :masks="{L:'DD/MM/YYYY'}"
                :max-date="new Date()"
              ></date-picker>
            </span>
          </td>
          <td class="text-right">
            <span v-if="typeof edit_due_date['payment_'+detail.id] === 'undefined'">
              {{ detail.payable_amount }}
            </span>
            <span v-else>
              <input
                v-model="edit_due_date['payment_'+detail.id].payable_amount"
                v-on:keyup="onKeyUp"
                type="text"
                class="form-control"
                value
              />
            </span>
          </td>
          <td>
            <center>
            <span v-if="typeof edit_due_date['payment_'+detail.id] === 'undefined'">
              <button :disabled="roles == 'Staff'? true : false " class="btn btn-warning btn-sm" @click="edit_due(detail)"><i class="fas fa-pencil-alt"></i></button>
            </span>
            <span v-else>
              <button :disabled="roles == 'Staff'? true : false " class="btn btn-success btn-sm" @click="save_due(edit_due_date['payment_'+detail.id])"><i class="fas fa-check"></i></button>
            </span>
            </center>
          </td>
        </tr>
      </tbody>
    </table>
      
  </div>
</template>
<script>
import moment from "moment";
export default {
  props: ["details", "course", "balance_due"],
  data() {
    return {
      app_color: app_color,
      app_settings: window.app_settings,
      comm_status: window.comm_status,
      payment_template: [],
      edit_due_date : {},
      roles : null,
      payment_details: {
        id: "",
        offer_letter_course_detail_id: "",
        note: "",
        amount: "",
        pre_deduc_comm: "",
        payment_date: "",
        comm_release_status: "",
        student_id: window.student_id,
        errors: [],
        edit: false,
      },
    };
  },
  created() {
    this.getTemplate();
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
    viewPaymentReceipt(id) {
      window.open(
        `/student/payment-receipt/preview/${id}`,
        "_blank"
      );
    },
    sendPaymentReceipt(id) {
      // Confirmation    
            swal.fire({
                title: 'Are you sure?',
                text: "This will send payment receipt to student.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.value) {
                    // // Loading Alert
                    swal.fire({
                        title: 'Sending Email',
                        html: 'Please wait...', // add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            swal.showLoading()
                        },
                    });
                    // Sending Email 
                    axios({
                        method: 'get',
                        url: `/student/payment-receipt/${student_id}/${id}/send`,
                    }).then(response => {
                      // console.log(response);
                        if (response.data.status == 'success') {
                            swal.fire({
                                title: 'Email sent!',
                                type: 'success',
                                timer: 3000,
                                showConfirmButton: false
                            })
                        } else {
                            Toast.fire({
                                position: 'top-end',
                                type: 'error',
                                title: 'Opss.. email was not sent',
                            });
                        }

                    });
                }
            });
    },
    UploadFile(index,event){
      swal.fire({
        title: "Updating Payment Detail...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      let vm = this;
      const files = event.target.files
      let filename = files[0].name
      const fileReader = new FileReader()
      fileReader.addEventListener('load', () => {
        this.imageUrl = fileReader.result
      })
      fileReader.readAsDataURL(files[0])
      let formData = new FormData();
      formData.append('payment_id',this.details[index].id)
      
      formData.append('payment_attachment',files[0])
      axios.post('/payment_attachment',formData,{
        headers: {
          'Content-Type' : 'multipart/form-data'
        }
      }).then(res=>{
         if(res.data.status == 'success') {
          Toast.fire({
            type: "success",
            position:'top-end',
            title: "Attachment added Successfuly",
          });
         }

      }).catch(err=>{
         if(res.data.status == 'success') {
          Toast.fire({
            type: "warning",
            position : 'top-end',
            title: "Payment Schedule Detail error",
          });
         }
      })
      vm.$parent.$parent.fetchStudentOfferLetter();
    },

    attachfile($event,index){
      const elem = this.$refs.fileInput
      elem[index].click();
      // console.log(elem);
    },
    edit_due(detail) {
      detail.due_date = moment(detail.due_date)._d;
      this.edit_due_date['payment_'+detail.id] = detail;
    },
    save_due(detail) {
      let vm = this;
      // console.log('saving')
      // console.log(detail)
      swal.fire({
        title: "Updating Payment Detail...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });

      axios.post('/student/payment-sched-detail/detail',{
        'detail': detail
      })
      .then(function (res) {
        if(res.data.status == 'success') {
          Toast.fire({
            type: "success",
            title: "Payment Schedule Detail Updated Successfuly",
          });
          vm.payment_template = res.data.payment_template;
          delete vm.edit_due_date['payment_'+detail.id];
        }else{
          Toast.fire({
            type: "error",
            title: "there seems to be a problem...",
          });
        }
      })
    },
    resetPayment() {
      let payments = this.details;
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
            swal.fire({
              title: "Please wait...",
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                swal.showLoading();
              },
            });
            if (result.value) {
              let id = this.payment_template[0].offer_letter_course_detail_id;
              axios
                .delete(`/offer-letter/payment/reset/${id}`)
                .then((response) => {
                  // console.log(response.data);
                  if (response.data.status == "success") {
                    Toast.fire({
                      type: "success",
                      title: "Updated Successfuly",
                    });
                    this.getTemplate();
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
        let id = this.payment_template[0].offer_letter_course_detail_id;
        swal.fire({
          title: "Please wait...",
          // html: '',// add html attribute if you want or remove
          allowOutsideClick: false,
          onBeforeOpen: () => {
            swal.showLoading();
          },
        });
        axios
          .delete(`/offer-letter/payment/reset/${id}`)
          .then((response) => {
            console.log(response.data.status);
            let res = response.data;
            if (res.status === "success") {
              // this.getData();
              this.getTemplate();
              Toast.fire({
                type: "success",
                position: "top-end",
                title: "Updated Successfuly",
              });
            } else {
              Toast.fire({
                type: "error",
                position: "top-end",
                title: "Something went wrong xxx",
              });
            }
          })
          .catch((err) => {
            console.log(err);
            Toast.fire({
              type: "error",
              position: "top-end",
              title: "Something went wrong .....",
            });
          });
      }
    },
    getTemplate() {
      let vm = this;
      axios
        .get(`/payment/detail/${this.$vnode.key}`)
        .then((response) => {
          vm.payment_template = response.data;
          // console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    savePayment(payement_id) {
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      let vm = this;
      if (vm.payment_details.amount > parseInt(vm.balance())) {
        Toast.fire({
          type: "error",
          position: "top-end",
          title: "Invalid Amount",
        });
      } else {
        vm.payment_details.offer_letter_course_detail_id = vm.$vnode.key;
        if (vm.payment_details.payment_date !== "") {
          vm.payment_details.payment_date = moment(
            vm.payment_details.payment_date
          ).format("YYYY-MM-DD");
        }
        axios
          .post(
            "/offer-letter/course-detail/payment-detail",
            this.payment_details
          )
          .then((response) => {
            if (response.data.status == "errors") {
              this.payment_details.errors = response.data.errors;
              Toast.fire({
                type: "error",
                position: "top-end",
                title: "Fail to add student",
              });
            } else {
              vm.payment_details.id = "";
              vm.payment_details.note = "";
              vm.payment_details.offer_letter_course_detail_id = "";
              vm.payment_details.payment_date = "";
              vm.payment_details.pre_deduc_comm = "";
              vm.payment_details.amount = "";
              vm.payment_details.comm_release_status = "";
              vm.payment_details.edit = false;
              vm.$parent.$parent.fetchStudentOfferLetter();
              Toast.fire({
                type: "success",
                position: "top-end",
                title: "Added Successfuly",
              });
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    editPayment(index, payement_id) {
      let vm = this;
      vm.payment_details.id = this.details[index].id;
      vm.payment_details.note = this.details[index].note;
      vm.payment_details.offer_letter_course_detail_id = this.details[
        index
      ].offer_letter_course_detail_id;
      vm.payment_details.payment_date = moment(
        this.details[index].payment_date,
        "YYYY-MM-DD"
      )._d;
      vm.payment_details.pre_deduc_comm = this.details[index].pre_deduc_comm;
      vm.payment_details.amount = this.details[index].amount;
      vm.payment_details.comm_release_status = this.details[
        index
      ].comm_release_status;
      vm.payment_details.edit = true;
    },
    remove(index, payement_id) {
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
              url: `/student/domestic/${window.student}/delete/${payement_id}`,
            })
              .then((res) => {
                // let i = this.fullfee_course[index].payment_details.map(item => item).indexOf(payment_detail_id) // find index of your object
                this.details.splice(index, 1);
                if (res.data.status == "success") {
                  Toast.fire({
                    type: "success",
                    title: "Data is deleted successfully",
                  });
                } else {
                  Toast.fire({
                    type: "error",
                    title: "Opss.. data was not deleted",
                  });
                }
              })
              .catch((err) => console.log(err));
          }
        });
    },
    totalPaid() {
      let sum = this.details
        .map((q) => parseInt(q.amount))
        .reduce(function (total, q) {
          return total + q;
        }, 0);
      // return sum.toFixed(2);
      return sum.toFixed(2);
    },
    balance() {
      let b = parseInt(this.balance_due) - parseInt(this.totalPaid());
      return b.toFixed(2);
    },
    onKeyUp() {
      // console.log(this.payment_details.errors);
      this.payment_details.errors = [];
    },
  },
  filters: {
    getStatus(element) {
      let status = "";
      window.comm_status.find((e) => {
        if (e.id == element) {
          status = e.description;
        }
      });
      return status;
    },
    getDate(element) {
      return moment(element).format("DD/MM/YYYY");
    },
  },
};
</script>
<style scoped>
.dropdown-menu {
  width: 250px!important;
}
</style>