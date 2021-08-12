<template>
     <div>
         <div class="row mb-2 d-flex justify-content-between">
            <div class="col-md-12">
                <a href="/external-forms" v-bind:class="'btn btn-'+app_color+' btn-sm text-primary text-light'">
                <i class="fas fa-long-arrow-alt-left"></i> Back
                </a>
            </div>
        </div>
         <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 :class="'m-0 font-weight-bold text-'+app_color">{{external_form.name}} - {{form_name}}</h6>
            </div>
            <div class="card-body">
                <div>
                    <div class="col-md-12 pull-right text-right">
                        <!-- <a
                        :href="`/student/attachment/preview/${pdf_link}`"
                        target="_blank"
                        class="btn btn-success"
                        style="display:inline-block"
                        >
                        <i class="fas fa-file-pdf"></i> View PDF
                        </a> -->
                        <button class="btn btn-success" @click="saveChanges()">
                            <i class="far fa-save"></i> Save Changes
                        </button>
                    </div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a
                                :class="'nav-item nav-link-'+app_color+' active'"
                                data-toggle="tab"
                                :href="'#external_form'"
                                role="tab"
                                aria-controls="info"
                                aria-selected="true"
                            >Student form</a>
                            <a
                                v-if="Object.keys(assessment_page).length!=0"
                                :class="'nav-item nav-link-'+app_color"
                                data-toggle="tab"
                                :href="'#assessment'"
                                role="tab"
                                aria-controls="info"
                                aria-selected="true"
                            >Assessment</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div
                        :class="'tab-pane fade show active'"
                        :id="'external_form'"
                        role="tabpanel"
                        aria-labelledby="nav-info-tab"
                        >
                            <dynamicForm :pages="external_form.form_json.pages" :inputs="inputs" :errors="errors" :required="required" :person="'student'"/>
                        </div>
                        <div
                        v-if="Object.keys(assessment_page).length!=0"
                        :class="'tab-pane fade'"
                        :id="'assessment'"
                        role="tabpanel"
                        aria-labelledby="nav-info-tab"
                        >
                            <dynamicForm :pages="assessment_page" :inputs="inputs" :errors="errors" :required="required" :person="'staff'"/>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
</template>
<script>
import dynamicForm from './tabs/dynamicForm.vue'
import moment from 'moment'
export default {
    data(){
        return{
            // urole:urole,
            external_form:external_form,
            app_color:app_color,
            pages:{},
            errors:[],
            required:[],
            // inputs: external_form.form_json.inputs?external_form.form_json.inputs:[],
            inputs:[],
            assessment_page:{}
        }
    },
    components:{
        dynamicForm
    },
    computed:{
        form_name(){
            if(this.external_form.form_type == 'complaints_and_appeals') return 'Complaints and appeals'
            if(this.external_form.form_type == 'application_for_release_letter') return 'Application for release letter'
            if(this.external_form.form_type == 'application_for_deferment') return 'Application for deferment suspension cancellation withdrawal'
            if(this.external_form.form_type == 'student_general_request_form') return 'Student general request form'
            if(this.external_form.form_type == 'qualification_request_form') return 'Qualification request form'
            if(this.external_form.form_type == 'refund_request_form') return 'Refund request form'
            if(this.external_form.form_type == 'critical_incident_report_form') return 'Critical incident report form'
        },
    },
    created(){
        this.pages = window.external_form.form_json.pages;
        if(this.external_form.form_type!='critical_incident_report_form'){
            this.assessment_page = this.external_form.form_json.pages.splice(-1);
        }
    },
    methods:{
        saveChanges(){
            let dis = this;
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
                // dis.errors = validationChecker;
                return false
            }else{
                dis.errors = [];
            }

            console.log('la nay error');
            
            swal.fire({
                title: 'Please wait...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                swal.showLoading()
                },
            });

            axios.post('/external-forms/update/'+this.external_form.id,{
                'inputs':this.inputs,
                'pages':this.pages,
                'staff_page':this.assessment_page,
            }).then(
                response=>{
                    if(response.data.status=='success'){
                       swal.fire(
                            'Saved!',
                            'Data saved successfully.',
                            'success'
                        )
                        this.$emit('ptrUpdate');
                    }else{
                        swal.fire({
                        type: 'error',
                        title: 'Something went wrong.',
                        html:response.data.message
                    })
                    }
                }
            ).catch(
                err=>{
                   swal.fire({
                    type: 'error',
                    title: 'Something went wrong.',
                   });
                }
            );
        }
    },
    watch:{
        pages : function (newval,oldval){
            let data = {};
            let required = {}
            console.log('tes');
            newval.forEach(element => {
                element.component.forEach(elem => {
                    elem.inputs.forEach(el => {
                        if(typeof el.required !== 'undefined'){
                            required[el.name] = el.label;
                        }

                        data[el.name] = null;

                        if(el.type == 'date' && typeof el.value !== 'undefined'){
                            el.value = moment(el.value)._d;
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
            
            this.inputs = data;
            // this.required = required;
        },
        assessment_page : function (newval,oldval){
            // console.log('test lods');
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
            
            this.inputs = data;
            // this.required = required;
        },
    }
}
</script>