<?php

Route::middleware(['rto'])->group(function () {
    Route::get('usi/verify', 'Usi\UsiController@verify')->name('usi.verify');
    Route::get('usi/verify/success/{student_id}/{usi}', 'Usi\UsiController@verify_store')->name('usi.store');
    
    Route::get('usi/create', 'Usi\UsiController@create')->name('usi.create');
    Route::get('usi/updatePersonalDetails', 'Usi\UsiController@updatePersonalDetails')->name('usi.update-personal');
    Route::get('usi/updateContactDetails', 'Usi\UsiController@updateContactDetails')->name('usi.update-contact');
    Route::get('usi/locate', 'Usi\UsiController@locate')->name('usi.locate');
});
