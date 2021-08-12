<template>
    <modal name="size-modal" transition="nice-modal-fade" classes="demo-modal-class" :min-width="200" :min-height="200" :pivot-y="0.1" :adaptive="true" :scrollable="true" :reset="true" width="60%" height="auto" @before-open="beforeOpen" @opened="opened" @closed="closed" @before-close="beforeClose">
        <div class="size-modal-content">
            <h4>Add Setting</h4>
            <hr>
            <form @submit.prevent="saveComSetting">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="course_codes">Course Codes</label>
                            <multiselect v-model="comset.course_codes" tag-placeholder="" placeholder="Select Course" label="name" track-by="code" :options="slct_courses" :multiple="true" :taggable="true" @tag="addTag">
                            </multiselect>
                            <span v-if="errors.course_codes" :class="['badge badge-danger']">{{ errors.course_codes[0] }}</span>
                            <!-- <pre>{{ trainer_collab_list }}</pre> -->
                            <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.commission_type_id ? 'has-error' : '']">
                            <label for="commission_type_id">Commission Mode</label>
                            <multiselect v-model="comset.commission_type_id" tag-placeholder="" placeholder="Select Mode Symbol" label="type" track-by="type" :options="slct_comtype" :multiple="false" :taggable="true" @tag="addTag">
                            </multiselect>
                            <span v-if="errors.commission_type_id" :class="['badge badge-danger']">{{ errors.commission_type_id[0] }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.student_quota ? 'has-error' : '']">
                            <label for="student_quota">Student Quota</label>
                            <input id="student_quota" name="student_quota" value="" autofocus="autofocus" class="form-control" type="number" v-model="comset.student_quota">
                            <span v-if="errors.student_quota" :class="['badge badge-danger']">{{ errors.student_quota[0] }}</span>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="trainer_collab">Trainer Collab</label>
                            <multiselect v-model="comset.trainer_collab" tag-placeholder="" placeholder="Select Trainer" label="name" track-by="trainer_id" :options="slct_trainer_collab" :multiple="true" :taggable="true" @tag="addTag">
                            </multiselect>
                            <span v-if="errors.trainer_collab" :class="['badge badge-danger']">{{ errors.trainer_collab[0] }}</span>
                            <!-- <pre>{{ trainer_collab_list }}</pre> -->
                            <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.commission_value ? 'has-error' : '']">
                            <label for="commission_value">Commision Value</label>
                            <input id="commission_value" name="commission_value" value="" autofocus="autofocus" class="form-control" type="number" v-model="comset.commission_value">
                            <span v-if="errors.commission_value" :class="['badge badge-danger']">{{ errors.commission_value[0] }}</span>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-success d-block ml-auto"><i class="far fa-save"></i> Save Setting</button>
            </form>
        </div>
    </modal>
</template>
<script>
    export default {
        name: 'SizeModalTest',
        props: ['id', 'course_codes', 'student_quota', 'commission_type_id', 'commission_value', 'trainer_collab'],
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                trainer_id: window.trainer_id,
                slct_courses: [],
                slct_trainer_collab: [],
                slct_comtype: [],
                comset: {
                    course_codes: '',
                    student_quota: '',
                    trainer_collab: '',
                    commission_type_id: '',
                    commission_value: '',
                },
                csrf: '',
                errors: [],
                success: false
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                    axios({
                            method: 'get',
                            url: '/trainer/commission-settings/create/' + trainer_id
                        })
                        .then(res => {
                            this.slct_courses = res.data.slct_courses;
                            this.slct_trainer_collab = res.data.slct_trainer_collab;
                            this.slct_comtype = res.data.slct_comtype;
                        })
                        .catch(err => console.log(err));
                },
                saveComSetting() {
                    axios.post('/trainer/commission-settings/store/' + trainer_id, this.comset)
                        .then(response => {
                            if (response.data.status == "errors") {
                                this.errors = response.data.errors;
                            } else {
                                this.errors = [];
                                this.comset.course_codes = '';
                                this.comset.student_quota = '';
                                this.comset.trainer_collab = '';
                                this.comset.commission_type_id = '';
                                this.comset.commission_value = '';
                                this.success = true;
                                Toast.fire({
                                    type: 'success',
                                    title: 'Data is saved successfully',
                                });
                                this.$parent.$children[4].fetchComSetting();
                                this.$modal.hide('size-modal');
                            }
                        })
                        .catch(error => {
                            Toast.fire({
                                type: "error",
                                title: "Fail to add commision setting"
                            });
                            console.log(error);
                        });
                },
                addTag(newTag) {
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
                },
                beforeOpen(e) {
                    // console.log(e.params);
                    // console.log(this.comset);
                    // console.log(this.$parent.$children[3].comsetList);
                    this.comset.id = e.params.id || null;
                    this.comset.course_codes = e.params.course_codes;
                    this.comset.student_quota = e.params.student_quota;
                    this.comset.trainer_collab = e.params.trainer_collab;
                    this.comset.commission_type_id = e.params.commission_type_id;
                    this.comset.commission_value = e.params.commission_value;
                    this.edit = e.params.edit || false;
                    this.trainer_id = e.params.trainer_id || null;
                    // this.fetchCourses();
                },
                beforeClose(e) {

                },
                opened(e) {
                    // e.ref should not be undefined here
                    // console.log('opened', e)
                    // console.log('ref', e.ref)
                },
                closed(e) {
                    console.log('closed', e)
                }
        }
    }
</script>