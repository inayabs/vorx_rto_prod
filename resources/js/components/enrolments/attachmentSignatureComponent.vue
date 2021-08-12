<template>
    <div class="app-modal">

        <div class="card border-0 shadow-lg ">
            <div class="card-header">
                <span class="font-weight-bold h5"> Attachment & Signature for <span :class="'text-'+this.app_color">{{student_name}}</span></span>
            </div>
            <div class="card-body p-0">
                <div>
                    <!-- Nested Row within Card Body -->
                    <!-- <div class="row px-4 pt-4">
                        <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-md-12 '">
                            <h6>LLN & PTR Tests</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button class="btn btn-lg btn-primary float-left" v-if="tests.lln == 0" @click="lln(process_id)"><i class="fas fa-pencil-alt"></i>  LLN Test</button>
                                    <button class="btn btn-lg btn-success float-left" v-else><i class="fa fa-check" aria-hidden="true"></i> LLN Test Done</button>
                                
                                    <button class="btn btn-lg btn-primary float-left ml-3" v-if="tests.ptr == 0" @click="ptr(process_id)"><i class="fas fa-pencil-alt"></i>  PTR Test</button>
                                    <button class="btn btn-lg btn-success float-left ml-3" v-else><i class="fa fa-check" aria-hidden="true"></i> LLN Test Done</button>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="row px-4 pt-4">
                        <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-md-12 '">
                            <h6>Upload Attachments</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Attachments</label>
                                <p v-if="concession_docs">
                                    Please Provide the Following:<br>
                                    <ul>
                                        <li v-for="(cd, key) in concession_docs" :key="key">{{cd.value}}</li> 
                                    </ul>
                                </p>
                                <attachments
                                    :uploadURL="'/online-enrolment/attachment/upload/'+process_id"
                                    :fetchURL="'/online-enrolment/attachment/fetch/'+process_id"
                                    :deleteURL="'/online-enrolment/attachment/delete'"
                                    :previewURL="'/online-enrolment/attachment/preview/'"
                                    :fileTypeValidate="['jpeg','jpg','png','pdf','docx','JPG']"
                                    :fileSizeValidate="10000000"
                                    :manualUpload='true'
                                    :renamefilenameURL="'/online-enrolment/attachment/rename/'"
                                ></attachments>
                            </div>
                        </div>
                        <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-md-12 '">
                            <!-- <h6>Pick one signature type to use</h6> -->
                            <h6>Applicant Signature</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Type Signature</label>
                                <input type="text" class="form-control type-signature" v-model="type_signature">
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

                    <!-- navigation -->
                    <div class="row p-3">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                            <button class="btn btn-primary" @click="back()"><i class="fas fa-arrow-circle-left"></i> Enrolment Form</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                            <!-- <button class="btn btn-success" v-if="tests.lln != 0 && tests.ptr != 0 && signature != null" @click="finishForm()"><i class="far fa-save"></i> Finish Enrolment</button> -->
                            <button class="btn btn-success" @click="finishForm()"><i class="far fa-save"></i> Finish Enrolment</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Attachments from './../globals/FileDragDropInstantComponent.vue';
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
            student_type: '',
            cur_page : 0,
            pages : {},
            inputs: [],
            errors: [],
            process_id: null,
            concession_docs: [],
            type_signature: '',
            signature: null,
            options: {
                penColor: "#000"
            },
        }
    },
    created() {
        this.process_id = typeof window.process_id !== 'undefined' ? window.process_id : null;
        this.signature = typeof window.signature !== 'undefined' ? window.signature : null;
        this.tests = typeof window.tests !== 'undefined' ? window.tests : null;
        this.student_name = typeof window.student_name !== 'undefined' ? window.student_name : null;
        this.student_type = typeof window.student_type !== 'undefined' ? window.student_type : null;
        this.concession_docs = typeof window.concession_docs !== 'undefined' ? window.concession_docs : [];
        this.type_signature = typeof window.type_signature !== 'undefined' ? window.type_signature : [];
        // console.log(typeof window.concession_docs);
    },
    methods: {
        back() {
            if(this.student_type == 1){
                window.location.href = '/international/online-enrolment/get/'+this.process_id;
            }else{
                window.location.href = '/online-enrolment/get/'+this.process_id;
            }
        },
        undo() {
            this.$refs.signaturePad.undoSignature();
        },
        reset() {
            this.signature = null;
        },
        lln(process_id) {
            // alert(process_id);
            let vm = this;
            swal.fire({
            title: 'Start LLN Test?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Start Test!'
            }).then((result) => {
            if (result.value) {
                swal.fire({
                    title: 'proceed to LLN Test...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });
                window.location.href = '/lln-test/process/'+vm.process_id;
            }
            })
            
        },
        ptr(process_id) {
            // alert(process_id);
            let vm = this;
            swal.fire({
            title: 'Start PTR Test?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Start Test!'
            }).then((result) => {
            if (result.value) {
                swal.fire({
                    title: 'proceed to PTR Test...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });
                window.location.href = '/ptr/process/'+vm.process_id;
            }
            })
            
        },
        saveForm() {
            // alert('submitting form...');
            let vm = this;

            if(vm.signature != null){
                swal.fire(
                    'Good job!',
                    'Save Signature!',
                    'success'
                )
            }

            const { isEmpty, data } = this.$refs.signaturePad.saveSignature();

            // console.log(isEmpty);
            // console.log(data);

            if(isEmpty == true){
                swal.fire(
                    'Opss!',
                    'No signature found!',
                    'error'
                )
                return false;
            }

            swal.fire({
            title: 'Save Signature?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
            }).then((result) => {
            if (result.value) {

                swal.fire({
                    title: 'Saving Signature...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });
                let link = vm.student_type == 1 ? '/international/online-enrolment/save-signature/'+process_id : '/online-enrolment/save-signature/'+process_id;
                axios.post(link,{
                    process_id: vm.process_id,
                    signature: data
                })
                .then(function(res){
                    // console.log(res.data);
                    if(res.data.status == 'success'){
                        // window.location.href = '/online-enrolment/process/'+res.data.process;
                        swal.fire(
                            'Good job!',
                            'Signature Saved!',
                            'success'
                        )
                        vm.signature = data;
                    }
                })
                .catch(function (err){
                    // console.log(err);
                    swal.fire(
                        'Oppss!',
                        'there seems to be a problem!',
                        'error'
                    )
                })
                
            }
            })

        },
        finishForm() {

            let vm = this;
            // console.log(vm.signature);
            let signValidation = ['', null];
            let type_s = signValidation.indexOf(vm.type_signature);
            let draw_s = signValidation.indexOf(vm.signature);
            if(draw_s != -1 && type_s != -1){
                swal.fire(
                    'Oppss!',
                    'Please Type Signature.',
                    'error'
                )
                return false;
            }

            swal.fire({
            title: 'Finish Enrolment?',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.value) {

                swal.fire({
                    title: 'Completing Process...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading()
                    },
                });
                let link = vm.student_type == 1 ? '/international/online-enrolment/finish/'+process_id : '/online-enrolment/finish/'+process_id;
                axios.post(link,{
                    process_id: vm.process_id,
                    type_signature: vm.type_signature,
                    signature: vm.signature,
                    process: 'completion_process'
                })
                .then(function(res){
                    // console.log(res.data);
                    if(res.data.status == 'success'){
                        // window.location.href = '/online-enrolment/process/'+res.data.process;
                        // swal.fire(
                        //     'Good job!',
                        //     'Your Enrolment form will be verified by our stuff!',
                        //     'success'
                        // )
                        // setTimeout(function() {
                            swal.fire({
                                title: "Good job!",
                                text: "Your Enrolment form will be verified by our staff!",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes!'
                            }).then((result) => {
                                if (result.value) {
                                    window.location.replace(res.data.site);
                                }
                            });
                        // }, 1000);
                        // vm.signature = data;
                    }else{
                        swal.fire(
                            'Oppss!',
                            res.data.msg,
                            'error'
                        )
                    }
                })
                .catch(function (err){
                    console.log(err);
                })
                
            }
            })
        }
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
        dateFormatter: function(date) {
            console.log(date);
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
            console.log(string);
            return string;
        }
    },
    watch: {

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
