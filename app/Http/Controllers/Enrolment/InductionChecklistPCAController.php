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

class InductionChecklistPCAController extends Controller
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

        return view('enrolment.pca.induction-checklist-form');
    }

    public function pages($process_id = null)
    {
        $student_id = '';
        $student_name = '';
        $student_dob = '';
        if (\Auth::user()->hasRole('Student')) {
            $student = Student::with(['party.person', 'type'])->where('party_id', \Auth::user()->party_id)->first();
            $student_id = $student->student_id;
            $student_name = $student->party->name;
            $student_dob = $student->party->person->date_of_birth;
        }else{
            $student_name = \Auth::user()->username;
        }
        

        if ($process_id != null) {
            $ep = EnrolmentPack::where('process_id', $process_id)->first();
            // return json_decode($ep->enrolment_form, true);
            $enrolment_form = Storage::get('/public/enrolment/' . $ep->process_id . '/induction-checklist-form.txt');
            // dd($enrolment_form);
            return json_decode($enrolment_form,true);
        }

        
        $courses = Course::select(DB::raw('id, code, name as name_only, concat(code, " - ", name) as name'))->where('is_active', 1)->get();
        $pages = [
            [
                "component" => [ //start components
                    [
                        'title' => 'Student’s Details',
                        'inputs' => [
                            [
                                'type' => 'text',
                                'name' => 'student_name',
                                'label' => 'Student Name',
                                'value' => $student_name,
                                'required' => true,
                                'col_size' => 12,
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
                                'name' => 'date_of_birth',
                                'label' => 'Date of Birth',
                                'col_size' => 6,
                                'value' => $student_dob,
                            ],
                            [
                                'type' => 'multiselect',
                                'name' => 'course',
                                'multiselect' => false,
                                'label'=> 'Course code and Name',
                                'selections' => $courses,
                                'mTrackBy' => 'code',
                                'mLabel' => 'name',
                                'required' => true,
                                'col_size' => 12,
                            ],
                            
                        ]
                    ],
                    [
                        "title" => 'Information',
                        'inputs' => [
                            [
                                'type' => 'check-description',
                                'name' => 'information',
                                // 'label' => 'Enrolment Declaration',
                                'col_size' => 12,
                                'content' => [
                                    [

                                        'description' => '<b>Course/module information</b> <br> 
                                        <ul>
                                            <li>Introduction   of   key   teaching   and support staff</li>
                                            <li>Course outline</li>
                                            <li>Training and Assessment Strategies Competency based training and assessment</li>
                                            <li>Duration and Timetables provided</li>
                                            <li>Assessment outcomes and student certificates upon completion</li>
                                        </ul>
                                        ',
                                    ],
                                    [

                                        'description' => '<b>Work Health and Safety Procedures</b> <br> 
                                        <ul>
                                            <li>Evacuation procedures explained</li>
                                            <li>Emergency exits clear</li>
                                            <li>Location/access to First Aid Kit</li>
                                        </ul>
                                        ',
                                    ],
                                    [
                                        'description' => '<b>Location of</b> <br> 
                                        <ul>
                                            <li>Classrooms</li>
                                            <li>Kitchen and Break out areas</li>
                                            <li>Toilets</li>
                                            <li>Public transport</li>
                                        </ul>
                                        ',
                                    ],
                                    [
                                        'description' => '<b>Ethics and standards of PCA</b> <br> 
                                        <ul>
                                            <li>Access and Equity</li>
                                            <li>Student Code of Conduct</li>
                                            <li>Plagiarism & cheating</li>
                                            <li>Student Handbook</li>
                                        </ul>
                                        ',
                                    ],
                                    [

                                        'description' => 'Information on resources / Course material / textbooks Learning outcomes.',
                                    ],
                                    [

                                        'description' => 'Complaints and Appeals Access to policies and procedures of PCA ',
                                    ],
                                    [

                                        'description' => 'Unique Student Identifier (USI)',
                                    ],
                                    [

                                        'description' => 'ESOS framework',
                                    ],	
                                    [

                                        'description' => 'Language, Literacy and Numeracy/Entry requirements',
                                    ],
                                    [

                                        'description' => 'Record Keeping',
                                    ],
                                    [

                                        'description' => 'Attendance importance',
                                    ],
                                    [

                                        'description' => 'Deferment, Suspension and Cancellation Policy ',
                                    ],
                                    [

                                        'description' => 'Refund Policy',
                                    ],
                                    [

                                        'description' => 'Credit Transfer and RPL Policy',
                                    ],
                                    [

                                        'description' => 'Course Progress and Intervention',
                                    ],
                                    [

                                        'description' => 'Transfer between Providers Policy',
                                    ],
                                    [

                                        'description' => 'Student Support Services offered',
                                    ],
                                    [

                                        'description' => 'Fees and Charges, refund policy and procedure',
                                    ],
                                    [

                                        'description' => 'Adjusting to Life in Melbourne/Brisbane',
                                    ],
                                    [

                                        'description' => 'Student Visa Conditions',
                                    ],
                                ]
                            ]
                        ]
                    ],
                    [
                        "title" => 'Student Declaration',
                        'inputs' => [
                            [
                                'type' => 'card',
                                'name' => 'student_declaration',
                                'label' => '',
                                'content' => [
                                    [
                                        'type' => 'paragraph',
                                        'body' => 'I have attended the Induction Program at Phoenix College of Australia. I acknowledge that I have been
                                        Provided with the Student Handbook and I have understood the information mentioned above. ',
                                    ]
                                ],
                                'col_size' => 12,
                            ],
                            [
                                'type' => 'date',
                                'name' => 'student_declaration_date',
                                'label' => 'Date',
                                'col_size' => 6,
                            ],
                        ]
                    ],

                ], // end components

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
            $e_pack = EnrolmentPack::where('student_id', $inputs['student_id'])->first();
            $e_pack->induction = $request->inputs;
            $e_pack->update();

            $path = '/public/enrolment/' . $e_pack->process_id . '/induction-checklist-form.txt';
            Storage::put($path, $request->pages);

            $this->student_attachment($inputs['student_id']);

            return ['status' => 'success', 'process' => $e_pack->process_id];
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
        $ef = json_decode($ep->induction, true);
        $inputs = $ef['inputs'];
        $signature = $ef['type_signature'];

        try {
            DB::beginTransaction();
            
            $file_path = storage_path() . '/app/public/student/new/attachments/' . $student_id;

            if (!File::isDirectory($file_path)) {
                File::makeDirectory($file_path, 0777, true, true);
            }

            $hashFileName = $ep->student_name.'-induction-form';
            $pdf_file = \PDF::loadView('enrolment.pca.induction-checklist-pdf', compact('inputs','ep', 'signature'))->setPaper(array(0, 0, 595, 842), 'portrait')->save($file_path.'/'. $hashFileName . '.pdf');

            $pdf = Storage::size('/public/student/new/attachments/' . $student_id . '/' . $hashFileName . '.pdf');
            $file = StudentAttachment::where('student_id', $student_id)->where('_input', 'induction-form')->first();
            if($file == null){
                $studentAttachment = new StudentAttachment([
                    'name'          => $ep->student_name.'-induction-form.pdf',
                    'hash_name'     => $hashFileName,
                    'size'          => $pdf,
                    'mime_type'     => 'application/pdf',
                    'ext'           => 'pdf',
                    '_input'        => 'induction-form',
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
        $ind = json_decode($ep->induction, true);
        $app_setting = TrainingOrganisation::first();
        \JavaScript::put([
            // 'courses' => $courses->pluck('name','code'),
            // 'avtDeliveryMode' => $avtDeliveryMode->pluck('description', 'value'),
            'pages'                     => $this->pages($process_id),
            'process_id'                => $process_id,
            'app_settings'              => $app_setting,
            'logo_url'                  => $this->get_logo(),
            'type_signature'            => $ind['type_signature'],
            'sig_acceptance_agreement'  => $ind['sig_acceptance_agreement']
        ]);

        return view('enrolment.pca.induction-checklist-form');
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
        $ef = json_decode($ep->induction, true);
        $inputs = $ef['inputs'];
        $signature = $ef['type_signature'];

        return \PDF::loadView('enrolment.pca.induction-checklist-pdf', compact('inputs', 'ep', 'signature'))->setPaper(array(0, 0, 595, 842), 'portrait')->stream('induction-checklist');


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
