@extends('adminlte::page')

@section('title', 'Web Informations')

@section('content_header')
    <h1>Web Informations</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ URL('web/informations') }}" method="POST">
			@csrf
			<h3>APP INFORMATIONS</h3>
			<div class="form-group">
				<label>APP TITLE : <span class="text-danger">(WARNING : IF YOU CHANGED THIS, YOU WILL BE LOGGED OUT AUTOMATICALLY)</span></label>
				{!! Form::text('APP_NAME', env('APP_NAME'), array('id' => 'APP_NAME', 'class' => 'form-control', 'placeholder' => 'example : iNew Works')) !!}
			</div>
			<div class="form-group">
				<label>APP URL :</label>
				{!! Form::text('APP_URL', env('APP_URL'), array('id' => 'APP_URL', 'class' => 'form-control', 'placeholder' => 'example : https://domain.com')) !!}
			</div>
			<div class="form-group">
				<label>APP DEBUG :</label>
				{!!Form::select('APP_DEBUG', ['true','false'], env('APP_DEBUG'), ['class' => 'form-control'])!!}
			</div>
			<h3>PANEL INFORMATIONS</h3>
			<div class="form-group">
				<label>PANEL TITLE :</label>
				{!! Form::text('PANEL_TITLE', env('PANEL_TITLE'), array('id' => 'PANEL_TITLE', 'class' => 'form-control', 'placeholder' => 'example : iNew Works Ran Panel')) !!}
			</div>
			<div class="form-group">
				<label>PANEL POSTFIX TITLE :</label>
				{!! Form::text('PANEL_TITLE_POSTFIX', env('PANEL_TITLE_POSTFIX'), array('id' => 'PANEL_TITLE_POSTFIX', 'class' => 'form-control', 'placeholder' => 'example : - Ran Panel')) !!}
			</div>
			<div class="form-group">
				<label>PANEL LOGO :</label>
				{!! Form::text('PANEL_LOGO', env('PANEL_LOGO'), array('id' => 'PANEL_LOGO', 'class' => 'form-control', 'placeholder' => 'example : <b>Over</b> Lord')) !!}
			</div>
			<div class="form-group">
				<label>PANEL MINI LOGO :</label>
				{!! Form::text('PANEL_MINI_LOGO', env('PANEL_MINI_LOGO'), array('id' => 'PANEL_MINI_LOGO', 'class' => 'form-control', 'placeholder' => 'example : <b>OL</b>Ran')) !!}
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