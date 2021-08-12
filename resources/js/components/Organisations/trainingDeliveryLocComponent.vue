<template>
  <form @submit.prevent>
    <div>
      <div class="row mb-3">
        <div class="col-md-6 pull-left text-left">
          <button v-if="setup == 1" class="btn btn-primary" @click="goBack">
            <i class="fas fa-angle-left mr-1"></i> Training Organisation
          </button>
        </div>
        <div class="col-md-6 pull-right text-right">
          <button v-if="setup != 1" class="btn btn-success" @click="saveTrainingDlvrLoc">
            <i class="far fa-save"></i> Save
          </button>
          <button v-else class="btn btn-info" @click="finishSetup">
            <i class="fas fa-flag-checkered mr-1"></i> Finish Configuration
          </button>
        </div>
      </div>
      <div class="clearfix"></div>
      <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'" id="formsection">
        <h6>Training Location Details</h6>
      </div>
      <div class="form-padding-left-right">
        <div class="row">
          <!-- <div class="col-lg-12">
                                <div :class="['form-group', errors.training_organisation_id ? 'has-error' : '']" >
                                    <label for="training_organisation_id">Organisation Identifier <a data-toggle="tooltip" data-placement="right" title="Avetmiss required!"><i class="fas fa-info-circle"></i></a></label>
                                    <input 
                                        id="training_organisation_id" 
                                        name="training_organisation_id" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="number" 
                                        readonly="true"
                                        v-model="training_dlvr_location.training_organisation_id">
                                    <span v-if="errors.training_organisation_id" :class="['badge badge-danger']">{{ errors.training_organisation_id[0] }}</span>
                                </div>
          </div>-->
          <div class="col-lg-6">
            <div :class="['form-group', errors.train_org_dlvr_loc_id ? 'has-error' : '']">
              <label for="train_org_dlvr_loc_id">Delivery Location Identifier</label>
              <input
                id="train_org_dlvr_loc_id"
                name="train_org_dlvr_loc_id"
                value
                autofocus="autofocus"
                class="form-control"
                disabled
                type="text"
                v-model="training_dlvr_location.train_org_dlvr_loc_id"
              />
              <span
                v-if="errors.train_org_dlvr_loc_id"
                :class="['badge badge-danger']"
              >{{ errors.train_org_dlvr_loc_id[0] }}</span>
            </div>
          </div>
          <div class="col-lg-6">
            <div :class="['form-group', errors.train_org_dlvr_loc_name ? 'has-error' : '']">
              <label for="train_org_dlvr_loc_name">Delivery Location Name</label>
              <input
                id="train_org_dlvr_loc_name"
                name="train_org_dlvr_loc_name"
                value
                autofocus="autofocus"
                class="form-control"
                type="text"
                v-model="training_dlvr_location.train_org_dlvr_loc_name"
              />
              <span
                v-if="errors.train_org_dlvr_loc_name"
                :class="['badge badge-danger']"
              >{{ errors.train_org_dlvr_loc_name[0] }}</span>
            </div>
          </div>
          <div class="col-lg-6">
            <div :class="['form-group', errors.addr_flat_unit_detail ? 'has-error' : '']">
              <label for="addr_flat_unit_detail">Unit</label>
              <input
                id="addr_flat_unit_detail"
                name="addr_flat_unit_detail"
                value
                autofocus="autofocus"
                class="form-control"
                type="text"
                v-model="training_dlvr_location.addr_flat_unit_detail"
              />
              <span
                v-if="errors.addr_flat_unit_detail"
                :class="['badge badge-danger']"
              >{{ errors.addr_flat_unit_detail[0] }}</span>
            </div>
          </div>
          <div class="col-lg-6">
            <div :class="['form-group', errors.addr_building_property_name ? 'has-error' : '']">
              <label for="addr_building_property_name">Building Name</label>
              <input
                id="addr_building_property_name"
                name="addr_building_property_name"
                value
                autofocus="autofocus"
                class="form-control"
                type="text"
                v-model="training_dlvr_location.addr_building_property_name"
              />
              <span
                v-if="errors.addr_building_property_name"
                :class="['badge badge-danger']"
              >{{ errors.addr_building_property_name[0] }}</span>
            </div>
          </div>
          
          <div class="col-lg-6">
            <div :class="['form-group', errors.addr_street_num ? 'has-error' : '']">
              <label for="addr_street_num">Street Number</label>
              <input
                id="addr_street_num"
                name="addr_street_num"
                value
                autofocus="autofocus"
                class="form-control"
                type="text"
                v-model="training_dlvr_location.addr_street_num"
              />
              <span
                v-if="errors.addr_street_num"
                :class="['badge badge-danger']"
              >{{ errors.addr_street_num[0] }}</span>
            </div>
          </div>
          <div class="col-lg-6">
            <div :class="['form-group', errors.addr_street_name ? 'has-error' : '']">
              <label for="addr_street_name">Street Name</label>
              <input
                id="addr_street_name"
                name="addr_street_name"
                value
                autofocus="autofocus"
                class="form-control"
                type="text"
                v-model="training_dlvr_location.addr_street_name"
              />
              <span
                v-if="errors.addr_street_name"
                :class="['badge badge-danger']"
              >{{ errors.addr_street_name[0] }}</span>
            </div>
          </div>
          <div class="col-lg-6">
            <div :class="['form-group', errors.addr_location ? 'has-error' : '']">
              <label for="addr_location">Suburb, State Postcode</label>
              <!-- <input 
                                        id="addr_location" 
                                        name="addr_location" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        v-on:keyup="fetchTrainingOrg"
                                        type="number" 
              v-model="training_dlvr_location.addr_location">-->
              <multiselect
                v-model="training_dlvr_location.postcode"
                tag-placeholder="Add this as new tag"
                placeholder="Search suburb"
                label="postcode_name"
                track-by="id"
                :options="slct_postcode"
                :multiple="false"
                :taggable="false"
                @tag="addTag"
              ></multiselect>
              <span v-if="errors.postcode" :class="['badge badge-danger']">{{ errors.postcode[0] }}</span>
            </div>
          </div>
          <!-- <div class="col-lg-6">
                                <div :class="['form-group', errors.state_id ? 'has-error' : '']" >
                                    <label for="state_id">State Identifier</label>
                                    <input 
                                        id="state_id" 
                                        name="state_id" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="text" 
                                        v-model="training_dlvr_location.state_id">
                                    <span v-if="errors.state_id" :class="['badge badge-danger']">{{ errors.state_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.postcode ? 'has-error' : '']" >
                                    <label for="postcode">Postcode</label>
                                    <input 
                                        id="postcode" 
                                        name="postcode" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="text" 
                                        v-model="training_dlvr_location.postcode">
                                    <span v-if="errors.postcode" :class="['badge badge-danger']">{{ errors.postcode[0] }}</span>
                                </div>
          </div>-->
          <!-- <div class="col-lg-6"> -->
            <!-- <div :class="['form-group', errors.country_identifier ? 'has-error' : '']"> -->
              <!-- <label for="country_identifier">Country</label> -->
              <!-- <multiselect
                v-model="training_dlvr_location.country_id"
                tag-placeholder="Add this as new tag"
                placeholder="Search country"
                label="full_name"
                track-by="identifier"
                :options="slct_country_identifier"
                :multiple="false"
                :taggable="false"
                @tag="addTag"
              ></multiselect> -->
              <!-- <span
                v-if="errors.country_id"
                :class="['badge badge-danger']"
              >{{ errors.country_id[0] }}</span> -->
            <!-- </div> -->
          <!-- </div> -->
          <div class="col-md-12 text-right" v-if="setup == 1">
            <button v-if="training_dlvr_location.id" class="btn btn-primary" @click="saveTrainingDlvrLoc">
                <i class="far fa-edit"></i> Update Delivery Location
            </button>
            <button v-else class="btn btn-success" @click="saveTrainingDlvrLoc">
                <i class="fas fa-plus"></i> Add Delivery Location
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
export default {
  data() {
    return {
      setup: window.setup ? 1 : null,
      training_dlvr_location: {
        training_organisation_id: window.training_organisation_id,
        train_org_dlvr_loc_id: "",
        train_org_dlvr_loc_name: "",
        postcode: "",
        state_id: "",
        addr_location: "",
        country_id: "1101",
        edit: 0,
        addr_flat_unit_detail: '',
        addr_building_property_name: '',
        addr_street_name: '',
        addr_street_num: ''
      },
      postcode_val: [],
      slct_postcode: window.slct_postcode,
      country_val: [],
      slct_country_identifier: window.slct_country_identifier,
      organisation_id: window.organisation_id,
      csrf: "",
      errors: [],
      success: false,
      app_color: app_color,
    };
  },
  created() {
    if (window.train_org_dlvr_loc_id == undefined) {
      this.refill();
    } else {
      this.training_dlvr_location.train_org_dlvr_loc_id =
        window.train_org_dlvr_loc_id;
    }
  },
  methods: {
    finishSetup() {
      let loading = swal.fire({
          title: 'Finishing configuration...',
          // html: '',// add html attribute if you want or remove
          allowOutsideClick: false,
          onBeforeOpen: () => {
              swal.showLoading()
          },
      });
      if(!this.$parent.deliveryLocList[0]) {
        swal.fire(
          'Opss...',
          'Must add training delivery location',
          'error'
        )
      }else{
        axios.post('/rto-configuration/finish', {is_done:1})
        .then(res => {
          if(res.data.status == 'success') {
            swal.fire({
                title: "Good job!",
                text: "You are now ready to use VORX!",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = '/dashboard';
                }
            });
          }else {
            swal.fire(
              'Opss...',
              'There seems to be a problem.',
              'error'
            )
          }
        })

      }
    },
    goBack() {
      document.getElementById("nav-organization-tab").classList.remove('disabled')
      document.getElementById("nav-location-tab").classList.add('disabled')
      // this.$parent.$children[1].formOpen();
      $('a[href="#nav-organization"]').tab('show')
      console.log($('a[href="#nav-organization"]'));
    },
    refill() {
      axios.get("training-delivery-location/generate").then((res) => {
        this.training_dlvr_location.train_org_dlvr_loc_id = res.data;
      });
    },
    saveTrainingDlvrLoc() {
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      axios
        .post(
          `/organisation/${this.organisation_id}/delivery-location`,
          this.training_dlvr_location
        )
        .then((response) => {
          if (response.data.status == "errors") {
            // alert('error ghorl');
            this.errors = response.data.errors;
            Toast.fire({
              position: "top-end",
              type: "error",
              title: "Failed to add data",
            });
          } else {
            // alert('success ghorl');
            this.errors = [];
            (this.training_dlvr_location.train_org_dlvr_loc_id = ""),
              (this.training_dlvr_location.train_org_dlvr_loc_name = ""),
              (this.training_dlvr_location.postcode = ""),
              (this.training_dlvr_location.country_id = "1101"),
              (this.postcode_val = []),
              (this.training_dlvr_location.addr_flat_unit_detail = ""),
              (this.training_dlvr_location.addr_building_property_name = ""),
              (this.training_dlvr_location.addr_street_name = ""),
              (this.training_dlvr_location.addr_street_num = "");
            this.country_val = [];
            delete this.training_dlvr_location.id;
            this.success = true;
            Toast.fire({
              position: "top-end",
              type: "success",
              title: "Data is saved successfully",
            });
            this.$parent.fetchDeliveryLoc();
            this.refill();
          }
        })
        .catch((error) => {
          console.log(error);
          Toast.fire({
            position: "top-end",
            type: "error",
            title: "Failed to add data",
          });
        });
    },
    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
      };
      this.slct_postcode.push(tag);
      this.training_dlvr_location.postcode.push(tag);
      // this.slct_state_identifier.push(tag)
      // this.training_dlvr_location.state_id.push(tag)
      this.slct_suburb.push(tag);
      this.slct_country_identifier.push(tag);
      this.training_dlvr_location.country_id.push(tag);
      // this.options.push(tag)
      // this.value.push(tag)
    },
    clearFields() {
        this.errors = [];
        (this.training_dlvr_location.train_org_dlvr_loc_id = ""),
        (this.training_dlvr_location.train_org_dlvr_loc_name = ""),
        (this.training_dlvr_location.postcode = ""),
        (this.training_dlvr_location.country_id = "1101"),
        (this.postcode_val = []),
        (this.training_dlvr_location.addr_flat_unit_detail = ""),
        (this.training_dlvr_location.addr_building_property_name = ""),
        (this.training_dlvr_location.addr_street_name = ""),
        (this.training_dlvr_location.addr_street_num = "");
      this.country_val = [];
      delete this.training_dlvr_location.id;
    }
  },
};
</script>