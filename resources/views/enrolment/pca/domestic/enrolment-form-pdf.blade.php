<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" href="{{public_path()}}/custom/pca-enrolment/pdf-style.css" rel="stylesheet" />
	<title>Enrolment Form</title>
	<style type="text/css">
		.ml-seventy{margin-left:70px!important;}
		.yowo{margin-left:70px;}
	</style>
</head>
<!-- Page 1 of 9 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 180px;">
						<!-- #1 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">1</span>
						<span class="proximanova-bold" style="transform: rotate(-90deg); position: absolute; top: 75px; left: 0; line-height: 14px;">COURSE INFORMATION</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="31%" valign="top">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;">Tick the course you <br> Going to apply for <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="top" style="padding-left: 10px;">
										@if(isset($ef['course']))
											<div class="checkbox checked"" style="margin-bottom: 0;">
												<label class="label label-checkbox black-font-color" style="font-family:'ProximaNova-Bold'!important;"> {{ $ef['course']['name']}}</label>
												<br>
												@if($matrix != null)
													<label class="px-12-font" style="line-height: 12px; margin-left: 69px;"> (CRICOS Course Code: {{ $matrix->cricos_code }}, Duration: {{ $matrix->wk_duration }})</label>
												@endif
												<div class="clearfix" style="height: 30px;"></div>
												<p class="proximanova-bold px-12-font m-0">Course Description:</p>
												<a href="https://training.gov.au/Training/Details/{{ $ef['course']['code'] }}" class="px-12-font">https://training.gov.au/Training/Details/{{ $ef['course']['code'] }}</a>
											</div>
										@endif
								</td>
							</tr>
						</table>
						<!-- END #1 -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 70px;">
						<!-- #2 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">2</span>
						<span class="proximanova-bold" style="transform: rotate(-90deg); position: absolute; top: 20px; left: 52px; line-height: 14px;">INTAKE</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;">Choose the <br> preferred month for <br> course <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<p class="px-12-font display-inlineblock proximanova-bold">Preferred Month to start</p>
									<div class="textbox display-inlineblock" style="width: 262px; margin-top: 3px; margin-bottom: 0; margin-left: 10px;">{{isset($ef['preferred_month_start']) ? $ef['preferred_month_start'] : ''}}</div>
								</td>
							</tr>
						</table>
						<!-- END #2 -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 180px;">
						<!-- #3 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">3</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 30px; left: 45px; line-height: 14px;">PERSONAL<br>DETAILS</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Title <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<table width="75%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
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
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Family Name <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['lastname']) ? $ef['lastname'] : ''}}</div>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Given Name <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['firstname']) ? $ef['firstname'] : ''}}</div>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Gender <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<table width="90%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
										<tr>
											<td width="20%">
												<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Male' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Male</label></div>
											</td>
											<td width="20%">
												<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Female' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Female</label></div>
											</td>
											<td width="20%">
												<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == 'Other' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other</label></div>
											</td>
											<td width="40%">
												<div class="checkbox {{isset($ef['gender']) && $ef['gender'] == '@' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Don’t want to disclose </label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Date of Birth<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">
												@php
													$dob = '';
													if(isset($ef['date_of_birth']['value'])){
														$dob = \Carbon\Carbon::parse($ef['date_of_birth']['value'])->timezone('Australia/Melbourne')->format('d / m / Y');
													}elseif(isset($ef['date_of_birth'])){
														$dob = \Carbon\Carbon::parse($ef['date_of_birth'])->timezone('Australia/Melbourne')->format('d / m / Y');
													}
												@endphp
												<span>{{$dob}}</span>
									
									<!-- {{isset($ef['date_of_birth']['value']) ? \Carbon\Carbon::parse($ef['date_of_birth']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}} -->
									</div>
								</td>
							</tr>
						</table>
						<!-- END #3 -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 250px;">
						<!-- #4 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">4</span>
						<span class="proximanova-bold text-center" style="transform: rotate(-90deg); position: absolute; top: 90px; left: 25px; line-height: 14px;">Australia <br> (Contact Details)</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Residential Add.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
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
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{implode(' ', $addr)}}</div>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> State<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 150px; margin-top: 5px; margin-bottom: 5px;">{{$ef['addr_location'] ? $ef['addr_location'] : null}}</div>
											</td>
											<td width="15%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Post Code<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="45%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 146px; margin-top: 5px; margin-bottom: 5px;">{{$ef['addr_postcode'] ? $ef['addr_postcode'] : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Postal Address <br> <span class="px-12-font">(if different from above)</span><img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['addr_postal_delivery_box']) ? $ef['addr_postal_delivery_box'] : null}}</div>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> State<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 150px; margin-top: 5px; margin-bottom: 5px;"></div>
											</td>
											<td width="24%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Post Code<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="36%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 146px; margin-top: 5px; margin-bottom: 5px;"></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Telephone<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 150px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['phone_home']) ? $ef['phone_home'] : null}}</div>
											</td>
											<td width="15%" valign="middle">
												@if(isset($ef['phone_home']) && $ef['phone_home'] != null)
													<p class="px-14-font proximanova-bold text-right " style="line-height: 14px;">Mobile<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@else
													<p class="px-14-font proximanova-bold text-right ml-seventy" style="line-height: 14px;width: 70px">Mobile<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@endif
												<!-- <p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Mobile<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p> -->
											</td>
											<td width="45%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 145px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['phone_mobile']) ? $ef['phone_mobile'] : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Email<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['email']) ? $ef['email'] : null}}</div>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Alternative Email <br> <span class="px-12-font">(Optional)</span><img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['email_at']) ? $ef['email_at'] : null}}</div>
								</td>
							</tr>
						</table>
						<!-- END #4 -->
					</div>
					<div class="clearfix"></div>
					<div class="content" style="position: relative; width: 100%; height: 250px;">
						<!-- #4 -->
						<span class="proximanova-bold text-center" style="transform: rotate(-90deg); position: absolute; top: 90px; left: 25px; line-height: 14px;">Home Country <br> (Contact Details)</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
						@php
												$addr_hc = [];
												$post_geo = isset($ef['home_country_addr_suburb']['value']) ? explode(' - ', $ef['home_country_addr_suburb']['value']) : null;
												if(isset($ef['home_country_addr_flat_unit_detail']) && !in_array($ef['home_country_addr_flat_unit_detail'], [null, ''])){
													$addr_hc[] = $ef['home_country_addr_flat_unit_detail'];
												}
												if(isset($ef['home_country_addr_building_property_name']) && !in_array($ef['home_country_addr_building_property_name'], [null, ''])){
													$addr_hc[] = $ef['home_country_addr_building_property_name'];
												}
												if(isset($ef['home_country_addr_street_num']) && !in_array($ef['home_country_addr_street_num'], [null, ''])){
													$addr_hc[] = $ef['home_country_addr_street_num'];
												}
												if(isset($ef['home_country_addre_street_name']) && !in_array($ef['home_country_addre_street_name'], [null, ''])){
													$addr_hc[] = $ef['home_country_addre_street_name'];
												}
												if(isset($ef['home_country_addr_suburb_state']) && !in_array($ef['home_country_addr_suburb_state'], [null, ''])){
													$addr_hc[] = $ef['home_country_addr_suburb_state'];
												}
											@endphp
											
							<tr>
								<td width="31%" valign="middle">
									{{-- @if(count($addr_hc) > 0)
										<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;">Residential Add.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
									@else
										<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;margin-left:-80px!important;">Residential Add.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
									@endif	 --}}		
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Residential Add.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<!-- <div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{implode(' ', $addr_hc)}}</div> -->
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">
										@if(isset($ef['home_country_res_addr']) && $ef['home_country_res_addr'] != null)
											{{ $ef['home_country_res_addr'] }}
										@else
										    {{implode(' ', $addr_hc)}}
										@endif
									</div>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> State<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 150px; margin-top: 5px; margin-bottom: 5px;">
												@if(isset($ef['home_country_state']))
													{{$ef['home_country_state'] ? $ef['home_country_state'] : null}}
												@endif
												@if(isset($ef['home_country_addr_location']))
													{{$ef['home_country_addr_location'] ? $ef['home_country_addr_location'] : null}}
												@endif
												</div>
											</td> 
											<td width="15%" valign="middle">
												@if(isset($ef['home_country_state']) && $ef['home_country_state'] != null)
													<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Post Code<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@else
													<!-- add margin left if previous column is empty "ml-seventy" -->
													<p class="px-14-font proximanova-bold text-right ml-seventy" style="line-height: 14px;width:70px;"> Post Code<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@endif

												<!-- <p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Post Code<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p> -->
											</td>
											<td width="45%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 146px; margin-top: 5px; margin-bottom: 5px;">
												@if(isset($ef['home_country_postcode']))
													{{ $ef['home_country_postcode'] ? $ef['home_country_postcode'] : null }}
												@endif
												@if(isset($ef['home_country_addr_postcode']))
													{{ $ef['home_country_addr_postcode'] ? $ef['home_country_addr_postcode'] : null }}
												@endif
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Postal Address <br> <span class="px-12-font">(if different from above)</span><img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['home_country_addr_postal_delivery_box']) ? $ef['home_country_addr_postal_delivery_box'] : null}}</div>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> State<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 150px; margin-top: 5px; margin-bottom: 5px;"></div>
											</td>
											<td width="24%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Post Code<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="36%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 146px; margin-top: 5px; margin-bottom: 5px;"></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Telephone<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 150px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['home_country_phone_home']) ? $ef['home_country_phone_home'] : null}}</div>
											</td>
											<td width="15%" valign="middle">
												@if(isset($ef['home_country_phone_home']) && $ef['home_country_phone_home'] != null)
													<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;">Mobile<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@else
													<p class="px-14-font proximanova-bold text-right ml-seventy" style="line-height: 14px;width: 70px">Mobile<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@endif
												<!-- <p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Mobile<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p> -->
											</td>
											<td width="45%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 145px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['home_country_phone_mobile']) ? $ef['home_country_phone_mobile'] : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Email<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['home_country_email']) ? $ef['home_country_email'] : null}}</div>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Alternative Email <br> <span class="px-12-font">(Optional)</span><img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['home_country_email_at']) ? $ef['home_country_email_at'] : null}}</div>
								</td>
							</tr>
						</table>
						<!-- END #4 -->
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 1 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 1 of 9 -->

<!-- Page 2 of 9 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 100px;">
						<!-- #5 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">5</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 20px; left: 45px; line-height: 14px;">EMERGENCY<br>CONTACT<br>DETAILS</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Name<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="30%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 180px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['e_contact_name']) ? $ef['e_contact_name'] : null}}</div>
											</td>
											<td width="14%" valign="middle">
												@if(isset($ef['e_contact_name']))
													<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Email<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@else
													<!-- add margin left if previous column is empty "ml-seventy" -->
													<p class="px-14-font proximanova-bold text-right ml-seventy" style="line-height: 14px;"> Email<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@endif
												<!-- <p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Email<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p> -->
											</td>
											<td width="36%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 124px; margin-top: 5px; margin-bottom: 5px;"></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="31%" valign="middle">
									<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Address <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
								</td>
								<td width="60%" valign="middle" style="padding-left: 10px;">
									<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['e_address']) ? $ef['e_address'] : null}}</div>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Telephone<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 135px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['e_telephone']) ? $ef['e_telephone'] : null}}</div>
											</td>
											<td width="18%" valign="middle">
												@if(isset($ef['e_telephone']))
													<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Relationship<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@else
													<!-- add margin left if previous column is empty "ml-seventy" -->
													<p class="px-14-font proximanova-bold text-right ml-seventy" style="line-height: 14px;"> Relationship<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@endif
												<!-- <p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Relationship<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p> -->
											</td>
											<td width="42%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 146px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['e_relationship']) ? $ef['e_relationship'] : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>	
						</table>
						<!-- END #5 -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 210px;">
						<!-- #6 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">6</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 60px; left: 18px; line-height: 14px;">RESIDENCY & VISA<br>INFORMATION</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Nationality<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 135px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['nationality']) ? $ef['nationality'] : null}}</div>
											</td>
											<td width="18%" valign="middle">
												@if(isset($ef['nationality']) && $ef['nationality'] != null)
													<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;">Passport No.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@else
													<!-- add margin left if previous column is empty "ml-seventy" -->
													<p class="px-14-font proximanova-bold text-right ml-seventy" style="line-height: 14px;">Passport No.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@endif
												<!-- <p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Passport No.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p> -->
											</td>
											<td width="42%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 146px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['passport_no']) ? $ef['passport_no'] : null}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
												@php
													
													$pi_date = '';
													if(isset($ef['passport_issued_date']['value'])){
														$pi_date = \Carbon\Carbon::parse($ef['passport_issued_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y');
													}elseif(isset($ef['passport_issued_date'])){
														$pi_date = \Carbon\Carbon::parse($ef['passport_issued_date'])->timezone('Australia/Melbourne')->format('d / m / Y');
														
													}

													$pe_date = '';
													if(isset($ef['passport_expiry_date']['value'])){
														$pe_date = \Carbon\Carbon::parse($ef['passport_expiry_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y');
													}elseif(isset($ef['passport_expiry_date'])){
														$pe_date = \Carbon\Carbon::parse($ef['passport_expiry_date'])->timezone('Australia/Melbourne')->format('d / m / Y');
													}
												@endphp
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Issue Date<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 135px; margin-top: 5px; margin-bottom: 5px;">
												
												<!-- {{isset($ef['passport_issued_date']['value']) ? \Carbon\Carbon::parse($ef['passport_issued_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}} -->
												<span>{{$pi_date}}</span>
												</div>
											</td>
											<td width="18%" valign="middle">
												@if($pi_date != '')
													<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Expiry Date<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@else
													<!-- add margin left if previous column is empty "ml-seventy" -->
													<p class="px-14-font proximanova-bold text-right ml-seventy" style="line-height: 14px;"> Expiry Date<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@endif
												<!-- <p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Expiry Date<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p> -->
											</td>
											<td width="42%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 143px; margin-top: 5px; margin-bottom: 5px;">
												<!-- {{isset($ef['passport_expiry_date']['value']) ? \Carbon\Carbon::parse($ef['passport_expiry_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}} -->
												<span>{{$pe_date}}</span>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Visa type <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"><br><span class="px-10-font">If not Australian Citizen</span></p>
											</td>
											<td width="80%" valign="middle" style="padding-left: 10px;">
                                            @php
                                                $visa = isset($ef['visa_type']['value']) ? explode( ' (subclass ',$ef['visa_type']['value']) : null;
                                            @endphp
												<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px; margin-bottom: 5px;">
                                                @if (isset($visa[0]) && strlen($visa[0]) > 25)
                                                    <p style="font-size:12px">{{isset($visa[0]) ? $visa[0] : null}}</p>
                                                @else
                                                    <p>{{isset($visa[0]) ? $visa[0] : null}}</p>
                                                @endif
                                                </div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Sub Class<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 135px; margin-top: 5px; margin-bottom: 5px;">{{isset($visa[1]) ? str_replace(")","",$visa[1]) : null}}</div>
											</td>
											<td width="18%" valign="middle">
												@if(isset($visa[1]))
													<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Expiry Date<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@else
													<!-- add margin left if previous column is empty "ml-seventy" -->
													<p class="px-14-font proximanova-bold text-right ml-seventy" style="line-height: 14px;"> Expiry Date<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												@endif
												<!-- <p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Expiry Date<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p> -->
											</td>
											<td width="42%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 145px; margin-top: 5px; margin-bottom: 5px;">
												@php
													$ve_date = '';
													if(isset($ef['visa_expiry_date']['value'])){
														$ve_date = \Carbon\Carbon::parse($ef['visa_expiry_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y');
													}elseif(isset($ef['visa_expiry_date'])){
														$ve_date = \Carbon\Carbon::parse($ef['visa_expiry_date'])->timezone('Australia/Melbourne')->format('d / m / Y');
													}
												@endphp
												<!-- {{isset($ef['visa_expiry_date']['value']) ? \Carbon\Carbon::parse($ef['visa_expiry_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}} -->
												<span>{{$ve_date}}</span>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="64%" valign="middle" colspan="3">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Study Rights <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"><br><span class="px-10-font">in Australia</span></p>
											</td>
											<td width="36%" valign="middle" style="padding-left: 10px;">
											<table width="80%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_rights']) && in_array($ef['study_rights'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_rights']) && !in_array($ef['study_rights'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="64%" valign="middle" colspan="3">
												<p class="px-14-font proximanova-bold" style="line-height: 14px; margin-left: 80px; margin-top:3px;"> Applied for Australian Permanent Residency <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"><br><span class="px-10-font">Please provide copies of the documents.</span></p>
											</td>
											<td width="36%" valign="middle" style="padding-left: 10px;">
												<table width="80%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-bottom: 5px;">
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['au_permanent_residency']) && in_array($ef['au_permanent_residency'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['au_permanent_residency']) && !in_array($ef['au_permanent_residency'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #6 -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 100px;">
						<!-- #7 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">7</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 25px; left: 30px;">SCHOOLING</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Still in School<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="middle" style="padding-left: 10px;">
												<table width="30%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['at_school']) && in_array($ef['at_school'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['at_school']) && !in_array($ef['at_school'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Highest School Level completed<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 407px; margin-top: 5px;">{{isset($ef['highest_school_level_completed_id']['description']) ? $ef['highest_school_level_completed_id']['description'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Year Completed<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="17%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 72px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['year_completed']) ? $ef['year_completed'] : ''}}</div>
											</td>
											<td width="14%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Institute<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="49%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 225px; margin-top: 5px; margin-bottom: 5px;">
												@if (isset($ef['institute']) && strlen($ef['institute']) > 25)
													<p style="font-size:12px">{{isset($ef['institute']) ? $ef['institute'] : ''}}</p>
												@else
													<p>{{isset($ef['institute']) ? $ef['institute'] : ''}}</p>
												@endif
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #7 -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 290px;">
						<!-- #8 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">8</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 80px; left: -10px; line-height: 14px;">PREVIOUS<br>QUALIFICATIONS ACHIEVED</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Post-Secondary<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="17%" valign="middle" style="padding-left: 10px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['post_secondary']) && in_array($ef['post_secondary'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['post_secondary']) && !in_array($ef['post_secondary'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
														</td>
													</tr>
												</table>
											</td>
											<td width="40%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Highest Qualification completed<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="23%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 72px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['post_highest_qualification_completed_id']) ? $ef['post_highest_qualification_completed_id'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Year Completed<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="17%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 72px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['post_year_completed']) ? $ef['post_year_completed'] : ''}}</div>
											</td>
											<td width="14%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Institute<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="49%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 225px; margin-top: 5px; margin-bottom: 5px;">
												@if (isset($ef['post_institute']) && strlen($ef['post_institute']) > 25)
													<p style="font-size:12px">{{isset($ef['post_institute']) ? $ef['post_institute'] : ''}}</p>
												@else
													<p>{{isset($ef['post_institute']) ? $ef['post_institute'] : ''}}</p>
												@endif
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
									@php
										$pea = [];
										if(isset($ef['prior_educational_achievement_ids'])){
											foreach ($ef['prior_educational_achievement_ids'] as $k => $v){
												$pea[$v['value']] = explode(' - ', $v['description'])[0];
											}
										}
									@endphp
										<tr>
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Equivalent<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;" colspan="3">
												<div style="width: 420px;">
													<p class="px-12-font" style="line-height: 12px;"><span class="proximanova-bold">A</span> - Australian, <span class="proximanova-bold">E</span> - Australian Equivalent or <span class="proximanova-bold">I</span> - International</p>
													<p class="px-12-font text-justify" style="line-height: 12px;">(Note : In case you have multiple Prior Education Achievement Recognition Identifiers of any qualification, use the following priority order number to determine which identifier to use:<span class="proximanova-bold">1:A</span> - Australia, <span class="proximanova-bold">2:E</span> - Australian Equivalent, <span class="proximanova-bold">3:I</span> - International</p>
												</div>
												<div class="clearfix" style="height:5px;"></div>
												<table class="table-bordered" width="91%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td width="50%" style="padding: 0;">
															<table width="100%" class="" cellpadding="0" cellspacing="0" border="0">
																<thead>
																	<tr>
																		<th width="7%" class="text-center">A</th>
																		<th width="7%" class="text-center">E</th>
																		<th width="7%" class="text-center">I</th>
																		<th width="79%" class="right-border"></th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['524']) && $pea['524'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="79%" class="right-border" style="height: 25px; padding-left: 5px;">
																			<p class="px-10-font proximanova-bold" style="line-height: 10px;">Certificate I</p>
																		</td>
																	</tr>
																	<tr>
																	<td width="7%">
																			<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['521']) && $pea['521'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="79%" class="right-border" style="height: 25px; padding-left: 5px;">
																			<p class="px-10-font proximanova-bold" style="line-height: 10px;">Certificate II</p>
																		</td>
																	</tr>
																	<tr>
																	<td width="7%">
																			<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['514']) && $pea['514'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="79%" class="right-border" style="height: 25px; padding-left: 5px;">
																			<p class="px-10-font proximanova-bold" style="line-height: 10px;">Certificate III or Trade Certificate</p>
																		</td>
																	</tr>
																	<tr>
																	<td width="7%">
																			<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['511']) && $pea['511'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="79%" class="right-border" style="height: 25px; padding-left: 5px;">
																			<p class="px-10-font proximanova-bold" style="line-height: 10px;">Certificate IV or Advanced
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
																		<td width="7%">
																			<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['420']) && $pea['420'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="79%" style="height: 25px; padding-left: 5px;">
																			<p class="px-10-font proximanova-bold" style="line-height: 10px;">Diploma of Associate Diploma</p>
																		</td>
																	</tr>
																	<tr>
																	<td width="7%">
																			<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['410']) && $pea['410'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="79%" style="height: 25px; padding-left: 5px;">
																			<p class="px-10-font proximanova-bold" style="line-height: 10px;">Advanced Diploma of Associate Degree Level</p>
																		</td>
																	</tr>
																	<tr>
																	<td width="7%">
																			<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['008']) && $pea['008'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="79%" style="height: 25px; padding-left: 5px;">
																			<p class="px-10-font proximanova-bold" style="line-height: 10px;">Bachelor Degree or Higher Degree Level</p>
																		</td>
																	</tr>
																	<tr>
																	<td width="7%">
																			<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'A' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'E' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="7%">
																			<div class="checkbox {{isset($pea['000']) && $pea['000'] == 'I' ? 'checked' : ''}}" style="margin-bottom: 0; margin-left: 1.5px;"></div>
																		</td>
																		<td width="79%" style="height: 25px; padding-left: 5px;">
																			<p class="px-10-font proximanova-bold" style="line-height: 10px;">Certificates other than the above</p>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</table>
												<p class="px-10-font">Please provide certified documents for the courses that you took.</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #8 -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 200px;">
						<!-- #9 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: 0;">9</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 80px; left: -10px; line-height: 14px;">LANGUAGE AND CULTURAL<br>DIVERSITY</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 10px; margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Birth Country<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="40%" valign="middle" style="padding-left: 10px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
													<tr>
														<td width="40%">
															<div class="checkbox {{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] == '1101' ? 'checked' : ''}}" ><label class="label label-checkbox black-font-color"> Australia</label></div>
														</td>
														<td width="60%">
															<div class="checkbox {{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] != '1101' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other, please specify</label></div>
														</td>
													</tr>
												</table>
											</td>
											<td width="40%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 172px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['birth_country_id']['identifier']) && $ef['birth_country_id']['identifier'] != '1101' ?  $ef['birth_country_id']['full_name'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 10px; margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Spoken Language <br><span class="px-10-font">(at home)</span><img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="24%" valign="middle" style="padding-left: 5px;">
												<p class="px-13-font proximanova-bold" style="line-height: 14px;"> Other than English<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="30%" valign="middle">
												<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
													<tr>
														<td width="25%">
															<div class="checkbox {{isset($ef['spoken_language']) && $ef['spoken_language'] != true ?  'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
														</td>
														<td width="75%">
															<div class="checkbox {{isset($ef['spoken_language']) && $ef['spoken_language'] == true ?  'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes, please specify</label></div>
														</td>
													</tr>
												</table>
											</td>
											<td width="31%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 110px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['spoken_language_specify']) ? $ef['spoken_language_specify']['description'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 10px; margin-left: 125px;">
										<tr>
											<td width="22%" valign="middle">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> English Language<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="22%" valign="middle" style="padding-left: 5px;">
												<p class="px-13-font proximanova-bold" style="line-height: 14px;"> Spoken English?<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="56%" valign="middle" colspan="2">
												<table width="90%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
													<tr>
														<td width="30%">
															<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Very Well' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Very Well</label></div>
														</td>
														<td width="20%">
															<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Well' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Well</label></div>
														</td>
														<td width="25%">
															<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Not Well' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Not Well</label></div>
														</td>
														<td width="25%">
															<div class="checkbox {{isset($ef['english_language']) && $ef['english_language'] == 'Not at all' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Not at all</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 10px; margin-left: 125px;">
										<tr>
											<td width="25%" valign="middle">
												<p class="px-13-font proximanova-bold" style="line-height: 14px;"> Language Test, <span class="px-10-font">If taken</span><img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="75%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 380px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['language_test']) ? $ef['language_test']['name'] : ''}}</div>
											</td>
											<!-- <td width="10%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Score<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="20%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 50px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['language_test_score']) ? $ef['language_test_score'] : ''}}</div>
											</td> -->
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 10px; margin-left: 125px;">
										<tr>
											<td width="25%" valign="middle">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Score<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="75%" valign="middle" style="padding-left: 10px;">
												<div class="textbox display-inlineblock" style="width: 50px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['language_test_score']) ? $ef['language_test_score'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle">
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="middle">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Origin<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="middle">
												<table width="90%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-left: 10px;">
													<tr>
														<td width="25%">
															<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Aboriginal' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Aboriginal</label></div>
														</td>
														<td width="35%">
															<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Torres Strait Islander' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Torres Strait Islander</label></div>
														</td>
														<td width="15%">
															<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'Both' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Both</label></div>
														</td>
														<td width="25%">
															<div class="checkbox {{isset($ef['origin']) && $ef['origin'] == 'None' ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> None</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #9 -->
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 2 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 2 of 9 -->

<!-- Page 3 of 9 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 120px;">
						<!-- #10 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">10</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 35px; left: 35px; line-height: 14px;">DISABILITY</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Condition<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> Do you consider yourself to have a disability, impairment or long-term condition?<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												<table width="70%" cellpadding="0" cellspacing="0" border="0" style="margin-top: -20px; float: right;">
													<tr>
														<td width="15%">
															<div class="checkbox {{isset($ef['disability_flag']) && $ef['disability_flag'] == false ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> No</label></div>
														</td>
														<td width="85%">
															<div class="checkbox {{isset($ef['disability_flag']) && $ef['disability_flag'] == true ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Yes, please indicate the areas of condition:</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="20%" valign="top">
												<p class="px-8-font proximanova-bold text-right" style="line-height: 8px;">If you answered ‘Yes’, you can<br>contact PCA for further support<br>services available</p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px; padding-top: 15px;">
											@php
												$dis = [];
												if(isset($ef['disabilitiy_ids'])){
													foreach ($ef['disabilitiy_ids'] as $k => $v){
														$dis[$v['description']] = true;
													}
												}
											@endphp
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td width="40%">
															<div class="checkbox {{isset($dis['Hearing/Deaf']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Hearing/Deaf</label></div>
														</td>
														<td width="30%">
															<div class="checkbox {{isset($dis['Physical']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Physical</label></div>
														</td>
														<td width="30%">
															<div class="checkbox {{isset($dis['Intellectual']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Intellectual</label></div>
														</td>
													</tr>
													<tr>
														<td width="40%">
															<div class="checkbox {{isset($dis['Acquired Brain Impairment']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Acquired Brain Impairment</label></div>
														</td>
														<td width="30%">
															<div class="checkbox {{isset($dis['Mental Illness']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Mental Illness</label></div>
														</td>
														<td width="30%">
															<div class="checkbox {{isset($dis['Vision']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Vision </label></div>
														</td>
													</tr>
													<tr>
														<td width="40%">
															<div class="checkbox {{isset($dis['Medical Condition']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Medical Condition</label></div>
														</td>
														<td width="30%">
															<div class="checkbox {{isset($dis['Learning']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Learning</label></div>
														</td>
														<td width="30%">
															<div class="checkbox {{isset($dis['Other']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color"> Other</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #10 -->
					</div>

					<div class="content" style="position: relative; width: 100%; height: 250px;">
						<!-- #11 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">11</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 40px; left: 25px; line-height: 14px;">EMPLOYMENT</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
								@php
									$labor = [];
									if(isset($ef['labour_force_status_id']['value'])){
										$labor[$ef['labour_force_status_id']['value']] = true;
									}
									// foreach ($ef['labour_force_status_id'] as $k => $v){
									// 	$labor[$v['value']] = true;
									// }
								@endphp
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px; margin-bottom: 15px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Employment<br>Status<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> In following categories, which BEST describes your current employment status?<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
										</tr>
										<tr>
											<td width="20%" valign="top"></td>
											<td width="80%" valign="top" style="padding-left: 10px; padding-top: 15px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($labor['01']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Full-time employee</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($labor['02']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Part-time employee</label></div>
														</td>
													</tr>
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($labor['04']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Self-employed - Employing others</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($labor['03']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Self-employed - Not employing others</label></div>
														</td>
													</tr>
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($labor['05']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Employed - Unpaid worker</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($labor['06']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Unemployed - Seeking Full-time work</label></div>
														</td>
													</tr>
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($labor['08']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Not employed - Not seeking work</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($labor['07']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Unemployed - Seeking Part-time work</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
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
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px; margin-top: -15px;"> If currently<br>employed, or<br>recently been<br>employed<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> Choose the classification of occupation that best describe your occupation (choose one only) <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
										</tr>
										<tr>
											<td width="20%" valign="top"></td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td width="30%">
															<div class="checkbox {{isset($if_employed['Manager']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> 1 - Manager</label></div>
														</td>
														<td width="70%">
															<div class="checkbox {{isset($if_employed['Community & Personal Service Worker']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> 4 - Community & Personal Service Worker</label></div>
														</td>
													</tr>
													<tr>
														<td width="30%">
															<div class="checkbox {{isset($if_employed['Professional']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> 2 - Professional</label></div>
														</td>
														<td width="70%">
															<div class="checkbox {{isset($if_employed['Early Childhood Educator']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> 5 - Early Childhood Educator</label></div>
														</td>
													</tr>
													<tr>
														<td width="30%">
															<div class="checkbox {{isset($if_employed['Chef']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> 3 - Chef</label></div>
														</td>
														<td width="70%">
															<div class="checkbox {{isset($if_employed['Other']) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> 6 - Other</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #11 -->
					</div>

					<div class="content" style="position: relative; width: 100%; height: 550px;">
						<!-- #12 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">12</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 45px; left: 25px; line-height: 14px;">STUDY REASON</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Main Reason<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> In following categories, which BEST describes your main reason for undertaking the course(s) with PCA?<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
										</tr>
										<tr>
											<td width="20%" valign="top"></td>
											<td width="80%" valign="top" style="padding-left: 10px; padding-top: 15px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '02'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> To develop my existing business </label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '04'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> To try for a different career</label></div>
														</td>
													</tr>
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '01'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> To get a job </label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '07'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Want extra skills for my job </label></div>
														</td>
													</tr>
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '05'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> To get better job or promotion</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '07'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Requirement of my job</label></div>
														</td>
													</tr>
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '08'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> To get into another course</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '12'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Personal interest & self-development</label></div>
														</td>
													</tr>
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '03'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> To start my own business</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['study_reason_id']['value']) && $ef['study_reason_id']['value'] == '11'  ? 'checked' : ''}}"><label class="label label-checkbox black-font-color" style="margin-left: 1px;"> Other reason (please state</label></div>
														</td>
													</tr>
													<tr>
														<td colspan="2">
															<div class="textbox display-inlineblock" style="width: 415px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['study_reason_other']) ? $ef['study_reason_other'] : ''}}</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							{{-- <tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px; padding-top: 10px;">
										<tr>
											<td width="20%" valign="top" rowspan="2">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Reason to study in<br>Australia<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"><br><span class="px-10-font" style="line-height: 10px;">Use extra sheets if<br>required</span></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> Why do you want to study your proposed course(s) in Australia and not in your home country? Please explain.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
										</tr>
										<tr>
											<td width="80%" valign="top" style="padding-left: 10px; padding-top: 5px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td>
															<div class="textbox display-inlineblock" style="height:300px; width: 415px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['reason_to_study_au']) ? $ef['reason_to_study_au'] : ''}}</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr> --}}
						</table>
						<!-- END #12 -->
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 3 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 3 of 9 -->

<!-- Page 4 of 9 -->
{{-- <body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 310px;">
						<!-- #12 Cont. -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">12</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 45px; left: 30px; line-height: 14px;">STUDY REASON <br>(Cont.)</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px; padding-top: 10px;">
										<tr>
											<td width="20%" valign="top" rowspan="2">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Reason to study<br>with PCA<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"><br><span class="px-10-font" style="line-height: 10px;">Use extra sheets if<br>required</span></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> Why would like to study with Phoenix College of Australia compared with other education providers in Australia? Please explain.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
										</tr>
										<tr>
											<td width="80%" valign="top" style="padding-left: 10px; padding-top: 5px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td>
															<div class="textbox display-inlineblock" style="height:230px; width: 415px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['reason_to_study_pca']) ? $ef['reason_to_study_pca'] : ''}}</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #12 Cont. -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 310px;">
						<!-- #12 Cont. -->
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px; padding-top: 10px;">
										<tr>
											<td width="20%" valign="top" rowspan="2">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Career benefit<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"><br><span class="px-10-font" style="line-height: 10px;">Use extra sheets if<br>required</span></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> How do you believe that course you are applying to study with Phoenix College of Australia will benefit your current or chosen career path? Please Explain.<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
										</tr>
										<tr>
											<td width="80%" valign="top" style="padding-left: 10px; padding-top: 5px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td>
															<div class="textbox display-inlineblock" style="height:230px; width: 415px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['reason_to_study_pca']) ? $ef['reason_to_study_pca'] : ''}}</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #12 Cont. -->
					</div>
					<div class="content" style="position: relative; width: 100%; height: 310px;">
						<!-- #12 Cont. -->
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px; padding-top: 10px;">
										<tr>
											<td width="20%" valign="top" rowspan="2">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Career Plan<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"><br><span class="px-10-font" style="line-height: 10px;">Use extra sheets if<br>required</span></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> What is your career plan after the end of your studies?<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
										</tr>
										<tr>
											<td width="80%" valign="top" style="padding-left: 10px; padding-top: 5px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td>
															<div class="textbox display-inlineblock" style="height:230px; width: 415px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['career_plan']) ? $ef['career_plan'] : ''}}</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #12 Cont. -->
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 4 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body> --}}
<!-- End Page 4 of 9 -->

<!-- Page 5 of 9 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 110px;">
						<!-- #13 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">13</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 30px; left: 35px; line-height: 14px;">RPL / CREDIT<br>TRANSFER</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Requirement<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-13-font proximanova-bold display-inlineblock" style="line-height: 14px;"> Are you seeking Recognition of Prior Learning or Credit Transfer? <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
												<table width="70%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-left: 10px; padding-bottom: 10px;">
													<tr>
														<td width="15%">
															<div class="checkbox {{isset($ef['rpl_ct_flag']) && !in_array($ef['rpl_ct_flag'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox"> No</label></div>
														</td>
														<td width="85%">
															<div class="checkbox {{isset($ef['rpl_ct_flag']) && in_array($ef['rpl_ct_flag'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox"> Yes</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="20%" valign="top">
											<td width="80%">
												<p class="px-14-font" style="line-height: 14px;">If ‘Yes’, then please contact Admissions Department for further details about the Recognition of Prior Learning (RPL) / Credit Transfer (CT) process.</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #13 -->
					</div>

					<div class="content" style="position: relative; width: 100%; height: 110px; ">
						<!-- #14 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">14</span>
						<span class="proximanova-bold text-center" style="transform: rotate(-90deg); position: absolute; top: 25px; left: 45px; line-height: 14px;">TRANSFER<br>LEARNING</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px; margin-bottom: 15px;">
										<tr>
											<td width="20%" valign="top" rowspan="2">
												<p class="px-12-font proximanova-bold text-right" style="line-height: 14px;"> Are you transferring<br>from another<br>education provider<br>in Australia? <img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<table width="70%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px; margin-left: 10px; padding-bottom: 10px;">
													<tr>
														<td width="15%">
															<div class="checkbox {{isset($ef['trasferring_learning']) && !in_array($ef['trasferring_learning'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox"> No</label></div>
														</td>
														<td width="85%">
															<div class="checkbox {{isset($ef['trasferring_learning']) && in_array($ef['trasferring_learning'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox"> Yes.</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font " style="line-height: 14px;"> <span class="proximanova-bold">Are you currently enrolled in an institute?</span> <span style="margin: 100px;">If <span class="proximanova-bold">‘Yes’</span>, then please provide the name of institute:</span></p>
												<table width="85%" cellpadding="0" cellspacing="0" border="0" style="margin-top: -30px; margin-left: 270px; padding-bottom: 10px;">
													<tr>
														<td width="50%">
															<div class="checkbox {{isset($ef['currently_enrolled_in_an_institute']) && !in_array($ef['currently_enrolled_in_an_institute'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox"> No</label></div>
														</td>
														<td width="50%">
															<div class="checkbox {{isset($ef['currently_enrolled_in_an_institute']) && in_array($ef['currently_enrolled_in_an_institute'], [1, true]) ? 'checked' : ''}}"><label class="label label-checkbox"> Yes.</label></div>
														</td>
													</tr>
												</table>
												<div class="textbox display-inlineblock" style="width: 415px; margin-top: 5px; margin-bottom: 5px;">{{isset($ef['currently_enrolled_in_an_institute_if_yes']) ? $ef['currently_enrolled_in_an_institute_if_yes'] : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #14 -->
					</div>

					<div class="content" style="position: relative; width: 100%; height: 140px;">
						<!-- #15 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">15</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 10px; left: 60px; line-height: 14px;">USI</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Unique Student<br>Identifier<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-14-font proximanova-bold display-inlineblock" style="line-height: 14px;"> Have you applied for Unique Student Identifier (USI) before?</p>
												<table width="70%" cellpadding="0" cellspacing="0" border="0" style=" margin-left: 10px;">
													<tr>
														<td width="15%">
															<div class="checkbox {{isset($ef['usi_flag']) && $ef['usi_flag'] == true ? 'checked' : ''}}"><label class="label label-checkbox"> Yes</label></div>
														</td>
														<td width="85%">
															<div class="checkbox {{isset($ef['usi_flag']) && $ef['usi_flag'] != true ? 'checked' : ''}}"><label class="label label-checkbox"> No</label></div>
														</td>
													</tr>
												</table>
												<p class="px-14-font display-inlineblock" style="line-height: 14px;">If <span class="proximanova-bold">‘Yes’</span>, please provide your USI</p>
												<div class="textbox display-inlineblock" style="width: 215px;">{{isset($ef['unique_student_id']) ? $ef['unique_student_id'] : ''}}</div>
												<div class="clearfix"></div>
												<p class="px-14-font text-justify" style="line-height: 14px;">If <span class="proximanova-bold">‘No’</span>,  you can visit <a href="https://www.usi.gov.au/">https://www.usi.gov.au/</a> to create USI. Once created, please provide the same to Admissions department. If you want PCA to create USI on your behalf, please contact one of our friendly team members at reception.</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #15 -->
					</div>
					
					<div class="content" style="position: relative; width: 100%; height: 220px;">
						<!-- #16 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">16</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 60px; left: 15px; line-height: 14px;">DOCUMENTATION</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Required<br>Documents<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-12-font text-justify" style="line-height: 14px;">Please provide the following documentation along with this Enrolment Application Form, so that your enrolment be processed in accordance with the application requirements. Where a document is not in English, you have to provide a certified translation along with the copy of original document.</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px; padding-top: 15px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Documents<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td width="100%">
															<div class="checkbox {{isset($ef['document_list-0']) && in_array($ef['document_list-0'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox"> <span class="proximanova-bold">Passport biodata pages</span></label></div>
														</td>
													</tr>
													<tr>
														<td width="100%">
															<div class="checkbox {{isset($ef['document_list-1']) && in_array($ef['document_list-1'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox"> <span class="proximanova-bold">Visa / Visa Notification</span></label></div>
														</td>
													</tr>
													<tr>
														<td width="100%">
															<div class="checkbox {{isset($ef['document_list-2']) && in_array($ef['document_list-2'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox"> <span class="proximanova-bold">Passport(s) of dependant(s), if any</span></label></div>
														</td>
													</tr>
													<tr>
														<td width="100%">
															<div class="checkbox {{isset($ef['document_list-3']) && in_array($ef['document_list-3'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox"> <span class="proximanova-bold">Past qualification documents</span>, including high school and other certificates</label></div>
														</td>
													</tr>
													<tr>
														<td width="100%">
															<div class="checkbox {{isset($ef['document_list-4']) && in_array($ef['document_list-4'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox"> <span class="proximanova-bold">English language proficiency</span> (IELTS, PTE, TOEFL etc.)</label></div>
														</td>
													</tr>
													<tr>
														<td width="100%">
															<div class="checkbox {{isset($ef['document_list-5']) && in_array($ef['document_list-5'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox"> <span class="proximanova-bold">Any other COE</span>, if transferring from other provider</label></div>
														</td>
													</tr>
													{{-- <tr>
														<td width="100%">
															<div class="checkbox {{isset($ef['document_list-6']) && in_array($ef['document_list-6'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox"> <span class="proximanova-bold">Statement addressing Genuine Temporary Entrant Criteria</span> (not required in cases of Security courses and if student is onshore)</label></div>
														</td>
													</tr> --}}
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #16 -->
					</div>

					<div class="content" style="position: relative; width: 100%; height: 140px;">
						<!-- #17 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">17</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 40px; left: 30px; line-height: 14px;">FEE PAYMENT</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Payment<br>Method<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 10px; padding-bottom: 15px;">
													<tr>
														<td width="20%">
															<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Cash' ? 'checked' : ''}}"><label class="label label-checkbox proximanova-bold" style="margin-left: 1.5px;"> Cash</label></div>
														</td>
														<td width="60%">
															<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Direct Deposit in PCA’s Bank Account' ? 'checked' : ''}}"><label class="label label-checkbox proximanova-bold" style="margin-left: 1.5px;"> Direct Deposit in PCA’s Bank Account</label></div>
														</td>
														<td width="20%">
															<div class="checkbox {{isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Credit Card' ? 'checked' : ''}}"><label class="label label-checkbox proximanova-bold" style="margin-left: 1.5px;"> Credit Card</label></div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="20%" valign="top">
												<p class="px-13-font proximanova-bold text-right" style="line-height: 14px;"> Bank Details<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<table width="80%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="0">
													<tbody>
														<tr>
															<td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;">
																<p class=" px-12-font">Account Name</p>
															</td>
															<td valign="top" width="70%" style="padding: 2px 5px;">
																<p class="px-12-font">Phoenix College of Australia Pty. Ltd.</p>
															</td>
														</tr>
														<tr>
															<td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;">
																<p class=" px-12-font">Bank</p>
															</td>
															<td valign="top" width="70%" style="padding: 2px 5px;">
																<p class="px-12-font">Westpac</p>
															</td>
														</tr>
														<tr>
															<td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;">
																<p class=" px-12-font">Branch</p>
															</td>
															<td valign="top" width="70%" style="padding: 2px 5px;">
																<p class="px-12-font">Werribee</p>
															</td>
														</tr>
														<tr>
															<td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;">
																<p class=" px-12-font">BSB</p>
															</td>
															<td valign="top" width="70%" style="padding: 2px 5px;">
																<p class="px-12-font">033-501</p>
															</td>
														</tr>
														<tr>
															<td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;">
																<p class=" px-12-font">Account Number</p>
															</td>
															<td valign="top" width="70%" style="padding: 2px 5px; ">
																<p class="px-12-font">289843</p>
															</td>
														</tr>
														<tr>
															<td valign="top" width="30%" class="peach-bg-color proximanova-bold" style="padding: 2px 5px;">
																<p class=" px-12-font">Swift Code</p>
															</td>
															<td valign="top" width="70%" style="padding: 2px 5px;">
																<p class="px-12-font">WPACAU2S</p>
															</td>
														</tr>
													</tbody>
												</table>
												<p class="px-12-font" style="line-height: 12px;"><i>(Please put your full name in description of payment)</i></p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- END #17 -->
					</div>
					
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 4 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 5 of 9 -->

<!-- Page 6 of 9 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 220px;">
						<!-- #17 Cont. -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">17</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 30px; left: 35px; line-height: 14px;">FEE PAYMENT<br>(Cont.)</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 14px;"> Credit Card<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-12-font" style="line-height: 12px;">I give permission for fee to be charged to my Credit Card for the selected course.</p>
												<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-left: 10px; padding-bottom: 10px;">
													<tr>
														<td width="20%">
															<div class="checkbox {{isset($ef['credit_card_type']['value']) && $ef['credit_card_type']['value'] == 'Visa' ? 'checked' : ''}}" style="margin-top: 7px;"><label class="label label-checkbox"> <span class="proximanova-bold">Visa Card</span></label></div>
														</td>
														<td width="25%">
															<div class="checkbox {{isset($ef['credit_card_type']['value']) && $ef['credit_card_type']['value'] == 'Master Card' ? 'checked' : ''}}" style="margin-top: 7px;"><label class="label label-checkbox"> <span class="proximanova-bold">Master Card</span></label></div>
														</td>
														<td width="55%">
															<p class="px-12-font proximanova-bold display-inlineblock">Card Expiry date</p>
															<div class="textbox display-inlineblock" style="width: 75px;">{{isset($ef['card_expiry_date']['value']) ? \Carbon\Carbon::parse($ef['card_expiry_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Card Number</span></p>
															<div class="textbox display-inlineblock" style="width: 324px;">{{isset($ef['card_number']) ? $ef['card_number'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Card Identification Number</span> (last 3 digits located on back</p>
															<div class="textbox display-inlineblock" style="width: 97px;">{{isset($ef['card_id_num']) ? $ef['card_id_num'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Amount</span> to be charged, in Australia Dollars</p>
															<div class="textbox display-inlineblock" style="width: 174px;">{{isset($ef['amount_to_be_charged']) ? $ef['amount_to_be_charged'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Card Holder’s Name</span></p>
															<div class="textbox display-inlineblock" style="width: 287px;">{{isset($ef['card_holder_name']) ? $ef['card_holder_name'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Card Holder’s Signature</span></p>
															<div class="textbox display-inlineblock" style="width: 267px;">@if (isset($ef['payment_method']['value']) && $ef['payment_method']['value'] == 'Credit Card')
															<p class="type-signature">{{isset($ep->type_signature) ? $ep->type_signature : ''}}<p>@endif</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>

									</table>
								</td>
							</tr>
						</table>
						<!-- END #17 Cont. -->
					</div>

					<div class="content" style="position: relative; width: 100%; height: 640px;">
						<!-- #18 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">18</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 60px; left: 15px; line-height: 14px;">EDUCATION AGENT</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-12-font proximanova-bold text-right" style="line-height: 12px;"> Details of approved<br>Education Agent<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-12-font" style="line-height: 12px;">I give permission for fee to be charged to my Credit Card for the selected course.</p>
												<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-left: 10px; padding-bottom: 10px;">
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Company Title</span></p>
															<div class="textbox display-inlineblock" style="width: 297px; margin-left: 24px;">{{isset($ef['company_title']) ? $ef['company_title'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Contact Name</span></p>
															<div class="textbox display-inlineblock" style="width: 297px; margin-left: 24px;">{{isset($ef['contact_name']) ? $ef['contact_name'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Contact Details</span></p>
															<div class="textbox display-inlineblock" style="width: 297px; margin-left: 18px;">{{isset($ef['contact_details']) ? $ef['contact_details'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Agent's Email</span></p>
															<div class="textbox display-inlineblock" style="width: 297px; margin-left: 28px;">{{isset($ef['contact_details_email']) ? $ef['contact_details_email'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock" style="line-height: 12px; vertical-align: top; margin-top: 7px;"><span class="proximanova-bold">Agent’s comments<br>on this application</span></p>
															<div class="textbox display-inlineblock" style="width: 297px; height: 150px; margin-top: 20px;">{{isset($ef['agents_comments']) ? $ef['agents_comments'] : ''}}</div>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font" style="line-height: 12px;"><span class="proximanova-bold">Declaration:</span></p>
															<ul class="list">
																<li class="px-14-font">I have assessed the applicant and to the best of my knowledge the applicant is</li>
																<li class="px-14-font">To the best of my knowledge, the applicant is genuine in making this application and has every intention of completing all programs listed in the application.</li>
																<li class="px-14-font">The documents which form part of this application appear to be authentic and valid. </li>
																<li class="px-14-font">I recommend that PCA proceed with the assessment for admission of this applicant.</li>
																<li class="px-14-font">I confirm the student has signed the application form.</li>
																<li class="px-14-font">I have provided the student’s personal email address and residential address, as disclosed to me by the student.</li>
															</ul>
														</td>
													</tr>
													<tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Date</span></p>
															<div class="textbox display-inlineblock" style="width: 297px; margin-left: 75px;">{{isset($ef['ed_agent_date']['value']) ? \Carbon\Carbon::parse($ef['ed_agent_date']['value'])->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
														</td>
													</tr>
													<!-- <tr>
														<td width="100%" colspan="3">
															<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Agent’s Signature</span></p>
															<div class="textbox display-inlineblock" style="width: 297px; margin-left: 4px;"></div>
														</td>
													</tr> -->
												</table>
											</td>
										</tr>

									</table>
								</td>
							</tr>
						</table>
						<!-- END #18 -->
					</div>

					
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 5 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 6 of 9 -->

<!-- Page 7 of 9 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%; height: 640px;">
						<!-- #19 -->
						<span class="px-60-font line-height-1" style="margin-left: 20px; position: absolute; top: 0; left: -20px;">19</span>
						<span class="proximanova-bold text-right" style="transform: rotate(-90deg); position: absolute; top: 80px; left: 5px; line-height: 14px;">POLICIES & PROCEDURES</span>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="20%" valign="middle" colspan="2">
									<table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-left: 125px;">
										<tr>
											<td width="20%" valign="top">
												<p class="px-14-font proximanova-bold text-right" style="line-height: 12px;">Policies &<br>Procedures<img src="{{public_path()}}/custom/pca-enrolment/images/arrow.png" style="margin-left: 2px;"></p>
											</td>
											<td width="80%" valign="top" style="padding-left: 10px;">
												<p class="px-12-font" style="line-height: 12px;">Refer to <span class="proximanova-bold">Student Handbook</span> for following policies and procedures. </p>
												<p class="px-12-font" style="line-height: 12px;">Same are available on website.</p>
												<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px; margin-left: 10px; padding-bottom: 10px;">
													<tr>
														<td width="100%" colspan="3">
															<ul class="list">
																<li class="px-14-font">Complaints and Appeals Policy and Procedure</li>
																<li class="px-14-font">Critical Incident Policy and Procedure</li>
																<li class="px-14-font">Pre-Enrolment Engagement Policy and Procedures</li>
																<li class="px-14-font">Entry Requirements for Domestic Students Policy and procedure</li>
																<li class="px-14-font">Fee Charges and Refunds Policy and Procedure</li>
																<li class="px-14-font">Deferral suspension and cancellation policy and procedure</li>
																<li class="px-14-font">Recognition of Prior Learning and Credit Transfer policy and procedure</li>
																<li class="px-14-font">Student Support Services Policy and Procedure</li>
																<li class="px-14-font">Privacy and Personal Information Policy and Procedure</li>
																<li class="px-14-font">Certification, issuing and recognition of Qualifications Policy and Procedure</li>
																<!-- <li class="px-14-font">Monitoring Course Progress and Intervention Strategy for International Students Policy and Procedure</li>
																<li class="px-14-font">Attendance Monitoring Policy and Procedure</li>
																<li class="px-14-font">Overseas Students Transfer Policy and Procedure</li> -->
																<li class="px-14-font">Plagiarism, Academic Misconduct and non-academic Misconduct Policy and Procedure</li>
																<li class="px-14-font">Assessment and Reassessment Policy and Procedure</li>
															</ul>
														</td>
													</tr>
												</table>
											</td>
										</tr>

									</table>
								</td>
							</tr>
						</table>
						<!-- END #19 -->
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 6 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 7 of 9 -->

<!-- Page 8 of 9 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%;">
						<p class="peach-bg-color proximanova-bold px-16-font text-uppercase text-center">ENROLMENT DECLARATION</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="proximanova-bold px-12-font">Privacy Notice</p>
						<p class="px-12-font text-justify" style="line-height: 12px;">Under the Data Provision Requirements 2012, PCA is required to collect personal information about you and to disclose that personal information to the National Centre for Vocational Education Research Ltd (NCVER).</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">Your personal information (including the personal information contained on this enrolment form and your training activity data) may be used or disclosed by PCA for statistical, regulatory and research purposes. PCA may disclose your personal information for these purposes to third parties, including:</p>
						<ul class="list">
							<li class="px-12-font" style="padding: 0 !important;">School – if you are a secondary student undertaking VET, including a school-based apprenticeship or traineeship;</li>
							<li class="px-12-font" style="padding: 0 !important;">Employer – if you are enrolled in training paid by your employer; </li>
							<li class="px-12-font" style="padding: 0 !important;">Government departments and authorised agencies;</li>
							<li class="px-12-font" style="padding: 0 !important;">NCVER;</li>
							<li class="px-12-font" style="padding: 0 !important;">Organisations conducting student surveys; and</li>
							<li class="px-12-font" style="padding: 0 !important;">Researchers.</li>
						</ul>
						<p class="px-12-font text-justify" style="line-height: 12px;">Personal information disclosed to NCVER may be used or disclosed for the following purposes:</p>
						<ul class="list">
							<li class="px-12-font" style="padding: 0 !important;">Issuing statements of attainment or qualification, and populating authenticated VET transcripts;</li>
							<li class="px-12-font" style="padding: 0 !important;">facilitating statistics and research relating to education, including surveys;</li>
							<li class="px-12-font" style="padding: 0 !important;">understanding how the VET market operates, for policy, workforce planning and consumer information; and</li>
							<li class="px-12-font" style="padding: 0 !important;">administering VET, including programme administration, regulation, monitoring and evaluation. </li>
						</ul>
						<p class="px-12-font text-justify" style="line-height: 12px;">You may receive an NCVER student survey which may be administered by an NCVER employee, agent or third party contractor. You may opt out of the survey at the time of being contacted. </p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">NCVER will collect, hold, use and disclose your personal information in accordance with the Privacy Act 1988 (Cth), the VET Data Policy and all NCVER policies and protocols (including those published on NCVER’s website at www.ncver.edu.au).</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">Please be advised that the information collected from the students as part of the enrolment will be provided to the Department of Home Affairs and other State/Territory government agencies.</p>
						<div class="clearfix" style="height: 10px;"></div>
						<p class="proximanova-bold px-12-font">Enrolment Declaration</p>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-0']) && in_array($ef['enrolment_declaration-0'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font">The information herein provided is to the best of my knowledge true, correct and complete at the time of my enrolment.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-1']) && in_array($ef['enrolment_declaration-1'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> PCA may refuse my application or cancel my enrolment if any information is found to be incorrect or misleading.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-2']) && in_array($ef['enrolment_declaration-2'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I consent to the collection, use and disclosure of my personal information in accordance with the Privacy Notice above.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-3']) && in_array($ef['enrolment_declaration-3'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I understand that by completing this application, I am giving written consent to PCA to independently verify the information supplied by me in this form and request further documents as required.</label></div>
											</td>
										</tr>
										{{-- <tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-4']) && in_array($ef['enrolment_declaration-4'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I declare that I am a Genuine Temporary Entrant and a Genuine Student. Please refer to the Department of Home Affairs website for details: <a href="https://www.homeaffairs.gov.au/trav/stud/more/genuine-temporary-entrant">https://www.homeaffairs.gov.au/trav/stud/more/genuine-temporary-entrant</a>.</label></div>
											</td>
										</tr> --}}
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-5']) && in_array($ef['enrolment_declaration-5'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I agree to undertake a testing requirement prior to course entry, if deemed necessary by PCA, and adhere to any other pre requisite identified above.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-6']) && in_array($ef['enrolment_declaration-6'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have got access to all the relevant policies and procedures as listed above.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-7']) && in_array($ef['enrolment_declaration-7'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I have been informed of my rights and obligations as a student with Phoenix College of Australia, and agree to abide by all rules and regulations of Phoenix College of Australia. I confirm that all arrangements are made to pay outstanding fees and charges applicable to this training program and that Phoenix College of Australia can withhold my academic results until my debt is fully paid and any property belonging to Phoenix College of Australia has been returned.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-8']) && in_array($ef['enrolment_declaration-8'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I confirm that I have received and read a copy of PCA’s student Handbook and fully understand the requirements of the course and relevant policies and procedures.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-9']) && in_array($ef['enrolment_declaration-9'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> (Optional) I hereby give my permission to Phoenix College of Australia to use my (Name, Testimonial, Image / Photograph) in publications and advertisements produced by or for Phoenix College of Australia. I understand that:</label></div>

												<ul class="list">
													<li class="px-12-font" style="padding: 0 !important;">These may be used for publication in film, photographs, in printed materials, electronically and on the internet.</li>
													<li class="px-12-font" style="padding: 0 !important;">The above permission will apply for three years from the date of signing this form.</li>
													<li class="px-12-font" style="padding: 0 !important;">I will not receive any compensation or payment for the above.</li>
													<li class="px-12-font" style="padding: 0 !important;">Once my personal information has been published on the internet, Phoenix College of Australia has no control over its subsequent use and disclosure.</li>
												</ul>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-10']) && in_array($ef['enrolment_declaration-10'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> A student’s USI may be used for specific VET purposes including the verification of student data provided by PCA, the administration and audit of VET providers and program; education-related policy and research purposes, and to assist in determining eligibility for training subsidies.</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 7 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 8 of 9 -->

<!-- Page 9 of 9 -->
<body>
	<div>
		<div class="col-xs-12 no-padding">
			<div class="pdf-wrapper">
				<div style="padding-bottom: 10px;  margin: 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo">
									<img src="{{public_path()}}/custom/pca-enrolment/images/phoenix.png" alt="">
								</div>
							</td>
							<td width="80%">
								<p class="primary-font-color proximanova-bold px-20-font text-right line-height-1">Domestic</p>
								<p class="primary-font-color proximanova-bold px-24-font text-right line-height-1">Enrolment Application Form</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 30px;">

					<div class="content" style="position: relative; width: 100%;">
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" class="form-table">
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-11']) && in_array($ef['enrolment_declaration-11'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font"> I agree to the Fee Charges and Refund Policy and Procedure.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-12']) && in_array($ef['enrolment_declaration-12'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font">I have read and understood the complaints and appeals processes, my rights as a student, the Privacy Statement and my right to access Australian Consumer Protection law.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-13']) && in_array($ef['enrolment_declaration-13'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font">I have also been provided with course information, duration of my course and I understand how to access support services and information I understand that access to academic records is provided free of charge.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-14']) && in_array($ef['enrolment_declaration-14'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font">I acknowledge that providing false, misleading or inaccurate information may affect the acceptance of this application and/or the continued provision of training and assessment services.</label></div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="checkbox {{isset($ef['enrolment_declaration-15']) && in_array($ef['enrolment_declaration-15'], [true, 1]) ? 'checked' : ''}}"><label class="label label-checkbox black-font-color px-10-font">I acknowledge that all fees are payable in full on course commencement or the commencement of the term that fees are due.</label></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table width="100%" class="form-table" cellpadding="0" cellspacing="0" border="0">
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
								<td width="100%" valign="top" style="padding: 20px 0;">
									<table width="100%" class="form-table">
										<tr>
											<td width="100%">
												<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Applicant’s Name</span></p>
												<div class="textbox display-inlineblock" style="width: 597px; margin-left: 5px;">{{implode(' ', $fullname)}}</div>
											</td>
										</tr>
										<tr>
											<td width="100%">
												<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Applicant’s Signature</span></p>
												<div class="textbox display-inlineblock" style="width: 380px; margin-left: 5px; margin-right: 10px;">
													<div class="type-signature">
														{{isset($ep->type_signature) ? $ep->type_signature : ''}}
													</div>
												</div>
												<p class="px-12-font display-inlineblock"><span class="proximanova-bold">Date</span></p>
												<div class="textbox display-inlineblock" style="width: 137px; margin-left: 5px;">{{isset($ep->created_at) ? \Carbon\Carbon::parse($ep->created_at)->timezone('Australia/Melbourne')->format('d / m / Y') : ''}}</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

						<p class="peach-bg-color proximanova-bold px-16-font text-uppercase text-center">WHAT’S NEXT!</p>

						<div class="clearfix" style="height: 10px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">If you are a successful applicant, Phoenix College of Australia (PCA) will issue you with an Offer letter and Enrolment Acceptance Agreement expressing the course, of which you have been acknowledged. This will express all the course points of interest and in addition the charges for the course.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">The acknowledgment of Offer Letter is the genuine assertion, which expresses all the information about the course, fees, refund and so on. You should sign this agreement to acknowledge the offer from Phoenix College of Australia of Australia.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">Return the copies of the Offer and Acceptance letter with your signature and the date to PCA and your course will commence as agreed. You can email these documents to <a href="mailto:phoenixcollegeaustralia@gmail.com">phoenixcollegeaustralia@gmail.com</a> or post/hand over your application at 2/11 Cordelia Street, South Brisbane, Qld 4101.</p>
						<div class="clearfix" style="height: 5px;"></div>
						<p class="px-12-font text-justify" style="line-height: 12px;">For any query, please contact PCA’s in the first instance by phone or email <a href="mailto:phoenixcollegeaustralia@gmail.com">phoenixcollegeaustralia@gmail.com</a>. </p>

					</div>

					<div class="footer bottom-placement px-10-font text-center blue-font-color">
						<p style="margin-bottom: 2px;">V1.0 | RTO No: 45633 | CRICOS Code: 03871F</p>
						<p style="margin-bottom: 0px;"> Page 8 of 8</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- End Page 9 of 9 -->
</html>