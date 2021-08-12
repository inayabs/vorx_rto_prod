<template >
  <div>
    <edit-attendance-modal/>
    <add-payment :payment_template="payment_template"></add-payment>
    <div class="row mt-2 mb-3">
      <div class="col-md-12 mb-3 text-right mb-3">
        
        <div class="form-group" style="display:inline-block">
          <select @change="updateStatus" v-model="student_status" class="form-control" name id>
            <option
              v-for="(status) in statuses"
              :key="status.id"
              :value="status.id"
            >{{ status.description }}</option>
          </select>
        </div>
        <div style="display:inline-block;width:250px;" v-if="attendance!=''">
          <multiselect v-model="attendance[0].student_class" 
          :disabled=true
          @select = "selectCourse"
          :options="availClasses" 
          :custom-label="getClassInfo"
          placeholder="Select one" 
          label="getClassInfo" 
          track-by="id"
          ></multiselect>
        </div>
        <div style="display:inline-block;width:250px;" v-else>
          <multiselect v-model="selected_class" 
          @select = "selectCourse"
          :options="availClasses" 
          :custom-label="getClassInfo"
          placeholder="Select one" 
          label="getClassInfo" 
          track-by="id"
          ></multiselect>
        </div>
        <!-- <button @click="resetPayment" class="btn btn-warning" style="display:inline-block">
          <i class="fas fa-recycle"></i> Reset Payment Schedule
        </button>-->
        <button @click="viewTrainingPlan" class="btn btn-info" style="display:inline-block">
          <i class="fas fa-plan"></i> View Training Plan
        </button>
        <a
          :href="`/offer-letter/pdf/course_detail/${detail.id}`"
          target="_blank"
          class="btn btn-success"
          style="display:inline-block"
        >
          <i class="fas fa-file-pdf"></i> View PDF
        </a>
      </div>
      <div class="card-body" v-for="att in attendance" :key="att.id">
        <div class="row mb-3">
        <div class="col-md-12 pull-right text-right">
                <a type="button" v-bind:class="'btn btn-'+app_color+' btn-sm'" target="_blank" :href="'/attendance/pdf/'+att.id"><i class="fas fa-file-pdf"></i>  Generate Student Attendance</a>
            
            <button class="btn btn-success" @click="saveChanges(att.id)">
            <i class="far fa-save"></i> Save Changes
            </button>
        </div>
        </div>
        <div :class="'horizontal-line-wrapper-'+app_color+' my-3'">
        <h6>Add New</h6>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Unit Code:</label>
                      <multiselect v-model="new_att.unit" 
                      :options="att.units" 
                      :custom-label="getUnitInfo"
                      placeholder="Select one" 
                      label="getUnitInfo" 
                      track-by="id"
                      ></multiselect>
                    <div v-if="errors">
                    <span v-if="errors.unit" :class="['badge badge-danger']">{{ errors.unit[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Date taken:</label>
                    <span style="font-size: 74%;opacity: 73%;">( DD/M/YYYY )</span>
                    <date-picker
                    locale="en"
                    v-model="new_att.class_date"
                    :masks="{L:'DD/MM/YYYY'}"
                    />
                    <div v-if="errors">
                    <span v-if="errors.class_date" :class="['badge badge-danger']">{{ errors.class_date[0] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time start:</label>
                    <input type="time" class="form-control" v-model="new_att.class_start_time">
                    <div v-if="errors">
                    <span v-if="errors.class_start_time" :class="['badge badge-danger']">{{ errors.class_start_time[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time end:</label>
                    <input type="time" class="form-control" v-model="new_att.class_end_time">
                    <div v-if="errors">
                    <span v-if="errors.class_end_time" :class="['badge badge-danger']">{{ class_end_time[0] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <v-client-table
        :class="'header-'+app_color"
        :data="att.attendance_details"
        :columns="columns"
        :options="options"
        >
        <div slot="date_taken" slot-scope="{row}">{{ row.date_taken | dateformat }}</div>
        <div slot="time_start" slot-scope="{row}">{{ row.time_start | timeformat }}</div>
        <div slot="time_end" slot-scope="{row}">{{ row.time_end | timeformat }}</div>
        <div class="btn-group" slot="actions" slot-scope="{row}">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)">
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
</template>
<script>
import moment from 'moment';
import addPayment from "./addPaymentComponent.vue";
export default {
  components: {
    addPayment,
  },
  props: ["detail"],
  mounted() {
    // console.log(this.detail);
    this.getClasses();
    this.getStudentAttendance();
  },
  data() {
    return {
      offer_letter_id:window.offer,
      statuses: window.offer_status,
      student_status: this.detail.status_id,
      payment_template: "",
      app_color: app_color,
      availClasses : [],
      selected_class:'',
      new_student_attendance:{
        selected_class:[],
      },
      columns: ["id","date_taken","time_start","time_end","unit_code","actions"],
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
      },
      errors:[],
      attendance:[],
      new_att:{
        unit:[],
        class_date:'',
        class_start_time:'',
        class_end_time:''
      },
      units:[],
    };
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
  methods: {
    saveChanges(id){
        let dis = this;
            // var class_name = 'class'+id;
            swal.fire({
            title: 'Please wait...',
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
            swal.showLoading()
            },
        });
        axios.post('/attendance/new_student_attendance_detail',{
          attendance_id : id,
          unit: this.new_att.unit.unit,
          class_date:this.new_att.class_date?moment(this.new_att.class_date).format('YYYY-MM-DD'):'',
          class_start_time:this.new_att.class_start_time,
          class_end_time:this.new_att.class_end_time
        }).then(
            response=>{
                let dis = this;
                if(response.data.status=='error'){
                dis.errors = response.data.errors;
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
                    this.new_att.class_date='',          
                    this.new_att.unit='',
                    this.new_att.class_start_time='',
                    this.new_att.class_end_time=''
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
    },
    edit(id){
        swal.fire({
            title: 'Please wait...',
            allowOutsideClick: false,
            onBeforeOpen: () => {
            swal.showLoading()
            },
        });
        axios.get('/attendance/get_student_attendance_detail_fields/'+id).then(
            response=>{
                this.$modal.show('edit-attendance-sheet',response.data);
                swal.close();
            }
        ).catch(
            e=>{
            console.log(e);
            }
        );
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
    getUnitInfo({unit}){
      return `${unit.code} - ${unit.description}`;
    },
    selectCourse(){
      swal
          .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Confirm!"
          })
          .then(result => {
          if (result.value) {
              axios.post('/student/intl/add_student_class',{
              class_id:this.selected_class,
              course_code:this.$props.detail.course_code,
              student_id:this.$props.detail.student_id
              }).then(
              response=>{
                  swal.fire(
                  "Class saved!",
                  "Success",
                  "success"
                  );
                  this.getStudentAttendance();
              }
              ).catch();
          }
      });
    },
    getStudentAttendance(){
        axios.get('/student/domestic/get_intl_student_attendance/'+this.$props.detail.student_id+'/'+this.$props.detail.course_code).then(
          response=>{
            // console.log(response);
            let vm = this;
            let data = [];
            // this.attendance = response.data;
            response.data.forEach(function(e){
              // console.log(e);
              e.units=[];
              axios.get('/student/intl/get_package_units/'+vm.offer_letter_id+'/'+e.course_code).then(
                response=>{
                  // console.log(response.data);
                  response.data.forEach(function(units){
                    e.units.push(units);
                  });
                }
              );;
              data.push(e);
            });
            vm.attendance = data;
          }
        ).catch();
    },
    getClassInfo({desc,course_code}){
      return `${desc} - ${course_code}`;
    },
    getClasses(){
        axios.get('/student/intl/get_avail_classes/'+this.$props.detail.course_code).then(
          response=>{
            this.availClasses = response.data;
            this.getStudentAttendance();
          }
        );
    },
    viewMore(payment) {
      let vm = this;
      vm.payment_template = payment;
      vm.$modal.show(`size-modal-${payment}`, { payment_detail: payment });
    },
    viewTrainingPlan() {
      window.location.href = `/training_plan/${this.detail.student_id}/${this.detail.id}`;
    },
    resetPayment() {
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
      });
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      let payments = this.detail.payments;
      console.log(payments);
      if (payments.length > 0) {
        swal
          .fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
          })
          .then((result) => {
            loadingSwal.fire({
              type: "info",
              title: "Please Wait ...",
            });
            if (result.value) {
              let id = this.detail.id;
              axios
                .delete(`/offer-letter/payment/reset/${id}`)
                .then((response) => {
                  if (response.data.status == "success") {
                    Toast.fire({
                      type: "success",
                      title: "Updated Successfuly",
                    });
                    this.$parent.getData();
                  } else {
                    Toast.fire({
                      type: "error",
                      title: response.data.message,
                    });
                  }
                })
                .catch((err) => {
                  Toast.fire({
                    type: "error",
                    title: err,
                  });
                });
              // swal.fire("Deleted!", "The Payment has been deleted.", "success");
            }
          });
      } else {
        loadingSwal.fire({
          type: "info",
          title: "Please Wait ...",
        });
        let id = this.detail.id;
        axios
          .delete(`/offer-letter/payment/reset/${id}`)
          .then((response) => {
            if (response.data.status == "success") {
              Toast.fire({
                type: "success",
                title: "Updated Successfuly",
              });
              this.$parent.getData();
            } else {
              Toast.fire({
                type: "error",
                title: response.data.message,
              });
            }
          })
          .catch((err) => {
            Toast.fire({
              type: "error",
              title: err,
            });
          });
      }
    },
    updateStatus(e) {
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
      });
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      let data = {
        status: e.target.value,
      };
      loadingSwal.fire({
        type: "info",
        title: "Please Wait ...",
      });
      axios
        .put(
          `/offer-letter/course-detail/change-status/${this.detail.id}`,
          data
        )
        .then((response) => {
          if (response.data.status == "success") {
            Toast.fire({
              type: "success",
              title: "Updated Successfuly",
            });
            this.$parent.getData();
          } else {
            Toast.fire({
              type: "error",
              title: response.data.message,
            });
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  computed: {
    balance: function () {
      let vm = this;
      let balance = parseInt(vm.detail.balance.replace(/,/g, "", 10));
      vm.detail.payments.forEach((element) => {
        balance = balance - element.amount_paid;
      });
      balance = balance.toFixed(2);
      return balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    amount_paid: function () {
      let vm = this;
      let paid = 0;
      vm.detail.payments.forEach((element) => {
        paid = paid + parseInt(element.amount_paid);
      });
      paid = paid.toFixed(2);
      return paid.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    payableTotal: function () {
      let vm = this;
      let payableTotal = 0;
      vm.detail.payments.forEach((element) => {
        let payable = element.payable_amount;
        payable = payable.split(",").join("");
        payableTotal = payableTotal + parseInt(payable);
      });
      payableTotal = payableTotal.toFixed(2);
      return payableTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
  },
};
</script>