<template>
  <div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">Enrolment List</h6>
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
                                        <label for="month">Start Month: <span class="badge"><i>( Course start month )</i></span></label>
                                        <input type="month" class="form-control" v-model="from" value="">
                                        <!-- <select id="month" class="form-control">
                                            <option value="01-03">Jan - Mar</option>
                                            <option value="01-06">Jan - Jun</option>
                                            <option value="01-09">Jan - Sep</option>
                                            <option value="01-12">Jan - Dec</option>
                                        </select> -->
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="year">End Month: <span class="badge"><i>(Course end month)</i></span></label>
                                        <input type="month" class="form-control" v-model="to" value="">
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="year">Type:</label>
                                        <!-- <input type="month" class="form-control" v-model="to" value=""> -->
                                        <select name="" id="" class="form-control" v-model="student_type" @change="filter_status()">
                                            <option value="*">All Student Type</option>
                                            <option value="2">Domestic</option>
                                            <option value="1">International</option>
                                        </select>
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="year">Course:</label>
                                        <select name="" id="" class="form-control" v-model="get_course">
                                            <option :value="key" v-for="(itm,key) in courses" :key="key">
                                                <span v-if="key != '*'">{{key}} - {{itm}}</span>
                                                <span v-else>{{itm}}</span>
                                            </option>
                                        </select>
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="year">Status:</label>
                                        <select name="" id="" class="form-control" v-model="get_status">
                                            <option :value="itm.key" v-for="itm in statuses" :key="itm.key">
                                                <span>{{itm.value}}</span>
                                            </option>
                                        </select>
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="year">Agent:</label>
                                        <select name="" id="" class="form-control" v-model="get_agent">
                                            <option :value="key" v-for="(itm,key) in agents" :key="key">
                                                <span>{{itm}}</span>
                                            </option>
                                        </select>
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="year">Avetmiss Report:</label>
                                        <select name="" id="" class="form-control" v-model="avetmiss_report">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            <option value="*">All</option>
                                        </select>
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

                <!-- <v-client-table :data="courseList" :columns="columns" :options="options" ref="courseTable"></v-client-table> -->
                <v-client-table :class="'header-'+app_color" :data="student_list" :columns="columns" :options="options" ref="courseTable">
                        <div slot="afterLimit" class="ml-2">
                            <div class="btn-group">
                                <!-- <a href="javascript:void(0)"  @click="showCreateCourse" class="btn btn-success" slot="afterLimit"><i class="fas fa-plus"></i> Add Course</a> -->
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export to
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- <a class="dropdown-item" href="#"><i class="far fa-file-pdf text-danger"></i>&nbsp; PDF</a> -->
                                    <a class="dropdown-item" href="#" @click="exportExcel"><i class="far fa-file-excel text-success"></i>&nbsp; Excel</a>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                        </div> -->
                </v-client-table>
            </div>
        </div>
    </div>
  </div>
</template>
<script>
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
      student_list: [],
      app_color: app_color,
      from: null,
      to: null,
      student_type: '*',
      get_course: '*',
      get_status: '*',
      get_agent: '*',
      avetmiss_report:'*',
      statuses: [],
      agents: window.agents,
      courses: window.courses,
      columns: ["Student ID", "Given Name", "Last Name", "Date of Birth","USI","Course Code", "Course Name","Start Date", "End Date"],
      options: {
            initialPage:1,
            perPage:10,
            highlightMatches:true,
            sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
            // headings: {
            //     id: '#',
            //     code: 'Course Code',
            //     name: 'Course Name',
            //     actions: 'Actions'
            // },
            sortable: ["Student ID", "Given Name", "Last Name", "Date of Birth","USI","Course Code", "Course Name","Start Date", "End Date"],
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
    this.filter_status();
  },
  methods: {
    exportExcel() {

        if(this.student_list.length == 0){
            swal.fire({
            type: "error",
            title: 'No records available...',
            });
            return false;
        }

        let vm = this;
        let loading = null
        loading = swal.fire({
            title: 'Exporting to Excel...',
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
                swal.showLoading()
            },
        });

        axios.post('/reports/export-excel-list', {
            enrolments: this.student_list,
            from: this.from,
            to: this.to,
        })
        .then(function (response) {
            // console.log(response);
            // vm.student_list = response.data;
            // console.log(vm.student_list);
            if(response.data.status == 1){
                window.location.href = "/reports/download/excel/"+response.data.file+"/"+response.data.rename;
            }
            loading.close();
        })
        .catch(function (error) {
            // console.log(error);
            loading.close();
        });

    },
    generateList() {
        let vm = this;
        let loading = null

        if(this.from == null || this.to == null){
            swal.fire({
            type: "error",
            title: 'Start and End Month must be filled.',
            });
            return false;
        }

        if(this.from > this.to){
            swal.fire({
            type: "error",
            title: 'Start Month must be less than End Month.',
            });
            return false;
        }

        loading = swal.fire({
            title: 'Processing Student List...',
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
                swal.showLoading()
            },
        });
        axios.post('/reports/generate-list', {
            from: this.from,
            to: this.to,
            student_type: this.student_type,
            get_course: this.get_course,
            get_status: this.get_status,
            get_agent: this.get_agent,
            avetmiss_report:this.avetmiss_report
        })
        .then(function (response) {
            // console.log(response);
            vm.student_list = response.data;
            // console.log(vm.student_list);
            loading.close();
        })
        .catch(function (error) {
            // console.log(error);
            loading.close();
        });
    },
    filter_status() {
        // console.log(window.student_status);
        // const st = window.student_status;
        let st = [];
        console.log(this.statuses);
        let count = 0; 
        if(this.student_type == '1'){
            // console.log('int');
            Object.entries(window.student_status).forEach((el) => {
                let stats = ['1','2','4','5','7'];
                if(stats.indexOf(el[0]) !== -1){
                    // console.log(el[0]);
                    // this.statuses;
                    st[count] = {
                        key: el[0],
                        value: el[1],
                    };
                    // delete this.statuses[el[0]];
                    count++;
                }
            });
        }else{
            console.log('dom');
            Object.entries(window.student_status).forEach((el) => {
                let stats = ['1','3','4','5','7'];
                if(stats.indexOf(el[0]) !== -1){
                    // console.log(el[0]);
                    st[count] = {
                        key: el[0],
                        value: el[1],
                    };
                    // delete this.statuses[el[0]];
                    count++;
                }
            });
        }
        st[count] = {
            key: '*',
            value: 'All Status',
        };
        this.statuses = st;
        // console.log(st);
        console.log(this.statuses);
    },
  }
};
</script>