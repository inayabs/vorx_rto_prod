<?php

/*
|--------------------------------------------------------------------------
| Email Sending Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Resource
    // Email Sending
Route::middleware(['rto'])->group(function () {
    Route::resource('email-sending', 'EmailSending\EmailSendingController')->middleware('auth');
    Route::get('email-sending/details/{id}', 'EmailSending\EmailSendingController@show')->name('email-sending.show')->middleware('auth');
    Route::post('email-sending/store', 'EmailSending\EmailSendingController@store');
    Route::get('email-sending/list/all', 'EmailSending\EmailSendingController@email_send_list')->name('email-sending.list')->middleware('auth');
    Route::get('email-sending/list/persons', 'EmailSending\EmailSendingController@get_persons_list')->name('email-sending.persons')->middleware('auth');
    
        // Email Template
    Route::get('email-sending/list/templates', 'EmailSending\EmailSendingController@get_templates_list')->name('email-sending.templates-list')->middleware('auth');
    Route::put('email-sending/store-update/template', 'EmailSending\EmailSendingController@template_store_update')->name('template.store_update');
    Route::get('email-sending/delete/template/{id}', 'EmailSending\EmailSendingController@destroy_template')->name('email-sending.template.-destroy')->middleware('auth');
    
    //  Email Module
    Route::get('email-sending/module/{m_id}', 'EmailSending\EmailSendingController@get_module_fields');
    
    
    // Route::get('email-sending/send', 'EmailSending\EmailSendingController@html_email');
});