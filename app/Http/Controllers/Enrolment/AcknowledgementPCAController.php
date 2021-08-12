<?php

namespace App\Http\Controllers\Enrolment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
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

use App\Models\Student\Type;
use App\Models\Student\Party;
use App\Models\PaymentStatus;
use App\Models\Student\Person;
use App\Models\Student\Student;
use App\Models\StudentAttachment;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

class AcknowledgementPCAController extends Controller
{

    public function __construct() {
        // dd(config('app.name'));
        // if(config('app.name') != 'Phoenix'){
        //     abort(403, 'Unauthorized action.');
        // }
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
        $app_setting = TrainingOrganisation::first();

        \JavaScript::put([
            // 'courses' => $courses->pluck('name','code'),
            // 'avtDeliveryMode' => $avtDeliveryMode->pluck('description', 'value'),
            'app_settings'  => $app_setting,
            'pages'         => $this->pages(),
            'logo_url'      => $this->get_logo(),
        ]);

        return view('enrolment.pca.acknowledgement-form');
    }

    public function pages($process_id = null)
    {

        $student_id = '';
        $student_name = '';
        if (\Auth::user()->hasRole('Student')) {
            $student = Student::with(['party.person', 'type'])->where('party_id', \Auth::user()->party_id)->first();
            $student_id = $student->student_id;
            $student_name = $student->party->name;
        }else{
            $student_name = \Auth::user()->username;
        }

        if ($process_id != null) {
            $ep = EnrolmentPack::where('process_id', $process_id)->first();
            // return json_decode($ep->enrolment_form, true);
            $enrolment_form = Storage::get('/public/enrolment/' . $ep->process_id . '/acknowledgement-form.txt');
            // dd($enrolment_form);
            return json_decode($enrolment_form,true);
        }

        $pages = [
            [
                "component" => [ //start components
                    [
                        "title" => 'Purpose of this Document',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'purpose_document',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'This document is to make sure that every student at Phoenix College of Australia (PCA) has received the pre-enrolment information including the student handbook before the enrollment at the institute so that an informed decision can be made by the student.   ',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        "title" => 'Marketing and recruitment',
                        'inputs' => [
                            [
                                'type' => 'radio',
                                'name' => 'mar1_the_info',
                                'label' => '1.	The information I received about my course before I enrolled (signed up) was true.',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'mar2_I_knew',
                                'label' => '2.	I knew the name of my training provider before I enrolled (signed up).',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'mar3_did_the_pca',
                                'label' => '3.	Did the PCA offer you any incentives to sign up to the course?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'mar4_pca_promise',
                                'label' => '4.	Did the PCA promise or guarantee you would get a job if you completed the course?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'mar5_were_you_referred',
                                'label' => '5.	Were you referred by an Education Agent?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                    [
                                        'value' => 'NA',
                                        'description' => 'NA'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'mar6_were_you_satisfied',
                                'label' => '6.	Were you satisfied with the knowledge and information provided by the agent?',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                    [
                                        'value' => 'NA',
                                        'description' => 'NA'
                                    ],
                                ]
                            ],

                        ]
                    ],
                    [
                        "title" => 'Enrolment',
                        'inputs' => [
                            [
                                'type' => 'radio',
                                'name' => 'enrolment1_understood_length',
                                'label' => '1.	I understood the length of the course before I enrolled (signed up).',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'enrolment2_pca_gave_info',
                                'label' => '2.	PCA gave me information about how the course would meet my needs before I enrolled (signed up).',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'enrolment3_understood_requirements',
                                'label' => '3.	I understood the study requirements before I enrolled (signed up).',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'enrolment4_rights',
                                'label' => '4.	My rights and responsibilities as a student were explained to me before I enrolled (signed up).',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'enrolment4_payment_terms',
                                'label' => '5.	The payment terms and conditions were clear to me when I enrolled (signed up).',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                            [
                                'type' => 'radio',
                                'name' => 'enrolment6_refund_policy',
                                'label' => '6.	I was aware of PCA refund policy when I enrolled (signed up).',
                                'col_size' => 12,
                                'content' => [
                                    [
                                        'value' => 'Yes',
                                        'description' => 'Yes',
                                    ],
                                    [
                                        'value' => 'No',
                                        'description' => 'No'
                                    ],
                                ]
                            ],
                        ]
                    ],

                ], // end components

            ],
            [
                'component' => [ //start component
                    [
                        'title' => 'Useful Links',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'useful_links',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Study in Australia</b><br><a href="https://www.studyinaustralia.gov.au/english/australian-education/education-system/esos-act" target="_blank">https://www.studyinaustralia.gov.au/english/australian-education/education-system/esos-act</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>National Code 2018 Factsheets</b><br><a href="https://internationaleducation.gov.au/Regulatory-Information/Pages/National-Code-2018-Factsheets-.aspx" target="_blank">https://internationaleducation.gov.au/Regulatory-Information/Pages/National-Code-2018-Factsheets-.aspx</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Study in Australia</b><br><a href="https://www.studyinaustralia.gov.au/English/Live-in-Australia/Accommodation" target="_blank">https://www.studyinaustralia.gov.au/English/Live-in-Australia/Accommodation</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Department of Home affairs</b><br><a href="https://immi.homeaffairs.gov.au/visas/getting-a-visa/visa-listing/student-500" target="_blank">https://immi.homeaffairs.gov.au/visas/getting-a-visa/visa-listing/student-500</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Australian Taxation Office</b><br><a href="https://www.ato.gov.au/" target="_blank">https://www.ato.gov.au/</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Legal Aid Queensland</b><br><a href="https://www.legalaid.qld.gov.au/Home" target="_blank">https://www.legalaid.qld.gov.au/Home</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Work safe Queensland</b><br><a href="https://www.worksafe.qld.gov.au/" target="_blank">https://www.worksafe.qld.gov.au/</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Fair work Australia</b><br><a href="https://www.fairwork.gov.au/" target="_blank">https://www.fairwork.gov.au/</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Ombudsman website </b><br><a href="https://www.ombudsman.gov.au/" target="_blank">https://www.ombudsman.gov.au/</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>National Register of VET</b><br><a href="https://training.gov.au/Organisation/Details/45633" target="_blank">https://training.gov.au/Organisation/Details/45633</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>Commonwealth Register of Institutions and courses for overseas Students </b><br><a href="https://cricos.education.gov.au/Institution/InstitutionDetails.aspx?ProviderCode=03871F" target="_blank">https://cricos.education.gov.au/Institution/InstitutionDetails.aspx?ProviderCode=03871F</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>College Website</b><br><a href="http://phoenixcollege.edu.au/courses/certificate-ii-in-security-operations/" target="_blank">http://phoenixcollege.edu.au/courses/certificate-ii-in-security-operations/</a>',
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'body' => '<b>USI Factsheet</b><br><a href="https://www.usi.gov.au/documents/factsheet-student-information-rtos" target="_blank">https://www.usi.gov.au/documents/factsheet-student-information-rtos</a>',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                        ]
                    ],
                    [
                        'title' => 'Declaration',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'student_name',
                                'label' => 'Name',
                                'col_size' => 6,
                                'value' => $student_name,
                                'required' => true,
                                'readOnly' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'student_id',
                                'label' => 'PCA ID',
                                'col_size' => 6,
                                'value' => $student_id,
                                'required' => true,
                                'readOnly' => true,
                            ],
                            // [
                            //     'type' => 'text',
                            //     'name' => 'declaration_sig',
                            //     'label' => 'Signature',
                            //     'col_size' => 6,
                            // ],
                            [
                                'type' => 'date',
                                'name' => 'declaration_date',
                                'label' => 'Date',
                                'col_size' => 6,
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
        $inputs = $request->inputs['inputs'];
        // $jsonPages = json_encode($request->pages);

        // $jsonPages = $request->inputs;
        // dd($jsonPages[0]->component[2]->inputs[1]->value);
        // dd($jsonPages);

        if($inputs['student_id'] != null) {
            $save = EnrolmentPack::where('student_id', $inputs['student_id'])->first();
            $save->acknowledgement = $request->inputs;
            $save->update();

            $path = '/public/enrolment/' . $save->process_id . '/acknowledgement-form.txt';
            Storage::put($path, $request->pages);

            $this->student_attachment($inputs['student_id']);

            return ['status' => 'success', 'process' => $save->process_id];
        } 

        

        // dd(json_decode($jsonPages, true));
    }

    public function student_attachment($student_id){

        // dd($student_id);

        $file_path = '';
        $pdf_file = null;
        $ep = EnrolmentPack::where('student_id', $student_id)->first();
        if(!$ep){
            abort(404);
        }
        $ef = json_decode($ep->acknowledgement, true);
        $inputs = $ef['inputs'];
        $signature = $ef['type_signature'];

        try {
            DB::beginTransaction();
            
            $file_path = storage_path() . '/app/public/student/new/attachments/' . $student_id;

            if (!File::isDirectory($file_path)) {
                File::makeDirectory($file_path, 0777, true, true);
            }

            $hashFileName = $ep->student_name.'-acknowledgement';
            $pdf_file = \PDF::loadView('enrolment.pca.acknowledgement-pdf', compact('inputs','ep', 'signature'))->setPaper(array(0, 0, 595, 842), 'portrait')->save($file_path.'/'. $hashFileName . '.pdf');

            $pdf = Storage::size('/public/student/new/attachments/' . $student_id . '/' . $hashFileName . '.pdf');
            $file = StudentAttachment::where('student_id', $student_id)->where('_input', 'acknowledgement')->first();
            if($file == null){
                $studentAttachment = new StudentAttachment([
                    'name'          => $ep->student_name.'-acknowledgement.pdf',
                    'hash_name'     => $hashFileName,
                    'size'          => $pdf,
                    'mime_type'     => 'application/pdf',
                    'ext'           => 'pdf',
                    '_input'        => 'acknowledgement',
                    // 'student_id'    => $student_id, 
                ]);
    
                // associated user
                $studentAttachment->user()->associate(\Auth::user());
                $studentAttachment->student()->associate($student_id);
                $studentAttachment->save();
                $studentAttachment->path_id = $student_id;
                $studentAttachment->update();
            }
            
            DB::commit();


            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $pdf_file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($file_path);
            dd($e->getMessage());
        }
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
        $ep = EnrolmentPack::where('process_id', $process_id)->first();
        // dd($ep);
        $ef = $ep->enrolment_form;

        // dump($ep);
        // dd($ef);
        //
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
        $ep = EnrolmentPack::where('process_id', $process_id)->first();
        $ack = json_decode($ep->acknowledgement, true);
        $app_setting = TrainingOrganisation::first();
        \JavaScript::put([
            // 'courses' => $courses->pluck('name','code'),
            // 'avtDeliveryMode' => $avtDeliveryMode->pluck('description', 'value'),
            'pages'                     => $this->pages($process_id),
            'process_id'                => $process_id,
            'app_settings'              => $app_setting,
            'logo_url'                  => $this->get_logo(),
            'type_signature'            => $ack['type_signature'],
            'sig_acceptance_agreement'  => $ack['sig_acceptance_agreement']
        ]);

        return view('enrolment.pca.acknowledgement-form');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
        // dd($process_id);
        $ep = EnrolmentPack::where('process_id', $process_id)->first();
        if(!$ep){
            abort(404);
        }
        $ef = json_decode($ep->acknowledgement, true);
        $inputs = $ef['inputs'];
        $signature = $ef['type_signature'];

        return \PDF::loadView('enrolment.pca.acknowledgement-pdf', compact('inputs', 'ep','signature'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream('acknowledgement_form');


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
}
