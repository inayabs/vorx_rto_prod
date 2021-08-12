<template>
  <div>
    <dynamic-form
      v-bind:form-settings="makeForm"
      v-bind:form-values="contact_details"
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
      store_url: `/test/student/contact`,
      makeForm: [
        {
          FormTitle: "Residential Address",
          FormBody: [
            {
              type: "text",
              lable: "Unit",
              name: "addr_flat_unit_detail",
              value: "test",
            },
            {
              type: "text",
              lable: "Building Name",
              name: "addr_building_property_name",
              value: "test",
            },
            {
              type: "text",
              lable: "Street Number",
              name: "addr_street_num",
              value: "test",
              avetmiss: "required",
            },
            {
              type: "text",
              lable: "Street Name",
              name: "addr_street_name",
              value: "test",
              avetmiss: "required",
            },
            {
              type: "singleselect",
              lable: "Postcode - Suburb, State",
              name: "addr_suburb",
              col_size: 12,
              selections: window.slct_postcode,
              value: "",
              avetmiss: "required",
            },
            {
              type: "text",
              lable: "Postal Delivery Box",
              name: "addr_postal_delivery_box",
              value: "test",
              col_size: 12,
            },
          ],
        },
        {
          FormTitle : "Home Country",
          FormBody  : [
             {
               type : "text",
               lable : "Residential Address",
               name : "home_address",
               value : 'text',
               col_size : 12
             }
          ]
        },
        {
          FormTitle: "Contact Details",
          FormBody: [
            {
              type: "text",
              lable: "Telephone Home No.",
              name: "phone_home",
              value: "test",
            },
            {
              type: "text",
              lable: "Telephone Work No.",
              name: "phone_work",
              value: "test",
            },
            {
              type: "text",
              lable: "Telephone Mobile No.",
              name: "phone_mobile",
              value: "test",
            },
            {
              type: "text",
              lable: "Email Address",
              name: "email",
              value: "test",
            },
            {
              type: "text",
              lable: "Second Email Address",
              name: "email_at",
              value: "test",
            },
          ],
        },
        {
          FormTitle: "Emergency Contact Details",
          FormBody: [
            {
              type: "text",
              lable: "Name",
              name: "emer_name",
              value: "test",
            },
            {
              type: "text",
              lable: "Address",
              name: "emer_address",
              value: "test",
            },
            {
              type: "text",
              lable: "Telephone No.",
              name: "emer_telephone",
              value: "test",
            },
            {
              type: "text",
              lable: "Relationship",
              name: "emer_relationship",
              value: "test",
            },
          ],
        },
      ],
    };
  },
  computed: {
    contact_details(){
      return this.$store.getters.contact;
    }
  },
  methods: {
    ...mapMutations(['updateContactInfo']),
    studentUpdate(e) {
      if (e.status == "success") {
        this.updateContactInfo(e.data);
      }
    },
  },
};
</script>

<style>
</style>