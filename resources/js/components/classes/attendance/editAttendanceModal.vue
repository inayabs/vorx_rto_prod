<template>
  <modal
    name="edit-attendance-sheet"
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
      <h4 :class="'modal-header-'+app_color">Edit Attendance</h4>
      <form @submit.prevent>
        <!-- <div class="row">
            
            <div class="col-md-12">
                <div :class="['form-group', errors.course_unit ? 'has-error' : '']" >
                <label for="deliver_loc">Course Unit</label>
                  <div v-if="units!=''">
                    <multiselect v-model="student_attendance.course_unit" 
                    :options="units" 
                    :custom-label="getUnitInfo"
                    placeholder="Select one" 
                    label="getUnitInfo" 
                    track-by="id"
                    ></multiselect>
                  </div>
                  <div v-else>
                     <span class="fa fa-ban"></span> No unit available
                  </div>
                  <span v-if="errors.course_unit" :class="['badge badge-danger']">{{ errors.course_unit[0] }}</span>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.date_taken ? 'has-error' : '']" >
                    <label for="class_date">Class Date</label>
                    <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                    <date-picker
                    locale="en"
                    v-model="student_attendance.date_taken"
                    :masks="{L:'DD/MM/YYYY'}"
                    />
                    <span v-if="errors.date_taken" :class="['badge badge-danger']">{{ errors.date_taken[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.status ? 'has-error' : '']" >
                    <label for="class_date">Status</label>
                    <select name="" id="" v-model="student_attendance.status" class="form-control">
                      <option value="Present">Present</option>
                      <option value="Absent">Absent</option>
                      <option value="N/A">N/A</option>
                    </select>
                    <span v-if="errors.date_taken" :class="['badge badge-danger']">{{ errors.status[0] }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.preferred_hours ? 'has-error' : '']" >
                    <label for="start_time">Preferred hours</label>
                    <input 
                    id="start_time" 
                    name="start_time" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="number" 
                    v-model="student_attendance.preferred_hours">
                    <span v-if="errors.preferred_hours" :class="['badge badge-danger']">{{ errors.preferred_hours[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.time_end ? 'has-error' : '']" >
                    <label for="end_time">Actual hours</label>
                    <input 
                    id="end_time" 
                    name="end_time" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="number" 
                    v-model="student_attendance.actual_hours">
                    <span v-if="errors.actual_hours" :class="['badge badge-danger']">{{ errors.actual_hours[0] }}</span>
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
      app_color: app_color,
      // units:window.units,
      units:[],
      errors: {},
      course_units:{},
      student_attendance:{},
      isModal: "true",
      opt: [],
      isLoading: false
    };
  },
  watch: {
    student_attendance : function(value){
        this.student_attendance.date_taken = moment(value.date_taken)._d;
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
      let dis = this;
        axios.get('/student/domestic/get_units/'+this.student_attendance.attendance.student_id+'/'+this.student_attendance.attendance.course_code).then(
            response=>{
              let unitz = [];
                response.data.forEach(function(units){
                    // dis.units = units;
                    unitz.push(units);
                });
              this.units = unitz;
            }
        );
    },
    beforeOpen(e) {
        this.student_attendance = e.params;
        this.getUnits();
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

      var start_time = this.student_attendance.time_start;
      var end_time = this.student_attendance.time_end;

      if(this.student_attendance.actual_hours>this.student_attendance.preferred_hours){
          this.errors = {
            actual_hours:['Must be lesser than preferred hours.']
          }
          Toast.fire({
              type: "error",
              title: "Opss.. something went wrong",
              background: "#ffcdd2"
              });
      }else{
        axios.post('/attendance/update_student_attendance_detail',{
          attendance_id:this.student_attendance.attendance_id,
          course_unit:this.student_attendance.course_unit,
          date_taken: moment(this.student_attendance.date_taken).format('YYYY-MM-DD'),
          id:this.student_attendance.id,
          student_sig:this.student_attendance.student_sig,
          preferred_hours:this.student_attendance.preferred_hours,
          actual_hours:this.student_attendance.actual_hours,
          trainer_sig:this.student_attendance.trainer_sig,
          unit_code:this.student_attendance.unit_code,
          status:this.student_attendance.status,
          class_id:this.student_attendance.attendance.class_id
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
                 swal.fire(
                  "Succes!",
                  "Data updated successfully.",
                  "success"
                  );
                  this.$modal.hide("edit-attendance-sheet");
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