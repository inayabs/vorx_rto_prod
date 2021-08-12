<template>
  <div class="app-modal">
    <create-class />
    <edit-class />
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Class List </h6>
        
      </div>
      <div class="card-body">
        <v-client-table
          :class="'header-'+app_color"
          :data="classList"
          :columns="columns"
          :options="options"
          ref="courseTable"
        >
          <div slot="afterLimit" class="ml-2" v-if="role.id===1||role.id===2||role.id===4">
            <div class="btn-group">
              <a
                href="javascript:void(0)"
                @click="showCreateCourse"
                class="btn btn-success"
                slot="afterLimit"
              >
                <i class="fas fa-plus"></i> Add Class
              </a>
            </div>
          </div>
          <div slot="afterLimit" class="ml-2" v-if="role.id===3">
            <div class="btn-group">
              <a
                :href="'/classes/trainer-classes/'+user_id"
                class="btn btn-success"
                slot="afterLimit"
              >
                <i class="far fa-folder"></i> My Classes
              </a>
            </div>
          </div>
          <div slot="class_start_time" slot-scope="{row}">{{ row.class_start_time | timeformat }}</div>
          <div slot="class_end_time" slot-scope="{row}">{{ row.class_end_time | timeformat }}</div>
          <div slot="start_date" slot-scope="{row}">{{ row.start_date | dateformat }}</div>
          <div slot="end_date" slot-scope="{row}">{{ row.end_date | dateformat }}</div>
          <div class="btn-group" slot="actions" slot-scope="{row}">
            <!-- <div class="dropdown"> -->
              <button class="btn btn-primary dropdown-toggle" type="button" :id="'dropdownMenuButton-'+row.id" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
              </button>
              <div class="dropdown-menu" :aria-labelledby="'dropdownMenuButton-'+row.id">
                <a href="javascript:void(0)" class="dropdown-item" @click="edit(row.id)" title="Edit">
                  <i class="fas fa-edit"></i> Edit
                </a>
                <a href="javascript:void(0)" class="dropdown-item" @click="tt(row.id)" title="Open">
                  <i class="far fa-folder-open"></i> Time Table
                </a>
                <a href="javascript:void(0)" class="dropdown-item" @click="open(row.id)" title="Open">
                  <i class="far fa-folder-open"></i> Attendance
                </a>
                <a
                  href="javascript:void(0)"
                  class="dropdown-item"
                  @click="remove(row.id)"
                >
                  <i class="fas fa-trash"></i> Remove
                </a>
              </div>
            <!-- </div> -->
          </div>
        </v-client-table>
      </div>
    </div>
  </div>
</template>


<script>
import CreateClass from "./createClassComponent.vue";
import moment from "moment";
export default {
  name: "app-modal",
  // mounted() {
  //     console.log('Component mounted.')
  // }
  components: {
    CreateClass
  },
  data() {
    return {
      role:window.user_role,
      module_active:true,
      app_color: app_color,
      classList: [],
      user_id:window.user_id,
      course_id: "",
      url: "course/show/",
      // Vue-Tables-2 Syntax
      columns: ["id","desc","delivery_location.train_org_dlvr_loc_name","venue","course_code","start_date","end_date","actions"],
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
          'desc':'Description',
          'delivery_location.train_org_dlvr_loc_name':'Delivery Location'
        },
        sortable: ["id", "code", "name"],
        rowClassCallback(row) {
          return (row.id = row.id);
        },
        columnClasses: { id: "class-is" },
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords"
        },
      }
    };
  },
  filters: {
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
    this.fetchClasses();
  },
  methods: {
    module_toggle(){
      alert('!!');
    },
    open(id){
      window.location ="/classes/attendance/"+id;
      // axios.get('/classes/attendance/'+id);
    },
    fetchClasses() {
      axios.get("/classes/class_list").then(response => {
        this.classList = response.data;
      });
    },

    showCreateCourse() {
      this.$modal.show("create-class-modal", {
        id: "",
        course_id: "",
        name: "",
        code: ""
      });
    },

    edit(id) {
      swal.fire({
          title: 'Please wait...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
          swal.showLoading()
          },
      });
      axios.get('/classes/get_class_fields/'+id).then(
          response=>{
              // this.stud = response.data;s
              this.$modal.show('edit-class-modal',response.data);
              swal.close();
          }
      ).catch(
          e=>{
          console.log(e);
          }
      );
      
    },
    tt(id) {
      window.location ="/classes/"+id+"/time-table";
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
            axios.post('/classes/delete_class',{
              id:id
            }).then(
              response=>{
                swal.fire(
                  "Deleted!",
                  "Class has been deleted.",
                  "success"
                );
                this.fetchClasses();
              }
            ).catch();


            // axios({
            //   method: "get",
            //   url: "/classes/delete/" + id
            // }).then(response => {
            //   swal.fire(
            //     "Deleted!",
            //     "Course matrix has been deleted.",
            //     "success"
            //   );
            //   this.fetchCourses();
            // });
          }
        });
    }
  }
};
</script>