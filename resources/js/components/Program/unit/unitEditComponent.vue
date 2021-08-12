<template>
  <div>
    <div class="row mb-2 d-flex justify-content-between">
      <div class="col-md-12">
        <a href="/unit" v-bind:class="'btn btn-'+app_color+' btn-sm text-primary text-light'">
          <i class="fas fa-long-arrow-alt-left"></i> Back
        </a>
      </div>
   </div>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 :class="'m-0 font-weight-bold text-'+app_color">Edit Unit</h6>
      </div>
      <div class="card-body">
          <div>
            <form @submit.prevent="update">
              <div class="row mb-2 d-flex justify-content-between">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success btn-sm d-block ml-auto">
                    <i class="far fa-save"></i> Save Unit
                  </button>
                </div>
              </div>
              <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>Edit Units</h6>
              </div>
              <div class="form-padding-left-right">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="code" class>Unit Code:</label>
                      <input
                        type="text"
                        class="form-control"
                        id="code"
                        v-model="fields.code"
                        :class="[errors && errors.code ? 'border-danger' : '']"
                      />
                      <div v-if="errors && errors.code" class="badge badge-danger">{{ errors.code[0] }}</div>
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
                  <div class="col-lg-12">
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
                  </div>
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
                  <div class="col-lg-7">
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
                        <option
                          v-bind:value="ufe.id"
                          v-for="ufe in unit_field_educ"
                          :key="ufe.id"
                        >{{ ufe.description }}</option>
                      </select>
                      <div
                        v-if="errors && errors.subject_educ_fld_identifier_id"
                        class="badge badge-danger"
                      >{{ errors.subject_educ_fld_identifier_id[0] }}</div>
                    </div>
                  </div>
                  <div class="col-lg-2">
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
                        <option
                          v-bind:value="tm.id"
                          v-for="tm in training_methods"
                          v-bind:key="tm.id"
                        >{{ tm.description }}</option>
                      </select>
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
                          name="vet_flag"
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
                          name="extra_unit"
                          v-model="fields.extra_unit"
                          value="0"
                        />
                        <label class="custom-control-label" for="extra_unit">Set as Unit of Competency</label>
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
                          name="active"
                          v-model="fields.active"
                          value="0"
                        />
                        <label class="custom-control-label" for="active">Set as Active</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>          
          </div>
      </div>
    </div>
  </div>
</template>


<script>
import FormMixin from "../../../mixins/FormMixin";
export default {
  mixins: [FormMixin],
  name: "unitCreate",
  data() {
    return {
      // Form Attributes
      action: "/unit/" + post_id,
      method: "put",
      app_color: app_color,
      // Form Inputs
      unit_field_educ: unit_field_educ,
      training_methods: training_methods,
      assessment_method: am_selected,
      options: assessment_method
    };
  },
  watch: {
    fields: function(value) {
      if (value.code != null) {
        this.errors.code = "";
      }
      if (value.description != null) {
        this.errors.description = "";
      }
      if (value.assessment_method != null) {
        this.errors.assessment_method = "";
      }
    }
  },
  created() {
    this.fetchData();
    this.fields.assessment_method = this.assessment_method;
  },
  methods: {
    fetchData() {
      this.fields = post_details;
      console.log(post_details);
    }
  }
};
</script>
