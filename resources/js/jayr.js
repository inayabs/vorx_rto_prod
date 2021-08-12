/* Courses */
Vue.component('course-list', require('./components/Program/course/courseListComponent.vue').default);
Vue.component('course-detail', require('./components/Program/course/courseDetailComponent.vue').default);
    // Package
Vue.component('course-package', require('./components/Program/coursePackage/coursePackageComponent.vue').default);
Vue.component('course-package-info', require('./components/Program/coursePackage/coursePackageInfoComponent.vue').default);

/* Units */
Vue.component('unit-list', require('./components/Program/unit/unitListComponent.vue').default);
// Vue.component('unit-create', require('./components/Program/unit/unitCreateComponent.vue').default);
Vue.component('unit-edit', require('./components/Program/unit/unitEditComponent.vue').default);

/* Documents */
Vue.component('documents', require('./components/documents/documentsComponent.vue').default);
Vue.component('documents-update', require('./components/documents/documentsUpdateComponent.vue').default);

/* Email Sending */
Vue.component('email', require('./components/email-sending/emailComponent.vue').default);
Vue.component('email-sending-details', require('./components/email-sending/emailSendingDetailsComponent.vue').default);