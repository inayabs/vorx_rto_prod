<template>
    <div>
        <div class="accordion" :id="'accordion'+index+class_detail.id">
            <div class="card buddoy" :id="'heading'+index+class_detail.id">
                <div class="card-header" :id="'heading'+index+class_detail.id">
                    <h2 class="mb-0">
                        <button
                        class="btn btn-link collapsed"
                        type="button"
                        data-toggle="collapse"
                        :data-target="'#collapse'+index+class_detail.id"
                        aria-expanded="false"
                        :aria-controls="'collapse'+index+class_detail.id"
                        >{{u.unit.code}} - {{u.unit.description}} ({{u.dates.start | dateformat}} - {{u.dates.end | dateformat}})<span v-if="u.isRotate===1" class="badge badge-pill badge-success">Rotate</span></button>
                    </h2>
                </div>
                <div
                :id="'collapse'+index+class_detail.id"
                class="collapse"
                :aria-labelledby="'heading'+index+class_detail.id"
                :data-parent="'#accordion'+index+class_detail.id"
                >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Date</label>
                                     <date-picker
                                        :min-date="class_detail.start_date"
                                        :max-date="class_detail.end_date"
                                        :placeholder="'Select date'"
                                        locale="en"
                                        v-model="date"
                                        :masks="{L:'DD/MM/YYYY'}"
                                    />
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" v-if="studentList!=''">
                            <div class="col-lg-12">
                                <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'">
                                    <h6>Student List</h6>
                                </div>
                                <v-client-table
                                :class="'header-'+app_color"
                                :data="studentList"
                                :columns="columns"
                                ref="courseTable"
                                :options="options"
                                >   
                                    <div slot="#" slot-scope="{index}">
                                        {{index}}
                                    </div>
                                    <div slot="time_start" slot-scope="{index}">
                                        <input type="time" class="form-control" v-model="studentList[index-1].time_start">
                                    </div>
                                    <div slot="time_end" slot-scope="{index}">
                                        <input type="time" class="form-control" v-model="studentList[index-1].time_end">
                                    </div>
                                    <div slot="actions" slot-scope="{index}">
                                        <button type="button" class="btn btn-warning" @click="resetTime(index)"><i class="fas fa-undo"></i></button>
                                    </div>

                                    <div slot="afterLimit" class="ml-2">
                                        <div class="btn-group" v-if="att_det_count>0">
                                        <a
                                            @click="clearAttendance"
                                            href="javascript:void(0)"
                                            class="btn btn-danger"
                                            slot="afterLimit"
                                        >
                                            <i class="fas fa-trash"></i><span>Clear Attendance</span>
                                        </a>
                                        </div>
                                        <div class="btn-group">
                                        <a
                                            @click="saveAttendance"
                                            href="javascript:void(0)"
                                            class="btn btn-success"
                                            slot="afterLimit"
                                        >
                                            <i class="fas fa-save"></i> <span v-if="att_det_count>0">Update</span><span v-else>Save</span>
                                        </a>
                                        </div>
                                    </div>
                                </v-client-table>
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
    props:['unit','i','class_details'],
    data(){
        return{
            app_color:app_color,
            date:null,
            u:this.$props.unit,
            index:this.$props.i,
            select_counter:0,
            class_detail:this.$props.class_details,
            columns:[
                '#',
                'attendance_today.id',
                'student.party.name',
                'student.student_id',
                'time_start',
                'time_end',
                'actions'
            ],
            options:{
                filterable:true,
                headings:{
                    'attendance_today.id':'att_id',
                    'student.party.name':'Name',
                    'student.student_id':'Student id'
                },
                // orderBy:{
                //     column:'student.party.name',
                //     ascending:true
                // },
                hiddenColumns:[
                    'attendance_today.id'
                ]
            },
            studentList:[],
            att_det_count:0,
            errors:[],
            error_messages:[],
            err_message_list:{
                one:'Time start must be earlier than time end input.',
                two:'Time start must not be blank if time end has data.'
            }
        }
    },
    created(){
        
    },
    watch:{
        date(){
            this.getStuds();
        },
        studentList:{
            handler(sl){
                var errors = [];

                for(var i = 0; i < sl.length; i++){
                    var time_start = sl[i].time_start;
                    var time_end = sl[i].time_end;
                    
                    if(time_end != null){
                        if(time_start>time_end){
                            var obj = {
                                line            : i+1,
                                error_message   : this.err_message_list.one
                            };
                            errors.push(obj);
                        }else if(time_start==null||typeof time_start == 'undefined'){
                            var obj = {
                                line            : i+1,
                                error_message   : this.err_message_list.two
                            }
                            errors.push(obj);
                        }
                    }
                }

                this.errors = errors;
            },
            deep:true
        }
    },
    filters:{
        dateformat: function(date) {
            if (!date) return "";
            date = moment(date).format("DD/MM/YYYY");
            return date;
        },
        timeformat: function(time){
            if (!time) return "";
            time = moment('1111-11-11 '+time).format("hh:mm A");
            return time;
        }
    },
    methods:{
        endChange(i){
            var err = this.errors;
            var err_msgs = this.error_messages;
            // console.log(err);
            var time_start = this.studentList[i].time_start;
            var time_end = this.studentList[i].time_end;
            let index = i+1;
            
            if(time_start>time_end){
                err.forEach(function(errors){
                    if(!err.includes(index)){
                        err.push({'line':index,'error_message':this.err_message_list.one});
                        this.errors = err;
                    };
                });
            }else if(time_start==null||typeof time_start == 'undefined'){
                if(!err.includes(index)){
                    this.errors = err;

                    //error msg
                    if(!err_msgs.includes(this.err_message_list.two)){
                        err.push({'line':index,'error_message':this.err_message_list.two});
                    }
                };
            }else{
                this.errors.forEach(function(erz){
                    dis = this;
                    if(erz.line == index){
                        delete dis.erz;
                    }
                });
            }
            // console.log(err);    
            // console.log(time_end);
        },
        getStuds(x=0){
            let dis = this;
            if(x==0){
                    swal.fire({
                    title: 'Please wait...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                    swal.showLoading()
                    },
                });
            }
            if(this.date != null){
                axios.post('/classes/trainer-classes/class-students',{'class_id':this.class_detail.id,'date':this.date,'unit':this.u}).then(
                    response=>{
                        // let dis  = this;
                        // response.data.forEach(function(data){
                        //     dis.attendance_dates.time_start = data.attendance_today?data.attendance_today.time_start:null;
                        //     dis.attendance_dates.time_end = data.attendance_today?data.attendance_today.time_end:null;
                        // });
                        var times = [];
                        for(var i = 0;i<response.data.students.length;i++){
                            var time = {};
                            response.data.students[i].time_start = response.data.students[i].attendance_today?dis.removeSeconds(response.data.students[i].attendance_today.time_start):null;
                            response.data.students[i].time_end = response.data.students[i].attendance_today?dis.removeSeconds(response.data.students[i].attendance_today.time_end):null;
                        }
                        this.att_det_count = response.data.att_det_count;
                        this.studentList = response.data.students;
                        if(x==0){
                            swal.close();
                        }
                    }
                ).catch();
            }else{
                this.studentList = [];
                swal.close();
            }
        },
        removeSeconds(time){
            // console.log(time);
            if(time!=null){
                var nt = time.split(':');
                var newTime = nt[0]+':'+nt[1];
                return newTime;
            }
            
        },
        saveAttendance(){
            // console.log(this.index_with_errors.length);
            var errors_count = this.errors.length;
            if(errors_count>0){
                let html = '<ul style="margin-left: 10% !important;">';

                this.errors.forEach(v => {
                    html += '<li style="text-align:left !important; font-size: 16px; color: #ff5757 !important;">Line #: '+v.line+' : '+v.error_message+'</li>';
                })
                html += '</ul>';

                swal.fire({
                    type: 'error',
                    title: 'Cannot proceed.',
                    html: html
                })
            }else{
                swal.fire({
                    title: 'Please wait...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                    swal.showLoading()
                    },
                });
                
                if(this.studentList!=''){
                    axios.post('/classes/trainer-classes/save-attendance',{'class_id':this.class_detail.id,'date':this.date,'student_list':this.studentList,'unit':this.u}).then(
                        response=>{
                            if(response.data==='success'){
                                this.getStuds(1);
                                swal.fire(
                                    'Saved!',
                                    'Data saved successfully.',
                                    'success'
                                )
                            }
                        }
                    ).catch(
                        err=>{
                            swal.fire({
                                type: 'error',
                                title: 'Something went wrong.',
                            })
                        }
                    );
                }else{
                    swal.fire({
                    type: "error",
                    title: "Date field is required."
                });
                }  
            }
            
        },
        clearAttendance(){
            swal.fire({
                title: "Are you sure?",
                text: "Attendance data will be cleared!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!"
            }).then(
                result=>{
                    if(result.value){
                        axios.post('/classes/trainer-classes/clear-attendance',{'class_id':this.class_detail.id,'date':this.date,'student_list':this.studentList,'unit':this.u}).then(
                            response=>{
                                if(response.data.message=='success'){
                                    swal.fire(
                                        "Cleared!",
                                        "Attendance Cleared.",
                                        "success"
                                    );
                                    this.getStuds(1);
                                }
                            }
                        ).catch(
                            err=>{
                                
                            }
                        );
                    }
                }
            );
        },
        resetTime(index){
            this.studentList[index-1].time_start = null;
            this.studentList[index-1].time_end = null;            
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

table tbody tr td input.vc-text-base {
  font-size: 12px !important;
}
.highlight {
  color: red;
}
</style>