<?php

Route::middleware(['rto'])->group(function () {
    Route::get('/menu-list','Menu\MenuController@index');
    Route::get('/menu/list','Menu\MenuController@list');
    Route::post('/menu/update_order','Menu\MenuController@update_order');
    Route::post('/submenu/update_order','Menu\MenuController@update_order_submenu');
    Route::post('/menu/add','Menu\MenuController@add_menu');
    Route::post('/submenu/{id}/add','Menu\MenuController@submenu_add');
    Route::get('/menu/remove/{id}','Menu\MenuController@remove_menu');
    Route::get('/submenu/remove/{id}','Menu\MenuController@remove_submenu');
    Route::get('/menu/{id}','Menu\MenuController@menu_edit');
    Route::get('/menu/{id}/details','Menu\MenuController@menu_details');
    Route::post('/menu/update','Menu\MenuController@menu_update');
    Route::post('/submenu/update','Menu\MenuController@submenu_update');
});