<template>
  <div class="app-modal">
    <div class="row mb-2 d-flex justify-content-between">
      <div class="col-md-6">
        <a
          href="/classes"
          v-bind:class="'btn btn-'+app_color+' btn-sm text-'+app_color+' text-light'"
        >
          <i class="fas fa-long-arrow-alt-left"></i> Back
        </a>
      </div>
    </div>
    <add-student-modal />
    <view-attendance-sheet-modal />
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Attendance</h6>
        <div>
          <br>
            <div class="row">
              <div class="col-md-6">
                <label for="description">Description:</label>
                <span>{{class_.desc}}</span>
              </div>
              <div class="col-md-6">
                <label for="course">Course:</label>
                <span>{{class_.course_code}} - {{class_.course.name}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="deliver_location">Delivery Location:</label>
                    <span v-if="class_.delivery_location">{{class_.delivery_location.train_org_dlvr_loc_name}} - {{class_.delivery_location.postcode}}</span>
              </div>
              <div class="col-md-6">
                <label for="start_date">Venue:</label>
                <span v-if="class_.venu">{{class_.venue}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="deliver_location">Delivery Mode:</label>
                    <span v-if="class_.del_mode">{{class_.del_mode.value}} - {{class_.del_mode.description}}</span>
              </div>
              <div class="col-md-6">
                <label for="start_date">Start-End Date:</label>
                <span>{{class_.start_date| dateformat}} - {{class_.end_date|dateformat}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="start_date">Class Time:</label>
                <span>{{class_.class_start_time| timeformat}} - {{class_.class_end_time|timeformat}}</span>
              </div>
              <div class="col-md-6">
                <label for="description">Trainers:</label>
                <template v-if="class_.trainer_id!=null">
                  <span v-for="(ti,index) in class_.trainer_selected" :key="ti.id"> {{ti.firstname}} {{ti.lastname}}<span v-if="index!= Object.keys(class_.trainer_selected).length - 1">,</span> </span>
                </template>
              </div>
            </div>
        </div>
      </div>
      <div class="card-body">
        <v-client-table
          :class="'header-'+app_color"
          :data="attendanceList"
          :columns="columns"
          :options="options"
          ref="courseTable"
        >
          <div slot="afterLimit" class="ml-2">
            <div class="btn-group">
              <a
                href="javascript:void(0)"
                @click="showCreateCourse"
                class="btn btn-success"
                slot="afterLimit"
              >
                <i class="fas fa-plus"></i> New
              </a>
            </div>
          </div>
          <div class="btn-group" slot="actions" slot-scope="{row}">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="view(row.id)" title="View attendance pdf">
              <i class="far fa-eye"></i>
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
import moment from "moment";
export default {
  name: "app-modal",
  data() {
    return {
      app_color: app_color,
      attendanceList: [],
      course_id: "",
      class_: window.class,
      class_id:window.class.id,
      // Vue-Tables-2 Syntax
      columns: ["id","student.party.name","student.student_id","student.type.type","actions"],
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
          'student.party.name': "Student",
          'student.type.type':"Student type",
          'student.student_id':"Student id"
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
  filters:{
    dateformat: function(date) {
      if (!date) return "";
      date = moment(date).format("DD/MM/YYYY");
      return date;
    },
    timeformat: function(time){
        if (!time) return "";
        time = moment('1111-11-11 '+time).format("hh:mm A");
        return time;
    }
  },
  created() {
    this.fetchAttendance();
  },
  methods: {
    fetchAttendance() {
      axios.get("/attendance/fetch_attendance/"+this.class_id).then(response => {
        this.attendanceList = response.data;
      });
    },

    showCreateCourse() {
      this.$modal.show("add-student-modal", {
        id: "",
        course_id: "",
        name: "",
        code: ""
      });
    },
    view(id){
      window.open("/attendance/pdf/" + id,'_blank');
      // this.$modal.show('attendance-sheet-modal');
    },
    edit(id) {
      window.location.href = "/classes/student_attendance/" + id;
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
            axios.post('/classes/delete_student',{
              id:id
            }).then(
              response=>{
                swal.fire(
                  "Deleted!",
                  "Class has been deleted.",
                  "success"
                );
                this.fetchAttendance();
              }
            ).catch();
          }
        });
    }
  }
};
</script>