<template>
    <modal
    name="adjust-due-modal"
    transition="nice-modal-fade"
    classes="demo-modal-class"
    :min-width="200"
    :min-height="200"
    :pivot-y="0.1"
    :adaptive="true"
    :scrollable="true"
    :reset="true"
    width="50%"
    height="auto"
    @before-open="beforeOpen"
    @opened="opened"
    @closed="closed"
    @before-close="beforeClose"
    >
    <div class="size-modal-content">
      <h4 :class="'modal-header-'+app_color">Adjust Payment Due Date for ( {{ student_id }} )</h4>
      <div class="row text-center">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="">Automated Due Date </label>
                  <input type="text " disabled v-model="old_date" class="form-control input-custom text-center" id="olddate" aria-describedby="emailHelp" placeholder="Enter email">
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <date-picker
                            v-model="newDate"
                            :masks="{L:'DD/MM/YYYY'}"
                            :max-date="new Date()"
                    >
                     <template v-slot="{ inputValue, inputEvents }">
                         <div class="form-group">
                            <label for="">New Due Date </label>
                            <input type="text" :value="inputValue" v-on="inputEvents" class="form-control input-custom text-center" id="newDate" aria-describedby="emailHelp">
                        </div>
                     </template>
                    </date-picker>
              </div>
          </div>
          <div class="col-md-12">
              <small> NOTE : Any changes to the due date will affect all payment modules including warning letters.</small>
          </div>
          <div class="col-md text-right mt-2">
              <button type="submit" @click="changeDate" class="btn btn-success btn-square">Save</button>
              <button type="submit" @click="closed" class="btn btn-danger btn-square">Cancel</button>
          </div>
      </div>
    </div>
    </modal>
</template>
<script>
import moment from 'moment';
export default {
    data(){
        return {
            app_color:app_color,
            student_id: window.student_id,
            old_date : "",
            newDate : "",
            sched_id : '',
        }
    },
    
    methods: {
        changeDate(){
             swal.fire({
                title: "Please wait...",
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                swal.showLoading();
                },
            });
            let formE = {
                template_id : this.sched_id,
                due_date : this.newDate,
            }
            axios.post('/offer-letter/payment/change_date',formE).then(response=>{
                let res = response.data;
                if(res.status == 'success'){
                    Toast.fire({
                        type: "success",
                        title: "Due date updated successfully",
                        position: "top-end",
                    });
                    this.$parent.$parent.fetchData();
                }
            }).catch(err=>{
                Toast.fire({
                type: "error",
                title: "Opss.. something went wrong",
                position: "top-end",
              });
            })
        },
        beforeOpen(e) {
            let vm = this;
            vm.old_date = moment(e.params.due_date).format('DD/MM/YYYY')
            vm.sched_id = e.params.id
            // console.log(e);
        // this.fetchCourses();
        },
        beforeClose(e) {},
        opened(e) {
        // e.ref should not be undefined here
        // console.log('ref', e.ref)
        },
        closed(e) {
            this.$modal.hide('adjust-due-modal');
        }
    }
}
</script>

<style scoped>
.input-custom{
  background-color: #7573731f;
  border:none;
  border-radius: 0;
}
.btn-square { border-radius: 0; }
</style>