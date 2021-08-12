<template>
  <div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">Attendance List</h6>
         </div>
        <div class="card-body">
            <div>
                <!-- <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                    <h6>Date Range</h6>
                </div> -->
                <div class="clearfix"></div>
                <div class="form-padding-left-right">
                    <div class="row">
                        <div class="col-md-12">
                            <form @submit.prevent>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="year">Class:</label>
                                        <multiselect
                                            :options="class_list"
                                            v-model="selected_class"
                                            trackBy="id"
                                            :custom-label="className"
                                        >
                                            
                                        </multiselect>
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="year">Student Type:</label>
                                        <select name="" id="" v-model="student_type" class="form-control">
                                            <option value="*">All</option>
                                            <option value="2">Domestic</option>
                                            <option value="1">International</option>
                                        </select>
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="clearfix" style="height: 22px;"></div>
                                        <button @click="resetFields" :class="'btn btn-warning'" title="Reset Fields"><i class="fa fa-rotate-left"></i></button>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="month">Start date: <span class="badge"></span></label>
                                        <date-picker :masks="{ L: 'DD/MM/YYYY' }" locale="en" v-model="from" ></date-picker>
                                        <!-- <select id="month" class="form-control">
                                            <option value="01-03">Jan - Mar</option>
                                            <option value="01-06">Jan - Jun</option>
                                            <option value="01-09">Jan - Sep</option>
                                            <option value="01-12">Jan - Dec</option>
                                        </select> -->
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="year">End date: <span class="badge"></span></label>
                                        <date-picker :masks="{ L: 'DD/MM/YYYY' }" locale="en" v-model="to" ></date-picker>
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="clearfix" style="height: 22px;"></div>
                                        <button type="submit" @click="generateList" :class="'btn btn-'+app_color">Generate</button>
                                    </div>
                                </div>
                            </form>
                        </div>  
                    </div>
                </div>
                <v-client-table :class="'header-'+app_color" :data="attendances" :columns="columns" :options="options" ref="courseTable"> 
                        <div slot="afterLimit" class="ml-2">
                            <div class="btn-group">
                                <!-- <a href="javascript:void(0)"  @click="showCreateCourse" class="btn btn-success" slot="afterLimit"><i class="fas fa-plus"></i> Add Course</a> -->
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export to
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" @click="exportExcel"><i class="far fa-file-excel text-success"></i>&nbsp; Excel</a>
                                    <!-- <form method="post" action="/reports/attendance/export-pdf" target="_blank" id="form">
                                        <input type="hidden" v-model="attendances"> -->
                                        <a class="dropdown-item" href="#" @click="exportPdf"><i class="far fa-file-pdf text-danger"></i>&nbsp; Pdf</a>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                        <div slot="profile_image" slot-scope="{row}">
                            <img class="img-fluid" :src="'/storage/user/avatars/'+getImage(row.user)" alt="Preview not avail">
                            <!-- <img class="rounded-circle img-fluid" :src="'/storage/user/avatars/'+getImage(sl.user)" alt="Preview not avail" style="width:100%;"> -->
                        </div>
                        <div slot="hours" slot-scope="{row}">
                            <div class="progress" v-if="toType(row.percent_actual_hours)!='undefined'">
                                <template v-if="row.percent_actual_hours == 0">
                                    <div :class="'progress-bar bg-'+progress_color(row.percent_actual_hours)" role="progressbar" style="width:100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" :title="'0/'+row.pref_hours+' hours'"></div>
                                </template>
                                <template v-else-if="row.percent_actual_hours>100">
                                    <div :class="'progress-bar bg-'+progress_color(row.percent_actual_hours)" role="progressbar" :style="'width:'+row.percent_actual_hours+'%'" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" :title="row.actual_hours+'/'+row.pref_hours+' hours'">{{row.percent_actual_hours.toFixed(1)}}%</div>
                                </template>
                                <template v-else>
                                    <div :class="'progress-bar bg-'+progress_color(row.percent_actual_hours)" role="progressbar" :style="'width:'+row.percent_actual_hours+'%'" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" :title="row.actual_hours+'/'+row.pref_hours+' hours'">{{row.percent_actual_hours.toFixed(1)}}%</div>
                                    <div class="progress-bar bg-gray" role="progressbar" :style="'width:'+ (100 - row.percent_actual_hours)+'%'" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" :title="row.actual_hours+'/'+row.pref_hours+' hours'"></div>
                                </template>
                            </div>
                            <div v-else>
                                No Attendance yet
                            </div>
                        </div>
                </v-client-table>
            </div>
        </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment'
// import CreateOfferLetter from "./createOfferLetterComponent.vue";
export default {
  name: "app-modal",
  mounted() {
    // console.log("hello");
  },
  components: {
    // CreateOfferLetter
  },
  data() {
    return {
      class_list:classes?classes:[],
      student_list: [],
      attendances:[],
      app_color: app_color,
      from: null,
      to: null,
      selected_class:'',
      student_type: '*',
      get_course: '*',
      get_status: '*',
      get_agent: '*',
      statuses: [],
      agents: window.agents,
      courses: window.courses,
      columns: ["profile_image","student.party.name","student_id","hours"],
      options: {
            orderBy:{
                column:'student.party.name',
                ascending:true
            },
            initialPage:1,
            perPage:10,
            highlightMatches:true,
            sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
            headings: {
                'student.party.name':'Student Name',
            },
            // sortable: ["Student ID", "Given Name", "Last Name", "Date of Birth","USI","Course Code", "Course Name","Start Date", "End Date"],
            rowClassCallback(row) {
                return row.id = row.id;
            },
            columnClasses: {id: 'class-is'},
            texts: {
                filter: "Search:",
                filterPlaceholder: "Search keywords",
            }
      },
    };
  },
  created() {
    // this.fetchStudents();
  },
  methods: {
      progress_color(percent){
          if(percent>=100){
              return 'success';
          }else if(percent>80 && percent<100){
              return 'warning';
          }else{
              return 'danger';
          }
      },
      toType(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },
      getImage(user){
            if(user!=''&&user!=null&&typeof user!='undefined'){
                if(user.profile_image!=''&&user.profile_image!=null&&typeof user.profile_image!='undefined'){
                    return user.profile_image;
                }else{
                    return 'default-profile.png';
                }
            }else{
                return 'default-profile.png';
            }
        },
      className({desc}){
          return `${desc}`
      },
      generateList(){
            let vm = this;
            let loading = null

            // if(this.from == null || this.to == null){
            //     swal.fire({
            //     type: "error",
            //     title: 'Start and End Month must be filled.',
            //     });
            //     return false;
            // }

            if(this.selected_class==null||this.selected_class==''){
                swal.fire({
                    type:"error",
                    title:"Class field must be filled"
                });
                return false;
            }

            if(this.from > this.to){
                swal.fire({
                type: "error",
                title: 'Start Month must be less than End Month.',
                });
                // return false;
            }

            loading = swal.fire({
                title: 'Processing Student List...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
            });

            axios.post('/reports/generate-attendance',{
                class_id:this.selected_class.id,
                from:this.from!==null?moment(this.from).format('YYYY-MM-DD'):null,
                to:this.to!==null?moment(this.to).format('YYYY-MM-DD'):null,
                student_type:this.student_type
            }).then(
                response=>{
                    console.log(response.data);
                    if(response.data.status=='success'){
                        vm.attendances = response.data.attendances
                        swal.close();
                    }else{
                        swal.fire({
                        type: "error",
                        title: 'Something went wrong',
                        html:response.data.message
                        });
                    }
                }
            ).catch(
                err=>{
                    swal.fire({
                        type: "error",
                        title: 'Something went wrong',
                        html:err
                    });
                }
            );
      },
      exportPdf(){
        //   window.open('','_blank');
        //   document.getElementById('form').submit();
          if(this.attendances.length>0){
            //   swal.fire({
            //     title: 'Exporting to Pdf...',
            //     // html: '',// add html attribute if you want or remove
            //     allowOutsideClick: false,
            //     onBeforeOpen: () => {
            //         swal.showLoading()
            //     },
            //     });
                var from = this.from!==null?moment(this.from).format('YYYY-MM-DD'):null;
                var to = this.to!==null?moment(this.to).format('YYYY-MM-DD'):null;

                var link = this.selected_class.id+','+this.student_type+','+from+','+to
                window.open('/reports/attendance/export-pdf/'+link);
          }else{
              swal.fire({
                    type: "error",
                    title: 'Data not found.',
                });
          }
      },
      exportExcel(){
          if(this.attendances.length>0){  
              swal.fire({
                title: 'Exporting to Excel...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
                });
              axios.post('/reports/attendance/export-excel',{
                class_id:this.selected_class.id,
                attendances:this.attendances,
                from:this.from!==null?moment(this.from).format('YYYY-MM-DD'):null,
                to:this.to!==null?moment(this.to).format('YYYY-MM-DD'):null,
              }).then(
                  response=>{
                      if(response.data.status=='success'){
                          window.location.href = "/reports/download/excel/"+response.data.file+"/"+response.data.rename;
                          swal.close();
                      }else{
                            swal.fire({
                            type: "error",
                            title: 'Something went wrong',
                            html:response.data.message
                            });
                      }
                  }
              ).catch(
                  err=>{
                      swal.fire({
                        type: "error",
                        title: 'Something went wrong',
                        html:err
                        });
                  }
              );
          }else{
              swal.fire({
                    type: "error",
                    title: 'Data not found.',
                });
          }
      },
      resetFields(){
          this.selected_class = '';
          this.student_type = '*';
          this.from = null;
          this.to = null;
      }
  },
};
</script>
<style>
#VueTables_th--profile_image{
    width:50px !important;
}
#VueTables_th--student\.party\.name{
    width:15% !important;
}
#VueTables_th--student_id{
    width:15% !important;
}
.vc-text-base{
    height: 70% !important;

}
.table-bordered th, .table-bordered td {
    vertical-align: middle;
}
</style>