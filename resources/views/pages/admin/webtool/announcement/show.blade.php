@extends('adminlte::page')

@section('title', 'Viewing ['.$annc->title.'] Announcement')

@section('content_header')
    <h1>Viewing [{{ $annc->title }}] Announcement</h1>
@stop

@section('content')
<div class="box">
	<div class="box-header">
		<h3 class="box-title">{{ $annc->title }}</h3>
		<span class="pull-right">
			<a href="{{ url('webtool/news') }}" class="btn btn-xs btn-danger">back</a>
			<a href="{{ url('webtool/news/'.$annc->id.'/edit') }}" class="btn btn-xs btn-primary">EDIT</a>
		</span>
	</div>
	<div class="box-body">
		{!! $annc->content !!}
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop