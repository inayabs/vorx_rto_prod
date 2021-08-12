<template>
  <div>
    <div class="row mb-2 d-flex justify-content-between">
      <div v-if="viewing != 'students'" class="col-md-6">
        <a
          href="/course_completion"
          v-bind:class="'btn btn-'+app_color+' btn-sm text-'+app_color+' text-light'"
        >
          <i class="fas fa-long-arrow-alt-left"></i> Back
        </a>
      </div>
    </div>
    <div class="card shadow mb-4">
            <div v-if="viewing != 'students'" class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">
                Student Completion Details 
                <span>
                  - {{ student.name }} (
                  <b>{{ student.id }}</b> )
                  <a
                    :href="this.completion_url"
                    :class="'btn btn-'+app_color+' text-primary btn-sm text-light'"
                    style="padding: 0px 4px;"
                  >
                  <i class="fas fa-user"></i>
                  </a>
                </span>
              </h6>
            </div>
            <div class="card-body">
                <div>
                    <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a 
                        v-for="(list,index) in courses"
                      
                        :key="list.course"
                        :class="['nav-link-'+app_color ,{' act':true,' active' : index == 0}]"
                        :id="`nav-${ [list.course == '@@@@' ? 'uoc-'+index : list.course+'-i'] }-tab`"
                        data-toggle="tab"
                        :href="`#nav-${[list.course == '@@@@' ? 'uoc-'+index : list.course+'-i']}`"
                        role="tab"
                        :aria-controls="`nav-${[list.course == '@@@@' ? 'uoc-'+index : list.course+'-i']}`"
                        aria-selected="true"
                      >
                       <span v-if="list.course != '@@@@'" > {{ list.name }} ( {{ list.course }} )</span>
                        <span v-else >{{list.name}}</span>
                      </a>
                      <a
                        href="#nav-certificate-list"
                        v-bind:class="'nav-link-'+app_color+' act'"
                        aria-controls="nav-certificate-list"
                        aria-selected="true"
                        role="tab"
                        data-toggle="tab"
                        id="nav-certificate-list-tab"
                      >Certificate List</a>
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <div
                      v-for="(list,index) in courses"
                      :key="list.course"
                      :class="{'tab-pane fade mb-3' : true,'show active': index == 0 }"
                      :id="`nav-${[list.course == '@@@@' ? 'uoc-'+index : list.course+'-i']}`"
                      role="tabpanel"
                      :aria-labelledby="`nav-${[list.course == '@@@@' ? 'uoc-'+index :list.course+'-i']}-tab`"
                    >
                      <course-detail
                        @generate="updateCertList($event)"
                        @updateData="updateDataParent($event)"
                        :units="list.units"
                        :soa_num="list.soa_num"
                        :completions="list.completion"
                        :course="list.course"
                        :edit_id="edit_id"
                        :edit_status="edit_status"
                      ></course-detail>
                    </div>
                    <div
                      class="tab-pane fade mb-3"
                      id="nav-certificate-list"
                      role="tabpanel"
                      aria-labelledby="nav-certificate-list-tab"
                    >
                      <certificate-list
                        :generate="generate"
                        @editExtraCompletion="editExtraComp($event)"
                        @editCompletion="editComp($event)"
                      ></certificate-list>
                    </div>
                  </div>
                </div>
            </div>
        </div>
  </div>
</template>
<script>
import courseDetail from "./CourseDetailComponent.vue";
import certificateList from "./CertificateListComponent.vue";
import extraUnit from "./ExtraUnitsComponent.vue";
import moment from "moment";
export default {
  components: {
    courseDetail,
    certificateList,
    extraUnit
  },
  data() {
    return {
      app_color: app_color,
      student: [],
      courses: [],
      completion_url: "",
      generate: "",
      extra_units: [],
      current_units: [],
      edit_id: "",
      edit_status: false,
      viewing : window.viewing
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    updateCertList(status) {
      this.generate = status;
    },
    updateDataParent(event) {
      if (event == "success") {
        this.fetchData();
        this.edit_status = false;
        this.edit_id = "";
      }
    },
    editExtraComp(e) {
      let newUnits = [];
      let vm = this;
      let extraUnits = vm.extra_units;
      vm.edit_status = true;
      vm.edit_id = e.id;
      extraUnits.forEach(element => {
        if (element.id == e.unit_id) {
          // console.log(element);
          // console.log(e);
          element.units.forEach(e1 => {
            let checker = 0;

            e.units.forEach(e2 => {
              if (e1.code == e2.code) {
                newUnits.push({
                  code: e2.code,
                  description: e2.description,
                  start_date: moment(e2.start_date)._d,
                  end_date: moment(e2.end_date)._d,
                  status: e2.status
                });
                checker = 1;
              }
            });
            if (checker == 0) {
              newUnits.push({
                code: e1.code,
                description: e1.description,
                start_date: "",
                end_date: "",
                status: e1.status
              });
            }
          });
          element.soa_num = e.soa_number;
          element.unit_id = e.id;
          element.units = newUnits;
        }
      });
    },
    editComp(e) { 
      this.courses.forEach(e1 => {
        if (e1.course === e.course) {
          let newUnits = [];
          e.units.forEach(element => {
            element.dates.start = moment(element.dates.start)._d;
            element.dates.end = moment(element.dates.end)._d;
          });
          e1.units = e.units;
          e1.soa_num = e.soa_number;
          this.edit_id = e.id;
          this.edit_status = true;
        }
      });
      // let vm = this;
      // // parsing observer
      // var courses = vm.courses;

      // courses.forEach(element => {
      //   if (element.course == e.course) {
      //     element.units = e.units;
      //     element.soa_num = e.soa_number;
      //   } else {
      //     element.units = element.units;
      //   }
      // });

      // vm.edit_id = e.id;
      // vm.edit_status = true;
      // console.log(parsedyourElement);
      // console.log(e);
    },
    fetchData() {
      if(window.student.id == undefined){
        axios
            .get(`/course_completion/student/${window.student_id}/base`)
            .then(response => {
              if (response.data != null) {
                this.student = response.data.student;
                this.courses = response.data.course;
                // this.completion_url
                if (this.student.type == 1) {
                  this.completion_url = "/student/" + this.student.sid;
                } else {
                  this.completion_url = "/student/domestic/" + this.student.sid;
                }
              }
            })
            .catch(err => {
              console.log(err);
            });
      }else{
        axios
            .get(`/course_completion/student/${window.student.id}/base`)
            .then(response => {
              if (response.data != null) {
                this.student = response.data.student;
                this.courses = response.data.course;
                // this.completion_url
                if (this.student.type == 1) {
                  this.completion_url = "/student/" + this.student.sid;
                } else {
                  this.completion_url = "/student/domestic/" + this.student.sid;
                }
              }
            })
            .catch(err => {
              console.log(err);
            });
        }
      }
      
  }
};
</script>