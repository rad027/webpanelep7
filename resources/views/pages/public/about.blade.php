@extends('adminlte::page')

@section('title', 'About Us')

@section('content_header')
    <h1>About Us</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3" style="padding: 0px 5px 0px 5px">
        @include('partials.sidepanel')
    </div>
    <div class="col-md-9" style="padding: 0px 5px 0px 5px">
    	<div class="box">
    		<div class="box-body">
    			{!! $about->content !!}
    		</div>
    	</div>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop