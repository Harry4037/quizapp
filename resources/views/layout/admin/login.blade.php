<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset("img/fav.ico") }}" type="image/x-icon"/>
        <title>{{ config('app.name') }}</title>

        <!-- Bootstrap -->
        <link href="{{ asset("vendors/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset("vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{ asset("vendors/nprogress/nprogress.css") }}" rel="stylesheet">
        <!-- Animate.css -->
        <link href="{{ asset("vendors/animate.css/animate.min.css") }}" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="{{ asset("css/admin/custom.css") }}" rel="stylesheet">

        <script src="{{ asset("vendors/jquery/dist/jquery.min.js") }}"></script>
        <script src="{{ asset("vendors/bootstrap/dist/js/bootstrap.min.js") }}"></script>
        <script src="{{ asset("vendors/fastclick/lib/fastclick.js") }}"></script>
        <script src="{{ asset("vendors/nprogress/nprogress.js") }}"></script>
        <script src="{{ asset("vendors/bootstrap-progressbar/bootstrap-progressbar.min.js") }}"></script>
        <script src="{{ asset("vendors/iCheck/icheck.min.js") }}"></script>   
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>   
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                @yield('content')
            </div>
        </div>
    </body>
</html>
