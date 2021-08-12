@extends('layouts.admin')
@section('title', 'Trainer Classes')
@section('content')
    <div id="app">
        <tportal-classes/>
    </div>
@endsection 

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/sb-admin/vendor/chart.js/Chart.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('/sb-admin/js/demo/chart-area-demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('/sb-admin/js/demo/chart-pie-demo.js') }}"></script> --}}
@endsection