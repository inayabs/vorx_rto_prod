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
    import DynamicForm from "../../../components/globals/form/DynamicFormComponent.vue";
    import moment from "moment";
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
                csrfToken: '',
                store_url: `/student/domestic/${window.student}/info_update`,
                getValues: window.student_info,
                makeForm : [{
                    FormTitle : 'Personal Information',
                    FormBody : [
                        {
                            type : 'select',
                            lable : 'Prefix',
                            name : 'prefix',
                            items :{ 
                                    'Mr.' : 'Mr.',
                                    'Ms.' : 'Ms.',
                                    'Mrs.' : 'Mrs.'
                            },
                            value : ''
                        },
                        {
                            type : 'text',
                            lable : 'Firstname',
                            name : 'firstname',
                            value : '',
                            avetmiss : 'required'
                        },
                        {
                            type : 'text',
                            lable : 'Middlename',
                            name : 'middlename',
                            value : ''
                        }, 
                        {
                            type : 'text',
                            lable : 'Lastname',
                            name : 'lastname',
                            value : '',
                            avetmiss : 'required'
                        },
                        {
                            type : 'select',
                            lable : 'Gender',
                            name : 'gender',
                            items :{ 
                                    'Male' : 'Male',
                                    'Female' : 'Female'
                            },
                            value : '',
                            avetmiss : 'required'
                        },  
                        {
                            type : 'datepicker',
                            lable : 'Date of Birth',
                            name : 'date_of_birth',
                            value : '',
                            avetmiss : 'required'
                        }             
                    ]
                }],
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                if(this.getValues != null){
                    if(this.getValues.date_of_birth != null){
                        this.getValues.date_of_birth = moment(this.getValues.date_of_birth)._d;
                    }else{
                        this.getValues.date_of_birth = null;
                    }
                }
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