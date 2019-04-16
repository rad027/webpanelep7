@extends('adminlte::page')

@section('title', 'Edit User ['.$user->name.']`s Account Password')

@section('content_header')
    <h1>Edit User [{{ $user->name }}]`s Account Password</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('game/users/'.$user->id.'/password') }}" method="POST">
			@csrf
			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label>New Password :</label>
				{!! Form::password('password',  array('id' => 'password', 'class' => 'form-control', 'placeholder' => 'Enter new password.')) !!}
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
			</div>
			<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
				<label>Confirm New Password :</label>
				{!! Form::password('password_confirmation',  array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => 'Confirm new password.')) !!}
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
			</div>
			<a href="{{ url('game/users') }}" class="btn btn-sm btn-danger">BACK</a>
			<button class="btn btn-sm btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop