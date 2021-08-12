<?php
Route::middleware(['rto'])->group(function () {
    Route::get('course_completion', 'CourseCompletion\CourseCompletionController@index')->name('course-completion.index');
    Route::get('course_completion/list', 'CourseCompletion\CourseCompletionController@list');
    Route::put('course_completion/update/units/{unit}', 'CourseCompletion\CourseCompletionController@update_units');
    Route::post('course_completion', 'CourseCompletion\CourseCompletionController@storeUpdate');
    Route::get('course_completion/student/{student}', 'CourseCompletion\CourseCompletionController@student');
    Route::get('course_completion/student/{student}/show', 'CourseCompletion\CourseCompletionController@student_show');
    Route::get('course_completion/student/{student}/base', 'CourseCompletion\CourseCompletionController@student_base');
    Route::delete('course_completion/student/delete/detail/{id}/{code}', 'CourseCompletion\CourseCompletionController@destroy_completion_details');
    Route::get('course_prospectus/{course}', 'CourseCompletion\CourseCompletionController@prospectus');
    Route::post('/course_completion/extraUnit', 'CourseCompletion\CourseCompletionController@saveExtraUnits');
    
    Route::get('/certificate_issuance/send/{id}', 'CertificateIssuance\CertificateIssuanceController@send_cert');
    Route::get('/certificate_issuance/preview/{id}', 'CertificateIssuance\CertificateIssuanceController@preview_cert')->middleware(['role:'.config('global.roles')]);
    Route::get('/certficate_issuance/list/{id}', 'CertificateIssuance\CertificateIssuanceController@student_list');
    Route::get('/certificate_issuance/generate/progress_report/{student}/{course}', 'CertificateIssuance\CertificateIssuanceController@progress_report')->middleware(['role:'.config('global.roles')]);
    Route::get('/hellooooo', 'CertificateIssuance\CertificateIssuanceController@checkcompletion');
    Route::post('/certificate_issuance/generate/extraUnit/{student_id}', 'CertificateIssuance\CertificateIssuanceController@generate_extraUnit');
    Route::resource('/certificate_issuance', 'CertificateIssuance\CertificateIssuanceController');
    Route::get('/HELLLOOOOOO', 'CertificateIssuance\CertificateIssuanceController@proscom');
    
    // confirmation report
    Route::get('course_completion/confirmation_report/{student_id}/{course_code}', 'CourseCompletion\CourseCompletionController@confirmation_report');
});
