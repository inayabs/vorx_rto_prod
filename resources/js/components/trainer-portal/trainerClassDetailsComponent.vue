<template>
    <div>
        <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Description:</label>
                    <span>{{this.$props.class_details.desc}}</span>
                </div>                
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Course:</label>
                    <span>{{this.$props.class_details.course_code}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Delivery Location:</label>
                    <span>{{this.$props.class_details.delivery_loc?this.$props.class_details.delivery_location.train_org_dlvr_loc_name:''}}</span>   
                </div>
             </div>
             <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Delivery Mode:</label>
                    <span v-if="class_details.delivery_mode!=''">{{this.$props.class_details.del_mode.value}} - {{this.$props.class_details.del_mode.description}}</span>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Venue:</label>
                    <span>{{this.$props.class_details.venue?this.$props.class_details.venue:''}}</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                <label for="">Start-End Date:</label>
                <span>{{this.$props.class_details.start_date?dateformat(this.$props.class_details.start_date):''}} - {{this.$props.class_details.end_date?dateformat(this.$props.class_details.end_date):''}}</span>                 
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Class Start Time:</label>
                    <span>{{this.$props.class_details.class_start_time?timeformat(this.$props.class_details.class_start_time):''}} - {{this.$props.class_details.class_end_time?timeformat(this.$props.class_details.class_end_time):''}}</span>
                </div>
                 
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Trainers:</label>
                        <span v-for="(ti,index) in this.$props.class_details.trainer_selected" :key="ti.id">
                            {{ti.firstname?ti.firstname:''}} {{ti.lastname?ti.lastname:''}}<span v-if="index!= trainer_count - 1">, {{ti.length}}</span> 
                        </span>              
                </div>
            </div>
            
            </div>
            <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Status</label><br>
                    <select name="" id="class_status" class="form-control" @change="statusUpdate()" v-model="status"> 
                        <option :value="opt" v-for="opt in status_options" :key="opt" v-if="opt==class_detail.class_status" selected>{{opt}}</option>
                        <option :value="opt" v-else>{{opt}}</option>
                    </select>       
                </div>
            </div>
        </div>
      </div>
      

      <div class="card-body">
          <v-client-table
          :class="'header-'+app_color"
          :data="attendanceList"
          :columns="columns"
          :options="options"
          ref="courseTable"
        >
            <div slot="#" slot-scope="{index}">
                {{index}}
            </div>
            <div slot="funded_course" slot-scope="{row}">
                {{dateformat(row.funded_course.start_date)}} - {{dateformat(row.funded_course.end_date)}}
            </div>
          </v-client-table>
      </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
export default {
    props:['class_details'],
    data(){
        return{
            app_color:app_color,
            trainer_count:this.$props.class_details?this.$props.class_details.trainer_selected.length:'',
            attendanceList:[],
            columns: ["#","student.student_id","student.party.name","student.type.type","funded_course"],
            status_options:[
                '',
                'Not yet taken',
                'Ongoing',
                'Finish'
            ],
            class_detail:this.$props.class_details,
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
                'student.student_id': "Student id",
                'student.party.name': "Student",
                'student.type.type':"Student type",
                'funded_course':"Course span"
                },
                sortable: ["id", "code", "name"],
                rowClassCallback(row) {
                return (row.id = row.id);
                },
                columnClasses: { id: "class-is" },
                texts: {
                filter: "Search:",
                filterPlaceholder: "Search keywords"
                }
            },
            status:this.$props.class_details.class_status,
            previous_selected:''
        }
    },
    created(){
        this.fetchAttendance();
    },
    methods:{
        statusUpdate(){
            // var class_status = $('#class_status').val();
            var class_status = this.status;
            if(class_status!=''){
                swal.fire({
                    title: 'Please wait...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                    swal.showLoading()
                    },
                });
                axios.get('/classes/trainer-classes/update-status/'+this.$props.class_details.id+'/'+class_status).then(
                    response=>{
                        this.$emit('statusUpdate');
                        Toast.fire({
                        // position: 'top-end',
                        type: "success",
                        title: "Class status is saved successfully",
                        background: "#DCEDC8"
                        });
                    }
                ).catch();
            }else{
                swal.fire({
                    allowOutsideClick: false,
                    type:"error",
                    title:"Not Saved",
                });
            }
        },
        dateformat: function(date) {
        if (!date) return "";
        date = moment(date).format("DD/MM/YYYY");
        return date;
        },
        timeformat: function(time){
            if (!time) return "";
            time = moment('1111-11-11 '+time).format("hh:mm A");
            return time;
        },
        fetchAttendance() {
            axios.get("/attendance/fetch_attendance/"+this.$props.class_details.id).then(response => {
            this.attendanceList = response.data;
            });
        },
    },
}
</script>