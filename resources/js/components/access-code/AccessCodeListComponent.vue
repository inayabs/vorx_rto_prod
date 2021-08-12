<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">Access Code List</h6>
            </div>
            <div class="card-body">
                <div>
                    <v-server-table url="/access-code/list" :class="'header-'+app_color" :columns="columns" ref="codeList" :options="options">
                        <div slot="afterLimit" class="ml-2">
                            <div class="btn-group">
                                <a
                                href="javascript:void(0)"
                                @click="generateCode"
                                class="btn btn-success"
                                slot="afterLimit"
                                >
                                <i class="fas fa-plus"></i> Generate Code
                                </a>
                            </div>
                        </div>
                        <div class="btn-group text-center" slot="created_at" slot-scope="{row}">
                            {{row.created_at | dateFormat}}
                        </div>
                        <div class="btn-group text-center" slot="actions" slot-scope="{row}">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" :id="'dropdownMenuButton-'+row.id" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="'dropdownMenuButton-'+row.id">
                                <!-- <a  target="_blank" class="dropdown-item" title="Edit">
                                    <i class="fa fa-edit" aria-hidden="true"></i> Edit
                                </a> -->
                                <a  href="javascript:void(0)" @click="deleteCode(row.id)" class="dropdown-item" title="Delete">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete
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
    export default {
        data() {
            return{ 
                 app_color: app_color,
                 codeList: [],
                 columns: ["process_id",'created_at','actions'],
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
                            sort: data.orderBy ? data.orderBy : "created_at",
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
                        // id: "#",
                        process_id: "Access Code",
                        created_at: "Date Created",
                        actions: "Actions"
                        },
                        sortable: ["created_at","process_id"],
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
            generateCode(){
                // Confirmation    
                    swal.fire({
                        title: 'Are you sure?',
                        text: "This will create Access Code.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, generate!'
                    }).then((result) => {
                        if (result.value) {
                            // // Loading Alert
                            swal.fire({
                                title: 'Generating Code',
                                html: 'Please wait...', // add html attribute if you want or remove
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    swal.showLoading()
                                },
                            });
                            // Sending Email 
                            axios({
                                method: 'post',
                                url: `/access-code/store`,
                            }).then(response => {
                            console.log(response);
                                if (response.data.status == 'success') {
                                    this.$refs.codeList.refresh();
                                    swal.fire({
                                        title: 'Successfully created Access Code',
                                        type: 'success',
                                        timer: 3000,
                                        showConfirmButton: false
                                    })
                                } else {
                                    Toast.fire({
                                        position: 'top-end',
                                        type: 'error',
                                        title: 'Opss.. something went wrong!',
                                    });
                                }

                            });
                        }
                    });
            },
            deleteCode(id){
            swal.fire({
                title: "Are you sure ?",
                text: "You wont be able to revert this!",
                type: "warning",
                width: "25%",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                })
                .then((result) => {
                if (result.value) {
                    axios
                    .delete(`/access-code/delete/${id}`)
                    .then((response) => {
                        this.$refs.codeList.refresh();
                        Toast.fire({
                            type: "success",
                            title: "You deleted successfuly",
                            position: "top-end",
                        });
                    })
                    .catch((error) => {
                        Toast.fire({
                            type: "error",
                            title: "Deletion failed",
                            position: "top-end",
                        });
                    });
                }
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
                return value == 1 ? 'Sent' : 'Not Yet Sent';
            },
            
        }
        
    }
</script>

<style lang="stylus" scoped>

</style>