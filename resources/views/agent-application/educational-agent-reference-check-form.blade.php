<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="{{public_path()}}/agent-application/pdf-style.css" rel="stylesheet" />
    <title>Online Agent Application</title>
</head>

<!-- Page 1 of 1 -->

<body>
    <div>
        <div class="col-xs-12 no-padding">
            <div class="pdf-wrapper">
                <div style="padding-bottom: 10px;  margin: 0 30px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="20%">
                                <div class="logo">
                                    <img src="{{public_path()}}/agent-application/images/vorx_logo.png" alt="">
									<!-- <img src="{{ $logo_url }}" alt=""> -->
                                </div>
                            </td>
                            <td width="80%">
                                <p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Education Agent Reference Check Form</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div style="padding-bottom: 10px;  margin: 0 30px;">

                    <div class="content">
                        <table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td colspan="2" class="primary-bg-color white-font-color px-12-font proximanova-bold">Agent’s Details</td>
                            </tr>
                            <tr>
                                <td width="15%" class="px-12-font proximanova-bold">Agent Name:</td>
                                <td width="85%" class="px-12-font">
                                @if(isset($application['agent_name']) && $application['agent_name'] !== null)
									{{$application['agent_name']}}
								@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font proximanova-bold">Agent Address:</td>
                                <td class="px-12-font">
                                @if(isset($application['agent_address']) && $application['agent_address'] !== null)
									{{$application['agent_address']}}
								@endif
                                </td>
                            </tr>
                        </table>
                        <table width="100%" class="table-bordered border-top-none" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="px-12-font proximanova-bold border-top-none" width="15%">Contact Number:</td>
                                <td class="px-12-font border-top-none" width="35%">
                                @if(isset($application['contact_no']) && $application['contact_no'] !== null)
									{{$application['contact_no']}}
								@endif
                                </td>
                                <td class="px-12-font proximanova-bold border-top-none" width="10%">Email:</td>
                                <td class="px-12-font border-top-none" width="40%">
                                @if(isset($application['agent_email']) && $application['agent_email'] !== null)
									{{$application['agent_email']}}
								@endif
                                </td>
                            </tr>
                        </table>
                        <table width="100%" class="table-bordered border-top-none" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td colspan="2" class="primary-bg-color white-font-color px-12-font proximanova-bold border-top-none">Referee Details (referee to complete)</td>
                            </tr>
                            <tr>
                                <td width="25%" class="px-12-font proximanova-bold">Organisation Name:</td>
                                <td width="75%" class="px-12-font">
                                @if(isset($application['ref_organization_name']) && $application['ref_organization_name'] !== null)
									{{$application['ref_organization_name']}}
								@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font proximanova-bold">Address:</td>
                                <td class="px-12-font">
                                @if(isset($application['ref_address']) && $application['ref_address'] !== null)
									{{$application['ref_address']}}
								@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font proximanova-bold">Contact Person:</td>
                                <td class="px-12-font">
                                @if(isset($application['ref_contact_person']) && $application['ref_contact_person'] !== null)
									{{$application['ref_contact_person']}}
								@endif
                                </td>
                            </tr>
                        </table>
                        <table width="100%" class="table-bordered border-top-none" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="px-12-font proximanova-bold border-top-none" width="25%">Phone:</td>
                                <td class="px-12-font border-top-none" width="25%">
                                @if(isset($application['ref_phone_no']) && $application['ref_phone_no'] !== null)
									{{$application['ref_phone_no']}}
								@endif
                                </td>
                                <td class="px-12-font proximanova-bold border-top-none" width="10%">Email:</td>
                                <td class="px-12-font border-top-none" width="40%">
                                @if(isset($application['ref_email']) && $application['ref_email'] !== null)
									{{$application['ref_email']}}
								@endif
                                </td>
                            </tr>
                        </table>
                        <table width="100%" class="table-bordered border-top-none" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="75%" class="px-12-font border-top-none">How long has the agent been associated with your organisation for?</td>
                                <td width="25%" class="px-12-font border-top-none">
                                @if(isset($application['how_long']) && $application['how_long'] !== null)
									{{$application['how_long']}}
								@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font">How many students has the agent enrolled with your organisation (approx.)?</td>
                                <td class="px-12-font">
                                @if(isset($application['how_many_student_enrolled']) && $application['how_many_student_enrolled'] !== null)
									{{$application['how_many_student_enrolled']}}
								@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font">How many students from these were cancelled with your organisation (approx.)?</td>
                                <td class="px-12-font">
                                @if(isset($application['how_many_student_cancelled']) && $application['how_many_student_cancelled'] !== null)
									{{$application['how_many_student_cancelled']}}
								@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font">Are there any complaints from students or other agents about this agent?</td>
                                <td class="px-12-font">
                                    <table width="80%" class="border-none" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
                                        <tr>
                                            <td width="50%" class="border-none">
                                                @if(isset($application['any_complaints']) && $application['any_complaints'] == 'Yes')
                                                    <div class="checkbox checked"><label class="label label-checkbox black-font-color"> Yes</label></div>
                                                @else
                                                    <div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
                                                @endif
                                            </td>
                                            <td width="50%" class="border-none">
                                                @if(isset($application['any_complaints']) && $application['any_complaints'] == 'No')
                                                    <div class="checkbox checked"><label class="label label-checkbox black-font-color"> No</label></div>
                                                @else
                                                    <div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font">Accurate and ethical marketing information provided by the agent about courses offered, fees, refund policy etc.</td>
                                <td class="px-12-font">
                                    <table width="80%" class="border-none" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
                                        <tr>
                                            <td width="50%" class="border-none">
                                                @if(isset($application['accurate_and_ethical']) && $application['accurate_and_ethical'] == 'Yes')
                                                    <div class="checkbox checked"><label class="label label-checkbox black-font-color"> Yes</label></div>
                                                @else
                                                    <div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
                                                @endif
                                            </td>
                                            <td width="50%" class="border-none">
                                                @if(isset($application['accurate_and_ethical']) && $application['accurate_and_ethical'] == 'No')
                                                    <div class="checkbox checked"><label class="label label-checkbox black-font-color"> No</label></div>
                                                @else
                                                    <div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font">Would you recommend us to collaborate with this agent?</td>
                                <td class="px-12-font">
                                    <table width="80%" class="border-none" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
                                        <tr>
                                            <td width="50%" class="border-none">
                                                @if(isset($application['would_you_recommend']) && $application['would_you_recommend'] == 'Yes')
                                                    <div class="checkbox checked"><label class="label label-checkbox black-font-color"> Yes</label></div>
                                                @else
                                                    <div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
                                                @endif
                                            </td>
                                            <td width="50%" class="border-none">
                                                @if(isset($application['would_you_recommend']) && $application['would_you_recommend'] == 'No')
                                                    <div class="checkbox checked"><label class="label label-checkbox black-font-color"> No</label></div>
                                                @else
                                                    <div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font border-bottom-none" colspan="2">Any additional Comments?</td>
                            </tr>
                            <tr>
                                <td class="px-12-font border-top-none text-justify" colspan="2">
                                @if(isset($application['comments']) && $application['comments'] !== null)
									{{$application['comments']}}
								@endif
                                </td>
                            </tr>
                        </table>
                        <table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td colspan="4" class="primary-bg-color white-font-color px-12-font proximanova-bold">Declaration</td>
                            </tr>
                            <tr>
                                <td width="20%" class="px-12-font proximanova-bold">Referee Name:</td>
                                <td width="80%" class="px-12-font" colspan="3">
                                @if(isset($application['comments']) && $application['comments'] !== null)
									{{$application['comments']}}
								@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-12-font proximanova-bold border-top-none" width="20%">Signature:</td>
                                <td class="px-12-font border-top-none" width="30%">
                                @if(isset($type_signature) && $type_signature != null)
									<!-- <img src="{{ $type_signature }}" alt="" style="width: 300px;margin-top: -40px;"> -->
									<div class="type-signature px-18-font" style="margin-top: -12px;">{{isset($type_signature) ? $type_signature : ''}}</div>
									@endif
                                </td>
                                <td class="px-12-font proximanova-bold border-top-none" width="10%">Date:</td>
                                <td class="px-12-font border-top-none" width="40%">
                                @if(isset($application['applicant_date']) && $application['applicant_date'] !== null)
										{{ \Carbon\Carbon::parse($application['applicant_date'])->format('d/m/Y') }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p style="margin-bottom: 2px;">V1.0 | RTO No. {{$org->training_organisation_id}} | CRICOS Code {{$org->cricos_code}}</p>
                        <p style="margin-bottom: 0px;"> Page 1 of 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- End Page 1 of 1 -->


</html>