<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	@if($app_settings->student_id_prefix =='PCA')
	<link type="text/css" href="{{ public_path()}}/custom/unit-of-competency-lln-test/pdf-style-pca.css" rel="stylesheet" />
	@elseif($app_settings->student_id_prefix =='CEA')
	<link type="text/css" href="{{ public_path()}}/cea-lln-test-form/pdf-style.css" rel="stylesheet" />
	@else
	<link type="text/css" href="{{ public_path()}}/custom/unit-of-competency-lln-test/pdf-style-cea.css" rel="stylesheet" />
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
		$attendance = collect($attendance);
	?>
@foreach($attendance->chunk(12) as $atte)
<body class="exo2-regular position-relative">
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper">
			
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
						@if($loop->first)
						<table width="100%" class="form-table">
							<tr>
								<td width="50%">
                                    <label class="label label-textbox">Class: <div class="text-input-line" style="width: 75%;margin-top: 5px;"><span class="dark-grey-font-color line-height-1point2">{{$student_class->desc}}</span></div></label> 
								</td>
								<td width="50%">
									<label class="label label-textbox">Student Type: <div class="text-input-line" style="width: 70%;margin-top: 5px;"><span class="dark-grey-font-color line-height-1point2">
                                        @if($student_type==1)
                                            International
                                        @elseif($student_type==2)
                                            Domestic
                                        @else
                                            All
                                        @endif
                                
                                    </span></div></label>
								</td>
							</tr>
                            <tr>
								<td width="50%">
                                    <label class="label label-textbox">Start Date: <div class="text-input-line" style="width: 75%;margin-top: 5px;"><span class="dark-grey-font-color line-height-1point2">{{$from != 'null' ? Carbon\Carbon::parse($from)->toFormattedDateString() : 'Not specified'}}</span></div></label> 
								</td>
								<td width="50%">
									<label class="label label-textbox">End Date: <div class="text-input-line" style="width: 70%;margin-top: 5px;"><span class="dark-grey-font-color line-height-1point2">{{$to != 'null' ? Carbon\Carbon::parse($to)->toFormattedDateString() : 'Not specified'}}</span></div></label>
								</td>
							</tr>
						</table>
						@endif
						<br>
						<table class="table default-bordered-table" cellspacing="0" cellpadding="0" width="85%" style="margin:0 auto !important">
							<thead>
								<tr>
                                    <th  width="15%">Profile image</th>
                                    <th  width="20%">Student Name</th>
                                    <th  width="15%">Student id</th>
                                    <th  width="20%">Preferred Hours</th>
                                    <th  width="20%">Actual Hours</th>
									<!-- <th class="text-center" style="background-color:{{$app_color}}"><span style="font-size:14px;">Date</span></th>
									<th class="text-center" style="background-color:{{$app_color}}"><span style="font-size:14px;">Hours of Training for that date</span></th> -->
                                    
								</tr>
							</thead>
							<tbody>
                                @foreach($atte as $att)
                                <tr>
                                    <td>
										
										@if(isset($att->user))
										<img src="{{public_path()}}/storage/user/avatars/{{$att->user->profile_image}}" alt="" style="width:50px;">
										@else
										<img src="{{public_path()}}/storage/user/avatars/default-profile.png" alt="" style="width:50px;">
										@endif
									</td>
                                    <td>{{$att->student->party->name}}</td>
                                    <td>{{$att->student_id}}</td>
                                    <td>{{$att->pref_hours}}</td>
                                    <td>{{$att->actual_hours}}
									</td>
                                </tr>
                                @endforeach
							</tbody>
							<tfoot>
								<tr>
									if way unod
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="footer bottom-placement px-10-font text-center blue-font-color">
                        <p>Warning - Uncontrolled when printed</p>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
@endforeach


<!-- End Page 1 of 1 -->

</html>