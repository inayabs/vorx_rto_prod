@extends('layouts.admin')
@section('title', 'Trainer Commission Settings')
@section('content')
    <div id="app">
        <commission-settings-list></commission-settings-list>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection