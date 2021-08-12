<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\ExternalForm;
use App\Models\TrainingOrganisation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteInspectionChecklistController extends Controller
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
        $app_setting = TrainingOrganisation::first();
        \JavaScript::put([
            // 'courses' => $courses->pluck('name','code'),
            // 'avtDeliveryMode' => $avtDeliveryMode->pluck('description', 'value'),
            'pages' => $this->pages(),
            'app_settings' => $app_setting, 
            'logo_url'      => $this->get_logo(),
        ]);

        return view('forms.site-inspection-checklist');
    }

    public function list()
    {
        return view('forms.site-inspection-checklist-list');
    }

    public function fetch()
    {
        $data = ExternalForm::where('form_type', 'site_inspection_checklist')->get();
        $list = [];
        foreach($data as $key => $itm) {
            $list[] = [
                'id' => $itm->id,
                'process_id' => $itm->process_id,
                'team_members' => isset($itm->form_json['team_members']) ? $itm->form_json['team_members'] : '',
                'date_of_inspection' => isset($itm->form_json['date_of_inspection']) ? Carbon::parse($itm->form_json['date_of_inspection'])->setTimezone('Australia/Brisbane')->format('d/m/Y') : '',
                'training_delivery_location_address' => isset($itm->form_json['training_delivery_location_address']) ? $itm->form_json['training_delivery_location_address'] : '',
            ];
        }

        return $list;

    }

    public function pages($process_id = null)
    {

        // if ($process_id != null) {
        //     $ep = EnrolmentPack::where('process_id', $process_id)->first();
        //     // return json_decode($ep->enrolment_form, true);
        //     $enrolment_form = Storage::get('/public/enrolment/' . $ep->process_id . '/enrolment-form.txt');
        //     // dd($enrolment_form);
        //     return json_decode($enrolment_form,true);
        // }

        // $courses = Course::select(DB::raw('id, code, name as name_only, concat(code, " - ", name) as name'))->where('is_active', 1)->get();
        // $units = Unit::select(DB::raw('id, code, description as name_only, concat(code, " - ", description) as description'))->where('extra_unit', 1)->get();
        // $avtDeliveryMode = AvtDeliveryMode::where('alt_description', '<>', null)->get();
        // $avtPostcodeGeo = AvtPostcode::select(DB::raw('id, concat(postcode, " - ", suburb, ", ", state) as value'))->get();
        // $visaType = VisaStatus::select(DB::raw('id, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS value'))->get();
        // $highSchoolLevel = AvtHighestSchlLvlCompleted::all();

        // dd(Course::select(DB::raw('code, name'))->where('is_active', 1)->get());
        // $courses_units = [];
        // foreach($courses as $v){
        //     $courses_units[] = [
        //         '<p class="text-center">'.$v->code.'</p>',
        //         '<p class="text-center">'.$v->name_only.'</p>'
        //     ];
        // }
        // foreach($units as $v){
        //     $courses_units[] = [
        //         '<p class="text-center">'.$v->code.'</p>',
        //         '<p class="text-center">'.$v->name_only.'</p>'
        //     ];
        // }
        // dd($courses_units);
        // $courses_units = array_merge(),;

        // dd($avtPostcodeGeo);
        $pages = [
            [
                'component' => [ //start component
                    [
                        // 'title' => 'SITE INSPECTION CHECKLIST',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'team_members',
                                'label' => 'Team Members',
                                'col_size' => 6,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'date_of_inspection',
                                'label' => 'Date of Inspection',
                                'col_size' => 6,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'training_delivery_location_address',
                                'label' => 'Training Delivery Location Address',
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'table-custom',
                                'col_size' => 12,
                                'headers' => [
                                    [
                                        'cols' => ['', 'Acceptable', 'Immediate action taken', 'Further action required*', 'Date signed off', 'Date to be completed'],
                                        'rowspan' => [2,0,2,2,2,2],
                                        'colspan' => [0,2,0,0,0],
                                    ],
                                    [
                                        'cols' => ['Y', 'N'],
                                        'rowspan' => [0,0],
                                        'colspan' => [0,0],
                                    ]
                                ],
                                'body' =>  [
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Thoroughfares (access and egress)',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Pathways/walkways/stairs/ramps and access areas clear of rubbish and obstructions',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Pathways/walkways are slip free. Surfaces are even, free of holes, cracks, fraying or uplifted edges',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Slip resistant materials or absorbent mats used in wet areas',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Steps/stairs/ramps/handrails are secure and in good repair',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Electrical cables/cords kept clear of walkways or secured',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Exit and egress points clearly identified and accessible',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Office environment (workstations and surrounding areas)',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Ergonomic furniture is appropriately adjusted e.g. keyboards, chairs',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Furniture is well maintained and in good/safe condition',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Desks and benches stable and suitable for the work',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Materials are stored appropriately e.g. not on floor around work areas',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Staff use good housekeeping practices around their work areas',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Sufficient space is provided around workstations so staff can move and work safely',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Walkways and aisles are clear of obstructions',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Floor mats do not present trip hazards',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Lifting aids are available where required',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Electrical equipment is in good working order',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Electrical leads are secured to prevent trip hazards',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Adequate ventilation in all areas',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],

                                ]
                            ],
                            
                        ]
                    ],
                    
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        // 'title' => 'SITE INSPECTION CHECKLIST',
                        'inputs' => [
                            [
                                'type' => 'table-custom',
                                'col_size' => 12,
                                'headers' => [
                                    [
                                        'cols' => ['', 'Acceptable', 'Immediate action taken', 'Further action required*', 'Date signed off', 'Date to be completed'],
                                        'rowspan' => [2,0,2,2,2,2],
                                        'colspan' => [0,2,0,0,0],
                                    ],
                                    [
                                        'cols' => ['Y', 'N'],
                                        'rowspan' => [0,0],
                                        'colspan' => [0,0],
                                    ]
                                ],
                                'body' =>  [
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Storage',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Storerooms and storage areas are tidy and free from obstruction',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Stored materials are secured appropriately to prevent them falling',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Heavy equipment (if any) is stored at waist level',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Storage areas are accessible and free from trip hazards',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Shelving is stable and well maintained',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Electrical',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'All power boards have an overload switch',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Portable power leakage circuits checked and functioning correctly',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'All electrical cables free of possible contact with water or other conductors',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Double adaptors are not used in conjunction with other double adaptors or extension leads',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'No leads placed where subject to damage e.g. heat or cutting',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'No broken plugs, sockets or switches',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Master controls – whole workplace',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Perimeter fences and safety barriers in place and maintained',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Access by delivery vehicles and other vehicles safe for pedestrians',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Rubbish is stored appropriately and removed regularly',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Building/renovation areas and contained debris are controlled through effective barriers against unauthorised access',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                ]
                            ],
                            
                        ]
                    ],
                    
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        // 'title' => 'SITE INSPECTION CHECKLIST',
                        'inputs' => [
                            [
                                'type' => 'table-custom',
                                'col_size' => 12,
                                'headers' => [
                                    [
                                        'cols' => ['', 'Acceptable', 'Immediate action taken', 'Further action required*', 'Date signed off', 'Date to be completed'],
                                        'rowspan' => [2,0,2,2,2,2],
                                        'colspan' => [0,2,0,0,0],
                                    ],
                                    [
                                        'cols' => ['Y', 'N'],
                                        'rowspan' => [0,0],
                                        'colspan' => [0,0],
                                    ]
                                ],
                                'body' =>  [
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Bathrooms and toilets',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Adequate and clean toilet facilities and supplies',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Toilets provided for people with disability',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Toilet and bathroom facilities cleaned regularly',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Paper towels or air dryers available and working',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Toilet paper available with spare rolls readily accessible',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Sanitary towel disposal units in female toilets',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Facilities well ventilated',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Kitchen',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Appropriate hand washing facilities are available',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Safety guidelines/rules are clearly displayed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'To prevent slips and trips, all areas are kept clean and free of waste or obstructions',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Access to kitchen equipment is restricted to relevant staff',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Hygiene',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Common rooms clean and tidy',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Food preparation areas clean and hygienic',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Fridges and food storage areas kept clean and hygienic',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Adequate drinking facilities',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                ]
                            ],
                            
                        ]
                    ],
                    
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        // 'title' => 'SITE INSPECTION CHECKLIST',
                        'inputs' => [
                            [
                                'type' => 'table-custom',
                                'col_size' => 12,
                                'headers' => [
                                    [
                                        'cols' => ['', 'Acceptable', 'Immediate action taken', 'Further action required*', 'Date signed off', 'Date to be completed'],
                                        'rowspan' => [2,0,2,2,2,2],
                                        'colspan' => [0,2,0,0,0],
                                    ],
                                    [
                                        'cols' => ['Y', 'N'],
                                        'rowspan' => [0,0],
                                        'colspan' => [0,0],
                                    ]
                                ],
                                'body' =>  [
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Room heaters, air conditioners and ventilation',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Heating and cooling units effective for the work area',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Heaters in good working condition',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Heaters situated clear of flammable items',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Photocopiers are placed in well ventilated areas',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Plant/machinery/equipment (tick only if applicable, otherwise write NA)',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'All fixed machines (if applicable) are secured on their mountings and free from movement and vibration',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Adequate workspace is marked around danger zones of each item of plant to ensure safety',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'All machines and equipment have adequate guards fitted as per manufacturers instructions',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'All items checked to ensure that guards have not been modified and are being used effectively e.g. circular saws, guillotines, lathes, tractors etc',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Emergency cut-off switches operational and within close proximity to users',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Safety procedures, Standard operating Procedures and related signage is prominently displayed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Areas around machines are kept clear of debris and stacked material',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Records of equipment inspection, maintenance and repair are available',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Hazardous substances (chemical safety, (tick only if applicable, otherwise write NA)',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'The hazardous substances register is up to date',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'MSDSs available to all staff online (ChemWatch website)',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'All chemicals are secured from unauthorised access',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'All chemicals are stored correctly according to MSDSs and CSIS guidelines',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Decanted chemicals are placed in suitable containers and correctly labelled',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Chemical storerooms are locked and signs prohibiting unauthorised personnel from entering are in place',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Only minimal quantities of chemicals are kept on site',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Dangerous Goods licence checklist and declaration has been completed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Spill kits are readily available to control chemical spills',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'All records on the acquisition, storage and disposal of hazardous substances are maintained as per CSIS',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                ]
                            ],
                            
                        ]
                    ],
                    
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        // 'title' => 'SITE INSPECTION CHECKLIST',
                        'inputs' => [
                            [
                                'type' => 'table-custom',
                                'col_size' => 12,
                                'headers' => [
                                    [
                                        'cols' => ['', 'Acceptable', 'Immediate action taken', 'Further action required*', 'Date signed off', 'Date to be completed'],
                                        'rowspan' => [2,0,2,2,2,2],
                                        'colspan' => [0,2,0,0,0],
                                    ],
                                    [
                                        'cols' => ['Y', 'N'],
                                        'rowspan' => [0,0],
                                        'colspan' => [0,0],
                                    ]
                                ],
                                'body' =>  [
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Personal protective equipment (PPE)',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'All PPE is stored appropriately',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'All PPE is checked and maintained appropriately e.g. cleaned or replaced as required',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Sun Safety procedures and No Hat No Play policy is practiced',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Training and Assessment',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'All the material and equipment required for delivering training and assessment is on the site and OHS compliant.',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Projectors/computers are in order.',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'PowerPoints are safe to use.',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Furniture has been placed in order and there is no hazard in the classroom.',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Technology learning environment',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'PPE is supplied appropriate to the task and the user',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Plant, equipment and furniture arranged to allow safe movement within the area',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Ventilation systems such as windows and fans functioning correctly',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                ]
                            ],
                            
                        ]
                    ],
                    
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        // 'title' => 'SITE INSPECTION CHECKLIST',
                        'inputs' => [
                            [
                                'type' => 'table-custom',
                                'col_size' => 12,
                                'headers' => [
                                    [
                                        'cols' => ['', 'Acceptable', 'Immediate action taken', 'Further action required*', 'Date signed off', 'Date to be completed'],
                                        'rowspan' => [2,0,2,2,2,2],
                                        'colspan' => [0,2,0,0,0],
                                    ],
                                    [
                                        'cols' => ['Y', 'N'],
                                        'rowspan' => [0,0],
                                        'colspan' => [0,0],
                                    ]
                                ],
                                'body' =>  [
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Housekeeping',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'All work spaces are clear, tidy and free of obstruction and waste',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'All displays, hanging or posted, are without risk',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Appropriate aids available for work being carried out e.g. steps/ladders, trolleys',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'OHS Corporate Policy is displayed on staff noticeboard(s)',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'OHS Consultation Statement is displayed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'List of OHS Committee Members or OHS Representative is displayed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Minutes of OHS Committee Meetings is displayed in staff room',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'The Reporting OHS Incidents and Injuries brochure is displayed in staff rooms',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Dignity and Respect Charter is displayed in staff areas',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'EAP information and brochures are displayed and available to staff',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'WorkCover “Watching out for you” poster is displayed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'First aid',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'First Aid Plan is displayed on noticeboard(s)',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'First aid arrangements are displayed, including name and location of first aid officer',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Appropriate first aid kits are available and easily accessible with signs clearly visible',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'A current record of all first aid treatment is kept',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'First aid room, sick bay or clinic is available',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'First aid arrangements are displayed, including name and location of first aid officer',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'First aid kits are checked regularly to ensure they are clean, orderly, fully stocked and not expired',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Standard precautions for infection control are displayed and hand washing facilities are available',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Medication associated with student health care are securely stored',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Emergency management',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Emergency Management Plan and procedures are',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'displayed on noticeboard(s)',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Emergency evacuation exercise is undertaken in accordance with the Emergency Management plan',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Emergency numbers are clearly displayed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Entrances and exits are clearly identified and kept free of obstruction',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Emergency equipment (e.g. fire extinguishers) is located appropriately and regularly tested and tagged to ensure it’s in good working order',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Emergency numbers (Poisons hotline etc) displayed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                ]
                            ],
                            
                        ]
                    ],
                    
                ] //end component
            ],
            [
                'component' => [ //start component
                    [
                        // 'title' => 'SITE INSPECTION CHECKLIST',
                        'inputs' => [
                            [
                                'type' => 'table-custom',
                                'col_size' => 12,
                                'headers' => [
                                    [
                                        'cols' => ['', 'Acceptable', 'Immediate action taken', 'Further action required*', 'Date signed off', 'Date to be completed'],
                                        'rowspan' => [2,0,2,2,2,2],
                                        'colspan' => [0,2,0,0,0],
                                    ],
                                    [
                                        'cols' => ['Y', 'N'],
                                        'rowspan' => [0,0],
                                        'colspan' => [0,0],
                                    ]
                                ],
                                'body' =>  [
                                    [   
                                        'title_row' => 1,
                                        'description' => 'Fire safety',
                                        'colspan' => 7,
                                        'inputs' => null,
                                    ],
                                    [
                                        'description' => 'Access to all fire safety equipment unobstructed',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Fire extinguishers mounted on the wall, signs located above them, fully charged and accessible',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Emergency equipment (e.g. fire extinguishers) has been tested, tagged and current',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Fire blanket required',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Fire and sprinkler heads clear of obstructions',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Clear instructions displayed for evacuation',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Adequate direction signs for emergency exits',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Fire doors and emergency exits clear of obstruction',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Correct operation of fire doors',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                    [
                                        'description' => 'Other:',
                                        'inputs' => [
                                            ['type'=>'checkbox','name' => 'checkbox_y', 'value' => false], 
                                            ['type'=>'checkbox','name' => 'checkbox_n', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_1', 'value' => false], 
                                            ['type'=>'text','name' => 'textbox_2', 'value' => false], 
                                            ['type'=>'date','name' => 'date_1', 'value' => false], 
                                            ['type'=>'date','name' => 'date_2', 'value' => false],
                                        ], 
                                    ],
                                ]
                            ],
                            
                        ]
                    ],
                    
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
        $save = null;

        if ($request->process_id == null) {

            

            $save = new ExternalForm;

            $save->process_id = $this->codeNumber();
            $save->form_type = 'site_inspection_checklist';
            $save->form_json = $request->inputs;
            $save->date_created = Carbon::now()->format('Y-m-d');
            // dd($save);
            $save->save();

            $path ='/public/site-inspection-checklist/' . $save->process_id . '/site-inspection-checklist.txt';
            Storage::put($path, $request->pages);
            $save->form_txt = $path;
            $save->update();

            return ['status' => 'success', 'process' => $save->process_id];
        } else {

            // $jsonPages = json_decode($request->pages, true);

            $save = ExternalForm::where('process_id', $request->process_id)->first();
            $save->form_json = $request->inputs;
            $path ='/public/site-inspection-checklist/' . $save->process_id . '/site-inspection-checklist.txt';
            Storage::put($path, $request->pages);
            $save->form_txt = $path;

            $save->update();

            return ['status' => 'success', 'process' => $save->process_id];
        }
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
        $form = ExternalForm::where('process_id', $process_id)->first();

        $pages = json_decode(Storage::get($form->form_txt), true);

        $inputs = $form->form_json;
        
        $app_setting = TrainingOrganisation::first();

        \JavaScript::put([
            // 'courses' => $courses->pluck('name','code'),
            // 'avtDeliveryMode' => $avtDeliveryMode->pluck('description', 'value'),
            'pages' => $pages,
            'inputs' => $inputs,
            'app_settings' => $app_setting,
            'logo_url'      => $this->get_logo(),
            'process_id' => $process_id,
        ]);

        return view('forms.site-inspection-checklist');
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

    public function generate_pdf($process_id)
    {
        $to = TrainingOrganisation::first();
        $form = ExternalForm::where('process_id', $process_id)->first();

        $inputs = $form->form_json;
        $pages = json_decode(Storage::get($form->form_txt), true);
        // dump($inputs);
        $tbody = [];
        $main_count = 0;
        foreach($pages as $key => $value) {
            foreach($value['component'][0]['inputs'] as $k => $v) {
                $sub_count = 0;
                if($v['type'] == 'table-custom'){
                   foreach($v['body'] as $kk => $vv) {
                       if(isset($vv['title_row'])){
                        $tbody[] = [
                            'type' => 'title',
                            'desc' => $vv['description'],
                        ];
                       }else{
                            $item = [];
                            foreach($vv['inputs'] as $itm){
                                if($itm['type'] == 'date'){
                                    $item[] = [
                                        'type' => $itm['type'],
                                        'value' => isset($inputs[$main_count.'-'.$sub_count.'-'.$itm['name']]) && !in_array($inputs[$main_count.'-'.$sub_count.'-'.$itm['name']], ['', null, '0000-00-00']) ? Carbon::parse($inputs[$main_count.'-'.$sub_count.'-'.$itm['name']])->setTimezone('Australia/Brisbane')->format('d/m/Y') : ''
                                    ];
                                }else{
                                    $item[] = [
                                        'type' => $itm['type'],
                                        'value' => isset($inputs[$main_count.'-'.$sub_count.'-'.$itm['name']]) ? $inputs[$main_count.'-'.$sub_count.'-'.$itm['name']] : ''
                                    ];
                                }
                            }

                            $tbody[] = [
                                'type' => 'item',
                                'desc' => $vv['description'],
                                'items' => $item,
                            ];
                           
                       }

                       $sub_count++;
                   }
                   $main_count++;
                }
            }
            // break;
        }
        $tbody_first = array_chunk($tbody, 15);
        $tbody_first = $tbody_first[0];
        $tbody_second = $tbody;
        
        foreach($tbody_first as $v){
            foreach($tbody_second as $kk => $vv){
                if($v['desc'] == $vv['desc']){
                    unset($tbody_second[$kk]);
                }
            }
        }
        $tbody_second = array_chunk($tbody_second, 21);
        $tbody = [];
        $tbody[] = $tbody_first;
        $tbody = array_merge($tbody, $tbody_second);
        // dump($tbody);
        
        // dd('end');
        // dd('end');
        return \PDF::loadView('forms.site-inspection-checklist-pdf', compact('to', 'inputs', 'tbody'))->stream('site-inspection-checklist');
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
        return ExternalForm::where('process_id', $number)->get();
    }
}
