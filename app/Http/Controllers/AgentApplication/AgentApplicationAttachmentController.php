<?php

namespace App\Http\Controllers\AgentApplication;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\AgentApplicationAttachment;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use Storage;
use Carbon\Carbon;

class AgentApplicationAttachmentController extends Controller
{

    public function documents_upload(Request $request)
    {

        // dd($request->process_id);

        $path = '';
        $file = null;
        // $date_uploaded = Carbon::now()->format('Y-m');
        $agent_application = AgentApplication::where('process_id', $request->process_id)->first();

        

        try {
            DB::beginTransaction();
            
            $file = $request->file('files');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());
            $documents = new AgentApplicationAttachment([
                'process_id' => $request->process_id,
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'    => 'attachment',
            ]);

            

            $path = $file->store('public/agent/' . $documents->process_id . '/');

            // associated user
            $documents->user()->associate(\Auth::user());

            // associated agent pack
            $documents->agent_application()->associate($agent_application);
            
            // dd($documents);
            
            // $documents->agent()->associate($agent);
            $documents->save();
            // $documents->path_id = $agent->id;
            // $documents->update();
            // $attID = $documents->id;
            // dd('sample');

            DB::commit();

            $file_path = '/storage/agent/' . $documents->process_id . '/' . $documents->hash_name . '.' . $documents->ext;

            $file = [
                'id' => $documents->id,
                'lastModified' => $documents->updated_at->timestamp,
                'lastModifiedDate' => $documents->updated_at,
                'name' => $documents->name,
                'size' => $documents->size,
                'file_path' => $file_path,
                'file_ext' => $documents->ext,
                'file_type' => explode('/', $documents->mime_type)[0],
            ];

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            // dd('test sample');
            dd($e->getMessage());
        }


        return $request->all();
    }

    public function documents_fetch($process_id)
    {
        $documentsUploaded = AgentApplicationAttachment::where('process_id', $process_id)->get();

        // dd($agentAttachments->toArray());

        $documents = [];
        foreach ($documentsUploaded as $key => $value) {

            // dd($value->updated_at->timestamp);
            $file_path = '/storage/agent/' . $value->process_id . '/' . $value->hash_name . '.' . $value->ext;

            array_push($documents, [
                'id' => $value->id,
                'process_id' => $value->process_id,
                'lastModified' => $value->updated_at->timestamp,
                'lastModifiedDate' => $value->updated_at,
                'name' => $value->name,
                'size' => $value->size,
                'file_path' => $file_path,
                'file_ext' => $value->ext,
                'file_type' => explode('/', $value->mime_type)[0],
            ]);
        }

        return $documents;
    }

    public function documents_delete($id)
    {
        // dd('test');
        $documentsUploaded = AgentApplicationAttachment::find($id);
        $path = '/public/agent/' . $documentsUploaded->process_id . '/' . $documentsUploaded->hash_name . '.' . $documentsUploaded->ext;
        
        try {
            DB::beginTransaction();
            $documentsUploaded->delete();
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

    public function documents_preview($id)
    {
        // file model instance
        $file = AgentApplicationAttachment::find($id);

        $path = storage_path() . '/app/public/agent/' . $file->process_id . '/' . $file->hash_name . '.' . $file->ext;

        // raw file contents
        $fileContent = File::get($path);

        return response($fileContent)->header('Content-Type', $file->mime_type);
    }

    public function documents_update($uid) {
        $findDocuments = AgentApplicationAttachment::where('u_id', $uid)->first();
        $findRelatedDocuments = AgentApplicationAttachment::where('u_id', $uid)->select(['id', 'note', 'is_current'])->get();

        \JavaScript::put([
            'related_documents' => $findDocuments,
            'find_related_documents' => $findRelatedDocuments,
        ]);
        return view('documents.edit');
    }

    public function rename(Request $request, $id){
        try {
            DB::beginTransaction();

            $studentAttachment = AgentApplicationAttachment::where('id', $id)->first();
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
    }
}
