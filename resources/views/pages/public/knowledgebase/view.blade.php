@extends('adminlte::page')

@section('title', 'Knowledge Base - '.$kbn->title)

@section('content_header')
    <h1>Knowledge Base - {{ $kbn->title }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        @include('partials.sidepanel')
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
    	<div class="box">
    		<div class="box-body">
    			{!! $kbn->content !!}
    		</div>
    	</div>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop