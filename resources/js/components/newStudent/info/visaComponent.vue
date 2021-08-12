<template>
  <div>
    <dynamic-form 
        v-bind:form-settings='makeForm' 
        v-bind:form-values='visa'
        v-bind:save-form='store_url'
        ></dynamic-form>
  </div>
</template>

<script>
import dynamicForm from "../../globals/form/new/DynamicFormComponent.vue";
import { mapGetters, mapMutations } from "vuex";
export default {
  components : {dynamicForm},
  data() {
    return {
      app_color: app_color,
      store_url: `/test/student/visa`,
      makeForm : [{
          FormTitle : 'Residency & Visa Information',
          FormBody : [
              {
                  type : 'text',
                  lable : 'Nationality',
                  name : 'nationality',
                  value : ''
              },
              {
                  type : 'text',
                  lable : 'Passport No.',
                  name : 'passport_number',
                  value : ''
              }, 
              {
                  type : 'datepicker',
                  lable : 'Issue Date',
                  name : 'issue_date',
                  value : '',
              }, 
              {
                  type : 'datepicker',
                  lable : 'Expiry Date',
                  name : 'expiry_date',
                  value : '',
              },               
          ]
      },
      {
          FormTitle: "If not Australian Citizen",
          FormBody: [
              {
                  type : 'singleselect',
                  lable : 'Visa Type',
                  name : 'visa_type',
                  selections: window.visa,
                  col_size: 12
              },
              // {
              //     type : 'text',
              //     lable : 'Sub Class',
              //     name : 'subclass',
              //     value : '',
              // },
              {
                  type : 'datepicker',
                  lable : 'Expiry Date',
                  name : 'expiry_date_visa_type',
                  value : '',
              },
              {
                  type : 'select',
                  lable : 'Applied for Australian Permanent Residency',
                  name : 'applied_for_au_residency',
                  value : 'No',
                  items: {
                      No: "NO",
                      Yes: "YES"
                  },
              }, 
              {
                  type : 'select',
                  lable : 'Study Rights',
                  name : 'study_rights',
                  value : 'No',
                  items: {
                      No: "NO",
                      Yes: "YES"
                  },
              }, 
              ]
          }
      ],
    };
  },
  computed: {
    visa(){
      return this.$store.getters.visa;
    }
  },
};
</script>

<style>
</style>