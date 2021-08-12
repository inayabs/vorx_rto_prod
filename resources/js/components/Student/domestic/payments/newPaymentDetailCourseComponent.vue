<template>
    <div>
        <adjust-date-modal />
        <verify-collection :data="trxn"/>
        <div class="float-left">
        <p>
                <a class="collapse-menu active p-1 pl-2 pr-2 m-1 paymentPlanH" type="button" data-toggle="collapse" @click="closeOther('paymentPlan','paymentPlanH')" href=".paymentPlan" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-scroll"></i> Payment Plan
                </a>
                <a class="collapse-menu p-1 pl-2 pr-2 m-1 addPaymentH" type="button" data-toggle="collapse"  @click="closeOther('addPayment','addPaymentH')" href=".addPayment" aria-expanded="false" aria-controls="collapseExample1">
                    <i class="fas fa-plus"></i> Add Payment
                </a>
               
        </p>
        </div>
        <div class="float-right">
            <h5 v-show="menuchoicer == 'addPaymentH'">
                Remaining Balance: $ <span>{{ balance.toFixed(2) }}</span>
            </h5>
            <h5 v-show="menuchoicer == 'paymentPlanH'">
                Total Paid: $ <span>{{ paid }}</span>
            </h5>
        </div>
        <div class="clearfix"></div>
        <div class="collapse show collapse-menu-body paymentPlan">
        <div class="card card-body">
            <table
                class="custom-table"
                id="dataTable"
                width="100%"
                cellspacing="0"
            >
            <thead>
                <tr>
                    <th class='text-center'>
                     
                    </th>
                    <th class='text-center'>Month</th>
                    <th class='text-center'>Amount Due</th>
                    <th class='text-center'>Recomended Pay Date</th>
                    <!-- <th class='text-center'>Amount Paid</th> -->
                    <!-- <th class='text-center'>Post Date</th> -->
                    <th class='text-center'></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(sched,index) in payment_sched" :key="index"> 
                    <td class='text-center'>
                      <div v-if=" remainingBalance[index] == 'danger'" >
                          <i class="fas fa-check-circle"></i>
                      </div>
                      <div v-else-if="remainingBalance[index] == 'bad'" >
                        <i class="fas fa-check-circle danger" style="color:red" data-toggle="tooltip" data-placement="top" title="partial payment below 50%"></i>
                      </div>
                      <div v-else-if="remainingBalance[index] == 'good'" >
                        <i class="fas fa-check-circle" style="color:yellow" data-toggle="tooltip" data-placement="top" title="partial payment above 50%"></i>
                      </div>
                      <div v-else >
                        <i class="fas fa-check-circle success" style="color:green" data-toggle="tooltip" data-placement="top" title="payment completed"></i>
                      </div>
                    </td>
                    <td class='text-center'>{{ index + 1 }}</td>
                    <td class='text-center'>{{ sched.payable_amount }}</td>
                    <td class='text-center'>
                      <span v-if="sched.adjusted_date == null"> {{ sched.due_date | dateFormat }} </span>
                      <span v-else data-toggle="tooltip" data-placement="top" title="adjusted due date" class="mark" >{{ sched.adjusted_date | dateFormat}}</span>
                    </td>
                    <td class='text-center'><div class="form-group mt-3">
                            <select @change="passAction(index,$event)" class="form-control custominput" id="exampleFormControlSelect1">
                            <option value="">Actions</option>
                            <option value="Verify">Verify Collection</option>
                            <option value="Delete">Delete</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
        <div class="collapse collapse-menu-body addPayment">
        <div class="card card-body">
            <div class="row align-items-center">
                <div class="col-md">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Amount:</label>
                        <input type="number"  v-model="payment_detail.amount" min="0" class="form-control input-custom" id="amount" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="col-md">
                    <date-picker
                            v-model="payment_detail.payment_date"
                            :masks="{L:'DD/MM/YYYY'}"
                            :max-date="new Date()"
                    >
                     <template v-slot="{ inputValue, inputEvents }">
                         <div class="form-group">
                            <label for="exampleInputEmail1">Post Date:</label>
                            <input type="text" :value="inputValue" v-on="inputEvents" class="form-control input-custom" id="postdate" aria-describedby="emailHelp">
                        </div>
                     </template>
                    </date-picker>
                    
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Notes:</label>
                        <input type="text" v-model="payment_detail.note" class="form-control input-custom" id="notes" aria-describedby="emailHelp">
                    </div>
                </div>
                <div  v-if="payment_detail.edit == true" class="col-md text-center ">
                    <div  class="form-group mt-4">
                        <button  @click="savePayment(detail.id)" class="btn btn-warning btn-square align-middle" style="width:100%"> <i class="fas fa-pen"></i> Update Payment </button>
                    </div>
                </div>
                <div  class="col-md text-center ">
                    <div  class="form-group mt-4">
                        <button v-if="payment_detail.edit == false" @click="savePayment(detail.id)" class="btn btn-success btn-square align-middle" style="width:100%"> <i class="fas fa-plus"></i> Add Payment </button>
                        <button v-else @click="cancelUpdate" class="btn btn-danger btn-square align-middle" style="width:100%"> <i class="fas fa-plus"></i> Cancel Changes </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix m-3" ></div>
        <div class="card card-body">
            <table
                class="custom-table"
                id="dataTable"
                width="100%"
                cellspacing="0"
            >
            <thead>
                <tr>
                    <th></th>
                    <th class='text-center'>Amount</th>
                    <th class='text-center'>Transaction #</th>
                    <th class='text-center'>Post Date</th>
                    <th class='text-center'>Notes</th>
                    <th class='text-center'>Agent</th>
                    <th class='text-center'>Attachment</th>
                    <!-- <th class='text-center'>Amount Paid</th> -->
                    <!-- <th class='text-center'>Post Date</th> -->
                    <th class='text-center'></th>
                </tr>
            </thead>
            <tbody>
              <template v-if="toType(detail.collection) !=='undefined'">
                <tr v-for="(sched,index) in detail.collection" :key="index"> 
                    <td class='text-center'>
                      <span v-if="sched.verified === 1" >
                          <i class="fas fa-check-circle" style="color:green"></i>
                      </span>
                      <span v-else-if="sched.verified === 2" >
                          <i class="fab fa-creative-commons-nc" style="color:red"></i>
                      </span>
                      <span v-else title="Pending">
                          <i class="fas fa-clock"></i>
                      </span>
                    </td>
                    <td class='text-center'>{{ sched.amount }}</td>
                    <td class='text-center'>{{ sched.transaction_code }}</td>
                    <td class='text-center'>{{ sched.payment_date | dateFormat }}</td>
                    <td class='text-center'>{{ sched.note }}</td>
                    <td class='text-center'>{{ sched.agent!=null ? sched.agent.agent_name : '' }}</td>
                    <td class='text-center'>
                      <a :href="'/payment_attachment/'+sched.attachment.id"  v-if="sched.attachment !== null" target="_blank"><span class="fa fa-paperclip"></span></a>
                      <span v-else>
                        No attachment
                      </span>
                    </td>
                    <td class='text-center'>
                        <div class="form-group mt-3">
                            <select class="form-control custominput"  @change="passAction(index,$event)" id="exampleFormControlSelect1">
                            <option value="">Actions</option>
                            <option value="Verify" v-if="sched.verified===0">Verify Collection</option>
                            <option value="Edit">Edit</option>
                            <option value="Delete">Delete</option>
                            </select>
                        </div>
                    </td>
                </tr>
                </template>
                <template v-else> 
                  <tr>
                    <td class="text-center" colspan="8">No data found</td>
                  </tr>
                </template>
            </tbody>
            </table>
        </div>
        </div>
        <div class="collapse collapse-menu-body invoices">
        <div class="card card-body">
            1Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
        </div>
        </div>
    </div>
</template>
<script>
import adjustDateModal from "./adjustDateModalComponent";
import moment from "moment";
export default {
  props: ["detail","payment_sched","payment_details","course_fee"],
  components: {
    adjustDateModal,
  },
  data() {
    return {
      demoUser: window.demoUser,
      stud_info: {},
      trxn:[],
      course_payments: [],
      // course_invoice: [],
      edit_due_date : {},
      payment_detail: {
        id: "",
        note: "",
        payment_date: "",
        amount: "",
        course_id: "",
        errors: [],
        edit: false,
        student_type: window.student_type
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
      menuchoicer : 'paymentPlanH',
      paid : 0,
      // totalAmount: '',
      // balanceFee: '',
    };
  },
  computed: {
      balance : function (){
            let balance = 0
            if(this.detail != undefined){
              console.log(this.payment_sched.length);
                if(this.payment_sched.length == 0){
                  balance  =  this.course_fee
                }else{
                  let temp_balance = this.payment_sched.map(function(item){
                      return item.payable_amount;
                    });
                  balance =  temp_balance.reduce((a,b)=> parseFloat(a)+ parseFloat(b));
                }

                if(this.payment_details.length > 0){
                    let payment_details = this.payment_details;
                    let paid = payment_details.map(function(item){
                      if(item.verified == 1){
                        return item.amount;
                      }else{
                        return "0"
                      }
                    });
                    console.log('mawni');
                    console.log(paid);
                    this.paid =  paid.reduce((a,b)=> parseFloat(a)+ parseFloat(b));
                    balance = balance - paid.reduce((a,b)=> parseFloat(a)+ parseFloat(b));
                }
            }
            return parseFloat(balance)
      },
       remainingBalance: function () {
        var tempBalance = this.paid
        return this.payment_sched.map((sched) => {
          tempBalance -= sched.payable_amount
          if(tempBalance >= 0){
            return 'complete';
          }else{
             if(Math.abs(tempBalance) > sched.payable_amount){
               return 'danger'
             }else{
                let perHolder = (Math.abs(tempBalance) /  sched.payable_amount )* 100 ;
                perHolder = 100 - perHolder 
                if(perHolder < 50){
                  return 'bad'
                }else{
                  return 'good'
                }
             }
            
          }
        })
        // [900, 750, 635]
      }

      
  },
  methods: {
    toType(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },
    passAction(index,event){
        // console.log(index,event);
        let action = event.target.value
        let vm = this;
        console.log(this.detail.collection[index]);
        if(action == 'Verify'){
            this.trxn = this.detail.collection[index];
            // if(this.payment_details[index].payment_schedule_template_id!==null){
                this.$modal.show('verifyModal');
            // }else{
            //     this.acceptWithoutSchedule(index);
            //     // console.log('chovuhr');
            // }
            event.target.value = ''
        }
        else if(action == 'Decline'){
            this.declineCollection(index);
            event.target.value = ''
        }
        else if(action == 'View'){
            this.trxn = this.payment_details[index];
            this.trxn_code = this.payment_details[index].transaction_code;
            this.$modal.show('viewTransactionModal');
            event.target.value = ''
        }
    },
    deletePaymentTemplate(id){
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
              title: "Deleting Template...",
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                swal.showLoading();
              },
            });
            axios.delete(`/offer-letter/payment/delete/${id}`).then(response=>{
              let res = response.data;
              if(res.status == 'success'){
                Toast.fire({
                        type: "success",
                        title: "Template deleted successfully",
                        position: "top-end",
                    });
                    this.$parent.fetchData();
              }else{
                 Toast.fire({
                    type: "error",
                    title: "Opss.. something went wrong",
                    position: "top-end",
                  });
              }
            }).catch(err=>{
               Toast.fire({
                  type: "error",
                  title: "Opss.. something went wrong",
                  position: "top-end",
                });
            })
          }
        });
    },
    showModal(data){
       this.$modal.show("adjust-due-modal",data);
    },
    // passAction(data,event){
    //   let action = event.target.value
    //   let vm = this;
    //   if(action == 'Edit'){
    //     this.editPayment(data);
    //     event.target.value = ''
    //   }
    //   else if(action == 'Delete'){
    //     this.remove(data,this.payment_details[data].id)
    //     event.target.value = ''
    //   }
    //   else if(action == 'Accept'){
    //     this.acceptPayment(data);
    //     event.target.value = ''
    //   }
    // },
    acceptPayment(idx){
      let data = {
        payment_details : this.payment_details[idx],
        payment_schedule:this.payment_sched
      }
      let dis = this;
      swal.fire({
        title: 'Accept Payment?',
        showCancelButton: true,
        confirmButtonText : 'Ok'
      }).then((result) => {
        if(result.value==true){
          swal.fire({
            title: "Please wait...",
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
              swal.showLoading();
            },
          });
          axios.post('/payment/detail/verify',data).then(
            response=>{
              if(response.data.status=='success'){
                if(window.student_type == 2){
                  dis.$parent.fetchData();
                  swal.close();
                }else{
                  dis.$parent.$parent.fetchStudent();
                }
              }else{
                swal.fire({
                  type:'error',
                  title:'Cannot proceed!',
                  html:response.data.message
                });
              }
            }
          ).catch(
            err=>{
              swal.fire({
                  type:'error',
                  title:'Cannot proceed!',
                  html: err.response.data.message
                });
            }
          );
        }
      })
    },
    edit_due(detail) {
      detail.due_date = moment(detail.due_date)._d;
      this.edit_due_date['payment_'+detail.id] = detail;
    },
    closeOther(e,v){
        let collapseMenuBody = Array.from(document.getElementsByClassName('collapse-menu-body'));
        let collapseMenu = Array.from(document.getElementsByClassName('collapse-menu'));
        collapseMenuBody.map(element => {
             if(!element.className.includes(e)){
                  element.classList.remove('show')
              }
          })
        collapseMenu.map(element1 => {
             if(!element1.className.includes(v)){
                  element1.classList.remove('active')
              }else{
                  element1.classList.add('active')
                  this.menuchoicer = v;
              }
        })
    },
    cancelUpdate(){
       this.payment_detail =  {
        id: "",
        note: "",
        payment_date: "",
        amount: "",
        course_id: "",
        errors: [],
        edit: false,
      }
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
      if (vm.payment_detail.amount > parseInt(this.balance)) {
        Toast.fire({
          type: "error",
          title: "Opss.. failed to add payment",
          position: "top-end",
        });
      } else {
        if(vm.detail.funded_course != undefined){
          vm.payment_detail.funded_id =  vm.detail.funded_course.id;
        }
        vm.payment_detail.course_id = course_id;
        if (vm.payment_detail.payment_date != null) {
          vm.payment_detail.payment_date = moment(
            vm.payment_detail.payment_date
          ).format("YYYY-MM-DD");
        }
        // console.log(vm.payment_details.payment_date);
        axios
          .post(
            `/student/domestic/${window.student}/payment-store`,
            this.payment_detail
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
              this.payment_detail.errors = [];
              this.payment_detail.id = "";
              this.payment_detail.note = "";
              this.payment_detail.payment_date = "";
              this.payment_detail.amount = "";
              this.payment_detail.course_id = "";
              this.payment_detail.edit = false;
              this.success = true;
              Toast.fire({
                type: "success",
                title: "Data is saved successfully",
                position: "top-end",
              });
              if(window.student_type == 2){
                this.$parent.fetchData();
              }else{
                this.$parent.$parent.fetchStudent();
              }
            }
            console.log(response);
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    editPayment(item) {
      let vm = this;
      vm.payment_detail.id = this.payment_details[item].id;
      vm.payment_detail.note = this.payment_details[item].note;
      vm.payment_detail.payment_date = moment(
        this.payment_details[item].payment_date,
        "YYYY-MM-DD"
      )._d;
      vm.payment_detail.amount = this.payment_details[item].amount;
      vm.payment_detail.edit = true;
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
                this.payment_details.splice(item, 1);
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
  },
  filters : {
      dateFormat : function(data){
          return moment(data).format('DD/MM/YYYY');
      },
      currencyDisplay: function(val){
          // read: function(val){
            return val.toFixed(2);
          // },
          // write: function(val){
            // var number = +val.replace(/[^\d.]/g,'');
            // return isNaN(number) ? 0 : number
          // }
      }
  }
}
</script>
<style scoped>
table.custom-table  th { background-color: transparent!important; color:gray!important; border: none!important;}
a.collapse-menu.active {
  background-color: #024b67;
  color: white;
}
.btn-square { border-radius: 0; }
.input-custom{
  background-color: #7573731f;
  border:none;
  border-radius: 0;
}
.custominput {
  border:none;
  border-radius: 0;
  text-align-last: center;
}
.pie {
  width: 25px; height: 25px;
  border-radius: 50%;
  background: white;
  background-image: linear-gradient(to right, transparent 50%, red 0);
}

.pie::before {
  content: ’;
  display: block;
  margin-left: 50%;
  height: 100%;
  border-radius: 0 100% 100% 0 / 30%;
  background-color: inherit;
  rotate: 45%;
}


</style>