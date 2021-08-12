<template>
    <div class="app-modal">

        <div class="card border-0 shadow-lg ">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <img :src="logo_url" alt="profile" width="170px">
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold h4 m-0 float-right"> Domestic</span>
                        <div class="clearfix"></div>
                        <span class="font-weight-bold h4 m-0 float-right"> Enrolment Application Form</span>
                        <div class="clearfix"></div>
                        <span class="float-right" style="font-size:12px;">RTO No: {{ app_settings.training_organisation_id }} | CRICOS Code: 03871F</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="clearfix"></div>
                <div class="row px-4 pt-2">
                    <div class="col-md-12">
                        <span class="font-weight-bold m-0 " style="font-size: 12px;"><i><span class="text-danger">NOTE:</span> All required fields (*) must be filled in.</i></span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div>
                    <!-- Nested Row within Card Body -->
                    <div class="row px-4 pt-4" v-for="(v, key) in pages[cur_page].component" :key="key">
                        <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-12 '">
                            <h6>{{v.title}}</h6>
                        </div>
                        <div v-for="(itm, k) in v.inputs" :key="k" v-bind:class="toType(itm['col_size']) !== 'undefined' ? 'col-md-'+itm['col_size'] : 'col-md-6'">
                            <div v-if="itm['type'] === 'text'">
                                <!-- text -->
                                <div class="form-group">
                                    <label for="company_name">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span> <span class="font-weight-bold" v-if="toType(itm['optional']) !== 'undefined'"><em>(Optional)</em></span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i :class="'fas fa-'+app_color+'-circle'"></i>
                                    </a></label>
                                    <input class="form-control" v-bind:name="itm['name']" type="text" v-if="typeof itm['readOnly'] !== 'undefined'" readonly v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                    <input class="form-control" v-bind:name="itm['name']" type="text" v-else v-bind:id="itm['name']" v-model="inputs[itm['name']]  = itm['value']">
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-if="itm['type'] === 'inputgroup'">
                                 <div class="form-group">
                                    <label for="agent_type">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2" v-bind:name="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                    <div class="input-group-append">
                                        <button :class="'btn btn-'+app_color" type="button" @click="findCode(inputs[itm['name']] = itm['value'])">
                                            <span v-if="code_verified == false">Find</span>
                                            <span v-else="code_verified == true">Verified</span>
                                        </button>
                                    </div>
                                    </div>
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>         
                            </div>
                            <div v-else-if="itm['type'] === 'select'">
                                <!-- selectbox -->
                                <div class="form-group">
                                    <label for="agent_type">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <select name="agent_type" class="form-control" v-model="inputs[itm['name']] = itm['value']">
                                        <option v-for="(opt, optKy) in itm['items']" v-bind:key="optKy" v-bind:value="optKy">{{opt}}</option>
                                    </select>
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'date'">
                                <!-- selectbox -->
                                <!-- <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <select v-bind:name="itm['name']" class="form-control" v-model="inputs[itm['name']] = itm['value']">
                                        <option v-for="(opt, optKy) in itm['items']" v-bind:key="optKy" v-bind:value="optKy">{{opt}}</option>
                                    </select>
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div> -->

                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <date-picker locale="en" v-model="inputs[itm['name']] = itm['value']" :masks="{L:'DD/MM/YYYY'}"></date-picker>
                                    <!-- <div v-if="errors && errors['acs.registered_gst_date']" class="badge badge-danger">{{ errors['acs.registered_gst_date'][0] }}</div> -->
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>

                            </div>
                            <div v-else-if="itm['type'] === 'checkbox'">
                                <!-- checkbox -->
                                <div class="form-group" :hidden="toType(itm['hidden']) !== 'undefined' ? true : false">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <div class="custom-control custom-switch my-2">
                                        <input type="checkbox" class="custom-control-input" v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                        <label class="custom-control-label" v-bind:for="itm['name']"></label> 
                                        <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'number'">
                                <!-- number -->
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <input class="form-control" v-bind:name="itm['name']" type="number"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'radio'">
                                <!-- radiobox -->
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <p>
                                        <span v-for="(v, k) in itm['content']" :key="k">
                                            <span class="radio-control"><input class="" type="radio" :value="v.value" v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']"> {{v.description}}</span>
                                        </span>
                                    </p>
                                    
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'email'">
                                <!-- emailbox -->
                                <div class="form-group">
                                    <label for="company_name">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <input class="form-control" v-bind:name="itm['name']" type="email"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'password'">
                                <!-- passwordbox -->
                                <div class="form-group">
                                    <label for="company_name">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <input class="form-control" v-bind:name="itm['name']" type="password"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'textarea'">
                                <!-- textbox -->
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <textarea class="form-control" v-bind:name="itm['name']"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']"></textarea>
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'multiselect'">
                                <!-- multiselect -->
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <multiselect 
                                        v-model="inputs[itm['name']] = itm['value']" 
                                        :options="itm['selections']" 
                                        :multiple="itm['multiselect']"  
                                        :class="'multiselect-color-'+app_color"
                                        placeholder="Type to search" 
                                        :close-on-select="itm['multiselect'] == true ? false : true"  
                                        :track-by="toType(itm['mTrackBy']) !== 'undefined' ? itm['mTrackBy'] : 'value'" 
                                        :label="toType(itm['mLabel']) !== 'undefined' ? itm['mLabel'] : 'value'"
                                        @select="secondOption"
                                        v-if ="toType(itm['second_option']) !== 'undefined'"
                                    >
                                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                                    </multiselect>
                                    <multiselect 
                                        v-model="inputs[itm['name']] = itm['value']" 
                                        :options="itm['selections']" 
                                        :multiple="itm['multiselect']"  
                                        :class="'multiselect-color-'+app_color"
                                        placeholder="Type to search" 
                                        :close-on-select="itm['multiselect'] == true ? false : true"  
                                        :track-by="toType(itm['mTrackBy']) !== 'undefined' ? itm['mTrackBy'] : 'value'" 
                                        :label="toType(itm['mLabel']) !== 'undefined' ? itm['mLabel'] : 'value'"
                                        v-else
                                    >
                                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                                    </multiselect>
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'hr'">
                                <div class="form-group">
                                    <hr :class="'background-'+app_color">
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'card'">
                                <!-- card -->
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <div v-for="(content, key_content) in itm['content']" :key="key_content">
                                        
                                        <p v-if="content.type == 'paragraph'"><span v-html="content.body"></span></p>
                                        
                                        <table v-if="content.type == 'table'" width="100%" :class="'header-'+app_color">
                                            <thead v-if="toType(content.body.thead) !== 'undefined'">
                                                <tr>
                                                    <th :class="'text-center table-header-'+app_color" :width="toType(content.body.column_width) !== 'undefined' ? content.body.column_width[k_list] : ''" v-for="(list, k_list) in content.body.thead" :key="k_list" v-html="list"></th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="toType(content.body.tbody) !== 'undefined'">
                                                <tr v-for="(row, k_row) in content.body.tbody" :key="k_row">
                                                    <td valign='top' v-for="(col, k_col) in row" :key="k_col" :class="content.body | table_class_addons(k_col)" v-html="col"></td>
                                                    <!-- <td valign='top' v-for="(col, k_col) in row" :key="k_col" :class="'pt-2 align-top '+toType(content.body.text_type) !== 'undefined' ? content.body.text_type[k_col] : 'text-left'+ toType(content.body.background_color) !== 'undefined' ?  ' '+content.body.background_color[k_col] : ''" v-html="col"></td> -->
                                                    <!-- <td>{{content.body.column_width[0]}}</td> -->
                                                    <!-- <td>{{content.body.text_type | text_type()}}</td> -->
                                                </tr>
                                            </tbody>
                                            <!-- <tr v-for="(body, key_body) in content.body" :key="key_body">
                                                <td class="text-center" v-for="(list, k_list) in body" :key="k_list" v-html="list"></td>
                                            </tr> -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'simple-attachment'">
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <input class="form-control" v-bind:name="itm['name']" type="file"  v-bind:id="itm['name']" multiple>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'attachment'">
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <Attachments
                                        v-bind:fileTypeValidate="['jpeg','jpg','png', 'pdf']"
                                        v-bind:fileSizeValidate="5000000"
                                    ></Attachments>
                                </div>
                                
                            </div>
                            <div v-else-if="itm['type'] === 'check-description'">
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    <a
                                        v-if="toType(itm['tooltip']) !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <p v-for="(i, key) in itm['content']" :key="key"><input v-if="toType(i.paragraph) === 'undefined'" type="checkbox" class="" v-model="inputs[itm['name']+'-'+key] = i['value']" style="width: 35px;height: 20px;"><span v-html="i.description"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- navigation -->
                    <div class="row p-3">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                            <button :class="'btn btn-'+app_color" v-if="toType(pages[cur_page - 1]) !== 'undefined'" @click="change_page(cur_page - 1)"><i class="fas fa-arrow-circle-left"></i> Back</button>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                            <button :class="'btn btn-'+app_color" v-if="toType(pages[cur_page  + 1]) !== 'undefined'" @click="change_page(cur_page + 1)">Next <i class="fas fa-arrow-circle-right"></i></button>
                            <button class="btn btn-success" v-else @click="saveForm()"><i class="far fa-save"></i> Proceed to Attachments & Signature</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Attachments from './../../FileDragDropComponent.vue';
import moment from 'moment';

export default {
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
    components: {
        Attachments
    },
    data () {
        return {
            app_color: app_color,
            courses : window.courses,
            fullname: '',
            cur_page : 0,
            pages : {},
            inputs: [],
            errors: [],
            process_id: null,
            required: [],
            app_settings: window.app_settings,
            logo_url: window.logo_url,
            verify_code: null,
            code_verified: false,
            agent_details: {}         
        }
    },
    created() {
        // console.log(moment('2020-07-06T16:00:00.000Z'));
        this.pages = window.pages;
        this.process_id = typeof window.process_id !== 'undefined' ? window.process_id : null;
    },
    methods: {
        toType(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },
        change_page (change_page) {
            this.cur_page = change_page;
        },
        saveForm () {
            let vm = this;
            let notAllowed = ['', null, undefined];
            let validationChecker = [];
            // validate required fields
            for (let vr in vm.required){
                
                // console.log(vm.inputs[vr]);
                if( notAllowed.indexOf(vm.inputs[vr]) != -1 && ['course', 'units'].indexOf(vr) == -1){
                    // console.log(vr);
                    // console.log(vm.required[vr]);
                    // errors[] = 'inputs.'+vr.name;
                    vm.errors['inputs.'+vr] = [vm.required[vr]+' is required'];
                    validationChecker.push(vm.required[vr]);
                }else{
                    delete vm.errors['inputs.'+vr];
                }
            }

            if(notAllowed.indexOf(vm.inputs['course']) != -1 && notAllowed.indexOf(vm.inputs['units']) != -1){
                vm.errors['inputs.course'] = ['Course is conditionally required with Unit of Competency'];
                vm.errors['inputs.units'] = ['Unit of Competency is conditionally required with Course'];
                validationChecker.push('Course');
                validationChecker.push('Unit of Competency');
            }else{
                delete vm.errors['inputs.course'];
                delete vm.errors['inputs.units'];
            }

            // if(vm.inputs['usi_flag'] == 1 && notAllowed.indexOf(vm.inputs['unique_student_id']) != -1){
            //     vm.errors['inputs.unique_student_id'] = ['USI is required'];
            //     validationChecker.push('USI');
            // }else{
            //     delete vm.errors['inputs.unique_student_id'];
            // }

            if(validationChecker.length > 0){
                let html = '<ul style="margin-left: 10% !important;margin-bottom:0!important;">';

                validationChecker.forEach(v => {
                    html += '<li style="text-align:left !important; font-size: 14px; color: #ff5757 !important;">'+v+'</li>';
                })
                html += '</ul>';

                swal.fire({
                    type: 'error',
                    title: 'Please fill the following:',
                    html: html
                })

                return false
            }else{
                vm.errors = [];
            }

            // console.log(vm.errors);
            

            let data = {
                inputs: vm.inputs,
                pages: JSON.stringify(vm.pages),
                process_id: vm.process_id
            }
            // console.log(JSON.stringify(data));
            // console.log(JSON.stringify(vm.pages));


            swal.fire({
            title: 'Submit Enrolment Form?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
            if (result.value) {

                swal.fire({
                    title: 'Submitting Enrolment Form...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });

                axios.post('/pca/online-enrolment/domestic/save',data)
                .then(function(res){
                    console.log(res);
                    if(res.data.status == 'success'){
                        window.location.href = '/pca/online-enrolment/domestic/process/'+res.data.process;
                    }
                })
                .catch(function (err){
                    // console.log(err);
                    swal.fire(
                        'Oppss!',
                        'there seems to be a problem!',
                        'error'
                    )
                })
                
            }
            })

            
            
        },
        findCode(data) {
             let vm = this;
             let code = data;
            if(code !== " " && code !== null){
                swal.fire({
                title: 'Please wait...',
                // html: ''
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
                });
                axios({
                    method: 'get',
                    url: `/pca/online-enrolment/domestic/agent/${code}`,
                }).then(response => {
                    if (response.data.status == 'success') {
                        vm.agent_details = response.data.data;
                        if(vm.pages.length > 0){
                            vm.pages.forEach(element => {
                            element.component.forEach(elem => {
                                elem.inputs.forEach(el => {
                                    //console.log(el);
                                    if(el.name == 'company_title'){
                                        el.value = this.agent_details.company_name;
                                    }
                                    if(el.name == 'contact_name'){
                                        el.value = this.agent_details.agent_name;
                                    }
                                    if(el.name == 'contact_details'){
                                        el.value = this.agent_details.phone;
                                    }
                                    if(el.name == 'contact_details_email'){
                                        el.value = this.agent_details.email;
                                    }
                                });
                            });
                        });
                        }
                        vm.code_verified = true;
                        // magic trick.. HAHAHAH
                        this.change_page(vm.cur_page - 1);
                        this.change_page(vm.cur_page + 1);
                        swal.fire({
                            title: 'Agent Code matched!',
                            type: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        })
                    } else {
                        swal.fire({
                            type: 'error',
                            title: 'Opss.. agent code is invalid.',
                            html: 'Please feel free to contact us on '+vm.app_settings.email_address+' to get your Agent Code.',
                            timer: 10000,
                        });
                    }

                }) 
                 .catch((err) => console.log(err));
            }else{
                swal.fire({
                    type: 'error',
                    title: 'Opss.. access code is invalid.',
                    html: 'Please feel free to contact us on '+vm.app_settings.email_address+' to get Access Code.',
                    timer: 10000,
                });
            }
        },
        dateFormatChange(date) {
            // console.log(date);
        },
        test () {
                // axios.get('https://demo.vorx.com.au/api/user/list')
                // .then(function(res){
                //     console.log(res.data);
                // })
                // .catch(function (err){
                //     console.log(err);
                // })

                axios({
                url: 'https://demo.vorx.com.au/api/user/list',
                method: 'get',
                })
                .then(function(res){
                // console.log(res.data);
                })
                .catch(function (err){
                // console.log(err);
                })
        },
        async secondOption(option) {
            console.log(option);
            let vm = this;
            let scndOp = option.second_option.values;
            // const keys = Object.keys(option.second_option.values)

            // for (let index = 0; index < keys.length; index++) {
            //      html += ``
            //     //  rtrn[index] = document.getElementById(`second_option_${keys[index]}`).value;
            // }
            // console.log(second_option_values)
            const { value: second } = await swal.fire({
                title: option.second_option.description,
                input: 'select',
                type: 'question',
                inputOptions: scndOp,
                allowOutsideClick: false,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value === 'undefined') {
                            swal.fire(`You need to select one.`);
                            vm.secondOption(option);
                        } else{
                            resolve()
                        }
                    })
                }
                // focusConfirm: false,
                
                // inputPlaceholder: 'Select option',
                // showCancelButton: true,
            
            })

            if (second) {
                if(typeof option.alt_desc === 'undefined'){
                    option.alt_desc = option.description;
                }
                option.description = second + ' - ' + option.alt_desc;
                swal.fire(`You selected: ${scndOp[second]}`)
            }

        }
    },
    filters: {
        text_type: function (string) {
            // let arr = string.split(',');
            // let arr = typeof string;
            // let arr = typeof string;
            // string.forEach(element => {
            //     console.log(element);
            // });
            // return string.join();
            // return arr[key];
        },
        dateFormatter: function(date) {
            // console.log(date);
        },
        table_class_addons: function (body, key) {
            let string = 'pt-2 align-top ';

            if(typeof body.text_type !== 'undefined' && typeof body.text_type[key] !== 'undefined'){
                string += body.text_type[key];
                string += ' ';
            }

            if(typeof body.background_color !== 'undefined' && typeof body.background_color[key] !== 'undefined'){
                string += body.background_color[key];
                string += ' ';
            }
            // console.log(string);
            return string;
        }
    },
    watch: {
        pages : function (newval,oldval){
            let data = {};
            let required = {}
            newval.forEach(element => {
                element.component.forEach(elem => {
                    elem.inputs.forEach(el => {
                        // if(el.name == 'firstname' && typeof el.value !== 'undefined'){
                        //     this.fullname += el.value;
                        // }
                        // if(el.name == 'lastname' && typeof el.value !== 'undefined'){
                        //     if(this.fullname == ''){
                        //         this.fullname += el.value;
                        //     }else{
                        //         this.fullname += ' '+el.value;
                        //     }
                        // }
                        if(typeof el.required !== 'undefined'){
                            required[el.name] = el.label;
                        }

                        data[el.name] = null;

                        if(el.type == 'date' && typeof el.value !== 'undefined'){
                            el.value = moment(el.value)._d;
                            // console.log(moment(el.value)._d);
                        }

                        if(el.type == 'check-description'){
                            el.content.forEach((e,ek) => {
                                // console.log(ek);
                                data[el.name+'-'+ek] = null;
                            });
                        }

                        if(el.type == 'multiselect' && typeof el.second_option !== 'undefined'){
                            // console.log(el.selections);
                            el.selections.forEach((e,ek) => {
                                el.selections[ek]['second_option'] = el.second_option;
                            })
                        }

                    });
                });
            });
            this.inputs = data;
            this.required = required;
        },
    }

    
}
</script>


<style scoped>

    td.text-center{
        border-right-color: #fff !important;
        border-left-color: #fff !important;
        vertical-align: top !important;
    }
    td {
        border : 1px solid #bdbdbd !important;
    }
    .radio-control {
        margin-left:10px;
    }
    .vc-border-gray-400{
        border-color: rgba(0, 0, 0, 0.5) !important;
    }

    .multiselect__element .multiselect__option--highlight {
        background: #2b388f !important;
    }

</style>
