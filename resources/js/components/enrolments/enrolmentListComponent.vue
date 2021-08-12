<template>
  <div>
    <verify-student v-bind="$props"></verify-student>
    <verify-initial-payment v-bind="$props"></verify-initial-payment>
    <div class="card border-0 shadow-lg">
      <div class="card-header">
        <span class="font-weight-bold h5"
          >Online Enrolment Application List</span
        >
      </div>
      <div class="card-body p-2 m-2">
        <v-server-table
          name="vue-enrolment-table"
          :class="'header-' + app_color"
          url="/enrolment-application/list"
          :columns="columns"
          ref="studentList"
          :options="options"
        >
          <!-- <div slot="afterFilter" class="VueTables__search-field ml-3">
            <label for>Filter Status :</label>
            <select class="form-control" name id v-model="filterCol" @change="cusVer($event)">
              <option value="verified">Verified</option>
              <option value="completed">Completed</option>
            </select>
          </div>-->
          <div slot="student_type" slot-scope="{ row }">
             <span v-if="row.student_type != 1">
              Domestic
              <br />
            </span>
            <span v-else>
              International
              <br />
            </span>
          </div>
          <div slot="course" slot-scope="{ row }">
            <span v-if="row.enrolment_form.course != undefined">
              {{ row.enrolment_form.course.name }}
              <br />
            </span>
            <span
              v-for="(unit, index) in row.enrolment_form.units"
              :key="index"
            >
              {{ unit.description }}
              <br />
            </span>
          </div>
          <div class="btn-group" slot="enrolment_type" slot-scope="{ row }">
            <select
              class="form-control"
              name
              id
              v-model="e_type[row.process_id]"
              @change="changeFunding(row)"
            >
              <option value="Funding">Funding</option>
              <option value="Full Fee">Full Fee</option>
            </select>
          </div>
          <div class="btn-group" slot="created" slot-scope="{ row }">
            {{ row.created_at | dateformat }}
          </div>
          <div class="btn-group" slot="actions" slot-scope="{ row }">
            <a
              v-if="row.status != 'verified'"
              :href="`/enrolment-application/${row.id}`"
              class="btn btn-primary btn-sm"
              title="Verify Application"
            >
              <i class="far fa-sticky-note"></i>
            </a>

            <a
              v-if="row.status != 'verified'"
              href="javascript:void(0)"
              class="btn btn-primary btn-sm"
              @click="verify(row, row.offer_sig_agreement)"
              title="Verify Application"
            >
              <i class="fas fa-check"></i>
            </a>

            <a
              href="javascript:void(0)"
              class="btn btn-info btn-sm"
              @click="view(row)"
              title="View Form"
            >
              <i class="fas fa-eye"></i>
            </a>
            <a
              href="javascript:void(0)"
              class="btn btn-success btn-sm"
              @click="generate(row)"
              title="Generate PDF"
            >
              <i class="far fa-file-pdf"></i>
            </a>
            <a
              v-if="row.status == 'verified'"
              href="javascript:void(0)"
              class="btn btn-success btn-sm"
              @click="linkattachment(row)"
              title="Link Attachment"
            >
              <i class="fas fa-paperclip"></i>
            </a>
            <a
              href="javascript:void(0)"
              class="btn btn-success btn-sm"
              @click="viewattachment(row)"
              title="View Attachment"
            >
              <i class="fas fa-eye"></i>
            </a>
          </div>
        </v-server-table>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import verifyStudent from "./verifyEnrolmentComponent.vue";
import verifyInitialPayment from "./VerifyInitialPaymentReceiptComponent.vue";
export default {
  props: ["app_name"],
  components: {
    verifyStudent,
    verifyInitialPayment,
  },
  data() {
    return {
      app_color: app_color,
      e_type: {},
      filterCol: "",
      columns: [
        "id",
        "process_id",
        "student_type",
        "student_name",
        "course",
        "enrolment_type",
        "status",
        "created",
        "actions",
      ],
      options: {
        customFilters: [
          {
            name: "filterByBrand",
            callback: function (row, query) {
              console.log(row);
              console.log(query);
              return row.brand === query;
            },
          },
        ],
        requestFunction: function (data) {
          console.log(data);
          // console.log(this.url);
          return axios
            .get(this.url, {
              params: data,
            })
            .catch(
              function (e) {
                this.dispatch("error", e);
              }.bind(this)
            );
        },
        requestAdapter(data) {
          // console.log(data);
          // console.log(data.limit);
          return {
            sort: data.orderBy ? data.orderBy : "id",
            direction: data.ascending ? "desc" : "asc",
            page: data.page ? data.page : "page",
            limit: data.limit ? data.limit : "10",
            search: data.query ? data.query : null,
          };
        },
        responseAdapter({ data }) {
          // console.log(data.data);
          return {
            data: data.data,
            count: data.total,
          };
        },
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
          process_id: "Process ID",
          student_name: "Student Name",
          course: "Course / Units",
          enrolment_type: "Type",
          status: "Status",
          created: "Created",
          // application_type: "Application Type",
          actions: "Actions",
        },
        sortable: ["process_id", "student_name", "status"],
        rowClassCallback(row) {
          return (row.id = row.id);
        },
        columnClasses: { id: "class-is" },
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords",
        },
      },
    };
  },
  created() {
    this.e_type = window.list;
  },
  methods: {
    cusVer() {
      Event.$emit("server-tables.loaded", function (data) {
        console.log(data);
      });
    },
    changeFunding(data) {
      let vm = this;
      console.log(vm.e_type[data.process_id]);
      swal.fire({
        title: "Changing Enrolment Type..",
        // html: '',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          swal.showLoading();
        },
      });

      axios
        .post("/enrolment-application/change-enrolment-type", {
          type: vm.e_type[data.process_id],
          row: data,
        })
        .then(function (r) {
          console.log(r);
          if (r.data.status == "success") {
            Toast.fire({
              position: "top-end",
              type: "success",
              title: "Enrolment Type Changes Successfully",
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    linkattachment(row) {
      axios
        .get(`enrolment-application/attachment/${row.process_id}`)
        .then(function (r) {
          console.log(r);
          if (r.data.status == "success") {
            Toast.fire({
              position: "top-end",
              type: "success",
              title: r.data.message,
            });
          } else {
            Toast.fire({
              position: "top-end",
              type: "error",
              title: r.data.message,
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    verify(data, agreement) {
      if (agreement == 0) {
        this.$modal.show("size-modal", data);
      } else {
        this.$modal.show("size-verify-initial-payment", data);
      }
      // axios
      //   .post("/enrolment-application", { verify: data })
      //   .then(res => {
      //     console.log(res);
      //   })
      //   .catch(err => {
      //     console.log(err);
      //   });
    },
    viewattachment(data) {
      if (this.app_name != "Phoenix") {
        window.open(`/online-enrolment/process/${data.process_id}`, "_blank");
      } else {
        if(data.student_type == 2){
          window.open(
            `/pca/online-enrolment/domestic/process/${data.process_id}`,
            "_blank"
          );
        }else{
          window.open(
            `/pca/online-enrolment/process/${data.process_id}`,
            "_blank"
          );

        }
      }
      // window.open(`/pca/online-enrolment/process/${data.process_id}`, "_blank");
    },
    view(data) {
      // window.location.href = `/online-enrolment/get/${data.process_id}`;
      console.log(data);
      if (this.app_name != "Phoenix") {
        if(data.student_type == ''){
        window.open(`/online-enrolment/get/${data.process_id}`, "_blank");
        }else if(data.student_type == 2){
        window.open(`/online-enrolment/get/${data.process_id}`, "_blank");
        } 
        else{
          window.open(`/international/online-enrolment/get/${data.process_id}`, "_blank");
        }
      } else {
        if(data.student_type == 2){
          window.open(`/pca/online-enrolment/domestic/get/${data.process_id}`, "_blank");
        }else{
          window.open(`/pca/online-enrolment/get/${data.process_id}`, "_blank");
        }
      }
    },
    generate(data) {
      if (this.app_name != "Phoenix") {
        window.open(`/online-enrolment/pdf/${data.process_id}`, "_blank");
      } else {
        if(data.student_type == 2){
          window.open(`/pca/online-enrolment/domestic/pdf/${data.process_id}`, "_blank");
        }else{
          window.open(`/pca/online-enrolment/pdf/${data.process_id}`, "_blank");
        }
      }
    },
  },
  watch: {},
  filters: {
    dateformat(value) {
      return moment(value).format("DD/MM/YYYY");
    },
  },
};
</script>