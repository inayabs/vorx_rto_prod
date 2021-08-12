<template>
        <div class="btn-group" role="group">
          <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Action
          </button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
            <h6 class="dropdown-header">Send Warning Letter</h6>
            <a class="dropdown-item" href="#">Dropdown link</a>
            <a class="dropdown-item" href="#">Dropdown link</a>
            <h6 class="dropdown-header">View Warning Letter</h6>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </div>
</template>


<script>
export default {
  props: {
    formSettings: Array,
    formValues: Object,
    saveForm: String
  },
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  },
  data() {
    return {
      inputs: this.formValues,
      csrfToken: "",
      rowCount: 1,
      errors: []
    };
  },
  created() {
    this.fetchData();
    // console.log(this.errors);
  },
  methods: {
    fetchData() {
      // console.log(this.formSettings);
      // console.log(this.inputs);
      // // console.log(course_id);
      // axios({
      //     method: 'get',
      //     url: '/agent/show/info/'+ this.agent_id
      // })
      // .then(res => {
      //     this.agent = res.data;
      // })
      // .catch(err => console.log(err));
    },
    saveChanges() {
      console.log(this.inputs);
      let inputs = this.inputs;
      if (inputs.date_of_birth != null) {
        inputs.date_of_birth = moment(inputs.date_of_birth).format(
          "YYYY-MM-DD"
        );
      }
      if (inputs.start_date != null) {
        inputs.start_date = moment(inputs.start_date).format("YYYY-MM-DD");
      }
      if (inputs.end_date != null) {
        inputs.end_date = moment(inputs.end_date).format("YYYY-MM-DD");
      }
      console.log(this.saveForm);
      // alert(this.csrfToken);

      axios
        .post(this.saveForm, {
          inputs: inputs,
          _token: this.csrfToken
        })
        .then(res => {
          console.log(res);
          if (res.data.status == "updated") {
            // UPDATE ONLY DATA
            Toast.fire({
              // position: 'top-end',
              type: "success",
              title: "Changes saved successfully"
            });
            this.$emit("updateCourse", "updated");
            this.agent = res.data.agent;
            if (inputs.date_of_birth != null) {
              inputs.date_of_birth = moment(inputs.date_of_birth)._d;
            }
            if (inputs.start_date != null) {
              inputs.start_date = moment(inputs.start_date)._d;
            }
            if (inputs.end_date != null) {
              inputs.end_date = moment(inputs.end_date)._d;
            }
          } else if (res.data.status == "success"){
            // ADD NEW DATA
            this.inputs = '';
            Toast.fire({
              // position: 'top-end',
              type: "success",
              title: "Data saved successfully"
            });
            this.$emit("updateCourse", "updated");
            this.agent = res.data.agent;
            if (inputs.date_of_birth != null) {
              inputs.date_of_birth = moment(inputs.date_of_birth)._d;
            }
            if (inputs.start_date != null) {
              inputs.start_date = moment(inputs.start_date)._d;
            }
            if (inputs.end_date != null) {
              inputs.end_date = moment(inputs.end_date)._d;
            }
          }else if (res.data.status == "errors") {
            Toast.fire({
              // position: 'top-end',
              type: "error",
              title: "All fields are required!"
            });
          } else {
            Toast.fire({
              // position: 'top-end',
              type: "error",
              title: "Opss.. was not saved successfully"
            });
          }
        })
        .catch(err => console.log(err));
    }
  }
};
</script>

<style>
.tab-pane {
  border: 1px solid #e0dfdf;
  border-top: none;
  padding: 1.3rem;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
  background-color: #ffffff;
}
</style>