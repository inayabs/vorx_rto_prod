<?php
Route::middleware(['rto'])->group(function () {
    Route::get('offer-letter-and-acceptance-agreement/{process_id}','Enrolment\InternationalEnrolmentApplicationController@previewOfferLetterPdf');
    Route::get('enrolment-process/{process_id}','Enrolment\InternationalEnrolmentApplicationController@student_review_page');
    Route::post('verify-initial-payment','Enrolment\InternationalEnrolmentApplicationController@verify_initial_payment');
    Route::post('pca/enrolment-process','Enrolment\InternationalEnrolmentApplicationController@review_agree');
    Route::get('enrolment-application/funding_type/{location}', 'Enrolment\EnrolmentApplicationController@funding_type');
    Route::post('enrolment-application/change-enrolment-type', 'Enrolment\EnrolmentApplicationController@change_enrolment_type');
    Route::get('enrolment-application/list', 'Enrolment\EnrolmentApplicationController@list');
    Route::get('enrolment-application/class/list/{location}', 'Enrolment\EnrolmentApplicationController@class_list');
    Route::post('enrolment-application/link', 'Enrolment\EnrolmentApplicationController@link_student');
    Route::post('enrolment-application/link_new', 'Enrolment\EnrolmentApplicationController@new_student');
    Route::get('enrolment-application/attachment/{process_id}', 'Enrolment\EnrolmentApplicationController@attachment');
    Route::post('enrolment-application/international', 'Enrolment\InternationalEnrolmentApplicationController@verify_int_student');
    Route::get('enrolment-application/international/course_matrix/{id}', 'Enrolment\InternationalEnrolmentApplicationController@getCourseMatrixInt');
    Route::get('enrolment-application/course_matrix/{id}', 'Enrolment\InternationalEnrolmentApplicationController@getCourseMatrixDom');
    Route::resource('enrolment-application', 'Enrolment\EnrolmentApplicationController');
    
    Route::get('enrolment-application-new/course_matrix/{course_code}/{location}','Enrolment\NewEnrolmentApplicationController@getMatrix');
    Route::post('enrolment-application-new', 'Enrolment\NewEnrolmentApplicationController@store');
    Route::post('enrolment-application-new-link', 'Enrolment\NewEnrolmentApplicationController@link');
});


