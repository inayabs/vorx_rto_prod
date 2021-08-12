<?php

/*
|--------------------------------------------------------------------------
| Course Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['rto'])->group(function () {
    // Resource
    Route::resource('course-package', 'Program\CoursePackageController');
    Route::get('course-package/delete/{id}', 'Program\CoursePackageController@destroy')->name('course-package.delete');
    Route::get('course-packages/list', 'Program\CoursePackageController@course_package_list')->name('course-package.list');
    Route::put('course-packages/store-update', 'Program\CoursePackageController@course_package_store_update')->name('course-package.store_update');
    Route::get('course-packages/destroy/{id}', 'Program\CoursePackageController@course_package_details_destroy')->name('course-package.delete');
});
