<template>
    <div class="app-modal">
        <div v-if="page_error!=null" class="card border-0 shadow-lg">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <img :src="logo_url" alt="profile" width="170px">
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold h4 m-0 float-right"> Pre-training Review </span>
                        <div class="clearfix"></div>
                        <span class="float-right" style="font-size:12px;">RTO No:  | CRICOS Code: 03871F</span>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <!-- card -->
                <div class="form-group">
                    <label >Something went wrong!</label>
                    <div >
                        <p><span>{{page_error}}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-lg " v-else>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <img :src="logo_url" alt="profile" width="170px">
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold h4 m-0 float-right"> Pre-training Review ({{student_type.type}})</span>
                        <div class="clearfix"></div>
                        <span class="float-right" style="font-size:12px;">RTO No: {{ app_settings.training_organisation_id }} | CRICOS Code: 03871F</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div>
                    <!-- Nested Row within Card Body -->
                    <div class="row px-4 pt-4" v-for="(v, key) in pages[cur_page].component" :key="key">
                        <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-12 '">
                            <h6>{{v.title}}</h6>
                        </div>
                        <div v-for="(itm, k) in v.inputs" :key="k" v-bind:class="typeof itm['col_size'] !== 'undefined' ? 'col-md-'+itm['col_size'] : 'col-md-6'">
                            <div v-if="itm['type'] === 'text'">
                                <!-- text -->
                                <div class="form-group">
                                    <label for="company_name">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span> <span class="font-weight-bold" v-if="typeof itm['optional'] !== 'undefined'"><em>(Optional)</em></span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                            <div v-else-if="itm['type'] === 'select'">
                                <!-- selectbox -->
                                <div class="form-group">
                                    <label for="agent_type">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label for="company_name">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label for="company_name">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                            <div v-else-if="itm['type'] === 'signature'">
                                <!-- textbox -->
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <input type="text" class="form-control type-signature" v-bind:name="itm['name']"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                            <div v-else-if="itm['type'] === 'textarea'">
                                <!-- textbox -->
                                <div class="form-group">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                        :track-by="typeof itm['mTrackBy'] !== 'undefined' ? itm['mTrackBy'] : 'value'" 
                                        :label="typeof itm['mLabel'] !== 'undefined' ? itm['mLabel'] : 'value'"
                                        @select="secondOption"
                                        v-if ="typeof itm['second_option'] !== 'undefined'"
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
                                        :track-by="typeof itm['mTrackBy'] !== 'undefined' ? itm['mTrackBy'] : 'value'" 
                                        :label="typeof itm['mLabel'] !== 'undefined' ? itm['mLabel'] : 'value'"
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                            <thead v-if="typeof content.body.thead !== 'undefined'">
                                                <tr>
                                                    <th :class="'text-center table-header-'+app_color" :width="typeof content.body.column_width !== 'undefined' ? content.body.column_width[k_list] : ''" v-for="(list, k_list) in content.body.thead" :key="k_list" v-html="list"></th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="typeof content.body.tbody !== 'undefined'">
                                                <tr v-for="(row, k_row) in content.body.tbody" :key="k_row">
                                                    <td valign='top' v-for="(col, k_col) in row" :key="k_col" :class="content.body | table_class_addons(k_col)" v-html="col"></td>
                                                    <!-- <td valign='top' v-for="(col, k_col) in row" :key="k_col" :class="'pt-2 align-top '+typeof content.body.text_type !== 'undefined' ? content.body.text_type[k_col] : 'text-left'+ typeof content.body.background_color !== 'undefined' ?  ' '+content.body.background_color[k_col] : ''" v-html="col"></td> -->
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
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
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span>
                                    <a
                                        v-if="typeof itm['tooltip'] !== 'undefined'"
                                        href="#"
                                        data-toggle="tooltip"
                                        :class="'a-'+app_color"
                                        :title="itm['tooltip']"
                                        data-placement="right"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </a></label>
                                    <p v-for="(i, key) in itm['content']" :key="key"><input v-if="typeof i.paragraph === 'undefined'" type="checkbox" class="" v-model="inputs[itm['name']+'-'+key] = i['value']" style="width: 35px;height: 20px;"><span v-html="i.description"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- navigation -->
                    <div class="row p-3">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                            <button :class="'btn btn-'+app_color" v-if="typeof pages[cur_page - 1] !== 'undefined'" @click="change_page(cur_page - 1)"><i class="fas fa-arrow-circle-left"></i> Back</button>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                            <button :class="'btn btn-'+app_color" v-if="typeof pages[cur_page  + 1] !== 'undefined'&&cur_page!=5" @click="change_page(cur_page + 1)">Next <i class="fas fa-arrow-circle-right"></i></button>
                            <button class="btn btn-success" v-else @click="saveForm()">
                                <div v-if="action=='edit'">
                                    <i class="far fa-save"></i> Update
                                </div>
                                <div v-else>
                                    <i class="far fa-save"></i> Save
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

// import Attachments from './../FileDragDropComponent.vue';
import moment from 'moment';

export default {
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
    components: {
        // Attachments
    },
    data () {
        return {
            app_color: app_color,
            courses : window.courses,
            student_type_sign: window.type_signature,
            student_type: window.student_type,
            fullname: '',
            cur_page : 0,
            pages : {},
            inputs: window.inputs?window.inputs:[],
            stored_inputs:window.inputs,
            errors: [],
            process_id: null,
            required: [],
            app_settings: window.app_settings,
            logo_url: window.logo_url,     
            page_error:window.error,
            action:window.action,
            student:window.student,
            redirect_to:window.link,
        }
    },
    created() {
        // console.log(moment('2020-07-06T16:00:00.000Z'));
        this.pages = window.pages;
        this.process_id = typeof window.process_id !== 'undefined' ? window.process_id : null;
    },
    methods: {
        change_page (change_page) {
            this.cur_page = change_page;
        },
        saveForm () {
            var action = this.action;
            var dis = this;
            var data ={'pages':this.pages,'inputs':this.inputs,'action':action};
            let validationChecker = [];
            let notAllowed = ['', null, undefined];
            
            for(let vr in dis.required){
                if(notAllowed.indexOf(dis.inputs[vr]) != -1){
                    dis.errors['inputs.'+vr] = [dis.required[vr]+' is required'];
                    validationChecker.push(dis.required[vr]);
                }else{
                    delete dis.errors['inputs'+vr];
                }
            }
            if(validationChecker.length > 0){
                let html = '<ul style="margin-left: 10% !important;">';

                validationChecker.forEach(v => {
                    html += '<li style="text-align:left !important; font-size: 16px; color: #ff5757 !important;">'+v+'</li>';
                })
                html += '</ul>';

                swal.fire({
                    type: 'error',
                    title: 'Please fill the following:',
                    html: html
                })

                return false
            }else{
                dis.errors = [];
            }
            // console.log(data);
            swal.fire({
                title: 'Submitting Pre-Training Review',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
            });
            axios.post('/ptr/save/'+dis.process_id,data).then(
                response=>{
                    if(response.data=="success"||response.data=="success update"){
                        swal.fire(
                            'Saved!',
                            'Proceed.',
                            'success'
                        ).then((result)=>{
                            if(this.action=='edit'){
                                window.location.href = "/student/"+dis.student.id;
                            }else{
                                if(typeof this.redirect_to!=='undefined'){
                                    window.location.href = dis.redirect_to;
                                }else{
                                    window.location.href = "/pca/enrolment-process/"+dis.process_id;
                                }
                            }
                        });
                    }else{
                        Toast.fire({
                            type: "error",
                            title: response.data.error,
                            background: "#ffcdd2"
                        });                        
                    }
                }
            ).catch(
                error=>{

                }
            );           
            
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
            if(this.action!='edit'&&this.action!='edit_student'){
                this.inputs = data;
            }
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

    @import url('/public/fonts/brush-script-mt/brush script mt kursiv.ttf');

    .type-signature {
        font-family: 'Brush Script MT', cursive;
        font-size:30px;
    }
</style>
