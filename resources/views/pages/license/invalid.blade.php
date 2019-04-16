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
        <div class="login-box-body">
            <p class="login-box-msg">YOUR LICENSE IS INVALID</p>
            @include('partials.form-status')
            <form action="{{ url('install/license') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>URL :</label>
                    <input type="text" name="license_url" disabled value="{{ $_SERVER['SERVER_NAME'] }}" class="form-control">
                </div>
                <div class="form-group {{ $errors->has('license_key') ? 'has-error' : '' }}">
                    <label>LICENSE KEY :</label>
                    <input type="text" name="license_key" class="form-control" value="{{ old('license_key') }}" placeholder="****-****-***-****">
                    @if ($errors->has('license_key'))
                        <span class="help-block">
                            <strong>{{ $errors->first('license_key') }}</strong>
                        </span>
                    @endif
                </div>
            <a href="{{ url()->previous() }}" class="btn btn-danger">BACK HOME</a>
            <button class="btn btn-success" type="submit">VALIDATE</button>
            </form>
        </div>
    </div>
@stop

@section('adminlte_js')
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
    @yield('js')
@stop
