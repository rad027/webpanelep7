@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    <h1>Change Password</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<div class="row">
			{!! Form::open(array('route' => ['users.password.update', Auth::user()->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
				<div class="col-md-12">
					<div class="form-group {{ $errors->has('old_password') ? ' has-error ' : '' }}">
						<label>Current Password : </label>
						<input type="password" name="old_password" class="form-control" placeholder="Enter your Current Password.">
                        @if($errors->has('old_password'))
                        <span class="help-block">
                        	<strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                        @endif
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group {{ $errors->has('password') ? ' has-error ' : '' }}">
						<label>Current Password : </label>
						<input type="password" name="password" class="form-control" placeholder="Enter your New Password.">
                        @if($errors->has('password'))
                        <span class="help-block">
                        	<strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">
						<label>Current Password : </label>
						<input type="password" name="password_confirmation" class="form-control" placeholder="Re-Enter your New Password.">
                        @if($errors->has('password_confirmation'))
                        <span class="help-block">
                        	<strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
					</div>
				</div>
				<div class="col-md-12">
					<button class="btn btn-sm btn-success" type="submit">CHANGE PASSWORD</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop