<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('/assets/images/favicon.png') }}">
    <!-- Pignose Calender -->
    <link href="{{ URL::asset('/assets/plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
    <!-- Custom Stylesheet -->
    <link href="{{ URL::asset('/assets/css/style.css') }}" rel="stylesheet">

</head>
<body>
   
    
            @yield('content')

    <script src="{{ URL::asset('/assets/plugins/common/common.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/custom.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/settings.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/gleek.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/styleSwitcher.js') }}"></script>

    <!-- Chartjs -->
    <script src="{{ URL::asset('/assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Circle progress -->
    <script src="{{ URL::asset('/assets/plugins/circle-progress/circle-progress.min.js') }}"></script>
    <!-- Datamap -->
    <script src="{{ URL::asset('/assets/plugins/d3v3/index.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/topojson/topojson.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/datamaps/datamaps.world.min.js') }}"></script>
    <!-- Morrisjs -->
    <script src="{{ URL::asset('/assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/morris/morris.min.js') }}"></script>
    <!-- Pignose Calender -->
    <script src="{{ URL::asset('/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
    <!-- ChartistJS -->
    <script src="{{ URL::asset('/assets/plugins/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>



    <script src="{{ URL::asset('/assets/js/dashboard/dashboard-1.js') }}"></script>
</body>
</html>
