@extends('adminlte::page')

@section('title', 'Editing ['.$annc->title.'] Announcement')

@section('content_header')
    <h1>Editing [{{ $annc->title }}] Announcement</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/news/'.$annc->id.'/edit') }}" method="post">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', $annc->title, [ 'class' => 'form-control', 'placeholder' => 'Enter Announcement`s Title.' ]) !!}
			</div>
			<div class="form-group">
				<label>CONTENT :</label>
				{!! Form::textarea('content', $annc->content, [ 'class' => 'form-control', 'id' => 'content' ]) !!}
			</div>
			<a href="{{ url('webtool/news') }}" class="btn btn-danger">CANCEL</a>
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
    CKEDITOR.replace('content')
  })
</script>
@stop