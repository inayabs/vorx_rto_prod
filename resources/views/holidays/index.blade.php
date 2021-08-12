@extends('layouts.admin')
@section('title', 'Holidays')
@section('content')
    <div id="app">
        <holidays></holidays>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection