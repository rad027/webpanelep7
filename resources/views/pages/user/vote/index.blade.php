@extends('adminlte::page')

@section('title', 'Earn Vote Points')

@section('content_header')
    <h1>Earn Vote Points</h1>
@stop

@section('content')
<div class="row">
	@if($topsites->where(['status' => 1])->count())
	@foreach($topsites->where(['status' => 1])->cursor() as $ts)
	<div class="col-md-4">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">{{ $ts->title }}</h3>
			</div>
			<div class="box-body">
				<center>
					<img src="{{ $ts->image_link }}">
				</center>
			</div>
			<div class="box-footer">
				<form action="{{ url('user/vote/'.$ts->id) }}" method="post">
					@csrf
					<button class="btn btn-flat btn-block btn-success" type="submit">VOTE NOW!</button>
				</form>
			</div>
		</div>
	</div>
	@endforeach
	@endif
</div>
@stop

@section('css')

@stop

@section('js')

@stop