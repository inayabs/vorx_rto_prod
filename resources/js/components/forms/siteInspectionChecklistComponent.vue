<template>
    <div class="app-modal">

        <div class="card border-0 " style="box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.675) !important;">
            <div class="card-header background-blue">
                <!-- <span class="font-weight-bold h5"> Community Education Australia - RTO No: 6074</span> -->
                <div class="row">
                    <div class="col-md-6">
                        <img :src="logo_url" alt="profile" width="170px">
                    </div>
                    <div class="col-md-6 text-center pt-4" style="color:#fff">
                        <span class="font-weight-bold h4 m-0 float-right"> Community Education Australia</span>
                        <!-- <div class="clearfix"></div> -->
                        <span class="font-weight-bold h4 m-0 float-right"> Site Inspection Checklist</span>
                        <div class="clearfix"></div>
                        <!-- <span class="float-right" style="font-size:12px;">RTO No: {{ app_settings.training_organisation_id }} | CRICOS Code: 03871F</span> -->
                        <span class="float-right" style="font-size:12px;">RTO No: {{ app_settings.training_organisation_id }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div>
                    <!-- Nested Row within Card Body -->
                    <div class="row px-4 pt-4" v-for="(v, key) in pages[cur_page].component" :key="key">
                        <div v-if="typeof v.title !== 'undefined'" :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-12 '">
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
                                    <date-picker :masks="{ input: 'DD/MM/YYYY' }"  locale="en" v-model="inputs[itm['name']]" ></date-picker>
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
                                        
                                        <table v-if="content.type == 'table'" width="100%">
                                            <thead v-if="typeof content.body.thead !== 'undefined'">
                                                <tr>
                                                    <th class="text-center" :width="typeof content.body.column_width !== 'undefined' ? content.body.column_width[k_list] : ''" v-for="(list, k_list) in content.body.thead" :key="k_list" v-html="list"></th>
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
                            <div v-else-if="itm['type'] === 'table-custom'">
                                <div class="clearfix mt-3"></div>
                                <table class="table table-responsive">
                                    <thead v-if="typeof itm['headers'] !== 'undefined'">
                                        <tr v-for="(h,k) in itm['headers']" :key="k">
                                            <th v-for="(vth, kth) in h.cols" :key="kth"  :class="['background-'+app_color, 'text-center']" :rowspan="h.rowspan[kth] != 0 ? h.rowspan[kth] : ''" :colspan="h.colspan[kth] != 0 ? h.colspan[kth] : ''" :style="k == 0 ? 'width: 10%;' : ''">{{vth}}</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="typeof itm['body'] !== 'undefined'">
                                        <tr v-for="(h,k) in itm['body']" :key="k">
                                            <th class="background-info" v-if="typeof h.title_row !== 'undefined'" :colspan="h.colspan"> {{h.description}}</th>
                                            <td v-else >
                                                <span>{{h.description}}</span>
                                            </td>
                                            <td v-for="(vtd, ktd) in h.inputs" :key="ktd">
                                                <span v-if="vtd.type == 'checkbox'">
                                                    <input type="checkbox" class="" style="width: 35px;height: 20px;" v-model="inputs[cur_page+'-'+k+'-'+vtd.name]">
                                                </span>
                                                <span v-else-if="vtd.type == 'text'">
                                                    <input type="text" class="form-control" v-model="inputs[cur_page+'-'+k+'-'+vtd.name]">
                                                </span>
                                                <span v-else>
                                                    <!-- <input type="date" class="form-control" v-model="inputs[cur_page+'-'+k+'-'+vtd.name]"> -->
                                                    <date-picker locale="en" v-model="inputs[cur_page+'-'+k+'-'+vtd.name]" :masks="{L:'DD/MM/YYYY'}"></date-picker>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    
                                </table>

                            </div>
                        </div>
                    </div>
                    <!-- navigation -->
                    <div class="row p-3">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                            <button :class="'btn btn-'+app_color" v-if="typeof pages[cur_page - 1] !== 'undefined'" @click="change_page(cur_page - 1)"><i class="fas fa-arrow-circle-left"></i> Back</button>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                            <button :class="'btn btn-'+app_color" v-if="typeof pages[cur_page  + 1] !== 'undefined'" @click="change_page(cur_page + 1)">Next <i class="fas fa-arrow-circle-right"></i></button>
                            <button class="btn btn-success" v-else @click="saveForm()"><i class="far fa-save"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Attachments from './../globals/FileDragDropComponent.vue';
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
            fullname: '',
            cur_page : 0,
            pages : {},
            inputs: [],
            errors: [],
            process_id: null,
            required: [],
            app_settings: window.app_settings,
            logo_url: window.logo_url,        
        }
    },
    created() {
        // console.log(moment('2020-07-06T16:00:00.000Z'));
        // console.log(window.inputs);
        this.pages = window.pages;
        this.inputs = typeof window.inputs !== 'undefined' ? window.inputs : [];
        this.process_id = typeof window.process_id !== 'undefined' ? window.process_id : null;
    },
    methods: {
        change_page (change_page) {
            this.cur_page = change_page;
        },
        saveForm () {
            let vm = this;
            let notAllowed = ['', null, undefined];
            let validationChecker = [];
            // validate required fields

            // console.log(vm.errors);
            

            let data = {
                inputs: vm.inputs,
                pages: JSON.stringify(vm.pages),
                process_id: vm.process_id
            }
            // console.log(JSON.stringify(vm.inputs));
            // console.log(JSON.stringify(vm.pages));


            swal.fire({
            title: 'Submit Form?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
            if (result.value) {

                swal.fire({
                    title: 'Submitting Form...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });

                axios.post('/forms/site-inspection-checklist-form/save',data)
                .then(function(res){
                    console.log(res.data);
                    if(res.data.status == 'success'){
                        // window.location.href = '/forms/site-inspection-checklist-form/process/'+res.data.process;

                        swal.fire({
                                title: "Good Job!",
                                text: "Site Inspection Checklist Saved Successfully",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes!'
                            }).then((result) => {
                                if (result.value) {
                                    window.location.replace('/forms/site-inspection-checklist-form/process/'+res.data.process);
                                }
                            });
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
        dateFormatChange(date) {
            // console.log(date);
        },
    },
    filters: {
    },
    watch: {
        
        inputs : function (n){
            console.log(n);

            for (const el in n) {
                if(el.match('date')) {
                    console.log(el)
                    console.log(n[el])
                    this.inputs[el] = moment(n[el])._d;
                    console.log(this.inputs[el]);
                }
                // console.log(`${el}: ${n[el]}`);
            }
            // this.inputs.date_of_inspection = moment(this.inputs.date_of_inspection)._d;
            console.log(n)
        }
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
