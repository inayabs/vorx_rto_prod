><template>
    <div>
        <dynamic-form 
        v-bind:form-settings='makeForm' 
        v-bind:form-values='getValues'
        v-bind:save-form='store_url'
        ></dynamic-form>
        
    </div>
</template>


<script>
    import moment from "moment";
    import DynamicForm from "../../../components/globals/form/DynamicFormComponent.vue";
    export default {
        components: {
            DynamicForm
        },
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                date: '',
                student_id: window.student_id,
                slct_visa_type: window.slct_visa_type,
                csrfToken: '',
                store_url: `/student/domestic/${window.student_id}/visa_update`,
                getValues: window.visa_info || {
                    nationality: '',
                    passport_number: '',
                    issue_date: '',
                    expiry_date: '',
                    visa_type: '',
                    subclass: '',
                    expiry_date_visa_type: '',
                    applied_for_au_residency: '',
                    study_rights: '',
                },
                makeForm : [{
                    FormTitle : 'Residency & Visa Information',
                    FormBody : [
                        {
                            type : 'text',
                            lable : 'Nationality',
                            name : 'nationality',
                            value : ''
                        },
                        {
                            type : 'text',
                            lable : 'Passport No.',
                            name : 'passport_number',
                            value : ''
                        }, 
                        {
                            type : 'datepicker',
                            lable : 'Issue Date',
                            name : 'issue_date',
                            value : '',
                        }, 
                        {
                            type : 'datepicker',
                            lable : 'Expiry Date',
                            name : 'expiry_date',
                            value : '',
                        },               
                    ]
                },
                {
                    FormTitle: "If not Australian Citizen",
                    FormBody: [
                        {
                            type : 'singleselect',
                            lable : 'Visa Type',
                            name : 'visa_type',
                            selections: window.slct_visa_type,
                            col_size: 12
                        },
                        // {
                        //     type : 'text',
                        //     lable : 'Sub Class',
                        //     name : 'subclass',
                        //     value : '',
                        // },
                        {
                            type : 'datepicker',
                            lable : 'Expiry Date',
                            name : 'expiry_date_visa_type',
                            value : '',
                        },
                        {
                            type : 'select',
                            lable : 'Applied for Australian Permanent Residency',
                            name : 'applied_for_au_residency',
                            value : 'No',
                            items: {
                                No: "NO",
                                Yes: "YES"
                            },
                        }, 
                        {
                            type : 'select',
                            lable : 'Study Rights',
                            name : 'study_rights',
                            value : 'No',
                            items: {
                                No: "NO",
                                Yes: "YES"
                            },
                        }, 
                        ]
                    }
                ],
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                // console.log(window.visa_info);
                if(window.visa_info != null){
                    if(window.visa_info.issue_date != null){
                        this.getValues.issue_date = moment(window.visa_info.issue_date)._d;
                    }
                    if(window.visa_info.expiry_date != null){
                        this.getValues.expiry_date = moment(window.visa_info.expiry_date)._d;
                    }
                    if(window.visa_info.expiry_date_visa_type != null){
                        this.getValues.expiry_date_visa_type = moment(window.visa_info.expiry_date_visa_type)._d;
                    }
                    if(window.visa_info.visa_type != null){
                        this.getValues.visa_type = this.getVisaType(window.visa_info.visa_type);
                    }
                }
            },
            getVisaType(vt_id){
                let vt = null;
                this.slct_visa_type.forEach(element => {
                    if(element.id == vt_id){
                        vt = element;
                    }
                });
                return vt;
            },
            saveChanges() {
                // @ dynamic form
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