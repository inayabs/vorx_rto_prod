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

// Resource
Route::middleware(['rto'])->group(function () {
    Route::get('course/list', 'Program\CourseController@course_list')->name('course.list');
    Route::get('course_options/list/{query}', 'Program\CourseController@course_option_list')->name('course_option.list');
    Route::resource('course', 'Program\CourseController');
    
    Route::get('course/delete/{id}', 'Program\CourseController@destroy')->name('course.delete');
    
    // Course List
    // Route::get('course/list', 'Program\CourseController@course_list')->name('course.list');
    // Route::post('course', 'Program\CourseController@store')->name('course.store');
    // Route::put('course', 'Program\CourseController@store')->name('course.update');
    
    // Course Info
    Route::get('course/show/info/{id}', 'Program\CourseController@course_info')->name('course.show.info');
    Route::post('course/show/info/update/{id}', 'Program\CourseController@course_info_update')->name('course.show.info.update');
    
    // Course Matrix
    Route::put('course/matrix/store-update/', 'Program\CourseController@course_matrix_store_update')->name('course.matrix.store_update');
    Route::get('course/matrix/destroy/{id}', 'Program\CourseController@course_matrix_destroy')->name('course.matrix.destroy');
    
    // Course Matrix
    Route::put('course/funded-matrix/store-update/', 'Program\CourseController@funded_course_matrix_store_update');
    Route::get('course/funded-matrix/destroy/{id}', 'Program\CourseController@funded_course_matrix_destroy');
    
    // Course Prospectus
    Route::get('course/prospectus/info/{id}', 'Program\CourseController@course_prospectus_info');
    Route::get('course/prospectus/list/{code}', 'Program\CourseController@course_prospectus_list')->name('course.prospectus.list');
    Route::put('course/prospectus/store-update', 'Program\CourseController@course_prospectus_store_update')->name('course.prospectus.store_update');
    Route::get('course/prospectus/destroy/{id}', 'Program\CourseController@course_prospectus_destroy')->name('course.prospectus.destroy');
    Route::get('course/prospectus/{state}', 'Program\CourseController@get_training_dlvr_loc');
    
    
    // course setup
    Route::get('course-setup', 'Program\CourseSetupController@index')->name('course-setup.index');
    Route::get('course-setup/course_options/list/{query}', 'Program\CourseSetupController@course_option_list')->name('course_option.list');
    
    Route::get('course-setup/unit_options/{query}', 'Program\CourseSetupController@course_unit_option_list')->name('course_option.unit.list');
    
    Route::post('course-setup/finish', 'Program\CourseSetupController@store')->name('course-setup.store');
    
    
    
    // course attachments
    Route::get('course/attachment/fetch/{course_code}', 'Program\CourseAttachmentController@fetch');
    Route::post('course/attachment/upload/{course_code}', 'Program\CourseAttachmentController@upload');
    Route::get('course/attachment/preview/{id}', 'Program\CourseAttachmentController@preview');
    Route::delete('course/attachment/delete/{id}', 'Program\CourseAttachmentController@destroy');
    Route::put('course/attachment/rename/{id}', 'Program\CourseAttachmentController@rename');
    Route::get('/course/attachment/download/{id}', 'Program\CourseAttachmentController@download');
    
    
    
    // course start date
    Route::get('course-dates/fetch/{start_date}/{class_id}/{course_id}', 'StudentClass\TimeTableController@fetch_course_dates');
});
