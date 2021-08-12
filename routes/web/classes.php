<?php

/*
|--------------------------------------------------------------------------
| Attendance Sheet routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['rto'])->group(function () {
    Route::get('classes','StudentClass\StudentClassController@index')->name('classes.index');
    Route::post('classes/add_class','StudentClass\StudentClassController@add_class');
    Route::get('classes/class_list','StudentClass\StudentClassController@class_list');
    Route::get('classes/get_class_fields/{class_id}','StudentClass\StudentClassController@get_class_fields');
    Route::put('classes/update_class/{class_id}','StudentClass\StudentClassController@update_class');
    
    //attendance
    Route::get('classes/attendance/{id}','StudentClass\StudentClassController@attendance');
    Route::get('attendance/get_students/{type_id}/{class_id}','StudentClass\StudentClassController@get_students');
    Route::get('attendance/fetch_attendance/{class_id}','StudentClass\StudentClassController@fetch_attendance');
    Route::post('attendance/new_student_attendance','StudentClass\StudentClassController@new_student_attendance');
    Route::get('classes/student_attendance/{attendance_id}','StudentClass\StudentClassController@student_attendance');
    Route::post('attendance/new_student_attendance_detail','StudentClass\StudentClassController@new_student_attendance_detail');
    Route::post('attendance/update_student_attendance_detail','StudentClass\StudentClassController@update_student_attendance_detail');
    Route::get('attendance/get_student_attendance/{attendance_id}','StudentClass\StudentClassController@get_student_attendance');
    Route::get('attendance/get_student_attendance_detail_fields/{attendance_id}','StudentClass\StudentClassController@get_student_attendance_detail_fields');
    Route::get('attendance/get_preferred/{class_id}/{day}','StudentClass\StudentClassController@get_preferred');

    //attendance sheet pdf
    Route::get('attendance/pdf/{id}','StudentClass\StudentClassController@pdf');
    
    //delete
    Route::post('classes/delete_class','StudentClass\StudentClassController@delete_class');
    Route::post('classes/delete_student','StudentClass\StudentClassController@delete_student');
    Route::post('classes/delete_attendance_detail','StudentClass\StudentClassController@delete_attendance_detail');
    
    //students domestic
    Route::get('student/domestic/get_courses/{id}','StudentClass\StudentClassController@get_courses');
    Route::get('student/domestic/get_classes/{student_id}','StudentClass\StudentClassController@get_classes');
    Route::get('student/domestic/get_units/{student_id}/{course_code}','StudentClass\StudentClassController@get_units');
    
    //students intl
    Route::get('student/intl/get_avail_classes/{course_code}','StudentClass\StudentClassController@get_avail_classes');
    Route::post('student/intl/add_student_class','StudentClass\StudentClassController@add_student_class');
    Route::get('student/domestic/get_intl_student_attendance/{student_id}/{course_code}','StudentClass\StudentClassController@get_intl_student_attendance');
    Route::get('student/intl/get_package_units/{offer_letter_id}/{course_code}','StudentClass\StudentClassController@get_package_units');
    
    
    
    
    // time table
    Route::get('classes/{id}/time-table', 'StudentClass\TimeTableController@show')->name('class.time-table');
    Route::post('classes/time-table', 'StudentClass\TimeTableController@store')->name('class.store');
    Route::get('classes/{id}/time-table/reset', 'StudentClass\TimeTableController@reset')->name('class.reset');
    Route::get('classes/time-table/test', 'StudentClass\TimeTableController@test');
    
    
    // generate time table from start date
    Route::get('/generate-time-table/{start_date}/{class_id}/{funded_course}', 'StudentClass\TimeTableController@generate_time_table');
});