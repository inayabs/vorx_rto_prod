<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAissAttachment;
use App\Models\Student\Student;
use Illuminate\Http\Request;
use DB;
use File;
use Storage;

class StudentAissAttachmentController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function upload(Request $request, $student_id)
    {

        $path = '';
        $file = null;

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            $path = $file->store('public/student/new/aiss-attachments/' . $student_id . '/');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());

            $studentAttachment = new StudentAissAttachment([
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'       => 'attachment',
            ]);
            
            // associated user
            $studentAttachment->user()->associate(\Auth::user());
            $studentAttachment->student()->associate($student_id);
            $studentAttachment->save();
            $studentAttachment->path_id = $student_id;
            $studentAttachment->update();

            DB::commit();

            $file_path = '/storage/student/new/aiss-attachments/' . $studentAttachment->trainer_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;

            $file = [
                'id' => $studentAttachment->id,
                'lastModified' => $studentAttachment->updated_at->timestamp,
                'lastModifiedDate' => $studentAttachment->updated_at,
                'name' => $studentAttachment->name,
                'size' => $studentAttachment->size,
                'file_path' => $file_path,
                'file_ext' => $studentAttachment->ext,
                'file_type' => explode('/', $studentAttachment->mime_type)[0],
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
        $file = StudentAissAttachment::find($id);

        // file path
        if ($file->path_id == $file->student_id) {
            $path = storage_path() . '/app/public/student/new/aiss-attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;
        } else {
            $path = storage_path() . '/app/public/student/old/aiss-attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;
        }

        // raw file contents
        $fileContent = File::get($path);

        return response($fileContent)->header('Content-Type', $file->mime_type);
    }
    public function fetch($student_id)
    {
        $studentAttachment = StudentAissAttachment::where('student_id', $student_id)->get();

        // dd($trainerAttachments->toArray());

        $attchments = [];
        foreach ($studentAttachment as $key => $value) {
            // dd($value->updated_at->timestamp);
            $file_path = '';

            if ($value->path_id == $value->student_id) {
                $file_path = '/storage/student/new/aiss-attachments/' . $value->student_id . '/' . $value->hash_name . '.' . $value->ext;
            } else {
                $file_path = '/storage/student/old/aiss-attachments/' . $value->path_id . '/' . $value->hash_name . '.' . $value->ext;
            }

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
    public function destroy($id)
    {
        $studentAttachment = StudentAissAttachment::where('id', $id)->first();

        if ($studentAttachment->path_id == $studentAttachment->student_id) {
            $file_path = '/storage/student/new/aiss-attachments/' . $studentAttachment->student_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;
        } else {
            $file_path = '/storage/student/old/aiss-attachments/' . $studentAttachment->path_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;
        }
        
        Storage::delete($file_path);

        if($studentAttachment){
            $studentAttachment->delete();

            return ['status' => 'success'];

        }else{
            return ['status' => 'error'];
        }


        // dd($studentAttachment);
    }

    public function rename(Request $request, $id){
        try {
            DB::beginTransaction();

            $studentAttachment = StudentAissAttachment::where('id', $id)->first();
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
}
