<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	@if($app_settings->student_id_prefix =='PCA')
	<link type="text/css" href="{{ public_path()}}/custom/unit-of-competency-lln-test/pdf-style-pca.css" rel="stylesheet" />
	@else
	<link type="text/css" href="{{ public_path()}}/cea-lln-test-form/pdf-style.css" rel="stylesheet" />
	@endif
	<title>Attendance Sheet</title>
	<!-- Page 1 of 1 -->
	
	<?php
		if($app_settings->student_id_prefix == 'PCA'){
			$app_color = '#F26522';
		}else if($app_settings->student_id_prefix == 'CEA'){
			$app_color = '#024B67';
		}else{
			$app_color = 'primary';
		}
	?>
@foreach($attendance->attendance_details->chunk(18) as $ads)
<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
			
		@if($loop->first)
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="20%">
								<div class="logo-wrapper">
									@if(isset($app_settings->logo_img)&&$app_settings->logo_img!=null)
										<img src="{{public_path()}}/images/logo/{{$app_settings->logo_img}}" alt="">
									@else
										<img src="{{public_path()}}/images/logo/vorx_logo.png" alt="" style="width:100px">
									@endif
								</div>
							</td>
							<td width="80%">
								<!-- <p class="primary-font-color px-12-font text-right line-height-1point2">Certificate 3 Guarantee Program</p> -->
								<p class="primary-font-color px-16-font text-right line-height-1point2">Attendance Sheet</p>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
				<div style="padding-bottom: 10px;  margin: 0 10px;">
					<div class="content">
						<h1 class="section-header proximanova-bold primary-font-color px-12-font text-justify text-uppercase"></h1>
                        <br>
						<table width="100%" class="form-table">
							<tr>
								<td width="50%">
                                    <label class="label label-textbox">Student Name: <div class="text-input-line" style="width: 75%;margin-top: 5px;"><span class="dark-grey-font-color line-height-1point2">{{$attendance['student']['party']->name}}</span></div></label> 
								</td>
								<td width="50%">
									<label class="label label-textbox">Location (Suburb and Postcode): <div class="text-input-line" style="width: 70%;margin-top: 5px;"><span class="dark-grey-font-color line-height-1point2">{{isset($attendance['student_class']['delivery_location']->train_org_dlvr_loc_name)?$attendance['student_class']['delivery_location']->train_org_dlvr_loc_name:''}} - {{isset($attendance['student_class']['delivery_location']->postcode)?$attendance['student_class']['delivery_location']->postcode:''}}</span></div></label>
								</td>
							</tr>
							<tr>
								<td width="100%" colspan="2">
                                    <label class="label label-textbox">Course: <div class="text-input-line" style="width: 42%;margin-top: 5px;"><span class="dark-grey-font-color line-height-1point2">{{$attendance['course']->code}} - {{$attendance['course']->name}}</span></div></label>
								</td>
							</tr>
							<tr>
								<td width="100%" colspan="2" valign="top">
                                    <br>
									<label class="label label-textbox dark-grey-font-color"> I acknowledge that I have received Learning Resources, pre-enrolment information, {{$app_settings->student_id_prefix}} Policies and Procedures and Student Handbook. 
                                        <span class="checkbox checked"><label class="label label-checkbox">YES </label></span>   
                                        <span class="checkbox"><label class="label label-checkbox">NO </label></span>
                                    </label>
								</td>
							</tr>
						</table>
						@endif
						<br>
						<table class="table default-bordered-table" cellspacing="0" cellpadding="0" width="85%" style="margin:0 auto !important">
							<thead>
								<tr>
									<th class="text-center" style="background-color:{{$app_color}}"><span style="font-size:14px;">Date</span></th>
                                    {{-- <th class="text-center">Class Start time and End time</th> --}}
									{{-- <th class="text-center" style="background-color:{{$app_color}}">Unit Code and name</th> --}}
									<th class="text-center" style="background-color:{{$app_color}}"><span style="font-size:14px;">Hours of Training for that date</span></th>
                                    {{-- <th class="text-center">Student Signature</th> --}}
                                    {{-- <th class="text-center">Trainer Signature</th> --}}
								</tr>
							</thead>
							<tbody>
							@foreach($ads as $ad)
								<tr>
                                    <td valign="top" width="50%" class="text-center"><span style="font-size:12px;">{{Carbon\Carbon::createFromFormat('Y-m-d',$ad->date_taken)->format('d/m/Y')}}</span></td>
                                    {{-- <td valign="top" width="15%" class="text-center">{{date("g:i a", strtotime($ad->time_start))}} to {{date("g:i a", strtotime($ad->time_end))}}</td> --}}
									{{-- <td valign="top" width="30%">{{$ad->unit_code}} {{$ad['course_unit']->description}}</td> --}}
									<td valign="top" width="50%" class="text-center"><span style="font-size:12px;">{{number_format($ad->actual_hours)}}</span></td>
									{{-- <td valign="top" width="15%" class="text-center">Student Sig </td> --}}
									{{-- <td valign="top" width="15%" class="text-center">Trainer Sig </td> --}}
								</tr>
							@endforeach
							</tbody>
							<tfoot>
								<tr>
									@if($attendance->total_hours>0)
										<td class="text-center">Total hours</td>
										<td class="text-center">{{$attendance->total_hours}}</td>
									@endif
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p>Warning - Uncontrolled when printed</p>
						<p style="margin-bottom: 2px;">© {{$app_settings->training_organisation_name}} RTO No. {{$app_settings->training_organisation_id}} </p>
						<p class="">Page {{$loop->index+1}} of {{$loop->count}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

@endforeach
<!-- End Page 1 of 1 -->

</html>