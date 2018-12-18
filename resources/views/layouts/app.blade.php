<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('lang.web_name') }}</title>

    <!-- Bootstrap -->
    <link href="{{ URL::asset('/asset/new/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('/asset/new/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ URL::asset('/asset/new/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">

    <!-- bootstrap-daterangepicker -->
    <link href="{{ URL::asset('/asset/new/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Animate.css -->
    <link href="{{ URL::asset('/asset/new/css/animate.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('/asset/new/css/custom.min.css') }}" rel="stylesheet">

    <!-- old css -->
    <link href="{{ URL::asset('/asset/css/permissionTree.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/asset/css/jquery-confirm.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/asset/css/flatpickr.min.css') }}" rel="stylesheet">

    @yield('css')
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
        @if (Auth::check())
            @include('layouts.aside')
            @include('layouts.header')
            @include('layouts.loader')

            <!-- page content -->
            <div class="right_col" role="main">
                @yield('content')
            </div>
            <!-- /page content -->

            @include('layouts.footer')
        @endif

        <!-- jQuery -->
        <script src="{{ URL::asset('/asset/new/js/jquery.min.js') }}"></script>

        <script src="{{ URL::asset('asset/js/jquery-confirm.min.js') }}"></script>
        <script src="{{ URL::asset('asset/js/jquery.form.min.js') }}"></script>

        <!-- Bootstrap -->
        <script src="{{ URL::asset('/asset/new/js/bootstrap.min.js') }}"></script>
        <!-- bootstrap-progressbar -->
        <script src="{{ URL::asset('/asset/new/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>

        <!-- NProgress -->
        <script src="{{ URL::asset('/asset/new/js/nprogress.js') }}"></script>

        <!-- DateJS -->
        <script src="{{ URL::asset('asset/new/vendors/DateJS/build/date.js') }}"></script>

        <!-- bootstrap-daterangepicker -->
        <script src="{{ URL::asset('asset/new/vendors/moment/min/moment.min.js') }}"></script>
        <script src="{{ URL::asset('asset/new/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

        <!-- Custom Theme Scripts -->
        <script src="{{ URL::asset('/asset/new/js/custom.js') }}"></script>

        <!-- Validation -->
        <script src="{{ URL::asset('asset/js/validation.js') }}"></script>

        <script src="{{ URL::asset('asset/js/DateAndTime.js') }}"></script>
        <script src="{{ URL::asset('asset/js/flatpickr.js') }}"></script>

        <script src="{{ URL::asset('asset/new/js/ajax_loader.js') }}"></script>
        <script src="{{ URL::asset('asset/new/js/common.js') }}"></script>
        @yield('js')
        </div>
    </div>
@yield('footerjs')
</body>
</html>
