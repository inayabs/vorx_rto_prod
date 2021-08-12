<?php

use App\Http\Controllers\Agent\CommissionController;

Route::middleware(['rto'])->group(function () {
    Route::get('commissions',[CommissionController::class,'commission_list']);
    Route::get('commission/list/{agent_id}',[CommissionController::class,'getCommission']);
    
});