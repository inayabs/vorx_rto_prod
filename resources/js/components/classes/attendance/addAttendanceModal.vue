<template>
  <modal
    name="add-attendance-modal"
    transition="nice-modal-fade"
    classes="demo-modal-class"
    :min-width="200"
    :min-height="200"
    :pivot-y="0.1"
    :adaptive="true"
    :scrollable="true"
    :reset="true"
    width="40%"
    height="auto"
    @before-open="beforeOpen"
    @opened="opened"
    @closed="closed"
    @before-close="beforeClose"
  >
    <div class="size-modal-content px-1">
      <h4 :class="'modal-header-'+app_color">New Attendance</h4>
      <form @submit.prevent>
        <div class="row">
            
            <div class="col-md-12">
                <div :class="['form-group', errors.student ? 'has-error' : '']" >
                <label for="deliver_loc">Course Unit</label>
                  <div v-if="units!=''">
                    <multiselect v-model="new_student_attendance.unit" 
                    :options="units" 
                    :custom-label="getUnitInfo"
                    placeholder="Select one" 
                    label="getUnitInfo" 
                    track-by="id"
                    ></multiselect>
                  </div>
                  <div v-else>
                    No unit available
                  </div>
                  <span v-if="errors.unit" :class="['badge badge-danger']">{{ errors.unit[0] }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.class_date ? 'has-error' : '']" >
                    <label for="start_date">Class Date</label>
                    <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                    <date-picker
                    locale="en"
                    v-model="new_student_attendance.class_date"
                    :masks="{L:'DD/MM/YYYY'}"
                    />
                    <span v-if="errors.class_date" :class="['badge badge-danger']">{{ errors.class_date[0] }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div :class="['form-group', errors.class_date ? 'has-error' : '']" >
                    <label for="start_time">Start Time</label>
                    <input 
                    id="start_time" 
                    name="start_time" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="time" 
                    v-model="new_student_attendance.class_start_time">
                    <span v-if="errors.class_start_time" :class="['badge badge-danger']">{{ errors.class_start_time[0] }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div :class="['form-group', errors.class_date ? 'has-error' : '']" >
                    <label for="end_time">End Time</label>
                    <input 
                    id="end_time" 
                    name="end_time" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="time" 
                    v-model="new_student_attendance.class_end_time">
                    <span v-if="errors.class_end_time" :class="['badge badge-danger']">{{ errors.class_end_time[0] }}</span>
                </div>
            </div>
        </div>
        <button :class="'btn btn-'+app_color+' btn-sm mt-3 float-right'" @click="saveAttendance">
          <i class="far fa-save"></i> Save
        </button>
        <div class="clearfix w-100"></div>
      </form>
    </div>
  </modal>
</template>
<script>
import moment from "moment";
const Toast = swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000
});

export default {
  data() {
    return {
      // student_completion:window.student_completion[0]['details'],
      app_color: app_color,
      units:window.units,
      errors: {},
      course_units:{},
      student_attendance:window.student_attendance,
      new_student_attendance:{
        class_date:'',
        attendance_id:window.student_attendance.id,          
        unit:'',
        class_start_time:'',
        class_end_time:''
      },
      isModal: "true",
      opt: [],
      isLoading: false
    };
  },
  watch: {
    fields: function(value) {
      if (value.code != null) {
        this.errors.code = "";
      }
      if (value.name != null) {
        this.errors.name = "";
      }
    },
    new_student_attendance: function(value){
      this.new_student_attendance = moment(value.class_date)._d;
    } 
  },
  mounted(){
      // this.getUnits();
  },
  methods: {
    getUnitInfo({code,description}){
        return `${code} ${description}`;
    },
    getUnits(){
        axios.get('/course/prospectus/list/'+this.student_attendance.course_code).then(
            response=>{
                this.course_units = response.data[0].course_units;
            }
        );
    },
    beforeOpen(e) {
      this.fields = {};
    },
    beforeClose(e) {
      this.isLoading = false;
    },
    opened(e) {
      // e.ref should not be undefined here
      // console.log('opened', e)
      // console.log('ref', e.ref)
    },
    closed(e) {
      this.new_student_attendance.class_date='',
      this.new_student_attendance.attendance_id=window.student_attendance.id,          
      this.new_student_attendance.unit='',
      this.new_student_attendance.class_start_time='',
      this.new_student_attendance.class_end_time=''
      this.errors = "";
    },
    saveAttendance(){
      swal.fire({
        title: 'Please wait...',
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading()
        },
      });
      axios.post('/attendance/new_student_attendance_detail',{
        class_date:this.new_student_attendance.class_date?moment(this.new_student_attendance.class_date).format('YYYY-MM-DD'):'',
        attendance_id:this.new_student_attendance.attendance_id,          
        unit:this.new_student_attendance.unit,
        class_start_time:this.new_student_attendance.class_start_time,
        class_end_time:this.new_student_attendance.class_end_time
      }).then(
          response=>{
            if(response.data.status=='error'){
              this.errors = response.data.errors;
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
                this.new_student_attendance.class_date='',
                this.new_student_attendance.attendance_id=window.student_attendance.id,          
                this.new_student_attendance.unit='',
                this.new_student_attendance.class_start_time='',
                this.new_student_attendance.class_end_time=''
                this.$modal.hide("add-attendance-modal");
                this.$parent.getStudentAttendance();
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
};
</script>
<style scoped>
.size-modal-content {
  padding: 10px;
  margin: 10px;
  font-style: 13px;
}
.v--modal-overlay[data-modal="size-modal"] {
  background: rgba(0, 0, 0, 0.5);
}
.demo-modal-class {
  border-radius: 5px;
  background: #f7f7f7;
  box-shadow: 5px 5px 30px 0px rgba(46, 61, 73, 0.6);
}
</style>