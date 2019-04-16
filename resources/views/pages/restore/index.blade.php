@extends('adminlte::page')

@section('title', 'Restore Account Form')

@section('content_header')
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">LOGIN :</h3>
            </div>
            <div class="box-body">
                <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                    {!! csrf_field() !!}

                    <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                               placeholder="Enter your username.">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password" class="form-control"
                               placeholder="{{ trans('adminlte::adminlte.password') }}">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <button type="submit"
                                    class="btn btn-primary btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                        </div>
                        <!-- /.col -->
                        <div class="auth-links col-md-12">
                            <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"
                               class="text-center"
                            >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>
                            <br>
                            @if (config('adminlte.register_url', 'register'))
                                <a href="{{ url(config('adminlte.register_url', 'register')) }}"
                                   class="text-center"
                                >{{ trans('adminlte::adminlte.register_a_new_membership') }}</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Restore Account Form</h3>
            </div>
            <div class="box-body">
            	<form action="{{ url('restore/account') }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('name2') ? 'has-error' : '' }}">
                    <input type="text" name="name2" class="form-control" value="{{ old('name2') }}"
                           placeholder="Enter your username.">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name2'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name2') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password2') ? 'has-error' : '' }}">
                    <input type="password" name="password2" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password2'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password2') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}"
                           placeholder="Enter your First Name.">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}"
                           placeholder="Enter your Last Name.">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="Enter your email.">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('pin') ? 'has-error' : '' }}">
                    <input type="number" name="pin" class="form-control" value="{{ old('pin') }}"
                           placeholder="Enter your PIN. eg : 1234">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('pin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('pin') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('secret_question') ? 'has-error' : '' }}">
                	@php
                	$sq = [
                		'1' => 'What is the first name of your favorite uncle?',
                		'2' => 'Where did you meet your spouse?',
                		'3' => 'What is your oldest cousin&#39;s name?',
                		'4' => 'What is your youngest child&#39;s nickname?',
                		'5' => 'What is your oldest child&#39;s nickname?',
                		'6' => 'What is the first name of your oldest niece?',
                		'7' => 'What is the first name of your oldest nephew?',
                		'8' => 'What is the first name of your favorite aunt?',
                		'9' => 'Where did you spend your honeymoon?'
                	];
                	@endphp
                	{!!Form::select('secret_question', $sq, old('secret_question'), ['class' => 'form-control'])!!}
                    @if ($errors->has('secret_question'))
                        <span class="help-block">
                            <strong>{{ $errors->first('secret_question') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('secret_answer') ? 'has-error' : '' }}">
                    <input type="text" name="secret_answer" class="form-control" value="{{ old('secret_answer') }}"
                           placeholder="Enter your Secret Answer.">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('secret_answer'))
                        <span class="help-block">
                            <strong>{{ $errors->first('secret_answer') }}</strong>
                        </span>
                    @endif
                </div>
                @if(config('settings.reCaptchStatus'))
                    <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                @endif
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >RESTORE</button>
            	</form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
@stop

@section('js')
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
    @if(config('settings.reCaptchStatus'))
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
@stop