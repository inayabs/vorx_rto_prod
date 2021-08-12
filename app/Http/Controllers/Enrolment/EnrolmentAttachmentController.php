<?php

namespace App\Http\Controllers\Enrolment;

use App\Http\Controllers\Controller;
use App\Models\EnrolmentPack;
use App\Models\EnrolmentPackAttachment;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;
use Storage;
use Carbon\Carbon;

class EnrolmentAttachmentController extends Controller
{

    public function documents_upload(Request $request)
    {

        // dd($request->process_id);

        $path = '';
        $file = null;
        // $date_uploaded = Carbon::now()->format('Y-m');
        $enrolment_pack = EnrolmentPack::where('process_id', $request->process_id)->first();

        

        try {
            DB::beginTransaction();
            
            $file = $request->file('files');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());
            $documents = new EnrolmentPackAttachment([
                'process_id' => $request->process_id,
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'    => 'attachment',
            ]);

            

            $path = $file->store('public/enrolment/' . $documents->process_id . '/');

            // associated user
            $documents->user()->associate(\Auth::user());

            // associated enrolment pack
            $documents->enrolment_pack()->associate($enrolment_pack);
            
            // dd($documents);
            
            // $documents->agent()->associate($agent);
            $documents->save();
            // $documents->path_id = $agent->id;
            // $documents->update();
            // $attID = $documents->id;
            // dd('sample');

            DB::commit();

            $file_path = '/storage/enrolment/' . $documents->process_id . '/' . $documents->hash_name . '.' . $documents->ext;

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
        $documentsUploaded = EnrolmentPackAttachment::where('process_id', $process_id)->get();

        // dd($agentAttachments->toArray());

        $documents = [];
        foreach ($documentsUploaded as $key => $value) {

            // dd($value->updated_at->timestamp);
            $file_path = '/storage/enrolment/' . $value->process_id . '/' . $value->hash_name . '.' . $value->ext;

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
        $documentsUploaded = EnrolmentPackAttachment::find($id);
        $path = '/public/enrolment/' . $documentsUploaded->process_id . '/' . $documentsUploaded->hash_name . '.' . $documentsUploaded->ext;
        
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
        $file = EnrolmentPackAttachment::find($id);

        $path = storage_path() . '/app/public/enrolment/' . $file->process_id . '/' . $file->hash_name . '.' . $file->ext;

        // raw file contents
        $fileContent = File::get($path);

        return response($fileContent)->header('Content-Type', $file->mime_type);
    }

    public function documents_update($uid) {
        $findDocuments = EnrolmentPackAttachment::where('u_id', $uid)->first();
        $findRelatedDocuments = EnrolmentPackAttachment::where('u_id', $uid)->select(['id', 'note', 'is_current'])->get();

        \JavaScript::put([
            'related_documents' => $findDocuments,
            'find_related_documents' => $findRelatedDocuments,
        ]);
        return view('documents.edit');
    }

    public function rename(Request $request, $id){
        try {
            DB::beginTransaction();

            $studentAttachment = EnrolmentPackAttachment::where('id', $id)->first();
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
