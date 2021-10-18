<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="{{ asset('js/nav.js') }}" defer></script>
  <script src="{{ asset('js/toast5.js') }}"></script>
  <script src="{{ asset('js/rate.js') }}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark')
  <link href="{{ asset('css/dark.css') }}" rel="stylesheet">
  @endif
  <link href="{{ asset('css/rate.css') }}" rel="stylesheet">
  <link href="{{ asset('css/toast.css') }}" rel="stylesheet">


    <!-- PWA  -->
    <meta name="theme-color" content="#6F899FFF"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    {{--Favicon--}}
  <link rel="shortcut icon" href="{{ URL::asset('image/favicon.ico') }}" type="image/x-icon" />
    @livewireStyles
</head>

<body>
@livewireScripts
  <div id="app">
    @include('layouts.partials.navbar')
    @include('layouts.partials.flash')

    <main class="pb-3">
      @yield('content')
    </main>
  </div>
  @stack('scripts')

<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>
</body>

</html>
