<?php

namespace App\Http\Controllers\Usi;

use App\Http\Controllers\Controller;
use App\Models\AvtStateIdentifier;
use App\Models\FundedStudentDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware(['role:' . config('global.roles')]);
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
        $state = AvtStateIdentifier::whereNotIn('id', [9, 10, 11])->orderBy('state_key')->pluck('state_key');
        \JavaScript::put([
            'state' => $state,
        ]);
        return view('usi.verify');
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

    public function verify()
    {
        return view('usi.verify');
    }
    public function verify_store($student, $usi)
    {
        // return view('usi.verify');
        $sd = FundedStudentDetails::where('student_id', $student)->first();
        $sd->verified = true;
        $sd->unique_student_id = $usi;
        $sd->verified_by = \Auth::user()->id;
        $sd->verified_date = Carbon::now();

        $sd->update();
    }

    public function updatePersonalDetails()
    {
        $state = AvtStateIdentifier::whereNotIn('id', [9, 10, 11])->orderBy('state_key')->pluck('state_key');
        \JavaScript::put([
            'state' => $state,
        ]);
        return view('usi.verify');
    }

    public function updateContactDetails()
    {
        $state = AvtStateIdentifier::whereNotIn('id', [9, 10, 11])->orderBy('state_key')->pluck('state_key');
        \JavaScript::put([
            'state' => $state,
        ]);
        return view('usi.verify');
    }

    public function locate()
    {
        $state = AvtStateIdentifier::whereNotIn('id', [9, 10, 11])->orderBy('state_key')->pluck('state_key');
        \JavaScript::put([
            'state' => $state,
        ]);
        return view('usi.verify');
    }
}
