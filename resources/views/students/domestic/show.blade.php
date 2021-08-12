@extends('layouts.admin')
@section('custom-css')
<style>
    .horizontal-line-wrapper{
        background-color: #355dce;
        padding: .5rem;
        color: #fff;
    }
    .horizontal-line-wrapper h6{
        margin-bottom: 0;
    }
    .row {
        padding: 1px;
    }
</style>
@endsection
@section('content')
    <!-- Page Heading -->
    <div id="app">
        <domestic-student  ref="studentbase" urole='{{\Auth::user()->roles->first()->name}}'></domestic-student>
    </div>

    

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection