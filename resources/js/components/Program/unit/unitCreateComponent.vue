<template lang="">
    <div>
        <h3>Create New Unit</h3>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane d-block">
                <form @submit.prevent="create">
                    
                    <div class="row mb-2 d-flex justify-content-between">
                        <div class="col-md-6">
                            <a href="/unit" v-bind:class="'btn btn-'+app_color+' text-primary text-light'"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success d-block ml-auto"><i class="far fa-save"></i> Save Unit</button>
                        </div>
                    </div>

                    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
                        <h6>Add Units</h6>
                    </div>
                    <div class="form-padding-left-right">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="code" class="">Unit Code:</label>
                                    <input type="text" class="form-control" id="code" v-model="fields.code" :class="[errors && errors.code ? 'border-danger' : '']"  />
                                    <div v-if="errors && errors.code" class="badge badge-danger" :class="[isValid ? 'd-none': 'd-inline-block']">{{ errors.code[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="unit_type" class="">Unit Type:</label>
                                    <select class="form-control" id="unit_type" v-model="fields.unit_type" :class="[errors && errors.unit_type ? 'border-danger' : '']" >
                                        <option value="core">Core</option>
                                        <option value="elective">Elective</option>
                                    </select>
                                    <div v-if="errors && errors.unit_type" class="badge badge-danger">{{ errors.unit_type[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description" class="">Subject Description:</label>
                                    <input type="text" class="form-control" id="description"v-model="fields.description" :class="[errors && errors.description ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.description" class="badge badge-danger">{{ errors.description[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="assessment_method" class="">Assessment Method:</label>
                                    <multiselect v-model="fields.assessment_method" :options="options" :multiple="true" :searchable="false" :close-on-select="false" label="description" track-by="id" :class="[errors && errors.assessment_method ? 'border-danger' : '']"></multiselect>
                                    <div v-if="errors && errors.assessment_method" class="badge badge-danger">{{ errors.assessment_method[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="subject_educ_fld_identifier_id" class="">Subject Field of Education Identifier:</label>
                                    <select class="form-control" id="subject_educ_fld_identifier_id" v-model="fields.subject_educ_fld_identifier_id" :class="[errors && errors.subject_educ_fld_identifier_id ? 'border-danger' : '']" >
                                        <option v-bind:value="ufe.id" v-for="ufe in unit_field_educ">{{ ufe.description  }}</option>
                                    </select>
                                    <div v-if="errors && errors.subject_educ_fld_identifier_id" class="badge badge-danger">{{ errors.subject_educ_fld_identifier_id[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nominal_hours" class="">Nominal Hours:</label>
                                    <input type="number" min="0" class="form-control" id="nominal_hours" v-model="fields.nominal_hours" :class="[errors && errors.nominal_hours ? 'border-danger' : '']" />
                                    <div v-if="errors && errors.nominal_hours" class="badge badge-danger">{{ errors.nominal_hours[0] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="training_method_id" class="">Training Method:</label>
                                    <select class="form-control" id="training_method_id" v-model="fields.training_method_id" :class="[errors && errors.training_method ? 'border-danger' : '']">
                                        <option v-bind:value="tm.id" v-for="tm in training_methods">{{ tm.description }}</option>
                                    </select>
                                    <!-- <input type="text" class="form-control" id="unit_type" name="unit_type" v-model="fields.unit_type" /> -->
                                    <div v-if="errors && errors.training_method_id" class="badge badge-danger">{{ errors.training_method_id[0] }}</div>
                                </div>
                            </div>
                            <div class="clearfix w-100"></div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="custom-control custom-switch my-3">
                                        <input type="checkbox" class="custom-control-input" id="vet_flag" v-model="fields.vet_flag" value="0">
                                        <label class="custom-control-label" for="vet_flag">VET Flag Status</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="custom-control custom-switch my-3">
                                        <input type="checkbox" class="custom-control-input" id="extra_unit" v-model="fields.extra_unit"  value="0">
                                        <label class="custom-control-label" for="extra_unit">Set as Extra Unit</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="custom-control custom-switch my-3">
                                        <input type="checkbox" class="custom-control-input" id="active" v-model="fields.active" value="0">
                                        <label class="custom-control-label" for="active">Set as Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import FormMixin from '../../../mixins/FormMixin'
    export default {
        mixins: [ FormMixin ],
        name: 'unitCreate',
        data() {
            return {
                // Form Attributes
                'action': '/unit',
                'method': 'post',
                app_color: app_color,
                isActive: true,
                // Form Inputs
                unit_field_educ: unit_field_educ,
                training_methods: training_methods,
                assessment_method: null,
                options: assessment_method,
            }
        }
    }
</script>
