<template>
    <form @submit.prevent>
        <div>
            <div class="row mb-3">
                <div class="col-md-12 pull-right text-right">
                    <button class="btn btn-success" @click="saveChanges()"><i class="far fa-save"></i> Save Changes</button>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
         <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>Email segments</h6>
            </div>
            <div class="form-padding-left-right">
                <div class="row">
                    <div class="col-lg-6">
                        <div :class="['form-group']" >
                            <label for="enrolment">Label:</label>
                            <input type="text" class="form-control" v-model="email_segment.label">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-padding-left-right form-group">
                    <div class="row">
                        <label for="enrolment">Emails -<span class="badge"><i>separate with comma(,)</i></span></label>
                        <textarea name="" class="form-control" id="" cols="30" rows="10" v-model="email_segment.emails"></textarea>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
            <div class="col-lg-12">
                <!-- <v-client-table
                        :class="'header-'+app_color"
                        :data="pdVars.email_segments"
                        :columns="columns"
                        :options="options"
                        >
                    <div slot="#" slot-scope="{index}"> 
                        {{index}}
                    </div>
                    <div slot="emails" slot-scope="{row}"> 
                       <div style="width:90%;overflow:hidden;text-overflow:ellipsis">
                           {{row.emails}}
                        </div> 
                    </div>
                    <div class="btn-group" slot="actions" slot-scope="{row}">
                        <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(row)"> <i class="fas fa-edit"> </i></a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                    </div>
                </v-client-table> -->

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th :class="['background-'+app_color]" width="10%" scope="col">#</th>
                        <th  :class="['background-'+app_color]" width="80%" scope="col">Label</th>
                        <th :class="['background-'+app_color]" width="10%" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(es,index) in pdVars.email_segments" :key="index">
                            <td>{{index+1}}</td>
                            <td >{{es.label}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(es)"> <i class="fas fa-edit"> </i></a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(es.id)"> <i class="fas fa-trash"> </i></a>
                                </div>                                
                            </td>
                        </tr>
                        <tr v-if="pdVars.email_segments==''">
                            <td colspan="6" style="text-align:center;">No data found</td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
    </form>
</template>
<script>
export default {
    name:'pdSegments',
    props:[
        'pdVars'
    ],
    data(){
        return{
            app_color:app_color,
            email_segment:{
                label:'',
                emails:'',
            },
            columns: ['#', 'label','actions'],
            options: {
                initialPage: 1,
                perPage: 10,
                highlightMatches: true,
                sortIcon: {
                base: "fas",
                up: "fa-sort-amount-up",
                down: "fa-sort-amount-down",
                is: "fa-sort"
                },
            }
        };
    },
    
    methods:{
        edit(row){
            this.email_segment = row;
        },
        remove(id){
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    axios({
                        method: 'get',
                        url: '/pdplan/segment/delete/' + id,
                    }).then(response => {
                        swal.fire(
                            'Deleted!',
                            'Email template has been deleted.',
                            'success'
                        );
                        this.$parent.$data.update = !this.$parent.$data.update;
                    });
                }
            });
        },
        saveChanges(){
             swal.fire({
                title: 'Saving Changes...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
            });

            let vm = this;

            axios.post('/pdplan/email-segment/save',
                this.email_segment
            ).then(
                response=>{
                    if(response.data.status=='added'||response.data.status=='updated'){
                        swal.fire(
                        "Succes!",
                        "Data "+response.data.status+" successfully.",
                        "success"
                        );
                        this.$parent.$data.update = !this.$parent.$data.update;
                        this.email_segment = {
                            label:'',
                            emails:''
                            };
                    }else{
                        var html = response.data.msg
                        swal.fire({
                            type: 'error',
                            title: 'Cannot proceed.',
                            html: html
                        })
                    }                    
                }                
            ).catch(
                err=>console.log(err)
            );
        },
        // fetch_segments(){
        //     axios.get('/pdplan/email-segment/fetch').then(
        //         response=>{
        //             this.email_segments = response.data;
        //             this.$emit('updateSegment',this.email_segments);
        //         }
        //     );
        // }
    }
}
</script>


<style scoped>
    .note {
        font-style: italic !important;
        font-size: 10px !important;
    }
    .card_logo {
        background-color: #d2d2d2;
    }
    .org_logo {
        width: 200px !important;
        margin: 0 auto;
    }
    .close{
        position: absolute;
        width: 100%;
        text-align: right;
    }
    .reload {
        font-style: italic !important;
        font-size: 10px !important;
        text-decoration: underline;
        color: #fff;
        cursor: pointer;
    }
    #VueTables_th--emails{
        width: 15px;
    }
</style>