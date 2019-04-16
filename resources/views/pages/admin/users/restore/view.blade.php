@extends('adminlte::page')

@section('title', 'Restoring User ['.$user->UserName.']')

@section('content_header')
    <h1>Restoring User [{{ $user->UserName }}]</h1>
@stop

@php
$faker = Faker\Factory::create();
@endphp

@section('content')
<div class="box">
	<div class="box-body">
		<form method="post">
			@csrf
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('name2') ? 'has-error' : '' }}">
                    <input type="text" name="name2" class="form-control" value="{{ $user->UserName }}"
                           placeholder="Enter username.">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name2'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name2') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password2') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <input type="text" name="password2" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" onclick="return generate_password(10)">GENERATE PASSWORD</button>
                        </span>
                    </div>
                    @if ($errors->has('password2'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password2') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <input type="text" name="first_name" class="form-control" value="{{ $user->UserName }}"
                           placeholder="Enter First Name.">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <input type="text" name="last_name" class="form-control" value="{{ 'ZGxOV' }}"
                           placeholder="Enter Last Name.">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label>EMAIL : (<span class="text-danger">YOU SHOULD CHANGE IT INTO VALID EMAIL SO THE USER CAN RECEIVE AN EMAIL CONTAINING USER CREDENTIALS.</span>)</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->UserEmail }}"
                           placeholder="Enter Valid email.">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('pin') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <input type="number" name="pin" class="form-control" value="{{ old('pin') }}"
                           placeholder="Enter PIN. eg : 1234">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" onclick="return generate_pin(4)">GENERATE PIN</button>
                        </span>
                    </div>
                    @if ($errors->has('pin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('pin') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('secret_question') ? 'has-error' : '' }}">
                	@php
                	$sq = [
                		'1' => 'What is the first name of favorite uncle?',
                		'2' => 'Where did you meet spouse?',
                		'3' => 'What is oldest cousin&#39;s name?',
                		'4' => 'What is youngest child&#39;s nickname?',
                		'5' => 'What is oldest child&#39;s nickname?',
                		'6' => 'What is the first name of oldest niece?',
                		'7' => 'What is the first name of oldest nephew?',
                		'8' => 'What is the first name of favorite aunt?',
                		'9' => 'Where did you spend honeymoon?'
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
                    <input type="text" name="secret_answer" class="form-control" value="{{ $faker->firstName }}"
                           placeholder="Enter Secret Answer.">
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
                <a href="{{ url('game/users/restore') }}" class="btn btn-flat btn-danger">CANCEL</a>
                <button type="submit"
                        class="btn btn-primary btn-flat"
                >RESTORE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
function generating_string(sizes) {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < sizes; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}
function generate_password(sizes){
    var pass = generating_string(sizes);
    $('input[name="password2"]').val(pass);
}
function generate_pin(sizes){
  var text = "";
  var possible = "0123456789";

  for (var i = 0; i < sizes; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

    $('input[name="pin"]').val(text);
}
</script>
@stop