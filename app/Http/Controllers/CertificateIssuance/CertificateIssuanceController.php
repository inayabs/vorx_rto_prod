<?php

namespace App\Http\Controllers\CertificateIssuance;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Send\EmailSendingController as AppEmailSendingController;
use App\Models\AvtCompletionStatus;
use App\Models\SentCertificate;
use App\Models\StudentCertificateIssuance;
use App\Models\CertificateIssuanceDetail;
use App\Models\EmailAutomation;
use App\Models\StudentAttachment;
use App\Models\StudentCompletion;
use Illuminate\Http\Request;
use App\Models\TrainingOrganisation;
use File;
use Illuminate\Support\Facades\Storage;

class CertificateIssuanceController extends Controller
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
        $units = $request->units;
        $completion =  StudentCompletion::find($request->course_completion['id'])->toArray();
        $student = $request->student;
        if(!isset($request->student)){
            $student = $completion['student_id'];
        }
        
        $cert_units = [];
        foreach ($units as $key => $unit) {
            if(isset($unit['status'])){
                if (in_array($unit['status'], [3, 4, 6, 7])) {
                    $cert_units[] = $unit;
                }
            }else{
                if (in_array($unit['completion_status_id'], [3, 4, 6, 7])) {
                    $cert_units[] = $unit;
                }
            }
            
        }
        // $cert = StudentCertificateIssuance::all();
        $cert = StudentCertificateIssuance::where('student_id', $student)
            ->where('student_completion_id', $completion['id'])
            ->latest()
            ->first();
        $to = TrainingOrganisation::first();
        $studIDPrefix = in_array($to->student_id_prefix, [null, '']) ? 'VRX' : $to->student_id_prefix;
        if ($completion == null) {
            return response()->json(['status' => 'error', 'message' => 'No Course Completion Found']);
        }
        if ($cert != null) {
            // dd($cert->details->first()->units);
            if ($cert->details->count() > 0) {
                if (count($cert_units) == count($cert->details->first()->units)) {
                    // dump($cert_units);
                    // dump($cert->details->first()->units);
                    return response()->json(['status' => 'error', 'message' => 'Number of units are the same']);
                }
            }


            if ($cert->manual_cert_num == null) {
                $sentSeq = $this->generate_certificate_number();
                $cert->update([
                    'manual_cert_num' => $sentSeq,
                    'generated_cert_num' => $sentSeq
                ]);
            }
            // $sendcert = SentCertificate::latest()->first();
            // $certDetail = CertificateIssuanceDetail::whereNotNull('soa_number')->withTrashed()->orderBy('id', 'DESC')->first();
            // dd($certDetail);
            // if ($certDetail == null) {
            //     $sentSeq = $sendcert->soa_number;
            //     $sentSeq = preg_replace('/[A-Z]/', '', $sentSeq);
            // } else {
            //     $sentSeq = $certDetail->soa_number;
            //     $sentSeq = preg_replace('/[A-Z]/', '', $sentSeq);
            // }

            // (int) $sentSeq++;
            if($completion['completion_status_id'] == '3'){
                $sentSeq = $cert->generated_cert_num;
            }else{

                $sentSeq = $this->genereate_soa_number();
            }
            // dd($completion);
            // dd($sentSeq);


            try {
                DB::beginTransaction();

                $certDetails = new CertificateIssuanceDetail;


                if ($cert->issued_date != null && $cert->release_date == null) {
                    $certDetails->fill([
                        'units' => $cert_units,
                        'soa_number' => $sentSeq,
                        'release_date' => $cert->issued_date,
                        'release' => 0
                    ]);
                } else {
                    $certDetails->fill([
                        'units' => $cert_units,
                        'soa_number' => $sentSeq
                    ]);
                }


                $certDetails->certificte_issuance()->associate($cert);
                $certDetails->save();

                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Generated Successfully.','data' => $certDetails]);
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }


            // dd($cert_units);
        } else {



            $generate = $this->generate_certificate_number();
            try {
                DB::beginTransaction();

                $studentCert = new StudentCertificateIssuance;
                $studentCert->fill([
                    'generated_cert_num' => $generate,
                    'manual_cert_num' => $generate,
                ]);

                $studentCert->completion()->associate($completion['id']);
                $studentCert->student()->associate($student);
                $studentCert->user()->associate(Auth::user());
                $studentCert->save();

                // $sendcert = SentCertificate::latest()->first();
                // $certDetail = CertificateIssuanceDetail::whereNotNull('soa_number')->withTrashed()->orderBy('id', 'DESC')->first();

                // if ($certDetail == null) {
                //     $sentSeq = $sendcert->soa_number;
                //     $sentSeq = preg_replace('/[A-Z]/', '', $sentSeq);
                // } else {
                //     $sentSeq = $certDetail->soa_number;
                //     $sentSeq = preg_replace('/[A-Z]/', '', $sentSeq);
                // }
                // (int) $sentSeq++;
                // $sentSeq = $studIDPrefix[0] . 'SOA' . $sentSeq;

                $sentSeq = $this->genereate_soa_number();

                $certDetails = new CertificateIssuanceDetail;
                $certDetails->fill([
                    'units' => $cert_units,
                    'soa_number' => $sentSeq
                ]);
                $certDetails->certificte_issuance()->associate($studentCert);
                $certDetails->save();

                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Generated Successfully.']);
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['status' => 'success', 'message' => $th->getMessage()]);

                // throw $th;
            }
        }
    }

    public function generate_certificate_number()
    {

        $number = mt_rand(0, 9999);
        $mustFiveDigit = sprintf('%04d', $number);
        $to = TrainingOrganisation::first();
        $studIDPrefix = in_array($to->student_id_prefix, [null, '']) ? 'VRX' : $to->student_id_prefix;
        $cert_no = $studIDPrefix[0] . $mustFiveDigit;

        $check = StudentCertificateIssuance::where('manual_cert_num', $cert_no)->orWhere('generated_cert_num', $cert_no)->first();
        if ($check) {
            $this->generate_certificate_number();
        }
        return $cert_no;
    }

    public function genereate_soa_number()
    {

        $number = mt_rand(0, 9999);
        $mustFiveDigit = sprintf('%04d', $number);
        $to = TrainingOrganisation::first();
        $studIDPrefix = in_array($to->student_id_prefix, [null, '']) ? 'VRX' : $to->student_id_prefix;
        $cert_no = $studIDPrefix[0] . 'SOA' . $mustFiveDigit;

        $check = CertificateIssuanceDetail::where('soa_number', $cert_no)->first();
        if ($check) {
            $this->genereate_soa_number();
        }
        return $cert_no;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id)
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
        // dd($request->all());
        try {
            DB::beginTransaction();
            $cert = CertificateIssuanceDetail::findOrFail($id);
            if ($request->release_date != '') {
                $cert->release_date = Carbon::parse($request->release_date)->format('Y-m-d');
                $cert->release = 0;
                $cert->save();
            }
            if ($request->reissued_date != '') {
                $cert->reissued_date = Carbon::parse($request->reissued_date)->format('Y-m-d');
                $cert->reissue = 0;
                $cert->save();
            }

            if ($request->completion_date != '') {
                $completion = StudentCertificateIssuance::findOrFail($cert->student_certificate_issuance_id);
                $completion->expected_course_completion = Carbon::parse($request->completion_date)->format('Y-m-d');
                $completion->save();
            }
            if ($request->enrolment_date != '') {
                $completion = StudentCertificateIssuance::findOrFail($cert->student_certificate_issuance_id);
                $completion->enrolment_date = Carbon::parse($request->enrolment_date)->format('Y-m-d');
                $completion->save();
            }
            if ($request->manual != '') {
                $completion = StudentCertificateIssuance::findOrFail($cert->student_certificate_issuance_id);
                $completion->manual_cert_num = $request->manual;
                $completion->save();
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Successfully updated ' . $request->soa_number]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            //throw $th;
        }
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
        try {
            DB::beginTransaction();
            $cert = CertificateIssuanceDetail::findOrFail($id);
            $cert->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Certificate Deleted ' . $cert->soa_number]);

            //code...
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            //throw $th;
        }
        // dd($id);
    }

    public function student_list($student_id)
    {
        $course_cert = StudentCertificateIssuance::with('sentCert', 'details', 'completion.details')->where('student_id', $student_id)->orderBy('id', 'DESC')->get();
        $certs = [];

        foreach ($course_cert as $course) {
            if (!$course->details->isEmpty()) {
                // dd($course->details);
                foreach ($course->details as $detail) {
                    # code...d
                    // dump($detail);
                    // dd($course->completion->course_code);
                    if ($course->completion != null) {
                        $certificate = [
                            'id' => $detail->id,
                            'student_certificate_issuance_id' => $detail->student_certificate_issuance_id,
                            'release_date' => $detail->release_date,
                            'reissued_date' => $detail->reissued_date,
                            'course' => $course->completion->course_code,
                            'units' => $detail->units,
                            'sent' => $detail->sent,
                            'soa_number' => ($course->completion->details->count() != count($detail->units) || $course->completion->details->count()  <= 5) ? $detail->soa_number : $course->manual_cert_num,
                            'manual' =>  $course->manual_cert_num,
                            'release' => $detail->release,
                            'reissue' => $detail->reissue,
                            'completion_date' => ($course->completion->details->count() != count($detail->units)) ? '' : $course->expected_course_completion,
                            'enrolment_date' => ($course->completion->details->count() != count($detail->units)) ? '' : $course->enrolment_date,
                            'created_at' => $detail->created_at,
                            'extra_unit_id' => $detail->extra_unit_id,
                        ];
                        // if (!$course->sentCert->isEmpty()) {
                        //     dd($course->sentCert);
                        // }
                        $certs[] = $certificate;
                    }
                }
            } else {
                foreach ($course->sentCert as $certkey => $sentCert) {
                    if ($sentCert->certificate != null) {
                        // dd($sentCert->certificate);
                        if ($certkey == 0) {
                            if ($sentCert->certificate->expected_course_completion != '') {
                                $certificate = [
                                    'id' => $sentCert->certificate_issuance_id,
                                    'student_certificate_issuance_id' => $sentCert->certificate_issuance_id,
                                    'release_date' => $sentCert->certificate->released_date,
                                    'reissued_date' => $sentCert->certificate->issued_date,
                                    'course' => $course->completion->course_code,
                                    'units' => [],
                                    'soa_number' => $sentCert->certificate->manual_cert_num,
                                    'release' =>  $sentCert->certificate->released_date == '' ? 1 : 0,
                                    'reissue' => $sentCert->certificate->issued_date == '' ? 1 : 0,
                                    'completion_date' => $sentCert->certificate->expected_course_completion,
                                    'enroment_date' => $sentCert->certificate->enrolment_date,
                                    'created_at' => $sentCert->certificate->created_at,
                                    'extra_unit_id' => null,
                                ];
                                // if($course->sentCert)
                                $certs[] = $certificate;
                            }
                        }
                        $certificate = [
                            'id' => $sentCert->id,
                            'student_certificate_issuance_id' => $sentCert->certificate_issuance_id,
                            'release_date' => $sentCert->certificate->released_date,
                            'reissued_date' => $sentCert->certificate->issued_date,
                            'course' => $course->completion->course_code,
                            'units' => [],
                            'soa_number' => $sentCert->soa_number,
                            'release' =>  $sentCert->certificate->released_date == '' ? 1 : 0,
                            'reissue' => $sentCert->certificate->issued_date == '' ? 1 : 0,
                            'completion_date' => $sentCert->certificate->expected_course_completion,
                            'enroment_date' => $sentCert->certificate->enrolment_date,
                            'created_at' => $sentCert->certificate->created_at,
                            'extra_unit_id' => null,
                        ];
                        // if($course->sentCert)
                        $certs[] = $certificate;
                    }
                }
                // dd($course->sentCert);
                // $certificate = [
                //     'id' => $course->sentCert->id,
                //     'student_certificate_issuance_id' => $course->sentCert->student_certificate_issuance_id,
                //     'release_date' => $course->sentCert->created_at,
                //     'reissued_date' => null,
                //     'course' => $course->completion->course_code,
                //     'soa_number' => $course->sentCert->soa_number,
                //     'release' => 1,
                //     'reissue' => 1,
                //     'completion_date' => '',
                //     'enroment_date' => $course->enrolment_date,
                //     'created_at' => $course->sentCert->created_at,
                // ];
                // // if($course->sentCert)
                // $certs[] = $certificate;
            }
            // dd($course->sentCert);

        }
        // exit();
        usort($certs, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });
        return $certs;
    }

    public function preview_cert($id)
    {
        try {
            $certificate = CertificateIssuanceDetail::with('certificte_issuance.completion.details', 'certificte_issuance.completion', 'certificte_issuance.completion.course', 'certificte_issuance.student.party.person', 'certificte_issuance.student.funded_detail')->findOrFail($id);
            $com_status = AvtCompletionStatus::all();
            $statuses = [];
            foreach ($com_status as $cs) {
                $statuses[$cs->id] = $cs->status_code;
            }
            $base_units = $certificate->certificte_issuance->completion->details->count();
            
            $fullname = $certificate->certificte_issuance->student->party->name;
            
            if(isset($certificate->certificte_issuance->student->party->person->full_name)) {
                $fullname = $certificate->certificte_issuance->student->party->person->full_name;
            }

            $student = [
                'student_id' => $certificate->certificte_issuance->student->student_id,
                'vetrack' => ($certificate->certificte_issuance->student->funded_detail != null) ? $certificate->certificte_issuance->student->funded_detail->vetrack_id : null,
                'name'       => $fullname,
                'dob'       => $certificate->certificte_issuance->student->party->person->date_of_birth,
                'cert_num'   => $base_units != count($certificate->units) || count($certificate->units)  <= 5 ?  $certificate->soa_number : $certificate->certificte_issuance->manual_cert_num,
                'soa_num'   => $certificate->soa_number,
                'course_code'     => !in_array($certificate->certificte_issuance->completion->course_code, ['@@@@', '1111'])  ? $certificate->certificte_issuance->completion->course->code : '',
                'course_name'     => !in_array($certificate->certificte_issuance->completion->course_code, ['@@@@', '1111']) ? $certificate->certificte_issuance->completion->course->name : 'Unit of Competency',
                'release'   => $certificate->release,
                'release_date'   => $certificate->release_date,
                'reissued'   => $certificate->reissue,
                'reissued_date'   => $certificate->reissued_date,
            ];
            //  dd($student);
            if (count($certificate->units)  > 15 && count($certificate->units) < 15) {
                $units = array_chunk($certificate->units, 20);
                $font = 10;
            } elseif (count($certificate->units) >= 15) {
                $units = array_chunk($certificate->units, 20);
                $font = 10;
            } else {
                $units[] = $certificate->units;
                $font = 10;
            }

            if (isset($certificate->certificte_issuance->completion->course->code)) {
                if ($certificate->certificte_issuance->completion->course->code == 'CHC30113') {
                    $units = array_chunk($certificate->units, 20);
                    $font = 14;
                }

                if ($certificate->certificte_issuance->completion->course->code == 'CPC50210') {
                    $units = array_chunk($certificate->units, 20);
                    $font = 14;
                }
            } else {
                $units = array_chunk($certificate->units, 20);
                $font = 14;
            }

            // dump($certificate);
            // dd($units);
            
            // if($student['course_code'] == '1111'){
            //     $student['course_code'] = $units[0][0]['code'];
            //     $student['course_name'] = $units[0][0]['description'];
            // }

            // dump($statuses);
            // dump($student);
            // dd($units);
            //code...
            if(env('APP_NAME') == 'Phoenix'){
                if(count($certificate->units)  <= 5){
                    $cert_template = (count($certificate->units)  <= 5 ? 'custom.pca.certificates.statement_of_attainment' : 'custom.pca.certificates.certificate');
                    
                }else{
                    $cert_template = ($base_units != count($certificate->units) ? 'custom.pca.certificates.statement_of_attainment' : 'custom.pca.certificates.certificate');

                }
                $file_name = $student['name'] . ' - (' . $student['course_code'] . ') ' . $student['course_name'] . ".pdf";
                return \PDF::loadView($cert_template, compact('student', 'units', 'font', 'statuses'))->setPaper('A4')->stream($file_name);

            }else{
                $cert_template = ($base_units != count($certificate->units) ? 'certificates.statement-of-attainment' : 'certificates.certificate');
                $cert_template = (count($certificate->units)  <= 5 ? 'certificates.statement-of-attainment' : 'certificates.certificate');

                $cert_template = (in_array($student['course_code'], ['1111', '@@@@']) ? 'certificates.statement-of-attainment' : $cert_template);
                $file_name = $student['name'] . ' - (' . $student['course_code'] . ') ' . $student['course_name'] . ".pdf";

                return \PDF::loadView($cert_template, compact('student', 'units', 'font', 'statuses'))->setPaper(array(0, 0, 595, 925))->stream($file_name);
            }
        } catch (\Throwable $th) {
            // dd('error');
            throw $th;
        }
    }

    public function progress_report($id, $course, $save = 0)
    {
        $completion = StudentCompletion::with('details.status', 'details.unit', 'student.party.person', 'course', 'certificate')
            ->where('student_id', $id)
            ->where('id', $course)
            ->first();

        // dd($completion);
        if ($completion == null) {
            dd('No progress found.');
        }
        // dd($completion->details);

        if (count($completion->details) > 21 && count($completion->details) < 20) {
            $units = $completion->details->chunk(21);
            $font = 12;
        } elseif (count($completion->details) >= 21) {
            $units = $completion->details->chunk(21);
            $font = 12;
        } else {
            $units[] = $completion->details;
            $font = 10;
        }

        $app = TrainingOrganisation::first();
        // dd($units);
        $course_code = $completion->course_code == '@@@@' ? 'Unit of Competency' : $completion->course_code;
        if ($save == 1) {
            try {
                $path = storage_path('app/student/reports/' . $completion->student_id);
                File::makeDirectory($path, $mode = 0777, true, true);
                $path .= '/' . $completion->student->party->name . ' - Progress Report (' . $course_code . ').pdf';
                \PDF::loadView('progress-report.progress_report', compact('completion', 'font', 'units', 'app'))->save($path)->stream($completion->student->party->name . ' - Progress Report (' . $course_code . ').pdf');
                return [
                    'status' => 'saved',
                    'path' => $path,
                ];
            } catch (\Throwable $th) {
                return false;
            }
        } else {
            return \PDF::loadView('progress-report.progress_report', compact('completion', 'font', 'units', 'app'))->stream($completion->student->party->name . ' - Progress Report (' . $course_code . ').pdf');
        }
    }

    public function generate_extraUnit(Request $request, $student)
    {
        // dump($student);
        $cert = StudentCompletion::where('student_id', $student)
            ->where('course_code', '1111')
            ->latest()
            ->first();
        try {
            DB::beginTransaction();
            $units = $request->units;
            $cert_units = [];
            foreach ($units as $key => $unit) {
                if (in_array($unit['status'], [3, 4, 6])) {
                    $cert_units[] = $unit;
                }
            }
            if ($cert == null) {
                $sc = new StudentCompletion;
                $sc->fill([
                    'student_id' => $student,
                    'course_code' => '1111',
                    'completion_status_id' => 1,
                    'user_id' => Auth::user()->id,
                ]);
                // $sc->user()->assosciate(Auth::user());
                $sc->save();

                $generate =  $this->generate_certificate_number();
                $studentCert = new StudentCertificateIssuance;
                $studentCert->fill([
                    'generated_cert_num' => $generate,
                    'manual_cert_num' => $generate,
                ]);

                $studentCert->completion()->associate($sc);
                $studentCert->student()->associate($student);
                $studentCert->user()->associate(Auth::user());
                $studentCert->save();

                $certDetail = CertificateIssuanceDetail::latest()->first();
                $sentSeq = $certDetail->soa_number;
                $sentSeq = preg_replace('/[A-Z]/', '', $sentSeq);
                (int) $sentSeq++;
                $sentSeq = 'ETISOA' . $sentSeq;
                $certDetails = new CertificateIssuanceDetail;
                $certDetails->fill([
                    'units' => $cert_units,
                    'soa_number' => $sentSeq,
                    'extra_unit_id' => $request->id
                ]);
                $certDetails->certificte_issuance()->associate($studentCert);
                $certDetails->save();
                return response()->json(['status' => 'success', 'message' => 'Generated Successfully.']);
                //code...

            } else {
                $certIssue = StudentCertificateIssuance::with('details')->where('student_id', $student)->where('student_completion_id', $cert->id)->first();
                $unitChecker = CertificateIssuanceDetail::where('student_certificate_issuance_id', $certIssue->id)->where('extra_unit_id', $request->id)->get();
                if ($unitChecker->isEmpty()) {
                    $certDetail = CertificateIssuanceDetail::latest()->first();
                    $sentSeq = $certDetail->soa_number;
                    $sentSeq = preg_replace('/[A-Z]/', '', $sentSeq);
                    (int) $sentSeq++;
                    $sentSeq = 'ETISOA' . $sentSeq;
                    $certDetails = new CertificateIssuanceDetail;
                    $certDetails->fill([
                        'units' => $cert_units,
                        'soa_number' => $sentSeq,
                        'extra_unit_id' => $request->id
                    ]);
                    $certDetails->certificte_issuance()->associate($certIssue);
                    $certDetails->save();
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Already Generated.']);
                }
                // dd($unitChecker);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function checkcompletion()
    {
        $students = StudentCompletion::with('details', 'course.courseprospectus')->get();
        // dd($student->count());
        $ctr = 0;
        foreach ($students as $student) {

            $prospectus = $student->course->courseprospectus->first();
            if ($prospectus == null) {
                // dump($student->course);
                dump($student->student_id . '-' . $student->student->party->name . ' no course prospectus');
            } else {
                if ($student->details->count() != count($prospectus->unit_selected)) {
                    $ctr++;
                    if ($student->details->count() > count($prospectus->unit_selected)) {
                        dump($ctr . '. ' . $student->student_id . '-' . $student->student->party->name . ' ' . $student->course->name . ' completion is greater than prospectus');
                    } else {
                        dump($ctr . '. ' . $student->student_id . '-' . $student->student->party->name . ' ' . $student->course->name . ' completion is less than prospectus');
                    }
                } else {
                    // dump('equal');
                }
                // dump(count($prospectus->unit_selected));
            }
        }
    }

    public function send_cert($id){
        try {
            $org = TrainingOrganisation::first();
            $certificate = CertificateIssuanceDetail::with('certificte_issuance.completion.details', 'certificte_issuance.completion', 'certificte_issuance.completion.course', 'certificte_issuance.student.party.person', 'certificte_issuance.student.funded_detail')->findOrFail($id);
            $com_status = AvtCompletionStatus::all();
            $statuses = [];
            foreach ($com_status as $cs) {
                $statuses[$cs->id] = $cs->status_code;
            }
            $base_units = $certificate->certificte_issuance->completion->details->count();

            $fullname = $certificate->certificte_issuance->student->party->name;

            if (isset($certificate->certificte_issuance->student->party->person->full_name)) {
                $fullname = $certificate->certificte_issuance->student->party->person->full_name;
            }
            if($certificate->release_date == null){
                $certificate->release_date = Carbon::now()->format('Y-m-d');
                $certificate->release = 0;
                $certificate->update();
            }


            $student = [
                'student_id' => $certificate->certificte_issuance->student->student_id,
                'vetrack' => ($certificate->certificte_issuance->student->funded_detail != null) ? $certificate->certificte_issuance->student->funded_detail->vetrack_id : null,
                'name'       => $fullname,
                'dob'       => $certificate->certificte_issuance->student->party->person->date_of_birth,
                'cert_num'   => $base_units != count($certificate->units) || count($certificate->units)  <= 5 ?  $certificate->soa_number : $certificate->certificte_issuance->manual_cert_num,
                'soa_num'   => $certificate->soa_number,
                'course_code'     => !in_array($certificate->certificte_issuance->completion->course_code, ['@@@@', '1111'])  ? $certificate->certificte_issuance->completion->course->code : '',
                'course_name'     => !in_array($certificate->certificte_issuance->completion->course_code, ['@@@@', '1111']) ? $certificate->certificte_issuance->completion->course->name : 'Unit of Competency',
                'release'   => $certificate->release,
                'release_date'   => $certificate->release_date,
                'reissued'   => $certificate->reissue,
                'reissued_date'   => $certificate->reissued_date,
            ];
            // dump($certificate);
            //  dd($student);
            if (count($certificate->units)  > 15 && count($certificate->units) < 15) {
                $units = array_chunk($certificate->units, 20);
                $font = 10;
            } elseif (count($certificate->units) >= 15) {
                $units = array_chunk($certificate->units, 20);
                $font = 10;
            } else {
                $units[] = $certificate->units;
                $font = 10;
            }

            if (isset($certificate->certificte_issuance->completion->course->code)) {
                if ($certificate->certificte_issuance->completion->course->code == 'CHC30113') {
                    $units = array_chunk($certificate->units, 20);
                    $font = 14;
                }

                if ($certificate->certificte_issuance->completion->course->code == 'CPC50210') {
                    $units = array_chunk($certificate->units, 20);
                    $font = 14;
                }
            } else {
                $units = array_chunk($certificate->units, 20);
                $font = 14;
            }

            // dump($certificate);
            // dd($units);

            // if($student['course_code'] == '1111'){
            //     $student['course_code'] = $units[0][0]['code'];
            //     $student['course_name'] = $units[0][0]['description'];
            // }

            // dump($statuses);
            // dump($student);
            // dd($units);
            //code...
            $student__ = $certificate->certificte_issuance->student;
            $path = storage_path() . '/app/public/student/new/attachments/' . $student__->student_id;
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            

            if (env('APP_NAME') == 'Phoenix') {
                
                if (count($certificate->units)  <= 5) {
                    $cert_template = (count($certificate->units)  <= 5 ? 'custom.pca.certificates.statement_of_attainment' : 'custom.pca.certificates.certificate');
                } else {
                    $cert_template = ($base_units != count($certificate->units) ? 'custom.pca.certificates.statement_of_attainment' : 'custom.pca.certificates.certificate');
                }
                $file_name = $student['name'] . ' - (' . $student['course_code'] . ') ' . $student['course_name'] . '-' . $certificate->soa_number . ".pdf";
               \PDF::loadView($cert_template, compact('student', 'units', 'font', 'statuses'))->setPaper('A4')->save($path . '/'.$file_name);
            } else {
                $cert_template = ($base_units != count($certificate->units) ? 'certificates.statement-of-attainment' : 'certificates.certificate');
                $cert_template = (count($certificate->units)  <= 5 ? 'certificates.statement-of-attainment' : 'certificates.certificate');

                $cert_template = (in_array($student['course_code'], ['1111', '@@@@']) ? 'certificates.statement-of-attainment' : $cert_template);
                $file_name = $student['name'] . ' - (' . $student['course_code'] . ') ' . $student['course_name'].'-'. $certificate->soa_number . ".pdf";

               \PDF::loadView($cert_template, compact('student', 'units', 'font', 'statuses'))->setPaper(array(0, 0, 595, 925))->save($path . '/' . $file_name);;
            }

            $pdf = Storage::size('/public/student/new/attachments/' . $student__->student_id . '/' . $file_name );
            $existattachment = StudentAttachment::where('student_id', $student__->student_id)->where('_input', $certificate->soa_number)->first();
            if ($existattachment == null) {
                $studentAttachment = new StudentAttachment([
                    'name'      => $file_name,
                    'hash_name' => $student['name'] . ' - (' . $student['course_code'] . ') ' . $student['course_name'] . '-' . $certificate->soa_number,
                    'size'      => $pdf,
                    'mime_type' => 'application/pdf',
                    'ext'       => 'pdf',
                    '_input'       => $certificate->soa_number,
                ]);
                // associated user
                $studentAttachment->user()->associate(\Auth::user());
                $studentAttachment->student()->associate($student__->student_id);
                $studentAttachment->save();
                $studentAttachment->path_id = $student__->student_id;
                $studentAttachment->update();
            }

            $content = '<b>Dear ' . $student__->party->name . ',</b><br><br>On behalf of the team at Phoenix College of Australia, we are pleased to inform you that you have successfully completed your course ' . $student['course_code'] . ' ' . $student['course_name'] . '.<br><br><br>We wish you good luck for your future endeavours.<br><br><br>Regards<br><br><b>Admin Team</b><br>Phoenix College of Australia<br>RTO NO: 45633 | CRICOS CODE: 03871F';
            $admin_emails = EmailAutomation::where('addOn', 'send_cer')->pluck('email');
            $send = new AppEmailSendingController;
            $attachment[] =['path'=>$path . '/' . $file_name];
            $s = $send->send_automate('Congratulations on completion of your ' . $student['course_code'] . ' ' . $student['course_name'], $content, ['Phoenix College of Australia' => $org->email_address], [$student__->contact_detail->email], $attachment, $admin_emails);
            if ($s['status'] == 'success') {
                $certificate->sent = 1;
                $certificate->update();
                return response()->json(['status' => 'success', 'message' => 'Successfully send to student']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
            }
        

        } catch (\Throwable $th) {
            // dd('error');
            throw $th;
        }
    }
}
