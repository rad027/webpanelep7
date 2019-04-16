@extends('adminlte::page')

@section('title', 'Viewing ['.$dl->title.'] Download Content')

@section('content_header')
    <h1>
    	Viewing [{{ $dl->title }}] Download Content
    	<span class="pull-right">
    		<a href="{{ url('webtool/download/') }}" class="btn btn-xs btn-danger">BACK</a>
    		<a href="{{ url('webtool/download/'.$dl->id.'/edit') }}" class="btn btn-xs btn-primary">EDIT</a>
    	</span>
    </h1>
@stop

@section('content')
<div class="box">
	<div class="box-header">
		<h3 class="box-title">{{ $dl->title }} @if($dl->status == 1) <span class="label label-success">VISIBLE</span> @else <span class="label label-danger">HIDDEN</span> @endif</h3>
	</div>
	<div class="box-body">
		{!! $dl->content !!}
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop