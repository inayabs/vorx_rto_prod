<?php
Route::middleware(['rto'])->group(function () {
    Route::get('student/getClassTimetable/{class}/{location}', 'Student\DomesticController@getClassTimetable');
    Route::get('student/getCourse/{student}/{international?}', 'Student\DomesticController@getCourses');
    Route::get('student/getCourseFee/{filter}/{code}', 'Student\DomesticController@getCourseFee');
    Route::get('student/getOptions/{filter}/{code}', 'Student\DomesticController@getOptions');
    Route::get('student/options/getFundingSourceState/{location}', 'Student\DomesticController@getFundingSourceState');
    Route::get('student/domestic/{student}/info', 'Student\DomesticController@student_info');
    Route::post('student/domestic/{student}/info_update', 'Student\DomesticController@update');
    Route::post('student/domestic/{student}/contact-update', 'Student\DomesticController@contact_update');
    Route::post('student/domestic/{student}/avetmiss-update', 'Student\DomesticController@avetmiss_update');
    Route::post('student/domestic/{student}/course-update', 'Student\DomesticController@course_details_update');
    Route::post('student/domestic/{student}/extra_units', 'Student\DomesticController@store_units');
    Route::post('student/domestic/{student}/visa_update', 'Student\DomesticController@visa_update');
    
    // Payment Details
    Route::get('student/domestic/{student}/payment-details', 'Student\DomesticPaymentController@payment_details');
    Route::post('student/domestic/{student}/payment-store', 'Student\DomesticPaymentController@payment_store');
    Route::delete('student/domestic/{student}/delete/{pd_id}', 'Student\DomesticPaymentController@pd_delete');
    
    // Invoice
    Route::get('/student/domestic/invoice/{student}/{code}', 'Student\DomesticController@generate_invoice');
    Route::post('/student/domestic/invoice-update', 'Student\DomesticController@update_invoice');
    // Payment Plan
    Route::get('/student/domestic/payment-plan/{student}/{code}', 'Student\DomesticController@generate_payment_plan');
    // PAYMENT RECEIPT
    Route::get('/student/domestic/payment-receipt/{student}/{code}', 'Student\DomesticController@generate_receipt');
    // Domestic Resource
    Route::resource('student/domestic', 'Student\DomesticController');
});
