@extends('layouts.admin')
@section('title', 'Representative Agent List')
@section('content')
    <!-- Page Heading -->
    <div id="app">
    <representative-agent-list></representative-agent-list>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection