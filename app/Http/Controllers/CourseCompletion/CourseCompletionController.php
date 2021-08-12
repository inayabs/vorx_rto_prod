<?php

namespace App\Http\Controllers\CourseCompletion;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\AvtCompletionStatus;
use App\Models\CourseProspectus;
use App\Models\StudentCompletion as CourseCompletion;
use App\Models\StudentCompletionDetail as CourseCompletionDetail;
use App\Models\CertificateIssuanceDetail;
use App\Models\FundedStudentCourse;
use App\Models\CompletionStudentCourse;
use App\Models\Course\Course;
use App\Models\FundedStudentExtraUnits;
use App\Models\Student\Student;
use App\Models\StudentCompletion;
use Illuminate\Http\Request;
use App\Models\TrainingOrganisation;

class CourseCompletionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('students.course_completion.index');
    }
    public function list()
    {
        if (\Auth::user()->hasRole('Demo')) {
            $student =  Student::with('party', 'type', 'offer_letter.course_details.course', 'funded_course.course', 'completion')->where('is_test', 0)->where('user_id', \Auth::user()->id)->has('completion')->orderBy('id', 'DESC')
                ->get();
        } else {
            $student =  Student::with('party', 'type', 'offer_letter.course_details.course', 'funded_course.course', 'completion')->where('is_test', 0)->has('completion')->orderBy('id', 'DESC')
                ->get();
        }

        // dd($student);
        return $student;
    }
    public function student_base($student)
    {

        $statuses = AvtCompletionStatus::all();
        $details = Student::with('party', 'funded_course.course', 'extra_units', 'offer_letter.course_details.course.courseprospectus')->where('student_id', $student)->first();
        $course = [];
        // dd($details);
       

        foreach ($details->funded_course as $fundedCourse) {
            if($fundedCourse->offer_letter_course_detail_id == null){
                $completion = CompletionStudentCourse::where('student_course_id',$fundedCourse->id)->where('student_type',$fundedCourse->student->student_type_id)->first();

            }else{
                $completion = CompletionStudentCourse::where('student_course_id', $fundedCourse->offer_letter_course_detail_id)->where('student_type',$details->student_type_id)->first();

            }
            $course_completion = CourseCompletion::with('certificate.details', 'details', 'status')
            ->where('id', $completion->completion_id)
            ->first();
            $course_detail = [];
            
            // if ($fundedCourse->course->courseprospectus->isEmpty()) {
            $unitsing = [];
            // dd($course_completion->details->sortBy('order'));
            foreach ($course_completion->details->sortBy('order') as $detailing) {
                $unitsing[] = [
                    'code' => $detailing->unit->code,
                    'description' => $detailing->unit->description,
                    'unit_type' =>  $detailing->unit->unit_type,
                    'order' =>  $detailing->order,
                    'dates' => '',
                    'actual_date' => '',
                    'status' => ''
                ];
            }
            // dump($course_completion->details );
            $course_detail = [
                'course' => $fundedCourse->course_code,
                'name' => $fundedCourse->course_code === '@@@@' ? 'Unit of Competency' : $fundedCourse->course->name,
                // 'name' => 'gugu gaga',
                'units' => $unitsing,
                'completion' => $course_completion
            ];
            /*  } else {
                    foreach ($fundedCourse->course->courseprospectus as $key => $prospectus) {
                        // dd($course_completion->details);
                        $units = [];
                        // dd($course_completion);
                        foreach ($prospectus->unit_selected as $selected) {
                            $units[] = [
                                'code' => $selected->code,
                                'description' => $selected->description,
                                'unit_type' => $selected->unit_type,
                                'dates' => '',
                                'status' => ''
                            ];
                        }
                        $course_detail = [
                            'course' => $fundedCourse->course_code,
                            'name' => $fundedCourse->course->name,
                            'units' => $units,
                            'completion' => $course_completion
                        ];
                    }
                } */
            $course[] = $course_detail;
        }
        // }
        $student = [
            'id' => $details->student_id,
            'sid' => $details->id,
            'name' => $details->party->name,
            'type' => $details->student_type_id,
        ];


        return response()->json(['student' => $student, 'course' => $course]);
    }
    public function student($student)
    {
        $statuses = AvtCompletionStatus::all();
        $details = Student::with('party', 'offer_letter.course_details.course.courseprospectus', 'funded_detail', 'contact_detail', 'offer_letter.student_details')->where('student_id', $student)->first();
        // dd($details);
        $course = [];
        foreach ($details->offer_letter as $key => $offer_letter) {
            // dump($offer_letter);
            $course_detail = [];
            foreach ($offer_letter->course_details as $k => $detail) {
                foreach ($detail->course->courseprospectus as $ky => $prospectus) {
                    $course_completion = CourseCompletion::with('certificate.details', 'details', 'status')
                        ->where('student_id', $student)
                        ->where('course_code', $detail->course->code)
                        ->first();
                    $units = [];
                    foreach ($prospectus->unit_selected as $selected) {
                        $units[] = [
                            'code' => $selected->code,
                            'description' => $selected->description,
                            'unit_type' => $selected->unit_type,
                            'dates' => '',
                            'status' => ''
                        ];
                    }
                    $course_detail = [
                        'course' => $detail->course->code,
                        'name' => $detail->course->name,
                        'units' => $units,
                        'completion' => $course_completion
                    ];
                }
                // $course[$key][$offer_letter->id] = [
                //     'student_type' => $details->type->type,
                //     'package' => $offer_letter->package_type,
                //     'courses' =>  $course_detail
                // ];
                // $cdetails = [
                //     'student_type' => $details->type->type,
                //     'package' => $offer_letter->package_type,
                //     'courses' =>  $course_detail
                // ];
                $course[] = $course_detail;
            }
        }

        // get emails 
        $email = [];
        if (isset($details->contact_detail)) {
            if (!in_array($details->contact_detail->email, ['', null]))
                $email[] = $details->contact_detail->email;
            if (!in_array($details->contact_detail->email_at, ['', null]))
                $email[] = $details->contact_detail->email_at;
        }
        if (isset($details->offer_letter->student_details)) {
            if (!in_array($details->offer_letter->student_details->email_personal, ['', null]))
                $email[] = $details->offer_letter->student_detail->email_personal;
        }

        $student = [
            'id' => $details->student_id,
            'name' => $details->party->name,
            'email' => $email
        ];
        \JavaScript::put([
            'student' => $student,
            'course' => $course,
            'statuses' => $statuses
        ]);
        return view('students.course_completion.show');
    }

    public function student_show($student)
    {
        $details = Student::with('party', 'offer_letter.course_details.course.courseprospectus')->where('student_id', $student)->first();
        // dd($details);
        $course = [];
        foreach ($details->offer_letter as $key => $offer_letter) {
            // dump($offer_letter);
            $course_detail = [];
            foreach ($offer_letter->course_details as $k => $detail) {
                // if($)
                foreach ($detail->course->courseprospectus as $ky => $prospectus) {
                    $course_completion = CourseCompletion::with('certificate.details', 'details', 'status')
                        ->where('student_id', $student)
                        ->where('course_code', $detail->course->code)
                        ->first();
                    $units = [];
                    foreach ($prospectus->unit_selected as $selected) {
                        $units[] = [
                            'code' => $selected->code,
                            'description' => $selected->description,
                            'unit_type' => $selected->unit_type,
                            'dates' => '',
                            'actual_date' => '',
                            'status' => ''
                        ];
                    }
                    $course_detail = [
                        'course' => $detail->course->code,
                        'name' => $detail->course->name,
                        'units' => $units,
                        'completion' => $course_completion
                    ];
                }
                $course[] = $course_detail;
            }
        }
        return $course;
    }

    public function storeUpdate(Request $request)
    {
        $latestCompletion = null;
        if ($request->course_completion == null) {
            try {
                DB::beginTransaction();
                $completion = new CourseCompletion;
                $completion->fill([
                    'student_id' => $request->student,
                    'course_code' => $request->course,
                    'completion_status' => 5,
                ]);
                $completion->user()->associate(Auth::user());
                $completion->save();

                foreach ($request->units as $key => $unit) {

                    if ($latestCompletion == null && $unit['dates']['end'] != null) {
                        // dump('hah');

                        $latestCompletion = $unit['dates']['end'];
                    } elseif ($latestCompletion != null && $latestCompletion < $unit['dates']['end']) {
                        // dump('wew');
                        $latestCompletion = $unit['dates']['end'];
                    }


                    if (in_array($unit['status'], [3, 4, 6])) {
                        $completion->update([
                            'partial_completion' => 1,
                        ]);
                    }

                    if (in_array($unit['status'], [2])) {
                        $completion = CourseCompletion::where('id',$request->course_completion['id'])->with(['student_course'=>function($q) use($request){
                            $q->where('course_code',$request->course);
                        }])->first();

                        $funded_id = $completion->student_course[0]->id;
                        // return $funded_id;
                        $funded_course = FundedStudentCourse::where('id',$funded_id)->first();
                        $funded_course->status_id = 7;
                        $funded_course->update();
                    }  

                    if ($unit['dates']['start'] !== null && $unit['dates']['end'] !== null) {
                        $completion_details = new CourseCompletionDetail;
                        $completion_details->fill([
                            'course_unit_code' => $unit['code'],
                            'actual_start' => ($unit['dates']['start'] != null) ? Carbon::createFromFormat('Y-m-d', $unit['dates']['start'])->format('Y-m-d') : null,
                            'actual_end' => ($unit['dates']['end']  != null) ? Carbon::createFromFormat('Y-m-d', $unit['dates']['end'])->format('Y-m-d') : null,
                            'completion_status_id' => $unit['status']
                        ]);
                        $completion_details->completion()->associate($completion);
                        $completion_details->save();
                    }
                }

                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Added Successfully.']);
                //code...
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['status' => 'error', 'messsage' => $th->getMessage()]);
            }


            // CourseCompletion::updateOrCreate(
            //     ['student_id'=>$request->student,'course_code'=>$request->course],
            //     ['']
            // )
        } else {
            try {
                DB::beginTransaction();
                $validateCompletion = 1;
                // dd($request->course_completion['id']);
                if (count($request->units) <= 5) {
                    $validateCompletion = 0;
                }
                foreach ($request->units as $key => $unit) {

                    // if ($validateCompletion == 1 && !in_array($unit['status'], [3, 4, 6])) {
                    if (!in_array($unit['status'], [3, 4, 6])) {
                        // dd('test');
                        $validateCompletion = 0;
                    }
                    if (in_array($unit['status'], [3, 4, 6])) {
                        $completion = CourseCompletion::find($request->course_completion['id']);
                        $completion->update([
                            'partial_completion' => 1,
                        ]);
                    }
                    
                    if (in_array($unit['status'], [2])) {
                        $completion = CourseCompletion::where('id',$request->course_completion['id'])->with(['student_course'=>function($q) use($request){
                            $q->where('course_code',$request->course);
                        }])->first();

                        $funded_id = $completion->student_course[0]->id;
                        // return $funded_id;
                        $funded_course = FundedStudentCourse::where('id',$funded_id)->first();
                        $funded_course->status_id = 7;
                        $funded_course->update();
                    }   

                    if ($latestCompletion == null && $unit['dates']['end'] != null) {
                        // dump('hah');
                        $latestCompletion = $unit['dates']['end'];
                    } elseif ($latestCompletion != null && $latestCompletion < $unit['dates']['end']) {
                        // dump('wew');
                        $latestCompletion = $unit['dates']['end'];
                    }

                    if ($unit['dates']['start'] !== null && $unit['dates']['end'] !== null) {
                        $completion_details = CourseCompletionDetail::where('student_completion_id', $request->course_completion['id'])
                            ->where('course_unit_code', $unit['code'])
                            ->update([
                                'actual_start' => ($unit['dates']['start'] != null) ? Carbon::createFromFormat('Y-m-d', $unit['dates']['start'])->format('Y-m-d') : null,
                                'actual_end' => ($unit['dates']['end'] != null) ? Carbon::createFromFormat('Y-m-d', $unit['dates']['end'])->format('Y-m-d') : null,
                                'completion_status_id' => $unit['status']
                            ]);
                        if ($completion_details == 0) {
                            if ($unit['dates']['start'] !== '') {
                                $completion_details = new CourseCompletionDetail;
                                $completion_details->fill([
                                    'course_unit_code' => $unit['code'],
                                    'actual_start' => isset($unit['dates']['start']) ? Carbon::createFromFormat('Y-m-d', $unit['dates']['start'])->format('Y-m-d') : null,
                                    'actual_end' => isset($unit['dates']['end']) ? Carbon::createFromFormat('Y-m-d', $unit['dates']['end'])->format('Y-m-d') : null,
                                    'completion_status_id' => $unit['status']
                                ]);
                                $completion_details->completion()->associate($request->course_completion['id']);
                                $completion_details->save();
                            }
                        }
                    }
                }
            
                if ($validateCompletion == 1) {

                    $completion = CourseCompletion::find($request->course_completion['id']);
                    $completion->update([
                        'completion_status_id' => 3,
                        'completion_date' => Carbon::createFromFormat('Y-m-d', $latestCompletion)->format('Y-m-d')
                    ]);
                } else {
                    $completion = CourseCompletion::find($request->course_completion['id']);
                    $completion->update([
                        'completion_status_id' => 5,
                        'completion_date' => null
                    ]);
                }
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Updated Successfully.']);
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
                return response()->json(['status' => 'error', 'messsage' => $th->getMessage()]);
            }
        }
    }
    public function prospectus($course)
    {
        $prospectus = CourseProspectus::where('course_code', $course)->first();
        foreach ($prospectus->unit_selected as $selected) {
            $units[] = [
                'code' => $selected->code,
                'description' => $selected->description,
                'unit_type' => $selected->unit_type,
                'dates' => '',
                'status' => ''
            ];
        }
        return $units;
    }

    public function update_units(Request $request, CertificateIssuanceDetail $unit)
    {

        try {
            // dd($unit);
            DB::beginTransaction();
            $_units = $request->units;
            $cert_units = [];
            foreach ($_units as $key => $_unit) {
                if (in_array($_unit['status'], [3, 4, 6])) {
                    $cert_units[] = $_unit;
                }
            }
            // dump($unit);
            // dd($cert_units);

            $unit->units = $cert_units;
            $unit->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Added Successfully.']);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

        // dump($request->all());
        // dd($unit);
    }
    public function saveExtraUnits(Request $request)
    {
        // dd($request->all());

        try {
            DB::beginTransaction();
            $fundedExtra = FundedStudentExtraUnits::where('id', $request->id)->first();
            $data = [];
            foreach ($request->units as $unit) {
                // dd($unit['start_date']);
                $start_date = '';
                $end_date = '';
                if ($unit['start_date'] != '') {
                    $start_date = Carbon::parse($unit['start_date'])->format('Y-m-d');
                }
                if ($unit['end_date'] != '') {
                    $end_date = Carbon::parse($unit['end_date'])->format('Y-m-d');
                }
                $data[] = [
                    'id' => $unit['id'],
                    'code' => $unit['code'],
                    'description' => $unit['description'],
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'status' => $unit['status'],
                ];
            }
            $fundedExtra->update(
                [
                    'extra_units' => json_encode($data)
                ]
            );
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Updated Successfully.']);
            //code...
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
        // dd($request->all());
    }

    public function destroy_completion_details($id, $code)
    {
        $detail = CourseCompletionDetail::where('student_completion_id', $id)->where('course_unit_code', $code)->get();
        if ($detail->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => $code . ' does not exists on completion details']);
        } else {
            $detail[0]->delete();
            return response()->json(['status' => 'success']);
        }
    }

    public function confirmation_report($student_id = 'SIA05744', $course_code)
    {
        $student = Student::with([
            'contact_detail',
            'funded_detail',
            'funded_course.course_completion.completion',
            'funded_course.course_completion.completion.certificate',
            'funded_course.course_completion.completion.course',
            'funded_course.course_completion.completion.details.unit',
            'funded_course.course_completion.completion.details.status',
            'funded_course.course',
            'funded_course.detail.fund_national',
            'offer_letter',
            'party.person'
        ])->where('student_id', $student_id)->whereHas('completion', function ($q) use ($course_code) {
            $q->where('course_code', $course_code);
        })->first();

        $getCourse = Course::where('code', $course_code)->first();

        if ($getCourse) {
            $getCourse = $getCourse;
        } else {
            $getCourse = '@@@@';
        }
        $course = [];


        dd($student);
        if (isset($student->completion[0])) {
            $sc = null;
            foreach ($student->completion as $k => $v) {
                if ($v->course_code == $course_code) {
                    $sc = $v;
                }
            }
            $student->completion[0] = $sc;

            // dd($student);

            $fc = null;
            if (isset($student->funded_course[0])) {
                foreach ($student->funded_course as $k => $v) {
                    if ($v->course_code == $course_code) {
                        $fc = $v;
                    }
                }
                $student->funded_course[0] = $fc;
            }
        }

        $com_setting = TrainingOrganisation::first();
        if ($com_setting->training_organisation_id != '') {
            $rto_code = $com_setting->training_organisation_id;
        } else {
            $rto_code = '';
        }

        foreach ($student->funded_course as $k => $v) {
            if ($v->course_code == $course_code) {
                // dump($v->course_completion);
                $course = $v;
                // dd($v->course_completion->completion);
            }
        }




        return \PDF::loadView('students.confirmation_report.confirmation-report', compact('student', 'rto_code', 'course', 'getCourse'))->setPaper('A4', 'landscape')->stream($student->party->name . ' - ' . $course_code . ' Confirmation Report.pdf');
    }
}
