<template lang="">
    <div>
            <div class="row">
                <div class="col-lg-12">
                    <v-client-table :class="'header-'+app_color" :data="warningHistoryList" :columns="columns" :options="options" ref="templateTable">
                            <div class="btn-group" slot="actions" >
                                <a href="#directEdit" class="btn btn-primary btn-sm" > <i class="fas fa-edit"> </i></a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"> </i></a>
                            </div>
                            <!-- <span slot="active" slot-scope="{row}" :class="'badge '+[row.active? 'badge-success' : 'badge-danger']">{{ row.active? 'Active' : 'Inactive' }}</span> -->
                    </v-client-table>
                </div>
            </div>
    </div>
</template>
<script>
export default {
  data(){
      return {
          app_color: app_color,
          warningHistoryList : [],
          // Vue-Tables-2 Syntax
            columns: ['id', 'email_template_type', 'date_sent', 'course_code'],
            options: {
                initialPage:1,
                perPage:10,
                highlightMatches:true,
                sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                headings: {
                    id: '#',
                    email_template_type: 'Warning Letter Type',
                    date_sent: 'Date Sent',
                    course_code: 'Course Code'
                },
                sortable: ['id','created_at'],
                // rowClassCallback(row) {
                //     return row.id = row.id;
                // },
                columnClasses: {id: 'class-is'},
                texts: {
                    filter: "Search:",
                    filterPlaceholder: "Search keywords",
                }
            },
      }
  },
    created() {
    this.fetchData();
  },
  methods : {
      fetchData(){
      axios({
        method: "get",
        url: `/student/warning-letters/${student_id}`
      })
      .then(res => {
          let vm = this;
          vm.warningHistoryList = res.data.warningHistory;
      })
      .catch(err => console.log(err));
      }
  }
}
</script>