<?php

/*
|--------------------------------------------------------------------------
| Agent Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['rto'])->group(function () {
    //Online Agent Application
    Route::get('/agent-application-form', 'AgentApplication\AgentApplicationController@index');
    Route::post('/agent-application/save', 'AgentApplication\AgentApplicationController@store');
    Route::get('/agent-application/get/{process_id}', 'AgentApplication\AgentApplicationController@edit');
    Route::get('/agent-application/pdf/{process_id}', 'AgentApplication\AgentApplicationController@generate_pdf');
    Route::get('/agent-application/process/{process_id}', 'AgentApplication\AgentApplicationController@show');
    Route::post('/agent-application/finish/{process_id}', 'AgentApplication\AgentApplicationController@finish');
    
    Route::get('/reference-check/{process_id}', 'AgentApplication\AgentReferenceCheckController@index');
    Route::post('/reference-check/save', 'AgentApplication\AgentReferenceCheckController@store');
    Route::get('/reference-check/get/{process_id}/{agent_reference}', 'AgentApplication\AgentReferenceCheckController@edit');
    Route::get('/reference-check/pdf/{process_id}/{agent_reference}', 'AgentApplication\AgentReferenceCheckController@generate_pdf');
    
    // attachments
    Route::post('/agent-application/attachment/upload/{process_id}', 'AgentApplication\AgentApplicationAttachmentController@documents_upload');
    Route::get('/agent-application/attachment/fetch/{process_id}', 'AgentApplication\AgentApplicationAttachmentController@documents_fetch');
    Route::delete('/agent-application/attachment/delete/{id}', 'AgentApplication\AgentApplicationAttachmentController@documents_delete');
    Route::get('/agent-application/attachment/preview/{id}', 'AgentApplication\AgentApplicationAttachmentController@documents_preview');
    Route::put('/agent-application/attachment/rename/{id}', 'AgentApplication\AgentApplicationAttachmentController@rename');
    
    // Representative Agent list
    Route::get('/representative-agent', 'AgentApplication\RepresentativeAgentController@index');
    Route::get('/representative-agent/list', 'AgentApplication\RepresentativeAgentController@list');
    Route::post('/representative-agent/verify', 'AgentApplication\RepresentativeAgentController@verify_agent');
    Route::get('representative-agent/attachment/{process_id}', 'AgentApplication\RepresentativeAgentController@link_attachment');
    Route::get('agent-agreement/review/{process_id}','AgentApplication\RepresentativeAgentController@review_agent_agreement');
    Route::get('/agent-agreement/preview/{process_id}', 'AgentApplication\RepresentativeAgentController@agentAgreementView');
    Route::post('agent-agreement/review','AgentApplication\RepresentativeAgentController@review_agree');
});