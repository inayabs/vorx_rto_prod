@extends('layouts.admin')
@section('title', 'Trainer Management')
@section('content')
    <div id="app">
        <trainer-list></trainer-list>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection