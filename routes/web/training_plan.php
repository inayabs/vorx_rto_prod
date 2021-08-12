<?php
Route::middleware(['rto'])->group(function () {
    Route::get('training_plan/{student_id}/{course}', 'TrainingPlan\TrainingPlanController@show');
    Route::get('training_plan/', 'TrainingPlan\TrainingPlanController@index');
    Route::resource('training_plan', 'TrainingPlan\TrainingPlanController');
});
