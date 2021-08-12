@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    {{-- <h1 class="h3 mb-0 text-gray-800">{{ $dashboard['student']['fullname'] }} ({{ $dashboard['student']['student_id'] }})</h1> --}}
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Current Course</div>
                {{-- <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $dashboard['courseDetail']['code'] }} - {{$dashboard['courseDetail']['course']}}</div> --}}
            </div>
            <div class="col-auto">
                <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
            </div>
            </div>
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $dashboard['courseDetail']['code'] }} </div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">{{$dashboard['courseDetail']['course']}}</div>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Remaining Fees</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">${{number_format($dashboard['courseDetail']['fee'], 2)}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Units</div>
                <div class="row no-gutters align-items-center">
                <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$dashboard['courseDetail']['units_taken']}}</div>
                </div>
                {{-- <div class="col">
                    <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div> --}}
                </div>
            </div>
            <div class="col-auto">
                <i class="fas fa-book fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Attendance</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dashboard['attendance']}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-tasks fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Content Row -->

    <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-7 col-lg-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                {{-- <h6 class="m-0 font-weight-bold text-primary">Attendance per Unit</h6> --}}
                <h6 class="m-0 font-weight-bold text-primary">Attendance Detail</h6>
                @if(isset($dashboard['student']['attendance_id']))
                <a type="button" class="'btn btn-primary btn-sm float-right'" target="_blank" href="/attendance/pdf/{{$dashboard['student']['attendance_id']}}"><i class="fas fa-file-pdf"></i>  Generate Attendance</a>
                @endif
                {{-- <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" target="_blank" href="/attendance/pdf/{{$dashboard['student']['attendance_id']}}">Action</a>
                    </div>
                </div> --}}
            </div>
            <!-- Card Body -->
            <div class="card-body" style="padding-right: 10px;">
                <div class="activity-list-wrapper" style="height: 320px; overflow-y: auto;">
                    {{-- @foreach ($dashboard['units'] as $unit)
                        <h4 class="small font-weight-bold">{{$unit['code'] }} -  {{ $unit['name'] }}<span class="float-right">{{number_format($unit['percentage'],0)}}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar  {{ $unit['color'] }}" role="progressbar" style="width:{{number_format($unit['percentage'],0)}}%" aria-valuenow="{{number_format($unit['percentage'],0)}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @endforeach --}}
                    @foreach ($dashboard['attendance_detail'] as $item)
                        @if ($item['status'] != 'N/A')
                        <div class="row {{$item['status'] == 'Present' ? 'background-success' : 'background-danger'}} m-3 p-3" style="border-radius: 5px;">
                            {{-- <div class="col-md-12 background-success"> --}}
                                <div class="col-md-6"><b>Date taken:</b> {{Carbon\Carbon::createFromFormat('Y-m-d', $item['date_taken'])->format('d/m/Y')}}</div>
                                <div class="col-md-6 text-right"><b>Hours taken:</b> {{$item['actual_hours']}} hrs</div>
                            {{-- </div> --}}
                        </div>
                        @endif
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-5 col-lg-6">
        <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Enrolment Documents</h6>
            {{-- <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Dropdown Header:</div>
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
            </div> --}}
        </div>
        <!-- Card Body -->
        <div class="card-body" style="padding-right: 10px;">
        <div class="activity-list-wrapper" style="height: 320px; overflow-y: auto;">
            <ul>
                @if($e_pack != null)
                    @if ($e_pack->enrolment_form != null)
                    <li>
                        @if ($e_pack['student_type'] == 2)
                            <a href="/pca/online-enrolment/domestic/pdf/{{ $dashboard['process_id'] }}" target="_blank">Enrolment Form</a>
                        @else
                            <a href="/pca/online-enrolment/pdf/{{ $dashboard['process_id'] }}" target="_blank">Enrolment Form</a>
                        @endif
                    </li>
                    @endif
                    <li>
                        <a href="http://phoenixcollege.edu.au/files/policies/Student%20Handbook%20and%20Policies%20and%20Procedure.pdf" target="_blank">Student Handbook</a>
                    </li>
                    @if ($e_pack->acknowledgement != null)
                    <li>
                        <a href="/pca/acknowledgement-of-receipt/pdf/{{ $dashboard['process_id'] }}" target="_blank">Acknowledgement</a>
                    </li>
                    @endif
                    @if ($e_pack->induction != null)
                    <li>
                        <a href="/pca/induction-checklist/pdf/{{ $dashboard['process_id'] }}" target="_blank">Induction Checklist</a>
                    </li>
                    @endif
                    @if ($e_pack->ptr != null)
                    <li>
                        <a href="/pca/pre-training-review/pdf/{{ $dashboard['process_id'] }}" target="_blank">Pre-Training Review</a>
                    </li>
                    @endif
                    @if ($e_pack->lln != null)
                    <li>
                        <a href="/pca/lln-test/pdf/{{ $dashboard['process_id'] }}" target="_blank">LLN Test</a>
                    </li>
                    @endif
                @endif
                @if ($dashboard['offer_letter_id'] != null)
                <li>
                    <a href="/offer-letter/pdf/preview/{{ $dashboard['offer_letter_id'] }}" target="_blank">Offer Letter Enrolment and Agreement</a>
                </li>
                @endif
            </ul>
                        <!-- <ul class="list-unstyled">
                            @if ($activities == null)
                                <li style="margin-bottom: 10px;" class="text-center"><p>No Activities</p></li>
                            @else
                                @foreach ($activities as $act)
                                    <li style="margin-bottom: 10px;">   
                                        <div class="position-relative arial-regular">
                                            <div class="activity-user-initials display-inlineblock position-absolute">
                                                <span class="europa-regular white-font-color px-10-font arial-bold" style="background:none !important;"><img src="{{$act['avatar']}}" width="40px" height="40px" style="border-radius: 50%;"></span>
                                            </div>
                                            <div class="activity-user-content display-inlineblock" style="margin-left: 45px; font-size:12px; ">
                                                @php
                                                    $url = explode('/', $act['url']);
                                                    $module = ucfirst($url[3]);
                                                @endphp
                                                <p style="margin:0;">{{$act['firstname']}} {{$act['lastname']}}</p>
                                                <p style="margin:0;line-height: initial;"><b>{{ucfirst($act['event'])}}</b> a data entry <b>{{$act['dname']}}</b> under {{str_replace('-',' ',$module)}} Module <br> <small style="color:dimgrey;font-style:italic">{{$act['created_min']}}</small>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul> -->
                    </div>
        </div>
        </div>
    </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/sb-admin/vendor/chart.js/Chart.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/sb-admin/js/demo/chart-area-demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('/sb-admin/js/demo/chart-pie-demo.js') }}"></script> --}}
@endsection