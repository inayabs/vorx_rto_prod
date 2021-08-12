<template>
    <div>
        <div class="row mb-3"></div>
        <div class="clearfix"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'" id="directIfEdit">
            <h6>Release Commission</h6>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-12" style="border-right: 1px solid #355dce">
                <div class="form-padding-left-right mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="released_date">Released Date</label>
                                <!-- <date-picker :max-date="new Date()"locale="en"></date-picker> -->
                                <date-picker v-model="acr.released_date" locale="en"></date-picker>
                                <div v-if="errors && errors['acr.released_date']" class="badge badge-danger">{{ errors['acr.released_date'][0] }}</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input class="form-control" name="amount" v-model="acr.amount" type="text" id="amount">
                                <div v-if="errors && errors['acr.amount']" class="badge badge-danger">{{ errors['acr.amount'][0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status_id">Release Status</label>
                                <select name="status_id" v-model="acr.status_id" class="form-control">
                                    <option v-for="value in comm_statuses" v-bind:value="value.id" v-bind:key="value.id">{{value.description}}</option>
                                    <!-- <option value="Including">Including</option> -->
                                    <!-- <option value="Excluding">Excluding</option> -->
                                </select>
                                <div v-if="errors && errors['acr.status_id']" class="badge badge-danger">{{ errors['acr.status_id'][0] }}</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="payable_amount">Payable Amount</label>
                                <input class="form-control" name="payable_amount" v-model="acr.payable_amount" type="text" id="payable_amount">
                                <div v-if="errors && errors['acr.payable_amount']" class="badge badge-danger">{{ errors['acr.payable_amount'][0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="total_amount_received">Total Amount Received from students</label>
                                <input class="form-control" name="total_amount_received" v-model="acr.total_amount_received" type="text" id="total_amount_received">
                                <div v-if="errors && errors['acr.total_amount_received']" class="badge badge-danger">{{ errors['acr.total_amount_received'][0] }}</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <!-- <input class="form-control" name="address" type="text" id="address"> -->
                                <textarea name="remarks" v-model="acr.remarks" class="form-control" id="" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 pull-right text-right">
                            <button class="btn btn-success" @click="saveChanges()" ><i class="far fa-save"></i> {{this.saveBtnTtle}} Changes</button>
                        </div>
                    </div>
                    
                    <div class="clearfix mb-3"></div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12">
                <v-client-table :class="'header-'+app_color" :data="releaseCommissions" :columns="columns" :options="options" ref="courseTable">
                        <div slot="afterLimit" class="ml-2">
                            <div class="btn-group">
                                <!-- <a href="javascript:void(0)" class="btn btn-success" slot="afterLimit"><i class="fas fa-plus"></i> Add Course</a> -->
                                `<button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export to
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>`
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="far fa-file-pdf text-danger"></i>&nbsp; PDF</a>
                                    <a class="dropdown-item" href="#"><i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)</a>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group" slot="released_date" slot-scope="{row}">
                            {{row.released_date | auDateFormat}}
                        </div>
                        <div class="btn-group" slot="amount" slot-scope="{row}">
                            {{row.amount | currencyFormat}}
                        </div>
                        <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="#directIfEdit" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                        </div>
                </v-client-table>
            </div>
        </div>
        
        <!-- <div class="clearfix"></div> -->
        <!-- <div class="clearfix mb-3"></div> -->
        
    </div>
</template>


<script>

    import moment from "moment";

    export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                agent_id: window.agent.id,
                errors: [],
                acr: [],
                app_color: app_color,
                releaseCommissions: [],
                csrfToken: '',
                saveBtnTtle : 'Create',
                release_statuses: window.courses,
                editForm : 0,
                comm_statuses : window.comm_statuses,
                // Vue-Tables-2 Syntax
                columns: ['released_date', 'amount', 'comm_status.description', 'actions'],
                options: {
                    initialPage:1,
                    perPage:10,
                    highlightMatches:true,
                    skin: 'table text-center',
                    ascending: false,
                    sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                    headings: {
                        release_date: 'Release Date',
                        amount: 'Amount Paid',
                        'comm_status.description': 'Status',
                        actions: 'Actions'
                    },
                    sortable: ['released_date', 'amount', 'comm_status.description'],
                    texts: {
                        filter: "Search:",
                        filterPlaceholder: "Search keywords",
                    }
                },
            };
        },
        created() {
            this.fetchData();
            // console.log(this);
        },
        methods: {
            fetchData() {
                // console.log(course_id);
                axios({
                    method: 'get',
                    url: '/agent/commission-release/'+ this.agent_id
                })
                .then(res => {
                    this.releaseCommissions = res.data;
                })
                .catch(err => console.log(err));
            },
            edit(id){
                // alert(id);
                this.editForm = 1;
                this.errors = [];
                axios({
                    method: 'get',
                    url: '/agent/commission-release/'+id+'/edit'
                })
                .then(res => {
                    this.acr = res.data;
                    this.acr.released_date = moment(this.acr.registered_gst_date)._d;
                    this.saveBtnTtle = "Update";
                    // console.log(this.acr.registered_gst_date);
                })
                .catch(err => console.log(err));
            },
            saveChanges() {
                let vm = this;
                this.errors = [];
                axios.post('/agent/commission-release-save/'+ vm.agent_id,{
                    acr: vm.acr,
                    isEdit: vm.editForm,
                    agentID: vm.agent_id,
                    _token: vm.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'success'){
                         let successType = vm.editForm == 1 ? 'updated' : 'created';
                         Toast.fire({
                            position: 'top-end',
                            type: 'success', title: 'Release Commission '+successType+' successfully',
                        })
                        this.acr = {};
                        this.fetchData();
                        this.editForm = 0;
                        this.saveBtnTtle = "Create";
                    }else{
                         Toast.fire({
                            position: 'top-end',
                            type: 'error', title: res.data.msg,
                        })
                    }
                })
                .catch(err => {
                    console.log(err.response.data);
                    if (err.response.status === 422) {
                        vm.errors = err.response.data || {};
                        console.log(vm.errors);
                        // console.log(error.data);
                        // this.errors.push({});
                        // console.log(this.errors[index]);
                        Toast.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Opss.. Commission was not saved',
                        })
                    }
                });
            },
            remove(id){
                let vm = this;
                swal.fire({
                    title: 'Are you sure delete commission setting?',
                    text: " commission setting won't be able to revert!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/agent/delete/commission/'+id)
                        .then(function(res){
                        // vm.files = res.data;
                        if(res.data.status == 'success'){
                            swal.fire(
                                'Deleted!',
                                'commission report has been deleted.',
                                'success'
                            )
                            vm.fetchData();
                        }
                        })
                        .catch(function(error){
                        });
                    }
                });

            },
        },
        filters : {
            auDateFormat: function (date) {
                return date ? moment(date).format('DD/MM/YYYY') : '';
            },
            currencyFormat: function(number) {
                number = number ? parseInt(number) : 0;
                return '$' + number.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },
        }
    }
</script>

<style>
    .tab-pane {
        border: 1px solid #e0dfdf;
        border-top: none;
        padding: 1.3rem;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        background-color: #ffffff;
    }

</style>