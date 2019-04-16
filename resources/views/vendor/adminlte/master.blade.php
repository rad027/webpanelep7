<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
            @yield('title', config('adminlte.title', 'AdminLTE 2'))&nbsp;|&nbsp;
            {{ env('APP_NAME') }}&nbsp;
            @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ url('favicon.png') }}" />
    <!-- Tell the browser to be responsive to screen width -->
    @if(Auth::guest())
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    @endif
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style type="text/css">
        body{
            background: #000 url({{ url('images/bg.jpg')  }}) top center no-repeat!important;
            background-size : cover cover;
        }
        div.loading {
            width: 100%;
            height: 100vh;
            position: absolute;
            background: #222;
            z-index: 99999;
            top:0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        .loadinger {
            overflow: hidden;
            width: 100%;
            height: 100vh;
            position: relative;
        }
        .flex-center-page {
            height: 100vh;
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .wrapper,.content-wrapper {
            background: #3d3d3d!important;
            color: #fff;
        }
        .navbar {
            background: #4b4b4b!important;
        }
        .box {
            background: rgba(75, 75, 75,0.6)!important;
            color: #eee!important;
        }
        .box-header,.content-header, ul.nav-pills > li > a {
            color: #eee!important;
        }
        ul.nav-pills > li.active, ul.nav-pills > li:hover {
            background: rgba(247, 241, 227,1.0)!important;
        }
        ul.nav-pills > li.active > a, ul.nav-pills > li:hover > a {
            color: #222!important;
        }
        .main-footer {
            background: rgba(75, 75, 75,0.6)!important;
            color: #eee!important;
        }
        ul.list-group > li{
            background: rgba(170, 166, 157,1.0)!important;
            color: #eee!important;
            padding-left: 5px!important;
            padding-right: 5px!important;
        }
        ul.list-group > li > a{
            color: rgba(64, 64, 122,1.0)!important;
        }
        a.logo {
            background: rgba(75, 75, 75,0.8)!important;
        }
        .box-widget {
            color: #222!important;
        }
        .register-logo > a,.login-logo > a {
            color: #eee!important;
        }
    </style>
    <style type="text/css">
    .c1 {background:url(/images/classes/ran_lqhmej.gif) 0 0}
    .c64 {background:url(/images/classes/ran_lqhmej.gif) 0 -53px}
    .c2 {background:url(/images/classes/ran_lqhmej.gif) -57px 0}
    .c128 {background:url(/images/classes/ran_lqhmej.gif) -57px -53px}
    .c256 {background:url(/images/classes/ran_lqhmej.gif) -114px 0}
    .c4 {background:url(/images/classes/ran_lqhmej.gif) -114px -53px}
    .c512 {background:url(/images/classes/ran_lqhmej.gif) -171px 0}
    .c8 {background:url(/images/classes/ran_lqhmej.gif) -171px -53px}
    .c16 {background:url(/images/classes/ran_lqhmej.gif) -228px 1px}
    .c32 {background:url(/images/classes/ran_lqhmej.gif) -228px -53px}
    .c16 {background:url(/images/classes/ran_lqhmej.gif) -285px 1px}
    .c32 {background:url(/images/classes/ran_lqhmej.gif) -285px -53px}
    .c4096 {background:url(/images/classes/ran_lqhmej.gif) -342px 1px}
    .c8192 {background:url(/images/classes/ran_lqhmej.gif) -342px -53px}
    .c16384 {background:url(/images/classes/ran_lqhmej.gif) -228px -107px}
    .c32768 {background:url(/images/classes/ran_lqhmej.gif) -287px -107px}
    .icon {height:53px;width:53px;margin-top:4px;margin-right:4px;cursor: pointer;border: 1px solid #333;border-radius:4px;}
    tr:hover {
        opacity: 0.8;
    }
    </style>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    @endif

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css">
    @endif

@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="{{ url('js/Chart.min.js') }}"></script>
@endif

    @yield('adminlte_css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="loadinger hold-transition layout-boxed @yield('body_class')">
@yield('body')
<div class="loading flex-center-page">
    <img src="{{ url('images/loading.gif') }}">
    <div style="color:#fff">Please wait while its loading...</div>
</div>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endif

@if(config('adminlte.plugins.datatables'))
    <!-- DataTables with bootstrap 3 renderer -->
    <script src="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
@endif

@yield('adminlte_js')
<script type="text/javascript">
@if(\Request::route()->getName() != "ads")
    function adsblock_detected(){
        location.href="{{ url('ads_blocker_detected') }}";
    }   
@endif
window.onload=function(){
    $('div.loading').fadeOut(1000);
    setTimeout(function(){
        $('html,body').removeClass('loadinger');
    },1000);
};
window.onbeforeunload = function(){
    $("html, body").animate({ scrollTop: 0 }, "fast");
    $('html,body').addClass('loadinger');
    $('div.loading').fadeIn();
};
</script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" onerror="adsblock_detected()"></script>
@if(Auth::guest())
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
@endif
</body>
</html>
