<template>
<div>
    <user-profile />
    <div class="row mb-3">
        <div class="col-md-12 pull-right text-right">
            <button class="btn btn-success" @click="saveChanges()">
                <i class="far fa-save"></i> Save Changes
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-padding-left-right">
                <div class="row">
                    <div class="col-md-12">
                        <a @click="editProfile" class="profile-wrapper">
                            <img :src="avtr_path" alt="profile">
                            <div class="edit-profile">
                                <a class="btn btn-link btn-sm float-right"><i class="fas fa-edit"></i></a>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="clearfix"></div>
            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>Login Credentials </h6>
            </div>
            <div class="clearfix"></div>
            <div class="form-padding-left-right">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input readonly class="form-control" name="username" type="text" id="uname" v-model="user.username">
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
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_status">Status</label>
                            <div class="custom-control custom-switch my-2">
                                <input type="checkbox" class="custom-control-input" id="user_status" v-model="user.is_active">
                                <label class="custom-control-label" for="user_status"></label> 
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix" style="height:20px"></div>
    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
        <h6>Personal Information</h6>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="prefix">Prefix</label>
                    <select id="studentPrefix" v-model="student.prefix" class="form-control">
                        <option value="Mr.">Mr.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Mrs.">Mrs.</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" v-model="student.firstname" id="firstname" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="middlename">Middle Name</label>
                    <input type="text" class="form-control" v-model="student.middlename" id="middlename" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" v-model="student.lastname" id="lastname" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" v-model="student.gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date_of_birth">
                        Date of birth
                        <span style="font-size: 74%;opacity: 73%;">( MM/DD/YYYY )</span>
                    </label>
                    <date-picker locale="en" v-model="student.date_of_birth" :masks="{L:'DD/MM/YYYY'}" :max-date="new Date()"></date-picker>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import UserProfile from './../../globals/avatar-profile/userProfileComponent.vue';
import CropUpload from './../../globals/avatar-profile/CropUploadComponent.vue';
import moment from "moment";
export default {
    components: {
        UserProfile,
        CropUpload
    },
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
    data() {
        return {
            date: '',
            app_color: app_color,
            has_logins: false,
            student_id: window.student_id,
            student: window.student_info,
            user: {},
            avtr_path: window.avtr_path,
            csrfToken: '',
            errors: {},
        };
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            let vm = this;
            if (this.student != null) {
                if (this.student.date_of_birth != null) {
                    this.student.date_of_birth = moment(this.student.date_of_birth)._d;
                } else {
                    this.student.date_of_birth = null;
                }
            }

            axios({
                    method: 'get',
                    url: '/student/fetch-logins/' + vm.student_id
                })
                .then(res => {
                    // console.log(res.data.party)
                    vm.has_logins = res.data.party.user == null ? false : true
                    vm.user = res.data.party.user == null ? {
                        username: vm.student_id
                    } : res.data.party.user
                })
                .catch(err => console.log(err));
        },
        saveChanges() {
            const Toast = swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
            swal.fire({
                title: "Please wait...",
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading();
                },
            });
            this.student.date_of_birth = moment(this.student.date_of_birth).format("YYYY-MM-DD");
            let data = {
                inputs: this.student,
                user: this.user
            }
            axios
                .post(`/student-profile/${window.student_id}/info-update`, data)
                .then((res) => {
                    // console.log(res);
                    if (res.data.status == "updated") {
                        // console.log("success");
                        this.student.date_of_birth = moment(this.student.date_of_birth)._d;
                        swal.fire({
                            title: "Updated Successfuly",
                            type: "success",
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    } else {
                        // console.log("error");
                        this.student.date_of_birth = moment(this.student.date_of_birth)._d;
                        swal.fire({
                            title: "Opss.. was not saved successfully",
                            type: "error",
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        editProfile() {
            this.$modal.show('size-modal', {
                avtr_path: '',
            });
        }
    }

}
</script>

<style scoped>
.profile-wrapper img {
    width: 100% !important;
}

.tab-pane {
    border: 1px solid #e0dfdf;
    border-top: none;
    padding: 1.3rem;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    background-color: #ffffff;
}
</style>
