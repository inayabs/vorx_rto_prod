<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */


    public function toArray($request)
    {
        // return parent::toArray($request);
        // $department = Departments::where('id', $this->department_type)->first();
        return [
            'order' => $this->order,
            // 'name' => $this->party->person->firstname . ' ' . $this->party->person->lastname,
            'menu_name' => $this->menu_name,
            'add_on_name'=>$this->add_on_name,
            'fa_icon' => $this->fa_icon,
            'link' => $this->link,
            'dropdown' => $this->dropdown,
            'is_default' => $this->is_default,
            'role_access'=>$this->role_access,
        ];
    }
}
