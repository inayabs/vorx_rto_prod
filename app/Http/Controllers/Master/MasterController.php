<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student\OfferLetter\OfferLetter;
use Illuminate\Http\Request;


// VORX RTO MODELS
use App\Models\Student\Student;
use App\Models\Student\Party;
use App\Models\Student\Person;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentCourseDetail;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentContactDetails;
use App\Models\StateIdentifier;
use App\Models\StudentCompletion;
use App\Models\StudentCompletionDetail;
use App\Models\AvtSub;
use App\Models\TrainingDeliveryLoc AS TDL;
use App\Models\TrainingOrganisation AS TO;
use App\Models\Course as C;
use App\Models\CourseAvtDetail as CAD;
use App\Models\AvtUnitEducationField;
use App\Models\StudentCertificateIssuance;
use App\Models\CertificateIssuanceDetail;
use App\Models\AvtCompletionStatus;
use App\Models\Unit;

class MasterController extends Controller
{
    //

    public function sia_student_check()
    {
        $sheet = [
            'course' => [
                'CPP30411','CPC30211','CPC40110','CPC30211','CPC40110','CPC30211','CPC30611','CPC30611','CPC30211','CPC30211','CPC40110','CPC30211','CPC40110','CPC30211','CPC40110','CPC30211','CPC40110','CPC40110','CPC30611','CPC30211','CPC40110','CPC30211','CPC30611','CPC30211','CPC40110','CPC30211','CPC30211','CPC40110','CPC40110','CPC40110','CPC30211','CPC40110','CPC30211','CPC40110','CPC40110','CPC30211','BSB61015','CPC30211','CPC40110','BSB61015','BSB61015','CPC30611','CPC30611','CPC30211','CPC40110','BSB51915','CPC40110','CPC40110','CPC30211','CPC30611','CPC40110','CPC30611','CPC30611','CPC30611','BSB51915','BSB51915','CPC40110','CPC30211','CPC40110','CPC30611','CPC30211','CPC40110','CPC30211','CPC30611','CPC30211','CPC30211','CPC40110','CPC30211','CPC40110','CPC40110','CPC30211','CPC30611','CPC40110','CPC30211','CPC40110','CPC30611','CPC40110','CPC30211','CPC30611','CPC30211','CPC30211','CPC30211','CPC30211','CPC30211','CPC40110','CPC40110','CPC30611','CPC30611','CPC30211','CPC40110','CPC40110','CPC40110','CPC40110','CPC40110','CPC40110','CPC40110','CPC30611','CPC30611','CPC30211','CPC30211','CPC40110','CPC40110','CPC40110','CPC40110','CPC30211','CPC40110','CPC40110','CPC30211','CPC40110','CPC30211','CPC40110','CPC30211','CPC30211','CPC30211','CPC30211','CPC30211','CPC40110','BSB51915','CPC30611','CPC30211','CPC30611','CPC40110','CPC30611','CPC30611','CPC30611','CPC40110','CPC40110','CPC40110','CPC30211','CPC40110','CPC40110','CPC30211','CPC30211','CPC30611','CPC40110','CPC40110','CPC40110','CPC30611','CPC40110','CPC40110','CPC30611','CPC30211','CPC30211','CPC30211','CPC30211','CPC30611','CPC30611','CPC30211','CPC40110','CPC30611','CPC40110','CPC30211','CPC30211','CPC30611','CPC40110','CPC30211','CPC30211','CPC40110','CPC40110','CPC40110','CPC40110','CPC40110','CPC30611','CPC30611','CPC30211','CPC40110','CPC40110','BSB51915','CPC30211','CPC30211','CPC30211','CPC30611','CPC40110','CPC30211','CPC30611','CPC30211','CPC40110','CPC30611','CPC30611','CPC30611','CPC30211','BSB61015','CPC40110','CPC40110','CPC40110','CPC40110','CPC40110','CPC30211','CPC40110'
            ],
            'firstname' => [
                'Janeczek','Janeczek','Janeczek','BIJAN','BIJAN','Kenan','Kenan','REZA','REZA','Tass Christopher','Tass Christopher','XUEWEI','XUEWEI','Craig Renton','Craig Renton','FOUAD','FOUAD','BELAL MAJDI ADBELQADER','MEHDI','LEI','LEI','ADAM','XUEGONG','BOHUMIL','SHENG','NITHARSAN','XIAOAO','Zhan','Xiang','JINTAO','Wessam','Wessam','Rauf','Rauf','Xin','Bryan','Mark Dominador','Misbah','Misbah','KARAN PARTAP SINGH','WASEEM','RENNAN','HAMID','MATUS','MATUS','SHEHAB YOUNES','Chung Ki','Kheiralla','AMIR','Saeid','CUMA','HASHEM','Mohammad','Qalbi Abbas','SAID MOHAMED','Bashir Abdullahi','MufeedFaraj Sabeeh','Brock John','Rafal Dariusz','Aliakbar','Danti Khnano Marcus','Danti Khnano Marcus','Aaron Michael','SHINOH','MUHIDIN','BLAIR KELVIN','BLAIR KELVIN','YAO RANG','YAO RANG','BOBAN','BOBAN','CHEE KWAI','CHRISTOPHE BAPTISTA','Riazati Keshe','Riazati Keshe','Mhd Hadi','KEVIN','KEVIN','MAZEN ABDULBASET','TONY','HANI','HAMAD','DAMIR','Ajay Kumar','Ajay Kumar','Amarjot Singh','AHMAD SHAH','Hadi','Shabaa','Shabaa','Nikolaos','Oliver','Angelo Ray','Adonia','MOHAMMAD TAHIR','HASSAN','ISMAEEL ABDULBASET','IBRAHIM ABDULBASET MOHAMMAD','DANIEL','ADAM','MICHAEL ROBERT','RAMAN','ARSHAD','SARKIS','HOANG HUU','HOANG HUU','GLEN DAVID','MUHAMMAD AMER','MUHAMMAD AMER','JINWOO ROY','WELLALA DON NISAN MADUSHANKA','Isah','ADNAN','BRENDAN G','GORAN','VICTOR','VEDRAN','JOHN','JAFFER','JIANZHOU','SAMI KHOSHABA ODEESHO','WILLIAM','TAHIR HUSSAIN','SANG KIL','HOSSAIN','JOHN','BIC','GABRIEL','DANG','SAMY','BENJAMIN JACOB','KAMAL SHUKRALLA SALIH','ZHENFAN','ALI','RICHARD SHAWKET','SANGWON','SAMER','ALI AHMAD','NAZIH BASHIR AZIZ','JOSHET FRANK','CRISTIAN','DAVID','ROMAIN RICHARD','MARIUSZ GRZEGORZ','ROBERT','SAMIR','ASHUR HURMIZ','JOSEF','FARZAD','MOHAMMAD HOSSEIN','SHAHRAM','HASSAN','MICHAEL JOHN','MOHAMMAD FARUK','BHUPINDER PAL','NILESH','DANIEL','PALWINDER','ANDREW','ASADULLAH','HARPREET SINGH','DHARAMJEET','HASSAN','HAMOODI','VELIMIR','HAYSSAM','FARHAD','MAYWAND','AHMAD','GIUSEPPE','MOUSTAFA','BABAK','ARIA','ROMAN','FANG','FANG','FANG','ARMIN','MIRCEA','SHAYAN','XINZHEN','MERVOLA','AHMAD','ALI REZA','GEORGE','SLOBODAN','WEI QIN','ABBAS SOLTANIAN','HAIYANG'
            ],
            'lastname' => [
                'Jan','Jan','Jan','SHAMSARIA','SHAMSARIA','Bicevic','Bicevic','BAHRAMIEH','BAHRAMIEH','Kalfas','Kalfas','CHEN','CHEN','Thomas','Thomas','REDA','REDA','HIHI','MEHD','SONG','SONG','SALAMI','ZHANG','RUZICKA','PENG','KARUNANITHY','YANG','Shi','Li','LIU','Alasadi','Alasadi','Hassani','Hassani','Jiang','Callaway','Mendoza','Jeelani','Jeelani','SAINI','AHMAD','ROSOLEM DOS SANTOS','MOHAMMADI','MONYOK','MONYOK','FARAGALLAH','Li','Mourched','SHAHBAHRAMI','Tafrashimonfared','CAPALI','SHAHED','Essa','Rana','ILMI','Yussuf','Almanahe','Sims','Skowron','Khedri','Zumaya','Zumaya','Grout','KANG','KADIC','THOMAS','THOMAS','OU','OU','JOVANOVIC','JOVANOVIC','LAI','RODRIGUES','Navid','Navid','Mehrat','KHOSRAVI','KHOSRAVI','SHEHOOD','KHA','DAVID','AL-AMERI','GOLUSIN','Trehan','Trehan','Gill','HAQIQATJO','Hassaini','Shabaa','Hatem','Merianos','Gozman','Pregliasco','Nwaya','NAWABI','GHASHAM','SHAHOUD','SHAHHOUD','CIRILLO','CIRILLO','RATTERY','CHHIKARA','MAHAMOOD','MERHI','NGUYEN','NGUYEN','BIGGS','KHAN','KHAN','LEE','THILAKAWARDENA','Makki','BIJEDIC','JOHNCOCK','MILIC','MORCOS','KNEZEVIC','WINSTON','HUSSAIN','DENG','ODEESHO','MAHFOUD','TURI','LEE','GULZARI','TRUONG','FOX','BESHARA','PHAM','ALAMEDDINE','EDWARDS','GEORGE','LI','EL-ASMAR','SOLOMON','LEE','HASSAN','REZAIE','WAHBA','MENJIVAR','ENE-MIRON','ZEMANEK','ANNE','MYCEK','MATUKIN','BRIKHA','ZIA','VOZENILEK','MAHDI','REZAEI YAZDI','HANIFEHPOUR','NIJATI','WITNEY','HUSSAIN','SINGH','LAL','SIMMONS','SINGH','ABOUNADER','BARAK','DANGI','SINGH','ALFRAJI','AL-OWICK','TALIC','ZREIKA','IBRAHIMI','HANIFI','IBRAHIM','STAFFIERI','KOUAIDER','HAJI ESMAIL ESFEHANI','REZAEI','HONZIK','YAN','YAN','YAN','MADADI','MITRULESCU','YAZDINEZHAD','HUANG','PATTIASINA','SALAMEH','HAJIAN','FAKHRI','DJORDJEVIC','ZHAO','BAJGIRAN','JIANG'
            ]
        ];


        
        $count = 0;
        foreach($sheet['firstname'] as $k => $v){
            $course = $sheet['course'][$k];
            $fname = $sheet['firstname'][$k];
            $lname = $sheet['lastname'][$k];
            $students = Student::with('completion', 'party.person')->whereHas('completion', function($q) use($course){
                $q->where('course_code', $course);
            })->whereHas('party', function($qq) use($fname, $lname) {
                $qq->where('name', 'like', '%'.strtoupper($fname).' '.strtoupper($lname).'%');
                // $qq->where('lastname', $lname);
            })->first();

            // dump($students);

            if($students){
                // dump($fname.' '.$lname.' - ' . $course. ' (existed)');
            }else{
                $count++;
                dump($fname.' '.$lname.' - ' . $course. ' (not existed)');
            }

        }
        
        dd('total -> '.$count);
        // 

    }


    public function test_certificate()
    {
        $student_id = '01310';
        $course_code = 'CPP20218';

        

        // $student = Student::with('contact_detail', 'funded_detail', 'funded_course.detail.fund_national', 'party.person', 'completion.certificate', 'completion.course','completion.details.unit', 'completion.details.status')->where('student_id', $student_id)->whereHas('completion', function($q) use($course_code) {
        //     $q->where('course_code', $course_code);
        // })->first();

        // $certificate['student'] = $student;

        // foreach($student->completion as $v){
        //     if($course_code == $v->course_code){
        //         $certificate['completion'] = $v;
        //     }
        // }

            // $completion = StudentCompletion::where('student_id', $student_id,)

            $certificate = CertificateIssuanceDetail::with('certificte_issuance.completion.details', 'certificte_issuance.completion', 'certificte_issuance.completion.course', 'certificte_issuance.student.party', 'certificte_issuance.student.funded_detail')->findOrFail(6);
            $com_status = AvtCompletionStatus::all();
            $statuses = [];
            foreach ($com_status as $cs) {
                $statuses[$cs->id] = $cs->status_code;
            }
            $base_units = $certificate->certificte_issuance->completion->details->count();
            $student = [
                'student_id' => $certificate->certificte_issuance->student->student_id,
                'vetrack' => ($certificate->certificte_issuance->student->funded_detail != null) ? $certificate->certificte_issuance->student->funded_detail->vetrack_id : null,
                'name'       => $certificate->certificte_issuance->studevnt->party->name,
                'dob'       => $certificate->certificte_issuance->student->party->person->date_of_birth,
                'cert_num'   => $base_units != count($certificate->units)  ?  $certificate->soa_number : $certificate->certificte_issuance->manual_cert_num,
                'soa_num'   => $certificate->soa_number,
                'course_code'     => $certificate->certificte_issuance->completion->course->code,
                'course_name'     => $certificate->certificte_issuance->completion->course->name,
                'release'   => $certificate->release,
                'release_date'   => $certificate->release_date,
                'reissued'   => $certificate->reissue,
                'reissued_date'   => $certificate->reissued_date,
            ];
            //  dd($student);
            // dd($certificate->certificte_issuance->completion->details);
            if (count($certificate->units)  > 15 && count($certificate->units) < 15) {
                $units = array_chunk($certificate->units, 35);
                $font = 10;
            } elseif (count($certificate->units) >= 15) {
                $units = array_chunk($certificate->units, 35);
                $font = 10;
            } else {
                $units[] = $certificate->units;
                $font = 10;
            }

            if ($certificate->certificte_issuance->completion->course->code == 'CHC30113') {
                $units = array_chunk($certificate->units, 35);
                $font = 14;
            }

            if ($certificate->certificte_issuance->completion->course->code == 'CPC50210') {
                $units = array_chunk($certificate->units, 35);
                $font = 14;
            }
            // dump($certificate);
            // dd($student);
            $cert_template = ($base_units != count($certificate->units) ? 'certificates.statement-of-attainment' : 'certificates.certificate');

            $cert_template = ($student['course_code'] == '1111' ? 'certificates.statement-of-attainment' : $cert_template);
            $file_name = $student['name'] . ' - (' . $student['course_code'] . ') ' . $student['course_name'] . ".pdf";

            if($student['course_code'] == '1111'){
                $student['course_code'] = $units[0][0]['code'];
                $student['course_name'] = $units[0][0]['description'];
            }

        // dd($certificate);

        // return view('certificates.sia-certificate', compact('certificate'));

        return \PDF::loadView('certificates.SIA-Certificates.certificate', compact('student', 'units', 'font', 'statuses'))->setPaper(array(0, 0, 595, 925))->stream('CEA-Certificate');
        // return \PDF::loadView('certificates.SIA-Certificates.statement-of-attainment', compact('student', 'units', 'font', 'statuses'))->setPaper(array(0, 0, 595, 925))->stream('CEA-Certificate');
    }


    public function update_completion_dates() {
        $data = StudentCompletion::where('course_code', 'CPP20218')->get(); 
        $students = [];
        foreach ($data as $k => $v) {
            
                $fsc = FundedStudentCourse::where('course_code', $v->course_code)->where('student_id', $v->student_id)->first();
                if($fsc){
                    if($fsc->end_date < date('Y-m-d') ){
                        $students[] = $fsc->toArray();
                        dump($fsc->toArray());
                        $v->completion_date = $fsc->end_date;
                        $v->update();
                    }
                }
        }
        dump(count($students));
        dd('end');
    }

    public function update_course_fees() {
        $data = FundedStudentCourse::whereBetween('start_date', ['2019-01-01', '2019-12-30'])->where('course_code', 'CPP30411')->get();
        $count = 1;
        // dd($data->count());
        foreach($data as $k => $v){
            // dump($v->matrices);

            // if($v->matrices) {
            //     // dump('naa');
            //     switch ($v->course_fee_type) {
            //         case 'NC':
            //             $v->course_fee = $v->matrices->non_concessional_fee;
            //             break;
            //         case 'C':
            //             $v->course_fee = $v->matrices->concessional_fee;
            //         break;
            //         case 'FF':
            //             $v->course_fee = $v->matrices->full_fee;
            //             # code...
            //             break;
                    
            //         default:
            //             # code...
            //             break;
            //     }
            //     $v->update();
            //     // dump($v->toArray());
            // }else{
            //     if($v->course_code == '1111'){
            //         // dump($v->course_code);
            //         $v->course_fee = '100.00';
            //         $v->course_code = '@@@@';
            //         $v->update();
            //         // dump($v->toArray());
            //     }
            // }
            
            // if($v->course_code == '1111'){

                $com = StudentCompletion::where('student_id', $v->student_id)->where('course_code', $v->course_code)->first();

                if($com){

                    // foreach ($com->details as $key => $value) {
                    //     $value->extra_unit = 1;
                    //     $value->update();
                    // }
                    if($com->details->count() == 3){
                        dump('refresher');
                        $v->course_fee_type = 'FF';
                        $v->course_fee = '300.00';
                        $v->update();
                    }
                    // if($v->end_date <= date('Y-m-d')){
                    //     // $com->completion_date = $v->end_date;
                    // }
                    // $com->update();
                    // $v->update();
                }

                // $v->update();
            // }

            // $course_fee = 
            $count++;
        }

        dump($count);
        dd('end');
    }


    public function update_student_created_at()
    {
        $student = Student::with('funded_course')->get();
        // dd($student[0]);
        foreach($student as $v) {
            
            if(isset($v->funded_course[0]->start_date) && substr($v->student_id, 0,1) == '0'){
                if($v->funded_course[0]->start_date < '2020'){
                    dump($v->student_id .' - '. $v->funded_course[0]->start_date);
                    // dump('update data');
                    $v->created_at = $v->funded_course[0]->start_date.' 00:00:00';
                    $v->update();

                    // dump('updated');
                }
            }
        }

        // dd('end')
    }


    public function teststudent($student_id){
        $student = Student::where('student_id',$student_id)->first();
        // dd($student);
        // dd(!$student->is_test);
        $student->is_test = !$student->is_test ? 1 : 0;
        $student->update();
        return response()->json(['status'=>'success']);
        // dd($student);
    }



}
