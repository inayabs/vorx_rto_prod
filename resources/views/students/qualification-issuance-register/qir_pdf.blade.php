<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="{{public_path()}}/progress-report/style.css" rel="stylesheet" />
    <title>Qualification Issuance Register</title>
</head>
@php
$ctr = 1;
@endphp
@if($page > 1)
@foreach($student_completion_lists as $k => $scl_chunk)
<body class="exo2-regular position-relative">
    <!-- <div id="page-background" class="overlay">
        <img src="{{public_path()}}/qir-pdf/images/progress-report-bg.jpg" height="100%" width="100%" style="position: absolute; width: 40%;z-index: -1;left: 30%;top:10%;">
     </div>  -->
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper proximanova-regular">
                <div class="pdf-header">
                    <div>
                        <table width="100%">
                            <tr>
                                <td width="50%">
                                    <div class="eti-logo">
                                        <img src="{{public_path()}}/images/logo/vorx_logo.png" alt="">
                                        <!-- <img src="{{ $logo_url }}" alt=""> -->
                                    </div>
                                </td>
                                <td width="50%">
                                    <p class="primary-font-color px-16-font text-right line-height-1point2 europa-bold">
                                        QUALIFICATION ISSUANCE REGISTER</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="pdf-wrapper pdf-body">
                    <table width="100%" class="green-bordered-table">
                        <tbody>
                            <tr>
                                <td class="text-center primary-bg-color" colspan="5"><span
                                        class="europa-bold white-font-color">QUALIFICATION ISSUANCE REGISTER</span></td>
                                <td class="text-center primary-bg-color" colspan="2"><span
                                        class="europa-bold white-font-color">CERTIFICATE</span></td>
                                <td class="text-center primary-bg-color" colspan="2"><span
                                        class="europa-bold white-font-color">RECORD OF RESULT</span></td>
                                <td class="text-center primary-bg-color" colspan="2"><span
                                        class="europa-bold white-font-color">STATEMENT OF ATTAINMENT</span></td>
                            </tr>
                            <tr class="px-10-font">
                                <td class="text-center primary-bg-color" width="5%"><span class="europa-bold white-font-color">SR.
                                    </span></td>
                                <td class="text-center primary-bg-color" width="10%"><span
                                        class="europa-bold white-font-color">STUDENT NAME</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span
                                        class="europa-bold white-font-color">STUDENT ID</span> </td>
                                <td class="text-center primary-bg-color" width="18%"><span
                                        class="europa-bold white-font-color">QUALIFICATION / UNIT</span> </td>
                                <td class="text-center primary-bg-color" width="10%"><span class="europa-bold white-font-color">CODE
                                    </span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span
                                        class="europa-bold white-font-color">CERTIFICATE NO.</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span class="europa-bold white-font-color">DATE
                                        ISSUED</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span
                                        class="europa-bold white-font-color">CERTIFICATE NO.</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span class="europa-bold white-font-color">DATE
                                        ISSUED</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span class="europa-bold white-font-color">SOA
                                        NO.</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span class="europa-bold white-font-color">DATE
                                        ISSUED</span> </td>
                            </tr>
                            @foreach($scl_chunk as $scl)
                            <tr>
                                <td class="text-center" width="5%" valign="top">{{ $ctr }}</td>
                                <td valign="top">{{ $scl['fullname'] }}</td>
                                <td valign="top">{{ $scl['student_id'] }}</td>
                                <td valign="top">{{ $scl['qualification'] }}</td>
                                <td valign="top">{{ $scl['course_code'] }}</td>
                                <td valign="top">{{ $scl['cert_no'] }}</td>
                                <td valign="top">{{ $scl['date_issued'] }}</td>
                                <td valign="top">{{ $scl['rr_cert_no'] }}</td>
                                <td valign="top">{{ $scl['rr_date_issued'] }}</td>
                                <td valign="top">{{ $scl['soa_no'] }}</td>
                                <td valign="top">{{ $scl['soa_date_issued'] }}</td>
                            </tr>
                            @php $ctr++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pdf-footer">
                <table width="100%">
                    <tr>
                        <td>
                            <div class="footer bottom-placement px-10-font text-center primary-font-color">
                                <p style="margin-bottom: 2px;">© VORX RTO | Qualification Issuance Register</p>
                                <!-- <p class=" px-10-font europa-bold">Page 2 of 2</p> -->
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
@endforeach
@endif
@if($page == 1)
<body class="exo2-regular position-relative">
    <!-- <div id="page-background" class="overlay">
        <img src="{{public_path()}}/qir-pdf/images/progress-report-bg.jpg" height="100%" width="100%" style="position: absolute; width: 40%;z-index: -1;left: 30%;top:10%;">
     </div>  -->
    <div>
        <div class="col-xs-12 no-padding position-relative">
            <div class="pdf-wrapper proximanova-regular">
                <div class="pdf-header">
                    <div>
                        <table width="100%">
                            <tr>
                                <td width="50%">
                                    <div class="eti-logo">
                                        <img src="{{public_path()}}/images/logo/vorx_logo.png" alt="">
                                        <!-- <img src="{{ $logo_url }}" alt=""> -->
                                    </div>
                                </td>
                                <td width="50%">
                                    <p class="primary-font-color px-16-font text-right line-height-1point2 europa-bold">
                                        QUALIFICATION ISSUANCE REGISTER</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="pdf-wrapper pdf-body">
                    <table width="100%" class="green-bordered-table">
                        <tbody>
                            <tr>
                                <td class="text-center primary-bg-color" colspan="5"><span
                                        class="europa-bold white-font-color">QUALIFICATION ISSUANCE REGISTER</span></td>
                                <td class="text-center primary-bg-color" colspan="2"><span
                                        class="europa-bold white-font-color">CERTIFICATE</span></td>
                                <td class="text-center primary-bg-color" colspan="2"><span
                                        class="europa-bold white-font-color">RECORD OF RESULT</span></td>
                                <td class="text-center primary-bg-color" colspan="2"><span
                                        class="europa-bold white-font-color">STATEMENT OF ATTAINMENT</span></td>
                            </tr>
                            <tr class="px-10-font">
                                <td class="text-center primary-bg-color" width="5%"><span class="europa-bold white-font-color">SR.
                                    </span></td>
                                <td class="text-center primary-bg-color" width="10%"><span
                                        class="europa-bold white-font-color">STUDENT NAME</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span
                                        class="europa-bold white-font-color">STUDENT ID</span> </td>
                                <td class="text-center primary-bg-color" width="18%"><span
                                        class="europa-bold white-font-color">QUALIFICATION / UNIT</span> </td>
                                <td class="text-center primary-bg-color" width="10%"><span class="europa-bold white-font-color">CODE
                                    </span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span
                                        class="europa-bold white-font-color">CERTIFICATE NO.</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span class="europa-bold white-font-color">DATE
                                        ISSUED</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span
                                        class="europa-bold white-font-color">CERTIFICATE NO.</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span class="europa-bold white-font-color">DATE
                                        ISSUED</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span class="europa-bold white-font-color">SOA
                                        NO.</span> </td>
                                <td class="text-center primary-bg-color" width="8%"><span class="europa-bold white-font-color">DATE
                                        ISSUED</span> </td>
                            </tr>
                            @foreach($student_completion_lists[0] as $scl)
                            <tr>
                                <td class="text-center" width="5%" valign="top">{{ $ctr }}</td>
                                <td valign="top">{{ $scl['fullname'] }}</td>
                                <td valign="top">{{ $scl['student_id'] }}</td>
                                <td valign="top">{{ $scl['qualification'] }}</td>
                                <td valign="top">{{ $scl['course_code'] }}</td>
                                <td valign="top">{{ $scl['cert_no'] }}</td>
                                <td valign="top">{{ $scl['date_issued'] }}</td>
                                <td valign="top">{{ $scl['rr_cert_no'] }}</td>
                                <td valign="top">{{ $scl['rr_date_issued'] }}</td>
                                <td valign="top">{{ $scl['soa_no'] }}</td>
                                <td valign="top">{{ $scl['soa_date_issued'] }}</td>
                            </tr>
                            @php $ctr++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pdf-footer">
                <table width="100%">
                    <tr>
                        <td>
                            <div class="footer bottom-placement px-10-font text-center primary-font-color">
                                <p style="margin-bottom: 2px;">© VORX RTO | Qualification Issuance Register</p>
                                <!-- <p class=" px-10-font europa-bold">Page 2 of 2</p> -->
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
@endif
</html>