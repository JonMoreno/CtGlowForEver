<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>GlowForEver</title>

    <!-- Fonts -->
    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/transitions.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/welcome.css') }}" rel="stylesheet" type="text/css">

</head>

<body id="html-ready" style="display: none">

<!-- APP-DIV -->
<div id="app">

    <!-- FLEX-CENTER -->
    <div class="flex-center position-ref full-height">
        <!-- TOP-RIGHT LINKS -->
        <div class="top-right links">
        </div>

        <transition
            name="custom-classes-transition"
            enter-active-class="animated slideInDown"
        >
            <span v-if="render.welcome_page">

                <!-- CONTENT -->
                <div class="content">
                
                        <!-- Title -->
                        <div class="title">
                                Glow For Ever 
                            </div>
                        <!-- Sub-Title -->
                        <div class="sub-title"> 
                                Beauty Salon & Spa 
                        </div>

                    
                    <!-- Links -->           
                    <div class="links">
                            <br/>
                        @if (Route::has('login'))
                            @auth
                                <!-- Logged In -->
                                    <a href="{{ secure_url('/dashboard') }}" class="home-href d-block text-center">
                                        <i class="fa fa-power-off fa-4x" aria-hidden="true"></i>
                                    </a>
                            @else
                                    <!-- Log In -->
                                <a href="{{ secure_url('login') }}">
                                    <i class="fa fa-power-off fa-4x" aria-hidden="true"></i>
                                </a>
                            @endauth
                        @endif
                    </div>
                    </div><!--../CONTENT -->
            </span>
        </transition>

    </div><!--../FLEX-CENTER -->

</div>

<script src="{{ secure_asset('js/app.js') }}"></script>

</body>

</html>
