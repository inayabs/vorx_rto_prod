<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>VORX - Online payment</title>

  {{-- favicon --}}
  <link rel="icon" href="{{asset('/images/favicon.png') }}" type="image/x-icon"/>
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('/sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('sb-admin/css/sb-admin-2.css') }}" rel="stylesheet">

  <script src="https://js.stripe.com/v3/"></script>
  <style>
  body{height: 100vh;}
  .StripeElement{
    border-color: rgba(0, 0, 0, 0.5) ;
    display: block;
    width: 100%;
    height: calc(1.6em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
    font-weight: 400;
    line-height: 1.6;
    color: #6e707e;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .StripeElement--invalid {
    border-color: #fa755a;
    }
    #card-errors{
        color: #fa755a;
    }

    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
  </style>

</head>

<body class="background-{{$app_settings[0]->app_color}}">

  <div class="container mt-5 mb-5">

    <div id="appsearch">
        
    </div>

    <!-- Outer Row -->
    <div class="row justify-content-center h-100">

      <div class="col-xl-6 col-lg-6 col-md-6">

            <div id="app">
        

                <div class="card">
                    <online-payment-stripe/>
                </div>
            </div>

      </div>
    </div>

  </div>

  <!-- <script src='assets/app.js'></script> -->
</body>

</html>

@include ('layouts.php-js-vars')
