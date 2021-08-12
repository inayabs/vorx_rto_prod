<?php

/*
|--------------------------------------------------------------------------
| Holidays Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['rto'])->group(function () {
    Route::post('holidays/store', 'Holidays\HolidayController@store');
    Route::get('holidays/list', 'Holidays\HolidayController@holiday_list');
    Route::get('holidays/info/{id}', 'Holidays\HolidayController@holiday_info');
    Route::delete('holidays/delete/{id}', 'Holidays\HolidayController@destroy');
    
    
    Route::resource('/holidays', 'Holidays\HolidayController');
});