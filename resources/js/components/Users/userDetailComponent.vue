<template>
<div class="app-modal">
    <user-profile/>
    <div>
        <div class="row mb-2 d-flex justify-content-between">
            <div class="col-md-6">
                <a href="/users" v-bind:class="'btn btn-'+app_color+' btn-sm text-primary text-light'"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">User Details</h6>
            </div>
            <div class="card-body">
                <div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a v-bind:class="'nav-item nav-link-'+app_color+' active'" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Info</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                            <div>
                                <div class="row mb-3">
                                    <div class="col-md-12 pull-right text-right">
                                        <button class="btn btn-success" @click="saveChanges()"><i class="far fa-save"></i> Save Changes</button>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                                    <h6>Login Details</h6>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-padding-left-right">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input class="form-control" name="username" type="text" id="uname" v-model="user.username">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input class="form-control" name="password" type="password" id="password" placeholder="********" v-model="user.password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                                    <h6>Personal Information</h6>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-padding-left-right">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="firstname">Firstname</label>
                                                <input class="form-control" name="firstname" type="text" id="fname" v-model="user.firstname">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastname">Lastname</label>
                                                <input class="form-control" name="lastname" type="text" id="lname" v-model="user.lastname">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                                    <h6>Configuration</h6>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-padding-left-right">
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="department_id">Department Type</label>
                                                <select name="department_id" class="form-control" v-model="slct_department">
                                                    <option v-for="value in department" v-bind:value="value.id" v-bind:key="value.id">
                                                        {{ value.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role_id">User Role</label>
                                                <select name="role_id" class="form-control" v-model="user.user_role">
                                                <option value="Staff">Staff</option>
                                                <!-- <option value="Trainer">Trainer</option> -->
                                                <option value="Demo">Demo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_status">Status</label>
                                                <div class="custom-control custom-switch my-2">
                                                    <input type="checkbox" class="custom-control-input" id="user_status" v-model="user.is_active">
                                                    <label class="custom-control-label" for="user_status"></label> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                                    <h6>Email Details</h6>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-padding-left-right">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email_address">Email Address</label>
                                                <input class="form-control" name="name" type="text" id="email_address" v-model="user.email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email_password">Email Password</label>
                                                <input class="form-control" name="password" type="password" id="email_password" placeholder="********" v-model="user.email_password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                                    <h6>Profile Image</h6>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-padding-left-right">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a @click="editProfile" class="profile-wrapper">
                                                <img :src="avtr_path" alt="profile">
                                                <div class="edit-profile">
                                                    <a class="btn btn-link btn-sm float-right"><i class="fas fa-edit"></i></a>
                                                </div>
                                            </a>
                                            <div class="clearfix" style="height:30px"></div>
                                            <!-- <user-profile></user-profile> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import UserProfile from './userProfileComponent.vue';
    import CropUpload from './CropUploadComponent.vue';
    
    export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        components: {
            UserProfile,
            CropUpload
        },
        data() {
            return {
                userList : [],
                avtr_path : '',
                department : [],
                slct_department : '',
                role : [],
                user : {
                    id: "",
                    username: "",
                    password: "",
                    department_type: "",
                    role: "",
                    is_active: "",
                    email: "",
                    email_password : "",
                     user_role : '',
                },
                person : {
                    firstname : "",
                    lastname : ""
                },
                user_id : window.user_id,
                csrfToken: '',
                app_color: app_color,
            };
        },
        created(){
            this.fetchUser();
        },
        methods: {
            fetchUser(){
                axios({
                    method: 'get',
                    url: '/user/show/'+user_id
                })
                .then(res => {
                    // console.log(res.data.user_role);
                    this.avtr_path = res.data.avtr_path || '';
                    this.department = res.data.department || '';
                    this.slct_department = res.data.user.department_type || '';
                    this.role = res.data.role || '';
                    this.slct_role = res.data.user.role_id || '';
                    this.user.id = res.data.user.id || '';
                    this.user.username = res.data.user.username || '';
                    this.user.password = res.data.user.password || '';
                    this.user.firstname = res.data.user.party.person.firstname || '';
                    this.user.lastname = res.data.user.party.person.lastname || '';
                    this.user.is_active = res.data.user.is_active || '';
                    this.user.email = res.data.user.email || '';
                    this.user.email_password = res.data.user.email_password || '';
                    this.user.user_role = res.data.user_role || '';
                })
                .catch(err => console.log(err));
            },
            saveChanges(){
                // console.log('yo');
                axios.post('/user/show/update/'+user_id,{
                    id: this.user.id,
                    username: this.user.username,
                    password: this.user.password,
                    firstname: this.user.firstname,
                    lastname: this.user.lastname,
                    is_active: this.user.is_active,
                    email: this.user.email,
                    email_password: this.user.email_password,
                    slct_department: this.slct_department,
                    role: this.user.user_role,
                    slct_role: this.slct_role,
                    _token: this.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'updated'){
                        Toast.fire({
                            type: 'success', title: 'Changes is saved successfully',
                        });
                    }else{
                        Toast.fire({
                            type: 'error', title: 'Oops... something went wrong',
                        });
                    }
                })
                .catch(err => console.log(err));
            },
            editProfile () {
                this.$modal.show('size-modal',{
                    avtr_path : '',
                });
            }
        }
    }
</script>

<style>
.tab-pane {border: 1px solid #e0dfdf;border-top: none;padding: 1.3rem;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;background-color: #ffffff;}
.profile-wrapper{display:inline-block;position: relative;}
.profile-wrapper:hover .edit-profile {visibility: visible;opacity: 1;}
.profile-wrapper img{border-radius: 5px;border: solid #ccc 3px;width: 200px;}
.profile-wrapper .edit-profile{width:100%; height: 100%; background-color:#0000002b; position: absolute;top: 0;right: 0;color: #fff !important;opacity: 0;visibility: hidden; -webkit-transition: opacity 600ms, visibility 600ms;transition: opacity 600ms, visibility 600ms;}
</style>