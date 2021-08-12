<template>
    <div class="card card-body"> 
        <verify-modal :data="trxn"/>
        <view-transaction-modal :data="trxn"/>
        <table
            class="table custom-table"
            id="dataTable"
            width="100%"
            cellspacing="0"
        >
            <thead>
                <tr>
                    <th class='text-center'>Trxn Code</th>
                    <th class='text-center'>Student ID</th>
                    <th class='text-center'>Course</th>
                    <th class='text-center'>Amount</th>
                    <th class='text-center'>Post Date</th>
                    <th class='text-center'>Attachment</th>
                    <th class='text-center'>Verified</th>
                    <!-- <th class='text-center'>Amount Paid</th> -->
                    <!-- <th class='text-center'>Post Date</th> -->
                    <th class='text-center'></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(pd,index) in payment_details" :key="pd.id" :id="pd.id" :style="pd.id == notif_row ? 'background-color:#f0f8ff;' : ''">
                    <td class="text-center">{{pd.transaction_code}}</td>
                    <td class="text-center">{{pd.student_id}}</td>
                    <td class="text-center">{{pd.funded_student_course.course_code != '@@@@' ? pd.funded_student_course.course_code : 'Unit of Competency'}}</td>
                    <td class="text-center">{{pd.amount}}</td>
                    <td class="text-center">{{pd.payment_date | dateFormat}}</td>
                    <td class="text-center">
                        <a :href="'/payment_attachment/'+pd.attachment.id"  v-if="pd.attachment !== null" target="_blank"><span class="fa fa-paperclip"></span></a>
                        <span v-else>
                            No attachment
                        </span>
                    </td>
                    <td class="text-center">
                        <span v-if="pd.verified === 1" title="Verified">
                          <i class="fas fa-check-circle" style="color:green"></i>
                        </span>
                        <span v-else-if="pd.verified === 2" title="Declined">
                          <i class="fab fa-creative-commons-nc" style="color:red"></i>
                        </span>
                        <span v-else title="Pending">
                            <i class="fas fa-clock"></i>
                        </span>
                    </td>
                    <td class='text-center'>
                        <select @change="passAction(index,$event)" class="form-control custominput" id="exampleFormControlSelect1" v-if="pd.verified===0">
                            <option value="">Actions</option>
                            <option value="Verify">Verify</option>
                        </select>
                        <select @change="passAction(index,$event)" class="form-control custominput" id="exampleFormControlSelect1" v-else-if="pd.verified===1">
                            <option value="">Actions</option>
                            <option value="View">View Transaction</option>
                        </select>
                    </td>
                </tr>
                <tr v-if="payment_details.length == 0">
                    <td colspan="8" class="text-center">No data available</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import moment from 'moment'
import verifyModal from './agent-collection/verifyCollectionModal.vue'
import viewTransactionModal from './agent-collection/viewTransactionModal.vue'
export default {
    components:{
        verifyModal,
        viewTransactionModal
    },
    data(){
        return{
            app_color:app_color,
            agent_id:window.agent.id,
            payment_details:[],
            trxn:[],
            trxn_code:'',
            notif_row:''
        }
    },
    created(){
        this.getAgentCollections();

        if(localStorage.getItem('row_id') != null){
            this.notif_row = localStorage.getItem('row_id');
            localStorage.removeItem('row_id');
        }
    },
    
    filters:{
        dateFormat : function(data){
          return moment(data).format('DD/MM/YYYY');
      },
    },
    methods:{
        getAgentCollections(){
            axios.get(`/agent/${this.agent_id}/collections`).then(
                response=>{
                    this.payment_details = response.data;
                }
            );
        },
        passAction(index,event){
            // console.log(index,event);
            let action = event.target.value
            let vm = this;
            if(action == 'Verify'){
                this.trxn = this.payment_details[index];
                if(this.payment_details[index].payment_schedule_template_id!==null){
                    this.$modal.show('verifyModal');
                }else{
                    this.acceptWithoutSchedule(index);
                    // console.log('chovuhr');
                }
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
        acceptWithoutSchedule(idx){
            swal.fire({
                title: "This has no payment schedule.",
                html:'Accept collection?',
                showCancelButton:true,
            }).then((result)=>{
                if(result.value===true){
                    swal.fire({
                        title: "Loading please wait...",
                        // html: '',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            swal.showLoading();
                        },
                    });
                    let dataz = {
                        student_payment:this.payment_details[idx],
                        payment_schedule:null
                    }
                    
                    axios.post(`/agent/collection/accept`,dataz).then(
                        response=>{
                            if(response.data.status==='success'){
                                this.getAgentCollections();
                                Toast.fire({
                                    position: "top-end",
                                    type: "success",
                                    title: 'Collection verified',
                                });
                            }else{
                                Toast.fire({
                                    position: "top-end",
                                    type: "error",
                                    title: response.data.message,
                                });
                            }
                        }
                    );
                }
            });
        },
        declineCollection(idx){
            swal.fire({
                title: "Decline this pending payment collection?",
                showCancelButton:true,
            }).then((result)=>{
                console.log(result.value==true)
                if(result.value===true){
                    swal.fire({
                        title: "Loading please wait...",
                        // html: '',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            swal.showLoading();
                        },
                    });
                    axios.get(`/agent/collection/${this.payment_details[idx].id}/decline`).then(
                        response=>{
                            this.getAgentCollections();
                            Toast.fire({
                            position: "top-end",
                            type: "success",
                            title: 'Collection declined!',
                        });
                        }
                    ).then(
                        err=>{
                            console.log(err);
                        }
                    );
                }
            });

            
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