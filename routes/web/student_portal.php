<?php
Route::middleware(['rto'])->group(function () {
    Route::get('/student-profile', 'StudentPortal\StudentProfileController@index');
    Route::post('student-profile/{student_id}/info-update', 'StudentPortal\StudentProfileController@info_update');
    Route::post('/profile/avatar', 'StudentPortal\StudentProfileController@avatar')->name('profile.avatar');
    Route::post('student-profile/{student_id}/contact-update', 'StudentPortal\StudentProfileController@contact_update');
    Route::get('/student-profile/contact-info', 'StudentPortal\StudentProfileController@contact_info');
    
    
    
    // single course attachments
    Route::get('/student-portal/single/course-attachments/{course_code}', 'Program\CourseAttachmentController@fetch_course_attachments_single');
    
    
    // commbank
    Route::get('/student-portal/commbank','StudentPortal\StudentProfileController@commbank');
});