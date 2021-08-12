<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Departments;

class ExternalFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function student(){
        return $this->belongsTo(Student::class,'student_id','student_id');
    }

    public function toArray($request)
    {
        // return parent::toArray($request);
        // $department = Departments::where('id', $this->department_type)->first();
        return [
            'id' => $this->id,
            // 'name' => $this->party->person->firstname . ' ' . $this->party->person->lastname,
            'student_id' => $this->student_id,
            'name'=>$this->name,
            'process_id' => $this->process_id,
            'form_type' => $this->form_type,
            'form_json' => $this->form_json,
            'status' => $this->status,
            // 'department_type' =>  $department['name'] != null ?  $department['name'] : 'N/A',
            'date_created' => $this->date_created
        ];
    }
}
