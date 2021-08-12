//pre-training review
Vue.component('ptr', require('./components/pre-training/preTrainingComponent.vue').default);
//ptr PCA
Vue.component('ptr-pca', require('./components/pre-training/pca/preTrainingPCAComponent.vue').default);

//classes
Vue.component('class-list',require('./components/classes/classListComponent.vue').default);
Vue.component('create-class',require('./components/classes/createClassComponent.vue').default);
Vue.component('edit-class',require('./components/classes/editClassModal.vue').default);

//atttendance
Vue.component('attendance',require('./components/classes/attendance/attendanceComponent.vue').default);
Vue.component('add-student-modal',require('./components/classes/attendance/addStudentModal.vue').default);
Vue.component('student-attendance',require('./components/classes/attendance/studentAttendanceComponent.vue').default);
Vue.component('add-attendance-modal',require('./components/classes/attendance/addAttendanceModal.vue').default);
Vue.component('view-attendance-sheet-modal',require('./components/classes/attendance/viewAttendanceSheetModal.vue').default);
Vue.component('edit-attendance-modal',require('./components/classes/attendance/editAttendanceModal.vue').default);

//student
Vue.component('domclass', require('./components/Student/domestic/domClassComponent.vue').default);

//student portal
Vue.component('sportal-courses', require('./components/StudentCourses/coursesComponent.vue').default);
Vue.component('student-portal-studentCourses', require('./components/StudentCourses/coursesComponent.vue').default);
Vue.component('student-portal-courseTabs', require('./components/StudentCourses/courseTabsComponent.vue').default);
Vue.component('student-portal-domesticCourseDetails', require('./components/StudentCourses/tabs/domesticCourseDetails.vue').default);
Vue.component('student-portal-classDetails', require('./components/StudentCourses/tabs/classDetails.vue').default);
Vue.component('student-portal-studentFees', require('./components/StudentCourses/tabs/studentFees.vue').default);
Vue.component('student-portal-timeTable', require('./components/StudentCourses/tabs/timeTable.vue').default);

// student portal ptr
Vue.component('student-ptr-list', require('./components/student-portal/ptr/ptrListComponent.vue').default);

//student portal fees
Vue.component('student-portal-fees', require('./components/student-portal/feesComponent.vue').default);


//trainer portal
Vue.component('tportal-classes', require('./components/trainer-portal/trainerClassesComponent.vue').default);
Vue.component('tportal-class-units', require('./components/trainer-portal/trainerClassUnits.vue').default);
Vue.component('tportal-class-attendance', require('./components/trainer-portal/classAttendanceComponent.vue').default);
Vue.component('tportal-class-details', require('./components/trainer-portal/trainerClassDetailsComponent.vue').default);

//new attendance
Vue.component('tportal-attendance', require('./components/trainer-portal/attendanceComponent.vue').default);


// offer letter ptr
Vue.component('ol-ptr', require('./components/Student/offerLetter/ptrComponent.vue').default);
Vue.component('ol-ptr-content', require('./components/Student/offerLetter/ptrContentComponent.vue').default);
Vue.component('ol-ptr-content-assessment', require('./components/Student/offerLetter/ptr/ptrAssessmentComponent.vue').default);
Vue.component('ol-ptr-content-student', require('./components/Student/offerLetter/ptr/ptrStudentForm.vue').default);

//online payment
Vue.component('online-payment-stripe', require('./components/StudentCourses/payments/stripeComponent.vue').default);

// external forms
// Vue.component('complaints-and-appeals', require('./components/external-forms/complaintsComponent.vue').default);
Vue.component('external-form', require('./components/external-forms/externalFormComponent.vue').default);
Vue.component('external-form-list', require('./components/external-forms/exFormsListComponent.vue').default);
Vue.component('external-form-edit', require('./components/external-forms/exFormsEditComponent.vue').default);

// mennus
Vue.component('menus', require('./components/menus/menuListComponent.vue').default);
Vue.component('menu-edit', require('./components/menus/editMenuComponent.vue').default);

// attendance list generator
Vue.component('attendance-list-generator', require('./components/reports/attendanceListGenerator.vue').default);

// payment list generator
Vue.component('payment-list-generator', require('./components/reports/paymentListGenerator.vue').default);

//verify collection modal
Vue.component('verify-collection', require('./components/agents/agent-collection/verifyCollectionModal.vue').default);

