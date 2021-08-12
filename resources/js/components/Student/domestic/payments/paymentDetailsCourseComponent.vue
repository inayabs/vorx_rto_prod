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
            <th :class="'text-center table-header-' + app_color">Amount</th>
            <th :class="'text-center table-header-' + app_color">
              Payment Date
            </th>
            <th :class="'text-center table-header-' + app_color">Notes</th>
            <th :class="'text-center table-header-' + app_color">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(pd, item) in detail.payment_details" :key="pd.id">
            <td class="text-center" width="5%">{{ pd.id }}</td>
            <td class="text-right" width="20%">
              <span>{{ pd.amount }}</span>
            </td>
            <td class="text-center" width="20%">
              {{ formatDate(pd.payment_date) }}
            </td>
            <td class="text-left" width="40%">{{ pd.note }}</td>
            <td class="text-center" width="10%">
              <div class="btn-group" slot="actions">
              <!-- <div class="dropdown"> -->
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" :id="'dropdownMenuButton-'+pd.id" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </button>
                <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="'dropdownMenuButton-'+pd.id">
                  <a v-if="roles != 'Staff'"  href="javascript:void(0)" class="dropdown-item" title="Edit Payment" @click="editPayment(item, pd.id)">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="javascript:void(0)" class="dropdown-item" title="Attachment"  @click="attachfile($event,item)">
                    <i class="fa fa-paperclip"></i> Attachment
                  </a>
                  <input accept="image/*" ref="fileInput" @change="UploadFile(item,$event)" type="file" style="display:none" />
                  <a v-if="pd.attachment != null " target="_blank" :href="`/payment_attachment/${pd.attachment.id}`" class="dropdown-item" title="View Attachment" click="viewFile(pd.attachment)">
                    <i class="fa fa-eye"></i> View Attachment
                  </a>
                  <a @click="viewPaymentReceipt(pd.id)" target="_blank" class="dropdown-item" title="View Payment Receipt" v-if="app_settings.training_organisation_id === '45633' && roles != 'Staff'">
                    <i class="fa fa-envelope-open"></i> View Payment Receipt
                  </a>
                  <a  @click="sendPaymentReceipt(pd.id)" class="dropdown-item" title="Send Payment Receipt" v-if="app_settings.training_organisation_id === '45633' && roles != 'Staff'">
                    <i class="fa fa-paper-plane"></i> Send Payment Receipt<span v-if="pd.sent_receipt === 1" class="float-right"><i class="fa fa-check text-success"></i></span>
                  </a>
                  <a v-if="roles != 'Staff'"
                    href="javascript:void(0)"
                    class="dropdown-item"
                    title="Delete Payment"
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
            <td class="text-center" width="20%">
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
            <td class="text-center" width="20%">
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
            <td class="text-center" width="40%">
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
            <td class="text-center" width="10%">
              <div class="btn-group" slot="actions">
                <a
                 v-if="roles != 'Staff'"
                  href="javascript:void(0)"
                  @click="savePayment(detail.id)"
                  class="btn btn-success btn-sm"
                >
                  <span v-if="payment_details.edit == true"> Update </span>
                  <span v-else><i class="fas fa-plus"></i> Add </span>
                </a>
                  <a
                 v-else
                  href="javascript:void(0)"
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
          </tr>
        </tfoot>
      </table>
    </form>
    <div class="clearfix"></div>
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
              <button class="btn btn-warning btn-sm" @click="edit_due(detail)"><i class="fas fa-pencil-alt"></i></button>
            </span>
            <span v-else>
              <button class="btn btn-success btn-sm" @click="save_due(edit_due_date['payment_'+detail.id])"><i class="fas fa-check"></i></button>
            </span>
            </center>
          </td>
        </tr>
      </tbody>
    </table>
    <br />
  </div>
</template>

<script>
import moment from "moment";
export default {
  props: ["detail"],
  data() {
    return {
      demoUser: window.demoUser,
      stud_info: {},
      course_payments: [],
      // course_invoice: [],
      edit_due_date : {},
      payment_details: {
        id: "",
        note: "",
        payment_date: "",
        amount: "",
        course_id: "",
        errors: [],
        edit: false,
      },
      invoice: {
        course_code: "",
        date: "",
        due_date: "",
        invoice_number: "",
      },
      errors: [],
      app_color: app_color,
      app_settings: window.app_settings,
      roles : null,
      // totalAmount: '',
      // balanceFee: '',
    };
  },
  mounted() {
     if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  created() {
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
         this.$parent.fetchData();

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
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      let vm = this;
      if (vm.payment_details.amount > parseInt(this.getBalanceFee())) {
        Toast.fire({
          type: "error",
          title: "Opss.. failed to add payment",
          position: "top-end",
        });
      } else {
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
            if (response.data.status == "errors") {
              this.payment_details.errors = response.data.errors;
              Toast.fire({
                type: "error",
                title: "Opss.. failed to add payment",
                position: "top-end",
              });
            } else if (response.data.status == "success") {
              this.payment_details.errors = [];
              this.payment_details.id = "";
              this.payment_details.note = "";
              this.payment_details.payment_date = "";
              this.payment_details.amount = "";
              this.payment_details.course_id = "";
              this.payment_details.edit = false;
              this.success = true;
              Toast.fire({
                type: "success",
                title: "Data is saved successfully",
                position: "top-end",
              });
              this.$parent.fetchData();
            }
            console.log(response);
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    editPayment(item, payment_detail_id) {
      let vm = this;
      vm.payment_details.id = this.detail.payment_details[item].id;
      vm.payment_details.note = this.detail.payment_details[item].note;
      vm.payment_details.payment_date = moment(
        this.detail.payment_details[item].payment_date,
        "YYYY-MM-DD"
      )._d;
      vm.payment_details.amount = this.detail.payment_details[item].amount;
      vm.payment_details.edit = true;
    },
    remove(item, payment_detail_id) {
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
};
</script>