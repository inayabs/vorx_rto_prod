<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnrolmentPack;
use App\Models\Student\Student;

class AccessCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('access-code.index');
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
        $ep = EnrolmentPack::find($id);
        $ep->delete();
    }

    public function access_code_list(Request $request){


        if ($request->sort) {
            $sortBy = $request->sort;
            $dir = $request->direction;
        }else{
            $sortBy = 'id';
            $dir = 'desc';
        }

        if (isset($request->search)) {
            $search = $request->search;
            $ep = EnrolmentPack::where('student_name', null)->where('enrolment_form', null)->where('lln', null)->where('status', 'lln_test')->where('process_id', 'like', '%' . $search . '%')->orderBy($sortBy, $dir)->paginate($request->limit);
            return $ep;
        } else {
            $ep = EnrolmentPack::where('student_name', null)->where('enrolment_form', null)->where('lln', null)->where('status', 'lln_test')->orderBy($sortBy, $dir)->paginate($request->limit);
            return $ep;
        }
    }
    public function storeCode(){

        $save = new EnrolmentPack;
        $save->process_id = $this->codeNumber();
        $save->status = 'lln_test';
        $save->save();

        return ['status' => 'success', 'process' => $save->process_id];
    }

    public function codeNumber()
    {
        $number = mt_rand(000000001, 999999999);

        $number = sprintf("%09d", $number);

        if (count($this->codeNumberExist($number))) {
            return $this->codeNumber();
        }

        return $number;
    }

    public function codeNumberExist($number)
    {
        return EnrolmentPack::where('process_id', $number)->get();
    }
}
