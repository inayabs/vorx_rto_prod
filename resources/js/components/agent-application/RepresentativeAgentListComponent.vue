<template>
    <div>
        <verify-agent></verify-agent>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Representative Agent List</h6>
            </div>
            <div class="card-body">
                <div>
                    <v-server-table url="/representative-agent/list" :class="'header-'+app_color" :columns="columns" ref="agentList" :options="options">
                        <!-- <div class="btn-group text-center" slot="name" slot-scope="{row}">
                            {{row.student.party.name}}
                        </div>
                        <div class="btn-group text-center" slot="course_code" slot-scope="{row}">
                            <span v-if="row.funded_student_course != null">{{row.funded_student_course.course.code}} - {{row.funded_student_course.course.name}}</span>
                            <span v-else>{{row.offer_detail.course.code}} - {{row.offer_detail.course.name}}</span>
                        </div>
                        <div class="btn-group text-center" slot="payment_date" slot-scope="{row}">
                            {{row.payment_date | dateFormat}}
                        </div>
                        <div class="text-right" slot="amount" slot-scope="{row}">
                            {{row.amount | currencyFormat}}
                        </div>
                        <div class="text-center" slot="sent_receipt" slot-scope="{row}">
                            <span class="badge badge-success" v-if="row.sent_receipt == 1">{{row.sent_receipt | statusLabel}}</span>
                            <span class="badge badge-warning" v-else>{{row.sent_receipt | statusLabel}}</span>
                        </div> -->
                        <!-- <div class="text-left" slot="ref1_contact_person" slot-scope="{row}">
                            {{row.application_form.inputs.ref1_contact_person}} <span class="badge badge-success" v-if="row.ref_form_1 !== null">Confirmed</span> <span class="badge badge-secondary" v-else>Not Yet Confirmed</span>
                        </div>
                        <div class="text-left" slot="ref2_contact_person" slot-scope="{row}">
                            {{row.application_form.inputs.ref2_contact_person}} <span class="badge badge-success" v-if="row.ref_form_2 !== null">Confirmed</span> <span class="badge badge-secondary" v-else>Not Yet Confirmed</span>
                        </div> -->
                        <div class="text-center" slot="status" slot-scope="{row}">
                            <span class="badge badge-success" v-if="row.status == 'verified'">{{row.status | statusLabel}}</span>
                            <span class="badge badge-primary" v-else-if="row.status == 'complete'">{{row.status | statusLabel}}</span>
                            <span class="badge badge-secondary" v-else>{{row.status | statusLabel}}</span>
                        </div>
                        <div class="btn-group text-center" slot="actions" slot-scope="{row}">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" :id="'dropdownMenuButton-'+row.id" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="'dropdownMenuButton-'+row.id">
                                <div class="dropdown-header">Agent</div>
                                <a v-if="row.status == 'complete'" href="javascript:void(0)" @click="verify(row)" class="dropdown-item" title="Verify Application">
                                   <i class="fas fa-check"></i> Verify Agent
                                </a>
                                <a v-if="row.status == 'verified'" href="javascript:void(0)" @click="linkattachments(row)" class="dropdown-item" title="Link Attachments">
                                   <i class="fas fa-paperclip"></i> Link Attachments
                                </a>
                                <a @click="view(row)" target="_blank" class="dropdown-item" title="View Agent Form">
                                    <i class="fa fa-eye"></i> View Agent Form
                                </a>
                                <a @click="generate(row)" target="_blank" class="dropdown-item" title="Generate PDF Agent Form">
                                    <i class="far fa-file-pdf"></i> Generate PDF Agent Form
                                </a>
                                <a @click="viewattachment(row)" target="_blank" class="dropdown-item" title="View Agent Attachments">
                                    <i class="fas fa-eye"></i> View Agent Attachments
                                </a>
                                <div class="dropdown-header" v-if="row.ref_form_1 !== null">Reference 1</div>
                                <a @click="viewref1(row)" target="_blank" class="dropdown-item" title="View Reference 1 Form" v-if="row.ref_form_1 !== null">
                                    <i class="fas fa-eye"></i> View Reference 1 Form
                                </a>
                                <a @click="generateref1(row)" target="_blank" class="dropdown-item" title=" Generate PDF Reference 1 Form" v-if="row.ref_form_1 !== null">
                                    <i class="far fa-file-pdf"></i> Generate PDF Reference 1 Form
                                </a>
                                <div class="dropdown-header" v-if="row.ref_form_2 !== null">Reference 2</div>
                                <a @click="viewref2(row)" target="_blank" class="dropdown-item" title="View Reference 2 Form" v-if="row.ref_form_2 !== null">
                                    <i class="fas fa-eye"></i> View Reference 2 Form
                                </a>
                                <a @click="generateref2(row)" target="_blank" class="dropdown-item" title=" Generate PDF Reference 2 Form" v-if="row.ref_form_2 !== null">
                                    <i class="far fa-file-pdf"></i> Generate PDF Reference 2 Form
                                </a>
                            </div>
                        </div>
                    </v-server-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    import verifyAgent from "./VerifyAgentApplicationComponent.vue";
    export default {
        components: {
            verifyAgent,
        },
        data() {
            return{ 
                 app_color: app_color,
                 agent_list: [],
                 columns: ["id","process_id", "agent_name",'status','actions'],
                 options: {
                        requestFunction: function(data) {
                        return axios
                            .get(this.url, {
                            params: data
                            })
                            .catch(
                            function(e) {
                                this.dispatch("error", e);
                            }.bind(this)
                            );
                        },
                        requestAdapter(data) {
                        return {
                            sort: data.orderBy ? data.orderBy : "id",
                            direction: data.ascending ? "desc" : "asc",
                            page: data.page ? data.page : "page",
                            limit: data.limit ? data.limit : "10",
                            search: data.query ? data.query : null
                        };
                        },
                        responseAdapter({ data }) {
                        return {
                            data: data.data,
                            count: data.total
                        };
                        },
                        initialPage: 1,
                        perPage: 10,
                        highlightMatches: true,
                        sortIcon: {
                        base: "fas",
                        up: "fa-sort-amount-up",
                        down: "fa-sort-amount-down",
                        is: "fa-sort"
                        },
                        headings: {
                        process_id: "Process ID",
                        agent_name: "Agent Name",
                        status:"Status",
                        actions: "Actions"
                        },
                        sortable: ["id"],
                        rowClassCallback(row) {
                        return (row.id = row.id);
                        },
                        columnClasses: { id: "class-is" },
                        texts: {
                        filter: "Search:",
                        filterPlaceholder: "Search keywords"
                        }
                }
            }
        },
        methods: {
            viewPaymentReceipt(id) {
                window.open(
                    `/student/payment-receipt/preview/${id}`,
                    "_blank"
                );
            },
            sendPaymentReceipt(payment) {
                if(payment.sent_receipt == 1){
                        swal.fire({
                            title: 'Payment Receipt was already sent to student!',
                            type: 'warning',
                            timer: 3000,
                            showConfirmButton: false
                        });
                }else{
                    // Confirmation    
                    swal.fire({
                        title: 'Are you sure?',
                        text: "This will send payment receipt to student.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, send it!'
                    }).then((result) => {
                        if (result.value) {
                            // // Loading Alert
                            swal.fire({
                                title: 'Sending Email',
                                html: 'Please wait...', // add html attribute if you want or remove
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    swal.showLoading()
                                },
                            });
                            // Sending Email 
                            axios({
                                method: 'get',
                                url: `/student/payment-receipt/${payment.student_id}/${payment.id}/send`,
                            }).then(response => {
                            // console.log(response);
                                if (response.data.status == 'success') {
                                    this.$refs.agentList.refresh();
                                    swal.fire({
                                        title: 'Email sent!',
                                        type: 'success',
                                        timer: 3000,
                                        showConfirmButton: false
                                    })
                                } else {
                                    Toast.fire({
                                        position: 'top-end',
                                        type: 'error',
                                        title: 'Opss.. email was not sent',
                                    });
                                }

                            });
                        }
                    });
                }
            
            },
            view(data) {
                window.open(`/agent-application/get/${data.process_id}`, "_blank");
            },
            generate(data) {
                window.open(`/agent-application/pdf/${data.process_id}`, "_blank");
            },
            viewattachment(data) {
                window.open(`/agent-application/process/${data.process_id}`, "_blank");
            },
            viewref1(data) {
                window.open(`/reference-check/get/${data.process_id}/1`, "_blank");
            },
            viewref2(data) {
                window.open(`/reference-check/get/${data.process_id}/2`, "_blank");
            },
            generateref1(data) {
                window.open(`/reference-check/pdf/${data.process_id}/1`, "_blank");
            },
            generateref2(data) {
                window.open(`/reference-check/pdf/${data.process_id}/2`, "_blank");
            },
            verify(data) {
                if(data.ref_form_1 !== null && data.ref_form_2 !== null){
                    this.$modal.show("size-modal", data);
                }else{
                    swal.fire({
                        type: 'warning',
                        title: 'Opss... referrers must confirm first.',
                        timer: 5000,
                        showConfirmButton: false
                    });
                }
                
            },
            linkattachments(data) {
            swal.fire({
                title: "Please wait..",
                showConfirmButton: false,
                onBeforeOpen: () => {
                    swal.showLoading();
                },
            });
            axios
                .get(`representative-agent/attachment/${data.process_id}`)
                .then(function (res) {
                if (res.data.status == "success") {
                    swal.fire({
                        type: "success",
                        title: res.data.message,
                    });
                } else if(res.data.status == "attached"){
                    swal.fire({
                        type: "success",
                        title: res.data.message,
                    });
                } else if(res.data.status == "error"){
                    swal.fire({
                        type: "error",
                        title: res.data.message,
                    });
                }else{
                    swal.fire({
                        type: "error",
                        title: 'Oopss.. Something went wrong.',
                    });
                }
                
                })
                .catch(function (error) {
                console.log(error);
                });
            },
        },

        filters: {
            dateFormat : function (date) {
                return date ? moment(date).format('DD/MM/YYYY') : '';
            },
            currencyFormat: function(number) {
                number = number ? parseInt(number) : 0;
                return '$' + number.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },
            statusLabel : function (value) {
                let status = ''
                if(value.length > 1){
                    status = value.replace(/^./, value[0].toUpperCase());
                }
                return status;
            },
            // statusLabel : function (value) {
            //     return value == 1 ? 'Sent' : 'Not Yet Sent';
            // },
            
        }
        
    }
</script>

<style lang="stylus" scoped>

</style>