@extends('layouts.admin')

@section('content')
    <!-- Page Heading -->
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Course</h1>
    </div> --}}
    <div id="app">
        <course-list></course-list>
    </div>
          

@endsection

@section('custom-js')
    <script>
        
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('/sb-admin/js/demo/chart-area-demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('/sb-admin/js/demo/chart-pie-demo.js') }}"></script> --}}
@endsection