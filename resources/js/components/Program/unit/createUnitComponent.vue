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
      <h4 :class="'modal-header-'+app_color">Add Unit</h4>
      <form @submit.prevent="create">
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="code" class>Unit Code / Unit Title:</label>
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
                :taggable="true"
                @select="checkSelect"
                @search-change="fetchUnitOption"
                @tag="addTag"
                id="ajax"
                v-model="fields.unit"
                placeholder="Type to search Unit"
                tag-placeholder="Add this as new unit"
                track-by="unit_code"
                label="unit_title"
              >
                <span slot="noResult">Oops! No Unit found. Consider changing the search query.</span>
              </multiselect>
              <!-- <input
                type="text"
                class="form-control"
                id="code"
                v-model="fields.code"
                :class="[errors && errors.code ? 'border-danger' : '']"
                autofocus
              />
              <div
                v-if="errors && errors.code"
                class="badge badge-danger"
                :class="[isValid ? 'd-none': 'd-inline-block']"
              >{{ errors.code[0] }}</div>-->
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="unit_type" class>Unit Type:</label>
              <select
                class="form-control"
                id="unit_type"
                v-model="fields.unit_type"
                :class="[errors && errors.unit_type ? 'border-danger' : '']"
              >
                <option value="core">Core</option>
                <option value="elective">Elective</option>
              </select>
              <div
                v-if="errors && errors.unit_type"
                class="badge badge-danger"
              >{{ errors.unit_type[0] }}</div>
            </div>
          </div>
          <!-- <div class="col-lg-12">
            <div class="form-group">
              <label for="description" class>Subject Description:</label>
              <input
                type="text"
                class="form-control"
                id="description"
                v-model="fields.description"
                :class="[errors && errors.description ? 'border-danger' : '']"
              />
              <div
                v-if="errors && errors.description"
                class="badge badge-danger"
              >{{ errors.description[0] }}</div>
            </div>
          </div>-->
          <div class="col-lg-12">
            <div class="form-group">
              <label for="assessment_method" class>Assessment Method:</label>
              <multiselect
                v-model="fields.assessment_method"
                :options="options"
                :multiple="true"
                :searchable="false"
                :close-on-select="false"
                label="description"
                track-by="id"
                :class="[errors && errors.assessment_method ? 'border-danger' : '']"
              ></multiselect>
              <div
                v-if="errors && errors.assessment_method"
                class="badge badge-danger"
              >{{ errors.assessment_method[0] }}</div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label
                for="subject_educ_fld_identifier_id"
                class
              >Subject Field of Education Identifier:</label>
              <select
                class="form-control"
                id="subject_educ_fld_identifier_id"
                v-model="fields.subject_educ_fld_identifier_id"
                :class="[errors && errors.subject_educ_fld_identifier_id ? 'border-danger' : '']"
              >
                <option v-bind:value="ufe.id" v-for="ufe in unit_field_educ">{{ ufe.description }}</option>
              </select>
              <div
                v-if="errors && errors.subject_educ_fld_identifier_id"
                class="badge badge-danger"
              >{{ errors.subject_educ_fld_identifier_id[0] }}</div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="nominal_hours" class>Nominal Hours:</label>
              <input
                type="number"
                min="0"
                class="form-control"
                id="nominal_hours"
                v-model="fields.nominal_hours"
                :class="[errors && errors.nominal_hours ? 'border-danger' : '']"
              />
              <div
                v-if="errors && errors.nominal_hours"
                class="badge badge-danger"
              >{{ errors.nominal_hours[0] }}</div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label for="training_method_id" class>Training Method:</label>
              <select
                class="form-control"
                id="training_method_id"
                v-model="fields.training_method_id"
                :class="[errors && errors.training_method ? 'border-danger' : '']"
              >
                <option v-bind:value="tm.id" v-for="tm in training_methods">{{ tm.description }}</option>
              </select>
              <!-- <input type="text" class="form-control" id="unit_type" name="unit_type" v-model="fields.unit_type" /> -->
              <div
                v-if="errors && errors.training_method_id"
                class="badge badge-danger"
              >{{ errors.training_method_id[0] }}</div>
            </div>
          </div>
          <div class="clearfix w-100"></div>
          <div class="col-lg-4">
            <div class="form-group">
              <div class="custom-control custom-switch my-3">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  id="vet_flag"
                  v-model="fields.vet_flag"
                  value="0"
                />
                <label class="custom-control-label" for="vet_flag">VET Flag Status</label>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <div class="custom-control custom-switch my-3">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  id="extra_unit"
                  v-model="fields.extra_unit"
                  value="0"
                />
                <label class="custom-control-label" for="extra_unit">Set as Extra Unit</label>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <div class="custom-control custom-switch my-3">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  id="active"
                  v-model="fields.active"
                  value="0"
                />
                <label class="custom-control-label" for="active">Set as Active</label>
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
  name: "unitModal",
  data() {
    return {
      // Form Attributes
      app_color: app_color,
      action: "/unit",
      method: "post",
      isModal: "true",
      isActive: true,
      // Form Inputs
      unit_field_educ: unit_field_educ,
      training_methods: training_methods,
      assessment_method: null,
      opt: [],
      isLoading: false,
      errors: {},
      options: assessment_method
    };
  },
  watch: {
    fields: function(value) {
      if (value.code != null) {
        this.errors.code = "";
      }
      if (value.unit_type != null) {
        this.errors.unit_type = "";
      }
      if (value.description != null) {
        this.errors.description = "";
      }
      if (value.assessment_method != null) {
        this.errors.assessment_method = "";
      }
    }
  },
  methods: {
    beforeOpen(e) {
      this.fields = {};
      // this.fetchCourses();
    },
    beforeClose(e) {
      //   console.log(this.$parent.$refs);
      this.$parent.$refs.unitList.refresh();
      //   let vm = this;
      //   vm.$refs.unitList.refresh();
      //   console.log(vm.$refs);
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
      console.log(this.isLoading);
      this.isLoading = false;
    },
    addTag(newTag) {
      let af = this;
      const fixedtag = newTag.split("-");
      const tag = {
        tp_code: "",
        unit_code: fixedtag[0],
        unit_title: fixedtag[1]
      };
      af.opt.push(tag);
      af.fields.unit = tag;
    },
    fetchUnitOption(query) {
      let af = this;

      if (query == "") {
        af.opt = [];
      } else {
        af.isLoading = true;
        axios
          .get("/units/list/" + query)
          .then(function(response) {
            // handle success
            // console.log(response.data);
            af.isLoading = false;
            af.opt = response.data;
          })
          .catch(function(error) {
            // handle error
            af.isLoading = false;
            console.log(error);
          })
          .then(function() {
            // always executed
            // alert(af.selectedStudent);
            af.isLoading = false;
          });
      }
    },
    limitText(count) {
      return `and ${count} other units`;
    },
    courseWithCode({ unit_code, unit_title }) {
      return `${unit_code} - ${unit_title}`;
    }
  }
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