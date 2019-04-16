@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
    <style type="text/css">
    .full-height {
        height: 100vh;
    }
    .full-height2 {
      height: 30vh;
    }
    .full-height-footer {
      height: 10vh;
    }
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
    </style>
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="container maxWidth">
        <div class="flex-center position-ref full-height2">
        <center>
            <h1 class="text-white">
                <img src="{{ url('images/ran.logo.png') }}">
            </h1>
        </center>
        </div>
    </div>
    </div>
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        @if(Auth::guest())
                        <li>
                            <a href="{{ URL('register') }}">REGISTER</a>
                        </li>
                        @else
                        <li>
                            @if(Auth::user()->isUser())
                                @if(Auth::user()->cart()->count())
                                    @php
                                        $cartcount = 0;
                                    @endphp
                                    @foreach(Auth::user()->cart()->cursor() as $cart)
                                        @php
                                            $cartcount += $cart->quantity;
                                        @endphp
                                    @endforeach
                                @else
                                    @php
                                        $cartcount = 0;
                                    @endphp
                                @endif
                                <a href="{{ URL('cart') }}"><i class="fa fa-shopping-cart"></i> CART <span class="badge badge-primary cart-badge">{{ $cartcount }}</span></a>
                            @endif
                        </li>
                        <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                                <script type="text/javascript">
                                function validate(){
                                    if(confirm('Are you sure you want to logout?')){
                                        document.getElementById('logout-form').submit();
                                    }
                                    return false;
                                }
                                </script>
                                <a href="#"
                                   onclick="return validate()"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" onsubmit="return confirm('Are you sure you want to logout?')" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
                        @endif
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="@if (Auth::user()->profile()->count() && Auth::user()->profile()->first()->avatar_status == True) {{ Auth::user()->profile()->first()->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <a><i class="fa fa-circle text-success"></i> {{ Auth::user()->roles()->first()->name }}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <br><br><br>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            @include('partials.form-status')
            <section class="content">
                @yield('content')

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs"><b>Version</b> 1.0.0</div>
            <!-- Default to the left -->
            <strong>Copyright © 2018 - {{ date('Y') }} <a href="https://www.facebook.com/roldhan27">RAN PANEL BY Roldhan Dasalla</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
