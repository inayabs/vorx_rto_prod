<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>VORX - LLN Test </title>

  {{-- favicon --}}
  <link rel="icon" href="{{asset('/images/favicon.png') }}" type="image/x-icon"/>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('/sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('sb-admin/css/sb-admin-2.css') }}" rel="stylesheet">
  <!-- pdf custom styles -->
  <!-- <link type="text/css" href="{{public_path()}}/enrolment-pack-pdf/pdf-style.css" rel="stylesheet" /> -->
  <link type="text/css" href="{{ asset('cea-lln-test-form/pdf-style.css') }}" rel="stylesheet" />
  <style>
  body{height: 100vh;}
  </style>

</head>

<body class="background-{{$app_settings[0]->app_color}}">

  <div class="container mt-5 mb-5">

    <div id="appsearch">
        
    </div>

    <!-- Outer Row -->
    <div class="row justify-content-center h-100">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div id="app">
            <lln-test-pca></lln-test-pca>
        </div>

      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('/sb-admin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('/sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('/sb-admin/js/sb-admin-2.min.js') }}"></script>
  
  @include ('layouts.php-js-vars')

  <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
