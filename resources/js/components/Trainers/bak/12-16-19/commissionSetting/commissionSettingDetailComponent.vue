<template lang="">
    <div>
        <h3>Commission Setting Details</h3>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Info</a>
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
                        <h6>Settings</h6>
                    </div>
                    <div class="form-padding-left-right">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="course_codes">Course Codes</label>
                                    <multiselect 
                                        v-model="comset.course_codes" 
                                        tag-placeholder="" 
                                        placeholder="Select Course" 
                                        label="name" 
                                        track-by="code" 
                                        :options="slct_course_codes" 
                                        :multiple="true" 
                                        :taggable="true" 
                                        @tag="addTag">
                                    </multiselect>
                                    <span v-if="errors.course_codes" :class="['badge badge-danger']">{{ errors.course_codes[0] }}</span>
                                    <!-- <pre>{{ trainer_collab_list }}</pre> -->
                                    <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.student_quota ? 'has-error' : '']" >
                                    <label for="student_quota">Student Quota</label>
                                    <input 
                                        id="student_quota" 
                                        name="student_quota" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="number" 
                                        v-model="comset.student_quota">
                                    <span v-if="errors.student_quota" :class="['badge badge-danger']">{{ errors.student_quota[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.commission_type_id ? 'has-error' : '']" >
                                    <label for="commission_type_id">Commission Mode</label>
                                        <multiselect 
                                        v-model="comset.commission_type_id" 
                                        tag-placeholder="" 
                                        placeholder="Select Mode Symbol" 
                                        label="type" 
                                        track-by="type" 
                                        :options="slct_com_type" 
                                        :multiple="false" 
                                        :taggable="true" 
                                        @tag="addTag">
                                        </multiselect>
                                        <span v-if="errors.commission_type_id" :class="['badge badge-danger']">{{ errors.commission_type_id[0] }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div :class="['form-group', errors.commission_value ? 'has-error' : '']" >
                                    <label for="commission_value">Commision Value</label>
                                    <input 
                                        id="commission_value" 
                                        name="commission_value" 
                                        value=""  
                                        autofocus="autofocus" 
                                        class="form-control" 
                                        type="number" 
                                        v-model="comset.commission_value">
                                    <span v-if="errors.commission_value" :class="['badge badge-danger']">{{ errors.commission_value[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="trainer_collab">Trainer Collab</label>
                                    <multiselect 
                                        v-model="comset.trainer_collab" 
                                        tag-placeholder="" 
                                        placeholder="Select Trainer" 
                                        label="name" 
                                        track-by="trainer_id" 
                                        :options="slct_trainer_collab" 
                                        :multiple="true" 
                                        :taggable="true" 
                                        @tag="addTag">
                                    </multiselect>
                                    <span v-if="errors.trainer_collab" :class="['badge badge-danger']">{{ errors.trainer_collab[0] }}</span>
                                    <!-- <pre>{{ trainer_collab_list }}</pre> -->
                                    <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
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
export default {
  data() {
    return {
        trainer_id : window.trainer_id,
        comset_id : window.comset_id,
        slct_course_codes: [],
        slct_com_type : [],
        slct_trainer_collab : [],
        comset: {
            id : '',
            course_codes : [],
            student_quota : '',
            trainer_collab : [],
            commission_type_id : [],
            commission_value : '',
        },
        csrf: '',
        errors: [],
        success : false  
    };
  },
  created(){
        this.fetchComSetting();
    },
  methods: {
    fetchComSetting(){
                axios({
                    method: 'get',
                    url: `/comsetting/info/${this.trainer_id}/trainer/${this.comset_id}`
                })
                .then(res => {
                    this.slct_course_codes = res.data.slct_course_codes || '';
                    this.comset.course_codes = res.data.comset_info.course_codes || '';
                    this.slct_com_type = res.data.slct_com_type || '';
                    this.comset.commission_type_id = res.data.comset_info.commission_type_id || '';
                    this.slct_trainer_collab = res.data.slct_trainer_collab || '';
                    this.comset.trainer_collab = res.data.comset_info.trainer_collab || '';
                    this.comset.id = res.data.comset_info.id || '';
                    this.comset.student_quota = res.data.comset_info.student_quota || '';
                    this.comset.commission_value = res.data.comset_info.commission_value || '';
                    if(res.data.comset_info.course_codes !== null){
                        this.comset.course_codes = res.data.course_codes || '';
                    }
                    if(res.data.comset_info.commission_type_id !== null){
                        this.comset.commission_type_id = res.data.commission_type_id || '';
                    }
                    if(res.data.comset_info.trainer_collab !== null){
                        this.comset.trainer_collab = res.data.trainer_collab || '';
                    }
                })
                .catch(err => console.log(err));
            },
            saveChanges(){
                // console.log('yo');
                axios.post(`/trainer-management/commission-settings/${this.trainer_id}/trainer/${comset_id}/update`,{
                    id: this.comset.id,
                    course_codes: this.comset.course_codes,
                    student_quota: this.comset.student_quota,
                    trainer_collab : this.comset.trainer_collab,
                    commission_type_id : this.comset.commission_type_id,
                    commission_value : this.comset.commission_value,
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
        this.comset.course_codes.push(tag)
        this.slct_course_codes.push(tag)
        this.comset.trainer_collab.push(tag)
        this.slct_trainer_collab.push(tag)
        this.comset.commission_type_id.push(tag)
        this.slct_com_type.push(tag)
        // this.options.push(tag)
        // this.value.push(tag)
        }
    }
}
</script>