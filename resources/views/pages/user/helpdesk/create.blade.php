@extends('adminlte::page')

@section('title', 'Create New ticket')

@section('content_header')
    <h1>Create New Ticket</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('user/helpdesk/create') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>TITLE :</label>
				{!! Form::text('title', old('title'), [ 'class' => 'form-control', 'placeholder' => 'Enter you concern topic title.' ]) !!}
			</div>
			<div class="form-group">
				<label>DEPARTMENT CATEGORY :</label>
				@php
					$newlist = array();
					$newlist[''] = "SELECT DEPARTMENT CATEGORY";
					$newlist['General Department'] = "General Department";
					$newlist['Sales Department'] = "Sales Department";
					$newlist['Technical Support'] = "Technical Support";
					$newlist['Account Support'] = "Account Support";
				@endphp
				{!! Form::select('category', $newlist, old('category'), [ 'class' => 'form-control' ]) !!}
			</div>
			<div class="form-group">
				<label>MESSAGE :</label>
				{!! Form::textarea('message', old('message'), [ 'class' => 'form-control', 'placeholder' => 'Enter Your message.', 'style' => 'resize:none' ]) !!}
			</div>
			<button class="btn btn-flat btn-danger" type="reset">CLEAR ALL</button>
			<button class="btn btn-flat btn-success" type="submit">SUBMIT</button>
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