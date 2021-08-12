<template>
  <div>
    <div class="row mb-3">
        <div class="col-md-6 pull-right text-left">
            <!-- <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('back')" ><i class="fas fa-chevron-circle-left"></i> Course Package</button> -->
            <button class="btn btn-md" :class="'btn-info'" @click="proceedTab('back')" ><i class="fas fa-chevron-circle-left"></i> Course Structure and Fees</button>
        </div>
        <div class="col-md-6 pull-right text-right">
            <button class="btn btn-md" :class="'btn-success'" @click="proceedTab('next')" ><i class="fas fa-check"></i> Finish</button>
        </div>
    </div>
    <div id="accordion">
        <div class="card mb-3" v-for="(item, k) in locations" :key="k" :id="item">
            <div class="card-header px-4 py-3" :class="['background-'+app_color, 'text-white']">
                <span class="float-left text h5 mb-0"> {{course.code}} - {{course.name}} Class ({{item}})</span>
                <span class="float-right">
                    <button class="btn btn-sm btn-secondary" :data-target="'#collapse'+item" aria-expanded="true" :aria-controls="'collapse'+item" data-toggle="collapse" ><i class="fas fa-window-minimize"></i></button>
                </span>
            </div>
            <!-- <h5 class="card-header " :class="['background-'+app_color, 'text-white']">Course Structure and Fees ({{item}})</h5> -->
            <div :id="'collapse'+item" class="collapse" :class="k == 0 ? 'show': ''" :aria-labelledby="item" data-parent="#accordion">
                <div class="card-body">
                    <!-- <h5 class="card-title">Special title treatment</h5> -->
                    <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    <!-- <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'" id="directEdit">
                        <h6>Funding / Non Funding Structure and Fees</h6>
                    </div> -->
                    <!-- <div class="clearfix"></div> -->
                    <div class="form-padding-left-right">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Description:</label>
                                    <input type="text" v-model="fields[item]['desc']" class="form-control" id="" :class="[errors && errors[item+'-desc'] ? 'border-danger' : '']" />
                                    <div v-if="errors && errors[item+'-desc']" class="badge badge-danger">{{ errors[item+'-desc'][0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Trainer:</label>
                                    <!-- <input type="number" min="0" v-model="fields[item]['trainer']" class="form-control" id="" :class="[errors && errors[item+'-trainer'] ? 'border-danger' : '']" /> -->
                                    <select name="" id="" v-model="fields[item]['trainer']" class="form-control">
                                        <option v-for="(v,k) in trainers" :value="v.id" :key="k">{{v.firstname}} {{v.lastname}}</option>
                                    </select>
                                    <div v-if="errors && errors[item+'-trainer']" class="badge badge-danger">{{ errors[item+'-trainer'][0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Venue:</label>
                                    <input type="text" v-model="fields[item]['venue']" class="form-control" id="" :class="[errors && errors[item+'-venue'] ? 'border-danger' : '']" />
                                    <div v-if="errors && errors[item+'-venue']" class="badge badge-danger">{{ errors[item+'-venue'][0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Start Date:</label>
                                    <date-picker :masks="{ input: 'DD/MM/YYYY' }" locale="en" v-model="fields[item]['start_date']" ></date-picker>
                                    <!-- <input type="number" min="0" v-model="fields[item]['start_date']" class="form-control" id="" :class="[errors && errors[item+'-start_date'] ? 'border-danger' : '']" /> -->
                                    <div v-if="errors && errors[item+'-start_date']" class="badge badge-danger">{{ errors[item+'-start_date'][0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">End Date:</label>
                                    <date-picker :masks="{ input: 'DD/MM/YYYY' }" locale="en" v-model="fields[item]['end_date']" ></date-picker>
                                    <!-- <input type="number" min="0" v-model="fields[item]['end_date']" class="form-control" id="" :class="[errors && errors[item+'-end_date'] ? 'border-danger' : '']" /> -->
                                    <div v-if="errors && errors[item+'-end_date']" class="badge badge-danger">{{ errors[item+'-end_date'][0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Start Time:</label>
                                    <input type="time" v-model="fields[item]['start_time']" class="form-control" id="" :class="[errors && errors[item+'-start_time'] ? 'border-danger' : '']" />
                                    <div v-if="errors && errors[item+'-start_time']" class="badge badge-danger">{{ errors[item+'-start_time'][0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">End Time:</label>
                                    <input type="time" v-model="fields[item]['end_time']" class="form-control" id="" :class="[errors && errors[item+'-end_time'] ? 'border-danger' : '']" />
                                    <div v-if="errors && errors[item+'-end_time']" class="badge badge-danger">{{ errors[item+'-end_time'][0] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

import moment from 'moment';

export default {
  name: "course-class",
  data() {
    return {
      course: {},
      locations: [],
      trainers: [],
      slct_option_state: window.slct_option_state,
      org_name: window.org_name,
      fields: {},
      errors: [],
      app_color: app_color
    };
  },
  created() {
    // this.fetchData();
  },
  watch: {
    fields: function(value) {
      let d = Object.keys(value)
      for (let i = 0; i < d.length; i++) {
        if(typeof value[d[i]].start_date !== 'undefined' && ['',null].indexOf(value[d[i]].start_date)){
            moment(value[d[i]].start_date)._d
        }
        if(typeof value[d[i]].end_date !== 'undefined' && ['',null].indexOf(value[d[i]].end_date)){
            moment(value[d[i]].end_date)._d
        }
        // console.log(i);
      }
    }
  },
  computed: {
      
  },
  methods: {
    finish() {
        let data = this.$parent.$store.state;

        swal.fire({
            title: 'Finishing setup..',
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
                swal.showLoading()
            },
        });

        console.log(data);
        axios.post('/course-setup/finish',{
            data: data
        }).then(function(res){
            console.log(res);
            if(res.data.status == 'success'){
                swal.fire(
                    'Hooray!',
                    res.data.message,
                    'success'
                )
                swal.fire({
                    title: "Hooray!",
                    text: res.data.message,
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '/course';
                    }
                });
            }else{
                swal.fire(
                    'Oppss..',
                    'There seems to be a problem..',
                    'error'
                )
            }
        }).catch(function(err){
            console.log(err);
            swal.fire(
                'Oppss..',
                'There seems to be a problem..',
                'error'
            )
        })

        // swal.fire(
        //     'Deleted!',
        //     'Your file has been deleted.',
        //     'success'
        // )
    },
    proceedTab(proceed){
        this.$parent.$store.state.classes = this.fields;
        document.getElementById("nav-class-tab").classList.add('disabled')
        if(proceed == 'back'){
            // document.getElementById("nav-package-tab").classList.remove('disabled')
            document.getElementById("nav-matrix-tab").classList.remove('disabled')
            this.$parent.$children[3].fetchData();
            $('a[href="#nav-matrix"]').tab('show')
            // $('a[href="#nav-package"]').tab('show')
        }
        if(proceed == 'next'){
            swal.fire({
                title: 'Finished setting up course?',
                // text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    this.finish();
                }
            })
        }
    },
    fetchData() {
    this.course = this.$parent.$store.state.course;
    this.locations = this.$parent.$store.state.course_locations;
    this.trainers = this.$parent.$store.state.class_opt.trainers;
    this.fields = this.$parent.$store.state.classes;
    // console.log('in');
    let data = {};
    this.locations.forEach(el => {
        if(typeof this.fields[el] === 'undefined'){
            data[el] = {};
        }else{
            data[el] = this.fields[el];
        }
    });
    this.fields = data;
},
    addBlock: function() {},
    saveBlock(index) {},
    removeBlock: function(index) {
      
    }
  }
};
</script>

<style lang="scss" scoped>
$white: #ffffff;
$grey: #e0dfdf;
$light-blue: #e0e9ff;
$green: #1cc88a;
$red: #e74a3b;
.tab-pane {
  border: 1px solid $grey;
  border-top: none;
  padding: 1.3rem;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
  background-color: $white;
}
.card {
  border-radius: 0;
  overflow: initial;
  .card-header {
    background-color: $light-blue;
    border-bottom: 0;
    padding: 0 1.25rem;
    .collapse-link {
      cursor: default;
      &:hover,
      &[aria-expanded="true"] {
        h5 {
          opacity: 1;
        }
      }
      &[aria-expanded="true"] {
        h5:after {
          content: "\f0d7";
        }
      }
      &[aria-expanded="false"] {
        h5:after {
          content: "\f0d7";
          transform: rotate(180deg);
        }
      }
    }
    h5 {
      padding: 0.75rem 0;
      border-bottom: 1px solid $grey;
      opacity: 0.7;
      &:after {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        display: inline-block;
        margin-right: 10px;
        float: right;
      }
    }
    .btn-options {
      position: absolute;
      top: 1px;
      left: -10px;
      .opt-btn {
        margin: 1px 0;
        height: 20px;
        width: 20px;
        background-color: $white;
        font-size: 9px;
        border: 1px solid $grey;
        border-radius: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        outline: none;
        &:hover {
          color: $white !important;
          transform: scale(1.5);
        }
        &:first-child {
          color: #1cc88a;
          &:hover {
            background-color: $green;
          }
        }
        &:last-child {
          color: $red;
          &:hover {
            background-color: $red;
          }
        }
      }
    }
  }
  &:last-of-type {
    border-bottom: 1px solid #e3e6f0;
  }
  .confirm-delete {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgb(231, 74, 59, 0.6);
  }
}
</style>