@extends('adminlte::page')

@section('title', 'Create New Announcement')

@section('content_header')
    <h1>Create New Announcement</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/news/create') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', old('title'), [ 'class' => 'form-control', 'placeholder' => 'Enter Announcement`s Title.' ]) !!}
			</div>
			<div class="form-group">
				<label>CONTENT :</label>
				{!! Form::textarea('content', old('content'), [ 'class' => 'form-control', 'id' => 'content' ]) !!}
			</div>
			<button class="btn btn-success" type="submit">POST</button>
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
    CKEDITOR.replace('content')
  })
</script>
@stop