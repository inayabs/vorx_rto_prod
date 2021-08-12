<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="{{public_path()}}/cea-enrolment-form/pdf-style.css" rel="stylesheet" />
    <title>Site Inspection Checklist</title>
    <style>
        p,th,td,span {
            color:#000 !important;
            font-family: 'Calibri-Regular';
        }
    </style>
</head>
<!-- {{public_path().'/custom/pca-enrolment/pdf-style.css'}} -->
<!-- Page 1 of 9 -->
@foreach ($tbody as $k => $v)
<body>
	<div class="col-xs-12 no-padding">
		<div class="pdf-wrapper">
				<div class="clearfix"></div>
            <div style="padding-bottom: 10px;  margin: 0 30px;">
                <p class="text-left proximanova-bold px-18-font text-center" style="">Community Education Australia (RTO NO: 6074)</p>
                @if ($k == 0)
                    <div style="background-color:#8eaadb; width:100%; border:1px solid #000" class="text-center"><span class="text-center proximanova-bold px-18-font" style="color:#fff !important;">SITE INSPECTION CHECKLIST</span></div>
                    <div style="padding-bottom: 10px;  margin: 15px 0;"></div>
                    <p class="text-left px-14-font">
                        <span class="proximanova-bold">Team Members:</span> <span style="border-bottom: 1px solid #000; padding-left:5px; padding-right:10px;">{{$inputs['team_members']}}</span>
                    </p>
                    <p class="text-left px-14-font">
                        <span class="proximanova-bold">Date of Inspection:</span> <span style="border-bottom: 1px solid #000; padding-left:5px; padding-right:10px;">{{\Carbon\Carbon::parse($inputs['date_of_inspection'])->setTimezone('Australia/Brisbane')->format('d/m/Y')}}</span>
                    </p>
                    <p class="text-left px-14-font">
                        <span class="proximanova-bold">Training Delivery Location address:</span> <span style="border-bottom: 1px solid #000; padding-left:5px; padding-right:10px;">{{$inputs['training_delivery_location_address']}}</span>
                    </p>
                    <div style="padding-bottom: 10px;  margin: 15px 0;"></div> 
                @endif
                {{-- table --}}
                <table width="100%" class="form-table table-bordered" cellpadding="0" cellspacing="0" border="1">
                    <thead>
                        <tr>
                            <th rowspan="2" width="40%" class="proximanova-bold" style="background-color:#8eaadb;"></th>
                            <th colspan="2" width="10%" class="proximanova-bold" style="background-color:#8eaadb; line-height:12px; font-size:12px">Acceptable</th>
                            <th rowspan="2" width="20%" class="proximanova-bold" style="background-color:#8eaadb; line-height:12px; font-size:14px">Immediate action taken</th>
                            <th rowspan="2" width="20%" class="proximanova-bold" style="background-color:#8eaadb; line-height:12px; font-size:14px">Further action required*</th>
                            <th rowspan="2" width="10%" class="proximanova-bold" style="background-color:#8eaadb; line-height:12px; font-size:12px">Date signed off</th>
                            <th rowspan="2" width="10%" class="proximanova-bold" style="background-color:#8eaadb; line-height:12px; font-size:12px">Date to be Completed</th>
                        </tr>
                        <tr>
                            <th style="background-color:#8eaadb;">Y</th>
                            <th style="background-color:#8eaadb;">N</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($v as $item)
                        <tr>
                            
                            @if ($item['type'] == 'title')
                            <td colspan="7" style="background-color:#8eaadb; padding:3px; font-size:12px;" class="proximanova-bold"> {{$item['desc']}}</td>
                            @else
                            <td style="line-height:14px; padding:3px; font-size:12px;"> {{$item['desc']}}</td>
                            @foreach ($item['items'] as $i)
                                @if($i['type'] == 'checkbox')
                                    <td class="text-center" style="">
                                        @if($i['value'] == 1)
                                            <img src="{{public_path()}}/images/checked-no-border.png" alt="">
                                        @endif
                                    </td>
                                @elseif($i['type'] == 'text')
                                     <td class="text-center" style="">
                                        <span style="font-size: 11px; line-height:10px;">{{$i['value']}}</span>
                                     </td>
                                @else
                                    <td class="text-center" style="font-size: 10px;"> {{$i['value']}}</td>
                                @endif
                            @endforeach
                            @endif
                        </tr>
                       @endforeach
                    </tbody>
                </table>

            </div>
            <div class="footer bottom-placement px-12-font text-center" style="margin-top: -5px;">
                <p style="margin-bottom: 2px;">SITE Inspection Checklist V1.0, RTO NO: 6074,       Page {{$k+1}}</p>
                <p class=""></p>
            </div>
        </div>
	</div>
</body>
@endforeach
</html>
