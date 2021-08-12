<template>
    <div>
        <div class="clearfix"></div>
        <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
                <a class="btn btn-success" @click="generate_commission()"><i class="fas fa-file-pdf"></i> Generate Commission</a>
            </div>
        </div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'" id="directIfEdit">
            <span class='text-align-left'>Commission Report</span>
        </div>
        <div class="clearfix"></div>
        <div class="crm-form-container no-padding">
            <div class="panel">
                <table width="100%">
                    <tr>
                        <td width="90%" class="text-right px-16-font europa-bold line-height-12">Total Students&nbsp;&nbsp;&nbsp;:</td>
                        <td class="text-right px-16-font europa-bold line-height-12">{{this.data.studentCount}}</td>
                    </tr>
                    <tr>
                        <td width="90%" class="text-right px-16-font europa-bold line-height-12">Total amount received for all students&nbsp;&nbsp;&nbsp;:</td>
                        <td class="text-right px-16-font europa-bold line-height-12">{{this.data.total_amount_received_from_students_excluding_resource | currencyFormat}}</td>
                    </tr>
                    <tr>
                        <td width="90%" class="text-right px-16-font europa-bold line-height-12">Total commission already paid for all students&nbsp;&nbsp;&nbsp;:</td>
                        <td class="text-right px-16-font europa-bold line-height-12">{{this.data.total_commission_already_paid | currencyFormat}}</td>
                    </tr>
                </table>
                <div class="clearfix" style="height: 5px;"></div>
                <div style="border-bottom: dotted #555555; width: 100%;"></div>
                <table width="100%">
                    <tr>
                        <td width="90%" class="text-right px-16-font europa-bold line-height-12">Total Amount Payable as of {{dateNow}} {{this.data.commValue}} {{this.data.commLabel}}&nbsp;&nbsp;&nbsp;: </td>
                        <td class="text-right px-16-font europa-bold line-height-12">{{this.data.commValue == 'No GST' ? this.data.due_commission_payable : this.data.amount_payable_including_gst | currencyFormat}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="clearfix" style="height: 20px;"></div>
        <div class="accordion" id="accordionCommReportView">
            <div class="card" v-for="(item, key) in this.data.students" v-bind:key="key">
                <div class="card-header" v-bind:id="'heading-'+key">
                    <h2 class="mb-0">
                        <button v-bind:class="item.count == 0 ? 'collapsed btn btn-link' : 'btn btn-link'" type="button" data-toggle="collapse" v-bind:data-target="'#collapse-'+key" v-bind:aria-expanded="item.count == 0 ? 'true' : 'false'" v-bind:aria-controls="'collapse-'+key" @click="studentPayments(key)">
                            {{key}} - {{item.firstname}} {{item.lastname}}
                        </button>
                    </h2>
                </div>
                <div v-bind:id="'collapse-'+key" v-bind:class="item.count == 0 ? 'show collapse' : 'collapse'" v-bind:aria-labelledby="'heading-'+key" data-parent="#accordionCommReportView">
                    <div class="card-body">
                        <div v-if="getStudentID != null && getStudentID == key">
                            <div class="row" v-for="(i, k) in getStudPayments" v-bind:key="k">
                                <div class="col-md-12">
                                    <table class="table course-fee addrow white-bg-color" cellspacing="0" width="100%">
                                        <tr>
                                            <td style="background-color: #525558;color: #fff;">Course Name</td>
                                            <td>{{i.course_name}}</td>
                                            <td style="background-color: #525558;color: #fff;">Start</td>
                                            <td>{{i.course_start_date | auDateFormat}}</td>
                                            <td style="background-color: #525558;color: #fff;">End</td>
                                            <td>{{i.course_end_date | auDateFormat}}</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #525558;color: #fff;">Tuition Fee</td>
                                            <td>{{i.tuition_fee | currencyFormat}}</td>
                                            <td style="background-color: #525558;color: #fff;">Non-Tuition Fee</td>
                                            <td>{{i.non_tuition_fee | currencyFormat}}</td>
                                            <td style="background-color: #525558;color: #fff;">Status</td>
                                            <td style="'color: #f44336;">
                                                {{i.status}}
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table class="table course-fee addrow white-bg-color" cellspacing="0" width="100%">
                                        <thead>
                                            <tr style="background-color: #525558;color: #fff;">
                                                <th style="width:5%;">No.</th>
                                                <th style="width:20%;text-align:center">Student Payment<br>Due Date</th>
                                                <th style="width:11%;text-align:right">Amount<br>Received</th>
                                                <th style="width:23%;text-align:center">Date Paid</th>
                                                <th style="width:12%;text-align:right">Actual Amount</th>
                                                <th style="width:15%;text-align:right">Pre-Deducted<br>Commission</th>
                                                <th style="width:15%;text-align:right">Commission<br>Payable</th>
                                                <th style="width:15%;text-align:right"></th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-if="typeof i.initial_payment !== 'undefined'" v-bind:class="i.initial_payment.is_comm_released | initialIsPaidFormat(i.initial_payment.pre_deducted_amount)">
                                                <td style="text-align:center">1</td>
                                                <td style="text-align:center"> {{i.initial_payment.student_payment_due_date | auDateFormat}} </td>
                                                <td style="text-align:right"> {{i.initial_payment.amount_received | currencyFormat}} </td>
                                                <td style="text-align:center"> {{i.initial_payment.date_paid}} </td>
                                                <td style="text-align:right"> {{i.initial_payment.actual_amount | currencyFormat}} </td>
                                                <td style="width:15%;text-align:right;"> {{i.initial_payment.pre_deducted_amount | currencyFormat}} </td>
                                                <td style="width:15%;text-align:right"> {{i.initial_payment.commission_payable_gst | currencyFormat}} </td>
                                                <td style="width:15%;text-align:center"> <a v-if="i.initial_payment.pre_deducted_amount == 0 || i.initial_payment.actual_amount" v-bind:class="i.initial_payment.is_comm_released | getToggleRelease('class')" @click="toggleRelease(i.initial_payment.id, i.initial_payment.is_comm_released, 'initial', k, 0, 0)"><i v-bind:class="i.initial_payment.is_comm_released | getToggleRelease('font')"></i></a> </td>
                                            </tr>
                                            <tr v-else>
                                                <td style="text-align:center">1</td>
                                                <td style="text-align:center"> - </td>
                                                <td style="text-a   lign:right"> - </td>
                                                <td style="text-align:center"> - </td>
                                                <td style="text-align:right"> - </td>
                                                <td style="width:15%;text-align:right;"> - </td>
                                                <td style="width:15%;text-align:right"> - </td>
                                                <td style="width:15%;text-align:center"> - </td>
                                            </tr>
                                        </tbody>
                                        
                                        <tbody v-for="(vtemp, ktemp) in i.payment_schedule" v-bind:key="ktemp">
                                            
                                            <tr v-for="(vpay, kpay) in vtemp" v-bind:key="vpay.id" v-bind:class=" vpay.is_comm_released | isPaidFormat(vpay.pre_deducted_amount)">
                                                
                                                <td v-if="kpay == 0" v-bind:rowspan="vtemp.length" style="text-align:center">{{ktemp}}</td>
                                                <td v-if="kpay == 0" v-bind:rowspan="vtemp.length" style="text-align:center"> {{vpay.student_payment_due_date | auDateFormat}} </td>
                                                <td style="text-align:right"> {{vpay.amount_received | currencyFormat}} </td>
                                                <td style="text-align:center"> {{vpay.date_paid}} </td>
                                                <td style="text-align:right"> {{vpay.actual_amount | currencyFormat}} </td>
                                                <td style="width:15%;text-align:right;"> {{vpay.pre_deducted_amount | currencyFormat}} </td>
                                                <td style="width:15%;text-align:right"> {{vpay.commission_payable_gst | currencyFormat}} </td>
                                                <td style="width:15%;text-align:center"> <a v-if="vpay.actual_amount != 0" v-bind:class="vpay.is_comm_released | getToggleRelease('class')" @click="toggleRelease(vpay.id, vpay.is_comm_released, 'detail', k, ktemp, kpay)"><i v-bind:class="vpay.is_comm_released | getToggleRelease('font')"></i></a> </td>
                                            </tr>
                                        </tbody>
                                    
                                        <tfoot v-bind:data="count = 2">
                                            <tr>
                                                <td colspan="6" class="text-right">Actual Total Amount Received as of {{dateNow}}:<br>
                                                    Total Calculated Paid Commission as of {{dateNow}}:<br>
                                                    Total Commission Payable as of {{dateNow}}:<br>
                                                    Calculated Pre-Deducted Commission:<br>
                                                    Commission Limit:
                                                </td>
                                                <td class="text-right">{{i | totalFeesPaid | currencyFormat}}<br>
                                                    {{i.stud_commission_payable - i.stud_commission_payable_no_released | currencyFormat}}<br>
                                                    {{i.stud_commission_payable_no_released | currencyFormat}}<br>
                                                    {{i | totalCommAdvance | currencyFormat}}<br>
                                                    {{i.commission_limit}}
                                                </td>
                                            </tr>
                                            
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
    </div>
</template>


<script>

    import moment from "moment";

    export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                agent_id: window.agent.id,
                data: {},
                dateNow: moment().format('DD/MM/YYYY'),
                count: 2,
                getStudPayments : [],
                getStudentID : null,
                app_color: app_color,

            };
        },
        computed:{
            
        },
        created() {
            this.fetchData();
            // console.log(this);
             
        },
        methods: {
            generate_commission(){
                window.open('/agent/commission-report-v4/'+this.agent_id, '_blank');
            },
            fetchData(){
                let vm = this;
                axios.get('/agent/commission-report-v4-view/'+this.agent_id)
                .then(function (response) {
                    // handle success
                    // console.log(response);
                    let x = 0;
                    vm.data = response.data;
                    // console.log(vm.data.students);
                    Object.keys(vm.data.students).forEach((key, element) => {
                        // console.log(key)
                        vm.data.students[key].count = x;
                        if(vm.getStudPayments.length == 0){
                            vm.getStudPayments =   vm.data.students[key].courses;
                            vm.getStudentID = key;
                        }
                        // vm.data.students.key.count = x;
                        x++;
                    });
                    // console.log(vm.data);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            studentPayments(student_id){
                this.getStudPayments = this.data.students[student_id].courses;
                this.getStudentID = student_id;
            },
            toggleRelease(id, release, payType, course, tempArr, detArr){
                // console.log(id + ' - ' + payType);
                let vm = this;
                let t = release == 1 ? 'remove released' : 'release';
                swal.fire({
                    title: 'Are you sure to '+ t +' payment?',
                    // text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes please!'
                }).then((result) => {
                    if (result.value) {

                        // axios post
                        axios.post('/agent/commission-report-v4-view/'+ vm.agent_id +'/toggle-release',{
                            id : id,
                            payType: payType,
                            _token: vm.csrfToken
                        })
                        .then(res => {
                            console.log(res);
                            if(res.data.status == 'success'){
                                if(payType == 'detail'){
                                    vm.getStudPayments[course].payment_schedule[tempArr][detArr].is_comm_released = release == 1 ? 0 : 1;
                                }else{
                                    vm.getStudPayments[course].initial_payment.is_comm_released = release == 1 ? 0 : 1;
                                }
                                swal.fire(
                                    'Success!',
                                    'Commission was '+ res.data.isRelease+' successfully!',
                                    'success'
                                )
                            }else{
                                swal.fire(
                                    'Oopss..',
                                    'There seems to be a problem',
                                    'error'
                                )
                            }
                            
                        })
                        .catch(err => {
                            console.log(err.response.data);
                        });


                        
                    }
                })
            },
        },
        filters: {
            auDateFormat: function (date) {
                return date ? moment(date).format('DD/MM/YYYY') : '';
            },
            currencyFormat: function(number) {
                number = number ? parseInt(number) : 0;
                return '$' + number.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },
            isPaidFormat: function(paid, prededuct) {
                let getClass = '';
                if (paid == 1 || prededuct != 0)
                    getClass = 'paid';
                else if (paid == 2 && prededuct == 0)
                    getClass = 'paid-refund';
                else
                    getClass = '';

                return getClass
            },
            initialIsPaidFormat: function(paid, prededuct) {
                let getClass = '';
                if (paid == 1 )
                    getClass = 'paid';
                else if (paid != 1 && prededuct != 0)
                    getClass = 'paid';
                else
                    getClass = '';

                return getClass
            },
            totalFeesPaid : function(course) {
                let tfp = 0;
                
                tfp +=  typeof course.initial_payment !== 'undefined' ? parseInt(course.initial_payment.actual_amount) : 0;
                if(typeof course.payment_schedule !== 'undefined'){
                    Object.keys(course.payment_schedule).forEach((key, element) => {
                        // console.log(element);
                        console.log();
                        if(typeof course.payment_schedule[key] !== 'undefined'){
                            // console.log(course.payment_schedule.key);
                            Object.keys(course.payment_schedule[key]).forEach((k, v) => {
                                tfp = tfp + parseInt(course.payment_schedule[key][v].actual_amount);
                            });
                        }
                    });
                }
                return tfp;
            },
            totalCommAdvance : function(course) {
                let initalDeduct = 0;
                let tca = 0
                initalDeduct +=  typeof course.initial_payment !== 'undefined' ? parseInt(course.initial_payment.pre_deducted_amount) : 0;
                if(typeof course.payment_schedule !== 'undefined'){
                    Object.keys(course.payment_schedule).forEach((key, element) => {
                        // console.log(element);
                        if(typeof course.payment_schedule[key] !== 'undefined'){
                            // console.log(course.payment_schedule.key);
                            Object.keys(course.payment_schedule[key]).forEach((k, v) => {
                                tca = tca + parseInt(course.payment_schedule[key][v].pre_deducted_amount);
                            });
                        }
                    });
                }
                return tca + initalDeduct;
            },
            getToggleRelease : function(release_id, type) {
                let getClass = 'btn btn-sm';
                let getFont = '';
                if(release_id == 1){
                    getClass += ' btn-danger'; 
                    getFont += 'fas fa-times'; 
                }else{
                    getClass += ' btn-success';
                    getFont += 'fas fa-check'; 
                }

                return type == 'class' ? getClass : getFont;
            }
            
        }
    }
</script>

<style>
    .tab-pane {
        border: 1px solid #e0dfdf;
        border-top: none;
        padding: 1.3rem;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        background-color: #ffffff;
    }

    .paid{background-color: #AED581; color: #3a3939}
    .paid-refund{background-color: #91d1ff;}
    .cancelled-student{color: #f44336 !important; font-family: 'Montserrat-Bold';}
    .not-exact-amount-over{color: #f44336 !important; font-size: 12px;}
    .not-exact-amount-less{color: #FF7032 !important; font-size: 12px;}
    table.legends tr td span{width: 20px;height: 10px;display: inline-block;}
    table.legends tr td span.commission-paid{background-color: #AED581;}
    table.legends tr td span.over-pd{background-color: #f44336;}
    table.legends tr td span.less-pd{background-color: #FF7032;}

    a.btn {
        color: #fff !important;
    }

</style>