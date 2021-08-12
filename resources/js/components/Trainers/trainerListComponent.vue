<template>
    <div class="app-modal">
        <create-trainer/>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Trainer List</h6>
            </div>
            <div class="card-body">
                <v-client-table :class="'header-'+app_color" :data="trainerList" :columns="columns" :options="options" ref="trainerTable">

                        <div slot="afterLimit" class="ml-2">

                            <div class="btn-group">
                                <a href="javascript:void(0)" @click="showCreateTrainer" class="btn btn-success" slot="afterLimit"><i class="fas fa-plus"></i> Add Trainer</a>
                                <!-- <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export to
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="far fa-file-pdf text-danger"></i>&nbsp; PDF</a>
                                    <a class="dropdown-item" href="#"><i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)</a>
                                </div> -->
                            </div>

                        </div>
                        <div slot="course_taught" slot-scope="{row}">
                            <!-- {{row.course_taught}} -->
                            <span v-if="['N/A', null, '', []].indexOf(row.course_taught) == -1">
                                <ul>
                                    <li v-for="(v,k) in row.course_taught" :key="k">{{v.name}}</li>
                                </ul>
                            </span>
                            <span v-else>{{row.course_taught}}</span>

                        </div>
                        <div slot="course_location" slot-scope="{row,index}">
                            <span v-if="row.course_location!=''&&typeof row.course_location!='undefined'&&row.course_location!='N/A'">
                                <ul>
                                    <li v-for="(cl,index) in row.course_location" :key="index"> 
                                        {{cl.postcode}} - {{cl.suburb}} - {{cl.state}}
                                    </li>
                                </ul>
                            </span>
                            <span v-else>
                                N/A
                            </span>
                        </div>
                        <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                        </div>

                </v-client-table>
            </div>
        </div>
    </div>
</template>


<script>

    import CreateTrainer from './createTrainerComponent.vue'

    export default {
        name: 'app-modal',
        components: {
            CreateTrainer
        },
        data() {
            return {
                app_color: app_color,
                trainerList : [],
                courseList : [],
                trainer : {
                    id : '',
                    firstname: '',
                    lastname: '',
                },
                trainer_id : '',
                url: 'trainer/show/',

                // Vue-Tables-2 Syntax
                columns:['name', 'phone_number','email','course_taught','course_location','actions'],
                options: {
                    initialPage:1,
                    perPage:10,
                    highlightMatches:true,
                    sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                    headings: {
                        Name: 'Trainer Name',
                        phone_number: 'Phone Number',
                        email: 'Email',
                        course_taught: 'Course Taught',
                        course_location: 'Course Location',
                        actions: 'Actions'
                    },
                    sortable: ['name'],
                    texts: {
                        filter: "Search:",
                        filterPlaceholder: "Search keywords",
                    }
                },
            };
        },
        created() {
            this.fetchTrainers();
        },
        methods: {
            fetchTrainers(page_url) {
                let vm = this;
                page_url = page_url || 'trainer/list'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        console.log(res);
                        this.trainerList = res.data;
                        // vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            showCreateTrainer () {
                this.$modal.show('size-modal',{
                    id : '',
                    trainer_id : '',
                    firstname : '',
                    lastname : '',
                    email : '',
                    phone_number: '',
                })
            },
            commissionSetting (id) {
                window.location.href = 'trainer-management/commission-settings/'+id;
            },
            edit (id) {
                window.location.href = 'trainer/'+id;
            },
            remove (id){
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
                            url: 'trainer-management/'+id
                        })
                        .then(res => {
                        console.log(res);
                        let i = vm.trainerList.map(item => item.id).indexOf(id) // find index of your object
                        vm.trainerList.splice(i, 1) // remove it from array
                        if(res.data.status == 'success'){
                            Toast.fire({
                                type: 'success', title: 'Data is deleted successfully',
                            });
                        }else{
                            Toast.fire({
                                type: 'error', title: 'Opss.. data was not deleted',
                            });
                        }
                        })
                        .catch(err => console.log(err));
                    }
                })
            }
        }
    }
</script>

<style scoped>
    /* table.table tr th{
        width: 130px;
    }  */
    /* th{
        background-color: #3f65d4;
        color: #fff;
        border:1px solid #3f65d4 !important;
    }
    td{
        border-right-color: #fff !important;
        border-left-color: #fff !important;
    } */
    /* th#VueTables_th--course_taught {
        width: 50% !important;
    } */
    ul {
        list-style-type:square;
        padding-left: 20px;
    }
</style>