<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <!-- CSRF Token -->
        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
        <script>document.documentElement.classList.remove("no-js");</script>

        <title>Gourmet Game</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta http-equiv="content-language" content="en">
        <meta name="creator" content="Robson Sousa">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A Laravel Restful API and VueJS project to guess the dish you are thinking. This systema learning new dishes with the use."/>
    </head>
    <body>  
        <div id="app">
        @yield('content')

        <nav class="nav-footer-content navbar navbar-light bg-white justify-content-center mt-4">
            <div class="">
                Gourmet Game
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Copyright © {{ date('Y') }}</div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </nav>
      </div>

    <noscript id="deferred-styles">
        <!-- Styles -->
        @if (config('app.env') == 'local')
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @else
            <link href="{{asset(mix('css/app.css'), true)}}" rel="stylesheet">
        @endif
    </noscript>
        <script>
            var loadDeferredStyles = function() {
                var addStylesNode = document.getElementById("deferred-styles");
                var replacement = document.createElement("div");
            
                replacement.innerHTML = addStylesNode.textContent;
                document.body.appendChild(replacement)
                addStylesNode.parentElement.removeChild(addStylesNode);
            };
            var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
            window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
          
            if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
            else window.addEventListener('load', loadDeferredStyles);
        </script>

        @if (config('app.env') == 'local')
            <script async src="{{ asset('js/app.js') }}"></script>
        @else
            <script async src="{{ asset(mix('js/app.js'), true) }}"></script>
        @endif
    </body>
</html>
