<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentAttachment;
use App\Models\Student\Party;
use Illuminate\Http\Request;
use DB;
use File;
use Storage;

class AgentAttachmentController extends Controller
{
    public function agent_attachment_upload(Request $request, $agent_id)
    {

        $agent = Agent::find($agent_id);

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
                'size'      => $file->getClientSize(),
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

            $file_path = '/storage/agent/new/attachments/' . $agentAttachment->agent_id . '/' . $agentAttachment->hash_name . '.' . $agentAttachment->ext;

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
            return response(['status' => 'success', 'file' => $file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }


        return $request->all();
    }

    public function agent_attachment_fetch($agent_id)
    {
        $agentAttachments = AgentAttachment::where('agent_id', $agent_id)->get();

        // dd($agentAttachments->toArray());

        $attchments = [];
        foreach ($agentAttachments as $key => $value) {
            // dd($value->updated_at->timestamp);
            $file_path = '';

            if ($value->path_id == $value->agent_id) {
                $file_path = '/storage/agent/new/attachments/' . $value->agent_id . '/' . $value->hash_name . '.' . $value->ext;
            } else {
                $file_path = '/storage/agent/attachments/' . $value->path_id . '/' . $value->hash_name . '.' . $value->ext;
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

    public function agent_attachment_delete($id)
    {
        $attachment = AgentAttachment::where('id', $id)->first();
        // dd($attachment);
        // /storage/agent/new/attachments/186/Ghy2wYxmFvLAbWHb34h68GaqehPCtGrIl1VOhuRD.jpeg
        if($attachment->agent_id != $attchment->path_id){
            $path = '/public/agent/attachments/' . $attachment->agent_id . '/' . $attachment->hash_name . '.' . $attachment->ext;
        }else{
            $path = '/public/agent/new/attachments/' . $attachment->agent_id . '/' . $attachment->hash_name . '.' . $attachment->ext;
        }
        try {
            DB::beginTransaction();
            $attachment->delete();
            // remove file
            $isDeleted = Storage::disk('local')->delete($path);
            if (!$isDeleted) throw new \Exception("File not deleted.");
            DB::commit();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            return $e->getMessage();
        }
    }

    public function agent_attachment_preview(Request $request, $id)
    {
        // file model instance
        $file = AgentAttachment::find($id);

        // file path
        if($file->path_id != $file->agent_id){
            $path = storage_path() . '/app/public/agent/attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;
        }else{
            $path = storage_path() . '/app/public/agent/new/attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;
        }

        // raw file contents
        $fileContent = File::get($path);

        return response($fileContent)->header('Content-Type', $file->mime_type);
       
    }
}
