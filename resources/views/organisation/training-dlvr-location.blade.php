@extends('layouts.admin')
@section('title', 'Training Delivery Location')
@section('content')
    <div id="app">
        <delivery-location></delivery-location>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection