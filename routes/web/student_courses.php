<?php

/*
|--------------------------------------------------------------------------
| Student Courses routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['rto'])->group(function () {
    Route::get('/student_courses','StudentCourses\StudentCourses@index');
    Route::get('/student_courses/getDomCourses/{id}','StudentCourses\StudentCourses@get_domStudent_courses');
    Route::get('/student_courses/gettimetable/{id}/{code}','StudentCourses\StudentCourses@time_table');
    
    //student fees
    Route::get('/student_fees','StudentCourses\StudentCourses@student_fees');
    Route::get('/student_fees/get-fees/{funded_student_course_id}','StudentCourses\StudentCourses@getFees');
    
    
    // payment
    Route::get('/student-portal/online-payment/{id}','Payments\OnlinePaymentController@stripe');
    Route::post('/student-portal/online-payment/stripe/pay','Payments\OnlinePaymentController@stripe_checkout')->name('stripe.checkout');
    Route::get('/student-portal/online-payment/stripe/getcustomer/{student_id}','Payments\OnlinePaymentController@getCus');
    
    Route::middleware('auth')->prefix('student-portal/online-payment')->group(function(){
        Route::get('/payment-receipt/{id}','Payments\OnlinePaymentController@payment_receipt');
        Route::get('/payment-receipt/{id}/send','Payments\OnlinePaymentController@send_receipt');
    });
});

