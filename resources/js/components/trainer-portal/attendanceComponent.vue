<template>
<div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Date</label>
                    <date-picker
                    :placeholder="'Select date'"
                    locale="en"
                    v-model="filter.date"
                    :masks="{L:'DD/MM/YYYY'}"
                />
            </div>
        </div>
        <!-- <div class="col-lg-9">
            <div class="form-group">
                <label for="">Unit</label>
                <multiselect
                    v-model="filter.unit"
                    :options="units"
                    :multiple="false"
                    :class="'multiselect-color-'+app_color"
                    placeholder="Select unit"
                    :trackBy="units.code"
                    :custom-label="unitName"
                />
            </div>
        </div> -->
    </div>
    <div class="row" v-if="studentList!=''">
        <div class="col-lg-12">
            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'">
                <h6>
                    <div class="row">
                        <div class="col-lg-3 mx-auto">
                            <div class="btn-group">
                                <a
                                    @click="getStudents()"
                                    href="javascript:void(0)"
                                    class="btn btn-danger"
                                    slot="afterLimit"
                                >
                                    <span>Student List</span>
                                </a>
                            </div>
                        </div>
                        <div style="text-align:right;" class="col-lg-9">
                            <div class="btn-group" v-if="att_det_count>0">
                                <a
                                    @click="clearAttendance"
                                    href="javascript:void(0)"
                                    class="btn btn-info"
                                    slot="afterLimit"
                                    title="Delete all data from this record."
                                >
                                    <i class="fas fa-trash"></i><span>Clear All</span>
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
                    </div>
                </h6>
                
            </div>
            <!-- <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Preferred time start</label>
                        <input type="time" class="form-control" v-model="pref_time.time_start">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Preferred time end</label>
                        <input type="time" class="form-control" v-model="pref_time.time_end">
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="form-group">
                        <label for=""></label>
                        <a
                        @click="getClassTime"
                        href="javascript:void(0)"
                        class="btn btn-info btn-sm form-control"
                        title="Copy class time"
                        >
                            <i class="fa fa-copy"></i>
                        </a>
                        
                    </div>
                </div>
            </div> -->
            <div style="height:24px;"></div>
            
            <div class="row">
                <div class="col-sm-6" style="margin-bottom:5px;" v-for="(sl,index) in studentList" :key="index" :id="index">
                    <div :class="'card border-'+border_color(sl.status)" :style="'background:'+bg_color(sl.status)">
                        <div>
                            #{{index+1}}
                            <select style="float:right" v-model="sl.statuz"  v-if="sl.attendance_today!=null" @change="status_change">
                                <!-- <option value="" disabled>Status</option> -->
                                <option value="Present">Present</option>    
                                <option value="Absent">Absent</option>    
                                <option value="N/A">N/A</option>    
                            </select>
                        </div>
                        <div class="card-horizontal">
                            <div class="card-body col-lg-4">
                                <img class="rounded-circle img-fluid" :src="'/storage/user/avatars/'+getImage(sl.user)" alt="Preview not avail" style="width:100%;">
                            </div>
                            <div class="card-body col-lg-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        {{sl.student.party.name}}
                                        <p style="font-size:12px;">{{sl.student_id}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Preferred hours</label>
                                            <input type="number" class="form-control" v-model="sl.preferred_hours" placeholder="8">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Actual hours</label>
                                            <input type="number" class="form-control" v-model="sl.actual_hours" placeholder="0">
                                        </div>
                                    </div>
                                </div>
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
export default {
    data(){
        return{
            app_color:app_color,
            filter:{
                date:null,
                unit:null
            },
            pref_attendance:[],
            att_det_count:0,
            studentList:[],
            errors:[],
            error_messages:[],
            err_message_list:{
                one:'Actual hours must be lesser than preferred hours.',
                // two:'Time start must not be blank if time end has data.',
                // three:'Time end must not be blank if time start has data.'
            }
        }
    },
    props:['units',"class_details"],
    watch:{
        pref_time:{
            handler(_){
                this.studentList.forEach(function(sl){
                    sl.time_start = _.time_start;
                    sl.time_end = _.time_end;
                });
            },
            deep:true
        },
        filter:{
            handler(_){
                // if(_.date!=null && _.unit!=null){
                //     this.getStudents();
                //     // this.getPrefTime();
                // }else{
                //     this.studentList = []
                // }
                if(_.date!=null){
                    this.getStudents();
                    // this.getPrefTime();
                }else{
                    this.studentList = []
                }
                
            },
            deep:true
        },
        studentList:{
            handler(sl){
                var errors = [];

                for(var i = 0; i < sl.length; i++){

                    var preferred_hours = sl[i].preferred_hours!=null ? parseInt(sl[i].preferred_hours) : 8;
                    var actual_hours = sl[i].actual_hours!=null ? parseInt(sl[i].actual_hours) : 0;
                    
                    // if(time_end != null){
                        if(actual_hours>preferred_hours){
                            var obj = {
                                line            : i+1,
                                error_message   : this.err_message_list.one
                            };
                            errors.push(obj);
                        }
                        // else if(time_start==null||typeof time_start == 'undefined'){
                        //     var obj = {
                        //         line            : i+1,
                        //         error_message   : this.err_message_list.two
                        //     }
                        //     errors.push(obj);
                        // }
                    // }else if(time_start !=null){
                    //     if(time_end==null||typeof time_end == 'undefined'){
                    //         var obj = {
                    //             line            : i+1,
                    //             error_message   : this.err_message_list.three
                    //         }
                    //         errors.push(obj);
                    //     }
                    }
                

                this.errors = errors;
            },
            deep:true
        }
    },
    methods:{
        // getClassTime(){
        //     this.pref_time.time_start = this.class_details.class_start_time;   
        //     this.pref_time.time_end = this.class_details.class_end_time; 
        // },
        // getPrefTime(){
        //     axios.post('/classes/trainer-classes/get_pref_time',{'class_id':this.class_details.id,'date':this.filter.date,'unit_code':this.filter.unit.unit.code}).then(
        //         response=>{
        //             if(response.data!=''){
        //                 this.pref_time.time_start = response.data.pref_time_start;   
        //                 this.pref_time.time_end = response.data.pref_time_end;   
        //             }else{
        //                 this.pref_time.time_start = this.class_details.class_start_time;   
        //                 this.pref_time.time_end = this.class_details.class_end_time;  
        //             }
        //         }
        //     );    
        // },
        status_change(e){
            var status = e.currentTarget.value;
            var idx = e.target.parentElement.parentElement.parentElement.id;
            var old_status = this.studentList[idx].status;
            let dis = this;
            swal.fire({
                title: "Are you sure?",
                text: this.studentList[idx].student.party.name+"'s status will be changed.",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!"
            }).then(
                result=>{
                    if(result.value){
                        this.studentList[idx].status = status;
                        this.studentList[idx].statuz = status;
                        axios.post('/classes/trainer-classes/update_student_class_status',this.studentList[idx]).then(
                            response=>{
                                if(response.data.response=='success'){
                                    this.getStudents(1);
                                    swal.fire(
                                        'Saved!',
                                        'Data saved successfully.',
                                        'success'
                                    )
                                }else{
                                    swal.fire({
                                        type: 'error',
                                        title: 'Something went wrong.',
                                        text:response.data.message
                                    })
                                }
                            }
                        ).catch(
                            err=>{
                                swal.fire({
                                    type: 'error',
                                    title: 'Something went wrong.',
                                })
                                dis.studentList[idx].status = old_status;
                                dis.studentList[idx].statuz = old_status;
                            }
                        );
                    }else{
                        this.studentList[idx].status = old_status;
                        this.studentList[idx].statuz = old_status;
                    }
                }
            );
        },
        getImage(user){
            if(user!=''&&user!=null&&typeof user!='undefined'){
                if(user.profile_image!=''&&user.profile_image!=null&&typeof user.profile_image!='undefined'){
                    return user.profile_image;
                }else{
                    return 'default-profile.png';
                }
            }else{
                return 'default-profile.png';
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
                        axios.post('/classes/trainer-classes/clear-attendance',
                        {
                            'class_id':this.class_details.id,
                            'date':this.filter.date,
                            'student_list':this.studentList,
                            'unit':this.filter.unit,
                            }).then(
                            response=>{
                                if(response.data.message=='success'){
                                    swal.fire(
                                        "Cleared!",
                                        "Attendance Cleared.",
                                        "success"
                                    );
                                    this.getStudents(1);
                                    // this.getPrefTime();
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
        border_color(status){
            if(status=='Present'){
                return 'success';
            }else if(status=='Absent'){
                return 'danger';
            }
        },
        bg_color(status){
            if(status=='Present'){
                return '#D6F8D6';
            }else if(status=='Absent'){
                return '#E4C5AF';
            }else{
                return '#FFFFFF'
            }
        },
        saveAttendance(){
            var errors_count = this.errors.length;
            if(errors_count>0){
                let html = '<ul style="margin-left: 10% !important;">';

                this.errors.forEach(v => {
                    html += '<li style="text-align:left !important; font-size: 16px; color: #ff5757 !important;">Student #: '+v.line+' : '+v.error_message+'</li>';
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
                    axios.post('/classes/trainer-classes/save-attendance',
                    {
                        'class_id':this.class_details.id,
                        'date':this.filter.date,
                        'student_list':this.studentList,
                        'unit':this.filter.unit,
                        'pref_time':this.pref_time,
                        }).then(
                        response=>{
                            if(response.data==='success'){
                                this.getStudents(1);
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
        unitName({unit}){
            return `${unit.code} - ${unit.description}`;
        },
        getStudents(x=0){
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
            axios.post('/classes/trainer-classes/class-students2',{'class_id':this.class_details.id,'date':this.filter.date,'unit':this.filter.unit}).then(
                response=>{
                    // let dis  = this;
                    // response.data.forEach(function(data){
                    //     dis.attendance_dates.time_start = data.attendance_today?data.attendance_today.time_start:null;
                    //     dis.attendance_dates.time_end = data.attendance_today?data.attendance_today.time_end:null;
                    // });
                    var times = [];
                    for(var i = 0;i<response.data.students.length;i++){
                        var time = {};
                        response.data.students[i].preferred_hours = response.data.students[i].attendance_today?response.data.students[i].attendance_today.preferred_hours:null;
                        response.data.students[i].actual_hours = response.data.students[i].attendance_today?response.data.students[i].attendance_today.actual_hours:null;
                        response.data.students[i].status = response.data.students[i].attendance_today?response.data.students[i].attendance_today.status:'';
                        response.data.students[i].statuz = response.data.students[i].attendance_today?response.data.students[i].attendance_today.status:'';
                    }
                    this.att_det_count = response.data.att_det_count;
                    this.studentList = response.data.students;
                    if(x==0){
                        swal.close();
                    }
                }
            ).catch();
            
        },
        removeSeconds(time){
            // console.log(time);
            if(time!=null){
                var nt = time.split(':');
                var newTime = nt[0]+':'+nt[1];
                return newTime;
            }
        },
    }
}
</script>
<style>
.card-horizontal {
  display: flex;
  flex: 1 1 auto;
}
</style>