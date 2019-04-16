@extends('adminlte::page')

@section('title', 'Create New Knowledge Base Category')

@section('content_header')
    <h1>Create New Knowledge Base Category</h1>
@stop

@section('content')
<div class="box">
	<div class="box-header">
		<h3 class="box-title">CREATE NEW</h3>
	</div>
	<div class="box-body">
		<form method="post">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', old('title'), [ 'class' => 'form-control', 'placeholder' => 'Enter title here.' ]) !!}
			</div>
			<button class="btn btn-flat btn-success" type="submit">CREATE</button>
		</form>
	</div>
</div>
{{-- LIST --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">LIST</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>TITLE</th>
					<th>CREATED DATE</th>
					<th>ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				@if($cat->count())
				@foreach($cat->cursor() as $cate)
				<tr>
					<td>{{ $cate->id }}</td>
					<td>{{ $cate->title }}</td>
					<td>{{ date('M d, Y h:i a',strtotime($cate->created_at)) }}</td>
					<td>
						<a href="{{ url('webtool/knowledgebase/category/'.$cate->id.'/edit') }}" class="btn btn-flat btn-xs btn-primary">EDIT</a>
						<a href="{{ url('webtool/knowledgebase/category/'.$cate->id.'/delete') }}" class="btn btn-flat btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this?')">DELETE</a>
					</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop