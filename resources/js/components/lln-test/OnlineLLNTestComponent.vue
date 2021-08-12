<template>
    <div class="app-modal">
        <div class="card border-0 shadow-lg ">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <img :src="logo_url" alt="profile" width="170px" style="margin-top: -25px;">
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold h4 m-0 float-right"> Guide and Mapping</span>
                        <span class="font-weight-bold h4 m-0 float-right"> Language, Literacy and Numeracy (LLN) Test</span>
                        <div class="clearfix"></div>
                        <span class="float-right" style="font-size:12px;">RTO No: {{ app_settings.training_organisation_id }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div>
                    <modal
                        name="process-code"
                        transition="nice-modal-fade"
                        classes="demo-modal-class"
                        :min-width="200"
                        :min-height="200"
                        :pivot-y="0.1"
                        :adaptive="true"
                        :scrollable="true"
                        :reset="true"
                        :clickToClose="false"
                        width="30%"
                        height="auto"
                    >
                        <div class="size-modal-content">
                        <h4 :class="'modal-header-'+app_color">Enter Access Code</h4>
                        <form @submit.prevent="submitCode">
                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <!-- <label for="access_code">Access Code:</label> -->
                                <input
                                    type="text"
                                    name="access_code"
                                    id="access_code"
                                    v-model="access_code"
                                    class="form-control"
                                />
                                <span
                                    v-if="errors.access_code"
                                    class="badge badge-danger"
                                    role="alert"
                                >{{ errors.access_code[0] }}</span>
                                </div>
                            </div>
                            </div>

                            <button type="submit" :class="'btn float-right btn-'+app_color">Submit</button>
                            <div class="clearfix"></div>
                        </form>
                        </div>
                    </modal>
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
                                    <input class="form-control" v-bind:name="itm['name']" type="text" v-if="assessor === true && toType(itm['readOnly']) !== 'undefined'" readonly v-bind:id="itm['name']" v-model="inputs[itm['name']]">
                                    <input class="form-control" v-bind:name="itm['name']" type="text" v-else v-bind:id="itm['name']" v-model="inputs[itm['name']]">
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
                                    <date-picker  locale="en" v-model="inputs[itm['name']]" :masks="{L:'DD/MM/YYYY'}" v-if="assessor === true && toType(itm['readOnly']) !== 'undefined'">
                                        <input disabled data-v-56ae83be="" :value="inputs[itm['name']] | getDate" type="input" class="vc-appearance-none vc-text-base vc-text-gray-800 vc-bg-white vc-border vc-border-gray-400 vc-rounded vc-w-full vc-py-2 vc-px-3 vc-leading-tight focus:vc-outline-none focus:vc-shadow">
                                    </date-picker>    
                                    <date-picker locale="en" v-model="inputs[itm['name']]" :masks="{L:'DD/MM/YYYY'}" v-else></date-picker>
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
                                            <div class="radio-control">
                                                <input class="" type="radio" :value="v.value" v-bind:id="itm['name']" v-model="inputs[itm['name']]" v-if="assessor === true" disabled> 
                                                <input class="" type="radio" :value="v.value" v-bind:id="itm['name']" v-model="inputs[itm['name']]" v-else> 
                                                {{v.description}}
                                            </div>
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
                                    
                                    <textarea class="form-control" v-bind:name="itm['name']"  v-bind:id="itm['name']" v-model="inputs[itm['name']]" v-if="toType(itm['readOnly']) !== 'undefined' && assessor === true" readonly></textarea>
                                    <textarea class="form-control" v-bind:name="itm['name']"  v-bind:id="itm['name']" v-model="inputs[itm['name']]" v-else></textarea>
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
                                        placeholder="Type to search" 
                                        :close-on-select="itm['multiselect'] == true ? false : true"  
                                        :track-by="toType(itm['mTrackBy']) !== 'undefined' ? itm['mTrackBy'] : 'value'" 
                                        :label="toType(itm['mLabel']) !== 'undefined' ? itm['mLabel'] : 'value'"
                                    >
                                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                                    </multiselect>
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
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
                                                    <td valign='top' v-for="(col, k_col) in row" :key="k_col">
                                                        <!-- input inside td -->
                                                        <div v-if="col['type'] === 'text'">
                                                            <!-- yoooooooooooooooooooo -->
                                                            <div class="form-group" style="margin-bottom:0;">
                                                                <input class="form-control" v-bind:name="col['name']" type="text" v-if="toType(col['readOnly']) !== 'undefined' && assessor === true" readonly v-bind:id="col['name']" v-model="inputs[col['name']]">
                                                                <input class="form-control" v-bind:name="col['name']" type="text" v-else v-bind:id="col['name']" v-model="inputs[col['name']]">
                                                                
                                                                <span v-if="errors && errors[col['name']]" class="badge badge-danger">{{ errors[col['name']][0] }}</span>
                                                            </div>
                                                        </div>
                                                        <!-- text only -->
                                                        <span v-else :class="content.body | table_class_addons(k_col)" v-html="col"></span>

                                                    </td>

                                                    <!-- <td valign='top' v-for="(col, k_col) in row" :key="k_col" :class="content.body | table_class_addons(k_col)" v-html="col"></td>  -->
                                                    
                                                    <!-- <td valign='top' v-for="(col, k_col) in row" :key="k_col" :class="'pt-2 align-top '+toType(content.body.text_type) !== 'undefined' ? content.body.text_type[k_col] : 'text-left'+ toType(content.body.background_color) !== 'undefined' ?  ' '+content.body.background_color[k_col] : ''" v-html="col"></td> -->
                                                    <!-- <td>{{content.body.column_width[0]}}</td> -->
                                                    <!-- <td>{{content.body.text_type | text_type()}}</td> -->
                                                </tr>
                                            </tbody>
                                            <!-- <tr v-for="(body, key_body) in content.body" :key="key_body">
                                                <td class="text-center" v-for="(list, k_list) in body" :key="k_list" v-html="list"></td>
                                            </tr> -->
                                        </table>
                                        <div v-if="content.type == 'illustrate'">
                                            <div class="illustrate-wrapper">
                                                <center>
                                                    <img src="/cea-lln-test-form/images/lln/partb-q5-c.jpg" width="200px" height="300px"/>
                                                    <!-- <canvas id="signature-pad" class="signature-pad" width="200px" height="300px"></canvas> -->
                                                    <img v-if="partb_q5_c_dataImage != null" :src="partb_q5_c_dataImage" width="200px" height="300px">
                                                    <VueSignaturePad v-if="partb_q5_c_dataImage == null" id="signature-pad" class="signature-pad" width="200px" height="300px" ref="signaturePad"></VueSignaturePad>
                                                </center>
                                            </div>
                                            <div v-if="partb_q5_c_dataImage == null">
                                                <button id="save" class="btn btn-success btn-sm" @click="saveCanvas()"> Save</button>
                                                <button @click="clearCanvas()" id="clear" class="btn btn-success btn-sm"> Clear</button>
                                            </div>
                                        </div>
                                        <div v-if="content.type == 'signature'">
                                            <div class="col-md-12 no-padding">
                                                    <div class="form-group">
                                                        <p class="text-justify"><input type="checkbox" v-model="sig_acceptance_agreement" class=""  style="width: 35px;height: 20px;"><span>Electronic Transactions (Queensland) Act 2001/Electronic Transactions (Victoria) Act 2000 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement.</span></p>
                                                    </div>
                                                </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    <label for="">Type Signature</label>
                                                    <input type="text" class="form-control type-signature" v-model="type_signature" v-if="assessor === true" readonly>
                                                    <input type="text" class="form-control type-signature" v-model="type_signature" v-else>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <!-- <Attachments
                                        v-bind:fileTypeValidate="['jpeg','jpg','png', 'pdf']"
                                        v-bind:fileSizeValidate="5000000"
                                    ></Attachments> -->
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
                                    <!-- <p v-for="(itm, key) in itm['content']" :key="key">
                                        <input v-if="typeof itm.paragraph === 'undefined'" type="checkbox" class="" v-model="inputs[itm['name']+'-'+key] = itm['value'][key]" style="width: 35px;height: 20px;">
                                        <span v-html="itm.description"></span>
                                    </p> -->
                                    <p>
                                        <span v-for="(v, k) in itm['content']" :key="k">
                                            <div class="radio-control"><input class="" type="checkbox" :value="v.value" v-bind:id="itm['name']" v-model="inputs[itm['name']]" style="width: 35px;height: 20px;"> {{v.description}}</div>
                                        </span>
                                    </p>
                                    
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- navigation -->
                    <div class="row p-3">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                            <button class="btn btn-primary" v-if="toType(pages[cur_page - 1]) !== 'undefined'" @click="change_page(cur_page - 1)"><i class="fas fa-arrow-circle-left"></i> Back</button>
                            <!-- <button :class="'btn btn-'+app_color" v-else @click="backStudentPortal()"><i class="fas fa-arrow-circle-left"></i> Back to Portal</button> -->
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                            <button class="btn btn-primary" v-if="toType(pages[cur_page  + 1]) !== 'undefined'" @click="change_page(cur_page + 1)">Next <i class="fas fa-arrow-circle-right"></i></button>
                            
                            <button class="btn btn-success" v-else @click="saveChanges()"><i class="far fa-save"></i> Submit</button>
                               
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

// import Attachments from './FileDragDropComponent.vue';
import VueSignaturePad from 'vue-signature-pad';
import moment from "moment";

export default {
    mounted() {
        this.showProcessCode();
        // this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
    data () {
        return {
            app_color: app_color,
            app_settings: window.app_settings,
            logo_url: window.logo_url,
            // courses : window.courses,
            cur_page : 0,
            pages : {},
            process_id: null,
            personalDetails: window.personal_details,
            student_name: window.student_name,
            student_dob: window.student_dob,
            inputs: {},
            savePages: {},
            errors: [],
            partb_q5_c_dataImage: null,
            type_signature: '',
            sig_acceptance_agreement: false,
            required: [],
            assessor: false,
            edit: false,
            access_code: null
        }
    },
    created() {
        // this.fetchData();
        // this.pages = window.pages;
        this.pages = typeof window.pages !== 'undefined' ? window.pages : {};
        this.student_name = typeof window.student_name !== 'undefined' ? window.student_name : '';
        this.process_id = typeof window.process_id !== 'undefined' ? window.process_id : null;
        this.inputs = typeof window.lln_inputs !== 'undefined' ? window.lln_inputs : this.inputs;
        this.partb_q5_c_dataImage = typeof window.partb_q5_c_dataImage !== 'undefined' ? window.partb_q5_c_dataImage : null;
        this.type_signature = typeof window.type_signature !== 'undefined' ? window.type_signature : [];
        this.sig_acceptance_agreement = window.sig_acceptance_agreement == 1 ? true : false;
        this.assessor = typeof window.assessor !== 'undefined' && window.assessor === true ? true : false;
        this.edit = typeof window.edit !== 'undefined' && window.edit === true ? true : false;
        
    },
    methods: {
        toType(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },
        showProcessCode () {
            if(this.edit == true || this.assessor == true){
                this.hideProcessCode();
            }else{
                this.$modal.show('process-code');
            }
        },
        hideProcessCode () {
            this.$modal.hide('process-code');
        },
        submitCode(e){
            let vm = this;
            // console.log(e);
            // console.log(vm.access_code);
            if(vm.access_code !== " " && vm.access_code !== null){
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
                    url: `/online-lln-test/find/${vm.access_code}`,
                }).then(response => {
                // console.log(response);
                    if (response.data.status == 'success') {
                        swal.fire({
                            title: 'Access Code matched!',
                            type: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        })
                        this.$modal.hide('process-code');
                        vm.process_id = response.data.data.process_id;
                    } else {
                        swal.fire({
                            type: 'error',
                            title: 'Opss.. access code is invalid.',
                            html: 'Please feel free to contact us on admin@phoenixcollege.edu.au to get Access Code.',
                            timer: 10000,
                        });
                    }

                }) 
                 .catch((err) => console.log(err));
            }else{
                swal.fire({
                    type: 'error',
                    title: 'Opss.. access code is invalid.',
                    html: 'Please feel free to contact us on admin@phoenixcollege.edu.au to get Access Code.',
                    timer: 10000,
                });
            }
                  
        },
        backStudentPortal (){
            window.location.href = '/dashboard';
        },
        clearCanvas() {
            this.$refs.signaturePad[0].undoSignature();
        },
        saveCanvas() {

        const { isEmpty, data } = this.$refs.signaturePad[0].saveSignature();

        swal.fire({
                title: 'Save Answer?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    if (isEmpty == true) {
                        // alert("Please do not blank.");
                        swal.fire({
                            title: 'Opss.. please illustrate your answer before saving.',
                            type: "warning",
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        this.partb_q5_c_dataImage = data;
                        this.$refs.signaturePad[0].lockSignaturePad();
                        // console.log(this.partb_q5_c_dataImage);
                        swal.fire({
                            title: 'Saved successfully',
                            type: "success",
                            timer: 3000,
                            showConfirmButton: false
                        });
                        // window.open(this.$refs.signaturePad[0].toDataURL());
                        // window.open(data);
                    }
                }
           });

        },
        change_page (change_page) {
            this.cur_page = change_page;
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
                console.log(res.data);
                })
                .catch(function (err){
                console.log(err);
                })
        },
        fetchData(){ 
        },
        saveChanges() {
                let vm = this;
                let inputs = vm.inputs
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
                // console.log(this.saveForm);
                // alert(this.csrfToken);

                if (inputs.date_of_birth != null) {
                    if(inputs.date_of_birth != 'undefined'){
                        inputs.date_of_birth = moment(inputs.date_of_birth).format("YYYY-MM-DD");
                    }
                }else{
                    inputs.date_of_birth = null;
                }

                if (inputs.date != null) {
                    if(inputs.date != 'undefined'){
                        inputs.date = moment(inputs.date).format("YYYY-MM-DD");
                    }
                }else{
                    inputs.date = null;
                }

                if (inputs.outcome_assessor_date != null) {
                    if(inputs.outcome_assessor_date != 'undefined'){
                        inputs.outcome_assessor_date = moment(inputs.outcome_assessor_date).format("YYYY-MM-DD");
                    }
                }else{
                    inputs.outcome_assessor_date = null;
                }

                // console.log(inputs.date_of_birth);
                // console.log(inputs.date);
                // console.log(inputs.outcome_assessor_date);
            let data = {
                inputs: {
                    inputs: inputs,
                    partb_q5_c_dataImage: vm.partb_q5_c_dataImage,
                    type_signature: vm.type_signature,
                    sig_acceptance_agreement: vm.sig_acceptance_agreement,
                },
                pages: JSON.stringify(vm.pages),
                process_id: vm.process_id,
                // savePages: vm.pages
            }
            swal.fire({
                title: 'Submit LLN Test?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {

                    swal.fire({
                        title: 'Submitting LLN Test...',
                        // html: '',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            swal.showLoading()
                        },
                    });

                    axios.post('/online-lln-test/submit', data)
                    .then(res => {
                        // console.log(res);
                        if(res.data.status == 'success'){
                            // console.log(pages);
                            // console.log(this.inputs);
                            this.errors = [];
                            // this.inputs = {};
                            swal.fire({
                                title: 'LLN Test submitted successfully',
                                type: "success",
                                timer: 3000,
                                showConfirmButton: false
                            });
                            window.location.replace(res.data.site);
                            // window.location.href = '/online-enrolment/process/'+window.process_id;

                        }else if(res.data.status == 'errors'){
                            // console.log(res.data.errors);
                            this.errors = res.data.errors;
                            swal.fire({
                                title: typeof res.data.message !== 'undefined' ? res.data.message : 'Opss.. was not submitted successfully',
                                type: "error",
                                timer: 3000,
                                showConfirmButton: false
                            });

                        }else{
                            swal.fire({
                                title: typeof res.data.message !== 'undefined' ? res.data.message : 'Opss.. was not submitted successfully',
                                type: "error",
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(err => console.log(err));
                }
            });
        },
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
        },
        getDate(element) {
            return moment(element).format("DD/MM/YYYY");
        },
        // beforeOpen(e) {
        // // this.fetchCourses();
        // },
        // beforeClose(e) {},
        // opened(e) {
        // // e.ref should not be undefined here
        // // console.log('opened', e)
        // // console.log('ref', e.ref)
        // },
        // closed(e) {
        // console.log("closed", e);
        // }
    },
    watch: {
        pages : function (newval,oldval){
            // console.log(newval);
            let data = {};
            let required = {}
            newval.forEach(element => {
                element.component.forEach(elem => {
                    // ReadOnly inputs if Assessor is true(on edit)
                    if(elem.title !== 'Outcome' && elem.title !== 'Assessor Notes'){
                        elem.inputs.forEach(t => {
                            //
                            if(this.assessor == true && typeof t.readOnly !== 'undefined'){
                                t.readOnly = true;
                            }
                            // inside table inputs
                            if(t.type == 'card'){
                                t.content.forEach(e => {
                                    if(e.type == 'table'){
                                        e.body.tbody.forEach(t1 => {
                                            t1.forEach(t2 => {
                                                if(this.assessor == true && typeof t2.readOnly !== 'undefined'){
                                                    t2.readOnly = true;
                                                }
                                            })
                                            
                                        })
                                    }
                                })
                            }
                        });
                    }
                    elem.inputs.forEach(el => {
                        if(typeof el.required !== 'undefined'){
                            required[el.name] = el.label;
                        }
                        data[el.name] = null;

                        if(el.name == 'candidate_name'){
                            data[el.name] = this.student_name;
                        }
                        
                        if(el.type == 'date' && typeof this.inputs[el.name] !== 'undefined'){
                            data[el.name] = moment(this.inputs[el.name])._d;
                            // console.log(this.inputs[el.name]);
                        }

                        // if(el.name == 'date_of_birth'){
                        //     data[el.name] = moment(this.student_dob)._d;
                        // }

                        
                        if(this.inputs[el.name] !== null){
                            data[el.name] = this.inputs[el.name];
                            if(el.type == 'date' && typeof this.inputs[el.name] !== 'undefined'){
                                data[el.name] = moment(this.inputs[el.name])._d;
                            }

                            // if(el.name == 'date_of_birth'){
                            //     data[el.name] = moment(this.inputs[el.name])._d;
                            // }
                        }

                        if(el.type == 'card'){
                            // console.log(el)
                            el.content.forEach(e => {
                                // console.log(e.type);
                                if(e.type == 'table'){
                                    // console.log(e.body.tbody);
                                    e.body.tbody.forEach(e1 => {
                                        // console.log(e1);
                                        e1.forEach(e2 => {
                                            // console.log(e2);
                                            if(typeof e2.name !== 'undefined'){
                                                // console.log(e2);
                                                data[e2.name] = null;
                                                if(this.inputs[e2.name] !== null){
                                                    data[e2.name] = this.inputs[e2.name];
                                                }
                                            }
                                        })
                                        
                                    })
                                }
                            })
                        }

                        
                        // console.log(el);
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
    @import url('/public/fonts/brush-script-mt/brush script mt kursiv.ttf');

    .type-signature {
        font-family: 'Brush Script MT', cursive;
        font-size:30px;
    }
    /* td.text-center{
        border-right-color: #fff !important;
        border-left-color: #fff !important;
        vertical-align: top !important;
    } */
    td {
        border : 1px solid #bdbdbd !important;
    }
    textarea#parta_assessor_notes, textarea#outcome_outline{
        height: 500px!important;
    }
    textarea#partb_task1_q1, textarea#partb_task1_q2, textarea#partb_task1_q3{
        height: 420px!important;
    }
    table tr th, table tr td{padding: 5px 10px;}
    default-bordered-table thead tr th{background-color: #e74a3b!important;}
    .horizontal-line-wrapper-primary{padding: 5px 10px!important;}
    .radio-control{margin-right:8px;}
.illustrate-wrapper {
  position: relative;
  width: 200px;
  height: 300px;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
img {
  position: absolute;
  left: 0;
  top: 0;
}

.signature-pad {
  position: absolute;
  left: 0;
  top: 0;
  width: 200px;
  height: 300px;
}

</style>
