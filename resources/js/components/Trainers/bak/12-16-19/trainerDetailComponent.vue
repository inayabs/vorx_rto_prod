<template>
    <div>
        <h3>Trainer Details</h3>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Info</a>
                <a class="nav-item nav-link" id="nav-comsetting-tab" data-toggle="tab" href="#nav-comsetting" role="tab" aria-controls="nav-comsetting" aria-selected="true">Commission Settings</a>
                <a class="nav-item nav-link" id="nav-attachments-tab" data-toggle="tab" href="#nav-attachments" role="tab" aria-controls="nav-attachments" aria-selected="true">Attachments</a>
                
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                <div>
                    <div class="row mb-3">
                        <div class="col-md-12 pull-right text-right">
                            <button class="btn btn-success" @click="saveChanges"><i class="far fa-save"></i> Save Changes</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="horizontal-line-wrapper mb-2">
                        <h6>Course Information</h6>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-padding-left-right">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">Firstname</label>
                                    <input class="form-control" name="firstname" type="text" v-model="trainer.firstname" id="firstname">
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
                                    <label for="lastname">Lastname</label>
                                    <input class="form-control" name="lastname" type="text" v-model="trainer.lastname" id="lastname">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input class="form-control" name="phone_number" type="number" v-model="trainer.phone_number" id="phone_number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" name="email" type="email" v-model="trainer.email" id="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_location">Course Location</label>
                                    <!-- <input class="form-control" name="course_location" type="number" id="course_location"> -->
                                    <select name="course_location" class="form-control" v-model="slct_course_location">
                                        <option v-for="value in course_location" v-bind:value="value.state_key" v-bind:key="value.state_key">
                                            {{ value.state_name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="course_taught">Course Thought</label>
                                    <multiselect 
                                        v-model="course_taught_list" 
                                        tag-placeholder="Add this as new tag" 
                                        placeholder="Search or add a tag" 
                                        label="name" 
                                        track-by="code" 
                                        :options="course_list" 
                                        :multiple="true" 
                                        :taggable="true" 
                                        @tag="addTag">
                                    </multiselect>
                                    <!-- <pre>{{ course_taught_list }}</pre> -->
                                    <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="nav-attachments" role="tabpanel" aria-labelledby="nav-attachments-tab">
                <div>
                    <trainer-attachment></trainer-attachment>
                </div>
            </div>
            <div class="tab-pane fade show" id="nav-comsetting" role="tabpanel" aria-labelledby="nav-comsetting-tab">
                <div>
                    <commission-settings-list></commission-settings-list>
                </div>
            </div>
              
        </div>
    </div>
</template>
<script>

import TrainerAttachment from "./trainerAttachmentComponent.vue";
import CreateComSetting from './commissionSetting/createComSettingComponent.vue';
import CommissionList from './commissionSetting/commissionSettingsListComponent.vue';

export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        components: {
            TrainerAttachment,
        },
        data() {
            return {
                trainerList : [],
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
            };
        },
        created(){
            this.fetchTrainers();
        },
        methods: {
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
            saveChanges(){
                // console.log('yo');
                axios.post('/trainer/show/update/'+trainer_id,{
                    id: this.trainer.id,
                    firstname: this.trainer.firstname,
                    middlename: this.trainer.middlename,
                    lastname: this.trainer.lastname,
                    phone_number: this.trainer.phone_number,
                    email: this.trainer.email,
                    course_taught: this.course_taught_list,
                    course_location: this.slct_course_location,
                    _token: this.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'updated'){
                        Toast.fire({
                            type: 'success', title: 'Data is updated successfully',
                        });
                    }else{
                        Toast.fire({
                            type: 'error', title: 'Oops... something went wrong',
                        });
                    }
                })
                .catch(err => console.log(err));
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