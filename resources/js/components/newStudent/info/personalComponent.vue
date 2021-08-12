<template>
  <div>
    <dynamic-form
      v-bind:form-settings="makeForm"
      v-bind:form-values="student_info"
      v-bind:save-form="store_url"
      @updateStudent="studentUpdate($event)"
    ></dynamic-form>
  </div>
</template>

<script>
import dynamicForm from "../../globals/form/new/DynamicFormComponent.vue";
import { mapGetters, mapMutations } from "vuex";
export default {
  components: { dynamicForm },
  data() {
    return {
      app_color: app_color,
      store_url: `/test/student`,
      getVaules: {},
      makeForm: [
        {
          FormTitle: "Personal Information",
          FormBody: [
            {
              type: "select",
              lable: "Prefix",
              name: "prefix",
              items: {
                "Mr.": "Mr.",
                "Ms.": "Ms.",
                "Mrs.": "Mrs.",
              },
              value: "",
            },
            {
              type: "text",
              lable: "Firstname",
              name: "firstname",
              value: "",
              avetmiss: "required",
            },
            {
              type: "text",
              lable: "Middlename",
              name: "middlename",
              value: "",
            },
            {
              type: "text",
              lable: "Lastname",
              name: "lastname",
              value: "",
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "Gender",
              name: "gender",
              items: {
                Male: "Male",
                Female: "Female",
              },
              value: "",
              avetmiss: "required",
            },
            {
              type: "datepicker",
              lable: "Date of Birth",
              name: "date_of_birth",
              value: "",
              avetmiss: "required",
            },
          ],
        },
      ],
    };
  },
  created() {
    this.student_info;
  },
  computed: {
    student_info() {
      return this.$store.getters.info;
    },
    student_id() {
      return this.$store.getters.info.student_id;
    },
  },
  methods: {
    ...mapMutations(["updateInfo"]),
    studentUpdate(e) {
      if (e.status == "success") {
        this.updateInfo(e.data);
      }
    },
  },
};
</script>

<style>
</style>