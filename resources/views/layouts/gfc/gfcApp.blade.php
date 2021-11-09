<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{asset('images/logo.png')}}">

    <!-- Styles -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/DataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/Toast/build/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/jquery-confirm/dist/jquery-confirm.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Nunito';
            src: url( {{asset('fonts/Nunito-Regular.woff2')}}) format('woff2'),
            url({{asset('fonts/Nunito-Regular.woff')}}) format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{asset('fonts/Nunito-Light.woff2')}}) format('woff2'),
            url({{asset('fonts/Nunito-Light.woff')}}) format('woff');
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{asset('fonts/Nunito-Bold.woff2')}}) format('woff2'),
            url({{asset('fonts/Nunito-Bold.woff')}}) format('woff');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{asset('fonts/Nunito-SemiBold.woff2')}}) format('woff2'),
            url({{asset('fonts/Nunito-SemiBold.woff')}}) format('woff');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{asset('fonts/Nunito-Black.woff2')}}) format('woff2'),
            url({{asset('fonts/Nunito-Black.woff')}}) format('woff');
            font-weight: 900;
            font-style: normal;
            font-display: swap;
        }
        .preloader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-image: url({{asset('images/spin.gif')}});
            background-repeat: no-repeat;
            background-color: #FFF;
            background-position: center;
        }
    </style>
</head>
<body>
<div id="app" style="font-family: Nunito !important; font-size: 13px !important;">
    <div class="preloader"></div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" style="color: darkslateblue; font-size: 13px" >
                <img src="{{asset('images/logo.png')}}" width="50px" alt=""> {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @if(Auth::user())
                        <li class=""><a class="nav-link {{$page=='contracts'?'active':''}}" href="{{route('gfc.contracts')}}">Contracts<span class="fa fa-handshake"></span></a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" style="font-size: 13px !important;"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <a class="dropdown-item" href="{{route('legal.settings')}}" style="font-size: 13px !important;">My account</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
    <div class="container">
        <br><br>
        <footer class="footer fixed-bottom px-5" style="background: white; color: darkslateblue">
            <h6 class="blue-text" style=" border-top: solid 1px darkslateblue;">Copyright @ 2021</h6><br>
            <span></span>
        </footer>
    </div>
</div>

<script src="{{asset('vendor/jquery/jQuery.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('vendor/DataTables/datatables.min.js')}}"></script>
<script src="{{asset('vendor/jquery-confirm/dist/jquery-confirm.min.js')}}"></script>
<script src="{{asset('vendor/Toast/build/toastr.min.js')}}"></script>
<script src="{{asset('vendor/chartJS/dist/chart.min.js')}}"></script>

@if(session()->has('success-notification'))
    <script>
        $(document).ready(() => {
            toastr.info('{{session('success-notification')}}');
        })
    </script>
@elseif(session()->has('error-notification') || count($errors) != 0 )
    <script>
        $(document).ready(() => {
            toastr.error('{{(session()->has('error-notification'))? session('error-notification'):'An error occurred'}}');
        })
    </script>
@endif
<script>
    $(window).on('load', function () {
        $('.preloader').fadeOut('slow');
    });
</script>

{{--Auto logout JS--}}
<script>
    $(document).ready(function () {
        const timeout = 60000;  // 900000 ms = 15 minutes
        var idleTimer = null;
        $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
            clearTimeout(idleTimer);

            idleTimer = setTimeout(function () {
                alert('Session Expired, Please log in again');
                document.getElementById('logout-form').submit();
            }, timeout);
        });
        $("body").trigger("mousemove");
    });
</script>
@yield('scripts')
</body>
</html>
