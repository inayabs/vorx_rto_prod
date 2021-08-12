@extends('layouts.admin')

@section('content')
<div id="app"><email-sending-details></email-sending-details></div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection