<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META SECTION -->
    <title>
        @yield('title', 'HR Management System')
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" href="{{asset('joli/favicon.ico')}}" type="image/x-icon"/>
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme"
          href="{{asset('bubbly/vendor/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('joli/css/bootstrap/bootstrap.min.css')}}"/>
    @yield('link')
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('joli/css/theme-default.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('joli/css/custom.css')}}"/>
@yield('style')
<!-- EOF CSS INCLUDE -->
</head>
<body>
<!-- START PAGE CONTAINER -->
<div class="page-container">
    <div id="loader" style="background: url({{asset('Load.gif')}}) 50% 50% no-repeat rgb(255, 255, 255);"></div>
    <!-- START PAGE SIDEBAR -->
@include('partial.joli.sidebar')
<!-- END PAGE SIDEBAR -->

    <!-- PAGE CONTENT -->
    <div class="page-content">
        <!-- START X-NAVIGATION VERTICAL -->
    @include('partial.joli.navigation')
    <!-- END X-NAVIGATION VERTICAL -->

        <!-- START BREADCRUMB -->
    @yield('breadcrumb')
    {{--        <ul class="breadcrumb">--}}

    {{--            <li><a href="#">Home</a></li>--}}
    {{--            <li class="active">Dashboard</li>--}}
    {{--        </ul>--}}
    <!-- END BREADCRUMB -->

        <!-- PAGE TITLE -->
        <div class="page-title">
            <h2>
                @yield('pageTitle')
            </h2>
        </div>
        <!-- END PAGE TITLE -->

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">

            @yield('content')

        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<!-- Start Modal -->
@yield('modal')
<!-- END Modal -->

<!-- START PRELOADS -->
<audio id="audio-alert" src="{{asset('joli/audio/alert.mp3')}}" preload="auto"></audio>
<audio id="audio-fail" src="{{asset('joli/audio/fail.mp3')}}" preload="auto"></audio>
<!-- END PRELOADS -->
<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="{{asset('joli/js/plugins/jquery/jquery.min.js')}}"></script>
<script>
    $(window).on('load', function () {
        $("#loader").fadeOut("fast");
    });
</script>
<script type="text/javascript" src="{{asset('joli/js/plugins/jquery/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('joli/js/plugins/bootstrap/bootstrap.min.js')}}"></script>
<!-- END PLUGINS -->

<!-- START THIS PAGE PLUGINS-->

<script type="text/javascript"
        src="{{asset('joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
@yield('script')
<!-- END THIS PAGE PLUGINS-->

<!-- START TEMPLATE -->
{{--Color Change Btn Start--}}
{{--<script type="text/javascript" src="{{asset('joli/js/settings.js')}}"></script>--}}
{{--Color Change Btn End--}}
<script type="text/javascript" src="{{asset('joli/js/plugins.js')}}"></script>
<script type="text/javascript" src="{{asset('joli/js/actions.js')}}"></script>
<!-- END TEMPLATE -->
{{--Custom Js--}}
<script type="text/javascript" src="{{asset('joli/js/custom.js')}}"></script>
{{--Custom Js End--}}
<!-- END SCRIPTS -->
</body>
</html>






