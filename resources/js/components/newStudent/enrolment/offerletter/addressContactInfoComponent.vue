<template>
  <div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="email_personal">Email Personal</label>
          <input type="text" class="form-control" v-model="student_details.email_personal" id="email_personal" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="telephone">Telephone</label>
          <input type="text" class="form-control" v-model="student_details.telephone" id="telephone" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="mobile">Mobile</label>
          <input type="text" class="form-control" v-model="student_details.mobile" id="mobile" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="home_address">Home Address</label>
          <input type="text" class="form-control" v-model="student_details.home_address" id="home_address" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="current_address">Current Address</label>
          <input type="text" class="form-control" v-model="student_details.current_address" id="current_address" />
        </div>
      </div>
      <!-- <div class="col-md-6">
                      <div class="form-group">
                        <label for="current_address">Current Address</label>
                        <input type="text" class="form-control" id="current_address" />
                      </div>
      </div>-->

      <div class="col-md-6">
        <div class="form-group">
          <label for="country">Country</label>
          <select name="country" id="country" v-model="student_details.country" class="form-control">
            <option value></option>
            <option
              v-for="country in countries"
              :key="country.id"
              :value="country.id"
            >{{ country.value}}</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="state_province">State Province</label>
          <select
            name="state_province"
            id="state_province"
            v-model="student_details.state_province"
            class="form-control"
          >
            <option value></option>
            <option
              v-for="(state , key) in states"
              :key="key"
              :value="key"
            >({{ key }}) {{ state }}</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="postcode">Postcode</label>
          <input type="text" class="form-control" v-model="student_details.postcode" id="postcode" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      student_type: window.student_type,
      countries : window.slct_country,
      states : window.states,
      telephone: "",
      mobile: "",
      current_address: "",
      home_address: "",
      country: "",
      state_province: "",
      postcode: "",
    };
  },
  computed: {
    student_details(){
      let index = this.$parent.$attrs.index;
      return this.$store.getters.enrolment[index].offer_letter.student_details;
    }
  },
};
</script>