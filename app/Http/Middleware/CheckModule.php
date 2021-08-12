<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\TrainingOrganisation;
use Closure;

class CheckModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $addOn)
    {
        // dd(\Auth::user()->roles[0]->name);

        $menu = Menu::where('add_on_name', $addOn)->first();
        $subMenu = SubMenu::where('add_on_name', $addOn)->first();
        $role = \Auth::user()->roles[0]->name;
        $access = 0;
        $isDefault = 1;
        if($menu){
            $isDefault = $menu->is_default == 1 ? 1 : 0;
            foreach ($menu->role_access as $v) {
                if($v == $role){
                    $access = 1;
                }
            }
        }
        if($subMenu){
            $isDefault = $subMenu->is_default == 1 ? 1 : 0;
            foreach ($subMenu->role_access as $v) {
                if($v == $role){
                    $access = 1;
                }
            }
        }
        if($isDefault == 1){
            if($access == 0){
                abort(403);
            }
        }else{
            $app_setting = TrainingOrganisation::first();
            if($app_setting->add_on($addOn) == 0){
                abort(403);
            }
        }

        return $next($request);
    }
}
