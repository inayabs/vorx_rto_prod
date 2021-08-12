<template>
  <div>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
      <div
        class="d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
        v-if="['Student','Trainer'].indexOf(role) == -1 && role !== null"
      >
        <multiselect
          v-model="selectedStudent"
          id="ajax"
          label="student_name"
          track-by="student_name"
          :class="'multiselect-color-'+app_color"
          placeholder="Student Search"
          open-direction="bottom"
          :options="students"
          :multiple="false"
          :searchable="true"
          :loading="isLoading"
          :internal-search="false"
          :clear-on-select="true"
          :options-limit="300"
          :limit="3"
          :limit-text="limitText"
          :max-height="600"
          :show-no-results="false"
          :hide-selected="true"
          @search-change="asyncFind"
          @select="onSelect"
        ></multiselect>
      </div>
      <div
        class=" d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
        v-else
      >
        <h5 class="text-danger font-weight-bold" v-if="toType(stud.party) !== 'undefined'">{{stud.party.name}} ({{stud.student_id}})</h5>
        <h5 class="text-danger font-weight-bold" v-if="toType(trainer.firstname) !== 'undefined'">{{trainer.firstname}} {{trainer.lastname}}</h5>
      </div>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        
        <!-- Nav Item - Enrolments -->
        <li class="nav-item dropdown no-arrow mx-1" v-if="enrolment_notif.length > 0">
          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-users"></i>
            <!-- Counter - Enrolments -->
            <span v-if="enrolment_notif.length > 0" class="badge badge-danger badge-counter">{{enrolment_notif.length}}</span>
          <!-- Counter - Enrolments -->
          </a>
        <!-- Dropdown - Enrolments -->
        <div v-if="enrolment_notif.length > 0" class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header" :class="'background-'+app_color">
                  Enrolment Application
                </h6>
                <a v-for="(v,k) in enrolment_notif" :key="k" class="dropdown-item d-flex align-items-center" href="/enrolment-application">
                  <!-- <div class="dropdown-list-image mr-3"> -->
                    <!-- <div class="status-indicator bg-success"></div> -->
                  <!-- </div> -->
                  <div class="font-weight-bold">
                    <div class="text-truncate">{{v.student_name}}</div>
                    <div class="small text-gray-500">Completed Enrolment Form · {{v.created_at | auDateFormat}}</div>
                    <!-- <div class="small text-gray-500">Completed Enrolment Form · 58m</div> -->
                  </div>
                </a>
                <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a> -->
        </div>
        </li>

        <!-- Nav Item - Alerts -->
        <!-- <li class="nav-item dropdown no-arrow mx-1"  v-if="role != 'Student'"> -->
        <li class="nav-item dropdown no-arrow mx-1">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="alertsDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span v-if="unseen_notif > 0" class="badge badge-danger badge-counter">{{unseen_notif}}</span>
          </a>
          <!-- Dropdown - Alerts -->
          <div
            class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown"
          >
            <!-- <h6 :class="'dropdown-header-'+app_color"> -->
            <!-- <h6 :class="'dropdown-header dropdown-header-'+app_color">Alerts Center</h6> -->
            <a
              class="dropdown-item d-flex align-items-center"
              v-bind:class="sa.is_seen == 0 ? 'not_seen' : ''"
              href="javascript:void(0)"
              v-for="(sa, k) in StudentAlerts"
              :key="k"  
              @click="viewNotif(sa)"
            >
              <div class="mr-3">
                <div :class="'icon-circle bg-'+app_color">
                  <i :class="sa.fa_class"></i>
                </div>
              </div>
              <div>
                <!-- <div class="small text-gray-500">December 12, 2019</div> -->
                <div class="small text-gray-500">{{sa.date}}</div>
                <span v-html="sa.message" style="width:100%"> </span><br>
                <span class="byUser" style="font-size:12px;" v-html="sa.timeDiff"></span>
              </div>
            </a>
            <!-- <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
            </a>-->
            <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
          </div>
        </li>
        <!-- Nav Item - Messages -->
        <!-- <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>-->
        <!-- Counter - Messages -->

        <!-- </a> -->
        <!-- Dropdown - Messages -->
        <!-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
        </div>-->
        <!-- </li> -->
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a
            href="javascript:void()"
            class="nav-link dropdown-toggle"
            id="userDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <div class="mr-2 rounded-circle border border-primary">
              <img
                class="img-profile rounded-circle border border-light"
                :src="'/storage/user/avatars/'+ this.user.profile_image"
              />
            </div>
            <span
              class="mr-2 d-none d-lg-inline text-gray-600 small font-weight-bold"
            >Hi, {{ user.username }}</span>
            <i class="fas fa-chevron-down"></i>
          </a>
          <!-- Dropdown - User Information -->
          <div
            class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown"
          >
            <a class="dropdown-item" :href="'/student-profile/'" v-if="role == 'Student'">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Student Profile
            </a>
            <a class="dropdown-item" :href="'/users/'+this.user.id" v-else>
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</template>
<script>
// import { ajaxFindCountry } from './countriesApi'
import moment from "moment";

export default {
  props: {
    backUrl: String,
    warningLetter: String
  },
  data() {
    return {
      search: [],
      stud: {},
      trainer: {},
      app_color: app_color,
      enrolment_notif: [],
      selectedStudent: [],
      students: [],
      isLoading: false,
      user: {},
      role: null,
      StudentAlerts: [],
      // unseen_notif:0
    };
  },
  //   components: {},
  mounted(){
    this.getUser();
  },
  computed:{
    unseen_notif(){
      let count = 0;
      this.StudentAlerts.forEach(function(data){
        if(data.is_seen == 0){
          count++;
        }
      });
      return count;
    }
  },
  async created() {
    // await this.getAlerts();
  },
  methods: {
    viewNotif(obj){
      axios.get(`/view-notif/${obj.id}`).then(
        response=>{
          localStorage.setItem('activeTab','nav-collections');
          localStorage.setItem('row_id',obj.table_id);
          location.href = obj.link;
        }
      );
    },
    toType(obj) {
        return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
    },
    enrol_notification() {
      let vm = this
      axios
      .get(`/enrolment/fetch`)
        .then(function(response) {
          // handle success
          // console.log(response.data);
          // console.log(response.data)
          vm.enrolment_notif = response.data
          // console.log(vm.StudentAlerts);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
          // alert(af.selectedStudent);
        });
    },
    fetchTrainer() {
      let vm = this
      axios
      .get(`/trainer/fetch/${vm.user.id}`)
        .then(function(response) {
          // handle success
          // console.log(response.data);
          console.log(response.data)
          vm.trainer = response.data
          // console.log(vm.StudentAlerts);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
          // alert(af.selectedStudent);
        });
    },
    fetchStudent() {
      let vm = this
      axios
        .get(`/student/fetch/${vm.user.username}`)
        .then(function(response) {
          // handle success
          // console.log(response.data);
          console.log(response.data)
          vm.stud = response.data
          // console.log(vm.StudentAlerts);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
          // alert(af.selectedStudent);
        });
    },
    getAlerts() {
      let vm = this;
      
      if(this.role == 'Staff' || this.role == 'Admin' || this.role == 'Super-Admin'){
          axios
          .get("/notifications")
          .then(function(response) {
            vm.StudentAlerts = response.data;
          })
          .catch(function(error) {
            console.log(error);
          })
          .then(function() {
            // always executed
            // alert(af.selectedStudent);
          });
      } else{
        axios
        .get("/get-stud-status-alert")
        .then(function(response) {
          vm.StudentAlerts = response.data;
        })
        .catch(function(error) {
          console.log(error);
        })
        .then(function() {
          // always executed
          // alert(af.selectedStudent);
        });
      }
      
    },
    getUser() {
      let vm = this;
      axios
        .get("/get-user-nav")
        .then(function(response) {
          // handle success
          // console.log(response.data);
          vm.user = response.data.user;
          vm.role = response.data.role;
          if(vm.role == 'Student'){
            vm.fetchStudent()
          }else if(vm.role == 'Trainer'){
            vm.fetchTrainer()
          }else{
            vm.enrol_notification()
          }
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
          // alert(af.selectedStudent);
          vm.getAlerts();
        });
    },
    limitText(count) {
      return `and ${count} other countries`;
    },
    asyncFind(query) {
      // alert(query);
      let af = this;
      af.isLoading = true;

      axios
        .get("/student/top-search/" + query)
        .then(function(response) {
          // handle success
          // console.log(response.data);
          af.students = response.data;
          af.isLoading = false;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
          // alert(af.selectedStudent);
          af.isLoading = false;
        });

      // ajaxFindCountry(query).then(response => {
      //     this.countries = response
      //     this.isLoading = false
      // })
    },
    onSelect(option) {
      if (option.student_type == 2) {
        window.location.href = "/student/domestic/" + option.student_table_id;
      } else {
        window.location.href = "/student/" + option.student_table_id;
      }
    }
  },
  filters: {
    auDateFormat: function (date) {
        return date ? moment(date).format('DD/MM/YYYY') : '';
    },
  }
};
</script>
<style >
  .multiselect__placeholder {
    white-space: nowrap !important;
  }
</style>
<style scoped>
.topbar .dropdown .dropdown-menu {
  width: auto;
  right: 0;
  max-height: 440px;
  overflow: auto;
}
.multiselect {
  border-radius: 5px;
  font-size: 14px;
}

.byUser {
    color: #a6a6a6!important;
    font-style: italic;
}
.not_seen {
  background-color: #f0f8ff;
}
/* width */
::-webkit-scrollbar {
  width: 3px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
</style>