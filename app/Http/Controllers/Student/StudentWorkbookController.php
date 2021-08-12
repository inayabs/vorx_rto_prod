<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController;
use App\Models\EmailAutomation;
use App\Models\FundedStudentCourse;
use App\Models\StudentCourseWorkbookAttachment;
use App\Models\TrainingOrganisation;
use Illuminate\Http\Request;
use DB;
use File;
use Storage;

class StudentWorkbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // dd($request->file('files'));
        $student_course = FundedStudentCourse::with(['course', 'student.party'])->where('id', $request->student_course_id)->first();

        // dd($student_course);

        $path = '';
        $file = null;
        
        if(!$student_course){
            return ['status' => 'error', 'message' => 'No path found'];
        }

        if(isset($student_course->student_workbook_attachment[0])){
            foreach($student_course->student_workbook_attachment as $v){
                $v->delete();
            }
        }

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            $path = $file->store('public/student/new/workbook/' . $student_course->student_id . '/' . $student_course->course_code . '/');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());

            
            $studentAttachment = new StudentCourseWorkbookAttachment([
                'name'      => $file->getClientOriginalName(),
                'student_id'      => $student_course->student_id,
                'course_code'      => $student_course->course_code,
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'       => 'attachment',
            ]);

            // associated user
            $studentAttachment->user()->associate(\Auth::user());
            $studentAttachment->funded_student_course()->associate($student_course);
            // $studentAttachment->student()->associate($student_course->student_id);
            $studentAttachment->save();
            // $studentAttachment->path_id = $student_id;
            // $studentAttachment->update();

            DB::commit();

            $file_path = '/storage/student/new/workbook/' . $studentAttachment->student_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;

            $file = [
                'id' => $studentAttachment->id,
                'course_code' => $studentAttachment->course_code,
                'lastModified' => $studentAttachment->updated_at->timestamp,
                'lastModifiedDate' => $studentAttachment->updated_at,
                'name' => $studentAttachment->name,
                'size' => $studentAttachment->size,
                'file_path' => $file_path,
                'file_ext' => $studentAttachment->ext,
                'file_type' => explode('/', $studentAttachment->mime_type)[0],
            ];

            $auto = EmailAutomation::where('addOn', 'workbook')->get();
            
            if(isset($auto[0])){
                $this->send_workbook($student_course, $studentAttachment, $auto);
            }

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $studentAttachment], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $student_courses = FundedStudentCourse::with(['course', 'student_workbook_attachment'])->where('student_id', $id)->get();

        $automate = EmailAutomation::where('addOn', 'workbook')->get();

        return [
            'student_courses' => $student_courses,
            'automate' => $automate ? $automate : [],
        ];
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
        $workbook = StudentCourseWorkbookAttachment::where('id', $id)->first();
        if($workbook){
            $workbook->delete();
            return ['status' => 'success', 'message' => 'Workbook deleted successfully!'];
        }else{
            return ['status' => 'error', 'message' => 'No workbook found.'];
        }

    }

    public function send_workbook($student_course, $workbook, $auto = [])
    {
        $send = new EmailSendingController;
        $org = TrainingOrganisation::first();
        $content = 'Uploaded <b>'.$student_course->course_code.' - '.$student_course->course->name.'</b> Workbook for <b>'.$student_course->student->party->name.'.</b> ';
        $email = [];
        $paths = [];
        foreach($auto as $v){
            $email[] = $v->email;
        }
        $paths[] = [
            'path' => storage_path('app/public/student/new/workbook/'.$student_course->student_id.'/'.$student_course->course_code.'/'.$workbook->hash_name.'.'.$workbook->ext), 
            'name' => $workbook->name
        ];

        $s = $send->send_automate('Workbook', $content, [$org->training_organisation_name => $org->email_address], $email, $paths);

        return $s;
    }

    public function download_workbook($id)
    {

        $workbook = StudentCourseWorkbookAttachment::where('id', $id)->first();

        $f = storage_path('app/public/student/new/workbook/'.$workbook->student_id.'/'.$workbook->course_code.'/'.$workbook->hash_name.'.'.$workbook->ext);

        // $f = $path.'/'.$file;

        // dd($f);

        $filetype=filetype($f);
        $filename=basename($f);
        header ("Content-Type: ".$filetype);
        header ("Content-Length: ".filesize($f));
        header ("Content-Disposition: attachment; filename=".$workbook->name);

        readfile($f);
    }
}
