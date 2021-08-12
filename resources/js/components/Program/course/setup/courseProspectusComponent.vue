<template lang="">
    <div>
        <div class="row mb-3">
            <div class="col-md-6 pull-right text-left">
                <!-- <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('back')" ><i class="fas fa-chevron-circle-left"></i> Units</button> -->
                <button class="btn btn-md" :class="'btn-info'" @click="proceedTab('back')" ><i class="fas fa-chevron-circle-left"></i> Units</button>
            </div>
            <div class="col-md-6 pull-right text-right">
                <!-- <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('next')" ><i class="fas fa-chevron-circle-right"></i> Course Structure and Fees</button> -->
                <button class="btn btn-md" :class="'btn-info'" @click="proceedTab('next')" ><i class="fas fa-chevron-circle-right"></i> Course Structure and Fees</button>
            </div>
        </div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'" id="directEdit">
            <h6>Training Delivery Location According to State and Territory</h6>
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
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="prospectus_name">Description:</label>
                        <input type="text" class="form-control" id="prospectus_name" name="name" v-model="fields.name" :class="[errors && errors.name ? 'border-danger' : '']" />
                        <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="wk_duration_package">State:</label>
                        <multiselect
                            v-model="fields.location"
                            :options="prospectus_opt.slct_state"
                            :multiple="true"
                            placeholder="Type to search"
                            :close-on-select="false"
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
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="wk_duration_package">Delivery Location:</label>
                        <multiselect
                            v-model="fields.delivery_loc_id"
                            :options="prospectus_opt.delivery_loc"
                            :multiple="false"
                            placeholder="Type to search"
                            :close-on-select="true"
                            track-by="id"
                            label="train_org_dlvr_loc_name"
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
                <!-- <div class="col-lg-2">
                    <div class="form-group">
                        <label for="is_active">Status:</label>
                        <div class="custom-control custom-switch my-2">
                            <input type="checkbox" class="custom-control-input" id="is_active_pros" v-model="fields.is_active" >
                            <label class="custom-control-label" for="is_active_pros">Set as Active</label>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="col-lg-12"> -->
                    <!-- <div class="form-group"> -->
                        <!-- <label for="wk_duration_package">Location:</label>
                            <select name="location" id="location" class="form-control" v-model="fields.location" :class="[errors && errors.location ? 'border-danger' : '']">
                                <option
                                    v-for="(opt, optKy) in slct_state"
                                    v-bind:key="optKy"
                                    v-bind:value="optKy"
                                >{{opt}} ({{optKy}})</option>
                            </select> -->
                        <!-- <label for="wk_duration_package">Location:</label>
                        <multiselect
                            v-model="fields.location"
                            :options="prospectus_opt.slct_state"
                            :multiple="true"
                            placeholder="Type to search"
                            :close-on-select="false"
                            track-by="state_key"
                            label="state_name"
                            >
                            <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                        </multiselect>
                        <div v-if="errors && errors.location" class="badge badge-danger">{{ errors.location[0] }}</div> -->
                    <!-- </div> -->
                <!-- </div> -->
                <div class="col-lg-12">
                    <div class="form-group formunits">
                        <label for="units">Units:</label>
                        <draggable :list="units_list" class="list-group" handle=".handle" @start="dragging = true" @end="dragging = false">
                            <div class="list-group-item" v-for="(v,k) in units_list" :key="k">
                                <span class="float-left"><i class="fas fa-align-justify handle mr-3"></i>{{v.unit_code}} - {{v.unit_title}}</span>
                                <span class="float-right">
                                    <!-- <button class="btn btn-sm" title="move up" @click="changeOrder('up',k)" :class="'btn-'+app_color"><i class="fas fa-arrow-circle-up"></i></button> -->
                                    <!-- <button class="btn btn-sm" title="move down" @click="changeOrder('down',k)" :class="'btn-'+app_color"><i class="fas fa-arrow-circle-down"></i></button> -->
                                    <button class="btn btn-sm" title="remove" @click="removeOrder(k)" :class="'btn-danger'"><i class="fas fa-trash"></i></button>
                                </span>
                            </div>
                        </draggable>
                        <!-- <ul id="sortable" class="list-group">
                            <li class="list-group-item" v-for="(v,k) in units_list" :key="k">
                                <span class="float-left">{{v.unit_code}} - {{v.unit_title}}</span>
                                <span class="float-right">
                                    <button class="btn btn-sm" title="move up" @click="changeOrder('up',k)" :class="'btn-'+app_color"><i class="fas fa-arrow-circle-up"></i></button>
                                    <button class="btn btn-sm" title="move down" @click="changeOrder('down',k)" :class="'btn-'+app_color"><i class="fas fa-arrow-circle-down"></i></button>
                                    <button class="btn btn-sm" title="remove" @click="removeOrder(k)" :class="'btn-danger'"><i class="fas fa-trash"></i></button>
                                </span>
                            </li>
                        </ul> -->
                        <!-- <multiselect 
                            v-model="units_list" 
                            :options="selections" 
                            :multiple="true"  
                            :group-select="false" 
                            placeholder="Type to search" 
                            :close-on-select="false" 
                            :custom-label="codeDescription"
                            track-by="code" 
                            label="description" 
                            :class="[errors && errors.course_units ? 'border-danger' : '' , {'unitsclass':true}, 'multiselect-color-'+app_color] ">
                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                        </multiselect> -->
                        <div v-if="errors && errors.course_units" class="badge badge-danger">{{ errors.course_units[0] }}</div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group float-right">
                        <button class="btn btn-success" @click="checkPList" v-if="is_update == 0"><i class="fas fa-save"></i> Add Details</button>
                        <button class="btn btn-success" @click="checkPList" v-else><i class="fas fa-save"></i> Update Details</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                  <v-client-table :class="'header-'+app_color" :data="prospectus_list" :columns="columns" :options="options" ref="prospectusTable">

                    <div class="btn-group" slot="actions" slot-scope="{row}">
                        <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(row)"> <i class="fas fa-edit"> </i></a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row)"> <i class="fas fa-trash"> </i></a>
                    </div>
                    <div class="" slot="location" slot-scope="{row}">
                        <span v-if="row.location.length > 0" v-for="(v,k) in row.location" :key="k">{{v.state_key}}{{k+1 == row.location.length ? '' : ','}}</span>
                    </div>
                    <div class="" slot="units" slot-scope="{row}">
                        {{ row.course_units.length }}
                    </div>
                    <div class="" slot="is_active" slot-scope="{row}">
                        <i :class="'fas fa-'+[row.is_active? 'check text-success' : 'times text-danger']"></i> {{row.is_active ? 'Active' : 'Not Active'}}
                    </div>
                  </v-client-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: "courseProspectus",
  data() {
    return {
      app_color: app_color,
      // Fetch Prospectus List
      prospectus_list: [],

      // Vue-multiselect syntax
      course_units: [],
      course: {},
      selections: [],
      units_list: [],
      units_list_temp : [],
      cur_locations: {},
      is_open: 0,
      is_update: 0,
      prospectus_opt : {},
      slct_state: window.slct_state,
      slct_training_dlvr_loc: window.slct_training_dlvr_loc,
      // Fetch data from controller

      // Save/Update Data Action
      fields: {
          is_active: true
      },
      errors: {},
      loaded: false,

      // Vue-Tables-2 syntax
      columns: [
        "name",
        "location",
        "units",
        "is_active",
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
          name: "Description",
          location: "Location",
          is_active: "Status",
          course_units: "Units",
          actions: "Actions"
        },
        sortable: ["name", "location", "is_active"],
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
  watch: {
    fields: function(value) {
      if (value.name != null) {
        this.errors.name = "";
      }
      if (value.location != null) {
        this.errors.location = "";
      }
      if (value.course_units != null) {
        this.errors.course_units = "";
      }
    }
    // 'fields.location' : function(newVal){
    //     this.filterTrainingDeliveryLoc(newVal);
    // }
  },
  created() {
    // this.getProspectusList();
    // console.log(this.$parent.$store.state);
    this.prospectus_opt = this.$parent.$store.state.prospectus_opt;

  },
  computed: {
  },
  methods: {
    proceedTab(proceed) {
        this.$parent.$store.state.course_prospectus = this.prospectus_list;
        this.$parent.$store.state.course_locations = Object.keys(this.cur_locations);
        document.getElementById("nav-prospectus-tab").classList.add('disabled')
        if(proceed == 'back'){
            document.getElementById("nav-units-tab").classList.remove('disabled')
            this.is_open = 0;
            this.$parent.$children[1].unitOpt();
            $('a[href="#nav-units"]').tab('show')
        }
        if(proceed == 'next'){
            if(this.prospectus_list.length > 0){
                this.$parent.$children[3].fetchData();
                document.getElementById("nav-matrix-tab").classList.remove('disabled')
                this.is_open = 0;
                $('a[href="#nav-matrix"]').tab('show')
            }else{
                swal.fire(
                    'Oppss..',
                    'No details added..',
                    'error'
                )
                return 0;
            }
        }
    },
    checkPList(){
        let vm = this;

        if(typeof vm.fields.location === 'undefined' || vm.fields.location.length < 1){
            swal.fire(
                'Oppss..',
                'State is required',
                'error'
            )
            return false;
        }

        const waitFor = (ms) => new Promise(r => setTimeout(r, ms))
        const asyncForEach = async (array, callback) => {
            for (let index = 0; index < array.length; index++) {
                await callback(array[index], index, array)
            }
        }

        if(vm.prospectus_list.length > 0){
            const start = async () => {
            console.log('in');
                let chEr = 0;
                let locV = {};
                await asyncForEach(vm.fields.location, async (element) => {
                    await waitFor(50);
                    if(typeof vm.cur_locations[element.state_key] === 'undefined'){
                            locV[element.state_key] = vm.fields.id;
                    }else{
                        // if(typeof vm.fields.id !== 'undefined'){
                        vm.prospectus_list.forEach(el => {
                            el.location.forEach(e => {
                                console.log(vm.fields.id);
                                console.log(vm.cur_locations[element.state_key]);
                                console.log(vm.cur_locations[element.state_key]);
                                // for update
                                if(element.state_key == e.state_key && vm.cur_locations[element.state_key] != vm.fields.id ){
                                    chEr = 1;
                                }else{
                                    locV[element.state_key] = vm.fields.id
                                }

                            })
    
                        })

                        // }

                    }
                    // if(typeof vm.cur_locations[element])
                    // vm.prospectus_list.forEach(el => {
                    //     el.location.forEach(e => {
                    //         console.log(e.state_key)
                    //         if(element.state_key == e.state_key){
                    //             chEr = 1;
                    //             // console.log('has duplicate');
                    //         }else{
                    //             locV[element.state_key] = el.id;
                    //         }
                    //     })
                    // });
                })
                
                if(chEr == 0){
                    console.log(vm.cur_locations);
                    vm.cur_locations = Object.assign(vm.cur_locations, locV);
                    // console.log(vm.cur_locations);
                    vm.checkProspectus();
                }else{
                    swal.fire(
                        'Oppss..',
                        'Location already existed in the list',
                        'error'
                    )
                }
            }

            start();
            
        }else{
            const start = async () => {
                let locV = {};
                await asyncForEach(vm.fields.location, async (element) => {
                    await waitFor(50);
                    locV[element.state_key] = vm.fields.id;
                })
                vm.cur_locations = Object.assign(vm.cur_locations, locV);;
                vm.checkProspectus();
            }

            start();
        }
    },
    checkProsListID(id){
        if(this.prospectus_list.length > 0){
            this.prospectus_list.forEach(el => {
                if(el.id == id){
                    this.IDrand();
                }
            })
        }else{
            return true;
        }
    },
    IDrand(min = 1, max = 9999) {
        let randomNum = Math.random() * (max - min) + min;
        randomNum = Math.round(randomNum);
        this.checkProsListID(randomNum);
        this.fields['id'] = randomNum
        
    },
    checkProspectus(){
        let vm = this;
        let type = this.is_update == 0 ? 'added' : 'updated';
        
        swal.fire({
            title: 'Processing Unit..',
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
                swal.showLoading()
            },
        });

        if(this.is_update == 0){
            // add
            vm.fields['course_units'] = vm.units_list; 
            // vm.fields['id'] = vm.IDrand; 
            // console.log(vm.fields);
            vm.prospectus_list.push(vm.fields);
            swal.fire(
                'Success',
                'Unit '+type+' successfully',
                'success'
            )
            
            vm.fields = {is_active:true};
            this.units_list = this.$parent.$store.state.units;
            vm.is_update = 0;
            vm.IDrand();
        }else{
            // for update
            vm.fields['course_units'] = vm.units_list;
            
            const waitFor = (ms) => new Promise(r => setTimeout(r, ms))
            const asyncForEach = async (array, callback) => {
                for (let index = 0; index < array.length; index++) {
                    await callback(array[index], index, array)
                }
            }

            const start = async () => {
                let lists = [];
                await asyncForEach(vm.prospectus_list, async (element) => {
                    await waitFor(50);
                    if(element.id != vm.fields.id){
                        lists.push(element);
                    }else{
                        lists.push(vm.fields)
                    }
                })
                console.log(lists);
                vm.prospectus_list = lists;
                swal.fire(
                    'Success',
                    'Unit '+type+' successfully',
                    'success'
                )
                
                vm.fields = {is_active:true};
                this.units_list = this.$parent.$store.state.units;
                vm.is_update = 0;
                vm.IDrand();
            }
            start();
        }
    },
    removeOrder(k){
        let vm = this;
        swal.fire({
            title: 'Are you sure to remove unit?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            let list = [];
            if (result.value) {
                 for (let i = 0; i < vm.units_list.length; i++){
                    if(k != i){
                        list.push(vm.units_list[i]);
                    }
                }
                vm.units_list = list;
                swal.fire(
                    'Success',
                    'Unit removed successfully',
                    'success'
                )
            }else{
                return false;
            }
        })
    },
    changeOrder(type, k) {
        let vm = this;
        if(type == 'up'){
            if(k != 0){
                let list = [];
                for (let i = 0; i < vm.units_list.length; i++){
                    if(k - 1 == i){
                        list.push(vm.units_list[k]);
                    }else if( k == i){
                        list.push(vm.units_list[k-1]);
                    }else{
                        list.push(vm.units_list[i]);
                    }
                }
                vm.units_list = list;
            }
        }else{
            if(k+1 != vm.units_list.length){
                let list = [];
                for (let i = 0; i < vm.units_list.length; i++){
                    if(k + 1 == i){
                        list.push(vm.units_list[k]);
                    }else if( k == i){
                        list.push(vm.units_list[k+1]);
                    }else{
                        list.push(vm.units_list[i]);
                    }
                }
                vm.units_list = list;
            }
        }
        vm.units_list
    },
    formOpen(){
        this.is_open = this.is_open == 1 ? 0 : 1;
        this.IDrand();
        this.units_list = this.$parent.$store.state.units;
        this.selection = this.$parent.$store.state.units;
        this.course = this.$parent.$store.state.course;
    },
    codeDescription({ unit_code, unit_title, unit_type }) {
      // return `${code} — ${description} [${unit_type}]`;
      return `${unit_code} — ${unit_title}`;
    },
    topFunction() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
    edit(row) {
        this.is_update = 1;
        this.fields = row;
        this.units_list = row.course_units;
        this.topFunction();
    },
    remove(row) {

        swal.fire({
            title: 'Are you sure to remove training delivery location?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                let list = [];
                this.prospectus_list.forEach(el => {
                    if(el.id != row.id){
                        list.push(el);
                    }
                })
                this.prospectus_list = list;
                swal.fire(
                    'Success',
                    'Training delivery location removed successfully',
                    'success'
                )
            }else{
                return false;
            }
        })


    }
    
  }
};
</script>

<style scoped>
.hide-form {
    display: none;
}
.formunits {
  counter-reset: my-awesome-counter;
}
.formunits .unitsclass .multiselect__tags-wrap {
  display: inline-grid;
}
.formunits .unitsclass .multiselect__tags-wrap .multiselect__tag:before {
  counter-increment: my-awesome-counter;
  content: counter(my-awesome-counter) ". ";
  color: #024b67;
  font-weight: bold;
}
</style>