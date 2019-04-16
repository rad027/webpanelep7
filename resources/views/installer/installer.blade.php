@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">INSTALLER by R.A.D</p>
            @include('partials.form-status')
            <form action="{{ URL('install') }}" method="POST">
                @csrf
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label>PANEL TITLE :</label>
                    <input type="text" name="title" class="form-control" value="{{ $errors->has('title') ? old('title') : env('PANEL_TITLE') }}" placeholder="Enter you panel title here.">
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('title_postfix') ? 'has-error' : '' }}">
                    <label>PANEL TITLE POSTFIX :</label>
                    <input type="text" name="title_postfix" class="form-control" value="{{ $errors->has('title_postfix') ? old('title_postfix') : env('PANEL_TITLE_POSTFIX') }}" placeholder="example : - Ran Web Panel">
                    @if ($errors->has('title_postfix'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title_postfix') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('panel_logo') ? 'has-error' : '' }}">
                    <label>PANEL LOGO :</label>
                    <input type="text" name="panel_logo" class="form-control" value="{{ $errors->has('panel_logo') ? old('panel_logo') : env('PANEL_LOGO') }}" placeholder="example : <b>iNew</b> Works">
                    @if ($errors->has('panel_logo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('panel_logo') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('panel_mini_logo') ? 'has-error' : '' }}">
                    <label>PANEL MINI LOGO :</label>
                    <input type="text" name="panel_mini_logo" class="form-control" value="{{ $errors->has('panel_mini_logo') ? old('panel_mini_logo') : env('PANEL_MINI_LOG') }}" placeholder="example : <b>i</b>NWs">
                    @if ($errors->has('panel_mini_logo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('panel_mini_logo') }}</strong>
                        </span>
                    @endif
                </div>
                <button class="btn btn-sm btn-success" type="submit" style="border-radius: 0px">NEXT</button>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
