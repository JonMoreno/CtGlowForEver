<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'GlowForEver') }}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/transitions.css') }}" rel="stylesheet">
        
        <!-- CUSTOM STYLE FILES -->
        @yield('custom-style')

    </head>

<body class="bg-light-secondary" id="html-ready" style="display: none">

    <!-- APP -->
    <div id="app">

        @yield('content')

    </div><!--../APP-DIV -->

<script src="{{ asset('js/app.js') }}"></script>

<!-- CUSTOM JS FILES -->
@yield('custom-js')

</body>
</html>