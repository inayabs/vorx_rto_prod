<template>
  <div>
    <!-- <div class="row mb-2 d-flex justify-content-between"> -->
    <!-- <div class="col-md-12"> -->
    <!-- <a href="/unit" v-bind:class="'btn btn-'+app_color+' btn-sm text-primary text-light'">
          <i class="fas fa-long-arrow-alt-left"></i> Back
    </a>-->
    <!-- </div> -->
    <!-- </div> -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-header py-3">
          <h6 :class="'m-0 font-weight-bold text-'+app_color">Edit Unit</h6>
    </div>-->
    <!-- <div class="card-body"> -->
    <div>
      <!-- <form> -->
      <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
        <h6>Units</h6>
      </div>
      <div class="row mb-2 d-flex justify-content-between">
        <div class="col-md-12">
          <button
            v-if="is_open == 0"
            @click="unitFields()"
            class="btn btn-success btn-sm d-block ml-auto"
          >
            <i class="fas fa-plus"></i> Add
          </button>
          <button v-else @click="unitFields()" class="btn btn-danger btn-sm d-block ml-auto">
            <i class="fas fa-minus"></i> Remove
          </button>
        </div>
      </div>
      <div class="form-padding-left-right" v-bind:class="is_open == 0 ? 'unit-fields-hide' : ''">
        <div class="row">
          <div class="col-lg-10">
            <div class="form-group">
              <label for="unit_code" v-if="is_update == 0">Unit:  <i>(Note: to add a new Unit. place a dash "-" between the Unit Code and Unit Title)</i></label>
              <label for="unit_code" v-else>Unit:  <i>(Note: Unit code and title cannot be edited.)</i></label>
              <!-- <input
                        type="text"
                        class="form-control"
                        id="unit_code"
                        v-model="fields.unit_code"
                        :class="[errors && errors.unit_code ? 'border-danger' : '']"
              />-->
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
                v-model="fields.unit_code_obj"
                placeholder="Type to search Unit"
                tag-placeholder="Add this as new unit"
                track-by="subject_code"
                label="unit_title"
                v-if="is_update == 0"
              >
                <span slot="noResult">Oops! No Unit found. Consider changing the search query.</span>
              </multiselect>
              <input type="text" v-else :value="fields.unit_code +' - '+ fields.unit_title" class="form-control" disabled>
              <div
                v-if="errors && errors.unit_code"
                class="badge badge-danger"
              >{{ errors.unit_code[0] }}</div>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="form-group">
              <label for="unit_type" class>Unit Type:</label>
              <select
                class="form-control"
                id="unit_type"
                v-model="fields.unit_type"
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
                v-model="fields.unit_title"
                :class="[errors && errors.unit_title ? 'border-danger' : '']"
              />
              <div
                v-if="errors && errors.unit_title"
                class="badge badge-danger"
              >{{ errors.unit_title[0] }}</div>
            </div>
          </div> -->
          <div class="col-lg-12">
            <div class="form-group">
              <label for="assessment_method" class>Assessment Method:</label>
              <multiselect
                v-model="fields.assessment_method"
                :options="am"
                :multiple="true"
                :searchable="true"
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
              <select
                class="form-control"
                id="subject_educ_fld_identifier_id"
                v-model="fields.subject_educ_fld_identifier_id"
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
              >{{ errors.subject_educ_fld_identifier_id[0] }}</div>
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
                v-model="fields.nominal_hours"
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
              <label for="scheduled_hours" class>Scheduled Hours:</label>
              <input
                type="number"
                min="0"
                class="form-control"
                id="scheduled_hours"
                v-model="fields.scheduled_hours"
                :class="[errors && errors.scheduled_hours ? 'border-danger' : '']"
              />
              <div
                v-if="errors && errors.scheduled_hours"
                class="badge badge-danger"
              >{{ errors.scheduled_hours[0] }}</div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="training_method_id" class>Training Method:</label>
              <select
                class="form-control"
                id="training_method_id"
                v-model="fields.training_method_id"
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
                  v-model="fields.vet_flag"
                  value="0"
                />
                <label class="custom-control-label" for="vet_flag">VET Flag Status</label>
              </div>
            </div>
          </div>
          <!-- <div class="col-lg-4">
                    <div class="form-group">
                      <div class="custom-control custom-switch my-3">
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          id="extra_unit"
                          name="extra_unit"
                          v-model="fields.extra_unit"
                          value="0"
                        />
                        <label class="custom-control-label" for="extra_unit">Set as Unit of Competency</label>
                      </div>
                    </div>
          </div>-->
          <div class="col-lg-4">
            <div class="form-group">
              <div class="custom-control custom-switch my-3">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  id="active"
                  name="active"
                  v-model="fields.active"
                  value="0"
                />
                <label class="custom-control-label" for="active">Set as Active</label>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="form-group float-right">
              <button class="btn btn-success" @click="createUnit" v-if="is_update == 0">
                <i class="fas fa-save"></i> Save Changes
              </button>
              <button class="btn btn-success" @click="createUnit" v-else>
                <i class="fas fa-save"></i> Update Changes
              </button>
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
      <div class slot="active" slot-scope="{row}">
        <i :class="'fas fa-'+[row.active? 'check text-success' : 'times text-danger']"></i>
      </div>
      <div class="btn-group" slot="actions" slot-scope="{row}">
        <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row)">
          <i class="fas fa-edit"></i>
        </a>
        <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row)">
          <i class="fas fa-trash"></i>
        </a>
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
      course_code: window.course_code,
      unit_options: {},
      fields: {},
      // Form Inputs
      unit_field_educ: [],
      training_methods: [],
      am: [],
      errors: [],
      is_update: 0,
      is_open: 0,
      opt: [],
      isLoading: false,
      // list
      units_list: [],
      columns: ["code", "description", "active", "actions"],
      options: {
        initialPage: 1,
        perPage: 10,
        highlightMatches: true,
        sortIcon: {
          base: "fas",
          up: "fa-sort-amount-up",
          down: "fa-sort-amount-down",
          is: "fa-sort",
        },
        headings: {
          name: "Unit Code",
          location: "Unit Description",
          active: "Status",
          actions: "Actions",
        },
        sortable: ["code", "description", "is_active"],
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords",
        },
        cellClasses: {
          is_active: [
            {
              class: "active",
              condition: (row) => row.active === 1,
            },
            {
              class: "inactive",
              condition: (row) => row.active === 0,
            },
          ],
        },
      },
    };
  },
  watch: {
    // fields: function(value) {
    //   if (value.code != null) {
    //     this.errors.code = "";
    //   }
    //   if (value.description != null) {
    //     this.errors.description = "";
    //   }
    //   if (value.assessment_method != null) {
    //     this.errors.assessment_method = "";
    //   }
    // }
  },
  created() {
    this.fetchData();
    // this.fields.assessment_method = this.assessment_method;
  },
  methods: {
    topFunction() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
    remove(row) {
      let vm = this;

      if(typeof row.used_by_student !== 'undefined' && row.used_by_student == 1){
        swal.fire("Oppss..", "Unit is assigned to a student. Deleting it will cause referrence error.", "error");
        return false;
      }

      swal
        .fire({
          title: "Are you sure to remove " + row.code + "?",
          // text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, remove unit!",
        })
        .then((result) => {
          if (result.value) {
            // vm.createUnit();
            axios
              .post("/course-unit/remove", {
                row: row,
                course_code: vm.course_code,
              })
              .then(function (res) {
                if (
                  typeof res.data.status !== "undefined" &&
                  res.data.status == "success"
                ) {
                  swal.fire("Success", "Unit removed successfully", "success");
                  vm.fetchData();
                  vm.fields = {assessment_method:[]};
                  vm.is_update = 0;
                  vm.is_open = 0;
                } else {
                  swal.fire("Oppss..", "Something went wrong..", "error");
                }
              })
              .catch(function (error) {
                console.log(error);
              });
          }
        });
    },
    edit(row) {
      this.topFunction();
      this.is_update = 1;
      this.is_open = 1;
      let selected = {};
      selected.unit_details = row;
      this.checkSelect(selected);

      // this.fields.unit_code = {
      //   subject_code : row.code,
      //   description : row.description
      // };
    },
    fetchData() {
      // this.fields = post_details;
      let vm = this;
      axios
        .get("/course-unit/show/" + vm.course_code)
        .then(function (res) {
          // handle success
          vm.unit_options = res.data;
          vm.unit_field_educ = res.data.unit_field_educ;
          vm.training_methods = res.data.training_methods;
          vm.am = res.data.assessment_method;
          vm.units_list = res.data.course_units;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });
    },
    confirm() {
      let type = this.is_update == 0 ? "create" : "update";
      let vm = this;
      swal
        .fire({
          title: "Are you sure to " + type + " Unit?",
          // text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, " + type + " unit!",
        })
        .then((result) => {
          if (result.value) {
            if (type == "create") {
              vm.createUnit();
            }
          }
        });
    },
    createUnit() {
      let vm = this;
      let type = this.is_update == 0 ? "created" : "updated";
      // swal.fire({
      //     title: 'Saving unit..',
      //     // html: '',// add html attribute if you want or remove
      //     allowOutsideClick: false,
      //     onBeforeOpen: () => {
      //         swal.showLoading()
      //     },
      // });

      axios
        .post("/course-unit/create", {
          unit: vm.fields,
          course_code: vm.course_code,
          unit_type: vm.fields.unit_type,
          assessment_method: vm.fields.assessment_method,
          scheduled_hours: vm.fields.scheduled_hours,
          subject_educ_fld_identifier_id: vm.fields.subject_educ_fld_identifier_id,
          nominal_hours: vm.fields.nominal_hours,
          training_method_id: vm.fields.training_method_id,
          vet_flag: vm.fields.vet_flag,
          extra_unit: 0,
          used_by_student: vm.fields.used_by_student,
          active: vm.fields.active,
        })
        .then(function (res) {
          if (
            typeof res.data.status !== "undefined" &&
            res.data.status == "success"
          ) {
            swal.fire("Success", "Unit " + type + " successfully", "success");
            vm.unitFields();
          } else {
            swal.fire("Oppss..", "Something went wrong..", "error");
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    unitFields() {
      this.is_open = this.is_open == 0 ? 1 : 0;
      if (this.is_open == 1) {
        this.unit_field_educ = this.unit_options.unit_field_educ;
        this.training_methods = this.unit_options.training_methods;
        this.am = this.unit_options.assessment_method;
      } else {
        this.fetchData();
        this.fields = {assessment_method:[]};
        this.is_update = 0;
      }
    },
    checkSelect(selected) {
      let vm = this;
      // console.log(selected);
      // this.fields = selected.unit_details;
      this.isLoading = false;
      // this.fields.assessment_method = selected.unit_details;
      if (typeof selected.unit_details !== "undefined") {
        // console.log(selected.unit_details.assessment_method);
        let sam = ["", null].indexOf(selected.unit_details.assessment_method) == -1 ? selected.unit_details.assessment_method.split(",") : [];
        let getAM = [];
        let vm = this;
        vm.fields = {assessment_method:[]};
        if (sam.length > 0) {
          sam.forEach((element) => {
            // console.log(element);
            vm.am.forEach((el) => {
              if (element == el.id) {
                getAM.push({description:el.description, id:el.id});
              }
            });
          });
        }
        // console.log(getAM);
        // check if update
        if (selected.unit_details.course_code.length > 0) {
          selected.unit_details.course_code.forEach((e) => {
            if (e == vm.course_code) {
              vm.is_update = 1;
            }
          });
        } else {
          vm.is_update = 0;
        }
        // console.log(getAM);
        // console.log(vm.am);
        vm.fields.assessment_method = getAM;
        vm.fields.nominal_hours = selected.unit_details.nominal_hours;
        vm.fields.scheduled_hours = selected.unit_details.scheduled_hours;
        vm.fields.subject_educ_fld_identifier_id = selected.unit_details.subject_educ_fld_identifier_id;
        vm.fields.training_method_id = selected.unit_details.training_method_id;
        vm.fields.unit_title = selected.unit_details.description;
        vm.fields.unit_type = selected.unit_details.unit_type;
        vm.fields.vet_flag = selected.unit_details.vet_flag;
        vm.fields.active = selected.unit_details.active;
        vm.fields.unit_code = selected.unit_details.code;
        vm.fields.unit_code_obj = {
          unit_code: selected.unit_details.code,
          unit_title: selected.unit_details.description,
        };
        vm.fields.unit_details = selected.unit_details;
      } else {
        vm.is_update = 0;
        vm.fields = {assessment_method:[]};
        vm.fields.unit_code = selected.unit_code;
        vm.fields.unit_title = selected.unit_title;
      }

      // vm.fetchData();
    },
    addTag(newTag) {
      // // console.log(newTag);
      // this.fields.unit_code = newTag;
      // this.fields.unit_code_obj = {
      //   subject_code: newTag,
      //   description: "",
      // };

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
            fields.unit_code_obj = tag;
            fields.unit_code = tag.unit_code;
            fields.unit_title = tag.unit_title;
            af.opt.push(tag);
        }

      this.is_update = 0;
      // let af = this;
      // const fixedtag = newTag.split("-");
      // const tag = {
      //   tp_code: "",
      //   unit_code: fixedtag[0],
      //   unit_title: fixedtag[1]
      // };
      // af.opt.push(tag);
      // af.fields = tag;
    },
    fetchUnitOption(query) {
      let af = this;

      if (query == "") {
        af.opt = [];
      } else {
        af.isLoading = true;
        axios
          .get("/course-setup/unit_options/" + query)
          .then(function (response) {
            // handle success
            // console.log(response.data);
            af.isLoading = false;
            af.opt = response.data;
          })
          .catch(function (error) {
            // handle error
            af.isLoading = false;
            console.log(error);
          })
          .then(function () {
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
      cwc += unit_title == "" ? "" : " - " + unit_title;
      // console.log(cwc);
      return cwc;
      // return `${subject_code} - ${description}`;
    },
  },
};
</script>


<style scoped>
.unit-fields-hide {
  display: none;
}
</style>
