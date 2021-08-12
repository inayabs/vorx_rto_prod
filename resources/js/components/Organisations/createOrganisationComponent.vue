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
      <h4>Add Organisation Info</h4>
      <form @submit.prevent="saveOrganisation">
        <div class="row">
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.trainer_organisation_id ? 'has-error' : '']" >
                                    <label for="trainer_organisation_id">Organisation Identifier</label>
                                    <input 
                                        id="trainer_organisation_id" 
                                        name="trainer_organisation_id" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="number" 
                                        v-on:keyup="onKeyUp"
                                        v-model="organisation.trainer_organisation_id">
                                    <span v-if="errors.trainer_organisation_id" :class="['badge badge-danger']">{{ errors.trainer_organisation_id[0] }}</span>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.trainer_organisation_name ? 'has-error' : '']" >
                                    <label for="trainer_organisation_name">Organisation Name</label>
                                    <input 
                                        id="trainer_organisation_name" 
                                        name="trainer_organisation_name" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="text" 
                                        v-on:keyup="onKeyUp"
                                        v-model="organisation.trainer_organisation_name">
                                    <span v-if="errors.trainer_organisation_name" :class="['badge badge-danger']">{{ errors.trainer_organisation_name[0] }}</span>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div :class="['form-group', errors.trainer_organisation_name ? 'has-error' : '']" >
                                    <label for="trainer_organisation_name">Organisation Type</label>
                                    <multiselect 
                                        v-model="organisation.org_type" 
                                        tag-placeholder="Add this as new tag" 
                                        placeholder="Search or add a tag" 
                                        label="description" 
                                        track-by="value" 
                                        :options="organisation.organisation_type" 
                                        :multiple="false" 
                                        :taggable="true" 
                                        @tag="addTag">
                                    </multiselect>
                                </div>
                            </div> -->
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.contact_name ? 'has-error' : '']" >
                                    <label for="contact_name">Contact Name</label>
                                    <input 
                                        id="contact_name" 
                                        name="contact_name" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="text" 
                                        v-on:keyup="onKeyUp"
                                        v-model="organisation.contact_name">
                                    <span v-if="errors.contact_name" :class="['badge badge-danger']">{{ errors.contact_name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.phone ? 'has-error' : '']" >
                                    <label for="phone">Telephone Number</label>
                                    <input 
                                        id="phone" 
                                        name="phone" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="number" 
                                        v-on:keyup="onKeyUp"
                                        v-model="organisation.phone">
                                    <span v-if="errors.phone" :class="['badge badge-danger']">{{ errors.phone[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.facsimile_number ? 'has-error' : '']" >
                                    <label for="facsimile_number">Facsimile Number</label>
                                    <input 
                                        id="facsimile_number" 
                                        name="facsimile_number" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="number" 
                                        v-on:keyup="onKeyUp"
                                        v-model="organisation.facsimile_number">
                                    <span v-if="errors.facsimile_number" :class="['badge badge-danger']">{{ errors.facsimile_number[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.email ? 'has-error' : '']" >
                                    <label for="email">Email Address</label>
                                    <input 
                                        id="email" 
                                        name="email" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="text" 
                                        v-on:keyup="onKeyUp"
                                        v-model="organisation.email">
                                    <span v-if="errors.email" :class="['badge badge-danger']">{{ errors.email[0] }}</span>
                                </div>
                            </div>
                        </div>

        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </modal>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      organisation: {
        trainer_organisation_id: '',
        trainer_organisation_name: '',
        contact_name: '',
        phone: '',
        facsimile_number: '',
        email: '',
      },
      errors: []
    };
  },
  methods: {
    saveOrganisation(e) {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      axios
        .post("/organisation/store", this.organisation)
        .then(response => {
          if (response.data.status == "errors") {
            this.errors = response.data.errors;
          } else {
            // console.log(response);
            this.organisation = "";
            // alert('Student Added');

            // this.$set("errors", []);
            Toast.fire({
              type: "success",
              title: "Created Successfully"
            });
            // this.$parent.fetchOrganisation();
            this.$parent.$refs.organisationList.refresh();
            this.$modal.hide("size-modal");
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    beforeOpen(e) {
      // this.fetchCourses();
    },
    beforeClose(e) {},
    opened(e) {
      // e.ref should not be undefined here
      // console.log('opened', e)
      // console.log('ref', e.ref)
    },
    closed(e) {
      console.log("closed", e);
    },
    onKeyUp(){
        this.errors = [];
    }
  }
};
</script>

<style>
.v--modal-overlay .v--modal-box {
  overflow: visible !important;
}
.vc-text-base {
  display: block;
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #6e707e;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #d1d3e2;
  border-radius: 0.35rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
</style>