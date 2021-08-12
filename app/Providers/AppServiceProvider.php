<?php

namespace App\Providers;

use App\Http\Controllers\HomeController;
use App\Models\Menu;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrganisation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        // dd(auth()->user());
        Schema::defaultStringLength(191);
        View::share('app_settings', TrainingOrganisation::all());
        View::share('sidebar_menu', Menu::with(['sub_menus'])->orderBy('order')->get());

        \JavaScript::put([
            'app_color' => TrainingOrganisation::all()[0]->app_color,
            'add_on' => explode(',',TrainingOrganisation::all()[0]->add_on),
        ]);
            
        // Laravel permissions - CREATE ROLES
        Role::findOrCreate('Super-Admin', 'web');
        Role::findOrCreate('User', 'web');
        Role::findOrCreate('Trainer', 'web');
        Role::findOrCreate('Staff', 'web');
        Role::findOrCreate('Demo', 'web');
        Role::findOrCreate('Student', 'web');
        Role::findOrCreate('Agent', 'web');
        Role::findOrCreate('Admin', 'web');

        View::share('NoDemoRole', implode('|', Role::where('name', '!=', 'Demo')->pluck('name')->toArray()) );

    }
}
