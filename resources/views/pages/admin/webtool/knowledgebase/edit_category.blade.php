@extends('adminlte::page')

@section('title', 'Editing ['.$cat->title.'] Category')

@section('content_header')
    <h1>Editing [{{ $cat->title }}] Category</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form method="post">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', $cat->title, [ 'class' => 'form-control', 'placeholder' => 'Enter title here.' ]) !!}
			</div>
			<a href="{{ url('webtool/knowledgebase/create/category') }}" class="btn btn-flat btn-danger">CANCEL</a>
			<button class=" btn btn-flat btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop