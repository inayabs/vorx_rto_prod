@extends('layouts.admin')

@section('content')
    <!-- Page Heading -->
    <div id="app">
        <time-table></time-table>
    </div>
          

@endsection

@section('custom-js')
    <script>
        
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
@endsection