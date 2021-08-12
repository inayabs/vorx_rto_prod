<?php

/*
|--------------------------------------------------------------------------
| Enrolment Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['rto'])->group(function () {
    Route::get('/online-enrolment', 'Enrolment\EnrolmentController@index');
    Route::post('/online-enrolment/save', 'Enrolment\EnrolmentController@store');
    Route::get('/online-enrolment/process/{process_id}', 'Enrolment\EnrolmentController@show');
    Route::get('/online-enrolment/get/{process_id}', 'Enrolment\EnrolmentController@edit');
    Route::post('/online-enrolment/finish/{process_id}', 'Enrolment\EnrolmentController@finish');
    Route::get('/online-enrolment/pdf/{process_id}', 'Enrolment\EnrolmentController@generate_pdf');
    Route::post('/online-enrolment/save-signature/{process_id}', 'Enrolment\EnrolmentController@update');
    
    // international enrolment form
    Route::get('/international/online-enrolment', 'Enrolment\InternationalEnrolmentController@index');
    Route::post('/international/online-enrolment/save', 'Enrolment\InternationalEnrolmentController@store');
    Route::get('/international/online-enrolment/process/{process_id}', 'Enrolment\InternationalEnrolmentController@show');
    Route::get('/international/online-enrolment/get/{process_id}', 'Enrolment\InternationalEnrolmentController@edit');
    Route::post('/international/online-enrolment/finish/{process_id}', 'Enrolment\InternationalEnrolmentController@finish');
    Route::get('/international/online-enrolment/pdf/{process_id}', 'Enrolment\EnrolmentController@generate_pdf');
    Route::post('/international/online-enrolment/save-signature/{process_id}', 'Enrolment\InternationalEnrolmentController@update');
    Route::get('/international/online-enrolment/agent/{code}', 'Enrolment\InternationalEnrolmentController@find_agent');
    
    // attachments
    Route::post('/online-enrolment/attachment/upload/{process_id}', 'Enrolment\EnrolmentAttachmentController@documents_upload');
    Route::get('/online-enrolment/attachment/fetch/{process_id}', 'Enrolment\EnrolmentAttachmentController@documents_fetch');
    Route::delete('/online-enrolment/attachment/delete/{id}', 'Enrolment\EnrolmentAttachmentController@documents_delete');
    Route::get('/online-enrolment/attachment/preview/{id}', 'Enrolment\EnrolmentAttachmentController@documents_preview');
    Route::put('/online-enrolment/attachment/rename/{id}', 'Enrolment\EnrolmentAttachmentController@rename');
    // Route::get('/online-enrolment/attachment/update/{uid}', 'Enrolment\EnrolmentAttachmentController@documents_update');
    
    
    Route::get('/check-enrolment/{process_id}', 'Student\StudentController@check_enrolment');
});





