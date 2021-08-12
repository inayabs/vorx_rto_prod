<template>
  <div>
    <div class="row mb-3">
        <div class="col-md-6 pull-right text-left">
            <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('back')" ><i class="fas fa-chevron-circle-left"></i> Course Structure and Fees</button>
        </div>
        <div class="col-md-6 pull-right text-right">
            <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('next')" ><i class="fas fa-chevron-circle-right"></i> Class</button>
        </div>
    </div>
    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'" id="directEdit">
        <h6>Course Package <i>(For International)</i></h6>
    </div>
    <div class="row mb-2 d-flex justify-content-between">
        <div class="col-md-12">
            <button v-if="is_open == 0" @click="formOpen()" class="btn btn-success btn-sm d-block ml-auto">
                <i  class="fas fa-plus"></i> Add
            </button>
            <button v-else @click="formOpen()" class="btn btn-danger btn-sm d-block ml-auto">
                <i  class="fas fa-minus"></i> Remove
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right">
        <div class="row" :class="is_open == 0 ? 'hide-form' : ''">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="">Name:</label>
                    <input type="text" class="form-control" id="" name="name" v-model="fields.name" :class="[errors && errors.name ? 'border-danger' : '']" />
                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="">Student Location:</label>
                    <select name="" id="" class="form-control" v-model="fields.shore_type">
                        <option value="ONSHORE">ONSHORE</option>
                        <option value="OFFSHORE">OFFSHORE</option>
                    </select>
                    <div v-if="errors && errors.shore_type" class="badge badge-danger">{{ errors.shore_type[0] }}</div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="wk_duration_package">State: <i class="info" :class="'text-'+app_color">(Note: Cricos Code is required in the Course Structure and Fees)</i></label>
                    <multiselect
                        v-model="fields.location"
                        :options="location_opt"
                        :multiple="false"
                        placeholder="Type to search"
                        :close-on-select="true"
                        @select="selectLocation"
                        track-by="state_key"
                        label="state_name"
                    >
                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                    </multiselect>
                    <div v-if="errors && errors.location" class="badge badge-danger">{{ errors.location[0] }}</div>
                    <!-- <label for="units">Select Default Training Delivery Location:</label>
                    <select name="train_org_dlvr_loc_id" id="train_org_dlvr_loc_id" class="form-control" v-model="fields.train_org_dlvr_loc_id" :class="[errors && errors.train_org_dlvr_loc_id ? 'border-danger' : '']">
                        <option
                            v-for="(opt, optKy) in prospectus_opt.slct_training_dlvr_loc"
                            v-bind:key="optKy"
                            v-bind:value="optKy"
                        >{{opt}}</option>
                    </select> -->
                </div>
            </div>
            <div class="col-lg-7">
                <div class="form-group">
                    <label for="">Description:</label>
                    <textarea id="description" class="form-control" v-model="fields.description" cols="30" rows="5" :class="[errors && errors.description ? 'border-danger' : '']"></textarea>
                    <div v-if="errors && errors.description" class="badge badge-danger">{{ errors.description[0] }}</div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="">Delivery Location:</label>
                    <multiselect
                        v-model="fields.delivery_location_id"
                        :options="prospectus_opt.delivery_loc"
                        :multiple="false"
                        placeholder="Type to search"
                        :close-on-select="true"
                        track-by="id"
                        label="train_org_dlvr_loc_name"
                        >
                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                    </multiselect>
                    <div v-if="errors && errors.delivery_location_id" class="badge badge-danger">{{ errors.delivery_location_id[0] }}</div>
                </div>
            </div>

            <div class="col-lg-12">
                    <div class="form-group formunits">
                        <label for="units">Course List:</label>
                        <div class="list-group">
                            <div class="list-group-item" v-for="(v,k) in fields.detail" :key="k" :class="typeof v.is_current !== 'undefined' ? 'is-current' : ''">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="">Course:</label>
                                        <span style="width:100%" class="float-left">{{v.get_course.code}} - {{v.get_course.name}}</span>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Duration (Weeks):</label>
                                            <input type="number" min="0" class="form-control" id="" name="name" v-model="fields.detail[k].wk_duration" :class="[errors && errors[v.get_course.code+'-wk_duration'] ? 'border-danger' : '']" />
                                            <div v-if="errors && errors[v.get_course.code+'-wk_duration']" class="badge badge-danger">{{ errors[v.get_course.code+'-wk_duration'][0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Tuition Fee:</label>
                                            <input type="number" min="0" class="form-control" id="" name="name" v-model="fields.detail[k].tuition_fee" :class="[errors && errors[v.get_course.code+'-tuition_fee'] ? 'border-danger' : '']" />
                                            <div v-if="errors && errors[v.get_course.code+'-tuition_fee']" class="badge badge-danger">{{ errors[v.get_course.code+'-tuition_fee'][0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Material Fee:</label>
                                            <input type="number" min="0" class="form-control" id="" name="name" v-model="fields.detail[k].material_fee" :class="[errors && errors[v.get_course.code+'-material_fee'] ? 'border-danger' : '']" />
                                            <div v-if="errors && errors[v.get_course.code+'-material_fee']" class="badge badge-danger">{{ errors[v.get_course.code+'-material_fee'][0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">Actions</label>
                                        <span style="width:100%" class="float-right">
                                            <button class="btn btn-sm" title="move up" @click="changeOrder('up',k)" :class="'btn-'+app_color"><i class="fas fa-arrow-circle-up"></i></button>
                                            <button class="btn btn-sm" title="move down" @click="changeOrder('down',k)" :class="'btn-'+app_color"><i class="fas fa-arrow-circle-down"></i></button>
                                            <!-- <button class="btn btn-sm" title="remove" @click="removeOrder(k)" :class="'btn-danger'"><i class="fas fa-trash"></i></button> -->
                                        </span>
                                    </div>
                                    
                                </div>
                                <!-- <span class="float-left">{{v.code}} - {{v.title}}</span>
                                <span class="float-right">
                                    <button class="btn btn-sm" title="move up" @click="changeOrder('up',k)" :class="'btn-'+app_color"><i class="fas fa-arrow-circle-up"></i></button>
                                    <button class="btn btn-sm" title="move down" @click="changeOrder('down',k)" :class="'btn-'+app_color"><i class="fas fa-arrow-circle-down"></i></button>
                                    <button class="btn btn-sm" title="remove" @click="removeOrder(k)" :class="'btn-danger'"><i class="fas fa-trash"></i></button>
                                </span> -->
                            </div>
                        </div>
                        <div v-if="errors && errors.detail" class="badge badge-danger">{{ errors.detail[0] }}</div>
                    </div>
                </div>
            
            <div class="col-lg-12">
                <div class="form-group float-right">
                    <button class="btn btn-success" @click="checkPackage" v-if="is_update == 0"><i class="fas fa-save"></i> Add Package</button>
                    <button class="btn btn-success" @click="checkPackage" v-else><i class="fas fa-save"></i> Update Package</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <v-client-table :class="'header-'+app_color" :data="package_list" :columns="columns" :options="options" ref="prospectusTable">

                <div class="btn-group" slot="actions" slot-scope="{row}">
                    <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(row)"> <i class="fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row)"> <i class="fas fa-trash"> </i></a>
                </div>

                <div class="" slot="location" slot-scope="{row}">
                    <span v-if="typeof row.location !== 'string'">{{typeof row.location.state_key !== 'undefined' ? row.location.state_key : ''}}</span>
                    <span v-else>{{row.location}}</span>
                </div>
                
                <div class="" slot="detail" slot-scope="{row}">
                    <ul v-if="typeof row.detail[0] !== 'undefined'">
                            <li v-for="(v,k) in row.detail" :key="k"><span>{{v.get_course.code}} - {{v.get_course.name}}</span></li>
                    </ul>
                </div>
                </v-client-table>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "course-package",
  data() {
    return {
        course: {},
        detail: [],
        package_list: [],
        matrix_list: {},
        locations: {},
        location_opt: [],
        fields: {detail:[]},
        prospectus_opt: {delivery_loc:[]},
        errors: {},
        is_open: 0,
        is_update: 0,
        app_color: app_color,

        // vue-tables-2
        columns: [
            "name",
            "shore_type",
            "location",
            "detail",
            "actions"
        ],
        options: {
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
            name: "Name",
            shore_type: "Student_location",
            location: "Location",
            detail: "Courses",
            actions: "Actions"
            },
            sortable: ["name", "shore_type", "location","detail"],
            texts: {
            filter: "Search:",
            filterPlaceholder: "Search keywords"
            },
            cellClasses: {
            is_active: [
                {
                class: "active",
                condition: row => row.is_active === 1
                },
                {
                class: "inactive",
                condition: row => row.is_active === 0
                }
            ]
            }
        }
    };
  },
  created() {
    // this.fetchData();
  },
  computed: {
      
  },
  watch: {
      fields : function(val) {
          if(typeof val.detail !== 'undefined' && val.detail.length > 0){
              let temp_order = [];
              let order = [];
              val.detail.forEach(el => {
                  temp_order[el.order] = el;
              });

              temp_order.forEach(el => {
                  order.push(el);
              });
            //   console.log(order);
          }
          if(typeof val.location !== 'undefined' && typeof val.location === 'string'){
              this.location_opt.forEach(el => {
                  if(val.location == el.state_key){
                      val.location = el;
                    //   console.log(val.location);
                  }
              })
          }
      }
  },
  methods: {
    topFunction() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
    edit(row){
        let vm = this;
        let det = row.detail;
        vm.topFunction();
        vm.is_update = 1;
        vm.fields = row;
        if(typeof vm.fields.temp_id === 'undefined'){
            let check = 0;
            vm.fields.detail.forEach(el=> {
                if(el.get_course.code == vm.course.code){
                    check = 1;
                }
            })
            // console.log(check);
            if(check != 1){
                vm.fields.detail.push({get_course:this.course, is_current: 1});
            }
        }
    },
    changeOrder(type, k) {
        let vm = this;
        if(type == 'up'){
            if(k != 0){
                let list = [];
                for (let i = 0; i < vm.fields.detail.length; i++){
                    if(k - 1 == i){
                        list.push(vm.fields.detail[k]);
                    }else if( k == i){
                        list.push(vm.fields.detail[k-1]);
                    }else{
                        list.push(vm.fields.detail[i]);
                    }
                }
                vm.fields.detail = list;
            }
        }else{
            if(k+1 != vm.fields.detail.length){
                let list = [];
                for (let i = 0; i < vm.fields.detail.length; i++){
                    if(k + 1 == i){
                        list.push(vm.fields.detail[k]);
                    }else if( k == i){
                        list.push(vm.fields.detail[k+1]);
                    }else{
                        list.push(vm.fields.detail[i]);
                    }
                }
                vm.fields.detail = list;
            }
        }
        // vm.fields.detail
    },
    checkPackage() {
        // console.log('check');
        let errors = {};
        let check = [
            {name:'name', lable:'Name'},
            {name:'location', lable:'Location'},
            {name:'shore_type', lable:'Student'},
        ];
        let vm = this;
        const waitFor = (ms) => new Promise(r => setTimeout(r, ms))
        const asyncForEach = async (array, callback) => {
            for (let index = 0; index < array.length; index++) {
                await callback(array[index], index, array)
            }
        }

        const start = async () => {
            // console.log(check);
            await asyncForEach (check, async (element) => {
                await waitFor(50);
                // if(typeof vm.fields[])
                // console.log(element.name)
                
                if(typeof element.name !== 'undefined'){

                    if(typeof vm.fields[element.name] === 'undefined'){
                        errors[element.name] = [element.lable+' is required'];
                    }else{
                        if(['',null].indexOf(vm.fields[element.name]) != -1){
                            errors[element.name] = [element.lable+' is required'];
                        }
                    }
                    if(typeof vm.fields[element.name] !== 'undefined' && ['',null].indexOf(vm.fields[element.name]) == -1){
                        delete errors[element.name];
                    }
                }
            })
            // console.log(errors);
            if(Object.keys(errors).length == 0){
                // proceed to add/update package
                this.addUpdatePackage();
            }else{
                swal.fire(
                    'Oppss..',
                    'Please fill required fields.',
                    'error'
                )
            }
            this.errors = errors;
        }

        start();
    },
    addUpdatePackage(){
        let vm = this;
        let type = this.is_update == 0 ? 'added' : 'updated';
        
        swal.fire({
            title: 'Processing Package..',
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
                swal.showLoading()
            },
        });

        if(vm.is_update == 0){
            vm.IDrand();
            vm.package_list.push(vm.fields);
            vm.fields = {};
            vm.fields.detail = [{get_course:vm.course, is_current: 1}]; 
            swal.fire(
                'Success',
                'Course pacakge '+type+' successfully!',
                'success'
            )
        }else{
            if(typeof vm.fields.temp_id === 'undefined'){
                vm.IDrand();
            }
            let pckg = [];
            vm.package_list.forEach(el=>{
                let is_save = 0;
                if(typeof el.temp_id !== 'undefined'){
                    if(typeof vm.fields.temp_id !== 'undefined' && el.temp_id == vm.fields.temp_id){
                        pckg.push(vm.fields)
                        is_save = 1;
                    }else if(typeof el.temp_id !== 'undefined' && el.temp_id != vm.fields.temp_id){
                        pckg.push(el)
                        is_save = 1;
                    }else{
                         pckg.push(el)
                         is_save = 1;
                    }
                }
                if(is_save == 0){
                    if(typeof el.id !== 'undefined'){
                        if(typeof vm.fields.id !== 'undefined' && el.id == vm.fields.id){
                            pckg.push(vm.fields)
                        }else if(typeof el.id !== 'undefined' && el.id != vm.fields.id){
                            pckg.push(el)
                        }else{
                             pckg.push(el)
                        }
                    }
                }
            })
            vm.package_list = pckg;
            vm.fields = {}; 
            vm.is_update = 0;
            vm.fields.detail = [{get_course:vm.course, is_current: 1}]; 
            swal.fire(
                'Success',
                'Course pacakge '+type+' successfully!',
                'success'
            )
        }

    },
    IDrand(min = 1, max = 9999) {
        let randomNum = Math.random() * (max - min) + min;
        randomNum = Math.round(randomNum);
        this.fields['temp_id'] = randomNum
    },
    formOpen(){
        this.is_open = this.is_open == 1 ? 0 : 1;

        let slct_locations = [];
        let slct_packages = []
        this.locations.forEach(element => {
            this.location_opt.forEach(el => {
                if(element == el.state_key){
                    if(typeof this.matrix_list[element]['international']['cricos_code'] !== 'undefined' && ['',null].indexOf(this.matrix_list[element]['international']['cricos_code']) == -1){
                        slct_locations.push(el);
                    }
                }
            })
            console.log(this.package_list);
            this.package_list.forEach(el => {
                console.log(el.location);
                if(typeof el.location === 'string' && element == el.location){
                    if(typeof this.matrix_list[element]['international']['cricos_code'] !== 'undefined' && ['',null].indexOf(this.matrix_list[element]['international']['cricos_code']) == -1){
                        slct_packages.push(el);
                    }
                }
                if(typeof el.location.state_key !== 'undefined' && element == el.location.state_key){
                    if(typeof this.matrix_list[element]['international']['cricos_code'] !== 'undefined' && ['',null].indexOf(this.matrix_list[element]['international']['cricos_code']) == -1){
                        slct_packages.push(el);
                    }
                }
                console.log(slct_packages);
            })
        });

        this.fields.detail = [{get_course:this.course, is_current: 1}]; 
        
        this.location_opt = slct_locations;
        this.package_list = slct_packages;

    },
    proceedTab(proceed){
        this.is_open = 0;
        this.$parent.$store.state.course_package = this.package_list;
        document.getElementById("nav-package-tab").classList.add('disabled')
        if(proceed == 'back'){
            document.getElementById("nav-matrix-tab").classList.remove('disabled')
            $('a[href="#nav-matrix"]').tab('show')
        }
        if(proceed == 'next'){
            this.$parent.$children[5].fetchData();
            document.getElementById("nav-class-tab").classList.remove('disabled')
            // this.is_open = 0;
            $('a[href="#nav-class"]').tab('show')
        }
    },
    fetchData() {
        console.log(this.$parent.$store.state.course_package.length);
        this.course = this.$parent.$store.state.course;
        this.locations = this.$parent.$store.state.course_locations;
        this.location_opt = this.$parent.$store.state.prospectus_opt.slct_state;
        this.package_list = this.$parent.$store.state.course_package.length > 0 ? this.$parent.$store.state.course_package : this.$parent.$store.state.cur_course_package;
        this.matrix_list = this.$parent.$store.state.structure_fees;
        this.prospectus_opt = this.$parent.$store.state.prospectus_opt;
        // console.log(prospectus_opt);
        this.formOpen();
    },
    selectLocation(r) {
        return r.state_key;
    }
  }
};
</script>

<style lang="scss" scoped>
.hide-form {
    display:none;
}
.is-current {
    background-color: #f0f8ff !important;
}
ul {
    list-style-type: square;
}
ul span {
    font-weight: 400;
}
.info{
    font-size: 12px !important;
}
</style>