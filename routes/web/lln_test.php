<?php

/*
|--------------------------------------------------------------------------
| LLN Test Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['rto'])->group(function () {
    Route::get('/lln-test', 'LLNTest\LLNTestController@index');
    Route::get('/lln-test/process/{process_id}', 'LLNTest\LLNTestController@show');
    Route::get('/lln-test/get/{process_id}', 'LLNTest\LLNTestController@edit');
    Route::post('/lln-test/{process_id}/submit', 'LLNTest\LLNTestController@llntest_submit');
    Route::get('/lln-test/{process_id}/preview', 'LLNTest\LLNTestController@lln_preview');
    
    // Unit Of Competency LLN Test CEA
    Route::get('/unit-of-competency/lln-test', 'LLNTest\UnitOfCompetencyLLNTestController@index');
    Route::post('/unit-of-competency/lln-test/submit', 'LLNTest\UnitOfCompetencyLLNTestController@llntest_submit');
    Route::get('/unit-of-competency/lln-test/get/{process_id}', 'LLNTest\UnitOfCompetencyLLNTestController@edit');
    Route::get('/unit-of-competency/lln-test/pdf/{process_id}', 'LLNTest\UnitOfCompetencyLLNTestController@lln_preview');
    
    // Online LLNTEST w/o student ID
    Route::get('/online-lln-test', 'LLNTest\OnlineLLNTestController@index');
    Route::post('/online-lln-test/submit', 'LLNTest\OnlineLLNTestController@llntest_submit');
    Route::get('/online-lln-test/assessor/{process_id}', 'LLNTest\OnlineLLNTestController@assessor');
    Route::get('/online-lln-test/get/{process_id}', 'LLNTest\OnlineLLNTestController@edit');
    Route::get('/online-lln-test/pdf/{process_id}', 'LLNTest\OnlineLLNTestController@lln_preview');
    Route::get('/online-lln-test/find/{process_id}', 'LLNTest\OnlineLLNTestController@findCode');
});