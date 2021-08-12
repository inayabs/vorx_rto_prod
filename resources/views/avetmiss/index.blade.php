@extends('layouts.admin')
@section('title', 'Avetmiss')
@section('content')
    <div id="app">
        <avetmiss></avetmiss>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection