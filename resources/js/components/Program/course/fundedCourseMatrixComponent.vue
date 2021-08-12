<template>
    <div>
        <button class="btn btn-success btn-sm d-table ml-auto" @click="addBlock"><i class="fas fa-plus"></i> Add</button>
        <div class="accordion mt-3" id="accordionMatrix">
            <div class="card card-default position-relative" v-for="(field, index) in fields" v-bind:id="'card-' + (index+1)">
                <div class="card-header position-relative" v-bind:id="'heading-' + (index+1)">
                    <a class="collapse-link" data-toggle="collapse" v-bind:data-target="'#collapse-' + (index+1)" aria-expanded="true" v-bind:aria-controls="'collapse-' + (index+1)">
                        <h5 class="m-0">{{course_code}} - {{course_name}} {{ field.location }}</h5>
                    </a>
                    <div class="btn-group-vertical btn-options">
                        <button  @click.prevent="saveBlock(index);"  class="opt-btn" title="Save"><i class="fas fa-save"></i></button>
                        <a href="javascript:void(0)" class="opt-btn"  v-on:click="removeBlock(index);"  title="Remove"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
                <div class="collapse show" v-bind:id="'collapse-' + (index+1)" v-bind:aria-labelledby="'heading-' + (index+1)" data-parent="#accordionMatrix">
                    <div class="card-body">
                        <input type="hidden" v-model="field.course_code">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="wk_duration_package">Location:</label>
                                    <select name="location" id="location" class="form-control" v-model="field.location" :class="[errors[index] && errors[index].location ? 'border-danger' : '']">
                                        <option
                                            v-for="(opt, optKy) in slct_option_state"
                                            v-bind:key="optKy"
                                            v-bind:value="optKy"
                                        >{{opt}} ({{optKy}})</option>
                                    </select>
                                    <div v-if="errors[index] && errors[index].location" class="badge badge-danger">{{ errors[index].location[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="material_fees">Concessional Fee:</label>
                                    <input type="number" min="0" class="form-control" name="concessional_fee" id="concessional_fee" v-model="field.concessional_fee" placeholder="N/A">
                                    <div v-if="errors[index] && errors[index].concessional_fee" class="badge badge-danger">{{ errors[index].concessional_fee[0]  }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="enrolment_fee">Non-concessional Fees:</label>
                                    <input type="number" min="0" class="form-control" name="non_concessional_fee" id="non_concessional_fee" v-model="field.non_concessional_fee" placeholder="N/A">
                                    <div v-if="errors[index] && errors[index].non_concessional_fee" class="badge badge-danger">{{ errors[index].non_concessional_fee[0]  }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="full_fee">Full Fee:</label>
                                    <input type="number" min="0" class="form-control" name="full_fee" id="full_fee" v-model="field.full_fee" placeholder="N/A">
                                    <div v-if="errors[index] && errors[index].full_fee" class="badge badge-danger">{{ errors[index].full_fee[0]  }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="enrolment_fee">Minimum Payment:</label>
                                    <input type="number" min="0" class="form-control" name="min_payment" id="min_payment" v-model="field.min_payment" placeholder="N/A">
                                    <div v-if="errors[index] && errors[index].min_payment" class="badge badge-danger">{{ errors[index].min_payment[0]  }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'course-matrix',
        data() {
            return {
                course_code: window.course_code,
                course_name: window.course_name,
                slct_option_state: window.slct_option_state,
                fields: [],
                errors: [],
            };
        },
        created() {
            this.fetchData()
        },
        watch: {
            fields: function (value, index) {
                for(let i = 0; i < index; i++) {
                    if (value[i].cricos_code != null) {
                        this.errors[i].cricos_code = "";
                    }
                    if (value[i].location != null) {
                        this.errors[i].location = "";
                    }
                    console.log(i);
                }
            }
        },
        methods: {
            fetchData() {
                this.fields = window.funded_course_matrix
                console.log(this.fields);
            },
            addBlock: function () {
                this.fields.push({});
            },
            saveBlock(index) {
                const Toast = swal.mixin({
                    toast : true,
                    position: 'top-end',
                    showConfirmButton : false,
                    timer : 3000
                });
                swal.fire({
                    title: 'Please wait...',
                    // html: '',// add html attribute if you want or remove
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                    swal.showLoading()
                    },
                });
                if(this.fields[index].id != undefined){
                    this.fields[index].is_update = 1
                }
                this.fields[index].course_code = this.course_code
                // console.log(this.fields[index]);
                let saveData = this.fields[index];
                axios({
                    method: 'put',
                    url: '/course/funded-matrix/store-update/',
                    data: saveData
                }).then(response => {
                    saveData = {};
                    this.errors = [];
                    Toast.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Course Structure and Fees saved successfully',
                    })
                }).catch(error => {
                    // console.log(error);
                    if (error.response.status === 422) {
                        this.errors[index] = error.response.data.errors || {};
                        this.errors.push({});
                        Toast.fire({
                            position: 'top-end',
                            type: 'error',
                            title: 'Opss..Course Structure and Fees was not saved',
                        })
                    }
                });
            },
            removeBlock: function(index) {
                // console.log(index);
                if (this.fields[index].id != undefined) {
                    swal.fire({
                        title: 'Are you sure?',
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
                                url: '/course/funded-matrix/destroy/' + window.funded_course_matrix[index].id,
                            }).then(response => {
                                if(response.data.status == 'success'){
                                    this.fields.splice(index, 1);
                                    Toast.fire({
                                        type: 'success', title: 'Data is deleted successfully',
                                    });
                                }else{
                                    Toast.fire({
                                        type: 'error', title: 'Opss.. data was not deleted',
                                    });
                                }
                            });
                        }
                    });
                } else {
                    this.fields.splice(index, 1);
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
$white: #ffffff;
$grey: #e0dfdf;
$light-blue: #e0e9ff;
$green: #1cc88a;
$red: #e74a3b;
.tab-pane {border: 1px solid $grey;border-top: none;padding: 1.3rem;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;background-color: $white;}
 .card{
     border-radius: 0; overflow: initial;
     .card-header{
         background-color:$light-blue; border-bottom: 0; padding: 0 1.25rem;
         .collapse-link{ cursor: default;
             &:hover,
             &[aria-expanded="true"]{
                 h5{opacity: 1;}
             }
             &[aria-expanded="true"] {
                 h5:after {content: "\f0d7";}
             }
             &[aria-expanded="false"] {
                 h5:after {content: "\f0d7"; transform: rotate(180deg);}
             }
         }
         h5{ padding: .75rem 0;border-bottom: 1px solid $grey;opacity: 0.7;
             &:after{font-family: 'Font Awesome 5 Free';font-weight: 900;display: inline-block;margin-right: 10px;float: right;}
         }
         .btn-options{
             position: absolute;top: 1px;left: -10px;
             .opt-btn{
                 margin: 1px 0;height: 20px;width: 20px;background-color: $white;font-size: 9px;border: 1px solid $grey;border-radius: 50px;display: flex;justify-content: center;align-items: center;outline: none;
                 &:hover{color: $white !important;transform: scale(1.5);}
                 &:first-child{
                     color: #1cc88a;
                     &:hover{background-color: $green;}
                 }
                 &:last-child{
                     color: $red;
                     &:hover{background-color: $red;}
                 }
             }
         }
     }
     &:last-of-type{border-bottom: 1px solid #e3e6f0;}
     .confirm-delete{position: absolute;top: 0;left: 0;height: 100%;width: 100%;background-color: rgb(231, 74, 59, 0.6);}
 }
</style>