<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use DateTime;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Carbon\Carbon;
use File as Files;

use App\Models\Organisation;
use App\Models\TrainingDeliveryLoc;
use App\Models\CourseAvtDetail;

// AVT MODELS
use App\Models\Avetmiss\Avt10;
use App\Models\Avetmiss\Avt20;
use App\Models\Avetmiss\Avt30;
use App\Models\Avetmiss\Avt60;
use App\Models\Avetmiss\Avt80;
use App\Models\Avetmiss\Avt85;
use App\Models\Avetmiss\Avt90;
use App\Models\Avetmiss\Avt100;
use App\Models\Avetmiss\Avt120;
use App\Models\Avetmiss\Avt130;

use App\Models\Avetmiss\Avetmiss;
use App\Models\Avetmiss\AvtProcess;
use App\Models\Avetmiss\AvtStatus;
use App\Models\AvtAnzscoIdentifier;
use App\Models\AvtCompletionStatus;
use App\Models\AvtDisabilityTypes;
use App\Models\AvtPrgLvlOfEducIdentifier;
use App\Models\AvtPrgRecogIdentifier;
use App\Models\AvtQlfFieldOfEducIdentifier;
use App\Models\AvtStateIdentifier;
use Bdt\Avetmiss\Config;
use Bdt\Avetmiss\File;
// use Bdt\Avetmiss\Nat\V7;
// use Bdt\Avetmiss\Nat\V8;

// AVET V8 VENDOR
use Bdt\Avetmiss\Nat\V8\Nat010;
use Bdt\Avetmiss\Nat\V8\Nat020;
use Bdt\Avetmiss\Nat\V8\Nat030;
use Bdt\Avetmiss\Nat\V8\Nat060;
use Bdt\Avetmiss\Nat\V8\Nat080;
use Bdt\Avetmiss\Nat\V8\Nat085;
use Bdt\Avetmiss\Nat\V8\Nat090;
use Bdt\Avetmiss\Nat\V8\Nat100;
use Bdt\Avetmiss\Nat\V8\Nat120;
use Bdt\Avetmiss\Nat\V8\Nat130;

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
use App\Models\CertificateIssuanceDetail;
use App\Models\Course\Course;
use App\Models\CourseProspectus;
use App\Models\FundedCourseMatrices;
use App\Models\QualificationClassification;
use App\Models\StudentCertificateIssuance;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ConversionController extends Controller
{
    //


    public function convert()
    {
        // $this->courses();
        // $this->delivery_location();
        // $this->course_units();
        $this->student();
    }

    public function courses()
    {
        // dd('test');

        // $path = Storage::get('/app/conversion/StaySafe/With Data');
        $path = storage_path('app/conversion/StaySafe/With_Data/QUALIFICATIONS.csv');
        // dump($path);
        $data = array_map('str_getcsv', file($path));
        dd($data);

        // 0 => "QualificationCode"
        // 1 => "QualificationName"
        // 2 => "NominalHours"
        // 3 => "DefaultPrice"
        // 4 => "FinanceCode"
        // 5 => "vet_RecognitionID"
        // 6 => "vet_Level"
        // 7 => "vet_EducationID"
        // 8 => "vet_ANZSCO"
        // 9 => "vet_Flag"
        // 10 => "shortdescription"
        // 11 => "pageContent"


        foreach($data as $k => $v){
            if($k != 0 && count($v) > 1){
                dump($v);
                $qc = QualificationClassification::where('qual_code', $v[0])->first();
                $d = C::updateOrCreate(
                    [
                        'code' => trim(preg_replace('/\s+/', ' ', $v[0])),
                    ],
                    [
                        'code' => trim(preg_replace('/\s+/', ' ', $v[0])),
                        'name' => trim(preg_replace('/\s+/', ' ', $v[1])),
                        'tp_code' => $qc ? $qc->tp_code : null,
                        'is_active' => 1,
                        'user_id' => 1
                    ]
                );
        
                $dd = CAD::updateOrCreate(
                    [
                        'course_code' => trim(preg_replace('/\s+/', ' ', $v[0])),
                    ],
                    [
                        'course_code' => trim(preg_replace('/\s+/', ' ', $v[0])),
                        'nominal_hours' => trim(preg_replace('/\s+/', ' ', $v[2])) != '' ? trim(preg_replace('/\s+/', ' ', $v[2])) : null,
                        'prg_recog_identifier_id' => trim(preg_replace('/\s+/', ' ', $v[5])) != '' ? trim(preg_replace('/\s+/', ' ', $v[5])) : null,
                        'prg_lvl_of_educ_identifier_id' => trim(preg_replace('/\s+/', ' ', $v[6])) != '' ? trim(preg_replace('/\s+/', ' ', $v[6])) : null,
                        'qlf_field_of_educ_identifier_id' => trim(preg_replace('/\s+/', ' ', $v[7])) != '' ? trim(preg_replace('/\s+/', ' ', $v[7])) : null,
                        'anzsco_identifier_id' => trim(preg_replace('/\s+/', ' ', $v[8])) != '' ? trim(preg_replace('/\s+/', ' ', $v[8])) : null,
                        'vet_flag_status' => trim(preg_replace('/\s+/', ' ', $v[9])) != '' ? trim(preg_replace('/\s+/', ' ', $v[9])) : null,
                    ]
                );

                if(trim(preg_replace('/\s+/', ' ', $v[3])) != ''){
                    FundedCourseMatrices::updateOrCreate(
                        [
                            'course_code' => trim(preg_replace('/\s+/', ' ', $v[0])),
                            'location' => 'QLD'
                        ],
                        [
                            'course_code' => trim(preg_replace('/\s+/', ' ', $v[0])),
                            'location' => 'QLD',
                            'full_fee' => trim(preg_replace('/\s+/', ' ', $v[3]))
                        ]
                    );
                }

                dump('ok');
            }
        }
        

        dd('end');

    }

    public function delivery_location()
    {
        $path = storage_path('app/conversion/StaySafe/With_Data/DELIVERY_LOCATIONS.csv');
        // dump($path);
        $data = array_map('str_getcsv', file($path));

        // 0 => "id"
        // 1 => "DeliveryLocationId"
        // 2 => "DeliveryLocationName"
        // 3 => "Postcode"
        // 4 => "StateId"
        // 5 => "City"
        // 6 => "CountryId"

        dump($data);

        foreach($data as $k => $v){
            if($k != 0 && count($v) > 1){
                dump($v);
                $d = TDL::updateOrCreate(
                    [
                        'train_org_dlvr_loc_id' => trim(preg_replace('/\s+/', ' ', $v[1])),
                    ],
                    [
                        'training_organisation_id' => '40963',
                        'train_org_dlvr_loc_id' => trim(preg_replace('/\s+/', ' ', $v[1])),
                        'train_org_dlvr_loc_name' => trim(preg_replace('/\s+/', ' ', $v[2])),
                        'postcode' => trim(preg_replace('/\s+/', ' ', $v[3])),
                        'state_id' => '03',
                        'addr_location' => trim(preg_replace('/\s+/', ' ', $v[5])),
                        'country_id' => trim(preg_replace('/\s+/', ' ', $v[6])),
                        'user_id' => 1
                    ]
                );
                dump('ok');
            }
        }

        dd('end');
    }

    public function course_units()
    {
        $path = storage_path('app/conversion/StaySafe/With_Data/UNITS_OF_COMPETENCY.csv');
        // $path = storage_path('app/conversion/StaySafe/With_Data/QUALIFICATION_AND_UNIT.csv');
        // dump($path);
        $data = array_map('str_getcsv', file($path));

        // 0 => "UnitCode"
        // 1 => "UnitName"
        // 2 => "NominalHours"
        // 3 => "DefaultPrice"
        // 4 => "validityPeriod"
        // 5 => "vet_NTISendorsed"
        // 6 => "vet_EducationID"
        // 7 => "vet_Flag"
        // 8 => "DeliveryModeLegacy"
        // 9 => "WADeliveryModeLegacy"
        // 10 => "DeliveryMode"
        // 11 => "DeliveryModeRAPT"


        dump($data[0]);

        foreach($data as $k => $v){
            // dump(in_array($v[0], [null, '']));
            if($k != 0 && count($v) > 1 && !in_array(trim(preg_replace('/\s+/', ' ', $v[0])), [null, ''])){
                // dump($v);

                $d = Unit::updateOrCreate(
                    [
                        'code' => trim(preg_replace('/\s+/', ' ', $v[0])),
                    ],
                    [
                        'code' => trim(preg_replace('/\s+/', ' ', $v[0])),
                        'description' => trim(preg_replace('/\s+/', ' ', $v[1])) != '' ? trim(preg_replace('/\s+/', ' ', $v[1])) : null,
                        'subject_educ_fld_identifier_id' => null,
                        'vet_flag' => trim(preg_replace('/\s+/', ' ', $v[7])) != '' ? trim(preg_replace('/\s+/', ' ', $v[7])) : 0,
                        'nominal_hours' => trim(preg_replace('/\s+/', ' ', $v[2])) != '' ? trim(preg_replace('/\s+/', ' ', $v[2])) : 0,
                        'unit_fee' => trim(preg_replace('/\s+/', ' ', $v[3])) != '' ? trim(preg_replace('/\s+/', ' ', $v[3])) : 0.00
                    ]
                );
                
                // dump('ok');
            }
        }

        $path2 = storage_path('app/conversion/StaySafe/With_Data/QUALIFICATION_AND_UNIT.csv');

        $data2 = array_map('str_getcsv', file($path2));

        // 0 => "DiplomaID"
        // 1 => "DiplomaCode"
        // 2 => "Diploma"
        // 3 => "UnitID"
        // 4 => "UnitCode"
        // 5 => "Unit"
        // 6 => "CoreUnit"

        // dump($data2[0]);
        $course_unit = [];
        foreach($data2 as $k => $v){
            if($k != 0 ){
                $courseCode = trim(preg_replace('/\s+/', ' ', $v[1]));
                $unitCode = trim(preg_replace('/\s+/', ' ', $v[4]));
    
                if(!isset($course_unit[$courseCode])){
                    $course_unit[$courseCode] = [];
                }
    
                if(!in_array($unitCode, $course_unit[$courseCode])){
                    $course_unit[$courseCode][] = $unitCode;
                }
    
                // if(in_array())
                // $prospectus[trim(preg_replace('/\s+/', ' ', $v[1]))] =
                // $unit = Unit::where('code', trim(preg_replace('/\s+/', ' ', $v[4])));
                // if($unit){
                //     dump('existed');
                // }else{
                //     dump('none');
                // }
            }
        }

        $prospectus = [];
        foreach($course_unit as $key => $value){
            foreach($value as $v){
                $prospectus[$key][] = [
                    'code' => $v,
                    'train_org_dlvr_loc_id' => '',
                ];
            }
            $c = Course::where('code', $key)->first();
            if($c){
                CourseProspectus::updateOrCreate(
                    [
                        'course_code' => $c->code
                    ],
                    [
                        'course_code' => $c->code,
                        'name' => $c->name,
                        'location' => 'QLD',
                        'course_units' => json_encode($prospectus[$key]),
                        'is_active' => 1
    
                    ]
                );
            }
            $prospectus[$key] = json_encode($prospectus[$key]);
        }

        // dump($prospectus);
        dd('end');
    }

    public function student()
    {
        $variable = [];
        
        // CONTACTS
        $path = storage_path('app/conversion/StaySafe/With_Data/CONTACTS.csv');
        $data = array_map('str_getcsv', file($path));
        // dd($data[0]);
        foreach ($data as $k => $v) {
            if($k != 0 ){
                foreach ($v as $kk => $vv){
                    $variable[trim(preg_replace('/\s+/', ' ', $v[2]))][$data[0][$kk]] = trim(preg_replace('/\s+/', ' ', $vv)); 
                }
            }
        }

        // QUALIFICATION_ENROLMENTS
        $path = storage_path('app/conversion/StaySafe/With_Data/QUALIFICATION_ENROLMENTS.csv');
        $data = array_map('str_getcsv', file($path));
        // dd($data[0]);
        foreach ($data as $k => $v) {
            if($k != 0 ){
                foreach ($v as $kk => $vv){
                    $variable[trim(preg_replace('/\s+/', ' ', $v[0]))][$data[0][$kk]] = trim(preg_replace('/\s+/', ' ', $vv)); 
                }
            }
        }

        // QUALIFICATION_ENROLMENTS_AND_UNITS
        $p = storage_path('app/conversion/StaySafe/With_Data/QUALIFICATION_ENROLMENTS_AND_UNITS.csv');
        $d = array_map('str_getcsv', file($p));
        // dd($d[0]);
        foreach ($d as $k => $v){
            if($k != 0 ){
                $arr = [];
                foreach ($v as $kk => $vv){
                    $arr[$d[0][$kk]] = trim(preg_replace('/\s+/', ' ', $vv)); 
                }
                $variable[trim(preg_replace('/\s+/', ' ', $v[2]))]['get_units'][trim(preg_replace('/\s+/', ' ', $v[35]))][] = $arr;
            }
        }

        // AWARDS
        $p = storage_path('app/conversion/StaySafe/With_Data/AWARDS.csv');
        $d = array_map('str_getcsv', file($p));
        // dd($d[0]);
        foreach ($d as $k => $v){
            if($k != 0 ){
                $arr = [];
                foreach ($v as $kk => $vv){
                    $arr[$d[0][$kk]] = trim(preg_replace('/\s+/', ' ', $vv)); 
                }
                $variable[trim(preg_replace('/\s+/', ' ', $v[9]))]['get_awards'][] = $arr;
            }
        }

        // dd($variable['9165006']);

        
        $count = 0;
        $student_count = 0;
        // VARIABLE LOOP
        foreach($variable as $k => $v){
            $count++;
            $fullname = $this->is_null($v['GivenName']) ? $v['GivenName'] : '';
            $fullname .= $this->is_null($v['Surname']) ? ' '.$v['Surname'] : '';
            dump($fullname);
            // PARTY
            $party = Party::updateOrCreate(
                [
                    'name' => $fullname,
                    'conversion_id' => $k,
                ],
                [
                    'name' => $fullname,
                    'party_type_id' => 1,
                    'conversion_id' => $k,
                ]
            );

            // PERSON
            $gender = null;
            switch ($this->is_null($v['Gender'])) {
                case 'M':
                    $gender = 'Male';
                    break;
                case 'F':
                    $gender = 'Female';
                    break;
                default:
                    $gender = '@';
                    break;
            }
            $person = Person::updateOrCreate(
                [
                    'firstname' => $this->is_null($v['GivenName']),
                    'middlename' => $this->is_null($v['MName']),
                    'lastname' => $this->is_null($v['Surname']),
                    'date_of_birth' => $this->is_null($v['DOB']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($v['DOB']))->format('Y-m-d') : null
                ],
                [
                    'person_type_id' => 5,
                    'gender' => $gender,
                    'firstname' => $this->is_null($v['GivenName']),
                    'middlename' => $this->is_null($v['MName']),
                    'lastname' => $this->is_null($v['Surname']),
                    'date_of_birth' => $this->is_null($v['DOB']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($v['DOB']))->format('Y-m-d') : null,
                    'prefix' => $this->is_null($v['Title']) ? $this->is_null($v['Title']).'.' : null,
                ]
            );
            $person->party()->associate($party);
            $person->update();

            // STUDENT MODULE
            if(isset($v['studentId'])){
                $student_count++;
                // STUDENT
                $student = Student::updateOrCreate(
                    [
                        'student_id' => $this->is_null($v['studentId']),
                    ],
                    [
                        'student_id' => $this->is_null($v['studentId']),
                        'student_type_id' => 2,
                        'is_active' => 1,
                    ]
                );
                $student->party()->associate($party);
                $student->user()->associate(User::where('id',1)->first());
                $student->update();

                // STUDENT DETAILS
                $p_flag = null;
                switch ($this->is_null($v['priorEducation'])) {
                    case '@':
                        $p_flag = '@';
                        break;
                    case null:
                        $p_flag = 'N';
                        break;
                    default:
                        $p_flag = 'Y';
                        break;
                }
                $d_flag = null;
                switch ($this->is_null($v['DisabilityStatus'])) {
                    case 0:
                        $d_flag = 'N';
                        break;
                    case 1:
                        $d_flag = 'Y';
                        break;
                    default:
                        $d_flag = '@';
                        break;
                }
                $disabilities = $this->is_null($v['DisabilityValue']) ? explode(',', $this->is_null($v['DisabilityValue'])) : null;
                $disabilities = $disabilities ? AvtDisabilityTypes::whereIn('value', $disabilities)->get()->pluck('value') : null;
                if($disabilities){
                    $disabilities = $disabilities->count() > 0 ?  implode(',', $disabilities->toArray()) : '99';
                }
                $funded_details = FundedStudentDetails::updateOrCreate(
                   [
                       'student_id' => $this->is_null($v['studentId'])
                   ],
                   [
                       'student_id' => $this->is_null($v['studentId']),
                       'location' => $this->is_null($v['State']),
                       // 'funded_student_contact_detail_id' => $contact_details->id,
                       // 'name_for_encryption' => '',
                       // 'commence_prg_identifier' => $v->enrolment->commencing_program_id,
                       'highest_school_level_completed_id' => $this->is_null($v['HighestEducation']) ? sprintf("%02d", $this->is_null($v['HighestEducation'])) : '@@',
                       'indigenous_status_id' => $this->is_null($v['IndigenousStatus']) ? $this->is_null($v['IndigenousStatus']) : '@',
                       'language_id' => $this->is_null($v['Language']),
                       'labour_force_status_id' => $this->is_null($v['Employment']) ? sprintf("%02d", $this->is_null($v['Employment'])) : '@@',
                       'country_id' => $this->is_null($v['CountryofCitizen']) ? $this->is_null($v['CountryofCitizen']) : $this->is_null($v['CountryofBirth']),
                       'disability_flag' => $d_flag,
                       'disability_ids' => $disabilities,
                       'prior_educational_achievement_flag' => $p_flag,
                       'prior_educational_achievement_ids' => in_array($p_flag, ['@', null]) ? null : $this->is_null($v['priorEducation']),
                       'at_school_flag' => '@',
                       'unique_student_id' => $this->is_null($v['USI']),
                       'verified' => $this->is_null($v['USI_verified']) == 1 ? 1 : 0,
                       'survey_contact_status' => 'A',
                       'statistical_area_level_1_id' => '',
                       'statistical_area_level_2_id' => '',
                       'full_time_leaning_option' => 'Y'
                   ]
               );


               // STUDENT CONTACT DETAILS
               $address1 = explode(' ', $this->is_null($v['Address1']));
               $address2 = explode(' ', $this->is_null($v['Address2']));

               $addr = [
                    'unit_no' => [],
                    'building' => [],
                    'strt_no' => [],
                    'strt_name' => [],
               ];
               

            //    dump($addr);
            // if(!is_numeric($address1[0])){
                // dump('-----------------------------');
                // dump($this->is_null($v['Address1']));
                // dump($address1);
                // dump(is_numeric($address1[0]));
                // dump('-----------------------------');
                if(is_numeric($address1[0]) && isset($address1[1])){
                     $addr['strt_no'][] = $address1[0];
                     foreach($address1 as $addr1_key => $addr1_value){
                         if($addr1_key != 0){
                             $addr['strt_name'][] = $addr1_value;
                         }
                     }
                }elseif(is_numeric($address1[0]) && !isset($address1[1])){
                    $addr['unit_no'][] = $address1[0];

                    // check address 2 for additional information
                    // dump('-----------------------------');
                    // dump($this->is_null($v['Address1']));
                    // dump($address2);

                    $is_num = '';
                    foreach ($address2 as $addr2_key => $addr2_value) {
                        if($addr2_key == 0){
                            if(is_numeric($addr2_value)){
                                $is_num .= $addr2_value;
                            }
                        }else{
                            if(strpos($addr2_value, '/') != false){
                                $is_num .= $addr2_value;
                            }elseif(is_numeric($addr2_value)){
                                $is_num .= $addr2_value;
                            }else{
                                $addr['strt_name'][] = $addr2_value;
                            }
                        }

                    }
                    if(strpos($is_num, '/') != false){
                        $addr['unit_no'][] = $is_num;
                    }else{
                        $addr['strt_no'][] = $is_num;
                    }
                    
                    // dump('-----------------------------');

                    
                }elseif(!is_numeric($address1[0]) && isset($address1[1])){
                     $is_bldg = 0;
                     foreach($address1 as $addr1_key => $addr1_value){
                         if($addr1_key == 0){
                             if(strpos($addr1_value, '/') != false){
                                 $addr['unit_no'][] = $addr1_value;
                             }elseif(strpos($addr1_value, '-') != false){
                                 $addr['strt_no'][] = $addr1_value;
                             }else{
                                 $addr['building'][] = $addr1_value;
                                 $is_bldg = intval($addr1_value) == 0 ? 1 : 0;
                             }
                         }else{
                             if($is_bldg == 1){
                                 $addr['building'][] = $addr1_value;
                             }else{
                                 $addr['strt_name'][] = $addr1_value; 
                             }
                         }
                     }

                     if($is_bldg == 1){
                        // dump('-----------------------------');
                        // dump($this->is_null($v['Address1']));
                        // dump($address2);
    
                        $is_num = '';
                        foreach ($address2 as $addr2_key => $addr2_value) {
                            if($addr2_key == 0){
                                if(is_numeric($addr2_value)){
                                    $is_num .= $addr2_value;
                                }
                            }else{
                                if($addr2_value == '/'){
                                    $is_num .= $addr2_value;
                                }elseif(is_numeric($addr2_value)){
                                    $is_num .= $addr2_value;
                                }else{
                                    $addr['strt_name'][] = $addr2_value;
                                }
                            }
    
                        }
                        if(strpos($is_num, '/') != false){
                            $addr['unit_no'][] = $is_num;
                        }else{
                            $addr['strt_no'][] = $is_num;
                        }
                        
                        // dump('-----------------------------');
                     }
                }
 
 
 
                //  dump($addr);
                //  dd($address1);

            // }
                // $addr_suburb = AvtPostcode::where('id', $v->party->address->location_suburb_town)->first();
                // dd($v);
                $state = AvtStateIdentifier::where('state_key', $this->is_null($v['State']))->first();
                $contact_details = FundedStudentContactDetails::updateOrCreate(
                    [
                        'student_id' => $this->is_null($v['studentId'])
                    ],
                    [
                        'student_id' => $this->is_null($v['studentId']),
                        'addr_suburb' => $this->is_null($v['City']),
                        'addr_postal_delivery_box' => '',            
                        'addr_street_name' => count($addr['strt_name']) > 0 ? implode(' ', $addr['strt_name']) : null,           
                        'addr_street_num' => count($addr['strt_no']) > 0 ? implode(' ', $addr['strt_no']) : null,            
                        'addr_flat_unit_detail' => count($addr['unit_no']) > 0 ? implode(' ', $addr['unit_no']) : null,            
                        'addr_building_property_name' => count($addr['building']) > 0 ? implode(' ', $addr['building']) : null,            
                        'postcode' => $this->is_null($v['Postcode']),
                        'state_id' => $state ? $state->id : null,
                        'phone_home' => $this->is_null($v['HomePhone']),
                        'phone_work' => $this->is_null($v['WorkPhone']),
                        'phone_mobile' => $this->is_null($v['MobilePhone']),
                        'email' => $this->is_null($v['EmailAddress']),
                        // 'email_at' => $v->party->contact->email_work
                    ]
                );
                
                
                // STUDENT COURSE
                $cft = '';
                switch ($this->is_null($v['ConcessionType'])) {
                    case 'Not Specified':
                        $cft = 'FF';
                        break;
                    
                    case 'N - Non Concession':
                        $cft = 'NC';
                        break;
                    
                    case 'C - Concession':
                        $cft = 'C';
                        break;
                    
                    default:
                        $cft = 'FF';
                        break;
                }

                $status_id = null;
                switch ($this->is_null($v['enrolStatus'])) {
                    case 'Completed':
                        $status_id = 4;
                        break;
                    
                    case 'In Progress':
                        $status_id = 3;
                        break;
                    
                    case 'Cancelled':
                        $status_id = 5;
                        break;
                }

                $funded_course = FundedStudentCourse::updateOrCreate(
                    [
                        'student_id' => $this->is_null($v['studentId']),
                        'course_code' => $this->is_null($v['QualificationCode'])
                    ],
                    [
                        'student_id' => $this->is_null($v['studentId']),
                        'course_code' => $this->is_null($v['QualificationCode']),
                        'eligibility' => $this->is_null($v['FundingNational']) == 20 && $this->is_null($v['FundingState']) == 20 ? 'NE' : 'E',
                        'location' => $this->is_null($v['State']),
                        'start_date' => $this->is_null($v['dateCommenced']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($v['dateCommenced']))->format('Y-m-d') : null,
                        'end_date' => $this->is_null($v['DateCompleted']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($v['DateCompleted']))->format('Y-m-d') : null,
                        // 'course_fee' => trim($client_fee) == '' ? 0 : $client_fee,
                        'course_fee_type' => $cft,
                        'status_id' => $status_id,
                    ]
                );

                // STUDENT COURSE DETAIL
                $funded_course_detail = FundedStudentCourseDetail::where('funded_student_course_id', $funded_course->id)->first();
                if(isset($funded_course_detail->id)){
                    $funded_course_detail->fill([
                        'outcome_id_national' => null,
                        'funding_source_national' => $this->is_null($v['FundingNational']),
                        'commence_prg_identifier' => null,
                        'training_contract_id' => '',
                        'client_id_apprenticeships' => '',
                        'study_reason_id' => '@@',
                        'specific_funding_id' => null,
                        'funding_source_state_training_authority' => $this->is_null($v['FundingState']),
                        'purchasing_contract_id' => $this->is_null($v['ContractCode']),
                        'purchasing_contract_schedule_id' => $this->is_null($v['scheduleCode']),
                        'associated_course_id' => null,
                        'predominant_delivery_mode' => null,
                        'full_time_leaning_option' => 'Y',
                    ]);
                    $funded_course_detail->update();
                }else{
                    $funded_course_detail = new FundedStudentCourseDetail;
                    $funded_course_detail->fill([
                        'outcome_id_national' => null,
                        'funding_source_national' => $this->is_null($v['FundingNational']),
                        'commence_prg_identifier' => null,
                        'training_contract_id' => null,
                        'client_id_apprenticeships' => null,
                        'study_reason_id' => '@@',
                        'specific_funding_id' => null,
                        'funding_source_state_training_authority' => $this->is_null($v['FundingState']),
                        'purchasing_contract_id' => $this->is_null($v['ContractCode']),
                        'purchasing_contract_schedule_id' => $this->is_null($v['scheduleCode']),
                        'associated_course_id' => null,
                        'predominant_delivery_mode' => null,
                        'full_time_leaning_option' => 'Y',
                    ]);
                    $funded_course_detail->funded_student_course()->associate($funded_course);
                    $funded_course_detail->save();
                }


                // STUDENT COMPLETION
                $sc = StudentCompletion::updateOrCreate(
                    [
                        'student_id' => $funded_course->student_id,
                        'course_code' => $funded_course->course_code
                    ],
                    [
                        'student_id' => $funded_course->student_id,
                        'course_code' => $funded_course->course_code,
                        'completion_status_id' => $status_id == 4 ? 3 : 5,
                        'partial_completion' => 1,
                        'user_id' => 1,
                        'train_org_loc_id' => $this->is_null($v['deliveryLocationID']),
                    ]
                );
                
                
                // STUDENT COMPLETION DETAILS
                if(isset($v['get_units'][$funded_course->course_code])){
                    foreach($v['get_units'][$funded_course->course_code] as $uk => $uv){
                        $check_scd = StudentCompletionDetail::where('student_completion_id', $sc->id)->where('course_unit_code', $this->is_null($uv['unitCode']))->first();
                        $com_stat = $this->is_null($uv['unitCode']) ? AvtCompletionStatus::where('value',abs($this->is_null($uv['unitCode'])))->first() : null;
                        
                        $dm = null;
                        if($this->is_null($uv['DeliveryMode'])){
                            switch ($this->is_null($uv['DeliveryMode'])) {
                                case 'I':
                                    $dm = 'YNN';
                                    break;
                                case 'E':
                                    $dm = 'NYN';
                                    break;
                                case 'W':
                                    $dm = 'NNY';
                                    break;
                                case 'N':
                                    $dm = 'NNN';
                                    break;
                                
                                default:
                                    $dm = null;
                                    break;
                            }
                            $funded_course_detail->predominant_delivery_mode = $this->is_null($uv['DeliveryMode']);
                            $funded_course_detail->update();
                        }
                        
                        if(isset($check_scd->id)){
                            $check_scd->fill([
                                'course_unit_code' => $this->is_null($uv['unitCode']), 
                                'start_date' => $this->is_null($uv['dateCommenced']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($uv['dateCommenced']))->format('Y-m-d') : null, 
                                'end_date' => $this->is_null($uv['DateCompleted']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($uv['DateCompleted']))->format('Y-m-d') : null, 
                                'completion_status_id' => $com_stat ? $com_stat->id : null, 
                                'completion_date' => $this->is_null($uv['DateCompleted']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($uv['DateCompleted']))->format('Y-m-d') : null, 
                                'delivery_mode_id' => $dm,
                                'train_org_loc_id' => $this->is_null($v['deliveryLocationID'])
                            ]);
        
                        }else{
                            $check_scd = new StudentCompletionDetail;
                            $check_scd->fill([
                                'course_unit_code' => $this->is_null($uv['unitCode']), 
                                'start_date' => $this->is_null($uv['dateCommenced']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($uv['dateCommenced']))->format('Y-m-d') : null, 
                                'end_date' => $this->is_null($uv['DateCompleted']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($uv['DateCompleted']))->format('Y-m-d') : null, 
                                'completion_status_id' => $com_stat ? $com_stat->id : null, 
                                'completion_date' => $this->is_null($uv['DateCompleted']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($uv['DateCompleted']))->format('Y-m-d') : null, 
                                'delivery_mode_id' => $dm,
                                'train_org_loc_id' => $this->is_null($v['deliveryLocationID'])
                            ]);
                            $check_scd->completion()->associate($sc);
                            $check_scd->save();
                        }
                    
                    }
                }else{
                    dump(null);
                }

                // STUDENT CERTIFICATE ISSUANCE
                if(isset($v['get_awards'])){
                    foreach($v['get_awards'] as $ak => $av){
                        // student certificate issaunce model
                        $student_certificate_issuance = StudentCertificateIssuance::where('student_id', $funded_course->student_id)->where('student_completion_id', $sc->id)->first();
                        if($student_certificate_issuance){
                            $student_certificate_issuance->fill([
                                'student_id' => $funded_course->student_id,
                                'issued_date' => $this->is_null($av['dateIssued']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($av['dateIssued']))->format('Y-m-d') : null,
                                'generated_cert_num' => $this->is_null($av['certificateNo']),
                                'manual_cert_num' => $this->is_null($av['certificateNo']),
                                'user_id' => 1
                            ]);
                            $student_certificate_issuance->update();
                        }else{
                            $student_certificate_issuance = new StudentCertificateIssuance;
                            $student_certificate_issuance->fill([
                                'student_id' => $funded_course->student_id,
                                'issued_date' => $this->is_null($av['dateIssued']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($av['dateIssued']))->format('Y-m-d') : null,
                                'released_date' => $this->is_null($av['dateIssued']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($av['dateIssued']))->format('Y-m-d') : null,
                                'generated_cert_num' => $this->is_null($av['certificateNo']),
                                'manual_cert_num' => $this->is_null($av['certificateNo']),
                                'user_id' => 1
                            ]);
                            $student_certificate_issuance->completion()->associate($sc);
                            $student_certificate_issuance->save();
                        }

                        // certificate issuance details
                        $certificate_issuance_detail = CertificateIssuanceDetail::where('student_certificate_issuance_id', $student_certificate_issuance->id)->where('soa_number', $this->is_null($av['certificateNo']))->first();
                        if($certificate_issuance_detail){
                            $certificate_issuance_detail->fill([
                                'release_date' => $this->is_null($av['dateIssued']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($av['dateIssued']))->format('Y-m-d') : null,
                                'release' => $this->is_null($av['dateIssued']) ? 1 : 0,
                                'soa_number' => $this->is_null($av['certificateNo']),
                                'units' => []
                            ]);
                            $certificate_issuance_detail->update();
                        }else{
                            $certificate_issuance_detail = new CertificateIssuanceDetail;
                            $certificate_issuance_detail->fill([
                                'release_date' => $this->is_null($av['dateIssued']) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->is_null($av['dateIssued']))->format('Y-m-d') : null,
                                'release' => $this->is_null($av['dateIssued']) ? 1 : 0,
                                'soa_number' => $this->is_null($av['certificateNo']),
                                'units' => []
                            ]);
                            $certificate_issuance_detail->certificte_issuance()->associate($student_certificate_issuance);
                            $certificate_issuance_detail->save();
                        }
                    }

                    dump('Award Saved -'. $this->is_null($av['certificateNo']));
                }

            }

            // dd($v);
            
            dump('ok');
        }



        dump('Student Count - '.$student_count);
        dump('Total Count - '.$count);
        dd('end');

    }

    public function is_null($data){
        $null = ['', null, '0000-00-00', '0000-00-00 00:00:00'];
        $data = trim(preg_replace('/\s+/', ' ', $data));
        return !in_array($data, $null) ? $data : null;

    }
}
