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
            <p class="login-box-msg">Ran Shop DATABASE CONFIGURATION</p>
            @include('partials.form-status')
            <div class="callout callout-warning">
                <h4>WEB PANEL <b>RAN SHOP</b> CONFIGURATION</h4>
                <p>
                    <ul>
                        <li>EXAMPLE DATABASE NAME :</li>
                        <li><i>RanShop</i></li>
                    </ul>
                </p>
            </div>
            <form action="{{ URL('install/6') }}" method="POST">
                @csrf
                <div class="form-group {{ $errors->has('DB_HOST') ? 'has-error' : '' }}">
                    <label>DB HOST :</label>
                    <input type="text" name="DB_HOST" class="form-control" value="{{ $errors->has('DB_HOST') ? old('DB_HOST') : old('DB_HOST') }}" placeholder="example : 127.0.0.1">
                    @if ($errors->has('DB_HOST'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_HOST') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('DB_PORT') ? 'has-error' : '' }}">
                    <label>DB PORT :</label>
                    <input type="text" name="DB_PORT" class="form-control" value="{{ $errors->has('DB_PORT') ? old('DB_PORT') : old('DB_PORT') }}" placeholder="example : 1433">
                    @if ($errors->has('DB_PORT'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_PORT') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('DB_DATABASE') ? 'has-error' : '' }}">
                    <label>DB Name :</label>
                    <input type="text" name="DB_DATABASE" class="form-control" value="{{ $errors->has('DB_DATABASE') ? old('DB_DATABASE') : old('DB_DATABASE') }}" placeholder="example : webpanel_db">
                    @if ($errors->has('DB_DATABASE'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_DATABASE') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('DB_USERNAME') ? 'has-error' : '' }}">
                    <label>DB Username :</label>
                    <input type="text" name="DB_USERNAME" class="form-control" value="{{ $errors->has('DB_USERNAME') ? old('DB_USERNAME') : old('DB_USERNAME') }}" placeholder="example : root">
                    @if ($errors->has('DB_USERNAME'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_USERNAME') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('DB_PASSWORD') ? 'has-error' : '' }}">
                    <label>DB Password :</label>
                    <input type="text" name="DB_PASSWORD" class="form-control" value="{{ $errors->has('DB_PASSWORD') ? old('DB_PASSWORD') : old('DB_PASSWORD') }}" placeholder="example : 1234">
                    @if ($errors->has('DB_PASSWORD'))
                        <span class="help-block">
                            <strong>{{ $errors->first('DB_PASSWORD') }}</strong>
                        </span>
                    @endif
                </div>
                <a href="{{ URL('install/5') }}" class="btn btn-sm btn-danger">BACK</a>
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
