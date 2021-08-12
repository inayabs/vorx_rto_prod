<?php

namespace App\Http\Controllers\Enrolment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Send\EmailSendingController;
use App\Http\Controllers\StudentClass\TimeTableController;
use App\Models\Attendance;
use App\Models\AvtDeliveryMode;
use App\Models\AvtFundingType;
use App\Models\AvtPostcode;
use App\Models\AvtStateIdentifier;
use App\Models\CompletionStudentCourse;
use App\Models\Course;
use App\Models\CourseProspectus;
use App\Models\EnrolmentPackAttachment;
use Carbon\Carbon;
use App\Models\EnrolmentPack;
use App\Models\FundedStudentContactDetails;
use App\Models\FundedStudentCourse;
use App\Models\FundedStudentCourseDetail;
use App\Models\FundedStudentDetails;
use App\Models\FundedStudentVisaDetails;
use App\Models\Unit;
use App\Models\OfferLetterCourseDetail;
use App\Models\OfferLetterStudentDetail;
use App\Models\OfferLetterFee;
use App\Models\Student\OfferLetter\OfferLetter;
use App\Models\CourseMatrix;
use App\Models\EmailAutomation;
use App\Models\OfferLetterStatus;
use App\Models\Student\Party;
use App\Models\Student\Person;
use App\Models\Student\Student;
use App\Models\StudentAttachment;
use App\Models\StudentClass;
use App\Models\StudentCompletion;
use App\Models\StudentCompletionDetail;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrganisation;
use Illuminate\Http\Request;
use Sabberworm\CSS\Comment\Comment;

class EnrolmentApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('checkModule:enrolment-application');
        $this->middleware('auth');
    }
    public function index()
    {
        //

        \JavaScript::put([
            'list' => EnrolmentPack::get()->pluck('enrolment_type', 'process_id'),
            'delivery_mode' => AvtDeliveryMode::all(),
            'delivery_loc'  => TrainingDeliveryLoc::with('state')->get(),
        ]);
        // dd(TrainingDeliveryLoc::with('state')->get());
        return view('enrolment.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $org = TrainingOrganisation::with('org_bank')->first();
        // dd($org);
        $data = EnrolmentPack::findOrFail($request->id);
        //
        // $this->validate($request, [
        //     'verify' => 'required',
        // ]);
        $emailsTo = [];
        if (isset($data->enrolment_form['email']) && !in_array($data->enrolment_form['email'], ['', null])) {
            $emailsTo[] = $data->enrolment_form['email'];
        }
        if (isset($data->enrolment_form['email_at']) && !in_array($data->enrolment_form['email_at'], ['', null])) {
            $emailsTo[] = $data->enrolment_form['email_at'];
        }
        // $emailsTo = ['niwang101@gmail.com'];

        // $admin_emails = ['phoenixcollegeaustralia@gmail.com', 'admin@phoenixcollege.edu.au','xyshain@gmail.com'];
        // $admin_emails = ['admin@phoenixcollege.edu.au', 'xyshain@gmail.com', 'niwang101@gmail.com'];
        $admin_emails = EmailAutomation::where('addOn', 'offer_letter')->pluck('email');
        if (isset($data->enrolmentForm['contact_details_email'])) {
            $admin_emails[] = $data->enrolmentForm['contact_details_email'];
        }
        $enrolmentForm = $data->enrolment_form;
        
        // dd($request->all());
        try {
            //code...
            \DB::beginTransaction();
            /* EnrolmentForm PARTS START */
            $modeOfDelivery = isset($enrolmentForm['mode_of_delivery']) ? $enrolmentForm['mode_of_delivery']['value'] : Null;
            $personalDetails['firstname'] = $enrolmentForm['firstname'];
            $personalDetails['lastname'] = $enrolmentForm['lastname'];
            $personalDetails['middlename'] =isset($enrolmentForm['middlename']) ? $enrolmentForm['middlename']:null;

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
            if($enrolmentForm['currently_in_australia'] === false){
                $studentContactDetails['currently_in_australia'] = false;
                $studentContactDetails['home_country_res_addr'] = $enrolmentForm['home_country_res_addr'];

            }

            $studentDetails['highest_school_level_completed_id'] = $enrolmentForm['highest_school_level_completed_id']['value'];
            $studentDetails['indigenous_status_id'] = $indigenous_status;  //usabon
            $studentDetails['location'] = $state->state_key; // usabon;
            // $studentDetails['language_id'] = $enrolmentForm[''];
            $studentDetails['labour_force_status_id'] = $this->nullchecker('labour_force_status_id', $enrolmentForm);
            $studentDetails['institute'] = $this->nullchecker('institute', $enrolmentForm);
            $studentDetails['country_id'] = isset($enrolmentForm['birth_country_id']) ? $enrolmentForm['birth_country_id']['identifier'] : null;
            $studentDetails['disability_flag'] = isset($enrolmentForm['disability_flag']) && $enrolmentForm['disability_flag'] == 1 ? 'Y' : 'N';
            $studentDetails['disability_ids'] = $disability;
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



            $checker = Person::where('firstname','like','%'.$personalDetails['firstname'].'%')->where('lastname', 'LIKE','%'. $personalDetails['lastname'].'%')->where('date_of_birth', $personalDetails['date_of_birth'])->first();
            if ($checker == null) {
                $to = TrainingOrganisation::first();
                $studIDPrefix = in_array($to->student_id_prefix, [null, '']) ? 'VRX' : $to->student_id_prefix;

                $party = new Party();
                $person = new Person;
                $student = new Student;
                $studentVisa = new FundedStudentVisaDetails;
                if($personalDetails['middlename'] != null){
                    $party->fill([
                        'party_type_id'    => 1,
                        'name'          => preg_replace('/\s+/', ' ', $personalDetails['firstname'] . ' '. $personalDetails['middlename'] .' ' . $personalDetails['lastname']),
                        // 'active'        => 1
                    ]);

                }else{
                    $party->fill([
                        'party_type_id'    => 1,
                        'name'          => preg_replace('/\s+/', ' ', $personalDetails['firstname'] . ' ' . $personalDetails['lastname']),
                        // 'active'        => 1
                    ]);
                }

                $party->save();

                $person->fill($personalDetails);
                $person->party()->associate($party);
                $person->save();

                $student->fill([
                    'is_active' => 1,
                    'student_type_id' => 2,
                ]);



                $student->party()->associate($party);
                $student->user()->associate(\Auth::user());
                $student->save();
                // $student->student_id = $studIDPrefix . str_pad($student->id + 1, 5, 0, STR_PAD_LEFT);
                $stud = new StudentController;
                $student->student_id = $stud->generate_student_id();
                $student->update();
                $studentVisa->fill($studentVisaInfo);

                $studentVisa->student()->associate($student->student_id);
                $studentVisa->save();

                // SAVE TO FUNDED IF THE STUDENT TYPE IS "DOMESTIC(2)"
                $funded_student = new FundedStudentDetails;
                $contact = new FundedStudentContactDetails;
                $contact->fill($studentContactDetails);
                $contact->student()->associate($student->student_id);
                $contact->save();
                $funded_student->fill($studentDetails);
                // dd($studentDetails);

                $funded_student->student()->associate($student->student_id);

                $funded_student->contact()->associate($contact);
                $funded_student->save();


                $courses = $request->courses;
                foreach ($courses as $key => $course) {
                    $courses[$key]['location'] = $state->state_key;
                }
                // $courseDetails = '';
                $courseDetails = isset($enrolmentForm['study_reason_id']) ? $enrolmentForm['study_reason_id']['value'] : "";
                if ($request['add_offer_letter'] == 1) {
                    $this->create_offer_letter($request->all(), $courses, $student, $enrolmentForm, $data->process_id);
                    $data->status = 'verified';
                    $data->student_id = $student->student_id;
                    $data->update();
                    \DB::commit();
                    $send = new EmailSendingController;
                    $ptrLink = url('pre-training-review/process/' . $data->process_id);
                    $reviewLink = url('enrolment-process/' . $data->process_id);

                    $content = '<b>Dear ' . $student->party->name . ',</b><br><br>On behalf of the team at '.$org->training_organisation_name.', I would like to take this opportunity to congratulate you for getting the offer letter to study your desired course. The digital copy of your Offer letter and Enrolment Acceptance Agreement for the course is ready for you to review and to sign. <br><br>Please complete the Pre-training review here on the link <a href="' . $ptrLink . '">(PTR)</a>. The information collected from this review will help PCA to remove barriers within learning and assessment processes and practices, which place individuals with specific needs and appropriateness of course for applicant. <br><br>Please review your offer letter and acceptance agreement on the ( <a href="' . $reviewLink . '">link</a> ) and sign to confirm that the information in the offer letter and acceptance agreement is true and correct.<br><br>Electronic Transactions (Queensland) Act 2001 establishes the regulatory framework for transactions to be completed electronically. This form requires you to tick the boxes and put your name as a electronic signature before submission. By ticking the box and putting the name in signature panel, you indicate your approval of the contents of this electronic offer letter and acceptance agreement.<br><br>Please deposit the amount as mentioned in the offer letter and enrolment acceptance agreement into the following account and send the receipt along with this offer letter and acceptance agreement.<br><br>Account name: '.$org->training_organisation_name.'<br>BSB: '.$org->org_bank->bsb.'<br>Account number: '.$org->org_bank->account_number. '<br><br><br>Thank you very much and I wish you good luck for your study at ' . $org->training_organisation_name . '.<br><br><br>Regards<br><br><b>Admin Team</b><br>' . $org->training_organisation_name . '<br>RTO NO: ' . $org->training_organisation_id . ' | CRICOS CODE: '.$org->cricos_code;

                    // EmailTemplate
                    // echo $content;
                    // exit();

                    $this->generatePDF($data->process_id);
                    $path = [['path' => storage_path() . '/app/public/offer_letter/' . $student->student_id . '/' . $student->party->name . ' - offer letter acceptance and agreement.pdf']];
                
                    $s = $send->send_automate('Pre-Training Review, Offer letter and Enrolment Acceptance Agreement', $content, [$org->training_organisation_name => $org->email_address], $emailsTo, $path, $admin_emails);
                    // $s = $send->send_automate('PCA Enrolment Application', $content, ['Phoenix College of Australia' => 'constant.claro@gmail.com'], ['konstant.claro@gmail.com']);

                    if ($s['status'] == 'success') {
                        $attachment = $this->attachment($data->process_id);
                        if ($attachment == 'no_attachment') {
                            return response()->json(['status' => 'success', 'message' => 'Verified Successfully']);
                        } else {
                            return response()->json(['status' => 'success', 'message' => 'Verified Successfully Attachment Linked']);
                        }
                        // return ['status' => 'success', 'site' => $org->site_url];
                    } else {
                        // return ['status' => 'error', 'message' => 'Something went wrong.'];
                        return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
                    }
                } else {
                    $this->storeCourses($courses,  $student, $courseDetails,null,$data->process_id);
                    // dd('humana');
                    $this->createCompletion($request->except('id'), $student->student_id, $state->state_key, $modeOfDelivery);
                    $data->status = 'verified';
                    $data->update();
                }

                /* EnrolmentForm PARTS END */
            } else {
                return response()->json(['status' => 'exist', 'message' => 'Student Already Exist']);
            }

            \DB::commit();


            // return response()->json(['status' => 'success', 'message' => 'Verified Successfully']);
            $attachment = $this->attachment($data->process_id);
            if ($attachment == 'no_attachment') {
                return response()->json(['status' => 'success', 'message' => 'Verified Successfully']);
            } else {
                return response()->json(['status' => 'success', 'message' => 'Verified Successfully Attachment Linked']);
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
            // return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    public function generatePDF($process_id)
    {
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
            $path = storage_path() . '/app/public/offer_letter/' . $offerData['student_id'] . '/';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            if ($ef->student_type == 2) {
                \PDF::loadView('enrolment.pca.offer-letter-enrolment-acceptance-agreement-domestic-pdf', compact('offerData', 'signed', 'org'))->setPaper('A4')->save($path . $offerData['student']['party']['name'] . ' - offer letter acceptance and agreement.pdf');
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
            $pdf->merge('file', storage_path() . '/app/public/offer_letter/' . $offerData['student_id'] . '/' . $offerData['student']['party']['name'] . ' offer letter and enrolment acceptance agreement.pdf');
        }
    }

    public function verifyChecker($student, $course)
    { }
    public function storeCourses_offer($_course, $student, $cdetail, $ocdetail,$process_id)
    {

        // foreach ($courses as $key => $_course) {
        $exist_course = FundedStudentCourse::where('student_id', $student->student_id)->where('course_code', $_course['course_code'])->first();
        if ($exist_course == null) {
            $fundedCourse = new FundedStudentCourse;
            $course = $_course;
            unset($course['funding_type']);
            $fundedCourse->fill($course);
            $discounted_amount = isset($course['discounted_amount']) && $course['discounted_amount'] > 0 ? $course['discounted_amount'] : 0;
            $fundedCourse->course_fee = $course['course_fee'] - $discounted_amount;
            $fundedCourse->process_id = $process_id;
            $fundedCourse->student()->associate($student->student_id);
            $fundedCourse->offer_detail()->associate($ocdetail);
            $fundedCourse->save();

            $fundedCourseDetail = new FundedStudentCourseDetail;
            if ($_course['funding_type'] != null) {
                $funding_type = AvtFundingType::where('id', $_course['funding_type'])->first();
                $fundedCourseDetail->fill([
                    'funding_type'                              => $funding_type->id,
                    'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                    'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                    'associated_course_id'                      => $funding_type->course_site_id,
                    'funding_source_national'                   => $funding_type->national_funding_code,
                    'training_contract_id'                      => $funding_type->training_contract,
                    'specific_funding_id'                       => $funding_type->specific_funding_code,
                    'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                    'study_reason_id'                           => $cdetail
                ]);
                $fundedCourseDetail->funded_student_course()->associate($fundedCourse);
                $fundedCourseDetail->save();
            } else {
                $fundedCourseDetail->funded_student_course()->associate($fundedCourse);
                $fundedCourseDetail->save();
            }
            return $fundedCourse;
        } else {
            $course = $_course;
            unset($course['funding_type']);
            $exist_course->update($course);
            $detail =  $exist_course->detail;
            if ($_course['funding_type'] != null) {
                $funding_type = AvtFundingType::where('id', $_course['funding_type'])->first();
                $detail->update([
                    'funding_type'                              => $funding_type->id,
                    'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                    'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                    'associated_course_id'                      => $funding_type->course_site_id,
                    'funding_source_national'                   => $funding_type->national_funding_code,
                    'training_contract_id'                      => $funding_type->training_contract,
                    'specific_funding_id'                       => $funding_type->specific_funding_code,
                    'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                    'study_reason_id'                           => $cdetail
                ]);
            }
            //
            return $exist_course;
        }
        // }
    }
    public function create_offer_letter($request, $courses, $student, $enrolmentForm, $process_id)
    {
        // dd($courses);
        $offer = new OfferLetter;
        $oStudentDetail = new OfferLetterStudentDetail;
        $ol_fee = new OfferLetterFee;
        $oCourseDetail = new OfferLetterCourseDetail;
        if (!isset($request['package'])) {
            foreach ($courses as $course) {
                $mcourse = CourseMatrix::where('course_code', $course['course_code'])->where('location', $course['location'])->first();
                // $offer->fill()
                $offer->fill([
                    'reference_id'      => null,
                    'issued_date'       => Carbon::now()->format('Y-m-d'),
                    'process_id'        => $process_id,
                    'is_sent'           => 0,
                    'remarks'           => null,
                    'shore_type'        => $course['shore_type'] != 'OffShore' ?  'OFFSHORE' : 'ONSHORE',
                    'package_type'      => isset($request['package']) ? 'Package' : 'Non-Package',
                ]);
                $offer->student()->associate($student->student_id);
                $offer->user()->associate(\Auth::user());
                $offer->save();

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


                $oStudentDetail->fill([
                    'current_address' => $current_address,
                    'home_address'      => $home_address,
                    'country'           => isset($enrolmentForm['birth_country_id']) ? $enrolmentForm['birth_country_id']['identifier'] : '',
                    'state_province'    => $course['location'],
                    'postcode'          => $addsuburb[0],
                    'mobile'            => isset($enrolmentForm['phone_mobile']) ? $enrolmentForm['phone_mobile'] : '',
                    'telephone'         => isset($enrolmentForm['phone_home']) ? $enrolmentForm['phone_home'] : '',
                    'email_personal'    => isset($enrolmentForm['email']) ? $enrolmentForm['email'] : '',
                    'country_birth'     => isset($enrolmentForm['birth_country_id']) ? $enrolmentForm['birth_country_id']['identifier'] : '',
                    // 'visa_no'           => $request->visa_num,
                    'passport_no'       => isset($enrolmentForm['passport_no']) ? $enrolmentForm['passport_no'] : '',
                    'passport_exp_date' => $passportexp
                ]);

                $oStudentDetail->offer_letter()->associate($offer);
                $oStudentDetail->save();
                $mat_fee = $course['material_fees'];
                $app_fee = $course['application_fees'];
                // $tuition = $course['shore_type'] == 'OnShore' ? $mcourse->onshore_tuition_individual : $mcourse->offshore_tuition_individual;
                $tuition = $course['course_fee'];
                $total_course_fee = $tuition + $app_fee + $mat_fee;
                // dd($course);
                if (isset($course['discounted_amount'])) {
                    if ($course['discounted_amount'] != '') {
                        $balance =  $total_course_fee - $course['discounted_amount'] - $course['payment_required'];
                    } else {
                        $balance =  $total_course_fee;
                    }
                    // $balance =  $course['course_fee'];
                } else {
                    $balance =  $total_course_fee;
                }

                
                // }
                // }
                // dd($course);
                // dd($balance);
                $ol_fee->fill([
                    'course_tuition_fee' => $tuition,
                    'application_fee' => $app_fee,
                    'materials_fee' => $mat_fee,
                    'total_course_fee' => $total_course_fee,
                    // 'oshc' => $package_structure->oshc,
                    'total_course_fee_due' => $total_course_fee,
                    'payment_required' => isset($course['payment_required']) ? $course['payment_required'] : $mat_fee+$app_fee,
                    'payment_due' => $course['payment_due'] != '' ? Carbon::parse($course['payment_due'])->timezone('Australia/Brisbane')->format('Y-m-d') : Carbon::parse($course['start_date'])->subDays(3)->format('Y-m-d'),
                    // 'payment_due' => isset($course['payment_due']) ? Carbon::parse($course['payment_due'])->timezone('Australia/Brisbane')->format('Y-m-d') : null,
                    // 'payment_required' => 1000,
                    'balance_due' => $balance,
                    'initial_payment_amount' => 0,
                    'discounted_amount' => isset($course['discounted_amount']) && $course['discounted_amount'] > 0 ? $course['discounted_amount'] : 0,
                ]);
                $ol_fee->offer_letter()->associate($offer);
                $ol_fee->save();

                $oCourseDetail->fill([
                    'package_batch' => 0,
                    'course_code'   => $mcourse->course_code,
                    'cricos_code'     => $mcourse->criscos_code,
                    'trainer_id'    => null,
                    'week_duration' => $mcourse->wk_duration,
                    'max_week_duration' => $mcourse->wk_duration,
                    'tuition_fees'      => $tuition,
                    'max_tuition_fee'  => $tuition,
                    'material_fees'     => $mat_fee,
                    // 'weekly_payment'     => $course['weekly_amount'] == '' ? '0.00' : $course['weekly_amount'],
                    'commition_limit'   => 0,
                    'course_start_date' => Carbon::parse($course['start_date'])->format('Y-m-d'),
                    'course_end_date' => Carbon::parse($course['end_date'])->format('Y-m-d'),
                    'status_id' => $course['status_id'],
                    'order' => 1
                ]);





                $oCourseDetail->offer_letter()->associate($offer);
                $oCourseDetail->course_matrix()->associate($mcourse->id);
                $oCourseDetail->save();

                $courseDetails = '';
                $courseDetails = isset($enrolmentForm['study_reason_id']) ? $enrolmentForm['study_reason_id']['value'] : "";

                $funded_course = $this->storeCourses_offer($course,  $student, $courseDetails, $oCourseDetail,$process_id);

                $sc = new StudentCompletion;
                $sc->fill([
                    'student_id' => $student->student_id,
                    'course_code' => $course['course_code'],
                    'user_id' => \Auth::user()->id,
                    'active' => 1
                ]);
                $sc->save();

                $completion_student_course = new CompletionStudentCourse;
                $completion_student_course->fill(['student_type' => 2]);
                $completion_student_course->completion()->associate($sc);
                $completion_student_course->offer_details()->associate($oCourseDetail);
                $completion_student_course->save();

                if (!isset($course['class'])) {
                    $_course = Course::where('code', $mcourse->course_code)->first();
                    $prospectuses = $_course->courseprospectus->first();
                    if ($prospectuses != null) {
                        foreach ($prospectuses->unit_selected as $key => $prosectus) {
                            $scd = new StudentCompletionDetail;
                            $scd->fill([
                                'course_unit_code' => $prosectus->code,
                                'start_date' => $oCourseDetail->course_start_date,
                                'end_date' => $oCourseDetail->course_end_date,
                                'order'   => $key + 1
                            ]);
                            $scd->completion()->associate($sc);
                            $scd->save();
                        }
                    }
                } else {
                    $class = StudentClass::with('time_table')->find($course['class']['id']);
                    $sa = new Attendance;
                    $sa->student()->associate($student->student_id);
                    $sa->course()->associate($course['course_code']);
                    $sa->student_class()->associate($class);
                    $sa->save();
                    $training_loc = TrainingDeliveryLoc::where('id', $class->delivery_loc)->first();
                    $arr_tt_units = [];
                    $timetable = $class->time_table;
                    $time_table = collect($timetable->time_table);
                    $modeOfDelivery = isset($enrolmentForm['mode_of_delivery']) ? $enrolmentForm['mode_of_delivery']['value'] : null;
                    if ($class->time_table != null) {
                        if ($class->time_table_type == 'Rotating') {
                            $unit_exist = array();
                            $start = Carbon::parse($course['start_date'])->timezone('Australia/Melbourne');
                            $deee = $time_table->reject(function ($item, $key) use ($start) {
                                $datec = Carbon::parse($item['dates']['start'])->timezone('Australia/Melbourne');
                                if ($datec->lte($start->format('Y-m-d'))) {
                                    return $item;
                                }
                            });
                            // dump($start->format('Y-m-d'));
                            foreach ($deee as $tt) {
                                if (isset($tt['unit'])) {
                                    $checker = in_array($tt['unit']['code'], $unit_exist);
                                    if ($checker === false) {
                                        $unit = $tt['unit'];
                                        array_push($unit_exist, $unit['code']);
                                        $arr_tt_units[] = [
                                            'subject_code'      => $unit['code'],
                                            'description'       => $unit['description'],
                                            'unit_type'         => $unit['unit_type'],
                                            'dates'             => ['start' => Carbon::parse($tt['dates']['start'])->timezone('Australia/Melbourne')->format('Y-m-d'), 'end' => Carbon::parse($tt['dates']['end'])->timezone('Australia/Melbourne')->format('Y-m-d')],
                                            'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                                            'training_hours'   => $tt['training_hours'],
                                            'trainer_id'        => isset($tt['trainer']) ? $tt['trainer']['id'] : null,
                                            'order'             => $tt['order']
                                        ];
                                    }
                                }
                            }
                        } else {
                            foreach ($time_table as $tt) {
                                $unit_exist = array();
                                if (isset($tt['unit'])) {
                                    $unit = $tt['unit'];
                                    array_push($unit_exist, $unit['code']);
                                    $arr_tt_units[] = [
                                        'subject_code'      => $unit['code'],
                                        'description'       => $unit['description'],
                                        'unit_type'         => $unit['unit_type'],
                                        'dates'            => ['start' => Carbon::parse($tt['dates']['start'])->timezone('Australia/Melbourne')->format('Y-m-d'), 'end' => Carbon::parse($tt['dates']['end'])->timezone('Australia/Melbourne')->format('Y-m-d')],

                                        'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                                        'training_hours'   => $tt['training_hours'],
                                        'trainer_id'        => isset($tt['trainer']) ? $tt['trainer']['id'] : null,
                                        'order'             => $tt['order']
                                    ];
                                }
                            }
                        }
                        foreach ($arr_tt_units as $tunit) {
                            $completionDetail = new StudentCompletionDetail;
                            $completionDetail->fill([
                                'course_unit_code' => $tunit['subject_code'],
                                'start_date' => Carbon::parse($tunit['dates']['start'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                                'end_date' => Carbon::parse($tunit['dates']['end'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                                'delivery_mode_id' => $modeOfDelivery,
                                'train_org_loc_id' => $tunit['train_org_loc_id'],
                                'trainer_id' => $tunit['trainer_id'],
                                'training_hours' => $tunit['training_hours'],
                                'order' => $tunit['order']
                            ]);
                            $completionDetail->completion()->associate($sc);
                            $completionDetail->save();
                        }
                    } else {
                        $_course = Course::where('code', $mcourse->course_code)->first();
                        $prospectuses = $_course->courseprospectus->first();
                        if ($prospectuses != null) {
                            foreach ($prospectuses->unit_selected as $key => $unit) {

                                $completionDetail = new StudentCompletionDetail;
                                $completionDetail->fill([
                                    'course_unit_code' => $unit->code,
                                    'start_date' => $course['start_date'],
                                    'end_date' => $course['end_date'],
                                    'delivery_mode_id' => $modeOfDelivery,
                                    'training_hours' => $unit->schedule_hours,
                                    'order' => $key + 1
                                ]);
                                $completionDetail->completion()->associate($sc);
                                $completionDetail->save();
                            }
                        }
                    }
                }
            }
            // create_offer_letter
            if (isset($class->id)) {
                $tt = new TimeTableController;
                $tt->generate_time_table($funded_course->start_date, $class->id, $funded_course->id, 0);
            }
        } else {
            dd('hello');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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

    public function show(EnrolmentPack $enrolment_application, Request $request)
    {
        // dd($enrolment_application);
        $dlvr_loc = TrainingDeliveryLoc::with(['state'])->orderBy('addr_location')->get();
        $student_status = OfferLetterStatus::all();
        $dlvr_mode = AvtDeliveryMode::all();
        $classes = StudentClass::all();
        // dd($student_status);
        // return $dlvr_loc;
        $funding_type = AvtFundingType::all();
         \JavaScript::put([
            'funding_type' => $funding_type,
            'dlvr_loc' => $dlvr_loc,
            'student_status'=> $student_status,
            'classes' => $classes,
            'dlvr_mode' => $dlvr_mode
         ]);
        return view('enrolment.show',compact('enrolment_application'));

    }

    public function storeCourses($courses, $student, $cdetail,$units = null,$process_id = null)
    {
        // dd($cdetail);
        foreach ($courses as $key => $_course) {
            if($_course['course_code'] == '@@@@'){
                
                $exist_course = FundedStudentCourse::where('student_id', $student->student_id)->where('course_code', $_course['course_code'])->first();
                $sim = [];
                if($exist_course != null){
                    $euntis = $exist_course->course_completion->completion->details;
                    $_unit = $euntis->map(function($element){
                        return $element->course_unit_code;
                    });
                            foreach($_unit as $bunit){
                                foreach($units as $unit){
                                    if($unit == $bunit){
                                        $sim[] = $unit;
                                    }
                                }
                            }
                            if(count($sim) == 0){
                                 $fundedCourse = new FundedStudentCourse;
                                 $course = $_course;
                                 $course['end_date'] = Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d');
             
                                 unset($course['funding_type']);
                                 
                                 $fundedCourse->fill($course);
                                 // dd($fundedCourse);
                                 if($process_id != null){
                                     $fundedCourse->process_id = $process_id;
                                 }
                                 $fundedCourse->student()->associate($student->student_id);
                                 $fundedCourse->save();
                                 $fundedCourseDetail = new FundedStudentCourseDetail;
                                 
                                 if ($_course['funding_type'] != null) {
                                     $funding_type = AvtFundingType::where('id', $_course['funding_type'])->first();
                                     $fundedCourseDetail->fill([
                                         'funding_type'                              => $funding_type->id,
                                         'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                                         'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                                         'associated_course_id'                      => $funding_type->course_site_id,
                                         'funding_source_national'                   => $funding_type->national_funding_code,
                                         'training_contract_id'                      => $funding_type->training_contract,
                                         'specific_funding_id'                       => $funding_type->specific_funding_code,
                                         'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                                         'study_reason_id'                           => $cdetail
                                     ]);
                                    //  dd($fundedCourseDetail);
                                   
                                     $fundedCourseDetail->funded_student_course()->associate($fundedCourse);
                                     $fundedCourseDetail->save();
                                 } else {
                                     $fundedCourseDetail->funded_student_course()->associate($fundedCourse);
                                     $fundedCourseDetail->save();
                                 }
                                 $this->createCompletionUnits($course, $fundedCourse, $course['delivery_mode']['value'],$units);
                                 return  'unit_completion';
                            }else{
                                 $course = $_course;
                                 unset($course['funding_type']);
                                 $course['end_date'] = Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d');
                                 $exist_course->update($course);
                                 $detail =  $exist_course->detail;
                                 if ($_course['funding_type'] != null) {
                                     $funding_type = AvtFundingType::where('id', $_course['funding_type'])->first();
                                     $detail->update([
                                         'funding_type'                              => $funding_type->id,
                                         'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                                         'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                                         'associated_course_id'                      => $funding_type->course_site_id,
                                         'funding_source_national'                   => $funding_type->national_funding_code,
                                         'training_contract_id'                      => $funding_type->training_contract,
                                         'specific_funding_id'                       => $funding_type->specific_funding_code,
                                         'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                                         'study_reason_id'                           => $cdetail
                                     ]);
                                 }
                            }
                }else{
                    $fundedCourse = new FundedStudentCourse;
                    $course = $_course;
                    $course['end_date'] = Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d');

                    unset($course['funding_type']);

                    $fundedCourse->fill($course);
                    // dd($fundedCourse);
                    $fundedCourse->student()->associate($student->student_id);
                    $fundedCourse->save();
                    $fundedCourseDetail = new FundedStudentCourseDetail;
                    if ($_course['funding_type'] != null) {
                        $funding_type = AvtFundingType::where('id', $_course['funding_type'])->first();
                       
                        $fundedCourseDetail->fill([
                            'funding_type'                              => $funding_type->id,
                            'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                            'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                            'associated_course_id'                      => $funding_type->course_site_id,
                            'funding_source_national'                   => $funding_type->national_funding_code,
                            'training_contract_id'                      => $funding_type->training_contract,
                            'specific_funding_id'                       => $funding_type->specific_funding_code,
                            'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                            'study_reason_id'                           => $cdetail
                        ]);

                        $fundedCourseDetail->funded_student_course()->associate($fundedCourse);
                        $fundedCourseDetail->save();
                    } else {
                        $fundedCourseDetail->funded_student_course()->associate($fundedCourse);
                        $fundedCourseDetail->save();
                    }
                 
                    return $fundedCourse;
                }
            }else{
                // if ($exist_course == null) {
                    $fundedCourse = new FundedStudentCourse;
                    $course = $_course;
                    $course['end_date'] = Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d');
    
                    unset($course['funding_type']);
                    // dd($course);
                    $fundedCourse->fill($course);
                    $fundedCourse->student()->associate($student->student_id);
                    $fundedCourse->save();
                    $fundedCourseDetail = new FundedStudentCourseDetail;
                    if ($_course['funding_type'] != null) {
                        $funding_type = AvtFundingType::where('id', $_course['funding_type'])->first();
                        $fundedCourseDetail->fill([
                            'funding_type'                              => $funding_type->id,
                            'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                            'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                            'associated_course_id'                      => $funding_type->course_site_id,
                            'funding_source_national'                   => $funding_type->national_funding_code,
                            'training_contract_id'                      => $funding_type->training_contract,
                            'specific_funding_id'                       => $funding_type->specific_funding_code,
                            'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                            'study_reason_id'                           => $cdetail
                        ]);
                        // dd($fundedCourse);
                        $fundedCourseDetail->funded_student_course()->associate($fundedCourse);
                        $fundedCourseDetail->save();
                    } else {
                        $fundedCourseDetail->funded_student_course()->associate($fundedCourse);
                        $fundedCourseDetail->save();
                    }
                    // return $fundedCourse;
                // } else {
                //     $course = $_course;
                //     unset($course['funding_type']);
                //     $course['end_date'] = Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d');
                //     $exist_course->update($course);
                //     $detail =  $exist_course->detail;
                //     if ($_course['funding_type'] != null) {
                //         $funding_type = AvtFundingType::where('id', $_course['funding_type'])->first();
                //         $detail->update([
                //             'funding_type'                              => $funding_type->id,
                //             'purchasing_contract_id'                    => $funding_type->purchasing_contract,
                //             'purchasing_contract_schedule_id'           => $funding_type->purchasing_schedule,
                //             'associated_course_id'                      => $funding_type->course_site_id,
                //             'funding_source_national'                   => $funding_type->national_funding_code,
                //             'training_contract_id'                      => $funding_type->training_contract,
                //             'specific_funding_id'                       => $funding_type->specific_funding_code,
                //             'funding_source_state_training_authority'   => $funding_type->state_funding_code,
                //             'study_reason_id'                           => $cdetail
                //         ]);
                //     }
                //     // return $exist_course;
                // }
                return $fundedCourse;
            }
            
        }
    }

    public function createCompletionUnits($course, $funded,  $modeDelivery,$units){
            $completion = new StudentCompletion;
            $completion->fill([
                'student_id' => $funded->student_id,
                'course_code' => '@@@@',
                'completion_status' => 5,
                'user_id' => \Auth::user()->id
            ]);
            $completion->save();
            $csc = new CompletionStudentCourse;
            $csc->fill(['student_type' => '2']);
            $csc->completion()->associate($completion);
            $csc->funded_course()->associate($funded->id);
            $csc->save();

            foreach ($units as $unit) {
                $unitdata = Unit::where('code', $unit)->first();
                $completionDetail = new StudentCompletionDetail;
                $completionDetail->fill([
                    'course_unit_code' => $unit,
                    'start_date' => $course['start_date'],
                    'end_date' => $course['end_date'],
                    'extra_unit' => 1,
                    'delivery_mode_id' => $modeDelivery,
                    'training_hours' => $unitdata != null ? $unitdata->schedule_hours : null
                ]);
                $completionDetail->completion()->associate($completion);
                $completionDetail->save();
            }
    }
    public function createCompletion($courses, $student, $location, $modeDelivery)
    {
   
        foreach ($courses['courses'] as $key => $course) {
            $fundedcourse = FundedStudentCourse::where('student_id', $student)->where('course_code', $course['course_code'])->first();
            // dump($fundedcourse);
            $completion_student_course = CompletionStudentCourse::where('student_course_id', $fundedcourse->id)->where('student_type', 2)->first();
            $sc = [];
            if($completion_student_course !== null){
                $sc = StudentCompletion::where('student_id', $student)->where('course_code', $course['course_code'])->get();
            }else{
                $sc = collect($sc);
            }
            if (!$sc->isEmpty()) {
                $csc = new CompletionStudentCourse;
                if ($completion_student_course == null) {

                    $csc->fill(['student_type' => '2']);
                    $csc->completion()->associate($sc[0]);
                    $csc->funded_course()->associate($fundedcourse->id);
                    $csc->save();

                    if ($course['course_code'] != '@@@@') {
                        $prospectus = CourseProspectus::where('course_code', $course['course_code'])->where('location', $location)->first();
                        // dd($prospectus);
                        if ($prospectus != null) {
                            foreach ($prospectus->unit_selected as $unit) {
                                $completionDetail = $csc->completion->details()->where('course_unit_code', $unit->code)->first();
                                // $completionDetail = new StudentCompletionDetail;
                                $completionDetail->update([
                                    'course_unit_code' => $unit->code,
                                    'start_date' => $course['start_date'],
                                    'end_date' => Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                                    'delivery_mode_id' => $modeDelivery
                                ]);
                            }
                        }
                    } else {
                        foreach ($courses['units'] as $unit) {
                            $completionDetail = $csc->completion->details()->where('course_unit_code', $unit)->first();
                            $completionDetail->update([
                                'course_unit_code' => $unit,
                                'start_date' => $course['start_date'],
                                'end_date' => Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                                'extra_unit' => 1,
                                'delivery_mode_id' => $modeDelivery
                            ]);
                        }
                    }
                } else {
                    if ($course['course_code'] != '@@@@') {
                        $prospectus = CourseProspectus::where('course_code', $course['course_code'])->where('location', $location)->first();
                        if ($prospectus != null) {
                            foreach ($prospectus->unit_selected as $unit) {
                                $completionDetail = $completion_student_course->completion->details()->where('course_unit_code', $unit->code)->first();
                                // $completionDetail = new StudentCompletionDetail;
                                $completionDetail->update([
                                    'course_unit_code' => $unit->code,
                                    'start_date' => $course['start_date'],
                                    'end_date' => Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                                    'delivery_mode_id' => $modeDelivery
                                ]);
                            }
                        }
                    } else {
                        foreach ($courses['units'] as $unit) {
                            $completionDetail = $completion_student_course->completion->details()->where('course_unit_code', $unit)->first();
                            $completionDetail->update([
                                'course_unit_code' => $unit,
                                'start_date' => $course['start_date'],
                                'end_date' => Carbon::parse($course['end_date'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                                'extra_unit' => 1,
                                'delivery_mode_id' => $modeDelivery
                            ]);
                        }
                    }
                }
            } else {
                $completion = new StudentCompletion;
                $completion->fill([
                    'student_id' => $student,
                    'course_code' => $course['course_code'],
                    'completion_status' => 5,
                    'user_id' => \Auth::user()->id
                ]);
                $completion->save();
                $csc = new CompletionStudentCourse;
                $csc->fill(['student_type' => 2]);
                $csc->completion()->associate($completion);
                $csc->funded_course()->associate($fundedcourse);
                $csc->save();

                if ($course['course_code'] != '@@@@') {
                    $prospectus = CourseProspectus::where('course_code', $course['course_code'])->where('location', $location)->first();
                    if (isset($course['class'])) {
                        $class = StudentClass::with('time_table')->find($course['class']['id']);
                        $sa = new Attendance;
                        $sa->student()->associate($student);
                        $sa->course()->associate($course['course_code']);
                        $sa->student_class()->associate($class);
                        $sa->save();
                        $training_loc = TrainingDeliveryLoc::where('id', $class->delivery_loc)->first();
                        $arr_tt_units = [];
                        $timetable = $class->time_table;
                        $time_table = collect($timetable->time_table);
                        if ($class->time_table != null) {
                            if ($class->time_table_type == 'Rotating') {
                                $unit_exist = array();
                                $start = Carbon::parse($course['start_date']);
                                $deee = $time_table->reject(function ($item, $key) use ($start) {
                                    $datec = Carbon::parse($item['dates']['start'])->timezone('Australia/Melbourne');
                                    if ($datec->lte($start)) {
                                        return $item;
                                    }
                                });

                                foreach ($deee as $tt) {
                                    if (isset($tt['unit'])) {
                                        $checker = in_array($tt['unit']['code'], $unit_exist);
                                        if ($checker === false) {
                                            $unit = $tt['unit'];
                                            array_push($unit_exist, $unit['code']);
                                            $arr_tt_units[] = [
                                                'subject_code'      => $unit['code'],
                                                'description'       => $unit['description'],
                                                'unit_type'         => $unit['unit_type'],
                                                'dates'             => ['start' => $tt['dates']['start'], 'end' => $tt['dates']['end']],
                                                'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                                                'training_hours'   => $tt['training_hours'],
                                                'trainer_id'        => isset($tt['trainer']) ? $tt['trainer']['id'] : null,
                                                'order'        => isset($tt['order']) ? $tt['order'] : null
                                            ];
                                        }
                                    }
                                }
                            } else {
                                $unit_exist = array();
                                foreach ($time_table as $tt) {
                                    // dd($tt);
                                    if (isset($tt['unit'])) {
                                        $unit = $tt['unit'];
                                        array_push($unit_exist, $unit['code']);
                                        $arr_tt_units[] = [
                                            'subject_code'      => $unit['code'],
                                            'description'       => $unit['description'],
                                            'unit_type'         => $unit['unit_type'],
                                            'dates'             => ['start' => $tt['dates']['start'], 'end' => $tt['dates']['end']],
                                            'train_org_loc_id'  => $training_loc->train_org_dlvr_loc_id,
                                            'training_hours'   => $tt['training_hours'],
                                            'trainer_id'        => isset($tt['trainer']) ? $tt['trainer']['id'] : null,
                                            'order'        => isset($tt['order']) ? $tt['order'] : null
                                        ];
                                    }
                                }
                            }
                            foreach ($arr_tt_units as $tunit) {
                                $completionDetail = new StudentCompletionDetail;
                                $completionDetail->fill([
                                    'course_unit_code' => $tunit['subject_code'],
                                    'start_date' => Carbon::parse($tunit['dates']['start'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                                    'end_date' => Carbon::parse($tunit['dates']['end'])->timezone('Australia/Melbourne')->format('Y-m-d'),
                                    'delivery_mode_id' => $modeDelivery,
                                    'train_org_loc_id' => $tunit['train_org_loc_id'],
                                    'trainer_id' => $tunit['trainer_id'],
                                    'training_hours' => $tunit['training_hours'],
                                    'order' => $tunit['order']
                                ]);
                                $completionDetail->completion()->associate($completion);
                                $completionDetail->save();
                            }
                        } else {

                            if ($prospectus != null) {
                                foreach ($prospectus->unit_selected as $unit) {

                                    $completionDetail = new StudentCompletionDetail;
                                    $completionDetail->fill([
                                        'course_unit_code' => $unit->code,
                                        'start_date' => $course['start_date'],
                                        'end_date' => $course['end_date'],
                                        'delivery_mode_id' => $modeDelivery,
                                        'training_hours' => $unit->schedule_hours
                                    ]);
                                    $completionDetail->completion()->associate($completion);
                                    $completionDetail->save();
                                }
                            }
                        }
                    } else {
                        if ($prospectus != null) {
                            foreach ($prospectus->unit_selected as $unit) {

                                $completionDetail = new StudentCompletionDetail;
                                $completionDetail->fill([
                                    'course_unit_code' => $unit->code,
                                    'start_date' => $course['start_date'],
                                    'end_date' => $course['end_date'],
                                    'delivery_mode_id' => $modeDelivery,
                                    'training_hours' => $unit->schedule_hours
                                ]);
                                $completionDetail->completion()->associate($completion);
                                $completionDetail->save();
                            }
                        }
                    }
                } else {
                    foreach ($courses['units'] as $unit) {
                        $unitdata = Unit::where('code', $unit)->first();
                        $completionDetail = new StudentCompletionDetail;
                        $completionDetail->fill([
                            'course_unit_code' => $unit,
                            'start_date' => $course['start_date'],
                            'end_date' => $course['end_date'],
                            'extra_unit' => 1,
                            'delivery_mode_id' => $modeDelivery,
                            'training_hours' => $unitdata != null ? $unitdata->schedule_hours : null
                        ]);
                        $completionDetail->completion()->associate($completion);
                        $completionDetail->save();
                    }
                }
            }
        }
    }
    public function new_student(Request $request)
    {
        $data = EnrolmentPack::findOrFail($request->id);


        $enrolmentForm = $data->enrolment_form;
        try {
            //code...
            \DB::beginTransaction();
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
            if($enrolmentForm['currently_in_australia'] === false){
                $studentContactDetails['currently_in_australia'] = false;
                $studentContactDetails['home_country_res_addr'] = $enrolmentForm['home_country_res_addr'];

            }

            $studentDetails['highest_school_level_completed_id'] = $enrolmentForm['highest_school_level_completed_id']['value'];
            $studentDetails['indigenous_status_id'] = $indigenous_status;  //usabon
            $studentDetails['location'] = $state->state_key; // usabon;
            // $studentDetails['language_id'] = $enrolmentForm[''];
            $studentDetails['labour_force_status_id'] = $this->nullchecker('labour_force_status_id', $enrolmentForm);
            $studentDetails['country_id'] = isset($enrolmentForm['birth_country_id']) ? $enrolmentForm['birth_country_id']['identifier'] : null;
            $studentDetails['disability_flag'] = isset($enrolmentForm['disability_flag']) && $enrolmentForm['disability_flag'] == 1 ? 'Y' : 'N';
            $studentDetails['disability_ids'] = $disability;
            $studentDetails['language_id'] = $this->nullchecker('spoken_language_specify', $enrolmentForm);
            $studentDetails['institute'] = $this->nullchecker('institute', $enrolmentForm);
            $studentDetails['prior_educational_achievement_flag'] = isset($enrolmentForm['prior_educational_achievement_ids']) ? 'Y' : 'N'; //usabon
            $studentDetails['prior_educational_achievement_ids'] = $pea;
            $studentDetails['at_school_flag'] = isset($enrolmentForm['at_school']) && $enrolmentForm['at_school'] == 1 ? 'Y' : 'N';
            $studentDetails['year_completed'] = isset($enrolmentForm['year_completed']) ? $enrolmentForm['year_completed'] : '';
            $studentDetails['unique_student_id'] = $this->nullchecker('unique_student_id', $enrolmentForm);
            // dd($studentDetails);

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
            $to = TrainingOrganisation::first();
            $studIDPrefix = in_array($to->student_id_prefix, [null, '']) ? 'VRX' : $to->student_id_prefix;
            $party = new Party();
            $person = new Person;
            $student = new Student;
            $studentVisa = new FundedStudentVisaDetails;

            if ($personalDetails['middlename'] != null) {
                $party->fill([
                    'party_type_id'    => 1,
                    'name'          => preg_replace('/\s+/', ' ', $personalDetails['firstname'] . ' ' . $personalDetails['middlename'] . ' ' . $personalDetails['lastname']),
                    // 'active'        => 1
                ]);
            } else {
                $party->fill([
                    'party_type_id'    => 1,
                    'name'          => preg_replace('/\s+/', ' ', $personalDetails['firstname'] . ' ' . $personalDetails['lastname']),
                    // 'active'        => 1
                ]);
            }

            $party->save();

            $person->fill($personalDetails);
            $person->party()->associate($party);
            $person->save();

            $student->fill([
                'is_active' => 1,
                'student_type_id' => 2,
            ]);



            $student->party()->associate($party);
            $student->user()->associate(\Auth::user());
            $student->save();
            // $student->student_id = $studIDPrefix . str_pad($student->id + 1, 5, 0, STR_PAD_LEFT);
            $stud = new StudentController;
            $student->student_id = $stud->generate_student_id();
            $student->update();

            $studentVisa->fill($studentVisaInfo);

            $studentVisa->student()->associate($student->student_id);
            $studentVisa->save();

            // SAVE TO FUNDED IF THE STUDENT TYPE IS "DOMESTIC(2)"
            $funded_student = new FundedStudentDetails;
            $contact = new FundedStudentContactDetails;
            $contact->fill($studentContactDetails);
            $contact->student()->associate($student->student_id);
            $contact->save();
            $funded_student->fill($studentDetails);

            $funded_student->student()->associate($student->student_id);

            $funded_student->contact()->associate($contact);
            // dd($funded_student);
            $funded_student->save();


            $courses = $request->courses;
            foreach ($courses as $key => $course) {
                $courses[$key]['location'] = $state->state_key;
            }
            // dd($courses);
            $courseDetails['study_reason_id'] = isset($enrolmentForm['study_reason_id']) ? $enrolmentForm['study_reason_id']['value'] : "";
            $this->storeCourses($courses,  $student, $courseDetails);
            $this->createCompletion($request->except('id'), $student->student_id, $state->state_key, $modeOfDelivery);
            /* EnrolmentForm PARTS END */
            $data->status = 'verified';
            $data->update();


            \DB::commit();


            return response()->json(['status' => 'success', 'message' => 'Verified Successfully']);
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
            // return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    public function link_student(Request $request)
    {
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
        if($enrolmentForm['currently_in_australia'] === false){
            $studentContactDetails['currently_in_australia'] = false;
            $studentContactDetails['home_country_res_addr'] = $enrolmentForm['home_country_res_addr'];

        }

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
            \DB::beginTransaction();
            $student = $checker->party->student;
            $contact = $student->contact_detail;
            $contact->update($studentContactDetails);
            $funded_student = $student->funded_detail;
            if ($enrolmentForm['usi_flag'] == 0) {
                unset($studentDetails['unique_student_id']);
            }
            $funded_student->update($studentDetails);
            $courses = $request->courses;
            foreach ($courses as $key => $course) {
                $courses[$key]['location'] = $state->state_key;
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
            $courseDetails['study_reason_id'] = isset($enrolmentForm['study_reason_id']) ? $enrolmentForm['study_reason_id']['value'] : "";
            
            $funded = $this->storeCourses($courses,  $student, $courseDetails['study_reason_id'],$request->units);
            if($funded != 'unit_completion'){
                $this->createCompletion($request->except('id'), $student->student_id, $state->state_key, $modeOfDelivery,$funded);
            }
            $data->status = 'verified';
            $data->update();
            \DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Linked Successfully']);
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list(Request $request)
    {
        if (isset($request->search)) {
            $en = EnrolmentPack::where('status', 'LIKE', '%' . $request->search . '%')->orWhere('student_name', 'LIKE', '%' . $request->search . '%')->wherein('status', ['complete', 'verified'])->orderBy('id', 'desc')->paginate(10);
            return $en;
        } else {
            $en = EnrolmentPack::wherein('status', ['complete', 'verified'])->orderBy('id', 'desc')->paginate(10);
            return $en;
        }
    }

    public function funding_type($location)
    {
        $state =  AvtPostcode::where('id', $location)->first();
        $funding_type = AvtFundingType::where('state_key', $state->state)->get()->pluck('name', 'id');
        return $funding_type;
    }

    public function change_enrolment_type(Request $request)
    {
        // dd($request->row['process_id']);

        $ep = EnrolmentPack::where('process_id', $request->row['process_id'])->first();
        $ep->enrolment_type = $request->type;
        $ep->update();

        return ['status' => 'success'];
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
                $studentAttachment->user()->associate(\Auth::user());
                $studentAttachment->student()->associate($student->party->student->student_id);
                $studentAttachment->save();
                $studentAttachment->path_id = $student->party->student->student_id;
                $studentAttachment->update();
                $attachment->linked = 1;
                $attachment->update();
                \Storage::disk('public')->move('/enrolment/' . $process_id . '/' . $attachment->hash_name . '.' . $attachment->ext, '/student/new/attachments/' . $studentAttachment->student_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext);
            }
            return 'attachment_link';
            // return response()->json(['status' => 'success', 'message' => 'Linked Successfully']);
        } else {
            return 'no_attachment';
            // return response()->json(['status' => 'error', 'message' => 'No Files Found']);
        }

        // Storage::move('old/file.jpg', 'new/file.jpg');
    }

    public function class_list($class_loc)
    {
        $data = AvtPostcode::where('id', $class_loc)->first('state');
        $classlist = StudentClass::with('time_table')->where('location', $data->state)->get();
        return response()->json($classlist);
    }
}
