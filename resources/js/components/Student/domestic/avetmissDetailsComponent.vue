<template>
  <div>
    <dynamic-form
      v-bind:form-settings="makeForm"
      v-bind:form-values="getValues"
      v-bind:save-form="store_url"
    ></dynamic-form>
  </div>
</template>


<script>
import DynamicForm from "../../../components/globals/form/DynamicFormComponent.vue";

export default {
  components: {
    DynamicForm,
  },
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  },
  data() {
    return {
      student_id: window.student_id,
      csrfToken: "",
      store_url: `/student/domestic/${window.student}/avetmiss-update`,
      getValues: window.student_details,
      makeForm: [
        {
          FormTitle: "Avetmiss Details",
          FormBody: [
            // {
            //     type : 'text',
            //     lable : 'Student ID',
            //     name : 'student_id',
            //     value : 'test',
            //     avetmiss : 'required'
            // },
            // {
            //     type : 'text',
            //     lable : 'Vetrack ID',
            //     name : 'vetrack_id',
            //     value : 'test'
            // },
            // {
            //     type : 'text',
            //     lable : 'Name for Encryption',
            //     name : 'name_for_encryption',
            //     value : 'test',
            //     avetmiss : 'required'
            // },
            {
              type: "select",
              lable: "Location",
              name: "location",
              items: window.slct_state,
              value: "",
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "School Level Completed",
              name: "highest_school_level_completed_id",
              items: window.slct_schl_lvl_completed,
              value: "@@",
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "Indigenous Status",
              name: "indigenous_status_id",
              items: window.slct_indigenous_status,
              value: "@",
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "Language Identifier",
              name: "language_id",
              items: window.slct_lang_identifer,
              value: "@@@@",
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "Labour Force Status",
              name: "labour_force_status_id",
              items: window.slct_labour_force_status,
              value: "@@",
              avetmiss: "required",
            },
            {
              type: "singleselect",
              lable: "Country of Birth",
              name: "country_id",
              selections: window.slct_country,
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "Disability Flag",
              name: "disability_flag",
              items: {
                N: "NO",
                Y: "YES",
              },
              value: "N",
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "Prior Education Achievement",
              name: "prior_educational_achievement_flag",
              items: {
                N: "NO",
                Y: "YES",
              },
              value: "N",
              avetmiss: "required",
            },
            {
              type: "multiselect",
              lable: "Disability Identifier",
              name: "disability_ids",
              col_size: 6,
              selections: window.slct_disability,
              avetmiss: "required",
            },
            {
              type: "multiselect",
              lable: "Prior Education Achievement Identifier",
              name: "prior_educational_achievement_ids",
              col_size: 6,
              selections: window.slct_educ_achievement,
              avetmiss: "required",
            },
            {
              type: "select",
              lable: "At School",
              name: "at_school_flag",
              items: {
                N: "NO",
                Y: "YES",
              },
              value: "N",
              avetmiss: "required",
            },
            {
                type : 'text',
                lable : 'Year Completed',
                name : 'year_completed',
                value : '',
                col_size: 2,
            },
            {
                type : 'text',
                lable : 'Institute',
                name : 'institute',
                value : '',
                col_size: 4,
            },
            {
              type: "text",
              lable: "Unique Student ID",
              name: "unique_student_id",
              value: "test",
              avetmiss: "required",
              verified: false,
            },
            {
              type: "select",
              lable: "Survey Contact Status",
              name: "survey_contact_status",
              items: window.slct_survey_contact_status,
            },
            {
              type: "text",
              lable: "Statistical Area Level 1",
              name: "statistical_area_level_1_id",
              value: "test",
            },
            {
              type: "text",
              lable: "Statistical Area Level 2",
              name: "statistical_area_level_2_id",
              value: "test",
            },
          ],
        },
      ],
    };
  },
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