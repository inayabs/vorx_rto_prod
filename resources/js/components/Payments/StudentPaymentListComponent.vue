<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Payment List</h6>
            </div>
            <div class="card-body">
                <div>
                    <v-server-table url="/student-payments/list" :class="'header-'+app_color" :columns="columns" ref="studentList" :options="options">
                        <div class="btn-group text-center" slot="name" slot-scope="{row}">
                            {{row.student.party.name}}
                        </div>
                        <div class="btn-group text-center" slot="course_code" slot-scope="{row}">
                            <span v-if="row.funded_student_course != null">
                                <span v-if="row.funded_student_course.course_code == '@@@@'">Unit of Competency</span>
                                <span v-else>{{row.funded_student_course.course.code}} - {{row.funded_student_course.course.name}}</span>
                            </span>
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
                        </div>
                        <div class="btn-group text-center" slot="actions" slot-scope="{row}">
                        <!-- <div class="dropdown"> -->
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" :id="'dropdownMenuButton-'+row.id" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="'dropdownMenuButton-'+row.id">
                            <a @click="viewPaymentReceipt(row.id)" target="_blank" class="dropdown-item" title="View Payment Receipt">
                                <i class="fa fa-eye"></i> View Payment Receipt
                            </a>
                            <a @click="sendPaymentReceipt(row)" class="dropdown-item" title="Send Payment Receipt">
                                <i class="fa fa-paper-plane"></i> Send Payment Receipt
                            </a>
                           <!-- <a  @click="sendPaymentReceipt(pd.id)" class="dropdown-item" title="Send Payment Receipt" v-if="app_settings.training_organisation_id === '45633'">
                                <i class="fa fa-paper-plane"></i> Send Payment Receipt<span v-if="pd.sent_receipt === 1" class="float-right"><i class="fa fa-check text-success"></i></span>
                            </a> -->
                            </div>
                        <!-- </div> -->
                        </div>
                    </v-server-table>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import moment from "moment";

    export default {
        data() {
            return{ 
                 app_color: app_color,
                 student_list: [],
                 columns: ["student_id", "name", "course_code",'amount', 'note', 'payment_date','sent_receipt','actions'],
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
                        pagination: {chunk: 5},
                        highlightMatches: true,
                        sortIcon: {
                        base: "fas",
                        up: "fa-sort-amount-up",
                        down: "fa-sort-amount-down",
                        is: "fa-sort"
                        },
                        headings: {
                        student_id: "Student ID",
                        name: "Student Name",
                        // type: "Student Type",
                        course_code: "Course",
                        note: "Note",
                        payment_date: "Payment Date",
                        // course_name: "Course Name",
                        // application_type: "Application Type",
                        sent_receipt:"Status",
                        actions: "Actions"
                        },
                        sortable: ["student_id","amount",'sent_receipt','payment_date'],
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
                                    this.$refs.studentList.refresh();
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
                return value == 1 ? 'Sent' : 'Not Yet Sent';
            },
            
        }
        
    }
</script>

<style lang="stylus" scoped>

</style>