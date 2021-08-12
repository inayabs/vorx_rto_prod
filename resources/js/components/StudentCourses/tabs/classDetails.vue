<template>
    <div v-if="this.$props.course.attendance">
        <div class="row">
            <div class="col-md-12">
                <a type="button" v-bind:class="'btn btn-'+app_color+' btn-sm float-right'" target="_blank" :href="'/attendance/pdf/'+course.attendance.id"><i class="fas fa-file-pdf"></i>  Generate Student Attendance</a>
            </div>
        </div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'">
            <h6>Class Details</h6>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Description:</label>
                    <span>{{course.attendance.student_class.desc}}</span>
                    <!-- <input type="text" class="form-control" readonly :value="this.$props.course.attendance.student_class.desc"> -->
                </div>                
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Course:</label>
                    <span>{{course.attendance.student_class.course_code}} - {{course.course.name}}</span>
                    <!-- <input type="text" class="form-control" readonly :value="this.$props.course.attendance.student_class.course_code"> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Delivery Location:</label>
                    <span v-if="course.attendance.student_class.delivery_loc!=null">{{course.attendance.student_class.delivery_location.train_org_dlvr_loc_name}}</span>
                    <!-- <input type="text" class="form-control" readonly :value="this.$props.course.attendance.student_class.delivery_loc?this.$props.course.attendance.student_class.delivery_location.train_org_dlvr_loc_name:''">     -->
                </div>
             </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Venue</label>
                    <span v-if="course.attendance.student_class.venue!=null">{{course.attendance.student_class.venue}}</span>
                    <!-- <input type="text" class="form-control" readonly :value="this.$props.course.attendance.student_class.venue?this.$props.course.attendance.student_class.venue:''"> -->
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Delivery Mode: </label>
                    <span v-if="course.attendance.student_class.delivery_mode!=null">{{course.attendance.student_class.del_mode.value}} - {{course.attendance.student_class.del_mode.description}}</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                <label for="">Start-End Date:</label>
                <span>{{course.attendance.student_class.start_date}} - {{course.attendance.student_class.end_date}}</span>
                </div>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Class Start-End Time:</label>
                    <span>{{course.attendance.student_class.class_start_time}} - {{course.attendance.student_class.class_end_time}}</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Trainers</label>
                    <span v-for="(ti,index) in course.attendance.student_class.trainer_selected" :key="ti.id"> {{ti.firstname}} {{ti.lastname}}<span v-if="index!= Object.keys(course.attendance.student_class.trainer_selected).length - 1">,</span> </span>
                    
                </div>
            </div>
        </div> -->
        <br>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'">
            <h6>Attendance</h6>
        </div>
        <v-client-table
          :class="'header-'+app_color"
          :data="this.$props.course.attendance.attendance_details"
          :columns="columns"
          ref="courseTable"
        >
        <div slot="#" slot-scope="{index}">{{ index }}</div>
        <div slot="date_taken" slot-scope="{row}">{{ row.date_taken | dateformat }}</div>
        <div slot="time_start" slot-scope="{row}">{{ row.time_start | timeformat }}</div>
        <div slot="time_end" slot-scope="{row}">{{ row.time_end | timeformat }}</div>
        </v-client-table>
    </div>
    <div v-else>
        No class found.
    </div>
</template>
<script>
import moment from "moment";
export default {
    props:['course'],
    data(){
        return{
            app_color:app_color,
            columns: ["#","id","date_taken","time_start","time_end","status"],
            trainer_count:this.$props.course.attendance?this.$props.course.attendance.student_class.trainer_selected.length:''
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
    }
}
</script>