<?php
Route::middleware(['rto'])->group(function () {
    Route::get('payment', 'Student\PaymentController@index')->name('payment.index');
    Route::get('payment/list', 'Student\PaymentController@payment_list')->name('payment.list');
    Route::get('payment/detail/{offer_detail}', 'Student\PaymentController@paymentDetailView');
    route::post('payment_attachment','Student\PaymentController@paymentAttachment');
    route::get('payment_attachment/{id}', 'Student\PaymentController@paymentAttachmentView');
    
    // verify payment detail
    Route::post('payment/detail/verify', 'Student\PaymentController@paymentDetailVerify');

    // generate initial payment receipt pdf
    Route::get('/pdf/generate-initial-payment-recept', 'Student\StudentAttachmentController@generate_reciept');
    // generate initial payment reciept pdf (Shortcut)
    Route::get('/generate/pdf/generate-initial-payment-recept/{id}/{receiptDate}', 'Student\StudentAttachmentController@generate_reciept');
    
    
    // update payment schedule details (amount & due date)
    Route::post('student/payment-sched-detail/detail', 'Student\PaymentController@updatePaymentSchedDetail');
    
    // view payment receipt
    Route::get('/student-payments','Student\PaymentController@student_payments');
    Route::get('/student-payments/list','Student\PaymentController@student_payments_list');
    Route::get('/student/payment-receipt/preview/{id}','Student\PaymentController@paymentReceiptView');
    Route::get('/student/payment-receipt/{student_id}/{id}/send','Student\PaymentController@send_receipt');
});