<?php

namespace App\Http\Controllers\Enrolment;

use File;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\StudentController;
use App\Models\AvtFundingType;
use App\Models\AvtPostcode;
use App\Models\AvtStateIdentifier;
use App\Models\CompletionStudentCourse;
use App\Models\CourseMatrix;
use App\Models\EnrolmentPack;
use App\Models\FundedStudentContactDetails;
use App\Models\FundedStudentCourse;
use App\Http\Controllers\Send\EmailSendingController;
use App\Http\Controllers\Enrolment\InternationalEnrolmentApplicationController;
use App\Models\FundedStudentCourseDetail;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentVisaDetails;
use App\Models\CourseProspectus;
use App\Models\EmailAutomation;
use App\Models\OfferLetterCourseDetail;
use App\Models\OfferLetterFee;
use App\Models\OfferLetterStudentDetail;
use App\Models\StudentCompletion;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\Student\Party;
use App\Models\Student\Person;
use App\Models\Student\Student;
use App\Models\StudentAttachment;
use App\Models\StudentCompletionDetail;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrganisation;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class NewEnrolmentApplicationController extends Controller
{
    //

    public function getMatrix($course_code,$location){
        $matrix = CourseMatrix::where('course_code',$course_code)->where('location',$location)->first();
        return $matrix;
    }

    public function store(Request $request){
        // dd($request->all());

        $ep = EnrolmentPack::where('process_id',$request->process_id)->first();
       
        if($ep != null){
            $emailsTo = [];
            if (isset($ep->enrolment_form['email']) && !in_array($ep->enrolment_form['email'], ['', null])) {
                $emailsTo[] = $ep->enrolment_form['email'];
            }
            if (isset($ep->enrolment_form['email_at']) && !in_array($ep->enrolment_form['email_at'], ['', null])) {
                $emailsTo[] = $ep->enrolment_form['email_at'];
            }
            // $emailsTo = ['niwang101@gmail.com'];
    
            // $admin_emails = ['phoenixcollegeaustralia@gmail.com', 'admin@phoenixcollege.edu.au','xyshain@gmail.com'];
            // $admin_emails = ['admin@phoenixcollege.edu.au', 'xyshain@gmail.com', 'niwang101@gmail.com'];
            $admin_emails = EmailAutomation::where('addOn', 'offer_letter')->pluck('email');
            if(isset($enrolmentForm['contact_details_email'])){
                $admin_emails[] = $enrolmentForm['contact_details_email'];
            }
            $ef = $ep->enrolment_form;

            /** 
             * Start Initiation 
             */
            $person = new Person();
            $party = new Party();
            $student = new Student();
            $student_visa = new FundedStudentVisaDetails();
            $student_detail = new FundedStudentDetails();
            $funded_contact = new FundedStudentContactDetails();
            $funded_course = new FundedStudentCourse();
            $funded_course_details = new FundedStudentCourseDetail();
            $offer_letter = new OfferLetter();
            $org = TrainingOrganisation::first();
            $stud = new StudentController;
            $suburb = $ef['addr_suburb'];
            $suburb_id = $suburb['id'];
            $postcode = AvtPostcode::where('id', $suburb_id)->first();
            $suburb = $postcode->suburb;
            $state = AvtStateIdentifier::where('state_key', $postcode->state)->first();
            $state_id = $state->id;

            $indigenous_status = '';
            if (isset($ef['origin'])) {
                if ($ef['origin'] == 'Aboriginal') {
                    $indigenous_status = 1;
                } elseif ($ef['origin'] == 'Torres Strait Islander') {
                    $indigenous_status = 2;
                } elseif ($ef['origin'] == 'None') {
                    $indigenous_status = 4;
                } else {
                    $indigenous_status = 3;
                }
            } else {
                $indigenous_status = '@';
            }
            $disability = [];
            $pea = [];
            if (isset($ef['disabilitiy_ids'])) {
                foreach ($ef['disabilitiy_ids'] as $key => $value) {
                    array_push($disability, $value['value']);
                }
                $disability = implode(',', $disability);
            } else {
                $disability = '';
            }

            // prior_educational_achievement_ids

            if (isset($ef['prior_educational_achievement_ids'])) {
                foreach ($ef['prior_educational_achievement_ids'] as $key => $value) {
                    array_push($pea, $value['value']);
                }

                $pea = implode(',', $pea);
            } else {
                $pea = '';
            }
            /** 
             * End Initiation
             */



            /** 
             * Start Data Segregation
             */

            $eperson = [
                'firstname' => $ef['firstname'],
                'lastname' => $ef['lastname'],
                'middlename' => isset($ef['middlename']) ? $ef['middlename'] : null,
                'date_of_birth' => Carbon::parse($ef['date_of_birth'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                'gender' => isset($ef['gender']) ? $ef['gender']: null,
                'prefix'  => isset($ef['prefix']) ? $ef['prefix'] : null,
                'person_type_id'=> 5
            ];

            $studentContactDetails['addr_suburb'] = $suburb; // usabon
            $studentContactDetails['addr_postal_delivery_box'] = $this->nullchecker('addr_postal_delivery_box', $ef); //$ef['addr_postal_delivery_box'];
            $studentContactDetails['addr_street_name'] = $this->nullchecker('addre_street_name', $ef);
            $studentContactDetails['addr_street_num'] = $this->nullchecker('addr_street_num', $ef);
            $studentContactDetails['addr_flat_unit_detail'] = $this->nullchecker('addr_flat_unit_detail', $ef);
            $studentContactDetails['addr_building_property_name'] =  $this->nullchecker('addr_building_property_name', $ef);
            $studentContactDetails['postcode'] = $postcode->postcode; // usabon
            $studentContactDetails['state_id'] = $state_id; // usabon
            $studentContactDetails['phone_home'] = $this->nullchecker('phone_home', $ef);
            $studentContactDetails['phone_mobile'] = $this->nullchecker('phone_mobile', $ef);
            $studentContactDetails['email'] = $ef['email'];
            $studentContactDetails['email_at'] = $this->nullchecker('email_at', $ef);
            $studentContactDetails['emer_name'] = $this->nullchecker('e_contact_name', $ef);
            $studentContactDetails['emer_address'] = $this->nullchecker('e_address', $ef);
            $studentContactDetails['emer_telephone'] = $this->nullchecker('e_telephone', $ef);
            $studentContactDetails['emer_relationship'] = $this->nullchecker('e_relationship', $ef);

            $studentDetails['highest_school_level_completed_id'] = $ef['highest_school_level_completed_id']['value'];
            $studentDetails['indigenous_status_id'] = $indigenous_status;  //usabon
            $studentDetails['location'] = $state->state_key; // usabon;
            // $studentDetails['language_id'] = $ef[''];
            $studentDetails['labour_force_status_id'] = $this->nullchecker('labour_force_status_id', $ef);
            $studentDetails['institute'] = $this->nullchecker('institute', $ef);
            $studentDetails['country_id'] = isset($ef['birth_country_id']) ? $ef['birth_country_id']['identifier'] : null;
            $studentDetails['disability_flag'] = isset($ef['disability_flag']) && $ef['disability_flag'] == 1 ? 'Y' : 'N';
            $studentDetails['disability_ids'] = $disability;
            $studentDetails['language_id'] = $this->nullchecker('spoken_language_specify', $ef);

            $studentDetails['prior_educational_achievement_flag'] = isset($ef['prior_educational_achievement_ids']) ? 'Y' : 'N'; //usabon
            $studentDetails['prior_educational_achievement_ids'] = $pea;
            $studentDetails['at_school_flag'] = isset($ef['at_school']) && $ef['at_school'] == 1 ? 'Y' : 'N';
            $studentDetails['year_completed'] = isset($ef['year_completed']) ? $ef['year_completed'] : '';
            $studentDetails['unique_student_id'] = $this->nullchecker('unique_student_id', $ef);


            $studentVisaInfo['passport_number'] = $this->nullchecker('passport_no', $ef);
            $studentVisaInfo['nationality'] = $this->nullchecker('nationality', $ef);
            $studentVisaInfo['issue_date'] = $this->doublenullchecker('passport_issued_date', $ef);
            $studentVisaInfo['expiry_date'] = $this->doublenullchecker('passport_expiry_date', $ef);
            $studentVisaInfo['visa_type'] = isset($ef['visa_type']) ? $ef['visa_type']['id']  : '';
            $studentVisaInfo['expiry_date_visa_type'] = $this->doublenullchecker('expiry_date_visa_type', $ef);
            $studyrights = null;
            if (isset($ef['study_rights'])) {
                $studyrights = $ef['study_rights'] == 1 ? "Yes" : "No";
            }
            $applied_for_au_residency = null;
            if (isset($ef['au_permanent_residency'])) {
                $applied_for_au_residency = $ef['au_permanent_residency'] == 1 ? "Yes" : "No";
            }
            $studentVisaInfo['study_rights'] = $studyrights;
            $studentVisaInfo['applied_for_au_residency'] = $applied_for_au_residency;
            $modeOfDelivery = isset($ef['mode_of_delivery']) ? $ef['mode_of_delivery']['value'] : Null;
            /**
             * End Data Segregation
             */
            
            /**
             * Start DATA ENTRY
             */
          
            try {

                $pexist = Person::where('firstname',$eperson['firstname'])->where('lastname',$eperson['lastname'])->where('date_of_birth',$eperson['date_of_birth'])->first();
                if($pexist == null){
                    
                    DB::beginTransaction();
                    if($eperson['middlename'] == null){
                        $party->fill([
                            'party_type_id'    => 1,
                            'name'          => preg_replace('/\s+/', ' ', $eperson['firstname'] . ' '. $eperson['middlename'] .' ' . $eperson['lastname']),
                        ]);

                    }else{
                        $party->fill([
                            'party_type_id'    => 1,
                            'name'          => preg_replace('/\s+/', ' ', $eperson['firstname'] . ' ' . $eperson['lastname']),
                        ]);
                    }
                    $party->save();
                    $person->fill($eperson);
                    $person->party()->associate($party);
                    $person->save();

                    $student->fill([
                        'is_active' => 1,
                        'student_type_id' => $ep->student_type,
                    ]);

                    $student->party()->associate($party);
                    $student->user()->associate(Auth::user());
                    $student->save();

                    
                    $student->student_id = $stud->generate_student_id();
                    $student->update();
                    $student_visa->fill($studentVisaInfo);

                    $student_visa->student()->associate($student->student_id);
                    $student_visa->save();

                    $funded_contact->fill($studentContactDetails);
                    $funded_contact->student()->associate($student->student_id);
                    $funded_contact->save();
                    $student_detail->fill($studentDetails);
                    $student_detail->student()->associate($student->student_id);

                    $student_detail->contact()->associate($funded_contact);
                    $student_detail->save();
                    $course = [];
                    $units = [];
                    if(isset($request->course[0])){
                        $units = $request->course;
                        $course = [
                            'course_code'               => '@@@@',
                            'process_id'                => $ep->process_id,
                            'eligibility'               => $request->eligibility == 1 ? 'E' : 'NE',
                            'location'                  => $state->state_key,
                            'start_date'                => Carbon::parse($request->start_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                            'end_date'                  => Carbon::parse($request->end_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                            'course_fee'                => (double)$request->tuition_fee,
                            'course_fee_type'           => $request->course_fee_type,
                            'status_id'                 => $request->status,
                        ];
                    }else{
                        $course = [
                            'course_code'               => $request->course['code'],
                            'process_id'                => $ep->process_id,
                            'eligibility'               => $request->eligibility == 1 ? 'E' : 'NE',
                            'location'                  => $state->state_key,
                            'start_date'                => Carbon::parse($request->start_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                            'end_date'                  => Carbon::parse($request->end_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                            'course_fee'                => (double)$request->tuition_fee,
                            'course_fee_type'           => $request->course_fee_type,
                            'status_id'                 => $request->status,
                        ];
                    }
                
                    $exist = FundedStudentCourse::where('course_code',$course['course_code'])->where('student_id',$student->student_id)->first();
                    if($exist == null){
                        $funded_course->fill($course);
                        $funded_course->student()->associate($student->student_id);
                        $funded_course->save();
                        if($request->funding_type != null) {
                            $funding_type = AvtFundingType::where('id', $request->funding_type)->first();
                            $funded_course_details->fill([
                                'funding_type'                              => $funding_type->id,
                                'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                                'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                                'associated_course_id'                      => $funding_type->course_site_id,
                                'funding_source_national'                   => $funding_type->national_funding_code,
                                'training_contract_id'                      => $funding_type->training_contract,
                                'specific_funding_id'                       => $funding_type->specific_funding_code,
                                'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                                'study_reason_id'                           => isset($ef['study_reason_id']) ? $ef['study_reason_id']['value'] : null
                            ]);
                            $funded_course_details->funded_student_course()->associate($funded_course);
                            $funded_course_details->save();
                        }else{
                            $funded_course_details->funded_student_course()->associate($funded_course);
                            $funded_course_details->save();
                        }
                        $this->createCompletion($funded_course,$state,$modeOfDelivery,$units);
                        
                        if($request->offer_letter == 1){
                            // dd($request->all());
                           $offer_data = [
                                'tuition_fee'       =>  $request->tuition_fee,
                                'application_fee'   =>  $request->application_fee,
                                'material_fee'      =>  $request->material_fee,
                                'discount'          =>  $request->discount,
                                'payment_required'  =>  $request->payment_required,
                                'payment_due'       =>  $request->payment_due,
                                'payment_required'  =>  $request->payment_required,
                                'start_date'        =>  $funded_course->start_date,
                                'end_date'          =>  $funded_course->end_date,
                                'shoretype'         =>  $request->shoretype,
                                'status'            =>  $request->status,
                            ];
                            $offer_detail = $this->create_offer_letter($request->course,$ef,$state->state_key,$offer_data,$student,$ep->process_id);
                            $funded_course->offer_detail()->associate($offer_detail);
                            $funded_course->save();
                            

                        }

                        //  $funded_course_details->fill()
                    }else{
                        $exist->update($course);
                        $exist->save();
                        $this->createCompletion($exist,$state,$modeOfDelivery,$units);
                    }
                    
                    

                    
                    $ep->status = "verified";
                    $ep->student_id = $student->student_id;
                    $ep->update();
                    DB::commit();
                    if($request->offer_letter == 1){
                        $send = new EmailSendingController;
                        $ptrLink = url('ptr/process/' . $ep->process_id);
                        $reviewLink = url('enrolment-process/' . $ep->process_id);
                        $content = '<b>Dear ' . $student->party->name . ',</b><br><br>On behalf of the team at '.$org->training_organisation_name.', I would like to take this opportunity to congratulate you for getting the offer letter to study your desired course. The digital copy of your Offer letter and Enrolment Acceptance Agreement for the course is ready for you to review and to sign. <br><br>Please complete the Pre-training review here on the link <a href="' . $ptrLink . '">(PTR)</a>. The information collected from this review will help '.$org->student_id_prefix.' to remove barriers within learning and assessment processes and practices, which place individuals with specific needs and appropriateness of course for applicant. <br><br>Please review your offer letter and acceptance agreement on the ( <a href="' . $reviewLink . '">link</a> ) and sign to confirm that the information in the offer letter and acceptance agreement is true and correct.<br><br>Electronic Transactions (Queensland) Act 2001/Electronic Transactions (Victoria) Act 2000 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement.<br><br>Please deposit the AUD ' . number_format($request->payment_required, 2) . ' into the following account and send the receipt along with this offer letter and acceptance agreement.<br><br>Account name: '.$org->org_bank->account_name.'<br>BSB:'. $org->org_bank->bsb.'<br>Account number: '. $org->org_bank->account_number. '.<br><br><br>Thank you very much and I wish you good luck for your study at ' . $org->training_organisation_name . '.<br><br><br>Regards<br><br><b>Admin Team</b><br>' . $org->training_organisation_name . '<br>RTO NO: '. $org->training_organisation_id.' | CRICOS CODE: '.$org->cricos_code;
                        $this->generatePDF($ep->process_id);
                        $path = [[  'path'=> storage_path() . '/app/public/offer_letter/'. $student->student_id.'/'.$student->party->name. ' - offer letter acceptance and agreement.pdf']];
                        $send->send_automate('Pre-Training Review, Offer letter and Enrolment Acceptance Agreement', $content, [$org->training_organisation_name => $org->email_address], $emailsTo, $path, $admin_emails);
                    }
                    


                    $attachment = $this->attachment($ep->process_id);
                    if ($attachment == 'no_attachment') {
                        return response()->json(['status' => 'success', 'message' => 'Verified Successfully']);
                    } else {
                        return response()->json(['status' => 'success', 'message' => 'Verified Successfully Attachment Linked']);
                    }

                }else{
                    return response()->json(['status' => 'exist', 'message' => 'Student Already Exist']);
                }
                


            
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
            /** 
             * End DATA ENTRY 
            */
            
            $exist = Person::where('firstname',$eperson['firstname'])->where('lastname',$eperson['lastname'])->where('date_of_birth',$eperson['date_of_birth'])->first();
            if($exist == null){
                try {
                    //code...
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
           
        }else{
            return ['status'=> 'error' , 'message'=> 'Enrolment not found'];
        }

        
    }

    public function create_offer_letter($course,$enrolmentForm,$location,$offer_data,$student,$pid){
        $oSDetail = new OfferLetterStudentDetail();
        $offerletter = new OfferLetter();
        $ol_fee = new OfferLetterFee();
        $oDetail = new OfferLetterCourseDetail();

        $mcourse = CourseMatrix::where('course_code', $course['code'])->where('location', $location)->first();
        $offerletter->fill([
            'issued_date'   => Carbon::now()->format('Y-m-d'),
            'shore_type'    => $offer_data['shoretype'],
            'package_type'  => 'Non-Package',
            'status_id'     => $offer_data['status'],
            'process_id'    => $pid
        ]);
        $offerletter->student()->associate($student->student_id);
        $offerletter->user()->associate(Auth::user());
        $offerletter->save();

        $ol_fee->fill([
            'course_tuition_fee'            => $offer_data['tuition_fee'],
            'application_fee'               => $offer_data['application_fee'],
            'materials_fee'                 => $offer_data['material_fee'],
            'total_course_fee'              => $offer_data['tuition_fee'] + $offer_data['application_fee'] + $offer_data['material_fee'],
            'total_course_fee_due'          => $offer_data['tuition_fee'] + $offer_data['application_fee'] + $offer_data['material_fee'],
            'payment_required'              => $offer_data['payment_required'],
            'payment_due'                   => $offer_data['payment_due'] != '' ? Carbon::parse($offer_data['payment_due'])->timezone('Australia/Melbourne')->format('Y-m-d') : Carbon::parse($offer_data['payment_due'])->subDays(3)->timezone('Australia/Melbourne')->format('Y-m-d'),
            'balance_due'                   => $offer_data['tuition_fee'] + $offer_data['application_fee'] + $offer_data['material_fee'] - $offer_data['discount'],
            'discounted_amount'             => $offer_data['discount'],
            'installment_desired_amount'    => ($offer_data['tuition_fee'] + $offer_data['application_fee'] + $offer_data['material_fee'] )- ($offer_data['discount'] + $offer_data['payment_required']),
            'installment_interval'          => 1,
        ]);
        $ol_fee->offer_letter()->associate($offerletter);
        $ol_fee->save();
        

        $home_address  = '';
        $current_address = '';
        $addsuburb = '';
        if (isset($enrolmentForm['home_country_res_addr'])) {
            $home_address = $enrolmentForm['home_country_res_addr'];
        } else {

            if (isset($enrolmentForm['home_country_addr_flat_unit_detail'])) {
                $home_address = $enrolmentForm['home_country_addr_flat_unit_detail'];
            }

            if (isset($enrolmentForm['home_country_addr_building_property_name'])) {
                $home_address .= ' ' . $enrolmentForm['home_country_addr_building_property_name'];
            }

            if (isset($enrolmentForm['home_country_addr_street_num'])) {
                $home_address .= ' ' . $enrolmentForm['home_country_addr_street_num'];
            }

            if (isset($enrolmentForm['home_country_addre_street_name'])) {
                $home_address .= ' ' . $enrolmentForm['home_country_addre_street_name'];
            }

            if (isset($enrolmentForm['home_country_addr_suburb'])) {
                $addsuburb = explode('-', $enrolmentForm['addr_suburb']['value']);
                $home_address .= ' ' . $addsuburb[1];
            }
        }

        // dump($home_address);

        if (isset($enrolmentForm['addr_flat_unit_detail'])) {
            $current_address = $enrolmentForm['addr_flat_unit_detail'];
        }

        if (isset($enrolmentForm['addr_building_property_name'])) {
            $current_address .= ' ' . $enrolmentForm['addr_building_property_name'];
        }

        if (isset($enrolmentForm['addr_street_num'])) {
            $current_address .= ' ' . $enrolmentForm['addr_street_num'];
        }

        if (isset($enrolmentForm['addre_street_name'])) {
            $current_address .= ' ' . $enrolmentForm['addre_street_name'];
        }

        if (isset($enrolmentForm['addr_suburb'])) {
            $addsuburb = explode('-', $enrolmentForm['addr_suburb']['value']);
            $current_address .= ' ' . $addsuburb[1];
        }
        // dd($current_address);



        $passportexp = '';

        if (isset($enrolmentForm['passport_expiry_date'])) {
            if (isset($enrolmentForm['passport_expiry_date']['value'])) {
                $passportexp = Carbon::parse($enrolmentForm['passport_expiry_date']['value'])->timezone('Australia/Brisbane')->format('Y-m-d');
            } else {
                $passportexp = Carbon::parse($enrolmentForm['passport_expiry_date'])->timezone('Australia/Brisbane')->format('Y-m-d');
            }
        }


        $oSDetail->fill([
            'current_address' => $current_address,
            'home_address'      => $home_address,
            'country'           => isset($enrolmentForm['birth_country_id']) ? $enrolmentForm['birth_country_id']['identifier'] : '',
            'state_province'    => $location,
            'postcode'          => $addsuburb[0],
            'mobile'            => isset($enrolmentForm['phone_mobile']) ? $enrolmentForm['phone_mobile'] : '',
            'telephone'         => isset($enrolmentForm['phone_home']) ? $enrolmentForm['phone_home'] : '',
            'email_personal'    => isset($enrolmentForm['email']) ? $enrolmentForm['email'] : '',
            'country_birth'     => isset($enrolmentForm['birth_country_id']) ? $enrolmentForm['birth_country_id']['identifier'] : '',
            // 'visa_no'           => $request->visa_num,
            'passport_no'       => isset($enrolmentForm['passport_no']) ? $enrolmentForm['passport_no'] : '',
            'passport_exp_date' => $passportexp
        ]);
        $oSDetail->offer_letter()->associate($offerletter);
        $oSDetail->save();
        
        $oDetail->fill([
            'package_batch' => 0,
            'course_code'   => $mcourse->course_code,
            'cricos_code'     => $mcourse->criscos_code,
            'trainer_id'    => null,
            'week_duration' => $mcourse->wk_duration,
            'max_week_duration' => $mcourse->wk_duration,
            'tuition_fees'      => $offer_data['tuition_fee'],
            'max_tuition_fee'  => $offer_data['shoretype'] == 'ONSHORE' ?  $mcourse->onshore_tuition_individual : $mcourse->offshore_tuition_individual,
            'material_fees'     => $offer_data['material_fee'],
            'commition_limit'   => 0,
            'course_start_date' => Carbon::parse($offer_data['start_date'])->timezone('Australia/Melbourne')->format('Y-m-d'),
            'course_end_date' => Carbon::parse($offer_data['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d'),
            'status_id' => $offer_data['status'],
            'order' => 1
        ]);
        
        $oDetail->offer_letter()->associate($offerletter);
        $oDetail->course_matrix()->associate($mcourse->id);
        $oDetail->save();
        return $oDetail;
    }

    public function link(Request $request){
        $data = EnrolmentPack::findOrFail($request->id);


        $enrolmentForm = $data->enrolment_form;
        /* EnrolmentForm PARTS START */
        $modeOfDelivery = $enrolmentForm['mode_of_delivery']['value'];
        $personalDetails['firstname'] = $enrolmentForm['firstname'];
        $personalDetails['lastname'] = $enrolmentForm['lastname'];
        $personalDetails['middlename'] = isset($enrolmentForm['middlename']) ? $enrolmentForm['middlename'] : null;


        $personalDetails['prefix'] = $this->nullchecker('prefix', $enrolmentForm);
        $personalDetails['gender'] = isset($enrolmentForm['gender']) ? $enrolmentForm['gender'] : "";
        $personalDetails['date_of_birth'] = $this->doublenullchecker('date_of_birth', $enrolmentForm);
        $personalDetails['person_type_id'] = 5;

        $suburb = $enrolmentForm['addr_suburb'];
        $suburb_id = $suburb['id'];
        $postcode = AvtPostcode::where('id', $suburb_id)->first();
        $suburb = $postcode->suburb;
        $state = AvtStateIdentifier::where('state_key', $postcode->state)->first();
        $state_id = $state->id;

        $indigenous_status = '';
        // dd(array_key_exists('origin', $enrolmentForm));
        if (isset($enrolmentForm['origin'])) {
            if ($enrolmentForm['origin'] == 'Aboriginal') {
                $indigenous_status = 1;
            } elseif ($enrolmentForm['origin'] == 'Torres Strait Islander') {
                $indigenous_status = 2;
            } elseif ($enrolmentForm['origin'] == 'None') {
                $indigenous_status = 4;
            } else {
                $indigenous_status = 3;
            }
        } else {
            $indigenous_status = '@';
        }

        // dd($enrolmentForm);
        $disability = [];
        $pea = [];
        if (isset($enrolmentForm['disabilitiy_ids'])) {
            foreach ($enrolmentForm['disabilitiy_ids'] as $key => $value) {
                array_push($disability, $value['value']);
            }
            $disability = implode(',', $disability);
        } else {
            $disability = '';
        }

        // prior_educational_achievement_ids

        if (isset($enrolmentForm['prior_educational_achievement_ids'])) {
            foreach ($enrolmentForm['prior_educational_achievement_ids'] as $key => $value) {
                array_push($pea, $value['value']);
            }

            $pea = implode(',', $pea);
        } else {
            $pea = '';
        }



        $studentContactDetails['addr_suburb'] = $suburb; // usabon
        $studentContactDetails['addr_postal_delivery_box'] = $this->nullchecker('addr_postal_delivery_box', $enrolmentForm); //$enrolmentForm['addr_postal_delivery_box'];

        $studentContactDetails['addr_street_name'] = $this->nullchecker('addre_street_name', $enrolmentForm);
        // $studentContactDetails['addr_street_name'] = $enrolmentForm['addr_street_name'];
        $studentContactDetails['addr_street_num'] = $this->nullchecker('addr_street_num', $enrolmentForm);
        $studentContactDetails['addr_flat_unit_detail'] = $this->nullchecker('addr_flat_unit_detail', $enrolmentForm);
        $studentContactDetails['addr_building_property_name'] =  $this->nullchecker('addr_building_property_name', $enrolmentForm);
        $studentContactDetails['postcode'] = $postcode->postcode; // usabon
        $studentContactDetails['state_id'] = $state_id; // usabon
        $studentContactDetails['phone_home'] = $this->nullchecker('phone_home', $enrolmentForm);
        $studentContactDetails['phone_mobile'] = $this->nullchecker('phone_mobile', $enrolmentForm);
        $studentContactDetails['email'] = $enrolmentForm['email'];
        $studentContactDetails['email_at'] = $this->nullchecker('email_at', $enrolmentForm);
        $studentContactDetails['emer_name'] = $this->nullchecker('e_contact_name', $enrolmentForm);
        $studentContactDetails['emer_address'] = $this->nullchecker('e_address', $enrolmentForm);
        $studentContactDetails['emer_telephone'] = $this->nullchecker('e_telephone', $enrolmentForm);
        $studentContactDetails['emer_relationship'] = $this->nullchecker('e_relationship', $enrolmentForm);

        $studentDetails['highest_school_level_completed_id'] = $enrolmentForm['highest_school_level_completed_id']['value'];
        $studentDetails['indigenous_status_id'] = $indigenous_status;  //usabon
        $studentDetails['location'] = $state->state_key; // usabon;
        // $studentDetails['language_id'] = $enrolmentForm[''];
        $studentDetails['labour_force_status_id'] = $this->nullchecker('labour_force_status_id', $enrolmentForm);
        $studentDetails['country_id'] = isset($enrolmentForm['birth_country_id']) ? $enrolmentForm['birth_country_id']['identifier'] : null;
        $studentDetails['disability_flag'] = isset($enrolmentForm['disability_flag']) && $enrolmentForm['disability_flag'] == 1 ? 'Y' : 'N';
        $studentDetails['disability_ids'] = $disability;
        $studentDetails['institute'] = $this->nullchecker('institute', $enrolmentForm);
        $studentDetails['language_id'] = $this->nullchecker('spoken_language_specify', $enrolmentForm);
        $studentDetails['prior_educational_achievement_flag'] = isset($enrolmentForm['prior_educational_achievement_ids']) ? 'Y' : 'N'; //usabon
        $studentDetails['prior_educational_achievement_ids'] = $pea;
        $studentDetails['at_school_flag'] = isset($enrolmentForm['at_school']) && $enrolmentForm['at_school'] == 1 ? 'Y' : 'N';
        $studentDetails['year_completed'] = isset($enrolmentForm['year_completed']) ? $enrolmentForm['year_completed'] : '';
        $studentDetails['unique_student_id'] = $this->nullchecker('unique_student_id', $enrolmentForm);


        $studentVisaInfo['passport_number'] = $this->nullchecker('passport_no', $enrolmentForm);
        $studentVisaInfo['nationality'] = $this->nullchecker('nationality', $enrolmentForm);
        $studentVisaInfo['issue_date'] = $this->doublenullchecker('passport_issued_date', $enrolmentForm);
        $studentVisaInfo['expiry_date'] = $this->doublenullchecker('passport_expiry_date', $enrolmentForm);
        $studentVisaInfo['visa_type'] = isset($enrolmentForm['visa_type']) ? $enrolmentForm['visa_type']['id']  : '';
        $studentVisaInfo['expiry_date_visa_type'] = $this->doublenullchecker('expiry_date_visa_type', $enrolmentForm);
        $studyrights = null;
        if (isset($enrolmentForm['study_rights'])) {
            $studyrights = $enrolmentForm['study_rights'] == 1 ? "Yes" : "No";
        }
        $applied_for_au_residency = null;
        if (isset($enrolmentForm['au_permanent_residency'])) {
            $applied_for_au_residency = $enrolmentForm['au_permanent_residency'] == 1 ? "Yes" : "No";
        }
        $studentVisaInfo['study_rights'] = $studyrights;

        $studentVisaInfo['applied_for_au_residency'] = $applied_for_au_residency;
        $checker = Person::where('firstname', $personalDetails['firstname'])->where('lastname', $personalDetails['lastname'])->where('date_of_birth', $personalDetails['date_of_birth'])->first();
        try {
            DB::beginTransaction();
            $student = $checker->party->student;
            $contact = $student->contact_detail;
            $contact->update($studentContactDetails);
            $funded_student = $student->funded_detail;
            if ($enrolmentForm['usi_flag'] == 0) {
                unset($studentDetails['unique_student_id']);
            }
            $funded_student->update($studentDetails);
            $course = [];
            $units = [];
            if(isset($request->course[0])){
                $units = $request->course;
                $course = [
                    'course_code'               => '@@@@',
                    'process_id'                => $data->process_id,
                    'eligibility'               => $request->eligibility == 1 ? 'E' : 'NE',
                    'location'                  => $state->state_key,
                    'start_date'                => Carbon::parse($request->start_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                    'end_date'                  => Carbon::parse($request->end_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                    'course_fee'                => (double)$request->tuition_fee,
                    'course_fee_type'           => $request->course_fee_type,
                    'status_id'                 => $request->status,
                ];
            }else{
                $course = [
                    'course_code'               => $request->course['code'],
                    'process_id'                => $data->process_id,
                    'eligibility'               => $request->eligibility == 1 ? 'E' : 'NE',
                    'location'                  => $state->state_key,
                    'start_date'                => Carbon::parse($request->start_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                    'end_date'                  => Carbon::parse($request->end_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                    'course_fee'                => (double)$request->tuition_fee,
                    'course_fee_type'           => $request->course_fee_type,
                    'status_id'                 => $request->status,
                ];
            }

            if ($student->visa_details != null) {
                $studentVisa = $student->visa_details;
                $studentVisa->update($studentVisaInfo);
            } else {
                $studentVisa = new FundedStudentVisaDetails;
                $studentVisa->fill($studentVisaInfo);
                $studentVisa->student()->associate($student->student_id);
                $studentVisa->save();
            }

            $exist = FundedStudentCourse::where('course_code',$course['course_code'])->where('student_id',$student->student_id)->first();
            if($exist != null){
                $exist->update($course);
                    $exist->save();
                    $this->createCompletion($exist,$state,$modeOfDelivery,$units);
            }else{
                DB::rollBack();
                return ['status'=>'error'];
            }


            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function newStudent(Request $request){
        $ep = EnrolmentPack::where('process_id',$request->process_id)->first();
        if($ep != null){
            $emailsTo = [];
            if (isset($ep->enrolment_form['email']) && !in_array($ep->enrolment_form['email'], ['', null])) {
                $emailsTo[] = $ep->enrolment_form['email'];
            }
            if (isset($ep->enrolment_form['email_at']) && !in_array($ep->enrolment_form['email_at'], ['', null])) {
                $emailsTo[] = $ep->enrolment_form['email_at'];
            }
            // $emailsTo = ['niwang101@gmail.com'];
    
            // $admin_emails = ['phoenixcollegeaustralia@gmail.com', 'admin@phoenixcollege.edu.au','xyshain@gmail.com'];
            // $admin_emails = ['admin@phoenixcollege.edu.au', 'xyshain@gmail.com', 'niwang101@gmail.com'];
            $admin_emails = EmailAutomation::where('addOn', 'offer_letter')->pluck('email');
            if(isset($enrolmentForm['contact_details_email'])){
                $admin_emails[] = $enrolmentForm['contact_details_email'];
            }
            $ef = $ep->enrolment_form;
            /** 
             * Start Initiation 
             */
            $person = new Person();
            $party = new Party();
            $student = new Student();
            $student_visa = new FundedStudentVisaDetails();
            $student_detail = new FundedStudentDetails();
            $funded_contact = new FundedStudentContactDetails();
            $funded_course = new FundedStudentCourse();
            $funded_course_details = new FundedStudentCourseDetail();
            $offer_letter = new OfferLetter();
            $org = TrainingOrganisation::first();
            $stud = new StudentController;
            $suburb = $ef['addr_suburb'];
            $suburb_id = $suburb['id'];
            $postcode = AvtPostcode::where('id', $suburb_id)->first();
            $suburb = $postcode->suburb;
            $state = AvtStateIdentifier::where('state_key', $postcode->state)->first();
            $state_id = $state->id;

            $indigenous_status = '';
            if (isset($ef['origin'])) {
                if ($ef['origin'] == 'Aboriginal') {
                    $indigenous_status = 1;
                } elseif ($ef['origin'] == 'Torres Strait Islander') {
                    $indigenous_status = 2;
                } elseif ($ef['origin'] == 'None') {
                    $indigenous_status = 4;
                } else {
                    $indigenous_status = 3;
                }
            } else {
                $indigenous_status = '@';
            }
            $disability = [];
            $pea = [];
            if (isset($ef['disabilitiy_ids'])) {
                foreach ($ef['disabilitiy_ids'] as $key => $value) {
                    array_push($disability, $value['value']);
                }
                $disability = implode(',', $disability);
            } else {
                $disability = '';
            }

            // prior_educational_achievement_ids

            if (isset($ef['prior_educational_achievement_ids'])) {
                foreach ($ef['prior_educational_achievement_ids'] as $key => $value) {
                    array_push($pea, $value['value']);
                }

                $pea = implode(',', $pea);
            } else {
                $pea = '';
            }
            /** 
             * End Initiation
             */



            /** 
             * Start Data Segregation
             */

            $eperson = [
                'firstname' => $ef['firstname'],
                'lastname' => $ef['lastname'],
                'middlename' => isset($ef['middlename']) ? $ef['middlename'] : null,
                'date_of_birth' => Carbon::parse($ef['date_of_birth'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                'gender' => isset($ef['gender']) ? $ef['gender']: null,
                'prefix'  => isset($ef['prefix']) ? $ef['prefix'] : null,
                'person_type_id'=> 5
            ];

            $studentContactDetails['addr_suburb'] = $suburb; // usabon
            $studentContactDetails['addr_postal_delivery_box'] = $this->nullchecker('addr_postal_delivery_box', $ef); //$ef['addr_postal_delivery_box'];
            $studentContactDetails['addr_street_name'] = $this->nullchecker('addre_street_name', $ef);
            $studentContactDetails['addr_street_num'] = $this->nullchecker('addr_street_num', $ef);
            $studentContactDetails['addr_flat_unit_detail'] = $this->nullchecker('addr_flat_unit_detail', $ef);
            $studentContactDetails['addr_building_property_name'] =  $this->nullchecker('addr_building_property_name', $ef);
            $studentContactDetails['postcode'] = $postcode->postcode; // usabon
            $studentContactDetails['state_id'] = $state_id; // usabon
            $studentContactDetails['phone_home'] = $this->nullchecker('phone_home', $ef);
            $studentContactDetails['phone_mobile'] = $this->nullchecker('phone_mobile', $ef);
            $studentContactDetails['email'] = $ef['email'];
            $studentContactDetails['email_at'] = $this->nullchecker('email_at', $ef);
            $studentContactDetails['emer_name'] = $this->nullchecker('e_contact_name', $ef);
            $studentContactDetails['emer_address'] = $this->nullchecker('e_address', $ef);
            $studentContactDetails['emer_telephone'] = $this->nullchecker('e_telephone', $ef);
            $studentContactDetails['emer_relationship'] = $this->nullchecker('e_relationship', $ef);

            $studentDetails['highest_school_level_completed_id'] = $ef['highest_school_level_completed_id']['value'];
            $studentDetails['indigenous_status_id'] = $indigenous_status;  //usabon
            $studentDetails['location'] = $state->state_key; // usabon;
            // $studentDetails['language_id'] = $ef[''];
            $studentDetails['labour_force_status_id'] = $this->nullchecker('labour_force_status_id', $ef);
            $studentDetails['institute'] = $this->nullchecker('institute', $ef);
            $studentDetails['country_id'] = isset($ef['birth_country_id']) ? $ef['birth_country_id']['identifier'] : null;
            $studentDetails['disability_flag'] = isset($ef['disability_flag']) && $ef['disability_flag'] == 1 ? 'Y' : 'N';
            $studentDetails['disability_ids'] = $disability;
            $studentDetails['language_id'] = $this->nullchecker('spoken_language_specify', $ef);

            $studentDetails['prior_educational_achievement_flag'] = isset($ef['prior_educational_achievement_ids']) ? 'Y' : 'N'; //usabon
            $studentDetails['prior_educational_achievement_ids'] = $pea;
            $studentDetails['at_school_flag'] = isset($ef['at_school']) && $ef['at_school'] == 1 ? 'Y' : 'N';
            $studentDetails['year_completed'] = isset($ef['year_completed']) ? $ef['year_completed'] : '';
            $studentDetails['unique_student_id'] = $this->nullchecker('unique_student_id', $ef);


            $studentVisaInfo['passport_number'] = $this->nullchecker('passport_no', $ef);
            $studentVisaInfo['nationality'] = $this->nullchecker('nationality', $ef);
            $studentVisaInfo['issue_date'] = $this->doublenullchecker('passport_issued_date', $ef);
            $studentVisaInfo['expiry_date'] = $this->doublenullchecker('passport_expiry_date', $ef);
            $studentVisaInfo['visa_type'] = isset($ef['visa_type']) ? $ef['visa_type']['id']  : '';
            $studentVisaInfo['expiry_date_visa_type'] = $this->doublenullchecker('expiry_date_visa_type', $ef);
            $studyrights = null;
            if (isset($ef['study_rights'])) {
                $studyrights = $ef['study_rights'] == 1 ? "Yes" : "No";
            }
            $applied_for_au_residency = null;
            if (isset($ef['au_permanent_residency'])) {
                $applied_for_au_residency = $ef['au_permanent_residency'] == 1 ? "Yes" : "No";
            }
            $studentVisaInfo['study_rights'] = $studyrights;
            $studentVisaInfo['applied_for_au_residency'] = $applied_for_au_residency;
            $modeOfDelivery = isset($ef['mode_of_delivery']) ? $ef['mode_of_delivery']['value'] : Null;
            /**
             * End Data Segregation
             */
            
            /**
             * Start DATA ENTRY
             */
          
            try {

                    
                    DB::beginTransaction();
                    if($eperson['middlename'] == null){
                        $party->fill([
                            'party_type_id'    => 1,
                            'name'          => preg_replace('/\s+/', ' ', $eperson['firstname'] . ' '. $eperson['middlename'] .' ' . $eperson['lastname']),
                        ]);

                    }else{
                        $party->fill([
                            'party_type_id'    => 1,
                            'name'          => preg_replace('/\s+/', ' ', $eperson['firstname'] . ' ' . $eperson['lastname']),
                        ]);
                    }
                    $party->save();
                    $person->fill($eperson);
                    $person->party()->associate($party);
                    $person->save();

                    $student->fill([
                        'is_active' => 1,
                        'student_type_id' => $ep->student_type,
                    ]);

                    $student->party()->associate($party);
                    $student->user()->associate(Auth::user());
                    $student->save();

                    
                    $student->student_id = $stud->generate_student_id();
                    $student->update();
                    $student_visa->fill($studentVisaInfo);

                    $student_visa->student()->associate($student->student_id);
                    $student_visa->save();

                    $funded_contact->fill($studentContactDetails);
                    $funded_contact->student()->associate($student->student_id);
                    $funded_contact->save();
                    $student_detail->fill($studentDetails);
                    $student_detail->student()->associate($student->student_id);

                    $student_detail->contact()->associate($funded_contact);
                    $student_detail->save();
                    $course = [];
                    $units = [];
                    if(isset($request->course[0])){
                        $units = $request->course;
                        $course = [
                            'course_code'               => '@@@@',
                            'process_id'                => $ep->process_id,
                            'eligibility'               => $request->eligibility == 1 ? 'E' : 'NE',
                            'location'                  => $state->state_key,
                            'start_date'                => Carbon::parse($request->start_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                            'end_date'                  => Carbon::parse($request->end_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                            'course_fee'                => (double)$request->tuition_fee,
                            'course_fee_type'           => $request->course_fee_type,
                            'status_id'                 => $request->status,
                        ];
                    }else{
                        $course = [
                            'course_code'               => $request->course['code'],
                            'process_id'                => $ep->process_id,
                            'eligibility'               => $request->eligibility == 1 ? 'E' : 'NE',
                            'location'                  => $state->state_key,
                            'start_date'                => Carbon::parse($request->start_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                            'end_date'                  => Carbon::parse($request->end_date)->timezone('Australia/Melbourne')->format('Y-m-d'),
                            'course_fee'                => (double)$request->tuition_fee,
                            'course_fee_type'           => $request->course_fee_type,
                            'status_id'                 => $request->status,
                        ];
                    }
                
                    $exist = FundedStudentCourse::where('course_code',$course['course_code'])->where('student_id',$student->student_id)->first();
                    if($exist == null){
                        $funded_course->fill($course);
                        $funded_course->student()->associate($student->student_id);
                        $funded_course->save();
                        if($request->funding_type != null) {
                            $funding_type = AvtFundingType::where('id', $request->funding_type)->first();
                            $funded_course_details->fill([
                                'funding_type'                              => $funding_type->id,
                                'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                                'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                                'associated_course_id'                      => $funding_type->course_site_id,
                                'funding_source_national'                   => $funding_type->national_funding_code,
                                'training_contract_id'                      => $funding_type->training_contract,
                                'specific_funding_id'                       => $funding_type->specific_funding_code,
                                'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                                'study_reason_id'                           => isset($ef['study_reason_id']) ? $ef['study_reason_id']['value'] : null
                            ]);
                            $funded_course_details->funded_student_course()->associate($funded_course);
                            $funded_course_details->save();
                        }else{
                            $funded_course_details->funded_student_course()->associate($funded_course);
                            $funded_course_details->save();
                        }
                        $this->createCompletion($funded_course,$state,$modeOfDelivery,$units);
                        
                        if($request->offer_letter == 1){
                            // dd($request->all());
                           $offer_data = [
                                'tuition_fee'       =>  $request->tuition_fee,
                                'application_fee'   =>  $request->application_fee,
                                'material_fee'      =>  $request->material_fee,
                                'discount'          =>  $request->discount,
                                'payment_required'  =>  $request->payment_required,
                                'payment_due'       =>  $request->payment_due,
                                'payment_required'  =>  $request->payment_required,
                                'start_date'        =>  $funded_course->start_date,
                                'end_date'          =>  $funded_course->end_date,
                                'shoretype'         =>  $request->shoretype,
                                'status'            =>  $request->status,
                            ];
                            $offer_detail = $this->create_offer_letter($request->course,$ef,$state->state_key,$offer_data,$student,$ep->process_id);
                            $funded_course->offer_detail()->associate($offer_detail);
                            $funded_course->save();
                        }

                        //  $funded_course_details->fill()
                    }else{
                        $exist->update($course);
                        $exist->save();
                        $this->createCompletion($exist,$state,$modeOfDelivery,$units);
                    }
                    
                    

                    
                    $ep->status = "verified";
                    $ep->update();
                    DB::commit();
                    if($request->offer_letter == 1){
                        $send = new EmailSendingController;
                        $ptrLink = url('ptr/process/' . $ep->process_id);
                        $reviewLink = url('enrolment-process/' . $ep->process_id);
                        $content = '<b>Dear ' . $student->party->name . ',</b><br><br>On behalf of the team at '.$org->training_organisation_name.', I would like to take this opportunity to congratulate you for getting the offer letter to study your desired course. The digital copy of your Offer letter and Enrolment Acceptance Agreement for the course is ready for you to review and to sign. <br><br>Please complete the Pre-training review here on the link <a href="' . $ptrLink . '">(PTR)</a>. The information collected from this review will help '.$org->student_id_prefix.' to remove barriers within learning and assessment processes and practices, which place individuals with specific needs and appropriateness of course for applicant. <br><br>Please review your offer letter and acceptance agreement on the ( <a href="' . $reviewLink . '">link</a> ) and sign to confirm that the information in the offer letter and acceptance agreement is true and correct.<br><br>Electronic Transactions (Queensland) Act 2001/Electronic Transactions (Victoria) Act 2000 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement.<br><br>Please deposit the AUD ' . number_format($request->payment_required, 2) . ' into the following account and send the receipt along with this offer letter and acceptance agreement.<br><br>Account name: '.$org->org_bank->account_name.'<br>BSB:'. $org->org_bank->bsb.'<br>Account number: '. $org->org_bank->account_number. '.<br><br><br>Thank you very much and I wish you good luck for your study at ' . $org->training_organisation_name . '.<br><br><br>Regards<br><br><b>Admin Team</b><br>' . $org->training_organisation_name . '<br>RTO NO: '. $org->training_organisation_id.' | CRICOS CODE: '.$org->cricos_code;
                        $this->generatePDF($ep->process_id);
                        $path = [[  'path'=> storage_path() . '/app/public/offer_letter/'. $student->student_id.'/'.$student->party->name. ' - offer letter acceptance and agreement.pdf']];
                        $send->send_automate('Pre-Training Review, Offer letter and Enrolment Acceptance Agreement', $content, [$org->training_organisation_name => $org->email_address], $emailsTo, $path, $admin_emails);
                    }
                    $attachment = $this->attachment($ep->process_id);
                    if ($attachment == 'no_attachment') {
                        return response()->json(['status' => 'success', 'message' => 'Verified Successfully']);
                    } else {
                        return response()->json(['status' => 'success', 'message' => 'Verified Successfully Attachment Linked']);
                    }

                


            
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => $th]);
            }
            /** 
             * End DATA ENTRY 
            */
            
           
        }else{
            return ['status'=> 'error' , 'message'=> 'Enrolment not found'];
        }
    }

    private function createCompletion($funded_course,$state,$modeOfDelivery,$units){
        try {
            //code...

            DB::beginTransaction();

            $csc = new CompletionStudentCourse;
            $completion = new StudentCompletion;
            $completion_student_course = CompletionStudentCourse::where('student_course_id',$funded_course->id)->where('student_type',$funded_course->student->student_type_id)->first();
            $sc = [];
            if($completion_student_course !== null){
                $sc = StudentCompletion::where('student_id', $funded_course->student->student_id)->where('course_code', $funded_course->course_code)->get();
            }else{
                $sc = collect($sc);
            }
            if(!$sc->isEmpty()){
                if ($completion_student_course == null) {
                    $csc->fill(['student_type' => $funded_course->student->student_type_id]);
                    $csc->completion()->associate($sc[0]);
                    $csc->funded_course()->associate($funded_course->id);
                    $csc->save();

                    if($funded_course->course_code != '@@@@@'){
                        $prospectus = CourseProspectus::where('course_code', $funded_course->course_code)->where('location', $state->state_key)->first();
                        if ($prospectus != null) {
                            foreach ($prospectus->unit_selected as $unit) {
                                $completionDetail = $csc->completion->details()->where('course_unit_code', $unit->code)->first();
                                // $completionDetail = new StudentCompletionDetail;
                                $completionDetail->update([
                                    'course_unit_code' => $unit->code,
                                    'start_date' => $funded_course->start_date,
                                    'end_date' => $funded_course->end_date,
                                    'delivery_mode_id' => $modeOfDelivery
                                ]);
                            }
                        }
                    }else{
                        foreach ($units as $unit) {
                            $completionDetail = $csc->completion->details()->where('course_unit_code', $unit)->first();
                            $completionDetail->update([
                                'course_unit_code' => $unit['code'],
                                'start_date' => $funded_course->start_date,
                                'end_date' => $funded_course->end_date,
                                'extra_unit' => 1,
                                'delivery_mode_id' => $modeOfDelivery
                            ]);
                        }
                    }
                }else{
                    if ($funded_course->course_code != '@@@@') {
                        $prospectus = CourseProspectus::where('course_code', $funded_course->course_code)->where('location', $state->state_key)->first();
                        if ($prospectus != null) {
                            foreach ($prospectus->unit_selected as $unit) {
                                $completionDetail = $completion_student_course->completion->details()->where('course_unit_code', $unit->code)->first();
                                // $completionDetail = new StudentCompletionDetail;
                                $completionDetail->update([
                                    'course_unit_code' => $unit->code,
                                    'start_date' => $funded_course->start_date,
                                    'end_date' =>$funded_course->end_date,
                                    'delivery_mode_id' => $modeOfDelivery
                                ]);
                            }
                        }
                    } else {
                        foreach ($units as $unit) {
                            $completionDetail = $completion_student_course->completion->details()->where('course_unit_code', $unit)->first();
                            $completionDetail->update([
                                'course_unit_code' => $unit['code'],
                                'start_date' => $funded_course->start_date,
                                'end_date' =>$funded_course->end_date,
                                'extra_unit' => 1,
                                'delivery_mode_id' => $modeOfDelivery
                            ]);
                        }
                    }
                }
            }else{
                $completion->fill([
                    'student_id' => $funded_course->student->student_id,
                    'course_code' => $funded_course->course_code,
                    'completion_status' => 5,
                    'user_id' => Auth::user()->id
                ]);
                $completion->save();
                $csc = new CompletionStudentCourse;
                $csc->fill(['student_type' => $funded_course->student->student_type_id]);
                $csc->completion()->associate($completion);
                $csc->funded_course()->associate($funded_course);
                $csc->save();
                if ($funded_course->course_code != '@@@@') {
                    $prospectus = CourseProspectus::where('course_code', $funded_course->course_code)->where('location', $state->state_key)->first();
                        if ($prospectus != null) {
                            foreach ($prospectus->unit_selected as $unit) {

                                $completionDetail = new StudentCompletionDetail();
                                $completionDetail->fill([
                                    'course_unit_code' => $unit->code,
                                    'start_date' => $funded_course->start_date,
                                    'end_date' => $funded_course->end_date,
                                    'delivery_mode_id' => $modeOfDelivery,
                                    'training_hours' => $unit->schedule_hours
                                ]);
                                $completionDetail->completion()->associate($completion);
                                $completionDetail->save();
                            }
                        }
                } else {
                    foreach ($units as $unit) {
                        $unitdata = Unit::where('code', $unit)->first();
                        
                        $completionDetail = new StudentCompletionDetail;
                        $completionDetail->fill([
                            'course_unit_code' => $unit['code'],
                            'start_date' => $funded_course->start_date,
                            'end_date' => $funded_course->end_date,
                            'extra_unit' => 1,
                            'delivery_mode_id' => $modeOfDelivery,
                            'training_hours' => $unitdata != null ? $unitdata->schedule_hours : null
                        ]);
                        $completionDetail->completion()->associate($completion);
                        $completionDetail->save();
                    }
                }

            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Verified Successfully']);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }

    

    private function doublenullchecker($key, $array)
    {
        if ($key == 'passport_issued_date' || $key == 'passport_expiry_date' || $key == 'expiry_date_visa_type' || $key == 'date_of_birth') {
            if (isset($array[$key])) {
                if (isset($array[$key]['value'])) {
                    return Carbon::parse($array[$key]['value'])->timezone('Australia/Melbourne')->format('Y-m-d');
                } else {
                    return Carbon::parse($array[$key])->timezone('Australia/Melbourne')->format('Y-m-d');
                }
            } else {
                return null;
            }
        }
    }
    private function nullchecker($key, $array)
    {
        if ($key == 'visa_type') {
            if (isset($array[$key])) {
                return $array[$key]['id'];
            } else {
                return '';
            }
        } else if ($key == 'labour_force_status_id') {
            if (isset($array[$key])) {
                return $array[$key]['value'];
            } else {
                return '';
            }
        } else if ($key == 'spoken_language_specify') {
           
            if (isset($array[$key])) {
                if(isset($array[$key]['value'])){
                    return $array[$key]['value'];
                }else{
                   return $array[$key];
                }
            } else {
                return '';
            }
        } else if ($key == 'unique_student_id') {
            if (isset($array[$key])) {
                if (strlen($array[$key]) > 10) {
                    $str = substr($array[$key], 0, 10);
                    return $str;
                } else {
                    return $array[$key];
                }
            } else {
                return '';
            }
        } else {
            if (isset($array[$key])) {
                if ($key !== 'birth_country_id') {
                    return $array[$key];
                } else {
                    return $array[$key]['identifier'];
                }
            } else {
                return '';
            }
        }
    }

    public function attachment($process_id)
    {
        $e = EnrolmentPack::where('process_id', $process_id)->first();
        $ef = $e->enrolment_form;
        // '/storage/student/new/attachments/'
        // dump($e);
        $student = Person::where('firstname', $ef['firstname'])->where('lastname', $ef['lastname'])->where('date_of_birth', $this->doublenullchecker('date_of_birth', $ef))->first();
        // dd($e->ep_attachments);
        $attachments = $e->ep_attachments()->where('linked', '0')->get();

        if (!$attachments->isEmpty()) {
            foreach ($attachments as $attachment) {
                $studentAttachment = new StudentAttachment([
                    'name'      => $attachment->name,
                    'hash_name' => $attachment->hash_name,
                    'size'      => $attachment->size,
                    'mime_type' => $attachment->mime_type,
                    'ext'       => $attachment->ext,
                    '_input'       => $attachment->_input,
                ]);

                // associated user
                $studentAttachment->user()->associate(Auth::user());
                $studentAttachment->student()->associate($student->party->student->student_id);
                $studentAttachment->save();
                $studentAttachment->path_id = $student->party->student->student_id;
                $studentAttachment->update();
                $attachment->linked = 1;
                try {
                    Storage::disk('public')->move('/enrolment/' . $process_id . '/' . $attachment->hash_name . '.' . $attachment->ext, '/student/new/attachments/' . $studentAttachment->student_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext);
                    //code...
                    $attachment->update();
                } catch (\Throwable $th) {
                    //throw $th;
                    return 'no_attachment';
                }
            }
            return 'attachment_link';
            // return response()->json(['status' => 'success', 'message' => 'Linked Successfully']);
        } else {
            return 'no_attachment';
            // return response()->json(['status' => 'error', 'message' => 'No Files Found']);
        }

        // Storage::move('old/file.jpg', 'new/file.jpg');
    }

    public function generatePDF($process_id){
        $org = TrainingOrganisation::first();
        // dd($org);
        $ef = EnrolmentPack::where('process_id', $process_id)->first();
        // dd($ef);
        // $ol = OfferLetter::where('student_id')

        $offerData = OfferLetter::with('agent.detail', 'student.party.person', 'course_details.course', 'course_details.course_matrix', 'course_details.package.dlvr_location', 'course_details.payment_template', 'student_details', 'fees')->where('student_id', $ef->student_id)->first()->toArray();
        $offerData['location'] = $offerData['course_details'][0]['package'] ?  $offerData['course_details'][0]['package']['dlvr_location']['train_org_dlvr_loc_name']  : $offerData['course_details'][0]['course_matrix']['location'];
        // $location = explode(',',$offerData['location']);
        $cp = CourseProspectus::where('course_code', $offerData['course_details']['0']['course_code'])->where('location', 'LIKE', '%' . $offerData['location'] . '%')->first();
        // dd($cp);
        $offerData['dlvr_loc']  = TrainingDeliveryLoc::with('state')->where('train_org_dlvr_loc_id', $cp->train_org_dlvr_loc_id)->first()->toArray();
        // dd($offerData);
        $breakdown = [];
        foreach ($offerData['course_details'][0]['payment_template'] as $template) {
            $breakdown[] = [
                'due_date' => Carbon::parse($template['due_date'])->format('d/m/Y'),
                'payable' => $template['payable_amount'],
                'receipt' => ''
            ];
            // dump($template);
        }
        if (count($breakdown) > 15) {
            $breakdowns = array_chunk($breakdown, 17);
            $page = count($breakdowns);
        } else {
            // $breakdowns = $offerData['payment_sched'][0];
            $breakdowns[0] = $breakdown;
            $page = 1;
        }
        // dd($offerData);
        $signed = false;
        // dd(env('APP_NAME'));
        // dd(env('APP_NAME')); 
        // dd($offerData);


        if (env('APP_NAME') == 'Phoenix') {
            $path = storage_path() . '/app/public/offer_letter/'.$offerData['student_id'].'/';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            if ($ef->student_type == 2) {
                \PDF::loadView('enrolment.pca.offer-letter-enrolment-acceptance-agreement-domestic-pdf', compact('offerData', 'signed', 'org'))->setPaper('A4')->save($path.$offerData['student']['party']['name'] . ' - offer letter acceptance and agreement.pdf');
            }
             \PDF::loadView('enrolment.pca.offer-letter-enrolment-acceptance-agreement-pdf', compact('offerData', 'signed', 'org'))->setPaper('A4')->save($path . $offerData['student']['party']['name'] . ' - offer letter acceptance and agreement.pdf');
        } else {
            $path = storage_path() . '/app/public/offer_letter/' . $offerData['student_id'] . '/';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $path = storage_path() . '/app/public/offer_letter/';
            \PDF::loadView('enrolment.cea.offer-letter-enrolment-acceptance-agreement-pdf', compact('offerData', 'signed', 'org'))->setPaper('A4')->save($path . '/dynamicOfferletter.pdf');

            $pdf = new \PDFMerger;

            $pdf->addPDF(storage_path() . '/app/public/offer_letter/dynamicOfferletter.pdf', '1');
            $pdf->addPDF(storage_path() . '/app/public/offer_letter/offerLetterStaticPages.pdf', '1-2');
            $pdf->addPDF(storage_path() . '/app/public/offer_letter/dynamicOfferletter.pdf', '2');
            $pdf->addPDF(storage_path() . '/app/public/offer_letter/offerLetterStaticPages.pdf', '3-24');
            $pdf->addPDF(storage_path() . '/app/public/offer_letter/dynamicOfferletter.pdf', '3-4');
            $pdf->merge('file', storage_path() . '/app/public/offer_letter/'. $offerData['student_id'].'/'. $offerData['student']['party']['name'].' offer letter and enrolment acceptance agreement.pdf');
        }
    }
}
