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
    // LLNTEST with student ID
    Route::get('/pca/lln-test', 'LLNTest\LLNTestPCAController@index');
    Route::post('/pca/lln-test/submit', 'LLNTest\LLNTestPCAController@llntest_submit');
    // Route::get('/pca/lln-test/process/{process_id}', 'LLNTest\LLNTestPCAController@show');
    Route::get('/pca/lln-test/get/{process_id}', 'LLNTest\LLNTestPCAController@edit');
    Route::get('/pca/lln-test/pdf/{process_id}', 'LLNTest\LLNTestPCAController@lln_preview');
    
    // Online LLNTEST w/o student ID
    Route::get('/pca/online-lln-test', 'LLNTest\OnlineLLNTestPCAController@index');
    Route::post('/pca/online-lln-test/submit', 'LLNTest\OnlineLLNTestPCAController@llntest_submit');
    Route::get('/pca/online-lln-test/assessor/{process_id}', 'LLNTest\OnlineLLNTestPCAController@assessor');
    Route::get('/pca/online-lln-test/get/{process_id}', 'LLNTest\OnlineLLNTestPCAController@edit');
    Route::get('/pca/online-lln-test/pdf/{process_id}', 'LLNTest\OnlineLLNTestPCAController@lln_preview');
    Route::get('/pca/online-lln-test/find/{process_id}', 'LLNTest\OnlineLLNTestPCAController@findCode');
});