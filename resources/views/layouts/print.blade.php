<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>WHAREHOUSE SYSTEM</title>

    <link rel="stylesheet" href="{{ asset('css') }}/print.css?v={{ env('CSS_VERSION') }}">
    @stack('page-css')
</head>

<body>
    <div class="invoice-box">
        @yield('content')
    </div>
    @yield('page-js')
</body>

</html>
