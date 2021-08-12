<template>
  <div class="row mb-3">
    <div class="col-md-12 pull-right text-right">
      <button v-if="edit_status" class="btn btn-success" @click="getLatest()">
        <i class="far fa-save"></i> Cancel Changes
      </button>
      <button class="btn btn-success" @click="generateCert()">
        <i class="far fa-save"></i> Generate
      </button>
      <button class="btn btn-success" @click="saveChanges()">
        <i class="far fa-save"></i> Update Changes
      </button>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
      <table class="table responsive-table mt-3">
        <thead>
          <tr>
            <th>#</th>
            <th>Code</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reissued</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(unit, index) in extra_unit.units" :key="unit.id">
            <td>{{ index+1 }}</td>
            <td>{{ unit.code }}</td>
            <td>{{ unit.description }}</td>
            <td>
              <date-picker
                :popover="{ placement: 'bottom', visibility: 'click' }"
                v-model="unit.start_date"
                locale="en"
                :masks="{L:'DD/MM/YYYY'}"
              ></date-picker>
            </td>
            <td>
              <date-picker
                :popover="{ placement: 'bottom', visibility: 'click' }"
                v-model="unit.end_date"
                locale="en"
                :masks="{L:'DD/MM/YYYY'}"
              ></date-picker>
            </td>
            <td></td>
            <td>
              <select v-model="unit.status" class="form-control">
                <option
                  v-for="(status) in statuses"
                  :key="status.id"
                  :value="status.id"
                >{{ status.status }}</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import moment from "moment";
export default {
  props: ["extra_unit", "edit_status", "edit_id"],
  mounted() {
    // this.extraUnit = this.extra_unit;
    // console.log(this.extra_unit);
  },
  data() {
    return {
      statuses: window.statuses
    };
  },
  methods: {
    getLatest() {
      this.$emit("updateData", "success");
    },
    saveChanges() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      const loadingSwal = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false
      });
      loadingSwal.fire({
        type: "info",
        title: "Please Wait ..."
      });
      let data = this.extra_unit;
      let vm = this;

      if (vm.edit_status) {
        axios
          .put(`/course_completion/update/units/${vm.extra_unit.unit_id}`, data)
          .then(response => {
            if (response.data.status == "success") {
              Toast.fire({
                type: "success",
                title: response.data.message
              });
              vm.$emit("updateData", "success");
              vm.$emit("generate", "success");
            } else {
              Toast.fire({
                type: "error",
                title: response.data.message
              });
            }
          })
          .catch(err => {
            console.log(err);
          });
      } else {
        axios
          .post("/course_completion/extraUnit", data)
          .then(res => {
            if (res.data.status == "success") {
              Toast.fire({
                type: "success",
                title: res.data.message
              });
              vm.$emit("updateData", "success");
            } else {
              Toast.fire({
                type: "error",
                title: res.data.message
              });
            }
          })
          .catch(err => {
            console.log(err);
          });
      }
    },
    generateCert() {
      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });
      let vm = this;
      let data = this.extra_unit;
      axios
        .post(
          `/certificate_issuance/generate/extraUnit/${window.student.id}`,
          data
        )
        .then(res => {
          if (res.data.status == "success") {
            Toast.fire({
              type: "success",
              title: res.data.message
            });
            vm.$emit("generate", "success");
            vm.$emit("updateData", "success");
          } else {
            Toast.fire({
              type: "error",
              title: res.data.message
            });
          }
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>