<template>

<div class="card shadow mb-4">
    <edit-attendance-modal/>
    <div v-if="classList.length==0">
        <div class="card">
            <div class="card-body">
            No Classes found

            </div>
        </div>
    </div>
    <div v-for="(cl,index) in classList" :key="cl.id" v-else>
        <div class="accordion" :id="'accordion'+cl.id">
            <div class="card buddoy">
                <div class="card-header" :id="'heading'+cl.id">
                <h2 class="mb-0">
                    <button
                    class="btn btn-link collapsed"
                    type="button"
                    data-toggle="collapse"
                    :data-target="'#collapse'+cl.id"
                    aria-expanded="false"
                    :aria-controls="'collapse'+cl.id"
                    >{{cl.student_class.desc}}({{cl.course_code}}) - {{cl.total_hours}} total hours</button>
                    <div class="d-inline-block float-right">
                        <a :href="'/attendance/pdf/'+cl.id" target="_blank" class="btn btn-warning" title="Generate PDF"><i class="fas fa-file-pdf"></i></a>
                        <button class="btn btn-danger" title="Withdraw Class" @click="deleteClass(cl.id)"><i class="fas fa-trash"></i></button>
                    </div>
                </h2>
                </div>
                <div
                :id="'collapse'+cl.id"
                class="collapse"
                :aria-labelledby="'heading'+cl.id"
                :data-parent="'#accordion'+cl.id"
                >
                <div class="card-body">
                    <div v-if="is_open == false">
                        <div class="col-md-12 pull-right text-right">
                        <button class="btn btn-success" @click="admod_attendance">
                        <i class="far fa-save"></i>
                        <span>Add</span>
                        </button>
                        </div>
                    </div>
                    <div v-else>
                        <div class="col-md-12 pull-right text-right">
                            <button class="btn btn-success" @click="saveChanges(index)">
                                <i class="far fa-save"></i> Save Changes
                            </button>
                            <button class="btn btn-danger" @click="cancelEdit(index)">
                                <i class="fa fa-window-close"></i> Cancel 
                            </button>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Date taken:</label>
                                <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                                <date-picker
                                @input="date_change(index)"
                                locale="en"
                                v-model="cl.admod.date_taken"
                                :masks="{L:'DD/MM/YYYY'}"
                                />
                                <div v-if="cl.errors">
                                <span v-if="cl.errors.date_taken" :class="['badge badge-danger']">{{ cl.errors.date_taken[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Status:</label>
                                <select name="" id="" class="form-control" v-model="cl.admod.status">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="N/A">N/A</option>
                                </select>
                                <div v-if="cl.errors">
                                <span v-if="cl.errors.status" :class="['badge badge-danger']">{{ cl.errors.status[0] }}</span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Preferred hours:</label>
                                    <input type="number" class="form-control" v-model="cl.admod.preferred_hours" placeholder="0">
                                    <div v-if="cl.errors">
                                    <span v-if="cl.errors.preferred_hours" :class="['badge badge-danger']">{{ cl.errors.preferred_hours[0] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Actual hours:</label>
                                    <input type="number" class="form-control" v-model="cl.admod.actual_hours" placeholder="0">
                                    <div v-if="cl.errors">
                                    <span v-if="cl.errors.actual_hours" :class="['badge badge-danger']">{{ cl.errors.actual_hours[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                        </div>
                        <!-- <div v-if="toType(cl.admod.id) != 'undefined'">
                            <button class="btn btn-success" @click="saveChanges(index)">
                                <i class="far fa-save"></i> Update
                            </button>
                            <button class="btn btn-danger" @click="cancelEdit(index)">
                                <i class="fa fa-window-close"></i> Cancel 
                            </button>
                        </div>
                        <div v-else>
                            <button class="btn btn-success" @click="saveChanges(index)">
                                <i class="far fa-save"></i> Add
                            </button>
                        </div> -->
                    </div>
                    </div>
                <div class="card-body">
                    <div :class="'horizontal-line-wrapper-'+app_color+' my-3'">
                    <h6>Attendance</h6>
                    </div>
                    <div>
                        <v-client-table
                        :class="'header-'+app_color"
                        :data="cl.attendance_details"
                        :columns="columns"
                        :options="options"
                        ref="courseTable"
                        >
                        
                        <div slot="date_taken" slot-scope="{row}">{{ row.date_taken | dateformat }}</div>
                        <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row,index)">
                            <i class="fas fa-edit"></i>
                            </a>
                            <a
                            href="javascript:void(0)"
                            class="btn btn-danger btn-sm text-white"
                            @click="remove(row.id)"
                            >
                            <i class="fas fa-trash"></i>
                            </a>
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
import StudentModal from "../../classes/attendance/addAttendanceModal.vue";
export default {
    props : ['updateDom'],
    data(){
        return{
            is_open:false,
            app_color:app_color,
            new_class:{
                student_class:[]
            },
            classList:[],
            studentCourses:[],
            isLoading:false,
            errors:[],
            student_id:window.student_id,
            columns: ["id","date_taken","preferred_hours","actual_hours","status","actions"],
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
            }
        }
    },
    mounted(){
       this.getStudentAttendance();
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
        deleteClass(id){
            swal
            .fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            })
            .then(result => {
            if (result.value) {
                axios.post('/classes/delete_student',{
                id:id
                }).then(
                response=>{
                    swal.fire(
                    "Deleted!",
                    "Class has been deleted.",
                    "success"
                    );
                    this.getStudentAttendance();
                }
                ).catch();
            }
            });
        },
        date_change(index){
            var val = this.classList[index].admod.date_taken;
            // console.log(val);
            var d_t = moment(val).format('llll');
            var dt_split = d_t.split(',');
            var day = dt_split[0];
            
            let dis = this;
            swal.fire({
            title: 'Please wait...',
            allowOutsideClick: false,
            onBeforeOpen: () => {
                swal.showLoading()
                },
            });
            axios.get(`/attendance/get_preferred/${this.classList[index].class_id}/${day}`).then(
                response=>{
                if(response.data.status=='success'){
                    // console.log(response.data.hours);
                    this.classList[index].admod.preferred_hours = response.data.hours;
                    swal.close();
                }else if(response.data.status=='error'){
                    swal.fire({
                    type: "error",
                    title: 'Opss. something went wrong.',
                    html:response.data.message
                    });
                    this.classList[index].admod.preferred_hours = 0;
                }else{
                    swal.close();
                    this.classList[index].admod.preferred_hours = 0;
                }
                }
            ).catch(
                err=>{
                swal.fire({
                    type: "error",
                    title: 'Opss. something went wrong.',
                    html:err
                    });
                }
            );
        },
        admod_attendance(){
            this.is_open = true;
        },
        toType(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },
        cancelEdit(idx){
            this.is_open = false;
            this.classList[idx].admod = {preferred_hours:0};
            // this.classList[idx].admod.preferred_hours = 0;
        },
        // getPrefTime(ind){
        //     if(this.classList[ind].unit!='' && this.classList[ind].class_date){
        //         swal.fire({
        //             title: 'Please wait...',
        //             allowOutsideClick: false,
        //             onBeforeOpen: () => {
        //             swal.showLoading()
        //             },
        //         });
        //         axios.post('/classes/trainer-classes/get_pref_time',{'class_id':this.classList[ind].class_id,'date':this.classList[ind].class_date,'unit_code':this.classList[ind].unit.code}).then(
        //             response=>{
        //                 if(response.data!=''){
        //                     this.classList[ind].pref_time.time_start = response.data.pref_time_start;   
        //                     this.classList[ind].pref_time.time_end = response.data.pref_time_end;   
        //                 }else{
        //                     this.classList[ind].pref_time.time_start = this.classList[ind].student_class.class_start_time;   
        //                     this.classList[ind].pref_time.time_end = this.classList[ind].student_class.class_end_time;  
        //                 }
        //                 swal.close();
        //             }
        //         );   
        //     }
        // },
        edit(row,idx){
            this.is_open = true;
            row.date_taken = moment(row.date_taken)._d;
            
            this.classList[idx].admod = row;

            window.scroll(0,window.pageYOffset=150);
        },
        remove(id) {
            swal
                .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                })
                .then(result => {
                if (result.value) {
                    axios.post('/classes/delete_attendance_detail',{
                    id:id
                    }).then(
                    response=>{
                        swal.fire(
                        "Deleted!",
                        "Class has been deleted.",
                        "success"
                        );
                        this.getStudentAttendance();
                    }
                    ).catch();
                }
            });
        },
        getUnitInfo({code,description}){
            return `${code} ${description}`;
        },
        showAddAttendance(){
            this.$modal.show('add-attendance-modal');
        },
        getCoursesInfo(){

        },
        getCourses(){
            axios.get('/student/domestic/get_courses/'+this.student_id).then(
                response=>{
                    this.studentCourses = response.data;
                }
            );
        },
        getClassInfo({desc,trainer}){
             return `${desc} - ${trainer.firstname} ${trainer.lastname}`;
        },
        getStudentAttendance(){
            axios.get('/student/domestic/get_classes/'+this.student_id).then(
                response=>{
                    let vm = this;
                    let data = [];
                    response.data.forEach(function(e){
                        e.errors = [];
                        e.units = [];
                        e.pref_time = {
                            time_start:null,
                            time_end:null,
                        };
                        e.admod = {
                            preferred_hours:0
                        };
                        axios.get('/student/domestic/get_units/'+e.student_id+'/'+e.course_code).then(
                            response=>{
                                if(response.data.length > 0){
                                     response.data.forEach(function(units){
                                        e.units.push(units);
                                    });
                                }
                            }
                        );
                        data.push(e);
                    });
                    // console.log(data);
                    vm.classList = data;
                }
            );
        },
        saveChanges(e){
            var pref_hours = typeof this.classList[e].admod.preferred_hours=='undefined'?8:this.classList[e].admod.preferred_hours;
            var actual_hours = typeof this.classList[e].admod.actual_hours=='undefined'?0:this.classList[e].admod.actual_hours;
            console.log('pref hours');
            console.log(pref_hours);
            console.log('actual hours');
            console.log(actual_hours);
            swal.fire({
                title: 'Please wait...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                swal.showLoading()
                },
            });
        if(parseInt(actual_hours)>parseInt(pref_hours)){
            this.classList[e].errors = {
                actual_hours:['Must be lesser than preferred hours.']
            }
            Toast.fire({
                type: "error",
                title: "Opss.. something went wrong",
                background: "#ffcdd2"
            });
        }else if(this.classList[e].actual_hours==''){
            if(parseInt(this.classList[e].preferred_hours)>8){
                this.classList[e].errors = {
                    actual_hours:['Must be lesser than preferred hours.']
                }
                Toast.fire({
                    type: "error",
                    title: "Opss.. something went wrong",
                    background: "#ffcdd2"
                });
            }
        }else{
            if(typeof this.classList[e].admod.id !='undefined'){//update
                console.log('update');
                this.classList[e].admod.attendance_id = this.classList[e].id;
                axios.post('/attendance/update_student_attendance_detail',this.classList[e].admod).then(
                            response=>{
                                console.log(response.data);
                            if(response.data.status=='error'){
                                this.errors = response.data.errors;
                                Toast.fire({
                                type: "error",
                                title: "Opss.. something went wrong",
                                background: "#ffcdd2"
                                });
                            }else{
                                swal.fire(
                                "Succes!",
                                "Data updated successfully.",
                                "success"
                                );
                                // this.$modal.hide("edit-attendance-sheet");
                                this.getStudentAttendance();
                                this.is_open = false;
                            }
                            }
                        ).catch(
                        e=>{
                            console.log(e);
                            Toast.fire({
                            type: "error",
                            title: "Opss.. something went wrong",
                            background: "#ffcdd2"
                            });
                        }
                    );
            }else{
                console.log('store');
                this.classList[e].admod.attendance_id = this.classList[e].id;
                axios.post('/attendance/new_student_attendance_detail',this.classList[e].admod).then(
                    response=>{
                        let dis = this;
                        if(response.data.status=='error'){
                        dis.classList[e].errors = response.data.errors;
                        Toast.fire({
                            type: "error",
                            title: "Opss.. something went wrong",
                            background: "#ffcdd2"
                        });
                        }else{
                            Toast.fire({
                            // position: 'top-end',
                            type: "success",
                            title: "Data is saved successfully",
                            background: "#DCEDC8"
                            });
                            this.is_open = false;
                            this.getStudentAttendance();
                        }
                    }
                ).catch(
                    e=>{
                    console.log(e);
                    Toast.fire({
                        type: "error",
                        title: "Opss.. something went wrong",
                        background: "#ffcdd2"
                        });
                    }
                );
                }
            }
        }
    },
    watch: {
        updateDom : function(newVal,oldVal){
            // console.log(newVal);
        }
    }
}
</script>
<style>
    html {
        scroll-behavior: smooth;
    }
</style>