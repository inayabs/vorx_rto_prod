<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link type="text/css" href="{{public_path()}}/progress-report/style.css" rel="stylesheet" />
	<title>Student Details</title>
    <style>
        .student-details tbody tr td{padding: 0 6px;}
        .student-details tbody tr.header td{padding: 2px 6px;background-color:#656565;color:#fff;}
    </style>
</head>
<body class="exo2-regular position-relative">
	<!-- <div id="page-background" class="overlay">
        <img src="{{public_path()}}/qir-pdf/images/progress-report-bg.jpg" height="100%" width="100%" style="position: absolute; width: 80%;z-index: -1;left: 10%;top:10%;">
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
										<!-- <img src="{{public_path()}}/images/logo/vorx_logo.png" alt=""> -->
                                        <!-- <img src="{{ $logo_url }}" alt=""> -->
                                        <p class="primary-font-color px-16-font text-left line-height-1point2"><span class="europa-bold">RTO Code:</span>  {{ $rto_code }}</p>
									</div>
								</td>
								<td width="50%">
									<p class="primary-font-color px-16-font text-right line-height-1point2 europa-bold">Student Details</p>
								</td>
							</tr>
						</table>
				</div>
				</div>
                <!-- <div class="clearfix" style="height:30px;"></div> -->
				<div class="pdf-wrapper pdf-body">
                    <div class="invoice-header">
                        <table width="100%" class="table student-details px-12-font line-height-1">
                            <tbody>
                                <tr>
                                    <td width="60%" valign="top">
                                        <table width="100%" class="table student-details px-12-font line-height-1">
                                            <tbody>
                                            <tr>
                                                    <td colspan="2" class="primary-font-color text-left europa-bold"><p class="px-16-font">Student</p></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%" class="text-left europa-bold" valign="top">Identifier:</td>
                                                    <td width="65%" class="text-left" valign="top">{{ $info['student_details']['student_id'] }}</td>
                                                </tr>
                                                <!-- <tr>
                                                    <td class="text-left europa-bold" valign="top">Name:</td>
                                                    <td class="text-left" valign="top">{{ $info['details']['prefix'] }} {{ $info['details']['lastname'] }}, {{ $info['details']['firstname'] }}  {{ $info['details']['middlename'] }}</td>
                                                </tr> -->
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Firstname:</td>
                                                    <td class="text-left" valign="top">{{ $info['details']['firstname'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Middle Name:</td>
                                                    <td class="text-left" valign="top">{{ $info['details']['middlename'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Lastname:</td>
                                                    <td class="text-left" valign="top">{{ $info['details']['lastname'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Gender:</td>
                                                    <td class="text-left" valign="top">{{ $info['details']['gender'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">D.O.B.:</td>
                                                    <td class="text-left" valign="top">{{ \Carbon\Carbon::parse($info['details']['date_of_birth'])->format('d/m/Y')}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Residential Address:</td>
                                                    <td class="text-left" valign="top">
                                                        @if($info['st_address'] != '')
                                                            <span>{{ $info['st_address'] }}</span>
                                                        @endif
                                                        @if($info['address'] != '')
                                                            <span>{{ $info['address'] }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($info['contact']['addr_postal_delivery_box'] != '')
                                                    <tr>
                                                        <td class="text-left europa-bold" valign="top">Postal Address:</td>
                                                        <td class="text-left" valign="top">
                                                            <span>{{ $info['contact']['addr_postal_delivery_box'] }}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if($info['telephone'] != '')
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Home Phone:</td>
                                                    <td class="text-left" valign="top">{{ $info['telephone'] }}</td>
                                                </tr>
                                                @endif
                                                @if($info['contact']['phone_work'] != '')
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Work Phone:</td>
                                                    <td class="text-left" valign="top">{{ $info['contact']['phone_work'] }}</td>
                                                </tr>
                                                @endif
                                                @if($info['mobile'] != '')
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Mobile:</td>
                                                    <td class="text-left" valign="top">{{ $info['mobile'] }}</td>
                                                </tr>
                                                @endif
                                                @if($info['email'] != '')
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Email:</td>
                                                    <td class="text-left" valign="top">{{ $info['email'] }}</td>
                                                </tr>
                                                @endif
                                                @if($info['contact']['email_at'] != '')
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Email Alternative:</td>
                                                    <td class="text-left" valign="top">{{ $info['contact']['email_at'] }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">USI:</td>
                                                    <td class="text-left" valign="top">
                                                    @if($info['usi'] != '')
                                                        {{ $info['usi']['unique_student_id'] }}
                                                    @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">USI Verified:</td>
                                                    <td class="text-left" valign="top">
                                                        @if ($info['usi'] != '' && $info['usi']['verified_date'])
                                                            <span>{{ \Carbon\Carbon::parse($info['usi']['verified_date'])->format('d/m/Y h:m:s')}}</span>
                                                        @endif
                                                        @if ($info['usi_verified_by'] != '')
                                                            <span class="europa-bold">by {{ $info['usi_verified_by'] }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="40%" valign="top">
                                        <table width="100%" class="table student-details px-12-font line-height-1">
                                            <tbody>
                                            <tr>
                                                        <td colspan="2"  class="europa-bold primary-font-color" valign="top"><p class="px-16-font">Emergency Contact Details</p> </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%" class="text-left europa-bold" valign="top">Name:</td>
                                                        <td width="65%" class="text-left" valign="top">{{ $info['contact']['emer_name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left europa-bold" valign="top">Address:</td>
                                                        <td class="text-left" valign="top">{{ $info['contact']['emer_address'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left europa-bold" valign="top">Telephone No.:</td>
                                                        <td class="text-left" valign="top">{{ $info['contact']['emer_telephone'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left europa-bold" valign="top">Relationship:</td>
                                                        <td class="text-left" valign="top">{{ $info['contact']['emer_relationship'] }}</td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- <tr>
                                    <td class="text-left europa-bold" valign="top">Study Reason:</td>
                                    <td class="text-left" valign="top">loremssss</td>
                                </tr> -->
                                
                                @if($info['visa_details'] != '')
                                <tr>
                                    <td colspan="2" class="europa-bold primary-font-color" valign="top"> <br> <p class="px-16-font">Visa Details</p> </td>
                                </tr>
                                <tr>
                                    <td class="text-left europa-bold" valign="top">Nationality:</td>
                                    <td class="text-left" valign="top">{{ $info['visa_details']['nationality'] }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left europa-bold" valign="top">Passport No.:</td>
                                    <td class="text-left" valign="top">{{ $info['visa_details']['passport_number'] }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left europa-bold" valign="top">Issue Date:</td>
                                    <td class="text-left" valign="top">
                                    @if($info['visa_details']['issue_date'] != null || $info['visa_details']['issue_date'] != '')
                                        {{ \Carbon\Carbon::parse($info['visa_details']['issue_date'])->format('d/m/Y') }}
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left europa-bold" valign="top">Expiry Date:</td>
                                    <td class="text-left" valign="top">
                                    @if($info['visa_details']['expiry_date'] != null || $info['visa_details']['expiry_date'] != '')
                                        {{ \Carbon\Carbon::parse($info['visa_details']['expiry_date'])->format('d/m/Y') }}
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left europa-bold" valign="top">Visa Type <i>(If not Australian Citizen)</i>:</td>
                                    <td class="text-left" valign="top">{{ $info['visa_type'] }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left europa-bold" valign="top">Expiry Date:</td>
                                    <td class="text-left" valign="top">
                                    @if($info['visa_details']['expiry_date_visa_type'] != null || $info['visa_details']['expiry_date_visa_type'] != '')
                                        {{ \Carbon\Carbon::parse($info['visa_details']['expiry_date_visa_type'])->format('d/m/Y') }}
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left europa-bold" valign="top">Applied for Australian Permanent Residency:</td>
                                    <td class="text-left" valign="top">{{ $info['visa_details']['applied_for_au_residency'] }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left europa-bold" valign="top">Study Rights:</td>
                                    <td class="text-left" valign="top">{{ $info['visa_details']['study_rights'] }}</td>
                                </tr>
                                @endif
                                <!-- AVETMISS -->
                                @if($info['avetmiss'] != null)
                                <tr>
                                    <td colspan="2" class="europa-bold primary-font-color" valign="top"> <br> <p class="px-16-font">Avetmiss</p></td>
                                </tr>
                                <tr>
                                    <td colspan="2" valign="top" width="100%">
                                        <table width="100%" class="table student-details px-12-font line-height-1">
                                            <tbody>
                                                <tr>
                                                    <td width="20%" class="text-left europa-bold" valign="top">Location:</td>
                                                    <td width="30%" class="text-left" valign="top">{{ $info['avetmiss']['location'] }}</td>
                                                    <td width="20%" class="text-left europa-bold" valign="top">School Level Completed:</td>
                                                    <td width="30%" class="text-left" valign="top">{{ $info['avetmiss']['highest_school_level_completed_id'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Indigenous Status:</td>
                                                    <td class="text-left" valign="top">{{ $info['avetmiss']['indigenous_status_id'] }}</td>
                                                    <td class="text-left europa-bold" valign="top">Language Identifier:</td>
                                                    <td class="text-left" valign="top">{{ $info['avetmiss']['language_id'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Labour Force Status:</td>
                                                    <td class="text-left" valign="top">{{ $info['avetmiss']['labour_force_status_id'] }}</td>
                                                    <td class="text-left europa-bold" valign="top">Country of Birth:</td>
                                                    <td class="text-left" valign="top">
                                                        {{ isset($info['avetmiss']['country_id']) && $info['avetmiss']['country_id'] != null ? $info['avetmiss']['country_id']['value'] : '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Disability Flag:</td>
                                                    <td class="text-left" valign="top">

                                                        @if ($info['avetmiss']['disability_flag'] != null)
                                                            @if($info['avetmiss']['disability_flag'] == 'Y')
                                                                <span>YES</span>
                                                            @elseif($info['avetmiss']['disability_flag'] == 'N')
                                                                <span>NO</span>
                                                            @endif
                                                        @else
                                                            <span> </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-left europa-bold" valign="top">Prior Education Achievement:</td>
                                                    <td class="text-left" valign="top">
                                                        @if ($info['avetmiss']['prior_educational_achievement_flag'] != null)
                                                            @if($info['avetmiss']['prior_educational_achievement_flag'] == 'Y')
                                                                <span>YES</span>
                                                            @elseif($info['avetmiss']['prior_educational_achievement_flag'] == 'N')
                                                                <span>NO</span>
                                                            @endif
                                                        @else
                                                            <span> </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">Disability Identifier:</td>
                                                    <td class="text-left" valign="top">
                                                    {{ $info['avetmiss']['disability_ids'] }}
                                                    </td>
                                                    <td class="text-left europa-bold" valign="top">Prior Education Achievement Identifier:</td>
                                                    <td class="text-left" valign="top">{{ $info['avetmiss']['prior_educational_achievement_ids'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left europa-bold" valign="top">At School:</td>
                                                    <td class="text-left" valign="top">
                                                        @if ($info['avetmiss']['at_school_flag'] != null)
                                                            @if($info['avetmiss']['at_school_flag'] == 'Y')
                                                                <span>YES</span>
                                                            @elseif($info['avetmiss']['at_school_flag'] == 'N')
                                                                <span>NO</span>
                                                            @endif
                                                        @else
                                                            <span> </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-left europa-bold" valign="top">Year Completed:</td>
                                                    <td class="text-left" valign="top">{{ $info['avetmiss']['year_completed'] != null ? $info['avetmiss']['year_completed'] : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <!-- <td class="text-left europa-bold" valign="top">Unique Student ID:</td>
                                                    <td class="text-left" valign="top">{{ $info['avetmiss']['location'] }}</td> -->
                                                    <td class="text-left europa-bold" valign="top">Survey Contact Status:</td>
                                                    <td class="text-left" valign="top">{{ $info['avetmiss']['survey_contact_status'] }}</td>
                                                    <td class="text-left europa-bold" valign="top">Institute:</td>
                                                    <td class="text-left" valign="top">
                                                    {{ $info['avetmiss']['institute'] != null ? $info['avetmiss']['institute'] : '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                <td class="text-left europa-bold" valign="top">Statistical Area Level 1:</td>
                                                    <td class="text-left" valign="top">
                                                    {{ $info['avetmiss']['statistical_area_level_1_id'] != null ? $info['avetmiss']['statistical_area_level_1_id'] : '' }}
                                                    </td>
                                                    <td class="text-left europa-bold" valign="top">Statistical Area Level 2:</td>
                                                    <td class="text-left" valign="top">{{ $info['avetmiss']['statistical_area_level_2_id'] != null ? $info['avetmiss']['statistical_area_level_2_id'] : '' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="2" class="europa-bold primary-font-color" valign="top"> <br> <p class="px-16-font">Enrolments</p> </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> 
                                        <table width="100%" class="table student-details px-14-font line-height-1">
                                            <tbody>
                                                <tr class="header">
                                                    <td width="10%" class="europa-bold">Commence</td>
                                                    <td width="10%" class="europa-bold">Complete</td>
                                                    <td width="10%" class="europa-bold">AISS</td>
                                                    <td width="10%" class="europa-bold">Course Fee</td>
                                                    <td width="10%" class="europa-bold">Status</td>
                                                    <td width="20%" class="europa-bold">Study Reason</td>
                                                    <td width="40%" class="europa-bold">Course</td>
                                                </tr>
                                                @if(count($info['courses']) != 0)
                                                @foreach($info['courses'] as $course)
                                                <tr>
                                                    <td valign="top">{{ \Carbon\Carbon::parse($course['start_date'])->format('d/m/Y')}}</td>
                                                    <td valign="top">{{ \Carbon\Carbon::parse($course['end_date'])->format('d/m/Y')}}</td>
                                                    <td valign="top">
                                                    @if($course['aiss_date'] != null || $course['aiss_date'] != '')
                                                        {{ \Carbon\Carbon::parse($course['aiss_date'])->format('d/m/Y') }}
                                                    @endif
                                                    </td>
                                                    <td valign="top" class="text-right">{{ $course['course_fee'] }}</td>
                                                    <td valign="top">{{ $course['status'] }}</td>
                                                    <td valign="top">{{ $course['study_reason'] }}</td>
                                                    <td valign="top">{{ $course['course_name'] }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
			<div class="pdf-footer">
						<table width="100%">
							<tr>
								<td>
									<div class="footer bottom-placement px-10-font text-center primary-font-color">
										<!-- <p style="margin-bottom: 2px;">© Elite Training Institute | Invoice Version 1.1 | RTO No. 40965 | RTO CRICOS Code 03470A</p> -->
										<p style="margin-bottom: 2px;">© VORX RTO | Student Details</p>
										<p class=" px-10-font europa-bold">Page 1 of 1</p>
									</div>
								</td>
							</tr>
						</table>
				    </div>
		</div>
	</div>
</body>

{{-- 
    <body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper proximanova-regular">
				<div class="pdf-header">
                  <div>
						<table width="100%">
							<tr>
								<td width="50%">
									<div class="eti-logo">
                                        <p class="primary-font-color px-16-font text-left line-height-1point2"><span class="europa-bold">RTO Code:</span>  {{ $rto_code }}</p>
									</div>
								</td>
								<td width="50%">
									<p class="primary-font-color px-16-font text-left line-height-1point2 europa-bold">Student Details</p>
								</td>
							</tr>
						</table>
				</div>
				</div>
                <!-- <div class="clearfix" style="height:30px;"></div> -->
				<div class="pdf-wrapper pdf-body">
                    <div class="invoice-header">
                        <table width="100%" class="table student-details px-14-font line-height-1">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <table width="100%" class="table student-details px-14-font line-height-1">
                                            @if(count($info['courses']) != 0)
                                                @foreach($info['courses'] as $course)
                                                    @if($course['remarks'] != '')
                                                    <tr>
                                                        <td colspan="2" class="europa-bold" valign="top"><p class="px-20-font">Comment</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%" class="europa-bold" valign="top">{{ $course['course_code'] }}</td>
                                                        <td width="70%" valign="top">{{ $course['remarks'] }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="europa-bold primary-font-color" valign="top"> <br> <p class="px-20-font">Enrolments</p> </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> 
                                        <table width="100%" class="table student-details px-14-font line-height-1">
                                            <tbody>
                                                <tr class="header">
                                                    <td width="15%" class="europa-bold">Commence</td>
                                                    <td width="15%" class="europa-bold">Complete</td>
                                                    <td width="15%" class="europa-bold">AISS</td>
                                                    <td width="15%" class="europa-bold">Status</td>
                                                    <td width="45%" class="europa-bold">Course</td>
                                                </tr>
                                                @if(count($info['courses']) != 0)
                                                @foreach($info['courses'] as $course)
                                                <tr>
                                                    <td valign="top">{{ \Carbon\Carbon::parse($course['start_date'])->format('d/m/Y')}}</td>
                                                    <td valign="top">{{ \Carbon\Carbon::parse($course['end_date'])->format('d/m/Y')}}</td>
                                                    <td valign="top">
                                                    @if($course['aiss_date'] != null || $course['aiss_date'] != '')
                                                        {{ \Carbon\Carbon::parse($course['aiss_date'])->format('d/m/Y') }}
                                                    @endif
                                                    </td>
                                                    <td valign="top">{{ $course['status'] }}</td>
                                                    <td valign="top">{{ $course['course_name'] }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
			<div class="pdf-footer">
						<table width="100%">
							<tr>
								<td>
									<div class="footer bottom-placement px-10-font text-center primary-font-color">
										<!-- <p style="margin-bottom: 2px;">© Elite Training Institute | Invoice Version 1.1 | RTO No. 40965 | RTO CRICOS Code 03470A</p> -->
										<p style="margin-bottom: 2px;">© VORX RTO | Student Details</p>
										<p class=" px-10-font europa-bold">Page 2 of 2</p>
									</div>
								</td>
							</tr>
						</table>
				    </div>
		</div>
	</div>
</body>    
--}}
</html>