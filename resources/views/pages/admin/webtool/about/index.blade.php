@extends('adminlte::page')

@section('title', 'About Us Page')

@section('content_header')
    <h1>About Us Page</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/aboutus') }}" method="post">
			@csrf
			<div class="form-group">
				<label>LASTE UPDATE BY :</label>
				<input type="text" class="form-control" value="{{ $last->name }}" disabled>
			</div>
			<div class="form-group">
				<label>PAGE CONTENT :</label>
				{!! Form::textarea('content', $about->content, [ 'class' => 'form-control', 'style' => 'resize:none', 'id' => 'content' ]) !!}
			</div>
			<button class="btn btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
{{-- PREVIEW --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">ABOUT US <span class="label label-warning">PREVIEW</span><span class="label label-primary">LAST UPDATE BY : {{ $last->name }}</span></h3>
	</div>
	<div class="box-body">
		{!! $about->content !!}
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