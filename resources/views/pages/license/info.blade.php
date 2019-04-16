@extends('adminlte::page')

@section('title', 'License Information')

@section('content_header')
    <h1>License Information</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('license') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>LICENSE PLAN :</label>
				<input type="text" name="url" value="{{ $file->url[3] }}" disabled class="form-control">
			</div>
			<div class="form-group">
				<label>LICENSE EXPIRATION :</label>
				<input type="text" name="url" value="{{ date('F d, Y h:i A',strtotime($file->url[2])) }}" disabled class="form-control">
			</div>
			<div class="form-group">
				<label>LICENSE URL :</label>
				<input type="text" name="url" value="{{ $_SERVER['SERVER_NAME'] }}" disabled class="form-control">
			</div>
			<div class="form-group">
				<label>LICENSE KEY :</label>
				{!! Form::text('license_key', env('LICENSE_KEY'), array('id' => 'license_key', 'class' => 'form-control', 'placeholder' => 'example : ****-****-***-***')) !!}
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