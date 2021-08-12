<template>
  <div>
    <div class="row mb-3">
        <div class="col-md-6 pull-right text-left">
            <!-- <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('back')" ><i class="fas fa-chevron-circle-left"></i> Course Delivery Location</button> -->
            <button class="btn btn-md" :class="'btn-info'" @click="proceedTab('back')" ><i class="fas fa-chevron-circle-left"></i> Course Delivery Location</button>
        </div>
        <div class="col-md-6 pull-right text-right">
            <!-- <button class="btn btn-md" :class="'btn-'+app_color" @click="proceedTab('next')" ><i class="fas fa-chevron-circle-right"></i> Course Package</button> -->
            <button class="btn btn-md" :class="'btn-info'" @click="proceedTab('next')" ><i class="fas fa-chevron-circle-right"></i> Class</button>
        </div>
    </div>
    <div id="accordion">
        <div class="card mb-3" v-for="(item, k) in locations" :key="k" :id="item">
            <div class="card-header px-4 py-3" :class="['background-'+app_color, 'text-white']">
                <span class="float-left text h5 mb-0">Structure and Fees ({{item}})</span>
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
                    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'" id="directEdit">
                        <h6>Funding / Non Funding Structure and Fees</h6>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-padding-left-right">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="prospectus_name">Concessional Fee:</label>
                                    <input type="number" min="0" v-model="fields[item]['domestic']['concessional_fee']" class="form-control" id="prospectus_name" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="prospectus_name">Non-Concessional Fee:</label>
                                    <input type="number" min="0" v-model="fields[item]['domestic']['non_concessional_fee']" class="form-control" id="prospectus_name" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="prospectus_name">Full Fee / Fee for Service:</label>
                                    <input type="number" min="0" v-model="fields[item]['domestic']['full_fee']" class="form-control" id="prospectus_name" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- International Funding -->
                    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'" id="directEdit">
                        <h6>Offer Letter Structure and Fees</h6>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-padding-left-right">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">CRICOS Code: <i class="info" :class="'text-'+app_color">(Note: this field is required for Course Package)</i></label>
                                    <input type="text" v-model="fields[item]['international']['cricos_code']" class="form-control" id="" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Duration (Weeks):</label>
                                    <input type="number" min="0" v-model="fields[item]['international']['wk_duration']" class="form-control" id="" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Material Fee:</label>
                                    <input type="number" min="0" v-model="fields[item]['international']['material_fees']" class="form-control" id="" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Enrolment Fee:</label>
                                    <input type="number" min="0" v-model="fields[item]['international']['enrolment_fees']" class="form-control" id="" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Onshore Fee:</label>
                                    <input type="number" min="0" v-model="fields[item]['international']['onshore_tuition_individual']" class="form-control" id="" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Offshore Fee:</label>
                                    <input type="number" min="0" v-model="fields[item]['international']['offshore_tuition_individual']" class="form-control" id="" :class="[errors && errors.name ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
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
export default {
  name: "course-matrix",
  data() {
    return {
      course: {},
      locations: [],
      slct_option_state: window.slct_option_state,
      org_name: window.org_name,
      fields: {},
      errors: [],
      app_color: app_color
    };
  },
  created() {
    this.fetchData();
  },
  watch: {
    fields: function(value, index) {
      for (let i = 0; i < index; i++) {
        if (value[i].cricos_code != null) {
          this.errors[i].cricos_code = "";
        }
        if (value[i].location != null) {
          this.errors[i].location = "";
        }
        // console.log(i);
      }
    }
  },
  computed: {
      
  },
  methods: {
    proceedTab(proceed){
        this.$parent.$store.state.structure_fees = this.fields;
        document.getElementById("nav-matrix-tab").classList.add('disabled')
        if(proceed == 'back'){
            document.getElementById("nav-prospectus-tab").classList.remove('disabled')
            this.$parent.$children[2].formOpen();
            $('a[href="#nav-prospectus"]').tab('show')
        }
        if(proceed == 'next'){
            this.$parent.$children[4].fetchData()
            // document.getElementById("nav-package-tab").classList.remove('disabled')
            document.getElementById("nav-class-tab").classList.remove('disabled')
            // this.is_open = 0;
            $('a[href="#nav-class"]').tab('show')
            // $('a[href="#nav-package"]').tab('show')
        }
    },
    fetchData() {
    this.course = this.$parent.$store.state.course;
    this.locations = this.$parent.$store.state.course_locations;
    // console.log('in');
    let data = {};
    this.locations.forEach(el => {
        if(typeof this.fields[el] === 'undefined'){
            data[el] = {
                domestic: {},
                international: {}
            };
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
.info{
    font-size: 12px !important;
}
</style>