<template>
  <div>
    <toolbar-actions
      v-bind:back-url="`/student`"
      v-bind:warning-letter="`/student/warning-letters/${student_id}`"
    ></toolbar-actions>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-md-6">
            <h6 :class="'m-0 font-weight-bold text-' + app_color">
              Student Details
              <span>
                ( {{ student_id }} - {{ fullname }}) : {{ student_type }}</span
              >
            </h6>
          </div>
          <div class="col-md-6">
            <div class="form-group row mb-0">
              <label v-if="urole != 'Staff'"
                for="report_avetmiss"
                class="col-sm-7 col-form-label col-form-label-sm text-right"
                >Test Student</label
              >
              <div  v-if="urole != 'Staff'" class="col-sm-1 px-0">
                <div class="custom-control custom-switch my-0">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    @change="isTest"
                    v-model="is_test"
                    id="report_avetmiss"
                  />
                  <label
                    class="custom-control-label"
                    for="report_avetmiss"
                  ></label>
                </div>
              </div>
              <label
                for="report_avetmiss"
                :class="`col-sm-${urole == 'Staff' ? '11' : '3'} col-form-label col-form-label-sm text-right`"
                >Report to Avetmiss</label
              >
              <div class="col-sm-1 px-0">
                <div class="custom-control custom-switch my-0">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    @change="isReport"
                    v-model="report_avetmiss"
                    id="report_avetmiss"
                  />
                  <label
                    class="custom-control-label"
                    for="report_avetmiss"
                  ></label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div>
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a
                v-bind:class="'nav-item nav-link-' + app_color + ' active'"
                id="nav-info-tab"
                data-toggle="tab"
                href="#nav-info"
                role="tab"
                aria-controls="nav-info"
                aria-selected="true"
                >Info</a
              >
              <a
                :class="'nav-item nav-link-' + app_color"
                id="nav-enrolment-tab"
                data-toggle="tab"
                href="#nav-enrolment"
                role="tab"
                aria-controls="nav-enrolment"
                aria-selected="false"
                >Enrolment</a
              >
              <a
                :class="'nav-item nav-link-' + app_color"
                id="nav-others-tab"
                data-toggle="tab"
                href="#nav-others"
                role="tab"
                aria-controls="nav-others"
                aria-selected="false"
                >Others</a
              >
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div
              class="tab-pane fade show active"
              id="nav-info"
              role="tabpanel"
              aria-labelledby="nav-info-tab"
            >
              <div>
                <info-tab></info-tab>
              </div>
            </div>
            <div
              class="tab-pane enrolments fade show"
              id="nav-enrolment"
              role="tabpanel"
              aria-labelledby="nav-enrolment-tab"
            >
              <div>
                <enrolment-tab></enrolment-tab>
              </div>
            </div>
            <div
              class="tab-pane fade show"
              id="nav-others"
              role="tabpanel"
              aria-labelledby="nav-others-tab"
            >
              <div>
                <others-tab></others-tab>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ToolbarActions from "../globals/ToolbarActionsComponent.vue";
import infoTab from "./infoTabComponent.vue";
import enrolmentTab from "./enrolmentTabComponent.vue";
import othersTab from "./othersTabComponent.vue";
import { mapGetters, mapActions } from "vuex";
export default {
  props : ['urole'],
  components: {
    ToolbarActions,
    infoTab,
    enrolmentTab,
    othersTab
  },
  data() {
    return {
      app_color: app_color,
      report_avetmiss: "",
      is_test: '',
    };
  },

  mounted() {
    swal.fire({
      title: "Loading Student Details...",
      // html: '',// add html attribute if you want or remove
      allowOutsideClick: false,
      onBeforeOpen: () => {
        swal.showLoading();
      },
    });
    this.$store.dispatch("getStudentInfo", window.student_id);
  },
  computed: {
    student_id() {
      return this.$store.getters.info.student_id;
    },
    fullname() {
      this.report_avetmiss = this.$store.getters.info.report_avetmiss;
      this.is_test = this.$store.getters.info.is_test;
      return this.$store.getters.info.name;
    },
    student_type() {
      return this.$store.getters.type;
    },
  },
  methods: {
    ...mapActions(["reportAvetmiss"]),
    isReport() {
      this.reportAvetmiss(this.report_avetmiss);
      // axios({
      //   method: "get",
      //   url: `/student/details/report-avetmiss/${student_id}/${report_avetmiss}`,
      // })
      //   .then((res) => {
      //     let vm = this;
      //     console.log(res.data.status);
      //   })
      //   .catch((err) => console.log(err));
    },
    isTest(){
      axios.get(`/testdriven/${student_id}`).then((res)=>{
          if(res.data.status == 'success'){
             Toast.fire({
              type: "success",
              title: "Student status is updated",
              position: "top-end",
            });
          }else{
             Toast.fire({
              type: "error",
              title: "Something Went Wrong",
              position: "top-end",
            });
          }
      })
    },
  },
};
</script>

<style scoped>
   .enrolments.tab-pane{
        padding:0!important;
    }
</style>
