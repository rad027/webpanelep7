@extends('adminlte::page')

@section('title', 'Editing ['.$dl->title.'] Download Content')

@section('content_header')
    <h1>Editing [{{ $dl->title }}] Download Content</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/download/'.$dl->id.'/edit') }}" method="post">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', $dl->title, [ 'class' => 'form-control', 'placeholder' => 'Enter download content title.' ]) !!}
			</div>
			<div class="form-group">
				<label>STATUS :</label>
				{!! Form::select('status', [ '' => 'SELECT CONTENT STATUS', '1' => 'VISIBLE', '0' => 'HIDDEN' ], $dl->status, [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group">
				<label>CONTENT :</label>
				{!! Form::textarea('content', $dl->content, [ 'class' => 'form-control', 'id' => 'content' ]) !!}
			</div>
			<a href="{{ url('webtool/download') }}" class="btn btn-danger">CANCEL</a>
			<button class="btn btn-success" type="submit">UPDATE</button>
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