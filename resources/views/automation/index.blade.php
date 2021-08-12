@extends('layouts.admin')
@section('title', 'Automations')
@section('content')
    <div id="app">
        <!-- <organisation-list></organisation-list> -->
        <automation-details></automation-details>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection