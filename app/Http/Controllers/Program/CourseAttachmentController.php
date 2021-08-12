<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use App\Models\Course\Course;
use App\Models\CourseAttachment;
use Illuminate\Http\Request;
use App\Models\TrainingOrganisation;
use App\Models\User;
use Carbon\Carbon;
use DB;
use File;
use Storage;
use Illuminate\Support\Facades\Hash;

class CourseAttachmentController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function upload(Request $request, $course_code)
    {

        $path = '';
        $file = null;

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            $course = Course::where('code', $course_code)->first();

            $path = $file->store('public/course/' . $course_code . '/');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());

            $courseAttachment = new CourseAttachment([
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'       => 'attachment',
            ]);

            // associated user
            $courseAttachment->user()->associate(\Auth::user());
            $courseAttachment->course()->associate($course);
            $courseAttachment->save();
            $courseAttachment->path_id = $course->id;
            $courseAttachment->update();

            DB::commit();

            $file_path = '/storage/course/' . $courseAttachment->course_code . '/' . $courseAttachment->hash_name . '.' . $courseAttachment->ext;

            $file = [
                'id' => $courseAttachment->id,
                'lastModified' => $courseAttachment->updated_at->timestamp,
                'lastModifiedDate' => $courseAttachment->updated_at,
                'name' => $courseAttachment->name,
                'size' => $courseAttachment->size,
                'file_path' => $file_path,
                'file_ext' => $courseAttachment->ext,
                'file_type' => explode('/', $courseAttachment->mime_type)[0],
            ];

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }
    }

    public function preview($id)
    {
        $file = CourseAttachment::find($id);
        $path_old = null;
        $path_new = null;
        $path = null;
        // file path
        // if ($file->path_id == $file->student_id) {
            $path = storage_path() . '/app/public/course/' . $file->course_code . '/' . $file->hash_name . '.' . $file->ext;
        // } else {
            // $path_old = storage_path() . '/app/public/student/old/attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;
        // }

        // $path = file_exists($path_old) ? $path_old : $path_new;

        // raw file contents
        $fileContent = File::get($path);

        return response($fileContent)->header('Content-Type', $file->mime_type);
    }

    public function fetch($course_code)
    {
        $courseAttachment = CourseAttachment::where('course_code', $course_code)->get();

        // dd($trainerAttachments->toArray());

        $attchments = [];
        foreach ($courseAttachment as $key => $value) { 
            // dd($value->updated_at->timestamp);
            $file_path = '';
            $path_old = null;
            $path_new = null;

            // if ($value->path_id == $value->student_id) {
                $file_path = '/storage/course/' . $value->course_code . '/' . $value->hash_name . '.' . $value->ext;
            // } else {
                // $path_old = '/storage/student/old/attachments/' . $value->path_id . '/' . $value->hash_name . '.' . $value->ext;
            // }

            // $file_path = file_exists($path_old) ? $path_old : $path_new;

            array_push($attchments, [
                'id' => $value->id,
                'lastModified' => $value->updated_at->timestamp,
                'lastModifiedDate' => $value->updated_at,
                'name' => $value->name,
                'size' => $value->size,
                'file_path' => $file_path,
                'file_ext' => $value->ext,
                'file_type' => explode('/', $value->mime_type)[0],
            ]);
        }

        return $attchments;
    }

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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $courseAttachment = CourseAttachment::where('id', $id)->first();

        $file_path = '/storage/course/' . $courseAttachment->course_code . '/' . $courseAttachment->hash_name . '.' . $courseAttachment->ext;
        
        
        Storage::delete($file_path);

        if($courseAttachment){
            $courseAttachment->delete();

            return ['status' => 'success'];

        }else{
            return ['status' => 'error'];
        }
    }

    public function rename(Request $request, $id){
        try {
            DB::beginTransaction();

            $courseAttachment = CourseAttachment::where('id', $id)->first();
            $courseAttachment->name = $request->rename;
            $courseAttachment->update();

            DB::commit();
            return json_encode(['status' => 'updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            // remove file
            // Storage::delete($path);
            dd($e->getMessage());
        }
    }



    // STUDENT PORTAL COURSE ATTACHMENTS
    
    public function fetch_course_attachments_single($course_code)
    {
        $attachments = CourseAttachment::where('course_code', $course_code)->get();

        return $attachments;
    }

    public function download($id)
    {
        $att = CourseAttachment::where('id', $id)-> first();
        $path = storage_path('app/public/course/'.$att->course_code.'/'.$att->hash_name.'.'.$att->ext);

        $f = $path;

        // dd($f);

        $filetype=filetype($f);
        // dd($filetype);
        $filename=basename($f);
        header ("Content-Type: ".$filetype);
        header ("Content-Length: ".filesize($f));
        header ("Content-Disposition: attachment; filename=".$filename);

        readfile($f);
    }
}
