<template>
    <div>
        <div id="new_payment">
            <p class="pull-left">
                <a class="collapse-menu active p-1 pl-2 pr-2 m-1 paymentPlanH" type="button" data-toggle="collapse" @click="closeOther('paymentPlan','paymentPlanH')" href=".paymentPlan" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-scroll"></i> Payment Plan
                </a>
                <a class="collapse-menu p-1 pl-2 pr-2 m-1 addPaymentH" type="button" data-toggle="collapse"  @click="closeOther('addPayment','addPaymentH')" href=".addPayment" aria-expanded="false" aria-controls="collapseExample1">
                    <i class="fas fa-plus"></i> Payments
                </a>   
            </p>
             <div class="pull-right">
                 <h5 v-show="menuchoicer == 'addPaymentH'">
                    Remaining Balance: $ <span>{{ remainingBalance.toFixed(2) }}</span> <a href="javascript:void(0)" class="btn btn-success btn-sm" title="pay" @click="pay()">Pay</a>
                </h5>
                <h5 v-show="menuchoicer == 'paymentPlanH'">
                    Total Paid: $ <span>{{ getTotal().toFixed(2) }}</span>
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
                                <th class='text-center' width="20px;"></th>
                                <th class='text-center'>Month</th>
                                <th class='text-center'>Amount Due</th>
                                <th class='text-center'>Recommended Pay Date</th>
                                <th class='text-center'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(pc,index) in schedule_template" :key="index">
                                <td class="text-center">
                                    <!-- <i class="fas fa-check-circle" style="color:red"></i> -->
                                </td>
                                <td class="text-center">{{index+1}}</td>
                                <td class="text-center">{{pc.due_date | dateformat}}</td>
                                <td class="text-center">{{pc.payable_amount}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="collapse collapse-menu-body addPayment">
                <div class="card card-body">
                    <table
                        class="custom-table"
                        id="dataTable"
                        width="100%"
                        cellspacing="0"
                    >
                        <thead>
                            <tr>
                                <th class='text-center' width="20px;"></th>
                                <th class='text-center'>Amount</th>
                                <th class='text-center'>Payment Date</th>
                                <th class='text-center'>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(pd,index) in payment_details" :key="index">
                                <td></td>
                                <td class="text-center">{{pd.amount}}</td>
                                <td class="text-center">{{pd.payment_date | dateformat}}</td>
                                <td class="text-center">{{pd.note}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <pay-modal :course="course" :student="student" />
    </div>
</template>
<script>
import moment from "moment";
import payModal from "./payModal.vue";
export default {
    components:{
        payModal
    },
    props:['course'],
    data(){
        return{
            app_color:app_color,
            columns: ["payment_date","note","amount"],
            payment_details:[],
            student:window.student,
            menuchoicer : 'paymentPlanH',
            open_pay:false,
            schedule_template:[],
            options:{
                headings: {
                payment_date: "Date Paid",
                note: "Description",
                amount: "Amount",
                filterable:[]
                },
            },
            total_due:0,
            remainingBalance:0,
            amount:0,
        }
    },
    created(){
        this.getPayments();
    },
    filters:{
        dateformat: function(date) {
        if (!date) return "";
        date = moment(date).format("DD/MM/YYYY");
        return date;
        },
    },
    watch:{
        
    },
    methods:{
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
        pay(){
            this.$modal.show('pay-modal');
            this.open_pay = !this.open_pay;
            // var encoded_id = btoa(this.course.id)

            // window.open("/student-portal/online-payment/"+encoded_id);
            // (async () => {
            
            // const { value: accept } = await swal.fire({
            // title: 'Online Payment',
            // width:400,
            // html:
            // `<div class="container"><div class="row justify-content-md-center"><input type="number" class="form-control col-md-5" value="${this.amount}" name="amount" min="0" step="0.01" placeholder="Amount in AUD"></div></div>`,
            // input: 'checkbox',
            // inputValue: 1,
            // inputPlaceholder:
            //     'Note: Service charge will be applied.',
            // confirmButtonText:
            //     'Continue&nbsp;<i class="fa fa-arrow-right"></i>',
            // inputValidator: (result) => {
            //     return !result && 'You need to agree with T&C'
            // }
            // })

            // if (accept) {
            // swal.fire('You agreed with T&C :)')
            // }

            // })()
            // location.href="/dashboard"
        },
        getTotal(){
            let vm = this;
            var sum = vm.payment_details
                .map((q) => parseInt(q.amount))
                .reduce(function (total, q) {
                return total + q;
                }, 0);
            return sum;
        },
        getPayments(){
            let id = 0;
            let dis = this;

            if(this.student.student_type_id==1){
                id = this.course.offer_letter_course_detail_id;
            }else{
                id = this.course.id;
            }
            // console.log(id);
            axios.get('/student_fees/get-fees/'+this.course.id).then(
                response=>{
                    var tot_due = 0;
                    var tot_paid = 0;

                    this.payment_details = response.data.payments;
                    this.schedule_template = response.data.schedule_template;
                    if(response.data.schedule_template!=''){
                        response.data.schedule_template.forEach(function(dis){
                            tot_due = tot_due + parseInt(dis.payable_amount);
                        });
                    }                    

                    if(response.data.payments!=''){
                        response.data.payments.forEach(function(dis){
                            tot_paid = tot_paid + parseInt(dis.amount);
                        });
                    }   
        
                    dis.total_due = tot_due;
                    dis.remainingBalance = tot_due-tot_paid;
                }
            ).catch(
                err=>{
                    console.log(err);
                }
            );
        }
    }
}
</script>
<style scoped>
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
table.custom-table  th { background-color: transparent!important; color:gray!important; border: none!important;}
table.custom-table tbody tr td{padding:20px !important;}
a.collapse-menu.active {
  background-color: #024b67;
  color: white;
}
.btn-square { border-radius: 0; }
</style>