<?php

namespace App\Http\Controllers\Trainers;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\TrainerAttachment;
use App\Models\Student\Party;
use Illuminate\Http\Request;
use DB;
use File;
use Storage;

class TrainerAttachmentController extends Controller
{
    public function trainer_attachment_upload(Request $request, $trainer_id)
    {

        $trainer = Trainer::find($trainer_id);

        $path = '';
        $file = null;

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            $path = $file->store('public/trainer/new/attachments/' . $trainer->id . '/');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());

            $trainerAttachment = new TrainerAttachment([
                'name'      => $file->getClientOriginalName(),
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'       => 'attachment',
            ]);

            // associated user
            $trainerAttachment->user()->associate(\Auth::user());
            $trainerAttachment->trainer()->associate($trainer);
            $trainerAttachment->save();
            $trainerAttachment->path_id = $trainer->id;
            $trainerAttachment->update();
            $attID = $trainerAttachment->id;

            DB::commit();

            $file_path = '/storage/trainer/new/attachments/' . $trainerAttachment->trainer_id . '/' . $trainerAttachment->hash_name . '.' . $trainerAttachment->ext;

            $file = [
                'id' => $trainerAttachment->id,
                'lastModified' => $trainerAttachment->updated_at->timestamp,
                'lastModifiedDate' => $trainerAttachment->updated_at,
                'name' => $trainerAttachment->name,
                'size' => $trainerAttachment->size,
                'file_path' => $file_path,
                'file_ext' => $trainerAttachment->ext,
                'file_type' => explode('/', $trainerAttachment->mime_type)[0],
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

    public function trainer_attachment_fetch($trainer_id)
    {
        $trainerAttachments = TrainerAttachment::where('trainer_id', $trainer_id)->get();

        // dd($trainerAttachments->toArray());

        $attchments = [];
        foreach ($trainerAttachments as $key => $value) {
            // dd($value->updated_at->timestamp);
            $file_path = '';

            if ($value->path_id == $value->trainer_id) {
                $file_path = '/storage/trainer/new/attachments/' . $value->trainer_id . '/' . $value->hash_name . '.' . $value->ext;
            } else {
                $file_path = '/storage/trainer/attachments/' . $value->path_id . '/' . $value->hash_name . '.' . $value->ext;
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

    public function trainer_attachment_delete($id)
    {
        $attachment = TrainerAttachment::where('id', $id)->first();
        // dd($attachment);
        // /storage/trainer/new/attachments/186/Ghy2wYxmFvLAbWHb34h68GaqehPCtGrIl1VOhuRD.jpeg
        $path = '/public/trainer/new/attachments/' . $attachment->trainer_id . '/' . $attachment->hash_name . '.' . $attachment->ext;
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

    public function trainer_attachment_preview(Request $request, $id)
    {
        // file model instance
        $file = TrainerAttachment::find($id);

        // file path
        $path = storage_path() . '/app/public/trainer/new/attachments/' . $file->path_id . '/' . $file->hash_name . '.' . $file->ext;

        // raw file contents
        $fileContent = File::get($path);

        return response($fileContent)->header('Content-Type', $file->mime_type);
       
    }
}
