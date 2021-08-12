<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="passport_number">Passport Number</label>
          <input type="text" class="form-control" v-model="student_details.passport_no" id="passport_number" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="passport_number">
            Expiry Date
            <span style="font-size: 74%;opacity: 73%;">( MM/DD/YYYY )</span>
          </label>
          <date-picker v-model="student_details.passport_exp_date" locale="en"></date-picker>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="visa_num">
            Visa Number
          </label>
          <input type="text" class="form-control" v-model="student_details.visa_no" id="visa_num" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment';
export default {
  computed: {
    student_details(){
      let index = this.$parent.$attrs.index;
      this.$store.getters.enrolment[index].offer_letter.student_details.passport_exp_date = moment(this.$store.getters.enrolment[index].offer_letter.student_details.passport_exp_date)._d
      return this.$store.getters.enrolment[index].offer_letter.student_details;
    }
  },
};
</script>