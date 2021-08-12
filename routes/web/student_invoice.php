<?php
// Invoice
Route::middleware(['rto'])->group(function () {
    Route::get('/student/invoice/{student_id}/{payment_template_id}', 'Student\StudentInvoiceController@generate_invoice');
    Route::get('/student/invoice/send', 'Student\StudentInvoiceController@send_invoice');
});

