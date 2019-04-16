@extends('adminlte::page')

@section('title', 'Meta Description')

@section('content_header')
    <h1>Meta Description</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ URL('web/meta') }}" method="POST">
			@csrf
			<div class="form-group {{ $errors->has('OG_URL') ? 'has-error' : '' }}">
				<label>URL* :</label>
				{!! Form::url('OG_URL', env('OG_URL'), array('id' => 'OG_URL', 'class' => 'form-control', 'placeholder' => 'example : https://domain.com')) !!}
			</div>
			<div class="form-group {{ $errors->has('OG_TITLE') ? 'has-error' : '' }}">
				<label>TITLE* :</label>
				{!! Form::text('OG_TITLE', env('OG_TITLE'), array('id' => 'OG_TITLE', 'class' => 'form-control', 'placeholder' => 'example : iNew Works Ran Panel')) !!}
			</div>
			<div class="form-group {{ $errors->has('OG_IMAGE') ? 'has-error' : '' }}">
				<label>IMAGE LINK* :</label>
				{!! Form::url('OG_IMAGE', env('OG_IMAGE'), array('id' => 'OG_IMAGE', 'class' => 'form-control', 'placeholder' => 'example : https://domain.com/logo.png')) !!}
			</div>
			<div class="form-group {{ $errors->has('OG_DESCRIPTION') ? 'has-error' : '' }}">
				<label>DESCRIPTION* :</label>
				{!! Form::textarea('OG_DESCRIPTION', env('OG_DESCRIPTION'), array('id' => 'OG_DESCRIPTION', 'class' => 'form-control', 'placeholder' => 'example : This website is a panel of Ran Online Game. Enjoy and have fun.', 'style' => 'resize:none', 'rows' => '5')) !!}
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