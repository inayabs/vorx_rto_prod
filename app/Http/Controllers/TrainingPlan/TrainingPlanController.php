<?php

namespace App\Http\Controllers\TrainingPlan;

use App\Http\Controllers\Controller;
use App\Models\CompletionStudentCourse;
use App\Models\Course\Course;
use App\Models\FundedStudentCourse;
use App\Models\OfferLetterCourseDetail;
use App\Models\Student\Student;
use App\Models\TrainingOrganisation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrainingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        //
        $students = Student::all();
        foreach ($students as $key => $student) {
            # code...
            if (!$student->completion->isEmpty()) {
                // if($student->student_id == '01310'){
                    // dd($student->completion);
                    foreach ($student->completion as $key => $completion) {
                        # code...
                        $funded_course = $student->funded_course()->where('course_code', $completion->course_code)->first();
                        // dump($funded_course);
                        $completion_student_course = CompletionStudentCourse::where('completion_id', $completion->id)->first();
                        // dump($completion_student_course);
                        if ($completion_student_course) {
                            // $completion_student_course->fill(['student_type' => $student->student_type_id]);
                            // $completion_student_course->completion()->associate($completion);
                            // $completion_student_course->funded_course()->associate($funded_course);
                            // $completion_student_course->update();
                        } else {
                            if($funded_course) {
                                $completion_student_course = new CompletionStudentCourse;
                                $completion_student_course->fill(['student_type' => $student->student_type_id]);
                                $completion_student_course->completion()->associate($completion);
                                $completion_student_course->funded_course()->associate($funded_course);
                                $completion_student_course->save();
                            }
                        }
                    }
                    // dd('end');
                // }
            }
            // dump($student->funded_course->isEmpty());
            // if (!$student->funded_course->isEmpty()) {
            //     foreach ($student->funded_course as $key => $funded_course) {
            //         # code...
            //     }
            // }
        }
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($student_id, $code)
    {
        //
        // dd($student_id);
        $student = Student::where('student_id', $student_id)->first();
        if ($student->type->type == 'International') {

            $_course = FundedStudentCourse::where('id', $code)->first();
            $course = OfferLetterCourseDetail::where('id', $_course->offer_letter_course_detail_id)->first();
            $cs = CompletionStudentCourse::where('student_course_id', $_course->offer_letter_course_detail_id)->where('student_type', $student->student_type_id)->first();
        } else {
            $course = FundedStudentCourse::where('id', $code)->first();
            if($course->offer_letter_course_detail_id != null){
                $cs = CompletionStudentCourse::where('student_course_id', $course->offer_letter_course_detail_id)->where('student_type', $student->student_type_id)->first();
            }else{
                $cs = CompletionStudentCourse::where('student_course_id', $code)->where('student_type', $student->student_type_id)->first();
            }
            
        }
        // dd($cs);
        $course_details = $course;
        $completion = $student->completion()->where('id', $cs->completion_id)->first();
        $program_details = [];
        foreach ($completion->details->sortBy('order') as $key => $detail) {
            $program_details[] = [
                'code' => $detail->unit->code,
                'name' => $detail->unit->description,
                'start_date' => Carbon::parse($detail->start_date)->format('d/m/Y'),
                'end_date' => Carbon::parse($detail->end_date)->format('d/m/Y'),
                'actual_start' =>  $detail->actual_start != null ? Carbon::parse($detail->actual_start)->format('d/m/Y') : '',
                'actual_end' =>  $detail->actual_end  != null ? Carbon::parse($detail->actual_end)->format('d/m/Y') : '',
                'assestment_method' => $detail->unit->assestment_method,
                'student_status' => $course_details->status->alt,
                'assestment_status' => $detail->status != null ? $detail->status->status_code : '',
            ];
        }
        $collect2 = collect($program_details)->chunk(4);
        $setone = $collect2[0];
        unset($collect2[0]);
        $collect2 = $collect2->flatten(1);
        $collect2 = $collect2->chunk(11);
        $collect2 = $collect2->prepend($setone);
        if ($student->type->type == 'International') {
            // dd($course_details->package->dlvr_location);
            $data = [
                'name' => $student->party->name,
                'phone_no' => $course_details->offer_letter->student_details->phone_mobile,
                'email_ad' => $course_details->offer_letter->student_details->email,
                'status'   => $course_details->status->alt,
                'course_code'   => $course->course_code != '@@@@'  ? $course->course->code : '',
                'course_name'   => $course->course_code != '@@@@' ? $course->course->name : 'Unit Of Competency',
                'delivery_mode' => '',
                'location' => $course_details->location,
                'start_date' =>  Carbon::parse($course_details->start_date)->format('d/m/Y'),
                'end_date' =>  Carbon::parse($course_details->end_date)->format('d/m/Y'),

                'program_details' => $collect2
            ];
        } else {
            $data = [
                'name' => $student->party->name,
                'phone_no' => $student->contact_detail->phone_mobile,
                'email_ad' => $student->contact_detail->email,
                'status'   => $course_details->status->alt,
                'course_code'   => $course->course_code != '@@@@'  ? $course->course->code : '',
                'course_name'   => $course->course_code != '@@@@' ? $course->course->name : 'Unit Of Competency',
                'delivery_mode' => $course_details->course_details->delivery_mode != null ? $course_details->course_details->delivery_mode->description : '',
                'location' => $course_details->location,
                'start_date' =>  Carbon::parse($course_details->start_date)->format('d/m/Y'),
                'end_date' =>  Carbon::parse($course_details->end_date)->format('d/m/Y'),

                'program_details' => $collect2
            ];
        }

        $com_setting = TrainingOrganisation::first();
        if ($com_setting->logo_img != null) {
            $logo = 'storage/config/images/' . $com_setting->logo_img;
        } else {
            $logo = 'images/logo/vorx_logo.png';
        }
        $logo_url = url('/' . $logo);
        return \PDF::loadView('training_plan.index', compact('logo_url', 'com_setting', 'data'))->setPaper('A4', 'landscape')->stream('hehe');
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
}
