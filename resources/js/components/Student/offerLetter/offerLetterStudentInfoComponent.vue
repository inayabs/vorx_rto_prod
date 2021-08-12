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
          <select
            name="student_type"
            v-model="student_type"
            id="student_type"
            disabled
            class="form-control"
          >
            <option v-for="type in types" :key="type.id" :value="type.id">{{ type.type}}</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="country_of_birth">Country of Birth</label>
          <select
            name="country_of_birth"
            v-model="country_of_birth"
            id="country_of_birth"
            class="form-control"
          >
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
          <label for="issue_date">Date Issued</label>
          <date-picker :max-date="new Date()" :masks="{ L: 'DD/MM/YYYY' }" v-model="issue_date" locale="en"></date-picker>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="reference_id">Reference Id</label>
          <input type="text" disabled v-model="reference_id" class="form-control" />
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
export default {
  props: ["types", "countries", "states", "agents", "refs"],
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
      issue_date: "",
      reference_id: "",
      agent: "",
      // agents: window.agents,
    };
  },
};
</script>