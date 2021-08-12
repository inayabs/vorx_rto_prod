<?php

/*
|--------------------------------------------------------------------------
| Trainer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Commission Settings
// Route::get('trainer-management/commission-settings/{id}', 'Trainers\TrainerCommissionController@show')->name('trainer.commission_setting.show');
Route::middleware(['rto'])->group(function () {
    Route::get('comsetting/list/{id}', 'Trainers\TrainerCommissionController@comset_list');
    Route::get('comsetting/info/{id}/trainer/{comset_id}', 'Trainers\TrainerCommissionController@comset_info');
    
    // Create Commission Setting
    Route::get('trainer/commission-settings/create/{id}', 'Trainers\TrainerCommissionController@create')->name('trainer.commission_setting.create');
    // store commission setting
    Route::post('trainer/commission-settings/store/{id}', 'Trainers\TrainerCommissionController@store')->name('trainer.commission_setting.store');
    // edit
    Route::get('trainer-management/commission-settings/{id}/trainer/{comset_id}/edit', 'Trainers\TrainerCommissionController@edit')->name('trainer.commission_setting.edit');
    // update
    Route::post('trainer/commission-settings/{id}/update/{comset_id}', 'Trainers\TrainerCommissionController@update')->name('trainer.commission_setting.update');
    // delete commission setting
    Route::delete('trainer/commission-settings/{id}/delete/{comset_id}', 'Trainers\TrainerCommissionController@destroy')->name('trainer.commission_setting.destroy');
    
    //Trainer 
    Route::get('trainer/list', 'Trainers\TrainerController@trainer_list')->name('trainer.list');
    Route::post('trainer', 'Trainers\TrainerController@store')->name('trainer.store');
    // Info and Update
    Route::get('trainer/{id}', 'Trainers\TrainerController@show');
    Route::get('trainer/show/{id}', 'Trainers\TrainerController@trainer_info')->name('trainer.show');
    Route::post('trainer/show/update/{id}', 'Trainers\TrainerController@trainer_info_update')->name('trainer.show.update');
    
    
    // trainer attachments upload
    Route::post('trainer/attachment/upload/{trainer_id}', 'Trainers\TrainerAttachmentController@trainer_attachment_upload');
    // trainer attachments fetch
    Route::get('trainer/attachment/fetch/{trainer_id}', 'Trainers\TrainerAttachmentController@trainer_attachment_fetch');
    // trainer attachments delete
    Route::get('trainer/attachment/delete/{id}', 'Trainers\TrainerAttachmentController@trainer_attachment_delete');
    // trainer attachments preview
    Route::get('trainer/attachment/preview/{id}', 'Trainers\TrainerAttachmentController@trainer_attachment_preview');
    
    //Trainer Resource
    Route::resource('trainer-management', 'Trainers\TrainerController');
    
    // dashboard fetch
    Route::get('trainer/fetch/{user_id}', 'Trainers\TrainerController@trainer_fetch');
});

