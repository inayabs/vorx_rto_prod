<?php

namespace App\Http\Controllers\Enrolment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use App\Models\EmailAutomation;
use App\Models\AvtCountryIdentifier;
use App\Models\AvtDeliveryMode;
use App\Models\AvtDisabilityTypes;
use App\Models\AvtHighestSchlLvlCompleted;
use App\Models\AvtLabourForceStatus;
use App\Models\AvtLangIdentifier;
use App\Models\AvtPostcode;
use App\Models\AvtPriorEducationAchievement;
use App\Models\AvtStateIdentifier;
use App\Models\AvtStudyReason;
use App\Models\Course;
use App\Models\Unit;
use App\Models\EnrolmentPack;
use App\Models\TrainingOrganisation;
use App\Models\TrainingDeliveryLoc;
use App\Models\VisaStatus;
use App\Models\EnglishTest;
use App\Models\EnrolmentPackAttachment;
use App\Models\EnrolmentMandatoryDocument;
use App\Models\AgentDetail;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InternationalEnrolmentController extends Controller
{
    public function __construct() {
        // dd(config('app.name'));
        // if(config('app.name') != 'CEA'){
        //     abort(403, 'Unauthorized action.');
        // }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('yooooooooo CEA International Enrolment Form');

        // dd($this->pages());
        $app_setting = TrainingOrganisation::first();

        \JavaScript::put([
            // 'courses' => $courses->pluck('name','code'),
            // 'avtDeliveryMode' => $avtDeliveryMode->pluck('description', 'value'),
            'app_settings'  => $app_setting,
            'pages'         => $this->pages(),
            'logo_url'      => $this->get_logo(),
        ]);

        return view('enrolment.internationalIndex');
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
        $fullname = '';
        $fullname .= isset($request->inputs['firstname']) ? $request->inputs['firstname'] : '';

        if (isset($request->inputs['lastname'])) {
            $fullname .= $fullname == '' ? $request->inputs['lastname'] : ' ' . $request->inputs['lastname'];
        }

        $save = null;

        if ($request->process_id == null) {

            $save = new EnrolmentPack;

            $save->process_id = $this->codeNumber();
            $save->student_name = $fullname;
            $save->student_type = 1; //International
            $save->enrolment_type = 'Full Fee'; 
            $save->enrolment_form = $request->inputs;
            $save->save();

            $path ='/public/enrolment/international/' . $save->process_id . '/enrolment-form.txt';
            Storage::put($path, $request->pages);

            return ['status' => 'success', 'process' => $save->process_id];
        } else {

            // $jsonPages = json_decode($request->pages, true);
            $save = EnrolmentPack::where('process_id', $request->process_id)->first();
            $save->student_name = $fullname;
            $save->enrolment_form = $request->inputs;
            $save->update();

            $path = '/public/enrolment/international/' . $save->process_id . '/enrolment-form.txt';
            Storage::put($path, $request->pages);


            return ['status' => 'success', 'process' => $save->process_id];
        }

        

        // dd(json_decode($jsonPages, true));
    }



    public function codeNumber()
    {
        $number = mt_rand(000000001, 999999999);

        $number = sprintf("%09d", $number);

        if (count($this->codeNumberExist($number))) {
            return $this->codeNumber();
        }

        return $number;
    }
    public function codeNumberExist($number)
    {
        return EnrolmentPack::where('process_id', $number)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($process_id)
    {
        //
        $ep = EnrolmentPack::where('process_id', $process_id)->first();
        // dd($ep->student_type);
        $ef = $ep->enrolment_form;
        $mandatoryList = EnrolmentMandatoryDocument::all();
        $app_setting = TrainingOrganisation::first();
        if ($ep) {
            \JavaScript::put([
                'tests' => [
                    'lln' => $ep->lln ? 1 : 0,
                    'ptr' => $ep->ptr ? 1 : 0,
                ],
                'signature'         => $ep->student_signature,
                'type_signature'    => $ep->type_signature,
                'student_name'      => $ep->student_name,
                'student_type'      => $ep->student_type,
                'process_id'        => $process_id,
                'sig_acceptance_agreement' => $ep->sig_acceptance_agreement,
                'concession_docs'   => isset($ef['valid_concession_card_yes']) ? $ef['valid_concession_card_yes'] : [],
                'logo_url'          => $this->get_logo(),
                'app_settings'      => $app_setting,
                'mandatoryList'     =>  $mandatoryList->count() > 0 ? $mandatoryList : [],
                'mandatory_docs' =>  json_decode($ep->mandatory_docs, true),
                'user'              => \Auth::user() != null ? true : false,
            ]);
            return view('enrolment.attachment-signature');
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($process_id)
    {
        //
        // $ep = EnrolmentPack::where('process_id', $process_id)->first();
        $app_setting = TrainingOrganisation::first();
        \JavaScript::put([
            // 'courses' => $courses->pluck('name','code'),
            // 'avtDeliveryMode' => $avtDeliveryMode->pluck('description', 'value'),
            'pages' => $this->pages($process_id),
            'process_id' => $process_id,
            'app_settings' => $app_setting,
            'logo_url'      => $this->get_logo(),
            // 'signature' => $ep->signature,
        ]);

        return view('enrolment.internationalIndex');
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

    public function finish(Request $request, $process_id)
    {
        $ep = EnrolmentPack::where('process_id', $process_id)->first();
        $org = TrainingOrganisation::first();

        if($ep){
            $ep->status = 'complete';
            $ep->type_signature = $request->type_signature != '' ? $request->type_signature : null;
            $ep->student_signature = $request->signature != '' ? $request->signature : null;
            $ep->update();

            // dd($ep->enrolment_form['email']);

            if(!isset(\Auth::user()->id)){
                $email = [];
                if(isset($ep->enrolment_form['email']) && !in_array($ep->enrolment_form['email'], ['', null])){
                    $email[] = $ep->enrolment_form['email']; 
                }
                if(isset($ep->enrolment_form['email_at']) && !in_array($ep->enrolment_form['email_at'], ['', null])){
                    $email[] = $ep->enrolment_form['email_at']; 
                }

                $emailBcc = ['ashmarkinvestments@gmail.com', 'admissions@communityeducation.edu.au'];
                // agent email
                if(isset($ep->enrolment_form['contact_details_email']) && !in_array($ep->enrolment_form['contact_details_email'], ['', null])){
                    $emailBcc[] = $ep->enrolment_form['contact_details_email']; 
                }
                // dd($email);
                $send = new EmailSendingController;
    
                $content = '<b>Dear '.$ep->student_name.',</b><br><br>We would like to thank you to express of your interest to study your desired course at Community Education Australia (RTO NO: 6074). One of our friendly team members will assess your application and contact you shortly.<br><br>We wish you good luck for your studies.<br><br>Regards<br><br><b>Admin Team</b><br>Community Education Australia<br>RTO NO:6074';
    
                $s = $send->send_automate('CEA Enrolment Application', $content, ['Community Education Australia' => $org->email_address], $email, [], $emailBcc);
                // $s = $send->send_automate('CEA International Enrolment Application', $content, ['Community Education Australia' => $org->email_address], ['jim@you1st.com.au']);
            }else{
                $s = ['status'=>'success'];
            }

            if($s['status'] == 'success'){
                return ['status' => 'success', 'site' => $org->site_url];
            }else{
                return ['status' => 'error', 'message' => 'Something went wrong.'];
            }


            
        }else{
            return ['status' => 'error', 'msg' => 'No enrolment form found'];
        }
    }

    public function pages ($process_id = null)
    {

        if ($process_id != null) {
            $ep = EnrolmentPack::where('process_id', $process_id)->first();
            // return json_decode($ep->enrolment_form, true);
            $enrolment_form = Storage::get('/public/enrolment/international/' . $ep->process_id . '/enrolment-form.txt');
            // dd($enrolment_form);
            return json_decode($enrolment_form,true);
        }

        // $courses = Course::select(DB::raw('id, code, name as name_only, concat(code, " - ", name) as name'))->where('is_active', 1)->has('matrix')->get();
        $courses = Course::with(['matrix'])->where('is_active', 1)->has('matrix')->get();
        $getCourses = [];
        foreach ($courses as $key => $value) {
            // dump($value);
            foreach ($value->matrix as $v) {
                $getCourses[] = [
                    'id' => $value->id,
                    'code' => $value->code,
                    'name_only' => $value->name,
                    'name' => $value->code.' - '.$value->name. ' (CRICOS CODE: '.$v->cricos_code.', Duration '. $v->wk_duration .' Weeks)',
                    'location' => $v->location
                ];
            }
        }
        // $units = Unit::select(DB::raw('id, code, description as name_only, concat(code, " - ", description) as description'))->where('extra_unit', 1)->get();
        $units = [];
        $avtDeliveryMode = AvtDeliveryMode::where('alt_description', '<>', null)->get();
        $avtPostcodeGeo = AvtPostcode::select(DB::raw('id, concat(postcode, " - ", suburb, ", ", state) as value'))->get();
        $visaType = VisaStatus::select(DB::raw('id, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS value'))->get();
        $highSchoolLevel = AvtHighestSchlLvlCompleted::all()->toArray();
        // $highQual = array_merge($highSchoolLevel, [['id' => 8, 'value' => '@@', 'description' => 'Bachelor']]);

        // dd($highQual);

        // dd(Course::select(DB::raw('code, name'))->where('is_active', 1)->get());
        $courses_units = [];
        foreach($courses as $v){
            $courses_units[] = [
                '<p class="text-center">'.$v->code.'</p>',
                '<p class="text-center">'.$v->name_only.'</p>'
            ];
        }
        foreach($units as $v){
            $courses_units[] = [
                '<p class="text-center">'.$v->code.'</p>',
                '<p class="text-center">'.$v->name_only.'</p>'
            ];
        }
        // dd($courses_units);
        // $courses_units = array_merge(),;

        // dd($avtPostcodeGeo);
        $pages = [
            [
                "component" => [ //start components
                    [
                        "title" => '1. Course',
                        'inputs' => [
                            [
                                'type' => 'multiselect',
                                'name' => 'course',
                                'multiselect' => false,
                                'label'=> 'The Course you are applying for',
                                'selections' => $getCourses,
                                'mTrackBy' => 'code',
                                'mLabel' => 'name',
                                'required' => true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'units',
                                'multiselect' => true,
                                'label'=> 'AND / OR The unit(s) you are applying for',
                                'selections' => $units,
                                'mTrackBy' => 'code',
                                'mLabel' => 'description',
                                'required'=> true,
                                'col_size' => 12,
                            ]
                        ]
                    ],
                    [
                        "title" => '2. Mode of Delivery',
                        'inputs' => [
                            [
                                'type' => 'multiselect',
                                'name' => 'mode_of_delivery',
                                'multiselect' => false,
                                'label' => 'Select Mode of Delivery',
                                'selections' => $avtDeliveryMode,
                                'mTrackBy' => 'value',
                                'mLabel' => 'alt_description',
                                'required'=> true,
                                'col_size' => 12,
                            ]
                        ]
                    ],
                    [
                        "title" => '3. Personal Details',
                        'inputs' => [
                            [
                                'type' => 'select',
                                'name' => 'prefix',
                                'label' => 'Title',
                                'items' => ['Mr.' => 'Mr.', 'Mrs.' => 'Mrs.', 'Miss' => 'Miss', 'Dr.' => 'Dr.', 'Other' => 'Other'],
                            ],
                            [
                                'type' => 'text',
                                'name' => 'lastname',
                                'label' => 'Family Name',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'firstname',
                                'label' => 'First Name',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'middlename',
                                'label' => 'Middle Name',
                            ],
                            [
                                'type' => 'select',
                                'name' => 'gender',
                                'label' => 'Gender',
                                'items' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other', '@' => 'Don\'t want to disclose'],
                                'required' => true,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'date_of_birth',
                                'label' => 'Date of Birth',
                                'required' => true,
                            ],
                        ]
                    ],
                    [
                        'title' => '4. Contact Details',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'home_country_res_addr',
                                'label' => 'Home Country Address',
                                'required' => true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'label',
                                'name' => 'Australian Residential Address',
                                'col_size' => 12
                            ],
                            [
                                'type' => 'text',
                                'name' => 'addr_flat_unit_detail',
                                'label' => 'Unit',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'addr_building_property_name',
                                'label' => 'Building Name',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'addr_street_num',
                                'label' => 'Street Number',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'addre_street_name',
                                'label' => 'Street Name',
                                'required' => true,
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'addr_suburb',
                                'multiselect' => false,
                                'label' => 'Postcode - Suburb, State',
                                'selections' => $avtPostcodeGeo,
                                'mTrackBy' => 'id',
                                'mLabel' => 'value',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'addr_postal_delivery_box',
                                'label' => 'Postal Address (if different from above)',
                                'col_size' => 12,
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'phone_home',
                                'label' => 'Telephone',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'phone_mobile',
                                'label' => 'Mobile',
                                'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'email',
                                'label' => 'Email',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'email_at',
                                'label' => 'Alternative Email',
                                // 'required'=> true,
                            ],
                        ]
                    ],
                    [
                        'title' => '5. Emergency Contact Details',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'e_contact_name',
                                'label' => 'Name',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'e_address',
                                'label' => 'Address',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'e_telephone',
                                'label' => 'Telephone',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'e_relationship',
                                'label' => 'Relationship',
                                // 'required'=> true,
                            ],
                        ]
                    ],


                ], // end components

            ],
            [
                'component' => [ //start component
                    [
                        'title' => '6. Residency & Visa Information',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'nationality',
                                'label' => 'Nationality',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'passport_no',
                                'label' => 'Passport No.',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'passport_issued_date',
                                'label' => 'Issued Date',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'passport_expiry_date',
                                'label' => 'Expiry Date',
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'visa_type',
                                'multiselect' => false,
                                'label' => 'Visa Type (if not Australian Citizen)',
                                'selections' => $visaType,
                                'mTrackBy' => 'id',
                                'mLabel' => 'value',
                                // 'required' => true,
                                'col_size' => 12,
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'visa_expiry_date',
                                'label' => 'Expiry Date',
                                'col_size' => 3,
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'study_rights',
                                'label' => 'Study Rights in Australia',
                                'value' => 1,
                                'col_size' => 3,
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'au_permanent_residency',
                                'label' => 'Applied for Australian Permanent Residency',
                                'value' => 1,
                                'col_size' => 6,
                                // 'required'=> true,
                            ],

                        ]
                    ],
                    [
                        'title' => '7. Schooling',
                        'inputs' => [
                            [
                                'type' => 'checkbox',
                                'name' => 'at_school',
                                'label' => 'Still in School',
                                'value' => 0,
                                'required' => true,
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'highest_school_level_completed_id',
                                'multiselect' => false,
                                'label' => 'Highest School Level Completed',
                                'selections' => $highSchoolLevel,
                                'mTrackBy' => 'value',
                                'mLabel' => 'description',
                                'required' => true,
                            ],
                            [
                                'type' => 'number',
                                'name' => 'year_completed',
                                'label' => 'Year Completed',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'institute',
                                'label' => 'Institute',
                            ],
                        ]
                    ],
                    [
                        'title' => '8. Previous Qualifications Achieved',
                        'inputs' => [
                            [
                                'type' => 'checkbox',
                                'name' => 'post_secondary',
                                'label' => 'Post-Secondary',
                                'value' => 0,
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'post_highest_qualification_completed_id',
                                'label' => 'Highest Qualification Completed',
                                // 'required'=> true,
                            ],
                            // [
                            //     'type' => 'multiselect',
                            //     'name' => 'post_highest_qualification_completed_id',
                            //     'multiselect' => false,
                            //     'label' => 'Highest Qualification Completed',
                            //     'selections' => $highSchoolLevel,
                            //     'mTrackBy' => 'value',
                            //     'mLabel' => 'description',
                            //     // 'required' => true,
                            // ],
                            [
                                'type' => 'number',
                                'name' => 'post_year_completed',
                                'label' => 'Year Completed',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'post_institute',
                                'label' => 'Institute',
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'prior_educational_achievement_ids',
                                'multiselect' => true,
                                'label' => 'Equivalent (Please provide certified documents for the courses that you took.)',
                                'selections' => AvtPriorEducationAchievement::all(),
                                'mTrackBy' => 'value',
                                'second_option' => [
                                    'description' => 'Please check which is applicable',
                                    'values' => ['A'=>'A - Australian', 'E'=>'E - Australian Equivalent', 'I'=>'I - International']
                                ],
                                'mLabel' => 'description',
                                'col_size' => 12,
                                // 'required'=> true,
                            ],
                        ]
                    ],
                    [
                        'title' => '9. Language and Cultural Diversity',
                        'inputs' => [
                            [
                                'type' => 'multiselect',
                                'name' => 'birth_country_id',
                                'multiselect' => false,
                                'label' => 'Birth Country',
                                'selections' => AvtCountryIdentifier::all(),
                                'mTrackBy' => 'identifier',
                                'mLabel' => 'full_name',
                                'required' => true,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'spoken_language',
                                'label' => 'Spoken Language (Other than English)',
                                'value' => 0,
                                // 'required'=> true,
                            ],
                            [
                                // 'type' => 'text',
                                // 'name' => 'spoken_language_specify',
                                // 'label' => 'If yes, please specify',
                                // 'required'=> true,
                                'type' => 'multiselect',
                                'name' => 'spoken_language_specify',
                                'multiselect' => false,
                                'label' => 'If yes, please specify',
                                'selections' => AvtLangIdentifier::all(),
                                'mTrackBy' => 'value',
                                'mLabel' => 'description',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'select',
                                'name' => 'english_language',
                                'label' => 'English Language',
                                'items' => ['Very Well' => 'Very Well', 'Well' => 'Well', 'Not Well' => 'Not Well', 'Not at all' => 'Not at all'],
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'select',
                                'name' => 'origin',
                                'label' => 'Origin',
                                'required' => true,
                                'items' => ['None' => 'None', 'Aboriginal' => 'Aboriginal', 'Torres Strait Islander' => 'Torres Strait Islander', 'Both' => 'Both'],
                                // 'required'=> true,
                            ],

                        ]
                    ],
                    [
                        'title' => '10. Disability',
                        'inputs' => [
                            [
                                'type' => 'checkbox',
                                'name' => 'disability_flag',
                                'label' => 'Do you consider yourself to have a disability, impairment or long-term condition?',
                                'tooltip' => 'If you answered ‘Yes’, you can contact CEA for further support services available',
                                'value' => 0,
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'disabilitiy_ids',
                                'multiselect' => true,
                                'label' => 'If yes, please indicate the areas of condition:',
                                'selections' => AvtDisabilityTypes::all(),
                                'mTrackBy' => 'value',
                                'mLabel' => 'description',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'specify_disability',
                                'label' => 'If Other, please specify',
                                'col_size' => 12,
                            ]

                        ]
                    ],
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => '11. Employment',
                        'inputs' => [
                            [
                                'type' => 'multiselect',
                                'name' => 'labour_force_status_id',
                                'multiselect' => false,
                                'label' => 'Employment Status : Which Best describes your current emplyoment status?',
                                'selections' => AvtLabourForceStatus::all(),
                                'mTrackBy' => 'value',
                                'mLabel' => 'status',
                                'required' => true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'if_employed',
                                'multiselect' => false,
                                'label' => 'If currently Employed, or recently been employed',
                                'tooltip' => 'Choose the classification of occupation that best describe your occupation',
                                'selections' => [
                                    ['value' => 'Manager', 'name' => 'Manager'],
                                    ['value' => 'Professional', 'name' => 'Professional'],
                                    ['value' => 'Admin & Support', 'name' => 'Admin & Support'],
                                    ['value' => 'Community & Personal Service Worker', 'name' => 'Community & Personal Service Worker'],
                                    ['value' => 'Early Childhood Educator', 'name' => 'Early Childhood Educator'],
                                    ['value' => 'Other', 'name' => 'Other'],
                                ],
                                'mTrackBy' => 'value',
                                'mLabel' => 'name',
                                'col_size' => 6,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'if_employed_other',
                                'label' => 'If other, please specify',
                                'col_size' => 6,
                            ],

                        ]
                    ],
                    [
                        'title' => '12. Study Reason',
                        'inputs' => [
                            [
                                'type' => 'multiselect',
                                'name' => 'study_reason_id',
                                'multiselect' => false,
                                'label' => 'Main Reason : In following categories, which BEST describes your main reason for undertaking the course(s) with CEA?',
                                'selections' => AvtStudyReason::all(),
                                'mTrackBy' => 'value',
                                'mLabel' => 'description',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'study_reason_other',
                                'label' => 'If other, please state',
                                'col_size' => 12,
                            ],

                        ]
                    ],
                    [
                        'title' => '13. RPL / CREDIT TRANSFER',
                        'inputs' => [
                            [
                                'type' => 'checkbox',
                                'name' => 'rpl_ct_flag',
                                'label' => 'Requirement : Are you seeking Recognition of Prior Learning or Credit Transfer?',
                                'tooltip' => 'If ‘Yes’, then please contact Admissions Department for further details about the Recognition of Prior Learning (RPL) / Credit Transfer (CT) process.',
                                'value' => 0,
                                'col_size' => 12,
                            ],

                        ]
                    ],
                    [
                        'title' => '14. TRANSFERRING LEARNING',
                        'inputs' => [
                            [
                                'type' => 'checkbox',
                                'name' => 'trasferring_learning',
                                'label' => 'Are you transferring from another education provider in Australia?',
                                // 'tooltip' => 'If ‘Yes’, then please contact Admissions Department for further details about the Recognition of Prior Learning (RPL) / Credit Transfer (CT) process.',
                                'value' => 0,
                                'col_size' => 7,
                            ],
                            [
                                'type' => 'checkbox',
                                'name' => 'currently_enrolled_in_an_institute',
                                'label' => 'Are you currently enrolled in an institute?',
                                // 'tooltip' => 'If ‘Yes’, then please contact Admissions Department for further details about the Recognition of Prior Learning (RPL) / Credit Transfer (CT) process.',
                                'value' => 0,
                                'col_size' => 5,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'currently_enrolled_in_an_institute_if_yes',
                                'label' => 'If Yes, then please provide the name of institute:',
                                'col_size' => 12,
                            ],

                        ]
                    ],
                    [

                        'title' => '15. Unique Student Identifier',
                        'inputs' => [
                            [
                                'type' => 'checkbox',
                                'name' => 'usi_flag',
                                'label' => 'Have you applied for Unique Student Identifier (USI) before?',
                                // 'tooltip' => 'If ‘Yes’, then please contact Admissions Department for further details about the Recognition of Prior Learning (RPL) / Credit Transfer (CT) process.',
                                'value' => 0,
                                // 'col_size' => 7,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'unique_student_id',
                                'label' => 'If ‘Yes’, please provide your USI',
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'if_no_usi',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>If ‘No’,</b> you can visit <a href="https://www.usi.gov.au/">https://www.usi.gov.au/</a> to create USI. Once created, please provide the same to Admissions department. If you want CEA to create USI on your behalf, please contact Admissions department, email at <a href = "mailto:info@communityeducation.edu.au">info@communityeducation.edu.au</a> or call (07)37081061 for further guidance.',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                        ]
                    ],
                ] // end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => '16. Fee Statement and Refunds',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'fees_policy_statement',
                                'label'=> 'Fees Policy Statement',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'The policy of the organisation is at all times to be fair and equitable to registered students. Applications for refunds can be made to the CEO of the organisation. Please go through Student Handbook for detailed policy and procedure. CEA makes sure that all stakeholders are informed about fees and charges for all courses on our scope. It identifies the processes in place to protect the fees paid by students in advance and also includes implementing the course fee outline (Please refer to the table below). Details of fees and charges are also supplied in the course information for each course and on our website (<a href="http://communityeducation.edu.au/" target="_blank">http://communityeducation.edu.au/</a>). Please also consult our course adviser for further details.',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'courses_fees',
                                'label'=> 'Courses Fees',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'The fee includes enrolment charges, tuition, and material costs associated with delivering the training and assessment services and awarding the qualification to the participant. Check with CEA Staff for latest fee schedule.',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Students who are unable to meet their payment deadlines should inform CEA staff and can request for payment plans. This is legally binding document between Community Education Australia and the student enrolling in a course. Full payment is required before course completion. No certificate will be awarded if full payment has not been received.',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                        ]
                    ]
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => '17. Fee Payment',

                        'inputs' => [
                            [
                                'type' => 'multiselect',
                                'name' => 'payment_method',
                                'multiselect' => false,
                                'label' => 'Payment Method',
                                'selections' => [
                                    ['value' => 'Cash', 'description' => 'Cash'],
                                    ['value' => 'Direct Deposit in CEA’s Bank Account', 'description' => 'Direct Deposit in CEA’s Bank Account'],
                                    ['value' => 'Credit Card', 'description' => 'Credit Card'],
                                ],
                                'mTrackBy' => 'value',
                                'mLabel' => 'description',
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'bank_details',
                                'label' => 'Bank Details (Please put your full name in description of direct deposit payment)',
                                'content' => [
                                    [
                                        'type' => 'table',
                                        'body' => [
                                            'column_width' => ['40%','60%'],
                                            'text_type' => ['text-center','text-left'],
                                            'background_color' => ['background-blue', 'none'],
                                            'tbody' => [
                                                [
                                                    '<b>Bank</p>',
                                                    'Commonwealth Bank Australia',
                                                ],
                                                [
                                                    '<b>BSB</p>',
                                                    '062 692',
                                                ],
                                                [
                                                    '<b>Account Number</p>',
                                                    ' 41445977',
                                                ],
                                                [
                                                    '<b>Account Name</p>',
                                                    'McEvoy & Doust Pty Ltd trading as Community Education Australia',
                                                ],
                                            ]
                                        ],
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'credit_card_type',
                                'multiselect' => false,
                                'tooltip' => 'I give permission for fee to be charged to my Credit Card for the selected course.',
                                'label' => 'Credit Card',
                                'selections' => [
                                    ['value' => 'Visa', 'description' => 'Visa'],
                                    ['value' => 'Master Card', 'description' => 'Master Card'],
                                ],
                                'mTrackBy' => 'value',
                                'mLabel' => 'description',
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'card_expiry_date',
                                'label' => 'Card Expiry Date',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'card_number',
                                'label' => 'Card Number',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'card_id_num',
                                'label' => 'Card Identification Number',
                                'tooltip' => "last 3 digits located on back",
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'amount_to_be_charged',
                                'label' => 'Amount to be charged',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'card_holder_name',
                                'label' => 'Card Holder’s Name',
                                // 'required'=> true,
                                // 'col_size' => 12,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'card_holder_signature',
                            //     'label'=> 'Card Holder’s Signature',
                            //     // 'required'=> true,
                            //     // 'col_size' => 12,
                            // ],
                        ]
                    ],
                    [
                        'title' => '18. Education Agent (Details of approved
                        Education Agent)',
                        'inputs' => [
                            [
                                'type' => 'inputgroup',
                                'name' => 'agent_code',
                                'tooltip' => 'Click find to verify agent.',
                                'label' => 'Agent Code',
                                // 'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'company_title',
                                'label' => 'Company Name',
                                // 'required'=> true,
                                'col_size' => 6,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'contact_name',
                                'label' => 'Contact Name',
                                // 'required'=> true,
                                'col_size' => 6,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'contact_details',
                                'label' => 'Contact Details',
                                // 'required'=> true,
                                'col_size' => 6,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'contact_details_email',
                                'label' => 'Email',
                                // 'required'=> true,
                                'col_size' => 6,
                            ],
                            [
                                'type' => 'textarea',
                                'name' => 'agents_comments',
                                'label' => 'Agent’s comments on this application',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'label' => 'Declaration:',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 
                                        '<ul>
                                            <li>I have assessed the applicant and to the best of my knowledge the applicant is</li>
                                            <li>To the best of my knowledge, the applicant is genuine in making this application and has every intention of completing all programs listed in the application.</li>
                                            <li>The documents which form part of this application appear to be authentic and valid. To the best of my knowledge the applicant has genuine access to the total funds required, while in Australia, to cover all travel, OSHC, tuition and living costs for themselves and their family members (if applicable).</li>
                                            <li>I recommend that CEA proceed with the assessment for admission of this applicant.</li>
                                            <li>I confirm the student has signed the application form.</li>
                                            <li>I have provided the student’s personal email address and residential address, as disclosed to me by the student.</li>
                                        </ul>',
                                    ],
                                ],
                                'col_size' => 12
                            ],
                            [
                                'type' => 'date',
                                'name' => 'ed_agent_date',
                                'label' => 'Date',
                            ],
                            [
                                'type' => 'text',
                                'name' => 'agents_signature',
                                'label' => 'Agent’s Signature',
                                // 'required'=> true,
                                'col_size' => 6,
                            ],
                        ]
                    ],
                    [
                        'title' => '19. Policies & Procedures',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'label' => 'Information',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'To ensure that you, as a student, understand your obligations and commitments to this course, we have developed our Community Education Australia <b>Student Handbook.</b>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'It is important that you read our handbook prior to submitting these documents. As part of the enrolment process, CEA delegate will summarise this and ask you to confirm your knowledge and understanding as well as your commitment and obligations.',
                                    ],
                                ],
                                // 'col_size' => 12
                            ],
                            [
                                'type' => 'card',
                                'name' => 'policies_procedure_access',
                                'label' => 'Policies & Procedures Access',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Please refer to CEA’s <b>Student Handbook</b> for following policies and procedures:<br><ul><li>Complaints and Appeals Policy and Procedure</li><li>Critical Incident Policy and Procedure</li><li>Pre-Enrolment Engagement Policy and Procedures</li><li>Entry Requirements for International Students Policy and procedure</li><li>Fee Charges and Refunds Policy and Procedure</li><li>Deferral suspension and cancellation policy and procedure</li><li>Recognition of Prior Learning and Credit Transfer policy and procedure</li><li>Student Support Services Policy and Procedure</li><li>Privacy and Personal Information Policy and Procedure</li><li>Certification, issuing and recognition of Qualifications Policy and Procedure</li><li>Monitoring Course Progress and Intervention Strategy for International Students Policy and Procedure</li><li>Attendance Monitoring Policy and Procedure</li><li>Overseas Students Transfer Policy and Procedure</li><li>Plagiarism, Academic Misconduct and non-academic Misconduct Policy and Procedure</li><li>Assessment and Reassessment Policy and Procedure</li></ul>',
                                    ],
                                ]
                            ],
                        ],

                    ]
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'ENROLMENT DECLARATION (For every Prospective Student to sign)',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'enrol_dec',
                                'label' => '',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Please go through the eligibility criteria carefully before submission of the documents. The information is provided on our website <a href="http://communityeducation.edu.au">http://communityeducation.edu.au</a> and Student Handbook.',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Student Privacy Information</b><br>Community Education Australia (CEA) is required to provide both State and Commonwealth Government, with student and training activity data which may include information you provide in this enrolment application form. Information is required to be provided for statistical purposes and in accordance with Information and Privacy Policy. The Education and Training Reform Act 2006, the Student Identifiers Act 2014 (Cth) and the Student Identifiers Regulation 2014 (Cth) require and Community Education Australia to collect and disclose student personal information for a number of purposes including Commonwealth’s Unique Student Identifier (USI). For more information in relation to how student information may be used or disclosed, please refer to Community Education Australia’s Personal Information & Privacy Policy and Procedure. <a href="http://communityeducation.edu.au">(http://communityeducation.edu.au/)</a> or contact Community Education Australia on (07) 3708 1061.',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Privacy Notice</b><br>Under the Data Provision Requirements 2012, Community Education Australia (CEA) is required to collect personal information about you and to disclose that personal information to the National Centre for Vocational Education Research Ltd (NCVER).',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Your personal information (including the personal information contained on this enrolment form) may be used or disclosed by CEA for statistical, administrative, regulatory and research purposes. CEA may disclose your personal information for these purposes to:
                                        <ul><li>School – if you are a secondary student undertaking VET, including a school-based apprenticeship or traineeship;</li><li>Employer – if you are enrolled in training paid by your employer;</li><li>Commonwealth, State or Territory government departments and authorised agencies;</li><li>NCVER;</li><li>Organisations conducting student surveys; and</li><li>Researchers.</li></ul>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Personal information disclosed to NCVER may be used or disclosed for the following purposes:<ul><li>populated authenticated VET transcripts;</li><li>facilitating statistics and research relating to education, including surveys and data linkage;</li><li>pre-populating RTO student enrolment forms;</li><li>understanding how the VET market operates, for policy, workforce, planning and consumer information; and</li><li>administering VET, including program administration, regulation, monitoring and evaluation.</li>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'You may receive a student survey which may be administered by a government department or NCVER employee, agent or third-party contractor or authorised agencies. Please note you may opt out of the survey at the time of being contacted.',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'NCVER will collect, hold, use and disclose your personal information in accordance with the Privacy Act 1988 (Cth), the National VET Data Policy and all NCVER policies and protocols (including those published on NCVER’s website at www.ncver.edu.au).',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'For more information about NCVER\'s Privacy Policy got to <a href="https://www.ncver.edu.au/privacy">https://www.ncver.edu.au/privacy</a>',
                                    ],
                                ],
                                // 'col_size' => 12
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'enrolment_declaration',
                                'label' => 'Enrolment Declaration',
                                'col_size' => 12,
                                'content' => [
                                    [

                                        'description' => 'The information herein provided is to the best of my knowledge true, correct and complete at the time of my enrolment.',
                                    ],
                                    [

                                        'description' => 'I consent to the collection, use and disclosure of my personal information in accordance with the Privacy Notice above.',
                                    ],
                                    [

                                        'description' => 'I confirm that I have conducted a pre-training review in which I have discussed all my training options including RPL and CT with Community Education Australia and that the elected course/s is the appropriate training option for me.',
                                    ],
                                    [

                                        'description' => 'I confirm and accept Community Education Australia’s recommended learning pathway as my training program.',
                                    ],
                                    [

                                        'description' => 'I have read and understood Community Education Australia’s Personal Information & Privacy Policy Procedure.',
                                    ],
                                    [

                                        'description' => 'I have been provided with information about/and access to Community Education Australia’s Student Handbook, course training plan and schedule, assessment due dates and a current Statement of Fees.',
                                    ],
                                    [

                                        'description' => 'I have been informed of my rights and obligations as a student with Community Education Australia, and agree to abide by all rules and regulations of Community Education Australia. I confirm that all arrangements are made to pay outstanding fees and charges applicable to this training program and that Community Education Australia can withhold my academic results until my debt is fully paid and any property belonging to Community Education Australia has been returned.',
                                    ],
                                    [

                                        'description' => 'I authorise Community Education Australia, in the event of illness or accident during any organized activity, and where emergency contact or next of kin cannot be contacted within reasonable time, to seek ambulance, medical or surgical treatment at my cost.',
                                    ],
                                    [

                                        'description' => '(Optional) I hereby give my permission to Community Education Australia to use my (Name, Testimonial, Image / Photograph) in publications and advertisements produced by or for Community Education Australia. I understand that:<br><ul><li>These may be used for publication in film, photographs, in printed materials, electronically and on the internet.</li><li>The above permission will apply for three years from the date of signing this form.</li><li>I will not receive any compensation or payment for the above.</li><li>Once my personal information has been published on the internet, Community Education Australia has no control over its subsequent use and disclosure.</li></ul>',
                                    ],
                                    [

                                        'description' => 'A student’s USI may be used for specific VET purposes including the verification of student data provided by CEA, the administration and audit of VET providers and program; education-related policy and research purposes, and to assist in determining eligibility for training subsidies.',
                                    ],
                                    [

                                        'description' => 'I agree to the Fee Charges and Refund Policy and Procedure.',
                                    ],
                                    [

                                        'description' => 'I have read and understood the complaints and appeals processes, my rights as a student, the Privacy Statement and my right to access Australian Consumer Protection law.',
                                    ],
                                    [

                                        'description' => 'I have completed the language literacy and numeracy indicator tool, or been given the opportunity to.',
                                    ],
                                    [

                                        'description' => 'I have also been provided with course information, duration of my course and I understand how to access support services and information I understand that access to academic records is provided free of charge.',
                                    ],
                                    [

                                        'description' => 'I acknowledge that providing false, misleading or inaccurate information may affect the acceptance of this application and/or the continued provision of training and assessment services.',
                                    ],
                                    [

                                        'description' => 'I have read and understood CEA’s policies listed above.',
                                    ],
                                    [

                                        'description' => 'I acknowledge that all fees are payable in full on course commencement or the commencement of the term that fees are due.',
                                    ],
                                    [

                                        'description' => 'I declare that I am a Genuine Temporary Entrant and a Genuine Student. Please refer to the Department of Home Affairs website for details: <a href="https://www.homeaffairs.gov.au/trav/stud/more/genuine-temporary-entrant" target="_blank">https://www.homeaffairs.gov.au/trav/stud/more/genuine-temporary-entrant</a>. 
                                   ',
                                    ],
                                ]
                            ],
                            [
                                'type' => 'text',
                                'name' => 'applicant_name',
                                'label' => 'Applicant\'s Name',
                                // 'col_size' => 12,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'applicant_signature',
                            //     'label' => 'Applicant\'s Signature',
                            // ],
                            [
                                'type' => 'date',
                                'name' => 'applicant_date',
                                'label' => 'Date',
                            ],
                        ]
                    ]
                ] //end component
            ]
            // [
            //     'component' => [ //start component
            //         [
            //             'title' => 'For Office Use Only',
            //             'inputs' => [
            //                 [
            //                     'type' => 'card',
            //                     'name' => 'office_use_only',
            //                     'label' => 'Please consider the qualification, the job role, and required level of language, literacy and numeracy that the vocation and industry requires.',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'type' => 'paragraph',
            //                             'body' => ''
            //                         ],
            //                     ]

            //                 ],
            //                 [
            //                     'type' => 'radio',
            //                     'name' => 'office_use_1',
            //                     'label' => 'Additional Language, Literacy, and Numeracy assistance required to achieve workplace competency?',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'value' => 'Yes',
            //                             'description' => 'Yes',
            //                         ],
            //                         [
            //                             'value' => 'No',
            //                             'description' => 'No'
            //                         ],
            //                     ]
            //                 ],
            //                 [
            //                     'type' => 'radio',
            //                     'name' => 'office_use_2',
            //                     'label' => 'Review deems proposed assessment instruments, learning material and strategies as appropriate.',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'value' => 'Yes',
            //                             'description' => 'Yes',
            //                         ],
            //                         [
            //                             'value' => 'No',
            //                             'description' => 'No'
            //                         ],
            //                     ]
            //                 ],
            //                 [
            //                     'type' => 'radio',
            //                     'name' => 'office_use_3',
            //                     'label' => 'Review deems proposed assessment instruments, learning material and strategies require adjustment. Additional language, literacy or numeracy support will be required.',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'value' => 'Yes',
            //                             'description' => 'Yes',
            //                         ],
            //                         [
            //                             'value' => 'No',
            //                             'description' => 'No'
            //                         ],
            //                     ]
            //                 ],
            //                 [
            //                     'type' => 'radio',
            //                     'name' => 'office_use_4',
            //                     'label' => 'What is applicant’s capacity to benefit?',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'value' => 'Poor',
            //                             'description' => 'Poor',
            //                         ],
            //                         [
            //                             'value' => 'Fair',
            //                             'description' => 'Fair'
            //                         ],
            //                         [
            //                             'value' => 'Good',
            //                             'description' => 'Good'
            //                         ],
            //                         [
            //                             'value' => 'Very Good',
            //                             'description' => 'Very Good'
            //                         ],
            //                         [
            //                             'value' => 'Excellent',
            //                             'description' => 'Excellent'
            //                         ],
            //                     ]
            //                 ],
            //                 [
            //                     'type' => 'radio',
            //                     'name' => 'office_use_5',
            //                     'label' => 'Review identified current competence (list below) (if Mutual Recognition, attach Record of Results)',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'value' => 'Yes',
            //                             'description' => 'Yes',
            //                         ],
            //                         [
            //                             'value' => 'No',
            //                             'description' => 'No'
            //                         ],
            //                     ]
            //                 ],
            //                 [
            //                     'type' => 'radio',
            //                     'name' => 'office_use_6',
            //                     'label' => 'Based on the information provided in the Pre-training',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'value' => 'Yes',
            //                             'description' => 'Yes',
            //                         ],
            //                         [
            //                             'value' => 'No',
            //                             'description' => 'No'
            //                         ],
            //                     ]
            //                 ],
            //                 [
            //                     'type' => 'check-description',
            //                     'name' => 'office_use_7',
            //                     'label' => '',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [

            //                             'description' => 'I have assessed this applicant;',
            //                         ],
            //                         [

            //                             'description' => 'I find that the applicant is competent in language, literacy and numeracy.',
            //                         ],
            //                         [

            //                             'description' => 'I find that the applicant is not competent in language, literacy and numeracy.',
            //                         ],
            //                     ]
            //                 ],
            //                 [
            //                     'type' => 'textarea',
            //                     'name' => 'office_use_comments',
            //                     'label' => 'Comments if Any:',
            //                     'col_size' => 12,
            //                 ],
            //             ]
            //         ],
            //         [
            //             'title' => 'Document Checklist',
            //             'inputs' => [
            //                 [
            //                     'type' => 'card',
            //                     'name' => 'stud_dec_statement_1',
            //                     'label' => 'Document Checklist',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'type' => 'paragraph',
            //                             'body' => '<ul>
            //                             <li>Proof of Australian citizenship/residency status or New Zealand citizenship</li>
            //                             <li>Photo identification</li>
            //                             <li>Proof of age, if no Australian Driving License</li>
            //                             <li>Enrolment Application Form filled and signed</li>
            //                             </ul>'
            //                         ]
            //                     ]
            //                 ],
            //             ]
            //         ],
            //         [
            //             'title' => 'For CEA Official',
            //             'inputs' => [
            //                 [
            //                     'type' => 'card',
            //                     'name' => 'for_cea',
            //                     'label' => 'For CEA Official',
            //                     'col_size' => 12,
            //                     'content' => [
            //                         [
            //                             'type' => 'paragraph',
            //                             'body' => 'I confirm that the applicant has been informed of entry requirements for the course and eligibility requirements for government
            //                             subsidised training under the VET Investment Plan or other subsidised training under the Queensland Government and that the applicant
            //                             is aware of the consequences arising from a false, misleading or an in complete declaration.'
            //                         ]
            //                     ]
            //                 ],
            //                 [
            //                     'type' => 'date',
            //                     'name' => 'for_cea_date_recieved',
            //                     'label' =>  'Date Received:'
            //                 ],
            //                 [
            //                     'type' => 'date',
            //                     'name' => 'for_cea_date_approved',
            //                     'label' =>  'Date Approved:'
            //                 ],
            //                 [
            //                     'type' => 'text',
            //                     'name' => 'for_cea_approved_by',
            //                     'label' =>  'Approved by:'
            //                 ],
            //                 // [
            //                 //     'type' => 'text',
            //                 //     'name' => 'for_cea_signature',
            //                 //     'label' =>  'Signature:'
            //                 // ],
            //             ]
            //         ]
            //     ] //end component
            // ],
        ];

        return $pages;
    }

    public function get_logo(){
        $app_setting = TrainingOrganisation::first();
        if($app_setting && in_array($app_setting->logo_img, ['', null])){
            $logo = 'images/logo/vorx_logo.png';
          }else{
            $logo = 'storage/config/images/'.$app_setting->logo_img;
          }
          $logo_url = url('/' . $logo . '');

          return $logo_url;
    }

    public function find_agent($code){
        if($code){
            $agent_detail = AgentDetail::where('agent_code', $code)->first();
            if($agent_detail != null){
                return ['status' => 'success', 'data' => $agent_detail];
            }else{
                return ['status' => 'error'];
            }
        }else{
            return ['status' => 'error'];
        } 
    }
}
