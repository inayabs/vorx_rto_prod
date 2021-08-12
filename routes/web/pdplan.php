<?php
Route::middleware(['rto'])->group(function () {
    Route::get('/pdplan/fetch','Automation\PDPlanController@fetch_email_templates');
    Route::post('/pdplan/save','Automation\PDPlanController@pd_plan_save');
    Route::get('/pdplan/delete/{id}','Automation\PDPlanController@pdplan_delete');
    Route::get('/pdplan/email-segment/fetch','Automation\PDPlanController@fetch_email_segments');
    Route::post('/pdplan/email-segment/save','Automation\PDPlanController@save_email_segment');
    Route::get('/pdplan/segment/delete/{id}','Automation\PDPlanController@segment_delete');
    Route::post('/pdplan/configuration/save','Automation\PDPlanController@save_configuration');
    
    Route::get('/pdplan/fetchVars','Automation\PDPlanController@fetchVars');
    Route::post('/pdplan/templates/save','Automation\PDPlanController@save_template');
    
    //sending
    Route::get('/pdplan/sendPdEmails','Automation\PDPlanController@sendPdEmails');
});