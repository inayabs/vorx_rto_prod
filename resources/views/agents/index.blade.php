@extends('layouts.admin')
@section('title', 'Agent Management')
@section('content')
    <!-- Page Heading -->
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Agent Management</h1>
    </div> --}}
    {{-- <style>
		@font-face {font-family: 'Europa-Regular';src: url('fonts/commission_payment_fonts/Europa-Regular.ttf')  format('truetype');  font-style: normal;font-weight: normal;}
        .europa-regular{font-family:'Europa-Regular'!important;}
        body {
            font-family: 'Europa-Regular';
        }
	</style> --}}

    <div id="app">
        <agent-list></agent-list>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection