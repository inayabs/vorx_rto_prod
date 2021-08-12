@extends('layouts.admin')

@section('content')
<div id="app">
    <course-package-info></course-package-info>
</div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection