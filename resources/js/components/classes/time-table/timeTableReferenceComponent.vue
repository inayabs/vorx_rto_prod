<template>
  <div>
      <div class="row mb-2 d-flex justify-content-between">
        <div class="col-md-6">
            <a :href="'/classes'" v-bind:class="'btn btn-'+app_color+' text-primary btn-sm text-light'">
                <i class="fas fa-long-arrow-alt-left"></i> Back
            </a>
        </div>
      </div>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Time Table ({{getClass.desc}})</h6>
        </div>
        <div class="card-body">
          <div class="row">
            
          </div>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group" >
                  <label for="company_name"><span style="">Duration: <i v-if="getClass.time_table_type == 'Straight'">(Month)</i><i v-else>(Year)</i></span></label>
                  <input type="month" class="form-control" v-if="getClass.time_table_type == 'Straight'" v-model="tt.duration_month">
                  <select v-else name="" class="form-control" v-model="tt.duration_year">
                    <option :value="i" v-for="(i) in year_duration" :key="i">{{i}}</option>
                  </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label class="w-100 mb-2" for="company_name">Training Days Per Week:
                  </label>
                    <span v-for="(i,k) in tt.training_days_weekly" :key="k" class="custom-switch mt-3 mx-2">
                        <input type="checkbox" class="custom-control-input" v-bind:id="k" v-model="tt.training_days_weekly[k]">
                        <label class="custom-control-label" v-bind:for="k">{{k}}</label>
                    </span>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                  <label for="company_name">Hours Per Day:
                  </label>
                  <input type="number" min="0" class="form-control" v-model="training_hours_daily">
              </div>
            </div>
            <div class="col-md-2 text-right mb-2 pt-3">
              <button class="btn btn-danger" @click="addBreak" v-if="getClass.time_table_type != 'Straight'"><i class="fas fa-plus"></i> Break</button>
              <button class="btn btn-warning" @click="autoFill(-1)" v-else><i class="fas fa-list"></i> Auto Fill</button>
              <button class="btn btn-success" @click="saveTimeTable"><i class="fas fa-save"></i> Save</button>
            </div>
          </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th class="text-center" :class="['background-'+app_color]" width="5%" scope="col">#</th>
                    <th class="text-center" :class="['background-'+app_color]" width="10%" scope="col">Unit Code</th>
                    <th class="text-center" :class="['background-'+app_color]" width="25%" scope="col">Unit Title</th>
                    <th class="text-center" :class="['background-'+app_color]"  scope="col">Start / End Dates</th>
                    <!-- <th class="text-center" :class="['background-'+app_color]" scope="col">End Date</th> -->
                    <th class="text-center" :class="['background-'+app_color]" width="10%" scope="col">Training Hours</th>
                    <th class="text-center" :class="['background-'+app_color]" width="10%" scope="col">Weeks</th>
                    <th class="text-center" :class="['background-'+app_color]" scope="col">Trainers</th>
                    <!-- <th class="text-center" :class="['background-'+app_color]" scope="col">Holidays</th> -->
                    <th class="text-center" :class="['background-'+app_color]" scope="col">-</th>
                    </tr>
                </thead>
                <!-- <tbody> -->
                  <draggable v-model="tt.time_table" tag="tbody" @start="drag=true" @end="drag=false">
                    <tr v-for="(item, key) in tt.time_table" :key="key">
                        <td>{{item.order = key+1}}</td>
                        <td v-if="typeof item.is_break !== 'undefined'" colspan="2" class="text-center"> Break </td>
                        <td v-if="typeof item.is_break === 'undefined'">{{item.unit.code}}</td>
                        <td v-if="typeof item.is_break === 'undefined'">{{item.unit.description}}</td>
                        <td>
                          <date-picker 
                            mode='range'
                            :input-props='{
                              class: "vc-appearance-none vc-text-base vc-text-gray-800 vc-bg-white vc-border vc-border-gray-400 vc-rounded vc-w-full vc-py-2 vc-px-3 vc-leading-tight focus:vc-outline-none focus:vc-shadow",
                              readonly: true,
                              style: item.dateError == 1 ? "border: 1px solid red !important;" : "",
                              onchange: ""
                            }'
                            :id="'dp-'+key"
                            :disabled-dates ="disabled_dates"
                            :dayclick ="getWeeks(key)"
                            :masks="{ input: 'DD/MM/YYYY' }" 
                            locale="en" 
                            v-model="tt.time_table[key]['dates']" ></date-picker>
                            
                        </td>
                        <td v-if="typeof item.is_break === 'undefined'"><input type="number" readonly min="0" class="form-control" v-model="tt.time_table[key]['training_hours']"></td>
                        <td v-else></td>
                        <td><input type="number" min="0" readonly class="form-control" v-model="tt.time_table[key]['weeks']"></td>
                        
                        <!-- trainers -->
                        <td v-if="typeof item.is_break === 'undefined'">

                          <multiselect
                            :class="'multiselect-color-'+app_color"
                            :options="trainers"
                            :multiple="false"
                            :custom-label="trainerLabel"
                            :close-on-select="true"
                            :select-label="''"
                            :searchable="false"
                            :limit="3"
                            :limit-text="limitText"
                            :max-height="600"
                            :show-no-results="false"
                            :hide-selected="true"
                            :id="'trainer-'+key"
                            v-model="tt.time_table[key]['trainer']"
                            placeholder="Select Trainer"
                          >
                          <span slot="noResult">Oops! No Unit found. Consider changing the search query.</span>
                          </multiselect>

                        </td>
                        <td v-else></td>

                        <td v-if="typeof item.is_break !== 'undefined'" colspan="2" class="text-center"> <button class="btn btn-danger btn-sm" @click="removeBreak(key)"><i class="fas fa-minus"></i></button> </td>
                        <td v-else></td>
                    </tr>
                  </draggable>
                    <!-- <tr v-for="(item, key) in timeTable.time_table" :key="key">
                      
                    </tr> -->
                <!-- </tbody> -->
                <tfoot>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <!-- <td></td> -->
                  <td class="text-right">{{tt.total_training_hours}}</td>
                  <td class="text-right">{{tt.total_weeks}}</td>
                  <td></td>
                  <td></td>
                </tfoot>
            </table>
            
        </div>
      </div>
  </div>
</template>


<script>
import moment from "moment";
import draggable from 'vuedraggable'
import endDatePicker from 'v-calendar/lib/components/date-picker.umd'

export default {
  name: "time-table",
  // mounted() {
  //     console.log('Component mounted.')
  // }
  components: {
    draggable,
    endDatePicker,
  },
  data() {
    return {
      app_color: app_color,
      getClass: window.class,
      trainers: window.trainers,
      // year_duration: [], 
      // tt:  window.time_table,
      training_hours_daily: 4,
      tt: {},
      // class_start_day: 'Monday',
      disabled_dates: []
    };
  },
  filters: {
    dateformat: function(date) {
      if (!date) return "";
      date = moment(date).format("DD/MM/YYYY");
      return date;
    },
    timeformat: function(time){
        if (!time) return "";
        time = moment('1111-11-11 '+time).format("hh:mm A");
        return time;
    }
  },
  computed: {
    year_duration: function() {
      let years = [];
      for (let i = 1; i < 10; i++) {
        years.push(moment().add(i, 'years').format('YYYY'))
      }
      return years;
    }
  },
  created() {
    this.tt = window.time_table;
  },
  methods: {
    trainerLabel({firstname, lastname}) {
      return firstname + ' ' + lastname;
    },
    limitText(count) {
      return `and ${count} other trainers`;
    },
    saveTimeTable() {
      let vm = this;
      swal.fire({
        title: 'Save time table?',
        // text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {

            swal.fire({
                title: 'Saving time table...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
            });

            axios.post('/classes/time-table',{
              class: vm.getClass,
              tt: vm.tt,
            })
            .then(function(res){
                // console.log(res.data);
                if(res.data.status == 'success'){
                    // window.location.href = '/online-enrolment/process/'+res.data.process;
                  swal.fire(
                    'Success!',
                    'Time table saved successfully',
                    'success'
                  )
                }
            })
            .catch(function (err){
                // console.log(err);
                swal.fire(
                    'Oppss!',
                    'there seems to be a problem!',
                    'error'
                )
            })
            
        }
      })
    },
    sample(){
      // alert('sample');
      console.log('wew')
    },
    addBreak(){
      let b = {
        is_break : 1,
        start_date: null,
        end_date: null,
        training_hours: null,
        weeks: null,
        order: null,
        holidays: []
      }
      this.tt.time_table.push(b); 
    },
    removeBreak(key){
      let tt = [];
      this.tt.time_table.forEach(element => {
        if(key+1 != element.order){
          tt.push(element);
        }
      });
      this.tt.time_table = tt;
    },
    totalTrainingHours(type){
      let total = 0;
      // console.log('click');
      this.tt.time_table.forEach(element => {
        if(type == 'th' && typeof element.training_hours !== 'undefined' && ['', null].indexOf(element.training_hours) == -1){
          if(typeof element.is_break === 'undefined'){
            total = parseInt(total) + parseInt(element.training_hours);
          }
        }
        if(type == 'wk' && typeof element.weeks !== 'undefined' && ['', null].indexOf(element.weeks) == -1){
          total = parseInt(total) + parseInt(element.weeks);
        }
      });
      // console.log(total);
      if(type == 'th'){
        this.tt.total_training_hours = Number.isNaN(total) ? 0 : total;
      }else{
        this.tt.total_weeks = Number.isNaN(total) ? 0 : total;
      }
    },
    getWeeks(key){
      if(key == 0){
        // console.log(moment().format('ddd'));
        // console.log(this.tt.time_table[key].start_date);
        
      }
      let start = null, end = null;
      // this.tt.time_table[key].dateError = 0;

      if(typeof this.tt.time_table[key].dates !== 'undefined'){
          // this.disabled_dates[key] = this.tt.time_table[key].dates;
          // console.log(this.tt.time_table[key].dates);
          this.autoFill(key)
      }

      
      // console.log('order - '+this.tt.time_table[key].order)
      // console.log('start - '+start)
      // console.log('end - '+end)

      
      // console.log(this.tt.time_table[key]);
    },
    autoFill(hasDates) {
      // console.log(this.tt.class_start_day);
      let dayStart = null;
      let vm = this;
      let table = [];
      let weekCount = 0;

      for ( var k in vm.tt.training_days_weekly ) {

        if (vm.tt.training_days_weekly.hasOwnProperty(k)) {
          if(dayStart == null && vm.tt.training_days_weekly[k] == 1){
            dayStart = k;
          }
          if(vm.tt.training_days_weekly[k] == 1){
            weekCount++;
          }
            // console.log(k + " -> " + vm.tt.training_days_weekly[k]);
        }
      }

      // console.log(weekCount);
      // console.log(hasDates);
      if(hasDates == -1){
        if(typeof vm.tt.duration_month === 'undefined'){
          swal.fire(
            'Oppss..',
            'Duration (Month) is required',
            'error'
          )
          return false
        }
        // console.log()
        
        let dateStart = null;
        // let dateStart = moment(vm.tt.duration_month).isoWeekday(8);
        // if(dateStart.date() == 8){
        //   dateStart = dateStart.isoWeekday(-6)
        // }
        // console.log(dateStart)
        // return false
        vm.tt.time_table.forEach(e => {
          // console.log(e);
        //   // let DayHours = parseInt(vm.tt.training_hours_daily) * parseInt(vm.tt.training_days_weekly)
          e.dates = {}
        //   // console.log(DayHours);
          let i = 0;
          let td = 0;
          // console.log('wew');
          let dateEnd = null;
          // if(typeof e.dates.start === 'undefined' && typeof e.dates.end === 'undefined'){
            if(e.order == 1){
              let x = 0;
              let count = 0;
              let dayNow = moment(vm.tt.duration_month);
              while (x < 1){
                console.log(dayNow._d);
                if(dayNow.format('ddd') == dayStart){
                  dateStart = moment(dayNow._d);
                  x = 1;
                }else{
                  count++
                  dayNow = moment(vm.tt.duration_month).add(count, 'days');
                }
              }

            }
  
            if(e.order != 1){
              let x = 0;
              let count = 1;
              let dayNext = moment(dateStart._d);
              console.log(dayNext._d)
              while (x < 1){
                // console.log(x);
                if(count == 1){
                  dayNext.add(count, 'days');
                }
  
                if(typeof vm.tt.training_days_weekly[dayNext.format('ddd')] !== 'undefined' && [1,true].indexOf(vm.tt.training_days_weekly[dayNext.format('ddd')]) != -1){
                  dateStart = dayNext;
                  x = 1;
                }else{
                  count++
                  dayNext.add(count, 'days');
                }
              }
            }
            // console.log(dateStart._d);
            dateEnd = moment(dateStart._d)
  
          // }else{
          //   dateStart = moment(e.dates.start);
          //   dateEnd = moment(e.dates.start);
          // }
  
          
          while ( i < e.training_hours){
            let x = 0;
            // let count = 1;
            if(vm.tt.training_days_weekly[dateEnd.format('ddd')] == 1){
              i = i + parseInt(vm.training_hours_daily);
              td++
            }
            if(i < e.training_hours){
              dateEnd.add(1, 'days');
            }
            
          }
  
          // console.log(i);
          e.weeks = Math.floor(td / weekCount);
          e.dates = {
            start: dateStart._d,
            end: dateEnd._d
          }
          // e.start_date = dateStart._d;
          // e.end_date = dateEnd._d
          // console.log(dateStart._d);
          // console.log(dateEnd._d);
          dateStart = moment(dateEnd._d);
          // console.log(e);
          // console.log('training days count - '+ td)
  
          table.push(e);
          // console.log('end');
          vm.tt.time_table = table;
        })
        
      }else{
        console.log('o')
          // FOR DATE CHANGES
          if(typeof vm.tt.time_table[hasDates].dates.start === 'undefined' && typeof vm.tt.time_table[hasDates].dates.end === 'undefined'){
            return false
          }
          table = vm.tt.time_table[hasDates];
          let td = 0;
          let i = 0;
          let dateStart = moment(vm.tt.time_table[hasDates].dates.start);
          let dateEnd = moment(vm.tt.time_table[hasDates].dates.end);
          let runDate = moment(dateStart._d);
          // console.log(runDate.format('YYYY-MM-DD'))
          // console.log(dateEnd.format('YYYY-MM-DD'))
          // console.log(vm.tt.time_table[hasDates].training_hours)
          while ( runDate.format('YYYY-MM-DD') <= dateEnd.format('YYYY-MM-DD')){
          //   let x = 0;
          //   // let count = 1;
          //   console.log(runDate);
            if(vm.tt.training_days_weekly[runDate.format('ddd')] == 1){
              i = i + parseInt(vm.tt.training_hours_daily);
              td++
            }
              // console.log(runDate.format('YYYY-MM-DD'))
            // if(i < vm.tt.time_table[hasDates].training_hours){
              runDate.add(1, 'days');
            // }  
          }
          // console.log(vm.tt.training_hours_daily)
          // console.log(i)
          table.weeks = Math.floor(td / weekCount);
          // table.dates = {
          //   start: dateStart._d,
          //   end: dateEnd._d
          // }
          if(vm.getClass.time_table_type == 'Rotating'){
            table.training_hours = i;
          }
          // console.log(table);
          // console.log(vm.tt.time_table[hasDates]);
          // vm.tt.time_table[hasDates] = table;
      }
      this.totalTrainingHours('th');
      this.totalTrainingHours('wk');
      // console.log(dateStart);
      
    },
    getDates(){
      this.tt.time_table.forEach(e => {
        let d = {};
        // console.log(e.dates);
        if(typeof e.dates !== 'undefined'){
          if(typeof e.dates.start !== 'undefined'){
            d.start = moment(e.dates.start)._d;
          }
          if(typeof e.dates.end !== 'undefined'){
            d.end = moment(e.dates.end)._d;
          }
        }
        e.dates = d;
      })
    }
  },
  watch: {
        tt : function (item){
          let data = [];
          item.time_table.forEach(e => {
            let th = 0;
            // if(typeof e.dates !== 'undefined'){
            //   if(typeof e.dates.start !== 'undefined'){
            //     e.dates.start = moment(e.dates.start)._d;
            //   }
            //   if(typeof e.dates.end !== 'undefined'){
            //     e.dates.end = moment(e.dates.end)._d;
            //   }
            // }
            // if(typeof e.end_date !== 'undefined'){
            //   e.end_date = moment(e.end_date)._d;
            // }
            if(typeof e.unit !== 'undefined' && typeof e.training_hours === 'undefined'){
              th = e.unit.scheduled_hours
            }else if(typeof e.training_hours !== 'undefined'){
              th = e.training_hours
            }

            if(typeof e.weeks === 'undefined'){
              e.weeks = 0;
            }
            // e.totalTrainingHours;
            e.training_hours = th;
            data.push(e);
          })
          this.tt.time_table = data;
          this.totalTrainingHours('th');
          this.totalTrainingHours('wk');
          this.getDates();
        }
  },
};
</script>

<style scoped>
  .dateError {
    border: 1px solid red !important;
  }
</style>