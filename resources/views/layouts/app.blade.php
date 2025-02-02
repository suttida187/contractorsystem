<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ContractorSystem</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ URL::asset('/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ URL::asset('/assets/js/plugin/webfont/webfont.min.js') }}"></script>


    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/demo.css') }}" />

</head>

<body>

    @guest {{-- ยังไม่ได้ login --}}
        @yield('content')
    @else
        {{-- login แล้ว --}}
        <div class="wrapper">
            @include('layouts.sidebar')
            <div class="main-panel">
                @include('layouts.navbar')
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
    @endguest


    <script src="{{ URL::asset('/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ URL::asset('/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ URL::asset('/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ URL::asset('/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ URL::asset('/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ URL::asset('/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ URL::asset('/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ URL::asset('/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ URL::asset('/assets/js/kaiadmin.min.js') }}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ URL::asset('/assets/js/setting-demo.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/demo.js') }}"></script>

</body>

</html>
