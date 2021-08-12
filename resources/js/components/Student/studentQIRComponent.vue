<template>
    <div>
      <div class="card shadow mb-4 filter-wrapper" v-if="!isHidden">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
      </div>
      <div class="card-body">
        <div class="col-md-12">
              <form id="filter-form" @submit.prevent="processFilter">
                <div class="row">
                  <div class="col">
                   <div class="form-group">
                    <label for="sel1">Course:</label>
                    <select class="form-control" 
                      name="course" 
                      v-on:change="filters"
                      v-model="qirFilter.course">
                      <option value=""></option>
                       <option v-for="(opt, optKy) in slct_course " v-bind:key="optKy" v-bind:value="optKy">{{opt}}</option>
                    </select>
                  </div>
                  </div>
                  <div class="col">
                   <div class="form-group">
                    <label for="sel1">Type:</label>
                    <select class="form-control" 
                      name="type" 
                      v-on:change="filters"
                      v-model="qirFilter.type">
                      <option value=''></option>
                      <option value='cert'>Certificate</option>
                      <option value='soa'>SOA</option>
                    </select>
                  </div>
                  </div>
                </div>
                <!-- <div class="row">
                  <div class="col">
                    <div class="form-group">
                    <label for="sel1">From:</label>
                    <input type="" class="form-control" placeholder="" name="" 
                      v-model="qirFilter.date_from">

                  </div>
                  </div>
                  <div class="col">
                     <div class="form-group">
                    <label for="sel1">To:</label>
                    <input type="" class="form-control" placeholder="" name="" 
                      v-model="qirFilter.date_to">

                  </div>
                  </div>
                  </div> -->
                </form>
                </div>
      </div>
    </div>

      <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Qualification Issuance Register</h6>
      </div>
      <div class="card-body">
        <!-- <div class="table-responsive"> -->
          <div>
          <div class="row mb-2">
            
            <!-- <br> -->
            <div class="col-md-4">
            <input
                type="text"
                v-on:keyup="searchData"
                v-model="searchQIR"
                class="form-control bg-light border-0 small"
                placeholder="Search for keyword..."
                aria-label="Search"
                aria-describedby="basic-addon2"
              /> 
            <!-- <input
                type="text"
                class="form-control bg-light border-0 small"
                placeholder="Search for Name..."
                aria-label="Search"
                aria-describedby="basic-addon2"
              /> -->
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-6 pull-right text-right">
              <button type="button" class="btn btn-success" v-on:click="isHidden = !isHidden">Filter</button>
              <div class="btn-group">
              <button v-if="newList.length != 0"
                type="button"
                class="btn btn-success dropdown-toggle dropdown-toggle-split"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                Export to
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" @click="generate_qir()" target="_blank">
                  <i class="far fa-file-pdf text-danger"></i>&nbsp; PDF
                </a>
                <!-- <a class="dropdown-item" href="#">
                  <i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)
                </a> -->
              </div>
            </div>
            </div>
          </div>
          <table :class="'table table-bordered header-'+app_color" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th :class="'text-center table-header-'+app_color" colspan="5">Qualification Issuance Register</th>
                <th :class="'text-center table-header-'+app_color" colspan="2">Certificate</th>
                <th :class="'text-center table-header-'+app_color" colspan="2">Record of Result</th>
                <th :class="'text-center table-header-'+app_color" colspan="2">Statement of Attainment</th>
              </tr>
              <tr>
                <th :class="'text-center table-header-'+app_color">ID</th>
                <th :class="'text-center table-header-'+app_color">Student Name</th>
                <th :class="'text-center table-header-'+app_color">Student ID</th>
                <th :class="'text-center table-header-'+app_color">Qualification / Unit</th>
                <th :class="'text-center table-header-'+app_color">Code</th>
                <th :class="'text-center table-header-'+app_color">Certificate No.</th>
                <th :class="'text-center table-header-'+app_color">Date Issued</th>
                <th :class="'text-center table-header-'+app_color">Certificate No.</th>
                <th :class="'text-center table-header-'+app_color">Date Issued</th>
                <th :class="'text-center table-header-'+app_color">SOA No.</th>
                <th :class="'text-center table-header-'+app_color">Date Issued</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(qir, item) in newList" v-bind:key="item+1">
                <td class="text-center"> {{ qir.id }} </td>
                <td class="text-center">{{ qir.fullname }}</td>
                <td class="text-center">{{ qir.student_id }}</td>
                <td class="text-center">{{ qir.qualification }}</td>
                <td class="text-center">{{ qir.course_code }}</td>
                <td class="text-center">{{ qir.cert_no }}</td>
                <td class="text-center">{{ qir.date_issued }}</td>
                <td class="text-center">{{ qir.rr_cert_no }}</td>
                <td class="text-center">{{ qir.rr_date_issued }}</td>
                <td class="text-center">{{ qir.soa_no }}</td>
                <td class="text-center">{{ qir.soa_date_issued }}</td>
              </tr>
              <tr v-if="newList.length == 0">
                <td colspan="11" class="text-center">No matching records</td>
              </tr>
            </tbody>
          </table>
          <div class="row no-padding no-margin">
            <div class="col-md-12 no-padding">
              <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                  <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a
                      class="page-link"
                      href="#"
                      @click="fetchData(pagination.prev_page_url)"
                    >Previous</a>
                  </li>
                  <li class="page-item" disabled>
                    <a
                      class="page-link text-dark"
                      href="#"
                    >Page {{pagination.current_page}} of {{pagination.last_page}}</a>
                  </li>
                  <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchData(pagination.next_page_url)">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
              app_color: app_color,
                qirList: [],
                qir: {
                  id: '',
                  fullname: '',
                  student_id: '',
                  qualification: '',
                  course_code: '',
                  cert_no: '',
                  date_issued: '',
                  rr_cert_no: '',
                  rr_date_issued: '',
                  soa_no: '',
                  soa_date_issued: '',
                },
                newList: [],
                pagination: {},
                searchQIR: '',
                qirFilter: {
                  course: '',
                  type: '',
                  date_from: '',
                  date_to: '',
                },
                slct_course : window.slct_course,
                isHidden: true
            };
        },
        computed: {
        merged_dataList() {
                  var formatted = [];
                  var x = [];
                  for (let i = 0; i < this.qirList.length; i++) {
                        x = this.$parent.$children[0].qirList[i];
                        x.forEach(function(el){
                          // console.log('last ka nlng gyud kol');
                          // console.log(el);
                          formatted.push(el);
                        });
                  }
                return formatted;
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData(page_url) {
              let vm = this;
              page_url = page_url || 'qualification-issuance-register/info';
              fetch(page_url)
                .then(res => res.json())
                .then(res => {
                  vm.qirList = res.data;
                  vm.newList = this.merged_dataList;
                  // console.log(this.merged_dataList);
                  vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },
            makePagination(meta, links) {
              let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
              };
              this.pagination = pagination;
            },
            searchData() {
            let vm = this;
            // console.log(vm);
            // console.log(this.searchQIR.length);
            if (vm.searchQIR.length != 'undefined' && vm.searchQIR.length > 3) {
              fetch(`/qualification-issuance-register/search/${vm.searchQIR}`)
                .then(res => res.json())
                .then(res => {
                  // console.log(res.data);
                  vm.qirList = res.data;
                  // console.log(this.merged_dataList);
                  vm.newList = this.merged_dataList;
                  // console.log(vm.newList);
                  vm.makePagination(res.meta, res.links);
                })
                .catch(err => {
                  console.log(err);
                });
            }else{
              vm.fetchData();
            }
          },
          filters(value){
            let vm = this;
            let filters = {course: vm.qirFilter.course, type: vm.qirFilter.type};
            let str = JSON.stringify(filters);
            console.log(str);
            fetch(`/qualification-issuance-register/filter/${str}`)
                .then(res => res.json())
                .then(res => {
                  // console.log(res.data);
                  vm.qirList = res.data;
                  vm.newList = this.merged_dataList;
                  // console.log(vm.newList);
                  // console.log(this.merged_dataList);
                  vm.makePagination(res.meta, res.links);
                })
                .catch(err => {
                  console.log(err);
                });
          },
          generate_qir(){
            let vm = this;
            let filters = {course: vm.qirFilter.course, type: vm.qirFilter.type};
            let str = JSON.stringify(filters);
            // console.log(this.qirFilter);
            window.open(`/qualification-issuance-register/generate/${str}`, '_blank');
            },
        }
    }
</script>
<style scoped>
.table-bordered th, .table-bordered td {
    border: 1px solid #e3e6f0!important;
}
</style>