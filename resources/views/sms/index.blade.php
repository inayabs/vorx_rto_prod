@extends('layouts.admin')
@section('title', 'SMS CREATE')
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
            @if (strpos(request()->route()->getName() , 'create') !== false)
            <sms-create></sms-create>              
            @else
            <sms-list></sms-list>
            @endif
        </div>
    
@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection