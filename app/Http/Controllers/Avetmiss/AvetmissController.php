<?php

namespace App\Http\Controllers\Avetmiss;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use DateTime;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Carbon\Carbon;
use File as Files;

use App\Models\Organisation;
use App\Models\TrainingDeliveryLoc;
use App\Models\CourseAvtDetail;
use App\Models\Unit;

// AVT MODELS
use App\Models\Avetmiss\Avt10;
use App\Models\Avetmiss\Avt20;
use App\Models\Avetmiss\Avt30;
use App\Models\Avetmiss\Avt60;
use App\Models\Avetmiss\Avt80;
use App\Models\Avetmiss\Avt85;
use App\Models\Avetmiss\Avt90;
use App\Models\Avetmiss\Avt100;
use App\Models\Avetmiss\Avt120;
use App\Models\Avetmiss\Avt130;

use App\Models\Avetmiss\Avetmiss;
use App\Models\Avetmiss\AvtProcess;
use App\Models\Avetmiss\AvtStatus;
use App\Models\AvtStateIdentifier;
use App\Models\FundedStudentCourse;
use App\Models\StudentCompletion;
use Bdt\Avetmiss\Config;
use Bdt\Avetmiss\File;
// use Bdt\Avetmiss\Nat\V7;
// use Bdt\Avetmiss\Nat\V8;

// AVET V8 VENDOR
use Bdt\Avetmiss\Nat\V8\Nat010;
use Bdt\Avetmiss\Nat\V8\Nat020;
use Bdt\Avetmiss\Nat\V8\Nat030;
use Bdt\Avetmiss\Nat\V8\Nat060;
use Bdt\Avetmiss\Nat\V8\Nat080;
use Bdt\Avetmiss\Nat\V8\Nat085;
use Bdt\Avetmiss\Nat\V8\Nat090;
use Bdt\Avetmiss\Nat\V8\Nat100;
use Bdt\Avetmiss\Nat\V8\Nat120;
use Bdt\Avetmiss\Nat\V8\Nat130;

use Bdt\Avetmiss\Fields\Field;
use Bdt\Avetmiss\Fieldset;
use Bdt\Avetmiss\Row;
use Illuminate\Support\Facades\Storage;

class AvetmissController extends Controller
{

    private $avtPath = '';
    private $dateFrom = '';
    private $dateTo = '';
    private $reportTo = [];
    private $studCom = [];

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
        // return $this->nat010();

        \JavaScript::put([
            // for course
            'states' => AvtStateIdentifier::whereNotIn('state_key', ['INT', 'OO', 'OAT'])->get(),
        ]);

        return view('avetmiss.index');
    }

    public function process_list()
    {
        return AvtProcess::orderBy('id', 'desc')->get();
    }

    public function save_remarks(Request $request) 
    {
        $process = AvtProcess::find($request->id);
        $process->remarks = $request->remarks;
        $process->save();

        return ['status' => 'success', 'process' => $process];
    }

    public function create_process()
    {
        $process_id = $this->codeNumber();
        $process = new AvtProcess;

        $process->process = $process_id;
        $process->dateFrom = date('Y-01-01');
        $process->dateTo = date('Y-12-31');
        $process->user()->associate(Auth::user());
        $process->save();

        return ['status' => 'success'];
    }

    public function delete_process($process_id)
    {
        $data = AvtProcess::with(['nat10', 'nat20', 'nat30', 'nat60', 'nat80', 'nat85', 'nat90', 'nat100', 'nat120', 'nat130'])->where('process', $process_id)->first();
        
        if($data){
            // Avt80::destroy($data->nat80);
            foreach($data->nat10 as $v){
                $v->delete();
            }
            foreach($data->nat20 as $v){
                $v->delete();
            }
            foreach($data->nat30 as $v){
                $v->delete();
            }
            foreach($data->nat60 as $v){
                $v->delete();
            }
            foreach($data->nat80 as $v){
                $v->delete();
            }
            foreach($data->nat85 as $v){
                $v->delete();
            }
            foreach($data->nat90 as $v){
                $v->delete();
            }
            foreach($data->nat100 as $v){
                $v->delete();
            }
            foreach($data->nat120 as $v){
                $v->delete();
            }
            foreach($data->nat130 as $v){
                $v->delete();
            }
            
            $data->delete();
            return ['status' => 'success'];
        }
    }

    public function toggle_lock(Request $request)
    {
        $process = AvtProcess::where('process', $request->process_id)->first();
        $process->is_locked = $process->is_locked == 0 ? 1 : 0;
        $process->update();
        
        return ['status' => 'success', 'is_locked' => $process->is_locked];
    }

    public function view_log_data($process_id = null, $nat = null)
    {
        $log_path = '/avetmiss/logs/'.$process_id . '/' . $nat . '.txt';
        
        if(Storage::exists($log_path)) {
            return Storage::get($log_path);
        }else {
            return 0;
        }
    }

    public function nat_count_list($process_id = null)
    {

        $process = AvtProcess::with(['nat10', 'nat20', 'nat30', 'nat60', 'nat80', 'nat85', 'nat90', 'nat100', 'nat120', 'nat130'])->where('process', $process_id)->first();
        $process->dateFrom = Carbon::createFromFormat('Y-m-d', $process->dateFrom)->format('Y-m');
        $process->dateTo = Carbon::createFromFormat('Y-m-d', $process->dateTo)->format('Y-m');

        $log_path = '/avetmiss/logs/'.$process_id;
    
        // dd(Storage::exists($log_path.'/NAT00010.txt'));
        // dd(count(json_decode(Storage::get($log_path.'/NAT00010.txt'))));

        $nat = [
            0 => [
                'name' => 'NAT00010',
                'description' => 'Training organisation',
                'count' => Storage::exists($log_path.'/NAT00010.txt') ? count(json_decode(Storage::get($log_path.'/NAT00010.txt'))) : 0,
                // 'count' => $process->nat10->count()
            ], 
            1 => [
                'name' => 'NAT00020',
                'description' => 'Training organisation delivery location',
                'count' =>  Storage::exists($log_path.'/NAT00020.txt') ? count(json_decode(Storage::get($log_path.'/NAT00020.txt'))) : 0,
                // 'count' => $process->nat20->count()
            ], 
            2 => [
                'name' => 'NAT00030',
                'description' => 'Program',
                'count' => Storage::exists($log_path.'/NAT00030.txt') ? count(json_decode(Storage::get($log_path.'/NAT00030.txt'))) : 0,
                // 'count' => $process->nat30->count()
            ], 
            3 => [
                'name' => 'NAT00060',
                'description' => 'Subject',
                'count' => Storage::exists($log_path.'/NAT00060.txt') ? count(json_decode(Storage::get($log_path.'/NAT00060.txt'))) : 0,
                // 'count' => $process->nat60->count()
            ], 
            4 => [
                'name' => 'NAT00080',
                'description' => 'Client',
                'count' => Storage::exists($log_path.'/NAT00080.txt') ? count(json_decode(Storage::get($log_path.'/NAT00080.txt'))) : 0,
                // 'count' => $process->nat80->count()
            ], 
            5 => [
                'name' => 'NAT00085',
                'description' => 'Client contact details',
                'count' => Storage::exists($log_path.'/NAT00085.txt') ? count(json_decode(Storage::get($log_path.'/NAT00085.txt'))) : 0,
                // 'count' => $process->nat85->count()
            ], 
            6 => [
                'name' => 'NAT00090',
                'description' => 'Disability',
                'count' => Storage::exists($log_path.'/NAT00090.txt') ? count(json_decode(Storage::get($log_path.'/NAT00090.txt'))) : 0,
                // 'count' => $process->nat90->count()
            ], 
            7 => [
                'name' => 'NAT00100',
                'description' => 'Prior educational achievement',
                'count' => Storage::exists($log_path.'/NAT00100.txt') ? count(json_decode(Storage::get($log_path.'/NAT00100.txt'))) : 0,
                // 'count' => $process->nat100->count()
            ], 
            8 => [
                'name' => 'NAT00120',
                'description' => 'Training activity',
                'count' => Storage::exists($log_path.'/NAT00120.txt') ? count(json_decode(Storage::get($log_path.'/NAT00120.txt'))) : 0,
                // 'count' => $process->nat120->count()
            ], 
            9 => [
                'name' => 'NAT00130',
                'description' => 'Program completed',
                'count' => Storage::exists($log_path.'/NAT00130.txt') ? count(json_decode(Storage::get($log_path.'/NAT00130.txt'))) : 0,
                // 'count' => $process->nat130->count()
            ]
        ];

        $this->avtPath = storage_path().'/app/avetmiss/'.$process_id;

        if (!file_exists($this->avtPath)) {
            Files::makeDirectory($this->avtPath, $mode = 0777, true, true);
        }


        return [
            'process' => $process,
            'nat' => $nat
        ];
    }

    public function avetmiss_info()
    {

        $training_org = Organisation::all();
        $training_dlvrloc = TrainingDeliveryLoc::all();
        $course_avt_details = CourseAvtDetail::all();
        $course_units = Unit::all();

        $data = [
            // 'nat00010' => $training_org,
            // 'nat00020'  => $training_dlvrloc,
            // 'nat00030' => $course_avt_details,
            // 'nat00060' => $course_units,
        ];
        
        return $data;
    }

    public function codeNumber()
    {
    	$number = mt_rand(00001, 99999);

    	if (count($this->codeNumberExist($number))) {
        	return $this->codeNumber();
    	}

    	return $number;
    }
    public function codeNumberExist($number)
    {
    	return AvtProcess::where('process', $number)->get();
    }

    public function generate_natfile(Request $request)
    {
        // dd($request->all());
        $process = AvtProcess::where('process', $request->process_id)->first();
        // $process_id = '11111';
        // $this->dateFrom = '2019-01-01';
        // $this->dateTo = '2019-12-31';
        $this->dateFrom = Carbon::createFromFormat('Y-m', $request->dateFrom)->format('Y-01-01');
        $this->dateTo = Carbon::createFromFormat('Y-m', $request->dateTo)->format('Y-m-t');

        if(in_array($request->report_to, ['', null])){
            return ['status' => 'error', 'message'=>'Report To must be filled'];
        }

        $this->reportTo = $request->report_to != '*' ? AvtStateIdentifier::where('state_key', $request->report_to)->first() : '*';

        $sc = new StudentCompletion;
        $this->studCom = $sc->avetmiss_compliant($this->dateFrom, $this->dateTo, $this->reportTo);

        // dump($this->dateFrom);

        if($this->studCom->count() < 1){
            return ['status' => 'error', 'message'=>'No students to be reported'];
        }

        $process->dateFrom = $this->dateFrom;
        $process->dateTo = $this->dateTo;
        $process->dateTo = $this->dateTo;
        $process->report_to = $this->reportTo == '*' ? '*' : $this->reportTo->state_key;

        $process->update();
        // dump($process);
        

        $this->check_process_id($request->process_id, $this->dateFrom, $this->dateTo);

        try {
            $nat010 = $this->nat010($request->process_id);
            $nat020 = $this->nat020($request->process_id);
            $nat030 = $this->nat030($request->process_id);
            $nat060 = $this->nat060($request->process_id);
            $nat080 = $this->nat080($request->process_id);
            $nat085 = $this->nat085($request->process_id);
            $nat090 = $this->nat090($request->process_id);
            $nat100 = $this->nat100($request->process_id);
            $nat120 = $this->nat120($request->process_id);
            $nat130 = $this->nat130($request->process_id);

            


            return ['status' => 'success'];
        } catch(Exception $e) {
            // Display or log any errors.
            return ['status' => 'error'];
        }

        return "NAT FILES GENERATED! :D";

    }

    public function download($process_id)
    {
        $zip = new ZipArchive;

        // $exp = explode('+', $ref);
        // $get = str_replace('+', '/', $ref);
        // $handle = $_SERVER['DOCUMENT_ROOT']."/../storage/app/avetmiss/".$get;
        if (!file_exists(storage_path()."/app/avetmiss/zip")) {
            Files::makeDirectory(storage_path()."/app/avetmiss/zip", $mode = 0777, true, true);
        }

        $zipname = storage_path()."/app/avetmiss/zip/".$process_id." - AVETMISS NAT Files Collection.zip";

        $path = storage_path('app/avetmiss/'.$process_id);
        
        
        $zip->open($zipname, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($path) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
        // dd($zip);

        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header("Content-Disposition: attachment; filename=".$process_id." - AVETMISS NAT Files Collection (".Carbon::now()->timestamp.").zip");
        header('Content-Length: ' . filesize(storage_path('app/avetmiss/zip/'.$process_id.' - AVETMISS NAT Files Collection.zip')));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        // header("Location: ".storage_path('app/avetmiss/zip/'.$process_id.' - AVETMISS NAT Files Collection.zip'));
        readfile(storage_path('app/avetmiss/zip/'.$process_id.' - AVETMISS NAT Files Collection.zip'));
        // return back();
    }

    public function check_process_id($process_id, $from, $to)
    {
        $data = AvtProcess::with(['nat10', 'nat20', 'nat30', 'nat60', 'nat80', 'nat85', 'nat90', 'nat100', 'nat120', 'nat130'])->where('process', $process_id)->first();
        
        if($data){
            // Avt80::destroy($data->nat80);
            $log_path = '/avetmiss/logs/'.$process_id;
            if(Storage::exists($log_path.'/NAT00010.txt')){
                Storage::delete($log_path.'/NAT00010.txt');
            }
            if(Storage::exists($log_path.'/NAT00020.txt')){
                Storage::delete($log_path.'/NAT00020.txt');
            }
            if(Storage::exists($log_path.'/NAT00030.txt')){
                Storage::delete($log_path.'/NAT00030.txt');
            }
            if(Storage::exists($log_path.'/NAT00060.txt')){
                Storage::delete($log_path.'/NAT00060.txt');
            }
            if(Storage::exists($log_path.'/NAT00080.txt')){
                Storage::delete($log_path.'/NAT00080.txt');
            }
            if(Storage::exists($log_path.'/NAT00085.txt')){
                Storage::delete($log_path.'/NAT00085.txt');
            }
            if(Storage::exists($log_path.'/NAT00090.txt')){
                Storage::delete($log_path.'/NAT00090.txt');
            }
            if(Storage::exists($log_path.'/NAT00100.txt')){
                Storage::delete($log_path.'/NAT00100.txt');
            }
            if(Storage::exists($log_path.'/NAT00120.txt')){
                Storage::delete($log_path.'/NAT00120.txt');
            }
            if(Storage::exists($log_path.'/NAT00130.txt')){
                Storage::delete($log_path.'/NAT00130.txt');
            }
            // foreach($data->nat10 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat20 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat30 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat60 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat80 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat85 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat90 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat100 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat120 as $v){
            //     $v->forceDelete();
            // }
            // foreach($data->nat130 as $v){
            //     $v->forceDelete();
            // }
            $this->avtPath = storage_path().'/app/avetmiss/'.$process_id;
        }else{
            // dd('create new process');
            $data = new AvtProcess;
            $data->process = $process_id;
            $data->dateFrom = $from;
            $data->dateTo = $to;
            $data->user()->associate(Auth::user());
            $data->save();

            $this->avtPath = storage_path().'/app/avetmiss/'.$process_id;
		    Files::makeDirectory($this->avtPath, $mode = 0777, true, true);
        }
        // dd($data);
        
    }

    public function nat010($process_id)
    {
        // array of student courses, pulled from the database
        // $avetmiss_data = $this->avetmiss_info();
        
        // -------------------------------------------------- //
        //                      NAT 10                        //
        // -------------------------------------------------- //
        $nat10 = new Avt10;
        $file = new File(new Nat010);
        $logs = [];
        foreach($nat10->get_data_avt10() as $org) {
            // try {
            // if(!in_array($org->training_organisation_id, [null, '']) && !in_array($org->training_organisation_name, [null, ''])){
            // dump($org);
            $row = $file->createRow();
            
            // cannot be null
            $t_org = !in_array($org['avetmiss_organisation_id'] , [null, '']) ? $org['avetmiss_organisation_id'] : $org['training_organisation_id'];
            $row->set('training_organisation_id', $t_org);
            $row->set('training_organisation_name', $org['training_organisation_name']);

            // can be null
            $row->set('contact_name', $org['contact_name']);
            $row->set('telephone_number', $org['telephone_number']);
            $row->set('facsimile_number', $org['facsimile_number']);
            $row->set('email_address', $org['email_address']);
            //...
        
            $file->writeRow($row);
            // }
            $saveNat10 = new Avt10;
            // save to database
            $saveNat10->training_organisation_id = $t_org;
            $saveNat10->training_organisation_name = $org['training_organisation_name'];
            $saveNat10->contact_name = $org['contact_name'];
            $saveNat10->telephone_number = $org['telephone_number'];
            $saveNat10->facsimile_number = $org['facsimile_number'];
            $saveNat10->email_address = $org['email_address'];
            $saveNat10->avt_process_id = $process_id;
            $saveNat10->error_code = 0;
            // $saveNat10->save();
            $logs[] = $saveNat10->toArray();
            // } catch(Exception $e) {
            //     // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00010.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00010.txt');

    }

    public function nat020($process_id)
    {
        // dump($this->avtPath);
        
        // -------------------------------------------------- //
        //                      NAT 20                        //
        // -------------------------------------------------- //
        $nat20 = new Avt20;
        $file = new File(new Nat020);
        $logs = [];
        // dump($nat20->get_data_avt20($this->dateFrom, $this->dateTo));
        // dd($file);

        // foreach($nat20->get_data_avt20($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat20->get_data_avt20($this->studCom) as $val) {
            // try {
            // if(!in_array($val->training_organisation_id, [null, '']) && !in_array($val->training_organisation_name, [null, ''])){
            // dump($val);
            $row = $file->createRow();

            // cannot be null
            $t_org = isset($val['training_org']['avetmiss_organisation_id']) && !in_array($val['training_org']['avetmiss_organisation_id'] , [null, '']) ? $val['training_org']['avetmiss_organisation_id'] : $val['training_organisation_id'];
            $row->set('training_organisation_id', $t_org);
            $row->set('training_organisation_delivery_location_id', $val['train_org_dlvr_loc_id']);
            $row->set('training_organisation_delivery_location_name', $val['train_org_dlvr_loc_name']);
            $row->set('postcode', $val['postcode']);
            $row->set('state_id', $val['state_id']);
            $row->set('address_location_suburb_locality_town', $val['addr_location']);
            $row->set('country_id', $val['country_id']);

            // can be null

            //...
        
            $file->writeRow($row);
            // }
            $saveNat20 = new Avt20;
            // save to database
            $saveNat20->training_organisation_id = $t_org;
            $saveNat20->train_org_dlvr_loc_id = $val['train_org_dlvr_loc_id'];
            $saveNat20->train_org_dlvr_loc_name = $val['train_org_dlvr_loc_name'];
            $saveNat20->postcode = $val['postcode'];
            $saveNat20->state_id = $val['state_id'];
            $saveNat20->addr_location = $val['addr_location'];
            $saveNat20->country_id = $val['country_id'];
            $saveNat20->avt_process_id = $process_id;
            $saveNat20->error_code = 0;
            // $saveNat20->save();
            $logs[] = $saveNat20->toArray();

                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00020.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00020.txt');
    }

    public function nat030($process_id)
    {
        // -------------------------------------------------- //
        //                      NAT 30                        //
        // -------------------------------------------------- //

        $nat30 = new Avt30;

        $fieldset = new Fieldset([
            Field::make('any')->name('program_id')->length(10),
            Field::make('any')->name('program_name')->length(100),
            Field::make('numeric')->name('nominal_hours')->length(4),
            Field::make('any')->name('program_recognition_identifier')->length(2),
            Field::make('any')->name('program_level_of_education_identifier')->length(3),
            Field::make('any')->name('program_field_of_education_identifier')->length(4),
            Field::make('any')->name('anzsco_identifier')->length(6),
            Field::make('any')->name('vet_flag')->length(1),
        ]);

        $file = new File($fieldset);
        $logs = [];
        // dump($nat30->get_data_avt30($this->dateFrom, $this->dateTo));
        // dd($file);

        // foreach($nat30->get_data_avt30($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat30->get_data_avt30($this->studCom) as $val) {
            // try {
            // if(!in_array($val->training_organisation_id, [null, '']) && !in_array($val->training_organisation_name, [null, ''])){
            // dump($val);
            if(!in_array($val['code'], ['1111', '@@@@']) && $val['is_uc'] != 1){
                $row = $file->createRow();
    
                $saveNat30 = new Avt30;
                // save to database
                $saveNat30->program_id = $val['code'];
                $saveNat30->program_name = $val['name'];
                $saveNat30->nominal_hours = !in_array($val['course_avt_detail']['nominal_hours'], ['', null]) ? sprintf("%04d", $val['course_avt_detail']['nominal_hours']) : '0000';
                $saveNat30->prg_recog_identifier = '';
                $saveNat30->prg_educ_lvl_identifier = '';
                $saveNat30->prg_educ_fld_identifier = '';
                $saveNat30->anzsco_identifier = '';
                $saveNat30->vet_flag = '';
                // $saveNat30->prg_recog_identifier = $val['course_avt_detail']['prg_recog_identifier_id'];
                // $saveNat30->prg_educ_lvl_identifier = $val['course_avt_detail']['prg_lvl_of_educ_identifier_id'];
                // $saveNat30->prg_educ_fld_identifier = $val['course_avt_detail']['qlf_field_of_educ_identifier_id'];
                // $saveNat30->anzsco_identifier = $val['course_avt_detail']['anzsco_identifier_id'];
                // $saveNat30->vet_flag = $val['course_avt_detail']['vet_flag_status'] == 1 ? 'Y' : 'N';
    
                // cannot be null
                $row->set('program_id', $saveNat30->program_id);
                $row->set('program_name', $saveNat30->program_name);
                $row->set('nominal_hours', $saveNat30->nominal_hours);
                $row->set('program_recognition_identifier', $saveNat30->prg_recog_identifier);
                $row->set('program_level_of_education_identifier', $saveNat30->prg_educ_lvl_identifier);
                $row->set('program_field_of_education_identifier', $saveNat30->prg_educ_fld_identifier);
                $row->set('anzsco_identifier', $saveNat30->anzsco_identifier);
                $row->set('vet_flag', $saveNat30->vet_flag);
                // can be null
    
                //...
            
                $file->writeRow($row);
                // }
                
                $saveNat30->avt_process_id = $process_id;
                $saveNat30->error_code = 0;
                // $saveNat30->save();
                $logs[] = $saveNat30->toArray();
            }


                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00030.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00030.txt');


    }

    public function nat060($process_id)
    {
        // -------------------------------------------------- //
        //                      NAT 60                        //
        // -------------------------------------------------- //

        $nat60 = new Avt60;
        $file = new File(new Nat060);
        $logs = [];
        // dump($nat60->get_data_avt60($this->dateFrom, $this->dateTo));
        // dd($file);

        // foreach($nat60->get_data_avt60($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat60->get_data_avt60($this->studCom, $this->dateFrom, $this->dateTo) as $val) {
            // try {
            // if(!in_array($val->training_organisation_id, [null, '']) && !in_array($val->training_organisation_name, [null, ''])){
            // dump($val);
            $row = $file->createRow();

            $saveNat60 = new Avt60;
            // save to database
            $saveNat60->unit_display_id = $val['code'];
            $saveNat60->unit_name = $val['description'];
            $saveNat60->module_field_of_education = $val['subject_educ_fld_identifier_id'];
            $saveNat60->vet_flag = $val['vet_flag'];
            $saveNat60->nominal_hours = !in_array($val['nominal_hours'] , ['', null]) ? $val['nominal_hours'] : 0;

            // cannot be null
            $row->set('unit_display_id', $saveNat60->unit_display_id);
            $row->set('unit_name', $saveNat60->unit_name);
            
            // can be null
            $row->set('module_field_of_education', $saveNat60->module_field_of_education);
            $row->set('vet_flag', $saveNat60->vet_flag);
            $row->set('nominal_hours', $saveNat60->nominal_hours);

            //...
        
            $file->writeRow($row);
            // }
            
            $saveNat60->avt_process_id = $process_id;
            $saveNat60->error_code = 0;
            // $saveNat60->save();
            $logs[] = $saveNat60->toArray();

                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00060.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00060.txt');


    }

    public function nat080($process_id)
    {
        // -------------------------------------------------- //
        //                      NAT 60                        //
        // -------------------------------------------------- //

        $nat80 = new Avt80;
        $file = new File(new Nat080);
        $logs = [];
        // $data = $nat80->get_data_avt80($this->dateFrom, $this->dateTo);
        // dump($data[701]);
        // dd($file);

        // foreach($nat80->get_data_avt80($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat80->get_data_avt80($this->studCom) as $val) {
            // try {
            // if(!in_array($val->training_organisation_id, [null, '']) && !in_array($val->training_organisation_name, [null, ''])){
            // dump($val['student_id']);
            // dd('000'.$val['student_id']);

            // for learner unique identifier
            $learner = '';
            // for($x = strlen($val['student_id']); $x < 10; $x++){
            //     $learner .= '0';
            // }
            // $learner .= $val['student_id'];

            // dd($learner);

            $saveNat = new Avt80;

            // $nfe = str_replace(' ', '-', $val['student']['party']['name']);
            // $nfe = preg_replace('/[^A-Za-z0-9-]/', '', $nfe);

            $nfe = $val['student']['party']['person']['lastname'].', '.$val['student']['party']['person']['firstname'];
            $nfe .= in_array($val['student']['party']['person']['middlename'], ['',null]) ? '' : ' '. $val['student']['party']['person']['middlename'];
            
            $getState = isset($val['student']['contact_detail']['state']['value']) ? sprintf("%02d", $val['student']['contact_detail']['state']['value'])  : '99';
            $getPostcode = $val['student']['contact_detail']['postcode'];
            $getSuburb = $val['student']['contact_detail']['addr_suburb'];
            $getStreetNum =  $val['student']['contact_detail']['addr_street_num'];
            $getStreetName = $val['student']['contact_detail']['addr_street_name'];

            if(isset($val['student']['course_code'])) {
                // && $val['student']['funded_course']['detail']['funded_source_national'] == 30
                // foreach($val['student']['funded_course'] as $fcKey => $fcVal) {
                //     if($fcVal['report_course_status_id'] > 1 && $fcVal['start_date'] >= $this->dateFrom){
                //         dump('in');
                //     }
                // }

                $c = FundedStudentCourse::with(['detail'])->where('course_code', $val['student']['course_code'])->where('student_id', $val['student_id'])->first();
                
                if($c->detail->funding_source_national == 30) {
                    $getState = 99;
                    $getPostcode = 'OSPC';
                    $getSuburb = 'NOT SPECIFIED';
                    $getStreetNum = 'NOT SPECIFIED';
                    $getStreetName = 'NOT SPECIFIED';
                }
                // dd($c);
            }

            // dd($val['student']['funded_course']);

            $saveNat->client_id = $val['student_id'];
            // $saveNat->name_for_encryption = preg_replace('/-+/', '_', $nfe);
            $saveNat->name_for_encryption = $nfe;
            $saveNat->highest_school_level_completed = $val['student']['funded_detail']['highest_school_level_completed_id'];
            $saveNat->gender = !in_array($val['student']['party']['person']['gender'], ['',null]) ? substr($val['student']['party']['person']['gender'], 0, 1) : null;
            $saveNat->date_of_birth = !in_array($val['student']['party']['person']['date_of_birth'], ['','0000-00-00', null]) ? Carbon::createFromFormat('Y-m-d', $val['student']['party']['person']['date_of_birth'])->format('dmY') : '00000000';
            $saveNat->postcode = $getPostcode;
            $saveNat->indigenous_status_id = $val['student']['funded_detail']['indigenous_status_id'];
            $saveNat->language_id = $val['student']['funded_detail']['language_id'];
            $saveNat->labour_force_status_id = $val['student']['funded_detail']['labour_force_status_id'];
            $saveNat->country_id = $val['student']['funded_detail']['country_id'];
            $saveNat->disability_flag = $val['student']['funded_detail']['disability_flag'];
            $saveNat->prior_educational_achievement_flag = $val['student']['funded_detail']['prior_educational_achievement_flag'];
            $saveNat->at_school_flag = $val['student']['funded_detail']['at_school_flag'];
            $saveNat->unique_student_id = $val['student']['funded_detail']['unique_student_id'];
            $saveNat->state_id = $getState;
            $saveNat->address_location_suburb_locality_or_town = $getSuburb;
            $saveNat->address_street_number = $getStreetNum;
            $saveNat->address_street_name = $getStreetName;
            $saveNat->learner_unique_identifier = $learner;
            $saveNat->address_building_property_name = $val['student']['contact_detail']['addr_building_property_name'];
            $saveNat->address_flat_unit_details = $val['student']['contact_detail']['addr_flat_unit_detail'];
            $saveNat->statistical_area_level_1_id = $val['student']['funded_detail']['statistical_area_level_1_id'];
            $saveNat->statistical_area_level_2_id = $val['student']['funded_detail']['statistical_area_level_2_id'];
            $saveNat->survey_contact_status = in_array($val['student']['funded_detail']['survey_contact_status'], ['', null]) ? 'A' : $val['student']['funded_detail']['survey_contact_status'];
            
            // dump($saveNat);

            $row = $file->createRow();
            // cannot be null
            $row->set('client_id', $saveNat->client_id);
            $row->set('name_for_encryption', $saveNat->name_for_encryption);
            $row->set('highest_school_level_completed', $saveNat->highest_school_level_completed);
            $row->set('gender', $saveNat->gender);
            $row->set('date_of_birth', $saveNat->date_of_birth);
            $row->set('postcode', $saveNat->postcode);
            $row->set('indigenous_status_id', $saveNat->indigenous_status_id);
            $row->set('language_id', $saveNat->language_id);
            $row->set('labour_force_status_id', $saveNat->labour_force_status_id);
            $row->set('country_id', $saveNat->country_id);
            $row->set('disability_flag', $saveNat->disability_flag);
            $row->set('prior_educational_achievement_flag', $saveNat->prior_educational_achievement_flag);
            $row->set('at_school_flag', $saveNat->at_school_flag);
            $row->set('unique_student_id', $saveNat->unique_student_id);
            $row->set('state_id', $saveNat->state_id);
            $row->set('address_location_suburb_locality_or_town', $saveNat->address_location_suburb_locality_or_town);
            $row->set('address_street_number', $saveNat->address_street_number);
            $row->set('address_street_name', $saveNat->address_street_name);
            $row->set('learner_unique_identifier', $saveNat->learner_unique_identifier);
            
            // can be null
            $row->set('address_building_property_name', $saveNat->address_building_property_name);
            $row->set('address_flat_unit_details', $saveNat->address_flat_unit_details);
            $row->set('statistical_area_level_1_id', $saveNat->statistical_area_level_1_id);
            $row->set('statistical_area_level_2_id', $saveNat->statistical_area_level_2_id);
            $row->set('survey_contact_status', $saveNat->survey_contact_status);
            
            // dd($row);
            //...
        
            $file->writeRow($row);
            // save to database
            $saveNat->avt_process_id = $process_id;
            $saveNat->error_code = 0;
            // $saveNat->save();
            $logs[] = $saveNat->toArray();

                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00080.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00080.txt');


    }

    public function nat085($process_id)
    {
        // -------------------------------------------------- //
        //                      NAT 85                        //
        // -------------------------------------------------- //

        $nat85 = new Avt85;
        $file = new File(new Nat085);
        $logs = [];
        // $data = $nat85->get_data_avt85($this->dateFrom, $this->dateTo);
        // dump($data[701]);
        // dd($file);

        // foreach($nat85->get_data_avt85($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat85->get_data_avt85($this->studCom) as $val) {
            // try {
            
            $saveNat = new Avt85;

            $getSuburb = $val['student']['contact_detail']['addr_suburb'];
            $getPostcode = $val['student']['contact_detail']['postcode'];
            $getState = isset($val['student']['contact_detail']['state']['value']) ? sprintf("%02d", $val['student']['contact_detail']['state']['value'])  : '99';
            $getStreetNum = $val['student']['contact_detail']['addr_street_num'];
            $getStreetName = $val['student']['contact_detail']['addr_street_name'];

            if(isset($val['student']['course_code'])) {

                $c = FundedStudentCourse::with(['detail'])->where('course_code', $val['student']['course_code'])->where('student_id', $val['student_id'])->first();
                
                if($c->detail->funding_source_national == 30) {
                    $getState = 99;
                    $getPostcode = 'OSPC';
                    $getSuburb = 'NOT SPECIFIED';
                    $getStreetNum = 'NOT SPECIFIED';
                    $getStreetName = 'NOT SPECIFIED';
                }
                // dd($c);
            }


            $saveNat->client_id = $val['student_id'];
            $saveNat->client_title = $val['student']['party']['person']['prefix'];
            $saveNat->client_first_given_name = $val['student']['party']['person']['firstname'];
            $saveNat->client_last_name = $val['student']['party']['person']['lastname'];
            $saveNat->address_building_property_name = $val['student']['contact_detail']['addr_building_property_name'];
            $saveNat->address_flat_unit_details = $val['student']['contact_detail']['addr_flat_unit_detail'];
            $saveNat->address_street_number = $getStreetNum;
            $saveNat->address_street_name = $getStreetName;
            $saveNat->address_postal_delivery_box = $val['student']['contact_detail']['addr_postal_delivery_box'];
            $saveNat->address_location_suburb_locality_or_town = $getSuburb;
            $saveNat->postcode = $getPostcode;
            $saveNat->state_id = $getState;
            $saveNat->telephone_number_home = $val['student']['contact_detail']['phone_home'];
            $saveNat->telephone_number_work = $val['student']['contact_detail']['phone_work'];
            $saveNat->telephone_number_mobile = $val['student']['contact_detail']['phone_mobile'];
            $saveNat->email_address = $val['student']['contact_detail']['email'];
            $saveNat->email_address_alternative = $val['student']['contact_detail']['email_at'];
            
            // dd($saveNat);

            $row = $file->createRow();

            // cannot be null
            $row->set('client_id', $saveNat->client_id);
            $row->set('client_last_name', $saveNat->client_last_name);
            $row->set('address_street_name', $saveNat->address_street_name);
            $row->set('address_postal_suburb_locality_town', $saveNat->address_location_suburb_locality_or_town);
            $row->set('postcode', $saveNat->postcode);
            $row->set('state_id', $saveNat->state_id);
            
            // can be null
            $row->set('client_title', $saveNat->client_title);
            $row->set('client_first_given_name', $saveNat->client_first_given_name);
            $row->set('address_street_number', $saveNat->address_street_number);
            $row->set('address_building_property_name', $saveNat->address_building_property_name);
            $row->set('address_flat_unit_details', $saveNat->address_flat_unit_details);
            $row->set('address_postal_delivery_box', $saveNat->address_postal_delivery_box);
            $row->set('telephone_number_home', $saveNat->telephone_number_home);
            $row->set('telephone_number_work', $saveNat->telephone_number_work);
            $row->set('telephone_number_mobile', $saveNat->telephone_number_mobile);
            $row->set('email_address', $saveNat->email_address);
            $row->set('email_address_alternative', $saveNat->email_address_alternative);
            
            // dd($row);
            //...
        
            $file->writeRow($row);
            // save to database
            $saveNat->avt_process_id = $process_id;
            $saveNat->error_code = 0;
            // $saveNat->save();
            $logs[] = $saveNat->toArray();

                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00085.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00085.txt');


    }

    public function nat090($process_id)
    {
        // -------------------------------------------------- //
        //                      NAT 90                        //
        // -------------------------------------------------- //

        $nat90 = new Avt90;
        $file = new File(new Nat090);
        $logs = [];
        // $data = $nat90->get_data_avt90($this->dateFrom, $this->dateTo);
        // dump($data[701]);
        // dd($file);

        // foreach($nat90->get_data_avt90($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat90->get_data_avt90($this->studCom) as $val) {
            // try {
            
            $saveNat = new Avt90;

            $saveNat->client_id = $val['client_id'];
            $saveNat->disability_type = $val['disability_type'];
            
            // dd($saveNat);

            $row = $file->createRow();

            // cannot be null
            $row->set('client_id', $saveNat->client_id);
            $row->set('disability_type', $saveNat->disability_type);
            
            // can be null

            
            // dd($row);
            //...
        
            $file->writeRow($row);
            // save to database
            $saveNat->avt_process_id = $process_id;
            $saveNat->error_code = 0;
            // $saveNat->save();
            $logs[] = $saveNat->toArray();

                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00090.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00090.txt');


    }

    public function nat100($process_id)
    {
        // -------------------------------------------------- //
        //                      NAT 100                        //
        // -------------------------------------------------- //

        $nat100 = new Avt100;
        $file = new File(new Nat100);
        $logs = [];
        // $data = $nat100->get_data_avt100($this->dateFrom, $this->dateTo);
        // dump($data[701]);
        // dd($file);

        // foreach($nat100->get_data_avt100($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat100->get_data_avt100($this->studCom) as $val) {
            // try {
            
            $saveNat = new Avt100;

            $saveNat->client_id = $val['client_id'];
            $saveNat->prior_education_achievement = $val['prior_education_achievement'];
            
            // dd($saveNat);

            $row = $file->createRow();

            // cannot be null
            $row->set('client_id', $saveNat->client_id);
            $row->set('prior_education_achievement', $saveNat->prior_education_achievement);
            
            // can be null

            
            // dd($row);
            //...
        
            $file->writeRow($row);
            // save to database
            $saveNat->avt_process_id = $process_id;
            $saveNat->error_code = 0;
            // $saveNat->save();
            $logs[] = $saveNat->toArray();

                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00100.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00100.txt');


    }

    public function nat120($process_id)
    {
        // -------------------------------------------------- //
        //                      NAT 120                        //
        // -------------------------------------------------- //

        $nat120 = new Avt120;
        $file = new File(new Nat120);
        // $data = $nat120->get_data_avt120($this->dateFrom, $this->dateTo);
        // dump($data[701]);
        // dd($file);
        $logs = [];
        // foreach($nat120->get_data_avt120($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat120->get_data_avt120($this->studCom, $this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
            // try {
            // dump($val['organisation']['org_type_identifier']);

            // if($val['student_course']['detail']['commence_prg_identifier'] == null){
            //     // dd($val['student_course']);
            // }
            if($val['student_course']['detail']['funding_source_national'] != null){
                $saveNat = new Avt120;

                $getFundingSourceNational = $val['student_course']['detail']['funding_source_national'] == null ? '@@' : $val['student_course']['detail']['funding_source_national'];

                // funding source national - International
                if($val['student_course']['detail']['funding_source_national'] == 30 && $val['offer_letter']) {
                    if($val['offer_letter']['shore_type'] == 'ONSHORE') {
                        $getFundingSourceNational = 31;
                    }elseif ($val['offer_letter']['shore_type'] == 'OFFSHORE') {
                        $getFundingSourceNational = 32;
                    }
                }

                // course fee type
                if($val['student_course']['course_fee_type'] == 'NC'){
                    $feeType = 'N'; 
                }elseif($val['student_course']['course_fee_type'] == 'FF'){
                    $feeType = 'Z'; 
                }else{
                    $feeType = $val['student_course']['course_fee_type'];
                }
                $t_org = isset($val['organisation']['avetmiss_organisation_id']) && !in_array($val['organisation']['avetmiss_organisation_id'], [null, '']) ? $val['organisation']['avetmiss_organisation_id'] : $val['organisation']['training_organisation_id'];
                $saveNat->training_organisation_id = $t_org;
                $saveNat->training_organisation_delivery_location_id = $val['train_org_loc_id'];
                $saveNat->client_id = $val['student_course']['student_id'];
                $saveNat->subject_id = $val['course_unit_code'];
                $saveNat->program_id = in_array($val['student_course']['course_code'], ['@@@@', '1111']) || isset($val['student_course']['course']['id']) && $val['student_course']['course']['is_uc'] == 1 ? '' : $val['student_course']['course_code'];
                $saveNat->activity_start_date = Carbon::createFromFormat('Y-m-d',$val['start_date'])->format('dmY');
                $saveNat->activity_end_date = Carbon::createFromFormat('Y-m-d',$val['end_date'])->format('dmY');
                $saveNat->delivery_mode_id = $val['delivery_mode_id'];
                $saveNat->outcome_id_national = $val['completion_status']['value'];
                $saveNat->funding_source_national = $getFundingSourceNational;
                $saveNat->commencing_program_id = $val['student_course']['detail']['commence_prg_identifier'] == null ? '@' : $val['student_course']['detail']['commence_prg_identifier'];
                $saveNat->training_contract_id = $val['student_course']['detail']['training_contract_id'];
                $saveNat->client_id_apprenticeships = $val['student_course']['detail']['client_id_apprenticeships'];
                $saveNat->study_reason_id = $val['student_course']['detail']['study_reason_id'];
                // $saveNat->vet_in_schools_flag = isset($val['unit']['vet_flag']) ? 'Y' : 'N';
                $saveNat->vet_in_schools_flag = 'N';
                $saveNat->specific_funding_id = $val['student_course']['detail']['specific_funding_id'] == '@@' ? '' : $val['student_course']['detail']['specific_funding_id'];
                $saveNat->school_type_identifier = $val['organisation']['org_type_identifier'];
                $saveNat->outcome_id_training_organisation = $val['completion_status']['value'];
                $saveNat->funding_source_state_training_authority = $val['student_course']['detail']['funding_source_state_training_authority'];
                // $saveNat->client_tuition_fee = round($val['student_course']['course_fee']);
                
                // tuition fee
                $tf = 0;
                if(!in_array($val['completion_status']['value'], ['60'])){
                    $tf = round($val['student_course']['course_fee'] / $val['unit_count']);
                }

                // scheduled hours
                $sched_hours = isset($val['unit']['nominal_hours']) ? sprintf("%04d", $val['unit']['nominal_hours']) : '00';
                $hours_attend = isset($val['unit']['nominal_hours']) ? sprintf("%04d", $val['unit']['nominal_hours']) : '00';
                if(isset($val['unit']['scheduled_hours']) && !in_array($val['unit']['scheduled_hours'], [null, '', 0])){
                    $sched_hours = sprintf("%04d", $val['unit']['scheduled_hours']);
                    $hours_attend = sprintf("%04d", $val['unit']['scheduled_hours']);
                }
                if(isset($val['training_hours']) && !in_array($val['training_hours'], [null, '', 0])){
                    $sched_hours = sprintf("%04d", $val['training_hours']);
                    $hours_attend = sprintf("%04d", $val['training_hours']);
                }
                // dd($sched_hours);

                $saveNat->client_tuition_fee = $tf;
                $saveNat->fee_exemption_concession_type_id = $feeType;
                $saveNat->purchasing_contract_id = $val['student_course']['detail']['purchasing_contract_id'];
                $saveNat->purchasing_contract_schedule_id = $val['student_course']['detail']['purchasing_contract_schedule_id'];
                $saveNat->hours_attended = $hours_attend;
                $saveNat->associated_course_id = $val['student_course']['detail']['associated_course_id'];
                $saveNat->scheduled_hours = $sched_hours;

                // predominant
                $pdm = $val['delivery_mode_id'] == 'NNN' ? 'N' : $val['student_course']['detail']['predominant_delivery_mode'];

                $saveNat->predominant_delivery_mode = $pdm;
                $saveNat->full_time_learning_option = $val['student_course']['detail']['full_time_leaning_option'] ? 'Y' : 'N';
                
                // dd($saveNat);
    
                $row = $file->createRow();
    
                // cannot be null
                $row->set('training_organisation_id', $saveNat->training_organisation_id);
                $row->set('training_organisation_delivery_location_id', $saveNat->training_organisation_delivery_location_id);
                $row->set('client_id', $saveNat->client_id);
                $row->set('subject_id', $saveNat->subject_id);
                $row->set('program_id', $saveNat->program_id);
                $row->set('activity_start_date', $saveNat->activity_start_date);
                $row->set('activity_end_date', $saveNat->activity_end_date);
                $row->set('delivery_mode_id', $saveNat->delivery_mode_id);
                $row->set('outcome_id_national', $saveNat->outcome_id_national);
                $row->set('funding_source_national', $saveNat->funding_source_national);
                $row->set('vet_in_schools_flag', $saveNat->vet_in_schools_flag);
                $row->set('specific_funding_id', $saveNat->specific_funding_id);
                
                // can be null
                $row->set('school_type_identifier', $saveNat->school_type_identifier);
                $row->set('associated_course_id', $saveNat->associated_course_id);
                $row->set('client_id_apprenticeships', $saveNat->client_id_apprenticeships);
                $row->set('study_reason_id', $saveNat->study_reason_id);
                $row->set('client_tuition_fee', $saveNat->client_tuition_fee);
                $row->set('fee_exemption_concession_type_id', $saveNat->fee_exemption_concession_type_id);
                $row->set('commencing_program_id', $saveNat->commencing_program_id);
                $row->set('training_contract_id', $saveNat->training_contract_id);
                $row->set('funding_source_state_training_authority', $saveNat->funding_source_state_training_authority);
                $row->set('scheduled_hours', $saveNat->scheduled_hours);
                $row->set('hours_attended', $saveNat->hours_attended);
                $row->set('outcome_id_training_organisation', $saveNat->outcome_id_training_organisation);
                $row->set('purchasing_contract_id', $saveNat->purchasing_contract_id);
                $row->set('purchasing_contract_schedule_id', $saveNat->purchasing_contract_schedule_id);
                $row->set('predominant_delivery_mode', $saveNat->predominant_delivery_mode);
                $row->set('full_time_learning_option', $saveNat->full_time_learning_option);
                
                
                // dd($row);
                //...
            
                $file->writeRow($row);
                // save to database
                $saveNat->avt_process_id = $process_id;
                $saveNat->error_code = 0;
                $logs[] = $saveNat->toArray(); 
                // $saveNat->save();

                // break;

            }
            

                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        // dd('test');
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00120.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00120.txt');


    }

    public function nat130($process_id)
    {
        // -------------------------------------------------- //
        //                      NAT 100                        //
        // -------------------------------------------------- //

        $nat130 = new Avt130;
        $logs = [];
        $fieldset = new Fieldset([
            Field::make('any')->name('training_organisation_id')->length(10),
            Field::make('any')->name('program_id')->length(10),
            Field::make('any')->name('client_id')->length(10),
            Field::make('any')->name('date_program_completed')->length(8),
            Field::make('any')->name('issued_flag')->length(1),
            Field::make('any')->name('parchment_issued_date')->length(8),
            Field::make('any')->name('parchment_number')->length(25),
        ]);
        // $avt130 = new Nat130([
        //     Field::make('date')->name('parchment_issued_date')->length(8),
        // ]);
        // $file = new File(new Nat130);
        $file = new File($fieldset);
        // $data = $nat130->get_data_avt130($this->dateFrom, $this->dateTo);
        // dump('data');
        // dd($file);
        // dd($avt130);
        // dd($this->dateTo);
        // dd($nat130->get_data_avt130($this->studCom));

        // foreach($nat130->get_data_avt130($this->dateFrom, $this->dateTo, $this->reportTo) as $val) {
        foreach($nat130->get_data_avt130($this->studCom) as $val) {
            // try {
            
            if(isset($val['completion_date']) && !in_array($val['completion_date'], ['', null, '0000-00-00']) && !in_array($val['course_code'], ['@@@@','1111']) && $val['completion_date'] <= $this->dateTo){
                $saveNat = new Avt130;
                
                $t_org = isset($val['organisation']['avetmiss_organisation_id']) && !in_array($val['organisation']['avetmiss_organisation_id'], [null, '']) ? $val['organisation']['avetmiss_organisation_id'] : $val['organisation']['training_organisation_id'];
                $saveNat->training_organisation_id = $t_org;
                $saveNat->program_id = $val['course_code'];
                $saveNat->client_id = $val['student_id'];
                $saveNat->date_program_completed = Carbon::createFromFormat('Y-m-d', $val['completion_date'])->format('dmY');
                if(isset($val['certificate']['id']) && !in_array($val['certificate']['issued_date'], ['', null, '0000-00-00'])){
                    $saveNat->issued_flag = 'Y';
                    // $saveNat->
                }else{
                    $saveNat->issued_flag = 'N';
                }
                if($saveNat->issued_flag == 'Y'){
                    $saveNat->parchment_issued_date = isset($val['certificate']['issued_date']) ? Carbon::createFromFormat('Y-m-d', $val['certificate']['issued_date'])->format('dmY') : '';
                    $saveNat->parchment_number = isset($val['certificate']['manual_cert_num']) ? $val['certificate']['manual_cert_num'] : '';
                }
                // $avt130->make('parchment_issued_date');
                // dd($avt130);
    
                $row = $file->createRow();
                // dd($row);
                // cannot be null
                $row->set('training_organisation_id', $saveNat->training_organisation_id);
                $row->set('program_id', $saveNat->program_id);
                $row->set('client_id', $saveNat->client_id);
                $row->set('date_program_completed', $saveNat->date_program_completed);
                $row->set('issued_flag', $saveNat->issued_flag);
                if($saveNat->issued_flag == 'Y'){
                    $row->set('parchment_issued_date', $saveNat->parchment_issued_date);
                    $row->set('parchment_number', $saveNat->parchment_number);
                }
                
                // can be null
    
                
                // dd($row);
                //...
            
                $file->writeRow($row);
                // save to database
                $saveNat->avt_process_id = $process_id;
                $saveNat->error_code = 0;
                // $saveNat->save();
                $logs[] = $saveNat->toArray();
            }
            

                
            // } catch(Exception $e) {
                // Display or log any errors.
            // }
            // dd($file);
        }
        if(count($logs) > 0){
            Storage::put('avetmiss/logs/'.$process_id.'/NAT00130.txt', collect($logs));
        }
        $file->export($this->avtPath.'/NAT00130.txt');


    }

    
}
