@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">WE HAVE DETECTED AN ADS BLOCKER TO YOUR BROWSER, PLEASE DISABLE IT AND CLICK "BACK HOME" TO CONTINUE.</p>
            <a href="{{ url()->previous() }}" class="btn btn-flat btn-block btn-danger">BACK HOME</a>
        </div>
    </div>
@stop

@section('adminlte_js')
    @yield('js')
@stop
