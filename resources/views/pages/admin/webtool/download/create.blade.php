@extends('adminlte::page')

@section('title', 'Create Download Content')

@section('content_header')
    <h1>Create Download Content</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/download/create') }}" method="post">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', old('title'), [ 'class' => 'form-control', 'placeholder' => 'Enter download content title.' ]) !!}
			</div>
			<div class="form-group">
				<label>STATUS :</label>
				{!! Form::select('status', [ '' => 'SELECT CONTENT STATUS', '1' => 'VISIBLE', '0' => 'HIDDEN' ], old('status'), [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group">
				<label>CONTENT :</label>
				{!! Form::textarea('content', old('content'), [ 'class' => 'form-control', 'id' => 'content' ]) !!}
			</div>
			<button class="btn btn-success" type="submit">CREATE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript" src="https://adminlte.io/themes/AdminLTE/bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
  	$('select').select2();
    CKEDITOR.replace('content')
  })
</script>
@stop