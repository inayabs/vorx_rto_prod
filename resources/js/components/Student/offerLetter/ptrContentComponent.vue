<template>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
            <!-- <a
            :href="`/pca/pre-training-review/process/${ptr.epack.process_id}/edit`"
            target="_blank"
            class="btn btn-success"
            style="display:inline-block"
            >
            <i class="fas fa-edit"></i> Edit Ptr
            </a> -->
            <a
            :href="`/student/attachment/preview/${pdf_link}`"
            target="_blank"
            class="btn btn-success"
            style="display:inline-block"
            >
            <i class="fas fa-file-pdf"></i> View PDF
            </a>
            <button class="btn btn-success" @click="saveChanges()">
                <i class="far fa-save"></i> Save Changes
            </button>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a
                    :class="'nav-item nav-link-'+app_color+' active'"
                    data-toggle="tab"
                    :href="'#student'"
                    role="tab"
                    aria-controls="info"
                    aria-selected="true"
                >Student PTR</a>
                <a
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
            :id="'student'"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
                <ol-ptr-content-student :pages="ptr.ptr.pages" :inputs="assessment"/>
            </div>
            <div
            :class="'tab-pane fade'"
            :id="'assessment'"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
                <ol-ptr-content-assessment :assessment="assessment" :student_type="student_type"/>
            </div>
        </div>
        
    </div>
</template>
<script>
import moment from 'moment'
export default {
    data(){
        return{
            app_color:app_color,
            assessment:this.$props.ptr.ptr.inputs,
             required:{
                auth_person_name:"Authorised Person's Name",
                auth_person_position:"Authorised Person's Position",
                auth_person_signature:"Authorised Person's Signature",
                auth_date:"Date",
            },
            errors:[],
            student_type:window.student_type,
            pdf_link:''
        }
    },
    props:['ptr','index'],
    created(){
        this.assessment.auth_date = moment(this.assessment.auth_date)._d;

        this.assessment.course_align_student = typeof this.assessment.course_align_student ==='undefined'?{yes:false,no:false}:{yes:this.assessment.course_align_student.yes,no:this.assessment.course_align_student.no};
        this.assessment.training_and_assessment_awareness = typeof this.assessment.training_and_assessment_awareness ==='undefined'?{yes:false,no:false}:{yes:this.assessment.training_and_assessment_awareness.yes,no:this.assessment.training_and_assessment_awareness.no};
        this.assessment.rights_and_obligation_awareness = typeof this.assessment.rights_and_obligation_awareness ==='undefined'?{yes:false,no:false}:{yes:this.assessment.rights_and_obligation_awareness.yes,no:this.assessment.rights_and_obligation_awareness.no};
        this.assessment.support_identified = typeof this.assessment.support_identified ==='undefined'?{yes:false,no:false}:{yes:this.assessment.support_identified.yes,no:this.assessment.support_identified.no};
        this.assessment.training_and_asses_strat = typeof this.assessment.training_and_asses_strat ==='undefined'?{yes:false,no:false}:{yes:this.assessment.training_and_asses_strat.yes,no:this.assessment.training_and_asses_strat.no};
        this.assessment.suitable_and_appropriate = typeof this.assessment.suitable_and_appropriate ==='undefined'?{yes:false,no:false}:{yes:this.assessment.suitable_and_appropriate.yes,no:this.assessment.suitable_and_appropriate.no};
        this.assessment.arrangment_awareness = typeof this.assessment.arrangment_awareness ==='undefined'?{yes:false,no:false}:{yes:this.assessment.arrangment_awareness.yes,no:this.assessment.arrangment_awareness.no};
        this.assessment.student_meets_requirements = typeof this.assessment.student_meets_requirements ==='undefined'?{yes:false,no:false}:{yes:this.assessment.student_meets_requirements.yes,no:this.assessment.student_meets_requirements.no};
        
        this.getpdflink();
    },
    methods:{
        getpdflink(){
            axios.get(`/pca/pre-training-review/getpdflink/${this.ptr.epack.process_id}/${this.ptr.epack.student_id}`).then(
                response=>{
                    this.pdf_link = response.data;
                }
            ).catch(
                err=>{
                    console.log(err)
                }
            );
        },
        saveChanges(){
            let dis = this;
            let validationChecker = [];
            let notAllowed = ['', null, undefined];

            for(let vr in dis.required){
                if(notAllowed.indexOf(dis.assessment[vr]) != -1){
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

            
            swal.fire({
                title: 'Please wait...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                swal.showLoading()
                },
            });

            axios.post('/pca/pre-training-review/save-intl/'+this.$props.ptr.epack.process_id,{ptr:this.ptr.ptr,student_type:this.student_type}).then(
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
    }
}
</script>

<style scoped>
    @import url('/public/fonts/brush-script-mt/brush script mt kursiv.ttf');

    .type-signature {
        font-family: 'Brush Script MT', cursive;
        font-size:30px;
    }
</style>