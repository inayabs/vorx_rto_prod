<template>
    <div>
        <!-- <create-commission/> -->
        <!-- <commission-detail/> -->
        <div class="row mb-2 d-flex justify-content-between">
        <div class="col-md-6">
            <a href="/trainer-management" class="btn btn-sm text-primary text-light" v-bind:class="'btn-'+app_color"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
        </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Trainer Details</h6>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Info</a>
                        <!-- <a class="nav-item nav-link" id="nav-comsetting-tab" data-toggle="tab" href="#nav-comsetting" role="tab" aria-controls="nav-comsetting" aria-selected="true">Commission Settings</a> -->
                        <!-- <a class="nav-item nav-link" id="nav-attachments-tab" data-toggle="tab" href="#nav-attachments" role="tab" aria-controls="nav-attachments" aria-selected="true">Attachments</a> -->
                        
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                        <div>
                            <div class="row mb-3">
                                <div class="col-md-12 pull-right text-right">
                                    <button class="btn btn-success" @click="checkLogins()"><i class="far fa-save"></i> Save Changes</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                                <h6>Trainer Information</h6>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-padding-left-right">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">Firstname *</label>
                                            <input class="form-control" name="firstname" type="text" v-model="trainer.firstname" id="firstname">
                                            <div v-if="typeof errors['trainer.firstname'] !== 'undefined'" class="badge badge-danger">{{ errors['trainer.firstname'][0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="middlename">Middlename</label>
                                            <input class="form-control" name="middlename" type="text" v-model="trainer.middlename" id="middlename">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Lastname *</label>
                                            <input class="form-control" name="lastname" type="text" v-model="trainer.lastname" id="lastname">
                                            <div v-if="typeof errors['trainer.lastname'] !== 'undefined'" class="badge badge-danger">{{ errors['trainer.lastname'][0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number *</label>
                                            <input class="form-control" name="phone_number" type="number" v-model="trainer.phone_number" id="phone_number">
                                            <div v-if="typeof errors['trainer.phone_number'] !== 'undefined'" class="badge badge-danger">{{ errors['trainer.phone_number'][0] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input class="form-control" name="email" type="email" v-model="trainer.email" id="email">
                                            <div v-if="typeof errors['trainer.email'] !== 'undefined'" class="badge badge-danger">{{ errors['trainer.email'][0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_location">Course Locations</label>
                                            <!-- <input class="form-control" name="course_location" type="number" id="course_location"> -->
                                            <multiselect 
                                                v-model="trainer.course_location" 
                                                placeholder="Search location" 
                                                :custom-label = "locInfo"
                                                track-by="id" 
                                                :close-on-select="false"
                                                :options="course_location" 
                                                :multiple="true" 
                                                >
                                            </multiselect>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_taught">Course Taught</label>
                                            <multiselect 
                                                v-model="trainer.course_taught" 
                                                tag-placeholder="Add this as new tag" 
                                                placeholder="Search or add a tag" 
                                                label="name" 
                                                track-by="code" 
                                                :close-on-select="false"
                                                :options="course_list" 
                                                :multiple="true" 
                                                :taggable="true" 
                                                @tag="addTag">
                                            </multiselect>
                                            <!-- <pre>{{ course_taught_list }}</pre> -->
                                            <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_status">Receive email</label>
                                            <span style="font-size: 90%;opacity: 73%;">( Enrolment form )</span>
                                            <div class="custom-control custom-switch my-2">
                                                <input type="checkbox" class="custom-control-input" id="receive_email" v-model="trainer.receive_email">
                                                <label class="custom-control-label" for="receive_email"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                                <h6>Login Credentials <i>(Note: {{has_logins != false ? 'Username and Password is required to change logins' : 'Username and Password is required to create logins'}})</i></h6>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-padding-left-right">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input class="form-control" name="username" type="text" id="uname" v-model="user.username">
                                            <div v-if="typeof errors['user.username'] !== 'undefined'" class="badge badge-danger">{{ errors['user.username'][0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input class="form-control" name="password" type="password" id="password" :placeholder="has_logins != false ? 'Fill to change password' : 'Fill to create password'" v-model="user.make_password">
                                            <div v-if="typeof errors['user.make_password'] !== 'undefined'" class="badge badge-danger">{{ errors['user.make_password'][0] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_status">Active</label>
                                                <div class="custom-control custom-switch my-2">
                                                    <input type="checkbox" class="custom-control-input" id="user_status" v-model="user.is_active">
                                                    <label class="custom-control-label" for="user_status"></label> 
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="tab-pane fade show" id="nav-attachments" role="tabpanel" aria-labelledby="nav-attachments-tab"> -->
                        <!-- <div> -->
                            <!-- <trainer-attachment></trainer-attachment> -->
                        <!-- </div> -->
                    <!-- </div> -->
                    <!-- <div class="tab-pane fade show" id="nav-comsetting" role="tabpanel" aria-labelledby="nav-comsetting-tab">
                        <div>
                            <commission-settings-list></commission-settings-list>
                        </div>
                    </div> -->
                    
                </div>
            </div>
        </div>
        
        
    </div>
</template>
<script>

import TrainerAttachment from "./trainerAttachmentComponent.vue";
import CreateCommission from './commissionSetting/createComSettingComponent.vue';
import CommissionDetail from './commissionSetting/commissionSettingDetailComponent.vue';
import CommissionList from './commissionSetting/commissionSettingsListComponent.vue';

export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        components: {
            TrainerAttachment,
            CreateCommission,
            CommissionDetail,
            CommissionList,
        },
        data() {
            return {
                app_color: app_color,
                trainerList : [],
                has_logins: false,
                user: {},
                course_list : [],
                course_taught_list : [],
                course_location: [],
                slct_course_location : '',
                trainer : {
                    id: "",
                    firstname: "",
                    lastname: "",
                    phone_number: "",
                    email : "",
                    course_taught: "",
                    course_location: ""
                },
                trainer_id : window.trainer_id,
                csrfToken: '',
                errors: {},
            };
        },
        created(){
            // this.fetchTrainers();
            this.trainer = window.trainer;
            this.trainer.course_location = window.trainer.course_location!=''?JSON.parse(window.trainer.course_location):'';
            this.course_location = window.course_location;
            // this.trainer.course_taught = window.trainer.course_taught != null ? window.trainer.course_taught.split(',') : [];
            this.course_list = window.course_list;
            this.errors['make_password'] = '';
            this.user = typeof window.hasLogins.id !== 'undefined' ? window.hasLogins : {};
            this.has_logins = typeof window.hasLogins.id !== 'undefined' ?  window.hasLogins.id : false;
        },
        methods: {
            locInfo({postcode,suburb,state}){
                return `${postcode} - ${suburb} - ${state}`;
            },
            fetchTrainers(){
                axios({
                    method: 'get',
                    url: '/trainer/show/'+trainer_id
                })
                .then(res => {
                    // console.log(this.course)
                    this.course_list = res.data.course_list || '';
                    this.course_taught_list = res.data.trainer.course_taught || '';
                    this.course_location = res.data.course_location || '';
                    this.slct_course_location = res.data.trainer.course_location || '';
                    this.trainer.id = res.data.trainer.id || '';
                    this.trainer.firstname = res.data.trainer.firstname || '';
                    this.trainer.lastname = res.data.trainer.lastname || '';
                    this.trainer.middlename = res.data.trainer.middlename || '';
                    this.trainer.phone_number = res.data.trainer.phone_number || '';
                    this.trainer.email = res.data.trainer.email || '';
                    if(res.data.trainer.course_taught !== null){
                        this.course_taught_list = res.data.course_taught_list || '';
                    }
                })
                .catch(err => console.log(err));
            },
            checkLogins() {
                let username = null
                let password = null;
                let error = [];
                let vm = this;
                let isRequired = ['firstname', 'lastname', 'email', 'phone_number'];

                const capitalize = (s) => {
                if (typeof s !== 'string') return ''
                    let str = s.charAt(0).toUpperCase() + s.slice(1)
                    return str.replace('_', ' ')
                }
                
                if(typeof vm.user.username !== 'undefined' && ['',null].indexOf(vm.user.username) == -1){
                    username = vm.user.username;
                }

                if(typeof vm.user.make_password !== 'undefined' && ['',null].indexOf(vm.user.make_password) == -1){
                    password = vm.user.make_password;
                }

                if(username != null && password == null && vm.has_logins == false){
                    // vm.errors['user.make_password'] = ['Password is required.'];
                    error['user.make_password'] = ['Password is required.'];
                }
                
                if(username == null && password != null){
                    error['user.username'] = ['Username is required.'];
                }
                
                isRequired.forEach(el => {
                    if([null, ''].indexOf(vm.trainer[el]) != -1){
                        error['trainer.'+el] = [capitalize(el)+' is required.'];
                    }else{
                        delete error['trainer.'+el];
                    }
                });


                // console.log(vm.errors)
                if(username != null && password != null){
                    delete error['user.make_password'];
                    delete error['user.username'];
                }

                if(username == null && password == null && vm.has_login == false){
                    delete error['user.make_password'];
                    delete error['user.username'];
                }

                this.errors = error;

                if(error.length > 0){
                    return false;
                }
                
                if(vm.has_logins == false && typeof username != null && password != null){
                    
                    delete error['user.make_password'];
                    delete error['user.username'];

                    swal.fire({
                        title: 'Are you sure to create logins?',
                        // text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, create logins!'
                    }).then((result) => {
                        if (result.value) {
                            vm.saveChanges();
                        }
                    })
                }else if(vm.has_logins != false && typeof username != null && password != null){
                    swal.fire({
                        title: 'Are you sure to change password?',
                        // text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change password!'
                    }).then((result) => {
                        if (result.value) {
                            vm.saveChanges();
                        }
                    })
                }else if(vm.has_logins != false && typeof username != null && password == null){
                    vm.saveChanges();
                }else if (vm.has_logins == false && typeof username == null && password == null){
                    vm.saveChanges();
                }

                
            },
            saveChanges(){
                // console.log('yo');
                let vm = this;
                

                swal.fire({
                    title: 'Saving changes..',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });

                axios.post('/trainer/show/update/'+trainer_id,{
                    id: this.trainer.id,
                    trainer: this.trainer,
                    user: this.user,
                    _token: this.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'updated'){
                        swal.fire(
                            'Success',
                            'Trainer updated successfully',
                            'success'
                        )
                        vm.trainer = res.data.data;
                        vm.user = res.data.data.has_login;
                        vm.has_logins = res.data.data.hasLogins;
                    }else{
                        swal.fire(
                            'Oppss..',
                            res.data.message,
                            'error'
                        )
                    }
                })
                .catch(err => {
                    swal.fire(
                        'Oppss..',
                        'Something is wrong.',
                        'error'
                    )
                    console.log(err)
                });
            },
            addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.course_list.push(tag)
            this.course_taught_list.push(tag)
            // this.options.push(tag)
            // this.value.push(tag)
            }
        }
}
</script>
<style>
    .tab-pane {
        border: 1px solid #e0dfdf;
        border-top: none;
        padding: 1.3rem;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        background-color: #ffffff;
    }
</style>