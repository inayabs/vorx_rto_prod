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
            <div class="col-md-6"></div>
            <div class="col-md-6 text-right">
              <button class="btn btn-warning" v-if="is_save == 1" @click="resetTimeTable"><i class="fas fa-undo"></i> Reset</button>
              <!-- <button class="btn btn-warning" @click="autoFill(-1)"><i class="fas fa-list"></i> Generate</button> -->
              <button class="btn btn-success" @click="saveTimeTable"><i class="fas fa-save"></i> Save</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group" >
                  <!-- <label for="company_name"><span style="">Duration: <i v-if="getClass.time_table_type == 'Straight'">(Month)</i><i v-else>(Year)</i></span></label>
                  <input type="month" class="form-control" v-if="getClass.time_table_type == 'Straight'" v-model="tt.duration_start_date">
                  <select v-else name="" class="form-control" v-model="tt.duration_year">
                    <option :value="i" v-for="(i) in year_duration" :key="i">{{i}}</option>
                  </select> -->
                  <label for="start_date"><span style="">Class Start Date: </span></label>
                  <!-- <input type="month" class="form-control" v-if="getClass.time_table_type == 'Straight'" v-model="tt.duration_start_date"> -->
                  <date-picker 
                    mode='single'
                    :input-props='{
                      class: "vc-appearance-none vc-text-base vc-text-gray-800 vc-bg-white vc-border vc-border-gray-400 vc-rounded vc-w-full vc-py-2 vc-px-3 vc-leading-tight focus:vc-outline-none focus:vc-shadow",
                      readonly: true,
                      onchange: ""
                    }'
                    :masks="{ input: 'DD/MM/YYYY' }" 
                    locale="en" 
                    v-model="tt.duration_start_date" ></date-picker>
              </div>
            </div>

            <!-- <div class="col-md-2">
              <div class="form-group">
                  <label for="company_name">Hours per day:
                  </label>
                  <input type="number" min="0" class="form-control" v-model="training_hours_daily">
              </div>
            </div> -->

            <!-- <div class="col-md-2">
              <div class="form-group">
                  <label for="company_name">Hours per week:
                  </label>
                  <input type="number" min="0" class="form-control" v-model="training_hours_weekly">
              </div>
            </div> -->

            <div class="col-md-9">
              <div class="form-group">
                  <label class="w-100" for="trainday">Training Days:</label>
                  <multiselect v-model="tt.training_days_weekly" 
                  :options="days" 
                  :multiple="true" 
                  :close-on-select="false" 
                  :clear-on-select="false" 
                  :preserve-search="true"
                  label="value"
                  track-by="day" 
                  placeholder="Select days of training" 
                  :preselect-first="true">
                    <!-- <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} days selected</span></template> -->
                  </multiselect>
                    <!-- <div v-for="(i,k) in tt.training_days_weekly" :key="k" class="daydiv ml-2 float-left">
                        <input type="checkbox" class="chkbx" v-bind:id="k" v-model="tt.training_days_weekly[k]">
                        <span class="chklbl h5" v-bind:for="k">{{k}}</span>
                    </div> -->
                    <!-- <span v-for="(i,k) in tt.training_days_weekly" :key="k" class="custom-switch ml-2">
                        <input type="checkbox" class="custom-control-input" v-bind:id="k" v-model="tt.training_days_weekly[k]">
                        <label class="custom-control-label" v-bind:for="k">{{k}}</label>
                    </span> -->
              </div>
            </div>
            <!-- <div class="col-md-2 text-left">
              <label class="w-100" for="calc"></label>
              <div class="form-group">
                <button class="btn btn-primary form-control" @click="autoFill()"><i class="fas fa-calculator mr-1"></i> Calculate</button>
              </div>
            </div> -->

            <!-- <div class="col-md-2 text-right mb-2 pt-3">
              <button class="btn btn-danger" @click="addBreak" v-if="getClass.time_table_type != 'Straight'"><i class="fas fa-plus"></i> Break</button>
              <button class="btn btn-warning" @click="autoFill(-1)" v-else><i class="fas fa-list"></i> Generate</button>
              <button class="btn btn-success" @click="saveTimeTable"><i class="fas fa-save"></i> Save</button>
            </div> -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                  <label class="w-100" for="timings">Timings:</label>
              </div>
            </div>
            <div class="col-md-12" >
              <table class="table">
                <thead>
                  <tr>
                    <td class="align-middle text-center font-weight-bold">Day</td>
                    <td class="align-middle text-center font-weight-bold">Time Start</td>
                    <td class="align-middle text-center font-weight-bold">Time End</td>
                    <td class="align-middle text-center font-weight-bold">Total Hours</td>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(i,k) in daysFilter" :key="k">
                    <td class="align-middle text-center">{{i.value}}</td>
                    <td><input type="time" @change="TimeCalcTotalHours(k)" class="form-control" v-model="i.time_start"></td>
                    <td><input type="time" @change="TimeCalcTotalHours(k)" class="form-control" v-model="i.time_end"></td>
                    <td class="align-middle text-center">{{i.hours}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
            <div class="table-responsive">
              <table class="table">
                  <thead class="thead-dark">
                      <tr>
                      <th class="text-center" :class="['background-'+app_color]" scope="col">-</th>
                      <th class="text-center" :class="['background-'+app_color]" width="5%" scope="col">#</th>
                      <th class="text-center" :class="['background-'+app_color]" width="10%" scope="col">Unit Code</th>
                      <th class="text-center" :class="['background-'+app_color]" width="25%" scope="col">Unit Title</th>
                      <th class="text-center" :class="['background-'+app_color]"  scope="col">Start / End Dates</th>
                      <!-- <th class="text-center" :class="['background-'+app_color]" scope="col">End Date</th> -->
                      <th class="text-center" :class="['background-'+app_color]" width="10%" scope="col">Training Hours</th>
                      <th class="text-center" :class="['background-'+app_color]" width="10%" scope="col">Weeks</th>
                      <th class="text-center" :class="['background-'+app_color]" scope="col">Trainers</th>
                      <!-- <th class="text-center" :class="['background-'+app_color]" scope="col">Holidays</th> -->
                      <!-- <th class="text-center" :class="['background-'+app_color]" scope="col">-</th> -->
                      </tr>
                  </thead>
                  <!-- <tbody> -->
                    <draggable v-model="tt.time_table" tag="tbody" handle=".handle" @start="drag=true" @end="drag=false">
                      <tr v-for="(item, key) in tt.time_table" :key="key">
                          <td class="text-center">
                            <!-- <i class="fas fa-align-justify handle mt-1"></i> -->
                            <i class="fas fa-sort handle mt-1"></i>
                          </td>
                          <td class="text-center">{{item.order = key+1}}</td>
                          <td v-if="toType(item.is_break) !== 'undefined'" colspan="2" class="text-center"> Break </td>
                          <td v-if="toType(item.is_break) === 'undefined'">{{item.unit.code}}</td>
                          <td v-if="toType(item.is_break) === 'undefined'">{{item.unit.description}}</td>
                          <td>
                            <date-picker 
                              mode='range'
                              :input-props='{
                                class: "vc-appearance-none vc-text-base vc-text-gray-800 vc-bg-white vc-border vc-border-gray-400 vc-rounded vc-w-full vc-py-2 vc-px-3 vc-leading-tight focus:vc-outline-none focus:vc-shadow",
                                readonly:"readonly",
                                style: item.dateError == 1 ? "border: 1px solid red !important;" : "",
                              }'
                              :id="'dp-'+key"
                              :disabled-dates ="disabled_dates"
                              :masks="{ input: 'DD/MM/YYYY' }" 
                              locale="en" 
                              v-model="tt.time_table[key]['dates']" ></date-picker>
                              
                          </td>
                          <td v-if="toType(item.is_break) === 'undefined'"><input type="number" min="0" class="form-control" v-model="tt.time_table[key]['training_hours']"></td>
                          <td v-else></td>
                          <td><input type="number" min="0" readonly class="form-control" v-model="tt.time_table[key]['weeks']"></td>
                          
                          <!-- trainers -->
                          <td v-if="toType(item.is_break) === 'undefined'">

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

                          <!-- <td v-if="toType(item.is_break) !== 'undefined'" colspan="2" class="text-center"> <button class="btn btn-danger btn-sm" @click="removeBreak(key)"><i class="fas fa-minus"></i></button> </td> -->
                          <!-- <td class="text-center" v-else> -->
                            <!-- <span
                                v-if="toType(item.holidays) !== 'undefined' && item.holidays.length > 0"
                                :class="['a-'+app_color, 'holiday-info']"
                                @click="getHolidays(item.holidays)"
                            >
                                <i class="fas fa-info-circle fa-2x"></i>
                            </span> -->
                            <!-- <i class="fas fa-align-justify handle mt-2"></i> -->
                          <!-- </td> -->
                      </tr>
                    </draggable>
                      <!-- <tr v-for="(item, key) in timeTable.time_table" :key="key">
                        
                      </tr> -->
                  <!-- </tbody> -->
                  <tfoot>
                    <!-- <td></td> -->
                    <td colspan="5" class="text-left">
                      <div class="row no-gutters">
                        <div class="col-md-3">
                          <button class="btn btn-info" style="width:100%" @click="autoFill(1)"><i class="far fa-calendar-alt mr-1"></i> Assign Dates</button>
                        </div>
                        <div class="col-md-9 pl-2">
                          <span><i><b>Note:</b> <b>Start</b> and <b>End dates</b> will be automatically assigned based on the inputs applied.</i></span>
                        </div>
                      </div>
                    </td>
                    <!-- <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"></td> -->
                    <td class="text-right">{{time_table_totals.total_training_hours}}</td>
                    <td class="text-right">{{time_table_totals.total_weeks}}</td>
                    <td></td>
                  </tfoot>
              </table>
            </div>
            
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
      getClass: {},
      trainers: window.trainers,
      is_save: 0,
      auto_if_update: 0,
      days : window.days,
      holidays: window.holidays,
      // year_duration: [], 
      // tt:  window.time_table,
      // training_hours_daily: window.time_table.training_hours_daily,
      // training_hours_weekly: window.time_table.training_hours_weekly,
      formatHolidays: [],
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
    daysFilter() {
      if(this.tt.training_days_weekly) {
        return this.tt.training_days_weekly.slice().sort(function(a, b) {
          return a.order - b.order;
        });
      }
    },
    training_hours_weekly: function() {
      let total = 0;
      if(this.tt.training_days_weekly) {
        for(let i = 0 ; i < this.tt.training_days_weekly.length ; i++) {
          let day = this.tt.training_days_weekly[i];
          total += day.hours ? parseInt(day.hours) : 0;
        }
      }
      return total
    },
    time_table_totals : function() {
      let tTrainHrs = 0;
      let tWeeks = 0;
      if(this.tt.time_table) {
        for(let i = 0 ; i < this.tt.time_table.length ; i++) {
          let timeTable = this.tt.time_table[i];
          
          if(timeTable.training_hours) {
            tTrainHrs += parseInt(timeTable.training_hours);
          }
          if(timeTable.weeks) {
            tWeeks += parseInt(timeTable.weeks);
          }
        }
      }
      this.tt.total_training_hours = tTrainHrs;
      this.tt.total_weeks = tWeeks;
      return {
        total_training_hours : tTrainHrs,
        total_weeks : tWeeks,
      }
    }
  },
  created() {
    // console.log(window.time_table);
    if(window.time_table.id) {
        // console.log('suloders?');
        let e = window.time_table.time_table;
        // console.log(e);
        for(let i = 0 ; e.length > i ; i++) {
          if(e[i].dates) {
            e[i].dates.start = e[i].dates.start ? moment(e[i].dates.start)._d : null;
            e[i].dates.end = e[i].dates.end ? moment(e[i].dates.end)._d : null;
          }
        }
        window.time_table.time_table = e;
        // console.log(window.time_table);
    }

    this.tt = window.time_table;
    this.getClass = window.class;
    this.is_save = window.is_save
    // if(this.tt.time_table) {
      // this.formatDates(this.tt.time_table);
    // }
    // this.autoFill();
  },
  methods: {
    formatDates(data) {
      console.log(data);
    },
    TimeCalcTotalHours(key) {
      let day = this.tt.training_days_weekly[key];
      if(typeof day.time_start && ['', null].indexOf(day.time_start) == -1 && typeof day.time_end && ['', null].indexOf(day.time_end) == -1) {
        let start = moment(moment().format('YYYY-MM-DD')+' '+day.time_start);
        let end = moment(moment().format('YYYY-MM-DD')+' '+day.time_end);
        // console.log(end - start);
        let duration = moment.duration(end.diff(start));
        day.hours = duration.asHours() > 0 ? duration.asHours() : 0;
      }
    },
    async autoFill(generate = 0) {
      
      // swal.fire({
      //     title: 'Generating time table...',
      //     // html: '',// add html attribute if you want or remove
      //     allowOutsideClick: false,
      //     onBeforeOpen: () => {
      //         swal.showLoading()
      //     },
      // });

      if( this.training_hours_weekly == 0) {
        if(generate == 1) {
          swal.fire(
            'Opss...',
            'Must have timings to calculate time table.',
            'error'
          )
          return false;
        }
        swal.close()
      }

    //   console.log('test');
      let dayStart = null;
      let vm = this;
      let totalTrainHrs = 0;
    //   console.log(vm.tt);
      let tt = vm.tt.time_table;
      // console.log(vm.tt);
      let start = null;
      let run = null;
      let end = null;
      // console.log('Hours Weekly: '+vm.training_hours_weekly);
      // console.log(vm.tt);
      for (let index = 0; index < tt.length; index++) {
            // console.log('--------------------------------------------------------');
            // check training hours

            if(start == null) {
              start = moment(vm.tt.duration_start_date);
              // console.log(`start : `+moment(start).format('DD/MM/YYYY'));
              run = start;
            }
            let trainHours = tt[index].training_hours;
            // console.log(`Training Hours : ${trainHours}`);

            // console.log(vm.tt.training_days_weekly);
            
            /* must search days that have training. */
            let dayComput = await this.getWeeksFromHours(trainHours, vm.training_hours_weekly, vm.tt.training_days_weekly, moment(run).format('ddd'));

            // console.log('Total weeks for this unit: '+ dayComput);
            tt[index].weeks = dayComput.weeks;
            totalTrainHrs += dayComput.weeks;
            // assign dates per unit 
            end = moment(run).add(dayComput.days, 'days');
            let dates = {
              start : moment(run)._d,
              end : moment(end)._d,
            }
            tt[index].dates = dates;
            // console.log(tt[index]);
            run = dayComput.left > 0 ? moment(end).subtract(1, 'day') : moment(end);
            // if(index == 0) {
            //     // console.log('first');
            //     if(tt[index].training_hours == 0) {
            //         console.log('break loop');
            //         break;
            //     }
            // }
      }
      this.tt.time_table = {};
      this.tt.time_table = tt;
      this.tt.total_weeks = totalTrainHrs;
      // this.getDates();
      // console.log(tt)
    //   vm.disabled_dates = disabled_dates;
    //   this.totalTrainingHours('th');
    //   this.totalTrainingHours('wk');
    //   this.fixDates(table)

      if(generate != 0) {
        
        let content = ''

        switch (generate) {
          case 1:
            content = 'Start / End dates assigned successfully'
            break;
          case 2:
            content = 'Time Table is now reset.'
            break;
        
          default:
            content = 'Start / End dates assigned successfully'
            break;
        }

        Toast.fire({
            position: 'bottom-end',
            type: 'success', title: content,
        })
      }else{
        swal.close()
      }

      
    },
    async getWeeksFromHours(trainHrs,hrsPerWeek,dw,ds) {
      let weeks = 0;
      let days = 0;
      let isoWeek = [
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun',
        ];
      // console.log(ds);
      while(trainHrs > 0) {
          weeks++;

          let daysOfWeekCounter = 0;

          //get days of week counter 
          while(daysOfWeekCounter < 7) {
            if(trainHrs < 1) {
                break;
            }
            for (let key = 0; key < isoWeek.length; key++) {
              let iso = isoWeek[key];

              if(daysOfWeekCounter == 7 || trainHrs < 1) {
                  break;
              }
              
              if(daysOfWeekCounter != 0) {
                  days++;
                  daysOfWeekCounter++;
                  console.log('count '+iso+' - '+ daysOfWeekCounter);
              }

              if(iso == ds && daysOfWeekCounter == 0) {
                  days++;
                  daysOfWeekCounter++;
                  console.log('first count '+iso+' - '+ daysOfWeekCounter);
              }

              if(daysOfWeekCounter != 0) {
                  for (let k = 0; k < dw.length; k++) {
                    const val = dw[k];
                    if(val.day == iso && [0,null].indexOf(val.hours) == -1) {
                        trainHrs = trainHrs - parseInt(val.hours);
                        console.log(trainHrs);
                    }
                  }
              }
              
            }
          } 
      }
      console.log('days - '+days);
      console.log('weeks - '+weeks);
      console.log(`training hours of that day left - ${trainHrs}`)
      return {
        days : days - 1,
        weeks : weeks,
        left : Math.abs(trainHrs)
      };
    },
    toType(obj) {
        return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
    },
    getHolidays(arr) {
      console.log(arr)

      let html = '<ul style="margin-left: 10% !important;">';

      arr.forEach(v => {
          html += `<li style="text-align:left !important; color: #ff5757 !important;">${v.name} - ${v.date} (${v.weekday})</li>`;
      })
      html += '</ul><br><span><i>Note: If a holiday comes at scheduled day, the training will be moved to very next available day by default.<i></span>';

      swal.fire({
          type: 'warning',
          title: 'Holidays:',
          html: html
      })

    },
    resetTimeTable() {
      let vm = this;
      swal.fire({
        title: 'Reset Time Table?',
        text: "Saved time table will be erased.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {

          swal.fire({
              title: 'Resetting Time Table',
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                  swal.showLoading()
              },
          });

          axios.get(`/classes/${vm.getClass.id}/time-table/reset`)
          .then(function(res) {

            if(res.data.status == 'success'){
              vm.tt = {};
              vm.getClass = res.data.class; 
              console.log(res.data);
              vm.tt = res.data.time_table;
              vm.is_save = 0
              vm.autoFill(2);
              swal.fire(
                'Success!',
                'Time table reset successfully',
                'success'
              )
            }

          })
          .catch(function(err) {
            console.log(err)
          })
          
        }
      })
    },
    trainerLabel({firstname, lastname}) {
      return firstname + ' ' + lastname;
    },
    limitText(count) {
      return `and ${count} other trainers`;
    },
    saveTimeTable() {

      if( this.training_hours_weekly == 0) {
          swal.fire(
            'Opss...',
            'Must have timings to calculate time table.',
            'error'
          )
        return false;
      }

      let vm = this;
      swal.fire({
        title: 'Save time table?',
        html: "<i>Start and end date of the first and last unit will be the start and end date of the class.</i>",
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
                  vm.is_save = 1;
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
    getDates(){
      this.tt.time_table.forEach(e => {
        let d = {
          start : '',
          end : '',
        };
        // console.log('test');
        if(typeof e.dates !== 'undefined'){
          if(typeof e.dates.start !== 'undefined'){
            d.start = moment(e.dates.start)._d;
          }
          if(typeof e.dates.end !== 'undefined'){
            d.end = moment(e.dates.end)._d;
          }
        }
        console.log(d);
        e.dates = d;
      })
    }
  },
  watch: {
        'tt.training_days_weekly' : function (newitem, olditem) {

          if(olditem && newitem && newitem.length != olditem.length) {
            let sorted = newitem.slice().sort(function(a, b) {
              return a.order - b.order;
            });
            this.tt.training_days_weekly = sorted;
          }
        },
        tt : function (item){
          this.tt.duration_start_date = moment(item.duration_start_date)._d;
          // let data = [];
          // if(this.auto_if_update == 0) {
          //   if(item.id) {
          //     console.log('suloders?');
          //     let e = item.time_table;
          //     console.log(e.dates);
          //     for(let i = 0 ; e.length > i ; i++) {
          //       if(e.dates) {
          //         e.dates.start = e.dates.start ? moment(e.dates.start)._d : null;
          //         e.dates.end = e.dates.end ? moment(e.dates.end)._d : null;

          //       }
          //     }
          //     this.auto_if_update = 1;
          //   }else{
          //     this.auto_if_update = 1;
          //   }
          // }
          // item.time_table.forEach(e => {
            // let th = 0;
            // if(typeof e.dates !== 'undefined'){
                
            // }
            // if(typeof e.end_date !== 'undefined'){
            //   e.end_date = moment(e.end_date)._d;
            // }

            // if(typeof e.dates !== 'undefined' && typeof e.dates.start !== 'undefined' && typeof e.dates.end !== 'undefined'){
            //   disabled_dates.push({dates:{start:moment(e.dates.start)._d, end:moment(e.dates.end)._d}})
            // }


            // if(typeof e.unit !== 'undefined' && typeof e.training_hours === 'undefined'){
            //   th = e.unit.scheduled_hours
            // }else if(typeof e.training_hours !== 'undefined'){
            //   th = e.training_hours
            // }

            // if(typeof e.weeks === 'undefined'){
            //   e.weeks = 0;
            // }
            // e.totalTrainingHours;
            // e.training_hours = th;
            // data.push(e);
          // })
          // console.log(data);
          // this.tt.time_table = data;

        // },


        // getClass: function(i) {
          // console.log(i)
          // let d = moment(i.start_date)._d;
          
          // if(typeof this.tt.duration_start_date === 'undefined'){
            // console.log(d)
            // this.tt.duration_start_date = d
            // this.autoFill();
            // this.tt.duration_start_date = moment(this.getClass.start_date)._d;
          // }
          
        }
  },
};
</script>

<style scoped>
  .holiday-info {
    cursor: pointer !important;
  }
  .dateError {
    border: 1px solid red !important;
  }
  .chkbx {
    width: 25px;
    height: 17px;
  }
</style>