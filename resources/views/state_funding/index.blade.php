@extends('layouts.admin')
@section('title', 'State Funding')
@section('content')
    <div id="app">
    @if (strpos(request()->route()->getName() , 'funding_type.index') !== false)
    <funding-type :states="{{ $states }}" :fstates="{{ $fstates }}" :fnational="{{ $fnational }}" :sf="{{ $sf }}"></funding-type>
    @else
    <state-funding :states="{{ $states }}"></state-funding>
    @endif
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection