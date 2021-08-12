<?php

namespace App\Http\Controllers\API\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentAttachment;
use App\Models\AgentDetail;
use App\Models\AvtClientIndigenousStatus;
use App\Models\AvtCountryIdentifier;
use App\Models\AvtDisabilityTypes;
use App\Models\AvtHighestSchlLvlCompleted;
use App\Models\AvtLabourForceStatus;
use App\Models\AvtLangIdentifier;
use App\Models\AvtPostcode;
use App\Models\AvtPriorEducationAchievement;
use App\Models\AvtStateIdentifier;
use App\Models\VisaStatus;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;
use Storage;
use App\Models\AgentTempUpdate;

class AgentController extends Controller
{
    public function profile()
    {
        try {
            $user = Auth::user();
            return $user->agent_details;
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    public function update(Request $request, $agent)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            AgentTempUpdate::updateOrCreate([
                'student_id' => '',
                'module' => 'agent_details',
                'agent_id'=> Auth::user()->id
            ],['inputs' => $data]);
            DB::commit();
            return response(['status'=>'success','message'=> 'Changes will be verified by the admin'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function fetchAllAttachment()
    {
        if( Auth::user()->agent_details != null){
            
            $agentAttachments = Auth::user()->agent_details->attachments;

            // dd($agentAttachments->toArray());
    
            $attchments = [];
            foreach ($agentAttachments as $key => $value) {
                // dd($value->updated_at->timestamp);
                $file_path = '';
    
                if ($value->path_id == $value->agent_id) {
                    $file_path = 'storage/agent/new/attachments/' . $value->agent_id . '/' . $value->hash_name . '.' . $value->ext;
                } else {
                    $file_path = 'storage/agent/attachments/' . $value->path_id . '/' . $value->hash_name . '.' . $value->ext;
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
        }else{
            return response(['status'=>'error','message'=>'not found'],404);
        }
    }

    public function preview($id)
    {
        $file = AgentAttachment::find($id);
        $path_old = null;
        $path_new = null;
        $path = null;
        // file path
        // if ($file->path_id == $file->agent_id) {
            $path_new = storage_path() . '/app/public/agent/new/attachments/' . $file->agent_id . '/' . $file->hash_name . '.' . $file->ext;
        // } else {
            $path_old = storage_path() . '/app/public/agent/old/attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;
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

    public function saveAttachment(Request $request)
    {

        if( Auth::user()->agent_details != null){
            $agent = Auth::user()->agent_details;

            $path = '';
            $file = null;
    
            try {
                DB::beginTransaction();
    
                $file = $request->file('files');
    
                $path = $file->store('public/agent/new/attachments/' . $agent->id . '/');
                $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());
    
                $agentAttachment = new AgentAttachment([
                    'name'      => $file->getClientOriginalName(),
                    'hash_name' => $hashFileName,
                    'size'      => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'ext'       => $file->guessClientExtension(),
                    '_input'       => 'attachment',
                ]);
    
                // associated user
                $agentAttachment->user()->associate(\Auth::user());
                $agentAttachment->agent()->associate($agent);
                $agentAttachment->save();
                $agentAttachment->path_id = $agent->id;
                $agentAttachment->update();
                $attID = $agentAttachment->id;
    
                DB::commit();
    
                $file_path = 'storage/agent/new/attachments/' . $agentAttachment->agent_id . '/' . $agentAttachment->hash_name . '.' . $agentAttachment->ext;
    
                $file = [
                    'id' => $agentAttachment->id,
                    'lastModified' => $agentAttachment->updated_at->timestamp,
                    'lastModifiedDate' => $agentAttachment->updated_at,
                    'name' => $agentAttachment->name,
                    'size' => $agentAttachment->size,
                    'file_path' => $file_path,
                    'file_ext' => $agentAttachment->ext,
                    'file_type' => explode('/', $agentAttachment->mime_type)[0],
                ];
    
                // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
                return response(['status' => 'success','message'=>'Attachment uploaded successfully.', 'file' => $file], 200)->header('Content-Type', 'text/json');
                // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
                // remove file
                Storage::delete($path);
                dd($e->getMessage());
            }
    
    
            return $request->all();

        }else{
            return response(['status'=>'error','message'=>'not found'],404);
        }
    }

    public function destroy($id)
    {
        $attachment = AgentAttachment::where('id', $id)->first();

        if ($attachment->path_id == $attachment->agent_id) {
            $file_path = 'storage/agent/new/attachments/' . $attachment->agent_id . '/' . $attachment->hash_name . '.' . $attachment->ext;
        } else {
            $file_path = 'storage/agent/old/attachments/' . $attachment->path_id . '/' . $attachment->hash_name . '.' . $attachment->ext;
        }
        
        Storage::delete($file_path);

        if($attachment){
            $attachment->delete();

            return ['status' => 'success','message'=>'File deleted successfully.'];

        }else{
            return ['status' => 'error', 'message'=>'File not deleted. Something went wrong...'];
        }
    }

    public function rename(Request $request, $id){

        try {
            DB::beginTransaction();

            $agentAttachment = AgentAttachment::where('id', $id)->first();
            $agentAttachment->name = $request->rename;
            $agentAttachment->update();

            DB::commit();
            return json_encode(['status' => 'updated']);
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            // Storage::delete($path);
            dd($e->getMessage());
        }
    }

    public function defaults(){
        $defaults = [];
        
        $country =  AvtCountryIdentifier::orderBy('full_name', 'asc')->select('full_name as label','identifier as value')->get();
        $disabilities = AvtDisabilityTypes::orderBy('description','asc')->select('description as label','value')->get();
        $achievements = AvtPriorEducationAchievement::orderBy('description','asc')->select('description as label','value')->get();
        $language = AvtLangIdentifier::orderBy('description','asc')->select('description as label','value')->get();
        $location = AvtStateIdentifier::orderBy('state_name','asc')->select('state_name as label','state_key as value')->get();
        $indigenous = AvtClientIndigenousStatus::orderBy('description','asc')->select('description as label','value')->get();
        $labour_force_status = AvtLabourForceStatus::orderBy('status','asc')->select('status as label','value')->get();
        $schl_lvl_completed = AvtHighestSchlLvlCompleted::orderBy('description','asc')->select('description as label','value')->get();
        $postcode = AvtPostcode::select(DB::raw("CONCAT(postcode ,' - ',suburb,', ',state) AS label"), 'id as value')->get();
        $visa_type = VisaStatus::select(DB::raw('id as value, IF(id=1, "Not Applicable", concat(type, " - ", visa)) AS label'))->orderBy('value', 'asc')->get();

        $courses = Course::orderBy('name','asc')->select(DB::raw("CONCAT(code,' - ',name) AS label"), 'code as value')->get();
        $defaults['country'] = $country;
        $defaults['disabilities'] = $disabilities;
        $defaults['achievements'] = $achievements;
        $defaults['language'] = $language;
        $defaults['location'] = $location;
        $defaults['indigenous'] = $indigenous;
        $defaults['labour_force_status'] = $labour_force_status;
        $defaults['schl_lvl_completed'] = $schl_lvl_completed;
        $defaults['postcode'] = $postcode;
        $defaults['visa_type'] = $visa_type;
        $defaults['courses'] = $courses;
        
        return $defaults;
    }
}
