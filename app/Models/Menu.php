<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    //
    use SoftDeletes;

    protected $casts = ['role_access' => 'array'];

    // protected $fillable = [
    //     'order',
    //     'menu_name',
    //     'add_on_name'
    // ]

    public function sub_menus()
    {
        return $this->hasMany(SubMenu::class);
    }

    public function getSubMenuLinksAttribute()
    {
        $data = $this->hasMany(SubMenu::class)->get();
        $r = [];
        if($data) {
            foreach($data as $v){
                $r[] = explode('/',$v->link)[1];
            }
        }
        return $r;
    }

}
