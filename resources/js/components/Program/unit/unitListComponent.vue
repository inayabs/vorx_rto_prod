<template lang="">
    <div>
        <create-unit/>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Unit List</h6>
            </div>
            <div class="card-body">
                <div>
                    
                    <!-- <v-client-table :class="'header-'+app_color" :data="units_list" :columns="columns" :options="options" ref="unitTable">

                        <div slot="afterLimit" class="ml-2">

                            <div class="btn-group">
                                <a href="javascript:void(0)" @click="showCreateUnit"  class="btn btn-success"><i class="fas fa-plus"></i> Add Unit</a>
                            </div>

                        </div>

                        <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                        </div>

                    </v-client-table> -->
                    <v-server-table
                        :class="'header-'+app_color"
                        url="units/list"
                        :columns="columns"
                        ref="unitList"
                        :options="options"
                    >
                      <div slot="afterLimit" class="ml-2">
                        <div class="btn-group">
                            <a href="javascript:void(0)" @click="showCreateUnit"  class="btn btn-success"><i class="fas fa-plus"></i> Add Unit</a>
                        </div>
                      </div>
                       <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                        </div>
                    </v-server-table>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import CreateUnit from "./createUnitComponent.vue";

export default {
  name: "unitList",
  components: {
    CreateUnit
  },
  data() {
    return {
      app_color: app_color,
      units_list: [],
      // Vue-Tables-2 Syntax
      columns: ["code", "description", "actions"],
      options: {
        requestFunction: function(data) {
          // console.log(data);
          // console.log(this.url);
          return axios
            .get(this.url, {
              params: data
            })
            .catch(
              function(e) {
                this.dispatch("error", e);
              }.bind(this)
            );
        },
        requestAdapter(data) {
          // console.log(data);
          return {
            sort: data.orderBy ? data.orderBy : "code",
            direction: data.ascending ? "asc" : "desc",
            page: data.page ? data.page : "page",
            limit: data.limit ? data.limit : "10",
            search: data.query ? data.query : null
          };
        },
        responseAdapter({ data }) {
          // console.log(data);
          return {
            data: data.data,
            count: data.total
          };
        },
        initialPage: 1,
        perPage: 10,
        perPageValues: [10, 25, 50, 100],
        highlightMatches: true,
        sortIcon: {
          base: "fas",
          up: "fa-sort-amount-up",
          down: "fa-sort-amount-down",
          is: "fa-sort"
        },
        headings: {
          code: "Unit Code",
          description: "Unit Description",
          // unit_type: 'Unit Type',
          actions: "Actions"
        },
        sortable: ["code", "description"],
        rowClassCallback(row) {
          return (row.id = row.id);
        },
        columnClasses: { id: "class-is" },
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords"
        }
      },
      isHidden: false
      /* options: {
        initialPage: 1,
        perPage: 10,
        highlightMatches: true,
        sortIcon: {
          base: "fas",
          up: "fa-sort-amount-up",
          down: "fa-sort-amount-down",
          is: "fa-sort"
        },
        headings: {
          code: "Unit Code",
          description: "Unit Description",
          // unit_type: 'Unit Type',
          actions: "Actions"
        },
        sortable: ["code", "description"],
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords"
        }
      }, */
    };
  },
  created() {
    // this.getUnitList();
  },
  methods: {
    getUnitList() {
      axios.get("/units/list").then(response => {
        this.units_list = response.data;
      });
    },
    showCreateUnit() {
      this.$modal.show("size-modal");
    },
    edit(units_listId) {
      window.location.href = "/unit/" + units_listId + "/edit/";
    },
    remove(units_listId) {
      let vm = this;
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            axios({
              method: "get",
              url: "/unit/delete/" + units_listId
            }).then(response => {
              swal.fire("Deleted!", "Unit has been deleted.", "success");
              vm.$refs.unitList.refresh();
            });
          }
        });
    }
  }
};
</script>