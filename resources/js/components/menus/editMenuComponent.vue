<template>
    <div>
        <create-menu :from="fromData"/>
        <edit-menu :subMenuData="editSubmenuData"/>
        <div class="row mb-2 d-flex justify-content-between">
            <div class="col-md-6">
                <a
                :href="'/menu-list'"
                v-bind:class="'btn btn-'+app_color+' btn-sm text-'+app_color+' text-light'"
                >
                <i class="fas fa-long-arrow-alt-left"></i> Back
                </a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">
                {{menu.menu_name}}
                </h6>
            </div>
            <div class="card-body">
                <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                    <h6>Menu details</h6>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 pull-right text-right">
                    <button class="btn btn-success btn-sm" @click="saveChanges()">
                        <i class="far fa-save"></i> Save details
                    </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div :class="['form-group', errors.menu_name ? 'has-error' : '']" >
                            <label for="menu_name">Menu name</label>
                            <input type="text" class="form-control" v-model="menu.menu_name">
                            <span v-if="errors.menu_name" :class="['badge badge-danger']">{{ errors.menu_name[0] }}</span>
                        </div>                       
                    </div>
                    <div class="col-md-6">
                        <div :class="['form-group', errors.add_on_name ? 'has-error' : '']" >
                            <label for="menu_name">Add-on name</label>
                            <input type="text" class="form-control" v-model="menu.add_on_name">
                            <span v-if="errors.add_on_name" :class="['badge badge-danger']">{{ errors.add_on_name[0] }}</span>
                        </div>                       
                    </div>
                    <div class="col-md-6">
                        <div :class="['form-group', errors.fa_icon ? 'has-error' : '']" >
                            <label for="menu_name">Fa icon</label>
                            <input type="text" class="form-control" v-model="menu.fa_icon">
                        </div>                       
                    </div>
                    <div class="col-md-6">
                        <div :class="['form-group', errors.link ? 'has-error' : '']" >
                            <label for="menu_name">Link</label>
                            <input type="text" class="form-control" v-model="menu.link">
                        </div>                       
                    </div>
                    <div class="col-md-6">
                        <div :class="['form-group', errors.dropdown ? 'has-error' : '']" >
                            <label for="menu_name">Dropdown</label>
                            <input type="checkbox" class="form-control" v-model="menu.new_dropdown">
                        </div>                       
                    </div>
                    <div class="col-md-6">
                        <div :class="['form-group', errors.is_default ? 'has-error' : '']" >
                            <label for="menu_name">Default</label>
                            <input type="checkbox" class="form-control" v-model="menu.is_default">
                        </div>                       
                    </div>
                    <div class="col-md-6">
                        <div :class="['form-group', errors.role_access ? 'has-error' : '']" >
                            <label for="menu_name">Role access</label>
                            <!-- <input type="text" class="form-control"> -->
                            <multiselect
                                v-model="menu.role_access"
                                :options="roles"
                                :multiple="true"
                                :close-on-select="false"
                                :class="'multiselect-color-'+app_color"
                                placeholder="Select role"
                            />
                        </div>                       
                    </div>
                </div>
                <div v-if="menu.dropdown == true">
                    <div :class="'horizontal-line-wrapper-'+app_color+' my-3'" >
                    <h6>Sub menu list</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pull-right text-right">
                            <button class="btn btn-info btn-sm" @click="openModal()">
                                <i class="fas fa-plus"></i> Add
                            </button>
                            <button class="btn btn-success btn-sm" @click="saveOrder()">
                                <i class="far fa-save"></i> Save order
                            </button>
                        </div>
                    </div>
                    <div>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th :class="['background-'+app_color]" width="5%" scope="col">#</th>
                                    <th :class="['background-'+app_color]" width="" scope="col" hidden>Order</th>
                                    <th :class="['background-'+app_color]" width="15%" scope="col">Sub menu name</th>
                                    <th :class="['background-'+app_color]" width="15%" scope="col">Add-on name</th>
                                    <th :class="['background-'+app_color]" width="10%%" scope="col">FA icon</th>
                                    <th :class="['background-'+app_color]" width="10%" scope="col">Link</th>
                                    <th :class="['background-'+app_color]" width="10%" scope="col">Default</th>
                                    <th :class="['background-'+app_color]" width="30%" scope="col">Role access</th>
                                    <th :class="['background-'+app_color]" width="10%" scope="col">Actions</th>
                                </tr>
                            </thead>
                                <draggable v-model="menu.sub_menus" tag="tbody" @change="autoFill(-1)" @start="drag=true" @end="drag=false" v-if="menu.sub_menus.length>0">
                                    <tr v-for="(item,index) in menu.sub_menus" :key="index">
                                        <td>{{index}}</td>
                                        <td hidden>{{item.order}}</td>
                                        <td>{{item.menu_name}}</td>
                                        <td>{{item.add_on_name}}</td>
                                        <td><i :class="item.fa_icon" v-if="item.fa_icon!=null"></i></td>
                                        <td>{{item.link}}</td>
                                        <td><i v-if="item.is_default==1" class="fas fa-check"></i></td>
                                        <td>
                                            <ul v-if="item.role_access!=null">
                                                <li v-for="ra in item.role_access" :key="ra">{{ra}}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="edit(item)">
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
                                <draggable v-else>
                                    <tr>
                                        <td colspan="9">No data found</td>
                                    </tr>
                                </draggable>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import createMenu from './createMenuModal.vue';
import editMenu from './editMenuModal.vue';
export default {
    components:{
        createMenu,
        editMenu
    },
    data(){
        return{
            app_color:app_color,
            menu_id:menu_id?menu_id:'',
            menu:{},
            roles:[
                'Super-Admin',
                'User',
                'Trainer',
                'Staff',
                'Demo',
                'Student',
                'Agent'
            ],
            errors:{},
            // subMenu:{},
            fromData:{
                name:'Sub Menu',
                id:menu_id
            },
            editSubmenuData:{}
        }
    },
    created(){
        this.getMenus();
    },
    methods:{
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
                    axios.get(`/submenu/remove/${id}`).then(
                        response=>{
                            swal.fire(
                                'Success!',
                                'Submenu removed',
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
        edit(row){
            // console.log(row);
            this.editSubmenuData = row;
            this.$modal.show('edit-submenu-modal');
        },
        openModal(){
            this.fromData = {name:'Sub Menu',id:menu_id};
            this.$modal.show('add-menu-modal');
        },
        getMenus(){
            axios.get(`/menu/${this.menu_id}/details`).then(
                response=>{
                    this.menu = response.data;
                }
            );
        },
        saveOrder(){
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

                axios.post('/submenu/update_order',dis.menu.sub_menus)
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
                            // location.reload();
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
        saveChanges(){
            let dis = this;
            swal.fire({
                title: 'Updating menu details',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
            });

            axios.post('/menu/update',this.menu).then(
                response=>{
                    if(response.data.status == 'success'){
                        // window.location.href = '/online-enrolment/process/'+res.data.process;
                    // vm.is_save = 1;
                    // this.$parent.getMenus();
                    swal.fire(
                        'Success!',
                        'Update success',
                        'success'
                    );
                        dis.getMenus();
                    }else{
                        Toast.fire({
                            type: "error",
                            title: "Opss.. something went wrong",
                            background: "#ffcdd2"
                        });
                        this.errors = response.data.errors;
                    }
                }
            ).catch(
                err=>{
                    this.errors = err;
                }
            );
        },
        autoFill(){
            console.log('hi');
        }
    },
    watch:{
        menu:{
            handler:function(item){
                if(item.dropdown == true){
                    item.link = ''
                }
                item.sub_menus.forEach(function(e,indx){
                    e.index = indx;
                });
            },
            deep:true
        },
    }
}
</script>