<template>
  <div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 :class="'m-0 font-weight-bold text-'+app_color">Student Course Completion List</h6>
      </div>
      <div class="card-body">
        <div>
          <v-client-table
            :class="'header-'+app_color"
            :data="student_list"
            :columns="columns"
            :options="options"
          >
            <!-- <div slot="afterLimit" class="ml-2">
                      <button
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
                      </div>
            </div>-->
            <div class="course-wrapper" slot="course" slot-scope="{row}">
              <div class="course-content">
                <ul v-if="row.type.type == 'Domestic'">
                  <li v-for="(course, index) in row.funded_course" :key="index">
                    <span
                      v-if="course.course_code != '@@@@'"
                    >{{ course.course_code }} - {{ course.course.name }}</span>
                    <span v-else>Unit of Competency</span>
                  </li>
                </ul>
                <ul v-else>
                  <div v-for="(offer_letter, index) in row.offer_letter" :key="index">
                    <li v-for="(offer,index) in offer_letter.course_details" :key="index" class>
                      {{offer.course.code}} - {{ offer.course.name }}
                    </li>
                  </div>
                </ul>
              </div>

              <!-- <pre>{{ row }}</pre> -->
            </div>
            <div class="text-center" slot="actions" slot-scope="{row}">
              <a
                href="javascript:void(0)"
                :class="'btn btn-sm btn-'+app_color"
                @click="viewCompletion(row.student_id)"
                data-toggle="tooltip"
                data-placement="top"
                title="View Course Progress"
              >
                <i class="fas fa-award"></i>
              </a>
            </div>
          </v-client-table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
$(function() {
  $('[data-toggle="tooltip"]').tooltip();
});
export default {
  data() {
    return {
      student_list: [],
      app_color: app_color,
      columns: ["id", "student_id", "party.name", "course", "actions"],
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
          student_id: "Student ID",
          "party.name": "Student Name",
          course: "Course",
          actions: "Actions"
        },
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
  mounted() {
    console.log("hello");
  },
  created() {
    this.fetchStudent();
  },
  methods: {
    fetchStudent() {
      axios
        .get("/course_completion/list")
        .then(response => {
          this.student_list = response.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    viewCompletion(student) {
      window.location.href = "/course_completion/student/" + student;
    }
  }
};
</script>
<style>
th#VueTables_th--actions {
  width: 8%;
}
th#VueTables_th--id {
  width: 5%;
}
</style>