<?php

namespace App\Http\Controllers\Organisations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingOrganisation;
use App\Models\OrganisationType;
use App\Models\AvtStateIdentifier;
use App\Models\AvtCountryIdentifier;
use App\Models\AvtOrgType;
use App\Models\AvtPostcode;
use App\Models\TrainingDeliveryLoc;
use App\Models\TrainingOrgBankDetails;
use App\Models\WP\RTO;
use Auth;
use \DB;
use Validator;
use File as Files;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;

class OrganisationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $org_id = TrainingOrganisation::first();
        $postcode = AvtPostcode::orderBy('suburb')->get();
        $country_id = AvtCountryIdentifier::orderBy('full_name')->get();

        $arr_postcode = [];
        foreach ($postcode as $key => $value) {
            $arr_postcode[] = [
                'id' => $value->id,
                'postcode' => $value->postcode,
                'suburb' => $value->suburb,
                'state' => $value->state,
                'postcode_name' => $value->suburb . ', ' . $value->state . ' ' . $value->postcode
            ];
        }

        \JavaScript::put([
            'training_organisation_id' => $org_id->training_organisation_id,
            'organisation_id' => $org_id->id,
            'slct_country_identifier' => $country_id,
            'slct_postcode' => $arr_postcode,
            'organisation_types' => AvtOrgType::all(),
        ]);

        return view('organisation.index');
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
        // dd($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        \JavaScript::put([
            'organisation_types' => AvtOrgType::all(),
        ]);
        return view('organisation.show');
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

    public function organisation_info($id)
    {
        $organisation = TrainingOrganisation::where('id', $id)->first();
        $bank_details = TrainingOrgBankDetails::where('training_organisation_id', $organisation->training_organisation_id)->first();

        $organisation_type = OrganisationType::all();

        $postcode = AvtPostcode::where('suburb', $organisation->addr_location)->get();

        $arr_postcode = [];
        foreach ($postcode as $key => $value) {
            $value = $value->where('postcode', $organisation->postcode)->where('suburb', $organisation->addr_location)->first();
            $arr_postcode = [
                'id' => $value->id,
                'postcode' => $value->postcode,
                'suburb' => $value->suburb,
                'state' => $value->state,
                'postcode_name' => $value->suburb . ', ' . $value->state . ' ' . $value->postcode
            ];
        }

        $data = [
            'organisation' => $organisation,
            'postcode_val' => $arr_postcode,
            'bank_details' => $bank_details
        ];

        return $data;
    }

    public function organisation_info_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trainer_organisation_id'   => 'required',
            'trainer_organisation_name' => 'required',
            'contact_name'              => 'required',
            'phone'                     => 'required',
            'facsimile_number'          => 'required',
            'email'                     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
        }

        try {
            // start db transaction
            DB::beginTransaction();

            $organisation = new TrainingOrganisation;

            $organisation->fill([
                'trainer_organisation_id'         => $request->trainer_organisation_id,
                'trainer_organisation_name'       => $request->trainer_organisation_name,
                'avetmiss_organisation_id'        => $request->avetmiss_organisation_id,  
                'contact_name'                    => $request->contact_name,
                'phone'                           => $request->phone,
                'facsimile_number'                => $request->facsimile_number,
                'email'                           => $request->email
            ]);
            $organisation->save();

            DB::commit();

            // return response()->json(['data'=>$request->all(), 'status' => 'success']);
            // return response()->json(['success'=>'Done!']);
            return json_encode(['data' => $request->all(), 'status' => 'success']);
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();

            // return to previous page with errors
            return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
        }
    }


    public function organisation_info_update(Request $request, $id)
    {

        try {

            // start db transaction
            DB::beginTransaction();

            $url = 'https://' . $_SERVER['HTTP_HOST'] . '/';

            if (isset($request->training_organisation_id) && !in_array($request->training_organisation_id, ['', null])) {
                $wprtoCheck = RTO::where('vorx_url', '!=', $url)->where('organisation_id', $request->training_organisation_id)->first();

                if ($wprtoCheck) {
                    return response()->json(['status' => 'errors', 'errors' => ['training_organisation_id' => ['Training Organisation ID already exist in different RTOs']]]);
                } else {
                    $wp_rto = RTO::updateOrCreate(
                        [
                            'vorx_url' => $url
                        ],
                        [
                            'vorx_url' => $url,
                            'organisation_id' => $request->training_organisation_id
                        ]
                    );
                }
            }



            $organisation = TrainingOrganisation::where('id', $id)->first();

            $organisation->update([
                'training_organisation_id'      => $request->training_organisation_id,
                'training_organisation_name'    => $request->training_organisation_name,
                'avetmiss_organisation_id'      => $request->avetmiss_organisation_id,  
                'addr_line1'                    => $request->addr_line1,
                'addr_location'                 => isset($request->addr_location) ? $request->addr_location['suburb'] : null,
                'state_identifier'              => isset($request->addr_location) ? $request->addr_location['state'] : null,
                'postcode'                      => isset($request->addr_location) ? $request->addr_location['postcode'] : null,
                'contact_name'                  => $request->contact_name,
                'telephone_number'              => $request->telephone_number,
                'facsimile_number'              => $request->facsimile_number,
                'email_address'                 => $request->email_address,
                'org_type_identifier'           => $request->org_type_identifier,
                'person_incharge'               => $request->person_incharge,
                'incharge_position'             => $request->incharge_position,
                'student_id_prefix'             => strtoupper($request->student_id_prefix),
                'app_color'                     => $request->app_color,
            ]);

            DB::commit();

            return json_encode(['data' => $request->all(), 'status' => 'updated']);
        } catch (\Exception $e) {
            // rollback db transactions
            DB::rollBack();

            echo $e->getMessage();
            exit();
            // return to previous page with errors
            return  response()->json(['message' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function get_organisation()
    {
        $organisation = TrainingOrganisation::all();

        return $organisation;
    }

    public function organisation_delete($id)
    {
        $org = TrainingOrganisation::find($id);
        if ($org != null) {
            $org->delete();
            return json_encode(['id' => $id, 'status' => 'success']);
        }
    }


    public function delivery_location()
    {


        // dd('hi');
        $org_id = TrainingOrganisation::first();
        $postcode = AvtPostcode::orderBy('suburb')->get();
        $country_id = AvtCountryIdentifier::orderBy('full_name')->get();


        $arr_postcode = [];
        foreach ($postcode as $key => $value) {
            $arr_postcode[] = [
                'id' => $value->id,
                'postcode' => $value->postcode,
                'suburb' => $value->suburb,
                'state' => $value->state,
                'postcode_name' => $value->suburb . ', ' . $value->state . ' ' . $value->postcode
            ];
        }
        $training_id = $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $train_org_dlvr_loc_id = $this->generate_string($permitted_chars, 10);
        \JavaScript::put([
            'training_organisation_id' => $org_id->training_organisation_id,
            'organisation_id' => $org_id->id,
            'slct_country_identifier' => $country_id,
            'slct_postcode' => $arr_postcode,
            'train_org_dlvr_loc_id' => $train_org_dlvr_loc_id
        ]);
        // dd($arr_postcode);    
        return view('organisation.training-dlvr-location');
    }

    public function generate_string($input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', $strength = 10)
    {
        $input_length = strlen($input);
        $random_string = '';

        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        $validate = TrainingDeliveryLoc::where('train_org_dlvr_loc_id', $random_string)->first();

        if ($validate) {
            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $this->generate_string($permitted_chars, 10);
        } else {
            return $random_string;
        }
    }

    public function delivery_location_store(Request $request, $id)
    {
        // dd($request);
        $postcode = $request->postcode;
        $country_id = $request->country_id;
        if ($postcode != null) {
            $state_id = AvtStateIdentifier::where('state_key', $postcode['state'])->first();
        }

        if (isset($request->id)) {
            try {
                // start db transaction
                DB::beginTransaction();

                $training_dlvr_location = TrainingDeliveryLoc::where('id', $request->id)->first();
                $training_dlvr_location->update([
                    'training_organisation_id'                         => $request->training_organisation_id,
                    'train_org_dlvr_loc_id'                            => $request->train_org_dlvr_loc_id,
                    'train_org_dlvr_loc_name'                          => $request->train_org_dlvr_loc_name,
                    'postcode'                                         => $postcode['postcode'],
                    'state_id'                                         => $state_id->value,
                    'addr_location'                                    => $postcode['suburb'],
                    // 'country_id'                                       => $country_id['identifier'],
                    'country_id'                                       => '1101',
                    "addr_flat_unit_detail"                            => $request->addr_flat_unit_detail,
                    "addr_building_property_name"                      => $request->addr_building_property_name,
                    "addr_street_name"                                 => $request->addr_street_name,
                    "addr_street_num"                                  => $request->addr_street_num,
                ]);
                
                DB::commit();

                // return response()->json(['data'=>$request->all(), 'status' => 'success']);
                // return response()->json(['success'=>'Done!']);
                return json_encode(['data' => $request->all(), 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        } else {

            $validator = Validator::make($request->all(), [
                'training_organisation_id'      => 'required',
                'train_org_dlvr_loc_id'         => 'required|unique:training_delivery_locations',
                'train_org_dlvr_loc_name'       => 'required',
                'postcode'                      => 'required',
                // 'state_id' => 'required',
                // 'addr_location' => 'required',
                // 'country_id'                     => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            }

            try {
                // start db transaction
                DB::beginTransaction();

                $training_dlvr_location = new TrainingDeliveryLoc;

                $training_dlvr_location->fill([
                    'training_organisation_id'                         => $request->training_organisation_id,
                    'train_org_dlvr_loc_id'                            => $request->train_org_dlvr_loc_id,
                    'train_org_dlvr_loc_name'                          => $request->train_org_dlvr_loc_name,
                    'postcode'                                         => $postcode['postcode'],
                    'state_id'                                         => $state_id->value,
                    'addr_location'                                    => $postcode['suburb'],
                    // 'country_id'                                       => $country_id['identifier'],
                    'country_id'                                       => '1101',
                    "addr_flat_unit_detail"                            => $request->addr_flat_unit_detail,
                    "addr_building_property_name"                      => $request->addr_building_property_name,
                    "addr_street_name"                                 => $request->addr_street_name,
                    "addr_street_num"                                  => $request->addr_street_num,
                ]);
                $training_dlvr_location->user()->associate(\Auth::user());
                $training_dlvr_location->save();

                DB::commit();

                // return response()->json(['data'=>$request->all(), 'status' => 'success']);
                // return response()->json(['success'=>'Done!']);
                return json_encode(['data' => $request->all(), 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }
    }

    public function delivery_location_list($id)
    {

        if (\Auth::user()->hasRole('Demo')) {
            $delivery_loc = TrainingDeliveryLoc::where('user_id', \Auth::user()->id)->get();
        } else {
            $delivery_loc = TrainingDeliveryLoc::all();
        }

        $arr_delivery_loc = [];
        $arr_postcode = [];
        foreach ($delivery_loc as $key => $value) {
            
            $country = AvtCountryIdentifier::where('identifier', $value->country_id)->first();
            $state_id = AvtStateIdentifier::where('value', $value->state_id)->first();

            // Ex. Unit 2, 11 Cordelia Street, South Brisbane, Queensland  4101.
            if($value->addr_flat_unit_detail && $value->addr_building_property_name != null){
                $building = $value->addr_flat_unit_detail.' '.$value->addr_building_property_name. ', ';
            }else{
                $building = '';
            }
            if($value->addr_street_num && $value->addr_street_name != null){
                $street = $value->addr_street_num. ' ' . $value->addr_street_name . ', ';
            }else{
                $street = '';
            }

            $full_location = $building.''.$street.''.$value->addr_location.', '.$state_id->state_name.' '.$value->postcode;

            $arr_postcode[] = [
                'id' => $value->id,
                'training_organisation_id'      => $value->training_organisation_id,
                'train_org_dlvr_loc_id'         => $value->train_org_dlvr_loc_id,
                'train_org_dlvr_loc_name'       => $value->train_org_dlvr_loc_name,
                'postcode'                      => $value->postcode,
                'addr_location'                 => $value->addr_location,
                'state_id'                      => $state_id->state_key,
                'country_id'                    => $country->full_name,
                "addr_flat_unit_detail"         => $value->addr_flat_unit_detail,
                "addr_building_property_name"   => $value->addr_building_property_name,
                "addr_street_name"              => $value->addr_street_name,
                "addr_street_num"               => $value->addr_street_num,
                'full_location'                 => $full_location
            ];
        }
        $data = [
            'deliveryLocList' => $arr_postcode,
        ];

        return $data;
    }


    public function delivery_location_info($id, $dl_id)
    {

        $dl = TrainingDeliveryLoc::where('id', $dl_id)->first();
        $postcode = AvtPostcode::where('suburb', $dl->addr_location)->get();
        $country_id = AvtCountryIdentifier::where('identifier', $dl->country_id)->first();

        $arr_postcode = [];
        foreach ($postcode as $key => $value) {
            $value = $value->where('postcode', $dl->postcode)->where('suburb', $dl->addr_location)->first();
            $arr_postcode = [
                'id' => $value->id,
                'postcode' => $value->postcode,
                'suburb' => $value->suburb,
                'state' => $value->state,
                'postcode_name' => $value->suburb . ', ' . $value->state . ' ' . $value->postcode
            ];
        }
        $data = [
            'delivery_location_info' => $dl,
            'postcode_val' => $arr_postcode,
            'country_val' => $country_id,
        ];

        return $data;
    }



    public function delivery_location_delete($id, $dl_id)
    {
        $dl = TrainingDeliveryLoc::with(['student_completion_detail','classes'])->where('id',$dl_id)->first();
        if ($dl != null) {
            if(isset($dl->student_completion_detail[0]) || isset($dl->classes[0])){
                return ['id'=> $dl_id, 'status' => 'denied', 'msg' => 'Delivery Location is in use.'];
            }
            $dl->delete();
            return json_encode(['id' => $dl_id, 'status' => 'success']);
        }
    }


    public function bank_details_store(Request $request, $id)
    {
        // dd($request);
        if (isset($request->id)) {
            try {
                // start db transaction
                DB::beginTransaction();

                $training_bank = TrainingOrgBankDetails::where('id', $request->id)->first();
                $training_bank->update([
                    'training_organisation_id'  => $request->training_organisation_id,
                    'bank_name'                 => $request->bank_name,
                    'bsb'                       => $request->bsb,
                    'account_name'              => $request->account_name,
                    'account_number'            => $request->account_number
                ]);

                DB::commit();

                // return response()->json(['data'=>$request->all(), 'status' => 'success']);
                // return response()->json(['success'=>'Done!']);
                return json_encode(['data' => $request->all(), 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        } else {

            $validator = Validator::make($request->all(), [
                'bank_name'         => 'required',
                'bsb'               => 'required',
                'account_name'      => 'required',
                'account_number'    => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'errors', 'errors' => $validator->messages()]);
            }

            try {
                // start db transaction
                DB::beginTransaction();

                $training_bank = new TrainingOrgBankDetails;
                $training_bank->fill([
                    'training_organisation_id'  => $request->training_organisation_id,
                    'bank_name'                 => $request->bank_name,
                    'bsb'                       => $request->bsb,
                    'account_name'              => $request->account_name,
                    'account_number'            => $request->account_number
                ]);
                $training_bank->save();

                DB::commit();

                // return response()->json(['data'=>$request->all(), 'status' => 'success']);
                // return response()->json(['success'=>'Done!']);
                return json_encode(['data' => $request->all(), 'status' => 'success']);
            } catch (\Exception $e) {
                // rollback db transactions
                DB::rollBack();

                // return to previous page with errors
                return  response()->json(['message' => $e->getMessage(), 'status' => 'errors']);
            }
        }
    }

    public function bank_list($id)
    {
        $bank = TrainingOrgBankDetails::all();
        $data = [
            'bankList' => $bank
        ];
        return $data;
    }

    public function bank_info($id, $bank_id)
    {
        $bank_info = TrainingOrgBankDetails::where('id', $bank_id)->first();
        $data = [
            'bank_info' => $bank_info,
        ];
        return $data;
    }

    public function bank_delete($id, $bank_id)
    {
        $bank = TrainingOrgBankDetails::find($bank_id);
        if ($bank != null) {
            $bank->delete();
            return json_encode(['id' => $bank_id, 'status' => 'success']);
        }
    }

    public function upload_logo(Request $request)
    {
        $to = TrainingOrganisation::where('id', $request->organisation_id)->first();

        $logo_path = storage_path() . '/app/public/config/images';

        if (!file_exists($logo_path)) {
            Files::makeDirectory($logo_path, $mode = 0777, true, true);
        }
        $file = $request->file('image');

        $image_size = getimagesize($file->path());
        // dd($image_size);

        $path = $file->storeAs('/public/config/images', $file->getClientOriginalName());
        // dd($path);
        $image_name =  $file->getClientOriginalName();
        
        
        if ($request->type == 'Logo') {

            if($image_size[0] < $image_size[1]){
                $arr = explode('.',$image_name);
                $resize_name = str_replace('.'.end($arr), '_resize.'.end($arr), $image_name); 
                $lg = Storage::path($path);
                $lg_rz = str_replace($image_name, $resize_name, $lg);
                $image_resize = Image::make($lg);
                $image_resize->resize(100,100);
                $image_resize->save($lg_rz);
                $image_name = $resize_name;
            }

            $to->logo_img = $image_name;

        } else {
            $to->incharge_signature = $image_name;
        }
        $to->update();


        return ['status' => 'success', 'image' => $file->getClientOriginalName()];
        // dd($file->getClientOriginalName());

    }
    public function delete_logo($id, $type)
    {
        $to = TrainingOrganisation::where('id', $id)->first();
        $path = storage_path() . '/app/public/config/images';
        $img = $type == 'Logo' ? $to->logo_img : $to->incharge_signature;
        if (file_exists($path . '/' . $img)) {
            Storage::delete($path . '/' . $img);
        }
        if ($type == 'Logo') {
            $to->logo_img = null;
        } else {
            $to->incharge_signature = null;
        }
        $to->update();

        return ['status' => 'success'];
    }
}
