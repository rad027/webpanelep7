@extends('adminlte::page')

@section('title', 'Create New Knowledge Base')

@section('content_header')
    <h1>Create New Knowledge Base</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form method="post">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', old('title'), [ 'class' => 'form-control', 'placeholder' => 'Enter title here.' ]) !!}
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
				{!! Form::select('category', $newlist, old('category'), [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group">
				<label>STATUS : </label>
				@php
					$newlist = array();
					$newlist[''] = "SELECT STATUS";
					$newlist['1'] = "PUBLISHED";
					$newlist['0'] = "UNPUBLISHED";
				@endphp
				{!! Form::select('status', $newlist, old('status'), [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group">
				<label>CONTENT :</label>
				{!! Form::textarea('content', old('content'), [ 'class' => 'form-control', 'id' => 'content', 'style' => 'color:#000' ]) !!}
			</div>
			<button class="btn btn-flat btn-success" type="submit">CREATE</button>
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