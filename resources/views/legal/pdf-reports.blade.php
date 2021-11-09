<?php $page = '' ?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{public_path('images/logo.png')}}">

    <!-- Styles -->
    <link href="{{ public_path('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ public_path('vendor/DataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ public_path('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ public_path('vendor/Toast/build/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ public_path('vendor/jquery-confirm/dist/jquery-confirm.min.css') }}" rel="stylesheet">
{{--    <link href="{{ public_path('vendor/fontawesome/css/all.css') }}" rel="stylesheet">--}}
    <link href="{{ public_path('css/app.css') }}" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Nunito';
            src: url( {{public_path('fonts/Nunito-Regular.woff2')}}) format('woff2'),
            url({{public_path('fonts/Nunito-Regular.woff')}}) format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{public_path('fonts/Nunito-Light.woff2')}}) format('woff2'),
            url({{public_path('fonts/Nunito-Light.woff')}}) format('woff');
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{public_path('fonts/Nunito-Bold.woff2')}}) format('woff2'),
            url({{public_path('fonts/Nunito-Bold.woff')}}) format('woff');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{public_path('fonts/Nunito-SemiBold.woff2')}}) format('woff2'),
            url({{public_path('fonts/Nunito-SemiBold.woff')}}) format('woff');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{public_path('fonts/Nunito-Black.woff2')}}) format('woff2'),
            url({{public_path('fonts/Nunito-Black.woff')}}) format('woff');
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
            background-image: url({{public_path('images/spin.gif')}});
            background-repeat: no-repeat;
            background-color: #FFF;
            background-position: center;
        }
    </style>
</head>
<body>
<div id="app" style="font-family: Nunito !important; font-size: 13px !important;">

    <main class="py-4">
        <div class="container-fluid wrapper py-3 px-4">
            <div class="text-center">
                <img src="{{public_path('images/logo.PNG')}}" alt="Logo">
            </div>
            <hr class="blue-line">
            <div class="mt-4">
                <h5 class="text-center font-weight-bold" style="text-decoration: underline"> <span class="fa fa-tags"></span> Contracts Expiring in: {{date('F-Y')}}</h5>
                <div class="table-responsive-md">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>Company</th>
                            <th>Title</th>
                            <th>Created</th>
                            <th>Expires On</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expiringContracts as $contract)
                            <tr>
                                <td>{{$contract->company}}</td>
                                <td>{{$contract->title}}</td>
                                <td>{{$contract->start_date}}</td>
                                <td>{{$contract->expiry_date}}</td>
                                <td>{{$contract->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <div class="container">
        <br><br>
        <footer class="footer fixed-bottom px-5" style="background: white; color: darkslateblue">
            <h6 class="blue-text" style=" border-top: solid 1px darkslateblue;">Copyright @ 2021</h6><br>
            <span></span>
        </footer>
    </div>
</div>

<script src="{{public_path('vendor/jquery/jQuery.js')}}"></script>
<script src="{{public_path('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{public_path('vendor/select2/dist/js/select2.min.js')}}"></script>
<script src="{{public_path('vendor/DataTables/datatables.min.js')}}"></script>
<script src="{{public_path('vendor/jquery-confirm/dist/jquery-confirm.min.js')}}"></script>
<script src="{{public_path('vendor/Toast/build/toastr.min.js')}}"></script>
<script src="{{public_path('vendor/chartJS/dist/chart.min.js')}}"></script>
</body>
</html>
