@extends('layouts.admin')
@section('title', 'Site Inspection Checklist List')
@section('content')
    <!-- Page Heading -->
    <div id="app">
        <site-inspection-checklist-list></site-inspection-checklist-list>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection