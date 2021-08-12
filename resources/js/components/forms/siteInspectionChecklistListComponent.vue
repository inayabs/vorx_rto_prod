<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Site Inspection Checklist List</h6>
            </div>
            <div class="card-body">
                <div>
                    <v-client-table :class="'header-'+app_color" :data="list" :columns="columns" ref="studentList" :options="options">
                       
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
                    </v-client-table>
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
                 list: [],
                //  columns: ["student_id", "name", "course_code",'course_name','type','amount', "actions"],
                 columns: ["id","process_id", "team_members", "date_of_inspection",'training_delivery_location_address', 'action'],
                 options: {
                    initialPage:1,
                    perPage:10,
                    highlightMatches:true,
                    sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                    headings: {
                        id: '#',
                        process_id: 'Process ID',
                        team_members: 'Team Members',
                        training_delivery_location_address: 'Training Delivery Location Address',
                        date_of_inspection: 'Date of Inspection',
                        actions: 'Actions'
                    },
                    // sortable: ["Process", "Given Name", "Last Name", "Date of Birth","USI","Course Code", "Course Name","Start Date", "End Date"],
                    rowClassCallback(row) {
                        return row.id = row.id;
                    },
                    columnClasses: {id: 'class-is'},
                    texts: {
                        filter: "Search:",
                        filterPlaceholder: "Search keywords",
                    }
                 }
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            showStudent(student){
                console.log(student);
                if(student.type == 'Domestic'){
                    window.location.href = "student/domestic/" + student.id;
                }else{
                    window.location.href = "student/" + student.id;
                }
            },
            fetchData() {
                let vm = this;

                axios.get('/forms/site-inspection-checklist-form-list/fetch')
                .then(res => {
                    console.log(res.data);
                    vm.list = res.data;
                })
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
        }
        
    }
</script>

<style lang="stylus" scoped>

</style>