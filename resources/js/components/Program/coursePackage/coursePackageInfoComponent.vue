<template>
  <div>
          <div class="row mb-2 d-flex justify-content-between">
            <div class="col-md-12">
                <a
                  href="/course-package"
                  v-bind:class="'btn btn-'+app_color+' btn-sm text-primary text-light'"
                >
                <i class="fas fa-long-arrow-alt-left"></i> Back
                </a>
            </div>
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Course Package Details</h6>
            </div>
            <div class="card-body">
                <div>
                    <form @submit.prevent="update">
                    <div class="row mb-2 d-flex justify-content-between">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-sm d-block ml-auto">
                          <i class="far fa-save"></i> Save Package Info
                        </button>
                      </div>
                    </div>
                    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                      <h6>Course Package</h6>
                    </div>
                    <div class="form-padding-left-right">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="name">Name:</label>
                            <input
                              type="text"
                              id="name"
                              class="form-control"
                              v-model="fields.name"
                              :class="[errors && errors.name ? 'border-danger' : '']"
                            />
                            <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="shore_type">Student Location:</label>
                            <select
                              id="shore_type"
                              class="form-control"
                              v-model="fields.shore_type"
                              :class="[errors && errors.shore_type ? 'border-danger' : '']"
                            >
                              <option value="ONSHORE">ONSHORE</option>
                              <option value="OFFSHORE">OFFSHORE</option>
                            </select>
                            <div
                              v-if="errors && errors.shore_type"
                              class="badge badge-danger"
                            >{{ errors.shore_type[0] }}</div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="location">State:</label>
                            <select
                              id="location"
                              class="form-control"
                              v-model="fields.location"
                              :class="[errors && errors.location ? 'border-danger' : '']"
                            >
                              <!-- <option value="QLD">Queensland (QLD)</option>
                              <option value="VIC">Victoria (VIC)</option> -->
                              <option v-for="(location, index) in state" :key="index"  :value="location.state_key">{{location.state_name}}</option>
                            </select>
                            <div
                              v-if="errors && errors.location"
                              class="badge badge-danger"
                            >{{ errors.location[0] }}</div>
                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea
                              id="description"
                              class="form-control"
                              v-model="fields.description"
                              cols="30"
                              rows="5"
                              :class="[errors && errors.description ? 'border-danger' : '']"
                            ></textarea>
                            <div
                              v-if="errors && errors.description"
                              class="badge badge-danger"
                            >{{ errors.description[0] }}</div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="delivery_location_id">Delivery Location:</label>
                            <select
                              id="delivery_location_id"
                              class="form-control"
                              v-model="fields.delivery_location_id"
                              :class="[errors && errors.delivery_location_id ? 'border-danger' : '']"
                            >
                              <!-- <option value="QLD">Queensland (QLD)</option>
                              <option value="VIC">Victoria (VIC)</option> -->
                              <option v-for="(item, index) in dlvr_location" :key="index"  :value="item.id">{{item.train_org_dlvr_loc_name}}</option>
                            </select>
                            <!-- <date-picker
                              locale="en"
                              v-model="fields.date_created"
                              :max-date="new Date()"
                              :formats="formats"
                              :class="[errors && errors.date_created ? 'border-danger' : '']"
                            ></date-picker> -->
                            <div
                              v-if="errors && errors.date_created"
                              class="badge badge-danger"
                            >{{ errors.date_created[0] }}</div>
                          </div>
                          <div class="form-group">
                            <label for="is_active">Status:</label>
                            <div class="custom-control custom-switch my-2">
                              <input
                                type="checkbox"
                                class="custom-control-input"
                                id="is_active"
                                v-model="fields.is_active"
                                value="0"
                              />
                              <label class="custom-control-label" for="is_active">Set as Active</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                    <h6>Package Details</h6>
                  </div>
                  <table :class="'table header-'+app_color" width="100%">
                    <thead>
                      <tr>
                        <th width="10%" :class="'table-header-'+app_color">Order</th>
                        <th width="80%" :class="'table-header-'+app_color">Course Matrix</th>
                        <!-- <th width="20%">Start Date</th>
                        <th width="20%">End Date</th>-->
                        <th width="10%" :class="'table-header-'+app_color">
                          <a href="javascrip:void(0)" class="btn btn-success btn-sm" @click="addPackage">
                            <i class="fas fa-plus"></i> Add
                          </a>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="10%" class="p-0"></td>
                        <td width="80%" class="p-0"></td>
                        <!-- <td width="20%" class="p-0"></td>
                        <td width="20%" class="p-0"></td>-->
                        <td width="10%" class="p-0"></td>
                      </tr>
                      <tr v-for="(pckg, index) in pckgs">
                        <td width="10%">
                          <input
                            type="number"
                            min="1"
                            class="form-control"
                            v-model="pckg.order"
                            :class="[errs[index] && errs[index].order ? 'border-danger' : '']"
                          />
                          <div
                            v-if="errs[index] && errs[index].order"
                            class="badge badge-danger"
                          >{{ errs[index].order[0] }}</div>
                        </td>
                        <td width="80%">
                          <select
                            class="form-control"
                            v-model="pckg.course_matrix_id"
                            :class="[errs[index] && errs[index].course_matrix_id ? 'border-danger' : '']"
                          >
                            <option
                              v-for="cm in courseMatrix"
                              :key="cm.id"
                              v-bind:value="cm.id"
                            >{{ cm.course_code }} - {{ cm.detail.name }} — {{ cm.location }}</option>
                          </select>
                          <div
                            v-if="errs[index] && errs[index].course_matrix_id"
                            class="badge badge-danger"
                          >{{ errs[index].course_matrix_id[0] }}</div>
                        </td>
                        <!-- <td width="20%">
                          <date-picker v-model="pckg.course_start_date" :formats='formats' :class="[errs[index] && errs[index].course_start_date ? 'border-danger' : '']"></date-picker>
                          <div v-if="errs[index] && errs[index].course_start_date" class="badge badge-danger">{{ errs[index].course_start_date[0]  }}</div>
                        </td>
                        <td width="20%">
                          <date-picker v-model="pckg.course_end_date" :formats='formats' :class="[errs[index] && errs[index].course_end_date ? 'border-danger' : '']"></date-picker>
                          <div v-if="errs[index] && errs[index].course_end_date" class="badge badge-danger">{{ errs[index].course_end_date[0]  }}</div>
                        </td>-->
                        <td width="10%">
                          <div class="btn-group">
                            <a
                              href="javascript:void(0)"
                              class="btn btn-primary btn-sm"
                              @click.prevent="savePackage(index);"
                            >
                              <i class="fas fa-save"></i>
                            </a>
                            <a
                              href="javascript:void(0)"
                              class="btn btn-danger btn-sm"
                              @click="removePackage(index);"
                            >
                              <i class="fas fa-trash"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
import FormMixin from "../../../mixins/FormMixin";
import moment from "moment";
export default {
  mixins: [FormMixin],
  name: "coursePackageInfo",
  data() {
    return {
      app_color: app_color,
      courseMatrix: course_matrix,
      packageId: course_package.id,
      dlvr_location : window.dlvr_location,
      state: window.state,
      pckgs: [],
      errs: [],
      // Form Attributes
      action: "/course-package/" + course_package.id,
      method: "put",

      formats: {
        title: "MMMM YYYY",
        weekdays: "W",
        navMonths: "MMM",
        input: ["L", "YYYY-MM-DD", "DD/MM/YYYY"],
        dayPopover: ""
      }
    };
  },
  watch: {
    fields: function(value) {
      if (value.name != null) {
        this.errors.name = "";
      }
      if (value.shore_type != null) {
        this.errors.shore_type = "";
      }
      if (value.location != null) {
        this.errors.location = "";
      }
    }
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.fields = course_package;
      this.fields.date_created = moment(course_package.date_created)._d;
      this.pckgs = package_details;

      for (let i = 0; i < this.pckgs.length; i++) {
        this.pckgs[i].course_start_date = moment(
          package_details.course_start_date
        )._d;
        this.pckgs[i].course_end_date = moment(
          package_details.course_end_date
        )._d;
      }
    },

    addPackage: function() {
      this.pckgs.push({});
    },

    savePackage(index) {
      if (this.pckgs[index].id != undefined) {
        this.pckgs[index].is_update = 1;
      }
      this.pckgs[index].course_package_id = this.packageId;
      let saveData = this.pckgs[index];
      // console.log(saveData);
      axios({
        method: "put",
        url: "/course-packages/store-update/",
        data: saveData
      })
        .then(response => {
          saveData = {};
          Toast.fire({
            // position: 'top-end',
            type: "success",
            title: "Course Package Details saved successfully"
          });
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errs[index] = error.response.data.errors || {};
            this.errs.push({});
            Toast.fire({
              // position: 'top-end',
              type: "error",
              title: "Opss..Course Package Details was not saved"
            });
          }
        });
    },

    removePackage: function(index) {
      if (this.pckgs[index].id != undefined) {
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
                url: "/course-packages/destroy/" + package_details[index].id
              }).then(response => {
                swal.fire(
                  "Deleted!",
                  "Course matrix has been deleted.",
                  "success"
                );
                this.pckgs.splice(index, 1);
              });
            }
          });
      } else {
        this.pckgs.splice(index, 1);
      }
    }
  }
};
</script>