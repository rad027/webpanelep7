@extends('adminlte::page')

@section('title', 'Edit ['.$kb->title.'] Knowledge Base')

@section('content_header')
    <h1>Edit [{{ $kb->title }}] Knowledge Base</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form method="post">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', $kb->title, [ 'class' => 'form-control', 'placeholder' => 'Enter title here.' ]) !!}
			</div>
			<div class="form-group">
				<label>CATEGORY :</label>
				@php
					$newlist = array();
					$newlist[''] = "SELECT CATEGORY";
					if($cat->count()):
						foreach($cat->cursor() as $cats):
							$newlist[$cats->id] = $cats->title;
						endforeach;
					endif;
				@endphp
				{!! Form::select('category', $newlist, $kb->category()->first()->id, [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group">
				<label>STATUS : </label>
				@php
					$newlist = array();
					$newlist[''] = "SELECT STATUS";
					$newlist['1'] = "PUBLISHED";
					$newlist['0'] = "UNPUBLISHED";
				@endphp
				{!! Form::select('status', $newlist, $kb->status, [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group">
				<label>CONTENT :</label>
				{!! Form::textarea('content', $kb->content, [ 'class' => 'form-control', 'id' => 'content', 'style' => 'color:#000' ]) !!}
			</div>
			<a href="{{ url('webtool/knowledgebase') }}" class="btn btn-flat btn-danger">CANCEL</a>
			<button class="btn btn-flat btn-success" type="submit">UPDATE</button>
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
    CKEDITOR.replace('content');
    $('select').select2();
  })
</script>
@stop