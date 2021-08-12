<template lang="">
    <div>
        <button class="btn btn-success btn-sm d-table ml-auto" @click="saveCreateUpdate"><i class="far fa-save"></i> Save Changes</button>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'" id="directEdit">
            <h6>Training Delivery Location According to State and Territory</h6>
        </div>
        <div class="clearfix"></div>
        <div class="form-padding-left-right">
            <div class="row">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="prospectus_name">Course Name:</label>
                        <input type="text" class="form-control" id="prospectus_name" name="name" v-model="fields.name" :class="[errors && errors.name ? 'border-danger' : '']" />
                        <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="units">Select Default Training Delivery Location:</label>
                        <select name="train_org_dlvr_loc_id" id="train_org_dlvr_loc_id" class="form-control" v-model="fields.train_org_dlvr_loc_id" :class="[errors && errors.train_org_dlvr_loc_id ? 'border-danger' : '']">
                                <option
                                    v-for="(opt, optKy) in slct_training_dlvr_loc"
                                    v-bind:key="optKy"
                                    v-bind:value="optKy"
                                >{{opt}}</option>
                            </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="is_active">Status:</label>
                        <div class="custom-control custom-switch my-2">
                            <input type="checkbox" class="custom-control-input" id="is_active_pros" v-model="fields.is_active"  value="0">
                            <label class="custom-control-label" for="is_active_pros">Set as Active</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <!-- <label for="wk_duration_package">Location:</label>
                            <select name="location" id="location" class="form-control" v-model="fields.location" :class="[errors && errors.location ? 'border-danger' : '']">
                                <option
                                    v-for="(opt, optKy) in slct_state"
                                    v-bind:key="optKy"
                                    v-bind:value="optKy"
                                >{{opt}} ({{optKy}})</option>
                            </select> -->
                        <label for="wk_duration_package">Location:</label>
                        <multiselect
                            v-model="fields.location"
                            :options="slct_state"
                            :multiple="true"
                            placeholder="Type to search"
                            :close-on-select="false"
                            track-by="state_key"
                            label="state_name"
                            >
                            <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                        </multiselect>
                        <div v-if="errors && errors.location" class="badge badge-danger">{{ errors.location[0] }}</div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group formunits">
                        <label for="units">Select Units:</label>
                        <multiselect 
                            v-model="fields.course_units" 
                            :options="selections" 
                            :multiple="true"  
                            :group-select="false" 
                            placeholder="Type to search" 
                            :close-on-select="false" 
                            :custom-label="codeDescription"
                            @search-change="fetchUnitOption"  
                            track-by="code" 
                            label="description" 
                            :class="[errors && errors.course_units ? 'border-danger' : '' , {'unitsclass':true}] ">
                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                        </multiselect>
                        <div v-if="errors && errors.course_units" class="badge badge-danger">{{ errors.course_units[0] }}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                  <v-client-table :class="'header-'+app_color" :data="prospectus_list" :columns="columns" :options="options" ref="prospectusTable">

                    <div class="btn-group" slot="actions" slot-scope="{row}">
                        <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                    </div>
                    <div class="" slot="units" slot-scope="{row}">
                        {{ row.course_units.length }}
                    </div>
                    <div class="" slot="is_active" slot-scope="{row}">
                        <i :class="'fas fa-'+[row.is_active? 'check text-success' : 'times text-danger']"></i>
                    </div>
                  </v-client-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: "courseProspectus",
  data() {
    return {
      app_color: app_color,
      // Fetch Prospectus List
      prospectus_list: [],

      // Vue-multiselect syntax
      course_units: [],
      selections: course_units,
      slct_state: window.slct_state,
      slct_training_dlvr_loc: window.slct_training_dlvr_loc,
      // Fetch data from controller
      course_code: course_code,

      // Save/Update Data Action
      fields: {},
      errors: {},
      loaded: false,

      // Vue-Tables-2 syntax
      columns: [
        "name",
        "location",
        "units",
        "is_active",
        "actions"
      ],
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
        headings: {
          name: "Course Name",
          location: "Location",
          is_active: "Status",
          untis: "Units",
          actions: "Actions"
        },
        sortable: ["name", "location", "is_active"],
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords"
        },
        cellClasses: {
          is_active: [
            {
              class: "active",
              condition: row => row.is_active === 1
            },
            {
              class: "inactive",
              condition: row => row.is_active === 0
            }
          ]
        }
      }
    };
  },
  watch: {
    fields: function(value) {
      if (value.name != null) {
        this.errors.name = "";
      }
      if (value.location != null) {
        this.errors.location = "";
      }
      if (value.course_units != null) {
        this.errors.course_units = "";
      }
    }
    // 'fields.location' : function(newVal){
    //     this.filterTrainingDeliveryLoc(newVal);
    // }
  },
  created() {
    this.getProspectusList();
  },
  methods: {
    fetchUnits(q) {
        // this.fields = post_details;
        let vm = this;
        axios.get('/course-unit/show/'+vm.course_code)
        .then(function (res) {
          // handle success
          vm.selections = res.data;

        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });
    },
    fetchUnitOption(q) {
      console.log(q);
      if(q != null){
        let vm = this;
        axios.get("/course_unit_options/" + q + "/"+vm.course_code)
          .then(function(response) {
            // handle success
            // console.log(response.data);
            // af.isLoading = false;
            vm.selections = response.data;
          })
          .catch(function(error) {
            // handle error
            // af.isLoading = false;
            console.log(error);
          })
          .then(function() {
            // always executed
            // alert(af.selectedStudent);
            // af.isLoading = false;
          });
      }
    },
    getProspectusList() {
      axios.get("/course/prospectus/list/" + course_code).then(response => {
        // console.log(response);
        this.prospectus_list = response.data;
      });
    },
    codeDescription({ code, description, unit_type }) {
      // return `${code} — ${description} [${unit_type}]`;
      return `${code} — ${description}`;
    },
    saveCreateUpdate() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      swal.fire({
        title: 'Please wait...',
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
           swal.showLoading()
        },
      });
      this.fields.course_code = this.course_code;
      let saveData = this.fields;
      axios({
        method: "put",
        url: "/course/prospectus/store-update",
        data: saveData
      })
        .then(response => {
          console.log(response);
          this.fields = {};
          this.errors = {};
          this.getProspectusList();
          Toast.fire({
            position: 'top-end',
            type: "success",
            title: "Course Detail saved successfully"
          });
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
            // this.errors.push({});
            Toast.fire({
              position: 'top-end',
              type: "error",
              title: "Opss..Course Details was not saved"
            });
            
          }
        });
    },
    edit(prospectus_Id) {
      let vm = this;
      axios({
        method: "get",
        url: `/course/prospectus/info/${prospectus_Id}`
      })
        .then(res => {
          vm.fields = res.data;
        })
        .catch(err => console.log(err));
    },
    remove(prospectus_listId) {
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
            axios({
              method: "get",
              url: "/course/prospectus/destroy/" + prospectus_listId
            }).then(response => {
              swal.fire(
                "Deleted!",
                "Course Details has been deleted.",
                "success"
              );
            this.getProspectusList();
            });
          }
        });
    }
    // If trainingdlvrloc per state
    // filterTrainingDeliveryLoc(state){
    //     axios({
    //         method: 'get',
    //         url: '/course/prospectus/' + state,
    //     }).then(response => {
    //         if(response.data != null){
    //             this.slct_training_dlvr_loc = response.data;
    //         }
    //     });
    // }
  }
};
</script>

<style>
.formunits {
  counter-reset: my-awesome-counter;
}
.formunits .unitsclass .multiselect__tags-wrap {
  display: inline-grid;
}
.formunits .unitsclass .multiselect__tags-wrap .multiselect__tag:before {
  counter-increment: my-awesome-counter;
  content: counter(my-awesome-counter) ". ";
  color: #024b67;
  font-weight: bold;
}
</style>