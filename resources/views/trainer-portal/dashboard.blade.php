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
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Not Started Class</div>
                {{-- <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $dashboard['courseDetail']['code'] }} - {{$dashboard['courseDetail']['course']}}</div> --}}
            </div>
            <div class="col-auto">
                <i class="fas fa-hourglass-start fa-2x text-gray-300"></i>
            </div>
            </div>
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="h6 mb-0 font-weight-bold text-gray-800">{{$class_statuses['not_yet_taken']}}</div>
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
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">On Going Class</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$class_statuses['ongoing']}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
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
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Finished Class</div>
                <div class="row no-gutters align-items-center">
                <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$class_statuses['finish']}}</div>
                </div>
                {{-- <div class="col">
                    <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div> --}}
                </div>
            </div>
            <div class="col-auto">
                <i class="fas fa-hourglass-end fa-2x text-gray-300"></i>
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
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Classes</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$class_statuses['finish'] + $class_statuses['ongoing'] + $class_statuses['not_yet_taken']}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-hourglass fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Content Row -->

    <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Ongoing Class Schedules</h6>
                
            </div>
            <!-- Card Body -->
            <div class="card-body" style="padding-right: 10px;">
                <div class="activity-list-wrapper" style="height: 320px; overflow-y: auto;">
                    @if(isset($ongoingStudent[0]))
                        @foreach ($trainerClass as $class)
                            @if($class->class_status == 'Ongoing')
                                <h6 class="font-weight-bold text-{{$app_settings[0]->app_color}}">{{$class->desc}} - {{$class->course_code}}</span></h6>
                                <div class="pl-3">
                                    @php
                                        $count = 0;
                                        $now = \Carbon\Carbon::now()->timezone('Australia/Brisbane')->format('Y-m-d');
                                    @endphp
                                    @foreach ($class->time_table->time_table as $i)
                                        @php
                                            $start = \Carbon\Carbon::parse($i['dates']['start'])->timezone('Australia/Brisbane')->format('Y-m-d');   
                                            $end = \Carbon\Carbon::parse($i['dates']['end'])->timezone('Australia/Brisbane')->format('Y-m-d');   
                                        @endphp
                                        {{-- <h6 class="font-weight-bold">{{$start}} - {{$end}} - {{$now}}</h6> --}}
                                        @if($start >= $now || $now <= $end)
                                            @php
                                                if($count > 4){
                                                    break;
                                                }else{
                                                    $count++;
                                                }  
                                            @endphp    
                                        
                                            <h6 class="font-weight-bold">{{$i['unit']['code']}} -  {{$i['unit']['description']}}</h6>
                                            <h6><span class="">{{\Carbon\Carbon::parse($i['dates']['start'])->timezone('Australia/Brisbane')->format('d / m / Y')}} - {{\Carbon\Carbon::parse($i['dates']['end'])->timezone('Australia/Brisbane')->format('d / m / Y')}}</span></h6>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-center">No Ongoing Class Available</p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Ongoing Class Students</h6>
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
            @if (isset($ongoingStudent[0]))
                @foreach ($ongoingStudent as $item)
                    <h6 class="font-weight-bold text-{{$app_settings[0]->app_color}}">{{$item['class']}}</span></h6>
                    {{-- <div class="pl-3"> --}}
                    <ul class="list-unstyled">
                        @foreach ($item['students'] as $i)
                        @if ($i->student)
                            <li style="margin-bottom: 10px;">   
                                <div class="position-relative arial-regular">
                                    <div class="activity-user-initials display-inlineblock position-absolute">
                                        {{-- <span class="europa-regular white-font-color px-10-font arial-bold" style="background:none !important;"><i class="fas fa-user-edit fa-2x"></i></span> --}}
                                        @if(isset($i->student->party->user->profile_image))
                                        <span class="europa-regular white-font-color px-10-font arial-bold" style="background:none !important;"><img src="/storage/user/avatars/{{$i->student->party->user->profile_image}}" width="40px" height="40px" style="border-radius: 50%;"></span>
                                        @else
                                        <span class="europa-regular white-font-color px-10-font arial-bold" style="background:none !important;"><img src="/storage/user/avatars/default-profile.png" width="40px" height="40px" style="border-radius: 50%;"></span>
                                        @endif
                                    </div>
                                    <div class="activity-user-content display-inlineblock" style="margin-left: 45px; font-size:16px; padding-top:10px;">
                                        
                                        <p style="margin:0;"><b>{{$i->student->party->name}}</b> ({{$i->student->student_id}})</p>
                                        
                                        {{-- <p style="margin:0;line-height: initial;"><b></b> --}}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endif
                        @endforeach
                    </ul>
                    {{-- </div> --}}
                @endforeach
            @else
                <p class="text-center">No Ongoing Class Available</p>
            @endif
            
            
            {{-- <ul class="list-unstyled">
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
            </ul> --}}
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