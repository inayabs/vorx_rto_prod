<template>
  <modal
    name="size-modal"
    transition="nice-modal-fade"
    classes="demo-modal-class"
    :min-width="200"
    :min-height="200"
    :pivot-y="0.1"
    :adaptive="true"
    :scrollable="true"
    :reset="true"
    width="40%"
    height="auto"
    @before-open="beforeOpen"
    @opened="opened"
    @closed="closed"
    @before-close="beforeClose"
  >
    <div class="size-modal-content px-1">
      <h4 :class="'modal-header-'+app_color">Add Course</h4>
      <form @submit.prevent>
        <div class="row">
          <multiselect
            :class="'multiselect-color-'+app_color"
            :options="opt"
            :multiple="false"
            :custom-label="courseWithCode"
            :close-on-select="true"
            :searchable="true"
            :loading="isLoading"
            :limit="3"
            :limit-text="limitText"
            :max-height="600"
            :show-no-results="false"
            :hide-selected="true"
            @select="checkSelect"
            @search-change="fetchCourseOption"
            id="ajax"
            v-model="fields.course"
            placeholder="Type to search Course"
            track-by="qual_code"
            label="qual_title"
          >
            <span slot="noResult">Oops! No Course found. Consider changing the search query.</span>
          </multiselect>
        </div>

        <div class="addcourse mt-3">
          <div class="row">
            <div class="col-md-12">
              <span>Customize Course</span>
            </div>
            <!-- <div class="col-md-2">
              <div class="form-group">
                <label for>TP Code</label>
                <input type="text" v-model="addFields.course.tp_code" class="form-control" />
              </div>
            </div> -->
            <div class="col-md-3">
              <div class="form-group">
                <label for>Course Code</label>
                <input type="text" v-model="addFields.course.qual_code" class="form-control" />
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label for>Course Name</label>
                <input type="text" v-model="addFields.course.qual_title" class="form-control" />
              </div>
            </div>
          </div>
        </div>

        <button @click="saveCourse" :class="'btn btn-sm mt-3 float-right btn-'+app_color">
          <i class="far fa-save"></i> Save
        </button>
        <div class="clearfix w-100"></div>
      </form>
    </div>
  </modal>
</template>
<script>
// import FormMixin from "../../../mixins/FormMixin";

const Toast = swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
});

export default {
  // mixins: [FormMixin],
  name: "courseModal",
  data() {
    return {
      // Form Attributes
      // action: "/course",
      // method: "post",
      fields: {
        course: [],
      },
      addFields: {
        course: {
          tp_code: "",
          qual_code: "",
          qual_title: "",
          active: 1,
        },
      },
      app_color: app_color,
      course: {},
      errors: {},
      isModal: "true",
      opt: [],
      isLoading: false,
    };
  },
  watch: {
    fields: function (value) {
      if (value.code != null) {
        this.errors.code = "";
      }
      if (value.name != null) {
        this.errors.name = "";
      }
    },
  },
  methods: {
    beforeOpen(e) {
      this.fields = {};
    },
    beforeClose(e) {
      this.isLoading = false;
      this.$parent.fetchCourses();
    },
    opened(e) {
      // e.ref should not be undefined here
      // console.log('opened', e)
      // console.log('ref', e.ref)
    },
    closed(e) {
      this.errors = "";
    },
    checkSelect(selected) {
      console.log(selected);
      this.addFields.course = selected;
      this.isLoading = false;
    },
    fetchCourseOption(query) {
      let af = this;

      if (query == "") {
        af.opt = [];
      } else {
        af.isLoading = true;
        axios
          .get("/course_options/list/" + query)
          .then(function (response) {
            // handle success
            // console.log(response.data);
            af.isLoading = false;
            af.opt = response.data;
          })
          .catch(function (error) {
            // handle error
            af.isLoading = false;
            console.log(error);
          })
          .then(function () {
            // always executed
            // alert(af.selectedStudent);
            af.isLoading = false;
          });
      }
    },
    limitText(count) {
      return `and ${count} other courses`;
    },
    courseWithCode({ qual_code, qual_title }) {
      return `${qual_code} - ${qual_title}`;
    },
    saveCourse() {
      swal.fire({
        title: "Please wait...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      let vm = this;
      vm.errors = {};
      axios
        .post("/course", vm.addFields)
        .then((response) => {
          Toast.fire({
            // position: 'top-end',
            type: "success",
            title: "Data is saved successfully",
            background: "#DCEDC8",
          });
          this.$modal.hide("size-modal");
        })
        .catch((error) => {
          // console.log(error.response.data);
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
            Toast.fire({
              // position: 'top-end',
              type: "error",
              title: "Opss.. data was not saved",
              background: "#ffcdd2",
            });
          } else {
            Toast.fire({
              // position: 'top-end',
              type: "error",
              title: "Opss.. something went wrong",
              background: "#ffcdd2",
            });
          }
        });
    },
  },
};
</script>
<style scoped>
.size-modal-content {
  padding: 10px;
  margin: 10px;
  font-style: 13px;
}
.v--modal-overlay[data-modal="size-modal"] {
  background: rgba(0, 0, 0, 0.5);
}
.demo-modal-class {
  border-radius: 5px;
  background: #f7f7f7;
  box-shadow: 5px 5px 30px 0px rgba(46, 61, 73, 0.6);
}
</style>