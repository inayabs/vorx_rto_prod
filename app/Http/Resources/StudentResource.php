<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
        // dd($this);
        // return $this;
        // return [
        //     '_id' => $this->id,
        //     'id' => $this->party_id,
        //     'students' => ['id' => $this->id, 'student_id' => $this->student_id],
        //     'students.student_id' => $this->student_id,
        //     'party' => ['name' => $this->party->name],
        //     'type' => ['type' => $this->type == null ? 'N/A' : $this->type]
        // ];

        $course = "";
        $status = '';
        if ($this->type == 'International') {
            if ($this->latest_offer_letter != '') {
                if($this->latest_offer_letter->offer_course->course == null){
                    // dd($this->latest_offer_letter->offer_course);
                }
                // dump($this->latest_offer_letter->offer_course);
                $course = $this->latest_offer_letter->offer_course->course->name;
                if($this->latest_offer_letter->offer_course->status != null){
                    $status = $this->latest_offer_letter->offer_course->status->description;
                }
            }else{
                if($this->latest_funded_course){
                    if ($this->latest_funded_course->status != null) {
                        $status = $this->latest_funded_course->status->description;
                    }
                    $course = !in_array($this->latest_funded_course->course_code, ['@@@@', '1111']) ? $this->latest_funded_course->course->name : 'Unit of Competency';
                }
               
            }
        } else {
            // dd($this->latest_funded_course);
            if ($this->latest_funded_course) {
                if ($this->latest_funded_course->status != null) {
                    $status = $this->latest_funded_course->status->description;
                }
                $course = !in_array($this->latest_funded_course->course_code, ['@@@@', '1111']) ? $this->latest_funded_course->course->name : 'Unit of Competency';
            }
        }
        return [
            '_id' => $this->_id,
            'id' => $this->id,
            'student_id' => $this->student_id,
            'name' => $this->name,
            'type' => $this->type,
            'course' => $course,
            'status' => $status,
            'report_avetmiss' => $this->report_avetmiss,
        ];
    }
}
