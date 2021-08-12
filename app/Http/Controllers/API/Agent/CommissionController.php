<?php

namespace App\Http\Controllers\API\Agent;

use App\Http\Controllers\Agent\CommissionController as AgentCommissionController;
use App\Http\Controllers\Controller;
use App\Models\AgentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
       $commissions =  Auth::user()->agent_details->commissions;
       if($commissions != null){
           return $commissions;
        //    return $commissions->load('commission_details.commission_sub');

       }
    }
    public function commission($serial){
        $agent = Auth::user()->agent_details;
        $c = new  AgentCommissionController;
        $settings = $c->view_commison_per_agent($serial,$agent);
        return $settings;
    }
}
