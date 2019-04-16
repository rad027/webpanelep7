@extends('adminlte::page')

@section('title', 'Editing ['.$ts->title.']')

@section('content_header')
    <h1>Editing <b>{{ $ts->title }}</b> </h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/vote/edit/'.$ts->id) }}" method="post">
			@csrf
			<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
				<label>TITLE :</label>
				{!! Form::text('title', $ts->title, [ 'class' => 'form-control', 'placeholder' => 'Enter the title of top site link.' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('image_link') ? 'has-error' : '' }}">
				<label>IMAGE LINK :</label>
				{!! Form::text('image_link', $ts->image_link, [ 'class' => 'form-control', 'placeholder' => 'Enter the image link of top site.' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
				<label>TOP SITE LINK :</label>
				{!! Form::text('link', $ts->link, [ 'class' => 'form-control', 'placeholder' => 'Example : http://www.gtop100.com/topsites/Ran-Online/sitedetails/ZG-5-CLASS-NO-EXTREME-FAIR-GAMEPLAY-93849?vote=1' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
				<label>STATUS :</label>
				@php
					$newlist = array();
					$newlist[''] = "SELECT STATUS";
					$newlist['1'] = "TRUE";
					$newlist['0'] = "FALSE";
				@endphp
				{!! Form::select('status', $newlist, $ts->status, [ 'class' => 'form-control' ]) !!}
			</div>
			<a href="{{ url('webtool/vote') }}" class="btn btn-flat btn-danger">CANCEL</a>
			<button class="btn btn-flat btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$('select').select2();
});
</script>
@stop