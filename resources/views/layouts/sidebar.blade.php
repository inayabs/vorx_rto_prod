<ul class="navbar-nav bg-gradient-{{$app_settings[0]->app_color}} sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    {{-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ URL::to('/') }}"> --}}
    @if(isset($app_settings[0]->logo_background_color) && !in_array($app_settings[0]->logo_background_color, [null,'']))
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ URL::to('/') }}" style="background-color:{{$app_settings[0]->logo_background_color}} !important">
    @else
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ URL::to('/') }}" >
    @endif
     <div class="sidebar-brand-icon" style="position:relative;">
      @if(!in_array($app_settings[0]->logo_img, ['', null]))
        <img class="img-profile img-fluid w-75 mt-3" src="{{ asset('/storage/config/images/'.$app_settings[0]->logo_img) }}">
      @else
        <img class="img-profile img-fluid w-75" src="{{ asset('/images/logo/vorx_logo-colored.png') }}">
      @endif
      </div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-3 ">
    <!-- Nav Item - Dashboard -->
    @foreach ($sidebar_menu as $key => $value)
      @if($value->is_default == 1 || $app_settings[0]->add_on($value->add_on_name) == 1)
        @if(in_array(\Auth::user()->roles[0]->name, $value->role_access))
          @if($value->dropdown == 0)
              <li class="nav-item {{ (request()->is($value->link)) ? 'active' : '' }}">
                <a class="nav-link" href="{{ URL::to($value->link) }}">
                  <i class="{{$value->fa_icon}}"></i>
                <span>{{$value->menu_name}}</span>
                </a>
              </li>
          @else
            <li class="nav-item {{ in_array(request()->segment(1), $value->sub_menu_links) ? 'active' : '' }}">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{$value->add_on_name}}Pages" aria-expanded="true" aria-controls="{{$value->add_on_name}}Pages">
              {{-- <a class="nav-link" href="{{ route('student.index') }}"> --}}
                <i class="{{$value->fa_icon}}"></i>
                <span>{{$value->menu_name}}</span>
              </a>
              <div id="{{$value->add_on_name}}Pages" class="collapse {{ in_array(request()->segment(1), $value->sub_menu_links) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  @foreach ($value->sub_menus as $v)
                    @if($v->is_default == 1 || $app_settings[0]->add_on($v->add_on_name) == 1)
                      <a class="collapse-item" href="{{ $v->link }}"><i class="{{$v->fa_icon}}"></i> {{ $v->menu_name }}</a>
                    @endif
                  @endforeach
                  {{-- <a class="collapse-item" href="#"><i class="fas fa-chart-line"></i> Progress Report</a> --}}
                  {{-- <a class="collapse-item" href="#"><i class="fas fa-certificate"></i> Certificate Issuance</a> --}}
                </div>
              </div>
            </li>
          @endif
        
      
          @if($key == 0)
            <hr class="sidebar-divider">
          @endif
        @endif
      @endif
    @endforeach

    {{-- <li class="nav-item {{ (request()->is('/')) ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::to('/') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li> --}}
    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}
    
    <!-- Heading -->
    {{-- <div class="sidebar-heading">
      Interface
    </div>  --}}
    
    
    <!-- Heading -->
    {{-- <div class="sidebar-heading">
      Management
    </div> --}}
    <!-- Nav Item - Pages Collapse Menu -->
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>