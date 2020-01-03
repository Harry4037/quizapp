<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name') }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @isset($css)
        @foreach($css as $cs)
        <link href="{{ asset($cs) }}" rel="stylesheet">
        @endforeach
        @endisset


        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            var site_url = "{{ url('/admin') }}";
        </script>
        <script type="text/javascript">
            var _baseUrl = "{{ URL::to('/') }}";
        </script>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="overlay">
            <div id="loading-img"></div>
        </div>
        <div class="wrapper">
            <div class="main_container">
                @include('layout.admin.header')

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('style')

                    @yield('content')
                </div>
                <!-- /page content -->

                @include('layout.admin.footer')

            </div>

            <!-- jQuery 3 -->
            <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
            <!-- Bootstrap 3.3.7 -->
            <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
            <!-- FastClick -->
            <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
            <!-- AdminLTE App -->
            <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
            <!-- Sparkline -->
            <script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

            <!-- SlimScroll -->
            <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
            <!-- AdminLTE for demo purposes -->
            <!--<script src="{{ asset('dist/js/demo.js') }}"></script>-->
            <script src="{{ asset("js/jquery.validate.js") }}"></script>  
            <script src="{{ asset("js/additional.validate.js") }}"></script> 
            <script src="{{ asset("js/bootbox.min.js") }}"></script> 

            @isset($js)
            @foreach($js as $js)
            <script src="{{ asset($js) }}"></script>
            @endforeach
            @endisset

            @yield('script')

            <script>

            //setup CSRF token for ajax forms
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function showErrorMessage(msg) {
                $(".msg").addClass("alert-danger");
                $(".msg").html(msg);
                $(".msg").fadeIn();
                setTimeout(function () {
                    $(".msg").fadeOut();
                }, 3000);
            }

            function showSuccessMessage(msg) {
                $(".msg").addClass("alert-success");
                $(".msg").html(msg);
                $(".msg").fadeIn();
                setTimeout(function () {
                    $(".msg").fadeOut();
                }, 3000);
            }

            function deletePopup(title, message, record_id, url) {
                bootbox.confirm({
                    size: "small",
                    title: title,
                    message: "<i class=\"fa fa-exclamation-triangle\" style=\"color:red\"></i> " + message,
                    buttons: {
                        confirm: {
                            label: 'Confirm',
                            className: 'btn-danger',
                        },
                        cancel: {
                            label: 'No',
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $.ajax({
                                url: url,
                                type: 'post',
                                data: {id: record_id},
                                dataType: 'json',
                                beforeSend: function () {
                                    $(".overlay").show();
                                },
                                success: function (res) {
                                    if (res.status)
                                    {
                                        t.draw();
                                        $(".overlay").hide();
                                        showSuccessMessage(res.message);
                                    } else {
                                        $(".overlay").hide();
                                        showErrorMessage(res.message);
                                    }
                                }
                            });
                        }
                    }
                });

            }

            setTimeout(function () {
                $(".alert").fadeOut();
            }, 3000);
            </script>
    </body>
</html>