<template>
  <div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="email_personal">Email Personal</label>
          <input type="text" class="form-control" v-model="email_personal" id="email_personal" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="telephone">Telephone</label>
          <input type="text" class="form-control" v-model="telephone" id="telephone" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="mobile">Mobile</label>
          <input type="text" class="form-control" v-model="mobile" id="mobile" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="home_address">Home Address</label>
          <input type="text" class="form-control" v-model="home_address" id="home_address" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="current_address">Current Address</label>
          <input type="text" class="form-control" v-model="current_address" id="current_address" />
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
          <select name="country" id="country" v-model="country" class="form-control">
            <option value></option>
            <option
              v-for="country in countries"
              :key="country.identifier"
              :value="country.identifier"
            >{{ country.full_name}}</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="state_province">State Province</label>
          <select
            name="state_province"
            id="state_province"
            v-model="state_province"
            class="form-control"
          >
            <option value></option>
            <option
              v-for="state in states"
              :key="state.id"
              :value="state.state_key"
            >({{ state.state_key }}){{ state.state_name}}</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="postcode">Postcode</label>
          <input type="text" class="form-control" v-model="postcode" id="postcode" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["types", "countries", "states"],
  data() {
    return {
      email_personal: "",
      telephone: "",
      mobile: "",
      current_address: "",
      home_address: "",
      country: "",
      state_province: "",
      postcode: "",
    };
  },
};
</script>