@extends('adminlte::page')

@section('title', 'Mail Configuration')

@section('content_header')
    <h1>Mail Configuration</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ URL('web/mail') }}" method="POST">
			@csrf
			<div class="form-group {{ $errors->has('MAIL_DRIVER') ? 'has-error' : '' }}">
				<label>MAIL DRIVER :</label>
				{!!Form::select('MAIL_DRIVER', ['mail' => 'mail','smtp' => 'smtp'], env('MAIL_DRIVER'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group {{ $errors->has('MAIL_HOST') ? 'has-error' : '' }}">
				<label>MAIL HOST :</label>
				{!! Form::text('MAIL_HOST', env('MAIL_HOST'), array('id' => 'MAIL_HOST', 'class' => 'form-control', 'placeholder' => 'example : smtp.google.com or mail.domain.com')) !!}
			</div>
			<div class="form-group {{ $errors->has('MAIL_PORT') ? 'has-error' : '' }}">
				<label>MAIL PORT :</label>
				{!! Form::text('MAIL_PORT', env('MAIL_PORT'), array('id' => 'MAIL_PORT', 'class' => 'form-control', 'placeholder' => 'example : 587')) !!}
			</div>
			<div class="form-group {{ $errors->has('MAIL_USERNAME') ? 'has-error' : '' }}">
				<label>MAIL USERNAME :</label>
				{!! Form::text('MAIL_USERNAME', env('MAIL_USERNAME'), array('id' => 'MAIL_USERNAME', 'class' => 'form-control', 'placeholder' => 'example : admin@domain.com')) !!}
			</div>
			<div class="form-group {{ $errors->has('MAIL_PASSWORD') ? 'has-error' : '' }}">
				<label>MAIL PASSWORD :</label>
				{!! Form::text('MAIL_PASSWORD', env('MAIL_PASSWORD'), array('id' => 'MAIL_PASSWORD', 'class' => 'form-control', 'placeholder' => 'example : 1234')) !!}
			</div>
			<div class="form-group {{ $errors->has('MAIL_ENCRYPTION') ? 'has-error' : '' }}">
				<label>MAIL ENCRYPTION :</label>
				{!! Form::text('MAIL_ENCRYPTION', env('MAIL_ENCRYPTION'), array('id' => 'MAIL_ENCRYPTION', 'class' => 'form-control', 'placeholder' => 'example : tls or null')) !!}
			</div>
			<div class="form-group {{ $errors->has('MAIL_FROM_ADDRESS') ? 'has-error' : '' }}">
				<label>MAIL FROM ADDRESS :</label>
				{!! Form::text('MAIL_FROM_ADDRESS', env('MAIL_FROM_ADDRESS'), array('id' => 'MAIL_FROM_ADDRESS', 'class' => 'form-control', 'placeholder' => 'example : no-reply@domain.com')) !!}
			</div>
			<div class="form-group {{ $errors->has('MAIL_FROM_NAME') ? 'has-error' : '' }}">
				<label>MAIL FROM NAME :</label>
				{!! Form::text('MAIL_FROM_NAME', env('MAIL_FROM_NAME'), array('id' => 'MAIL_FROM_NAME', 'class' => 'form-control', 'placeholder' => 'example : iNew Works Ran Panel')) !!}
			</div>
			<button class="btn btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop