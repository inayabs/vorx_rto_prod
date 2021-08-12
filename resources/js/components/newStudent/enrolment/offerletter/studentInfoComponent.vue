<template>
  <div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="student_id">Student ID</label>
          <input
            type="text"
            ref="student_id"
            v-model="student_id"
            class="form-control"
            id="student_id"
          />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="student_type">Student Type</label>
          <input
            type="text"
            disabled
            v-model="student_type"
            class="form-control"
            id="student_type"
          />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="country_of_birth">Country of Birth</label>
          <select
            name="country_of_birth"
            v-model="student_details.country_birth"
            id="country_of_birth"
            class="form-control"
          >
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
          <label for="issue_date">Date Issued</label>
          <date-picker :max-date="new Date()" v-model="offer_data.issued_date" locale="en"></date-picker>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="reference_id">Reference Id</label>
          <input type="text" disabled v-model="offer_data.reference_id" class="form-control" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="agency_name">Agent</label>
          <!-- <input type="text" v-model="agent" class="form-control" id="agent" /> -->
          <select name="student_type" v-model="agent" id="agent" class="form-control">
            <option v-if="agents.length == 0" value>NONE</option>
            <option v-for="agent in agents" :key="agent.id" :value="agent.id">{{ agent.agent_name}}</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment';
export default {
  created() {
    if (window.student_id == null) {
      this.student_id = `ETI${window.student}`;
    } else {
      this.student_id = window.student_id;
    }
  },
  data() {
    return {
      refe: "",
      student_id: "",
      student_type: window.student_type,
      country_of_birth: "",
      reference_id: "",
      agent: "",
      agents : window.agents,
      countries : window.slct_country
      // agents: window.agents,
    };
  },
  computed: {
    offer_data(){
       let index = this.$parent.$attrs.index;
       this.$store.getters.enrolment[index].offer_letter.issued_date = moment(this.$store.getters.enrolment[index].offer_letter.issued_date)._d
      return this.$store.getters.enrolment[index].offer_letter;
    },
    student_details(){
      let index = this.$parent.$attrs.index;
      return this.$store.getters.enrolment[index].offer_letter.student_details;
    }
  },
};
</script>