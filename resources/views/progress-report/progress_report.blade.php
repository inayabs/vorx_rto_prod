<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link type="text/css" href="{{public_path()}}/progress-report/style.css" rel="stylesheet" />
	<title>Progress Report</title>
</head>
<!-- Page 1 of 2 -->
<body class="exo2-regular position-relative">
	<div id="page-background" class="overlay">
        {{-- <img src="{{public_path()}}/progress-report/images/progress-report-bg.jpg" height="100%" width="100%" style="position: absolute; width: 100%;z-index: -1;"> --}}
     </div> 
	<div>
		<div class="col-xs-12 no-padding position-relative">
			<div class="pdf-wrapper proximanova-regular">
				<div class="pdf-header">
                  <div>
						<table width="100%">
							<tr>
								<td width="50%">
									<div class="eti-logo">
										@if ($app->logo_img != null)
											<p class=" px-16-font text-left line-height-1point2">RTO - {{$app->training_organisation_id}}</p>
										@else
											<img src="{{public_path()}}/images/logo/vorx_logo-colored_1.png" alt="">
										@endif
									</div>
								</td>
								<td width="50%">
									<p class=" px-16-font text-right line-height-1point2">PROGRESS REPORT</p>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="pdf-wrapper pdf-body">
					<table width="100%" class="green-bordered-table">
						<tbody>
							<tr>	
								<td class="text-left background-{{$app->app_color}} text-center" width="20%"><span class="europa-bold white-font-color">STUDENT NAME</span></td>
								<td class="text-left" colspan="3"> {{ $completion->student->party->name }} ( {{ $completion->student->student_id }} ) </td>
							</tr>
							<tr>	
								<td class="text-left background-{{$app->app_color}} text-center" width="20%"><span class="europa-bold white-font-color">COURSE CODE </span></td>
								<td class="text-left" width="30%">{{$completion->course_code != '@@@@' ? $completion->course_code : ' Unit of Competency'}} </td>
								<td class="text-left background-{{$app->app_color}} text-center" width="15%"><span class="europa-bold white-font-color">COURSE NAME </span></td>
								<td class="text-left" width="35%">{{$completion->course_code != '@@@@' ? $completion->course->name : $completion->completion_course->funded_course->uc_description}} </td>
							</tr>
						</tbody>
					</table>
					<table width="100%" class="green-bordered-table">
						<tbody>
							<tr>
								<td class="text-left background-{{$app->app_color}} text-center" width="30%"><span class="europa-bold white-font-color">EXPECTED COURSE COMPLETION </span></td>
								<td class="text-left" width="20%">
									@if(isset($completion->completion_course->funded_course->end_date) && !in_array($completion->completion_course->funded_course->end_date, ['', null, '0000-00-00']))
									{{
										\Carbon\Carbon::createFromFormat('Y-m-d', $completion->completion_course->funded_course->end_date)->format('d/m/Y')
										}} 
									@endif
									
								</td>
								<td class="text-left background-{{$app->app_color}} text-center" width="15%"><span class="europa-bold white-font-color">ENROLMENT DATE  </span></td>
								<td class="text-left" width="35%">
									@if(isset($completion->completion_course->funded_course->start_date) && !in_array($completion->completion_course->funded_course->start_date, ['', null, '0000-00-00']))
									{{
										\Carbon\Carbon::createFromFormat('Y-m-d', $completion->completion_course->funded_course->start_date)->format('d/m/Y')
										}} 
									@endif
								 </td>
							</tr>
						</tbody>
					</table>
					<div class="clearfix" style="height: 30px;"></div>
					<p  class="px-10-font  text-justify line-height-1point2">This is to inform you that you have completed the following units successfully. Please find the results below: </p>
					<div class="clearfix" style="height: 10px;"></div>
					<table width="100%" class="green-bordered-table">
						<tbody>
							<tr>
								<td colspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">UNITS OF COMPETENCY  </span></td>
								<td rowspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">START DATE</span> </td>
								<td rowspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">COMPLETION DATE</span> </td>
								<td rowspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">RESULT</span> </td>
								{{-- <td rowspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">PRACTICAL</span> </td> --}}
							</tr>
							<tr>
								<td class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">UNIT CODE</span> </td>
								<td class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color" >UNIT TITLE</span> </td>
							</tr>
							@foreach ($units[0] as $unit)
								<tr>
										<td class="text-left" width="12%">{{ $unit->course_unit_code }} </td>
										<td class="text-left" width="30%">{{ $unit->unit->description }} </td>
									@if($unit->completion_status_id != 1)
										<td class="text-center" width="12%">{{ $unit->start_date != null ? \Carbon\Carbon::parse($unit->start_date)->format('d/m/Y') : ''}}</td>
										<td class="text-center" width="12%">{{ $unit->end_date != null ? \Carbon\Carbon::parse($unit->end_date)->format('d/m/Y') : ''}}</td>
										<td class="text-center" width="15%">
											@if($unit->status != null)
												{{$unit->status->status}}
											@endif
										 </td>
										{{-- <td class="text-center" width="12%"></td> --}}
									@else
										<td class="text-center" width="12%"></td> </td>
										<td class="text-center" width="12%"></td>
										<td class="text-center" width="15%"></td>
										{{-- <td class="text-center" width="12%"></td> --}}
									@endif
								</tr>
								
							@endforeach
						</tbody>
					</table>
					@if($font != 12)
					<div class="clearfix" style="height: 40px;"></div>
					<table>
						<tr>
							{{-- <td>
								<p class="line-height-1">Sincerely,</p>
								<img src="{{public_path()}}/progress-report/images/DALBIR-SIGNATURE.png" style="width: 180px;">
								<p class="line-height-1">Administration Department</p>
								<p class="line-height-1">Elite Training Institute</p>
							</td> --}}
						</tr>
					</table>
					@endif
				</div>
			</div>
			<div class="pdf-footer">
						<table width="100%">
							<tr>
								<td>
									<div class="footer bottom-placement px-10-font text-center ">
										<p style="margin-bottom: 2px;">Progress Report (C) Copyright VORX</p>
										@if($font == 12)
											<p class=" px-10-font europa-bold">Page 1 of {{count($units)}}</p>
										@endif
									</div>
								</td>
							</tr>
						</table>
				    </div>
		</div>
	</div>
</body>
@for ($i=1; $i < count($units); $i++) 
<!-- End Page 1 of 3 -->
@if($font == 12)
	<!-- Page 1 of 2 -->
	<body class="exo2-regular position-relative">
		<div id="page-background" class="overlay">
	        {{-- <img src="{{public_path()}}/progress-report/images/progress-report-bg.jpg" height="100%" width="100%" style="position: absolute; width: 100%;z-index: -1;"> --}}
	     </div> 
		<div>
			<div class="col-xs-12 no-padding position-relative">
				<div class="pdf-wrapper proximanova-regular">
					<div class="pdf-header">
	                  <div>
							<table width="100%">
								<tr>
									<td width="50%">
										<div class="eti-logo">
											@if ($app->logo_img != null)
												<p class=" px-16-font text-left line-height-1point2">RTO - {{$app->training_organisation_id}}</p>
											@else
												<img src="{{public_path()}}/images/logo/vorx_logo-colored_1.png" alt="">
											@endif
										</div>
									</td>
									<td width="50%">
										<p class=" px-16-font text-right line-height-1point2">PROGRESS REPORT</p>
									</td>
								</tr>
							</table>
					</div>
					</div>
					<div class="pdf-wrapper pdf-body">
						<table width="100%" class="green-bordered-table">
							<tbody>
								<tr>
									<td colspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">UNITS OF COMPETENCY  </span></td>
									<td rowspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">START DATE</span> </td>
									<td rowspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">COMPLETION DATE</span> </td>
									<td rowspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">RESULT</span> </td>
									{{-- <td rowspan="2" class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">PRACTICAL</span> </td> --}}
								</tr>
								<tr>
									<td class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">UNIT CODE</span> </td>
									<td class="text-center background-{{$app->app_color}}"><span class="europa-bold white-font-color">UNIT TITLE</span> </td>
								</tr>
								@foreach ($units[$i] as $k => $unit)
									{{-- @if($k != 0) --}}
										{{-- @foreach ($v as $unit) --}}
											<tr>
													<td class="text-left" width="12%">{{ $unit->course_unit_code }} </td>
													<td class="text-left" width="30%">{{ $unit->unit->description }} </td>
												@if($unit->completion_status_id != 1)
													<td class="text-center" width="12%">{{ $unit->start_date != null ? \Carbon\Carbon::parse($unit->start_date)->format('d/m/Y') : ''}}</td>
													<td class="text-center" width="12%">{{ $unit->end_date != null ? \Carbon\Carbon::parse($unit->end_date)->format('d/m/Y') : ''}}</td>
													<td class="text-center" width="15%">
														@if($unit->status != null)
														{{$unit->status->status}}
														@endif 
													</td>
													{{-- <td class="text-center" width="12%"></td> --}}
												@else
													<td class="text-center" width="12%"></td> </td>
													<td class="text-center" width="12%"></td>
													<td class="text-center" width="15%"></td>
													{{-- <td class="text-center" width="12%"></td> --}}
												@endif
											</tr>
										{{-- @endforeach --}}
									{{-- @endif --}}
								@endforeach
							</tbody>
						</table>
						<div class="clearfix" style="height: 40px;"></div>
						<table>
							<tr>
								<td>
									{{-- <p class="line-height-1">Sincerely,</p>
									<img src="{{public_path()}}/progress-report/images/DALBIR-SIGNATURE.png" style="width: 180px;">
									<p class="line-height-1">Administration Department</p>
									<p class="line-height-1">Elite Training Institute</p> --}}
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="pdf-footer">
							<table width="100%">
								<tr>
									<td>
										<div class="footer bottom-placement px-10-font text-center ">
											<p style="margin-bottom: 2px;">Progress Report (C) Copyright VORX</p>
											<p class=" px-10-font europa-bold">Page {{$i + 1}} of {{count($units)}}</p>
										</div>
									</td>
								</tr>
							</table>
					    </div>
			</div>
		</div>
	</body>
	<!-- End Page 1 of 3 -->
@endif
</html>
@endfor