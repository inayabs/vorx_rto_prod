<template lang="">
    <div>
        <h3>Create Setting</h3>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane d-block">
                <form @submit.prevent="saveComSetting">
                    <div class="row mb-2 d-flex justify-content-between">
                        <div class="col-md-6">
                            <a href="/unit" class="btn btn-primary text-primary text-light"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success d-block ml-auto"><i class="far fa-save"></i> Save Setting</button>
                        </div>
                    </div>

                    <div class="horizontal-line-wrapper mb-2">
                        <h6>Add Commission Setting</h6>
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
                                        :options="slct_courses" 
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
                                        :options="slct_comtype" 
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
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  data() {
    return {
        trainer_id : window.trainer_id,
        slct_courses : window.slct_courses,
        slct_trainer_collab : window.slct_trainer_collab,
        slct_comtype : window.slct_comtype,
        comset: {
            course_codes : '',
            student_quota : '',
            trainer_collab : '',
            commission_type_id : '',
            commission_value : '',
        },
        csrf: '',
        errors: [],
        success : false  
    };
  },
  methods: {
    saveComSetting() {
      axios.post(`/trainer-management/commission-settings/${this.trainer_id}`, this.comset)
        .then(response => {
          if (response.data.status == "errors") {
            this.errors = response.data.errors;
          } else {
            //   consol.log('success');
            this.errors = [];
            this.comset.course_codes = '';
            this.comset.student_quota = '';
            this.comset.trainer_collab = '';
            this.comset.commission_type_id = '';
            this.comset.commission_value = '';
            this.success = true;
            Toast.fire({
                type: 'success', title: 'Data is saved successfully',
            });
          }
        })
        .catch(error => {
          Toast.fire({
            type: "error",
            title: "Fail to add student"
          });
          console.log(error);
        });
    },
    addTag (newTag) {
        const tag = {
            name: newTag,
            code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
        }
        this.comset.courses.push(tag)
        this.slct_courses.push(tag)
        this.comset.trainer_collab.push(tag)
        this.slct_trainer_collab.push(tag)
        this.comset.commission_type_id.push(tag)
        this.slct_comtype.push(tag)
        // this.options.push(tag)
        // this.value.push(tag)
        }
    }
}
</script>