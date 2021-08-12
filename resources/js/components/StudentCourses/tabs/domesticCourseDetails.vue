<template>
    <div>
        <!-- <button class="btn float-right"> 
            <a
            @click="generate_training_plan()"
            target="_blank"
            >
            <i class="far fa-file-pdf text-danger"></i>&nbsp; Trainings Plan
            </a>
        </button> -->
        <div class="clearfix"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'">
            <h6>Course Details</h6>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Course</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.course_code+' - '+this.$props.course.course.name">
                </div>                
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <label for="">Class</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.attendance?this.$props.course.attendance.student_class?this.$props.course.attendance.student_class.desc?this.$props.course.attendance.student_class.desc:'':'':''">
                </div>                
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Eligibility</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.eligibility=='E'?'Eligible':'Not Eligible'">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Location</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.state.state_name">                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Start Date</label>
                    <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                    <input type="text" class="form-control" readonly :value="this.$props.course.start_date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">End Date</label>
                    <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                    <input type="text" class="form-control" readonly :value="this.$props.course.end_date">
                </div>                
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Course Fee Type</label>
                    <input type="text" class="form-control" readonly :value="course_fee">
                </div>                
            </div>
            <div class="col-md-6">
                <div class="form-group">    
                    <label for="">Course Fee</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.course_fee">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Status</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.status.description?this.$props.course.status.description:''">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">AISS</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.aiss_date">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Remarks</label>
                    <textarea rows="3" class="form-control" readonly :value="this.$props.course.remarks"></textarea>
                </div>
            </div>
        </div>
        <br>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'">
            <h6>Enrolment Details</h6>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">    
                    <label for="">Funding Type</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.funding_type?this.$props.course.detail.funding_type.name:'':''">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Funding Source National</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.funding_source_national?this.$props.course.detail.funding_source_national.description:'':''">                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Commencing Course</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.commence_prg_identifier?this.$props.course.detail.commence_prg_identifier.description:'':''">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Training Contract</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.training_contract_id?this.$props.course.detail.training_contract_id:'':''">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Client ID Appreticeships</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.client_id_apprenticeships?this.$props.course.detail.client_id_apprenticeships:'':''">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Study Reason</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.study_reason?this.$props.course.detail.study_reason.description:'':''">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Specific Funding</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.specific_funding?this.$props.course.detail.specific_funding.description:'':''">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Funding Source State</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.funding_source_state?this.$props.course.detail.funding_source_state.description:'':''">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Purchasing Contract</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.purchasing_contract_id?this.$props.course.detail.purchasing_contract_id:'':''">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Purchasing Contract Schedule</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.purchasing_contract_schedule_id?this.$props.course.detail.purchasing_contract_schedule_id:'':''">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Associated Course</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.associated_course_id?this.$props.course.detail.associated_course_id:'':''">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Predominant Delivery Mode</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.predominant_delivery_mode?this.$props.course.detail.pdelivery_mode.description:'':''">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Full-time Learning Option</label>
                    <input type="text" class="form-control" readonly :value="this.$props.course.detail?this.$props.course.detail.full_time_leaning_option?this.$props.course.detail.full_time_leaning_option:'':''">
                </div>
            </div>
        </div>
        <br>
        <!-- <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'">
            <h6>Subject List</h6>
        </div>
        <table :class="'table header-'+app_color" id="dataTable" width="100%">
            <thead>
                <th :class="'table-header-'+app_color" style="width:5%!important">#</th>
                <th :class="'table-header-'+app_color">Unit</th>
                <th :class="'table-header-'+app_color">Description</th>
                <th :class="'table-header-'+app_color">Start date</th>
                <th :class="'table-header-'+app_color">End date</th>
                <th :class="'table-header-'+app_color">Training delivery location</th>
                <th :class="'table-header-'+app_color">Delivery mode</th>
            </thead>
            <tbody>
                <tr v-for="(unit,index) in units" :key="unit.id" style="font-size:12px">
                    <td width="5%">{{index+1}}</td>
                    <td width="10%">{{unit.course_unit_code?unit.course_unit_code:''}}</td>
                    <td width="20%">{{unit.unit.description?unit.unit.description:''}}</td>
                    <td width="15%">{{unit.start_date|dateformat}}</td>
                    <td width="15%">{{unit.end_date|dateformat}}</td>
                    <td width="15%">{{unit.training_delivery_location?unit.training_delivery_location.addr_location:''}}</td>
                    <td width="15%">{{unit.delivery_mode?unit.delivery_mode.description:''}}</td>     
                </tr>
            </tbody>
        </table> -->
        <!-- <br> -->
        <!-- <div v-if="student_type==2">
            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'">
            <h6>Unit of Competency</h6>
            </div>
            <div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Description</label><br>
                        <span>
                            {{this.$props.course.uc_description?this.$props.course.uc_description:''}}
                        </span>
                    </div>
                </div>
            </div>
            <table :class="'table header-'+app_color" id="dataTable" width="100%">
                <thead>
                    <th :class="'table-header-'+app_color" style="width:5%!important">#</th>
                    <th :class="'table-header-'+app_color">Unit</th>
                    <th :class="'table-header-'+app_color">Description</th>
                    <th :class="'table-header-'+app_color">Start date</th>
                    <th :class="'table-header-'+app_color">End date</th>
                    <th :class="'table-header-'+app_color">Training delivery location</th>
                    <th :class="'table-header-'+app_color">Delivery mode</th>
                </thead>
                <tbody>
                    <tr v-for="(unit,index) in extra_unitz" :key="unit.id" style="font-size:12px">
                            <td width="5%">{{index+1}}</td>
                            <td width="10%">{{unit.course_unit_code?unit.course_unit_code:''}}</td>
                            <td width="20%">{{unit.unit.description?unit.unit.description:''}}</td>
                            <td width="15%">{{unit.start_date|dateformat}}</td>
                            <td width="15%">{{unit.end_date|dateformat}}</td>
                            <td width="15%">{{unit.training_delivery_location?unit.training_delivery_location.addr_location:''}}</td>
                            <td width="15%">{{unit.delivery_mode?unit.delivery_mode.description:''}}</td>                
                    </tr>
                </tbody>
            </table>
        </div> -->
    </div>
</template>
<script>
import moment from "moment";
export default {
    props:['course'],
    data(){
        return{
            app_color:app_color,
            student_type:window.student.student_type_id,
            courseDetails:[],
            columns: ["id","course_unit_code","unit.description","start_date","end_date","train_org_loc_id","delivery_mode_id"],
            options: {
                initialPage: 1,
                perPage: 10,
                highlightMatches: true,
                sortIcon: {
                base: "fas",
                up: "fa-sort-amount-up",
                down: "fa-sort-amount-down",
                is: "fa-sort"
                },
                headings: {
                'course_nit_code':'Unit',
                'unit.description':'Description'
                },
                sortable: ["id", "code", "name"],
                rowClassCallback(row) {
                return (row.id = row.id);
                },
                columnClasses: { id: "class-is" },
                texts: {
                filter: "Search:",
                filterPlaceholder: "Search keywords"
                },
            },
            all_units:this.$props.course.subjects?this.$props.course.subjects.details:''
        }
    },
    methods: {
        generate_training_plan() {
            window.open(
                `/training_plan/${window.student.student_id}/${this.$props.course.id}`,
                "_blank"
            );
        },
    },
    filters:{
        dateformat: function(date) {
        if (!date) return "";
        date = moment(date).format("DD/MM/YYYY");
        return date;
        },
    },
    computed:{
        units:function(){
            return this.all_units.filter(i=>i.extra_unit==0);
        },
        extra_unitz:function(){
            return this.all_units.filter(i=>i.extra_unit==1);
        },
        
        course_fee: function () {
            if(this.course.course_fee_type == 'FF') {
                return 'Full Fee';
            }else if (this.course.course_fee_type == 'NC') {
                return 'Non - Concessional'
            } else if (this.course.course_fee_type == 'C') {
                return 'Concessional';
            }
        }

    }
}
</script>
