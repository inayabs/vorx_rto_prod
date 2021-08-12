@extends('layouts.admin')

@section('content')
    <div id="app">
        <course-package></course-package>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection