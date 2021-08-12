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
//Online Enrolment
Route::middleware(['rto'])->group(function () {
    Route::get('/pca/online-enrolment', 'Enrolment\EnrolmentPCAController@index');
    Route::post('/pca/online-enrolment/save', 'Enrolment\EnrolmentPCAController@store');
    Route::get('/pca/online-enrolment/process/{process_id}', 'Enrolment\EnrolmentPCAController@show');
    Route::get('/pca/online-enrolment/get/{process_id}', 'Enrolment\EnrolmentPCAController@edit');
    Route::post('/pca/online-enrolment/finish/{process_id}', 'Enrolment\EnrolmentPCAController@finish');
    Route::get('/pca/online-enrolment/pdf/{process_id}', 'Enrolment\EnrolmentPCAController@generate_pdf');
    Route::post('/pca/online-enrolment/save-signature/{process_id}', 'Enrolment\EnrolmentPCAController@update');
    Route::get('/pca/online-enrolment/agent/{code}', 'Enrolment\EnrolmentPCAController@find_agent');
    
    //Acknowledgement
    Route::get('/pca/acknowledgement-of-receipt ', 'Enrolment\AcknowledgementPCAController@index');
    Route::post('/pca/acknowledgement-of-receipt/save', 'Enrolment\AcknowledgementPCAController@store');
    Route::get('/pca/acknowledgement-of-receipt/get/{process_id}', 'Enrolment\AcknowledgementPCAController@edit');
    Route::get('/pca/acknowledgement-of-receipt/pdf/{process_id}', 'Enrolment\AcknowledgementPCAController@generate_pdf');
    
    //Induction Checklist
    Route::get('/pca/induction-checklist ', 'Enrolment\InductionChecklistPCAController@index');
    Route::post('/pca/induction-checklist/save', 'Enrolment\InductionChecklistPCAController@store');
    Route::get('/pca/induction-checklist/get/{process_id}', 'Enrolment\InductionChecklistPCAController@edit');
    Route::get('/pca/induction-checklist/pdf/{process_id}', 'Enrolment\InductionChecklistPCAController@generate_pdf');
    
    // Online Enrolment attachment
    Route::post('/pca/online-enrolment/attachment/upload/{process_id}', 'Enrolment\EnrolmentPCAController@documents_upload');
    Route::get('/pca/online-enrolment/attachment/fetch/{process_id}', 'Enrolment\EnrolmentPCAController@documents_fetch');
    Route::delete('/pca/online-enrolment/attachment/delete/{id}', 'Enrolment\EnrolmentPCAController@documents_delete');
    Route::get('/pca/online-enrolment/attachment/preview/{id}', 'Enrolment\EnrolmentPCAController@documents_preview');
    Route::put('/pca/online-enrolment/attachment/rename/{id}', 'Enrolment\EnrolmentPCAController@rename');
});


//Online Enrolment - Domestic
Route::get('/pca/online-enrolment/domestic', 'Enrolment\EnrolmentPCADomesticController@index');
Route::post('/pca/online-enrolment/domestic/save', 'Enrolment\EnrolmentPCADomesticController@store');
Route::get('/pca/online-enrolment/domestic/process/{process_id}', 'Enrolment\EnrolmentPCADomesticController@show');
Route::get('/pca/online-enrolment/domestic/get/{process_id}', 'Enrolment\EnrolmentPCADomesticController@edit');
Route::post('/pca/online-enrolment/domestic/finish/{process_id}', 'Enrolment\EnrolmentPCADomesticController@finish');
Route::get('/pca/online-enrolment/domestic/pdf/{process_id}', 'Enrolment\EnrolmentPCADomesticController@generate_pdf');
Route::post('/pca/online-enrolment/domestic/save-signature/{process_id}', 'Enrolment\EnrolmentPCADomesticController@update');
Route::get('/pca/online-enrolment/domestic/agent/{code}', 'Enrolment\EnrolmentPCADomesticController@find_agent');