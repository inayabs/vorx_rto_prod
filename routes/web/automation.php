<?php

/*
|--------------------------------------------------------------------------
| Agent Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['rto'])->group(function () {
    Route::get('automation', 'Automation\AutomationController@index')->name('automation.index');
    Route::post('automation/save', 'Automation\AutomationController@store');
    
    
    // warning letters for attendance
    Route::get('warning-letter/attendance/template/fetch', 'Automation\AttendanceEmailWarningController@fetch_email_warning_templates');
    Route::put('warning-letter/attendance/template/store', 'Automation\AttendanceEmailWarningController@save_email_warning_temnplate');
    
    // agent/referees reminder
    Route::get('agent-reminder/template/fetch', 'Automation\AgentReminderController@fetch_email_reminder_templates');
    Route::put('agent-reminder/template/store', 'Automation\AgentReminderController@save_email_reminder_template');
    Route::get('agent-reminder/test_send', 'Automation\AgentReminderController@send_agent_reminder');
});