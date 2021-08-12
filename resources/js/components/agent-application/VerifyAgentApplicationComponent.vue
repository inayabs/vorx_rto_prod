<template>
  <modal
    name="size-modal"
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
      <h4 :class="'background-' + app_color">Verify Agent Application</h4>
      <div
        v-for="(verify_form, index) in verify_forms"
        :key="index"
        class="row m-2"
      >
      <div class="col-md-12">
            <h3>Agent Details</h3>
          </div>
        <div class="col-md-12">
            <div class="form-group">
              <label for="companyname">Company Name</label>
              <input type="text" class="form-control " v-model="verify_form.company_name">
              <div
                v-if="errors && errors.company_name"
                class="badge badge-danger"
              >{{ errors.company_name[0] }}</div>
            </div>
          </div>
         <div class="col-md-6">
            <div class="form-group">
              <label for="agentname">Agent Name</label>
              <input type="text" class="form-control " v-model="verify_form.agent_name" >
              <div
                v-if="errors && errors.agent_name"
                class="badge badge-danger"
              >{{ errors.agent_name[0] }}</div>
            </div>
          </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="agent_type">Agent Type</label>
            <select
              name="agent_type"
              v-model="verify_form.agent_type"
              class="form-control"
            >
              <option value=""></option> 
              <option value="ON-SHORE">ON-SHORE</option> 
              <option value="OFF-SHORE">OFF-SHORE</option>
            </select>
          </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
              <label for="address">Office Address</label>
              <input type="text" class="form-control " v-model="verify_form.office_address" >
            </div>
          </div>
         <div class="col-md-6">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control " v-model="verify_form.email" >
              <div
                v-if="errors && errors.email"
                class="badge badge-danger"
              >{{ errors.email[0] }}</div>
            </div>
          </div>
         <div class="col-md-6">
            <div class="form-group">
              <label for="secondary_email">Secondary Email</label>
              <input type="text" class="form-control " v-model="verify_form.email_2" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="number" class="form-control " v-model="verify_form.phone" >
              <div
                v-if="errors && errors.phone"
                class="badge badge-danger"
              >{{ errors.phone[0] }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="mobile">Mobile Number</label>
              <input type="number" class="form-control " v-model="verify_form.mobile" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="faxnumber">Fax Number</label>
              <input type="number" class="form-control " v-model="verify_form.fax_number" >
            </div>
          </div>
           <div class="col-md-6">
            <div class="form-group">
              <label for="website">Website</label>
              <input type="text" class="form-control " v-model="verify_form.website" >
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="notes">Notes</label>
              <textarea type="text" class="form-control " v-model="verify_form.notes" ></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <h3>Bank Details</h3>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bankname">Bank Name</label>
              <input type="text" class="form-control " v-model="verify_form.bank_name" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="accountname">Account Name</label>
              <input type="text" class="form-control " v-model="verify_form.account_name" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bsb">BSB</label>
              <input type="text" class="form-control " v-model="verify_form.bsb" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="accountnumber">Account Number</label>
              <input type="number" class="form-control " v-model="verify_form.account_number" >
            </div>
          </div>
      </div>
      <div class="row">
        <div class="col-md-12 pull-right text-right">
          <button class="btn btn-success" @click="verify">
            <i class="far fa-save"></i> Verify Application
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>
<style scoped>
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}
</style>
<script>
import moment from "moment";
export default {
  props: ["app_name"],
  data() {
    return {
      app_color: app_color,
      verify_forms: [],
      errors: [],
    };
  },
  methods: {
    beforeOpen(e) {
      let vm = this;
      let vf = [];
      let inputs = {};
      if (typeof e.params !== "undefined") {
          if(e.params.application_form !== null){
            inputs = e.params.application_form.inputs;
              vf.push({
                agent_app_id: e.params.id,
                process_id: e.params.process_id,
                agent_name: inputs.name_of_contact_person,
                email: inputs.agent_email,
                email_2: '',
                office_address: inputs.address,
                company_name: inputs.name_of_company,
                notes: '',
                position: inputs.position,
                phone: inputs.phone_no,
                mobile: inputs.mobile_no,
                fax_number: '',
                website: '',
                agent_type: '',
                bank_name: '',
                account_name: '',
                bsb: '',
                account_number: '',
            });
          }
      }
      vm.verify_forms = vf;
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
    verify() {
      swal.fire({
        title: 'Verify?',
        text: "This will send Agent Agreement.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          swal.fire({
          title: "Please wait..",
          showConfirmButton: false,
          onBeforeOpen: () => {
            swal.showLoading();
          },
        });
        axios
            .post(`/representative-agent/verify`, {inputs: this.verify_forms[0]})
            .then((res) => {
              let vm = this;
              if (res.data.status == "success") {
                swal.fire({
                  type: "success",
                  title: res.data.message,
                  // html: ''
                });
                this.$parent.$refs.agentList.refresh();
                this.$parent.$modal.hide("size-modal");
              }else if(res.data.status == "errors") {
                vm.errors = res.data.errors
                console.log(vm.errors);
                swal.fire({
                  type: "error",
                  title: 'Oopss.. Something went wrong.',
                  // html: ''
                });
              }else{
              }
              this.$parent.$refs.agentList.refresh();
              // this.$parent.$modal.hide("size-modal");
            })
            .catch((err) => {
              console.log(err);
            });
        }
      });

        
    },
  },
  watch: {
    // verify_form : function (data) {
    //   console.log(data.course_);
    // }
  },
};
</script>
