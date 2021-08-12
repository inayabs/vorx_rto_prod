<template>
  <div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">Payment List</h6>
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
                                        <label for="month">Start Month: <span class="badge"></span></label>
                                        <input type="month" class="form-control" v-model="from" value="">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="year">End Month: <span class="badge"></span></label>
                                        <input type="month" class="form-control" v-model="to" value="" :min="from" :disabled="disableTo"> 
                                        <!-- <input type="number" class="form-control" id="year" placeholder=""> -->
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="year">Course:</label>
                                        <select name="" id="" class="form-control" v-model="get_course">
                                            <option :value="key" v-for="(itm,key) in courses" :key="key">
                                                <span v-if="key != '*'">{{key}} - {{itm}}</span>
                                                <span v-else>{{itm}}</span>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="clearfix" style="height: 22px;"></div>
                                        <button @click="resetFields" :class="'btn btn-warning'" title="Reset Fields"><i class="fa fa-rotate-left"></i></button>
                                        <button type="submit" @click="generateList" :class="'btn btn-'+app_color">Generate</button>
                                    </div>
                                </div>
                            </form>
                        </div>  
                    </div>
                </div>
                <div>
                    <v-client-table :class="'header-'+app_color" :data="payments" :columns="columns" :options="options" ref="paymentsTable">
                        <div slot="funded_student_course" slot-scope="{row}">
                            {{row.course_code}} - {{row.course.name}}
                        </div>
                        <div slot="payment_date" slot-scope="{row}">
                            {{row.payment_date | dateformat}}
                        </div>
                    </v-client-table>
                </div>
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
  filters:{
        dateformat: function(date) {
        if (!date) return "";
        date = moment(date).format("DD/MM/YYYY");
        return date;
        },
  },
  data() {
    return {
        from:null,
        to:null,
        disableTo:true,
        app_color:app_color,
        courses:courses,
        get_course:'*',
        payments:[],
        columns:['student.party.name','funded_student_course','amount_due','total_paid'],
        options:{
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
                'funded_student_course':'Course',
                'payment_methods_id':'Payment Method'
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
    }
  },
  created() {
    // this.fetchStudents();
  },
  watch:{
      from(val){
          if(typeof val!='undefined' && val!=null){
            var fromDate = new Date(val);
            if(fromDate=='Invalid Date'){
                this.disableTo = true;
                this.to = null;
            }else{
                var newDate = new Date(fromDate.setMonth(fromDate.getMonth()+1));
                var toDate = moment(newDate).format('YYYY-MM');
                
                this.disableTo = false
                this.to = toDate;
            }            
          }else{
              this.to = null;
          }
      },
      to(val){
          if(typeof val=='undefined'||val==null){
              this.disableTo = true;
          }
      }
  },
  methods: {
      generateList(){
        let loading = null;
        if(this.from > this.to){
            swal.fire({
            type: "error",
            title: 'Start Month must be less than End Month.',
            });
            // return false;
        }
        loading = swal.fire({
            title: 'Processing Payments List...',
            // html: '',// add html attribute if you want or remove
            allowOutsideClick: false,
            onBeforeOpen: () => {
                swal.showLoading()
            },
        });

        axios.post('/reports/generate-payments',{
            from: this.from,
            to: this.to,
            get_course: this.get_course,
        }).then(
            response=>{
                this.payments = response.data
                swal.close();
            }
        ).catch(
            err=>{
                console.log(err);
            }
        );
      },
      exportExcel(){
          
      },
      resetFields(){
          this.get_course = '*';
          this.from = null;
        //   this.to = null;
      }
  },
};
</script>
