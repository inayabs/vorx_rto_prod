<template>
    <modal
        name="edit-submenu-modal"
        transition="nice-modal-fade"
        classes="demo-modal-class"
        :min-width="200"
        :min-height="200"
        :pivot-y="0.1"
        :adaptive="true"
        :scrollable="true"
        :reset="true"
        width="40%"
        height="auto"
        @before-open="beforeOpen"
        @opened="opened"
        @closed="closed"
        @before-close="beforeClose"
    >
    <div class="size-modal-content px-1">
      <h4 :class="'modal-header-'+app_color">Edit</h4>
      <form @submit.prevent>
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.menu_name ? 'has-error' : '']" >
                <label for="menu_name">Name</label>
                    <input type="text" v-model="subMenuData.menu_name" class="form-control">
                    <span v-if="errors.menu_name" :class="['badge badge-danger']">{{ errors.menu_name[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.add_on_name ? 'has-error' : '']" >
                <label for="add_on_name">Add-on name</label>
                    <input type="text" v-model="subMenuData.add_on_name" class="form-control">
                  <span v-if="errors.add_on_name" :class="['badge badge-danger']">{{ errors.add_on_name[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.fa_icon ? 'has-error' : '']" >
                <label for="add_on_name">FA Icon:</label> <i v-if="subMenuData.fa_icon!=null&&subMenuData.fa_icon!=''" :class="subMenuData.fa_icon"></i>
                    <input type="text" v-model="subMenuData.fa_icon" class="form-control">
                  <span v-if="errors.fa_icon" :class="['badge badge-danger']">{{ errors.fa_icon[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.link ? 'has-error' : '']" >
                <label for="add_on_name">Link</label>
                    <input type="text" v-model="subMenuData.link" class="form-control">
                  <span v-if="errors.link" :class="['badge badge-danger']">{{ errors.link[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.is_default ? 'has-error' : '']" >
                <label for="add_on_name">Default</label>
                    <input type="checkbox" v-model="subMenuData.is_default" class="form-control">
                  <span v-if="errors.is_default" :class="['badge badge-danger']">{{ errors.is_default[0] }}</span>
                </div>
            </div>
            <div class="col-md-12">
                <div :class="['form-group', errors.role_access ? 'has-error' : '']" >
                    <label for="menu_name">Role access</label>
                    <!-- <input type="text" class="form-control"> -->
                    <multiselect
                        v-model="subMenuData.role_access"
                        :options="roles"
                        :multiple="true"
                        :close-on-select="false"
                        :class="'multiselect-color-'+app_color"
                        placeholder="Select role"
                    />
                  <span v-if="errors.role_access" :class="['badge badge-danger']">{{ errors.role_access[0] }}</span>
                </div>                       
            </div>
            <div class="col-md-6" v-if="subMenuData.name == 'Menu'">
                <div :class="['form-group', errors.dropdown ? 'has-error' : '']" >
                <label for="add_on_name">Dropdown</label>
                <input type="checkbox" v-model="subMenuData.dropdown">
                    <!-- <input type="checkbox" v-model="menu.dropdown" class="form-control">
                  <span v-if="errors.dropdown" :class="['badge badge-danger']">{{ errors.dropdown[0] }}</span> -->
                </div>
            </div>
        </div>
        <button :class="'btn btn-'+app_color+' btn-sm mt-3 float-right'" @click="saveMenu">
          <i class="far fa-save"></i> Save
        </button>
        <div class="clearfix w-100"></div>
      </form>
    </div>
    </modal>
</template>
<script>
export default {
    data(){
        return{
            app_color: app_color,
            errors: {},
            isModal: "true",
            opt: [],
            isLoading: false,
            roles:[
                'Super-Admin',
                'User',
                'Trainer',
                'Staff',
                'Demo',
                'Student',
                'Agent'
            ],
        }
    },
    props:['subMenuData'],
    computed:{
        link(){
            if(this.from.name =='Menu'){
                return `/menu/add`
            }else if(this.from.name=='Sub Menu'){
                return `/submenu/${this.from.id}/add`
            }
        }
    },
    methods:{
        saveMenu(){
            // console.log('haluu');
            swal.fire({
                title: 'Saving Submenu',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
            });

            axios.post('/submenu/update',this.subMenuData).then(
                response=>{
                    if(response.data.status == 'success'){
                        // window.location.href = '/online-enrolment/process/'+res.data.process;
                    // vm.is_save = 1;
                    this.$parent.getMenus();
                    swal.fire(
                        'Success!',
                        'New menu added.',
                        'success'
                    ).then(
                        result=>{
                            this.$modal.hide('add-menu-modal');
                        }
                    );
                    }else{
                        Toast.fire({
                            type: "error",
                            title: "Opss.. something went wrong",
                            background: "#ffcdd2"
                        });
                        this.errors = response.data.errors;
                        // swal.close();
                    }
                }
            ).catch(
                err=>{
                    
                }
            );
        },
        beforeOpen(e) {
        // this.fields = {};
        // console.log('test');
        // console.log(e);
        // console.log(e);
        // this.menu = e;
        },
        beforeClose(e) {
        // this.new_attendance.student_type = '';
        this.isLoading = false;
        },
        opened(e) {
        // e.ref should not be undefined here
        // console.log('opened', e)
        // console.log('ref', e.ref)
        
        },
        closed(e) {
        // this.errors = "";
        // this.menu.menu_name = ''
        // this.menu.add_on_name = ''
        // this.menu.link = ''
        // this.menu.fa_icon = ''
        // this.new_attendance.student='';
        },
        capitalize(s){
            return s.replace(/\w\S*/g, function(txt){
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }
    },
    watch:{
        menu:{
            handler(item){
                if(typeof item !='undefined'){
                    item.menu_name = this.capitalize(item.menu_name);
                    item.add_on_name = item.add_on_name.toLowerCase();
                    item.fa_icon = item.fa_icon.toLowerCase();
                    item.link = item.link.toLowerCase();
                    // item.dropdown
                    if(item.dropdown==true){
                        item.link = ''
                    }
                }
            },
            deep:true
        }
    }
}
</script>
