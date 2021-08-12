<template>
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
</template>
<script>

    import CreateCommission from './createComSettingComponent.vue'
    import CommissionDetail from './commissionSettingDetailComponent.vue'

    export default {
        name: 'app-modal',
        components: {
            CreateCommission,
            CommissionDetail,
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
            fetchComSetting(page_url) {
            let vm = this;
            page_url = page_url || '/comsetting/list/'+trainer_id
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    vm.trainerInfo = res.trainerInfo;
                    vm.comsetList = res.comsetList;
                })
                .catch(err => console.log(err));
            },
            addSetting () {
                this.$modal.show('size-modal',{
                    edit : false,
                    id : '',
                    course_codes : '',
                    student_quota : '',
                    commission_type_id : '',
                    commission_value : '',
                    trainer_collab : '',
                })
            },
            edit (id) {
                let comset_id = id;
                this.$modal.show('size-modal-edit',{
                    edit : true,
                    id : comset_id,
                })
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
                            url: `/trainer/commission-settings/${this.trainer_id}/delete/${comset_id}`
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