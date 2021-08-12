<?php

namespace App\Http\Controllers\Migration;

use App\Http\Controllers\Controller;
use App\Models\AvtHighestSchlLvlCompleted;
use App\Models\AvtLabourForceStatus;
use Illuminate\Http\Request;
use App\Models\SIA\Deal;
use App\Models\SIA\Course\Course;
use App\Models\SIA\TrainingDeliveryLoc;
use App\Models\SIA\Course\CourseUnit;


// VORX RTO MODELS
use App\Models\Student\Student;
use App\Models\Student\Party;
use App\Models\Student\Person;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentCourseDetail;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentContactDetails;
use App\Models\StudentCertificateIssuance;
use App\Models\StateIdentifier;
use App\Models\StudentCompletion;
use App\Models\StudentCompletionDetail;
use App\Models\TrainingDeliveryLoc AS TDL;
use App\Models\Course as C;
use App\Models\CourseAvtDetail as CAD;
use App\Models\Unit;

// AVT
use App\Models\AvtPostcode;

class MigrationController extends Controller
{
    //

    public function migrate_students()
    {
        // dd(Deal::all());

        $deals = Deal::with(['party.person.student_info', 'party.address.stateidentifier', 'party.contact', 'party.person.student_completion.details', 'party.person.student_completion.cert_issuance', 'deal_detail.course', 'opportunity', 'certificate_issued', 'enrolment'])->get();
        
        $students = [];

        foreach($deals as $k => $v){
            
            if(isset($v->party->person->id)) {
                // dump($v);

                // party
                $party = Party::updateOrCreate(
                    [
                        'name' => $v->party->name,
                        'created_at' => $v->party->created_at
                    ],
                    [
                        'name' => $v->party->name,
                        'party_type_id' => 1,
                        'created_at' => $v->party->created_at,
                    ]
                );
                $party->created_at = $v->party->created_at;
                $party->update();

                // students
                $student = Student::updateOrCreate(
                    [
                        'student_id' => 'SIA' . str_pad($party->id, 5, 0, STR_PAD_LEFT),
                        'created_at' => $v->party->created_at,
                    ],
                    [
                        'student_id' => 'SIA' . str_pad($party->id, 5, 0, STR_PAD_LEFT),
                        'party_id' => $party->id,
                        'student_type_id' => 2,
                        'is_active' => 1,
                        'created_at' => $party->created_at,
                    ]
                );
                $student->created_at = $v->party->created_at;
                $student->party()->associate($party);
                $student->user()->associate(\Auth::user());
                $student->update();

                // person
                $person = Person::updateOrCreate(
                    [
                        'firstname' => $v->party->person->firstname,
                        'lastname' => $v->party->person->lastname,
                        'date_of_birth' => $v->party->person->date_of_birth,
                    ],
                    [
                        'person_type_id' => 5,
                        'gender' => $v->party->person->gender,
                        'firstname' => $v->party->person->firstname,
                        'lastname' => $v->party->person->lastname,
                        'middlename' => $v->party->person->middlename,
                        'date_of_birth' => $v->party->person->date_of_birth,
                        'prefix' => $v->party->person->prefix,
                    ]
                );
                $person->created_at = $v->party->person->created_at;
                $person->party()->associate($party);
                $person->update();

                // funded course
                $funded_course = FundedStudentCourse::updateOrCreate(
                    [
                        'student_id' => $student->student_id,
                        'course_code' => $v->deal_detail->course->code,
                        
                    ],
                    [
                        'student_id' => $student->student_id,
                        'course_code' => $v->deal_detail->course->code,
                        'eligibility' => $v->deal_detail->eligible == 1 ? 'E' : 'NE',
                        'location' => isset($v->party->address->stateidentifier->state_key) ? $v->party->address->stateidentifier->state_key : null,
                        'start_date' => isset($v->certificate->enrolment_date) ? $v->certificate->enrolment_date : null,
                        'end_date' => isset($v->certificate->expected_course_completion) ? $v->certificate->expected_course_completion : null,
                        // 'course_fee' => ,
                        // 'course_fee_type' => ,
                        'status_id' => 1,

                    ]
                );
                $funded_course->user()->associate(\Auth::user());
                $funded_course->created_at = $v->deal_detail->created_at;
                $funded_course->update();

                // contact details
                $addr_suburb = AvtPostcode::where('id', $v->party->address->location_suburb_town)->first();
                $contact_details = FundedStudentContactDetails::updateOrCreate(
                    [
                        'student_id' => $student->student_id
                    ],
                    [
                        'student_id' => $student->student_id,
                        'addr_suburb' => isset($addr_suburb->suburb) ? $addr_suburb->suburb : null,
                        'addr_postal_delivery_box' => $v->party->address->postal_dlvr_box,            
                        'addr_street_name' => $v->party->address->street_name,           
                        'addr_street_num' => $v->party->address->street_num,            
                        'addr_flat_unit_detail' => $v->party->address->flat_unit,            
                        'addr_building_property_name' => $v->party->address->bldg_property_name,            
                        'postcode' => $v->party->address->postcode,
                        'state_id' => $v->party->address->state_identifier,
                        'phone_home' => $v->party->contact->phone_home,
                        'phone_work' => $v->party->contact->phone_work,
                        'phone_mobile' => $v->party->contact->mobile_number,
                        'email' => $v->party->contact->email_personal,
                        'email_at' => $v->party->contact->email_work
                    ]
                );
                $contact_details->created_at = $v->party->contact->created_at;
                $contact_details->update();

                // funded details
                if(isset($v->party->person->student_info) && isset($v->enrolment)){
                    $hsl = isset($v->party->person->student_info->highest_school_lvl_comp_identifier) ? AvtHighestSchlLvlCompleted::where('id', $v->party->person->student_info->highest_school_lvl_comp_identifier)->first() : '@@';
                    // dd($v->party->person->student_info);
                    $lfs = isset($v->party->person->student_info->lbr_force_status_identifier) ? AvtLabourForceStatus::where('id', $v->party->person->student_info->lbr_force_status_identifier)->first() : '@@';
                    $funded_details = FundedStudentDetails::updateOrCreate(
                        [
                            'student_id' => $student->student_id
                        ],
                        [
                            'student_id' => $student->student_id,
                            'location' => isset($v->party->address->stateidentifier->state_key) ? $v->party->address->stateidentifier->state_key : null,
                            'funded_student_contact_detail_id' => $contact_details->id,
                            'name_for_encryption' => '',
                            // 'commence_prg_identifier' => $v->enrolment->commencing_program_id,
                            'highest_school_level_completed_id' => isset($hsl->value) ? $hsl->value : '@@',
                            'indigenous_status_id' => $v->party->person->student_info->ind_status_identifier,
                            'language_id' => $v->party->person->student_info->lang_identifier,
                            'labour_force_status_id' => isset($lfs->value) ? $lfs->value : '@@',
                            'country_id' => 1101,
                            'disability_flag' => 'N',
                            'disability_ids' => null,
                            'prior_educational_achievement_flag' => 'N',
                            'prior_educational_achievement_ids' => null,
                            'at_school_flag' => $v->party->person->student_info->at_school_flag == 1 ? 'Y' : 'N',
                            'unique_student_id' => $v->party->person->student_info->uniq_stud_identifier,
                            'survey_contact_status' => $v->enrolment->survey_contact_status,
                            'statistical_area_level_1_id' => '',
                            'statistical_area_level_2_id' => '',
                            // 'full_time_leaning_option' => 'Y'
                        ]
                    );
                    $funded_details->created_at = $v->created_at;
                    $funded_details->update();

                    // funded course detail
                    $funded_course_detail = FundedStudentCourseDetail::updateOrCreate(
                        [
                            'funded_student_course_id' => $funded_course->id
                        ],
                        [
                            // 'outcome_id_national' => ,
                            'funding_source_national' => $v->enrolment->funding_source_national,
                            'commence_prg_identifier' => $v->enrolment->commencing_program_id,
                            'training_contract_id' => $v->enrolment->training_contract_identifier,
                            'client_id_apprenticeships' => $v->enrolment->client_identifier_appren,
                            'study_reason_id' => $v->enrolment->study_reason_id,
                            'specific_funding_id' => $v->enrolment->specific_funding_id,
                            'funding_source_state_training_authority' => $v->enrolment->funding_source_state_training_authority,
                            'purchasing_contract_id' => $v->enrolment->pur_contract_identifier,
                            'purchasing_contract_schedule_id' => $v->enrolment->pur_contract_sched_identifier,
                            'associated_course_id' => $v->enrolment->assoc_course_identifier,
                            'predominant_delivery_mode' => $v->deal_detail->predominant_delivery_mode_id,
                            'full_time_leaning_option' => $v->enrolment->full_time_learning_option == 1 ? 'Y' : 'N',
                        ]
                    );
                    $funded_course_detail->funded_student_course()->associate($funded_course);
                    $funded_course_detail->created_at = $v->enrolment->created_at;
                    $funded_course_detail->update();
                }

                // dd('inserted');

                if(isset($v->party->person->student_completion)){
                    foreach($v->party->person->student_completion as $kk => $vv) {
                        if($vv->course_code == $v->deal_detail->course->code && $vv->forSOA == 0){
                            // student completion
                            $student_completion = StudentCompletion::updateOrCreate(
                                [
                                    'student_id' => $student->student_id,
                                    'course_code' => $vv->course_code
                                ],
                                [
                                    'student_id' => $student->student_id,
                                    'course_code' => $vv->course_code,
                                    'completion_status_id' => $vv->completion_status_id,
                                    'completion_date' => $vv->completion_date,
                                    'user_id' => 1,
                                    'partial_completion' => $vv->completion_status_id != 3 ? 1 : 0
                                ]
                            );

                            foreach($vv->details as $kkk => $vvv) {
                                // dump($vvv);
                                // dd($student_completion->id);
                                $completion_detail = StudentCompletionDetail::updateOrCreate(
                                    [
                                        'student_completion_id' => $student_completion->id,
                                        'course_unit_code' => $vvv->course_units_id, 
                                    ],
                                    [
                                        'course_unit_code' => $vvv->course_units_id, 
                                        'start_date' => $vvv->start_date, 
                                        'end_date' => $vvv->end_date, 
                                        'completion_status_id' => $vvv->completion_status_id, 
                                        'completion_date' => $vvv->completion_date,
                                        'delivery_mode_id' => $v->deal_detail->delivery_mode_id,
                                        'train_org_loc_id' => $vv->train_org_dlvr_loc_identifier
                                    ]
                                );
                                $completion_detail->completion()->associate($student_completion);
                                $completion_detail->update();
                            }

                            // if(isset($vv->certificate)){

                            //     $certificate_issuance = 
                            // }


                            // certificate issuance
                            if(isset($vv->cert_issuance->id)){
                                // dd('test123');
                                $cert_issuance = StudentCertificateIssuance::updateOrCreate(
                                    [
                                        'student_id' => $student->student_id,
                                        'student_completion_id' => $student_completion->id
                                    ],
                                    [
                                        'student_id' => $student->student_id,
                                        'generated_cert_num' => $vv->cert_issuance->generated_cert_num,
                                        'manual_cert_num' => $vv->cert_issuance->manual_cert_num,
                                        'issued_date' => $vv->cert_issuance->issued_date,
                                        'released_date' => $vv->cert_issuance->released_date, 
                                        'enrolment_date' => $vv->cert_issuance->enrolment_date,
                                        'expected_course_completion' => $vv->cert_issuance->expected_course_completion
                                    ]
                                );
                                $cert_issuance->completion()->associate($student_completion);
                                $cert_issuance->user()->associate(\Auth::user());
                                $cert_issuance->update();


                                $funded_course->start_date = $vv->cert_issuance->enrolment_date;
                                $funded_course->end_date = $vv->cert_issuance->expected_course_completion;
                                $funded_course->update();
                            }

                        }
                    }
                    

                }

                // if($v->id == 329){
                //     dd($v->party->person->student_completion->toArray());
                // }
                dump($k. ' - ' .$v->party->name . ' - DONE');

            }
            // dd('end');
        }


        dd('test');
        
    }

    public function org_courses()
    {
        // training delivery location
        $tdl = TrainingDeliveryLoc::all();

        foreach($tdl as $k => $v){
            $dl = TDL::updateOrCreate(
                [
                    'train_org_dlvr_loc_id' => $v->dlvr_loc_identifier
                ],
                [
                    'training_organisation_id' => $v->org_identifier,
                    'train_org_dlvr_loc_id' => $v->dlvr_loc_identifier,
                    'train_org_dlvr_loc_name' => $v->dlvr_loc_name,
                    'postcode' => $v->postcode,
                    'state_id' => $v->state_identifier,
                    'addr_location' => $v->addr_location,
                    'country_id' => $v->country_identifier
                ]
            );

            dump('TDL - '.$v->dlvr_loc_identifier.' - DONE');
        }

        // course
        $courses = Course::with('course_avt_details')->get();
        foreach($courses as $k => $v){
            $c = C::updateOrCreate(
                [
                    'code' => $v->code
                ],
                [
                    'code' => $v->code,
                    'name' => $v->name
                ]
            );

            $cad = CAD::updateOrCreate(
                [
                    'course_code' => $v->code,
                ],
                [
                    'course_code' => $v->code,
                    'nominal_hours' => $v->course_avt_details->nominal_hours,
                    'prg_recog_identifier_id' => $v->course_avt_details->prg_recog_identifier_id,
                    'prg_lvl_of_educ_identifier_id' => $v->course_avt_details->prg_lvl_of_educ_identifier_id,
                    'qlf_field_of_educ_identifier_id' => $v->course_avt_details->qlf_field_of_educ_identifier_id,
                    'anzsco_identifier_id' => $v->course_avt_details->anzsco_identifier_id,
                    'vet_flag_status' => $v->course_avt_details->vet_flag_status
                ]
            );

            dump('Course - '.$v->code.' - DONE');
        }

        // units
        $units = CourseUnit::all();

        foreach($units as $k => $v){
            $u = Unit::updateOrCreate(
                [
                    'code' => $v->code
                ],
                [
                    'code' => $v->code,
                    'description' => $v->description,
                    'unit_type' => $v->unit_type,
                    'assessment_method' => $v->assesment_method,
                    'nominal_hours' => $v->nominal_hours,
                    'training_method_id' => $v->training_method_id,
                    'subject_educ_fld_identifier_id' => $v->subject_educ_fld_identifier_id,
                    'vet_flag' => $v->vet_flag,
                    'extra_unit' => $v->extra_unit,
                    'active' => $v->active,
                ]
            );

            dump('Unit - '.$v->code.' - DONE');
        }

        dd('end');
    }
}