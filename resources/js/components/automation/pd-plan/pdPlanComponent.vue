<template lang="">
<div>
    <button class="btn btn-success d-table ml-auto" @click="saveCreateUpdate()"><i class="far fa-save"></i> Save Changes</button>
    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'" id="directEdit">
        <h6>Pd plan details</h6>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputName">Type of activity :</label>
                    <input type="text" id="inputName" class="form-control" v-model="fields.activity_type" :class="[errors && errors.activity_type ? 'border-danger' : '']" autofocus>
                    <div v-if="errors && errors.activity_type" class="badge badge-danger">{{ errors.activity_type[0] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputSubject">Activity description:</label>
                    <input type="text" id="inputSubject" class="form-control" v-model="fields.activity_description" :class="[errors && errors.activity_description ? 'border-danger' : '']">
                    <div v-if="errors && errors.activity_description" class="badge badge-danger">{{ errors.activity_description[0] }}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="enrolment">Activity date:</i></span>
                    </label>
                    <date-picker
                        :placeholder="'Select date'"
                        locale="en"
                        v-model="fields.activity_date"
                        :masks="{L:'DD/MM/YYYY'}"
                    />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="enrolment">Email date:</i></span>
                    </label>
                    <date-picker
                        :placeholder="'Select date'"
                        locale="en"
                        v-model="fields.email_date"
                        :masks="{L:'DD/MM/YYYY'}"
                    />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="inputSubject">Email to:</label>
                    <!-- <select v-model="fields.email_to" class="form-control">
                        <option v-for="es in pdVars.email_segments" :value="es.id">{{es.label}}</option>
                    </select> -->
                    <multiselect 
                        v-model="fields.email_to" 
                        :class="[errors && errors.email_subject ? 'border-danger' : '']+'multiselect-color-'+app_color"
                        :options="opts" 
                        :custom-label="selectName"
                        :multiple="true"
                        :close-on-select="false"
                        placeholder="Select email segments"  
                        track-by='id'></multiselect>
                    <div v-if="errors && errors.email_to" class="badge badge-danger">{{ errors.email_to[0] }}</div> 
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th :class="['background-'+app_color]" width="5%" scope="col">#</th>
                        <th :class="['background-'+app_color]" width="15%" scope="col">Type of activity</th>
                        <th :class="['background-'+app_color]" width="35%" scope="col">Activity description</th>
                        <th  :class="['background-'+app_color]" width="15%" scope="col">Activity date</th>
                        <th  :class="['background-'+app_color]" width="10%" scope="col">Email date</th>
                        <th :class="['background-'+app_color]" width="20%" scope="col">Applicable to</th>
                        <th :class="['background-'+app_color]" width="10%" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(pp,index) in pdVars.pd_plans" :key="index">
                            <td>{{index+1}}</td>
                            <td >{{pp.activity_type}}</td>
                            <td >{{pp.activity_description}}</td>
                            <td >{{pp.activity_date | dateformat}}</td>
                            <td >{{pp.email_date | dateformat}}</td>
                            <td >
                                <ul>
                                    <li v-for="et in pp.email_to">
                                        {{et.label}}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(pp)"> <i class="fas fa-edit"> </i></a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(pp.id)"> <i class="fas fa-trash"> </i></a>
                                </div>                                
                            </td>
                        </tr>
                        <tr v-if="pdVars.pd_plans==''">
                            <td colspan="6" style="text-align:center;">No data found</td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import moment from 'moment'

export default {
    name: 'emailtemplate',
    data() {
        return {
            app_color: app_color,
            slct_module: [],
            moduleFields: [],
            addOn: null,
            opts:[],
            // Fetch Template List
            templateList: [],
            pd_plan:{
                email_to:[],
                email_date:null,
            },
            fields: {
                succeeding_email_type: 'none'
            },
            errors: {},
            loaded: false,

            // Vue-Tables-2 Syntax
            columns: ['id', 'type_of_activity', 'activity_description', 'send_to', 'email_date'],
            options: {
                initialPage: 1,
                perPage: 10,
                highlightMatches: true,
                sortIcon: {
                    base: 'fas',
                    up: 'fa-sort-amount-up',
                    down: 'fa-sort-amount-down',
                    is: 'fa-sort'
                },
                headings: {
                    id: '#',
                    name: 'Template Name',
                    module_name: 'Module',
                    actions: 'Actions'
                },
                sortable: ['id', 'name', 'created_at'],
                rowClassCallback(row) {
                    return row.id = row.id;
                },
                columnClasses: {
                    id: 'class-is'
                },
                texts: {
                    filter: "Search:",
                    filterPlaceholder: "Search keywords",
                }
            },

            // ckEditor
            editor: ClassicEditor,
            editorConfig: {
                toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', '|', 'link', 'blockQuote', 'insertTable', ],
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        },
                    ]
                },
                placeholder: "Compose email content",
            },
        }
    },
    created() {
        this.fetchTemplates();  
    },
    name:'pdTemplates',
    props:[
        'pdVars'
    ],
    filters:{
        e_template: function(et){
            if(et==1){
                return "Yes"
            }else if(et==0){
                return "No"
            }
            else{
                return "null"
            }
        },
        dateformat: function(date) {
        if (!date) return "";
        date = moment(date).format("DD/MM/YYYY");
        return date;
        },
    },
    methods: {
        selectName({label}){
            return `${label}`;
        },
        fetchTemplates() {
            axios.get('/pdplan/fetch').then(response => {
                // console.log(response);
                this.templateList = response.data.ew;
                this.slct_module = response.data.m;
                this.addOn = response.data.addOn;
            });
        },
        saveCreateUpdate() {
            axios.post('/pdplan/save',
                this.fields
            ).then(
                response=>{
                    if(response.data.status=='success'){
                         swal.fire(
                            "Succes!",
                            "Data "+response.data.message+" successfully.",
                            "success"
                            );
                            this.$parent.$data.update = !this.$parent.$data.update;
                            this.fields = [];
                    }else{
                        swal.fire({
                            type: 'error',
                            title: 'Cannot proceed.',
                        });
                        this.errors = response.data.errors;
                    }
                }
            );
        },
        edit(row) {
            this.fields = row;
            // console.log(row);
            // this.fields.activity_type = row.activity_type;
            // this.fields.activity_description = row.activity_description;
            this.fields.email_date = moment(row.email_date)._d;
            this.fields.activity_date = moment(row.activity_date)._d;
        },
        remove(id) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    axios({
                        method: 'get',
                        url: '/pdplan/delete/' + id,
                    }).then(response => {
                        swal.fire(
                            'Deleted!',
                            'Email template has been deleted.',
                            'success'
                        );
                        this.$parent.$data.update = !this.$parent.$data.update;
                    });
                }
            });
        },
        module_checker(option) {
            if (option != 0) {
                axios({
                        method: "get",
                        url: `/email-sending/module/${option}`
                    })
                    .then(res => {
                        let vm = this;
                        vm.moduleFields = res.data;
                        // console.log(vm.moduleFields);
                    })
                    .catch(err => console.log(err));
            } else {
                this.moduleFields = [];
            }

        }
    },
    watch: {
        fields: function (value) {
            // remove error msg onkeyup
            if (value.email_to != null) {
                this.errors.email_to = "";
            }
        },
        'fields.email_module_id': function (newVal) {
            this.module_checker(newVal);
        },
        pdVars: function (varr) {
            // remove error msg onkeyup
            if (varr.email_segments !='') {
                this.opts = varr.email_segments;
            }else{
                this.opts = []
            }
        },
    },
}
</script>

<style>
.ck-editor .ck-content {
    height: 500px !important;
}

ul.legend-fields {
    padding: 8px 10px;
    font-size: 12px;
    background-color: #c3ffd1;
    border-radius: 3px;
    border: 1px #a4fdb8 solid;
}

ul.legend-fields li {
    list-style: none;
    line-height: normal;
}
</style>
