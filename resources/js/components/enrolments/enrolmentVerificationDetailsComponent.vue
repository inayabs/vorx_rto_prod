<template>
    <div class="card-body">
        <form @submit.prevent>
            <div class="row">
                <div class="col-md-12 pull-right text-right">
                    <button @click="verify()" class="btn btn-success">Verify</button>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Class</label>
                       <select v-model="class_" class="custom-select">
                        <option selected>Select Class</option>
                            <option  v-for="(class_, index) in classes"  :key="index" :value="class_.id">{{ class_.desc }}</option>
                        </select>
                    </div>
                </div>
                <div v-if="unit == 0" class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Add Offer Letter {{ edata.length }}</label>
                        <select v-model="offer_letter" class="custom-select">
                            <option value="1">Yes</option>
                            <option selected value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mode of study</label>
                        <select v-model="mode_study" class="custom-select">
                            <option  v-for="(mode,index) in dlvr_mode" :key="index"  :value="mode.value">{{ mode.description }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Delivery Location</label>
                        <select  v-model="dlvr_loc" class="custom-select">
                            <option v-for="(location, index) in dlv_loc" :key="index"> {{ location.addr_location }}, {{location.state.state_key}}  - {{ location.postcode }}</option>
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Shore type</label>
                        <select v-model="shore_type" class="custom-select">
                            <option value="ONSHORE">ONSHORE</option>
                            <option selected value="OFFSHORE">OFFSHORE</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select v-model="status"  class="custom-select">
                            <option  v-for="status in student_status" :key="status.id" :value="status.id">{{status.description}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Course Start</label>
                        <date-picker
                        locale="en"
                        :masks="{ L: 'DD/MM/YYYY' }"
                        v-model="start_date"
                        ></date-picker>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Course End</label>
                        <date-picker
                        locale="en"
                        :masks="{ L: 'DD/MM/YYYY' }"
                        v-model="end_date"
                        ></date-picker>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Eligibility</label>
                        <select v-model="eligibility" class="custom-select">
                            <option value="1">Eligible</option>
                            <option selected value="0">Not Eligible</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Course Fee type</label>
                        <select v-model="fee_type" class="custom-select">
                            <option value="" selected></option>
                            <option v-for="(type,index) in course_fee" :key="index" :value="index">{{ type }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Funding type</label>
                        <select v-model="course_funding_type" class="custom-select">
                            <option value="" selected></option>
                            <option v-for="type in funding_type" :key="type.id" :value="type.id"> {{ type.name }} </option>
                            
                        </select>
                    </div>
                </div>
                <div v-if="offer_letter == 0" class="col-md-6">
                    <div  class="form-group">
                        <label for="exampleInputEmail1">Course Tuition fee</label>
                        <input  v-model="tuition_fee" type="number" class="form-control">
                    </div>
                </div>

            </div>
              <div class="clearfix"></div>
            <div v-if="offer_letter == 1" class="row">
                <div class="clearfix p-1"></div>
                <div class="col-md-12">
                     <div :class="`horizontal-line-wrapper-${app_color} my-3`">
                        Fees and Payments
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                        <label for="exampleInputEmail1">Course Tuition fee</label>
                        <input  v-model="tuition_fee" type="number" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Application fee</label>
                        <input v-model="application_fee" type="number" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Material fee</label>
                        <input v-model="material_fee" type="number" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Discount amount</label>
                        <input v-model="discount" type="number" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Payment required</label>
                        <input v-model="payment_required" type="number" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Payment due <small><em></em>( leave blank if default 3 days )</small></label>
                        <date-picker
                        locale="en"
                        :masks="{ L: 'DD/MM/YYYY' }"
                        v-model="payment_due"
                        ></date-picker>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    props : ['edata','location','pid','stype'],
    data() { 
        return {
            app_color: app_color,
            start_date: "",
            end_date: "",
            payment_due: "",
            eligibility: "",
            class_ : "",
            mode_study : "",
            dlvr_loc : "",
            shore_type : "",
            status : "",
            fee_type : "",
            course_funding_type : "",
            tuition_fee: 0,
            application_fee: 0,
            material_fee: 0,
            discount: 0,
            payment_required: 0,
            offer_letter : 0,
            unit : 0,
            matrix : {},
        }
    },
    created() {
        this.funding_type;
        if(this.edata.length > 0){
            this.unit = 1;
        }
        if(this.stype  == 'International'){
            this.offer_letter = 1 
        }
        // console.log(this.edata.length)
    },
    methods: {
        verify(){
            let vm = this;
            let toast = swal.fire({
                position: "top-end",
                title: "Please wait",
                showConfirmButton: false,
                onBeforeOpen: () => {
                    swal.showLoading();
                },
            });

            let verify_data = {
                class :  vm.class_,
                course : vm.edata,
                offer_letter : vm.offer_letter,
                mode_of_study : vm.mode_study,
                dlvr_loc : vm.dlvr_loc,
                shoretype : vm.shore_type,
                status : vm.status,
                start_date : vm.start_date,
                end_date : vm.end_date,
                eligibility : vm.eligibility,
                course_fee_type : vm.fee_type,
                funding_type : vm.course_funding_type,
                tuition_fee : vm.tuition_fee,
                application_fee : vm.application_fee,
                material_fee : vm.material_fee,
                discount : vm.discount,
                payment_required : vm.payment_required,
                payment_due : vm.payment_due,
                process_id : vm.pid,
            }
            axios.post('/enrolment-application-new',verify_data)
            .then(response => {
                let data = response.data;
                console.log(data);
                if(data.status == 'exist'){
                     swal
                  .fire({
                    title: "Student Already exist",
                    text: "Do you want to link ?",
                    type: "warning",
                    // width: "30%",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    cancelButtonColor: "#d33",
                    cancelButtonText: "No!",
                  })
                  .then((result) => {
                        if(result.value){
                              axios.post('/enrolment-application-new-link',verify_data)
                                .then(response => {
                                    let data = response.data;
                                   if(data.status == 'success'){
                                        Toast.fire({
                                            type: "success",
                                            position: "top-end",
                                            title: res.data.message,
                                        });
                                    }else{
                                        swal.fire({
                                                type: "error",
                                                title: "Oops...",
                                                html: `ERROR`,
                                                });
                                    }
                                });
                        }
                    });
                }else if(data.status == 'success'){
                   Toast.fire({
                        type: "success",
                        position: "top-end",
                        title: res.data.message,
                    });
                }else{
                     swal.fire({
                              type: "error",
                              title: "Oops...",
                              html: `ERROR`,
                            });
                }
            })

        },
        getCourseFee(){
            axios.get(`/enrolment-application-new/course_matrix/${this.edata.code}/${this.location}`).then(res=>{
                this.matrix = res.data
            });
        }
        
    },
    computed: {
        funding_type :function(){
            let funding = window.funding_type;
            let choices = [];
            funding.map((element)=>{
                if(element.state_key == this.location){
                    choices.push(element);
                }
            })
            return choices;
        },
        student_status : function(){
            let stud_status = window.student_status;
            return stud_status;
        },
        dlv_loc : function(){
            return window.dlvr_loc;
        },
        course_fee: function(){
            let choices = {};
            if(this.eligibility == '1'){
                choices = {  
                            'C' : "Concessional", 
                            'NC' : "Government Funded",
                            'FF' : "Fee for Service"
                        }
            }else{
                  choices = {
                            'NC' : "Government Funded",
                            'FF' : "Fee for Service"
                        }
            }
            return choices;
        },
        classes : function(){
            return window.classes;
        },
        dlvr_mode : function(){
            return window.dlvr_mode;
        }
    },
    watch:{
        offer_letter : function(newVal){
            if(newVal == 0){
                this.payment_due = null
            }else{
                this.getCourseFee();
            }
        },
        shore_type : function (newVal,oldVal) {
            if(this.matrix != ''){
                if(newVal == 'ONSHORE'){
                    this.tuition_fee = parseInt(this.matrix.onshore_tuition_individual).toFixed(2) ;
                }else{
                    this.tuition_fee = parseInt(this.matrix.offshore_tuition_individual).toFixed(2) ;
                }
                this.material_fee = parseInt(this.matrix.material_fees).toFixed(2);
                this.application_fee = parseInt(this.matrix.enrolment_fee).toFixed(2);
                let prequired = parseInt(this.material_fee) + parseInt(this.application_fee);
                this.payment_required = prequired.toFixed(2);
            }
        },
        
    }


    
}
</script>