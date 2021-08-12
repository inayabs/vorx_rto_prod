<template>
    <div>
        <div class="row mb-3">
            <div class="col-md-6 pull-left text-left">
                <h5 v-if="agent.detail.agent_code != null" class="px-26-font">Agent Code: <b>{{agent.detail.agent_code}}</b></h5>
            </div>
            <div class="col-md-6 pull-right text-right">
                <button class="btn btn-success" @click="saveChanges()" ><i class="far fa-save"></i> Save Changes</button>
            </div>
        </div>
        <div class="clearfix"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
            <h6>Agent Information</h6>
        </div>
        <div class="clearfix"></div>
        <div class="form-padding-left-right">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input class="form-control" name="company_name" type="text" v-model="agent.detail.company_name" id="company_name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                            <label for="is_active">Active</label>
                            <div class="custom-control custom-switch my-2">
                                <input type="checkbox" class="custom-control-input" id="is_active" v-model="agent.detail.is_active">
                                <label class="custom-control-label" for="is_active"></label> 
                            </div>
                        </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="vet_flag_status">Status</label>
                        <div class="custom-control custom-switch my-2">
                            <input type="checkbox" class="custom-control-input" id="vet_flag_status" v-model="agent.is_active">
                            <label class="custom-control-label" for="vet_flag_status"></label> 
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="agent_name">Agent Name</label>
                        <input class="form-control" name="agent_name" type="text" v-model="agent.detail.agent_name" id="agent_name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="agent_type">Shore Type</label>
                        <select name="agent_type" class="form-control" v-model="agent.detail.agent_type">
                                <!-- <option v-for="value in prgRecog" v-bind:value="value.id" v-bind:key="value.id"></option> -->
                                <option value="ON-SHORE">ON-SHORE</option>
                                <option value="OFF-SHORE">OFF-SHORE</option>
                            </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input class="form-control" name="address" type="text" v-model="agent.detail.office_address" id="address">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" name="email" type="email" v-model="agent.detail.email" id="email">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email_2">Alt Email</label>
                        <input class="form-control" name="email_2" v-model="agent.detail.email_2" type="email"  id="email_2">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone #</label>
                        <input class="form-control" name="phone" type="text" v-model="agent.detail.phone" id="phone">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mobile">Mobile #</label>
                        <input class="form-control" name="mobile" v-model="agent.detail.mobile" type="text"  id="mobile">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fax_number">Fax #</label>
                        <input class="form-control" name="fax_number" type="text" v-model="agent.detail.fax_number" id="fax_number">
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- <div class="form-group">
                        <label for="position">Position</label>
                        <input class="form-control" name="position" v-model="agent.position" type="text"  id="position">
                    </div> -->
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input class="form-control" name="website" type="text" v-model="agent.detail.website" id="website">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes" v-model="agent.detail.notes" id="notes"></textarea>
                    </div>
                </div>
            </div>
            <div class="clearfix mb-2"></div>
            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>Bank Account Details</h6>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input class="form-control" name="bank_name" type="text" v-model="agent.detail.bank_name" id="bank_name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account_name">Account Name</label>
                        <input class="form-control" name="account_name" type="text" v-model="agent.detail.account_name" id="account_name">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bsb">BSB</label>
                        <input class="form-control" name="bsb" type="text" v-model="agent.detail.bsb" id="bsb">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input class="form-control" name="account_number" type="text" v-model="agent.detail.account_number" id="account_number">
                    </div>
                </div>
            </div>
            <div class="clearfix mb-2"></div>
            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>Education Agent Agreement</h6>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <button class="btn btn-success" @click="createAgreement()">
                    <i class="fas fa-pdf"></i> Create Agent Agreement PDF
                    </button>
                </div>
                <div class="col-md-6 text-right">
                    <div class="form-group">
                        <br>
                        <button class="btn btn-warning" @click="sendAgreement(agent.detail.id)"><i class="fab fa-telegram-plane"></i> Send</button>
                        <a
                        target="_blank"
                        :href="`/agent/preview-agent-agreement/${agent.detail.id}`"
                        class="btn btn-success"
                        >
                        <i class="fas fa-file-pdf"></i> View
                        </a>
                        <!-- <button class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                agent_id: window.agent.id,
                agent: {
                    detail:window.agent
                },
                csrfToken: '',
                app_color: app_color,
            };
        },
        created() {
            this.fetchData();
            this.agent.detai.is_active = typeof this.agent.detail.is_active !== 'undefined'  && this.agent.detail.is_active == 1 ? true : false;
            // console.log(this);
        },
        methods: {
            fetchData() {
                // console.log(course_id);
                axios({
                    method: 'get',
                    url: '/agent/show/info/'+ this.agent_id
                })
                .then(res => {
                    console.log(res.data);
                    this.agent = {
                        detail: res.data
                    };
                })
                .catch(err => console.log(err));
            },
            saveChanges() {

                // alert(this.csrfToken);

                axios.post('/agent/show/info/update/'+ this.agent_id,{
                    agent: this.agent,
                    _token: this.csrfToken
                })
                .then(res => {
                    console.log(res);
                    if(res.data.status == 'updated'){
                         Toast.fire({
                            // position: 'top-end',
                            type: 'success', title: 'Changes saved successfully',
                        })
                        this.fetchData;
                    }else{
                         Toast.fire({
                            // position: 'top-end',
                            type: 'error', title: 'Opss.. was not saved successfully',
                        })
                    }
                })
                .catch(err => console.log(err));
            },
            createAgreement(){
            swal
                .fire({
                    title: "Are you sure ?",
                    text:
                    "Creating new Agent Agreement will delete the EXISTING.",
                    type: "warning",
                    width: "25%",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Continue!",
                })
                .then((result) => {
                    if (result.value) {
                    swal.fire({
                        title: "Please wait...",
                        // html: '',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                        swal.showLoading();
                        },
                    });
                    axios
                        .get(
                        "/agent/" + this.agent.detail.id+ "/generate_agent_agreement"
                        )
                        .then((res) => {
                        if (res.data.status == "success") {
                            swal.fire({
                            type: "success",
                            title: "Created Successfuly",
                            });
                        } else {
                            swal.fire({
                            type: "error",
                            title: res.data.message,
                            });
                        }
                        // console.log(res);
                        })
                        .catch((err) => {
                        swal.fire({
                            type: "error",
                            title: res.data.message,
                        });
                        });
                    }
                });
            },
            sendAgreement(id) {
            const Toast = swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
            swal
                .fire({
                title: "Are you sure ?",
                text: "Resend application verification email",
                type: "warning",
                width: "25%",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, send it!",
                })
                .then((result) => {
                if (result.value) {
                    swal.fire({
                    title: "Please wait...",
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading();
                    },
                    });

                    axios
                    .get(`/agent/application-email/${id}/send`)
                    .then((response) => {
                        if (response.data.status == "success") {
                        swal.fire({
                            type: "success",
                            title: "Emailed successfuly",
                        });
                        } else {
                        swal.fire({
                            type: "error",
                            title: response.data.message,
                        });
                        }
                    })
                    .catch((error) => {
                        swal.fire({
                            type: "error",
                            title: response.data.message,
                        });
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