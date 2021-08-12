<template>
  <div>
    <div v-if="this.$store.getters.enrolment[this.$attrs.index].offer_letter == null">walay operleter. hihi</div>
    <div v-else>
        <div class="row mb-3">
          <div class="col-md-12 pull-right text-right">
            <button :disabled="roles == 'Staff'? true : false "  class="btn btn-success" @click="saveChanges()">
              <i class="far fa-save"></i> Update Changes
            </button>
          </div>
      </div>
      <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
        <h6>Student Information</h6>
      </div>
      <student-info></student-info>
      <div class="clearfix mb-3"></div>
      <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
        <h6>Address / Contact Information</h6>
      </div>
      <address-contact-info></address-contact-info>
      <div class="clearfix mb-3"></div>
      <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
        <h6>Passport Information</h6>
      </div>
       <passport-info></passport-info>
      <div class="clearfix mb-5"></div>
      <div v-bind:class="'horizontal-line-wrapper-' + app_color + ' mb-2'">
        <h6>Package Information</h6>
      </div>
      <package-info ref="packageInfo"></package-info>
    </div>
  </div>
</template>

<script>
import studentInfo from './studentInfoComponent.vue'
import addressContactInfo from './addressContactInfoComponent.vue'
import passportInfo from './passportComponent.vue'
import packageInfo from './packageInfoComponent.vue'
export default {
  components : { studentInfo, addressContactInfo, passportInfo , packageInfo },
  data() {
    return {
      app_color : app_color,
      roles : null
    }
  },
  mounted(){
    if(this.$root.$refs.studentbase != undefined){
      this.roles = this.$root.$refs.studentbase.urole;
    }
  },
  methods: {
    saveChanges(){
      // alert('hi');
      let index = this.$attrs.index;
      let offer_letter = this.$store.getters.enrolment[index].offer_letter;
      let student_info = offer_letter.student_details;
      let packageInfo = this.$refs.packageInfo
      // console.log(offer_letter);
      student_info.reference_id = offer_letter.reference_id;
      student_info.issued_date = offer_letter.issued_date;
      student_info.package_structure = packageInfo.course_package_structure;
      student_info.package_structure = packageInfo.course_package_structure;
      student_info.courseInfo = {};
      student_info.courseInfo.package_id = packageInfo.package_id;
      student_info.remarks = packageInfo.remarks;
      student_info.courseInfo.non_package_id = packageInfo.non_package_id;
      student_info.courseInfo.package_type = packageInfo.package_type;
      student_info.courseInfo.courseInfo = packageInfo.shore_type;
      student_info.courseInfo.selected_package = packageInfo.selected_package;
      console.log(student_info);
      // delete student_info.created_at;
      // delete student_info.updated_at;
      // delete student_info.deleted_at;

       axios.put(
          "/offer-letter/" + student_info.offer_letter_id,
          JSON.stringify(student_info),
          {
            headers: {
              "content-type": "application/json",
            },
          }
        )
        .then((res) => {
          if (res.data.status == "success") {
            swal.fire({
              type: "success",
              title: "Update Successfuly",
            });
            this.$emit("checkpaymentHistory", true);
            this.update = false;
          } else {
            swal.fire({
              type: "error",
              title: "Failed to Update student",
            });
          }
          // console.log(res);
        })
        .catch((err) => {
          swal.fire({
            type: "error",
            title: "Failed to Update student",
          });
        });

    }
  },
}
</script>

<style>

</style>
