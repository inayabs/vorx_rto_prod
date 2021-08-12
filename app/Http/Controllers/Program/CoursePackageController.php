<?php

namespace App\Http\Controllers\Program;

use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\AvtStateIdentifier;
use Illuminate\Http\Request;

use App\Models\CoursePackage;
use App\Models\CoursePackageDetail;
use App\Models\CourseMatrix;
use App\Models\TrainingDeliveryLoc;
use Carbon\Carbon;

class CoursePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dlvr_location = TrainingDeliveryLoc::select('id', 'train_org_dlvr_loc_name')->orderBy('train_org_dlvr_loc_name', 'asc')->get();
        \JavaScript::put([
            'dlvr_location' => $dlvr_location,
        ]);

        return view('program.course-package.index');
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
    {   //
        $this->validate($request, [
            'name' => 'required',
            'shore_type' => 'required',
            'location' => 'required',
        ]);

        $package = new CoursePackage();
        $data = [
            'date_created' => Carbon::parse($request->date_created)->format('Y-m-d'),
            'shore_type' => $request->shore_type,
            'location' => $request->location,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active ? 1 : 0,
        ];
        $package->fill($data);
        $package->user()->associate(\Auth::user());
        $package->save();
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
        $coursePackage = CoursePackage::find($id);
        $packageDetails = CoursePackageDetail::where('course_package_id', $coursePackage->id)->get();
        $courseMatrix = CourseMatrix::with('detail')->select(['id', 'course_code', 'location'])->get();
        $dlvr_location = TrainingDeliveryLoc::select('id', 'train_org_dlvr_loc_name')->orderBy('train_org_dlvr_loc_name', 'asc')->get();
        $state = AvtStateIdentifier::all();
        // dd($courseMatrix);
        \JavaScript::put([
            'course_package' => $coursePackage,
            'package_details' => $packageDetails,
            'course_matrix' => $courseMatrix,
            'dlvr_location' => $dlvr_location,
            'state' => $state,
        ]);

        return view('program.course-package.show');
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
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'shore_type' => 'required',
            'location' => 'required',
            'delivery_location_id' => 'required',
        ]);

        $package = CoursePackage::find($id);
        $package->date_created = Carbon::parse($request->date_created)->format('Y-m-d');
        $package->shore_type = $request->shore_type;
        $package->location = $request->location;
        $package->delivery_location_id = $request->delivery_location_id;
        $package->name = $request->name;
        $package->description = $request->description;
        $package->is_active = $request->is_active ? 1 : 0;
        $package->update();
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
        $getCoursePackage = CoursePackage::find($id);
        $getCoursePackage->delete();
    }

    public function course_package_list()
    {
        if (\Auth::user()->hasRole('Demo')) {
            return CoursePackage::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();
        } else {
            return CoursePackage::orderBy('id', 'DESC')->get();
        }
    }

    public function course_package_store_update(Request $request)
    {

        $package_id = $request->course_package_id;
        if (!isset($request->is_update)) {
            $this->validate($request, [
                // 'course_start_date' => 'required',
                // 'course_end_date' => 'required',
                'course_matrix_id' => [
                    'required',
                    Rule::unique('course_package_details')->where(function ($query) use ($package_id) {
                        $query->where('course_package_id', $package_id);
                    })
                ],
                'order' => [
                    'required',
                    Rule::unique('course_package_details')->where(function ($query) use ($package_id) {
                        $query->where('course_package_id', $package_id);
                    })
                ]
            ]);
        } else {
            $this->validate($request, [
                // 'course_matrix_id' => 'required',
                // 'course_start_date' => 'required',
                'course_end_date' => 'required',
                'order' => [
                    'required',
                ]
            ]);
        }

        CoursePackageDetail::updateOrCreate(
            [
                'course_matrix_id' => $request->course_matrix_id,
            ],
            [
                'course_package_id' => $package_id,
                'order' => $request->order,
                'course_matrix_id' => $request->course_matrix_id,
                // 'course_start_date' => Carbon::parse($request->course_start_date)->format('Y-m-d'),
                // 'course_end_date' => Carbon::parse($request->course_end_date)->format('Y-m-d'),
                // ''
            ]
        );
    }

    public function course_package_details_destroy($id)
    {
        $getPackageDetails = CoursePackageDetail::find($id);
        $getPackageDetails->delete();
    }
}
