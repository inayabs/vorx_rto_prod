@extends('layouts.admin')
@section('title', 'Payment List')
@section('content')
    <!-- Page Heading -->
    <div id="app">
        <payment-list-generator></payment-list-generator>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection