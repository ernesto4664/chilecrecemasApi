<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        footer {
            background: #9D6BE1;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        header {
            background: #9D6BE1;
            color: white;
            text-align: center;
            padding: 1rem;
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0">
                @include('layouts.menu')
            </div>
            <div class="col-md-10">
                @yield('content')
            </div>
            
        </div>
    </div>

    @include('layouts.footer')
    <!-- Incluye jQuery desde un CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/js.js') }}"></script>
</body>
</html>
