<!doctype html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script async type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=BGaY6Byppq">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=BGaY6Byppq">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=BGaY6Byppq">
    <link rel="manifest" href="/site.webmanifest?v=BGaY6Byppq">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=BGaY6Byppq" color="#21b64c">
    <link rel="shortcut icon" href="/favicon.ico?v=BGaY6Byppq">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="theme-color" content="#f4f4f4">
    <title>@fallbackDefault($title, 'title')</title>
    @stack('scripts')
{{--    @env('local')--}}
{{--        <script>--}}
{{--            document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +--}}
{{--                ':35729/livereload.js?snipver=1"></' + 'script>')--}}
{{--        </script>--}}
{{--    @endenv--}}
</head>
<body class="font-primary">
    {{ $slot }}
    @stack('footer')
</body>
