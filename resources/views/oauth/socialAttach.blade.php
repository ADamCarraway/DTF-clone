<html>
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }}</title>
  <script>
    window.opener.postMessage({status: "{{$status}}", provider: "{{ $provider }}"}, "{{ url('/') }}")
    window.close()
  </script>
</head>
<body>
</body>
</html>
