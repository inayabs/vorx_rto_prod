<?php
Route::middleware(['rto'])->group(function () {
    Route::get('/external-forms/list','Forms\ExternalFormController@list')->middleware('auth');
    
    Route::get('/external-forms/getStudent/{id}','Forms\ExternalFormController@get_student');
    
    Route::get('/external-forms','Forms\ExternalFormController@index')->middleware('auth');
    
    Route::get('/external-forms/{id}/check','Forms\ExternalFormController@show')->middleware('auth');
    
    // Route::get('/external-forms/application-for-release-letter/{id}','Forms\ExternalFormController@afrl');
    Route::post('/external-forms/save/{form}','Forms\ExternalFormController@store');
    Route::post('/external-forms/update/{id}','Forms\ExternalFormController@update');
    Route::get('/external-forms/delete/{id}','Forms\ExternalFormController@delete')->middleware('auth');
    
    Route::get('/external-forms/{form_name}','Forms\ExternalFormController@external_form');
    Route::get('/external-forms/{form_name}/{id}','Forms\ExternalFormController@external_form');
});


