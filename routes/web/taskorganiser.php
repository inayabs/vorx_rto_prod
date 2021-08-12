<?php
Route::middleware(['rto'])->group(function () {
    ROUTE::resource('task-organizer', 'TaskOrganizer\TaskOrganizerController');
});
