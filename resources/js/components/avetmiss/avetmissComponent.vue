<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Avetmiss (NAT Files)</h6>
            </div>
            <div class="card-body">
                <div>
                    <!-- <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a :class="'nav-item nav-link-'+app_color+' active'" id="nav-avetmiss-tab" data-toggle="tab" href="#nav-avetmiss" role="tab" aria-controls="nav-avetmiss" aria-selected="true">NAT Files</a>
                        </div>
                    </nav> -->
                    <!-- <div class="tab-content" id="nav-tabContent"> -->
                        <!-- <div class="tab-pane fade show active" id="nav-avetmiss" role="tabpanel" aria-labelledby="nav-avetmiss-tab"> -->
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- For AVT PROCESS LIST -->
                                    <h3>Process List <a @click="addProcess" class="add text-success"><i class="fas fa-plus-circle"></i></a></h3>
                                    <div class="col-md-12 plist">
                                        <a @click="selectProcess(item.process)" v-for="item in pList" :key="item.id">
                                        <div v-if="selectedProcess == item.process" :class="'card text-left card-'+app_color+' selected'">
                                        <!-- <img class="card-img-top" src="holder.js/100px180/" alt=""> -->
                                        <!-- <a class="close" href=""><i class="fas fa-times"></i></a> -->
                                            <div class="card-body">
                                                <h4 class="card-title">{{item.process}} <span class="h6"><i class="fas fa-unlock" v-if="item.is_locked == 0"></i><i class="fas fa-lock" v-else></i></span> </h4>
                                                <p class="card-text mb-0">{{generate.dateFrom | formatDate}} - {{generate.dateTo | formatDate}}</p>
                                                <p v-if="['',null].indexOf(item.remarks) == -1" class="font-weight-bold font-italic card-text mb-0 notes">Note: {{item.remarks}}</p>
                                            </div>
                                        </div>
                                        <div v-else :class="'card text-left card-'+app_color">
                                        <!-- <a class="close" href=""><i class="fas fa-times"></i></a> -->
                                            <div class="card-body">
                                                <h4 class="card-title">{{item.process}} <span class="h6"><i class="fas fa-unlock" v-if="item.is_locked == 0"></i><i class="fas fa-lock" v-else></i></span> </h4>
                                                <p class="card-text mb-0">{{item.dateFrom | formatDate}} - {{item.dateTo | formatDate}}</p>
                                                <p v-if="['',null].indexOf(item.remarks) == -1" class="font-weight-bold font-italic card-text mb-0 notes">Note: {{item.remarks}}</p>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <!-- FOR NAT FILE GENERATION -->
                                <h3>NAT File Generation</h3>
                                <div class="col-md-12">
                                        <form @submit.prevent>
                                            <div class="form-row">
                                                <!-- <div class="form-group col-md-5"> -->
                                                    <!-- <label for="month">Select Year:</label> -->
                                                    <!-- <input type="month" class="form-control" v-model="generate.dateFrom" min="2018-01" value=""> -->
                                                    <!-- <date-picker
                                                    locale="en"
                                                    :masks="{L:'YYYY'}"
                                                    :format="{L:'YYYY'}"
                                                    placeholder="Select year"
                                                    v-model="generate.year"
                                                    @change="getMonths(generate.year)"
                                                    v-bind:name="'year'"
                                                    v-bind:id="'year'"
                                                    ></date-picker> -->
                                                    <!-- <select id="year" v-model="generate.year" @change="getMonths(generate.year)" class="form-control">
                                                        <option value="2014">2014</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2020">2020</option>
                                                    </select> -->
                                                <!-- </div> -->
                                                <div class="form-group col-md-5">
                                                    <label for="year">End Month:</label>
                                                    <input type="month" class="form-control" v-model="generate.dateTo" @change="getMonths()" min="2018-01" value="">
                                                    <!-- <select id="year" v-model="generate.dateTo" @change="getMonth(generate.dateTo)" class="form-control">
                                                        <option value="01">January</option>
                                                        <option value="02">Febuary</option>
                                                        <option value="03">March</option>
                                                        <option value="04">April</option>
                                                        <option value="05">May</option>
                                                        <option value="06">Jun</option>
                                                        <option value="07">July</option>
                                                        <option value="08">August</option>
                                                        <option value="09">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">Novermber</option>
                                                        <option value="12">December</option>
                                                    </select> -->
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="year">Report To:</label>
                                                    <select id="year" v-model="generate.report_to" class="form-control">
                                                        <option value="*" selected>NCVER</option>
                                                        <option :value="v.state_key" v-for="(v,k) in states" :key="k">{{v.state_name}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <div class="clearfix" style="height: 22px;"></div>
                                                    <button @click="generateNAT" type="submit" :class="'btn btn-'+app_color" v-if="generate.is_locked == 0">Generate</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div v-if="selectedProcess != ''">
                                            <div class="row" v-if="generate.is_locked == 0">
                                                <div class="col-md-12">
                                                    <label class="mb-0 font-weight-bold" for="note">Note:</label>
                                                </div>
                                                <div class="col-md-10 col-sm-10 col-xs-10 pr-0">
                                                    <textarea name="" id="" v-model="generate.remarks" class="form-control notes-text" placeholder="Notes..."></textarea>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-2 pl-0">
                                                    <button @click="saveRemarks" :class="`btn-${app_color}`" class="btn notes-save form-control">Save Note</button>
                                                </div>
                                            </div>
                                            <div class="row" v-else>
                                                <div class="col-md-12">
                                                    <label class="mb-0 font-weight-bold" for="note">Note:</label>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <textarea name="" id="" readonly v-model="generate.remarks" class="form-control" placeholder="Notes..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-8 text-left" v-if="selectedProcess != '' ">
                                                <a class="btn btn-danger btn-sm" @click="deleteProcess(selectedProcess)" v-if="generate.is_locked == 0"><i class="fas fa-trash-alt"></i> Delete</a>
                                                <a class="btn btn-success btn-sm" @click="downloadNatFile(selectedProcess)"><i class="fas fa-download"></i> Download</a>
                                                
                                            </div>
                                            <div class="col-md-4 text-right" v-if="selectedProcess != ''">
                                                <a class="btn btn-secondary btn-sm" @click="toggleLock(generate.is_locked)" v-if="generate.is_locked == 1"><i class="fas fa-lock"></i> Lock</a>
                                                <a class="btn btn-info btn-sm" @click="toggleLock(generate.is_locked)" v-else><i class="fas fa-unlock"></i> Unlock</a>
                                            </div>
                                        </div>
                                        <br>
                                        <v-client-table :data="natList" :class="'header-'+app_color" :columns="columns" :options="options" ref="avetmissTable">

                                                <!-- <div slot="afterLimit" class="ml-2">

                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-success" slot="afterLimit"><i class="fas fa-plus"></i> Generate</a>
                                                    </div>

                                                </div> -->

                                                <!-- <div class="btn-group" slot="actions" slot-scope="{row}">
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                                                </div> -->

                                        </v-client-table>
                                </div>
                                </div>
                            </div>
                            
                        <!-- </div> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import GenerateNAT from './generateNATComponent.vue';
    import moment from "moment";
    export default {
        name: 'app-modal',
        components:{
            // GenerateNAT
        },
        data() {
            return {
                app_color: app_color,
                avetmiss : [],
                pList: [],
                selectedProcess: '',
                generate: {
                    report_to: '*',
                },
                states: window.states,
                natList: [],
                // Vue-Tables-2 Syntax
                columns:['name','description','count'],
                options: {
                    initialPage:1,
                    perPage:10,
                    highlightMatches:true,
                    sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                    headings: {
                        name: 'NAT File',
                        description: 'Description',
                        count: 'Count',
                    },
                    sortable: ['description','name'],
                    texts: {
                        filter: "Search:",
                        filterPlaceholder: "Search keywords",
                    }
                },
            };
        },
        created() {
            this.processList();
        },
        methods: {
            fetchData() {
                // axios({
                //     method: 'get',
                //     url: `/avetmiss/process-`
                // })
                // .then(res => {
                //     console.log(res);
                // })
                // .catch(err => console.log(err));
            },
            saveRemarks() {
                let vm = this;

                Toast.fire({
                    position: 'bottom-end',
                    showConfirmButton: false,
                    type : 'info',
                    title: 'Saving remarks...',
                })

                axios.post('/avetmiss/save-remarks', vm.generate)
                .then( res => {
                    if(res.data.status == 'success') {
                        Toast.fire({
                            position: 'bottom-end',
                            showConfirmButton: false,
                            type : 'success',
                            title: 'Remarks saved successfully!',
                        })
                        vm.processList();
                    }
                })
                .catch( err => {
                    console.log(err)
                    Toast.fire({
                        position: 'bottom-end',
                        showConfirmButton: false,
                        type : 'error',
                        title: 'There seems to be a problem...',
                    })
                })

            },
            toggleLock(lock) {
                let vm = this;

                swal.fire({
                    title: lock == 1 ? 'Locking process...' : 'Unlocking process',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });

                axios.post('/avetmiss/toggle-lock', {
                    is_locked : lock,
                    process_id: this.selectedProcess,
                })
                .then( res => {

                    console.log(res.data)
                    if(res.data.status == 'success'){
                        vm.generate.is_locked = res.data.is_locked;
                        vm.processList();
                        // swal.fire(
                        // 'Success!',
                        // 'process '+ res.data.is_locked == 1 ? 'locked.' : 'unlocked',
                        // 'success'
                        // )
                        Toast.fire({
                            // position: 'top-end',
                            type: 'success',
                            title: res.data.is_locked == 1 ? 'Process locked.' : 'Process unlocked.',
                        })
                    }else{
                        Toast.fire({
                            // position: 'top-end',
                            type: 'error', title: 'There seems to be a problem',
                        })
                    }
                })
                .catch( err => {
                    console.log(err)
                    swal.fire(
                    'Opps!',
                    'there seems to be a problem',
                    'error'
                    )
                })
            },
            processList() {
                let vm = this;
                axios({
                    method: 'get',
                    url: `/avetmiss/process-list`
                })
                .then(res => {
                    // console.log(res.data);
                    vm.pList = res.data;
                })
                .catch(err => console.log(err));
            },
            deleteProcess(process) {
                let vm = this;
                swal.fire({
                    title: 'Delete process?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        // loading
                        swal.fire({
                            title: 'Deleting process..',
                            // html: '',// add html attribute if you want or remove
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                swal.showLoading()
                            },
                        });

                        // delete process
                        axios({
                            method: 'get',
                            url: '/avetmiss/delete-process/'+process
                        })
                        .then(res => {
                            if(res.data.status == 'success'){
                                vm.processList();
                                vm.natList = [];
                                vm.generate = {report_to: '*',};
                                vm.selectedProcess = '';
                                swal.fire(
                                'Success!',
                                'process deleted.',
                                'success'
                                )
                            }
                                   
                        })
                        .catch(err => console.log(err));
                    }
                })
            },
            addProcess() {
                let vm = this;
                swal.fire({
                    title: 'Create new process?',
                    // text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, create it!'
                }).then((result) => {
                    if (result.value) {
                        // create process
                        axios({
                            method: 'get',
                            url: '/avetmiss/create-process'
                        })
                        .then(res => {
                            if(res.data.status == 'success'){
                                vm.processList();
                                swal.fire(
                                'Success!',
                                'New process created.',
                                'success'
                                )
                            }
                                   
                        })
                        .catch(err => console.log(err));
                    }
                })
            },
            selectProcess(process, load = 1) {
                // alert(process);
                let loading = null
                if(load == 1){
                    loading = swal.fire({
                        title: 'Loading Process ID',
                        // html: '',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            swal.showLoading()
                        },
                    });
                }

                let vm = this;
                vm.selectedProcess = process;
                axios({
                    method: 'get',
                    url: '/avetmiss/nat-count-list/'+process
                })
                .then(res => {
                    vm.natList = res.data.nat;
                    vm.generate = res.data.process;
                    vm.generate.year = res.data.process.dateFrom.split('-')[0];
                    // console.log(vm.generate.year);
                    // vm.generate.year = 
                    if(load == 1){
                        loading.close();
                    }
                })
                .catch(err => console.log(err));
            },
            generateNAT (){
                // generate
                let vm = this;
                
                if(typeof vm.generate.dateTo === 'undefined' || ['',null].indexOf(vm.generate.dateTo) != -1){
                    swal.fire({
                        type: 'error', title: 'End month is required',
                    });
                }

                if(vm.selectedProcess == ''){
                    swal.fire({
                        type: 'error', title: 'Please select process id',
                    });
                }else{
                    if(vm.generate.dateFrom > vm.generate.dateTo){
                        swal.fire({
                            type: 'error', title: 'Start Month must be less than End Month.',
                        });
                        return false;
                    }

                    let loading = swal.fire({
                        title: 'Generating NAT Files',
                        html: 'this may take a while...',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            swal.showLoading()
                        },
                    });
                    // return false;

                    axios.post('/avetmiss/generate', {
                        dateFrom: vm.generate.dateFrom,
                        dateTo: vm.generate.dateTo,
                        report_to: vm.generate.report_to,
                        process_id: vm.selectedProcess
                    })
                    .then(function (res) {
                        // loading.close();
                        if(res.data.status == 'success'){
                            swal.fire({
                                type: 'success', title: 'NAT Files Generated',
                            });
                            vm.selectProcess(vm.selectedProcess, 0);
                        }else{
                            let msg = typeof res.data.message !== 'undefined' ? res.data.message : 'Error detected. Please contact support team';
                            swal.fire({
                                type: 'error', title: msg,
                            });
                        }
                    })
                    .catch(function (error) {
                        loading.close();
                        swal.fire({
                            type: 'error', title: 'Error detected. Please contact support team',
                        });
                    });

                }
            },
            getMonths() {
                console.log(this);
                let year = this.generate['dateTo'].split('-');
                this.generate['dateFrom'] = year[0]+'-01';
                console.log(this.generate['dateFrom']);
                // this.generate['dateTo'] = year+'-12';
            },
            downloadNatFile(process_id) {
                // alert(process_id);
                window.location.href = '/avetmiss/download/'+process_id;
            },
            // edit (id) {
            //     window.location.href = 'trainer/'+id;
            // },
            // remove (id){
            //     swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     type: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes, delete it!'
            //     }).then((result) => {
            //         let vm = this;
            //         if (result.value === true) {
            //             axios({
            //                 method: 'delete',
            //                 url: 'trainer-management/'+id
            //             })
            //             .then(res => {
            //             console.log(res);
            //             let i = vm.trainerList.map(item => item.id).indexOf(id) // find index of your object
            //             vm.trainerList.splice(i, 1) // remove it from array
            //             if(res.data.status == 'success'){
            //                 Toast.fire({
            //                     type: 'success', title: 'Data is deleted successfully',
            //                 });
            //             }else{
            //                 Toast.fire({
            //                     type: 'error', title: 'Opss.. data was not deleted',
            //                 });
            //             }
            //             })
            //             .catch(err => console.log(err));
            //         }
            //     })
            // }
        },
        filters : {
            formatDate: function (date) {
                console.log(date);
                return date ? moment(date).format('MMMM YYYY') : '';
            },
        }
    }
</script>

<style scoped>
table.table tr th{
    width: 130px;
} 
    th{
        background-color: #3f65d4;
        color: #fff;
        border:1px solid #3f65d4 !important;
    }
    td{
        border-right-color: #fff !important;
        border-left-color: #fff !important;
    }
    .plist {
        max-height: 600px;
        overflow: auto;
    }
    .card.text-left {
        margin-bottom:10px;
        cursor: pointer;
        
    }
    /* .card.text-left:hover {
        background-color: #024B67;
        color: #fff;
    }
    .selected {
        background-color: #024B67;
        color: #fff;
    } */
    .close {
        color: red;
        text-align: right;
    }
    .add {
        cursor: pointer;
        font-size: 20px;
    }
    .notes {
        width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>