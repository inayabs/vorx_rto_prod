<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/cea-enrolment-form/pdf-style.css" rel="stylesheet" />
	<title>Enrolment Form</title>
	<!-- Page 1 of 5 -->
	<body class="exo2-regular position-relative page-1">
	<img src="{{public_path()}}/cea-enrolment-form/images/p1.jpg" class="page" alt="">
	<div class="part-1-a" style="width: 250px; position: absolute; top: 220px; left: 110px;">
		<p class="px-12-font with-arrow-after calibri-bold primary-font-color" style="line-height: 10px;">The course(s) you <br> are applying for</p>
		<div class="clearfix" style="height: 30px;"></div>
		<table width="100%" class="form-table">
			<tr>
				<td>
					<div class="checkbox {{isset($ef['course']) && $ef['course']['code'] == 'CPP20218' ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">CPP20218</span> - Certificate II in Security Operations</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{isset($ef['course']) && $ef['course']['code'] == 'SIT30816' ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">SIT30816</span> - Certificate III in Commercial Cookery</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{isset($ef['course']) && $ef['course']['code'] == 'SIT40516' ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">SIT40516</span> - Certificate IV in Commercial Cookery</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{isset($ef['course']) && $ef['course']['code'] == 'SIT50416' ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">SIT50416</span> - Diploma of Hospitality Management</label></div>
				</td>
			</tr>
		</table>
	</div>
	<div class="part-1-b" style="width: 350px; position: absolute; top: 188px; right: 20px;">
		<p class="px-12-font with-arrow-after calibri-bold primary-font-color" style="line-height: 10px;">AND / OD <br> The unit(s) you are <br> applying for</p>
		<div class="clearfix" style="height: 5px;"></div>
		<table width="100%" class="form-table">
			@php
				$units = [];
				if(isset($ef['units'])){
					foreach ($ef['units'] as $key => $value) {
						$units[] = $value['code'];
					}
				}
			@endphp
			<tr>
				<td>
					<div class="checkbox {{in_array('RIIWHS205E',$units) ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">RIIWHS205E</span> - Control traffic with stop-slow bat</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{in_array('RIIWHS302E',$units) ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">RIIWHS302E</span> - Implement traffic management plan</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{in_array('CPCCWHS1001',$units) ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">CPCCWHS1001</span> - Prepare to Work Safely in the Construction Industry</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{in_array('CPPSEC3101',$units) ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">CPPSEC3101</span> - Manage conflict and security risks using negotiation</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{in_array('CPPSEC3121',$units) ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">CPPSEC3121</span> - Control persons using empty hand techniques</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{in_array('HLTAID001',$units) ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">HLTAID001</span> - Provide cardiopulmonary resuscitation</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{in_array('HLTAID003',$units) ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">HLTAID003</span> - Provide first aid</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox {{in_array('HLTAID006',$units) ? 'checked' : ''}}"><label class="primary-font-color px-11-font"> <span class="calibri-bold">HLTAID006</span> - Provide advanced first aid</label></div>
				</td>
			</tr>
		</table>
	</div>
	<div class="part-2" style="width: 260px; position: absolute; top: 425px; left: 110px;">
		<p class="px-12-font with-arrow-after calibri-bold primary-font-color" style="line-height: 10px;">Choose the <br> preferred mode of <br> delivery </p>
		<p class="px-12-font calibri-bold primary-font-color" style="line-height: 10px;">In following categories, which BEST describes your requirement ?</p>
		<div class="clearfix" style="height: 25px;"></div>
		<table width="100%" class="form-table">
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'Face to face' ? 'checked' : ''}}"><label class="primary-font-color px-10-font"> Face-to-Face</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'Blended' ? 'checked' : ''}}"><label class="primary-font-color px-10-font"> Blended</label></div>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'Work based' ? 'checked' : ''}}"><label class="primary-font-color px-10-font"> Work based</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'On-site at your address' ? 'checked' : ''}}"><label class="primary-font-color px-10-font"> On-site at your address</label></div>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'Distance Learning' ? 'checked' : ''}}"><label class="primary-font-color px-10-font"> Distance Learning</label></div>
				</td>
			</tr>
		</table>
	</div>
	<div class="part-3" style="width: 300px; position: absolute; top: 435px; right: 25px;">
		<table width="100%" class="form-table">
			<tr>
				<td>
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Title <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="70%">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="18%">
											<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Mr.' ? 'checked' : ''}}"><label class="primary-font-color px-10-font" style="margin-left: 2px;">Mr.</label></div>
										</td>
										<td width="20%">
											<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Mrs.' ? 'checked' : ''}}"><label class="primary-font-color px-10-font" style="margin-left: 2px;">Mrs.</label></div>
										</td>
										<td width="20%">
											<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Miss' ? 'checked' : ''}}"><label class="primary-font-color px-10-font" style="margin-left: 2px;">Miss</label></div>
										</td>
										<td width="20%">
											<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Dr.' ? 'checked' : ''}}"><label class="primary-font-color px-10-font" style="margin-left: 2px;">Dr.</label></div>
										</td>
										<td width="22%">
											<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Other' ? 'checked' : ''}}"><label class="primary-font-color px-10-font" style="margin-left: 2px;">Other</label></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Family Name <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
											<div class="textbox">{{isset($ef['lastname']) ? $ef['lastname'] : ''}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Given Name(s) <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png"></p>
							</td>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
											<div class="textbox">{{isset($ef['firstname']) ? $ef['firstname'] : ''}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Gender <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="70%">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="25%">
											<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Male' ? 'checked' : ''}}"><label class="primary-font-color px-10-font" style="margin-left: 2px;">Male</label></div>
										</td>
										<td width="25%">
											<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Female' ? 'checked' : ''}}"><label class="primary-font-color px-10-font" style="margin-left: 2px;">Female</label></div>
										</td>
										<td width="25%">
											<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Other' ? 'checked' : ''}}"><label class="primary-font-color px-10-font" style="margin-left: 2px;">Other</label></div>
										</td>
										<td width="25%">
											<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == '@' ? 'checked' : ''}}" style="vertical-align: middle; display: inline-block;"></div><label class="primary-font-color px-10-font" style="display: inline-block; line-height: 8px; margin-left: -30px; vertical-align: middle;">Don't <br> want to <br> disclose</label>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Date of Birth <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
											<div class="textbox">{{isset($ef['date_of_birth']['value']) ? \Carbon\Carbon::parse($ef['date_of_birth']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>

		</table>
	</div>

	<div class="part-4" style="width: 657px; position: absolute; bottom: 265px; left: 110px;">
		<table width="100%" class="form-table">
			<tr>
				<td>
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="10%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Residential Add <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="90%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
											@php
												$addr = [];
												$post_geo = isset($ef['addr_suburb']['value']) ? explode(' - ', $ef['addr_suburb']['value']) : null;
												if(isset($ef['addr_flat_unit_detail']) && !in_array($ef['addr_flat_unit_detail'], [null, ''])){
													$addr[] = $ef['addr_flat_unit_detail'];
												}
												if(isset($ef['addr_building_property_name']) && !in_array($ef['addr_building_property_name'], [null, ''])){
													$addr[] = $ef['addr_building_property_name'];
												}
												if(isset($ef['addr_street_num']) && !in_array($ef['addr_street_num'], [null, ''])){
													$addr[] = $ef['addr_street_num'];
												}
												if(isset($ef['addre_street_name']) && !in_array($ef['addre_street_name'], [null, ''])){
													$addr[] = $ef['addre_street_name'];
												}
												if(isset($ef['addr_suburb_state']) && !in_array($ef['addr_suburb_state'], [null, ''])){
													$addr[] = $ef['addr_suburb_state'];
												}
											@endphp
											<div class="textbox">{{implode(' ', $addr)}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">State <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width='56%'>
											<div class="textbox">{{$ef['addr_location'] ? $ef['addr_location'] : null}}</div>
										</td>
										<td width='14%'>
											<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Post Code <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
										</td>
										<td width='30%'>
											<div class="textbox">{{$ef['addr_postcode'] ? $ef['addr_postcode'] : null}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px; display: inline-block; margin-left: 43px; margin-top: 2px;">Postal Address (If <br> different from above) </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -5px;">
							</td>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
											<div class="textbox">{{isset($ef['addr_postal_delivery_box']) ? $ef['addr_postal_delivery_box'] : null}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">State <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width='56%'>
											<div class="textbox"></div>
										</td>
										<td width='14%'>
											<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Post Code <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
										</td>
										<td width='30%'>
											<div class="textbox"></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Telephone <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width='43%'>
											<div class="textbox">{{isset($ef['phone_home']) ? $ef['phone_home'] : null}}</div>
										</td>
										<td width='12%'>
											<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Mobile <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
										</td>
										<td width='45%'>
											<div class="textbox">{{isset($ef['phone_mobile']) ? $ef['phone_mobile'] : null}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="10%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Email <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
							</td>
							<td width="90%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
											<div class="textbox">{{isset($ef['email']) ? $ef['email'] : null}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="30%" align="right">
								<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px; display: inline-block; margin-left: 62px; margin-top: 2px;">Alternative Email <br> (optional) </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -5px;">
							</td>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
											<div class="textbox">{{isset($ef['email_at']) ? $ef['email_at'] : null}}</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>

		</table>
	</div>

	<div class="part-5" style="width: 240px; position: absolute; bottom: 55px; left: 90px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="35%" align="right">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Name <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="65%">
					<div class="textbox">{{isset($ef['e_contact_name']) ? $ef['e_contact_name'] : null}}</div>
				</td>
			</tr>
			<tr>
				<td width="35%" align="right" valign="top" rowspan="2">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: 10px;">Address <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="65%">
					<div class="textbox">{{isset($ef['e_address']) ? $ef['e_address'] : null}}</div>
				</td>
			</tr>
			<tr>
				{{-- <td width="65%">
					<div class="textbox"></div>
				</td> --}}
			</tr>
			<tr>
				<td width="35%" align="right">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Telephone <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="65%">
					<div class="textbox">{{isset($ef['e_telephone']) ? $ef['e_telephone'] : null}}</div>
				</td>
			</tr>
			<tr>
				<td width="35%" align="right">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Relationship <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="65%">
					<div class="textbox">{{isset($ef['e_relationship']) ? $ef['e_relationship'] : null}}</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-6" style="width: 365px; position: absolute; bottom: 60px; right: 25px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="50%" valign="top">
					@php
						$visa = isset($ef['visa_type']['value']) ? explode( ' (subclass ',$ef['visa_type']['value']) : null;
					@endphp
					<label class="label label-textbox calibri-bold with-arrow-after" style="margin: 0 !important;">Nationality</label>
					<div class="textbox" style="margin-top: 0; margin-bottom: -10px;">{{isset($ef['nationality']) ? $ef['nationality'] : null}}</div>
					<label class="label label-textbox calibri-bold with-arrow-after" style="margin: 0 !important;">Issue Date</label>
					<div class="textbox" style="margin-top: 0; margin-bottom: -10px;">{{isset($ef['passport_issued_date']['value']) ? \Carbon\Carbon::parse($ef['passport_issued_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
					{{-- <div class="textbox" style="margin-top: 0; margin-bottom: -10px;">{{$ef['passport_issued_date']}}</div> --}}
					<label class="label label-textbox calibri-bold with-arrow-after" style="margin: 0 !important;">Visa Type <span class="px-9-font">(if not Australian Citizen)</span></label>
					<div class="textbox" style="margin-top: 0; margin-bottom: -10px;">
						@if (isset($visa[0]) && strlen($visa[0]) > 25)
							<p style="margin-top:-3px;line-height:6px; font-size:12px">{{isset($visa[0]) ? $visa[0] : null}}</p>
						@else
							<p>{{isset($visa[0]) ? $visa[0] : null}}</p>
						@endif
					</div>
					<label class="label label-textbox calibri-bold with-arrow-after" style="margin: 0 !important;">Expiry Date</label>
					<div class="textbox" style="margin-top: 0; margin-bottom: -10px;">{{isset($ef['visa_expiry_date']['value']) ? \Carbon\Carbon::parse($ef['visa_expiry_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
				</td>
				<td width="50%" valign="top">
					<label class="label label-textbox calibri-bold with-arrow-after" style="margin: 0 !important;">Passport No.</label>
					<div class="textbox" style="margin-top: 0; margin-bottom: -10px;">{{isset($ef['passport_no']) ? $ef['passport_no'] : null}}</div>
					<label class="label label-textbox calibri-bold with-arrow-after" style="margin: 0 !important;">Expiry Date</label>
					<div class="textbox" style="margin-top: 0; margin-bottom: -10px;">{{isset($ef['passport_expiry_date']['value']) ? \Carbon\Carbon::parse($ef['passport_expiry_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
					<label class="label label-textbox calibri-bold with-arrow-after" style="margin: 0 !important;">Sub Class</label>
					<div class="textbox" style="margin-top: 0;">{{isset($visa[1]) ? str_replace(")","",$visa[1]) : null}}</div>
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<label class="label label-textbox calibri-bold" style="line-height: 8px; display: inline-block;">Study Right <br><span class="px-9-font">in Australia</span></label><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -5px;">
							</td>
							<td width="50%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="50%">
											<label class="label label-textbox"></label>
											<div class="checkbox {{isset($ef['study_rights']) && in_array($ef['study_rights'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox primary-font-color"> Yes</label></div>
										</td>
										<td width="50%">
											<label class="label label-textbox"></label>
											<div class="checkbox {{isset($ef['study_rights']) && !in_array($ef['study_rights'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox primary-font-color"> No</label></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="55%">
								<label class="label label-textbox calibri-bold" style="line-height: 8px; display: inline-block; font-size: 9px;">Applied for Australian <br>Permanent Residency</label><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -5px;">
							</td>
							<td width="45%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="50%">
											<label class="label label-textbox"></label>
											<div class="checkbox {{isset($ef['au_permanent_residency']) && in_array($ef['au_permanent_residency'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox primary-font-color">Yes</label></div>
										</td>
										<td width="50%">
											<label class="label label-textbox"></label>
											<div class="checkbox {{isset($ef['au_permanent_residency']) && !in_array($ef['au_permanent_residency'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox primary-font-color">No</label></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

</body>
	<!-- End Page 1 of 5 -->
	<!-- Page 2 of 5 -->

	<body class="exo2-regular position-relative page-1">
	<img src="{{public_path()}}/cea-enrolment-form/images/p2.jpg" class="page" alt="">
	<div class="part-7" style="width: 260px; position: absolute; top: 190px; left: 90px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="40%" align="right">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Still in School<img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="60%">
					<table width="50%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="checkbox {{isset($ef['at_school']) && in_array($ef['at_school'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px;"><label class="label label-checkbox primary-font-color">Yes</label></div>
							</td>
							<td width="50%">
								<div class="checkbox {{isset($ef['at_school']) && !in_array($ef['at_school'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px;"><label class="label label-checkbox primary-font-color">No</label></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="40%" align="right">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px; display: inline-block; margin-left: 8px; margin-top: 2px;">Highest School <br> Level Completed </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -5px;">
				</td>
				<td width="60%">
					<div class="textbox">{{isset($ef['highest_school_level_completed_id']['description']) ? $ef['highest_school_level_completed_id']['description'] : ''}}</div>
				</td>
			</tr>
			<tr>
				<td width="40%" align="right">
					<p class="px-11-font calibri-bold primary-font-color text-right" style="line-height: 10px; display: inline-block; margin-left: 33px; margin-top: 2px;">Year <br> Completed </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -5px;">
				</td>
				<td width="60%">
					<div class="textbox">{{isset($ef['year_completed']) ? $ef['year_completed'] : ''}}</div>
				</td>
			</tr>
			<tr>
				<td width="40%" align="right">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Institute <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="60%">
					<div class="textbox">
						@if (isset($ef['institute']) && strlen($ef['institute']) > 25)
							<p style="margin-top:-3px;line-height:6px; font-size:12px">{{isset($ef['institute']) ? $ef['institute'] : ''}}</p>
						@else
							<p>{{isset($ef['institute']) ? $ef['institute'] : ''}}</p>
						@endif
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-8" style="width: 335px; position: absolute; top: 190px; right: 25px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="25%" align="right">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px;">Still in School <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="75%">
					<table width="40%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="checkbox {{isset($ef['post_secondary']) && in_array($ef['post_secondary'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px;"><label class="label label-checkbox primary-font-color">Yes</label></div>
							</td>
							<td width="50%">
								<div class="checkbox {{isset($ef['post_secondary']) && in_array(!$ef['post_secondary'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px;"><label class="label label-checkbox primary-font-color">No</label></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: -5px; display: inline-block;">Highest School Level Completed <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
					<div class="textbox" style="width: 150px; display: inline-block; margin: 0;">
						@if ($ef['post_highest_qualification_completed_id'])
							@if (isset($ef['post_highest_qualification_completed_id']['description']))
								{{$ef['post_highest_qualification_completed_id']['description']}}
							@else
							{{$ef['post_highest_qualification_completed_id']}}
							@endif
						@endif
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p class="px-11-font calibri-bold primary-font-color text-right" style="line-height: 10px; display: inline-block; margin-top: 2px;">Year <br> Completed </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-left: 5px; margin-top: -5px;">
					<div class="textbox" style="width: 25px; display: inline-block; margin: 0;">{{isset($ef['post_year_completed']) ? $ef['post_year_completed'] : ''}}</div>
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: -5px; display: inline-block;">Institute <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px; margin-top:3px;"></p>
					<div class="textbox" style="width: 150px; display: inline-block; margin: 0;">
						@if (isset($ef['post_institute']) && strlen($ef['post_institute']) > 25)
							<p style="margin-top:-3px;line-height:6px; font-size:12px">{{isset($ef['post_institute']) ? $ef['post_institute'] : ''}}</p>
						@else
							<p>{{isset($ef['post_institute']) ? $ef['post_institute'] : ''}}</p>
						@endif
					</div>
				</td>
			</tr>
		</table>
		<p class="primary-font-color px-10-font" style="line-height: 8px;"><span class="calibri-bold">A</span> - Australian, <span class="calibri-bold">E</span> - Australian Equivalent or <span class="calibri-bold">I</span> - International</p>
		<p class="primary-font-color px-10-font text-justify" style="line-height: 8px;">(Note : In case you have multiple Prior Education Achievement Recognition Identifiers of any qualification, use the following priority order number to determine which identifier to use:<span class="calibri-bold">1:A</span> - Australia, <span class="calibri-bold">2:E</span> - Australian Equivalent, <span class="calibri-bold">3:I</span> - International</p>
		<div class="clearfix" style="height: 15px;"></div>
		<table class="table-bordered" width="100%" cellpadding="0" cellspacing="0" border="0">
			@php
				$pea = [];
				if(isset($ef['prior_educational_achievement_ids'])){
					foreach ($ef['prior_educational_achievement_ids'] as $k => $v){
						$pea[$v['value']] = explode(' - ', $v['description'])[0];
					}
				}
			@endphp
			<tr>
				<td colspan="2" class="px-12-font primary-font-color calibri-bold text-center">
					A E I
				</td>
			</tr>
			<tr>
				<td width="50%" style="padding: 0;">
					<table width="100%" class="" cellpadding="0" cellspacing="0" border="0">
						<tbody>
							<tr>
								<td width="10%">
									<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="70%" style="height: 25px; padding-left: 5px;">
									<p class="px-10-font proximanova-bold" style="line-height: 8px;">Certificate I</p>
								</td>
							</tr>
							<tr>
								<td width="10%">
									<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="70%" style="height: 25px; padding-left: 5px; padding-left: 5px;">
									<p class="px-10-font proximanova-bold" style="line-height: 8px;">Certificate II</p>
								</td>
							</tr>
							<tr>
								<td width="10%">
									<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="70%" style="height: 25px; padding-left: 5px; padding-left: 5px;">
									<p class="px-10-font proximanova-bold" style="line-height: 8px;">Certificate III or Trade Certificate</p>
								</td>
							</tr>
							<tr>
								<td width="10%">
									<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="70%" style="height: 25px; padding-left: 5px; padding-left: 5px;">
									<p class="px-10-font proximanova-bold" style="line-height: 8px;">Certificate IV or Advanced
										Certificate/Technician </p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td width="50%" style="padding: 0;">
					<table width="100%" class="" cellpadding="0" cellspacing="0" border="0">
						<tbody>
							<tr>
								<td width="10%">
									<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="70%" style="height: 25px; padding-left: 5px;">
									<p class="px-10-font proximanova-bold" style="line-height: 8px;">Diploma of Associate Diploma</p>
								</td>
							</tr>
							<tr>
								<td width="10%">
									<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="70%" style="height: 25px; padding-left: 5px;">
									<p class="px-10-font proximanova-bold" style="line-height: 8px;">Advanced Diploma of Associate Degree Level</p>
								</td>
							</tr>
							<tr>
								<td width="10%">
									<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="70%" style="height: 25px; padding-left: 5px;">
									<p class="px-10-font proximanova-bold" style="line-height: 8px;">Bachelor Degree or Higher Degree Level</p>
								</td>
							</tr>
							<tr>
								<td width="10%">
									<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="10%">
									<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 3px;"></div>
								</td>
								<td width="70%" style="height: 25px; padding-left: 5px;">
									<p class="px-10-font proximanova-bold" style="line-height: 8px;">Certificates other than the above</p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
		<div class="clearfix" style="height: 10px;"></div>
		<p class="primary-font-color px-10-font calibri-bold" style="line-height: 8px;">Please provide certified documents for the courses that you took.</p>
	</div>

	<div class="part-9" style="width: 275px; position: absolute; top: 350px; left: 80px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="35%" align="right" valign="top">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: 5px;">Birth Country <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="65%">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="39%">
								<div class="checkbox {{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] == '1101' ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color">Australia</label></div>
							</td>
							<td width="61%">
								<div class="checkbox {{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] != '1101' ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color">Other, <span class="px-8-font">Please specify</span></label></div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="textbox" style="margin-top: 0; margin-bottom: 0;">{{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] != '1101' ?  $ef['birth_country_id']['full_name'] : ''}}</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="35%" align="right" valign="top">
					<p class="px-11-font calibri-bold primary-font-color text-right" style="line-height: 10px; display: inline-block; margin-left: 32px; margin-top: 6px;">Spoken <br> Language <br> <span class="px-8-font">(at home)</span> </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -20px;">
				</td>
				<td width="65%">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="57%">
								<p class="px-10-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: -2px;">Other than English <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 1px;"></p>
							</td>
							<td width="20%">
								<div class="checkbox {{isset($ef['spoken_language']) && $ef['spoken_language'] != true ?  'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">No</label></div>
							</td>
							<td width="23%">
								<div class="checkbox {{isset($ef['spoken_language']) && $ef['spoken_language'] == true ?  'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Yes,</label></div>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<p class="px-8-font text-right" style="margin-top: -7px;">Please specify</p>
								<div class="textbox" style="margin-top: 0; margin-bottom: 0;">
									@if ($ef['spoken_language_specify'])
										@if (isset($ef['spoken_language_specify']['description']))
											{{$ef['spoken_language_specify']['description']}}
										@else
											{{$ef['spoken_language_specify']}}
										@endif
									@endif
									{{-- {{isset($ef['spoken_language_specify']) ? $ef['spoken_language_specify'] : ''}} --}}
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="35%" align="right" valign="top">
					<p class="px-11-font calibri-bold primary-font-color text-right" style="line-height: 10px; display: inline-block; margin-left: 34px; margin-top: 5px;">English <br> Language</p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -10px;">
				</td>
				<td width="65%">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="57%" colspan="2">
								<p class="px-10-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: -2px;">How well do you speak English?</p>
							</td>
						</tr>
						<tr>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="50%">
											<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Very Well' ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Very Well</label></div>
										</td>
										<td width="50%">
											<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Well' ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Well</label></div>
										</td>
									</tr>
									<tr>
										<td width="50%">
											<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Not Well' ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Not Well</label></div>
										</td>
										<td width="50%">
											<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Not at all' ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Not at all</label></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="35%" align="right" valign="top">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: 5px;">Origin <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="65%">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Aboriginal' ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Aboriginal</label></div>
							</td>
							<td width="50%" rowspan="2">
								<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Torres Strait Islander' ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Torres Strait <br> Islander</label></div>
							</td>
						</tr>
						<tr>
							<td width="50%">
								<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Both' ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Both</label></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>

		</table>
	</div>

	<div class="part-10" style="width: 240px; position: absolute; top: 540px; left: 90px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="30%" align="right" valign="top">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 8px;">Condition<img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="70%">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<p class="px-10-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: -2px;">Do you consider yourself to have a disability, impairment or long-term</p>
							</td>
						</tr>
						<tr>
							<td width="70%">
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="22%">
											<div class="checkbox {{isset($ef['disability_flag']) && $ef['disability_flag'] == false ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">No</label></div>
										</td>
										<td width="24%">
											<div class="checkbox {{isset($ef['disability_flag']) && $ef['disability_flag'] == true ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Yes,</label></div>
										</td>
										<td width="54%">
											<p class="px-9-font" style="line-height: 8px;">Please indicate the areas of condition :</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-left: 20px;">
					@php
						$dis = [];
						if(isset($ef['disabilitiy_ids'])){
							foreach ($ef['disabilitiy_ids'] as $k => $v){
								$dis[$v['description']] = true;
							}
						}
					@endphp
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="40%" style="padding-bottom:2px;">
								<div class="checkbox {{isset($dis['Hearing/Deaf']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Hearing/Deaf</label></div>
							</td>
							<td width="60%" style="padding-bottom:2px;">
								<div class="checkbox {{isset($dis['Learning']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Learning</label></div>
							</td>
						</tr>
						<tr>
							<td width="40%" style="padding-bottom:2px;">
								<div class="checkbox display-inlineblock {{isset($dis['Acquired Brain Impairment']) ? 'checked' : ''}}" style="margin-top: -4px;"></div>
								<p class="primary-font-color calibri-regular display-inlineblock" style="font-size: 9px; line-height: 8px; margin-top: 5px; margin-left: -67px;">Acquired Brain <br> Impairment</p>
							</td>
							<td width="60%" style="padding-bottom:2px;">
								<div class="checkbox {{isset($dis['Intellectual']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Intellectual</label></div>
							</td>
						</tr>
						<tr>
							<td width="40%" style="padding-bottom:2px;">
								<div class="checkbox {{isset($dis['Medical Condition']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Medical Condition</label></div>
							</td>
							<td width="60%" style="padding-bottom:2px;">
								<div class="checkbox {{isset($dis['Vision']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Vision</label></div>
							</td>
						</tr>
						<tr>
							<td width="40%" style="padding-bottom:2px;">
								<div class="checkbox {{isset($dis['Physical']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Physical</label></div>
							</td>
							<td width="60%" style="padding-bottom:2px;">
								<div class="checkbox {{isset($dis['Other']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Other, <span class="px-8-font">please specify</span></label></div>
							</td>
						</tr>
						<tr>
							<td width="40%" style="padding-bottom:2px;">
								<div class="checkbox {{isset($dis['Mental Illness']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 9px;">Mental Illness</label></div>
							</td>
							<td width="60%" style="padding-bottom:2px;">
								<div class="textbox" style="margin-top: 0; margin-bottom: 0;">{{isset($dis['specify_disability']) ? $dis['specify_disability'] : ''}}</div>
							</td>
						</tr>
					</table>
					<p class="px-8-font primary-font-color" style="line-height: 8px;">if you answered ‘Yes’, you can contact CEA for further support services available</p>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-11" style="position: absolute; top: 530px; right: 25px; width: 360px;">
		<p class="calibri-bold primary-font-color px-14-font" style="line-height: 12px; margin: 3 0;">Employment Status</p>
		<p class="calibri-bold primary-font-color px-10-font with-arrow-before" style="line-height: 10px; margin-top: -5px;">In following categories, which BEST describes your current employment status?</p>
		<div class="clearfix" style="height:5px;"></div>
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			@php
				$labor = [];
				if(isset($ef['labour_force_status_id']['value'])){
					$labor[$ef['labour_force_status_id']['value']] = true;
				}
				// foreach ($ef['labour_force_status_id'] as $k => $v){
				// 	$labor[$v['value']] = true;
				// }
			@endphp
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($labor['01']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Full-time employee</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($labor['02']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Part-time employee</label></div>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($labor['04']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Self-employed-Employing others</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($labor['03']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Self-employed-Not employing others</label></div>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($labor['05']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Employed-Unpaid worker</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($labor['06']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Unemployed-Seeking Full-time work</label></div>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($labor['08']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Not employed-Not seeking work</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($labor['07']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Unemployed-Seeking Part-time work</label></div>
				</td>
			</tr>
		</table>
		<div class="clearfix" style="height:3px;"></div>
		<p class="calibri-bold primary-font-color px-14-font" style="line-height: 12px; margin-bottom: 3px;">If currently employed, or recently been employed</p>
		<p class="calibri-bold primary-font-color px-10-font with-arrow-before" style="line-height: 10px; margin-top: -5px;">Choose the classification of occupation that best describe your occupation</p>
		<p class="calibri-bold primary-font-color px-8-font text-right" style="line-height: 8px; margin-top: -5px; margin-right: 40px;">(Choose one only)</p>
		<div class="clearfix" style="height:5px;"></div>
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			@php
				$if_employed = [];
				if(isset($ef['if_employed']['name'])){
					$if_employed[$ef['if_employed']['name']] = true;
				}
				// foreach ($ef['if_employed'] as $k => $v){
				// 	$if_employed[$v['name']] = true;
				// }
			@endphp
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($if_employed['Manager']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Manager</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($if_employed['Community & Personal Sevice Worker']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Community & Personal Sevice Worker</label></div>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<div class="checkbox {{isset($if_employed['Professional']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Professional</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($if_employed['Early Childhood Educator']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Early Childhood Educator</label></div>
				</td>
			</tr>
			<tr>
				<td width="50%" valign="top">
					<div class="checkbox {{isset($if_employed['Admin & Support']) ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Admin & Support</label></div>
				</td>
				<td width="50%">
					<div class="checkbox {{isset($if_employed['Other']) ? 'checked' : ''}}" style="margin-left: 1px; margin-top: 3px; margin-bottom: 0; display: inline-block;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Other, <br> <span class="px-8-font" style="line-height: 8px;"> please specify</span></label></div>
					<div class="textbox" style="display: inline-block; width: 100px; margin-top: 0; margin-bottom: 0; margin-left: -120px;">{{isset($ef['if_employed_other']) ? $ef['if_employed_other'] : ''}}</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-12" style="position: absolute; bottom: 245px; left: 85px; width: 340px;">
		<p class="calibri-bold primary-font-color px-14-font" style="line-height: 12px; margin-bottom: 3px;">Main Reason</p>
		<p class="calibri-bold primary-font-color px-10-font with-arrow-before" style="line-height: 10px; margin-top: -5px;"> In following categories, which BEST describes your main reason for undertaking the course(s) with CEA?</p>
		<div class="clearfix" style="height:5px;"></div>
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="45%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '02'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">To develop my existing business</label></div>
				</td>
				<td width="55%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '04'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">To try a different career</label></div>
				</td>
			</tr>
			<tr>
				<td width="45%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '01'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">To get a job</label></div>
				</td>
				<td width="55%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '07'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Want extra skills for my job</label></div>
				</td>
			</tr>
			<tr>
				<td width="45%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '05'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">To get better job or promotion</label></div>
				</td>
				<td width="55%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '07'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Requirement of my job</label></div>
				</td>
			</tr>
			<tr>
				<td width="45%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '08'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">To get into another course</label></div>
				</td>
				<td width="55%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '12'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">For personal interest & self-development</label></div>
				</td>
			</tr>
			<tr>
				<td width="45%" valign="top">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '03'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">To start my own business</label></div>
				</td>
				<td width="55%">
					<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '11'  ? 'checked' : ''}}" style="margin-left: 1px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Other reason <span class="px-8-font">please state</span></label></div>
					<div class="textbox" style="width: 150px; margin-top: 0; margin-bottom: 0; margin-left: 15px;">{{isset($ef['study_reason_other']) ? $ef['study_reason_other'] : ''}}</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-13" style="position: absolute; bottom: 288px; right: 25px; width: 260px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="35%" align="right" valign="top">
					<p class="px-11-font calibri-bold primary-font-color" style="line-height: 8px;">Requirement<img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
				</td>
				<td width="65%">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<p class="px-10-font calibri-bold primary-font-color" style="line-height: 10px; margin-top: -2px;">Are you seeking Recognition of Prior Learning or Credit Transfer?</p>
							</td>
						</tr>
						<tr>
							<td>
								<table width="50%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="50%">
											<div class="checkbox {{isset($ef['rpl_ct_flag']) && !in_array($ef['rpl_ct_flag'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">No</label></div>
										</td>
										<td width="50%">
											<div class="checkbox {{isset($ef['rpl_ct_flag']) && in_array($ef['rpl_ct_flag'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Yes</label></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">If <span class="calibri-bold">‘YES’</span> , then please contact Admissions Department for furtherdetails about the Recognition of Prior Learning (RPL)/Credit Transfer (CT) process.</p>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-14" style="position: absolute; bottom: 85px; left: 85px; width: 340px;">
		<p class="calibri-bold primary-font-color px-14-font" style="line-height: 12px; margin-bottom: 3px;">Uniqe Student Identifier</p>
		<p class="calibri-bold primary-font-color px-10-font with-arrow-before" style="line-height: 10px;"> Have you applied for Uniqe Student Identifier (USI) before?</p>
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0" style="padding-left: 20px;">
			<tr>
				<td>
					<table width="30%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="50%">
								<div class="checkbox {{isset($ef['usi_flag']) && $ef['usi_flag'] != true ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">No</label></div>
							</td>
							<td width="50%">
								<div class="checkbox {{isset($ef['usi_flag']) && $ef['usi_flag'] == true ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Yes</label></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<p class="primary-font-color px-10-font display-inlineblock">is <span class="calibri-bold">‘Yes’</span>, please provide your USI </p>
					<div class="textbox display-inlineblock" style="width: 170px; margin-top: 0; margin-bottom: 0;">{{isset($ef['unique_student_id']) ? $ef['unique_student_id'] : ''}}</div>
				</td>
			</tr>
			<tr>
				<td>
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">if <span class="calibri-bold">‘No’</span>, you can visit <a href="https://www.usi.gov.au/" class="text-decoration">https://www.usi.gov.au/</a> to create USI. Once created,please provide the same to Adminissions department.If you want CEA to create USI on your behalf, please contact Admissions department,email at <a href="https://www.usi.gov.au/" class="text-decoration">info@communityeducation.edu.au</a> or call (07)37081061 for further guidance.</p>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-15" style="position: absolute; bottom: 155px; right: 25px; width: 260px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="40%" align="right" valign="top">
					<p class="px-10-font calibri-bold primary-font-color text-right" style="line-height: 10px; display: inline-block; margin-left: 0; margin-top: 6px;">Are you transfering <br> from another <br> education provider <br> in Australia? </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -5px;">
				</td>
				<td width="60%" valign="top">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<table width="50%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="50%">
											<div class="checkbox {{isset($ef['trasferring_learning']) && !in_array($ef['trasferring_learning'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">No</label></div>
										</td>
										<td width="50%">
											<div class="checkbox {{isset($ef['trasferring_learning']) && in_array($ef['trasferring_learning'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Yes</label></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<p class="px-10-font calibri-bold primary-font-color display-inlineblock" style="line-height: 10px; margin-top: 2px;">Are you currently enrolled in an institute?</p>
								<div class="display-inlineblock" style="margin-top: 5px; margin-left: -90px;">
									<table width="35%" class="form-table" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="50%">
												<div class="checkbox {{isset($ef['currently_enrolled_in_an_institute']) && !in_array($ef['currently_enrolled_in_an_institute'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">No</label></div>
											</td>
											<td width="50%">
												<div class="checkbox {{isset($ef['currently_enrolled_in_an_institute']) && in_array($ef['currently_enrolled_in_an_institute'], [1, true]) ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Yes</label></div>
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">If <span class="calibri-bold">‘YES’</span> , then please provide the name of institute:</p>
					<div class="textbox" style="margin-top: 0; margin-bottom: 0;">{{isset($ef['currently_enrolled_in_an_institute_if_yes']) ? $ef['currently_enrolled_in_an_institute_if_yes'] : ''}}</div>
				</td>
			</tr>
		</table>
	</div>

</body>
	<!-- End Page 2 of 5 -->
	<!-- Page 3 of 5 -->

	<body class="exo2-regular position-relative page-1">
	<img src="{{public_path()}}/cea-enrolment-form/images/p3.jpg" class="page" alt="">
	<div class="part-16" style="position: absolute; top: 180px; left: 95px; width: 670px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="13%" align="right" valign="top">
					<p class="px-10-font calibri-bold primary-font-color" style="line-height: 10px; display: inline-block; margin-top: 3px; margin-left: 10px; ">Fees Policy <br> Statement </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: -10px;">
				</td>
				<td width="87%" valign="top">
					<p class="primary-font-color px-9-font text-justify" style="line-height: 9px;">The policy of the organisation is at all times to be fair and equitable to registered students. Applications for refunds can be made to the CEO of the organisation. Please go through Student Handbook for detailed policy and procedure. CEA makes sure that all stakeholders are informed about fees and charges for all courseson our scope. It identifies  the processes in place to protect the fees paid by students in advance and also includes implementing the course fee outline (please refer to the table below). Details of fees and charges are also supplied in the course information for each course and on our website (<a href="http://communityeducation.edu.au/" class="text-underline">http://communityeducation.edu.au/</a>). Please also consult our course adviser for further details.</p>
				</td>
			</tr>
		</table>
		<div class="clearfix" style="height: 10px;"></div>
		<table width="100%" class="form-table">
			<tr>
				<td width="7%" valign="top">
					<p class="px-10-font calibri-bold primary-font-color" style="line-height: 10px; display: inline-block; margin-top: 3px; margin-left: 10px; ">Courses <br> Fees</p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: 1px; margin-left: -10px;">
				</td>
				<td width="48%" valign="top">
					<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
						<thead>
							<tr>
								<th class="secondary-bg-color primary-font-color text-center px-9-font" style="line-height: 10px;" width="30%">Course Code</th>
								<th class="secondary-bg-color primary-font-color text-center px-9-font" style="line-height: 10px;" width="70%">Course Title</th>
							</tr>
						</thead>
						<tbody class="primary-font-color calibri-bold px-8-font">
							<tr>
								<td class="text-center" style="line-height: 8px;">CP20218</td>
								<td style="line-height: 10px;">Certificate II in Security Operations</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">SIT30816</td>
								<td style="line-height: 10px;">Certificate III in Commercial Cookery</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">SIT40516</td>
								<td style="line-height: 10px;">Certificate IV in Commercial Cookery</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">SIT50416</td>
								<td style="line-height: 10px;">Diploma of Hospitality Management</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">RIIWHS205D</td>
								<td style="line-height: 10px;">Control traffic management plan</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">RIIWHS302D</td>
								<td style="line-height: 10px;">Implement traffic management plan</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">CPPSEC3101</td>
								<td style="line-height: 10px;">Manage conflict and security risks using negotiation</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">CPPSEC3121</td>
								<td style="line-height: 10px;">Control persons using empty hands techniques</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">HLTAID001</td>
								<td style="line-height: 10px;">Provide cardiopulmonary resuscitation</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">HLTAID003</td>
								<td style="line-height: 10px;">Provide first aid</td>
							</tr>
							<tr>
								<td class="text-center" style="line-height: 8px;">HLTAID006</td>
								<td style="line-height: 10px;">Provide advanced first aid</td>
							</tr>

						</tbody>
					</table>
				</td>
				<td width="45%" valign="top">
					<div class="clearfix" style="height: 5px;"></div>
					<ul class="dotted-list thick-top-border">
						<li><p class="primary-font-color px-10-font" style="line-height: 10px;">The fee includes enrolment charges, tuition, and material costs associated with deliverinng the training and assessment services and awarding the qualification to the participant. Check with CEA Staff for latest fee schedule.</p></li>
						<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Students who are unable to meet their payment deadlines should inform CEA Staff and can request for payment plans. This is legally binding document between Community Education Australia and student enrolling in a course. Full payment is required before course completion. No certificate will be awarded if full payment has not been received.</p></li>
					</ul>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-17-a" style="position: absolute; top: 475px; left: 95px; width: 290px;">
		<table width="100%" class="form-table">
			<tr>
				<td width="25%" valign="top">
					<p class="px-10-font calibri-bold primary-font-color" style="line-height: 10px; display: inline-block; margin-top: 3px; margin-left: 10px; ">Payment <br> Method </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: 1px;">
				</td>
				<td width="75%">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<div class="clearfix" style="height: 10px;"></div>
								<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td>
											<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Cash' ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Cash</label></div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Direct Deposit in CEA’s Bank Account' ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Direct Deposit in CEA’s Bank Account</label></div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Credit Card' ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Credit Card</label></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="100%" class="form-table">
			<tr>
				<td width="28%" valign="top">
					<p class="px-10-font calibri-bold primary-font-color" style="line-height: 10px; display: inline-block; margin-top: 3px; margin-left: 10px; ">Bank Details </p><img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="display: inline-block; margin-top: 15px; margin-left: -10px;">
				</td>
				<td width="72%" style="padding: 0;">
					<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td style="padding: 0;">
								<div class="clearfix" style="height: 25px;"></div>
								<table width="100%" class="table-bordered" cellpadding="0" cellspacing="0" border="0">
									<tbody class="primary-font-color px-10-font">
										<tr>
											<td width="40%" class="secondary-bg-color calibri-bold" style="line-height: 10px; height: 30px;">Bank</td>
											<td width="60%" style="line-height: 10px; height: 30px;">Commonwealth Bank Australia</td>
										</tr>
										<tr>
											<td width="40%" class="secondary-bg-color calibri-bold" style="line-height: 10px; height:30px;">BSB</td>
											<td width="60%" style="line-height: 10px; height:30px;">062 514</td>
										</tr>
										<tr>
											<td width="40%" class="secondary-bg-color calibri-bold" style="line-height: 10px; height:30px;">Account Number</td>
											<td width="60%" style="line-height: 10px; height: 30px;">104 757 85</td>
										</tr>
										<tr>
											<td width="40%" class="secondary-bg-color calibri-bold" style="line-height: 10px;">Account Name</td>
											<td width="60%" style="line-height: 10px;">McEvoy & Doust Pty Ltd trading as Community Education Australia</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<div class="part-17-b" style="position: absolute; top: 480px; right: 25px; width: 330px;">
		<div style="padding-left: 20px;">
			<p class="px-11-font calibri-bold primary-font-color" style="line-height: 8px;">Credit Card <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
			<div class="clearfix" style="height:5px;"></div>
			<p class="px-11-font primary-font-color" style="line-height: 8px;">I give permission for fee to be charged to my <br> Credit Card for the selected course.</p>
			<div class="clearfix" style="height:5px;"></div>
			<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="20%" valign="top">
						<div class="checkbox {{isset($ef['credit_card_type']['value']) && $ef['credit_card_type']['value'] == 'Visa' ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Visa Card</label></div>
					</td>
					<td width="25%" valign="top">
						<div class="checkbox {{isset($ef['credit_card_type']['value']) && $ef['credit_card_type']['value'] == 'Master Card' ? 'checked' : ''}}" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Master Card</label></div>
					</td>
					<td width="30%" valign="top">
						<div class="checkbox" style="margin-top: 5px; margin-bottom: 0;"><label class="label label-checkbox primary-font-color" style="font-size: 10px;">Card Expiry date</label></div>
					</td>
					<td width="25%" valign="top">
						<div class="textbox" style="margin-top: 0; margin-bottom: 0;">{{isset($ef['card_expiry_date']['value']) ? \Carbon\Carbon::parse($ef['card_expiry_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
					</td>
				</tr>
			</table>	
		</div>
		<div class="clearfix" style="height:30px;"></div>
		<div>
			<p class="primary-font-color px-12-font display-inlineblock">Card Number</p>
			<div class="textbox display-inlineblock" style="width: 248px; margin-top: 0; margin-bottom: 0;">{{isset($ef['card_number']) ? $ef['card_number'] : ''}}</div>
			<div class="clearfix"></div>
			<p class="primary-font-color px-12-font display-inlineblock">Card Identification Number <span class="px-10-font">(last 3 digits located on back)</span></p>
			<div class="textbox display-inlineblock" style="width: 59px; margin-top: 0; margin-bottom: 0;">{{isset($ef['card_id_num']) ? $ef['card_id_num'] : ''}}</div>
			<div class="clearfix"></div>
			<p class="primary-font-color px-12-font display-inlineblock">Amount <span class="px-10-font">to be charged</span></p>
			<div class="textbox display-inlineblock" style="width: 214px; margin-top: 0; margin-bottom: 0;">{{isset($ef['amount_to_be_charged']) ? $ef['amount_to_be_charged'] : ''}}</div>
			<div class="clearfix"></div>
			<p class="primary-font-color px-12-font display-inlineblock">Card Holder’s Name</span></p>
			<div class="textbox display-inlineblock" style="width: 214px; margin-top: 0; margin-bottom: 0;">{{isset($ef['card_holder_name']) ? $ef['card_holder_name'] : ''}}</div>
			<div class="clearfix"></div>
			<p class="primary-font-color px-12-font display-inlineblock">Card Holder’s Signature</span></p>
			<div class="textbox display-inlineblock" style="width: 197px; margin-top: 0; margin-bottom: 0;">
				@if (isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Credit Card')
				<p class="type-signature">{{isset($ep->type_signature) ? $ep->type_signature : ''}}<p>
				@endif
			</div>
		</div>
	</div>

	<div class="part-18-a" style="position: absolute; bottom: 180px; left: 80px; width: 340px;">
		<div style="padding-left: 20px;">
			<p class="px-12-font calibri-bold primary-font-color" style="line-height: 8px;">Information <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
			<div class="clearfix" style="height:20px;"></div>
			<p class="px-10-font primary-font-color text-justify" style="line-height: 8px; text-indent: 20px;">To ensure that you, as a student, understand your obligations and commitmens to this courses, we have developed our Community Education Australia ‘STUDENT HANDBOOK’</p>
			<div class="clearfix" style="height:20px;"></div>
			<p class="px-10-font primary-font-color text-justify" style="line-height: 8px; text-indent: 20px;">It is important that you read our handbook prior to submitting these documents. As part of the enrolment process, CEA delegate will summarise this and ask you to confirm your knowledge and understanding as well as your commitment and obligations.</p>
		</div>
	</div>

	<div class="part-18-b" style="position: absolute; bottom: 130px; right: 25px; width: 340px;">
		<div style="padding-left: 20px;">
			<p class="px-12-font calibri-bold primary-font-color" style="line-height: 8px;">Policies & Procedures Acces <img src="{{public_path()}}/cea-enrolment-form/images/blue-arrow.png" style="margin-left: 2px;"></p>
			<div class="clearfix" style="height:5px;"></div>
			<p class="px-10-font primary-font-color text-justify" style="line-height: 8px;">Please refer to CEA’s ‘STUDENT HANDBOOK’ for following  policies and procedures :</p>
			<div class="clearfix" style="height:10px;"></div>
			<ul class="dotted-list" style="margin-left: 20px;">
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Fee Refund Policy and Procedure</p></li>
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Complaints and Appeals Policy and Procedure</p></li>
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Code of Conduct</p></li>
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Fees and Charges Policy and Procedure</p></li>
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Access and Equality Policy and Procedure</p></li>
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Disciplinary Policy and Procedure</p></li>
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Recognition of Prior Learning and Course Credit Policy and Procedure</p></li>
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Qualification Issuing Policy and Procedure</p></li>
				<li><p class="primary-font-color px-10-font" style="line-height: 10px;">Personal Information and Privacy Policy and Procedure</p></li>
			</ul>
		</div>
	</div>
</body>
	<!-- End Page 3 of 5 -->
	<!-- Page 4 of 5 -->

<body class="exo2-regular position-relative page-1">
	<img src="{{public_path()}}/cea-enrolment-form/images/p4.jpg" class="page" alt="">
	<div class="" style="position: absolute; top: 200px; left: 30px; width: 735px;">
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">Please go through the eligibility criteria carefully before submission of the documents. The information is provided on our website <a href="http://communityeducation.edu.au" class="text-underline">http://communityeducation.edu.au</a> and Student Handbook.</p>
		<div class="clearfix" style="height: 15px;"></div>
		<h3 class="calibri-bold primary-font-color px-12-font no-margin">Student Privacy Information</h3>
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">Community Education Australia (CEA) is required to provide both state and Commonwealth Government, with student and training activity data which may include information you provide in this enrolment application form. Information is required to be provided for statistical purposes and in accordance with information and Privacy Policy. The Education and Training Reform Act 2006,the Student Identifiers Act 2014 (cth) and the Student Identifiers Regulation 2014 (cth) require and Community Education Australia to collect and disclose student personal information for a number of purposes including Commonwealth’s Uniqe Student Identifier (USI). For more Information in relation to how student information may be used or disclosed, please refer to Community Education Australia’s Personal Information & Privacy Policy and Procedure. (<a href="http://communityeducation.edu.au/" class="text-underline">http://communityeducation.edu.au/</a>) or contact Community Education AustraliCommunity a on (07) 3708 1061.</p>
		<div class="clearfix" style="height: 15px;"></div>
		<h3 class="calibri-bold primary-font-color px-12-font no-margin">Privacy Notice</h3>
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">Under the Data Provision Requirements 2012, Community Education Australia (CEA) is required to collect personal information about you and to disclose that personal information to the National Centre for Vocational Education Research Ltd (NCVER)</p>
	</div>

	<div class="" style="position: absolute; top: 445px; left: 30px; width: 360px;">
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">Your personal information (including the personal information contained on this enrolment form) may be used or disclosed by CEA for statistical, administrative, regulatory and research purposes. CEA may disclose your personal information for these purposes to:</p>
		<div class="clearfix" style="height: 10px;"></div>
		<ul class="dotted-list" style="margin-left: 10px;">
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">School - If you are a secondary student undertaking VET, including a school-based apprenticeship or traineeship;</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Employer - if you are enrolled in training paid by your employer;</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Commonwealth, State or Territory government departments and authorised agencies;</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">NCVER;</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Organisations conducting student surveys; and</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Researchers.</p>
			</li>
		</ul>
	</div>

	<div class="" style="position: absolute; top: 445px; right: 25px; width: 350px;">
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">Personal Information disclosed to NCVER may be used or disclosed for the following purposes:</p>
		<div class="clearfix" style="height: 25px;"></div>
		<ul class="dotted-list" style="margin-left: 10px;">
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Populated authenticated VET transcripts;</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Facilitating statistics and research relating to education,including surveys and data linkage;</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Pre-populating RTO student enrolment forms;</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Understanding how the VET market operates, for policy workforce, planning and consumer information;and</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Organisations conducting student surveys; and</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Administering VET, including program administration, regulation, monitoring and evaluation.</p>
			</li>
		</ul>
	</div>

	<div class="" style="position: absolute; bottom: 360px; left: 30px; width: 735px;">
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">You may receive a student survey which may be administered by a government department or NCVER employee, agent or third-party contractor or authorised agencies. Please note you may opt out of the survey at the time of being contacted NCVER will collect, hold, use and disclose your personal information in accordance with the Privacy Act 1988 (Cth), the National VET Data Policy and all NCVER policies and protocols (including those published on NCVER's website at <a href="www.ncver.edu.au" class="text-underline">www.ncver.edu.au</a>).</p>
		<div class="clearfix" style="height: 15px;"></div>
		<ul class="dotted-list" style="margin-left: 10px;">
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">For more information about NCVER's Privacy Policy got to <a href="https://www.ncver.edu.au/privacy" class="text-underline">https://www.ncver.edu.au/privacy</a></p>
			</li>
		</ul>
	</div>

	<div class="" style="position: absolute; bottom: 90px; left: 30px; width: 360px;">
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-0']) && in_array($ef['enrolment_declaration-0'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">The information herein provided is to the best of my knowledge true, correct, and complete at the time of enrolment,</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-1']) && in_array($ef['enrolment_declaration-1'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">I consent to the collection, use and disclosure of my personal information in accordance with the Privacy Notice above</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-2']) && in_array($ef['enrolment_declaration-2'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">I confirm that I have conducted a pre-training review in which I have discussed all my training options including RPL and CT with Community Education Australia and that the elected course/s is the appropriate training option for me.</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-3']) && in_array($ef['enrolment_declaration-3'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">I confirm and accept Community Education Australia’s recommended learning pathway as my training program.</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-4']) && in_array($ef['enrolment_declaration-4'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">I have read and understood Community Education Australia’s Personal Information & Privacy Policy Procedure</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-5']) && in_array($ef['enrolment_declaration-5'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">I have been provided with information about/and access to Community Education Australia’s Student Handbook, course training plan and schedule, assessment due dates and a current Statement of Fees.</p>
				</td>
			</tr>
		</table>
	</div>

	<div class="" style="position: absolute; bottom: 110px; right: 25px; width: 350px;">
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-6']) && in_array($ef['enrolment_declaration-6'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 30px;">I have been informed of my rights and obligations as a student with Community Education Australia, and agree to abide by all rules and regulations of Community Education Australia. I confirm that all arrangements are made to pay outstanding fees and charges applicable to this training program and that Community Education Australia can withhold my academic results until my debt is fully paid and any property belonging to Community Education Australia has been returned</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-7']) && in_array($ef['enrolment_declaration-7'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">I authorise Community Education Australia, in the of illness or accident during any organised activity, and where emergency contact or next ok kin cannot be contacted within reasonable time, to seek ambulance, medical or surgical treatment at my cost.</p>
				</td>
			</tr>
		</table>
	</div>

</body>
<!-- End Page 4 of 5 -->
<!-- Page 5 of 5 -->

<body class=" exo2-regular position-relative page-1">
	<img src="{{public_path()}}/cea-enrolment-form/images/p5.jpg" class="page" alt="">
	<div class="" style="position: absolute; top: 170px; left: 30px; width: 360px;">
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-8']) && in_array($ef['enrolment_declaration-8'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">(Optional) I hereby give my permission to Community Education Australia to use my (Name, Testimonial, Image /Photograph) in publications and advertisements produced by or for Community Education Australia. I understand that:</p>
					<ul class="dotted-list" style="margin-left: 10px;">
						<li>
							<p class="primary-font-color px-10-font" style="line-height: 10px;">These may be used for publication in film, photographs, in printed materials, electronically and on the internet.</p>
						</li>
						<li>
							<p class="primary-font-color px-10-font" style="line-height: 10px;">The above permission will apply for three years from the date of signing this form.</p>
						</li>
						<li>
							<p class="primary-font-color px-10-font" style="line-height: 10px;">I will not receive any compensation or payment for the above.</p>
						</li>
						<li>
							<p class="primary-font-color px-10-font" style="line-height: 10px;">Once my personal information has been published on the internet, Community Education Australia has no control over its subsequent use and disclosure.</p>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-9']) && in_array($ef['enrolment_declaration-9'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">A student’s USI may be used for specific VET purposes including the verification of student data provided by CEA, the administration and audit of VET providers and program; education-related policy and research purposes, and to assist in determining eligibility for training subsidies.</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-10']) && in_array($ef['enrolment_declaration-10'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">I agree to the Fee Refund Policy and Procedure.</p>
				</td>
			</tr>
		</table>
	</div>

	<div class="" style="position: absolute; top: 165px; right: 25px; width: 350px;">
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-11']) && in_array($ef['enrolment_declaration-11'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 3px;">I have read and understood the complaints and appeals processes, my rights as a student, the Privacy Statement and my right to access Australian Consumer Protection law.</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-12']) && in_array($ef['enrolment_declaration-12'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 3px;">I have completed the language literacy and numeracy indicator tool, or been given the opportunity to.</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-13']) && in_array($ef['enrolment_declaration-13'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 3px;">I have also been provided with course information, duration of my course and I understand how to access support services and information I understand that access to academic records is provided free of charge.</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-14']) && in_array($ef['enrolment_declaration-14'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 3px;">I acknowledge that providing false, misleading or inaccurate information may affect the acceptance of this application and/or the continued provision of training and assessment services.</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-15']) && in_array($ef['enrolment_declaration-15'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 3px;">I have read and understood CEA’s Statement of Fees.</p>
				</td>
			</tr>
			<tr>
				<td width="5%" valign="top">
					<div class="checkbox {{isset($ef['enrolment_declaration-16']) && in_array($ef['enrolment_declaration-16'], [true, 1]) ? 'checked' : ''}}" style="margin-top: 3px;"></div>
				</td>
				<td width="95%" valign="top">
					<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 3px;">I acknowledge that all fees are payable in full on course commencement or the commencement of the term that fees are due.</p>
				</td>
			</tr>
		</table>
		<div>
			@php
				$fullname = [];
				if(isset($ef['firstname'])){
					$fullname[] = $ef['firstname'];
				}
				if(isset($ef['lastname'])){
					$fullname[] = $ef['lastname'];
				}
			@endphp
			<p class="primary-font-color px-12-font display-inlineblock">Applicant’s Name</p>
			{{-- <div class="textbox display-inlineblock" style="width: 248px; margin-top: 0; margin-bottom: 0;">{{implode(' ', $fullname)}}</div> --}}
			<div class="textbox display-inlineblock" style="width: 125px; margin-top: 0; margin-bottom: 0;">{{implode(' ', $fullname)}}</div>
			
			<p class="primary-font-color px-12-font display-inlineblock">Date</span></p>
			<div class="textbox display-inlineblock" style="width: 80px; margin-top: 0; margin-bottom: 0;">{{isset($ep->created_at) ? \Carbon\Carbon::parse($ep->created_at)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
			<div class="clearfix"></div>

			<p class="primary-font-color px-12-font display-inlineblock">Applicant’s Signature</span></p>
			<div class="textbox display-inlineblock" style="width: 220px; margin-top: 0; margin-bottom: 0; margin-right: 10px;"><p class="type-signature">{{isset($ep->type_signature) ? $ep->type_signature : ''}}<p></div>
			
		</div>
	</div>

	<div style="position: absolute; top: 470px; left: 30px; width: 735px;">
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px;">Please consider the qualification, the job role, and required level of language, literacy and numeracy that</p>
	</div>

	<div class="" style="position: absolute; top: 500px; left: 30px; width: 360px;">
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">Additional Language, Literacy, and Numeracy assistance required to achieve workplace competency?</p>
		<table width="30%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> Yes</label></div>
				</td>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> No</label></div>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">Review deems proposed assessment instruments, learning material and strategies as appropriate.</p>
		<table width="30%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> Yes</label></div>
				</td>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> No</label></div>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">Review deems proposed assessment instruments, learning material and strategies require adjustment. Additional language, literacy or numeracy support will be required.</p>
		<table width="30%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> Yes</label></div>
				</td>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> No</label></div>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">What is applicant’s capacity to benefit?</p>
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="15%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> Yes</label></div>
				</td>
				<td width="15%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> No</label></div>
				</td>
				<td width="20%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> Good</label></div>
				</td>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> Very Good Excellent</label></div>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>
	</div>

	<div class="" style="position: absolute; top: 500px; right: 25px; width: 350px;">
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">Review identified current competence (list below) (if Mutual Recognition, attach Record of Results)</p>
		<table width="30%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> Yes</label></div>
				</td>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> No</label></div>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>
		<p class="primary-font-color px-10-font text-justify" style="line-height: 10px; margin-bottom: 5px;">Based on the information provided in the Pre-training review I believe the course selected is suitable for the learner.</p>
		<table width="30%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> Yes</label></div>
				</td>
				<td width="50%">
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> No</label></div>
				</td>
			</tr>
		</table>
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> I have assessed this applicant</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> I find that the applicant is competent in language, literacy and numeracy.</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label label-textbox"></label>
					<div class="checkbox"><label class="label label-checkbox primary-font-color"> I find that the applicant is not competent in language, literacy and numeracy.</label></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="textbox long white-bg-color" style="height: 70px;">Comment if any</div>
				</td>
			</tr>
		</table>
		<div class="clearfix"></div>
	</div>

	<div style="position: absolute; bottom: 230px; left: 30px; width: 735px;">
		<h3 class="calibri-bold primary-font-color px-12-font no-margin" style="line-height: 12px; margin-bottom: 5px;">Document Checklist</h3>
		<ul class="dotted-list" style="margin-left: 10px;">
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Proof of Australian citizenship/residency status or New Zealand citizenship</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Photo identification</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Proof of residential address</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Proof of age, if no Australian Driving License</p>
			</li>
			<li>
				<p class="primary-font-color px-10-font" style="line-height: 10px;">Enrolment Application Form filled and signed</p>
			</li>
		</ul>
	</div>

	<div style="position: absolute; bottom: 78px; left: 30px; width: 735px;">
		<h3 class="calibri-bold primary-font-color px-12-font no-margin" style="line-height: 12px;">For CEA Official</h3>
		<p class="primary-font-color px-10-font" style="line-height: 10px; margin-bottom: 10px;">I confirm that the applicant has been informed of entry requirements for the course and eligibility requirements for government subsidised training under the VET Investment Plan or other subsidised training under the Queensland Government and that the applicant is aware of the consequences arising from a false, misleading or an in complete declaration.</p>
		<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="50%">
					<p class="primary-font-color px-10-font" style="line-height: 10px;">Date Received:</p>
					<div class="textbox" style="margin-top: 0;"></div>
				</td>
				<td width="50%">
					<p class="primary-font-color px-10-font" style="line-height: 10px;">Date Approved:</p>
					<div class="textbox" style="margin-top: 0;"></div>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<p class="primary-font-color px-10-font" style="line-height: 10px;">Approved by:</p>
					<div class="textbox" style="margin-top: 0;"></div>
				</td>
				<td width="50%">
					<p class="primary-font-color px-10-font" style="line-height: 10px;">Signature:</p>
					<div class="textbox" style="margin-top: 0;"></div>
				</td>
			</tr>
		</table>
	</div>

</body>
<!-- End Page 5 of 5 -->

</html>