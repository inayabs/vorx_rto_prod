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
    width="60%"
    height="auto"
    @before-open="beforeOpen"
    @opened="opened"
    @closed="closed"
    @before-close="beforeClose"
  >
    <div class="size-modal-content px-1">
      <h4 :class="'modal-header-'+app_color">Add Package</h4>
      <form @submit.prevent="create">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="name">Name:</label>
              <input
                type="text"
                id="name"
                class="form-control"
                v-model="fields.name"
                :class="[errors && errors.name ? 'border-danger' : '']"
                autofocus
              />
              <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="shore_type">Student Location:</label>
              <select
                id="shore_type"
                class="form-control"
                v-model="fields.shore_type"
                :class="[errors && errors.shore_type ? 'border-danger' : '']"
              >
                <option value="ONSHORE">ONSHORE</option>
                <option value="OFFSHORE">OFFSHORE</option>
              </select>
              <div
                v-if="errors && errors.shore_type"
                class="badge badge-danger"
              >{{ errors.shore_type[0] }}</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="location">Location:</label>
              <select
                id="location"
                class="form-control"
                v-model="fields.location"
                :class="[errors && errors.location ? 'border-danger' : '']"
              >
                <!-- <option value="QLD">Queensland (QLD)</option>
                <option value="VIC">Victoria (VIC)</option>-->
                <option
                  v-for="(location, index) in dlvr_location"
                  :key="index"
                  :value="location.id"
                >{{ location.train_org_dlvr_loc_name }}</option>
              </select>
              <div
                v-if="errors && errors.location"
                class="badge badge-danger"
              >{{ errors.location[0] }}</div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea
                id="description"
                class="form-control"
                v-model="fields.description"
                cols="30"
                rows="5"
                :class="[errors && errors.description ? 'border-danger' : '']"
              ></textarea>
              <div
                v-if="errors && errors.description"
                class="badge badge-danger"
              >{{ errors.description[0] }}</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="date_created">Date Created:</label>
              <date-picker
                v-model="fields.date_created"
                :max-date="new Date()"
                :formats="formats"
                :class="[errors && errors.date_created ? 'border-danger' : '']"
              ></date-picker>
              <div
                v-if="errors && errors.date_created"
                class="badge badge-danger"
              >{{ errors.date_created[0] }}</div>
            </div>
            <div class="form-group">
              <label for="is_active">Status:</label>
              <div class="custom-control custom-switch my-2">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  id="is_active"
                  v-model="fields.is_active"
                  value="0"
                />
                <label class="custom-control-label" for="is_active">Set as Active</label>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" :class="'btn btn-sm float-right btn-'+app_color">
          <i class="far fa-save"></i> Save
        </button>
        <div class="clearfix w-100"></div>
      </form>
    </div>
  </modal>
</template>
<script>
import FormMixin from "../../../mixins/FormMixin";
export default {
  mixins: [FormMixin],
  name: "packageModal",
  data() {
    return {
      // Form Attributes
      action: "/course-package",
      method: "post",
      isModal: "true",
      course_id: "",
      dlvr_location: window.dlvr_location,
      formats: {
        title: "MMMM YYYY",
        weekdays: "W",
        navMonths: "MMM",
        input: ["", "YYYY-MM-DD", "YYYY/MM/DD"], // Only for `v-date-picker`
        data: ["", "YYYY-MM-DD", "YYYY/MM/DD"],
      },
      app_color: app_color,
    };
  },
  watch: {
    fields: function (value) {
      if (value.name != null) {
        this.errors.name = "";
      }
      if (value.shore_type != null) {
        this.errors.shore_type = "";
      }
      if (value.location != null) {
        this.errors.location = "";
      }
    },
  },
  methods: {
    beforeOpen(e) {
      this.fields = {};

      // this.fetchCourses();
    },
    beforeClose(e) {
      this.$parent.getPackageList();
    },
    opened(e) {
      // e.ref should not be undefined here
      // console.log('opened', e)
      // console.log('ref', e.ref)
    },
    closed(e) {
      this.errors = "";
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