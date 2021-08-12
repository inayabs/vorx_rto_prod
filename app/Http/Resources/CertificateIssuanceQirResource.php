<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class CertificateIssuanceQirResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this);
        
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
                if($qualification->completion_status_id == 3 || $qualification->certificate->expected_course_completion != null){
                    
                    $cert_details = $qualification->certificate->details;
                    $release_date = "";
                    $cert_num = $qualification->certificate->manual_cert_num;
                    foreach($cert_details as $detail){
                        if(count($detail->units) == $units->count()){
                            $release_date = Carbon::parse($detail->release_date)->format('d/m/Y');
                            $arr_qir[] = [
                                'id'                => $this->id,
                                'fullname'          => $this->party->name,
                                'student_id'        => $this->student_id,
                                'student_type'      => $this->type->type,
                                'qualification'     => $course_name,
                                'course_code'       => $course_code,
                                'cert_no'           => $cert_num,
                                'date_issued'       => $release_date,
                                'rr_cert_no'        => $cert_num,
                                'rr_date_issued'    => $release_date,
                                'soa_no'            => '',
                                'soa_date_issued'   => '',
                                'status'           => 'cert',
                            ];
                        }
                    }  
                }
                // dump($arr_qir);


                    // SOA NUMBER AND ISSUED DATE
                    $soa_numbers = [];
                    $soa_dateIssued = [];
                    
                    if(!$qualification->certificate->details->isEmpty()){
                        $details = $qualification->certificate->details;
                            foreach($qualification->certificate->details as $detail){
                                $soa_numbers[] = $detail->soa_number;
                                $soa_dateIssued[] = Carbon::parse($detail->release_date)->format('d/m/Y');
                                // $soa_dateIssued[] = $detail->created_at->format('d/m/Y');

                                if(count($detail->units) !== $units->count()){
                                    $arr_qir[] = [
                                        'id'                => $this->id,
                                        'fullname'          => $this->party->name,
                                        'student_id'        => $this->student_id,
                                        'student_type'      => $this->type->type,
                                        'qualification'     => $course_name,
                                        'course_code'       => $course_code,
                                        'cert_no'           => '',
                                        'date_issued'       => '',
                                        'rr_cert_no'        => '',
                                        'rr_date_issued'    => '',
                                        'soa_no'            => implode(', ',$soa_numbers),
                                        'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                        'status'           => 'soa',
                                    ];
                                }
                                


                            }
                            // dump($qualification);
                            // dump($qualification->certificate->details);
                            // dump($qualification->course);
                            if($qualification->completion_date == null){
                                $arr_qir[] = [
                                    'id'                => $this->id,
                                    'fullname'          => $this->party->name,
                                    'student_id'        => $this->student_id,
                                    'student_type'      => $this->type->type,
                                    'qualification'     => $course_name,
                                    'course_code'       => $course_code,
                                    'cert_no'           => '',
                                    'date_issued'       => '',
                                    'rr_cert_no'        => '',
                                    'rr_date_issued'    => '',
                                    'soa_no'            => implode(', ',$soa_numbers),
                                    'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                    'status'           => 'soa',
                                ];
                            }elseif($qualification->completion_date != null){
                                    if($details->count()>1){
                                        $arr_qir[] = [
                                            'id'                => $this->id,
                                            'fullname'          => $this->party->name,
                                            'student_id'        => $this->student_id,
                                            'student_type'      => $this->type->type,
                                            'qualification'     => $course_name,
                                            'course_code'       => $course_code,
                                            'cert_no'           => '',
                                            'date_issued'       => '',
                                            'rr_cert_no'        => '',
                                            'rr_date_issued'    => '',
                                            'soa_no'            => implode(', ',$soa_numbers),
                                            'soa_date_issued'   => implode(', ',$soa_dateIssued),
                                            'status'           => 'both',
                                        ];
                                    }
                                    // if(is_array($_arr_qir)){
                                    //     $arr_qir = $_arr_qir;
                                    // }
                                    // dump($_arr_qir);
                            }
                        
                    }
            }

        }
        // $newlist = [];
        // // studentlist katong pic na imung gipakita
        // foreach($arr_qir as $key => $list){
        //   //check nmu if cert ug soa sya
        //   if(is_array($list)){
        //     foreach($list as $cert_soa){
        //       //push nmu sya into one array
        //       $newlist[$key] = $cert_soa;
        //     }
        //   }else{
        //     // etc
        //     $newlist[$key] = $list;
        //   }
        // }
        // dump($newlist);
// WALA NAKA BY GROUP PERO DILI MUDISPLAY INIG RETURN SA DATA
// $arr = [];
// for($i=0, $keyCount = count($arr_qir); $i < $keyCount; $i++){
//     if(count($arr_qir) > 1){
//         // dump($arr_qir[$i]);
//         foreach($arr_qir[$i] as $key => $value){
//             // dump($value);
//             $arr[$key] = $value;
//         }
//     }else{
//         $arr = $arr_qir[$i];
//     }
//     // dump($arr);
//  return $arr;
// }


// BY GROUP
// dump($arr_qir);
        // $qirList = array_merge($arr_qir, $_arr_qir);
        return $arr_qir;


        
    }
}