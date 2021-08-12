<?php

namespace App\Http\Middleware;

use App\Http\Controllers\HomeController;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrganisation;
use Closure;

class RtoSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($request);
        // $tdl = TrainingDeliveryLoc::all();
        $to = TrainingOrganisation::all();
        $role = \Auth::user()->roles[0]->name;
        
        if($to[0]->is_setup == 0 && in_array($role, ['Admin', 'Super-Admin'])) {
            return redirect('/rto-configuration');
        }elseif($to[0]->is_setup == 0 && !in_array($role, ['Admin', 'Super-Admin'])) {
            abort(403);
        }

        return $next($request);
    }
}
