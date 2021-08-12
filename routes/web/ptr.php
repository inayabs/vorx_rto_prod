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
Route::middleware(['rto'])->group(function () {
    Route::get('/ptr','PreTraining\PtrController@index');
    Route::get('/ptr/process/{process_id}','PreTraining\PtrController@show');
    Route::get('/ptr/pdf/{process_id}','PreTraining\PtrController@ptr_pdf');
    Route::post('/ptr/save/{process_id}','PreTraining\PtrController@save');
});