<template>
    <modal
    name="size-verify-initial-payment"
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
        <h4 :class="'background-'+app_color">Verify Initial payment receipt</h4>
        <div class="col-md-12" >
             <div class="form-group">
                <label for="status">Inital Payment Required </label>
                <input type="text" v-model="verifyForm.initial_payment" class="form-control" />
            </div>
        </div>
         <div class="col-md-12 pull-right text-right">
          <button class="btn btn-success" @click="verify">
            <i class="far fa-save"></i> Save Initial Payment
          </button>
        </div>
    </div>
    </modal>
</template>
<script>
export default {
    data() {
      return {
        app_color:app_color,
        verifyForm : {
          initial_payment : 0,
          process_id : '',
          student_id : ''
        }
      }
    },
    methods: {
        beforeOpen(e) {
            let vm = this;
            console.log(e.params)
            vm.verifyForm.process_id = e.params.process_id
            vm.verifyForm.student_id = e.params.student_id
        },
        beforeClose(e) {},
        opened(e) {
        // e.ref should not be undefined here
        // console.log('opened', e)
        // console.log('ref', e.ref)
        },
        closed(e) {
        // console.log("closed", e);
        },
        verify(){
             let toast = swal.fire({
                                position: "top-end",
                                title: "Please wait",
                                showConfirmButton: false,
                                onBeforeOpen: () => {
                                    swal.showLoading();
                                },
                            });
            axios.post('/pca/verify-initial-payment',this.verifyForm).then(res=>{
                // console.log(res.data);\
                if(res.data.status ==  'success'){
                    Toast.fire({
                              type: "success",
                              position: "top-end",
                              title: res.data.message,
                            });
                             this.$parent.$refs.studentList.refresh();
                             this.$parent.$modal.hide("size-verify-initial-payment");
                }else{
                    Toast.fire({
                              type: "error",
                              position: "top-end",
                              title: 'Something went wrong....',
                            });
                }
            }).catch(err=>{
                console.log(err);
            })
        }
    },
}
</script>