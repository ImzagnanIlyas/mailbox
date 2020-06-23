<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Authentification</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google fonts - Popppins for copy -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

    <!-- theme stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/layout/style.default.css') }}" id="theme-stylesheet">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/layout/custom.css') }}">
  </head>
  <body>
    <div class="page-holder d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center py-5">
          <div class="col-5 col-lg-7 mx-auto mb-5 mb-lg-0">
            <div class="pr-lg-5"><img src="{{ asset('img/illustration2.svg') }}" alt="" class="img-fluid"></div>
          </div>
          <div class="col-lg-5 px-lg-4">
            <h1 class="text-base text-primary text-uppercase mb-4">WEHELP</h1>
            <h3 class="mb-4">Bienvenu à votre boîte mail</h3>
            <!-- <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p> -->
            <form method="POST" action="{{ route('login') }}" id="loginForm" class="mt-4">
              @csrf
              <div class="form-group mb-4">
                <input type="email" id="email" name="email" placeholder="Adresse e-mail" class="form-control border-0 shadow form-control-lg @error('email') is-invalid @enderror"  required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group mb-4">
                <input type="password" id="password" name="password" placeholder="mot de passe" class="form-control border-0 shadow form-control-lg text-violet @error('password') is-invalid @enderror" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group mb-4">
                <div class="custom-control custom-checkbox">
                  <input name="remember" id="remember" type="checkbox" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                  <label for="remember" class="custom-control-label">Se souvenir de moi</label>

                </div>
              </div>
              <button type="submit" class="btn btn-primary shadow px-5">Connexion</button>
            </form>
          </div>
        </div>
        <!-- <p class="mt-5 mb-0 text-gray-400 text-center">Design by <a href="https://bootstrapious.com/admin-templates" class="external text-gray-400">Bootstrapious</a> & Your company</p> -->
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)                 -->
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script src="js/front.js"></script>
  </body>
</html>
