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
            <p class="login-box-msg">FINAL TALLY</p>
            <ul>
            @if(is_array($dbresult))
            @foreach($dbresult as $db)
            <li>{!! nl2br($db) !!}</li>
            @endforeach
            @endif
            </ul>      
            <p class="login-box-msg" style="padding: 0px">ADMIN ACCOUNT CREDENTIAL</p>
            <p class="login-box-msg text-danger" style="font-size: 11px">(COPY/REMEMBER YOUR ADMIN CREDENTIAL)</p>
            <div class="form-group">
                <label>ADMIN USERNAME :</label>
                <input type="text" value="admin" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label>ADMIN PASSWORD :</label>
                <input type="text" value="password" class="form-control" disabled>
            </div>
            <p class="login-box-msg" style="padding: 0px">WEBSITE PANEL LICENSE</p>
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
            <button class="btn btn-success" type="submit">VALIDATE</button>
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
