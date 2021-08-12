@extends('layouts.admin')
@section('title', 'Access Code')
@section('content')
    <!-- Page Heading -->
    <div id="app">
        <access-code></access-code>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection