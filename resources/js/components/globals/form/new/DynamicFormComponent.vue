<template>
  <div>
    <div class="row mb-3">
      <div class="col-md-12 pull-right text-right">
        <button  class="btn btn-success" :disabled="roles == 'Staff'? true : false " @click="saveChanges()">
          <i class="far fa-save"></i> Save Changes
        </button>
      </div>
    </div>
    <div v-for="(form, key) in this.formSettings" :key="key">
      <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
        <h6>{{ form.FormTitle }}</h6>
      </div>
      <div class="clearfix"></div>
      <div class="form-padding-left-right">
        <div class="row">
          <div
            v-for="(itm, k) in form.FormBody"
            :key="k"
            v-bind:class="
              typeof itm['col_size'] !== 'undefined'
                ? 'col-md-' + itm['col_size']
                : 'col-md-6'
            "
          >
            <div v-if="itm['type'] === 'text'">
              <!-- text -->

              <div class="form-group" :hidden="typeof itm['hidden'] !== 'undefined' ? true : false">
                <label for="company_name">
                  {{ itm["lable"] }}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-' + app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                  <span
                    style="font-size: 74%; opacity: 73%"
                    v-if="itm['name'] === 'addr_postal_delivery_box'"
                  >
                    (
                    <i>If different from above</i> )
                  </span>
                </label>
                <div
                  v-if="itm['name'] == 'unique_student_id'"
                  class="input-group mb-3"
                >
                  <input
                    type="text"
                    class="form-control"
                    v-bind:name="itm['name']"
                    v-bind:id="itm['name']"
                    v-model="inputs[itm['name']]"
                    aria-describedby="basic-addon2"
                  />

                  <div class="input-group-append">
                    <button
                      v-if="inputs['verified']"
                      class="btn btn-success btn-outline-secondary"
                      @click="verifyUsiData"
                      type="button"
                    >
                      Verified
                    </button>
                    <button
                      v-else
                      class="btn btn-outline-secondary"
                      @click="verifyUsiData"
                      type="button"
                    >
                      Verify
                    </button>
                  </div>
                </div>
                <input
                  v-else
                  class="form-control"
                  v-bind:name="itm['name']"
                  type="text"
                  v-bind:id="itm['name']"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                />
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                  >{{ errors[itm["name"]][0] }}</span
                >
              </div>
            </div>
            <div v-else-if="itm['type'] === 'select'">
              <!-- selectbox -->
              <div v-if="itm['name'] === 'funding_type'" class="form-group">
                <label v-bind:for="itm['name']">{{ itm["lable"] }}</label>
                <select
                  name="agent_type"
                  class="form-control"
                  @change="autofillFields(inputs[itm['name']])"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                >
                  <option value></option>
                  <option
                    v-for="opt in itm['items']"
                    v-bind:key="opt.id"
                    v-bind:value="opt"
                  >
                    {{ opt.name }}
                  </option>
                  <label
                    class="custom-control-label"
                    v-bind:for="itm['name']"
                  ></label>
                </select>
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                  >{{ errors[itm["name"]][0] }}</span
                >
              </div>
              <div v-else-if="itm['name'] === 'language_id'" class="form-group">
                <label v-bind:for="itm['name']">
                  {{ itm["lable"] }}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-' + app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <select
                  name="agent_type"
                  class="form-control"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                >
                  <option
                    v-for="(opt, optKy) in itm['items']"
                    v-bind:key="opt"
                    v-bind:value="opt"
                  >
                    {{ optKy }}
                  </option>
                  <label
                    class="custom-control-label"
                    v-bind:for="itm['name']"
                  ></label>
                </select>
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                  >{{ errors[itm["name"]][0] }}</span
                >
              </div>
              <div v-else class="form-group">
                <label v-bind:for="itm['name']">
                  {{ itm["lable"] }}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-' + app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <select
                  name="agent_type"
                  class="form-control"
                  v-model="inputs[itm['name']]"
                  :disabled="itm['disabled'] === 'disabled'"
                >
                  <option :value="itm['name'] === 'class' ? 0 : ''"></option>
                  <option
                    v-for="(opt, optKy) in itm['items']"
                    v-bind:key="optKy"
                    v-bind:value="optKy"
                  >
                    {{ opt }}
                  </option>
                  <label
                    class="custom-control-label"
                    v-bind:for="itm['name']"
                  ></label>
                </select>
                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                  >{{ errors[itm["name"]][0] }}</span
                >
              </div>
            </div>
            <div v-else-if="itm['type'] === 'checkbox'">
              <!-- checkbox -->
              <div class="form-group">
                <label v-bind:for="itm['name']">{{ itm["lable"] }}</label>
                <div class="custom-control custom-switch my-2">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    v-bind:id="itm['name']"
                    v-model="inputs[itm['name']]"
                  />
                  <label
                    class="custom-control-label"
                    v-bind:for="itm['name']"
                  ></label>
                </div>
              </div>
            </div>
            <div v-else-if="itm['type'] === 'radio'">
              <!-- radiobox -->
            </div>
            <div v-else-if="itm['type'] === 'email'">
              <!-- emailbox -->
              <div class="form-group">
                <label for="company_name">{{ itm["lable"] }}</label>
                <input
                  class="form-control"
                  v-bind:name="itm['name']"
                  type="email"
                  v-bind:id="itm['name']"
                  v-model="inputs[itm['name']]"
                />
              </div>
            </div>
            <div v-else-if="itm['type'] === 'password'">
              <!-- passwordbox -->
              <div class="form-group">
                <label for="company_name">{{ itm["lable"] }}</label>
                <input
                  class="form-control"
                  v-bind:name="itm['name']"
                  type="password"
                  v-bind:id="itm['name']"
                  v-model="inputs[itm['name']]"
                />
              </div>
            </div>
            <div v-else-if="itm['type'] === 'textbox'">
              <!-- textbox -->
              <div class="form-group">
                <label v-bind:for="itm['name']">{{ itm["lable"] }}</label>
                <textarea
                  class="form-control"
                  v-bind:name="itm['name']"
                  v-bind:id="itm['name']"
                  v-model="inputs[itm['name']]"
                ></textarea>
              </div>
            </div>
            <div v-else-if="itm['type'] === 'multiselect'">
              <!-- multiselect -->
              <div class="form-group">
                <label v-bind:for="itm['name']">
                  {{ itm["lable"] }}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-' + app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <multiselect
                  v-model="inputs[itm['name']]"
                  :options="itm['selections']"
                  :multiple="true"
                  placeholder="Type to search"
                  :close-on-select="false"
                  track-by="id"
                  label="value"
                >
                  <span slot="noResult"
                    >Oops! No units found. Consider changing the search
                    query.</span
                  >
                </multiselect>
              </div>
            </div>
            <div v-else-if="itm['type'] === 'singleselect'">
              <!-- multiselect -->
              <div class="form-group">
                <label v-bind:for="itm['name']">
                  {{ itm["lable"] }}
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-' + app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <multiselect
                  v-model="inputs[itm['name']]"
                  :options="itm['selections']"
                  :multiple="false"
                  :disabled="itm['disabled']"
                  placeholder="Type to search"
                  :close-on-select="true"
                  track-by="id"
                  label="value"
                >
                  <span slot="noResult"
                    >Oops! No units found. Consider changing the search
                    query.</span
                  >
                </multiselect>
              </div>
            </div>
            <div v-if="itm['type'] === 'datepicker'">
              <div class="form-group">
                <label>
                  {{ itm["lable"] }}
                  <span style="font-size: 74%; opacity: 73%"
                    >( DD/MM/YYYY )</span
                  >
                  <a
                    v-if="itm['avetmiss'] === 'required'"
                    href="#"
                    data-toggle="tooltip"
                    :class="'a-' + app_color"
                    title="Avetmiss required!"
                    data-placement="right"
                  >
                    <i class="fas fa-info-circle"></i>
                  </a>
                </label>
                <date-picker
                  v-if="inputs[itm['name']] === inputs.end_date"
                  locale="en"
                  :masks="{ L: 'DD/MM/YYYY' }"
                  v-bind:value="inputs[itm['value']]"
                  v-model="inputs[itm['name']]"
                  v-bind:name="itm['name']"
                  v-bind:id="itm['name']"
                  :min-date="
                    inputs.start_date != '' || inputs.start_date != null
                      ? inputs.start_date
                      : ''
                  "
                  :disabled-dates="getDisabledDate"
                ></date-picker>
                <date-picker
                  v-else-if="inputs[itm['name']] === inputs.start_date"
                  locale="en"
                  :masks="{ L: 'DD/MM/YYYY' }"
                  v-bind:value="inputs[itm['value']]"
                  v-model="inputs[itm['name']]"
                  v-bind:name="itm['name']"
                  v-bind:id="itm['name']"
                  :disabled-dates="getDisabledDate"
                ></date-picker>
                <date-picker
                  v-else
                  locale="en"
                  :masks="{ L: 'DD/MM/YYYY' }"
                  v-bind:value="inputs[itm['value']]"
                  v-model="inputs[itm['name']]"
                  v-bind:name="itm['name']"
                  v-bind:id="itm['name']"
                ></date-picker>

                <span
                  v-if="errors && errors[itm['name']]"
                  :class="['badge badge-danger']"
                  >{{ errors[itm["name"]][0] }}</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import { mapGetters, mapMutations, mapActions } from "vuex";
export default {
  props: {
    formSettings: Array,
    formValues: {
      type: Object,
      required: true,
    },
    saveForm: String,
  },
  data() {
    return {
      app_color: app_color,
      inputs: this.formValues,
      errors: [],
      roles : null,
    };
  },
  mounted(){
    if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },

  methods: {
    ...mapActions(['verify_usi']),
    verifyUsiData(){
      this.verify_usi();
    },
    saveChanges() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", swal.stopTimer);
          toast.addEventListener("mouseleave", swal.resumeTimer);
        },
      });
      swal.fire({
        title: "Loading Student Details...",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });
      let inputs = this.inputs;
      axios
        .post(this.saveForm, inputs)
        .then((response) => {
          if (response.data.status == "success") {
            this.$emit("updateStudent", response.data);
            swal.fire({
              type: "success",
              title: "Data saved successfully",
              timer: 3000,
              showConfirmButton: false,
            });
          }else if(response.data.status == "updated"){
            swal.fire({
              title: "Updated Successfully",
              type: "success",
              timer: 3000,
              showConfirmButton: false,
            });
          }else if(response.data.status == "errors"){
            //return required fields
            this.errors = response.data.errors;
            swal.fire({
              title: "Opss.. was not saved successfully",
              type: "error",
              timer: 3000,
              showConfirmButton: false,
            });
          }else{
            // for unknown errors XD
            this.errors = response.data.errors;
            swal.fire({
              title: "Opss.. was not saved successfully",
              type: "error",
              timer: 3000,
              showConfirmButton: false,
            });
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getDisabledDate(date) {
      let vm = this;
      const today = new Date();
      let x = false;
      vm.formSettings.forEach((element) => {
        if (element.FormTitle == "Course Details") {
          element.FormBody.map((e, key) => {
            // console.log(e.name);
            if (e.name == "start_date" || e.name == "end_date") {
              if (e.disabled == "disabled") {
                today.setHours(0, 0, 0, 0);
                // // with today plus 7 days
                // // console.log(moment(date.id)._d < today || moment(date.id)._d > new Date(today.getTime() + 7 * 24 * 3600 * 1000));
                x =
                  moment(date.id)._d <= today ||
                  moment(date.id)._d > new Date(today.getTime());
              }
            }
          });
        }
      });
      // console.log(x);
      return x;
    },
  autofillFields(data) {
      let vm = this;
      let inputs = this.inputs;
      inputs.purchasing_contract_id = data.purchasing_contract;
      inputs.purchasing_contract_schedule_id = data.purchasing_schedule;
      inputs.specific_funding_id = data.specific_funding_code;
      inputs.funding_source_national = data.national_funding_code;
      inputs.funding_source_state_training_authority = data.state_funding_code;
      inputs.training_contract_id = data.training_contract;

      if (data.traineeship_apprenticeship == 1) {
        vm.$emit("fundingType", data.traineeship_apprenticeship);
      }
    },
  },
  watch: {
    formValues: function (val, oval) {
      let vm = this;
      vm.inputs = val;
    },
  },
};
</script>

<style>
</style>
