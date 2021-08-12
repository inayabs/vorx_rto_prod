<?php
Route::middleware(['rto'])->group(function () {
    Route::get('state-funding', 'StateFunding\StateFundingController@state_funding')->name('state.funding');
    Route::get('state-funding/list', 'StateFunding\StateFundingController@state_funding_list')->name('state.funding-list');
    Route::post('state-funding', 'StateFunding\StateFundingController@store')->name('state.store');
    Route::get('funding-type', 'StateFunding\StateFundingController@fundingTypeIndex')->name('funding_type.index');
    Route::post('funding-type', 'StateFunding\StateFundingController@storeFunding')->name('funding_type.store');
    Route::delete('funding-type/{id}', 'StateFunding\StateFundingController@deleteFundingType');
    Route::delete('state-funding/{id}', 'StateFunding\StateFundingController@deleteStateFunding');
    Route::get('funding-type/list', 'StateFunding\StateFundingController@fundingTypeList')->name('funding_type.list');
});
