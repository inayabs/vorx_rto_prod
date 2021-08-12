<template>
    <modal
        name="verifyModal"
        transition="nice-modal-fade"
        classes="verify-collection"
        :min-width="1000"
        :min-height="200"
        :pivot-y="0.1"
        :adaptive="true"
        :scrollable="true"
        :reset="true"
        width="40%"
        height="auto"
        style="padding-top:100px;"
        @opened="opened"
        @closed="closed"
    >
        
        <div class="card">
            <div v-if="data.payment_schedule_template_id !== null">
                <div class="card card-header text-center">
                Payment Details
                </div>
                <div class="card card-body" style="overflow:auto;height:400px;">
                    <div class="card text-left" style="border:none">
                        <span><strong>Student:</strong> {{toType(data.student) !== 'undefined' ? data.student.party.name : ''}}</span>
                    </div>
                    <div class="card text-left" style="border:none">
                        <span><strong>Course:</strong>
                        <template v-if="toType(data.funded_student_course)!=='undefined'">
                            <template v-if="data.funded_student_course.course_code=='@@@@'">
                                Unit of Competency
                            </template>
                            <template v-else>
                                {{data.funded_student_course.course_code}} - {{data.funded_student_course.course.name}}
                            </template>
                        </template>
                        </span>
                        
                    </div>
                    <div class="card text-left" style="border:none">
                        <span><strong>Attachment: </strong>
                        <span v-if="toType(data.attachment)!=='undefined'">
                            <a :href="'/payment_attachment/'+data.attachment.id" target="_blank"> Go to link</a>
                        </span>
                        <span v-else>
                            No attachment found.
                        </span>
                        </span>
                    </div>
                    <div class="card text-left"  style="border:none">
                        <span>
                            <span class="fas fa-circle " style="color:#f6c23e"></span> 
                            <strong>Received Amount :</strong>  
                            {{amount_paid.toFixed(2)}} 
                        </span>
                    </div>
                    <div class="card text-left" style="border:none">
                        <span>
                            <span class="fas fa-circle " style="color:#858796"></span> 
                            <strong>Pre Deducted Comission: </strong>
                            {{parseFloat(data.pre_deduc_comm).toFixed(2)}}
                        </span>
                    </div>
                    <div class="card text-left" style="border:none">
                        <span>
                            <strong>Total Amount: </strong>
                            {{(parseFloat(data.amount) + parseFloat(data.pre_deduc_comm)).toFixed(2)}}
                        </span>
                    </div>
                    <div class="card text-left" style="border:none">
                        <span>
                            <strong>Notes: </strong>
                            {{data.notes}}
                        </span>
                    </div>
                    <table
                        class="table custom-table"
                        id="dataTable"
                        width="100%"
                        cellspacing="0"
                    >
                         <thead>
                            <tr>
                                <th class='text-center' width="10%">Month #</th>
                                <th class='text-center' width="15%">Amount Due</th>
                                <th class='text-center' width="15%">Due Date</th>
                                <!-- <th class='text-center' width="15%">Amount Paid</th> -->
                                <!-- <th class='text-center' width="15%">Total Amount</th> -->
                                <th class='text-center' width="15%">Allocated Amount</th>
                                <th class='text-center' width="15%">Commission</th>
                                <th class='text-center' width="15%">Pre Deducted Commission</th>
                            </tr>
                         </thead>
                         <tbody>
                             <tr v-for="(st,index) in student_payment.funded_payment_sched_template" :key="index">
                                 <td class="text-center">{{parseInt(index)+1}}</td>
                                 <td class="text-center">{{st.balance.toFixed(2)}}</td>
                                 <td class="text-center">{{st.due_date | dateFormat}}</td>
                                 <!-- <td class="text-center">{{toType(st.unverified_total_amount)!=='undefined' ? st.unverified_total_amount.toFixed(2) : 0.00}}</td> -->
                                
                                 <!-- <td :class="'text-center bg-warning text-white'" v-if="toType(st.allocated_amount) !== 'undefined' && st.allocated_amount > 0 && (toType(st.adjusted)=='undefined' || st.adjusted ==false) && toType(st.allocated_amount)=='undefined'">
                                         {{parseFloat(st.allocated_amount).toFixed(2)}}<sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                 </td>
                                 <td v-else-if="st.allocated_amount==0 && (toType(st.adjusted)=='undefined' || st.adjusted ==false)" class="text-center">
                                        {{parseFloat(st.allocated_amount).toFixed(2)}}<sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                 </td>
                                 <td v-else-if="st.adjusted==true && st.allocated_amount>0" class="text-center">
                                        {{parseFloat(st.allocated_amount).toFixed(2)}}<sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                        <p class="bg-black" style="margin-bottom:-25px;">&#8595;</p>
                                 </td>
                                 <td v-else-if="toType(st.exceeding_amount) !== 'undefined'" class="text-center bg-warning text-white">
                                     {{parseFloat(st.new_allocated).toFixed(2)}}<sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                 </td>
                                 <td v-else class="text-center">
                                         -{{parseFloat(st.allocated_comm).toFixed(2)}}<sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                        <p class="bg-black" style="margin-bottom:-25px;">&#8595;</p>

                                 </td>  
                                 <td v-if="toType(st_allocated_amount) !== 'undefined' && st.allocated_amount > 0">
                                         {{parseFloat(st.allocated_amount).toFixed(2)}}<sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                 </td> -->
                                 <td v-if="st.allocated_amount > 0 && toType(st.exceeding_amount)=='undefined'" class="text-center bg-warning text-white">
                                        {{parseFloat(st.allocated_amount).toFixed(2)}}<sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                 </td>
                                 <td v-else-if="toType(st.exceeding_amount) !== 'undefined'" class="text-center bg-warning text-white">
                                        {{parseFloat(st.new_allocated).toFixed(2)}}<sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                 </td>
                                 <td v-else class="text-center">
                                    <!-- {{parseFloat(st.approved_amount_paid).toFixed(2)}} -->
                                    0.00 <sup class="pull-right">{{st.approved_amount_paid}}</sup>
                                 </td>
                                 <td class="text-center">{{st.comm_balance.toFixed(2)}}</td>
                                 <td class="text-center bg-secondary text-white" v-if="st.allocated_comm > 0">{{parseFloat(st.allocated_comm).toFixed(2)}} <sup class="pull-right">{{st.approved_commission}}</sup></td>
                                 <td class="text-center" v-else>{{st.allocated_comm.toFixed(2)}} <sup class="pull-right">{{st.approved_commission}}</sup> </td>
                             </tr>
                         </tbody>
                    </table>  
                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="" id="" cols="30" rows="4" class="form-control" placeholder="Remarks (Optional)" v-model="remarks"></textarea>
                        </div>
                    </div>     <br>
                    <div class="row text-right">
                        <div class="col-md-12">
                            <button class="btn btn-success btn-sm" @click="action('accept')">Accept</button>
                            <button class="btn btn-danger btn-sm" @click="action('decline')">Decline</button>
                        </div>    
                    </div>             
                </div>

            </div>
            <div v-else class="text-center card card-header">
                Payment Schedule not found
            </div>
        </div>
    </modal>
</template>
<script>
import moment from 'moment'
export default {
    props:['data'],
    data(){
        return{
            student_payment:[],
            amount_paid:0,
            remarks:''
        }
    },
    filters:{
        dateFormat : function(data){
          return moment(data).format('DD/MM/YYYY');
        },
    },
    methods:{
        toType(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },
        decline(){
            console.log('wakla pa');
        },  
        action(action){
            swal.fire({
                title: "Loading please wait...",
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading();
                },
            });
            let dataz = {
                action:action,
                remarks: this.remarks,
                student_payment:this.data,
                payment_schedule:this.student_payment.funded_payment_sched_template
            }
            axios.post(`/agent/collection/action`,dataz).then(
                response=>{
                    if(response.data.status==='success'){
                        this.$parent.getAgentCollections();
                        this.$modal.hide('verifyModal');
                        Toast.fire({
                            position: "top-end",
                            type: "success",
                            title: 'Collection Updated',
                        });
                    }else{
                        Toast.fire({
                            position: "top-end",
                            type: "error",
                            title: response.data.message,
                        });
                    }
                }
            ).catch(
                err=>{
                    Toast.fire({
                        position:'top-end',
                        type:'error',
                        title:'Cannot proceed!',
                        html: err.response.data.message
                    });
                }
            );
        },
        getBg(unv_amount){
            if(typeof unv_amount!=='undefined' && unv_amount!=0){
                return 'warning'
            }
        },
        getAllocated(payable){
            let cash = this.amount_paid;
            console.log(cash);
            if(cash >= payable){
                return payable;
                this.amount_paid = this.amount_paid - payable;
            }else{
                this.cash;
            }
        },
        closed(){
            this.student_payment = [];
            this.amount_paid = 0;
        },
        opened(e){
            this.amount_paid = parseFloat(this.data.amount);
            this.getStudentPayments();
        },
        getStudentPayments(){
            axios.post(`/agent/student-payments`,
            {
                id:this.data.id,
                amount_paid:this.amount_paid,
                pre_deduc_com:this.data.pre_deduc_comm
            }).then(
                response=>{
                    // console.log('gago');
                     this.student_payment = response.data;  
                }
            );
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