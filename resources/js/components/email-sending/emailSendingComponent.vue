<template>
    <div>
        <form @submit.prevent="create" class="email-sending mb-3" :class="(sending? 'now-sending': '')">
            <div class="form-padding-left-right">
                <div class="row">
                    <div class="col-lg-12"> 
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold rounded-0 border-bottom-0 border-right-0" id="from-addon">From:</span>
                            </div>
                            <input type="text" class="form-control rounded-0 border-bottom-0 shadow-none px-2" aria-describedby="from-addon" placeholder="ETI <admin@eti.edu.au>"  readonly />
                        </div>
                    </div>
                    <!-- <div class="col-lg-12"> 
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold rounded-0 border-bottom-0 border-right-0" id="to-addon">To:</span>
                            </div>
                            <multiselect v-model="fields.to" :options="userOptions" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" class="form-control rounded-0 border-bottom-0 shadow-none px-0 h-auto" aria-describedby="to-addon" placeholder="Select the recipients email" label="email" track-by="user_id" :class="[disabledTo ? 'disabled': '']" @input="notifyWarning" v-popover:top="'Warning'" data-content='Don&#39;t use "To" for sending emails to all students, agents, or trainers. Instead use "Bcc" for sending emails for user privacy...'><span slot="noResult">Oops! No emails found. Consider changing the search query.</span></multiselect>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <table class="input-table-group" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td rowspan="2" width="4.4%" class="text-center"><span class="font-weight-bold">Cc:</span></td>
                                <td>
                                    <select class="form-control rounded-0 border-bottom-0 border-right-0 shadow-none h-100" @change="ccEmail()" v-model="selectedFilterCC">
                                        <option value="">Select Emails</option>
                                        <option v-for="pf in personFilters" :value="pf">{{ pf.title }}</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control rounded-0 border-bottom-0 border-right-0 shadow-none h-100" @change="ccEmail()" v-model="filterLocationCC" :class="[disabledLocationCC ? 'disabled': '']">
                                        <option value="">Student Type</option>
                                        <option value="1">International</option>
                                        <option value="2">Domestic</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control rounded-0 border-bottom-0 shadow-none h-100" @change="ccEmail()" v-model="filterCourseCC" :class="[disabledCourseCC ? 'disabled': '']">
                                        <option value="">If "all student" is selected please pick course.</option>
                                        <option v-for="course in coursesOptions" :value="course.code">({{ course.code  }}) {{ course.name  }}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <multiselect v-model="fields.cc" :options="userOptions" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" class="form-control rounded-0 border-bottom-0 shadow-none px-0 h-auto" aria-describedby="cc-addon" placeholder="Select the emails to be CC'd" label="email" track-by="user_id" :class="[disabledCc ? 'disabled': '']"><span slot="noResult">Oops! No emails found. Consider changing the search query.</span><template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} emails selected</span></template></multiselect>
                                </td>
                            </tr>
                        </table>
                    </div> -->
                    <div class="col-lg-12">
                        <table class="input-table-group" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td rowspan="2" width="4.4%" class="text-center"><span class="font-weight-bold">Bcc:</span></td>
                                <td>
                                    <select class="form-control rounded-0 border-bottom-0 border-right-0 shadow-none h-100" @change="bccEmail()" v-model="selectedFilterBCC">
                                        <option value="">Select Emails</option>
                                        <option v-for="pf in personFilters" :value="pf">{{ pf.title }}</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control rounded-0 border-bottom-0 border-right-0 shadow-none h-100" @change="bccEmail()" v-model="filterLocationBCC" :class="[disabledLocationBCC ? 'disabled': '']">
                                        <option value="">Student Type</option>
                                        <option value="1">International</option>
                                        <option value="2">Domestic</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control rounded-0 border-bottom-0 shadow-none h-100" @change="bccEmail()" v-model="filterCourseBCC" :class="[disabledCourseBCC ? 'disabled': '']">
                                        <option value="">If "all student" is selected please pick course.</option>
                                        <option v-for="course in coursesOptions" :value="course.code">({{ course.code  }}) {{ course.name  }}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <multiselect v-model="fields.bcc" :options="userOptions" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" class="form-control rounded-0 border-bottom-0 shadow-none px-0 h-auto" aria-describedby="bcc-addon" placeholder="Select the emails to be BCC'd" label="email" track-by="user_id" :class="[disabledBcc ? 'disabled': '']"><span slot="noResult">Oops! No emails found. Consider changing the search query.</span> <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} emails selected</span></template></multiselect>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-12"> 
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold rounded-0 border-bottom-0 border-right-0 shadow-none" id="bcc-addon">Subject:</span>
                            </div>
                            <input type="text" v-model="fields.subject" class="form-control rounded-0 border-bottom-0" placeholder="Email Subject" />
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <ckeditor :editor="editor" v-model="fields.email_content" :config="editorConfig" tag-name="textarea"></ckeditor>
                    </div>
                    <!-- <div class="col-lg-12"> 
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold rounded-0 border-top-0 border-right-0 shadow-none" id="bcc-addon">Template:</span>
                            </div>
                            <select class="form-control rounded-0 border-top-0" id="" v-model="fields.email_template">
                                <option value="">Empty</option>
                                <option value="1">Warning Letter</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold rounded-0 border-top-0 border-right-0" id="attach-addon"><i class="fas fa-paperclip"></i></span>
                            </div>
                            <multiselect v-model="fields.attachments" :options="attachmentsOptions" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" class="form-control rounded-0 border-top-0 shadow-none px-0 h-auto" aria-describedby="attach-addon" placeholder="Select attachemnts " :custom-label="nameWithVersion" track-by="id"><span slot="noResult">Oops! No documents found. Consider changing the search query.</span></multiselect>
                            <button type="submit" @click = "sendEmails()" class="btn btn-success btn-sm px-3 input-group-append font-weight-bold rounded-0"><i class="far fa-paper-plane"></i> &nbsp; Send</button>
                        </div>
                        <small id="attachementHelpBlock" class="form-text text-muted">
                            <b>Note:</b> File attachements are stored in <a href="/documents" target="_blank" class="text-primary"><b>documents</b></a> section. 
                        </small>
                    </div>
                </div>
            </div>
            <!-- <div class="email-identifier"><i class="fas fa-spinner fa-pulse fa-3x"></i><br><div>Sending 1 of {{ $data.totalEmails }} emails...</div></div> -->
            <div class="email-identifier"><i class="fas fa-spinner fa-pulse fa-3x"></i><br><div>Sending emails wait for confirmation, Please wait...</div></div>
        </form>
        <!-- <pre class="my-5">{{ $data.fields }}</pre> -->
        <hr>

        <v-client-table :class="'header-'+app_color" :data="email_sending_list" :columns="columns" :options="options" ref="emailSendingTable">
             <div slot="id" slot-scope="{row,index}">{{ index }}</div>
             <div class="" slot="success" slot-scope="{row}">{{row.success ? row.success.split(',').length : '0'}}</div>
             <div class="" slot="failed" slot-scope="{row}">{{row.failed ? row.failed.split(',').length : '0'}}</div>
             <!-- <div class="" slot="actions" slot-scope="{row}">
                 <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="viewEmailSended(row.id)"> <i class="far fa-eye"> </i> View Details</a>
            </div> -->
        </v-client-table>
        
    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import FormMixin from '../../mixins/FormMixin';

export default {
    mixins: [ FormMixin ],
    data() {
        return {
            app_color: app_color,
            // Form Attributes
            'action': 'email-sending/store',
            'method': 'post',
            sending: false,
            disabledCourseCC: true,
            disabledCourseBCC: true,
            disabledLocationCC: true,
            disabledLocationBCC: true,
            disabledTo: false,
            disabledCc: false,
            disabledBcc: false,
            totalEmails: [],
            personFilters: [
                { value: 'all', title: 'All' },
                { value: 'student', title: 'All Students' },
                { value: 'agent', title: 'All Agents' }
            ],
                // Filter for the person type
            selectedFilterCC: '',
            selectedFilterBCC: '',
            filterCourseCC: '',
            filterCourseBCC: '',
            filterLocationCC: '',
            filterLocationBCC: '',
            // ckEditor
            editor: ClassicEditor,
            editorConfig: {
                 toolbar: [ 'undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', '|', 'link', 'blockQuote', 'insertTable',],
                 heading: {
                     options: [
                         { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                         { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                         { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                         { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                         { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                         { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                         { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' },
                    ]
                },
                 placeholder: "Compose email content",
            },
            // Vue Multiselect
                // TO
            to: null,
                // CC
            cc: null,
                // BCC
            bcc: null,
            userOptions: [
                {"user_id":1,"person_type":"agent","email":"xyshain@gmail.com"},
                {"user_id":2,"person_type":"agent","email":"xyshain@gmail.com"},
                {"user_id":3,"person_type":"student0","email":"xyshain@gmail.com"},
            ],
                // Attachments
            attachments: null,
            attachmentsOptions: fetchDocuments,
                // Courses
            coursesOptions: fetchCourses,
            // Email Sending List
            email_sending_list: [],
            // Vue-Tables-2 Syntax
            columns: ['id', 'subject', 'success', 'failed', 'created_at'],
            options: {
                initialPage:1,
                perPage:10,
                highlightMatches:true,
                sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                headings: {
                    id: '#',
                    subject: 'Subject',
                    success: 'Success',
                    failed: 'Failed',
                    created_at: 'Date',
                    // actions: 'Actions',
                },
                sortable: ['id', 'subject', 'success', 'failed', 'created_at'],
                texts: {
                    filter: "Search:",
                    filterPlaceholder: "Search keywords",
                }
            },
        };
    },
    watch: {
        success: function (value) {
            this.getEmailSendingList();
            this.sending = false;
            this.success = false;
        },
        fields: function (value) {
            if(value.to != undefined) {
                this.totalEmails = value.to.length;
            }
        }
    },
    created() {
        this.getEmailSendingList();
        // this.getPersonsList();
    },
    methods: {
        async getEmailSendingList() {
            axios.get('/email-sending/list/all').then(response => {
                this.email_sending_list = response.data;
            });
        },
        // async getPersonsList() {
        //     axios.get('/email-sending/list/persons').then(response => {
        //         this.userOptions = response.data;
        //     });
        // },
            // viewEmailSended(id) {
            //     window.location.href = '/email-sending/details/'+ id;
            // },
        nameWithVersion ({ name, version }) {
            return `${name} (v${version})`
        },
        notifyWarning() { /* Warning message in To email address */
            if (this.fields.to.length === 1) {
                console.log('Warning');
            } else {
                return false;
            }
        },
        sendEmails() {
            this.sending = true;
        },
        ccEmail() { /* CC selectbox function for vue-multiselect */
            if (!this.selectedFilterCC) {
                this.fields.cc = [];
                this.disabledCourseCC = this.disabledLocationCC = true;
                this.disabledCc = this.disabledTo = false;
            } else {
                this.fields.cc = [];
                this.disabledCourseCC = this.disabledLocationCC = true;
                this.disabledCc = this.disabledTo = true;
            }
            switch(this.selectedFilterCC.value) {
                case 'all':
                    this.fields.cc = this.userOptions; break;
                case 'student': // All Students
                    this.disabledLocationCC = false;
                    this.fields.cc = this.userOptions.filter(persons => persons.person_type == this.selectedFilterCC.value);
                    if (this.filterLocationCC != "" || this.filterCourseCC != ""){
                        this.fields.cc.forEach(el_location => {
                            if (this.filterLocationCC === el_location.student_type) {
                                this.disabledCourseCC = false;
                                this.fields.cc = this.fields.cc.filter(
                                    locations => 
                                        locations.student_type == this.filterLocationCC
                                );
                            }
                            this.fields.cc.forEach(el_course => {
                                if (this.filterCourseCC === el_course.course) {
                                    this.fields.cc = this.fields.cc.filter(
                                        courses => 
                                            courses.course == this.filterCourseCC
                                    );
                                }
                            });
                        });
                    } break;
                case 'agent': // All Agents
                    this.fields.cc = this.userOptions.filter(persons => persons.person_type == this.selectedFilterCC.value);break;
            }
        },
        bccEmail() { /* BCC selectbox function for vue-multiselect */
            if (!this.selectedFilterBCC) {
                this.fields.bcc = [];
                this.disabledCourseBCC = this.disabledLocationBCC = true;
                this.disabledBcc = this.disabledTo = false;
            } else {
                this.fields.bcc = [];
                this.disabledCourseBCC = this.disabledLocationBCC = true;
                this.disabledBcc = this.disabledTo = true;
            }
            switch(this.selectedFilterBCC.value) {
                case 'all':
                    this.fields.bcc = this.userOptions; break;
                case 'student': // All Students
                    this.disabledLocationBCC = false;
                    this.fields.bcc = this.userOptions.filter(persons => persons.person_type == this.selectedFilterBCC.value);
                    if (this.filterLocationBCC != "" || this.filterCourseBCC != ""){
                        this.fields.bcc.forEach(el_location => {
                            if (this.filterLocationBCC === el_location.student_type) {
                                this.disabledCourseBCC = false;
                                this.fields.bcc = this.fields.bcc.filter(
                                    locations => 
                                        locations.student_type == this.filterLocationBCC
                                );
                            }
                            this.fields.bcc.forEach(el_course => {
                                if (this.filterCourseBCC === el_course.course) {
                                    this.fields.bcc = this.fields.bcc.filter(
                                        courses => 
                                            courses.course == this.filterCourseBCC
                                    );
                                }
                            });
                        });
                    } break;
                case 'agent': // All Agents
                    this.fields.bcc = this.userOptions.filter(persons => persons.person_type == this.selectedFilterBCC.value); break;
            }
        },
    }
}
</script>

<style lang="scss">
.email-sending{
    .multiselect{
        width: 99.8%;
        padding-bottom: 1px;
        .multiselect__select{
            transform: translate(5px, 7px);
        }
        .multiselect__tags{
            padding-top: 0.26rem !important; padding-left: 0.6rem !important;
            .multiselect__input,
            .multiselect__single{
                margin: 0px !important;padding: 0px !important;vertical-align: middle !important;
            }
        }
    }
    .disabled{
        pointer-events: none;user-select: none;
        &.form-control{
            color: #C5C6CB;
        }
        .multiselect__tags{
            opacity: 0.6;
            color: #363636;
        }
    }
    .ck-editor{
        .ck-content{
            height: 200px !important;
        }
    }

    .input-table-group{
        tr{
            &:first-child{
                td{
                    &:first-child{
                        color: #6e707e;
                        background-color: #eaecf4;
                        border-top: 1px solid rgba(2, 75, 103, 0.5) !important;
                        border-left: 1px solid rgba(2, 75, 103, 0.5) !important;
                    }
                }
            }
        }
    }
}
.popover {
    .popover-header{
        background-color: #e53935; color: #FFF; font-weight: 700;
    }
}
</style>

<style lang="scss" scoped>
$white: #fff !default;
$blue: #024B67 !default;
    .email-sending{
        position: relative;
        .email-identifier{
            display: none;color: $white;
        }
        &.now-sending{
            user-select: none;pointer-events: none;
            &:after {content: "";background-color: rgba($blue, 0.4);background-image: linear-gradient(45deg, rgba($blue, 0.7) 25%, transparent 25%, transparent 50%, rgba($blue, 0.7) 50%, rgba($blue, 0.7) 75%, transparent 75%, transparent);background-size: 70px 70px;animation: barberpole 5s linear infinite;position: absolute;top: 0;left: 0;height: 100%;width: 100%;}
            .email-identifier{display: block; font-weight: 700; line-height: 2; width: 50%; text-align: center; position: absolute; z-index: 99; top: 50%; left: 50%; right: 50%; transform: translate(-50%, -50%);}
        }
        .btn {
            &:focus{box-shadow: none;}
        }
    }
    @keyframes barberpole {
        from {background-position: 0 0;}
        to {background-position: 140px 70px;}
    }
</style>