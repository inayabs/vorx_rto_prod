<?php

/*
|--------------------------------------------------------------------------
| PCA PTR Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['rto'])->group(function () {
    Route::get('/pca/pre-training-review','PreTraining\PtrPCAController@student_ptr')->middleware('auth');
    Route::get('/pca/pre-training-review/process/{process_id}','PreTraining\PtrPCAController@show');
    Route::get('/pca/pre-training-review/process/{process_id}/{action}','PreTraining\PtrPCAController@ptr_edit')->middleware('auth');
    Route::get('/pca/pre-training-review/pdf/{process_id}','PreTraining\PtrPCAController@ptr_pdf');
    Route::post('/pca/pre-training-review/save/{process_id}','PreTraining\PtrPCAController@save');
    
    //student
    Route::get('/my_ptr/{process_id}','PreTraining\PtrPCAController@student_ptr_pdf')->middleware('auth');
    
    //international
    Route::post('/pca/pre-training-review/save-intl/{process_id}','PreTraining\PtrPCAController@save_international');
    Route::get('/pca/pre-training-review/getpdflink/{process_id}/{student_id}','PreTraining\PtrPCAController@getpdflink');
});
