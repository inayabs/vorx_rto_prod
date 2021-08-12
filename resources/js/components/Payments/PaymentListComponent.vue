<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Payment List</h6>
            </div>
            <div class="card-body">
                <div>
                    <v-server-table url="/payment/list" :class="'header-'+app_color" :columns="columns" ref="studentList" :options="options">
                        <div class="btn-group text-center" slot="course_code" slot-scope="{row}">
                            {{row.course_code}} - {{row.course_name}}
                        </div>
                        <div class="btn-group text-center" slot="payment_date" slot-scope="{row}">
                            {{row.payment_date | dateFormat}}
                        </div>
                        <div class="text-right" slot="amount" slot-scope="{row}">
                            {{row.amount | currencyFormat}}
                        </div>
                        <!-- <div class="btn-group text-center" slot="actions" slot-scope="{row}"> -->
                            <!-- <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="showStudent(row)"> -->
                            <!-- <i class="fas fa-eye"></i> -->
                            <!-- </a> -->
                            <!-- <a
                            href="javascript:void(0)"
                            class="btn btn-danger btn-sm text-white"
                            @click="deleteStudent(row.payment_id)"
                            >
                            <i class="fas fa-trash"></i>
                            </a> -->
                        <!-- </div> -->
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
                //  columns: ["student_id", "name", "course_code",'course_name','type','amount', "actions"],
                 columns: ["student_id", "name", "course_code",'amount', 'note', 'payment_date'],
                 options: {
                        requestFunction: function(data) {
                        // console.log(data);
                        // console.log(this.url);
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
                        console.log(data);
                        return {
                            sort: data.orderBy ? data.orderBy : "name",
                            direction: data.ascending ? "desc" : "asc",
                            page: data.page ? data.page : "page",
                            search: data.query ? data.query : null
                        };
                        },
                        responseAdapter({ data }) {
                        console.log(data.total);
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
                        student_id: "Student ID",
                        name: "Student Name",
                        type: "Student Type",
                        course_code: "Course",
                        note: "Note",
                        payment_date: "Payment Date",
                        // course_name: "Course Name",
                        // application_type: "Application Type",
                        actions: "Actions"
                        },
                        sortable: ["name", "course_code" , "course_name" ,"type" ,"amount"],
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
            showStudent(student){
                console.log(student);
                if(student.type == 'Domestic'){
                    window.location.href = "student/domestic/" + student.id;
                }else{
                    window.location.href = "student/" + student.id;
                }
            }
        },

        filters: {
            dateFormat : function (date) {
                return date ? moment(date).format('DD/MM/YYYY') : '';
            },
            currencyFormat: function(number) {
                number = number ? parseInt(number) : 0;
                return '$' + number.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },
        }
        
    }
</script>

<style lang="stylus" scoped>

</style>