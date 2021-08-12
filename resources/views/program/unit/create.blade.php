@extends('layouts.admin')

@section('content')
<div id="app">
    <unit-create></unit-create>
</div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection