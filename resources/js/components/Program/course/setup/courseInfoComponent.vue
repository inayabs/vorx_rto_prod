<template>
    <div>
        <div class="row mb-3">
            <div class="col-md-6 pull-left text-left">
                <a class="btn btn-md" :class="'btn-danger'" href="/course" ><i class="fas fa-chevron-circle-left"></i> Course and Units</a>
                <!-- <a class="btn btn-md" :class="'btn-'+app_color" href="/course" ><i class="fas fa-chevron-circle-left"></i> Course and Units</a> -->
            </div>
            <div class="col-md-6 pull-right text-right">
                <!-- <button class="btn btn-md" :class="'btn-'+app_color" @click="checkCourse()" ><i class="fas fa-chevron-circle-right"></i> Units</button> -->
                <button class="btn btn-md" :class="'btn-info'" @click="checkCourse()" ><i class="fas fa-chevron-circle-right"></i> Units</button>
            </div>
        </div>
        <div class="clearfix"></div>
        <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
            <h6>Course Information</h6>
        </div>
        <div class="clearfix"></div>
        <div class="form-padding-left-right">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="code">Course <i>(Note: to add a new Course. place a dash "-" between the Course Code and Name)</i></label>
                        <!-- <input class="form-control" type="text" v-model="course.code" id="code" :class="[errors && errors.code ? 'border-danger' : '']"> -->
                        <multiselect
                            :class="'multiselect-color-'+app_color"
                            :options="opt"
                            :multiple="false"
                            :custom-label="courseWithCode"
                            :close-on-select="true"
                            :searchable="true"
                            :loading="isLoading"
                            :limit="3"
                            :limit-text="limitText"
                            :max-height="600"
                            :max-width="1000"
                            @tag="addTag"
                            :show-no-results="false"
                            :hide-selected="true"
                            :taggable="true"
                            @select="checkSelect"
                            @search-change="fetchCourseOption"
                            id="ajax"
                            v-model="course.course_obj"
                            placeholder="Add/Search Course"
                            tag-placeholder="Add this as new Course"
                            track-by="subject_code"
                            label="unit_title"
                        >
                          <span slot="noResult">Oops! No Unit found. Consider changing the search query.</span>
                        </multiselect>
                        <div v-if="errors && errors.course" class="badge badge-danger">{{ errors.course[0] }}</div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="course_name">Course Name</label>
                        <input class="form-control" type="text" v-model="course.name" id="course_name" :class="[errors && errors.name ? 'border-danger' : '']">
                        <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                    </div>
                </div> -->
                
                <!-- <div class="col-md-2">
                    <div class="form-group">
                        <label for="target_enrolee">Target Enrolee</label>
                        <input class="form-control" type="number" min="0" v-model="course.target_enrolee" id="target_enrolee">
                    </div>
                </div> -->
                <div class="col-md-1">
                    <div class="form-group">
                            <label for="is_active">Active</label>
                            <div class="custom-control custom-switch my-2">
                                <input type="checkbox" class="custom-control-input" id="is_active" v-model="course.is_active">
                                <label class="custom-control-label" for="is_active"></label> 
                            </div>
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
                            <input class="form-control" type="number" min="0" v-model="course.course_avt_detail.nominal_hours" id="target_enrolee" :class="[errors && errors.nominal_hours ? 'border-danger' : '']">
                            <div v-if="errors && errors.nominal_hours" class="badge badge-danger">{{ errors.nominal_hours[0] }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prg_recog_identifier_id">Program Recognition Identifier</label>
                            <!-- <select class="form-control" v-model="slct_prgRecog"> -->
                                <!-- <option v-for="value in prgRecog" v-bind:value="value.id" v-bind:key="value.id">
                                    {{ value.description }}
                                </option> -->
                            <!-- </select> -->

                                <multiselect 
                                    v-model="course.slct_prgRecog" 
                                    :options="prgRecog" 
                                    :multiple="false"  
                                    :class="'multiselect-color-'+app_color"
                                    placeholder="Type to search" 
                                    :close-on-select="true"  
                                    :track-by="'id'" 
                                    :label="'description'"
                                >
                                    <span slot="noResult">Oops! No data found. Consider changing the search query.</span>
                                </multiselect>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prg_lvl_of_educ_identifier_id">Program Education Level Identifier</label>
                            <!-- <select class="form-control" v-model="slct_prgLvl">
                                <option v-for="value in prgLvl" v-bind:value="value.id" v-bind:key="value.id">
                                    {{ value.description }}
                                </option>
                            </select> -->
                            <multiselect 
                                    v-model="course.slct_prgLvl" 
                                    :options="prgLvl" 
                                    :multiple="false"  
                                    :class="'multiselect-color-'+app_color"
                                    placeholder="Type to search" 
                                    :close-on-select="true"  
                                    :track-by="'id'" 
                                    :label="'description'"
                                >
                                    <span slot="noResult">Oops! No data found. Consider changing the search query.</span>
                                </multiselect>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="qlf_field_of_educ_identifier_id">Program Education Field Identifier</label>
                            <!-- <select class="form-control" v-model="slct_qlf">
                                <option v-for="value in qlf" v-bind:value="value.id" v-bind:key="value.id">
                                    {{ value.description }}
                                </option>
                            </select> -->
                            <multiselect 
                                v-model="course.slct_qlf" 
                                :options="qlf" 
                                :multiple="false"  
                                :class="'multiselect-color-'+app_color"
                                placeholder="Type to search" 
                                :close-on-select="true"  
                                :track-by="'id'" 
                                :label="'description'"
                            >
                                <span slot="noResult">Oops! No data found. Consider changing the search query.</span>
                            </multiselect>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="anzsco_identifier_id">Anzsco Identifier</label>
                            <!-- <select class="form-control" v-model="slct_anzsco">
                                <option v-for="value in anzsco" v-bind:value="value.id" v-bind:key="value.id">
                                    {{ value.description }}
                                </option>
                            </select> -->
                            <multiselect 
                                v-model="course.slct_anzsco" 
                                :options="anzsco" 
                                :multiple="false"  
                                :class="'multiselect-color-'+app_color"
                                placeholder="Type to search" 
                                :close-on-select="true"  
                                :track-by="'id'" 
                                :label="'description'"
                            >
                                <span slot="noResult">Oops! No data found. Consider changing the search query.</span>
                            </multiselect>
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

    const Toast = swal.mixin({
        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
    });

    export default {
        data() {
            return {
                courseList : [],
                errors : {},
                anzsco : window.anzsco,
                slct_anzsco : '',
                prgLvl : window.prgLvl,
                slct_prgLvl : '',
                prgRecog : window.prgRecog,
                slct_prgRecog : '',
                qlf : window.qlf,
                slct_qlf : '',
                course : {
                    course_avt_detail: {}
                },

                opt: [],
                isLoading : false,
                course_code : window.course_code,
                errors: {},
                app_color: app_color,
            };
        },
        created() {
            // this.fetchData();
            // console.log(this);
            // console.log(this.anzsco);
            // console.log(this.$parent.$store);
        },
        watch: {
            course: function (value) {
                console.log(value);
                if (value.code != null) {
                    this.errors.code = "";
                }
                if (value.name != null) {
                    this.errors.name = "";
                }
            }
        },
        methods: {
            checkCourse() {
                let af = this;
                let errors = {};
                if(typeof af.course.course_obj !== 'undefined'){
                    // delete af.errors['course'];
                    if(af.course.course_obj == null){
                        swal.fire(
                            'Oppss..',
                            'Course is required..',
                            'error'
                        )
                        errors['course'] = ["Course is required."];
                        // return false;
                    }
                }else{
                    swal.fire(
                        'Oppss..',
                        'Course is required..',
                        'error'
                    )
                    errors['course'] = ["Course is required."];
                    // return false;
                }
                // console.log(errors['course']);
                // console.log(errors.length);
                if (typeof errors['course'] !== 'undefined'){
                    af.errors = errors;
                    return false
                }else{
                    delete errors['course'];
                    af.errors = errors;
                }
                
                // document.getElementById("nav-info-tab").classList.remove("active");
                // document.getElementById("nav-info").classList.remove("active");

                this.$parent.$store.state.course = this.course;
                document.getElementById("nav-info-tab").classList.add('disabled')
                
                document.getElementById("nav-units-tab").classList.remove('disabled')
                this.$parent.$children[1].unitOpt();
                $('a[href="#nav-units"]').tab('show')
                // console.log($('a[href="#nav-units"]').tab());
                // document.getElementById("nav-units").classList.add('active')
            },
            fetchData() {
                // console.log(course_id);
                axios({
                    method: 'get',
                    url: '/course/show/info/'+this.course_code
                })
                .then(res => {
                })
                .catch(err => console.log(err));
            },
            saveChanges() {
            },
            checkSelect(selected) {
                let af = this;
                af.course.code = selected.qual_code;
                af.course.name = selected.qual_title;
                af.course.tp_code = selected.tp_code;

            },
            addTag(newTag) {
            // console.log(newTag);
                let af = this;
                const fixedtag = newTag.split("-");
                if(fixedtag.length < 2){
                    swal.fire(
                        'Oppss..',
                        'Please follow the course format..',
                        'error'
                    )
                }else{
                    const tag = {
                    tp_code: "",
                    qual_code: fixedtag[0].trim(),
                    qual_title: fixedtag[1].trim()
                    };
                    af.course.course_obj = tag;
                    af.course.code = tag.qual_code;
                    af.course.name = tag.qual_title;
                    af.opt.push(tag);
                }
            },
            fetchCourseOption(query) {
            let af = this;

            if (query == "") {
                af.opt = [];
            } else {
                af.isLoading = true;
                axios
                .get("/course-setup/course_options/list/" + query)
                .then(function(response) {
                    // handle success
                    // console.log(response.data);
                    af.isLoading = false;
                    af.opt = response.data;
                })
                .catch(function(error) {
                    // handle error
                    af.isLoading = false;
                    // console.log(error);
                })
                .then(function() {
                    // always executed
                    // alert(af.selectedStudent);
                    af.isLoading = false;
                });
            }
            },
            limitText(count) {
                return `and ${count} other units`;
            },
            courseWithCode({ qual_code, qual_title, selected = 0 }) {
                let cwc = qual_code;
                // console.log(selected);
                if(selected == 0)
                    cwc += qual_title == '' ? '' : ' - '+ qual_title;
                // console.log(cwc);
                // this.name = qual_title;
                return cwc;
            // return `${subject_code} - ${description}`;
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