Vue.component('agent-list', require('./components/agents/agentListComponent.vue').default);
Vue.component('agent-detail', require('./components/agents/agentDetailComponent.vue').default);
Vue.component('test-dynamic-form', require('./components/globals/form/TestDynamicFormComponent.vue').default);
Vue.component('top-search', require('./components/globals/topSearchComponent.vue').default);
// reports
Vue.component('list-generator', require('./components/reports/listGeneratorComponent.vue').default);
// enrolments
Vue.component('enrolment-form', require('./components/enrolments/enrolmentComponent.vue').default);
Vue.component('attach-signature', require('./components/enrolments/attachmentSignatureComponent.vue').default);

// international enrolments
Vue.component('enrolment-form-int', require('./components/enrolments/enrolmentIntComponent.vue').default);

// Configuration -> Automations
Vue.component('automation-details', require('./components/automation/automationDetailsComponent.vue').default);
// Course Setup
Vue.component('course-setup', require('./components/Program/course/setup/courseSetupComponent.vue').default);
// Class Time Table
Vue.component('time-table', require('./components/classes/time-table/new/timeTableComponent.vue').default);
Vue.component('rotating-time-table', require('./components/classes/time-table/timeTableRotatingComponent.vue').default);
// Site Inspection Checklist Form
Vue.component('site-inspection-checklist-form', require('./components/forms/siteInspectionChecklistComponent.vue').default);
Vue.component('site-inspection-checklist-list', require('./components/forms/siteInspectionChecklistListComponent.vue').default);

// RTO SETUP
Vue.component('training-org-config', require('./components/Organisations/rtoSetupComponent.vue').default);
