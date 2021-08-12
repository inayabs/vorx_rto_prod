<template>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Trainer Commission Settings</h6>
            </div>
            <div class="card-body">
                <table width="50%">
                    <tr>
                        <td colspan="2"> <b>Trainer Details</b> </td>
                    </tr>
                    <tr>
                        <td width="12%"><b>Name:</b> </td>
                        <td><span>{{trainerInfo.firstname}}</span> <span>{{trainerInfo.middlename}}</span> <span>{{trainerInfo.lastname}}</span></td>
                    </tr>
                    <tr>
                        <td width="12%"><b>Email:</b></td>
                        <td>{{trainerInfo.email}}</td>
                    </tr>
                </table>
                <div class="clearfix" style="height:20px;"></div>
                <v-client-table :data="comsetList" :columns="columns" :options="options" ref="trainerTable">

                        <div slot="afterLimit" class="ml-2">

                            <div class="btn-group">
                                <a href="javascript:void(0)" class="btn btn-success" slot="afterLimit" @click="addSetting"><i class="fas fa-plus"></i> Add Setting</a>
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export to
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="far fa-file-pdf text-danger"></i>&nbsp; PDF</a>
                                    <a class="dropdown-item" href="#"><i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)</a>
                                </div>
                            </div>

                        </div>

                        <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(row.id)"> <i class="fas fa-edit"> </i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                        </div>

                </v-client-table> 
            </div>
        </div>
</template>
<script>
    const Toast = swal.mixin({
        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
    });

    import CreateComSetting from './createComSettingComponent.vue'

    export default {
        name: 'app-modal',
        components: {
            CreateComSetting
        },
        data() {
            return {
                trainerInfo : {
                    id: '',
                    firstname: '',
                    lastname: '',
                    email: '',
                },
                comsetList : [],
                trainer_id : window.trainer_id,
                comset_id : window.comset_id,

                // Vue-Tables-2 Syntax
                columns:['id','course_codes', 'student_quota','trainer_collab','commission_value','actions'],
                options: {
                    initialPage:1,
                    perPage:10,
                    highlightMatches:true,
                    sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                    headings: {
                        id: '#',
                        course_codes: 'Course',
                        student_quota: 'Student Target',
                        trainer_collab: 'Trainer Collab',
                        commission_value: 'Commission Value',
                        actions: 'Actions'
                    },
                    sortable: ['id','course_codes'],
                    texts: {
                        filter: "Search:",
                        filterPlaceholder: "Search keywords",
                    }
                },
            };
        },
        created() {
            this.fetchComSetting();
        },
        methods: {
            fetchComSetting(){
                axios({
                    method: 'get',
                    url: '/comsetting/list/'+trainer_id
                })
                .then(res => {
                    this.trainerInfo = res.data.trainerInfo;
                    this.comsetList = res.data.comsetList;
                })
                .catch(err => console.log(err));
            },
            addSetting (id){
                window.location.href = `/trainer-management/commission-settings/${this.trainer_id}/create`;
            },
            edit (id) {
                let comset_id = id;
                window.location.href = `/trainer-management/commission-settings/${this.trainer_id}/trainer/${comset_id}/edit`;
            },
            remove (id){
                let comset_id = id;
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
                            url: `/trainer-management/commission-settings/${this.trainer_id}/delete/${comset_id}`
                        })
                        .then(res => {
                        // console.log(res);
                        let i = vm.comsetList.map(item => item.id).indexOf(id) // find index of your object
                        vm.comsetList.splice(i, 1) // remove it from array
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
</style>