<template>
    <div class="app-modal">
        <create-organisation/>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Organisation</h6>
            </div>
            <div class="card-body">
                <v-client-table :data="organisationList" :columns="columns" :options="options" ref="organisationTable">

                        <div slot="afterLimit" class="ml-2">

                            <div class="btn-group" v-if="organisationList.length == 0">
                                <a href="javascript:void(0)" @click="showCreateOrganisation" class="btn btn-success" slot="afterLimit">Create Organisation</a>
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
    import CreateOrganisation from './createOrganisationComponent.vue'
    export default {
        name: 'app-modal',
        components:{
            CreateOrganisation
        },
        data() {
            return {
                organisationList : [],

                // Vue-Tables-2 Syntax
                columns:['training_organisation_id','training_organisation_name','email_address','actions'],
                options: {
                    initialPage:1,
                    perPage:10,
                    highlightMatches:true,
                    sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                    headings: {
                        training_organisation_id: 'Training Organisation Identifier',
                        training_organisation_name: 'Training Organisation Name',
                        email_address: 'Email',
                        actions: 'Actions'
                    },
                    sortable: ['id','name'],
                    texts: {
                        filter: "Search:",
                        filterPlaceholder: "Search keywords",
                    }
                },
            };
        },
        created() {
            this.fetchOrganisation();
        },
        methods: {
            fetchOrganisation(page_url) {
                let vm = this;
                page_url = page_url || 'organisation/list'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.organisationList = res;
                        // vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            showCreateOrganisation() {
                this.$modal.show("size-modal");
            },
            edit (id) {
                window.location.href = 'organisation/'+id;
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
                            url: 'organisation/delete/'+id
                        })
                        .then(res => {
                        let i = vm.organisationList.map(item => item.id).indexOf(id) // find index of your object
                        vm.organisationList.splice(i, 1) // remove it from array
                        if(res.data.status == 'success'){
                            Toast.fire({
                                position: 'top-end',
                                type: 'success', title: 'Data is deleted successfully',
                            });
                        }else{
                            Toast.fire({
                                position: 'top-end',
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