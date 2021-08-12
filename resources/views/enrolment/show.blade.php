@extends('layouts.admin')
@section('title', 'Enrolment Application')
@section('content')
    <div id="app">
        <application-show ea="{{ $enrolment_application }}"  app_name="{{ config('app.name') }}"></application-show>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection