<template>
    <div class="app-modal">
        <create-agent/>
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Agent List</h6>
        </div>
        <div class="card-body">

            <v-client-table :class="'header-'+app_color" :data="agentList" :columns="columns" :options="options">

                        <div slot="afterLimit" class="ml-2">

                            <div class="btn-group">
                                <a
                                    href="javascript:void(0)"
                                    @click="showCreateAgent"
                                    class="btn btn-success"
                                    slot="afterLimit"
                                >
                                    <i class="fas fa-plus"></i> Add Agent
                                </a>
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
                        <div class="text-center" slot="is_active" slot-scope="{row}">
                            <span class="badge badge-success" v-if="row.is_active == 1">{{row.is_active | statusLabel}}</span>
                            <span class="badge badge-warning" v-else>{{row.is_active | statusLabel}}</span>
                        </div>
                        <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="#formsection" class="btn btn-primary btn-sm" @click="agentDetail(row.id)"> <i class="fas fa-edit"> </i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="removeAgent(row.id)"> <i class="fas fa-trash"> </i></a>
                        </div>

                </v-client-table>

            <!-- <div class="table-responsive">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="text" v-on:keyup="searchAgent" v-model="agent.searchNameCompanyName" class="form-control bg-light border-1 small" placeholder="Search for Name or Company..." aria-label="Search" aria-describedby="basic-addon2">
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-6 pull-right text-right">
                        <button class="btn btn-success" @click="showCreateAgent" ><i class="fas fa-plus"></i> Add Agent</button>
                    </div>
                </div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th  class="text-center">#</th>
                        <th  class="text-center">Company</th>
                        <th  class="text-center">Email</th>
                        <th  class="text-center">Phone<br>Number</th>
                        <th  class="text-center">Active</th>
                        <th  class="text-center">Action</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="agent in agentList" v-bind:key="agent.id">
                            <td class="text-center">{{agent.id}}</td>
                            <td class="text-center">{{agent.detail.company_name}}</td>
                            <td class="text-center">{{agent.detail.email}}</td>
                            <td class="text-center">{{agent.detail.phone}}</td>
                            <td class="text-center">
                                <div v-if="agent.is_active == '1'">
                                    <i class="fas fa-check" style="color:green"></i>
                                </div>
                                <div v-else>
                                    <i class="fas fa-times" style="color:#e74a3b;"></i>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary btn-sm" @click="agentDetail(agent.id)"><i class="far fa-eye"></i></button>
                                    <button class="btn btn-danger btn-sm" @click="removeAgent(agent.id)"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row no-padding no-margin">
                    <div class="col-md-12 no-padding ">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchAgents(pagination.prev_page_url)">Previous</a></li>
                                <li class="page-item" disabled><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchAgents(pagination.next_page_url)">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div> -->
        </div>
        </div>
    </div>
</template>


<script>

    import CreateAgent from './createAgentComponent.vue'

    export default {
        name: 'app-modal',
        // mounted() {
        //     console.log('Component mounted.')
        // }
        components: {
            CreateAgent
        },
        data() {
            return {
                agentList : [],
                agent : {
                    id : '',
                    name: '',
                    company_name: '',
                    email: '',
                    phone: '',
                    is_active: '',
                },

                columns:['agent_code','agent_name','company_name','email', 'phone','is_active','actions'],
                app_color: app_color,
                options: {
                    initialPage:1,
                    perPage:10,
                    highlightMatches:true,
                    sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                    headings: {
                        'agent_code': 'Agent Code',
                        'agent_name': 'Agent Name',
                        'company_name': 'Company',
                        'email': 'Email',
                        'phone': 'Phone Number',
                        'is_active': 'Status',
                        actions: 'Actions'
                    },
                    sortable: ['agent_code','company_name', 'agent_name','email', 'phone'],
                    texts: {
                        filter: "Search:",
                        filterPlaceholder: "Search keywords",
                    }
                },

                agent_id : '',
                pagination : {},
                edit: false,
                searchNameCompanyName: '',
                url: 'agent/show/'
            };
        },
        created() {
            this.fetchAgents();
        },
        methods: {
            searchAgent() {
                let vm = this;
                console.log(this.agent.searchNameCompanyName);
                let search = (this.agent.searchNameCompanyName ? this.agent.searchNameCompanyName : '');

                fetch('agent/list/search/'+search)
                    .then(res => res.json())
                    .then(res => {
                        this.agentList = res.data;
                        // vm.makePagination(res);
                    })
                    .catch(err => console.log(err));
            },
            fetchAgents(page_url) {
                let vm = this;
                page_url = page_url || 'agent/list'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        console.log(res);
                        this.agentList = res;
                        console.log(this.agentList)
                        // vm.makePagination(res);
                    })
                    .catch(err => console.log(err));
            },
            // makePagination(meta){
            //     let pagination = {
            //         current_page: meta.current_page,
            //         last_page: meta.last_page,
            //         next_page_url: meta.next_page_url,
            //         prev_page_url: meta.prev_page_url
            //     }
            //     this.pagination = pagination
            // },
            showCreateAgent () {
                this.$modal.show('size-modal',{
                    edit : false,
                    id : '',
                    course_id : '',
                    name : '',
                    code : '',
                })
            },
            agentDetail (id) {
                window.location.href = 'agent/'+id;
            },
            removeAgent(id) {
                let vm = this;
                swal.fire({
                    title: 'Are you sure delete agent?',
                    text: " this won't be able to revert!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/agent/'+id)
                        .then(function(res){
                        // vm.files = res.data;
                        if(res.data.status == 'success'){
                            swal.fire(
                                'Deleted!',
                                'Agent has been deleted.',
                                'success'
                            )
                            vm.fetchAgents();
                        }
                        })
                        .catch(function(error){
                        });
                    }
                });
            }
  
            
        },
         filters: {
           statusLabel : function (value) {
                return value == 1 ? 'Active' : 'Inactive';
            },
            
        }
    }
</script>

<style scoped>
    th.text-center{
        background-color: #3f65d4;
        color: #fff;
        border:1px solid #3f65d4 !important;
        vertical-align: middle !important;
    }
    td.text-center{
        border-right-color: #fff !important;
        border-left-color: #fff !important;
        vertical-align: middle !important;
    }
</style>