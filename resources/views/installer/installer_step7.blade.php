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
            <p class="login-box-msg">MAIL CONFIGURATION</p>
            @include('partials.form-status')
            <form action="{{ URL('install/7') }}" method="POST">
                @csrf
                <div class="form-group {{ $errors->has('MAIL_DRIVER') ? 'has-error' : '' }}">
                    <label>MAIL DRIVER :</label>
                    <select name="MAIL_DRIVER" class="form-control">
                        <option value="">SELECT MAIL DRIVER</option>
                        <option value="mail">LOCAL</option>
                        <option value="smtp">SMTP</option>
                    </select>
                    @if ($errors->has('MAIL_DRIVER'))
                        <span class="help-block">
                            <strong>{{ $errors->first('MAIL_DRIVER') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('MAIL_HOST') ? 'has-error' : '' }}">
                    <label>MAIL HOST :</label>
                    <input type="text" name="MAIL_HOST" class="form-control" value="{{ $errors->has('MAIL_HOST') ? old('MAIL_HOST') : old('MAIL_HOST') }}" placeholder="example : mail.domain.com or smtp.google.com">
                    @if ($errors->has('MAIL_HOST'))
                        <span class="help-block">
                            <strong>{{ $errors->first('MAIL_HOST') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('MAIL_PORT') ? 'has-error' : '' }}">
                    <label>MAIL PORT :</label>
                    <input type="text" name="MAIL_PORT" class="form-control" value="{{ $errors->has('MAIL_PORT') ? old('MAIL_PORT') : old('MAIL_PORT') }}" placeholder="example : 587">
                    @if ($errors->has('MAIL_PORT'))
                        <span class="help-block">
                            <strong>{{ $errors->first('MAIL_PORT') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('MAIL_USERNAME') ? 'has-error' : '' }}">
                    <label>MAIL USERNAME :</label>
                    <input type="text" name="MAIL_USERNAME" class="form-control" value="{{ $errors->has('MAIL_USERNAME') ? old('MAIL_USERNAME') : old('MAIL_USERNAME') }}" placeholder="example : admin@domain.com">
                    @if ($errors->has('MAIL_USERNAME'))
                        <span class="help-block">
                            <strong>{{ $errors->first('MAIL_USERNAME') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('MAIL_PASSWORD') ? 'has-error' : '' }}">
                    <label>MAIL PASSWORD :</label>
                    <input type="password" name="MAIL_PASSWORD" class="form-control" value="{{ $errors->has('MAIL_PASSWORD') ? old('MAIL_PASSWORD') : old('MAIL_PASSWORD') }}" placeholder="Enter mail server password.">
                    @if ($errors->has('MAIL_PASSWORD'))
                        <span class="help-block">
                            <strong>{{ $errors->first('MAIL_PASSWORD') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('MAIL_ENCRYPTION') ? 'has-error' : '' }}">
                    <label>MAIL ENCRYPTION :</label>
                    <input type="text" name="MAIL_ENCRYPTION" class="form-control" value="{{ $errors->has('MAIL_ENCRYPTION') ? old('MAIL_ENCRYPTION') : old('MAIL_ENCRYPTION') }}" placeholder="example : tls or null">
                    @if ($errors->has('MAIL_ENCRYPTION'))
                        <span class="help-block">
                            <strong>{{ $errors->first('MAIL_ENCRYPTION') }}</strong>
                        </span>
                    @endif
                </div>
                <p class="login-box-msg">ADDITIONAL CONFIGURATION</p>
                <div class="form-group {{ $errors->has('MAIL_FROM_ADDRESS') ? 'has-error' : '' }}">
                    <label>MAIL FROM ADDRESS :</label>
                    <input type="text" name="MAIL_FROM_ADDRESS" class="form-control" value="{{ $errors->has('MAIL_FROM_ADDRESS') ? old('MAIL_FROM_ADDRESS') : old('MAIL_FROM_ADDRESS') }}" placeholder="example : no-reply@domain.com">
                    @if ($errors->has('MAIL_FROM_ADDRESS'))
                        <span class="help-block">
                            <strong>{{ $errors->first('MAIL_FROM_ADDRESS') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('MAIL_FROM_NAME') ? 'has-error' : '' }}">
                    <label>MAIL FROM NAME :</label>
                    <input type="text" name="MAIL_FROM_NAME" class="form-control" value="{{ $errors->has('MAIL_FROM_NAME') ? old('MAIL_FROM_NAME') : old('MAIL_FROM_NAME') }}" placeholder="example : Admin Email Title">
                    @if ($errors->has('MAIL_FROM_NAME'))
                        <span class="help-block">
                            <strong>{{ $errors->first('MAIL_FROM_NAME') }}</strong>
                        </span>
                    @endif
                </div>
                <a href="{{ URL('install/6') }}" class="btn btn-sm btn-danger">BACK</a>
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
