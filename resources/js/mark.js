Vue.component('student-list', require('./components/Student/studentListComponent.vue').default);
Vue.component('student-details', require('./components/Student/studentDetailComponent.vue').default);
Vue.component('offer-course-detail', require('./components/Student/offerLetterCourseDetail/CourseDetailComponent.vue').default);
Vue.component('course-completion', require('./components/Student/CourseCompletion/CourseCompletionComponent.vue').default);
Vue.component('course-completion-details', require('./components/Student/CourseCompletion/CourseCompletionDetailsComponent.vue').default);
Vue.component('payment-list', require('./components/Payments/PaymentListComponent.vue').default);
Vue.component('earnings-chart', require('./components/Dashboard/EarningsChartComponent.vue').default);
Vue.component('usi-form', require('./components/USI/UsiComponent.vue').default);
Vue.component('create-usi-form', require('./components/USI/CreateUsiComponent.vue').default);
Vue.component('update-personal-details-usi-form', require('./components/USI/UpdatePersonalDetailsComponent.vue').default);
Vue.component('update-contact-details-usi-form', require('./components/USI/UpdateContactDetails.vue').default);
Vue.component('locate-usi-form', require('./components/USI/LocateComponent.vue').default);
Vue.component('sms-list', require('./components/SMS/SmsListComponent.vue').default);
Vue.component('sms-create', require('./components/SMS/SmsCreateComponent.vue').default);
Vue.component('state-funding', require('./components/StateFunding/StateFundingComponent.vue').default);
Vue.component('funding-type', require('./components/StateFunding/FundingTypeComponent.vue').default);
Vue.component('application-list', require('./components/enrolments/enrolmentListComponent.vue').default);
Vue.component('application-show', require('./components/enrolments/enrolmentShowComponent.vue').default);

Vue.component('student-review-pca', require('./components/enrolments/pca/studentReviewPageComponent.vue').default);

Vue.component('commission-list', require('./components/agents/commissions/commissionListComponent.vue').default);



// new student UI

Vue.component('student', require('./components/newStudent/studentComponent.vue').default);