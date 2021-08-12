<template>
    <div>
        <create-menu :from="fromData"/>
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 :class="'m-0 font-weight-bold text-'+app_color">Menus</h6>
        </div>
        
        <div class="card-body">
            <div class="row mb-3">
        <div class="col-md-12 pull-right text-right">
            <button class="btn btn-info btn" @click="openModal()">
                <i class="fas fa-plus"></i> Add
            </button>
            <button class="btn btn-success btn" @click="saveChanges()">
                <i class="far fa-save"></i> Save
            </button>
        </div>
    </div>
            <div>  
            <!-- <v-client-table :data="courseList" :columns="columns" :options="options" ref="courseTable"></v-client-table> -->
            <table class="table">
                <!-- menu_name", "add_on_name",'fa_icon', "link", "dropdown", "role_access","actions -->
                <thead class="thead-dark">
                    <tr>
                    <th class="text" :class="['background-'+app_color]" width="5%" scope="col">#</th>
                    <th class="text" :class="['background-'+app_color]" width="5%" scope="col" hidden>Order</th>
                    <th class="text" :class="['background-'+app_color]" width="15%" scope="col">Menu name</th>
                    <th class="text" :class="['background-'+app_color]" width="10%" scope="col">Add on name</th>
                    <th class="text" :class="['background-'+app_color]" width="10%">FA Icon</th>
                    <!-- <th class="text-center" :class="['background-'+app_color]" scope="col">End Date</th> -->
                    <th class="text" :class="['background-'+app_color]" width="20%" scope="col">Link</th>
                    <th class="text" :class="['background-'+app_color]" width="10%" scope="col">Dropdown</th>
                    <th class="text" :class="['background-'+app_color]" width="10%" scope="col">Default</th>
                    <th class="text" :class="['background-'+app_color]" width="10%" scope="col">Actions</th>                   
                    </tr>
                </thead>
                <draggable v-model="menuList" tag="tbody" @change="autoFill(-1)" @start="drag=true" @end="drag=false" >
                    <tr v-for="(item,index) in menuList" :key="index">
                        <td>{{index}}</td>
                        <td hidden>{{item.order}}</td>
                        <td>{{item.menu_name}}</td>
                        <td>{{item.add_on_name}}</td>
                        <td><i :class="item.fa_icon" v-if="item.fa_icon!=null"></i></td>
                        <td>{{item.link}}</td>
                        <td><i v-if="item.dropdown==1" class="fas fa-check"></i></td>
                        <td><i v-if="item.is_default==1" class="fas fa-check"></i></td>
                        <td>
                            <div class="btn-group">
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(item.id)">
                                <i class="fas fa-edit"></i>
                                </a>
                                <a
                                    href="javascript:void(0)"
                                    class="btn btn-danger btn-sm text-white"
                                    @click="remove(item.id)"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </draggable>
            </table>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
import createMenu from './createMenuModal.vue'
export default {
    components:{
        createMenu
        },
    data(){
        return{
            menuList:[],
            app_color:app_color,
            errors:[],
            fromData:{
                name:'Menu'
            }
        }
    },
    created(){
        this.getMenus();
    },
    methods:{
        openModal(){
            this.$modal.show('add-menu-modal');
        },
        saveChanges(){
            let dis = this;
            swal.fire({
            title: 'Save menu list?',
            html: "<i>Menu list order will be updated.</i>",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
            if (result.value) {
                swal.fire({
                    title: 'Updating menu list...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });

                axios.post('/menu/update_order',dis.menuList)
                .then(function(res){
                    // console.log(res.data);
                    if(res.data.status == 'success'){
                        // window.location.href = '/online-enrolment/process/'+res.data.process;
                    // vm.is_save = 1;
                    swal.fire(
                        'Success!',
                        'Page reload',
                        'success'
                    ).then(
                        (result)=>{
                            dis.getMenus();
                            location.reload();
                        }
                    );
                    }
                })
                .catch(function (err){
                    // console.log(err);
                    swal.fire(
                        'Oppss!',
                        'there seems to be a problem!',
                        'error'
                    )
                })
                
            }
        })
        },
        getMenus(){
            let dis = this;
            axios.get('/menu/list').then(
                response=>{
                    this.menuList = response.data;
                }
            ).catch(
                err=>{
                    this.errors = response;
                }
            );
        },
        edit(id){
            // console.log(id);
            location.href = `/menu/${id}`
        },
        remove(id){
            let dis = this;
            swal
                .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                })
                .then(result => {
                if (result.value) {
                    axios.get(`/menu/remove/${id}`).then(
                        response=>{
                            swal.fire(
                                'Success!',
                                'Page reload',
                                'success'
                            );

                            dis.getMenus();
                        }
                    ).catch(
                        err=>{
                            swal.fire(
                                'Oppss!',
                                'there seems to be a problem!',
                                'error'
                            )
                        }
                    );
                }
            });
            
        },
        autoFill(){
            console.log('hi');
        }
    },
    watch:{
        menuList: function(item){
            item.forEach(function(e,indx){
                e.index = indx;
            });
        }
    }
}
</script>
