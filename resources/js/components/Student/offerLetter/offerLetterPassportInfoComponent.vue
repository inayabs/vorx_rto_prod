<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="passport_number">Passport Number</label>
          <input type="text" class="form-control" v-model="passport_num" id="passport_number" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="passport_number">
            Expiry Date
            <span style="font-size: 74%;opacity: 73%;">( MM/DD/YYYY )</span>
          </label>
          <date-picker v-model="expiry_date" locale="en"></date-picker>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="visa_num">
            Visa Number
          </label>
          <input type="text" class="form-control" v-model="visa_num" id="visa_num" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      passport_num: "",
      visa_num: "",
      expiry_date: ""
    };
  }
};
</script>