<template>
  <div>
    <h4 class="float-right">
      Remaining Balance:
      <b>
        $
        <span>{{ getBalanceFee() }}</span>
      </b>
    </h4>
    <div class="clearfix" style="height: 10px"></div>
    <form @submit.prevent>
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
            <th :class="'text-center table-header-' + app_color">
              Payment Date
            </th>
            <th :class="'text-center table-header-' + app_color">Amount</th>
            <th :class="'text-center table-header-' + app_color">Pre-Deducted Commision</th>
            <th :class="'text-center table-header-' + app_color">Commision Release Status</th>
            <th :class="'text-center table-header-' + app_color">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(pd, item) in detail.payment_details" :key="pd.id">
            <td class="text-center" width="5%">{{ item + 1 }}</td>
            <td class="text-left" width="25%">{{ pd.note }}</td>
            <td class="text-center" width="15%">
              {{ formatDate(pd.payment_date) }}
            </td>
            <td class="text-right" width="15%">
              <span>{{ pd.amount }}</span>
            </td>
            <td class="text-center" width="15%">{{ pd.pre_deduc_comm }}</td>
            <td class="text-center" width="15%">
              {{ pd.comm_release_status | getStatus }}
            </td>
            <td class="text-center" width="10%">
              <div class="btn-group" slot="actions">
              <!-- <div class="dropdown"> -->
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" :id="'dropdownMenuButton-'+pd.id" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </button>
                <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="'dropdownMenuButton-'+pd.id">
                  <a href="javascript:void(0)" class="dropdown-item" title="Edit Payment" @click="editPayment(item, pd.id)">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="javascript:void(0)" class="dropdown-item" title="Attachment"  @click="attachfile($event,item)">
                    <i class="fa fa-paperclip"></i> Attachment
                  </a>
                  <input accept="image/*" ref="fileInput" @change="UploadFile(item,$event)" type="file" style="display:none" />
                  <a v-if="pd.attachment != null " target="_blank" :href="`/payment_attachment/${pd.attachment.id}`" class="dropdown-item" title="View Attachment" click="viewFile(pd.attachment)">
                    <i class="fa fa-eye"></i> View Attachment
                  </a>
                  <a @click="viewPaymentReceipt(pd.id)" target="_blank" class="dropdown-item" title="View Payment Receipt" v-if="app_settings.training_organisation_id === '45633'">
                    <i class="fa fa-envelope-open"></i> View Payment Receipt
                  </a>
                  <a  @click="sendPaymentReceipt(pd.id)" class="dropdown-item" title="Send Payment Receipt" v-if="app_settings.training_organisation_id === '45633'">
                    <i class="fa fa-paper-plane"></i> Send Payment Receipt<span v-if="pd.sent_receipt === 1" class="float-right"><i class="fa fa-check text-success"></i></span>
                  </a>
                  <a
                    href="javascript:void(0)"
                    class="dropdown-item"
                    title="Delete Payment"
                    :disabled="roles == 'Staff'? true : false "
                    @click="remove(item, pd.id)"
                  >
                    <i class="fas fa-trash"></i> Delete
                  </a>
                </div>
              <!-- </div> -->
            </div>
              <!-- <div class="btn-group" slot="actions">
                <a href="javascript:void(0)" class="btn btn-info btn-sm" @click="attachfile($event,item)" title="Attach Receipt"><i class="fas fa-paperclip"> </i></a>
                <a v-if="pd.attachment != null " target="_blank" :href="`/payment_attachment/${pd.attachment.id}`" class="btn btn-warning btn-sm" @click="viewFile(pd.attachment)" title="View Attachment"><i class="fas fa-eye"> </i></a>
                <input accept="image/*" ref="fileInput" @change="UploadFile(item,$event)" type="file" style="display:none" />
                  <a
                    href="javascript:void(0)"
                    class="btn btn-primary btn-sm"
                    @click="editPayment(item, pd.id)"
                    title="Edit Payment"
                  >
                    <i class="fas fa-edit"></i>
                  </a>
                  <a
                    href="javascript:void(0)"
                    class="btn btn-danger btn-sm text-white"
                    @click="remove(item, pd.id)"
                    title="Delete Payment"
                  >
                    <i class="fas fa-trash"></i>
                  </a>
                </div> -->
            </td>
          </tr>
          <tr>
            <td class="text-center" width="5%">#</td>
            <td class="text-center" width="25%">
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
            <td class="text-center" width="15%">
              <!-- <date-picker v-model="payment_details.payment_date" v-on:keyup="onKeyUp" :max-date="new Date()"></date-picker>  -->
              <date-picker
                :popover="{ placement: 'bottom', visibility: 'click' }"
                v-model="payment_details.payment_date"
                v-on:keyup="onKeyUp"
                mode="single"
                locale="en"
                :masks="{ L: 'DD/MM/YYYY', data: 'DD/MM/YYYY' }"
              ></date-picker>
              <span
                v-if="payment_details.errors.payment_date"
                class="badge badge-danger"
                role="alert"
                >{{ payment_details.errors.payment_date[0] }}</span
              >
            </td>
            <td class="text-center" width="15%">
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
            <td class="text-center" width="15%">
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
          <td class="text-center" width="15%">
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
            <td class="text-center" width="10%">
              <div class="btn-group" slot="actions">
                <a
                :disabled="roles == 'Staff'? true : false "
                  href="javascript:void(0)"
                  @click="savePayment(detail.id)"
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
            <td colspan="4">
              <h4 class="float-right">
                Total:
                <b>
                  $
                  <span>{{ getTotalAmount() }}</span
                  >.00
                </b>
              </h4>
            </td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </form>
    <div class="clearfix"></div>
    <table :class="'table table-bordered payment-table header-' + app_color" v-if="this.detail.payment_sched.length > 0">
      <thead>
        <tr>
          <th :class="'table-header-' + app_color">#</th>
          <th :class="'table-header-' + app_color">Due Date</th>
          <th :class="'table-header-' + app_color">Amount</th>
          <th :class="'table-header-' + app_color">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(detail, index) in this.detail.payment_sched"
          :key="detail.id"
        >
          <td>{{ index + 1 }}</td>
          <td class="text-center">
            <span v-if="typeof edit_due_date['payment_'+detail.id] === 'undefined'">
              {{ formatDate(detail.due_date) }}
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
    <br />
    <div v-if="demoUser == false">
          <div v-for="(ci, item) in invoice" :key="item">
            <!-- ci.student_id == ff.student_id && -->
            <div
              class="row"
              v-if="
                ci.course_code == detail.course_code &&
                ci.student_id == detail.student_id
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
                    @click="updateInvoice(ci.course_code)"
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
            </div>
          </div>
        </div>
    <br>
  </div>
</template>

<script>
import moment from "moment";
import { mapGetters, mapMutations } from "vuex";
export default {
  props: ["detail"],
  data() {
    return {
      roles : null,
      demoUser: window.demoUser,
      // stud_info: {},
      course_payments: [],
      // course_invoice: [],
      edit_due_date : {},
      payment_details: {
        id: "",
        offer_letter_course_detail_id: "",
        note: "",
        payment_date: "",
        amount: "",
        course_id: "",
        pre_deduc_comm: "",
        comm_release_status: "",
        student_id: window.student_id,
        errors: [],
        edit: false,
      },
      // invoice: {
      //   course_code: "",
      //   date: "",
      //   due_date: "",
      //   invoice_number: "",
      // },
      errors: [],
      app_color: app_color,
      app_settings: window.app_settings,
      comm_status: window.comm_status,
      // totalAmount: '',
      // balanceFee: '',
    };
  },
  computed : {
        invoice(){
          let i = this.$store.getters.invoice;
          i.map((element, key) => {
              if(this.detail.course_code == element.course_code ){
                  if(element.date != null && typeof element.date !== 'undefined') {
                    element.date = moment(element.date)._d;
                  }
                  if (element.due_date != null && typeof element.due_date !== 'undefined') {
                    element.due_date = moment(element.due_date)._d;
                  }
              }
              })
              return i;
            }
        },
  mounted(){
    if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  methods: {
    // ...mapMutations(['updatePayment']),
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
      const files = event.target.files
      let filename = files[0].name
      const fileReader = new FileReader()
      fileReader.addEventListener('load', () => {
        this.imageUrl = fileReader.result
      })
      fileReader.readAsDataURL(files[0])
      let formData = new FormData();
      formData.append('payment_id',this.detail.payment_details[index].id)
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
          vm.detail.payment_sched = res.data.payment_template;
          delete vm.edit_due_date['payment_'+detail.id];
        }else{
          Toast.fire({
            type: "error",
            title: "there seems to be a problem...",
          });
        }
      })
    },
    getTotalAmount() {
      let vm = this;
      var sum = vm.detail.payment_details
        .map((q) => parseInt(q.amount))
        .reduce(function (total, q) {
          return total + q;
        }, 0);
      return sum;
    },
    getBalanceFee() {
      let vm = this;
      let cf = vm.detail.course_fee;

      if (vm.detail.payment_details.length == 0) {
        var bal = cf;
      } else {
        var bal = cf - this.getTotalAmount();
        bal = bal + ".00";
      }
      return bal;
    },
    savePayment(course_id) {
      // console.log(course_id);
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      let vm = this;
      if(vm.roles != 'Staff'){
        if (vm.payment_details.amount > parseInt(this.getBalanceFee())) {
          Toast.fire({
            type: "error",
            title: "Opss.. failed to add payment",
            position: "top-end",
          });
        } else {
          vm.payment_details.offer_letter_course_detail_id = vm.detail.offer_letter_course_detail_id;
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
              // console.log(response);
              // console.log(course_id);
              if (response.data.status == "errors") {
                this.payment_details.errors = response.data.errors;
                Toast.fire({
                  type: "error",
                  title: "Opss.. failed to add payment",
                  position: "top-end",
                });
              } else if (response.data.status == "success") {
                if(response.data.data == false || vm.payment_details.edit == false){
                  vm.detail.payment_details.push(response.data.data);
                }else{
                  if(vm.detail.payment_details.length > 0){
                    vm.detail.payment_details.map((element, key) => {
                      if(element.id == response.data.data.id){
                        // element = response.data.data;
                        element.note = response.data.data.note;
                        element.payment_date = response.data.data.payment_date;
                        element.amount = response.data.data.amount;
                        element.pre_deduc_comm = response.data.data.pre_deduc_comm;
                        element.comm_release_status = response.data.data.comm_release_status;
                      }
                    })
                  }
                }
                vm.payment_details.errors = [];
                vm.payment_details.id = "";
                vm.payment_details.offer_letter_course_detail_id = "";
                vm.payment_details.note = "";
                vm.payment_details.payment_date = "";
                vm.payment_details.amount = "";
                vm.payment_details.course_id = "";
                vm.payment_details.pre_deduc_comm = "";
                vm.payment_details.comm_release_status = "";
                vm.payment_details.edit = false;
                vm.success = true;
                Toast.fire({
                  type: "success",
                  title: "Data is saved successfully",
                  position: "top-end",
                });
                // vm.updatePayment(vm.detail);
              //this.$parent.fetchData();

              }
            })
            .catch((error) => {
              console.log(error);
            });
        }
      }else{
        Toast.fire({
          type: "error",
          title: "Opss.. Not Authorized",
          position: "top-end",
        });
      }


    },
    editPayment(item, payment_detail_id) {
      // console.log(payment_detail_id);

      let vm = this;

      if(vm.roles != 'Staff'){
        vm.payment_details.id = this.detail.payment_details[item].id;
        vm.payment_details.note = this.detail.payment_details[item].note;
        vm.payment_details.payment_date = moment(
          this.detail.payment_details[item].payment_date,
          "YYYY-MM-DD"
        )._d;
        vm.payment_details.amount = this.detail.payment_details[item].amount;
        vm.payment_details.pre_deduc_comm = this.detail.payment_details[item].pre_deduc_comm;
        vm.payment_details.comm_release_status = this.detail.payment_details[item].comm_release_status;
        vm.payment_details.edit = true;
      }else{
        Toast.fire({
          type: "error",
          title: "Opss.. Not Authorized",
          position: "top-end",
        });
      }

    },
    remove(item, payment_detail_id) {
      let vm = this;
      if(vm.roles != 'Staff'){
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

            if (result.value === true) {
              axios({
                method: "delete",
                url: `/student/domestic/${window.student}/delete/${payment_detail_id}`,
              })
                .then((res) => {
                  // let i = this.course_payments[index].payment_details.map(item => item).indexOf(payment_detail_id) // find index of your object
                  this.detail.payment_details.splice(item, 1);
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
      }else{
        Toast.fire({
          type: "error",
          title: "Opss.. Not Authorized",
          position: "top-end",
        });
      }

    },
    updateInvoice(course_code) {
      let vm = this;
      let _date = null;
      let _due_date = null;
      let _invoice_num = null;

      vm.invoice.forEach((ci) => {
        if (
          vm.detail.student_id == ci.student_id &&
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
        student_id: vm.detail.student_id,
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
                console.log(res);
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
      generateInvoiceNum(course_code) {
      let vm = this;
      //generate 12 digits random number
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
          vm.detail.student_id == ci.student_id &&
          course_code == ci.course_code
        ) {
          ci.invoice_number = randomChar;
        }
      });
      // return `00${randomNum}`;
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
