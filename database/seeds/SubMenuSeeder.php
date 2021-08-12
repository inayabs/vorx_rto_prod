<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('sub_menus')->insert([
            'menu_id' => 6,
            'order' => 3,
            'menu_name' => 'Commission Report',
            'add_on_name' => 'agent-commission',
            'fa_icon' => 'fas fa-coins',
            'link' => '/commissions',
            'dropdown' => 0,
            'is_default' => 1,
            'role_access' => '["Super-Admin", "Staff"]',
            'created_at' => Carbon::now(),
        ]);
    }
}
