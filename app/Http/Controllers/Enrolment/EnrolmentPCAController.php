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

use function PHPSTORM_META\type;

class EnrolmentPCAController extends Controller
{

    public function __construct() {
        // dd(config('app.name'));
        // if(config('app.name') != 'Phoenix'){
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
        //
        // dd('yooooooooo PCA Enrolment Form');

        // dd($this->pages());
        $app_setting = TrainingOrganisation::first();

        \JavaScript::put([
            // 'courses' => $courses->pluck('name','code'),
            // 'avtDeliveryMode' => $avtDeliveryMode->pluck('description', 'value'),
            'app_settings'  => $app_setting,
            'pages'         => $this->pages(),
            'logo_url'      => $this->get_logo(),
        ]);

        return view('enrolment.pca.index');
    }

    public function pages($process_id = null)
    {
        if ($process_id != null) {
            $ep = EnrolmentPack::where('process_id', $process_id)->first();
            // return json_decode($ep->enrolment_form, true);
            $enrolment_form = Storage::get('/public/enrolment/' . $ep->process_id . '/enrolment-form.txt');
            // dd($enrolment_form);
            return json_decode($enrolment_form,true);
        }

        $courses = Course::select(DB::raw('id, code, name as name_only, concat(code, " - ", name) as name'))->where('is_active', 1)->get();
        $units = Unit::select(DB::raw('id, code, description as name_only, concat(code, " - ", description) as description'))->where('extra_unit', 1)->get();
        $avtDeliveryMode = AvtDeliveryMode::where('alt_description', '<>', null)->get();
        $avtPostcodeGeo = AvtPostcode::select(DB::raw('id, concat(postcode, " - ", suburb, ", ", state) as value'))->get();
        $visaType = VisaStatus::select(DB::raw('id, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS value'))->get();
        $highSchoolLevel = AvtHighestSchlLvlCompleted::all();
        $englishTest = EnglishTest::all();

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
                                'selections' => $courses,
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
                        "title" => '2. Intake',
                        'inputs' => [
                            // [
                            //     'type' => 'multiselect',
                            //     'name' => 'mode_of_delivery',
                            //     'multiselect' => false,
                            //     'label' => 'Select Mode of Delivery',
                            //     'selections' => $avtDeliveryMode,
                            //     'mTrackBy' => 'value',
                            //     'mLabel' => 'alt_description',
                            //     'required'=> true,
                            //     'col_size' => 12,
                            // ],
                            [
                                'type' => 'select',
                                'name' => 'preferred_month_start',
                                'label' => 'Choose the preferred month for course (Preferred Month to start)',
                                'items' => [
                                    'January' => 'January', 
                                    'February' => 'February', 
                                    'March' => 'March', 
                                    'April' => 'April', 
                                    'May' => 'May',
                                    'June' => 'June',
                                    'July' => 'July',
                                    'August' => 'August',
                                    'September' => 'September',
                                    'October' => 'October',
                                    'November' => 'November',
                                    'December' => 'December',
                                ],
                                'col_size' => 12,
                            ],
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
                                'type' => 'card',
                                'name' => 'australia_country_contact_details',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h5><b>Australia</b><h5>',
                                    ]
                                ],
                                'col_size' => 12,
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
                                'col_size' => 12,
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
                            [
                                'type' => 'card',
                                'name' => 'home_country_contact_details',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<h5><b>Home Country</b><h5>',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'home_country_addr_flat_unit_detail',
                            //     'label' => 'Unit',
                            //     // 'required'=> true,
                            // ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'home_country_addr_building_property_name',
                            //     'label' => 'Building Name',
                            //     // 'required'=> true,
                            // ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'home_country_addr_street_num',
                            //     'label' => 'Street Number',
                            //     // 'required' => true,
                            // ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'home_country_addre_street_name',
                            //     'label' => 'Street Name',
                            //     // 'required' => true,
                            // ],
                             [
                                'type' => 'text',
                                'name' => 'home_country_res_addr',
                                'label' => 'Residential Address',
                                'required' => true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'home_country_state',
                                'label' => 'State',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'home_country_postcode',
                                'label' => 'Postcode',
                                'required' => true,
                            ],
                            // [
                            //     'type' => 'multiselect',
                            //     'name' => 'home_country_addr_suburb',
                            //     'multiselect' => false,
                            //     'label' => 'Postcode - Suburb, State',
                            //     'selections' => $avtPostcodeGeo,
                            //     'mTrackBy' => 'id',
                            //     'mLabel' => 'value',
                            //     // 'required' => true,
                            //     'col_size' => 12,
                            // ],
                            [
                                'type' => 'text',
                                'name' => 'home_country_addr_postal_delivery_box',
                                'label' => 'Postal Address (if different from above)',
                                'col_size' => 12,
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'home_country_phone_home',
                                'label' => 'Telephone',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'home_country_phone_mobile',
                                'label' => 'Mobile',
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'home_country_email',
                                'label' => 'Email',
                                // 'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'home_country_email_at',
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
                                'label' => 'Name (for emergency contact)',
                                'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'e_address',
                                'label' => 'Address (for emergency contact)',
                                'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'e_telephone',
                                'label' => 'Telephone (for emergency contact)',
                                'required'=> true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'e_relationship',
                                'label' => 'Relationship (for emergency contact)',
                                'required'=> true,
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
                                'label' => 'Visa Expiry Date',
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
                                // 'required' => true,
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
                                'items' => ['None' => 'None', 'Aboriginal' => 'Aboriginal', 'Torres Strait Islander' => 'Torres Strait Islander', 'Both' => 'Both'],
                                // 'required'=> true,
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'language_test',
                                'multiselect' => false,
                                'label' => 'Language Test,  if taken',
                                'selections' => $englishTest,
                                'mTrackBy' => 'id',
                                'mLabel' => 'name',
                                'col_size' => 8,
                                // 'required' => true,
                            ],
                            [
                                'type' => 'number',
                                'name' => 'language_test_score',
                                'label' => 'Score',
                                'col_size' => 4,
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
                                'tooltip' => 'If you answered ‘Yes’, you can contact PCA for further support services available',
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
                                'label' => 'Main Reason : In following categories, which BEST describes your main reason for undertaking the course(s) with PCA?',
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
                            // [
                            //     'type' => 'textarea',
                            //     'name' => 'reason_to_study_au',
                            //     'label' => 'Reason to study in Australia: Why do you want to study your proposed course(s) in Australia and not
                            //     in your home country? Please explain.',
                            //     'col_size' => 12,
                            // ],
                            // [
                            //     'type' => 'textarea',
                            //     'name' => 'reason_to_study_pca',
                            //     'label' => 'Reason to study with PCA: Why would like to study with Phoenix College of Australia compared with
                            //     other education providers in Australia? Please explain.',
                            //     'col_size' => 12,
                            // ],
                            // [
                            //     'type' => 'textarea',
                            //     'name' => 'career_benefit',
                            //     'label' => 'Career benefit: How do you believe that course you are applying to study with Phoenix
                            //     College of Australia will benefit your current or chosen career path?
                            //     Please Explain.',
                            //     'col_size' => 12,
                            // ],
                            // [
                            //     'type' => 'textarea',
                            //     'name' => 'career_plan',
                            //     'label' => 'Career Plan: What is your career plan after the end of your studies?',
                            //     'col_size' => 12,
                            // ],
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
                                'value' => 1,
                                'hidden' => true,
                                'col_size' => 12,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'unique_student_id',
                            //     'label' => 'If ‘Yes’, please provide your USI',
                            //     // 'col_size' => 12,
                            // ],
                            [
                                'type' => 'text',
                                'name' => 'unique_student_id',
                                'label' => 'Unique Student Identifier (USI)',
                                'required'=> true,
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'card',
                                'name' => 'if_no_usi',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>If ‘No’,</b> you can visit <a href="https://www.usi.gov.au/">https://www.usi.gov.au/</a> to create USI. Once created,
                                        please provide the same to Admissions department. If you want PCA to
                                        create USI on your behalf, please contact one of our friendly team
                                        members at reception.',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [

                        'title' => '16. Overseas Student Health Cover (OSHC)',
                        'inputs' => [
                            [
                                'type' => 'checkbox',
                                'name' => 'oshc_flag',
                                'label' => 'Have you got OSHC?',
                                // 'tooltip' => 'If ‘Yes’, then please contact Admissions Department for further details about the Recognition of Prior Learning (RPL) / Credit Transfer (CT) process.',
                                'value' => 0,
                                // 'col_size' => 7,
                            ],
                            [
                                'type' => 'select',
                                'name' => 'oshc_type',
                                'label' => 'Type of OSHC?',
                                'items' => ['Single' => 'Single', 'Couple' => 'Couple', 'Family' => 'Family'],
                            ],
                            [
                                'type' => 'card',
                                'name' => 'if_no_usi',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Please refer to OSHC providers such as but not limited to: <a href="nib.com.au/overseas-students">nib.com.au/overseas-students</a>',
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
                        'title' => '17. Documentation',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'documentation',
                                'label' => 'Required Documents : Please provide the following documentation along with this Enrolment Application Form, so that your enrolment be processed in accordance with the application requirements. Where a document is not in English, you have to provide a certified translation along with the copy of original document.',
                                // 'content' => [
                                //     [
                                //         'type' => 'table',
                                //         'body' => [
                                //             'column_width' => ['100%'],
                                //             'thead' => [
                                //                 'Documents',
                                //             ],
                                //             'text_type' => ['text-left'],
                                //             'tbody' => [
                                //                 [
                                //                     '<ul>
                                //                         <li><b>Passport biodata pages</b></li>
                                //                         <li><b>Visa / Visa Notification</b> </li>
                                //                         <li><b>Passport(s) of dependant(s)</b>, if any
                                //                         </li>
                                //                         <li><b>Past qualification documents</b>, including high school and other certificates</li>
                                //                         <li><b>English language proficiency</b> (IELTS, PTE, TOEFL etc.)
                                //                         </li>
                                //                         <li><b>Any other COE</b>, if transferring from other provider</li>
                                //                         <li><b>Statement addressing Genuine Temporary Entrant Criteria</b> (not required in
                                //                         cases of Security courses and if student is onshore)
                                //                        </li>
                                //                     </ul>'
                                                    
                                //                 ]
                                //             ]
                                //         ]
                                //     ]

                                // ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'check-description',
                                'name' => 'document_list',
                                'label' => 'Documents:',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'description' => '<b>Passport biodata pages</b>',
                                    ],
                                    [
                                        'description' => '<b>Visa / Visa Notification</b>',
                                    ],
                                    [
                                        'description' => '<b>Passport(s) of dependant(s)</b>, if any',
                                    ],
                                    [
                                        'description' => '<b>Past qualification documents</b>, including high school and other certificates',
                                    ],
                                    [
                                        'description' => '<b>English language proficiency</b> (IELTS, PTE, TOEFL etc.)',
                                    ],
                                    [
                                        'description' => '<b>Any other COE</b>, if transferring from other provider',
                                    ],
                                    // [
                                    //     'description' => '<b>Statement addressing Genuine Temporary Entrant Criteria</b> (not required in cases of Security courses and if student is onshore)',
                                    // ],

                                ],
                            ]
                            // [
                            //     'type' => 'checkbox',
                            //     'name' => 'valid_concession_card_flag',
                            //     'label' => 'Do you have a valid Concession Card?',
                            //     'value' => 0,
                            // ],
                            // [
                            //     'type' => 'multiselect',
                            //     'name' => 'valid_concession_card_yes',
                            //     'multiselect' => true,
                            //     'label' => 'If yes, Please indicate below:',
                            //     'selections' => [
                            //         ['value' => 'Healthcare Card', 'description' => 'Healthcare Card'],
                            //         ['value' => 'Pensioner Concession Card', 'description' => 'Pensioner Concession Card'],
                            //         ['value' => 'Veteran’s Gold Card', 'description' => 'Veteran’s Gold Card'],
                            //         ['value' => 'Other proof as per the above Concessional list', 'description' => 'Other proof as per the above Concessional list'],
                            //     ],
                            //     'mTrackBy' => 'value',
                            //     'mLabel' => 'description',
                            //     // 'col_size' => 12,
                            // ],
                            // [
                            //     'type' => 'simple-attachment',
                            //     'name' => 'concession_card_attachments',
                            //     'label'=> 'Attach Concessional Cards',
                            //     'col_size' => 12,
                            // ],
                        ]
                    ],
                    [
                        'title' => '18. Fee Payment',

                        'inputs' => [
                            [
                                'type' => 'multiselect',
                                'name' => 'payment_method',
                                'multiselect' => false,
                                'label' => 'Payment Method',
                                'selections' => [
                                    ['value' => 'Cash', 'description' => 'Cash'],
                                    ['value' => 'Direct Deposit in PCA’s Bank Account', 'description' => 'Direct Deposit in PCA’s Bank Account'],
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
                                            'background_color' => ['background-danger', 'none'],
                                            'tbody' => [
                                                [
                                                    '<b>Account Name</b>',
                                                    'Phoenix College of Australia Pty. Ltd.',
                                                ],
                                                [
                                                    '<b>Bank</b>',
                                                    'Westpac',
                                                ],
                                                [
                                                    '<b>Branch</b>',
                                                    'Werribee',
                                                ],
                                                [
                                                    '<b>BSB</b>',
                                                    '033-501',
                                                ],
                                                [
                                                    '<b>Account Number</b>',
                                                    '289843',
                                                ],
                                                [
                                                    '<b>Swift Code</b>',
                                                    'WPACAU2S',
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
                        'title' => '19. Education Agent (Details of approved
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
                                'label' => 'Company Title',
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
                                            <li>I have assessed the applicant and to the best of my knowledge the
                                            applicant is</li>
                                            <li>To the best of my knowledge, the applicant is genuine in making this
                                            application and has every intention of completing all programs listed in
                                            the application.</li>
                                            <li>The documents which form part of this application appear to be
                                            authentic and valid. To the best of my knowledge the applicant has
                                            genuine access to the total funds required, while in Australia, to cover all travel, OSHC, tuition and living costs for themselves and their family members (if applicable). </li>
                                            <li>I recommend that PCA proceed with the assessment for admission of
                                            this applicant.</li>
                                            <li>I confirm the student has signed the application form.</li>
                                            <li> I have provided the student’s personal email address and residential
                                            address, as disclosed to me by the student.</li>
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
                            // [
                            //     'type' => 'text',
                            //     'name' => 'agents_signature',
                            //     'label' => 'Agent’s Signature',
                            //     // 'required'=> true,
                            //     'col_size' => 6,
                            // ],
                        ]
                    ],
                    [
                        'title' => '20. Policies & Procedures',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'info',
                                'label' => 'Refer to Student Handbook for following policies and procedures. Same are available on website.',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 
                                        '<ul>
                                            <li>Complaints and Appeals Policy and Procedure</li>
                                            <li>Critical Incident Policy and Procedure</li>
                                            <li>Pre-Enrolment Engagement Policy and Procedures
                                            </li>
                                            <li>Entry Requirements for International Students Policy and
                                            procedure</li>
                                            <li> Fee Charges and Refunds Policy and Procedure
                                            </li>
                                            <li>Deferral suspension and cancellation policy and procedure</li>
                                            <li>Recognition of Prior Learning and Credit Transfer policy
                                            and procedure
                                            </li>
                                            <li>Student Support Services Policy and Procedure
                                            </li>
                                            <li>Privacy and Personal Information Policy and Procedure</li>
                                            <li>Certification, issuing and recognition of Qualifications
                                            Policy and Procedure</li>
                                            <li>Monitoring Course Progress and Intervention Strategy for
                                            International Students Policy and Procedure
                                            </li>
                                            <li>Attendance Monitoring Policy and Procedure</li>
                                            <li>Overseas Students Transfer Policy and Procedure
                                            </li>
                                            <li>Plagiarism, Academic Misconduct and non-academic
                                            Misconduct Policy and Procedure
                                            </li>
                                            <li>Assessment and Reassessment Policy and Procedure</li>
                                        </ul>',
                                    ],
                                ],
                                'col_size' => 12
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
                                'label' => 'Privacy Notice',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Under the Data Provision Requirements 2012, PCA is required to collect personal information about you and to disclose
                                        that personal information to the National Centre for Vocational Education Research Ltd (NCVER).',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Your personal information (including the personal information contained on this enrolment form and your training activity
                                        data) may be used or disclosed by PCA for statistical, regulatory and research purposes. PCA may disclose your personal
                                        information for these purposes to third parties, including:
                                            <ul>
                                                <li>School – if you are a secondary student undertaking VET, including a school-based apprenticeship or traineeship;</li>
                                                <li>Employer – if you are enrolled in training paid by your employer; </li>
                                                <li>Government departments and authorised agencies;</li>
                                                <li>NCVER;</li>
                                                <li>Organisations conducting student surveys; and
                                                </li>
                                                <li>Researchers</li>
                                            </ul>
                                            ',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Personal information disclosed to NCVER may be used or disclosed for the following purposes:
                                            <ul>
                                                <li>Issuing statements of attainment or qualification, and populating authenticated VET transcripts;</li>
                                                <li>facilitating statistics and research relating to education, including surveys;</li>
                                                <li>understanding how the VET market operates, for policy, workforce planning and consumer information; and
                                                </li>
                                                <li>administering VET, including programme administration, regulation, monitoring and evaluation. </li>
                                            </ul>
                                            ',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'You may receive an NCVER student survey which may be administered by an NCVER employee, agent or third party contractor. You may opt out of the survey at the time of being contacted. ',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'NCVER will collect, hold, use and disclose your personal information in accordance with the Privacy Act 1988 (Cth), the VET
                                        Data Policy and all NCVER policies and protocols (including those published on NCVER’s website at www.ncver.edu.au).',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'Please be advised that the information collected from the students as part of the enrolment will be provided to the Department of Home Affairs, other State/Territory government agencies, the Tuition Protection Scheme (TPS) and the ESOS Assurance Fund Manager in relation to administering the ESOS Act 2000 and the Migration Act 1958.',
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

                                        'description' => 'PCA may refuse my application or cancel my enrolment if any information is found to be incorrect or misleading.',
                                    ],
                                    [

                                        'description' => 'I consent to the collection, use and disclosure of my personal information in accordance with the Privacy Notice above.',
                                    ],
                                    [

                                        'description' => 'I understand that by completing this application, I am giving written consent to PCA to independently verify the
                                        information supplied by me in this form and request further documents as required.',
                                    ],
                                    [

                                        'description' => 'I declare that I am a Genuine Temporary Entrant and a Genuine Student. Please refer to the Department of Home Affairs
                                        website for details: <a href="https://www.homeaffairs.gov.au/trav/stud/more/genuine-temporary-entrant">https://www.homeaffairs.gov.au/trav/stud/more/genuine-temporary-entrant</a>.',
                                    ],
                                    [

                                        'description' => 'I agree to undertake a testing requirement prior to course entry, if deemed necessary by PCA, and adhere to any other
                                        pre requisite identified above.',
                                    ],
                                    [

                                        'description' => 'I have got access to all the relevant policies and procedures as listed above.',
                                    ],
                                    [

                                        'description' => 'I have been informed of my rights and obligations as a student with Phoenix College of Australia, and agree to abide by
                                        all rules and regulations of Phoenix College of Australia. I confirm that all arrangements are made to pay outstanding fees
                                        and charges applicable to this training program and that Phoenix College of Australia can withhold my academic results
                                        until my debt is fully paid and any property belonging to Phoenix College of Australia has been returned.',
                                    ],
                                    [

                                        'description' => 'I confirm that I have received and read a copy of PCA’s student Handbook and fully understand the requirements of the
                                        course and relevant policies and procedures.',
                                    ],
                                    [

                                        'description' => '(Optional) I hereby give my permission to Phoenix College of Australia to use my (Name, Testimonial, Image /
                                        Photograph) in publications and advertisements produced by or for Phoenix College of Australia. I understand that:
                                            <ul>
                                            <li>These may be used for publication in film, photographs, in printed materials, electronically and on the internet.</li>
                                            <li>The above permission will apply for three years from the date of signing this form.</li>
                                            <li>I will not receive any compensation or payment for the above.</li>
                                            <li>Once my personal information has been published on the internet, Phoenix College of Australia has no control
                                            over its subsequent use and disclosure.</li>
                                        </ul>',
                                    ],
                                    [

                                        'description' => 'A student’s USI may be used for specific VET purposes including the verification of student data provided by PCA, the
                                        administration and audit of VET providers and program; education-related policy and research purposes, and to assist in
                                        determining eligibility for training subsidies.',
                                    ],
                                    [

                                        'description' => 'I agree to the Fee Charges and Refund Policy and Procedure',
                                    ],
                                    [

                                        'description' => 'I have read and understood the complaints and appeals processes, my rights as a student, the Privacy Statement and my
                                        right to access Australian Consumer Protection law.',
                                    ],
                                    [

                                        'description' => 'I have also been provided with course information, duration of my course and I understand how to access support
                                        services and information I understand that access to academic records is provided free of charge.',
                                    ],
                                    [

                                        'description' => 'I acknowledge that providing false, misleading or inaccurate information may affect the acceptance of this application
                                        and/or the continued provision of training and assessment services.',
                                    ],
                                    [

                                        'description' => 'I acknowledge that all fees are payable in full on course commencement or the commencement of the term that fees
                                        are due',
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
            ],
        ];

        return $pages;
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
        //
        // dd($request->inputs);
        // $jsonPages = json_encode($request->pages);

        // $jsonPages = $request->inputs;
        // dd($jsonPages[0]->component[2]->inputs[1]->value);
        // dd($jsonPages);
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
            $save->enrolment_form = $request->inputs;
            $save->save();

            $path ='/public/enrolment/' . $save->process_id . '/enrolment-form.txt';
            Storage::put($path, $request->pages);

            return ['status' => 'success', 'process' => $save->process_id];
        } else {

            // $jsonPages = json_decode($request->pages, true);
            $save = EnrolmentPack::where('process_id', $request->process_id)->first();
            $save->student_name = $fullname;
            $save->enrolment_form = $request->inputs;
            $save->update();

            $path = '/public/enrolment/' . $save->process_id . '/enrolment-form.txt';
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
        // dd(\Auth::user());
        $ep = EnrolmentPack::where('process_id', $process_id)->first();
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
                'process_id'        => $process_id,
                'sig_acceptance_agreement' => $ep->sig_acceptance_agreement,
                'concession_docs'   => isset($ef['valid_concession_card_yes']) ? $ef['valid_concession_card_yes'] : [],
                'logo_url'          => $this->get_logo(),
                'app_settings'      => $app_setting,
                'mandatoryList'     =>  $mandatoryList->count() > 0 ? $mandatoryList : [],
                'mandatory_docs' =>  json_decode($ep->mandatory_docs, true),
                'user'              => \Auth::user() != null ? true : false,
            ]);
            return view('enrolment.pca.attachment-signature');
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

        return view('enrolment.pca.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $process_id)
    {
        //
        // dd($request->all());
        $ep = EnrolmentPack::where('process_id', $process_id)->first();

        $ep->student_signature = $request->signature;
        $ep->update();

        return ['status' => 'success'];
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
        // dump(\Auth::user());
        $ep = EnrolmentPack::where('process_id', $process_id)->first();
        $org = TrainingOrganisation::first();
        // dd($request);
        if($ep){
            if($ep->status == 'process'){
                $ep->status = 'complete';
            }
            $ep->type_signature = $request->type_signature != '' ? $request->type_signature : null;
            $ep->student_signature = $request->signature != '' ? $request->signature : null;
            $ep->sig_acceptance_agreement = $request->sig_acceptance_agreement == true ? '1' : '0';
            $ep->mandatory_docs = isset($request->mandatory_docs) && $request->mandatory_docs != null ? json_encode($request->mandatory_docs) : null;
            $ep->update();

            // dd($ep->enrolment_form['email']);
            $emailsTo = [];
            if(isset($ep->enrolment_form['email']) && !in_array($ep->enrolment_form['email'], ['', null])){
                $emailsTo[] = $ep->enrolment_form['email']; 
            }
            if(isset($ep->enrolment_form['email_at']) && !in_array($ep->enrolment_form['email_at'], ['', null])){
                $emailsTo[] = $ep->enrolment_form['email_at']; 
            }
            
            // $admin_emails = ['phoenixcollegeaustralia@gmail.com', 'admin@phoenixcollege.edu.au','xyshain@gmail.com'];
            // $emailsBcc = ['admin@phoenixcollege.edu.au','xyshain@gmail.com'];
            $emailsBcc = EmailAutomation::where('addOn', 'enrolment')->pluck('email');
            // agent email
            if(isset($ep->enrolment_form['contact_details_email']) && !in_array($ep->enrolment_form['contact_details_email'], ['', null])){
                $emailsBcc[] = $ep->enrolment_form['contact_details_email']; 
            }
            $pfd_url = url('pca/online-enrolment/pdf/' . $ep['process_id'] . '');
            // get from course matrix(add column hours per week) and training delivery location(add column unit, building name, street num, street name)
            // course, duration, hours per week, cricos code and delivery location will/must be dynamic
            // dd($ep->enrolment_form['course']['code']);
            $course = Course::with(['matrix','courseprospectus'])->where('code', $ep->enrolment_form['course']['code'])->first();
            $applied_course = $ep->enrolment_form['course']['name'];
            $location = '';
            $duration = '';
            $training_hours_weekly = '';
            $cricos_code = '';
            $full_location = '';

            // get Delivery Location
            if(count($course->courseprospectus) > 0){
                foreach($course->courseprospectus as $key => $dl){
                    $dlvr_loc = TrainingDeliveryLoc::where('train_org_dlvr_loc_id', $dl->train_org_dlvr_loc_id)->first();
                    $state_id = AvtStateIdentifier::where('value', $dlvr_loc->state_id)->first();

                    // Ex. Unit 2, 11 Cordelia Street, South Brisbane, Queensland  4101.
                    if($dlvr_loc->addr_flat_unit_detail != null){
                        $unit = $dlvr_loc->addr_flat_unit_detail.' ';
                    }else{
                        $unit = '';
                    }
                    if($dlvr_loc->addr_building_property_name != null){
                        $building = $dlvr_loc->addr_building_property_name;
                    }else{
                        $building = '';
                    }
                    if($dlvr_loc->addr_street_num && $dlvr_loc->addr_street_name != null){
                        $street = $dlvr_loc->addr_street_num. ' ' . $dlvr_loc->addr_street_name . ', ';
                    }else{
                        $street = '';
                    }
                    $location = $state_id->state_key;
                    $full_location = $unit.''.$building.', '.$street.''.$dlvr_loc->addr_location.', '.$state_id->state_name.' '.$dlvr_loc->postcode;
                }
            }
            // get duration, hours per week and cricos code 
            if(count($course->matrix) > 0){
                foreach($course->matrix as $key => $x){
                    if($location != ''){
                        $cm = $x->where('location', $location)->where('course_code', $x->course_code)->first();
                        $duration = $cm->wk_duration != null ? $cm->wk_duration : '';
                        $training_hours_weekly = $cm->training_hours_weekly != null ? $cm->training_hours_weekly : '';
                        $cricos_code = $cm->cricos_code != null ? $cm->cricos_code : '';
                    }
                }
            }

            $send = new EmailSendingController;
            $content = '<b>Dear '.$ep->student_name.',</b><br><br>Thank you for choosing Phoenix College of Australia as a place to study '.$applied_course.'. One of our friendly team members will be in contact with you shortly. Please be advised that the duration of the course is '.$duration.' weeks and the delivery location is '.$full_location.'. You will be required to attend '.$training_hours_weekly.' hours per week and maintain the satisfactory course progress, to complete the course successfully. You are requested to visit <a href="https://phoenixcollege.edu.au/">www.phoenixcollege.edu.au</a> for pre-enrollment information. The website has got all the information required to take the informed decision of studying the chosen course.<br><br>If you have further questions, please feel free to contact us on admin@phoenixcollege.edu.au. Click <a href="'.$pfd_url.'">here</a> to view enrolment form.<br><br>Thank you very much.<br><br>Regards<br><br><b>Admin Team</b><br>Phoenix College of Australia<br>RTO NO: 45633 | CRICOS CODE: '.$cricos_code.'';
            // dd($content);
            // $content = '<b>Dear '.$ep->student_name.',</b><br><br>We would like to thank you to express of your interest to study your desired course at Phoenix College of Australia (RTO NO: 45633). One of our friendly team members will assess your application and contact you shortly. Please click <a href="'.$pfd_url.'">here</a> to view enrolment form.<br><br>We wish you good luck for your studies.<br><br>Regards<br><br><b>Admin Team</b><br>Phoenix College of Australia<br>RTO NO:45633';
            
            //save "enrolment form pdf" to enrolment_pack_attachments
            $save_ef_pdf = $this->student_attachment($process_id);
            // dd(\Auth::user());
            if(\Auth::user() == null){
                if($save_ef_pdf['status'] == 'success'){
                    // dd('musend lng kung walay user');
                    $s = $send->send_automate('PCA Enrolment Application', $content, ['Phoenix College of Australia' => $org->email_address], $emailsTo, [], $emailsBcc);
                    // $s = $send->send_automate('PCA Enrolment Application', $content, ['Phoenix College of Australia' => 'constant.claro@gmail.com'], ['konstant.claro@gmail.com']);
                    if($s['status'] == 'success'){
                        return ['status' => 'success', 'site' => $org->site_url];
                    }else{
                        return ['status' => 'error', 'message' => 'Something went wrong.'];
                    }
    
                }
            }
            

            return ['status' => 'success', 'site' => $org->site_url];
        }else{
            return ['status' => 'error', 'msg' => 'No enrolment form found'];
        }  
    }
    public function student_attachment($process_id){

        $file_path = '';
        $pdf_file = null;

        $ep = EnrolmentPack::where('process_id', $process_id)->first();
        $org = TrainingOrganisation::first();
        if(!$ep){
            abort(404);
        }

        $ef = $ep->enrolment_form;
        // australia contact details
        $post_geo = isset($ef['addr_suburb']['value']) ? explode(' - ', $ef['addr_suburb']['value']) : null;
        $location = null;
        if(isset($post_geo[1])){
            $getloc = explode(', ', $post_geo[1]);
            if(isset($getloc[1])){
                $location = AvtStateIdentifier::where('state_key', $getloc[1])->first();
            }
        }
        $ef['addr_postcode'] =  isset($post_geo[0]) ? $post_geo[0] : null;
        $ef['addr_suburb_state'] =  isset($post_geo[1]) ? $post_geo[1] : null;
        $ef['addr_location'] =  $location ? $location->state_name : null;
        
        // home country contact details
        $home_post_geo = isset($ef['home_country_addr_suburb']['value']) ? explode(' - ', $ef['home_country_addr_suburb']['value']) : null;
        $home_location = null;
        if(isset($home_post_geo[1])){
            $getloc_ = explode(', ', $home_post_geo[1]);
            if(isset($getloc_[1])){
                $home_location = AvtStateIdentifier::where('state_key', $getloc_[1])->first();
            }
        }
        $ef['home_country_addr_postcode'] =  isset($home_post_geo[0]) ? $home_post_geo[0] : null;
        $ef['home_country_addr_suburb_state'] =  isset($home_post_geo[1]) ? $home_post_geo[1] : null;
        $ef['home_country_addr_location'] =  $home_location ? $home_location->state_name : null;

        $matrix = $this->getMatrix($ef['course']['code'], $ef['addr_suburb']);
        // dump($ep);
        // dd($ef);

        try {
            DB::beginTransaction();

            $file_path = storage_path() . '/app/public/enrolment/' . $process_id;

            if (!File::isDirectory($file_path)) {
                File::makeDirectory($file_path, 0777, true, true);
            }

            $hashFileName = 'enrolment-form';
            $pdf_file = \PDF::loadView('enrolment.pca.enrolment-form-pdf', compact('ef', 'ep', 'matrix'))->setPaper(array(0, 0, 595, 842), 'portrait')->save($file_path.'/'. $hashFileName . '.pdf');

            $pdf = Storage::size('/public/enrolment/' . $process_id . '/' . $hashFileName . '.pdf');
            $file = EnrolmentPackAttachment::where('process_id', $process_id)->where('_input', 'enrolment-form')->first();
            
            if($file == null){
                $studentAttachment = new EnrolmentPackAttachment([
                    'name'          => 'enrolment-form.pdf',
                    'hash_name'     => $hashFileName,
                    'size'          => $pdf,
                    'mime_type'     => 'application/pdf',
                    'ext'           => 'pdf',
                    '_input'        => 'enrolment-form',
                    'process_id'    => $process_id, 
                ]);
    
                // associated user
                $studentAttachment->user()->associate(\Auth::user());
                $studentAttachment->enrolment_pack()->associate($ep->id);
                $studentAttachment->save();
                $studentAttachment->path_id = $process_id;
                $studentAttachment->update();
            }else{
                if($file->linked == 1){
                    //save it to student details attachments if done linked/sync/verified, pdf update only 
                    $file_path_ = storage_path() . '/app/public/student/new/attachments/' . $ep->student_id;
                    if (!File::isDirectory($file_path_)) {
                        File::makeDirectory($file_path_, 0777, true, true);
                    }
                    $pdf_file = \PDF::loadView('enrolment.pca.enrolment-form-pdf', compact('ef', 'ep', 'matrix'))->setPaper(array(0, 0, 595, 842), 'portrait')->save($file_path_.'/'. $hashFileName . '.pdf');
                }   
            }
            
            DB::commit();

            return ['status' => 'success', 'site' => $org->site_url];
            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'file' => $pdf_file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($file_path);
            dd($e->getMessage());
        }
    }

    
    public function generate_pdf($process_id)
    {
        // dd($process_id);
        $ep = EnrolmentPack::where('process_id', $process_id)->first();

        if(!$ep){
            abort(404);
        }
        // dd(Carbon::parse($ep->enrolment_form['date_of_birth'])->timezone('Australia/Melbourne')->format('Y-m-d'));
        // dd($ep->enrolment_form);
        $ef = $ep->enrolment_form;
        // australia contact details
        $post_geo = isset($ef['addr_suburb']['value']) ? explode(' - ', $ef['addr_suburb']['value']) : null;
        $location = null;
        if(isset($post_geo[1])){
            $getloc = explode(', ', $post_geo[1]);
            if(isset($getloc[1])){
                $location = AvtStateIdentifier::where('state_key', $getloc[1])->first();
            }
        }
        $ef['addr_postcode'] =  isset($post_geo[0]) ? $post_geo[0] : null;
        $ef['addr_suburb_state'] =  isset($post_geo[1]) ? $post_geo[1] : null;
        $ef['addr_location'] =  $location ? $location->state_name : null;
        
        // home country contact details
        $home_post_geo = isset($ef['home_country_addr_suburb']['value']) ? explode(' - ', $ef['home_country_addr_suburb']['value']) : null;
        $home_location = null;
        if(isset($home_post_geo[1])){
            $getloc_ = explode(', ', $home_post_geo[1]);
            if(isset($getloc_[1])){
                $home_location = AvtStateIdentifier::where('state_key', $getloc_[1])->first();
            }
        }
        $ef['home_country_addr_postcode'] =  isset($home_post_geo[0]) ? $home_post_geo[0] : null;
        $ef['home_country_addr_suburb_state'] =  isset($home_post_geo[1]) ? $home_post_geo[1] : null;
        $ef['home_country_addr_location'] =  $home_location ? $home_location->state_name : null;

        $matrix = $this->getMatrix($ef['course']['code'], $ef['addr_suburb']);
        // dump($matrix);
        // dump($ep);
        // dd($ef);
        // return view('enrolment.enrolment-form', compact('ef', 'ep'));
        return \PDF::loadView('enrolment.pca.enrolment-form-pdf', compact('ef', 'ep', 'matrix'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream('enrolment_form');
        // if($ep->enrolment_type == 'Full Fee'){
        //     return \PDF::loadView('enrolment.pca.enrolment-form', compact('ef', 'ep'))->stream('enrolment_form');
        // }else{
        //     return \PDF::loadView('enrolment.pca.enrolment-form-funding', compact('ef', 'ep'))->setPaper('a4', 'portrait')->stream('enrolment_form');
        // }

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

    // attachments '_input'    => 'initial_payment_receipt',
    public function documents_upload(Request $request)
    {

        // dd($request->process_id);

        $path = '';
        $file = null;
        // $date_uploaded = Carbon::now()->format('Y-m');
        $enrolment_pack = EnrolmentPack::where('process_id', $request->process_id)->first();

        try {
            DB::beginTransaction();
            
            $file = $request->file('files');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());
            $documents = new EnrolmentPackAttachment([
                'process_id' => $request->process_id,
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'    => 'initial_payment_receipt',
            ]);

            

            $path = $file->store('public/enrolment/' . $documents->process_id . '/');

            // associated user
            $documents->user()->associate(\Auth::user());

            // associated enrolment pack
            $documents->enrolment_pack()->associate($enrolment_pack);
            
            // dd($documents);
            
            // $documents->agent()->associate($agent);
            $documents->save();
            // $documents->path_id = $agent->id;
            // $documents->update();
            // $attID = $documents->id;
            // dd('sample');

            DB::commit();

            $file_path = '/storage/enrolment/' . $documents->process_id . '/' . $documents->hash_name . '.' . $documents->ext;

            $file = [
                'id' => $documents->id,
                'lastModified' => $documents->updated_at->timestamp,
                'lastModifiedDate' => $documents->updated_at,
                'name' => $documents->name,
                'size' => $documents->size,
                'file_path' => $file_path,
                'file_ext' => $documents->ext,
                'file_type' => explode('/', $documents->mime_type)[0],
            ];

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            // dd('test sample');
            dd($e->getMessage());
        }


        return $request->all();
    }

    public function documents_fetch($process_id)
    {
        $documentsUploaded = EnrolmentPackAttachment::where('process_id', $process_id)->where('_input','initial_payment_receipt')->get();

        // dd($agentAttachments->toArray());

        $documents = [];
        foreach ($documentsUploaded as $key => $value) {

            // dd($value->updated_at->timestamp);
            $file_path = '/storage/enrolment/' . $value->process_id . '/' . $value->hash_name . '.' . $value->ext;

            array_push($documents, [
                'id' => $value->id,
                'process_id' => $value->process_id,
                'lastModified' => $value->updated_at->timestamp,
                'lastModifiedDate' => $value->updated_at,
                'name' => $value->name,
                'size' => $value->size,
                'file_path' => $file_path,
                'file_ext' => $value->ext,
                'file_type' => explode('/', $value->mime_type)[0],
            ]);
        }

        return $documents;
    }

    public function documents_delete($id)
    {
        // dd('test');
        $documentsUploaded = EnrolmentPackAttachment::find($id);
        $path = '/public/enrolment/' . $documentsUploaded->process_id . '/' . $documentsUploaded->hash_name . '.' . $documentsUploaded->ext;
        
        try {
            DB::beginTransaction();
            $documentsUploaded->delete();
            // remove file
            $isDeleted = Storage::disk('local')->delete($path);
            if (!$isDeleted) throw new \Exception("File not deleted.");
            DB::commit();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            DB::rollBack();
            // remove file
            return $e->getMessage();
        }


    }

    public function documents_preview($id)
    {
        // file model instance
        $file = EnrolmentPackAttachment::find($id);

        $path = storage_path() . '/app/public/enrolment/' . $file->process_id . '/' . $file->hash_name . '.' . $file->ext;

        // raw file contents
        $fileContent = File::get($path);

        return response($fileContent)->header('Content-Type', $file->mime_type);
    }

    public function documents_update($uid) {
        $findDocuments = EnrolmentPackAttachment::where('u_id', $uid)->first();
        $findRelatedDocuments = EnrolmentPackAttachment::where('u_id', $uid)->select(['id', 'note', 'is_current'])->get();

        \JavaScript::put([
            'related_documents' => $findDocuments,
            'find_related_documents' => $findRelatedDocuments,
        ]);
        return view('documents.edit');
    }

    public function rename(Request $request, $id){
        try {
            DB::beginTransaction();

            $studentAttachment = EnrolmentPackAttachment::where('id', $id)->first();
            $studentAttachment->name = $request->rename;
            $studentAttachment->update();

            DB::commit();
            return json_encode(['status' => 'updated']);
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }
    }

    public function getMatrix($course_code, $suburb){

        $cd = Course::with('matrix','courseprospectus')->where('code', $course_code)->first();
        $postcode = AvtPostcode::where('id',$suburb['id'])->first();
        $matrix = $cd->matrix->where('location',$postcode->state)->where('course_code', $course_code)->first();

        return $matrix;
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
