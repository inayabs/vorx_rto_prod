@extends('layouts.admin')
@section('title', 'Payment List')
@section('content')
    <!-- Page Heading -->
    <div id="app">
        <student-payments></student-payments>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection