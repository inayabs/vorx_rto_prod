@extends('layouts.admin')
@section('title', 'Attendance List')
@section('content')
    <!-- Page Heading -->
    <div id="app">
        <attendance-list-generator></attendance-list-generator>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection