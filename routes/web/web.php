<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
// Route::get('/', function () {
    //     return view('welcome');
    // });
    Route::get('agent/generate/commission', 'Agent\CommissionController@index');
    Route::get('agent/view/{serial}/{agent}', 'Agent\CommissionController@view_commison_per_agent');

    
Route::middleware(['rto'])->group(function () {
    //student login
    Route::get('/student-login','Auth\LoginController@student_login');
    
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/dynamic-form', 'HomeController@dynamic_form')->name('dynamic-form');
    
    Route::get('/migrate-students', 'Migration\MigrationController@migrate_students')->name('migrate_students');
    
    Route::get('/get-user-nav', 'HomeController@get_user_nav');
    Route::get('/get-stud-status-alert', 'HomeController@student_status_alert');
    Route::get('/notifications', 'HomeController@notifs');
    Route::get('/view-notif/{id}', 'HomeController@view_notif');
    
    // SIA check students
    Route::get('/sia-check-students', 'Master\MasterController@sia_student_check');
    
    Route::get('/test-certificate', 'Master\MasterController@test_certificate');
    
    
    Route::group(['middleware' => 'web'], function () {
        Route::get('/centralized-login/{username}/{password}', 'Auth\LoginController@centralized_login');
        Route::get('/check-rto/{org_id}', 'Auth\LoginController@check_rto');
    });
    
    
    // fetch completed status enrolment applications
    Route::get('enrolment/fetch', 'HomeController@fetch_enrolments');


});
// rto configuration
Route::get('rto-configuration', 'HomeController@rto_config');
Route::post('rto-configuration/finish', 'HomeController@rto_config_finish');




