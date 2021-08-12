<?php

/*
|--------------------------------------------------------------------------
| Forms Routes
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
    // Site Inspection Checklist From routes
    Route::get('/forms/site-inspection-checklist-form-list', 'Forms\SiteInspectionChecklistController@list');
    Route::get('/forms/site-inspection-checklist-form-list/fetch', 'Forms\SiteInspectionChecklistController@fetch');
    Route::get('/forms/site-inspection-checklist-form', 'Forms\SiteInspectionChecklistController@index');
    Route::post('/forms/site-inspection-checklist-form/save', 'Forms\SiteInspectionChecklistController@store');
    Route::get('/forms/site-inspection-checklist-form/process/{process_id}', 'Forms\SiteInspectionChecklistController@show');
    Route::get('/forms/site-inspection-checklist-form/pdf/{process_id}', 'Forms\SiteInspectionChecklistController@generate_pdf');
    // Route::get('/online-enrolment/get/{process_id}', 'Enrolment\EnrolmentController@edit');
    // Route::post('/online-enrolment/finish/{process_id}', 'Enrolment\EnrolmentController@finish');
    // Route::post('/online-enrolment/save-signature/{process_id}', 'Enrolment\EnrolmentController@update');
});



// attachments





