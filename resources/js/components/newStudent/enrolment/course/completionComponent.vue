<template>
    <div class="row g-0">
        <div class="col-md-6 mb-3 mt-3" v-if="soa_num == undefined">CERT / SOA # : ( LATEST )</div>
        <div class="col-md-6 mb-3 mt-3" v-else>CERT / SOA # : ( {{soa_num}} )</div>
        <div class="col-md-6 text-right mb-3 mt-3">
          <button
            :disabled="roles == 'Staff'? true : false "
            v-if="edit_status && soa_num != undefined"
            class="btn btn-success mt-2"
            @click="getLatest()"
          >
            <i class="far fa-save"></i> Cancel Changes
          </button>

          <!-- SEND -->
          <div class="btn-group mt-2" v-if="add_on.indexOf('automation.course_progress') != -1">
            <button
              :disabled="roles == 'Staff'? true : false "
              type="button"
              class="btn btn-warning dropdown-toggle dropdown-toggle-split"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              v-if="demoUser == false"
            >
              Send
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a
                class="dropdown-item"
                @click="sendReport('Progress Report')"
                target="_blank"
              >
                <i class="fas fa-clipboard text-success"></i>&nbsp; Progress Report
              </a>
            </div>
          </div>
          <!-- VIEW -->
          <div class="btn-group mt-2" v-if="add_on.indexOf('automation.course_progress') != -1">
            <button
              type="button"
              class="btn btn-info dropdown-toggle dropdown-toggle-split"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              v-if="demoUser == false"
            >
              View
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" @click="progressReport()" target="_blank">
                <i class="fas fa-clipboard text-success"></i>&nbsp; Progress Report
              </a>
              <!-- <a class="dropdown-item" @click="completionReport()" target="_blank">
                <i class="fas fa-clipboard text-success"></i>&nbsp; Completion Report
              </a> -->
            </div>
          </div>

          <!-- <button class="btn btn-success mt-2" @click="progressReport(course)">
            <i class="fas fa-clipboard"></i> Completion Report
          </button>-->
          <button :disabled="roles == 'Staff'? true : false " class="btn btn-primary mt-2" @click="generateCert">
            <i class="far fa-save"></i> Generate Certificates
          </button>
          <button class="btn btn-info mt-2" @click="useProposed">
            <i class="far fa-calendar"></i> Use Proposed Date
          </button>
          <button :disabled="roles == 'Staff'? true : false " class="btn btn-success mt-2" @click="saveChanges">
            <i class="far fa-save"></i> Save Changes
          </button>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2 offset-md-4 mb-2">
          <label for>Start Date</label>
          <date-picker
            :popover="{ placement: 'bottom', visibility: 'click' }"
            :class="'form-control p-0 border-0'"
            mode="single"
            locale="en"
            v-model="modifyDateStart"
            :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
          ></date-picker>
        </div>
        <div class="col-md-2 mb-2">
          <label for>End Date</label>
          <date-picker
            :popover="{ placement: 'bottom', visibility: 'click' }"
            :class="'form-control p-0 border-0'"
            mode="single"
            locale="en"
            v-model="modifyDateEnd"
            :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
          ></date-picker>
        </div>
        <div class="col-md-4 mb-2">
          <label for>Status</label>
          <select v-model="modifyAll" @change="modifyStatus" class="form-control">
            <option value selected></option>
            <option
              v-for="(status) in statuses"
              :key="status.id"
              :value="status.id"
            >{{ status.status }}</option>
          </select>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <table class="table" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th v-bind:class="'text-center background-'+app_color" style="width:5%!important">#</th>
                        <th v-bind:class="'text-center background-'+app_color">Code</th>
                        <th v-bind:class="'text-center background-'+app_color">Description</th>
                        <th v-bind:class="'text-center background-'+app_color">Actual Start</th>
                        <th v-bind:class="'text-center background-'+app_color">Actual End Date</th>
                        <th v-bind:class="'text-center background-'+app_color">Status</th>
                        <th v-bind:class="'text-center background-'+app_color" style="width:5%!important">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(_unit, index) in units" :key="index">
                        <td width="">{{ index +1 }}</td>
                        <td width="10%">{{ _unit.course_unit_code }}</td>
                        <td width="25%">{{ _unit.unit.description }}</td>
                        <td width="17%">
                            <date-picker
                                :popover="{ placement: 'bottom', visibility: 'click' }"
                                mode="single"
                                locale="en"
                                v-model="_unit.actual_start"
                                :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
                            ></date-picker>
                        </td>
                        <td width="17%">
                            <date-picker
                                :popover="{ placement: 'bottom', visibility: 'click' }"
                                mode="single"
                                locale="en"
                                v-model="_unit.actual_end"
                                :masks="{L:'DD/MM/YYYY',data:'DD/MM/YYYY'}"
                            ></date-picker>
                        </td>
                            <td width="17%">
                                <select v-model="_unit.completion_status_id" class="form-control">
                                    <option
                                    v-for="(status) in statuses"
                                    :key="status.id"
                                    :value="status.id"
                                    >{{ status.status }}</option>
                                </select>
                            </td>
                            <td width="5%" style=" text-align: center;">
                        <button
                          :disabled="roles == 'Staff'? true : false "
                          class="btn btn-danger"
                          @click="destroy_single(completion.id,_unit.code,index)"
                            type="submit"
                        >-</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    props : ['completion','completionData'],
    data() {
        return {
            modifyDateStart: "",
            modifyDateEnd: "",
            modifyAll : "",
            add_on: add_on,
            soa_num : '',
            demoUser: false,
            edit_status : false,
            app_color : app_color,
            statuses : window.slct_completion_statuses,
            // units : this.completion.details
            roles : null,

        }
    },
    mounted(){
      if(this.$root.$refs.studentbase != undefined){
        this.roles = this.$root.$refs.studentbase.urole;
      }
    },
    methods: {
        sendReport(type) {
            let vm = this;
            swal
        .fire({
          title: "Send " + type + " to " + vm.student_info.name + "?",
          // text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Send!",
        })
        .then((result) => {
          if (result.value) {
            swal.fire({
              title: "Sending progress report..",
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                swal.showLoading();
              },
            });

            if (vm.contact_details.email.length < 1) {
              swal.fire(
                "Opps..",
                "No email address assigned to " + vm.student_info.name,
                "error"
              );
              return false;
            }
            let email = [];
            email.push(vm.contact_details.email,vm.contact_details.email_at)
            axios
              .post("/report/send/course-progress", {
                student_id: vm.student_info.student_id,
                course: vm.completion,
                type: type,
                // email: 'vm.student_detail.email',
                email: email,
              })
              .then((res) => {
                // console.log(res);
                if (res.data.status == "success") {
                  swal.fire("Success", type + " successfully sent.", "success");
                } else {
                  swal.fire("Opps..", res.data.message, "error");
                }
              })
              .catch((err) => {
                swal.fire("Opps..", "There seems to be a problem.", "error");
              });
          }
        });
        },
        progressReport() {
                window.open(
                `/certificate_issuance/generate/progress_report/${window.student_id}/${this.completion.id}`,
                // `/course_completion/confirmation_report/${window.student.id}/${this.course}`,
                "_blank"
                );
        },
        modifyStatus() {
            let vm = this;
            vm.units.forEach((element) => {
                element.completion_status_id = vm.modifyAll;
            });
        },
        destroy_single (id,code,index) {},
        generateCert() {

          const loadingSwal = swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
            });
            loadingSwal.fire({
                type: "info",
                title: "Please Wait ...",
            });

          const Toast = swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
          });
           let vm = this
           let data ={
             'units' :vm.units,
             'course_completion' : this.completion
           }

           data.units.forEach((e1) => {
              if (e1.actual_start != null) {
                e1.actual_start = moment(e1.actual_start).format("YYYY-MM-DD");
              }
              if (e1.actual_start != null) {
                e1.actual_end = moment(e1.actual_end).format("YYYY-MM-DD");
              }
            });
            axios
            .post("/certificate_issuance", data)
            .then((response) => {
              if (response.data.status == "success") {
                Toast.fire({
                  type: "success",
                  title: response.data.message,
                });
                vm.$emit("generate", "success");
                vm.$emit("updateData", {status : 'success', data: response.data.data});
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
        useProposed() {
            this.units.forEach(element =>{
                if (element.start_date != null && element.end_date != null) {
                    element.actual_start = element.start_date
                    element.actual_end =  element.end_date
                }
            })
        },
        saveChanges() {
            // console.log(this.units);
            const Toast = swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
             const loadingSwal = swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
            });
               loadingSwal.fire({
                  type: "info",
                  title: "Please Wait ...",
              });
              if(this.edit_status){
                axios.post('/test/student/certcompletion',{cert_id: this.completionData.id,units:this.units})
                  .then(response=>{
                      Toast.fire({
                        type: "success",
                        title: response.data.message,
                      });
                  }).catch(err=>{
                      Toast.fire({
                        type: "error",
                        title: 'something went wrong',
                      });
                  })
              }else{
                axios.post('/test/student/completion',this.units)
                  .then(response=>{
                      Toast.fire({
                        type: "success",
                        title: response.data.message,
                      });
                  }).catch(err=>{
                      Toast.fire({
                        type: "error",
                        title: 'something went wrong',
                      });
                  })
              }

        },
        getLatest(){
          swal.fire({
              title: "Loading Student data...",
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                swal.showLoading();
              },
            });
           this.$store.dispatch("getStudentInfo", window.student_id);
           this.edit_status = false;
           this.soa_num = ""
        }

    },
    computed: {
        student_info() {
          return this.$store.getters.info;
        },
        contact_details(){
          return this.$store.getters.contact;
        },
        units(){
            this.completion.details.forEach(element =>{
                if (element.start_date != null && element.end_date != null) {
                    element.start_date =  moment(element.start_date)._d
                    element.end_date =  moment(element.end_date)._d
                }
                if (element.actual_start != null && element.actual_end != null) {
                    element.actual_start =  moment(element.actual_start)._d
                    element.actual_end =  moment(element.actual_end)._d
                }
            })
            return this.completion.details
        },


    },
    watch : {
        modifyDateStart : function( newVal,OldVal){
            if(newVal != '' ){
                this.units.forEach(element =>{
                    element.actual_start = newVal
                })
            }
        },
        modifyDateEnd : function( newVal,OldVal){
            if(newVal != '' ){
                this.units.forEach(element =>{
                    element.actual_end = newVal
                })
            }
        },
        completionData : function(newVal){
          let vm = this;
          if(JSON.stringify(newVal) != '{}'){
            vm.edit_status = newVal.edit;
            vm.soa_num = newVal.soa_number;
            // vm.soa_num = newVal.soa_number;
            if(newVal.units.length > 0){
              let units = newVal.units;
              this.completion.details = units;
            }
          }
        }
    }
}
</script>
