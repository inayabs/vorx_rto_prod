<template>
  <modal
    name="create-class-modal"
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
      <h4 :class="'modal-header-'+app_color">Add Class</h4>
      <form @submit.prevent>
        <div class="row">
            <div class="col-md-12">
                <div :class="['form-group', errors.description ? 'has-error' : '']" >
                  <label for="description">Class Name</label>
                  <input 
                    id="description" 
                    name="description" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="text" 
                    v-model="student_class.description">
                  <span v-if="errors.description" :class="['badge badge-danger']">{{ errors.description[0] }}</span>
                </div>
            </div>
            <!-- <div class="col-md-6">
                <div :class="['form-group', errors.time_table_type ? 'has-error' : '']" >
                  <label for="time_table_type">Time Table Type</label>
                  <select name="time_table_type" id="time_table_type" class="form-control" v-model="student_class.time_table_type">
                    <option value="Straight">Straight</option>
                    <option value="Rotating">Rotating</option>
                  </select>
                  <span v-if="errors.time_table_type" :class="['badge badge-danger']">{{ errors.time_table_type[0] }}</span>
                </div>
            </div> -->
            <div class="col-md-12">
                <div :class="['form-group', errors.course_code ? 'has-error' : '']" >
                <label for="course_code">Course</label>
                 <multiselect v-model="student_class.course_code" 
                 :options="courses" 
                 :custom-label="courseCode"
                  placeholder="Select one" 
                  @select="selectCourse"
                  label="code" 
                  track-by="id"></multiselect>
                  
                  <span v-if="errors.course_code" :class="['badge badge-danger']">{{ errors.course_code[0] }}</span>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
              <div :class="['form-group', errors.trainer ? 'has-error' : '']" >
              <label for="trainer">Trainer</label>
              <multiselect 
              v-model="student_class.trainer" 
              :options="trainers" 
              :custom-label="trainerName" 
              :multiple="true"
              :close-on-select="false"
              placeholder="Select Trainer(s)" 
              label="firstname" 
              track-by="id">
                </multiselect>
                <span v-if="errors.trainer" :class="['badge badge-danger']">{{ errors.trainer[0] }}</span>
              </div>
          </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.delivery_loc ? 'has-error' : '']" >
                <label for="deliver_loc">Delivery Location</label>
                 <multiselect v-model="student_class.delivery_loc" 
                 :options="delivery_locations" 
                 :custom-label="deliveryLocations"
                 @select="selectDelLoc"
                  placeholder="Select one" 
                  label="deliveryLocation" 
                  track-by="id"></multiselect>
                  
                  <span v-if="errors.delivery_loc" :class="['badge badge-danger']">{{ errors.delivery_loc[0] }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
              <div :class="['form-group', errors.location ? 'has-error' : '']" >
                <label for="state">State</label>
                <select v-model="student_class.location" class="form-control" v-if="lockState == 0">
                  <option v-for="(i,k) in getLocationsFromCourse" :key="k" :value="i">{{i}}</option>
                </select>
                <select v-model="student_class.location" class="form-control" disabled v-else>
                  <option v-for="(i,k) in getLocationsFromCourse" :key="k" :value="i">{{i}}</option>
                </select>

                <span v-if="errors.location" :class="['badge badge-danger']">{{ errors.location[0] }}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div :class="['form-group', errors.venue ? 'has-error' : '']" >
                <label for="venue">Venue</label>
                <input 
                  id="venue" 
                  name="venue" 
                  value=""  
                  autofocus="autofocus" 
                  class="form-control" 
                  type="text" 
                  v-model="student_class.venue">
                <span v-if="errors.venue" :class="['badge badge-danger']">{{ errors.venue[0] }}</span>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div :class="['form-group', errors.delivery_modes ? 'has-error' : '']" >
                <label for="delivery_modes">Delivery Mode</label>
                 <multiselect v-model="student_class.delivery_mode" 
                 :options="delivery_modes" 
                 :custom-label="deliveryModes"
                  placeholder="Select one" 
                  label="deliveryModes" 
                  track-by="value"></multiselect>
                  
                  <span v-if="errors.delivery_loc" :class="['badge badge-danger']">{{ errors.delivery_loc[0] }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.start_date ? 'has-error' : '']" >
                  <label for="start_date">Start Date</label>
                  <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                    <date-picker
                    locale="en"
                    v-model="student_class.start_date"
                    :masks="{L:'DD/MM/YYYY'}"
                    />
                  <span v-if="errors.start_date" :class="['badge badge-danger']">{{ errors.start_date[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.end_date ? 'has-error' : '']" >
                  <label for="end_date">End Date</label>
                  <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                    <date-picker
                    locale="en"
                    v-model="student_class.end_date"
                    :masks="{L:'DD/MM/YYYY'}"
                    :min-date="student_class.start_date"
                    />
                  <span v-if="errors.end_date" :class="['badge badge-danger']">{{ errors.end_date[0] }}</span>
                </div>
            </div>
        </div>
        <button :class="'btn btn-'+app_color+' btn-sm mt-3 float-right'" @click="saveClass">
          <i class="far fa-save"></i> Save
        </button>
        <div class="clearfix w-100"></div>
      </form>
    </div>
  </modal>
</template>
<script>
import moment from 'moment';
const Toast = swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000
});

export default {
  data() {
    return {
      fields: {
        course: []
      },
      trainers:window.trainers?window.trainers:[],
      delivery_locations:window.delivery_loc?window.delivery_loc:[],
      delivery_modes:window.delivery_modes?window.delivery_modes:[],
      courses:window.courses?window.courses:[],
      selected_course : {},
      // lockState: 0,
      app_color: app_color,
      student_class: {
          description:'',
          time_table_type:'Straight',
          trainer:'',
          delivery_loc:'',
          delivery_mode:'',
          course_code:'',
          start_date:'',
          end_date:'',
          class_start_time:'',
          class_end_time:'',
          venue:''
      },
      errors: {},
      isModal: "true",
      opt: [],
      isLoading: false
    };
  },
  computed: {
    getLocationsFromCourse() {
      let ex = '';
      if(this.selected_course.id) {
        // console.log('in?');
        if(this.selected_course.courseprospectus[0]) {
          let prospect = this.selected_course.courseprospectus;
          for(let i = 0 ; i < prospect.length ; i++) {
            ex += i != 0 ? ',' : '';
            ex += prospect[i].location;

          }
        }
      }
      return ex.split(',');
    },
    lockState () {
      if(this.student_class.delivery_loc) {
        return 1;
      }
      return 0;
    }
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
    // 'student_course.delivery_loc' : function (newval) {
    //   if(newval) {
    //     this.lockState =  1;
    //   }else {
    //     this.lockState =  0;
    //   }
    // }
  },
  methods: {
    selectCourse(course) {
        this.selected_course = course;
    },
    selectDelLoc(delLoc) {
      console.log(delLoc);
      if(delLoc.state) {
        this.student_class.location = delLoc.state.state_key;
      }
    },
    trainerName({firstname,lastname}){
      return `${firstname} ${lastname}`
    },
    deliveryLocations({train_org_dlvr_loc_name}){
      return `${train_org_dlvr_loc_name}`;
    },
    deliveryModes({value,description}){
      return `${value} - ${description}`;
    },
    courseCode({code,name}){
      return  `${code} - ${name}`;
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
      this.errors = "";
    },
    saveClass(){
      swal.fire({
        title: 'Please wait...',
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading()
        },
      });
      axios.post('/classes/add_class',{
        description:this.student_class.description,
        trainer:this.student_class.trainer,
        delivery_loc:this.student_class.delivery_loc,
        delivery_mode:this.student_class.delivery_mode,
        location:this.student_class.location,
        course_code:this.student_class.course_code,
        start_date:this.student_class.start_date?moment(this.student_class.start_date).format('YYYY-MM-DD'):'',
        end_date:this.student_class.end_date?moment(this.student_class.end_date).format('YYYY-MM-DD'):'',
        class_start_time:this.student_class.class_start_time,
        class_end_time:this.student_class.class_end_time,
        time_table_type:this.student_class.time_table_type,
        venue:this.student_class.venue
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
                this.$modal.hide("create-class-modal");
                this.$parent.fetchClasses();
            }
          }
      ).catch(
        e=>{
          console.log(e);
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