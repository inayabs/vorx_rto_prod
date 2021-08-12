<template>
    <div>
        <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
                <button class="btn btn-success" :disabled="roles == 'Staff'? true : false "  @click="saveChanges()" v-if="has_logins == false"><i class="far fa-save"></i> Create Login</button>
                <button class="btn btn-success" :disabled="roles == 'Staff'? true : false "  @click="saveChanges()" v-else><i class="far fa-save"></i> Update Login</button>
            </div>
        </div>
        <form autocomplete="nope">
        <div class="clearfix"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
            <h6>Login Credentials <i>(Note: Setting status to active indicates logins to be usable by student)</i></h6>
        </div>
        <div class="clearfix"></div>
        <div class="form-padding-left-right">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input readonly class="form-control" type="text" id="uname" v-model="user.username">
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
                            <label for="user_status">Status</label>
                            <div class="custom-control custom-switch my-2">
                                <input type="checkbox" class="custom-control-input" id="user_status" v-model="user.is_active">
                                <label class="custom-control-label" for="user_status"></label> 
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </form>
    </div>
</template>
<script>

export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
            if(this.$root.$refs.studentbase != undefined){
            this.roles = this.$root.$refs.studentbase.urole;
            }
        },
        components: {
        },
        data() {
            return {
                app_color: app_color,
                has_logins: false,
                student_id: window.student_id,
                party: {},
                user:{},
                csrfToken: '',
                errors: {},
                roles : "",
            };
        },
        created(){
            this.fetchLogins();
            // this.trainer = window.trainer;
            // this.course_location = window.course_location;
            // // this.trainer.course_taught = window.trainer.course_taught != null ? window.trainer.course_taught.split(',') : [];
            // this.course_list = window.course_list;
            // this.errors['make_password'] = '';
            // this.user = typeof window.hasLogins.id !== 'undefined' ? window.hasLogins : {};
            // this.has_logins = typeof window.hasLogins.id !== 'undefined' ?  window.hasLogins.id : false;
        },

        methods: {
            fetchLogins(){
                let vm = this;
                axios({
                    method: 'get',
                    url: '/student/fetch-logins/'+vm.student_id
                })
                .then(res => {
                    // console.log(res.data.party)
                    vm.has_logins = res.data.party.user == null ? false : true
                    vm.user = res.data.party.user == null ? {username:vm.student_id} : res.data.party.user
                })
                .catch(err => console.log(err));
            },
            checkLogins() {

            },
            saveChanges(){
                // console.log('yo');
                let vm = this;
                
                let msg = vm.has_logins == false  ? 'created' : 'updated';
                swal.fire({
                    title: vm.has_logins == false ? 'Saving changes..' : 'Updating changes..',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });

                if(vm.has_logins == false){
                    if(typeof vm.user.make_password !== 'undefined' && ['', null].indexOf(vm.user.make_password) != -1 || typeof vm.user.make_password === 'undefined'){
                        swal.fire(
                            'Oppss..',
                            'Password is required',
                            'error'
                        )
                        return false
                    }
                }

                axios.post('/student/store-logins',{
                    student_id: vm.student_id,
                    user: vm.user,
                    _token: this.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'success'){
                        swal.fire(
                            'Success',
                            'Student Login '+ msg +' successfully',
                            'success'
                        )
                        // vm.trainer = res.data.data;
                        vm.user = res.data.user;
                        vm.has_logins = res.data.user != null ? true: false;
                        
                    }else{
                        swal.fire(
                            'Oppss..',
                            'There seems to be a problem',
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