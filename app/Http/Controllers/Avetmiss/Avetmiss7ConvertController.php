<?php

namespace App\Http\Controllers\Avetmiss;

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
use App\Models\AvtCompletionStatus;
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
use App\Models\StudentCertificateIssuance;
use App\Models\TrainingOrganisation;
use App\Models\Unit;

class Avetmiss7ConvertController extends Controller
{
    private $path = null;

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return $this->nat010();
        return view('avetmiss.index');
    }


    public function convert($convert = null)
    {

        $this->path = $convert ? storage_path('app/avetmiss/convert/'.$convert) : storage_path('app/avetmiss/convert/CEA/New/2017 AVETMISS Files (Queensland)');

        // dd(;
        if(!is_dir($this->path)){
            dd('No Directory Found...');
        }

        // $this->nat10(); -------> NOT NEEDED AS OF FOR NOW
        $this->nat20();
        $this->nat30();
        $this->nat60();
        $this->nat80();
        $this->nat85();
        $this->nat90();
        $this->nat100();
        $this->nat120();
        $this->nat130();
    }

    public function nat10()
    {
        $file_path = $this->path.'/NAT00010.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        $textCount = strlen($txt);
        // dump($txt);
        // dd($textCount);

        
        for($count = 0 ; $count < $textCount ; $count++){
            $nextLine = $count + 450;
            dump($count.' - '. $nextLine);
            $data = substr($txt,$count, 448);

            dd($data);

            // breakdown per row
            $train_org_id = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $train_org_name = trim(preg_replace('/\s+/', ' ', substr($data,10, 100)));
            $addr_line1 = trim(preg_replace('/\s+/', ' ', substr($data,112, 50)));
            $addr_line2 = trim(preg_replace('/\s+/', ' ', substr($data,162, 50)));
            $contact_name = trim(preg_replace('/\s+/', ' ', substr($data,268, 60)));
            $telephone_number = trim(preg_replace('/\s+/', ' ', substr($data,328, 20)));
            $fax = trim(preg_replace('/\s+/', ' ', substr($data,348, 20)));
            $email = trim(preg_replace('/\s+/', ' ', substr($data,368, 80)));

            $d = TO::updateOrCreate(
                [
                    'training_organisation_id' => $train_org_id
                ],
                [
                    'training_organisation_id' => $train_org_id,
                    'training_organisation_name' => $train_org_name,
                    'contact_name' => $contact_name,
                    'telephone_number' => $telephone_number,
                    'facsimile_number' =>  $fax,
                    'email_address' => $email
                ]
            );

            // dump($train_org_id);
            // dump($train_org_name);
            // dump($contact_name);
            // dump($telephone_number);
            // dump($fax);
            // dump($email);

            $count = $nextLine -1;

        }

        dump('NAT 10 - DONE');
        

    }

    public function nat20()
    {
        $file_path = $this->path.'/NAT00020.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);
        $data = [];
        $to = TrainingOrganisation::first();
        for($count = 0 ; $count < $textCount ; $count++){
            $nextLine = $count + 182;
            dump($count.' - '. $nextLine);
            $data = substr($txt,$count, 180);

            // dd($data);
            
            
            
            // breakdown per row
            $train_org_id = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $train_org_dlvry_loc_id = trim(preg_replace('/\s+/', ' ', substr($data,10, 10)));
            $train_org_dlvry_loc_name = trim(preg_replace('/\s+/', ' ', substr($data,20, 100)));
            $postcode = trim(preg_replace('/\s+/', ' ', substr($data,120, 4)));
            $state_id = trim(preg_replace('/\s+/', ' ', substr($data,124, 2)));
            $addr = trim(preg_replace('/\s+/', ' ', substr($data,126, 50)));
            $country_id = trim(preg_replace('/\s+/', ' ', substr($data,176, 4)));

            $d = TDL::where('train_org_dlvr_loc_id', $train_org_dlvry_loc_id)->first();

            if(!$d){
                $d = TDL::updateOrCreate(
                    [
                        'train_org_dlvr_loc_id' => $train_org_dlvry_loc_id,
                    ],
                    [
                        'training_organisation_id' => $to->training_organisation_id,
                        'train_org_dlvr_loc_id' => $train_org_dlvry_loc_id,
                        'train_org_dlvr_loc_name' => $train_org_dlvry_loc_name,
                        'postcode' => $postcode,
                        'state_id' => $state_id,
                        'addr_location' => $addr,
                        'country_id' => $country_id,
                        'is_active' => 0
                    ]
                );
            }else{
                $d->is_active = 0;
                $d->update();
            }
            
            $count = $nextLine - 1;
        }


        dump('NAT 20 - Done');
    }


    public function nat30()
    {
        $file_path = $this->path.'/NAT00030.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);

        // dd($textCount);

        $data = [];
        for($count = 0 ; $count < $textCount ; $count++){
            $nextLine = $count + 132;
            // dump($count.' - '. $nextLine);
            $data = substr($txt,$count, 130);
            
            // dump($data);

            // breakdown per row
            $code = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $name = trim(preg_replace('/\s+/', ' ', substr($data,10, 100)));
            $nominal_hours = trim(preg_replace('/\s+/', ' ', substr($data,110, 4)));
            $prg_recog_identifier_id = trim(preg_replace('/\s+/', ' ', substr($data,114, 2)));
            $prg_lvl_of_educ_identifier_id = trim(preg_replace('/\s+/', ' ', substr($data,116, 3)));
            $qlf_field_of_educ_identifier_id = trim(preg_replace('/\s+/', ' ', substr($data,119, 4)));
            $anzsco_identifier_id = trim(preg_replace('/\s+/', ' ', substr($data,123, 6)));
            $vet_flag_status = trim(preg_replace('/\s+/', ' ', substr($data,129, 1)));
            // $postcode = trim(preg_replace('/\s+/', ' ', substr($data,120, 4)));
            // $state_id = trim(preg_replace('/\s+/', ' ', substr($data,124, 2)));
            // $addr = trim(preg_replace('/\s+/', ' ', substr($data,126, 50)));
            // $country_id = trim(preg_replace('/\s+/', ' ', substr($data,176, 4)));

            // dump($code);
            // dump($name);
            // dump($nominal_hours);

            $c = C::where('code', $code)->first();
            // dd($c);
            if(!$c){
                $d = C::updateOrCreate(
                    [
                        'code' => $code,
                    ],
                    [
                        'code' => $code,
                        'name' => $name,
                    ]
                );
    
                $dd = CAD::updateOrCreate(
                    [
                        'course_code' => $code,
                    ],
                    [
                        'course_code' => $code,
                        'nominal_hours' => $nominal_hours,
                        'prg_recog_identifier_id' => $prg_recog_identifier_id,
                        'prg_lvl_of_educ_identifier_id' => $prg_lvl_of_educ_identifier_id,
                        'qlf_field_of_educ_identifier_id' => $qlf_field_of_educ_identifier_id,
                        'anzsco_identifier_id' => $anzsco_identifier_id,
                        'vet_flag_status' => $vet_flag_status == 'Y' ? 1 : 0
                    ]
                );
            }else{
                dump($code.' Course Existed...');
            }
            
            $count = $nextLine - 1;
        }

        // dd('test');
        dump('NAT 30 - Done');
        dump('--------------------------------------------------------------');
    }


    public function nat60()
    {
        $file_path = $this->path.'/NAT00060.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);

        // dd($textCount);

        $data = [];
        for($count = 0 ; $count < $textCount ; $count++){
            $nextLine = $count + 126;
            // dump($count.' - '. $nextLine);
            $data = substr($txt,$count, 124);
            
            // dd($data);
            
            // breakdown per row
            $code = trim(preg_replace('/\s+/', ' ', substr($data,1, 12)));
            $description = trim(preg_replace('/\s+/', ' ', substr($data,13, 100)));
            $subject_field_of_educ = trim(preg_replace('/\s+/', ' ', substr($data,113, 6)));
            $vet_flag = trim(preg_replace('/\s+/', ' ', substr($data,119, 1)));
            $nominal_hours = trim(preg_replace('/\s+/', ' ', substr($data,120, 4)));
            // $postcode = trim(preg_replace('/\s+/', ' ', substr($data,120, 4)));
            // $state_id = trim(preg_replace('/\s+/', ' ', substr($data,124, 2)));
            // $addr = trim(preg_replace('/\s+/', ' ', substr($data,126, 50)));
            // $country_id = trim(preg_replace('/\s+/', ' ', substr($data,176, 4)));

            dump($code);
            dump($description);
            dump($nominal_hours);
            // dd('test');

            $subjFldEduc = AvtUnitEducationField::where('id', $subject_field_of_educ)->first();

            $d = Unit::updateOrCreate(
                [
                    'code' => $code,
                ],
                [
                    'code' => $code,
                    'description' => $description,
                    'subject_educ_fld_identifier_id' => isset($subjFldEduc->id) ? $subjFldEduc->id : null,
                    'vet_flag' => $vet_flag == 'Y' ? 1 : 0,
                    'nominal_hours' => $nominal_hours,
                ]
            );

            $count = $nextLine - 1;
        }


        dump('NAT 60 - Done');
    }


    public function nat80()
    {
        $file_path = $this->path.'/NAT00080.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);

        // dd($textCount);

        $data = '';
        $number = 0;
        $nextLine = 0;
        for($count = 0 ; $count < $textCount ; $count++){
            $number++;
            
            // if($data == ''){
                $data = substr($txt,$count, 343);
                // $nextLine = $count + 339;
            // }
            dump($data);
            
            if(strpos(substr($data,341, 343), "\n") !== FALSE) {
                $nextLine = $count + 343;
                $data = substr($txt,$count, 341);

            }else{
                $data = substr($txt,$count, 349);

                if(strpos(substr($data,347, 349), "\n") !== FALSE){
                    // dd('test');
                    $nextLine = $count + 349;
                    $data = substr($txt,$count, 347);
                
                }else{
                    $data = substr($txt,$count, 353);

                    if(strpos(substr($data,351, 353), "\n") !== FALSE) {
                        $nextLine = $count + 353;
                        $data = substr($txt,$count, 351);
                    }else{
                        dd('Data has a problem. please fix');
                    }
                }
            }

            dump($count.' - '. $nextLine);
            // dump($count);
            // dd($data);
            // dump(substr($data,0, 10));
            

            // $nextLine = $count + 359;
            // $nextLine = $count + 339;
            
            // $data = substr($txt,$count, 357);
            // $data = substr($txt,$count, 337);

            // $data = substr($txt, 20679, 349);

            // dump(substr($data,347, 349));

            

            // dd($data);
            
            $prefix = TO::first()->student_id_prefix;

            // breakdown per row
            // $student_id = $prefix.''.trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $student_id = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $name_encryp = explode(', ',trim(preg_replace('/\s+/', ' ', substr($data,10, 60))));
            $hghst_schl = trim(preg_replace('/\s+/', ' ', substr($data,70, 2)));
            $gender = trim(preg_replace('/\s+/', ' ', substr($data,76, 1)));
            $date_of_birth = trim(preg_replace('/\s+/', ' ', substr($data,77, 8)));
            $postcode = trim(preg_replace('/\s+/', ' ', substr($data,85, 4)));
            $indigenous = trim(preg_replace('/\s+/', ' ', substr($data,89, 1)));
            $lang = trim(preg_replace('/\s+/', ' ', substr($data,90, 4)));
            $labour = trim(preg_replace('/\s+/', ' ', substr($data,94, 2)));
            $country_id = trim(preg_replace('/\s+/', ' ', substr($data,96, 4)));
            $disability_flag = trim(preg_replace('/\s+/', ' ', substr($data,100, 1)));
            $prior_educ = trim(preg_replace('/\s+/', ' ', substr($data,101, 1)));
            $at_school_flag = trim(preg_replace('/\s+/', ' ', substr($data,102, 1)));
            $addr = trim(preg_replace('/\s+/', ' ', substr($data,104, 50)));
            $usi = trim(preg_replace('/\s+/', ' ', substr($data,154, 10)));
            $state_id = trim(preg_replace('/\s+/', ' ', substr($data,164, 2)));
            $addr_bldg = trim(preg_replace('/\s+/', ' ', substr($data,166, 50)));
            $addr_unit = trim(preg_replace('/\s+/', ' ', substr($data,216, 30)));
            $addr_street_number = trim(preg_replace('/\s+/', ' ', substr($data,246, 15)));
            $addr_street_name = trim(preg_replace('/\s+/', ' ', substr($data,261, 70)));
            // $survey_contact_status = trim(preg_replace('/\s+/', ' ', substr($data,326, 1)));
            // dump($name_encryp);
            $name = isset($name_encryp[1]) ? $name_encryp[1] : '';
            $name .= isset($name_encryp[0]) ? ' '.$name_encryp[0] : '';
            $arr = [
                'student_id' => $student_id,
                'name_encryp' => $name,
                'hghst_schl' => $hghst_schl,
                'gender' => $gender,
                'date_of_birth' => $date_of_birth,
                'postcode' => $postcode,
                'indigenous' => $indigenous,
                'labour' => $labour,
                'country_id' => $country_id,
                'disability_flag' => $disability_flag,
                'prior_educ' => $prior_educ,
                'at_school_flag' => $at_school_flag,
                'addr' => $addr,
                'usi' => $usi,
                'state_id' => $state_id,
                'addr_bldg' => $addr_bldg,
                'addr_unit' => $addr_unit,
                'addr_street_number' => $addr_street_number,
                'addr_street_name' => $addr_street_name,
                // 'survey_contact_status' => $survey_contact_status,
            ];

            dump($arr);
            
            $studentExist = Student::with('party.person')->where('student_id', $student_id)->first();
           
            // dd($arr);
            // dd($studentExist);

            if(!$studentExist){

                // party
                $party = Party::updateOrCreate(
                    [
                        'name' => $name,
                    ],
                    [
                        'name' => $name,
                        'party_type_id' => 1,
                    ]
                );

                // person
                $person = Person::updateOrCreate(
                    [
                        'firstname' => isset($name_encryp[1]) ? $name_encryp[1] : '',
                        'lastname' => isset($name_encryp[0]) ? $name_encryp[0] : '',
                        'date_of_birth' => trim($date_of_birth) != '' ? Carbon::createFromFormat('dmY', $date_of_birth)->format('Y-m-d') : null
                    ],
                    [
                        'person_type_id' => 5,
                        'gender' => $gender == "M" ? 'Male' : 'Female',
                        'firstname' => isset($name_encryp[1]) ? $name_encryp[1] : '',
                        'lastname' => isset($name_encryp[0]) ? $name_encryp[0] : '',
                        'date_of_birth' => trim($date_of_birth) != '' ? Carbon::createFromFormat('dmY', $date_of_birth)->format('Y-m-d') : null
                        // 'prefix' => $v->party->person->prefix,
                    ]
                );
                $person->party()->associate($party);
                $person->update();
            
            }else{
                $party = $studentExist->party;
                $person = $studentExist->party->person;
            }

                // student
                $student = Student::updateOrCreate(
                    [
                        'student_id' => $student_id,
                    ],
                    [
                        'student_id' => $student_id,
                        'party_id' => $party->id,
                        'student_type_id' => 2,
                        'is_active' => 1,
                    ]
                );
                $student->party()->associate($party);
                $student->user()->associate(\Auth::user());
                $student->update();

                 // student detail
                 $state = AvtStateIdentifier::where('value', $state_id)->first();
                 $funded_details = FundedStudentDetails::updateOrCreate(
                    [
                        'student_id' => $student_id
                    ],
                    [
                        'student_id' => $student_id,
                        'location' => isset($state->id) ? $state->state_key : '',
                        // 'funded_student_contact_detail_id' => $contact_details->id,
                        // 'name_for_encryption' => '',
                        // 'commence_prg_identifier' => $v->enrolment->commencing_program_id,
                        'highest_school_level_completed_id' => $hghst_schl,
                        'indigenous_status_id' => $indigenous,
                        'language_id' => $lang,
                        'labour_force_status_id' => $labour,
                        'country_id' => $country_id,
                        'disability_flag' => $disability_flag == '@' ? 'N' : $disability_flag,
                        'disability_ids' => null,
                        'prior_educational_achievement_flag' => $prior_educ == '@' ? 'N' : $prior_educ,
                        'prior_educational_achievement_ids' => null,
                        'at_school_flag' => $at_school_flag == '@' ? 'N' : $at_school_flag,
                        'unique_student_id' => $usi,
                        // 'survey_contact_status' => $survey_contact_status,
                        'statistical_area_level_1_id' => '',
                        'statistical_area_level_2_id' => '',
                        'full_time_leaning_option' => 'Y'
                    ]
                );


                // contact details
                // $addr_suburb = AvtPostcode::where('id', $v->party->address->location_suburb_town)->first();
                $contact_details = FundedStudentContactDetails::updateOrCreate(
                    [
                        'student_id' => $student_id
                    ],
                    [
                        'student_id' => $student_id,
                        'addr_suburb' =>$addr,
                        // 'addr_postal_delivery_box' => '',            
                        'addr_street_name' => $addr_street_name,           
                        'addr_street_num' => $addr_street_number,            
                        'addr_flat_unit_detail' => $addr_unit,            
                        'addr_building_property_name' => $addr_bldg,            
                        'postcode' => $postcode,
                        'state_id' => $state->id,
                        // 'phone_home' => $v->party->contact->phone_home,
                        // 'phone_work' => $v->party->contact->phone_work,
                        // 'phone_mobile' => $v->party->contact->mobile_number,
                        // 'email' => $v->party->contact->email_personal,
                        // 'email_at' => $v->party->contact->email_work
                    ]
                );         

            
            
            
            // $party = Party::updateOrCreate(
            //     [
            //         'name' => $name_encryp[1] .' '. $name_encryp[0],
            //     ],
            //     [
            //         'name' => $v->party->name,
            //         'party_type_id' => 1,
            //         'created_at' => $v->party->created_at,
            //     ]
            // );
            // $party->created_at = $v->party->created_at;
            // $party->update();
            
            // person
            
            // student


            // dd($arr);
            // dump($code);
            // dump($name);
            // dump($nominal_hours);
            // dd('test');

            
            dump($number);
            $count = $nextLine - 1;
        }


        dump('NAT 80 - Done');
        dump('---------------------------------------------------------------------------------------------');
    }


    public function nat85()
    {
        $file_path = $this->path.'/NAT00085.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);

        dump($textCount);

        $data = [];
        $number = 0;
        for($count = 0 ; $count < $textCount ; $count++){
            $number++;
            $nextLine = $count + 479;
            dump($count.' - '. $nextLine);
            $data = substr($txt,$count, 477);

            dump($data);
            
            $prefix = TO::first()->student_id_prefix;

            // breakdown per row
            // $student_id = $prefix.''.trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $student_id = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $client_title = trim(preg_replace('/\s+/', ' ', substr($data,10, 4)));
            $firstname = trim(preg_replace('/\s+/', ' ', substr($data,14, 40)));
            $lastname = trim(preg_replace('/\s+/', ' ', substr($data,54, 40)));
            $addr_bldg = trim(preg_replace('/\s+/', ' ', substr($data,94, 50)));
            $addr_flat = trim(preg_replace('/\s+/', ' ', substr($data,144, 30)));
            $addr_street_number = trim(preg_replace('/\s+/', ' ', substr($data,174, 15)));
            $addr_street_name = trim(preg_replace('/\s+/', ' ', substr($data,189, 70)));
            $addr_postal_dlvry_box = trim(preg_replace('/\s+/', ' ', substr($data,259, 22)));
            $addr_sub = trim(preg_replace('/\s+/', ' ', substr($data,281, 50)));
            $postcode = trim(preg_replace('/\s+/', ' ', substr($data,331, 4)));
            $state_id = trim(preg_replace('/\s+/', ' ', substr($data,335, 2)));
            $tel_home = trim(preg_replace('/\s+/', ' ', substr($data,337, 20)));
            $tel_work = trim(preg_replace('/\s+/', ' ', substr($data,357, 20)));
            $tel_mobile = trim(preg_replace('/\s+/', ' ', substr($data,377, 20)));
            $email = trim(preg_replace('/\s+/', ' ', substr($data,397, 80)));
            // $email_alt = trim(preg_replace('/\s+/', ' ', substr($data,477, 80)));
            
            
            $arr = [
                'student_id' => $student_id,
                'client_title' => $client_title, 
                'firstname' => $firstname, 
                'lastname' => $lastname, 
                'addr_bldg' => $addr_bldg, 
                'addr_flat' => $addr_flat, 
                'addr_street_name' => $addr_street_name, 
                'addr_street_number' => $addr_street_number, 
                'addr_postal_dlvry_box' => $addr_postal_dlvry_box, 
                'addr_sub' => $addr_sub, 
                'postcode' => $postcode, 
                'state_id' => $state_id, 
                'tel_home' => $tel_home, 
                'tel_work' => $tel_work, 
                'tel_mobile' => $tel_mobile, 
                'email' => $email, 
                // 'email_alt' => $email_alt, 
            ];

            
            
            $student = Student::with('party.person', 'contact_detail')->where('student_id', $student_id)->first();
           
            dump($arr);
            // dd($student);

            if($student){

                // person
                $student->party->person->fill(
                    [
                        'prefix' => $client_title,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        // 'prefix' => $v->party->person->prefix,
                    ]
                );
                $student->party->person->update();

                $state = AvtStateIdentifier::where('value', $state_id)->first();
                $contact_details = $student->contact_detail->fill(
                    [
                        'student_id' => $student_id,
                        'addr_suburb' =>$addr_sub,
                        'addr_postal_delivery_box' => $addr_postal_dlvry_box,            
                        'addr_street_name' => $addr_street_name,           
                        'addr_street_num' => $addr_street_number,            
                        'addr_flat_unit_detail' => $addr_flat,            
                        'addr_building_property_name' => $addr_bldg,            
                        'postcode' => $postcode,
                        'state_id' => $state->id,
                        'phone_home' => $tel_home,
                        'phone_work' => $tel_work,
                        'phone_mobile' => $tel_mobile,
                        'email' => $email,
                        // 'email_at' => $email_alt
                    ]
                );
                $contact_details->update();

                // dd($arr);
                dump($number .' - '. $firstname);
            
            }

            $count = $nextLine - 1;
        }


        dump('NAT 85 - Done');
    }
    
    public function nat90()
    {
        $file_path = $this->path.'/NAT00090.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");

        if(filesize($file_path) == 0){
            dump('NAT90 NO DATA FOUND...');
            return false;
        }

        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);

        // dd($textCount);

        $arr = [];
        for($count = 0 ; $count < $textCount ; $count++){
            $nextLine = $count + 14;
            // dump($count.' - '. $nextLine);
            $data = substr($txt,$count, 12);
            
            // dd($data);

            // breakdown per row
            $student_id = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $prior = trim(preg_replace('/\s+/', ' ', substr($data,10, 2)));
            // $postcode = trim(preg_replace('/\s+/', ' ', substr($data,120, 4)));
            // $state_id = trim(preg_replace('/\s+/', ' ', substr($data,124, 2)));
            // $addr = trim(preg_replace('/\s+/', ' ', substr($data,126, 50)));
            // $country_id = trim(preg_replace('/\s+/', ' ', substr($data,176, 4)));

            // dump($student_id);
            // dump($prior);
            // dump($nominal_hours);
            // dd('test');

            // dump($student_id);
            // dd($prior);

            $arr[$student_id][] = $prior;

            // $subjFldEduc = AvtUnitEducationField::where('id', $subject_field_of_educ)->first();

            // $d = Unit::updateOrCreate(
            //     [
            //         'code' => $code,
            //     ],
            //     [
            //         'code' => $code,
            //         'description' => $description,
            //         'subject_educ_fld_identifier_id' => isset($subjFldEduc->id) ? $subjFldEduc->id : null,
            //         'vet_flag' => $vet_flag == 'Y' ? 1 : 0,
            //         'nominal_hours' => $nominal_hours,
            //     ]
            // );

            $count = $nextLine - 1;
        }
        
        foreach($arr as $k => $v){
            $student = Student::with('funded_detail')->where('student_id', $k)->first();
            $ids = implode(',', $v);
            if($student){
                $student->funded_detail->disability_ids = $ids;
                $student->funded_detail->update();

                dump($student->student_id .' - '. $student->party->name);

            }
        }

        // dd($arr);

        dump('NAT 90 - Done');
    }

    public function nat100()
    {
        $file_path = $this->path.'/NAT00100.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");

        if(filesize($file_path) == 0){
            dump('NAT100 NO DATA FOUND...');
            return false;
        }

        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);

        // dd($textCount);

        $arr = [];
        for($count = 0 ; $count < $textCount ; $count++){
            $nextLine = $count + 15;
            // dump($count.' - '. $nextLine);
            $data = substr($txt,$count, 13);
            
            // dd($data);

            // breakdown per row
            $student_id = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $prior = trim(preg_replace('/\s+/', ' ', substr($data,10, 3)));
            // $postcode = trim(preg_replace('/\s+/', ' ', substr($data,120, 4)));
            // $state_id = trim(preg_replace('/\s+/', ' ', substr($data,124, 2)));
            // $addr = trim(preg_replace('/\s+/', ' ', substr($data,126, 50)));
            // $country_id = trim(preg_replace('/\s+/', ' ', substr($data,176, 4)));

            // dump($code);
            // dump($name);
            // dump($nominal_hours);
            // dd('test');

            // dump($student_id);
            // dd($prior);

            $arr[$student_id][] = $prior;

            // $subjFldEduc = AvtUnitEducationField::where('id', $subject_field_of_educ)->first();

            // $d = Unit::updateOrCreate(
            //     [
            //         'code' => $code,
            //     ],
            //     [
            //         'code' => $code,
            //         'description' => $description,
            //         'subject_educ_fld_identifier_id' => isset($subjFldEduc->id) ? $subjFldEduc->id : null,
            //         'vet_flag' => $vet_flag == 'Y' ? 1 : 0,
            //         'nominal_hours' => $nominal_hours,
            //     ]
            // );

            $count = $nextLine - 1;
        }
        
        foreach($arr as $k => $v){
            $student = Student::with('funded_detail')->where('student_id', $k)->first();
            $ids = implode(',', $v);
            if($student){
                $student->funded_detail->prior_educational_achievement_ids = $ids;
                $student->funded_detail->update();

                dump($student->student_id .' - '. $student->party->name);

            }
        }

        // dd($arr);

        dump('NAT 100 - Done');
        dump('------------------------------------------------------------------------------------------');
    }


    public function nat120()
    {
        $file_path = $this->path.'/NAT00120.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);

        // dd($textCount);

        $data = [];
        $number = 0;
        for($count = 0 ; $count < $textCount ; $count++){
            $number++;
            // $nextLine = $count + 160;
            // 
            // $data = substr($txt,$count, 145);
            $data = substr($txt,$count, 144);

            dump($data);

            // dd(substr($data,158, 160));

            if(strpos(substr($data,142, 144), "\n") !== FALSE) {
                // dd('wew');
                $nextLine = $count + 144;
                $data = substr($txt,$count, 142);
                

            }else{
                $data = substr($txt,$count, 145);

                if(strpos(substr($data,143, 145), "\n") !== FALSE){
                    // dd('test');
                    $nextLine = $count + 145;
                    $data = substr($txt,$count, 143);
                
                }else{
                    $data = substr($txt,$count, 159);

                    if(strpos(substr($data,159, 161), "\n") !== FALSE){
                        // dd('test');
                        $nextLine = $count + 161;
                        $data = substr($txt,$count, 159);
                    
                    }else{
                        dd('Data has a problem. please fix');
                    }

                }
            }

            // dd($data);


            dump($count.' - '. $nextLine);

            
            $prefix = TO::first()->student_id_prefix;

            // breakdown per row
            // $train_org_id = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $train_org_dlvry_loc_id =trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            // $student_id = $prefix.''.trim(preg_replace('/\s+/', ' ', substr($data,20, 10)));
            $student_id = trim(preg_replace('/\s+/', ' ', substr($data,10, 10)));
            $subject_id = trim(preg_replace('/\s+/', ' ', substr($data,20, 12)));
            $program_id = trim(preg_replace('/\s+/', ' ', substr($data,32, 10)));
            $start_date = trim(preg_replace('/\s+/', ' ', substr($data,42, 8)));
            $end_date = trim(preg_replace('/\s+/', ' ', substr($data,50, 8)));
            $dlvr_mode_id = trim(preg_replace('/\s+/', ' ', substr($data,58, 2)));
            $outcome_ntl = trim(preg_replace('/\s+/', ' ', substr($data,60, 2)));
            $sched_hours = trim(preg_replace('/\s+/', ' ', substr($data,62, 4)));
            $funding_ntl = trim(preg_replace('/\s+/', ' ', substr($data,66, 2)));
            $commencing_prg_id = trim(preg_replace('/\s+/', ' ', substr($data,68, 1)));
            $train_contract_id = trim(preg_replace('/\s+/', ' ', substr($data,69, 10)));
            $client_id_app = trim(preg_replace('/\s+/', ' ', substr($data,79, 10)));
            $study_reason_id = trim(preg_replace('/\s+/', ' ', substr($data,89, 2)));
            $vet_flag = trim(preg_replace('/\s+/', ' ', substr($data,91, 1)));
            $specific_funding = trim(preg_replace('/\s+/', ' ', substr($data,92, 10)));

            // $school_type_id = trim(preg_replace('/\s+/', ' ', substr($data,109, 2)));
            $outcome_id_train_org = trim(preg_replace('/\s+/', ' ', substr($data,102, 3)));
            $funding_state = trim(preg_replace('/\s+/', ' ', substr($data,105, 3)));
            $client_fee = trim(preg_replace('/\s+/', ' ', substr($data,108, 4)));
            $fee_type_id = trim(preg_replace('/\s+/', ' ', substr($data,112, 1)));
            $pur_contract_id = trim(preg_replace('/\s+/', ' ', substr($data,113, 12)));
            $pur_contract_sched_id = trim(preg_replace('/\s+/', ' ', substr($data,125, 3)));
            $hours_attend = trim(preg_replace('/\s+/', ' ', substr($data,128, 4)));
            $assoc_course_id = trim(preg_replace('/\s+/', ' ', substr($data,132, 10)));
            
            // $predom_dlvr_mode = trim(preg_replace('/\s+/', ' ', substr($data,157, 1)));
            // $fulltime = trim(preg_replace('/\s+/', ' ', substr($data,158, 1)));
            
            $program_id = trim($program_id) == '' ? '1111' : $program_id;

            $arr = [
                'student_id' => $student_id,
                // 'train_org_id' => $train_org_id,
                'train_org_dlvry_loc_id' => $train_org_dlvry_loc_id,
                'subject_id' => $subject_id,
                'program_id' => $program_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'dlvr_mode_id' => $dlvr_mode_id,
                'outcome_ntl' => $outcome_ntl,
                'funding_ntl' => $funding_ntl,
                'commencing_prg_id' => $commencing_prg_id,
                'train_contract_id' => $train_contract_id,
                'client_id_app' => $client_id_app,
                'study_reason_id' => $study_reason_id,
                'vet_flag' => $vet_flag,
                'specific_funding' => $specific_funding,
                // 'school_type_id' => $school_type_id,
                'outcome_id_train_org' => $outcome_id_train_org,
                'funding_state' => $funding_state,
                'client_fee' => $client_fee,
                'fee_type_id' => $fee_type_id,
                'pur_contract_id' => $pur_contract_id,
                'pur_contract_sched_id' => $pur_contract_sched_id,
                'hours_attend' => $hours_attend,
                'assoc_course_id' => $assoc_course_id,
                'sched_hours' => $sched_hours,
                // 'predom_dlvr_mode' => $predom_dlvr_mode,
                // 'fulltime' => $fulltime
            ];

            dump($arr);
            
            // for delivery mode 
            $dlvryMode = '';
            switch($dlvr_mode_id){
                case '10':
                    $dlvryMode = 'YNN';
                    break;

                case '20':
                    $dlvryMode = 'NYN';
                    break;

                case '40':
                    $dlvryMode = 'YNN';
                    break;

                case '50':
                    $dlvryMode = 'YYY';
                    break;
                
                case '30':
                    $dlvryMode = 'NNY';
                    break;
                
                default:
                    $dlvryMode = null;
                    break;

            }
            
            $student = Student::with('party.person', 'funded_detail', 'funded_course.detail')->where('student_id', $student_id)->first();
            $train_org_dlvr_loc = TrainingDeliveryLoc::where('train_org_dlvr_loc_id', $train_org_dlvry_loc_id)->first();
           
            // dd($student);

            if($student){

                // student completion
                $sc = StudentCompletion::updateOrCreate(
                    [
                        'student_id' => $student_id,
                        'course_code' => $program_id
                    ],
                    [
                        'student_id' => $student_id,
                        'course_code' => $program_id,
                        'partial_completion' => 1,
                        'user_id' => 1,
                        'train_org_loc_id' => $train_org_dlvry_loc_id,
                    ]
                );
                
                // student completion detail
                $check_scd = StudentCompletionDetail::where('student_completion_id', $sc->id)->where('course_unit_code', $subject_id)->first();
                $completion_status = AvtCompletionStatus::where('value', $outcome_ntl)->first();
                if(isset($check_scd->id)){
                    $check_scd->fill([
                        'course_unit_code' => $subject_id, 
                        'start_date' => Carbon::createFromFormat('dmY', $start_date)->format('Y-m-d'), 
                        'end_date' => Carbon::createFromFormat('dmY', $end_date)->format('Y-m-d'),
                        'actual_start' => Carbon::createFromFormat('dmY', $start_date)->format('Y-m-d'), 
                        'actual_end' => Carbon::createFromFormat('dmY', $end_date)->format('Y-m-d'), 
                        'training_hours' => intval($sched_hours),
                        'completion_status_id' => $completion_status->id, 
                        'completion_date' => Carbon::createFromFormat('dmY', $end_date)->format('Y-m-d'), 
                        'delivery_mode_id' => $dlvryMode,
                        'train_org_loc_id' => $train_org_dlvry_loc_id
                    ]);
                    $check_scd->update();

                }else{
                    $check_scd = new StudentCompletionDetail;
                    $check_scd->fill([
                        'course_unit_code' => $subject_id, 
                        'start_date' => Carbon::createFromFormat('dmY', $start_date)->format('Y-m-d'), 
                        'end_date' => Carbon::createFromFormat('dmY', $end_date)->format('Y-m-d'),
                        'actual_start' => Carbon::createFromFormat('dmY', $start_date)->format('Y-m-d'), 
                        'actual_end' => Carbon::createFromFormat('dmY', $end_date)->format('Y-m-d'), 
                        'training_hours' => intval($sched_hours),
                        'completion_status_id' => $completion_status->id, 
                        'completion_date' => Carbon::createFromFormat('dmY', $end_date)->format('Y-m-d'), 
                        'delivery_mode_id' => $dlvryMode,
                        'train_org_loc_id' => $train_org_dlvry_loc_id
                    ]);
                    $check_scd->completion()->associate($sc);
                    $check_scd->save();
                }

                if($fee_type_id == 'C'){
                    $course_fee_type = 'C';
                    $eligibility = 'E';
                }elseif($fee_type_id == 'N'){
                    $course_fee_type = 'NC';
                    $eligibility = 'NE';
                }else{
                    $course_fee_type = 'FF';
                    $eligibility = 'NE';
                }

                // funded course
                $funded_course = FundedStudentCourse::updateOrCreate(
                    [
                        'student_id' => $student_id,
                        'course_code' => $program_id
                    ],
                    [
                        'student_id' => $student_id,
                        'course_code' => $program_id,
                        'eligibility' => $eligibility,
                        'location' => isset($train_org_dlvr_loc->state->id) ? $train_org_dlvr_loc->state->state_key : '',
                        'course_fee' => trim($client_fee) == '' ? 0 : $client_fee,
                        'course_fee_type' => $course_fee_type,
                        'status_id' => 3,
                    ]
                );

                if($student_id == $funded_course->student_id && $program_id == $funded_course->course_code){
                    
                    $get_start_date = Carbon::createFromFormat('dmY', $start_date)->format('Y-m-d');
                    $get_end_date = Carbon::createFromFormat('dmY', $end_date)->format('Y-m-d');

                    $funded_course->start_date = $funded_course->start_date == null ? $get_start_date : $funded_course->start_date;
                    $funded_course->end_date = $funded_course->end_date == null ? $get_end_date : $funded_course->end_date;

                    $funded_course->start_date = $funded_course->start_date > $get_start_date  ? $get_start_date : $funded_course->start_date;
                    $funded_course->end_date = $funded_course->end_date < $get_start_date  ? $get_start_date : $funded_course->end_date;

                    $funded_course->update();
                }

                // funded course detail
                $funded_course_detail = FundedStudentCourseDetail::where('funded_student_course_id', $funded_course->id)->first();
                if(isset($funded_course_detail->id)){
                    $funded_course_detail->fill([
                        'outcome_id_national' => $outcome_ntl,
                        'funding_source_national' => $funding_ntl,
                        'commence_prg_identifier' => $commencing_prg_id,
                        'training_contract_id' => $train_contract_id,
                        'client_id_apprenticeships' => $client_id_app,
                        'study_reason_id' => $study_reason_id,
                        'specific_funding_id' => $specific_funding,
                        'funding_source_state_training_authority' => $funding_state,
                        'purchasing_contract_id' => $pur_contract_id,
                        'purchasing_contract_schedule_id' => $pur_contract_sched_id,
                        'associated_course_id' => $assoc_course_id,
                        // 'predominant_delivery_mode' => $predom_dlvr_mode,
                        // 'full_time_leaning_option' => $fulltime,
                    ]);
                    $funded_course_detail->update();
                }else{
                    $funded_course_detail = new FundedStudentCourseDetail;
                    $funded_course_detail->fill([
                        'outcome_id_national' => $outcome_ntl,
                        'funding_source_national' => $funding_ntl,
                        'commence_prg_identifier' => $commencing_prg_id,
                        'training_contract_id' => $train_contract_id,
                        'client_id_apprenticeships' => $client_id_app,
                        'study_reason_id' => $study_reason_id,
                        'specific_funding_id' => $specific_funding,
                        'funding_source_state_training_authority' => $funding_state,
                        'purchasing_contract_id' => $pur_contract_id,
                        'purchasing_contract_schedule_id' => $pur_contract_sched_id,
                        'associated_course_id' => $assoc_course_id,
                        // 'predominant_delivery_mode' => $predom_dlvr_mode,
                        // 'full_time_leaning_option' => $fulltime,
                    ]);
                    $funded_course_detail->funded_student_course()->associate($funded_course);
                    $funded_course_detail->save();
                }


                // course avt detail
                $course_avt_detail = CourseAvtDetail::where('course_code', $program_id)->first();
                if($course_avt_detail){
                    $course_avt_detail->vet_flag_status = $vet_flag == 'Y' ? 1 : 0;
                    $course_avt_detail->update();
                }

                // dd($arr);
                dump($number .' - '. $student_id);
            
            }

            
            
            $count = $nextLine - 1;
        }


        dump('NAT 120 - Done');
    }

    
    public function nat130()
    {
        $file_path = $this->path.'/NAT00130.txt';
        $txt = '';
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        $txt = fread($myfile,filesize($file_path));
        fclose($myfile);

        // dd(substr($txt, 182, 182));

        $textCount = strlen($txt);

        dump($textCount);

        $data = [];
        $number = 0;
        for($count = 0 ; $count < $textCount ; $count++){
            $number++;
            // $nextLine = $count + 41;
            // dump($count.' - '. $nextLine);
            $data = substr($txt,$count, 37);

            // dd($data);

            // dump($data);

            // dd(substr($data,158, 160));
            if(strpos(substr($data,35, 37), "\n") !== FALSE){
                // dd('test');
                $nextLine = $count + 37;
                $data = substr($txt,$count, 35);

            }else{
                $data = substr($txt,$count, 72);
                
                if(strpos(substr($data,72, 74), "\n") !== FALSE) {
                    $nextLine = $count + 74;
                    $data = substr($txt,$count, 72);
                
                
                }else{
                   dd('Data has a problem. please fix');
                }
            }

            dump($count.' - '. $nextLine);
            
            $prefix = TO::first()->student_id_prefix;

            // breakdown per row

            // $student_id = $prefix.''.trim(preg_replace('/\s+/', ' ', substr($data,20, 10)));
            $student_id = trim(preg_replace('/\s+/', ' ', substr($data,20, 10)));
            $train_org_id = trim(preg_replace('/\s+/', ' ', substr($data,0, 10)));
            $program_id = trim(preg_replace('/\s+/', ' ', substr($data,10, 10)));
            $date_prog_completed = trim(preg_replace('/\s+/', ' ', substr($data,30, 4)));
            $issued_flag = trim(preg_replace('/\s+/', ' ', substr($data,34, 1)));
            
            $program_id = trim($program_id) == '' ? '1111' : $program_id;
            
            
            $arr = [
                'student_id' => $student_id,
                'train_org_id' => $train_org_id,
                'program_id' => $program_id,
                'date_prog_completed' => $date_prog_completed,
                'issued_flag' => $issued_flag
            ];

            
            
            
            $studentcompletion = StudentCompletion::with(['student.funded_course'])->where('student_id', $student_id)->where('course_code', $program_id)->first();
            // dump($studentcompletion->details); 
            // dd($arr);
            // if(strpos($student_id, '2014R77W2W') !== false){
            //     dd('sulod');
            // }
            // dump($studentcompletion->toArray());
            // dump($student_id);
            // dd($studentcompletion);

            if($studentcompletion){

                dump('inside');

               
                $yearProgCompleted = '0000-00-00';
                foreach($studentcompletion->student->funded_course as $fc){
                   if($fc->course_code == $program_id){
                    $yearProgCompleted = $date_prog_completed . '-' . Carbon::createFromFormat('Y-m-d', $fc->end_date)->format('m-d');
                    $fc->status_id = 4;
                    $fc->update();
                   }
                }
               
               $studentcompletion->completion_date = $yearProgCompleted;
               $studentcompletion->completion_status_id = 3;
               $studentcompletion->update();

               if($issued_flag == 'Y'){
                   $student_certificate_issuance = StudentCertificateIssuance::updateOrCreate(
                       [
                        'student_id' => $student_id,
                        'student_completion_id' => $studentcompletion->id
                       ],
                       [
                        'student_id' => $student_id,
                        'student_completion_id' => $studentcompletion->id,
                        'issued_date' => $yearProgCompleted,
                        'user_id' => 1
                       ]
                   );
               }

                // dd($arr);
                dump($number .' - '. $student_id);
            
            }

            $count = $nextLine - 1;
        }


        dump('NAT 130 - Done');
    }





}
