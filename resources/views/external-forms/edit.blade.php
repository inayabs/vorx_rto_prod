@extends('layouts.admin')

@section('content')
    <div id="app"><external-form-edit></external-form-edit></div>
@endsection

@section('custom-js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection