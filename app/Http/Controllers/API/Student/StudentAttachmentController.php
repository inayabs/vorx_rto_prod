<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Models\PaymentAttachment;
use App\Models\StudentAttachment;
use App\Models\Student\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use File;
use Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class StudentAttachmentController extends Controller
{

    public function saveAttachment(Request $request, $student_id)
    {

        $path = '';
        $file = null;

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            $path = $file->store('public/student/new/attachments/' . $student_id . '/');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());
            $ext = $file->guessClientExtension();
            if($file->getMimeType() == 'application/x-rar'){
                $ext = 'rar';
            }

            $studentAttachment = new StudentAttachment([
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $ext,
                '_input'       => 'attachment',
            ]);

            // associated user
            $studentAttachment->user()->associate(\Auth::user());
            $studentAttachment->student()->associate($student_id);
            $studentAttachment->save();
            $studentAttachment->path_id = $student_id;
            $studentAttachment->update();

            DB::commit();

            $file_path = '/storage/student/new/attachments/' . $studentAttachment->trainer_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;

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
            return response(['status' => 'success', 'message'=>'Attachment uploaded successfully.', 'file' => $file], 200)->header('Content-Type', 'text/json');
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
        $file = StudentAttachment::find($id);
        $path_old = null;
        $path_new = null;
        $path = null;
        // file path
        // if ($file->path_id == $file->student_id) {
            $path_new = storage_path() . '/app/public/student/new/attachments/' . $file->student_id . '/' . $file->hash_name . '.' . $file->ext;
        // } else {
            $path_old = storage_path() . '/app/public/student/old/attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;
        // }

        $path = file_exists($path_old) ? $path_old : $path_new;

        // raw file contents
        $fileContent = File::get($path);

        if(in_array($file->ext, ['zip', 'rar'])) {
            $filetype=filetype($path);
            // $filename=basename($path);
            header ("Content-Type: ".$filetype);
            header ("Content-Length: ".filesize($path));
            header ("Content-Disposition: attachment; filename=".$file->name);
            readfile($path);
        }else{
            return response($fileContent)->header('Content-Type', $file->mime_type);
        }

    }
    public function fetchAllAttachment($student_id)
    {

        $studentAttachment = StudentAttachment::where('student_id', $student_id)->get();

        // dd($trainerAttachments->toArray());

        $attchments = [];
        foreach ($studentAttachment as $key => $value) { 
            // dd($value->updated_at->timestamp);
            $file_path = '';
            $path_old = null;
            $path_new = null;

            // if ($value->path_id == $value->student_id) {
                $path_new = '/storage/student/new/attachments/' . $value->student_id . '/' . $value->hash_name . '.' . $value->ext;
            // } else {
                $path_old = '/storage/student/old/attachments/' . $value->path_id . '/' . $value->hash_name . '.' . $value->ext;
            // }

            $file_path = file_exists($path_old) ? $path_old : $path_new;

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

        if(\Auth::user()->roles->first()->name != 'Staff'){
            $studentAttachment = StudentAttachment::where('id', $id)->first();
    
            if ($studentAttachment->path_id == $studentAttachment->student_id) {
                $file_path = '/storage/student/new/attachments/' . $studentAttachment->student_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;
            } else {
                $file_path = '/storage/student/old/attachments/' . $studentAttachment->path_id . '/' . $studentAttachment->hash_name . '.' . $studentAttachment->ext;
            }
            
            Storage::delete($file_path);
    
            if($studentAttachment){
                $studentAttachment->delete();
    
                return ['status' => 'success' ,'message'=>'File deleted successfully.'];
    
            }else{
                return ['status' => 'error', 'message'=>'File not deleted. Something went wrong...'];
            }
        }else{
            return ['status' => 'Access Denied'];
        }


        // dd($studentAttachment);
    }
    public function rename(Request $request, $id){
        try {
            DB::beginTransaction();

            $studentAttachment = StudentAttachment::where('id', $id)->first();
            $studentAttachment->name = $request->rename;
            $studentAttachment->update();

            DB::commit();
            return json_encode(['status' => 'updated']);
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            // Storage::delete($path);
            dd($e->getMessage());
        }
    }

    public function previewPayment($hash)
    {
        $file = PaymentAttachment::where('hash_name',$hash)->first();
        
        $path_old = null;
        $path_new = null;
        $path = null;
        // file path
        // if ($file->path_id == $file->student_id) {
            $path_new = storage_path() . '/app/public/student/new/attachments/' . $file->path_id . '/payments/' . $file->hash_name . '.' . $file->ext;
        // } else {
            $path_old = storage_path() . '/app/public/student/old/attachments/' . $file->path_id . '/payments/' . $file->hash_name . '.' . $file->ext;
        // }

        $path = file_exists($path_old) ? $path_old : $path_new;
        // raw file contents
        $fileContent = File::get($path);

        if(in_array($file->ext, ['zip', 'rar'])) {
            $filetype=filetype($path);
            // $filename=basename($path);
            header ("Content-Type: ".$filetype);
            header ("Content-Length: ".filesize($path));
            header ("Content-Disposition: attachment; filename=".$file->name);
            readfile($path);
        }else{
            return response($fileContent)->header('Content-Type', $file->mime_type);
        }

    }
}