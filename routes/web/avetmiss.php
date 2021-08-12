<?php

/*
|--------------------------------------------------------------------------
| Avetmiss Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Avetmiss Resource
// Route::resource('avetmiss', 'Avetmiss\AvetmissController');
Route::middleware(['rto'])->group(function () {
    Route::get('avetmiss/info', 'Avetmiss\AvetmissController@avetmiss_info');
    Route::get('avetmiss/create-process', 'Avetmiss\AvetmissController@create_process')->name('avetmiss.create-process')->middleware('auth');
    Route::get('avetmiss/delete-process/{process_id}', 'Avetmiss\AvetmissController@delete_process')->name('avetmiss.delete-process')->middleware('auth');
    // Avetmiss NAT process
    Route::post('avetmiss/generate', 'Avetmiss\AvetmissController@generate_natfile')->name('avetmiss.generate-natfile')->middleware('auth');
    
    Route::get('avetmiss', 'Avetmiss\AvetmissController@index')->name('avetmiss.index')->middleware('auth');
    Route::get('avetmiss/process-list', 'Avetmiss\AvetmissController@process_list')->name('avetmiss.process-list')->middleware('auth');
    Route::get('avetmiss/nat-count-list/{process_id}', 'Avetmiss\AvetmissController@nat_count_list')->name('avetmiss.nat-count-list')->middleware('auth');
    Route::get('avetmiss/download/{process_id}', 'Avetmiss\AvetmissController@download')->name('avetmiss.download')->middleware('auth');
    // toggle lock
    Route::post('avetmiss/toggle-lock', 'Avetmiss\AvetmissController@toggle_lock')->name('avetmiss.lock')->middleware('auth');
    
    // avetmiss converter
    Route::get('avetmiss/convert', 'Avetmiss\AvetmissConvertController@convert')->name('avetmiss.convert')->middleware('auth');
    
    // View logs from Nat files
    Route::get('avetmiss/view-log/{process_id}/{nat}', 'Avetmiss\AvetmissController@view_log_data')->middleware('auth');
    
    // save remarks
    Route::post('avetmiss/save-remarks', 'Avetmiss\AvetmissController@save_remarks')->middleware('auth');
});
