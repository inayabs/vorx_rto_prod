<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/agent-application/pdf-style.css" rel="stylesheet" />
	<title>Online Agent Application</title>
</head>

<!-- Page 1 of 2 -->

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
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Representative/Education Agent Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="30%" class="primary-bg-color white-font-color px-12-font proximanova-bold">Name of the company</td>
								<td width="70%" class="px-12-font">
								@if(isset($application['name_of_company']) && $application['name_of_company'] !== null)
									{{$application['name_of_company']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">ABN</td>
								<td class="px-12-font">
								@if(isset($application['abn']) && $application['abn'] !== null)
									{{$application['abn']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Name of the contact person</td>
								<td class="px-12-font">
								@if(isset($application['name_of_contact_person']) && $application['name_of_contact_person'] !== null)
									{{$application['name_of_contact_person']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Position</td>
								<td class="px-12-font">
								@if(isset($application['position']) && $application['position'] !== null)
									{{$application['position']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">Migration Agent Registration Authority Number (MARN)/QEAC (if applicable)</td>
								<td class="px-12-font">
								@if(isset($application['marn']) && $application['marn'] !== null)
									{{$application['marn']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Address</td>
								<td class="px-12-font">
								@if(isset($application['address']) && $application['address'] !== null)
									{{$application['address']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Phone No</td>
								<td class="px-12-font">
								@if(isset($application['phone_no']) && $application['phone_no'] !== null)
									{{$application['phone_no']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Mobile No</td>
								<td class="px-12-font">
								@if(isset($application['mobile_no']) && $application['mobile_no'] !== null)
									{{$application['mobile_no']}}
								@endif
								</td>
							</tr>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Email</td>
								<td class="px-12-font">
								@if(isset($application['agent_email']) && $application['agent_email'] !== null)
									{{$application['agent_email']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">How long has been your business operating? </td>
								<td class="px-12-font">
								@if(isset($application['how_long']) && $application['how_long'] !== null)
									{{$application['how_long']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">Number of international students recruited for study in Australia each year</td>
								<td class="px-12-font">
								@if(isset($application['no_of_int_students']) && $application['no_of_int_students'] !== null)
									{{$application['no_of_int_students']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">List of other institutions you are currently representing in Australia</td>
								<td class="px-12-font">
								@if(isset($application['list_of_institutions']) && $application['list_of_institutions'] !== null)
									{{$application['list_of_institutions']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">List the courses you usually promote and enrol students into</td>
								<td class="px-12-font">
								@if(isset($application['list_the_course']) && $application['list_the_course'] !== null)
									{{$application['list_the_course']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">List of countries you operate from</td>
								<td class="px-12-font">
								@if(isset($application['list_the_countries']) && $application['list_the_countries'] !== null)
									{{$application['list_the_countries']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">What services do you provide to the international students?</td>
								<td class="px-12-font">
								@if(isset($application['what_services']) && $application['what_services'] !== null)
									{{$application['what_services']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">Do you charge students additional fees for the above services?</td>
								<td class="px-12-font">
								@if(isset($application['do_you_charge_students']) && $application['do_you_charge_students'] !== null)
									{{$application['do_you_charge_students']}}
								@endif
								</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 20px;"></div>

						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td colspan="2" class="px-14-font proximanova-bold">REFEREES: Please indicate two referees from Australian educational institutions that you represent.</td>
							</tr>
							<tr>
								<td colspan="2" class="px-14-font proximanova-bold">Reference 1</td>
							</tr>
							<tr>
								<td width="30%" class="primary-bg-color white-font-color px-12-font proximanova-bold">Organization Name</td>
								<td width="70%" class="px-12-font">
								@if(isset($application['ref1_organization_name']) && $application['ref1_organization_name'] !== null)
									{{$application['ref1_organization_name']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Contact Person</td>
								<td class="px-12-font">
								@if(isset($application['ref1_contact_person']) && $application['ref1_contact_person'] !== null)
									{{$application['ref1_contact_person']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Position</td>
								<td class="px-12-font">
								@if(isset($application['ref1_position']) && $application['ref1_position'] !== null)
									{{$application['ref1_position']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Address</td>
								<td class="px-12-font">
								@if(isset($application['ref1_address']) && $application['ref1_address'] !== null)
									{{$application['ref1_address']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Telephone</td>
								<td class="px-12-font">
								@if(isset($application['ref1_telephone']) && $application['ref1_telephone'] !== null)
									{{$application['ref1_telephone']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Email</td>
								<td class="px-12-font">
								@if(isset($application['ref1_email']) && $application['ref1_email'] !== null)
									{{$application['ref1_email']}}
								@endif
								</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 10px;"></div>

						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td colspan="2" class="px-14-font proximanova-bold">Reference 2</td>
							</tr>
							<tr>
								<td width="30%" class="primary-bg-color white-font-color px-12-font proximanova-bold">Organization Name</td>
								<td width="70%" class="px-12-font">
								@if(isset($application['ref2_organization_name']) && $application['ref2_organization_name'] !== null)
									{{$application['ref2_organization_name']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Contact Person</td>
								<td class="px-12-font">
								@if(isset($application['ref2_contact_person']) && $application['ref2_contact_person'] !== null)
									{{$application['ref2_contact_person']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Position</td>
								<td class="px-12-font">
								@if(isset($application['ref2_position']) && $application['ref2_position'] !== null)
									{{$application['ref2_position']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Address</td>
								<td class="px-12-font">
								@if(isset($application['ref2_address']) && $application['ref2_address'] !== null)
									{{$application['ref2_address']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Telephone</td>
								<td class="px-12-font">
								@if(isset($application['ref2_telephone']) && $application['ref2_telephone'] !== null)
									{{$application['ref2_telephone']}}
								@endif
								</td>
							</tr>
							<tr>
								<td class="primary-bg-color white-font-color px-12-font proximanova-bold">Email</td>
								<td class="px-12-font">
								@if(isset($application['ref2_email']) && $application['ref2_email'] !== null)
									{{$application['ref2_email']}}
								@endif
								</td>
							</tr>
						</table>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. {{$org->training_organisation_id}} | CRICOS Code {{$org->cricos_code}}</p>
						<p style="margin-bottom: 0px;"> Page 1 of 2</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 2 -->

<!-- Page 2 of 2 -->

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
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Representative/Education Agent Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content">
						<p class="primary-font-color px-20-font proximanova-bold">Checklist and Declaration</p>
						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td colspan="2" class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">Checklist: Your application will be assessed on the quality of the supporting documentation you provide, so please be as thorough as possible.</td>
							</tr>
							<tr>
								<td width="5%" class="px-12-font proximanova-bold">
									@if(isset($application['checklist1']) && $application['checklist1'] == 'True')
										<div class="checkbox checked" style="margin-bottom: 0; margin-left: 15px"></div>
									@else
										<div class="checkbox" style="margin-bottom: 0; margin-left: 15px"></div>
                                    @endif
								</td>
								<td width="95%" class="px-12-font">Have you completed all relevant sections of the application form?</td>
							</tr>
							<tr>
								<td width="5%" class="px-12-font proximanova-bold">
									@if(isset($application['checklist2']) && $application['checklist2'] == 'True')
										<div class="checkbox checked" style="margin-bottom: 0; margin-left: 15px"></div>
									@else
										<div class="checkbox" style="margin-bottom: 0; margin-left: 15px"></div>
                                    @endif
								</td>
								<td width="95%" class="px-12-font">Have you included in your application, a copy of your company profile?</td>
							</tr>
							<tr>
								<td width="5%" class="px-12-font proximanova-bold">
									@if(isset($application['checklist3']) && $application['checklist3'] == 'True')
										<div class="checkbox checked" style="margin-bottom: 0; margin-left: 15px"></div>
									@else
										<div class="checkbox" style="margin-bottom: 0; margin-left: 15px"></div>
                                    @endif
								</td>
								<td width="95%" class="px-12-font">Have you provided your ABN, and Business Registration Documentation?</td>
							</tr>
							<tr>
								<td width="5%" class="px-12-font proximanova-bold">
									@if(isset($application['checklist4']) && $application['checklist4'] == 'True')
										<div class="checkbox checked" style="margin-bottom: 0; margin-left: 15px"></div>
									@else
										<div class="checkbox" style="margin-bottom: 0; margin-left: 15px"></div>
                                    @endif
								</td>
								<td width="95%" class="px-12-font">Have you provided a copy of your professional or industry membership documentation?</td>
							</tr>
							<tr>
								<td width="5%" class="px-12-font proximanova-bold">
									@if(isset($application['checklist5']) && $application['checklist5'] == 'True')
										<div class="checkbox checked" style="margin-bottom: 0; margin-left: 15px"></div>
									@else
										<div class="checkbox" style="margin-bottom: 0; margin-left: 15px"></div>
                                    @endif
								</td>
								<td width="95%" class="px-12-font">And other supporting document</td>
							</tr>

							<tr>
								<td colspan="2" class="primary-bg-color white-font-color px-12-font proximanova-bold" style="line-height: 12px;">AGENT DECLARATION</td>
							</tr>
							<tr>
								<td colspan="2" style="padding: 10px 20px;">
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font">I agree to the personal information being:</p>
									<div class="clearfix" style="height: 10px;"></div>
									<ul class="list no-margin text-justify">
										<li>
											<p class="px-12-font text-justify">Recorded in PRISMS and sent to other regulatory bodies like ASQA. This may include my name, business email address, phone number and address;</p>
										</li>
										<li>
											<p class="px-12-font text-justify">Accessed by the Australian Government Department of Education and Training, Department of Home Affairs and other Commonwealth agencies that access PRISMS;</p>
										</li>
										<li>
											<p class="px-12-font text-justify">Used to administer or monitor compliance with the Commonwealth legislation e.g. Education Services for Overseas Students Act 2000, Migration Act 1958; and</p>
										</li>
										<li>
											<p class="px-12-font text-justify">Disclosed by the Australian Government Department of Education and Training to other Australian Government entities (including, but not limited to ASQA), education institutions and publically. The Australian Government Department of Education and Training will share individual agents’ performance publically as aggregated data (but will not identify agent – provider relationships). Agent-provider relationships will only be identified when data is shared with education providers and other Australian Government entities.</p>
										</li>
									</ul>
									<div class="clearfix" style="height: 10px;"></div>
									<p class="px-12-font text-justify" style="line-height: 12px;">I also agree to personal information that Australian Government Department of Education and Training currently hold in PRISMS regarding myself and any other personal information that the department may collect in future being disclosed as described above. </p>

									<div class="clearfix" style="height: 30px;"></div>
									<p class="px-12-font text-justify display-inlineblock">Name of Representative/Education Agent: </p>
									<div class="textbox display-inlineblock line-textbox" style="width: 390px;">
									@if(isset($application['applicant_name']) && $application['applicant_name'] !== null)
										{{$application['applicant_name']}}
                                    @endif
									</div>
									<div class="clearfix" style="height: 10px;"></div>
									<p class="px-12-font text-justify display-inlineblock">Signatures: </p>
									<div class="textbox display-inlineblock line-textbox" style="width: 390px;">
									@if(isset($type_signature) && $type_signature != null)
									<!-- <img src="{{ $type_signature }}" alt="" style="width: 300px;margin-top: -40px;"> -->
									<div class="type-signature px-18-font" style="margin-top: -12px;">{{isset($type_signature) ? $type_signature : ''}}</div>
									@endif
									</div>
									<div class="clearfix" style="height: 10px;"></div>
									<p class="px-12-font text-justify display-inlineblock">Date: </p>
									<div class="textbox display-inlineblock line-textbox" style="width: 190px;">
									@if(isset($application['applicant_date']) && $application['applicant_date'] !== null)
										{{ \Carbon\Carbon::parse($application['applicant_date'])->format('d/m/Y') }}
                                    @endif
									</div>
								</td>
							</tr>
							
						</table>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No. {{$org->training_organisation_id}} | CRICOS Code {{$org->cricos_code}}</p>
						<p style="margin-bottom: 0px;"> Page 1 of 2</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 2 of 2 -->

</html>