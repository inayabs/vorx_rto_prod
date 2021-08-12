<template>
  <div>
    <create-offer-letter></create-offer-letter>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 :class="'m-0 font-weight-bold text-'+app_color">Student List</h6>
      </div>
      <div class="card-body">
        <div>
          <!-- <v-client-table :data="courseList" :columns="columns" :options="options" ref="courseTable"></v-client-table> -->
          <v-server-table
            :class="'header-'+app_color"
            url="/student/list"
            :columns="columns"
            ref="studentList"
            :options="options"
          >
            <div slot="afterLimit" class="ml-2">
              <div class="btn-group">
                <a
                  href="javascript:void(0)"
                  @click="showCreateOfferLetter"
                  class="btn btn-success"
                  slot="afterLimit"
                >
                  <i class="fas fa-plus"></i> Add Student
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
            <div class="btn-group" slot="report" slot-scope="{row}">
              <div class="custom-control custom-switch my-0">
                  <input type="checkbox" class="custom-control-input" v-model="row.report_avetmiss" @change="isReport(row)" :id="`report_avetmiss-${row._id}`">
                  <!-- <input type="checkbox" class="custom-control-input" v-else @change="isReport(row.student_id, row.report_avetmiss)" :id="`report_avetmiss-${row._id}`"> -->
                  <label class="custom-control-label" :for="`report_avetmiss-${row._id}`"></label>
              </div>
            </div>
            <div class="btn-group" slot="actions" slot-scope="{row}">
              <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="showStudent(row)">
                <i class="fas fa-edit"></i>
              </a>
              <a
                v-if="urole != 'Staff'"
                href="javascript:void(0)"
                class="btn btn-danger btn-sm text-white"
                @click="deleteStudent(row._id)"
              >
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </v-server-table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import CreateOfferLetter from "./createOfferLetterComponent.vue";
export default {
  name: "app-modal",
  mounted() {
    // console.log("hello");
  },
  components: {
    CreateOfferLetter,
  },
  props : ['urole'],
  data() {
    return {
      student_list: [],
      app_color: app_color,
      columns: ["student_id", "name", "type",'status', "course", "report", "actions"],
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
            sort: data.orderBy ? data.orderBy : "students.created_at",
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
            count: data.meta.total,
          };
        },
        initialPage: 1,
        perPage: 10,
        pagination: {chunk: 5},
        highlightMatches: true,
        sortIcon: {
          base: "fas",
          up: "fa-sort-amount-up",
          down: "fa-sort-amount-down",
          is: "fa-sort",
        },
        headings: {
          student_id: "Student ID",
          name: "Student Name",
          type: "Student Type",
          report: "Report",
          // application_type: "Application Type",
          actions: "Actions",
        },
        sortable: ["student_id", "name", "type"],
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
  created() {
    // this.fetchStudents();
  },
  methods: {
    isReport(row) {

        let update_changes = 1;

      if(row.report_avetmiss == false) {
        swal
        .fire({
          title: "Are you sure?",
          text: "this student will not be included in the reporting!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes!",
        })
        .then((result) => {
          let vm = this;
          if (result.value == true) {
            vm.updateReport(row);
          }else{
            row.report_avetmiss = true;
          }
        });
      }else{
        this.updateReport(row);
      }

        // axios({
        //         method: "get",
        //         url: `/student/details/report-avetmiss/${student_id}/${value}`
        //     })
        //     .then(res => {
        //         let vm = this;
        //         console.log(res.data.status);
        //     })
        //     .catch(err => console.log(err));
    },

    updateReport(row) {
      axios({
          method: "get",
          url: `/student/details/report-avetmiss/${row.student_id}/${row.report_avetmiss}`,
        })
        .then((res) => {

          let vm = this;
          console.log(res.data.status);
          if(res.data.status == 'success') {
            Toast.fire({
              type: "success",
              title: "Report status is updated",
              position: "bottom-end",
            });
          }else if (res.data.status == 'error') {
            let errors = res.data.errors
            let html = '<ul style="margin-left: 10% !important;">';
            row.report_avetmiss = res.data.value == 1 ? true : false;
            if(typeof errors.data !== 'undefined'){
              errors.data.forEach(v => {
                  html += '<li style="text-align:left !important; color: #ff5757 !important;">'+v+'</li>';
              })
            }

            if(typeof errors.courses !== 'undefined'){
              for (var key in errors.courses) {
                  if (errors.courses.hasOwnProperty(key)) {
                      // console.log(key + " -> " + errors.courses[key]);
                      if(key == '@@@@') {
                        html += '<li style="text-align:left !important; color: #ff5757 !important;"><b>Unit of Competency:</b><ul>';
                      }else{
                        html += '<li style="text-align:left !important; color: #ff5757 !important;"><b>'+key+':</b><ul>';
                      }
                      errors.courses[key].forEach(vv => {
                        html += '<li style="text-align:left !important; color: #ff5757 !important;">'+vv+'</li>';
                      })
                      html += '</ul>';
                  }
              }
            }

            html += '</ul>';
      
            swal.fire({
              type: "error",
              title: "Update required fields for Avetmiss",
              html: html,
            });

          }else if (res.data.status == 'warning') {
            // accepted but has errors in other courses
          }
        })
        .catch((err) => console.log(err));
    },

    showCreateOfferLetter() {
      this.$modal.show("size-modal");
    },
    fetchStudents(page_url) {
      let vm = this;
      page_url = page_url || "/student/list";
      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          // console.log(res);
          this.student_list = res.data;
        })
        .catch((err) => console.log(err));
    },
    deleteStudent(student) {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });

      swal
        .fire({
          title: "Are you sure ?",
          text: "You wont be able to revert this!",
          type: "warning",
          width: "25%",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete(`/student/${student}`)
              .then((response) => {
                this.$refs.studentList.refresh();
                // this.$refs.table.refresh();
                // this.fetchStudents();
                Toast.fire({
                  type: "success",
                  title: "You deleted successfuly",
                });
              })
              .catch((error) => {
                Toast.fire({
                  type: "error",
                  title: "Deletion failed",
                });
              });
          }
        });
    },
    // showStudent(student) {
    //   window.location.href = "student/" + student;
    // },
    showStudent(_id) {
      // let i = this.student_list.map(item => item._id).indexOf(_id);
      // console.log(_id.type);
      // let capStudent = this.student_list[_id];
      // console.log(capStudent);
      console.log(_id);
      let dom = "Domestic";
      if (_id.type === dom) {
        // alert('domestic student ni ghorl');
        window.location.href = "student/domestic/" + _id._id;
      } else {
        // alert('international student ni ghorl');
        window.location.href = "student/" + _id._id;
      }
    },
    searchStudent: _.debounce(function (e) {
      this.search = e.target.value;
      this.url = `/student/search/${this.search}`;
      let vm = this;
      if (this.search.length > 2) {
        fetch(`/student/search/${this.search}`)
          .then((res) => res.json())
          .then((res) => {
            this.student_list = res.data;
            vm.makePagination(res.meta, res.links);
          })
          .catch((err) => {
            console.log(err);
          });
      } else if (this.search.length == 0) {
        this.fetchStudents();
      }
    }, 300),
  },
};
</script>