<template>
    <form @submit.prevent>
        <div>
            <div class="row mb-3">
                <div class="col-md-12 pull-right text-right">
                    <button v-if="setup == 1" class="btn btn-primary" @click="saveTrainingOrg">Training Delivery Location <i class="fas fa-angle-right ml-1"></i></button>
                    <button v-else class="btn btn-success" @click="saveTrainingOrg"><i class="far fa-save"></i> Save Changes</button>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>Organisation Details</h6>
            </div>
            <div class="form-padding-left-right">
                <div class="row">
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.training_organisation_id ? 'has-error' : '']" >
                            <label for="training_organisation_id">Organisation Identifier <a data-toggle="tooltip" data-placement="right" title="USI required!"><i class="fas fa-info-circle"></i></a></label>
                            <input 
                                id="training_organisation_id" 
                                name="training_organisation_id" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="number" 
                                v-model="organisation.training_organisation_id">
                            <span v-if="errors.training_organisation_id" :class="['badge badge-danger']">{{ errors.training_organisation_id[0] }}</span>
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.cricos_code ? 'has-error' : '']" >
                            <label for="cricos_code">Cricos Code</label>
                            <input 
                                id="cricos_code" 
                                name="cricos_code" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="number" 
                                v-model="organisation.cricos_code">
                            <span v-if="errors.cricos_code" :class="['badge badge-danger']">{{ errors.training_organisation_id[0] }}</span>
                            
                        </div>
                    </div>
                    <!-- <div class="col-lg-6">
                        <div :class="['form-group', errors.avetmiss_organisation_id ? 'has-error' : '']" >
                            <label for="avetmiss_organisation_id">Avetmiss Organisation Identifier <a data-toggle="tooltip" data-placement="right" title="Leave blank if the same with Organisation Identifier."><i class="fas fa-info-circle"></i></a></label>
                            <input 
                                id="avetmiss_organisation_id" 
                                name="avetmiss_organisation_id" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="number" 
                                v-model="organisation.avetmiss_organisation_id">
                            <span v-if="errors.avetmiss_organisation_id" :class="['badge badge-danger']">{{ errors.training_organisation_id[0] }}</span>
                            
                        </div>
                    </div> -->
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.training_organisation_name ? 'has-error' : '']" >
                            <label for="training_organisation_name">Organisation Name <a data-toggle="tooltip" data-placement="right" title="Avetmiss required!"><i class="fas fa-info-circle"></i></a></label>
                            <input 
                                id="training_organisation_name" 
                                name="training_organisation_name" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="text" 
                                v-model="organisation.training_organisation_name">
                            <span v-if="errors.training_organisation_name" :class="['badge badge-danger']">{{ errors.training_organisation_name[0] }}</span>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6">
                        <div :class="['form-group', errors.training_organisation_name ? 'has-error' : '']" >
                            <label for="training_organisation_name">Organisation Type</label>
                            <multiselect 
                                v-model="organisation.org_type" 
                                tag-placeholder="Add this as new tag" 
                                placeholder="Search or add a tag" 
                                label="description" 
                                track-by="value" 
                                :options="organisation.organisation_type" 
                                :multiple="false" 
                                :taggable="true" 
                                @tag="addTag">
                            </multiselect>
                        </div>
                    </div> -->
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.addr_line1 ? 'has-error' : '']" >
                            <label for="addr_line1">Address Line </label>
                            <input 
                                id="addr_line1" 
                                name="addr_line1" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="text" 
                                v-model="organisation.addr_line1">
                            <span v-if="errors.addr_line1" :class="['badge badge-danger']">{{ errors.addr_line1[0] }}</span>
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.addr_location ? 'has-error' : '']" >
                            <label for="addr_location">Suburb, State Postcode </label>
                            <multiselect 
                                v-model="organisation.addr_location"
                                tag-placeholder="Add this as new tag" 
                                placeholder="Search suburb" 
                                label="postcode_name" 
                                track-by="id" 
                                :options="slct_postcode" 
                                :multiple="false" 
                                :taggable="false" 
                                @tag="addTag">
                            </multiselect>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.contact_name ? 'has-error' : '']" >
                            <label for="contact_name">Contact Name</label>
                            <input 
                                id="contact_name" 
                                name="contact_name" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="text" 
                                v-model="organisation.contact_name">
                            <span v-if="errors.contact_name" :class="['badge badge-danger']">{{ errors.contact_name[0] }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.telephone_number ? 'has-error' : '']" >
                            <label for="telephone_number">Telephone Number</label>
                            <input 
                                id="telephone_number" 
                                name="telephone_number" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="number" 
                                v-model="organisation.telephone_number">
                            <span v-if="errors.telephone_number" :class="['badge badge-danger']">{{ errors.telephone_number[0] }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.facsimile_number ? 'has-error' : '']" >
                            <label for="facsimile_number">Facsimile Number</label>
                            <input 
                                id="facsimile_number" 
                                name="facsimile_number" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="number" 
                                v-model="organisation.facsimile_number">
                            <span v-if="errors.facsimile_number" :class="['badge badge-danger']">{{ errors.facsimile_number[0] }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.email_address ? 'has-error' : '']" >
                            <label for="email_address">Email Address</label>
                            <input 
                                id="email_address" 
                                name="email_address" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="text" 
                                v-model="organisation.email_address">
                            <span v-if="errors.email_address" :class="['badge badge-danger']">{{ errors.email_address[0] }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.org_type_identifier ? 'has-error' : '']" >
                            <label for="org_type_identifier">Organisation Type</label>
                            <select v-model="organisation.org_type_identifier" class="form-control">
                                <option v-for="(i,k) in org_types" :key="k" :value="i.value">{{i.description}}</option>
                            </select>
                            <span v-if="errors.org_type_identifier" :class="['badge badge-danger']">{{ errors.org_type_identifier[0] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                <h6>App Settings <a @click="reloadPage()" class="reload"><i class="fas fa-sync-alt"></i> Reload Page</a></h6>
            </div>
            <div class="form-padding-left-right">
                <div class="row">
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.student_id_prefix ? 'has-error' : '']" >
                            <label for="student_id_prefix">Student ID Prefix <span class="note">(up to 3 alphabets only.)</span></label>
                            <input 
                                id="student_id_prefix" 
                                name="student_id_prefix" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="input"
                                @keydown="studIDPrefix" 
                                v-model="organisation.student_id_prefix">
                            <span v-if="errors.student_id_prefix" :class="['badge badge-danger']">{{ errors.student_id_prefix[0] }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.app_color ? 'has-error' : '']" >
                            <label for="app_color">App Color</label>
                            <select class="form-control" v-model="organisation.app_color" id="">
                                <option value="primary">Primary</option>
                                <option value="secondary">Secondary</option>
                                <option value="info">Info</option>
                                <option value="success">Success</option>
                                <option value="danger">Danger</option>
                                <option value="warning">Warning</option>
                                <option value="blue">Blue</option>
                                <option value="indigo">Indigo</option>
                                <option value="purple">Purple</option>
                                <option value="pink">Pink</option>
                                <option value="red">Red</option>
                                <option value="orange">Orange</option>
                                <option value="yellow">Yellow</option>
                                <option value="green">Green</option>
                                <option value="teal">Teal</option>
                                <option value="cyan">Cyan</option>
                                <option value="white">White</option>
                                <option value="gray">Gray</option>
                                <option value="gray-dark">Gray-Dark</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.person_incharge ? 'has-error' : '']" >
                            <label for="person_incharge">Person In-Charge <span class="note">(used for qualification.)</span></label>
                            <input 
                                id="person_incharge" 
                                name="person_incharge" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="input"
                                v-model="organisation.person_incharge">
                            <span v-if="errors.person_incharge" :class="['badge badge-danger']">{{ errors.person_incharge[0] }}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.incharge_position ? 'has-error' : '']" >
                            <label for="incharge_position">Position <span class="note">(used for qualification.)</span></label>
                            <input 
                                id="incharge_position" 
                                name="incharge_position" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="input"
                                v-model="organisation.incharge_position">
                            <span v-if="errors.incharge_position" :class="['badge badge-danger']">{{ errors.incharge_position[0] }}</span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.logo_img ? 'has-error' : '']" v-if="org_logo == ''">
                            <label for="logo_img">Organisation Logo</label>
                            <input 
                                id="logo_img" 
                                name="logo_img" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="file"
                                @change="uploadOrgLogo"
                                >
                            <span v-if="errors.logo_img" :class="['badge badge-danger']">{{ errors.logo_img[0] }}</span>
                        </div>
                        <div v-else class="form-group">
                            <label for="logo_img">Organisation Logo</label>
                            <div class="card card_logo">
                                <div class="close">
                                    <a class="text-danger" @click="deleteOrgLogo()"><i class="fas fa-times"></i></a>
                                </div>
                                <img class="org_logo" v-bind:src="'/storage/config/images/'+org_logo" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div :class="['form-group', errors.sig_img ? 'has-error' : '']" v-if="signature == ''">
                            <label for="sig_img">Signature Image</label>
                            <input 
                                id="sig_img" 
                                name="logo_img" 
                                value=""  
                                autofocus="autofocus" 
                                class="form-control" 
                                type="file"
                                @change="uploadSignature"
                                >
                            <span v-if="errors.sig_img" :class="['badge badge-danger']">{{ errors.sig_img[0] }}</span>
                        </div>
                        <div v-else class="form-group">
                            <label for="sig_img">Signature Image</label>
                            <div class="card card_logo">
                                <div class="close">
                                    <a class="text-danger" @click="deleteSignature()"><i class="fas fa-times"></i></a>
                                </div>
                                <img class="org_logo" v-bind:src="'/storage/config/images/'+signature" alt="">
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
    </form>
</template>
<script>
export default {
    data(){
        return{
            setup: window.setup ? 1 : null,
            organisation: {
                training_organisation_id: '',
                avetmiss_organisation_id: '',
                training_organisation_name: '',
                addr_line1: '',
                addr_location: '',
                contact_name: '',
                telephone_number: '',
                facsimile_number: '',
                email_address: '', 
            },
            slct_postcode: window.slct_postcode,
            'org_logo': '',
            'signature': '',
            app_color: app_color,
            org_types: window.organisation_types,
            organisation_id : window.organisation_id,
            csrf: '',
            errors: [],
            success : false  
        };
    },
    created(){
        this.fetchTrainingOrg();
    },
    methods:{
        reloadPage() {
            location.reload();
        },
        studIDPrefix(event) {
            const char = String.fromCharCode(event.keyCode)
            
            if (!/[0-9]/.test(char)) {
                // console.log(event.target.value.toUpperCase());
                // return event.target.value.toUpperCase();
            }else{
                event.preventDefault()
            }
        },
        uploadImage(vm, image, type) {
            let acceptedFiles = ['png','jpeg','jpg'];
            let loading = swal.fire({
                title: 'Uploading '+type,
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading()
                },
            });
            if(acceptedFiles.indexOf(image.name.split('.').pop()) != -1){
                // upload logo
                let formData = new FormData();
                formData.append('image', image);
                formData.append('organisation_id', vm.organisation_id);
                formData.append('type', type);

                axios.post('/organisation/upload-logo', formData )
                .then(function (res) {
                    // console.log(res);
                    if(res.data.status == 'success'){
                        swal.fire({
                            type: 'success', title: type+' updated. Reload page to see changes',
                        });
                        if(type == 'Logo'){
                            vm.org_logo = res.data.image;
                        }else{
                            vm.signature = res.data.image;
                        }
                    }else{
                        swal.fire({
                            type: 'error', title: 'Error detected. Please contact support team',
                        });
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    loading.close();
                });
            }else{
                loading.close();
            }
        },
        uploadOrgLogo(e) {
            let vm = this;
            let image = e.target.files[0];
            let type = 'Logo';
            this.uploadImage(vm, image, type);
        },
        deleteImage(type) {
            let vm = this;
            swal.fire({
                title: 'Delete logo?',
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
                        url: `/organisation/delete-logo/${this.organisation_id}/${type}`
                    })
                    .then(res => {
                        if(res.data.status == 'success'){
                            swal.fire(
                                'Deleted!',
                                type+' has been deleted. Reload page to see changes',
                                'success'
                            )
                            if(type == 'Logo'){
                                vm.org_logo = '';
                            }else{
                                vm.signature = '';
                            }
                        }
                    })
                    .catch(err => console.log(err));

                    
                }
            })
        },
        deleteOrgLogo() {
            this.deleteImage('Logo');
        },
        uploadSignature(e) {
            let vm = this;
            let image = e.target.files[0];
            let type = 'Signature';
            this.uploadImage(vm, image, type);
        },
        deleteSignature() {
            this.deleteImage('Signature');
        },
        fetchTrainingOrg(){
            axios({
                method: 'get',
                url: `/organisation/show/${this.organisation_id}`
            })
            .then(res => {
                this.organisation = res.data.organisation;
                this.organisation.addr_location = res.data.postcode_val;
                this.org_logo = ['',null].indexOf(res.data.organisation.logo_img) == -1 ? res.data.organisation.logo_img : '';
                this.signature = ['',null].indexOf(res.data.organisation.incharge_signature) == -1 ? res.data.organisation.incharge_signature : '';
            })
            .catch(err => console.log(err));
        },
        saveTrainingOrg() {
            swal.fire({
                title: 'Please wait...',
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                swal.showLoading()
                },
            });
             axios.post('/organisation/show/update/'+organisation_id,{
                    training_organisation_id: this.organisation.training_organisation_id,
                    training_organisation_name: this.organisation.training_organisation_name,
                    avetmiss_organisation_id: this.organisation.avetmiss_organisation_id,
                    addr_line1: this.organisation.addr_line1,
                    addr_location: this.organisation.addr_location,
                    contact_name: this.organisation.contact_name,
                    telephone_number: this.organisation.telephone_number,
                    facsimile_number: this.organisation.facsimile_number,
                    email_address: this.organisation.email_address,
                    person_incharge: this.organisation.person_incharge,
                    incharge_position: this.organisation.incharge_position,
                    student_id_prefix: this.organisation.student_id_prefix,
                    org_type_identifier: this.organisation.org_type_identifier,
                    app_color: this.organisation.app_color,
                    _token: this.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'updated'){
                        this.$parent.$children[1].training_dlvr_location.training_organisation_id = this.organisation.training_organisation_id;
                        
                        this.errors = [];

                        if(this.setup == 1) {
                            document.getElementById("nav-organization-tab").classList.add('disabled')
                            document.getElementById("nav-location-tab").classList.remove('disabled')
                            // this.$parent.$children[1].formOpen();
                            $('a[href="#nav-location"]').tab('show')
                            swal.close();
                        }else{
                            Toast.fire({
                                type: 'success', title: 'Data is updated successfully', position: 'top-end'
                            });
                        }

                    }else{
                        Toast.fire({
                            type: 'error', title: 'Oops... something went wrong', position: 'top-end'
                        });
                        if(typeof res.data.errors !== 'undefined'){
                            this.errors = res.data.errors;
                        }
                    }
                })
                .catch(err => console.log(err));
        },
        addTag(newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.slct_postcode.push(tag)
            this.training_dlvr_location.postcode.push(tag)
            // this.slct_state_identifier.push(tag)
            // this.training_dlvr_location.state_id.push(tag)
            this.slct_suburb.push(tag)
            this.slct_country_identifier.push(tag)
            this.training_dlvr_location.country_id.push(tag)
                // this.options.push(tag)
                // this.value.push(tag)
        }
    }
}
</script>


<style scoped>
    .note {
        font-style: italic !important;
        font-size: 10px !important;
    }
    .card_logo {
        background-color: #d2d2d2;
    }
    .org_logo {
        width: 200px !important;
        margin: 0 auto;
    }
    .close{
        position: absolute;
        width: 100%;
        text-align: right;
    }
    .reload {
        font-style: italic !important;
        font-size: 10px !important;
        text-decoration: underline;
        color: #fff;
        cursor: pointer;
    }
</style>