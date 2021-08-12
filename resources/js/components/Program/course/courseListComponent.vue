<template>
  <div class="app-modal">
    <create-course />
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Course List</h6>
      </div>
      <div class="card-body">
        <v-client-table
          :class="'header-'+app_color"
          :data="courseList"
          :columns="columns"
          :options="options"
          ref="courseTable"
        >
          <div slot="afterLimit" class="ml-2">
            <div class="btn-group">
              <!-- <a
                href="javascript:void(0)"
                @click="showCreateCourse"
                class="btn btn-success"
                slot="afterLimit"
              >
                <i class="fas fa-plus"></i> Add Course
              </a> -->
              <a
                href="/course-setup"
                class="btn btn-info"
                slot="afterLimit"
              >
                <i class="fas fa-apple-alt"></i> Course Setup Wizard
              </a>
              <!-- <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export to
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="far fa-file-pdf text-danger"></i>&nbsp; PDF</a>
                                    <a class="dropdown-item" href="#"><i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)</a>
              </div>-->
            </div>
          </div>
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
        </v-client-table>
      </div>
    </div>
  </div>
</template>


<script>
import CreateCourse from "./createCourseComponent.vue";

export default {
  name: "app-modal",
  // mounted() {
  //     console.log('Component mounted.')
  // }
  components: {
    CreateCourse
  },
  data() {
    return {
      app_color: app_color,
      courseList: [],
      course_id: "",
      url: "course/show/",

      // Vue-Tables-2 Syntax
      columns: ["id", "code", "name", "actions"],
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
          id: "#",
          code: "Course Code",
          name: "Course Name",
          actions: "Actions"
        },
        sortable: ["id", "code", "name"],
        rowClassCallback(row) {
          return (row.id = row.id);
        },
        columnClasses: { id: "class-is" },
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords"
        }
      }
    };
  },
  created() {
    this.fetchCourses();
  },
  methods: {
    fetchCourses() {
      axios.get("/course/list").then(response => {
        this.courseList = response.data;
      });
    },

    showCreateCourse() {
      this.$modal.show("size-modal", {
        id: "",
        course_id: "",
        name: "",
        code: ""
      });
    },

    edit(id) {
      window.location.href = "course/" + id;
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
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            axios({
              method: "get",
              url: "/course/delete/" + id
            }).then(response => {
              swal.fire(
                "Deleted!",
                "Course matrix has been deleted.",
                "success"
              );
              this.fetchCourses();
            });
          }
        });
    }
  }
};
</script>