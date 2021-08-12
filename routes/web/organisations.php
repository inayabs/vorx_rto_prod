<?php

/*
|--------------------------------------------------------------------------
| Organization Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('organisation/list', 'Organisations\OrganisationController@get_organisation');
Route::get('organisation/{id}', 'Organisations\OrganisationController@show');
Route::get('organisation/show/{id}', 'Organisations\OrganisationController@organisation_info');
Route::post('organisation/store', 'Organisations\OrganisationController@organisation_info_store');
Route::post('organisation/show/update/{id}', 'Organisations\OrganisationController@organisation_info_update');
Route::delete('organisation/delete/{id}', 'Organisations\OrganisationController@organisation_delete');

// Training Delivery Location
Route::get('training-delivery-location', 'Organisations\OrganisationController@delivery_location')->name('training-delivery-location.index');
Route::get('training-delivery-location/generate', 'Organisations\OrganisationController@generate_string')->name('training-delivery-location.generate_string');
Route::post('organisation/{org_id}/delivery-location', 'Organisations\OrganisationController@delivery_location_store')->name('organisation-delivery-location.store');
Route::get('organisation/{id}/delivery-location/list', 'Organisations\OrganisationController@delivery_location_list')->name('organisation-delivery-location.list');
Route::get('organisation/{id}/delivery-location/show/{dl_id}', 'Organisations\OrganisationController@delivery_location_info')->name('organisation-delivery-location.show');
Route::delete('organisation/{id}/delivery-location/delete/{dl_id}', 'Organisations\OrganisationController@delivery_location_delete')->name('organisation-delivery-location.delete');


// upload/delete organisation logo
Route::post('organisation/upload-logo', 'Organisations\OrganisationController@upload_logo');
Route::get('organisation/delete-logo/{id}/{type}', 'Organisations\OrganisationController@delete_logo');

Route::post('organisation/{org_id}/bank', 'Organisations\OrganisationController@bank_details_store');
Route::get('organisation/{id}/bank/list', 'Organisations\OrganisationController@bank_list');
Route::get('organisation/{id}/bank/show/{bank_id}', 'Organisations\OrganisationController@bank_info');
Route::delete('organisation/{id}/bank/delete/{bank_id}', 'Organisations\OrganisationController@bank_delete');




// Organisation Resource
Route::resource('organisation', 'Organisations\OrganisationController');
