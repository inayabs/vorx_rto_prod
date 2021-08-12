@extends('layouts.admin')
@section('title', 'USI Services')

@section('content')
        <div id="app">
        
        @hasrole('Demo')
        <div class="jumbotron jumbotron-fluid text-danger">
        <div class="container">
            <h4 class="display-5 danger"> <span class="text-danger"> Disclaimer </span> : This feature is available only if you have the following information:</h4>
            <ul>
                <li>Keystore</li>
                <li>Credential Username / Alias</li>
                <li>Credential Password</li>
                <li>Training Organisation Code</li>
                <li>Training Organisation Name</li>
            </ul>
        </div>
        </div>
        @endhasrole
        @if (strpos(request()->route()->getName() , 'verify') !== false)
        <usi-form :training_org="{{$app_settings[0]}}"></usi-form>
        @elseif(strpos(request()->route()->getName() , 'create') !== false)
        <create-usi-form :training_org="{{$app_settings[0]}}"></create-usi-form>
        @elseif(strpos(request()->route()->getName(),'personal') !==false)
        <update-personal-details-usi-form  :training_org="{{$app_settings[0]}}"></update-personal-details-usi-form>
         @elseif(strpos(request()->route()->getName(),'contact') !==false)
        <update-contact-details-usi-form  :training_org="{{$app_settings[0]}}"></update-contact-details-usi-form>
         @elseif(strpos(request()->route()->getName(),'locate') !==false)
         <locate-usi-form :training_org="{{$app_settings[0]}}"></locate-usi-form>
        @endif
        </div>
    
@endsection 

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection