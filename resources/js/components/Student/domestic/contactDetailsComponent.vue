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
    DynamicForm
  },
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  },
  data() {
    return {
      contact: {
        detail: {}
      },
      student_id: window.student_id,
      csrfToken: "",
      store_url: `/student/domestic/${window.student}/contact-update`,
      getValues: window.contact,
      makeForm: [
        {
          FormTitle: "Residential Address",
          FormBody: [
            {
              type: "text",
              lable: "Unit",
              name: "addr_flat_unit_detail",
              value: "test"
            },
            {
              type: "text",
              lable: "Building Name",
              name: "addr_building_property_name",
              value: "test"
            },
            {
              type: "text",
              lable: "Street Number",
              name: "addr_street_num",
              value: "test",
              avetmiss : 'required'
            },
            {
              type: "text",
              lable: "Street Name",
              name: "addr_street_name",
              value: "test",
              avetmiss : 'required'
            },
            {
              type: "singleselect",
              lable: "Postcode - Suburb, State",
              name: "addr_suburb",
              col_size: 12,
              selections: [],
              value: "",
              avetmiss : 'required'
            },
            // {
            //   type : 'select',
            //   lable : 'Suburb Locality Town',
            //   name : 'addr_suburb',
            //   items : window.slct_postcode,
            //   value : ''
            // },
            {
              type: "text",
              lable: "Postal Delivery Box",
              name: "addr_postal_delivery_box",
              value: "test",
              col_size: 12,
            },
            
            // {
            //     type : 'text',
            //     lable : 'Suburb/CityTown',
            //     name : 'addr_suburb',
            //     value : 'test'
            // },
            
            // {
            //   type: "text",
            //   lable: "Postcode",
            //   name: "postcode",
            //   value: "test",
            //   avetmiss : 'required'
            // }
          ]
        },
        {
          FormTitle: "Contact Details",
          FormBody: [
            {
              type: "text",
              lable: "Telephone Home No.",
              name: "phone_home",
              value: "test"
            },
            {
              type: "text",
              lable: "Telephone Work No.",
              name: "phone_work",
              value: "test"
            },
            {
              type: "text",
              lable: "Telephone Mobile No.",
              name: "phone_mobile",
              value: "test"
            },
            {
              type: "text",
              lable: "Email Address",
              name: "email",
              value: "test"
            },
            {
              type: "text",
              lable: "Second Email Address",
              name: "email_at",
              value: "test"
            }
          ]
        },
        {
          FormTitle: "Emergency Contact Details",
          FormBody: [
            {
              type: "text",
              lable: "Name",
              name: "emer_name",
              value: "test"
            },
            {
              type: "text",
              lable: "Address",
              name: "emer_address",
              value: "test"
            },
            {
              type: "text",
              lable: "Telephone No.",
              name: "emer_telephone",
              value: "test"
            },
            {
              type: "text",
              lable: "Relationship",
              name: "emer_relationship",
              value: "test"
            }
          ]
        }
      ]
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      // @ dynamic form
      axios({
        method: "get",
        url: `/student/domestic/${window.student}/info`
      })
        .then(res => {
          this.makeForm[0].FormBody[4].selections = res.data.postcode;
          this.getValues.addr_suburb = res.data.suburb_val;
        })
        .catch(err => console.log(err));
    },
    saveChanges() {
      // @ dynamic form
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