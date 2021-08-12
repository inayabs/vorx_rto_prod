@extends('layouts.admin')
@section('title', 'External Forms')
@section('content')
    <div id="app"><external-form-list /></div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection