@extends('layouts.admin')
@section('title', 'Offer Letter')
@section('content')
    <!-- Page Heading -->
    <div id="app">
        <offer-letter-list></offer-letter-list>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('/sb-admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('/sb-admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('/sb-admin/js/demo/chart-pie-demo.js') }}"></script> --}}
@endsection