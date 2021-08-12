<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class RRCIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dump($this);
        // exit();
        $arr_qir = [];
        $_arr_qir = [];
        foreach($this->completion as $key => $qualification){
            // dd($qualification);
            if($qualification->certificate != null){
                if($qualification->course_code == '@@@@'){
                    $course_code = 'Unit of Competency';
                    $course_name = $qualification->completion_course->funded_course->uc_description;
                }else{
                    $course_code = $qualification->course->code;
                    $course_name = $qualification->course->name;
                }
                // CERTIFICATE
                $units = $qualification->details;
                    // SOA NUMBER AND ISSUED DATE
                    $soa_numbers = [];
                    $soa_dateIssued = [];
                    $soa_created = [];
                    $unit_code = null;
                    $unit_description = null;

                    // dump($units);
                    // dump($qualification->certificate->details);

                    if(!$qualification->certificate->details->isEmpty()){
                        $details = $qualification->certificate->details;
                        // dump($details->count());
                            foreach($qualification->certificate->details as $detail){
                                // dump($detail);
                                // dump(count($detail->units));
                                // dump($detail->units);
                                
                                if($detail->release == 0 && $detail->release_date != null){
                                
                                $soa_numbers[] = $detail->soa_number;
                                $soa_dateIssued[] = Carbon::parse($detail->release_date)->format('d/m/Y');
                                $soa_created[] = Carbon::parse($detail->created_at)->format('d/m/Y');

                                // dump($detail);  
                                // if(count($detail->units) !== $units->count()){
                                
                                    // dump('dsds');
                                    foreach($detail->units as $c){
                                        $unit_code = $c['code'];
                                        $unit_description = $c['description'];

                                        if($unit_code != null && $unit_code == 'CPCCWHS1001'){
                                            if($qualification->completion_date == null){
                                                $arr_qir[] = [
                                                    'id'                => $this->id,
                                                    'fullname'          => $this->party->name,
                                                    'student_id'        => $this->student_id,
                                                    'student_type'      => $this->type->type,
                                                    'dob'               => Carbon::parse($this->party->person->date_of_birth)->format('d/m/Y'),
                                                    'qualification'     => $course_name,
                                                    'course_code'       => $course_code,
                                                    'unit_code'         => $unit_code,
                                                    'unit_description'  => $unit_description,
                                                    'cert_no'           => '',
                                                    'date_issued'       => '',
                                                    'rr_cert_no'        => '',
                                                    'rr_date_issued'    => '',
                                                    'soa_no'            => implode(', ',$soa_numbers),
                                                    'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                                    'soa_date_created'  => implode(', ',$soa_created), 
                                                    'status'           => 'soa',
                                                ];
                                            }elseif($qualification->completion_date != null){
                
                                                if($details->count()>1){
                                                    $arr_qir[] = [
                                                        'id'                => $this->id,
                                                        'fullname'          => $this->party->name,
                                                        'student_id'        => $this->student_id,
                                                        'student_type'      => $this->type->type,
                                                        'dob'               => Carbon::parse($this->party->person->date_of_birth)->format('d/m/Y'),
                                                        'qualification'     => $course_name,
                                                        'course_code'       => $course_code,
                                                        'unit_code'         => $unit_code,
                                                        'unit_description'  => $unit_description,
                                                        'cert_no'           => '',
                                                        'date_issued'       => '',
                                                        'rr_cert_no'        => '',
                                                        'rr_date_issued'    => '',
                                                        'soa_no'            => implode(', ',$soa_numbers),
                                                        'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                                        'soa_date_created'  => implode(', ',$soa_created),
                                                        'status'           => 'both',
                                                    ];
                                                }
                                            }
                                        }
                                    }
                                
                                }
                            }    
                    }
            }

        }
        return $arr_qir;
    }
}