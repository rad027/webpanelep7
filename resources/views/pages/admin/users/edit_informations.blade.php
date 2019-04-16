@extends('adminlte::page')

@section('title', 'Edit User ['.$user->name.']`s Account Informations')

@section('content_header')
    <h1>Edit User [{{ $user->name }}]`s Account Informations</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('game/users/'.$user->id.'/informations') }}" method="POST">
			@csrf
			<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
				<label>First Name :</label>
				{!! Form::text('first_name', $user->first_name, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => 'example : Roldhan')) !!}
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
			</div>
			<div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
				<label>Last Name :</label>
				{!! Form::text('last_name', $user->last_name, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => 'example : Dasalla')) !!}
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
			</div>
			<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
				<label>Email Address :</label>
				{!! Form::text('email', $user->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'example : roldhandasalla27@gmail.com')) !!}
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
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