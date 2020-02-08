<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Bad Tournament</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet" type="text/css">
        <style>
            @yield('style')
        </style>
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>

        <script src="/js/manifest.js"></script>
        <script src="/js/vendor.js"></script>
        <script src="/js/app.js"></script>
    </body>
</html>
