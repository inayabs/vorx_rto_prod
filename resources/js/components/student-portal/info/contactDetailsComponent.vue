<template>
<div>
    <div class="row mb-3">
        <div class="col-md-12 pull-right text-right">
            <button class="btn btn-success" @click="saveChanges()">
                <i class="far fa-save"></i> Save Changes
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
        <h6>Residential Address</h6>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right">
        <div class="row">
            <div class="col-md-6" v-if="student_type == 'International'">
                <div class="form-group">
                    <label for="current_address">Current Address</label>
                    <input type="text" class="form-control" v-model="contact.current_address" id="current_address" />
                </div>
            </div>
            <div class="col-md-6" v-if="student_type == 'International'">
                <div class="form-group">
                    <label for="home_address">Home Address</label>
                    <input type="text" class="form-control" v-model="contact.home_address" id="home_address" />
                </div>
            </div>
            <div class="col-md-4" v-if="student_type == 'Domestic'">
                <div class="form-group">
                    <label for="addr_flat_unit_detail">Unit</label>
                    <input type="text" class="form-control" v-model="contact.addr_flat_unit_detail" id="addr_flat_unit_detail" />
                </div>
            </div>
            <div class="col-md-4" v-if="student_type == 'Domestic'">
                <div class="form-group">
                    <label for="addr_building_property_name">Building Name</label>
                    <input type="text" class="form-control" v-model="contact.addr_building_property_name" id="addr_building_property_name" />
                </div>
            </div>
            <div class="col-md-4" v-if="student_type == 'Domestic'">
                <div class="form-group">
                    <label for="addr_street_num">Street Number</label>
                    <input type="text" class="form-control" v-model="contact.addr_street_num" id="addr_street_num" />
                </div>
            </div>
            <div class="col-md-6" v-if="student_type == 'Domestic'">
                <div class="form-group">
                    <label for="addr_street_name">Street Name</label>
                    <input type="text" class="form-control" v-model="contact.addr_street_name" id="addr_street_name" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">
                        Postcode - <span v-if="student_type == 'Domestic'">Suburb,</span> State
                    </label>
                    <multiselect 
                    v-model="contact.addr_suburb" 
                    :options="slct_postcode" 
                    :multiple="false"  
                    placeholder="Type to search" 
                    :close-on-select="true" 
                    track-by="id" label="value">
                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                    </multiselect>
                    <span v-if="errors.addr_suburb" :class="['badge badge-danger']">{{ errors.addr_suburb[0] }}</span>
                </div>
            </div>
            <div class="col-md-6" v-if="student_type == 'International'">
                <div :class="['form-group', errors.country_birth ? 'has-error' : '']">
                    <label for="country_birth">Country of Birth</label>
                    <multiselect 
                    v-model="contact.country_birth" 
                    :options="slct_country" 
                    :multiple="false" 
                    placeholder="Type to search" 
                    :close-on-select="true" 
                    track-by="id" 
                    label="value">
                        <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                    </multiselect>
                    <span v-if="errors.country_birth" :class="['badge badge-danger']">{{ errors.country_birth[0] }}</span>
                </div>
            </div>
            <div class="col-md-12" v-if="student_type == 'Domestic'">
                <div class="form-group">
                    <label for="addr_postal_delivery_box">Postal Delivery Box <span class="badge">( If different from above )</span></label>
                    <input type="text" class="form-control" v-model="contact.addr_postal_delivery_box" id="addr_postal_delivery_box" />
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
        <h6>Contact Details</h6>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right">
        <div class="row">
          <div class="col-md-6">
                <div class="form-group">
                    <label for="phone_home">Telephone Home No.</label>
                    <input type="number" class="form-control" v-model="contact.phone_home" id="phone_home" />
                </div>
            </div>
            <div class="col-md-6" v-if="student_type == 'Domestic'">
                <div class="form-group">
                    <label for="phone_work">Telephone Work No.</label>
                    <input type="number" class="form-control" v-model="contact.phone_work" id="phone_work" />
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label for="phone_mobile">Telephone Mobile No.</label>
                    <input type="number" class="form-control" v-model="contact.phone_mobile" id="phone_mobile" />
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" class="form-control" v-model="contact.email" id="email" />
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group" v-if="student_type == 'Domestic'" >
                    <label for="email_at">Second Email Address</label>
                    <input type="text" class="form-control" v-model="contact.email_at" id="email_at" />
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'" v-if="student_type == 'Domestic'">
        <h6>Emergency Contact Details</h6>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right" v-if="student_type == 'Domestic'">
        <div class="row">
          <div class="col-md-6">
                <div class="form-group">
                    <label for="emer_name">Name</label>
                    <input type="text" class="form-control" v-model="contact.emer_name" id="emer_name" />
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label for="emer_address">Address</label>
                    <input type="text" class="form-control" v-model="contact.emer_address" id="emer_address" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="emer_telephone">Telephone No.</label>
                    <input type="text" class="form-control" v-model="contact.emer_telephone" id="emer_telephone" />
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label for="emer_relationship">Relationship</label>
                    <input type="text" class="form-control" v-model="contact.emer_relationship" id="emer_relationship" />
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
export default {
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    },
    data() {
        return {
            app_color: app_color,
            student_id: window.student_id,
            student_type: window.student_type,
            csrfToken: "",
            // contact: window.contact,
            contact: {
              current_address: '',
              home_address: '',
              addr_flat_unit_detail: '',
              addr_building_property_name: '',
              addr_street_num: '',
              addr_street_name: '',
              addr_suburb: '',
              country_birth: '',
              addr_postal_delivery_box: '',
              phone_home: '',
              phone_work: '',
              phone_mobile: '',
              email: '',
              email_at: '',
              emer_name: '',
              emer_address: '',
              emer_telephone: '',
              emer_relationship: '',
            },
            slct_postcode: window.slct_postcode,
            slct_country: window.slct_country,
            slct_state: window.slct_state,
            errors: {}
        };
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            // @ dynamic form
            axios({
                    method: "get",
                    url: `/student-profile/contact-info`
                })
                .then(res => {
                  this.contact = res.data.contact_details;
                })
                .catch(err => console.log(err));
        },
        saveChanges() {
            const Toast = swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
            swal.fire({
                title: "Please wait...",
                // html: '',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading();
                },
            });
            console.log(this.contact);
            let data = {
                inputs: this.contact,
            }
            axios
                .post(`/student-profile/${window.student_id}/contact-update`, data)
                .then((res) => {
                    // console.log(res);
                    if (res.data.status == "updated") {
                        // console.log("success");
                        swal.fire({
                            title: "Updated Successfuly",
                            type: "success",
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    } else {
                        // console.log("error");
                        swal.fire({
                            title: "Opss.. was not saved successfully",
                            type: "error",
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        }
    }
};
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
