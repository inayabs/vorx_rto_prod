<template lang="">
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Training Delivery Location</h6>
            </div>
            <div class="card-body">
                <div>
                    <training-delivery-loc></training-delivery-loc>
                    <hr>
                    <v-client-table :class="'header-'+app_color" :data="deliveryLocList" :columns="columns" :options="options" ref="trainerTable">
                        <div slot="afterLimit" class="ml-2">

                        </div>
                        <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="#formsection" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                        </div>
                    </v-client-table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TrainingOrg from "../trainingOrgComponent.vue";
import TrainingDeliveryLoc from "../trainingDeliveryLocComponent.vue";
import TrainingBankDetails from "../trainingBankDetailsComponent.vue";

export default {
  components: {
    TrainingOrg,
    TrainingDeliveryLoc,
    TrainingBankDetails,
  },
  data() {
    return {
      deliveryLocList: [],
      // Vue-Tables-2 Syntax
      columns: [
        "id",
        "train_org_dlvr_loc_id",
        "train_org_dlvr_loc_name",
        'full_location',
        // "addr_location",
        // "state_id",
        // "postcode",
        "country_id",
        "actions",
      ],
      app_color: app_color,
      options: {
        initialPage: 1,
        perPage: 10,
        highlightMatches: true,
        sortIcon: {
          base: "fas",
          up: "fa-sort-amount-up",
          down: "fa-sort-amount-down",
          is: "fa-sort",
        },
        headings: {
          id: "#",
          // training_organisation_id: 'Organisation Identifier',
          train_org_dlvr_loc_id: "Delivery Location ID",
          train_org_dlvr_loc_name: "Delivery Location Name",
          full_location: "Location",
          // addr_location: "Suburb",
          // state_id: "State",
          // postcode: "Postcode",
          country_id: "Country",
          actions: "Actions",
        },
        sortable: ["id", "name"],
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords",
        },
      },
      organisation_id: window.organisation_id,
    };
  },
  created() {
    this.fetchDeliveryLoc();
    console.log(window.organisation_id);
  },
  methods: {
    fetchDeliveryLoc(page_url) {
      let vm = this;
      page_url =
        page_url ||
        `/organisation/${this.organisation_id}/delivery-location/list`;

      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          this.deliveryLocList = res.deliveryLocList;
        })
        .catch((err) => console.log(err));
    },
    edit(id) {
      axios({
        method: "get",
        url: `/organisation/${this.organisation_id}/delivery-location/show/${id}`,
      })
        .then((res) => {
          console.log(this);
          let i = this.deliveryLocList.map((item) => item.id).indexOf(id);
          console.log(i);
          // this.$parent.$children[0].$children[1].training_dlvr_location = this.$parent.$children[0].deliveryLocList[i];
          this.$parent.$children[0].$children[0].training_dlvr_location.id = this.$parent.$children[0].deliveryLocList[
            i
          ].id;
          this.$parent.$children[0].$children[0].training_dlvr_location.training_organisation_id = this.$parent.$children[0].deliveryLocList[
            i
          ].training_organisation_id;
          this.$parent.$children[0].$children[0].training_dlvr_location.train_org_dlvr_loc_id = this.$parent.$children[0].deliveryLocList[
            i
          ].train_org_dlvr_loc_id;
          this.$parent.$children[0].$children[0].training_dlvr_location.train_org_dlvr_loc_name = this.$parent.$children[0].deliveryLocList[
            i
          ].train_org_dlvr_loc_name;
          // this.$parent.$children[0].$children[1].postcode_val = res.data.postcode_val;
          this.$parent.$children[0].$children[0].training_dlvr_location.postcode =
            res.data.postcode_val;
          // this.$parent.$children[0].$children[1].training_dlvr_location.state_id = this.$parent.$children[0].deliveryLocList[i].state_id;
          // this.$parent.$children[0].$children[1].training_dlvr_location.addr_location = this.$parent.$children[0].deliveryLocList[i].addr_location;
          this.$parent.$children[0].$children[0].training_dlvr_location.country_id =
            res.data.country_val;
          this.$parent.$children[0].$children[0].training_dlvr_location.edit = 1;

          this.$parent.$children[0].$children[0].training_dlvr_location.addr_flat_unit_detail = this.$parent.$children[0].deliveryLocList[i].addr_flat_unit_detail;
          this.$parent.$children[0].$children[0].training_dlvr_location.addr_building_property_name = this.$parent.$children[0].deliveryLocList[i].addr_building_property_name;
          this.$parent.$children[0].$children[0].training_dlvr_location.addr_street_name = this.$parent.$children[0].deliveryLocList[i].addr_street_name;
          this.$parent.$children[0].$children[0].training_dlvr_location.addr_street_num = this.$parent.$children[0].deliveryLocList[i].addr_street_num;
        })
        .catch((err) => console.log(err));
    },
    remove(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          let vm = this;
          if (result.value === true) {
            axios({
              method: "delete",
              url: `/organisation/${this.organisation_id}/delivery-location/delete/${id}`,
            })
              .then((res) => {
                console.log(res);
                let i = vm.deliveryLocList.map((item) => item.id).indexOf(id); // find index of your object
                vm.deliveryLocList.splice(i, 1); // remove it from array
                if (res.data.status == "success") {
                  Toast.fire({
                    position: "top-end",
                    type: "success",
                    title: "Data is deleted successfully",
                  });
                } else {
                  Toast.fire({
                    position: "top-end",
                    type: "error",
                    title: "Opss.. data was not deleted",
                  });
                }
              })
              .catch((err) => console.log(err));
          }
        });
    },
  },
};
</script>