<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/cea-enrolment-form-funding/pdf-style.css" rel="stylesheet" />
	<title>Enrolment Form</title>
	<!-- Page 1 of 8 -->

	<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{public_path()}}/cea-enrolment-form-funding/images/cea-logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p>
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">
						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>1. Course</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="100%">
									<label class="label label-textbox">The course you are applying for</label>
									<div class="checkbox {{isset($ef['course']) && $ef['course']['code'] == 'CPP20218' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color">&nbsp;<span class="proximanova-bold">CPP20218</span> - CERTIFICATE II IN SECURITY OPERATIONS</label></div>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>2. Mode of Delivery</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="100%">
									<label class="label label-textbox">Choose the preferred mode of delivery</label>
									<table width="70%" class="form-table">
										<tr>
											<td width="10%">
												<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'Face to face' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Face-to-Face</label></div>
											</td>
											<td width="10%">
												<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'Blended' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Blended</label></div>
											</td>
											<td width="10%">
												<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'Distance Learning' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Distance Learning</label></div>
											</td>
										</tr>
										<tr>
											<td width="10%">
												<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'Work based' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Work based</label></div>
											</td>
											<td width="10%">
												<div class="checkbox {{isset($ef['mode_of_delivery']['alt_description']) && $ef['mode_of_delivery']['alt_description'] == 'On-site at your address' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> On-site at your address</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>3. Personal Details</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="100%">
									<label class="label label-textbox">Title</label>
									<table width="50%" class="form-table">
										<tr>
											<td width="10%">
												<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Mr.' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Mr.</label></div>
											</td>
											<td width="10%">
												<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Mrs.' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Mrs.</label></div>
											</td>
											<td width="10%">
												<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Miss' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Miss</label></div>
											</td>
											<td width="10%">
												<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Dr.' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Dr.</label></div>
											</td>
											<td width="10%">
												<div class="checkbox {{isset($ef['prefix']) && $ef['prefix'] == 'Other' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other</label></div>
											</td>
										</tr>
									</table>
									<table width="100%" class="form-table">
										<tr>
											<td width="50%">
												<label class="label label-textbox">Family Name</label>
												<div class="textbox">{{isset($ef['lastname']) ? $ef['lastname'] : ''}}</div>
											</td>
											<td width="50%">
												<label class="label label-textbox">Given Name(s)</label>
												<div class="textbox">{{isset($ef['firstname']) ? $ef['firstname'] : ''}}</div>
											</td>
										</tr>
										<tr>
											<td width="50%">
												<label class="label label-textbox">Gender</label>
												<table width="100%" class="form-table">
													<tr>
														<td width="8%">
															<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Male' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Male</label></div>
														</td>
														<td width="10%">
															<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Female' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Female</label></div>
														</td>
														<td width="9%">
															<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Other' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other</label></div>
														</td>
														<td width="23s%">
															<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == '@' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Don’t want to disclose</label></div>
														</td>
													</tr>
												</table>
											</td>
											<td width="50%">
												<label class="label label-textbox">Date of Birth</label>
												@php
													$dob = null;
													if (isset($ef['date_of_birth']['value'])){
														$dob = $ef['date_of_birth']['value'];
													}elseif (isset($ef['date_of_birth'])){
														$dob = $ef['date_of_birth'];
													}
												@endphp
												<div class="textbox">{{$dob ? \Carbon\Carbon::parse($dob)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>4. Contact Details</span></p>

						<table width="100%" class="form-table">
							<tr>
								<td width="100%">
									<table width="100%" class="form-table">
										<tr>
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
											<td width="100%" colspan="2">
												<label class="label label-textbox">Residential Address</label>
												<div class="textbox">{{implode(' ', $addr)}}</div>
											</td>
										</tr>
										<tr>
											<td width="50%">
												<label class="label label-textbox">State</label>
												<div class="textbox">{{$ef['addr_location'] ? $ef['addr_location'] : null}}</div>
											</td>
											<td width="50%">
												<label class="label label-textbox">Post Code</label>
												<div class="textbox">{{$ef['addr_postcode'] ? $ef['addr_postcode'] : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="100%">
									<table width="100%" class="form-table">
										<tr>
											<td width="100%" colspan="2">
												<label class="label label-textbox">Postal Address (if
													different from above)</label>
												<div class="textbox">{{isset($ef['addr_postal_delivery_box']) ? $ef['addr_postal_delivery_box'] : null}}</div>
											</td>
										</tr>
										<tr>
											<td width="50%">
												<label class="label label-textbox">State</label>
												<div class="textbox"></div>
											</td>
											<td width="50%">
												<label class="label label-textbox">Post Code</label>
												<div class="textbox"></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="100%">
									<table width="100%" class="form-table">
										<tr>
											<td width="50%">
												<label class="label label-textbox">Telephone</label>
												<div class="textbox">{{isset($ef['phone_home']) ? $ef['phone_home'] : null}}</div>
											</td>
											<td width="50%">
												<label class="label label-textbox">Mobile</label>
												<div class="textbox">{{isset($ef['phone_mobile']) ? $ef['phone_mobile'] : null}}</div>
											</td>
										</tr>
										<tr>
											<td width="50%">
												<label class="label label-textbox">Email</label>
												<div class="textbox">{{isset($ef['email']) ? $ef['email'] : null}}</div>
											</td>
											<td width="50%">
												<label class="label label-textbox">Alternative Email</label>
												<div class="textbox">{{isset($ef['email_at']) ? $ef['email_at'] : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>5. Emergency Contact Details</span></p>

						<table width="100%" class="form-table">
							<tr>
								<td width="100%">
									<table width="100%" class="form-table">
										<tr>
											<td width="100%" colspan="2">
												<label class="label label-textbox">Name</label>
												<div class="textbox">{{isset($ef['e_contact_name']) ? $ef['e_contact_name'] : null}}</div>
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="2">
												<label class="label label-textbox">Address</label>
												<div class="textbox"{{isset($ef['e_address']) ? $ef['e_address'] : null}}></div>
											</td>
										</tr>
										<tr>
											<td width="50%">
												<label class="label label-textbox">Telephone</label>
												<div class="textbox">{{isset($ef['e_telephone']) ? $ef['e_telephone'] : null}}</div>
											</td>
											<td width="50%">
												<label class="label label-textbox">Relationship</label>
												<div class="textbox">{{isset($ef['e_relationship']) ? $ef['e_relationship'] : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<!-- End Page 1 of 8 -->

	<!-- Page 2 of 8 -->

	<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{public_path()}}/cea-enrolment-form-funding/images/cea-logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p>
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">
						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>6. Residency & Visa Information</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="100%" colspan="3">
									<table width="100%" class="form-table">
										<tr>
											<td width="50%">
												<label class="label label-textbox">Nationality</label>
												<div class="textbox">{{isset($ef['nationality']) ? $ef['nationality'] : null}}</div>
											</td>
											<td width="50%">
												<label class="label label-textbox">Pasport No.</label>
												<div class="textbox">{{isset($ef['passport_no']) ? $ef['passport_no'] : null}}</div>
											</td>
										</tr>
										<tr>
											<td width="50%">
												@php
													$pid = null;
													if(isset($ef['passport_issued_date']['value'])){
														$pid = $ef['passport_issued_date']['value'];
													}elseif(isset($ef['passport_issued_date'])){
														$pid = $ef['passport_issued_date'];
													}
												@endphp
												<label class="label label-textbox">Issue Date</label>
												<div class="textbox">{{$pid ? \Carbon\Carbon::parse($pid)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
											</td>
											<td width="50%">
												@php
													$ped = null;
													if(isset($ef['passport_expiry_date']['value'])){
														$ped = $ef['passport_expiry_date']['value'];
													}elseif(isset($ef['passport_expiry_date'])){
														$ped = $ef['passport_expiry_date'];
													}
												@endphp
												<label class="label label-textbox">Expiry Date</label>
												<div class="textbox">{{$ped ? \Carbon\Carbon::parse($ped)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
											</td>
										</tr>
										<tr>
											<td width="50%">
												@php
													$visa = isset($ef['visa_type']['value']) ? explode( ' (subclass ',$ef['visa_type']['value']) : null;
												@endphp
												<label class="label label-textbox">Visa Type (If not australian Citizen)</label>
												<div class="textbox">{{isset($visa[0]) ? $visa[0] : null}}</div>
											</td>
											<td width="50%">
												<label class="label label-textbox">Sub Class</label>
												<div class="textbox">{{isset($visa[1]) ? str_replace(")","",$visa[1]) : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								@php
									$ved = null;
									if(isset($ef['visa_expiry_date']['value'])){
										$ved = $ef['visa_expiry_date']['value'];
									}elseif(isset($ef['visa_expiry_date'])){
										$ved = $ef['visa_expiry_date'];
									}
								@endphp
								<td width="40%" valign="top">
									<label class="label label-textbox">Expiry Date</label>
									<div class="textbox">{{$ved ? \Carbon\Carbon::parse($ved)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
								</td>
								<td width="20%" valign="top">
									<label class="label label-textbox">Study Rights (In Australia)</label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="50%" class="form-table">
										<tr>
											<td width="10%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['study_rights']) && in_array($ef['study_rights'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="10%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['study_rights']) && !in_array($ef['study_rights'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
								<td width="40%" valign="top">
									<label class="label label-textbox">Applied for Australian Permanent Residency</label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="50%" class="form-table">
										<tr>
											<td width="10%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['au_permanent_residency']) && in_array($ef['au_permanent_residency'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="10%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['au_permanent_residency']) && !in_array($ef['au_permanent_residency'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>7. Schooling</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="15%" valign="top">
									<label class="label label-textbox">Still in School</label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="10%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['at_school']) && in_array($ef['at_school'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="10%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['at_school']) && !in_array($ef['at_school'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
								<td width="25%" valign="top">
									<label class="label label-textbox">Highest Qualification completed</label>
									<div class="textbox">{{isset($ef['highest_school_level_completed_id']['description']) ? $ef['highest_school_level_completed_id']['description'] : ''}}</div>
								</td>
								<td width="15%" valign="top">
									<label class="label label-textbox">Year Completed</label>
									<div class="textbox">{{isset($ef['year_completed']) ? $ef['year_completed'] : ''}}</div>
								</td>
								<td width="40%" valign="top">
									<label class="label label-textbox">Institute</label>
									<div class="textbox">{{isset($ef['institute']) ? $ef['institute'] : ''}}</div>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>8. Previous Qualifications Achieved</span></p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="15%" valign="top">
									<label class="label label-textbox">Still in School</label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="10%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['post_secondary']) && in_array($ef['post_secondary'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="10%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['post_secondary']) && !in_array($ef['post_secondary'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
								<td width="25%" valign="top">
									<label class="label label-textbox">Highest Qualification completed</label>
									<div class="textbox">
										@if ($ef['post_highest_qualification_completed_id'])
											@if (isset($ef['post_highest_qualification_completed_id']['description']))
												{{$ef['post_highest_qualification_completed_id']['description']}}
											@else
											{{$ef['post_highest_qualification_completed_id']}}
											@endif
										@endif
										{{-- {{isset($ef['post_highest_qualification_completed_id']) ? $ef['post_highest_qualification_completed_id'] : ''}} --}}
									</div>
								</td>
								<td width="15%" valign="top">
									<label class="label label-textbox">Year Completed</label>
									<div class="textbox">{{isset($ef['post_year_completed']) ? $ef['post_year_completed'] : ''}}</div>
								</td>
								<td width="40%" valign="top">
									<label class="label label-textbox">Institute</label>
									<div class="textbox">{{isset($ef['post_institute']) ? $ef['post_institute'] : ''}}</div>
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<label class="label label-textbox">Equivalent</label>
									<table class="table-bordered" width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="50%" style="padding: 0;">
												<table width="100%" class="" cellpadding="0" cellspacing="0" border="0">
													@php
														$pea = [];
														if(isset($ef['prior_educational_achievement_ids'])){
															foreach ($ef['prior_educational_achievement_ids'] as $k => $v){
																$pea[$v['value']] = explode(' - ', $v['description'])[0];
															}
														}
													@endphp
													<thead>
														<tr>
															<th width="5%" class="text-center">A</th>
															<th width="5%" class="text-center">E</th>
															<th width="5%" class="text-center">I</th>
															<th width="80%"></th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td width="5%">
																<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="80%">
																<p class="px-12-font proximanova-bold">Certificate I</p>
															</td>
														</tr>
														<tr>
															<td width="5%">
																<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="80%">
																<p class="px-12-font proximanova-bold">Certificate II</p>
															</td>
														</tr>
														<tr>
															<td width="5%">
																<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="80%">
																<p class="px-12-font proximanova-bold">Certificate III or Trade Certificate</p>
															</td>
														</tr>
														<tr>
															<td width="5%">
																<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="80%">
																<p class="px-12-font proximanova-bold">Certificate IV or Advanced
																	Certificate/Technician </p>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
											<td width="50%" style="padding: 0;">
												<table width="100%" class="" cellpadding="0" cellspacing="0" border="0">
													<thead>
														<tr>
															<th width="5%" class="text-center">A</th>
															<th width="5%" class="text-center">E</th>
															<th width="5%" class="text-center">I</th>
															<th width="80%"></th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td width="5%">
																<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="80%">
																<p class="px-12-font proximanova-bold">Diploma of Associate Diploma</p>
															</td>
														</tr>
														<tr>
															<td width="5%">
																<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="80%">
																<p class="px-12-font proximanova-bold">Advanced Diploma of Associate Degree Level</p>
															</td>
														</tr>
														<tr>
															<td width="5%">
																<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="80%">
																<p class="px-12-font proximanova-bold">Bachelor Degree or Higher Degree Level</p>
															</td>
														</tr>
														<tr>
															<td width="5%">
																<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="5%">
																<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0;"></div>
															</td>
															<td width="80%">
																<p class="px-12-font proximanova-bold">Certificates other than the above</p>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<p class="px-12-font">Please provide certified documents for the courses that you took.</p>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>9. Language and Cultural Diversity</span></p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="59%" valign="top">
									<label class="label label-textbox">Birth Country</label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="20%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] == '1101' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Australia</label></div>
											</td>
											<td width="35%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] != '1101' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other, please specify</label></div>
											</td>
											<td width="45%">
												<label class="label label-textbox"></label>
												<div class="textbox">{{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] != '1101' ?  $ef['birth_country_id']['full_name'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
								<td width="45%" valign="top">
									<label class="label label-textbox">Spoken Language <span class="px-10-font">(at home)</span></label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="30%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['spoken_language']) && $ef['spoken_language'] != true ?  'checked' : ''}}"><label class="label label-checkbox black-font-color"> No <span class="px-10-font">(Yes, please specify)</span></label></div>
											</td>
											<td width="30%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['spoken_language']) && $ef['spoken_language'] == true ?  'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes, please specify </label></div>
											</td>
											<td width="40%">
												<label class="label label-textbox"></label>
												<div class="textbox">
													@if (isset($ef['spoken_language_specify']))
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
								<td width="50%" valign="top">
									<label class="label label-textbox">English Language <span class="px-10-font">( How well do you speak English? )</span></label></label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="25%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Very Well' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Very Well</label></div>
											</td>
											<td width="25%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Well' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Well</label></div>
											</td>
											<td width="25%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Not Well' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Not Well</label></div>
											</td>
											<td width="25%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Not at all' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Not at all</label></div>
											</td>
										</tr>
									</table>
								</td>
								<td width="50%" valign="top">
									<label class="label label-textbox">Origin</label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="30%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Aboriginal' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Aboriginal</label></div>
											</td>
											<td width="40%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Torres Strait Islander' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Torres Strait Islander</label></div>
											</td>
											<td width="30%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Both' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Both</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>10. Disability</span></p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="40%" valign="top">
									<label class="label label-textbox">Condition: </label>
									<label class="label label-textbox">Do you consider yourself to have a disability, impairment or long-term
										condition?</label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="20%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['disability_flag']) && $ef['disability_flag'] != true ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
											<td width="80%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($ef['disability_flag']) && $ef['disability_flag'] == true ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes, please indicate the areas of condition:</label></div>
											</td>
										</tr>
									</table>
								</td>
								<td width="60%"></td>
							</tr>
							<tr>
								<td width="100%" colspan="2" valign="top">
									<label class="label label-textbox">Condition: </label>
									<label class="label label-textbox">Do you consider yourself to have a disability, impairment or long-term
										condition?</label>
									<div class="clearfix" style="height: 10px;"></div>
									<table width="100%" class="form-table">
										@php
											$dis = [];
											if(isset($ef['disabilitiy_ids'])){
												foreach ($ef['disabilitiy_ids'] as $k => $v){
													$dis[$v['description']] = true;
												}
											}
										@endphp
										<tr>
											<td width="20%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Hearing/Deaf']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Hearing/Deaf</label></div>
											</td>
											<td width="25%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Physical']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Physical</label></div>
											</td>
											<td width="20%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Intellectual']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Intellectual</label></div>
											</td>
											<td width="35%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Acquired Brain Impairment']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Acquired Brain Impairment</label></div>
											</td>
											<td width="30%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Mental Illness']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Mental Illness</label></div>
											</td>
										</tr>
										<tr>
											<td width="20%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Vision']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Vision</label></div>
											</td>
											<td width="25%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Medical Condition']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Medical Condition</label></div>
											</td>
											<td width="20%">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Learning']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Learning</label></div>
											</td>
											<td width="35%" colspan="2">
												<label class="label label-textbox"></label>
												<div class="checkbox {{isset($dis['Other']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<!-- End Page 2 of 8 -->

	<!-- Page 3 of 8 -->

	<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{public_path()}}/cea-enrolment-form-funding/images/cea-logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p>
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>11. Employment</span></p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Employment Status: </label>
									<label class="label label-textbox">In following categories, which BEST describes your current employment status?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table">
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
											<td width="25%">
												<div class="checkbox {{isset($labor['01']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Full-time employee</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($labor['02']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Part-time employee</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($labor['04']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Self-employed - Employing others</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($labor['03']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 9px;"> Self-employed - Not employing others</label></div>
											</td>
										</tr>
										<tr>
											<td width="25%">
												<div class="checkbox {{isset($labor['05']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Employed - Unpaid worker</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($labor['06']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 9px;"> Unemployed - Seeking Full-time work</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($labor['08']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Not employed - Not seeking work</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($labor['07']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 9px;"> Unemployed - Seeking Part-time work</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">If currently employed, or recently been employed: </label>
									<label class="label label-textbox" style="font-size: 10px;">Choose the classification of occupation that best describe your occupation (choose one only)</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table">
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
											<td width="20%">
												<div class="checkbox {{isset($if_employed['Manager']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Manager</label></div>
											</td>
											<td width="35%">
												<div class="checkbox {{isset($if_employed['Community & Personal Sevice Worker']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Community & Personal Service Worker</label></div>
											</td>
											<td width="15%">
												<div class="checkbox {{isset($if_employed['Professional']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Professional</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($if_employed['Early Childhood Educator']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Early Childhood Educator</label></div>
											</td>
										</tr>
										<tr>
											<td width="20%">
												<div class="checkbox {{isset($if_employed['Admin & Support']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Admin & Support</label></div>
											</td>
											<td width="35%">
												<div class="checkbox {{isset($if_employed['Other']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other (please specify)</label></div>
											</td>
											<td width="40%" colspan="2">
												<div class="textbox">{{isset($ef['if_employed_other']) ? $ef['if_employed_other'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>12. Study Reason</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Main Reason: </label>
									<label class="label label-textbox">In following categories, which BEST describes your main reason for undertaking the course(s) with CEA?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="25%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '02'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> To develop my existing business</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '04'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> To try for a different career</label></div>
											</td>
											<td width="20%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '01'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> To get a job</label></div>
											</td>
											<td width="30%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '07'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Want extra skills for my job</label></div>
											</td>
										</tr>
										<tr>
											<td width="25%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '05'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> To get better job or promotion</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '07'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Requirement of my job</label></div>
											</td>
											<td width="20%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '08'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> To get into another course</label></div>
											</td>
											<td width="30%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '12'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> For personal interest & self-development</label></div>
											</td>
										</tr>
										<tr>
											<td width="25%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '03'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> To start my own business</label></div>
											</td>
											<td width="25%">
												<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '11'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Other reason (please state)</label></div>
											</td>
											<td width="50%" colspan="2">
												<div class="textbox">{{isset($ef['study_reason_other']) ? $ef['study_reason_other'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>13. RPL / Credit Transfer</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Requirement: </label>
									<label class="label label-textbox">Are you seeking Recognition of Prior Learning or Credit Transfer?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="10%">
												<div class="checkbox {{isset($ef['rpl_ct_flag']) && !in_array($ef['rpl_ct_flag'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
											<td width="10%">
												<div class="checkbox {{isset($ef['rpl_ct_flag']) && in_array($ef['rpl_ct_flag'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="80%">
												<p class="px-10-font">If ‘Yes’, then please contact Admissions Department for further details about the Recognition of Prior Learning (RPL) / Credit Transfer (CT) process.</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>14. Transferring Learning</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Are you transferring from another education provider in Australia?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="20%" class="form-table">
										<tr>
											<td width="50%">
												<div class="checkbox {{isset($ef['trasferring_learning']) && !in_array($ef['trasferring_learning'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
											<td width="50%">
												<div class="checkbox {{isset($ef['trasferring_learning']) && in_array($ef['trasferring_learning'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Are you currently enrolled in an institute?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="10%">
												<div class="checkbox {{isset($ef['currently_enrolled_in_an_institute']) && !in_array($ef['currently_enrolled_in_an_institute'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
											<td width="45%">
												<div class="checkbox {{isset($ef['currently_enrolled_in_an_institute']) && in_array($ef['currently_enrolled_in_an_institute'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes. If ‘Yes’, then please provide the name of institute:</label></div>
											</td>
											<td width="45%">
												<div class="textbox">{{isset($ef['currently_enrolled_in_an_institute_if_yes']) ? $ef['currently_enrolled_in_an_institute_if_yes'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>15. USI</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Unique Student Identifier: </label>
									<label class="label label-textbox">Have you applied for Unique Student Identifier (USI) before?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="10%">
												<div class="checkbox {{isset($ef['usi_flag']) && $ef['usi_flag'] != true ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
											<td width="45%">
												<div class="checkbox {{isset($ef['usi_flag']) && $ef['usi_flag'] == true ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes. If ‘Yes’, please provide your USI:</label></div>
											</td>
											<td width="45%">
												<div class="textbox">{{isset($ef['unique_student_id']) ? $ef['unique_student_id'] : ''}}</div>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<p class="px-12-font text-justify">If ‘No’, you can visit <a href="https://www.usi.gov.au/" class="primary-font-color">https://www.usi.gov.au/</a> to create USI. Once created, please provide the same to Admissions department. If you want CEA to create USI on your behalf, please contact Admissions department, email at <a href="mailto:info@communityeducation.edu.au" class="primary-font-color">info@communityeducation.edu.au</a> or call (07)37081061 for further guidance.</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>16. Documentation</span></p>
						<table width="100%" class="form-table">
							<tr>
								<td width="50%" valign="top">
									<label class="label label-textbox">Required Documen: </label>
									<label class="label label-textbox" style="font-size: 9px;">Please provide the following documentation if you believe you are eligible to access Queensland Government funding (must provide a clear copy).</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
										<thead>
											<tr>
												<th width="33.33%" class="px-10-font primary-bg-color" style="padding: 2px 5px;">Australian citizen / <br>Permanent Resident / <br>New Zealand citizen</th>
												<th width="33.33%" class="px-10-font primary-bg-color" style="padding: 2px 5px;">Queensland<br>Residency</th>
												<th width="33.33%" class="px-10-font primary-bg-color" style="padding: 2px 5px;">Concessional<br>(if Applicable)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td valign="top" style="padding: 2px 5px; ">
													<ul class="px-8-font" style="padding-left: 7px;">
														<li>Green Medicare Card</li>
														<li>Australian Birth Certificate</li>
														<li>New Zealand passport</li>
														<li>New Zealand Certificate of Statust</li>
														<li>Permanent Residency Visa</li>
														<li>Special Category visa</li>
														<li>Temporary Residence on a pathway to permanent residency – official letter </li>
													</ul>
												</td>
												<td valign="top" style="padding: 2px 5px;">
													<ul class="px-8-font" style="padding-left: 7px;">
														<li>Driver’s license (Front and Back)</li>
														<li>Rates/Utility bills</li>
														<li>Queensland Vehicle Registration Certificate</li>
														<li>Official mail from a bank or ATO or Centrelink</li>
													</ul>
												</td>
												<td valign="top" style="padding: 2px 5px;">
													<ul class="no-padding px-8-font" style="padding-left: 7px;">
														<li>Health Care Card</li>
														<li>Pensioner Card</li>
														<li>Official Form – Confirming a person is a dependent/partner of concession cardholder and is named on the card</li>
														<li>Aboriginal or Torres Strait Islander</li>
														<li>Has a disability; and</li>
														<li>Adult Prisoner (HLS)</li>
													</ul>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td width="50%" valign="top">
									<label class="label label-textbox">Valid Concession Card: </label>
									<label class="label label-textbox">Do you have a valid Concession Card?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="100%" colspan="2">
												<div class="checkbox {{isset($ef['valid_concession_card_flag']) && !in_array($ef['valid_concession_card_flag'], [1,true]) ? 'checked' : '' }}"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
										<tr>
											<td width="100%" colspan="2">
												<div class="checkbox {{isset($ef['valid_concession_card_flag']) && !in_array($ef['valid_concession_card_flag'], [1,true]) ? 'checked' : '' }}"><label class="label label-checkbox black-font-color"> Yes, please indicate below:</label></div>
											</td>
										</tr>
									</table>
									<div class="clearfix" style="height: 20px;"></div>
									<table width="100%" class="form-table">
										@php
											$consession_yes = [];
											if(isset($ef['valid_concession_card_yes'])){
												foreach ($ef['valid_concession_card_yes'] as $key => $value) {
													$consession_yes[$value['value']] = true;
												}
											}
										@endphp
										<tr>
											<td width="50%">
												<div class="checkbox {{isset($consession_yes['Healthcare Card']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Healthcare Card</label></div>
											</td>
											<td width="50%">
												<div class="checkbox {{isset($consession_yes['Pensioner Concession Card']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Pensioner Concession Card</label></div>
											</td>
										</tr>
										<tr>
											<td width="50%">
												<div class="checkbox {{isset($consession_yes['Veteran’s Gold Card']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Veteran’s Gold Card</label></div>
											</td>
											<td width="50%">
												<div class="checkbox {{isset($consession_yes['Other proof as per the above Concessional list']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other proof as per the above Concessional list</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<!-- End Page 3 of 8 -->

	<!-- Page 4 of 8 -->

	<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{public_path()}}/cea-enrolment-form-funding/images/cea-logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p>
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>17. Fee Statement</span></p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Statement of Fees</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="100%" class="form-table">
										<tr>
											<td width="100%">
												<p class="px-12-font text-justify">CEA makes sure that all stakeholders are informed about fees and charges for all courses on
													our scope. It identifies the processes in place to protect the fees paid by students in advance
													and also includes implementing the course fee outline. (Please refer to the table below). Details
													of fees and charges are also supplied in the course information for each course and on the
													Policies sub-option found on our website ( <a href="http://communityeducation.edu.au/" class="primary-font-color">http://communityeducation.edu.au/</a> ). Please
													consult our course adviser too for further details.
												</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="100%" valign="top">
									<div class="clearfix" style="height: 10px;"></div>
									<label class="label label-textbox">Queensland Government Funding</label>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font">Tuition fees for eligible students under the state government funding:</p>
									<table width="100%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
										<thead>
											<tr>
												<th width="40%" class="px-12-font primary-bg-color text-center" style="padding: 2px 5px;">Course</th>
												<th width=" 20%" class="px-12-font primary-bg-color text-center" style="padding: 2px 5px;">Full Fee (FFS*)</th>
												<th width=" 20%" class="px-12-font primary-bg-color text-center" style="padding: 2px 5px;">Concession**</th>
												<th width=" 20%" class="px-12-font primary-bg-color text-center" style="padding: 2px 5px;">Non Concession**</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td valign=" top" style="padding: 2px 5px;">
													<p class=" px-12-font"><span class="proximanova-bold">CPP20218</span> - Certificate II in Security Operations</p>
												</td>
												<td valign="top" class="text-center" style="padding: 2px 5px;">
													<p class=" px-12-font">AUD1,200</p>
												</td>
												<td valign="top" class="text-center" style="padding: 2px 5px;">
													<p class=" px-12-font line-height-1">AUD 14.00</p>
													<p class="px-10-font">AUD 1.00 per unit</p>
												</td>
												<td valign="top" class="text-center" style="padding: 2px 5px;">
													<p class=" px-12-font line-height-1">AUD 28.00</p>
													<p class="px-10-font">AUD 2.00 per unit</p>
												</td>
											</tr>
										</tbody>
									</table>
									<p class="px-12-font">* FFS – Fee for Service</p>
									<p class="px-12-font">** Certificate 3 Guarantee Program</p>
									<div class="clearfix" style="height: 10px;"></div>
									<p class="px-12-font text-justify">This fee includes enrolment charges, tuition, services, material fees and other costs associated with delivering the training and assessment services and awarding the qualification to theparticipant.</p>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font text-justify">Students who are unable to meet their payment deadlines should inform CEA Reception staff and can request for payment plans. This is legally binding documents between Community Education Australia and the student enrolling in a course. Full payment is required before course completion. No certificate will be awarded if full payment has not been received.</p>
								</td>
							</tr>

						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>18. Fee Payment</span></p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Payment Method</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="50%" class="form-table">
										<tr>
											<td width="15%">
												<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Cash' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Cash</label></div>
											</td>
											<td width="55%">
												<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Direct Deposit in CEA’s Bank Account' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Direct Deposit in CEA’s Bank Account</label></div>
											</td>
											<td width="30%">
												<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Credit Card' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="font-size: 10px;"> Credit Card</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Bank Details</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="70%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
										<tbody>
											<tr>
												<td valign="top" width="30%" class="primary-bg-color proximanova-bold" style="padding: 2px 5px;">
													<p class=" px-12-font">Bank</p>
												</td>
												<td valign="top" width="70%" style="padding: 2px 5px;">
													<p class="px-12-font">Commonwealth Bank Australia</p>
												</td>
											</tr>
											<tr>
												<td valign="top" width="30%" class="primary-bg-color proximanova-bold" style="padding: 2px 5px;">
													<p class=" px-12-font">BSB</p>
												</td>
												<td valign="top" width="70%" style="padding: 2px 5px;">
													<p class="px-12-font">062 514</p>
												</td>
											</tr>
											<tr>
												<td valign="top" width="30%" class="primary-bg-color proximanova-bold" style="padding: 2px 5px;">
													<p class=" px-12-font">Account Number</p>
												</td>
												<td valign="top" width="70%" style="padding: 2px 5px; ">
													<p class="px-12-font">104 757 85</p>
												</td>
											</tr>
											<tr>
												<td valign="top" width="30%" class="primary-bg-color proximanova-bold" style="padding: 2px 5px;">
													<p class=" px-12-font">Account Name</p>
												</td>
												<td valign="top" width="70%" style="padding: 2px 5px;">
													<p class="px-12-font">McEvoy & Doust Pty Ltd trading as Community Education Australia</p>
												</td>
											</tr>
										</tbody>
									</table>
									<p class="px-12-font">(Please put your full name in description of direct deposit payment)</p>
								</td>
							</tr>
							<tr>
								<td width="100%" valign="top">
									<label class="label label-textbox">Credit Card</label>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font">I give permission for fee to be charged to my Credit Card for the selected course.</p>
									<table width="100%" class="form-table">
										<tr>
											<td width="30%" valign="top">
												<label class="label label-textbox">Card Type</label>
												<div class="clearfix" style="height: 5px;"></div>
												<table width="100%" class="form-table">
													<tr>
														<td width="50%">
															<div class="clearfix" style="height: 5px;"></div>
															<div class="checkbox {{isset($ef['credit_card_type']['value']) && $ef['credit_card_type']['value'] == 'Visa' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Visa Card</label></div>
														</td>
														<td width="50%">
															<div class="clearfix" style="height: 5px;"></div>
															<div class="checkbox {{isset($ef['credit_card_type']['value']) && $ef['credit_card_type']['value'] == 'Master Card' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Master Card</label></div>
														</td>
													</tr>
												</table>
											</td>
											<td width="25%" valign="top">
												@php
													$ced = null;
													if(isset($ef['card_expiry_date']['value'])){
														$ced = $ef['card_expiry_date']['value'];
													}elseif(isset($ef['card_expiry_date'])){
														$ced = $ef['card_expiry_date'];
													}
												@endphp
												<label class="label label-textbox">Card Expiry date</label>
												<div class="textbox">{{$ced ? \Carbon\Carbon::parse($ced)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
											</td>
											<td width="45%" valign="top">
												<label class="label label-textbox">Card Number</label>
												<div class="textbox">{{isset($ef['card_number']) ? $ef['card_number'] : ''}}</div>
											</td>
										</tr>
									</table>
									<table width="100%" class="form-table">
										<tr>
											<td width="25%" valign="top">
												<label class="label label-textbox">Card Identification Number <span class="px-10-font">(last 3 digits located on back)</span></label>
												<div class="textbox" style="display: inline-block; width: 30px;">{{isset($ef['card_id_num']) ? $ef['card_id_num'] : ''}}</div>
											</td>
											<td width="20%" valign="top">
												<label class="label label-textbox">Amount to be charged</label>
												<div class="textbox">{{isset($ef['amount_to_be_charged']) ? $ef['amount_to_be_charged'] : ''}}</div>
											</td>
											<td width="35%" valign="top">
												<label class="label label-textbox">Card Holder’s Name</label>
												<div class="textbox">{{isset($ef['card_holder_name']) ? $ef['card_holder_name'] : ''}}</div>
											</td>
											<td width="20%" valign="top">
												<label class="label label-textbox">Card Holder’s Signature</label>
												<div class="textbox">
													@if (isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Credit Card')
														<p class="type-signature">{{isset($ep->type_signature) ? $ep->type_signature : ''}}<p>
													@endif
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="section-header title proximanova-bold primary-font-color px-12-font text-justify text-uppercase"><span>19. Policies & Procedures</span></p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="50%" valign="top">
									<label class="label label-textbox">Information</label>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font">To ensure that you, as a student, understand your obligations and commitments to this course, we have developed our Community Education Australia <span class="proximanova-bold">Student Handbook</span>.</p>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-12-font">It is important that you read our handbook prior to submitting these documents. As part of the enrolment process, CEA delegate will summarise this and ask you to confirm your knowledge and understanding as well as your commitment and obligations.</p>
								</td>
								<td width="50%" valign="top">
									<label class="label label-textbox">Policies & Procedures access</label>
									<div class="clearfix" style="height: 5px;"></div>
									<p class="px-10-font">Please refer to CEA’s <span class="proximanova-bold">Student Handbook</span> for following policies and procedures:</p>
									<div class="clearfix" style="height: 1px;"></div>
									<ul class="no-padding px-10-font" style="padding-left: 7px;">
										<li>Fee Refund Policy and Procedure</li>
										<li>Complaints and Appeals Policy and Procedure</li>
										<li>Code of Conduct</li>
										<li>Fees and Charges Policy and Procedure</li>
										<li>Access and Equity Policy and Procedure</li>
										<li>Disciplinary Policy and Procedure</li>
										<li>Recognition of Prior Learning and Course Credit Policy and Procedure</li>
										<li>Qualification Issuing Policy and Procedure</li>
										<li>Personal Information and Privacy Policy and Procedure</li>
									</ul>
								</td>
							</tr>
						</table>

					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<!-- End Page 4 of8 -->

	<!-- Page 5 of8 -->

	<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{public_path()}}/cea-enrolment-form-funding/images/cea-logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p>
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">

						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="text-center primary-bg-color" style="padding: 5px 0;">
									<h3 class="no-margin px-14-font proximanova-bold line-height-1">ENROLMENT DECLARATION</h3>
									<p class="px-12-font">(For every Prospective Student to sign)</p>
								</td>
							</tr>
						</table>
						<p class="px-12-font">Please go through the eligibility criteria carefully before submission of the documents. The information is provided on our website <a href="http://communityeducation.edu.au" class="primary-font-color">http://communityeducation.edu.au</a> and Student Handbook.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<h5 class="proximanova-bold px-12-font no-margin">Student Privacy Information</h5>
						<p class="text-justify px-12-font">Community Education Australia (CEA) is required to provide both State and Commonwealth Government, with student and
							training activity data which may include information you provide in this enrolment application form. Information is required
							to be provided for statistical purposes and in accordance with Information and Privacy Policy. The Education and Training
							Reform Act 2006, the Student Identifiers Act 2014 (Cth) and the Student Identifiers Regulation 2014 (Cth) require and
							Community Education Australia to collect and disclose student personal information for a number of purposes including
							Commonwealth’s Unique Student Identifier (USI). For more information in relation to how student information may be
							used or disclosed, please refer to Community Education Australia’s Personal Information & Privacy Policy and Procedure.
							(<a href="http://communityeducation.edu.au/">http://communityeducation.edu.au/</a>) or contact Community Education Australia on (07) 3708 1061.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<h5 class="proximanova-bold px-12-font no-margin">Privacy Notice</h5>
						<p class="text-justify px-12-font">Under the Data Provision Requirements 2012, Community Education Australia (CEA) is required to collect personal information about you and to disclose that personal information to the National Centre for Vocational Education Research Ltd (NCVER).</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="text-justify px-12-font">Your personal information (including the personal information contained on this enrolment form) may be used or disclosed by CEA for statistical, administrative, regulatory and research purposes. CEA may disclose your personal information for these purposes to:</p>
						<ul class="px-12-font">
							<li>School – if you are a secondary student undertaking VET, including a school-based apprenticeship or traineeship;</li>
							<li>Employer – if you are enrolled in training paid by your employer;</li>
							<li>Commonwealth, State or Territory government departments and authorised agencies;</li>
							<li>NCVER;</li>
							<li>Organisations conducting student surveys; and</li>
							<li>Researchers.</li>
						</ul>
						<p class="text-justify px-12-font">Personal information disclosed to NCVER may be used or disclosed for the following purposes:</p>
						<ul class="px-12-font">
							<li>populated authenticated VET transcripts;</li>
							<li>facilitating statistics and research relating to education, including surveys and data linkage;</li>
							<li>pre-populating RTO student enrolment forms;</li>
							<li>understanding how the VET market operates, for policy, workforce, planning and consumer information; and</li>
							<li>administering VET, including program administration, regulation, monitoring and evaluation. </li>
						</ul>

						<p class="text-justify px-12-font">You may receive a student survey which may be administered by a government department or NCVER employee, agent or third-party contractor or authorised agencies. Please note you may opt out of the survey at the time of being contacted. </p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="text-justify px-12-font">NCVER will collect, hold, use and disclose your personal information in accordance with the Privacy Act 1988 (Cth), the National VET Data Policy and all NCVER policies and protocols (including those published on NCVER’s website at <a href="www.ncver.edu.au" class="primary-font-color">www.ncver.edu.au</a> ).</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="text-justify px-12-font">For more information about NCVER's Privacy Policy got to <a href="https://www.ncver.edu.au/privacy" class="primary-font-color">https://www.ncver.edu.au/privacy</a></p>

						<div class="clearfix" style="height: 10px;"></div>
						<h5 class="proximanova-bold px-12-font no-margin">Enrolment Declaration</h5>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-0']) && in_array($ef['enrolment_declaration-0'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> The information herein provided is to the best of my knowledge true, correct and complete at the time of my enrolment.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-1']) && in_array($ef['enrolment_declaration-1'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I consent to the collection, use and disclosure of my personal information in accordance with the Privacy Notice above.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-2']) && in_array($ef['enrolment_declaration-2'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I confirm that I have conducted a pre-training review in which I have discussed all my training options including RPL and CT with Community Education Australia and that the elected course/s is the appropriate training option for me.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-3']) && in_array($ef['enrolment_declaration-3'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I confirm and accept Community Education Australia’s recommended learning pathway as my training program.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-4']) && in_array($ef['enrolment_declaration-4'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have read and understood Community Education Australia’s Personal Information & Privacy Policy Procedure</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-5']) && in_array($ef['enrolment_declaration-5'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have been provided with information about/and access to Community Education Australia’s Student Handbook, course training plan and schedule, assessment due dates and a current Statement of Fees.</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<!-- End Page 5 of 8 -->

	<!-- Page 6 of 8 -->

	<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{public_path()}}/cea-enrolment-form-funding/images/cea-logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p>
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">

						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-6']) && in_array($ef['enrolment_declaration-6'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have been informed of my rights and obligations as a student with Community Education Australia, and agree to abide by all rules and regulations of Community Education Australia. I confirm that all arrangements are made to pay outstanding fees and charges applicable to this training program and that Community Education Australia can withhold my academic results until my debt is fully paid and any property belonging to Community Education Australia has been returned</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-7']) && in_array($ef['enrolment_declaration-7'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I authorise Community Education Australia, in the event of illness or accident during any organized activity, and where emergency contact or next of kin cannot be contacted within reasonable time, to seek ambulance, medical or surgical treatment at my cost.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-8']) && in_array($ef['enrolment_declaration-8'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> (Optional) I hereby give my permission to Community Education Australia to use my (Name, Testimonial, Image /Photograph) in publications and advertisements produced by or for Community Education Australia. I understand that:</label></div>
												<ul class="px-10-font">
													<li>These may be used for publication in film, photographs, in printed materials, electronically and on the internet.</li>
													<li>The above permission will apply for three years from the date of signing this form.</li>
													<li>I will not receive any compensation or payment for the above.</li>
													<li>Once my personal information has been published on the internet, Community Education Australia has no control over its subsequent use and disclosure.</li>
												</ul>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-9']) && in_array($ef['enrolment_declaration-9'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> A student’s USI may be used for specific VET purposes including the verification of student data provided by CEA, the administration and audit of VET providers and program; education-related policy and research purposes, and to assist in determining eligibility for training subsidies.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-10']) && in_array($ef['enrolment_declaration-10'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I agree to the Fee Refund Policy and Procedure.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-11']) && in_array($ef['enrolment_declaration-11'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have read and understood the complaints and appeals processes, my rights as a student, the Privacy Statement and my right to access Australian Consumer Protection law.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-12']) && in_array($ef['enrolment_declaration-12'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have completed the language literacy and numeracy indicator tool, or been given the opportunity to.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-13']) && in_array($ef['enrolment_declaration-13'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have also been provided with course information, duration of my course and I understand how to access support services and information I understand that access to academic records is provided free of charge.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-14']) && in_array($ef['enrolment_declaration-14'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I acknowledge that providing false, misleading or inaccurate information may affect the acceptance of this application and/or the continued provision of training and assessment services.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-15']) && in_array($ef['enrolment_declaration-15'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have read and understood CEA’s Statement of Fees.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-16']) && in_array($ef['enrolment_declaration-16'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I acknowledge that all fees are payable in full on course commencement or the commencement of the term that fees are due.</label></div>
											</td>
										</tr>
									</table>
									<table width="100%" class="form-table">
										@php
											$fullname = [];
											if(isset($ef['firstname'])){
												$fullname[] = $ef['firstname'];
											}
											if(isset($ef['lastname'])){
												$fullname[] = $ef['lastname'];
											}
										@endphp
										<tr>
											<td width="30%" valign="top" colspan="2">
												<label class="label label-textbox">Applicant’s Name</label>
												<div class="textbox">{{implode(' ', $fullname)}}</div>
											</td>
											<td width="50%" valign="top">
												<label class="label label-textbox">Applicant’s Signature</label>
												<div class="textbox"><p class="type-signature">{{isset($ep->type_signature) ? $ep->type_signature : ''}}<p></div>
											</td>
											<td width="20%" valign="top">
												<label class="label label-textbox">Date</label>
												<div class="textbox">{{isset($ep->created_at) ? \Carbon\Carbon::parse($ep->created_at)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 10px;"></div>

						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="text-center primary-bg-color" style="padding: 5px 0;">
									<h3 class="no-margin px-14-font proximanova-bold line-height-1">ENROLMENT DECLARATION</h3>
									<p class="px-12-font">(For Prospective Students accessing Queensland Government Funding)</p>
								</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 10px;"></div>
						<h3 class="no-margin px-12-font proximanova-bold text-center">PART A</h3>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_a-0']) && in_array($ef['part_a-0'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> 15 years of age or over, and are no longer at school (with the exception of VET in School (VETIS) Student)</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_a-1']) && in_array($ef['part_a-1'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> An Australian citizen, Australian permanent resident (includes humanitarian entrant), temporary resident with the necessary visa and work permits on the pathway to permanent residency, or a New Zealand citizen</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_a-2']) && in_array($ef['part_a-2'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> Permanently reside in QLD</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_a-3']) && in_array($ef['part_a-3'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> Do not hold, and neither enrolled in, a similar or higher-level qualification, not including qualifications completed at school and foundation skills training</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 5px;"></div>
						<h3 class="no-margin px-12-font proximanova-bold text-center">PART B</h3>
						<p class="px-12-font">I confirm that by signing this declaration, I am accepting an offer of a place in the course as outlined within this enrolment form and I further acknowledge and confirm that:</p>
						<div class="clearfix" style="height: 2px;"></div>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-0']) && in_array($ef['part_b-0'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I understand that the information I have provided to Community Education Australia (CEA) at enrolment and during my course may be disclosed to the Department of Employment, Small Business and Training (DESBT), the Commonwealth and State Agencies through its obligations to comply with the Training Reform Act 2006. The DESBT may use the information provided to it for planning, administration, policy development, program evaluation, resource allocation, and reporting and/or research activities. For these and other lawful purposes, the DESBT may also disclose information to its consultants, advisers, other government agencies, professional bodies and or other organisations. I have been advised by CEA that I may be contacted and requested to participate in a National Centre for Vocational Education Research survey or a Department-endorsed project for audit or review.)</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-1']) && in_array($ef['part_b-1'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> Prior to enrolment, I have read and understand the Community Education Australia Student Handbook and agree to abide by Community Education Australia policies and procedures and Code of Conduct.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-2']) && in_array($ef['part_b-2'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I agree to the Refund Policy provided in the Student Handbook.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-3']) && in_array($ef['part_b-3'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have read and understood the complaints and appeals processes, my rights as a student, the Privacy Statement and my right to access Australian Consumer Protection law.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-4']) && in_array($ef['part_b-4'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have completed the language literacy and numeracy indicator tool, or understand that I will be given the opportunity to.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-5']) && in_array($ef['part_b-5'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have also been provided with course information, duration of my course and I understand how to access support services and information I understand that access to academic records is provided free of charge.</label></div>
											</td>
										</tr>


									</table>
								</td>
							</tr>
						</table>


					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<!-- End Page 6 of 8 -->

	<!-- Page 7 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{public_path()}}/cea-enrolment-form-funding/images/cea-logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p>
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">

						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-6']) && in_array($ef['part_b-6'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I acknowledge that providing false, misleading or inaccurate information may affect the acceptance of this application and/or the continued provision of training and assessment services.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-7']) && in_array($ef['part_b-7'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have read and understood CEA’s fee information and course cancellation terms.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-8']) && in_array($ef['part_b-8'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I acknowledge that all fees are payable in full on course commencement.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-9']) && in_array($ef['part_b-9'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I understand it is a requirement of the program that I complete and return a Training and Employment Survey within three months of finishing the training and assessment.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_b-10']) && in_array($ef['part_b-10'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> All this information is available on the Community Education Australia Website.</label></div>
											</td>
										</tr>

									</table>
								</td>
							</tr>
						</table>
						<div class="clearfix" style="height: 10px;"></div>
						<h3 class="no-margin px-12-font proximanova-bold text-center">PART C</h3>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_c-0']) && in_array($ef['part_c-0'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I declare the information provided in this enrolment application by me and/or in relation to me and that all documents I have provided to meet the requirements of the course as of the date of signing this form are true and correct.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_c-1']) && in_array($ef['part_c-1'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I confirm that I meet the eligibility requirements and I understand that I can only access the Certificate 3 Guarantee subsidy once, and I wish to enroll in the above course. I will follow all the study instructions and Rules and Regulations as outlined on this page as well as all policies in the student handbook. I release and hold harmless CEA, its CEO, staff and agents in respect of any property loss or personal injury that I may sustain whilst participating in my course. </label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_c-2']) && in_array($ef['part_c-2'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I declare that the work and answers given in the Language, Literacy & Numeracy task was completed by me and is my own work.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_c-3']) && in_array($ef['part_c-3'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I understand that I am only entitled to concessional student Contribution Fees when a Commonwealth Government agency or Employment Service Provider is not funding my Co-contribution Fee.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_c-4']) && in_array($ef['part_c-4'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> understand that, I need to provide Signed Statutory Declaration if required by Community Education Australia.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['part_c-5']) && in_array($ef['part_c-5'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I confirm that I have read Certificate 3 Guarantee Student fact sheet (For Certificate III Level Courses) <a href="https://training.qld.gov.au/site/providers/Documents/funded/certificate3/c3g-factsheet-student.pdf" class="primary-font-color">https://training.qld.gov.au/site/providers/Documents/funded/certificate3/c3g-factsheet-student.pdf</a></label></div>
											</td>
										</tr>

									</table>

									<table width="100%" class="form-table">
										<tr>
											<td width="100%" valign="top" colspan="2">
												I, <div class="textbox" style="display: inline-block; width: 280px;">{{implode(' ', $fullname)}}</div> , in seeking to enrol in <div class="textbox" style="display: inline-block; width: 300px;">{{isset($ef['course']['name']) ? $ef['course']['name'] : ''}}</div>
											</td>
										</tr>
									</table>

									<div class="clearfix" style="height: 10px;"></div>

									<p class="px-12-font">declare and agree to the following to be true and accurate statements: </p>
									<ol class="px-10-font" style="padding-left: 15px;">
										<li>I will follow all the study instructions and Rules and Regulations as outlined on this page as well as all policies in the student handbook that I have received & I also have access to the handbook online.</li>
										<li>I release and hold harmless CEA, its CEO, staff and agents in respect of any property loss or personal injury that I may sustain while participating in my course.</li>
										<li>I declare that the work and answers given in the Language, literacy & numeracy test is completed by me and is my</li>
										<li>own work.</li>
										<li>I declare that I was NOT offered any incentive or gift to sign up for the course.</li>
										<li>I declare that I am enrolled with CEA and there are no third party arrangements.</li>
										<li>I understand that, I need to provide Signed Statutory Declaration if required by Community Education Australia.</li>
										<li>All fees related information has been provided to me and I understand and agree to it.</li>
										<li> I give consent to CEA to apply for the USI on my behalf and may use the USI to access my electronic VET record to assist in assessing pre-requisites and credit transfers.</li>
										<li>I confirm that I have read and understand the information applicable to my course related to funding.</li>
										<li>I declare that the information provided in the form is true and accurate. </li>
										<li>Under the Agreement, I agree to:
											<ol type="a" style="padding-left: 15px;">
												<li>Attend the orientation, induction, Pre-training review and LLN test as part of the enrolment process at CEA on date advised by CEA before the commencement of training and assessment;</li>
												<li>Commence the course on the day as indicated in the training plan.</li>
												<li>Provide the CEA with my current address, telephone number(s), and email address within 7 days of enrolment at the CEA;</li>
												<li>Notify the CEA in writing of any changes to my address, telephone number(s) and email address, (including when on industry placement, (if applicable) regardless of location), within 7 days of changing address; </li>
												<li>Attend full-time or part-time studies including all scheduled classes, course-related information sessions, supervised study sessions and assessment sessions as identified on my timetable or through other communication methods used by CEA staff; </li>
												<li>Attend classes in or other work placements as required by the course:</li>
												<li>Provide original medical certificates if unable to attend classes or rostered shifts because of illness;</li>
												<li>Seek assistance from trainers and CEA staff as soon as I experience difficulties with any aspect of my course;</li>
												<li>Seek assistance from CEA delegate should I experience difficulties of a personal nature or difficulties with budgeting or time management;</li>
												<li>Pay enrolment fees to the CEA by dates stipulated in the invoices sent to me at my address registered with the CEA;</li>
												<li>Accept all conditions of the college Refund Policy for students;</li>
												<li>Abide by the rules and regulations of the CEA.</li>
											</ol>
										</li>
									</ol>
								</td>
							</tr>
						</table>
						<table width="100%" class="form-table">
							<tr>
								<td width="70%" valign="top">
									<label class="label label-textbox">Applicant’s Signature</label>
									<div class="textbox"><p class="type-signature">{{isset($ep->type_signature) ? $ep->type_signature : ''}}<p></div>
								</td>
								<td width="30%" valign="top">
									<label class="label label-textbox">Date</label>
									<div class="textbox">{{isset($ep->created_at) ? \Carbon\Carbon::parse($ep->created_at)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 7 of 8 -->

<!-- Page 8 of 8 -->

<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="eti-logo">
									<img src="{{public_path()}}/cea-enrolment-form-funding/images/cea-logo.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p>
								<p class="secondary-font-color px-16-font text-right line-height-1point2">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">

						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="text-center primary-bg-color" style="padding: 5px 0;">
									<h3 class="no-margin px-14-font proximanova-bold line-height-1">FOR OFFICE USE ONLY</h3>
								</td>
							</tr>
						</table>
						<p class="px-12-font">Please consider the qualification, the job role, and required level of language, literacy and numeracy that the vocation and industry requires. </p>
						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="form-table">
							<tr>
								<td width="30%" valign="top">
									<label class="label label-textbox">Additional Language, Literacy, and Numeracy assistance required to achieve workplace competency?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="20%" class="form-table">
										<tr>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="30%" valign="top">
									<label class="label label-textbox">Review deems proposed assessment instruments, learning material and strategies as appropriate.</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="20%" class="form-table">
										<tr>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="30%" valign="top">
									<label class="label label-textbox">Review deems proposed assessment instruments, learning material and strategies require adjustment. Additional language, literacy or numeracy support will be required.</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="20%" class="form-table">
										<tr>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="30%" valign="top">
									<label class="label label-textbox">What is applicant’s capacity to benefit?</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="20%" class="form-table">
										<tr>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="30%" valign="top">
									<label class="label label-textbox">Review identified current competence (list below) (if Mutual Recognition, attach Record of Results)</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="20%" class="form-table">
										<tr>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="30%" valign="top">
									<label class="label label-textbox">Based on the information provided in the Pre-training review I believe the course selected is suitable for the learner.</label>
									<div class="clearfix" style="height: 5px;"></div>
									<table width="20%" class="form-table">
										<tr>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> Yes</label></div>
											</td>
											<td width="50%">
												<div class="checkbox"><label class="label label-checkbox black-font-color"> No</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox"><label class="label label-checkbox black-font-color px-10-font"> I have assessed this applicant;</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox"><label class="label label-checkbox black-font-color px-10-font"> I find that the applicant is competent in language, literacy and numeracy.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox"><label class="label label-checkbox black-font-color px-10-font"> I find that the applicant is not competent in language, literacy and numeracy.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<label class="label label-textbox">Comments if any:</label>
												<div class="textbox long"></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<div class="clearfix" style="height: 10px;"></div>

						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="primary-bg-color" style="padding: 2px 5px;">
									<h3 class="no-margin px-14-font proximanova-bold line-height-1">Document Checklist</h3>
								</td>
							</tr>
						</table>
						<ul class="px-10-font" style="padding-left: 15px;">
							<li>Proof of Australian citizenship/residency status or New Zealand citizenship</li>
							<li>Photo identification</li>
							<li>Proof of residential address</li>
							<li>Proof of age, if no Australian Driving License</li>
							<li>Enrolment Application Form filled and signed</li>
						</ul>

						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="primary-bg-color" style="padding: 2px 5px;">
									<h3 class="no-margin px-14-font proximanova-bold line-height-1">For CEA Official</h3>
								</td>
							</tr>
						</table>
						<p class="text-justify px-12-font">I confirm that the applicant has been informed of entry requirements for the course and eligibility requirements for government subsidised training under the VET Investment Plan or other subsidised training under the Queensland Government and that the applicant is aware of the consequences arising from a false, misleading or an in complete declaration.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<table width="100%" class="form-table">
							<tr>
								<td width="50%" valign="top">
									<label class="label label-textbox">Date Received:</label>
									<div class="textbox"></div>
								</td>
								<td width="50%" valign="top">
									<label class="label label-textbox">Date Approved:</label>
									<div class="textbox"></div>
								</td>
							</tr>
							<tr>
								<td width="50%" valign="top">
									<label class="label label-textbox">Approved by:</label>
									<div class="textbox"></div>
								</td>
								<td width="50%" valign="top">
									<label class="label label-textbox">Signature:</label>
									<div class="textbox"></div>
								</td>
							</tr>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">McEvoy & Doust Pty Ltd trading as Community Education Australia | RTO No. 6074| V3.0</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 8 of 8 -->

</html>