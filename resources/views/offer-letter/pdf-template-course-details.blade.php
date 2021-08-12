<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="{{public_path()}}/css/offer_letter/pdf-style-v2.css" rel="stylesheet" />
    <title>Student Payment Schedule Of Course Fees</title>

<body class="exo2-regular position-relative">
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper">
                <div style="border-bottom: 5px solid #09455e; padding-bottom: 10px;  margin: 0 10px;">
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <div class="eti-logo">
									{{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
											<img class="img-profile img-fluid w-75" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
										@else
											
                                        @endif --}}
                                        <img src="{{public_path()}}/images/logo/vorx_logo.png"  class="img-profile img-fluid w-75" alt="">
                                </div>
                            </td>
                            <td width="50%">
                                <p class="blue-font-color px-16-font text-right line-height-1">OFFER LETTER AND ENROLMENT<br>ACCEPTANCE</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="pdf-wrapper">
                    <div class="cleafix" style="height: 5px;"></div>
                    <div class="content">
                        <h2 class="blue-font-color px-16-font">STUDENT INSTALLMENT PLAN OF COURSE FEES {{$offerData->course->code}} - {{strtoupper($offerData->course->name)}}</h2>
                        <div class="cleafix" style="height: 5px;"></div>
                        <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Date of Issue:</td>
                                    <td width="35%">{{Carbon\Carbon::parse($offerData->offer_letter->issued_date)->format('d/m/Y')}}</td>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Student ID:</td>
                                    {{-- <td width="35%">{{$offerData['student_id'] ? $offerData['student_id'] : 'ETI-'.$offerData['old_id']}}</td> --}}
                                    <td width="35%">{{$offerData->offer_letter->student_id ? $offerData->offer_letter->student_id : '12121-'.$offerData->offer_letter->old_id}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Student Name:</td>
                                    <td width="85%">{{$offerData->offer_letter->student->party->name}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Date of Birth:</td>
                                    <td width="35%">{{Carbon\Carbon::parse($offerData->offer_letter->student->party->person->date_of_birth)->format('d/m/Y')}}</td>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Email address:</td>
                                    <td width="35%">{{$offerData->offer_letter->student_details->email_personal}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Address:</td>
                                    <td width="85%">{{$offerData->offer_letter->student_details->current_address}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" class="package-course">
                            <tbody>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Name of the Agent’s company</td>
                                    <td class="blue-bg-color white-font-color text-center" width="15%">Email of the agent:</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cleafix" style="height: 15px;"></div>


                        <table width="100%" class="package-course">
                            <thead>
                                <tr>
                                    <th class="proximanova-bold line-height-1point2 text-center px-11-font" colspan="2" style="padding: 10px;">Balance due after the initial<br>payment: AUD {{number_format($offerData->tuition_fees, 2)}}<br>(rest amount to be paid in monthly instalments after commencement of the first course)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $breakdowns as $bd)
                                <tr>
                                    <td class="text-center">{{$bd['due_date']}}</td>
                                    <td class="text-center">{{$bd['payable']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="blue-bg-color white-font-color text-center px-11-font" colspan="2" style="padding: 3px;">Proposed Course End Date: {{\Carbon\Carbon::parse($offerData['course_details'][0]['course_end_date'])->format('d/m/Y')}}</td>
                                </tr>
                            </tfoot>
                        </table>
                        <p class="px-10-font text-justify line-height-1point2">Please be advised that the student will be provided with the installment plans before the commencement of the next course. </p>

                        <div class="clearfix" style="height: 30px;"></div>
                        @if($page == 1)
                        <table width="100%">
                            <tr>
                                <td>
                                    <div>
                                        <h2 class="blue-font-color px-14-font">DECLARATION AND ACCEPTANCE BY APPLICANT: </h2>
                                        <div class="clearfix" style="height: 5px;"></div>
                                        <p class="px-11-font">• I, <span class="blue-font-color">{{$offerData['student']['party']['name']}}</span></p>
                                        <p class="px-11-font line-height-1point2"> agree that by signing this declaration, I am accepting the above payment terms and conditions as outlined within this Offer letter. </p>
                                        <div class="clearfix" style="height: 5px;"></div>
                                        <p class="px-11-font line-height-1point2">• I understand that my weekly payable tuition fees for the study period are calculated as:</p>
                                        <div class="clearfix" style="height: 5px;"></div>
                                        <table width="60%">
                                            <tr>
                                                <td class="text-center px-10-font">
                                                    <div class="line-height-1">Total Tuition Fees</div>
                                                    <div class="line-height-1">----------------------------------</div>
                                                    <div class="line-height-1">Total duration (No. of weeks)</div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="clearfix" style="height: 5px;"></div>
                                        <p class="px-11-font line-height-1point2">• I understand that I have to keep paying the agreed amount according to the student instalment plans for the future
                                            course(s).</p>


                                        <div class="clearfix" style="height: 10px;"></div>
                                        <p class="px-11-font">Signed by Applicant:.........................................................................................................</p>
                                        <p class="px-11-font">Date: </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        @endif
                    </div>
                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p>©  {{ $app_settings[0]->training_organisation_name }} - Offer Letter And Enrolment Acceptance Conditional Version 1.4 | RTO {{ $app_settings[0]->training_organisation_id }} | CRICOS No. 03470A</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>