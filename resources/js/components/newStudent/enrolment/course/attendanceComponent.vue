<template>

    <!-- <edit-attendance-modal/> -->
            <div>

                <div>
                    <div class="row mb-3">

                    <div class="col-md-12 pull-right text-right">
                            <!-- <a type="button" v-bind:class="'btn btn-info btn-sm'" target="_blank" :href="'/classes/attendance/'+cl.class_id" title="Go to class module"><i class="fas fa-eye"></i>  View class</a> -->
                            <a type="button" v-bind:class="'btn btn-'+app_color+' btn-sm'" target="_blank" :href="'/attendance/pdf/'+attendance.id"><i class="fas fa-file-pdf"></i>  Generate Student Attendance</a>
                    </div>
                    </div>
                    <div :class="'horizontal-line-wrapper-'+app_color+' my-3'">
                    <h6>Add New</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Date taken:</label>
                                <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                                <date-picker
                                locale="en"
                                v-model="attendance.admod.date_taken"
                                :masks="{L:'DD/MM/YYYY'}"
                                />
                                <div v-if="attendance.errors">
                                <span v-if="attendance.errors.date_taken" :class="['badge badge-danger']">{{ attendance.errors.date_taken[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Status:</label>
                                <select name="" id="" class="form-control" v-model="attendance.admod.status">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="N/A">N/A</option>
                                </select>
                                <div v-if="attendance.errors">
                                <span v-if="attendance.errors.status" :class="['badge badge-danger']">{{ attendance.errors.status[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Preferred hours:</label>
                                <input type="number" class="form-control" v-model="attendance.admod.preferred_hours" placeholder="8">
                                <div v-if="attendance.errors">
                                <span v-if="attendance.errors.preferred_hours" :class="['badge badge-danger']">{{ attendance.errors.preferred_hours[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Actual hours:</label>
                                <input type="number" class="form-control" v-model="attendance.admod.actual_hours" placeholder="0">
                                <div v-if="attendance.errors">
                                <span v-if="attendance.errors.actual_hours" :class="['badge badge-danger']">{{ attendance.errors.actual_hours[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                    <div v-if="typeof attendance.admod.id != 'undefined'">
                        <button class="btn btn-success" @click="saveChanges()">
                            <i class="far fa-save"></i> Update
                        </button>
                        <button class="btn btn-danger" @click="cancelEdit()">
                            <i class="fa fa-window-close"></i> Cancel
                        </button>
                    </div>
                    <div v-else>
                         <button class="btn btn-success" @click="saveChanges()">
                            <i class="far fa-save"></i> Add
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div :class="'horizontal-line-wrapper-'+app_color+' my-3'">
                    <h6>Attendance</h6>
                    </div>
                    <div>
                        <v-client-table
                        :class="'header-'+app_color"
                        :data="attendance.attendance_details"
                        :columns="columns"
                        :options="options"
                        ref="courseTable"
                        >

                        <div slot="date_taken" slot-scope="{row,}">{{ row.date_taken | dateformat }}</div>
                        <div class="btn-group" slot="actions" slot-scope="{index}">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(index-1)" title="edit">
                            <i class="fas fa-edit"></i>
                            </a>
                            <a
                            href="javascript:void(0)"
                            class="btn btn-danger btn-sm text-white"
                            @click="remove(index-1)"
                            >
                            <i class="fas fa-trash"></i>
                            </a>
                        </div>
                        </v-client-table>
                    </div>
                </div>
                </div>

</template>
<script>
import moment from "moment";
import { mapMutations } from 'vuex';
// import StudentModal from "../../classes/attendance/addAttendanceModal.vue";
export default {
    props : ['attendance'],
    data(){
        return{
            app_color:app_color,
            new_class:{
                student_class:[]
            },
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
    //    this.getStudentAttendance();
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
        ...mapMutations(['updateEnrolment']),
        edit(idx){
            this.attendance.attendance_details[idx].date_taken = moment(this.attendance.attendance_details[idx].date_taken)._d;
            this.attendance.admod = this.attendance.attendance_details[idx]
            window.scroll(0,window.pageYOffset=350);
        },
        cancelEdit(){
            this.attendance.admod = {}
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
                        // this.getStudentAttendance();
                    }
                    ).catch();
                }
            });
        },
        getUnitInfo({code,description}){
            return `${code} ${description}`;
        },
        // showAddAttendance(){
        //     this.$modal.show('add-attendance-modal');
        // },
        getCoursesInfo(){

        },
        getCourses(){
            axios.get('/student/domestic/get_courses/'+this.student_id).then(
                response=>{
                    this.studentCourses = response.data;
                }
            );
        },
        // getClassInfo({desc,trainer}){
        //      return `${desc} - ${trainer.firstname} ${trainer.lastname}`;
        // },
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
                        axios.get('/student/domestic/get_units/'+e.student_id+'/'+e.course_code).then(
                            response=>{
                                response.data.forEach(function(units){
                                    e.units.push(units);
                                });
                            }
                        );
                        data.push(e);
                    });
                    // console.log(data);
                    vm.attendance = data;
                }
            );
        },
        saveChanges(){
            var pref_hours = typeof this.attendance.admod.preferred_hours=='undefined'?8:this.attendance.admod.preferred_hours;
            var actual_hours = typeof this.attendance.admod.actual_hours=='undefined'?0:this.attendance.admod.actual_hours;
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
                this.attendance.errors = {
                    actual_hours:['Must be lesser than preferred hours.']
                }
                Toast.fire({
                    type: "error",
                    title: "Opss.. something went wrong",
                    background: "#ffcdd2"
                });
            }else{
                if(typeof this.attendance.admod.id != 'undefined'){//store
                    console.log('update');
                    this.attendance.admod.attendance_id = this.attendance.id;
                    axios.post('/attendance/update_student_attendance_detail',this.attendance.admod).then(
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
                                this.$modal.hide("edit-attendance-sheet");
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
                    swal.close();
                }else{
                    console.log('store');
                    this.attendance.admod.attendance_id = this.attendance.id;
                    axios.post('/attendance/new_student_attendance_detail',this.attendance.admod).then(
                        response=>{
                            let dis = this;
                            if(response.data.status == 'error'){
                                dis.attendance.errors = response.data.errors;
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
                                console.log(response.data.enrolment_pack);
                                this.updateEnrolment(response.data.enrolment_pack);
                            }
                        }
                    ).catch(
                        err=>{

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
