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
            <h6 class="m-0 font-weight-bold text-primary">Rotating Time Table ({{getClass.desc}})</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 text-right">
              <button class="btn btn-warning" v-if="is_save == 1" @click="resetTimeTable"><i class="fas fa-undo"></i> Reset</button>
              <button class="btn btn-success" @click="saveTimeTable"><i class="fas fa-save"></i> Save</button>
              <button class="btn btn-danger" @click="addBreak"><i class="fas fa-plus"></i> Break</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                  <!-- <label for="company_name"><span style="">Duration: <i v-if="getClass.time_table_type == 'Straight'">(Month)</i><i v-else>(Year)</i></span></label>
                  <input type="month" class="form-control" v-if="getClass.time_table_type == 'Straight'" v-model="tt.duration_month">
                  <select v-else name="" class="form-control" v-model="tt.duration_year">
                    <option :value="i" v-for="(i) in year_duration" :key="i">{{i}}</option>
                  </select> -->
                  <label for="company_name"><span style="">Class Start Date:</span></label>
                  <date-picker 
                    mode='single'
                    :input-props='{
                      class: "vc-appearance-none vc-text-base vc-text-gray-800 vc-bg-white vc-border vc-border-gray-400 vc-rounded vc-w-full vc-py-2 vc-px-3 vc-leading-tight focus:vc-outline-none focus:vc-shadow",
                      readonly: true,
                      onchange: ""
                    }'
                    :masks="{ input: 'DD/MM/YYYY' }" 
                    locale="en" 
                    v-model="class_start_date" ></date-picker>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label class="w-100 mb-2" for="company_name">Training Days Per Week:
                  <!-- <a
                      href="#"
                      data-toggle="tooltip"
                      :class="'a-'+app_color"
                      :title="'Select days of training in a week'"
                      data-placement="right"
                  >
                      <i class="fas fa-info-circle"></i>
                  </a> -->
                  </label>
                  <!-- <div class="row"> -->
                    <span v-for="(i,k) in tt.training_days_weekly" :key="k" class="custom-switch mt-3 mx-2">
                        <input type="checkbox" class="custom-control-input" v-bind:id="k" @change="autoFill" v-model="tt.training_days_weekly[k]">
                        <label class="custom-control-label" v-bind:for="k">{{k}}</label>
                    </span>
                  <!-- </div> -->
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                  <!-- <label for="company_name">Training Hours Per Day: -->
                  <label for="company_name">Hours Per Week:
                  </label>
                  <!-- <input type="number" min="0" class="form-control" @change="autoFill" v-model="tt.training_hours_daily"> -->
                  <input type="number" min="0" class="form-control" @change="autoFill" v-model="tt.training_hours_weekly">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                  <label for="company_name">Hours Per Day:
                  <!-- <label for="company_name"><span style="font-size:14px;">Training Days Per Week:</span> -->
                  <a
                      href="#"
                      data-toggle="tooltip"
                      :class="'a-'+app_color"
                      :title="'Number of training hours per day'"
                      data-placement="right"
                  >
                      <i class="fas fa-info-circle"></i>
                  </a></label>
                  <input type="number" min="1" @keydown="trainHoursPerDay" @change="trainHoursPerDay" max=7 class="form-control" v-model="tt.training_hours_daily">
              </div>
            </div>
            <div class="col-md-2 text-right mb-2 pt-3">
              
              <!-- <button class="btn btn-warning" @click="autoFill(-1)"><i class="fas fa-list"></i> Auto Fill</button> -->
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
                  <draggable v-model="tt.time_table" tag="tbody" @start="drag=true" @end="drag=false" @change="autoFill">
                    <tr v-for="(item, key) in tt.time_table" :key="key" :class="backgroundColor(item)">
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
                              onchange: ""
                            }'
                            :disabled-dates ="disabled_dates"
                            :masks="{ input: 'DD/MM/YYYY' }" 
                            locale="en" 
                            v-model="tt.time_table[key]['dates']" ></date-picker>
                            
                        </td>
                        <td v-if="typeof item.is_break === 'undefined'"><input type="number" min="0" class="form-control" @change="processTH" v-model="tt.time_table[key]['training_hours']"></td>
                        <td v-else></td>
                        <!-- <td v-if="typeof item.is_break === 'undefined'"><input type="number" min="0" class="form-control" @change="autoFill" v-model="tt.time_table[key]['weeks']"></td> -->
                        <td v-if="typeof item.is_break === 'undefined'"><input type="number" min="0" class="form-control" readonly @change="autoFill" v-model="tt.time_table[key]['weeks']"></td>
                        <td v-else><input type="number" min="0" class="form-control" @change="autoFill" v-model="tt.time_table[key]['weeks']"></td>
                        
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
                        <td class="text-center" v-else>
                          <span
                              v-if="typeof item.holidays !== 'undefined' && item.holidays.length > 0"
                              :class="['a-'+app_color, 'holiday-info']"
                              @click="getHolidays(item.holidays)"
                          >
                              <i class="fas fa-info-circle fa-2x"></i>
                          </span>
                        </td>
                    </tr>
                  </draggable>
                    <!-- <tr v-for="(item, key) in timeTable.time_table" :key="key">
                      
                    </tr> -->
                <!-- </tbody> -->
                <tfoot>
                  <td colspan="3"> <div class="boxBreak float-left"></div> <div class="float-left boxText">Break</div> <div class="boxRotate float-left"></div> <div class="float-left boxText">Rotated Units</div></td>
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
      getClass: {},
      trainers: window.trainers,
      is_save: 0,
      class_start_date : null,
      checkAutoFill : 0,
      // tt:  window.time_table,
      holidays: window.holidays,
      formatHolidays: {},
      tt: {},
      // class_start_day: 'Monday',
      disabled_dates: []
    };
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
    this.getClass = window.class;
    this.tt = window.time_table;
    // this.class_start_date = window.class;
    // console.log(this.tt);
    this.is_save = window.is_save;
  },
  methods: {
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
              // console.log(res.data.time_table)
              vm.tt = res.data.time_table;
              vm.is_save = 0
              vm.tt.training_hours_weekly = 20
              swal.fire(
                'Success!',
                'Time table reset successfully',
                'success'
              )
              vm.autoFill()
            }

          })
          .catch(function(err) {
            console.log(err)

          })
          
        }
      })
    },
    backgroundColor(e){
      let css = []
      if(typeof e.is_break !== 'undefined'){
        css.push('isBreak')
      }
      if(typeof e.isRotate !== 'undefined'){
        css.push('isRotate')
      }
      return css
    },
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
                  swal.fire(
                    'Success!',
                    'Time table saved successfully',
                    'success'
                  )
                  vm.is_save = 1
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
        dates:{},
        training_hours: null,
        weeks: 1,
        order: null,
        holidays: []
      }
      this.tt.time_table.push(b); 
      this.autoFill()
    },
    removeBreak(key){
      let tt = [];
      this.tt.time_table.forEach(element => {
        if(key+1 != element.order){
          tt.push(element);
        }
      });
      this.tt.time_table = tt;
      this.autoFill();
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
          // total = parseInt(total) + parseInt(element.weeks);
          total = total + element.weeks;
        }
      });
      // console.log(total);
      if(type == 'th'){
        this.tt.total_training_hours = Number.isNaN(total) ? 0 : total;
      }else{
        this.tt.total_weeks = Number.isNaN(total) ? 0 : Math.round(total);
      }
    },
    trainDaysPerWeek(event) {
      const char = String.fromCharCode(event.keyCode)
      if(['ArrowDown','ArrowUp','Backspace', 'Delete'].indexOf(event.code) == -1){
        if (!/[0-9]/.test(char)) {
          event.preventDefault()
        }else{
          event.preventDefault()
            if(char > 7){
              this.tt.training_days_weekly = 7;
            }else if (char < 1){
              this.tt.training_days_weekly = 1;
            }else{
              this.tt.training_days_weekly = char;
            }
        }
      }
    },
    trainHoursPerDay(event) {
      const char = String.fromCharCode(event.keyCode)
      if(['ArrowDown','ArrowUp','Backspace', 'Delete'].indexOf(event.code) == -1){
        if (!/[0-9]/.test(char)) {
          event.preventDefault()
        }else{
          event.preventDefault()
            if(char > 24){
              this.tt.training_hours_daily = 24;
            }else if (char < 1){
              this.tt.training_hours_daily = 1;
            }else{
              this.tt.training_hours_daily = char;
            }
        }
      }
    },
    autoFill() {

      swal.fire({
          title: 'Generating time table...',
          // html: '',// add html attribute if you want or remove
          allowOutsideClick: false,
          onBeforeOpen: () => {
              swal.showLoading()
          },
      });

      let dayStart = null;
      let vm = this;
      let tt = [];
      let weekCount = 0;
      let class_start_date = moment(vm.getClass.start_date);
      
      // console.log(vm.tt.training_hours_weekly);

      // format holidays
      if(Object.keys(vm.formatHolidays).length == 0 && vm.holidays.length > 0){
        vm.holidays.forEach( e => {
          let obj = {}
          obj.month = e.month
          obj.year = class_start_date.format('YYYY')
          obj.name = e.name
          obj.location = []
          
          JSON.parse(e.location).forEach(loc => {
            obj.location[loc.id] = loc.value
          });

          if(typeof obj.location[vm.getClass.location] !== 'undefined'){
            if(e.type == 'day'){
              obj.weekday = moment().month(parseInt(e.month)-1).set('date', parseInt(e.day)).format('dddd')
              obj.day = e.day
              obj.type = 'day'
              obj.date = moment().month(parseInt(e.month)-1).set('date', parseInt(e.day)).format('DD/MM/YYYY')
            }else if(e.type == 'week'){
              let d = moment(moment().format(class_start_date.format('YYYY')+'-'+e.month+'-01')).weeks()
              d = moment().weeks(d)

              if(d.format('M') != parseInt(e.month)){
                if(d.format('M') > parseInt(e.month)){
                  d.subtract('weeks', e.weekday)
                }else if(d.format('M') < parseInt(e.month)){
                  d.add(parseInt(e.week), 'weeks')
                }
              }
              d = d.isoWeekday(parseInt(e.weekday))
              obj.weekday = d.format('dddd')
              obj.day = d.format('D')
              obj.week = parseInt(e.week)
              obj.type = 'week'
              obj.date = d.format('DD/MM/YYYY')
            }
  
            if( typeof vm.formatHolidays[moment(moment().format(class_start_date.format('YYYY')+'-'+e.month+'-01')).format('MMM')] === 'undefined'){
              vm.formatHolidays[moment(moment().format(class_start_date.format('YYYY')+'-'+e.month+'-01')).format('MMM')] = [];
            }
            vm.formatHolidays[moment(moment().format(class_start_date.format('YYYY')+'-'+e.month+'-01')).format('MMM')].push(obj);
          }


        })
      }

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

      // console.log(class_start_date);
      // FOR DATE CHANGES
      let dateStart = null;
      let dateEnd = null;
      let runDate = null;

      // FOR WEEKLY DATE CALCULATION
      let wStart = null;
      let wEnd = null;

      // training hours daily
      // let thd = vm.tt.training_hours_weekly / weekCount
      let thd = vm.tt.training_hours_daily
      let hpwLeft = null
      let newWeek = 1;



      let disabled_dates = [];

      console.log('---------------------------------------------------------------------------------------------')
      
      for (let index = 0; index < vm.tt.time_table.length; index++) {
        let e = vm.tt.time_table[index];
        let td = 0;
        let hours = 0;
        let h = [];

        if(e.order != 1){
          let tDay = 0
          while(tDay < 1){
            runDate.add(1, 'days');
            if(vm.tt.training_days_weekly[runDate.format('ddd')] == 1){
              tDay = 1;
            }
          }
          // console.log(runDate)
        }

        // console.log(vm.tt.training_hours_weekly)
        // console.log(e.weeks)

        let hrs = e.training_hours

        hrs * parseInt(e.weeks)
        // console.log(hrs)
        e.training_hours = hrs

        hpwLeft = hpwLeft == null ? vm.tt.training_hours_weekly : hpwLeft;
        
        
        // if(typeof e.dates.start === 'undefined' && typeof e.dates.end === 'undefined'){
          // console.log('in')
          dateStart = e.order == 1 ? moment(class_start_date) : moment(runDate);
          dateEnd = e.order == 1 ? null : moment(dateEnd);
          runDate = e.order == 1 ? moment(class_start_date) : moment(runDate);
        // }

        console.log(e.order)
        // for new week
        if(hpwLeft == vm.tt.training_hours_weekly){
          wStart = wStart == null ? dateStart : wStart;
          wEnd = moment(wStart).add(1, 'weeks');
          wEnd = moment(wEnd).subtract(1, 'days');
          // console.log(moment(wStart)._d)
          // console.log(moment(wEnd)._d)
        }

        // console.log(e)
        if(typeof e.is_break === 'undefined'){
          while ( hours < e.training_hours){
            
            // start holiday search
            // console.log(vm.formatHolidays);
             if(typeof vm.formatHolidays[runDate.format('MMM')] !== 'undefined'){
               vm.formatHolidays[runDate.format('MMM')].forEach(obj => {
                // use h variable
                if(obj.type == 'day'){
                  if(runDate.format('D') == obj.day){
                    h.push(obj)
                  }

                }else if (obj.type == 'week'){
                  if(runDate.format('YYYY') != obj.year){
                    // if run date year is different from the course start date (year)
                    let d = moment(moment().format(runDate.format('YYYY')+'-'+obj.month+'-01')).weeks()
                    d = moment().weeks(d)
                    if(d.format('M') != parseInt(obj.month)){
                      if(d.format('M') > parseInt(obj.month)){
                        d.subtract(1, 'weeks')
                      }else if(d.format('M') < parseInt(e.month)){
                        d.add(parseInt(obj.week), 'weeks')
                      }
                    }

                    d = d.isoWeekday(obj.weekday)
                    obj.day = d.format('D')
                  }

                  if(runDate.format('D') == obj.day){
                    h.push(obj)
                  }

                }

               })
              // console.log('inside')
             }
            //  console.log(runDate.format('MMM-DD'))
            //  console.log(h)
            // end holiday search


            if(vm.tt.training_days_weekly[runDate.format('ddd')] == 1){
              hours = hours + thd;
              td++

              // console.log(e.order+' - '+hours+' - '+e.training_hours);
            }
              if(hours < e.training_hours){
                runDate.add(1, 'days');
              }
              
          }

          // for weekly start end
          hpwLeft = hpwLeft - e.training_hours;

          e.weeks = e.training_hours / vm.tt.training_hours_weekly
          // console.log(unitWeek)
          // e.weeks = Math.floor(td / weekCount);
        }else{

          // console.log('-------- BREAKS --------')

          let wkDay = 7 * parseInt(e.weeks)
          // console.log(Math.floor(wkDay / weekCount) * weekCount)
          runDate.add(parseInt(e.weeks), 'weeks');
          runDate.subtract(1, 'days');
          // console.log(e.weeks + ' - ' + wkDay)
          td = wkDay
          // console.log('------------------------')
        }
        console.log(e.order +' - '+e.training_hours+' - '+ hpwLeft)
        
        if(hpwLeft < 0){
          // wEnd = moment(wEnd).add(1, 'days');
          wEnd = moment(wEnd).add(1, 'weeks');
          // wEnd = moment(wEnd).subtract(1, 'days');
          // console.log('end - '+ wEnd._d)
        }

        let noTraining = moment(runDate)
        let z = 1
        while(z != 0){
          noTraining.add(1, 'days')
          if(vm.tt.training_days_weekly[noTraining.format('ddd')] == 1){
            noTraining.subtract(1, 'days')
            z = 0
          }
        }

        dateEnd = moment(noTraining);

        // e.dates = {
        //   start: moment(dateStart)._d,
        //   end: moment(dateEnd)._d
        // }

        // console.log(moment(wStart)._d)
        // console.log(moment(wEnd)._d)
        // for week start end
        e.dates = {
          start: moment(wStart)._d,
          end: moment(wEnd)._d
        }

        if(hpwLeft < 1){
          wStart = moment(wStart).add(1,'weeks')
          hpwLeft = vm.tt.training_hours_weekly - Math.abs(hpwLeft);
        }

        e.holidays = h

        // console.log(h)
        // e.dates.start = moment(dateStart)._d
        // e.dates.end = moment(dateEnd)._d

        // disabled_dates.push({dates:{start:moment(dateStart)._d, end:moment(dateEnd)._d}})
        disabled_dates.push({dates:{start:moment(wStart)._d, end:moment(wEnd)._d}})
        // console.log(runDate._d);
        // console.log(hours)
        // console.log(e)
        // console.log('------------------------------------------------')

        
        tt.push(e)
      
        // e.training_hours = hours;

        // console.log(e)

        // if(e.order ==  1){
        //   break;
        // }
      }
      // console.log(table);
      // console.log(vm.tt.time_table[hasDates]);
      // console.log(tt)
      vm.tt.time_table = tt;
      vm.disabled_dates = disabled_dates; 
      vm.totalTrainingHours('th');
      this.totalTrainingHours('wk');
      // console.log(dateStart);
      swal.close()
      
    },
    processTH(){
      this.autoFill();
    },
    getDates(k){
        let d = {};
        let e = this.tt.time_table[k]
        
        if(typeof e.dates !== 'undefined'){
          console.log('dates')
          if(typeof e.dates.start !== 'undefined'){
            d.start = moment(e.dates.start)._d;
          }else{
            d.start = moment()._d
          }
          if(typeof e.dates.end !== 'undefined'){
            d.end = moment(e.dates.end)._d;
          }else{
            d.end =  moment()._d
          }
          e.dates = d;
        }else{
          e.dates = {};
        }
    }
  },
  watch: {

        tt : function(item) {
          // console.log(item)
          let vm = this;
          let count = 0;
          swal.fire({
              title: 'Generating time table...',
              // html: '',// add html attribute if you want or remove
              allowOutsideClick: false,
              onBeforeOpen: () => {
                  swal.showLoading()
              },
          });
          const waitFor = (ms) => new Promise(r => setTimeout(r, ms));
          const asyncForEach = async (array, callback) => {
            for (let index = 0; index < array.length; index++) {
              await callback(array[index], index, array)
            }
          }

          const start = async () => {
            await asyncForEach(item.time_table, async (el) => {
              await waitFor(20);
              let th = 0;
              let wk = 0;
              if(typeof el.unit !== 'undefined' && typeof el.training_hours === 'undefined'){
                // th = el.unit.scheduled_hours
                th = vm.tt.training_hours_weekly
                wk = 1
                // console.log('in');
                if(typeof el.unit.scheduled_hours !== 'undefined' && [0,'', 'null'].indexOf(el.unit.scheduled_hours) == -1){
                  th = el.unit.scheduled_hours;
                }
                // console.log(el.unit.scheduled_hours);
              }else if(typeof el.training_hours !== 'undefined'){
                // console.log('driii')
                th = el.training_hours
                wk = el.weeks
              }
              // console.log(el);
              el.training_hours = th;
              el.weeks = wk;
              vm.getDates(count);
              // console.log('te')
              // vm.getWeeks(count)
              count++
            });
            // console.log('Done');
            vm.autoFill();
            this.checkAutoFill = 1;
          }

          start();
          // item.time_table.forEach(el => {
            
          // });
          // console.log(vm.tt)
         
        },
        
        getClass: function(i) {
          // console.log(i)
          let d = moment(i.start_date)._d;
          // console.log(d)
          i.start_date = d;
          this.class_start_date = d;
          
        },

        class_start_date: function(i) {
          // console.log(i)
          if(this.checkAutoFill == 1){
            this.getClass.start_date = i;
            this.autoFill()
          }
          // this.class_start_date = 
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
  .isBreak {
    background-color: #ffb8b8 !important;
  }
  .boxBreak{
    width: 15px;
    height: 15px;
    background-color: #ffb8b8 !important;
  }
  .isRotate {
    background-color: #d1ffd1 !important;
  }
  .boxRotate{
    width: 15px;
    height: 15px;
    background-color: #d1ffd1 !important;
  }
  .boxText {
    margin: -1px 5px;
  }
</style>