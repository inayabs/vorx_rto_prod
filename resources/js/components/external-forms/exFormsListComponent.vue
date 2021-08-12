<template>
    <div>
         <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">External Forms</h6>
            </div>
            <div class="card-body">
                <div>
                    <v-server-table
                        ref="exforms_table"
                        url="/external-forms/list"
                        :class="'header-'+app_color"
                        :columns="columns"
                        :options="options"
                    >
                        <div class="btn-group" slot="actions" slot-scope="{row}">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="showExternalForm(row.id)">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a
                                href="javascript:void(0)"
                                class="btn btn-danger btn-sm text-white"
                                @click="deleteForm(row.id)"
                            >
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </v-server-table>
                </div>
            </div>
         </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            app_color:app_color,
            columns:['id','name','form_type','actions'],
            options: {
                requestFunction: function (data) {
                // console.log(data);
                // console.log(this.url);
                    return axios
                        .get(this.url, {
                        params: data,
                        })
                        .catch(
                        function (e) {
                            this.dispatch("error", e);
                        }.bind(this)
                        );
                    },
                requestAdapter(data) {
                    return {
                        sort: data.orderBy ? data.orderBy : "created_at",
                        direction: data.ascending ? "desc" : "asc",
                        page: data.page ? data.page : "page",
                        limit: data.limit ? data.limit : "10",
                        search: data.query ? data.query : null,
                    };
                },
                responseAdapter({ data }) {
                // console.log(data.data);
                    return {
                        data: data.data,
                        count: data.meta.total,
                    };
                },
                initialPage: 1,
                perPage: 10,
                highlightMatches: true,
                sortIcon: {
                base: "fas",
                up: "fa-sort-amount-up",
                down: "fa-sort-amount-down",
                is: "fa-sort",
                },
                headings: {
                    // 'org_details.serial_no': "Serial number",
                    // 'party.name': "Hospital",
                    // // application_type: "Application Type",
                    // actions: "Actions",
                },
                // sortable: ["id", "party.name"],
                rowClassCallback(row) {
                    return (row.id = row.id);
                },
                columnClasses: { id: "class-is" },
                texts: {
                filter: "Search:",
                filterPlaceholder: "Search keywords",
                },
            },
        }
    },
    methods:{
        showExternalForm(id){
            location.href='/external-forms/'+id+'/check'
        },
        deleteForm(id){
            // console.log(id);
            swal
            .fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            })
            .then((result) => {
            let vm = this;
            if (result.value === true) {
                if (result.value) {
                        axios.get('/external-forms/delete/'+id)
                        .then(function(res){
                        // vm.files = res.data;
                        if(res.data.status == 'success'){
                            swal.fire(
                                'Deleted!',
                                'External form data has been deleted.',
                                'success'
                            )
                            vm.$refs.exforms_table.refresh();
                            // vm.fetchList();
                        }
                        })
                        .catch(function(error){
                        });
                    }
            }                
            });
        }
    }
}
</script>