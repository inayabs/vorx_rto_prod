@extends('layouts.admin')

@section('content')
    <div id="app">
        <unit-list></unit-list>
        {{-- <unit-create-update class="d-none"></unit-create-update> --}}
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection