@extends('layouts.admin')
@section('title', 'Student Management')
@section('content')
    <!-- Page Heading -->
    <div id="app">
        {{-- {{  \Auth::user()->roles->first()->name }} --}}
        <student-list  urole='{{\Auth::user()->roles->first()->name}}'></student-list>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('/sb-admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('/sb-admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('/sb-admin/js/demo/chart-pie-demo.js') }}"></script> --}}
@endsection