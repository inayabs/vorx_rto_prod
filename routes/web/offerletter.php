<?php
Route::middleware(['rto'])->group(function () {
    Route::post('offer-letter/payment/trnx', 'Student\PaymentController@store_cash');
    Route::post('offer-letter/payment/trnx/online', 'Student\PaymentController@store_online');
    Route::get('offer-letter/payment/trnx', 'Student\PaymentController@generate_string');
    Route::post('offer-letter/payment/change_date', 'Student\PaymentController@changeDate');
    Route::delete('offer-letter/payment/delete/{id}', 'Student\PaymentController@Delete');
    Route::get('offer-letter/paymenthistory/{student_id}', 'Student\PaymentController@payment_history');
    Route::delete('offer-letter/payment/reset/{id}', 'Student\PaymentController@paymentResched');
    Route::get('offer-letter/package/{package_type}/{shore_type}', 'Student\OfferLetterController@getPackage');
    Route::get('offer-letter/{offer_letter}/course-detail/show', 'Student\OfferLetterController@course_detail');
    Route::get('offer-letter/{offer_letter}/course-detail', 'Student\OfferLetterController@show_course_detail');
    Route::get('offer-letter/course-detail/payment-detail/{id}', 'Student\PaymentController@payment_detail');
    Route::post('offer-letter/course-detail/payment-detail', 'Student\PaymentController@payment_detail_store');
    Route::post('offer-letter/course-detail/payment-detail/update', 'Student\PaymentController@payment_detail_update');
    Route::put('offer-letter/course-detail/change-status/{course_detail}', 'Student\OfferLetterController@course_detail_update');
    Route::delete('offer-letter/course-detail/payment-detail/{payment_detail}', 'Student\PaymentController@payment_detail_destory');
    Route::put('offer-letter/fees/{id}', 'Student\PaymentController@fees_store');
    Route::get('offer-letter/pdf/preview/{id}', 'Student\OfferLetterController@previewOfferLetterPdf')->middleware(['role:' . config('global.roles')]);
    Route::get('offer-letter/pdf/course_detail/{id}', 'Student\OfferLetterController@previewCourseDetailPdf')->middleware(['role:' . config('global.roles')]);
    Route::post('offer-letter/checklist/{student}', 'Student\OfferLetterController@store_checklist');
    Route::post('offer-letter/course-details', 'Student\OfferLetterController@coursedetail');

    // COE
    Route::get('offer-letter/coe/fetch/{ol_id}', 'Student\StudentAttachmentController@fetch_coe');
    Route::post('offer-letter/coe/upload', 'Student\StudentAttachmentController@upload_coe');
    Route::get('offer-letter/coe/remove/{id}', 'Student\StudentAttachmentController@remove_coe');
    Route::post('offer-letter/coe/send', 'Student\StudentAttachmentController@send_coe');

    // initial payment receipt fetch
    Route::get('offer-letter/inital-payment-reciept/{id}', 'Student\StudentAttachmentController@fetch_initial_payment');
    Route::post('offer-letter/inital-payment-receipt/upload', 'Student\StudentAttachmentController@upload_initial_payment');

    // generate confirmation of enrolment COE
    Route::get('offer-letter/generate/coe/{id}', 'Student\StudentAttachmentController@generate_coe');

    //send 2nd email enrolment
    Route::get('offer-letter/enrolment-email/{id}', 'Student\OfferLetterController@enrolment_email');
    Route::get('offer-letter/{id}/offer_create_pdf', 'Student\OfferLetterController@create_pdf_again');
    Route::resource('offer-letter', 'Student\OfferLetterController');
});
