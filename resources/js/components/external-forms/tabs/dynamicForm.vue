<template>
    <div class="card-body p-0">
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
                                    <input class="form-control" v-bind:name="itm['name']" type="text" v-if="toType(itm['readOnly']) !== 'undefined'" readonly v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
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
                                        <button :class="'btn btn-'+app_color" type="button" @click="findStudent(inputs[itm['name']] = itm['value'])">
                                            <span>Check</span>
                                        </button>
                                    </div>
                                    </div>
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>         
                            </div>
                            <div v-if="itm['type'] === 'time'">
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
                                    <input class="form-control" v-bind:name="itm['name']" type="time" v-if="toType(itm['readOnly']) !== 'undefined'" readonly v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                    <input class="form-control" v-bind:name="itm['name']" type="time" v-else v-bind:id="itm['name']" v-model="inputs[itm['name']]  = itm['value']">
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
                            <div v-else-if="itm['type'] === 'signature'">
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
                                    <input type="text" class="form-control type-signature" v-bind:name="itm['name']"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
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
                            <div v-else-if="itm['type'] === 'dynamic-table'">
                                    <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="toType(itm['required']) !== 'undefined'">*</span>
                                    </label>
                                        <table
                                            :class="'header-'+app_color"
                                            style="width:100%"
                                        >
                                        <thead>
                                            <tr v-if="toType(itm['headers']) !=='undefined'">
                                                <th v-for="i in itm['headers']" :class="'text-center table-header-'+app_color">{{i}}</th>
                                                <th :class="'text-center table-header-'+app_color">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="itm['value'].length>0">
                                                <tr v-for="(i,parent_node_index) in itm['value']">
                                                    <td v-for="(e,index) in i" >
                                                        <!-- [inputs][{{itm['name']}}][{{parent_node_index}}][{{index}}] = {{e}} -->
                                                        <!-- {{inputs[itm['name']][1][1]}} -->
                                                        <input type="text" v-model="inputs[itm['name']][parent_node_index][index]" class="form-control">
                                                    </td>
                                                    <td :class="'text-center'"><button class="btn btn-danger" @click="removeRow(itm['name'],parent_node_index)">-</button></td>
                                                </tr>
                                            </template>
                                            <tr v-else>
                                                <td v-for="count in itm['headers']">
                                                    <input type="text" class="form-control">
                                                </td>
                                                <td :class="'text-center'"><button class="btn btn-danger" @click="removeRow(itm['name'],parent_node_index)">-</button></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td :colspan="itm['headers'].length+1"><button class="btn btn-success form-control" @click="addRow(itm['name'],itm['max_rows'])">Add row</button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <br><br>
                            </div>
                        </div>
                    </div>
                    <!-- navigation -->
                    <div class="row p-3">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                            <button :class="'btn btn-'+app_color" v-if="toType(pages[cur_page - 1]) !== 'undefined'" @click="change_page(cur_page - 1)"><i class="fas fa-arrow-circle-left"></i> Back</button>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                            <button :class="'btn btn-'+app_color" v-if="toType(pages[cur_page  + 1]) !== 'undefined'&&cur_page!=5" @click="change_page(cur_page + 1)">Next <i class="fas fa-arrow-circle-right"></i></button>
                            <!-- <button class="btn btn-success" v-else @click="saveForm()">
                                <div v-if="action=='edit'">
                                    <i class="far fa-save"></i> Update
                                </div>
                                <div v-else>
                                    <i class="far fa-save"></i> Save
                                </div>
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
</template>
<script>
import moment from 'moment';
export default {
    data(){
        return{
            app_color:app_color,    
            cur_page : 0,
            student_details:[]
        }
    },
    props:['pages','errors','required','inputs','person'],
    methods:{
        findStudent(data){
            // console.log(data);
            let dis = this;
            let student_id = data;
            if(student_id !== '' && student_id!==null){
                swal.fire({
                title: 'Please wait...',
                // html: ''
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
                });
                axios.get(`/external-forms/getStudent/${student_id}`).then(
                    response=>{
                        if(response.data.status === 'success'){
                            // console.log(dis.inputs.student_name);
                            // dis.inputs.student_name = response.data.student_details.party.name
                            dis.student_details = response.data.student_details

                            if(dis.pages.length > 0){
                                dis.pages.forEach(element=>{
                                    // console.log(elem);
                                    element.component.forEach(elem=>{
                                        elem.inputs.forEach(el=>{
                                            if(el.name=='student_name'){
                                                el.value = dis.student_details.party.name
                                            }
                                            if(el.name=='email'){
                                                el.value = dis.student_details.contact_detail.email
                                            }
                                            if(el.name=='phone'){
                                                el.value = dis.student_details.contact_detail.phone_mobile
                                            }
                                            if(el.name=='student_dob'){
                                                el.value = moment(dis.student_details.party.person.date_of_birth)._d
                                            }
                                        });
                                    });
                                });
                            }
                            dis.verified_student_id = data;
                            dis.student_verified = true
                            swal.fire({
                                title: 'Student verified!',
                                type: 'success',
                            })
                        }else{
                            swal.fire({
                            type: 'error',
                            title: 'Opss.. something went wrong.',
                            html: response.data.message
                        });
                        }
                    }
                ).catch(
                    err=>{
                        swal.fire({
                            type: 'error',
                            title: 'Opss.. something went wrong.',
                            html:err
                        });
                    }
                );
            }else{
                swal.fire({
                    type: 'error',
                    title: 'Opss.. something went wrong.',
                    html:'Student ID not found.'
                });
            }
        },
        toType(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },
        removeRow(name,idx){
            const array = this.inputs[name];
            // console.log(this.inputs[name]);
            // console.log(name,idx);
            // console.log('test');
            if(array.length>1){
                array.splice(idx,1);
            }
        },
        addRow(itm_name,max_rows=Infinity){
            var row_length = this.inputs[itm_name].length;
            if(row_length<max_rows){
                this.inputs[itm_name].push(["","",""]);
            }else{
                Toast.fire({
                type: "error",
                title: "Cannot add more rows",
                position: "bottom-end",
                });
            }
        },
        change_page (change_page) {
            this.cur_page = change_page;
        },
    },
    watch:{
        pages : function (newval,oldval){
            // console.log(';test');
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

                        if(el.type == 'dynamic-table'){
                            data[el.name] = el.value;
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
            // if(this.action!='edit'&&this.action!='edit_student'){
            //     this.inputs = data;
            // }
            this.inputs = data;
            this.required = required;
        },
    },
    // created(){
    //     this.pages.forEach(function(element){
    //         element.component.forEach(elem => {
    //             elem.inputs.forEach(el => {
    //                 console.log('el');
    //                 // console.log(el);
    //                 if(el.type == 'date' && typeof el.value !== 'undefined'){
    //                     el.value = moment(el.value)._d;
    //                     // console.log(moment(el.value)._d);
    //                 }
    //                 // if(el.type == 'dynamic-table'){
    //                 //     data[el.name] = el.value;
    //                 // }
    //             });
                
    //         });
    //     });
    // }
}
</script>
<style scoped>
@import url('/public/fonts/brush-script-mt/brush script mt kursiv.ttf');

    .type-signature {
        font-family: 'Brush Script MT', cursive;
        font-size:30px;
    }
</style>