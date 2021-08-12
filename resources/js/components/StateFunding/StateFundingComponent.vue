<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 :class="'m-0 font-weight-bold text-'+app_color">State Funding</h6>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-12 pull-right text-right">
            <div v-if="editState == false">
              <button class="btn btn-success" @click="submitChanges">
                <i class="far fa-save"></i>
                <span>Save Changes</span>
              </button>
            </div>
            <div v-else>
              <button class="btn btn-success" @click="submitChanges">
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
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for class="mb-2">Location</label>
              <multiselect
                v-model="state_form.location"
                placeholder="Select Location"
                :options="states"
                label="state_name"
                track-by="state_key"
                :multiple="false"
              ></multiselect>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for class="mb-2">Value</label>
              <input
                type="text"
                maxlength="3"
                name
                id="value"
                class="form-control"
                v-model="state_form.value"
              />
            </div>
          </div>
          <div class="col-md-12">
            <label for class="mb-2">Description</label>
            <input
              type="text"
              name
              id="description"
              class="form-control"
              v-model="state_form.description"
            />
          </div>
          <div class="col-md-12">
            <div class="mt-5">
              <v-server-table
                :class="'header-'+app_color"
                url="/state-funding/list"
                :columns="columns"
                ref="state_funding"
                :options="options"
              >
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
                    class="btn btn-danger btn-sm text-white"
                    @click="deleteFunding(row.id)"
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
  </div>
</template>
<script>
export default {
  props: ["states"],
  data() {
    return {
      app_color: app_color,
      state_form: {
        location: "",
        value: "",
        description: "",
        id: "",
      },
      editState: false,
      columns: ["id", "location", "value", "description", "actions"],
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
          location: "Location",
          value: "Value",
          description: "Description",
          // application_type: "Application Type",
          actions: "Actions",
        },
        sortable: ["value", "description", "location"],
        rowClassCallback(row) {
          return (row.id = row.id);
        },
        columnClasses: { id: "class-is" },
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords",
        },
      },
    };
  },
  methods: {
    editFunding(row) {
      let vm = this;
      vm.editState = true;
      // vm.state_form.location = { state_key: "ACT", state_name: pakyu };
      if (row.location != null) {
        vm.states.forEach((element) => {
          console.log(element);
          if (element.state_key == row.location) {
            vm.state_form.location = element;
          }
        });
      } else {
        vm.state_form.location = {};
      }
      vm.state_form.value = row.value;
      vm.state_form.id = row.id;
      vm.state_form.description = row.description;
      // console.log(row);
    },
    submitChanges() {
      // console.log(this.state_form);
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
      axios
        .post("/state-funding", this.state_form)
        .then((res) => {
          console.log(res.data);
          if (res.data.status == "success") {
            // console.log(this.$refs.state - funding);
            this.$refs.state_funding.refresh();
            Toast.fire({
              type: "success",
              title: res.data.message,
            });
          } else {
            Toast.fire({
              type: "error",
              title: "Opps.. something Went Wrong",
            });
          }
        })
        .catch((err) => {
          console.log(err);
        });
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
        .delete(`/state-funding/${row}`)
        .then((res) => {
          Toast.fire({
            type: "success",
            title: res.data.message,
          });
          this.$refs.state_funding.refresh();
        })
        .catch((err) => {
          Toast.fire({
            type: "error",
            title: `${err.response.data.message}`,
          });
        });
    },
    cancelChanges() {
      this.state_form = {
        location: "",
        value: "",
        description: "",
        id: "",
      };
      this.editState = false;
    },
  },
};
</script>
<style scoped>
tr td:nth-child(3) {
  width: 6%;
}
</style>