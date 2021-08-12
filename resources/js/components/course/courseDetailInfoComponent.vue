<template>
    <div>
        <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
                <button class="btn btn-success" @click="saveChanges()" ><i class="far fa-save"></i> Save Changes</button>
            </div>
        </div>
        <div class="clearfix"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
            <h6>Course Information</h6>
        </div>
        <div class="clearfix"></div>
        <div class="form-padding-left-right">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Course Name</label>
                        <input class="form-control" name="name" type="text" v-model="course.name" id="name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="code">Course Code</label>
                        <input class="form-control" name="code" type="text" v-model="course.code" id="code">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="target_enrolee">Target Enrolee</label>
                        <input class="form-control" name="target_enrolee" type="number" v-model="course.target_enrolee" id="target_enrolee">
                    </div>
                </div>
            </div>
            <div class="clearfix w-100"></div>
            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>Avetmiss</h6>
            </div>
            <div class="clearfix"></div>
            <div class="form-padding-left-right">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prg_lvl_of_educ_identifier_id">Nominal Hours</label>
                            <input class="form-control" name="nominal_hours" type="number" v-model="course.course_avt_detail.nominal_hours" id="target_enrolee">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prg_recog_identifier_id">Program Recognition Identifier</label>
                            <select name="prg_recog_identifier_id" class="form-control" v-model="slct_prgRecog">
                                <option v-for="value in prgRecog" v-bind:value="value.id" v-bind:key="value.id">
                                    {{ value.description }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prg_lvl_of_educ_identifier_id">Program Education Level Identifier</label>
                            <select name="prg_lvl_of_educ_identifier_id" class="form-control" v-model="slct_prgLvl">
                                <option v-for="value in prgLvl" v-bind:value="value.id" v-bind:key="value.id">
                                    {{ value.description }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="qlf_field_of_educ_identifier_id">Program Education Field Identifier</label>
                            <select name="qlf_field_of_educ_identifier_id" class="form-control" v-model="slct_qlf">
                                <option v-for="value in qlf" v-bind:value="value.id" v-bind:key="value.id">
                                    {{ value.description }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="anzsco_identifier_id">Anzsco Identifier</label>
                            <select name="anzsco_identifier_id" class="form-control" v-model="slct_anzsco">
                                <option v-for="value in anzsco" v-bind:value="value.id" v-bind:key="value.id">
                                    {{ value.description }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vet_flag_status">VET Flag Status</label>
                            <div class="custom-control custom-switch my-2">
                                <input type="checkbox" class="custom-control-input" id="vet_flag_status" v-model="course.course_avt_detail.vet_flag_status">
                                <label class="custom-control-label" for="vet_flag_status"></label> 
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
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                courseList : [],
                anzsco : [],
                slct_anzsco : '',
                prgLvl : [],
                slct_prgLvl : '',
                prgRecog : [],
                slct_prgRecog : '',
                qlf : [],
                slct_qlf : '',
                course : {
                    id : '',
                    code: '',
                    name: '',
                    target_enrolee: '',
                    course_avt_detail: {
                        nominal_hours: '',
                        vet_flag_status : '',
                    }
                },
                course_code : window.course_code,
                csrfToken: '',
                app_color: app_color,
            };
        },
        created() {
            this.fetchData();
            // console.log(this);
        },
        methods: {
            fetchData() {
                // console.log(course_id);
                axios({
                    method: 'get',
                    url: '/course/show/info/'+this.course_code
                })
                .then(res => {

                    this.anzsco = res.data.anzsco || '';
                    this.qlf = res.data.Qlf || '';
                    this.prgLvl = res.data.prgLvl || '';
                    this.prgRecog = res.data.prgRecog || '';
                    this.course.id = res.data.course.id || '';
                    this.course.name = res.data.course.name || '';
                    this.course.code = res.data.course.code || '';
                    this.course.target_enrolee = res.data.course.target_enrolee || 0;
                    if(res.data.course.course_avt_detail !== null){
                        this.course.course_avt_detail.nominal_hours = res.data.course.course_avt_detail.nominal_hours || '';
                        this.course.course_avt_detail.vet_flag_status = res.data.course.course_avt_detail.vet_flag_status || '';
                        this.slct_qlf = res.data.course.course_avt_detail.qlf_field_of_educ_identifier_id || '';
                        this.slct_anzsco = res.data.course.course_avt_detail.anzsco_identifier_id || '';
                        this.slct_prgLvl = res.data.course.course_avt_detail.prg_lvl_of_educ_identifier_id || '';
                        this.slct_prgRecog = res.data.course.course_avt_detail.prg_recog_identifier_id || '';
                    }
                })
                .catch(err => console.log(err));
            },
            saveChanges() {
                // alert('test');

                // alert(this.csrfToken);

                axios.post('/course/show/info/update/'+course_id,{
                    id: this.course.id,
                    name: this.course.name,
                    code: this.course.code,
                    target_enrolee: this.course.target_enrolee,
                    nominal_hours: this.course.course_avt_detail.nominal_hours,
                    vet_flag_status: this.course.course_avt_detail.vet_flag_status,
                    slct_qlf: this.slct_qlf,
                    slct_anzsco: this.slct_anzsco,
                    slct_prgLvl: this.slct_prgLvl,
                    slct_prgRecog: this.slct_prgRecog,
                    _token: this.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'updated'){
                        Toast.fire({
                            // position: 'top-end',
                            type: 'success', title: 'Changes saved successfully',
                        })
                    }else{
                        Toast.fire({
                            // position: 'top-end',
                            type: 'error', title: 'Opss.. data was not saved',
                        })
                    }
                })
                .catch(err => console.log(err));
            },
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