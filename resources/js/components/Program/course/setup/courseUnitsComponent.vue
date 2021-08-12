<template>
  <div>
    <!-- <div class="row mb-2 d-flex justify-content-between"> -->
      <!-- <div class="col-md-12"> -->
        <!-- <a href="/unit" v-bind:class="'btn btn-'+app_color+' btn-sm text-primary text-light'">
          <i class="fas fa-long-arrow-alt-left"></i> Back
        </a> -->
      <!-- </div> -->
   <!-- </div> -->
    <!-- <div class="card shadow mb-4"> -->
      <!-- <div class="card-header py-3">
          <h6 :class="'m-0 font-weight-bold text-'+app_color">Edit Unit</h6>
      </div> -->
      <!-- <div class="card-body"> -->
          <div>
            <!-- <form> -->
            <div class="row mb-3">
                <div class="col-md-6 pull-right text-left">
                    <!-- <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('course')" ><i class="fas fa-chevron-circle-left"></i> Course</button> -->
                    <button class="btn btn-md" :class="'btn-info'" @click="proceedTab('course')" ><i class="fas fa-chevron-circle-left"></i> Course</button>
                </div>
                <div class="col-md-6 pull-right text-right">
                    <!-- <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('next')" ><i class="fas fa-chevron-circle-right"></i> Course Delivery Location</button> -->
                    <button class="btn btn-md" :class="'btn-info'" @click="proceedTab('next')" ><i class="fas fa-chevron-circle-right"></i> Course Delivery Location</button>
                </div>
            </div>
              <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>Units</h6>
              </div>
              <div class="row mb-2 d-flex justify-content-between">
                <div class="col-md-12">
                  <button v-if="is_open == 0" @click="unitOpt()" class="btn btn-success btn-sm d-block ml-auto">
                    <i  class="fas fa-plus"></i> Add
                  </button>
                  <button v-else @click="unitOpt()" class="btn btn-danger btn-sm d-block ml-auto">
                    <i  class="fas fa-minus"></i> Remove
                  </button>
                </div>
              </div>
              <div class="form-padding-left-right" v-bind:class="is_open == 0 ? 'unit-unit-hide' : ''">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="unit_code" class>Unit Code: <i>(Note: to add a new Unit. place a dash "-" between the Unit Code and Unit Title)</i></label>
                      <!-- <input
                        type="text"
                        class="form-control"
                        id="unit_code"
                        v-model="unit.unit_code"
                        :class="[errors && errors.unit_code ? 'border-danger' : '']"
                      /> -->
                      <multiselect
                        :class="'multiselect-color-'+app_color"
                        :options="opt"
                        :multiple="false"
                        :custom-label="courseWithCode"
                        :close-on-select="true"
                        :searchable="true"
                        :loading="isLoading"
                        :limit="3"
                        :limit-text="limitText"
                        :max-height="600"
                        @tag="addTag"
                        :show-no-results="false"
                        :hide-selected="true"
                        :taggable="true"
                        @select="checkSelect"
                        @search-change="fetchUnitOption"
                        id="ajax"
                        v-model="unit.unit_code_obj"
                        placeholder="Type to search Unit"
                        tag-placeholder="Add this as new unit"
                        track-by="subject_code"
                        label="unit_title"
                      >
                        <span slot="noResult">Oops! No Unit found. Consider changing the search query.</span>
                      </multiselect>
                      <div v-if="errors && errors.unit_code" class="badge badge-danger">{{ errors.unit_code[0] }}</div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="unit_type" class>Unit Type:</label>
                      <select
                        class="form-control"
                        id="unit_type"
                        v-model="unit.unit_type"
                        :class="[errors && errors.unit_type ? 'border-danger' : '']"
                      >
                        <option value="core">Core</option>
                        <option value="elective">Elective</option>
                      </select>
                      <div
                        v-if="errors && errors.unit_type"
                        class="badge badge-danger"
                      >{{ errors.unit_type[0] }}</div>
                    </div>
                  </div>
                  <!-- <div class="col-lg-12">
                    <div class="form-group">
                      <label for="unit_title" class>Subject Description:</label>
                      <input
                        type="text"
                        class="form-control"
                        id="unit_title"
                        v-model="unit.unit_title"
                        :class="[errors && errors.unit_title ? 'border-danger' : '']"
                      />
                      <div
                        v-if="errors && errors.unit_title"
                        class="badge badge-danger"
                      >{{ errors.unit_title[0] }}</div>
                    </div>
                  </div> -->
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="assessment_method" class>Assessment Method:</label>
                      <multiselect
                        v-model="unit.assessment_method"
                        :options="am"
                        :multiple="true"
                        :searchable="false"
                        :close-on-select="false"
                        label="description"
                        track-by="id"
                        :class="[errors && errors.assessment_method ? 'border-danger' : '', 'multiselect-color-'+app_color]"
                      ></multiselect>
                      <div
                        v-if="errors && errors.assessment_method"
                        class="badge badge-danger"
                      >{{ errors.assessment_method[0] }}</div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="form-group">
                      <label
                        for="subject_educ_fld_identifier_id"
                        class
                      >Subject Field of Education Identifier:</label>
                      <!-- <select
                        class="form-control"
                        id="subject_educ_fld_identifier_id"
                        v-model="unit.subject_educ_fld_identifier_id"
                        :class="[errors && errors.subject_educ_fld_identifier_id ? 'border-danger' : '']"
                      >
                        <option
                          v-bind:value="ufe.id"
                          v-for="ufe in unit_field_educ"
                          :key="ufe.id"
                        >{{ ufe.description }}</option>
                      </select>
                      <div
                        v-if="errors && errors.subject_educ_fld_identifier_id"
                        class="badge badge-danger"
                      >{{ errors.subject_educ_fld_identifier_id[0] }}</div> -->
                      <multiselect 
                            v-model="unit.subject_educ_fld_identifier_id" 
                            :options="unit_field_educ" 
                            :multiple="false"  
                            :class="'multiselect-color-'+app_color"
                            placeholder="Type to search" 
                            :close-on-select="true"  
                            :track-by="'id'" 
                            :label="'description'"
                        >
                            <span slot="noResult">Oops! No data found. Consider changing the search query.</span>
                        </multiselect>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label for="nominal_hours" class>Nominal Hours:</label>
                      <input
                        type="number"
                        min="0"
                        class="form-control"
                        id="nominal_hours"
                        v-model="unit.nominal_hours"
                        :class="[errors && errors.nominal_hours ? 'border-danger' : '']"
                      />
                      <div
                        v-if="errors && errors.nominal_hours"
                        class="badge badge-danger"
                      >{{ errors.nominal_hours[0] }}</div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label for="schedule_hours" class>Scheduled Hours:</label>
                      <input
                        type="number"
                        min="0"
                        class="form-control"
                        id="schedule_hours"
                        v-model="unit.schedule_hours"
                        :class="[errors && errors.schedule_hours ? 'border-danger' : '']"
                      />
                      <div
                        v-if="errors && errors.schedule_hours"
                        class="badge badge-danger"
                      >{{ errors.schedule_hours[0] }}</div>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label for="training_method_id" class>Training Method:</label>
                      <select
                        class="form-control"
                        id="training_method_id"
                        v-model="unit.training_method_id"
                        :class="[errors && errors.training_method ? 'border-danger' : '']"
                      >
                        <option
                          v-bind:value="tm.id"
                          v-for="tm in training_methods"
                          v-bind:key="tm.id"
                        >{{ tm.description }}</option>
                      </select>
                      <div
                        v-if="errors && errors.training_method_id"
                        class="badge badge-danger"
                      >{{ errors.training_method_id[0] }}</div>
                    </div>
                  </div>
                  <div class="clearfix w-100"></div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="custom-control custom-switch my-3">
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          id="vet_flag"
                          name="vet_flag"
                          v-model="unit.vet_flag"
                          value="0"
                        />
                        <label class="custom-control-label" for="vet_flag">VET Flag Status</label>
                      </div>
                    </div>
                  </div> <!--  -->
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="custom-control custom-switch my-3">
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          id="extra_unit"
                          name="extra_unit"
                          v-model="unit.extra_unit"
                          value="0"
                        />
                        <label class="custom-control-label" for="extra_unit">Set as Unit of Competency</label>
                      </div>
                    </div>
                  </div> <!--  -->
                  <!-- <div class="col-lg-4">
                    <div class="form-group">
                      <div class="custom-control custom-switch my-3">
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          id="active"
                          name="active"
                          v-model="unit.active"
                          value="0"
                        />
                        <label class="custom-control-label" for="active">Set as Active</label>
                      </div>
                    </div>
                  </div> -->
                  <div class="col-lg-12">
                    <div class="form-group float-right">
                      <button class="btn btn-success" @click="checkUnit" v-if="is_update == 0"><i class="fas fa-save"></i> Add Unit</button>
                      <button class="btn btn-success" @click="checkUnit" v-else><i class="fas fa-save"></i> Update Unit</button>
                    </div>
                  </div>
                </div>
              </div>
            <!-- </form>           -->
          </div>
          <!-- Unit list -->
          <v-client-table
              :class="'header-'+app_color"
              :columns="columns"
              :data="units_list"
              ref="unitList"
              :options="options"
          >
              <div class="" slot="active" slot-scope="{row}">
                  <i :class="'fas fa-'+[row.active? 'check text-success' : 'times text-danger']"></i> {{row.active ? 'Active' : 'Not Active'}}
              </div>
              <div class="btn-group" slot="actions" slot-scope="{row}">
                  <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row)"> <i class="fas fa-edit"> </i></a>
                  <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row)"> <i class="fas fa-trash"> </i></a>
              </div>
          </v-client-table>
      <!-- </div> -->
    <!-- </div> -->
  </div>
</template>


<script>
// import FormMixin from "../../../mixins/FormMixin";
export default {
  // mixins: [FormMixin],
  name: "unitCreate",
  data() {
    return {
      // Form Attributes
      // action: "/unit/" + post_id,
      // method: "put",
      app_color: app_color,
      course: {},
      unit_options: {},
      unit: {active:true},
      
      // Form Inputs
      unit_field_educ: [],
      training_methods: [],
      am: window.am,
      errors: [],
      is_update: 0,
      is_open: 0,
      opt: [],
      isLoading: false,
      // list
      units_list: [],
      prospectus_list: [],
      columns: ["unit_code", "unit_title", 'active', "actions"],
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
          unit_code: "Unit Code",
          unit_title: "Unit Description",
          active: "Status",
          actions: "Actions"
        },
        sortable: ["unit_code", "unit_title", "active"],
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords"
        },
        cellClasses: {
          active: [
            {
              class: "active",
              condition: row => row.active === 1
            },
            {
              class: "inactive",
              condition: row => row.active === 0
            }
          ]
        }
      }
    };
  },
  watch: {},
  created() {
      this.unit_options = this.$parent.$store.state.unit_opt;
  },
  methods: {
    proceedTab(proceed) {
        this.$parent.$store.state.units = this.units_list;
        document.getElementById("nav-units-tab").classList.add('disabled')
        if(proceed == 'course'){
            document.getElementById("nav-info-tab").classList.remove('disabled')
            this.is_open = 0;
            $('a[href="#nav-info"]').tab('show')
        }
        if(proceed == 'next'){
            if(this.units_list.length > 0){
                document.getElementById("nav-prospectus-tab").classList.remove('disabled')
                this.is_open = 0;
                this.$parent.$children[2].formOpen();
                $('a[href="#nav-prospectus"]').tab('show')
            }else{
                swal.fire(
                    'Oppss..',
                    'No units added..',
                    'error'
                )
                return 0;
            }
        }
    },
    async remove(row) {
        let vm = this;
        swal.fire({
            title: 'Are you sure to remove '+ row.unit_code+' - '+row.unit_title,
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                    let uu = []
                    vm.units_list.forEach(el => {
                        if(el.unit_code != row.unit_code){
                            // vm.units_list[count] = ;
                            uu.push(el) 
                        }
                    })
                    vm.units_list = uu;
                    swal.fire(
                        'Success',
                        'Unit deleted successfully',
                        'success'
                    )
                    vm.unit = {active:true};
            }else{
                return false;
            }
        })
    },
    topFunction() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
    edit(row){
        this.unit = row;
        this.is_update = 1;
        this.topFunction();
    },
    fetchData() {

    },
    confirm(title = 'Do you want to add unit to course detail?'){
    //   let type = this.is_update == 0 ? 'create' : 'update';
      let vm = this;
       swal.fire({
          title: title,
          // text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
      }).then((result) => {
          if (result.value) {
            //   if(type == 'create'){
                return true
            //   }
          }else{
              return false;
          }
      })
    },
    checkUnit() {
        let vm = this;
        if(typeof vm.unit.unit_code === 'undefined' || ['',null].indexOf(vm.unit.unit_code) != -1){
            swal.fire(
                'Oppss..',
                'Unit is required..',
                'error'
            )
            return false;
        }
        if(vm.units_list.length > 0 && vm.is_update == 0){
            let has = 0;
                vm.units_list.forEach(el =>{
    
                    if(el.unit_code == vm.unit.unit_code){
                        has = 1;
                        return false;
                    }
                })
    
                if(has == 1){
                    swal.fire(
                        'Oppss..',
                        'Unit already existed..',
                        'error'
                    )
                    return false;
                }else{
                    vm.createUnit()
                }
            
        }else{
            vm.createUnit();
        }
    },
    async createUnit(){
        let vm = this;
        let type = this.is_update == 0 ? 'added' : 'updated';
        
        swal.fire({
            title: 'Processing Unit..',
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
                swal.showLoading()
            },
        });

        if(this.is_update == 0){
            // add
            vm.units_list.push(vm.unit);
            swal.fire(
                'Success',
                'Unit '+type+' successfully',
                'success'
            )
            vm.unit = {active:true};
            vm.is_update = 0;

        }else{
            // update
            let count = 0;
            let uu = []
            await vm.units_list.forEach(el => {
                if(el.unit_code == vm.unit.unit_code){
                    // vm.units_list[count] = ;
                    uu.push(vm.unit)
                }else{
                    uu.push(el) 
                }
                count++;
            })
            vm.units_list = uu;
            swal.fire(
                'Success',
                'Unit '+type+' successfully',
                'success'
            )
            vm.unit = {active:true};
            vm.is_update = 0;
            // console.log();
        }
      
        
        
    //   axios.post('/course-unit/create',{
    //     unit: vm.unit,
    //     course_code: vm.course_code,
    //     unit_type: vm.unit.unit_type,
    //     assessment_method: vm.unit.assessment_method,
    //     subject_educ_fld_identifier_id: vm.unit.subject_educ_fld_identifier_id,
    //     nominal_hours: vm.unit.nominal_hours,
    //     training_method_id: vm.unit.training_method_id,
    //     vet_flag: vm.unit.vet_flag,
    //     extra_unit: 0,
    //     active: vm.unit.active,

    //   }).then(function (res) {
    //     if(typeof res.data.status !== 'undefined' && res.data.status == 'success'){
    //       swal.fire(
    //           'Success',
    //           'Unit '+type+' successfully',
    //           'success'
    //       )
    //       vm.unitOpt();
    //     }else{
    //       swal.fire(
    //           'Oppss..',
    //           'Something went wrong..',
    //           'error'
    //       )
    //     }
    //   })
    //   .catch(function (error) {
    //     console.log(error);
    //   });
    },
    unitOpt(){
      this.course = this.$parent.$store.state.course;
      
      this.is_open = this.is_open == 0 ? 1 : 0;
      if(this.is_open == 1){
        this.unit_field_educ = this.unit_options.unit_field_educ;
        this.training_methods = this.unit_options.training_methods;
        this.am = this.unit_options.assessment_method;
      }else{
        // this.fetchData();
        this.unit = {active:true};
        this.is_update = 0;
      }
    },
    checkSelect(selected) {
      this.unit.unit_code = selected.unit_code;
      this.unit.unit_title = selected.unit_title;
      this.isLoading = false;
      
    },
    addTag(newTag) {

        let af = this;
        const fixedtag = newTag.split("-");
        if(fixedtag.length < 2){
            swal.fire(
                'Oppss..',
                'Please follow the unit format..',
                'error'
            )
        }else{
            const tag = {
                tp_code: "",
                unit_code: fixedtag[0].trim(),
                unit_title: fixedtag[1].trim()
            };
            af.unit.unit_code_obj = tag;
            af.unit.unit_code = tag.unit_code;
            af.unit.unit_title = tag.unit_title;
            af.opt.push(tag);
        }

    },
    fetchUnitOption(query) {
      let af = this;

      if (query == "") {
        af.opt = [];
      } else {
        af.isLoading = true;
        axios
          .get("/course-setup/unit_options/" + query)
          .then(function(response) {
            // handle success
            // console.log(response.data);
            af.isLoading = false;
            af.opt = response.data;
          })
          .catch(function(error) {
            // handle error
            af.isLoading = false;
            console.log(error);
          })
          .then(function() {
            // always executed
            // alert(af.selectedStudent);
            af.isLoading = false;
          });
      }
    },
    limitText(count) {
      return `and ${count} other units`;
    },
    courseWithCode({ unit_code, unit_title }) {
      let cwc = unit_code;
      cwc += unit_title == '' ? '' : ' - '+ unit_title
      // console.log(cwc);
      return cwc;
      // return `${subject_code} - ${description}`;
    }
  }
};
</script>


<style scoped>
  .unit-unit-hide{
    display: none;
  }
</style>
