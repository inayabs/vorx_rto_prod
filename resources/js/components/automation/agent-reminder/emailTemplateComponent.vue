<template lang="">
<div>
    <ul class="legend-fields" v-if="moduleFields.length > 0">
        <li v-for="(field, index) in moduleFields" :key="field.index">
            <span>{{ field }}:</span> <span>%{{ field }}%</span>
        </li>
    </ul>
    <button class="btn btn-success d-table ml-auto" @click="saveCreateUpdate()"><i class="far fa-save"></i> Save Template</button>
    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' my-3'" id="directEdit">
        <h6>Email Template</h6>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputName">Template name:</label>
                    <input type="text" id="inputName" class="form-control" v-model="fields.name" :class="[errors && errors.name ? 'border-danger' : '']" autofocus>
                    <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputSubject">Subject:</label>
                    <input type="text" id="inputSubject" class="form-control" v-model="fields.email_subject" :class="[errors && errors.email_subject ? 'border-danger' : '']">
                    <div v-if="errors && errors.email_subject" class="badge badge-danger">{{ errors.email_subject[0] }}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="inputSubject">Module:</label>
                    <select class="form-control" name="email_module_id" v-model="fields.email_module_id">
                        <option value="0"></option>
                        <option v-for="(opt, optKy) in slct_module " v-bind:key="optKy" v-bind:value="optKy">{{opt}}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="enrolment">Succeeding Email Template</i></span>
                    </label>
                    <select class="form-control" 
                    name="email_template"
                    v-model="fields.succeeding_email_type">
                        <option value="none" selected="selected">None</option>
                        <option v-for="(opt, optKy) in templateList " v-bind:key="optKy" v-bind:value="opt.email_type">{{opt.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6" v-if="fields.succeeding_email_type !== 'none'">
                <div class="form-group">
                    <label for="enrolment">Interval<span class="badge"><i>(Number of days before sending succeeding email template)</i></span>
                    </label>
                    <input type="number" class="form-control" v-model="fields.interval">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="active_status">Status:</label>
                    <div class="custom-control custom-switch my-2">
                        <input type="checkbox" class="custom-control-input" id="active_status" v-model="fields.active" value="0">
                        <label class="custom-control-label" for="active_status">Set as Active</label>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="inputContent">Body:</label>
                    <ckeditor :editor="editor" :config="editorConfig" v-model="fields.email_content" tag-name="textarea"></ckeditor>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <v-client-table :class="'header-'+app_color" :data="templateList" :columns="columns" :options="options" ref="templateTable">
                    <div class="btn-group" slot="actions" slot-scope="{row}">
                        <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(row)"> <i class="fas fa-edit"> </i></a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                    </div>
                    <div slot="module_name" slot-scope="{row}">
                        {{row.email_module.module_name}}
                    </div>
                    <span slot="active" slot-scope="{row}" :class="'badge '+[row.active? 'badge-success' : 'badge-danger']">{{ row.active? 'Active' : 'Inactive' }}</span>
                </v-client-table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    name: 'emailtemplate',
    data() {
        return {
            app_color: app_color,
            slct_module: [],
            m: [],
            moduleFields: [],
            addOn: null,
            // Fetch Template List
            templateList: [],

            // Save/Update Data Action
            fields: {
                succeeding_email_type: 'none'
            },
            errors: {},
            loaded: false,

            // Vue-Tables-2 Syntax
            columns: ['id', 'name', 'module_name', 'active', 'actions'],
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
                    active: 'Status',
                    actions: 'Actions'
                },
                sortable: ['id', 'name', 'active', 'created_at'],
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
    methods: {
        fetchTemplates() {
            axios.get('/agent-reminder/template/fetch').then(response => {
                this.templateList = response.data.ew;
                this.slct_module = response.data.m;
                this.addOn = response.data.addOn;
                this.m = this.slct_module;
            });
        },
        saveCreateUpdate() {
            axios({
                method: 'put',
                url: '/agent-reminder/template/store',
                data: this.fields,
            }).then(response => {
                if (response.data.status == 'errors') {
                    this.errors = response.data.errors;
                } else if (response.data.status == 'success') {
                    this.errors = {};
                    this.fields = {};
                    this.fields.succeeding_email_type = 'none';
                    this.moduleFields = {};
                    this.fetchTemplates();
                    Toast.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Email Template saved successfully',
                        background: '#DCEDC8',
                    })
                }
            }).catch(error => {
                console.log(error);
            });
        },
        edit(row) {
            this.fields = row;
            // console.log(row);
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
                        url: '/email-sending/delete/template/' + id,
                    }).then(response => {
                        swal.fire(
                            'Deleted!',
                            'Email template has been deleted.',
                            'success'
                        );
                        this.fetchTemplates();
                        this.fields.succeeding_email_type = 'none';
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

        },
        getModule(val){
            console.log(val);
        },
    },
    watch: {
        fields: function (value) {
            // remove error msg onkeyup
            if (value.name != null) {
                this.errors.name = "";
            }
            if (value.email_subject != null) {
                this.errors.email_subject = "";
            }
        },
        'fields.email_module_id': function (newVal) {
            this.module_checker(newVal);
        },
        "fields.succeeding_email_type": function(newVal) {
            this.fields.succeeding_email_type = newVal;
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
