<?php

use App\Http\Controllers\API\Agent\AgentController;
use App\Http\Controllers\API\Agent\CommissionController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Student\StudentController;
use App\Http\Controllers\API\Student\StudentAttachmentController;
use App\Http\Controllers\API\DashboardController;
use App\Models\Agent;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/check-rto/{org_id}', 'Auth\LoginController@check_rto');


Route::post('login',[LoginController::class,'login']);
Route::delete('logout',[LoginController::class,'logout']);

Route::get('/test/student/{user}',[ StudentController::class, 'index' ]);
// Route::get('/test/student/{student}/course',[ StudentController::class, 'course' ]);
Route::get('/test/student/{student}/payments',[ StudentController::class, 'payments' ]);
Route::get('student/attachment/payment/preview/{hash}',[ StudentAttachmentController::class, 'previewPayment']);

Route::middleware(['auth:sanctum'])->group(function(){
    // default fetching 
    Route::get('defaults/all',[AgentController::class,'defaults']);

    Route::get('profile/',[AgentController::class,'profile']);
    Route::patch('/profile/update/{id}',[ AgentController::class, 'update' ]);

    /* Agent attachment */
    Route::get('profile/attachment/fetch',[ AgentController::class, 'fetchAllAttachment']);
    Route::get('profile/attachment/preview/{id}',[ AgentController::class, 'preview']);
    Route::post('profile/attachment/save',[ AgentController::class, 'saveAttachment']);
    Route::delete('profile/attachment/delete/{id}', [ AgentController::class, 'destroy']);
    Route::put('profile/attachment/rename/{id}', [ AgentController::class, 'rename']);

    /* Student */
    Route::get('/student/{student}',[ StudentController::class, 'show' ]);
    Route::get('/student/{student}/course',[ StudentController::class, 'course' ]);
    Route::get('/student/{student}/payments',[ StudentController::class, 'payments' ]);
    Route::post('/student/payments/{student_id}',[ StudentController::class, 'paymentsStore' ]);
    Route::post('/student/payments/update/{student_id}', [ StudentController::class, 'paymentsUpdate' ]);
    Route::get('/students/{user}',[ StudentController::class, 'index' ]);
    Route::patch('/student/info/{student}',[ StudentController::class, 'update' ]);

    /* Student attachment */
    Route::get('student/attachment/fetch/{student_id}',[ StudentAttachmentController::class, 'fetchAllAttachment']);
    Route::get('student/attachment/preview/{id}',[ StudentAttachmentController::class, 'preview']);
  
    Route::post('student/attachment/save/{student_id}',[ StudentAttachmentController::class, 'saveAttachment']);
    Route::delete('student/attachment/delete/{id}', [ StudentAttachmentController::class, 'destroy']);
    Route::put('student/attachment/rename/{id}', [ StudentAttachmentController::class, 'rename']);


    /* Commission */
    Route::get('commission',[ CommissionController::class, 'index']);
    Route::get('commission/{commission_serial}',[ CommissionController::class, 'commission']);

    /* Dashboard */
    Route::get('dashboard',[ DashboardController::class, 'index']);
    Route::get('notifications',[ DashboardController::class, 'notifications']);
    // student top - search
    Route::get('/search/{search}',[ DashboardController::class, 'top_search']);
    
    Route::post('/notification/update/{id}',[ DashboardController::class, 'updateNotification' ]);
});
