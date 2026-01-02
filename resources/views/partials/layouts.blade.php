<?php

$hour = date('G');
$minute = date('i');
$second = date('s');
$msg = ' Today is ' . date('l, M. d, Y.');

if ($hour >= 0 && $hour <= 9) {
    $greet = 'Good Morning,';
} elseif ($hour >= 10 && $hour <= 11) {
    $greet = 'Good Day,';
} elseif ($hour >= 12 && $hour <= 15) {
    $greet = 'Good Afternoon,';
} else {
    $greet = 'Good Evening,';
}
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>GEKY MEDIA GHANA | STAFF</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('asset/apple-touch-icon.png') }}">
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ asset('asset/favicon-32x32.png') }}">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="{{ asset('asset/favicon-32x32.png') }}">
    <link rel="manifest" href="{{ asset('asset/site.webmanifest') }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{URL::to('assets/favicon.ico')}}">

    <link rel="icon" href="{{ asset('asset/favicon.png') }}" sizes="16x16" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" type="image/x-icon">
    <link rel="icon" href="GEKY MEDIA GHANA LOGO DESIGN.png" sizes="48x48" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('asset/style.css') }}" rel="stylesheet"> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="container">
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('dashboard') }}">
                        {{-- {{ config('app.name', 'Laravel') }} --}}
                        {{ Auth::user()->name }} Dashboard
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <!-- Add any additional links here -->
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

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

            <header class="bg-white shadow-sm py-3">
                <div class="container d-flex justify-content-between align-items-center">
                    <h4 class="page-title">{{ $greet }} {{ Auth::user()->name }}!</h4>
                    <h6 class="text-muted">{{ $msg }}</h6>
                </div>
            </header>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>

