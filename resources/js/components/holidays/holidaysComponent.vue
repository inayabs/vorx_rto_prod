<template>
<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-primary-'+app_color">Holidays</h6>
        </div>
        <div class="card-body">
            <form @submit.prevent>
                <div>
                    <div class="row mb-3">
                        <div class="col-md-12 pull-right text-right">
                            <button class="btn btn-success" @click="saveHoliday">
                                <i class="far fa-save"></i> 
                                <span v-if="isEdit == true"> Update</span>
                                <span v-else>Save</span>
                            </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'" id="formsection">
                        <h6>Holiday Details</h6>
                    </div>
                    <div class="form-padding-left-right">
                        <div class="row">
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.name ? 'has-error' : '']">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" value autofocus="autofocus" class="form-control" type="text" v-on:keyup="onKeyUp()" v-model="holidays.name" />
                                    <span v-if="errors.name" :class="['badge badge-danger']">{{ errors.name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="enrolment">Month</label>
                                    <select id="month" name="month" class="form-control" v-model="holidays.month">
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <span v-if="errors.month" :class="['badge badge-danger']">{{ errors.month[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="enrolment">Type</label>
                                    <select id="type" name="type" class="form-control" v-model="holidays.type">
                                        <!-- <option value=""></option> -->
                                        <option value="day">Day</option>
                                        <option value="week">Week</option>
                                    </select>
                                    <span v-if="errors.type" :class="['badge badge-danger']">{{ errors.type[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-3" v-if="holidays.type == 'week'">
                                <div class="form-group">
                                    <label for="enrolment">Days of the week</label>
                                    <select id="weekday" name="weekday" class="form-control" v-model="holidays.weekday">
                                        <option value=""></option>
                                        <option value="1">Monday</option>
                                        <option value="2">Tuesday</option>
                                        <option value="3">Wednesday</option>
                                        <option value="4">Thursday</option>
                                        <option value="5">Friday</option>
                                        <option value="6">Saturday</option>
                                        <option value="0">Sunday</option>
                                    </select>
                                    <span v-if="errors.weekday" :class="['badge badge-danger']">{{ errors.weekday[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-3" v-if="holidays.type == 'week'">
                                <div class="form-group">
                                    <label for="enrolment">Week</label>
                                    <select id="week" name="week" class="form-control" v-model="holidays.week">
                                        <option value=""></option>
                                        <option value="1">First Week</option>
                                        <option value="2">Second Week</option>
                                        <option value="3">Third Week</option>
                                        <option value="4">Fourth Week</option>
                                        <option value="5" v-if="no_of_weeks == '5' || no_of_weeks == '6'">Fifth Week</option>
                                        <!-- <option value="6" v-if="no_of_weeks == '6'">Sixth Week</option> -->
                                    </select>
                                    <span v-if="errors.week" :class="['badge badge-danger']">{{ errors.week[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6" v-if="holidays.type == 'day' || holidays.type == ''">
                                <div class="form-group">
                                    <label for="enrolment">Day</label>
                                    <input type="number" name="day" class="form-control" max="31" @keyup="dayRange()" v-model="holidays.day">
                                    <span v-if="errors.day" :class="['badge badge-danger']">{{ errors.day[0] }}</span>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div :class="['form-group', errors.location ? 'has-error' : '']">
                                    <label for="location">Location</label>
                                    <!-- <select class="form-control" style="font-size:12px" v-model="holidays.location">
                                        <option v-for="(opt, optKy) in slct_state" v-bind:key="optKy" v-bind:value="optKy">{{opt}}</option>
                                    </select> -->
                                    <multiselect
                                        v-model="holidays.location"
                                        :options="slct_state"
                                        :multiple="true"
                                        placeholder="Type to search"
                                        :close-on-select="false"
                                        track-by="id"
                                        label="value"
                                        >
                                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                                    </multiselect>
                                    <span v-if="errors.location" :class="['badge badge-danger']">{{ errors.location[0] }}</span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <v-client-table :class="'header-'+app_color" :data="holidayList" :columns="columns" :options="options" ref="trainerTable">
                <div slot="afterLimit" class="ml-2">

                </div>
                <div class="btn-group" slot="actions" slot-scope="{row}">
                    <a href="#formsection" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                </div>
            </v-client-table>
        </div>
    </div>
</div>
</template>
<script>
import moment from "moment";
export default {
    data() {
        return {
            app_color: app_color,
            holidayList: [],
            holidays: {
                id: '',
                name: '',
                day: '',
                month: '',
                location: '',
                type: 'day',
                week: '',
                weekday:''
            },
            isEdit: false,
            no_of_weeks: '',
            slct_state: window.slct_state,
            errors: [],
            // Vue-Tables-2 Syntax
            columns: [
                // "id",
                "name",
                "date",
                "location",
                "actions",
            ],
            options: {
                initialPage: 1,
                perPage: 10,
                highlightMatches: true,
                sortIcon: {
                    base: "fas",
                    up: "fa-sort-amount-up",
                    down: "fa-sort-amount-down",
                    is: "fa-sort",
                },
                headings: {
                    // id: "#",
                    name: "Holiday Name",
                    date: "Date",
                    location: "Location",
                    actions: "Actions",
                },
                sortable: ["id", "name", "date"],
                texts: {
                    filter: "Search:",
                    filterPlaceholder: "Search keywords",
                },
            },
        };
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            fetch(`/holidays/list`)
                .then((res) => res.json())
                .then((res) => {
                    // console.log(res);
                    this.holidayList = res.holidayList;
                })
                .catch((err) => console.log(err));
        },
        getNumWeeksForMonth( month) {
            var year = moment().format('YYYY')
            var date = new Date(year, month - 1, 1);
            var day = date.getDay();
            var numDaysInMonth = new Date(year, month, 0).getDate();
            return Math.ceil((numDaysInMonth + day) / 7);
        },
        saveHoliday() {
            swal.fire({
                title: "Please wait...",
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading();
                },
            });
            let data = {
                inputs: this.holidays,
                // savePages: vm.pages
            }
            axios
                .post(`/holidays/store`, data)
                .then((response) => {
                    if (response.data.status == "errors") {
                        // alert('error ghorl');
                        this.errors = response.data.errors;
                        Toast.fire({
                            position: "top-end",
                            type: "error",
                            title: "Failed to add data",
                        });
                    } else if (response.data.status == "success"){
                        // alert('success ghorl');
                        // response.data.status == "success"
                        // console.log(this.holidays);
                        this.errors = [];
                        // this.holidays = {};
                        this.holidays.id = '';
                        this.holidays.name = '';
                        this.holidays.day = '';
                        this.holidays.month = '';
                        this.holidays.location = '';
                        this.holidays.type = '';
                        this.holidays.week = '';
                        this.holidays.weekday ='';
                        this.isEdit = false;
                        this.fetchData();
                        Toast.fire({
                            position: "top-end",
                            type: "success",
                            title: "Data is saved successfully",
                        });
                    }
                })
                .catch((error) => {
                    // console.log(error);
                    Toast.fire({
                        position: "top-end",
                        type: "error",
                        title: "Failed to add data",
                    });
                });
        },
        edit(id) {
            this.isEdit = true;
            axios({
                    method: "get",
                    url: `/holidays/info/${id}`,
                })
                .then((res) => {
                    console.log(res);
                    this.holidays = res.data;
                    // this.holidays.date = moment(res.data.date)._d;
                })
                .catch((err) => console.log(err));
        },
        remove(id) {
            swal
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                })
                .then((result) => {
                    let vm = this;
                    if (result.value === true) {
                        axios({
                                method: "delete",
                                url: `/holidays/delete/${id}`,
                            })
                            .then((res) => {
                                console.log(res);
                                let i = vm.holidayList.map((item) => item.id).indexOf(id); // find index of your object
                                vm.holidayList.splice(i, 1); // remove it from array
                                if (res.data.status == "success") {
                                    Toast.fire({
                                        position: "top-end",
                                        type: "success",
                                        title: "Data is deleted successfully",
                                    });
                                } else {
                                    Toast.fire({
                                        position: "top-end",
                                        type: "error",
                                        title: "Opss.. data was not deleted",
                                    });
                                }
                            })
                            .catch((err) => console.log(err));
                    }
                });
        },
        onKeyUp() {
            this.errors = [];
        },
        dayRange (){
            let day = this.holidays.day;
            if(parseInt(day) > 31){
                this.holidays.day = 31;
            }else if(parseInt(day) < 1){
                this.holidays.day = 1;
            }else{
                this.holidays.day = day;
            }
        }
    },
    watch: {
        "holidays.type": function(newVal) {
            this.holidays.type = newVal;
        },
        "holidays.month": function(newVal) {
            this.holidays.month = newVal;
            this.no_of_weeks = this.getNumWeeksForMonth(newVal);
        }
    }
};
</script>
