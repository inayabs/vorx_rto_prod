<?php

/*
|--------------------------------------------------------------------------
| Agent Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['rto'])->group(function () {
    Route::get('agent/list', 'Agents\AgentController@lists')->name('agent.list');
    Route::get('agent/list/search/{data}', 'Agents\AgentController@list_search');
    
    // show agent info
    Route::get('agent/show/info/{agent_id}', 'Agents\AgentController@agent_info');
    Route::post('agent/show/info/update/{agent_id}', 'Agents\AgentController@agent_info_update');
    
    // show agent commission
    Route::get('agent/show/commission/{agent_id}', 'Agents\AgentController@fetch_agent_commission');
    // show agent commission edit
    Route::get('agent/edit/commission/{commId}', 'Agents\AgentController@edit_agent_commission');
    // show agent commission save
    Route::post('/agent/save/commission/{id}', 'Agents\AgentController@agent_commission_save');
    // show agent commission delete
    Route::get('agent/delete/commission/{commId}', 'Agents\AgentController@delete_agent_commission');
    
    // agent attachments upload
    Route::post('agent/attachment/upload/{agent_id}', 'Agents\AgentAttachmentController@agent_attachment_upload');
    // agent attachments fetch
    Route::get('agent/attachment/fetch/{agent_id}', 'Agents\AgentAttachmentController@agent_attachment_fetch');
    // agent attachments delete
    Route::delete('agent/attachment/delete/{id}', 'Agents\AgentAttachmentController@agent_attachment_delete');
    // agent attachments preview
    Route::get('agent/attachment/preview/{id}', 'Agents\AgentAttachmentController@agent_attachment_preview');
    
    
    // agent commission report version 4 PDF
    Route::get('agent/commission-report-v4/{agent_id}', 'Agents\AgentCommissionController@agent_commission_report_v4');
    // agent commission report version 4 View
    Route::get('agent/commission-report-v4-view/{agent_id}', 'Agents\AgentCommissionController@agent_commission_report_v4_view');
    // agent commission report version 4 View toggle release button
    Route::post('agent/commission-report-v4-view/{agent_id}/toggle-release', 'Agents\AgentCommissionController@agent_commission_report_v4_toggle_release');
    
    // agent release commission
    Route::get('agent/commission-release/{agent_id}', 'Agents\AgentCommissionController@agent_release_commission');
    // agent release commission edit
    Route::get('agent/commission-release/{id}/edit', 'Agents\AgentCommissionController@agent_release_commission_edit');
    // agent release commission save
    Route::post('agent/commission-release-save/{id}', 'Agents\AgentCommissionController@agent_release_commission_save');
    
    Route::get('agent/{agent}/generate/commission', 'Agent\CommissionController@agent_commission_generate');
    

    
    //Agent Agreement
    Route::get('agent/{id}/generate_agent_agreement', 'Agents\AgentController@generate_agreement'); //generate after agent signed agent agreement (with agent's signature)
    Route::get('agent/application-email/{id}/send', 'Agents\AgentController@application_email'); // Resend Agent application Verification Email (with agent's signature)
    Route::get('agent/preview-agent-agreement/{id}', 'Agents\AgentController@agentAgreementView'); 
    
    // agent collection
    Route::get('agent/{id}/collections','Agents\AgentController@agentCollection');
    Route::get('agent/{id}/collections','Agents\AgentController@agentCollection');
    Route::post('agent/student-payments','Agents\AgentController@studentPayments');
    Route::post('agent/collection/action','Agents\AgentController@collectionAction');
    Route::get('agent/collection/{id}/decline','Agents\AgentController@declineCollection');
    Route::get('agent/get-transaction/{id}/{code}','Agents\AgentController@getTransaction');

    Route::get('/agent/collection/delete_sana_all','Agents\AgentController@sanaAll');

    // Resource
    Route::resource('agent', 'Agents\AgentController');
});

