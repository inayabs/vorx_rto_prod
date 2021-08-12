@extends('layouts.admin')
@section('title', 'Menus')
@section('content')
    <div id="app">
        <!-- <organisation-list></organisation-list> -->
        <menus/>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection