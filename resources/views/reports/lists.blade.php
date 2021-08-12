@extends('layouts.admin')
@section('title', 'List Generator')
@section('content')
    <!-- Page Heading -->
    <div id="app">
        <list-generator></list-generator>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection