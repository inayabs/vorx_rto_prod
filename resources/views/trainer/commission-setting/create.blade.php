@extends('layouts.admin')
@section('title', 'Trainer Commission Settings')
@section('content')
<div id="app">
    <commission-settings-create></commission-settings-create>
</div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection