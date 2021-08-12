// Users
Vue.component('user-list', require('./components/Users/userListComponent.vue').default);
Vue.component('user-detail', require('./components/Users/userDetailComponent.vue').default);
// Vue.component('crop-upload', require('./components/Users/CropUploadComponent.vue').default);

// Trainer Management
Vue.component('trainer-list', require('./components/Trainers/trainerListComponent.vue').default);
Vue.component('trainer-detail', require('./components/Trainers/trainerDetailComponent.vue').default);

//Commission Settings
Vue.component('commission-settings-list', require('./components/Trainers/commissionSetting/commissionSettingsListComponent.vue').default);
Vue.component('commission-settings-create', require('./components/Trainers/commissionSetting/createComSettingComponent.vue').default);
Vue.component('commission-settings-detail', require('./components/Trainers/commissionSetting/commissionSettingDetailComponent.vue').default);

// Organization
Vue.component('organisation-list', require('./components/Organisations/organisationListComponent.vue').default);
Vue.component('organisation', require('./components/Organisations/organisationComponent.vue').default);

//Training Delivery Location
Vue.component('delivery-location', require('./components/Organisations/deliveryLocation/trainingDeliveryLocationComponent.vue').default);

// Domestic student
Vue.component('domestic-student', require('./components/Student/domestic/domesticStudentDetailComponent.vue').default);

// Avetmiss
Vue.component('avetmiss', require('./components/avetmiss/avetmissComponent.vue').default);

// Qualification Issuance Register 
Vue.component('qir-detail', require('./components/Student/studentQIRComponent.vue').default);

// Language, Literacy and Numeracy (LLN) Test
Vue.component('lln-test', require('./components/lln-test/LLNTestComponent.vue').default);
// Unit Of Competency (LLN) Test
Vue.component('unit-of-competency-lln-test', require('./components/lln-test/UnitOfCompetencyLLNTestComponent.vue').default);

// Holidays
Vue.component('holidays', require('./components/holidays/holidaysComponent.vue').default);

//STUDENT PORTAL
Vue.component('student-info', require('./components/student-portal/info/studentMainComponent.vue').default);

// enrolments PCA - Phoenix College of Australia
Vue.component('enrolment-form-pca', require('./components/enrolments/pca/enrolmentPCAComponent.vue').default);
Vue.component('attach-signature-pca', require('./components/enrolments/pca/attachmentSignatureComponent.vue').default);
Vue.component('acknowledgement-form-pca', require('./components/enrolments/pca/acknowledgementOfReceiptComponent.vue').default);
Vue.component('induction-checklist-pca', require('./components/enrolments/pca/inductionChecklistComponent.vue').default);

// enrolments PCA - Phoenix College of Australia (Domestic)
Vue.component('enrolment-form-pca-dom', require('./components/enrolments/pca/domestic/enrolmentPCADomesticComponent.vue').default);
Vue.component('attach-signature-pca-dom', require('./components/enrolments/pca/domestic/attachmentSignatureComponent.vue').default);

// Language, Literacy and Numeracy (LLN) Test for PCA
Vue.component('lln-test-pca', require('./components/lln-test/pca/LLNTestPCAComponent.vue').default);

// ONLINE Language, Literacy and Numeracy (LLN) Test for PCA
Vue.component('online-lln-test-pca', require('./components/lln-test/pca/OnlineLLNTestPCAComponent.vue').default);

// ONLINE Language, Literacy and Numeracy (LLN) Test for CEA
Vue.component('online-lln-test', require('./components/lln-test/OnlineLLNTestComponent.vue').default);

// Register for Recording Construction Induction Statement of Attainments
Vue.component('rrci-detail', require('./components/Student/studentRRCIComponent.vue').default);

//Seending Fees Receipt 
Vue.component('student-payments', require('./components/Payments/StudentPaymentListComponent.vue').default);

//Generate Process ID / access code
Vue.component('access-code', require('./components/access-code/AccessCodeListComponent.vue').default);

//Agent Application 
Vue.component('agent-application', require('./components/agent-application/AgentApplicationComponent.vue').default);
Vue.component('agent-application-attachment', require('./components/agent-application/attachmentSignatureComponent.vue').default);
Vue.component('reference-check', require('./components/agent-application/AgentReferenceCheckComponent.vue').default);
Vue.component('representative-agent-list', require('./components/agent-application/RepresentativeAgentListComponent.vue').default);
Vue.component('agent-agreement-review', require('./components/agent-application/ReviewAgentAgreementComponent.vue').default);