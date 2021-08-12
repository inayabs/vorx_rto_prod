<template>
    <div class="card-body" v-if="ptr!=null">
        <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
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
                    :href="'#student-'+index"
                    role="tab"
                    aria-controls="info"
                    aria-selected="true"
                >Student PTR</a>
                <a
                    :class="'nav-item nav-link-'+app_color"
                    data-toggle="tab"
                    :href="'#assessment-'+index"
                    role="tab"
                    aria-controls="info"
                    aria-selected="true"
                >Assessment</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div
            :class="'tab-pane fade show active'"
            :id="'student-'+index"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
                <ptr-student :index="index"/>
            </div>
            <div
            :class="'tab-pane fade'"
            :id="'assessment-'+index"
            role="tabpanel"
            aria-labelledby="nav-info-tab"
            >
                <ptr-admin :index="index"/>
            </div>
        </div>
        
    </div>
    <div v-else>
        No PTR found
    </div>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
import ptrAdmin from './ptrAdminComponent.vue';
import ptrStudent from './ptrStudentComponent.vue';

export default {
    components:{
        ptrAdmin,ptrStudent
    },
    data(){
        return{
            app_color:app_color,
            pdf_link:'',
            student_id:window.student_id,
            errors:[]
        }
    },
    props:['index'],
    computed:{
        ptr(){
            return this.$store.getters.enrolment[this.index].ptr
        }                
    },
    created(){
        this.getpdflink();
    },
    methods:{
        ...mapMutations(['updateEnrolment']),
        getpdflink(){
            axios.get(`/pca/pre-training-review/getpdflink/${this.$store.getters.enrolment[this.$props.index].process_id}/${this.student_id}`).then(
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
            
            axios.post('/pca/pre-training-review/save-intl/'+this.$store.getters.enrolment[this.index].process_id,{ptr:this.ptr,student_type:this.$store.getters.enrolment[this.index].student_type}).then(
                response=>{
                    if(response.data.status=='success'){
                       swal.fire(
                            'Saved!',
                            'Data saved successfully.',
                            'success'
                        )
                        // this.$emit('ptrUpdate');
                        this.updateEnrolment(response.data.enrolment_pack);
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
                    title: 'Something went wrongz.',
                    text:err
                   });
                }
            );
        }
    }
}
</script>