<template>
  <div class="app-modal">
    <create-package />
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Course Package List</h6>
      </div>
      <div class="card-body">
        <div>
          <v-client-table
            :class="'header-'+app_color"
            :data="package_list"
            :columns="columns"
            :options="options"
            ref="packageTable"
          >
            <div slot="afterLimit" class="ml-2">
              <div class="btn-group">
                <a
                  href="javascript:void(0)"
                  @click="showCreateCoursePackage"
                  class="btn btn-success"
                  slot="afterLimit"
                >
                  <i class="fas fa-plus"></i> Add Package
                </a>
                <!-- <button
                  type="button"
                  class="btn btn-success dropdown-toggle dropdown-toggle-split"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  Export to
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#">
                    <i class="far fa-file-pdf text-danger"></i>&nbsp; PDF
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)
                  </a>
                </div>-->
              </div>
            </div>
            <div slot="date_created" slot-scope="{row}">{{ row.date_created | dateformat }}</div>
            <div class="btn-group" slot="actions" slot-scope="{row}">
              <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)">
                <i class="fas fa-edit"></i>
              </a>
              <a
                href="javascript:void(0)"
                class="btn btn-danger btn-sm text-white"
                @click="remove(row.id)"
              >
                <i class="fas fa-trash"></i>
              </a>
            </div>
            <div class slot="is_active" slot-scope="{row}">
              <i :class="'fas fa-'+[row.is_active? 'check text-success' : 'times text-danger']"></i>
            </div>
          </v-client-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import CreatePackage from "./createCoursePackageComponent.vue";

export default {
  components: {
    CreatePackage,
  },
  data() {
    return {
      app_color: app_color,
      package_list: [],
      // Vue-Tables-2 Syntax
      columns: ["name", "shore_type", "date_created", "is_active", "actions"],
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
          name: "Name",
          shore_type: "Student Location",
          date_created: "Date Created",
          is_active: "Status",
          actions: "Actions",
        },
        sortable: ["name", "shore_type", "date_created", "is_active"],
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords",
        },
      },
    };
  },
  created() {
    this.getPackageList();
  },
  filters: {
    dateformat: function (date) {
      if (!date) return "";
      date = moment(date).format("DD/MM/YYYY");
      return date;
    },
  },
  methods: {
    getPackageList() {
      axios.get("/course-packages/list").then((response) => {
        this.package_list = response.data;
      });
    },
    showCreateCoursePackage() {
      this.$modal.show("size-modal");
    },
    edit(id) {
      window.location.href = "course-package/" + id;
    },
    remove(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.value) {
            axios({
              method: "get",
              url: "/course-package/delete/" + id,
            }).then((response) => {
              swal.fire(
                "Deleted!",
                "Course matrix has been deleted.",
                "success"
              );
              this.getPackageList();
            });
          }
        });
    },
  },
};
</script>
