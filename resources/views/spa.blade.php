@php
  $config = [
      'appName' => config('app.name'),
      'locale' => $locale = app()->getLocale(),
      'locales' => config('app.locales'),
      'categories' => $categories ?? [],
  ];
@endphp
  <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>

  <title>{{ config('app.name') }}</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,700&amp;subset=cyrillic,cyrillic-ext,latin-ext">
  <!-- import CSS -->
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
  <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

<div id="app"></div>

{{-- Global configuration object --}}
<script>
  window.config = @json($config);
</script>

{{-- Load the application scripts --}}
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
<script src="{{ mix('dist/js/app.js') }}"></script>
</body>
</html>
