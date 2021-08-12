<template>
    <div>
        <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
                <button  v-if="editForm" class="btn btn-warning" @click="cancelChanges()" ><i class="far fa-save"></i> Cancel Changes</button>
                <button class="btn btn-success" @click="saveChanges()" ><i class="far fa-save"></i> Save Changes</button>
            </div>
        </div>
        <div class="clearfix"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'" id="directIfEdit">
            <h6>Commission Settings</h6>
        </div>
        <div class="clearfix"></div>
        <div class="form-padding-left-right">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="courses">Course</label>
                        <select name="courses" class="form-control" v-model="acs.course_id">
                            <option v-for="value in courses" v-bind:value="value.id" v-bind:key="value.id">{{value.code}} - {{value.name}}</option>
                        </select>
                        <div v-if="errors && errors['acs.course_code']" class="badge badge-danger">{{ errors['acs.course_code'][0] }}</div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="all_courses">All Courses</label>
                        <div class="custom-control custom-switch my-2">
                            <input type="checkbox" class="custom-control-input" id="all_courses" v-model="acs.all_courses">
                            <label class="custom-control-label" for="all_courses"></label> 
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="commission_value">Commission Value</label>
                        <input class="form-control" name="commission_value" type="text" id="commission_value" v-model="acs.commision_value">
                        <div v-if="errors && errors['acs.commision_value']" class="badge badge-danger">{{ errors['acs.commision_value'][0] }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="registered_gst">Registered GST</label>
                        <!-- <div class="custom-control custom-switch my-2"> -->
                             <select name="agent_type" class="form-control" v-model="acs.gst_type">
                                <!-- <option v-for="value in prgRecog" v-bind:value="value.id" v-bind:key="value.id"></option> -->
                                <option value="registered">Registered</option>
                                <option value="not_registered">Not Registered</option>
                            </select>
                            <!-- <input type="checkbox" v-if="acs.gst_type" class="custom-control-input" id="registered_gst" v-model="acs.gst_type"> -->
                            <!-- <label class="custom-control-label" for="gst_type"></label>  -->
                            <div v-if="errors && errors['acs.gst_type']" class="badge badge-danger">{{ errors['acs.gst_type'][0] }}</div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="agent_type">GST Type</label>
                        <select name="agent_type" class="form-control" v-model="acs.gst_status">
                            <!-- <option v-for="value in prgRecog" v-bind:value="value.id" v-bind:key="value.id"></option> -->
                            <option value="1">Including</option>
                            <option value="0">Excluding</option>
                        </select>
                        <div v-if="errors && errors['acs.gst_status']" class="badge badge-danger">{{ errors['acs.gst_status'][0] }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="registered_gst_date">Registered GST Date</label>
                        <!-- <date-picker :max-date="new Date()" v-model="issue_date" locale="en"></date-picker> -->
                        <date-picker  locale="en" v-model="acs.registered_date"></date-picker>
                        <div v-if="errors && errors['acs.registered_date']" class="badge badge-danger">{{ errors['acs.registered_date'][0] }}</div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="starting_student_count">Starting Student Count</label>
                        <input class="form-control" name="starting_student_count" type="text" v-model="acs.starting_student_count" id="starting_student_count">
                        <div v-if="errors && errors['acs.starting_student_count']" class="badge badge-danger">{{ errors['acs.starting_student_count'][0] }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="starting_commission_value">Starting Commission Value</label>
                        <input class="form-control" name="starting_commission_value" type="text" v-model="acs.starting_commission_value" id="starting_commission_value">
                        <div v-if="errors && errors['acs.starting_commission_value']" class="badge badge-danger">{{ errors['acs.starting_commission_value'][0] }}</div>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <!-- <input class="form-control" name="address" type="text" id="address"> -->
                        <textarea name="remarks" class="form-control" id="" v-model="acs.remarks" ></textarea>
                    </div>
                </div>
            </div>
            <div class="clearfix mb-3"></div>
        </div>
        <div class="clearfix"></div>
        <div class="clearfix mb-3"></div>
        <v-client-table :class="'header-'+app_color" :data="commissionSettings" :columns="columns" :options="options" ref="courseTable">
                <div slot="afterLimit" class="ml-2">
                    <div class="btn-group">
                        <!-- <a href="javascript:void(0)" class="btn btn-success" slot="afterLimit"><i class="fas fa-plus"></i> Add Course</a> -->
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Export to
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>`
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="far fa-file-pdf text-danger"></i>&nbsp; PDF</a>
                            <a class="dropdown-item" href="#"><i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)</a>
                        </div>
                    </div>
                </div>
                <div class="registeredsign" slot="registered_gst" slot-scope="{row}">
                    <span v-if="row.registered_gst == 'Registered'" > <i class="fas fa-check" style="color: green;"></i> </span>
                    <span v-else> <i class="fas fa-times" style="color: rgb(231, 74, 59);"></i></span>
                </div>
                <div class="btn-group" slot="actions" slot-scope="{row}">
                    <a href="#directIfEdit" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                </div>
        </v-client-table>
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
                acs: {
                    // all_courses: false
                },
                errors: [],
                app_color: app_color,
                commissionSettings: [],
                csrfToken: '',
                courses: window.courses,
                editForm : 0,
                // Vue-Tables-2 Syntax
                columns: ['course_code', 'real_commission_value', 'gst_type', 'registered_gst', 'actions'],
                options: {
                    initialPage:1,
                    perPage:10,
                    highlightMatches:true,
                    skin: 'table text-center',
                    ascending: false,
                    sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                    headings: {
                        course_code: 'Course Code',
                        real_commission_value: 'Commission Value',
                        gst_type: 'GST Type',
                        registered_gst: 'Registered',
                        actions: 'Actions'
                    },
                    sortable: ['course_code', 'real_commission_value', 'gst_type', 'registered_gst'],
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
                    url: '/agent/show/commission/'+ this.agent_id
                })
                .then(res => {
                    this.commissionSettings = res.data;
                })
                .catch(err => console.log(err));
            },
            cancelChanges(){
                this.editForm = 0;
                this.acs = {}
            },
            edit(id){
                // alert(id);
                this.editForm = 1;
                this.errors = [];
                swal.fire({
                title: "Please wait...",
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                  swal.showLoading();
                },
              });
                axios({
                    method: 'get',
                    url: '/agent/edit/commission/'+ id
                })
                .then(res => {
                    this.acs = res.data;
                    this.acs.registered_date = moment(this.acs.registered_date)._d;
                    // console.log(this.acs.registered_gst_date);
                    swal.close();
                })
                .catch(err => {
                    console.log(err.response)
                    if(err.response.status == '401'){
                        Toast.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Please Login again . seesion expired',
                        })
                    }else{
                        Toast.fire({
                            position: 'top-end',
                            type: 'error',
                            title: err.response.data.message,
                        })
                    }
                }
                    // Toast.fire({
                    //         position: 'top-end',
                    //         type: 'error',
                    //         title: err.response,
                    //     })
                );
            },
            saveChanges() {
                let vm = this;
                this.errors = [];
                axios.post('/agent/save/commission/'+ vm.agent_id,{
                    acs: vm.acs,
                    isEdit: vm.editForm,
                    agentID: vm.agent_id,
                    _token: vm.csrfToken
                })
                .then(res => {
                    console.log(res);
                    if(res.data.status == 'success'){
                         let successType = vm.editForm == 1 ? 'updated' : 'created';
                         Toast.fire({
                            position: 'top-end',
                            type: 'success', title: 'Changes '+successType+' successfully',
                        })
                        this.acs = {all_courses:false};
                        this.fetchData();
                        this.editForm = 0;
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