<?php
Route::middleware(['rto'])->group(function () {
    route::get('/classes/trainer-classes','Trainers\TrainerPortalController@trainer_classes');
    route::get('/classes/trainer-classes/{id}/gettrainerclasses','Trainers\TrainerPortalController@getTrainerClasses');
    route::get('/classes/trainer-classes/{class_id}/class-units','Trainers\TrainerPortalController@class_units');
    route::post('/classes/trainer-classes/class-students','Trainers\TrainerPortalController@getStudentList');
    route::post('/classes/trainer-classes/clear-attendance','Trainers\TrainerPortalController@clear_attendance');
    route::post('/classes/trainer-classes/save-attendance','Trainers\TrainerPortalController@save_attendance');
    route::get('/nice/{class_id}/{date}/{code}','Trainers\TrainerPortalController@nice_one');//tester
    route::post('/classes/trainer-classes/get_pref_time','Trainers\TrainerPortalController@get_pref_time');
    
    
    //
    route::post('/classes/trainer-classes/class-students2','Trainers\TrainerPortalController@getStudentList2');
    route::post('/classes/trainer-classes/update_student_class_status','Trainers\TrainerPortalController@update_student_class_status');
    
    
    route::get('/classes/trainer-classes/update-status/{id}/{status}','Trainers\TrainerPortalController@update_status');
});