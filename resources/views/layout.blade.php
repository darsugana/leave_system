<!doctype html>
<html lang="en" data-token="{{ csrf_token() }}">
<head>
    <meta charset="UTF-8">
    <title>Project Leave</title>
    <!-- Default styles -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Additional styles -->
    @yield('css')
</head>
<body>

    <!-- Main content -->
    <div class="container">
        @include('components.menu')
        @yield('content')
    </div>

    <!-- Default scripts -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Additional scripts -->
    @yield('js')
</body>
</html>
