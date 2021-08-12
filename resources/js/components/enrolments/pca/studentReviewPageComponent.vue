<template>
    <div>
       <div class="app-modal">

        <div class="card border-0 shadow-lg ">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <img :src="logo_url" alt="profile" width="170px">
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold h4 m-0 float-right"> Enrolment Application Review</span>
                        <div class="clearfix"></div>
                        <span class="float-right" style="font-size:12px;">RTO No: {{ app_settings.training_organisation_id }} | CRICOS Code: 03871F</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div>
                    <div class="row px-4 pt-4">
                        <span class="font-weight-bold h5 m-0"> Payment Receipt  & Signature for <span :class="'text-'+this.app_color">{{student_name}}</span></span>
                        <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-md-12 '">
                            <h6>Please review the following List </h6>
                            </div>
                        <div class="col-md-12">
                             <label for=""> <a :href="`/offer-letter-and-acceptance-agreement/${process_id}`" target="_blank"> Offer Letter and Acceptance Agreement -view  <i class="fas fa-eye"> </i></a> </label>
                        </div>
                        <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-md-12 '">
                            <h6>Upload Attachments</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Attachments</label>
                                <p>Please Provide the Following:<br>
                                    <ul>
                                        <li>Initial Payment Receipt</li> 
                                    </ul>
                                </p>

                                <attachments v-if="app_settings.student_id_prefix != 'CEA'"
                                    :uploadURL="'/pca/online-enrolment/attachment/upload/'+process_id"
                                    :fetchURL="'/pca/online-enrolment/attachment/fetch/'+process_id"
                                    :deleteURL="'/pca/online-enrolment/attachment/delete/'"
                                    :previewURL="'/pca/online-enrolment/attachment/preview/'"
                                    :fileTypeValidate="['jpeg','jpg','png','pdf','docx','JPG']"
                                    :fileSizeValidate="5000000"
                                    :manualUpload='true'
                                    :renamefilenameURL="'/pca/online-enrolment/attachment/rename/'"
                                ></attachments>
                                <attachments v-else
                                    :uploadURL="'/online-enrolment/attachment/upload/'+process_id"
                                    :fetchURL="'/online-enrolment/attachment/fetch/'+process_id"
                                    :deleteURL="'/online-enrolment/attachment/delete/'"
                                    :previewURL="'/online-enrolment/attachment/preview/'"
                                    :fileTypeValidate="['jpeg','jpg','png','pdf','docx','JPG']"
                                    :fileSizeValidate="5000000"
                                    :manualUpload='true'
                                    :renamefilenameURL="'/pca/online-enrolment/attachment/rename/'"
                                ></attachments>
                            </div>
                        </div>
                        <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-md-12 '">
                            <!-- <h6>Pick one signature type to use</h6> -->
                            <h6>Applicant Signature</h6>
                        </div>
                        <div class="col-md-12">
                                <div class="form-group">
                                    <!-- <label for="">  -->
                                    <p class="text-justify"><input type="checkbox" v-model="sig_acceptance_agreement" class=""  style="width: 35px;height: 20px;"><span>Electronic Transactions (Queensland) Act 2001/Electronic Transactions (Victoria) Act 2000 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement.</span></p>
                                </div>
                            </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Type Signature</label>
                                <input type="text" class="form-control type-signature" v-model="type_signature">
                                <button class="btn btn-success float-right mt-3 mb-3" @click="save_form()">Submit</button>
                            </div>
                        </div>
                        <!-- <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Draw Signature</label>
                                <div v-if="signature != null" style="border:1px solid #000">
                                    <img :src="signature">
                                </div>
                                <div v-else style="border:1px solid #000; background-color:#deeaf6;">
                                    <VueSignaturePad
                                        id="signature"
                                        width="100%"
                                        height="250px"
                                        ref="signaturePad"
                                        :options="options"
                                    />
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <button v-if="signature != null" class="btn btn-secondary btn-lg float-left" @click="reset">Reset Signature</button>
                                <button v-else class="btn btn-secondary btn-lg float-left" @click="undo">Undo</button>
                                <button class="btn btn-success btn-lg float-left ml-3" @click="saveForm()">Save Draw Signature</button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
</template>
<script>
import Attachments from './../../globals/FileDragDropInstantComponent.vue';
import moment from 'moment';
export default {
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
    components: {
        Attachments
    },
    data () {
        return {
            app_color: app_color,
            tests : [],
            student_name: '',
            cur_page : 0,
            pages : {},
            inputs: [],
            errors: [],
            process_id: null,
            concession_docs: [],
            type_signature: '',
            sig_acceptance_agreement: false,
            signature: null,
            options: {
                penColor: "#000"
            },
            app_settings: window.app_settings,
            logo_url: window.logo_url,
        }
    },
    created() {
        this.student_name = typeof window.ef !== 'undefined' ? window.ef.student_name : null;
        this.process_id = typeof window.ef !== 'undefined' ? window.ef.process_id : null;
    },
    methods: {
        undo() {
            this.$refs.signaturePad.undoSignature();
        },
        save_form(){
            let toast = swal.fire({
                            position: "top-end",
                            title: "Please wait",
                            showConfirmButton: false,
                            onBeforeOpen: () => {
                                swal.showLoading();
                            },
                        });
            let data = {
                process_id : this.process_id,
                signature : this.type_signature
            }
            if(this.sig_acceptance_agreement == true && this.type_signature != ''){
                axios.post('/pca/enrolment-process',data).then(res=>{
                     
                        if(res.data.status ==  'success'){
                    // Toast.fire({
                    //           type: "success",
                    //           position: "top-end",
                    //           title: res.data.message,
                    //         });
                            swal.fire(
                                'Good job!',
                                'Agreement Processed!',
                                'success'
                            ).then(result=>{
                                if(result.isConfirmed){
                                    
                                         window.location.href= window.app_settings.site_url;
                                }else{
                                       window.location.href= window.app_settings.site_url;
                                }
                            })

                            //  this.$parent.$refs.studentList.refresh();
                            //  this.$parent.$modal.hide("size-verify-initial-payment");
                }else{
                    Toast.fire({
                              type: "error",
                              position: "top-end",
                              title: 'Something went wrong....',
                            });
                }
                    // console.log(res.data);
                
                }).catch(err=>{
                    console.log(err);
                })
            }else{
                 Toast.fire({
                              type: "error",
                              position: "top-end",
                              title: 'Please check the agreement and fill up signature....',
                            });
            }
            
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

    td.text-center{
        border-right-color: #fff !important;
        border-left-color: #fff !important;
        vertical-align: top !important;
    }
    td {
        border : 1px solid #bdbdbd !important;
    }
    .radio-control {
        margin-left:10px;
    }
</style>