<?php

/*
|--------------------------------------------------------------------------
| Unit Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['rto'])->group(function () {
    Route::resource('unit', 'Program\UnitController')->middleware('auth');
    
    Route::get('units/list', 'Program\UnitController@UnitList')->name('unit.list')->middleware('auth');
    Route::get('units/list/{query}', 'Program\UnitController@addUnitList')->name('unit.list-add')->middleware('auth');
    Route::get('unit/delete/{id}', 'Program\UnitController@destroy')->name('unit.delete');
    Route::get('unit_options/{search}', 'Program\UnitController@unit_option_list')->name('unit_option.list')->middleware('auth');
    Route::get('course_unit_options/{search}/{course_code}', 'Program\UnitController@course_unit_option_list')->name('unit_option.list')->middleware('auth');
    
    // Course Unit integration
    Route::get('course-unit/show/{course_code}', 'Program\UnitController@course_unit_show')->name('course-unit.show')->middleware('auth');
    Route::post('course-unit/create', 'Program\UnitController@store')->name('course-unit.store')->middleware('auth');
    Route::post('course-unit/remove', 'Program\UnitController@course_unit_remove')->name('course-unit.remove')->middleware('auth');
});

