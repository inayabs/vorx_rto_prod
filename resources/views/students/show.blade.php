@extends('layouts.admin')
@section('custom-css')
<style>
    .horizontal-line-wrapper{
        background-color: #355dce;
        padding: .5rem;
        color: #fff;
    }
    .horizontal-line-wrapper h6{
        margin-bottom: 0;
    }
    .row {
        padding: 1px;
    }
</style>
@endsection
@section('content')
    <!-- Page Heading -->
    <div id="app">
      
        <student-details ref='{{\Auth::user()->roles->first()->name}}'></student-details>
    </div>

    

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('/sb-admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('/sb-admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('/sb-admin/js/demo/chart-pie-demo.js') }}"></script> --}}
@endsection