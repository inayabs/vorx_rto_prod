<template>
    <div>
        <form @submit.prevent>
            <div>
                <div class="row mb-3">
                    <div class="col-md-12 pull-right text-right">
                        <button class="btn btn-success" @click="saveBankDetails"><i class="far fa-save"></i> Save</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                    <h6>Bank Details</h6>
                </div>
                <div class="form-padding-left-right">
                    <div class="row">
                        <div class="col-lg-6">
                            <div :class="['form-group', errors.bank_name ? 'has-error' : '']">
                                <label for="bank_name">Bank Name </label>
                                <input name="bank_name" value="" autofocus="autofocus" class="form-control" type="text" v-model="bank_details.bank_name" v-on:keyup="onKeyUp()">
                                <span v-if="errors.bank_name" :class="['badge badge-danger']">{{ errors.bank_name[0] }}</span>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div :class="['form-group', errors.bsb ? 'has-error' : '']">
                                <label for="bsb">BSB</label>
                                <input name="bsb" value="" autofocus="autofocus" class="form-control" type="text" v-model="bank_details.bsb" v-on:keyup="onKeyUp()">
                                <span v-if="errors.bsb" :class="['badge badge-danger']">{{ errors.bsb[0] }}</span>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div :class="['form-group', errors.account_name ? 'has-error' : '']">
                                <label for="account_name">Account Name</label>
                                <input name="account_name" value="" autofocus="autofocus" class="form-control" type="text" v-model="bank_details.account_name" v-on:keyup="onKeyUp()">
                                <span v-if="errors.account_name" :class="['badge badge-danger']">{{ errors.account_name[0] }}</span>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div :class="['form-group', errors.account_number ? 'has-error' : '']">
                                <label for="account_number">Account Number</label>
                                <input name="account_number" value="" autofocus="autofocus" class="form-control" type="text" v-model="bank_details.account_number" v-on:keyup="onKeyUp()">
                                <span v-if="errors.account_number" :class="['badge badge-danger']">{{ errors.account_number[0] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <v-client-table :data="bankList" :columns="columns" :options="options" ref="trainerTable" :class="'header-'+app_color">
            <div slot="afterLimit" class="ml-2">

                <!-- <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export to
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="far fa-file-pdf text-danger"></i>&nbsp; PDF</a>
                                    <a class="dropdown-item" href="#"><i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)</a>
                                </div>
                            </div> -->

            </div>
            <div class="btn-group" slot="actions" slot-scope="{row}">
                <a href="#formsection" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
            </div>
        </v-client-table>
    </div>
</template>
<script>
    export default {
        data() {
                return {
                    bank_details: {
                        training_organisation_id: window.training_organisation_id,
                        bank_name: '',
                        bsb: '',
                        account_name: '',
                        account_number: ''
                    },
                    organisation_id: window.organisation_id,
                    bankList: [],
                    // Vue-Tables-2 Syntax
                    columns: ['bank_name', 'bsb', 'account_name', 'account_number', 'actions'],
                    options: {
                        initialPage: 1,
                        perPage: 10,
                        highlightMatches: true,
                        sortIcon: {
                            base: 'fas',
                            up: 'fa-sort-amount-up',
                            down: 'fa-sort-amount-down',
                            is: 'fa-sort'
                        },
                        headings: {
                            bank_name: 'Bank Name',
                            bsb: 'BSB',
                            account_name: 'Account Name',
                            account_number: 'Account Number',
                            actions: 'Actions'
                        },
                        sortable: ['id', 'bank_name'],
                        texts: {
                            filter: "Search:",
                            filterPlaceholder: "Search keywords",
                        }
                    },
                    csrf: '',
                    errors: [],
                    success: false,
                    app_color: app_color,
                };
            },
            created() {
                this.fetchBank();
            },
            methods: {
                fetchBank(page_url) {
                        let vm = this;
                        page_url = page_url || `/organisation/${this.organisation_id}/bank/list`

                        fetch(page_url)
                            .then(res => res.json())
                            .then(res => {
                                this.bankList = res.bankList;
                            })
                            .catch(err => console.log(err));
                    },
                    saveBankDetails() {
                        swal.fire({
                            title: 'Please wait...',
                            // html: '',// add html attribute if you want or remove
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                            swal.showLoading()
                            },
                        });
                        this.bank_details.training_organisation_id = window.training_organisation_id;
                        axios.post(`/organisation/${this.organisation_id}/bank`, this.bank_details)
                            .then(response => {
                                // console.log(response);
                                if (response.data.status == "errors") {
                                    this.errors = response.data.errors;
                                    Toast.fire({
                                        position: 'top-end',
                                        type: 'error',
                                        title: 'Opss.. data was not saved',
                                    });
                                } else if(response.data.status == "success"){
                                    // alert('success ghorl');
                                    this.errors = [];
                                    this.bank_details = {},
                                    this.success = true;
                                    Toast.fire({
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'Data is saved successfully',
                                    });
                                    this.fetchBank();
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    edit(id) {
                        axios({
                                method: 'get',
                                url: `/organisation/${this.organisation_id}/bank/show/${id}`
                            })
                            .then(res => {
                                console.log(res);
                                this.bank_details = res.data.bank_info;
                            })
                            .catch(err => console.log(err));
                    },
                    remove(id) {
                        swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            let vm = this;
                            if (result.value === true) {
                                axios({
                                        method: 'delete',
                                        url: `/organisation/${this.organisation_id}/bank/delete/${id}`
                                    })
                                    .then(res => {
                                        let i = vm.bankList.map(item => item.id).indexOf(id) // find index of your object
                                        vm.bankList.splice(i, 1) // remove it from array
                                        if (res.data.status == 'success') {
                                            Toast.fire({
                                                position: 'top-end',
                                                type: 'success',
                                                title: 'Data is deleted successfully',
                                            });
                                        } else {
                                            Toast.fire({
                                                position: 'top-end',
                                                type: 'error',
                                                title: 'Opss.. data was not deleted',
                                            });
                                        }
                                    })
                                    .catch(err => console.log(err));
                            }
                        })
                    },
                    onKeyUp() {
                        this.errors = [];
                    },
            }
    }
</script>