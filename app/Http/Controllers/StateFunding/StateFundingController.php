<?php

namespace App\Http\Controllers\StateFunding;

use App\Http\Controllers\Controller;
use App\Models\AvtFundingSourceNational;
use App\Models\AvtFundingSourceState;
use App\Models\AvtFundingType;
use App\Models\AvtSpecificFunding;
use App\Models\AvtStateIdentifier;
use Illuminate\Http\Request;

class StateFundingController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function state_funding()
    {
        $states = AvtStateIdentifier::orderBy('state_name', 'asc')->get();
        return view('state_funding.index', compact('states'));
    }

    public function state_funding_list(Request $request)
    {
        if (isset($request->search)) {
            return AvtFundingSourceState::where('description', 'LIKE', '%' . $request->search . '%')
                ->orWhere('value', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%')
                ->orderBy($request->sort, $request->direction)
                ->paginate($request->limit);
        } else {
            return AvtFundingSourceState::orderBy($request->sort, $request->direction)->paginate($request->limit);
        }
    }

    public function store(Request $request)
    {
        if ($request->id != '') {
            try {
                \DB::beginTransaction();
                $funding_source_state = AvtFundingSourceState::find($request->id);
                $funding_source_state->update([
                    'location' => $request->location['state_key'],
                    'value'    => $request->value,
                    'description' => $request->description
                ]);
                \DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Updated Successfully']);
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        } else {
            try {
                \DB::beginTransaction();
                $state_funding = new AvtFundingSourceState;
                $state_funding->fill([
                    'location' => $request->location['state_key'],
                    'value'    => $request->value,
                    'description' => $request->description
                ]);
                $state_funding->save();
                \DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Updated Successfully']);
            } catch (\Throwable $th) {
                \DB::rollback();
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
                //throw $th;
            }
        }
    }

    public function fundingTypeIndex()
    {
        $states = AvtStateIdentifier::orderBy('state_name', 'asc')->get();
        $fstates = AvtFundingSourceState::orderBy('location', 'asc')->get();
        $fnational = AvtFundingSourceNational::orderBy('description', 'asc')->get();
        $sf = AvtSpecificFunding::orderBy('description', 'asc')->get();
        // dd($fstates);
        return view('state_funding.index', compact('states', 'fstates', 'fnational', 'sf'));
    }


    public function fundingTypeList(Request $request)
    {
        if (isset($request->search)) {
            return AvtFundingType::where('name', 'LIKE', '%' . $request->search . '%')
                ->orderBy($request->sort, $request->direction)
                ->paginate($request->limit);
        } else {
            return AvtFundingType::orderBy($request->sort, $request->direction)->paginate($request->limit);
        }
    }

    public function storeFunding(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'national_funding_code' => 'required'
        ]);

        if ($request->id != '') {
            try {
                \DB::beginTransaction();
                $ft = AvtFundingType::find($request->id);
                $ft->update([
                    'state_key' => $request->state_key['state_key'],
                    'name' => $request->name,
                    'state_funding_code' => $request->state_funding_code['value'],
                    'national_funding_code' => $request->national_funding_code != null ?  $request->national_funding_code['value'] : null,
                    'specific_funding_code' => $request->specific_funding_code != null ? $request->specific_funding_code['identifier'] : null,
                    'traineeship_apprenticeship' => $request->traineeship_apprenticeship ? 1 : 0,
                    'funding_disclosed' => $request->funding_disclosed ? 1 : 0,
                    'vet_student_loan' => $request->vet_student_loan ? 1 : 0,
                    'purchasing_contract' => $request->purchasing_contract,
                    'training_contract' => $request->training_contract,
                    'purchasing_schedule' => $request->purchasing_schedule,
                    'intake_number' => $request->intake_number,
                    'acquitted' => $request->acquitted ? 1 : 0,
                    'funding_removed' => $request->funding_removed ? 1 : 0,
                    'course_site_id' => $request->course_site_id,
                    'booking_id' => $request->booking_id,
                    'avetmiss' => $request->avetmiss ? 1 : 0,
                    'user_id' => \Auth::user()->id
                ]);
                \DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Updated Successfully']);
            } catch (\Throwable $th) {
                \DB::rollback();
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        } else {
            try {
                $ft = new AvtFundingType;
                \DB::beginTransaction();
                $ft->fill([
                    'state_key' => $request->state_key['state_key'],
                    'name' => $request->name,
                    'state_funding_code' => $request->state_funding_code['value'],
                    'national_funding_code' => $request->national_funding_code != null ?  $request->national_funding_code['value'] : null,
                    'specific_funding_code' => $request->specific_funding_code != null ? $request->specific_funding_code['identifier'] : null,
                    'traineeship_apprenticeship' => $request->traineeship_apprenticeship ? 1 : 0,
                    'funding_disclosed' => $request->funding_disclosed ? 1 : 0,
                    'vet_student_loan' => $request->vet_student_loan ? 1 : 0,
                    'purchasing_contract' => $request->purchasing_contract,
                    'training_contract' => $request->training_contract,
                    'purchasing_schedule' => $request->purchasing_schedule,
                    'intake_number' => $request->intake_number,
                    'acquitted' => $request->acquitted ? 1 : 0,
                    'funding_removed' => $request->funding_removed ? 1 : 0,
                    'course_site_id' => $request->course_site_id,
                    'booking_id' => $request->booking_id,
                    'avetmiss' => $request->avetmiss ? 1 : 0,
                    'user_id' => \Auth::user()->id
                ]);
                $ft->save();
                \DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Added Successfully']);
                //code...
            } catch (\Throwable $th) {
                //throw $th;
                \DB::rollback();
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        }
    }

    public function deleteFundingType($id)
    {
        try {
            \DB::beginTransaction();
            $fundingType = AvtFundingType::find($id);
            $fundingType->delete();

            \DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            \DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong']);
        }
    }

    public function deleteStateFunding($id)
    {
        try {
            \DB::beginTransaction();
            $fundingState = AvtFundingSourceState::find($id);
            $fundingState->delete();

            \DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            \DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong']);
        }
    }
}
