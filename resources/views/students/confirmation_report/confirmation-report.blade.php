<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="{{public_path()}}/css/confirmation_report/style.css" rel="stylesheet" />
</head>
<style>
    .unit-table thead tr{
        /* background-color:#000 !important; */
        margin-bottom: 100px !important;
    }
</style>
@php
    $unit_completed = 0;
    $scheduled_hours = 0;
    $started_hours = 0;
    $units_ct = 0;
    $ct_hours = 0;
    $units_rpl = 0;
    $rpl_hours = 0;
@endphp
<body class="exo2-regular" style="padding: 10px 20px;">
    <div style="position: relative;">
        <table width="100%" style="border-bottom: 1px solid #000;">
            <tr>
                <td width="20%" valign="top" style="padding-bottom:10px;">
                    

                    {{-- @if(!in_array($app_settings[0]->logo_img, ['', null]))
                    <img src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}" style="width:70px; margin-top:10px;">
                    @else
                    <img src="{{ asset('/images/logo/vorx_logo-colored_1.png') }}" style="width:70px; margin-top:10px;">
                    @endif --}}

                    <p class="primary-font-color"><span class="font-exo-bold">RTO Code</span> : {{ $rto_code }}</p>
                </td>
                <td width="60%" class="text-center" valign="top" style="padding-bottom:10px;">
                    <h1 class="font-exo-bold primary-font-color px-20-font no-margin no-padding">Completion Report</h1>
                    <p class="primary-font-color px-13-font">
                        @if ($getCourse != '@@@@')
                            {{$getCourse->code}} - {{$getCourse->name}}
                        @else
                            Unit of Competency {{isset($course->uc_description) ? '- '.$course->uc_description : ''}}</p>
                        @endif
                </td>
                <td width="20%" class="text-right" style="padding-bottom:10px;">
                    {{-- <p>30 May, 2020</p> --}}
                </td>
            </tr>
        </table>
        <div class="clearfix"></div>
        <table width="100%" style="margin-bottom: 10px;">
            <tr>
                <td width="33.33%">
                    <table width="100%">
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Student:</td>
                            <td colspan="5">{{$student->party->name}}</td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Student #:</td>
                            <td width="20%">{{$student->student_id}}</td>
                            <td class="font-exo-bold primary-font-color" width="7%">USI:</td>
                            <td width="25%">{{$student->funded_detail->unique_student_id}}</td>
                            <td class="font-exo-bold primary-font-color" width="7%">DOB:</td>
                            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d', $student->party->person->date_of_birth)->format('d/m/Y')}}</td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Email:</td>
                            <td colspan="5">{{$student->contact_detail->email}}</td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Phone:</td>
                            <td colspan="5"><span class="font-exo-bold">H: </span> {{$student->contact_detail->phone_home}} <span class="font-exo-bold">M: </span>{{$student->contact_detail->phone_mobile}} </td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Address:</td>
                            <td colspan="5">{{$student->contact_detail->addr_building_property_name}} {{$student->contact_detail->addr_flat_unit_detail}} {{$student->contact_detail->addr_street_num}} {{$student->contact_detail->addr_street_name}} {{$student->contact_detail->addr_suburb}} {{isset($student->contact_detail->state->state_key) ? $student->contact_detail->state->state_key : ''}} {{$student->contact_detail->postcode}}</td>
                        </tr>
                    </table>
                </td>
                <td width="33.33%">
                    <table width="100%">
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Status:</td>
                            <td>{{$course->course_completion->completion->completion_status_id == 3 ? 'Completed Successfully' : 'Not Yet Completed'}} {{isset($course->course_completion->completion->certificate->issued_date) && !in_array($course->course_completion->completion->certificate->issued_date, ['', null, '0000-00-00']) ? 'and Certificate Issued' : ''}}</td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Dates:</td>
                            <td>{{isset($course->start_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $course->start_date)->format('d/m/Y') : ''}} to {{isset($course->start_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $course->end_date)->format('d/m/Y') : ''}}</td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Funding:</td>
                            <td>{{isset($course->detail->fund_national->id) ? $course->detail->fund_national->description : ''}}</td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">-</td>
                            <td></td>
                        </tr>
                        
                    </table>
                </td>
                {{-- <td width="33.33%">
                    <table width="100%">
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Employer:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Contact:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Email:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Phone:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-exo-bold primary-font-color" width="20%">Address:</td>
                            <td>No Address</td>
                        </tr>
                    </table>
                </td> --}}
            </tr>
        </table>
        <div class="clearfix"></div>
        <table width="100%" class="unit-table">
            <thead>
                <tr>
                    <th class="font-exo-bold background-{{$app_settings[0]->app_color}}">Unit</th>
                    <th width="7%" class="font-exo-bold text-center background-{{$app_settings[0]->app_color}}">Hours</th>
                    <th width="7%" class="font-exo-bold text-center background-{{$app_settings[0]->app_color}}">Started</th>
                    <th width="10%" class="font-exo-bold text-center background-{{$app_settings[0]->app_color}}">Start Date</th>
                    <th width="10%" class="font-exo-bold text-center background-{{$app_settings[0]->app_color}}">End Date</th>
                    <th width="3%" class="font-exo-bold text-center background-{{$app_settings[0]->app_color}}">Result</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="text-center" colspan="6">Core</td>
                </tr> --}}
                @foreach ($course->course_completion->completion->details as $item)
                    {{-- @if($item->unit->unit_type == 'core') --}}
                        <tr>
                            <td>{{$item->unit->code}} — {{$item->unit->description}}</td>
                            <td class="text-center">{{$item->unit->nominal_hours}}</td>
                            <td class="text-center">{{$item->unit->nominal_hours}}</td>
                            <td class="text-center">{{isset($item->start_date) && !in_array($item->start_date, ['', null, '0000-00-00']) ? \Carbon\Carbon::createFromFormat('Y-m-d', $item->start_date)->format('d/m/Y') : ''}}</td>
                            <td class="text-center">{{isset($item->end_date) && !in_array($item->end_date, ['', null, '0000-00-00']) ? \Carbon\Carbon::createFromFormat('Y-m-d', $item->end_date)->format('d/m/Y') : ''}}</td>
                            <td class="text-center">{{$item->status->status_code}}</td>
                        </tr>

                        @php
                            if(in_array($item->completion_status_id, [3,4,6])){
                                $unit_completed = $unit_completed + 1;
                            }

                            $scheduled_hours = $scheduled_hours + $item->unit->nominal_hours;
                            $started_hours = $started_hours + $item->unit->nominal_hours;

                            if($item->completion_status_id == 4){
                                $units_ct = $units_ct + 1;
                                $ct_hours = $ct_hours + $item->unit->nominal_hours;
                            }

                            if($item->completion_status_id == 6){
                                $units_rpl = $units_rpl + 1;
                                $rpl_hours = $rpl_hours + $item->unit->nominal_hours;
                            }
                        @endphp 
                    {{-- @endif --}}
                @endforeach
                
            </tbody>
            {{-- <tbody>
                <tr>
                    <td class="sub-title text-center" colspan="6">Elective</td>
                    
                </tr>
                @foreach ($course->course_completion->completion->details as $item)
                    @if($item->unit->unit_type == 'elective')
                        <tr>
                            <td>{{$item->unit->code}} — {{$item->unit->description}}</td>
                            <td class="text-center">{{$item->unit->nominal_hours}}</td>
                            <td class="text-center">{{$item->unit->nominal_hours}}</td>
                            <td class="text-center">{{isset($item->start_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $item->start_date)->format('d/m/Y') : ''}}</td>
                            <td class="text-center">{{isset($item->end_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $item->end_date)->format('d/m/Y') : ''}}</td>
                            <td class="text-center">{{$item->status->status_code}}</td>
                        </tr>

                        @php
                            if($item->completion_status_id == 3){
                                $unit_completed = $unit_completed + 1;
                            }

                            $scheduled_hours = $scheduled_hours + $item->unit->nominal_hours;
                            $started_hours = $started_hours + $item->unit->nominal_hours;

                            if($item->completion_status_id == 4){
                                $units_ct = $units_ct + 1;
                                $ct_hours = $ct_hours + $item->unit->nominal_hours;
                            }

                            if($item->completion_status_id == 6){
                                $units_rpl = $units_rpl + 1;
                                $rpl_hours = $rpl_hours + $item->unit->nominal_hours;
                            }
                        @endphp
                    @endif
                @endforeach
            </tbody> --}}
            <tfoot >
                <tr >
                    <td colspan="3" valign="top" style="padding-top:20px !important;">
                        <p class="line-height-1"><span class="font-exo-bold">Nominal Hours: </span> The development of nominal hours is based on the anticipated hours of supervised learning or training deemed necessary in order to adequately present the educational material to the learner and may not necessarily reflect the time needed for any individual learner to demonstrate competency.</p>
                    </td>
                    <td colspan="3" class="text-right" valign="top" style="padding-top:20px !important;">
                        <p class="line-height-1">{{$unit_completed}} out of {{$course->course_completion->completion->details->count()}} Course Unit(s) Completed</p>
                        <p class="line-height-1">Scheduled Hours: {{$scheduled_hours}} Hours</p>
                        <p class="line-height-1">Started Hours: {{$started_hours}} Hours</p>
                        <p class="line-height-1">{{$units_ct}} Units by Credit Transfer: {{$ct_hours}} Hours</p>
                        <p class="line-height-1">{{$units_rpl}} Units by RPL: {{$rpl_hours}} Hours</p>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="certificate-footer">
            <table width="100%" style="margin-bottom: 10px;">
                <tr>
                    <td>LEGEND</td>
                    <td><span class="font-exo-bold" style="margin-right: 5px;">C</span> Competent</td>
                    <td><span class="font-exo-bold" style="margin-right: 5px;">CT</span> Credit Transfer</td>
                    <td><span class="font-exo-bold" style="margin-right: 5px;">NPL</span> RPL not Granted</td>
                    <td><span class="font-exo-bold" style="margin-right: 5px;">NYC</span> Not Yet Competent</td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td><span class="font-exo-bold" style="margin-right: 5px;">RAU</span> RPL Underway</td>
                    <td><span class="font-exo-bold" style="margin-right: 5px;">RPL</span> RPL Granted</td>
                    <td><span class="font-exo-bold" style="margin-right: 5px;">W</span> Withdrawn</td>
                    <td><span class="font-exo-bold" style="margin-right: 5px;">DNS</span> Did Not Start</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td width="50%">
                        <span>Comfirmation Report 1.0 (C) Copyright www.vorx.com.au</span>
                    </td>
                    <td width="50%"></td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>