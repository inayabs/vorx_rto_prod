<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentNote;
use App\Models\Student\Student;
use DB;
use Carbon\Carbon;

class StudentNoteController extends Controller
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
        $now = Carbon::now()->setTimezone('Australia/Brisbane')->format('Y-m-d');    
        try {
            // start db transaction
            DB::beginTransaction();
            $deal_type = null;
            if ($request->edit == true) {

                $note = StudentNote::find($request->id);
                $note->remarks = $request->remarks;
                $note->date_notes = isset($request->date_notes) ? Carbon::parse($request->date_notes)->timezone('Australia/Melbourne')->format('Y-m-d') : $now;
                $note->update();

            } else {
                $note = new StudentNote;
                // $student = Student::where('student_id', $request->student_id)->first();
                $note->remarks = $request->remarks;
                $note->date_notes = isset($request->date_notes) ? Carbon::parse($request->date_notes)->timezone('Australia/Melbourne')->format('Y-m-d') : $now;
                $note->user()->associate(\Auth::user());
                $note->student()->associate($request->student_id);
                $note->save();
            }

            DB::commit();

            return ['status' => 'success','data'=> $note->load('user.party')];
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();

            // return to previous page with errors
            return json_encode(['message' => $e->getMessage(), 'status' => 'error']);
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
        //
        // dump($id);
        $notes = StudentNote::with(['student', 'user.party'])->where('student_id', $id)->orderBy('date_notes', 'desc')->get();
        // dump($notes);
        return $notes;
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
        try {
            // start db transaction
            DB::beginTransaction();

            $note = StudentNote::find($id);
            $note->delete();

            DB::commit();

            return ['status' => 'success', 'data'=> $note->load('user.party')];
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();

            // return to previous page with errors
            return json_encode(['message' => $e->getMessage(), 'status' => 'error']);
        }
    }
}
