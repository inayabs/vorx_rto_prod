<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 :class="'m-0 font-weight-bold text-'+app_color">Funding Type</h6>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-12 pull-right text-right">
            <div v-if="is_open == 0">
              <button class="btn btn-success" @click="addFundingType">
                <i class="far fa-save"></i>
                <span>Add</span>
              </button>
            </div>
            <div v-else-if="editState == false">
              <button class="btn btn-success" @click="saveChanges">
                <i class="far fa-save"></i>
                <span>Save Changes</span>
              </button>
              <button class="btn btn-warning" @click="cancelChanges">
                <i class="far fa-save"></i>
                <span>Cancel</span>
              </button>
            </div>
            <div v-else>
              <button class="btn btn-success" @click="saveChanges">
                <i class="far fa-save"></i>
                <span>Update Changes</span>
              </button>
              <button class="btn btn-warning" @click="cancelChanges">
                <i class="far fa-save"></i>
                <span>Cancel Changes</span>
              </button>
            </div>
          </div>
        </div>
        <div :class="is_open == 0 ? 'unit-fields-hide' : ''">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for class="mb-2">Report To *</label>
                <multiselect
                  v-model="funding_form.state_key"
                  placeholder="Select Location"
                  :options="states"
                  label="state_name"
                  track-by="state_key"
                  :multiple="false"
                  @select="onSelect"
                ></multiselect>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for>Name *</label>
                <input type="text" v-model="funding_form.name" class="form-control" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for>State funding *</label>
                <!-- <input type="text" v-model="funding_form.state_funding_code" class="form-control" /> -->
                <multiselect
                  v-model="funding_form.state_funding_code"
                  placeholder="Select State Funding"
                  :options="fstate"
                  label="description"
                  track-by="id"
                  :multiple="false"
                  :custom-label="styleLabel"
                ></multiselect>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for>National funding *</label>
                <!-- <input type="text" v-model="funding_form.national_funding_code" class="form-control" /> -->
                <multiselect
                  v-model="funding_form.national_funding_code"
                  placeholder="Select National Funding"
                  :options="fnational"
                  label="description"
                  track-by="value"
                  :multiple="false"
                  :custom-label="styleLabel"
                  :show-labels="false"
                ></multiselect>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for>Specific funding *</label>
                <!-- <input type="text" v-model="funding_form.specific_funding_code" class="form-control" /> -->
                <multiselect
                  v-model="funding_form.specific_funding_code"
                  placeholder="Select Specific Funding"
                  :options="sf"
                  label="description"
                  track-by="identifier"
                  :multiple="false"
                  :custom-label="styleLabel"
                  :show-labels="false"
                ></multiselect>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <div>
                  <input
                    class
                    type="checkbox"
                    v-model="funding_form.traineeship_apprenticeship"
                    value
                    id="defaultCheck1"
                  />
                  <label class="form-check-label" for="defaultCheck1">Traineeship / Apprenticeship</label>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <div>
                  <input
                    class
                    type="checkbox"
                    v-model="funding_form.funding_disclosed"
                    value
                    id="defaultCheck2"
                  />
                  <label class="form-check-label" for="defaultCheck2">Funding Disclosed</label>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <div>
                  <input
                    class
                    type="checkbox"
                    v-model="funding_form.vet_student_loan"
                    id="defaultCheck3"
                  />
                  <label class="form-check-label" for="defaultCheck3">Vet Student Loan</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for>Purchasing Contract</label>
                <input type="text" v-model="funding_form.purchasing_contract" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for>Purchasing Schedule</label>
                <input type="text" v-model="funding_form.purchasing_schedule" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for>Intake Number</label>
                <input type="text" v-model="funding_form.intake_number" class="form-control" />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mt-4">
                <div>
                  <input
                    class
                    type="checkbox"
                    v-model="funding_form.acquitted"
                    value
                    id="defaultCheck5"
                  />
                  <label class="form-check-label" for="defaultCheck5">
                    Aquitted
                    <i
                      class="fas fa-info-circle"
                      title="do not include in Western Australia RAPT Export"
                    ></i>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mt-4">
                <div>
                  <input
                    class
                    type="checkbox"
                    v-model="funding_form.funding_removed"
                    value
                    id="defaultCheck6"
                  />
                  <label class="form-check-label" for="defaultCheck6">
                    Funding Removed
                    <i
                      class="fas fa-info-circle"
                      title="when Western Australia RAPT has determined that the Unit of Competency will not be funded"
                    ></i>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for>
                      Course Site ID
                      <i class="fas fa-info-circle" title="ATTP or PPP"></i>
                    </label>
                    <input
                      type="text"
                      maxlength="10"
                      v-model="funding_form.course_site_id"
                      class="form-control"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for>Booking ID</label>
                    <input
                      type="text"
                      maxlength="10"
                      v-model="funding_form.booking_id"
                      class="form-control"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for>Training Contract</label>
                <input
                  type="text"
                  maxlength="10"
                  v-model="funding_form.training_contract"
                  class="form-control"
                />
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <div>
                  <input
                    class
                    type="checkbox"
                    v-model="funding_form.avetmiss"
                    value
                    id="defaultCheck7"
                  />
                  <label class="form-check-label" for="defaultCheck7">Report To AVETMISS</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <v-server-table
              :class="'header-'+app_color"
              url="/funding-type/list"
              :columns="columns"
              ref="funding_type"
              :options="options"
            >
              <div slot="avetmiss" slot-scope="{row}">
                <span v-if="row.avetmiss == 1">Yes</span>
                <span v-else>No</span>
              </div>
              <div slot="acquitted" slot-scope="{row}">
                <span v-if="row.acquitted == 1">Yes</span>
                <span v-else>No</span>
              </div>
              <div slot="vet_student_loan" slot-scope="{row}">
                <span v-if="row.vet_student_loan == 1">Yes</span>
                <span v-else>No</span>
              </div>
              <div slot="funding_disclosed" slot-scope="{row}">
                <span v-if="row.funding_disclosed == 1">Yes</span>
                <span v-else>No</span>
              </div>
              <div slot="traineeship_apprenticeship" slot-scope="{row}">
                <span v-if="row.traineeship_apprenticeship == 1">Yes</span>
                <span v-else>No</span>
              </div>
              <div class="btn-group" slot="actions" slot-scope="{row}">
                <a
                  href="javascript:void(0)"
                  class="btn btn-primary btn-sm"
                  @click="editFunding(row)"
                >
                  <i class="fas fa-edit"></i>
                </a>
                <a
                  href="javascript:void(0)"
                  @click="deleteFunding(row)"
                  class="btn btn-danger btn-sm text-white"
                >
                  <i class="fas fa-trash"></i>
                </a>
              </div>
            </v-server-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["states", "fstates", "fnational", "sf"],
  data() {
    return {
      app_color: app_color,
      editState: false,
      is_open: 0,
      fstate: [],
      columns: [
        "id",
        "name",
        "state_key",
        "traineeship_apprenticeship",
        "funding_disclosed",
        "vet_student_loan",
        "acquitted",
        "avetmiss",
        "actions",
      ],
      options: {
        requestFunction: function (data) {
          // console.log(data);
          // console.log(this.url);
          return axios
            .get(this.url, {
              params: data,
            })
            .catch(
              function (e) {
                this.dispatch("error", e);
              }.bind(this)
            );
        },
        requestAdapter(data) {
          // console.log(data);
          // console.log(data.limit);
          return {
            sort: data.orderBy ? data.orderBy : "id",
            direction: data.ascending ? "desc" : "asc",
            page: data.page ? data.page : "page",
            limit: data.limit ? data.limit : "10",
            search: data.query ? data.query : null,
          };
        },
        responseAdapter({ data }) {
          // console.log(data.data);
          return {
            data: data.data,
            count: data.total,
          };
        },
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
          id: "Id",
          name: "Name",
          state_key: "Location",
          traineeship_apprenticeship: "Traineeship / Apprenticeship",
          acquitted: "Aquitted",
          // description: "Description",
          // application_type: "Application Type",
          actions: "Actions",
        },
        sortable: ["name", "location"],
        rowClassCallback(row) {
          return (row.id = row.id);
        },
        columnClasses: { id: "class-is" },
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords",
        },
      },
      funding_form: {
        state_key: "",
        name: "",
        state_funding_code: "",
        national_funding_code: "",
        specific_funding_code: "",
        training_contract: "",
        traineeship_apprenticeship: false,
        funding_disclosed: false,
        vet_student_loan: false,
        purchasing_contract: "",
        purchasing_schedule: "",
        intake_number: "",
        acquitted: false,
        funding_removed: "",
        course_site_id: "",
        booking_id: "",
        avetmiss: true,
        id: "",
      },
    };
  },
  created() {
    this.states.push({
      shortname: "NCVER",
      state_code: "NCVER",
      state_name: "NCVER",
      state_key: "NCVER",
      value: "NCVER",
    });
  },
  methods: {
    addFundingType() {
      this.is_open = 1;
    },
    editFunding(row) {
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
      console.log(row);
      let vm = this;
      vm.editState = true;
      vm.is_open = 1;
      //  vm.funding_form.location = { state_key: "ACT", state_name: pakyu };
      if (row.state_key != null) {
        vm.states.forEach((element) => {
          if (element.state_key == row.state_key) {
            vm.onEditSelect(element);
            vm.funding_form.state_key = element;
          }
        });
      } else {
        vm.funding_form.state_key = {};
      }
      // vm.funding_form.value = row.value;
      if (row.state_funding_code != null) {
        vm.fstates.forEach((ee) => {
          if (ee.value == row.state_funding_code) {
            vm.funding_form.state_funding_code = ee;
          }
        });
      } else {
        vm.funding_form.state_funding_code = "";
      }

      if (row.national_funding_code != null) {
        vm.fnational.forEach((element) => {
          if (element.value == row.national_funding_code) {
            vm.funding_form.national_funding_code = element;
          }
        });
      } else {
        vm.funding_form.national_funding_code = "";
      }

      if (row.specific_funding_code != null) {
        vm.sf.forEach((element) => {
          if (element.identifier == row.specific_funding_code) {
            vm.funding_form.specific_funding_code = element;
          }
        });
      } else {
        vm.funding_form.specific_funding_code = "";
      }
      vm.funding_form.id = row.id;
      vm.funding_form.name = row.name;
      vm.funding_form.traineeship_apprenticeship =
        row.traineeship_apprenticeship;
      vm.funding_form.funding_disclosed = row.funding_disclosed;
      vm.funding_form.vet_student_loan = row.vet_student_loan;
      vm.funding_form.acquitted = row.acquitted;
      vm.funding_form.purchasing_contract = row.purchasing_contract;
      vm.funding_form.purchasing_schedule = row.purchasing_schedule;
      vm.funding_form.intake_number = row.intake_number;
      vm.funding_form.course_site_id = row.course_site_id;
      vm.funding_form.booking_id = row.booking_id;
      vm.funding_form.avetmiss = row.avetmiss;
      vm.funding_form.training_contract = row.training_contract;
      vm.funding_form.funding_removed = row.funding_removed;
      // console.log(row);
    },
    styleLabel(data) {
      if (data.value !== undefined) {
        return `${data.value} - ${data.description}`;
      } else {
        return `${data.identifier} - ${data.description}`;
      }
    },
    deleteFunding(row) {
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      axios
        .delete(`/funding-type/${row.id}`)
        .then((res) => {
          Toast.fire({
            type: "success",
            title: res.data.message,
          });
          this.$refs.funding_type.refresh();
        })
        .catch((err) => {
          Toast.fire({
            type: "error",
            title: `${err.response.data.message}`,
          });
        });
    },
    saveChanges() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      // console.log(this.funding_form);
      axios
        .post("/funding-type", this.funding_form)
        .then((res) => {
          if (res.data.status == "success") {
            // console.log(this.$refs.state - funding);
            this.$refs.funding_type.refresh();
            Toast.fire({
              type: "success",
              title: res.data.message,
            });
            this.funding_form = {
              state_key: "",
              name: "",
              state_funding_code: "",
              national_funding_code: "",
              specific_funding_code: "",
              traineeship_apprenticeship: false,
              funding_disclosed: false,
              vet_student_loan: false,
              purchasing_contract: "",
              purchasing_schedule: "",
              intake_number: "",
              aquitted: false,
              funding_removed: "",
              course_site_id: "",
              booking_id: "",
              avetmiss: true,
              id: "",
              training_contract: "",
            };
            this.editState = false;
            this.is_open = 0;
          } else {
            Toast.fire({
              type: "error",
              title: "Opps.. something Went Wrong",
            });
          }
        })
        .catch((err) => {
          console.log(err);
          Toast.fire({
            type: "error",
            title: `${err.response.data.message}`,
          });
        });
    },

    onSelect(data) {
      let vm = this;
      vm.fstate = [];
      vm.funding_form.state_funding_code = "";
      vm.fstates.forEach((element) => {
        if (element.location == data.state_key) {
          // console.log(element);
          vm.fstate.push(element);
        }
      });
    },
    onEditSelect(data) {
      console.log(data);
      let vm = this;
      vm.fstate = [];
      vm.fstates.forEach((element) => {
        if (element.location == data.state_key) {
          // console.log(element);
          vm.fstate.push(element);
        }
      });
    },
    cancelChanges() {
      this.funding_form = {
        state_key: "",
        name: "",
        state_funding_code: "",
        national_funding_code: "",
        specific_funding_code: "",
        traineeship_apprenticeship: false,
        funding_disclosed: false,
        vet_student_loan: false,
        purchasing_contract: "",
        purchasing_schedule: "",
        intake_number: "",
        aquitted: false,
        funding_remove: "",
        course_site_id: "",
        booking_id: "",
        avetmiss: true,
        id: "",
        training_contract: "",
      };
      this.editState = false;
      this.is_open = 0;
    },
  },
};
</script>
<style scope >
.form-check-label {
  margin-bottom: 0;
  top: -2px;
  position: relative;
}
.unit-fields-hide {
  display: none;
}
</style>

