@extends('layouts.admin')
@section('title', 'Training Organization')
@section('content')
    <div id="app">
        <organisation-create></organisation-create>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection