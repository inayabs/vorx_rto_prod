<template>
  <modal
    name="attendance-sheet-modal"
    transition="nice-modal-fade"
    classes="demo-modal-class"
    :min-width="500"
    :min-height="500"
    :pivot-y="0.1"
    :adaptive="true"
    :scrollable="true"
    :reset="true"
    width="60%"
    height="auto"
    @before-open="beforeOpen"
    @opened="opened"
    @closed="closed"
    @before-close="beforeClose"
  >
    <div class="size-modal-content px-1">
      <form @submit.prevent> <br>
          <div class="col-md-12">
              <p class="text-center"><u>Attendance Sheet</u></p>
          </div>
          
        <div class="row">
                        
        </div>
        <div class="row p-3">
            <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                <button :class="'btn btn-'+app_color"><i class="fas fa-arrow-circle-left"></i> Back</button>
            </div>
        
            <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                <button :class="'btn btn-'+app_color">Next <i class="fas fa-arrow-circle-right"></i></button>
            </div>
        </div>
        <div class="clearfix w-100"></div>
      </form>
    </div>
  </modal>
</template>
<script>
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
      errors: {},
      new_attendance:{
          student:'',
          class_date:'',
          class_id:window.class_id,
      },
      studentList:[],
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
    }
  },
  mounted(){
    //   this.getStudents();
  },
  methods: {
    
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
    saveAttendance(){
     
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
form{
    margin-top: 50px;
}
</style>