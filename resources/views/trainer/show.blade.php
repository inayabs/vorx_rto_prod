@extends('layouts.admin')
@section('title', 'Trainer Management')
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
    <div id="app">
        <trainer-detail></trainer-detail>
    </div>
          

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection