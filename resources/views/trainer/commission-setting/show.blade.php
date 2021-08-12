@extends('layouts.admin')
@section('title', 'Trainer Commission Settings')
@section('content')
    <div id="app">
        <commission-settings-detail></commission-settings-detail>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection