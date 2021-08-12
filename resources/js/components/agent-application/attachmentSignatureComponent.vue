<template>
<div class="app-modal">

    <div class="card border-0 shadow-lg ">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <img :src="logo_url" v-if="app_settings.training_organisation_id == '6074'" alt="profile" width="170px" style="margin-top: -25px;"> <!-- CEA -->
                    <img :src="logo_url" v-else alt="profile" width="170px">
                </div>
                <div class="col-md-6">
                    <span class="font-weight-bold h4 m-0 float-right"> Representative/Education Agent</span>
                    <div class="clearfix"></div>
                    <span class="font-weight-bold h4 m-0 float-right">Application Form</span>
                    <div class="clearfix"></div>
                    <span class="float-right" style="font-size:12px;">RTO No: {{ app_settings.training_organisation_id }} | CRICOS Code: {{ app_settings.cricos_code }}</span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div>
                <!-- Nested Row within Card Body -->
                <div class="row px-4 pt-4">
                    <span class="font-weight-bold h5 m-0"> Attachment & Signature for <span :class="'text-'+this.app_color">{{agent_name}}</span></span>
                    <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-md-12 '">
                        <h6>Upload Attachments</h6>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <!-- <label for="">Attachments</label> -->
                            <!-- <p v-if="concession_docs">
                                    Please Provide the Following:<br>
                                    <ul>
                                        <li v-for="(cd, key) in concession_docs" :key="key">{{cd.value}}</li> 
                                    </ul>
                                </p> -->
                            <!-- mandatory docs -->
                            <div v-if="mandatoryList != null">
                                <b>Please Provide the Following:</b><br>
                                <ul class="mandatory-docs">
                                    <li v-for="(md, key) in mandatoryList" :key="key">
                                        <p class="text-justify"><input type="checkbox" v-model="mandatory_docs[md.slug_name]" class="" style="width: 35px;height: 20px;"><span>{{ md.document_name }}</span></p>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <attachments 
                        :uploadURL="'/agent-application/attachment/upload/'+process_id" 
                        :fetchURL="'/agent-application/attachment/fetch/'+process_id" 
                        :deleteURL="'/agent-application/attachment/delete/'" 
                        :previewURL="'/agent-application/attachment/preview/'" 
                        :fileTypeValidate="['jpeg','jpg','png','pdf','docx','JPG']" :fileSizeValidate="5000000" 
                        :manualUpload='true' 
                        :renamefilenameURL="'/agent-application/attachment/rename/'"></attachments>
                    </div>
                </div>
                <div class="row px-4 pt-4">
                
                    <div :class="'horizontal-line-wrapper-'+app_color+' mb-2 col-md-12 '">
                        <!-- <h6>Pick one signature type to use</h6> -->
                        <h6>Applicant Signature</h6>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <!-- <label for="">  -->
                            <p class="text-justify"><input type="checkbox" v-model="sig_acceptance_agreement" class="" style="width: 35px;height: 20px;"><span>Electronic Transactions (Queensland) Act 2001/Electronic Transactions (Victoria) Act 2000 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement.</span></p>
                        </div>
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
            </div>

            <!-- navigation -->
            <div class="row p-3">
                <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                    <button :class="'btn btn-'+app_color" @click="back()"><i class="fas fa-arrow-circle-left"></i> Agent Application Form</button>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                    <!-- <button class="btn btn-success" v-if="tests.lln != 0 && tests.ptr != 0 && signature != null" @click="finishForm()"><i class="far fa-save"></i> Finish Enrolment</button> -->

                    <button class="btn btn-success" @click="validateMandatoryDocs()" v-if="user == true"><i class="far fa-save"></i> Save Changes</button>
                    <button class="btn btn-success" @click="validateMandatoryDocs()" v-else><i class="far fa-save"></i> Finish Application Form</button>
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
    data() {
        return {
            app_color: app_color,
            // tests: [],
            agent_name: '',
            cur_page: 0,
            pages: {},
            inputs: [],
            errors: [],
            process_id: null,
            concession_docs: [],
            mandatory_docs: {},
            mandatoryList: [],
            type_signature: '',
            sig_acceptance_agreement: false,
            signature: null,
            options: {
                penColor: "#000"
            },
            app_settings: window.app_settings,
            logo_url: window.logo_url,
            attachments: [],
            user: window.user,
            // attachmentsCount: 0,
        }
    },

    created() {
        // console.log(this.user);
        this.process_id = typeof window.process_id !== 'undefined' ? window.process_id : null;
        this.signature = typeof window.signature !== 'undefined' ? window.signature : null;
        // this.tests = typeof window.tests !== 'undefined' ? window.tests : null;
        this.agent_name = typeof window.agent_name !== 'undefined' ? window.agent_name : null;
        // this.concession_docs = typeof window.concession_docs !== 'undefined' ? window.concession_docs : [];
        this.type_signature = typeof window.type_signature !== 'undefined' ? window.type_signature : [];
        this.sig_acceptance_agreement = window.sig_acceptance_agreement == 1 ? true : false;
        this.mandatoryList = typeof window.mandatoryList !== 'undefined' ? window.mandatoryList : [];
        this.mandatory_docs = typeof window.mandatory_docs !== 'undefined' && window.mandatory_docs != null ? window.mandatory_docs : {};
    },

    methods: {
        back() {
            window.location.href = '/agent-application/get/' + this.process_id;
        },
        undo() {
            this.$refs.signaturePad.undoSignature();
        },
        reset() {
            this.signature = null;
        },
        saveForm() {
            // alert('submitting form...');
            let vm = this;

            if (vm.signature != null) {
                swal.fire(
                    'Good job!',
                    'Save Signature!',
                    'success'
                )
            }

            const {
                isEmpty,
                data
            } = this.$refs.signaturePad.saveSignature();

            // console.log(isEmpty);
            // console.log(data);

            if (isEmpty == true) {
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

                    axios.post('/agent-application/save-signature/' + process_id, {
                            process_id: vm.process_id,
                            signature: data
                        })
                        .then(function (res) {
                            // console.log(res.data);
                            if (res.data.status == 'success') {
                                // window.location.href = '/agent-application/process/'+res.data.process;
                                swal.fire(
                                    'Good job!',
                                    'Signature Saved!',
                                    'success'
                                )
                                vm.signature = data;
                            }
                        })
                        .catch(function (err) {
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

        validateMandatoryDocs() {
            // console.log(this.$parent.$children[0].$children[0].files);
            let vm = this;
            let x = 0;
            vm.attachments = this.$parent.$children[0].$children[0].files;
            //console.log(vm.attachments);
            if (vm.attachments.length >= 1) {
                vm.mandatoryList.forEach(element => {
                    // if(element.slug_name == 'company_profile'){
                    //      console.log(vm.mandatory_docs[element.slug_name]);
                    // }
                    // typeof vm.mandatory_docs[element.slug_name] === 'undefined' || vm.mandatory_docs[element.slug_name] == false
                    if (typeof vm.mandatory_docs[element.slug_name] === 'undefined') {
                        //  console.log('yowo');
                        x = 0;
                        swal.fire(
                            'Oppss!',
                            'Please check and attach all mandatory documents.',
                            'error'
                        )
                        return false;
                    } else {
                        x = 1;
                    }
                });
                // console.log(x);
                if (x == 1) {
                    vm.finishForm();
                }
            } else {
                swal.fire(
                    'Oppss!',
                    'Please check and attach all mandatory documents.',
                    'error'
                )
            }
        },
        finishForm() {
            // console.log('sulod');
            let vm = this;
            // console.log(vm.signature);
            let signValidation = ['', null];
            let type_s = signValidation.indexOf(vm.type_signature);
            let draw_s = signValidation.indexOf(vm.signature);
            if (draw_s != -1 && type_s != -1) {
                swal.fire(
                    'Oppss!',
                    'Please Type Signature.',
                    'error'
                )
                return false;
            }

            swal.fire({
                title: vm.user == true ? 'Save Changes?' : 'Finish Form?',
                // text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    swal.fire({
                        title: vm.user == true ? 'Saving Changes' : 'Completing Process...',
                        // html: '',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            swal.showLoading()
                        },
                    });
                    // console.log(vm.mandatory_docs);
                    // console.log(this.mandatory_docs);
                    axios.post('/agent-application/finish/' + process_id, {
                            process_id: vm.process_id,
                            type_signature: vm.type_signature,
                            signature: vm.signature,
                            sig_acceptance_agreement: vm.sig_acceptance_agreement,
                            process: 'completion_process',
                            mandatory_docs: vm.mandatory_docs
                        })
                        .then(function (res) {
                            if (res.data.status == 'success') {
                                // window.location.href = '/agent-application/process/'+res.data.process;
                                // swal.fire(
                                //     'Good job!',
                                //     'Your Enrolment form will be verified by our stuff!',
                                //     'success'
                                // )
                                // setTimeout(function() {
                                swal.fire({
                                        title: vm.user == true ? 'Changes saved successfully!' : "Good job!",
                                        text: vm.user == true ? ' ' : "Your Application form was submitted successfully.",
                                        type: "success",
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes!'
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.replace(res.data.site);
                                            // window.close();   
                                        }else{
                                            window.location.replace(res.data.site);
                                        }
                                    });
                                    
                                // }, 1000);
                                // vm.signature = data;
                            } else {
                                // console.log(res);
                                swal.fire(
                                    'Oppss!',
                                    res.data.msg,
                                    'error'
                                )
                            }
                        })
                        .catch(function (err) {
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
        dateFormatter: function (date) {
            console.log(date);
        },
        table_class_addons: function (body, key) {
            let string = 'pt-2 align-top ';

            if (typeof body.text_type !== 'undefined' && typeof body.text_type[key] !== 'undefined') {
                string += body.text_type[key];
                string += ' ';
            }

            if (typeof body.background_color !== 'undefined' && typeof body.background_color[key] !== 'undefined') {
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
    font-size: 30px;
}

td.text-center {
    border-right-color: #fff !important;
    border-left-color: #fff !important;
    vertical-align: top !important;
}

td {
    border: 1px solid #bdbdbd !important;
}

.radio-control {
    margin-left: 10px;
}

ul.mandatory-docs {
    padding-left: 0;
}

ul.mandatory-docs li {
    list-style: none;
}

ul.mandatory-docs li p {
    margin-bottom: 0;
}

ul.mandatory-docs li p span {
    position: relative;
    top: -2px;
}
</style>
