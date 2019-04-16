@extends('adminlte::page')

@section('title', 'Voting System')

@section('content_header')
    <h1>Voting System</h1>
@stop

@section('content')
{{-- ADD NEW VOTING SISTE --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">ADD NEW VOTING SITE</h3>
	</div>
	<div class="box-body">
		<form action="{{ url('webtool/vote/create') }}" method="post">
			@csrf
			<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
				<label>TITLE :</label>
				{!! Form::text('title', old('title'), [ 'class' => 'form-control', 'placeholder' => 'Enter the title of top site link.' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('image_link') ? 'has-error' : '' }}">
				<label>IMAGE LINK :</label>
				{!! Form::text('image_link', old('image_link'), [ 'class' => 'form-control', 'placeholder' => 'Enter the image link of top site.' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
				<label>TOP SITE LINK :</label>
				{!! Form::text('link', old('link'), [ 'class' => 'form-control', 'placeholder' => 'Example : http://www.gtop100.com/topsites/Ran-Online/sitedetails/ZG-5-CLASS-NO-EXTREME-FAIR-GAMEPLAY-93849?vote=1' ]) !!}
			</div>
			<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
				<label>STATUS :</label>
				@php
					$newlist = array();
					$newlist[''] = "SELECT STATUS";
					$newlist['1'] = "TRUE";
					$newlist['0'] = "FALSE";
				@endphp
				{!! Form::select('status', $newlist, old('status'), [ 'class' => 'form-control' ]) !!}
			</div>
			<button class="btn btn-flat btn-success" type="submit">CREATE</button>
		</form>
	</div>
</div>
{{-- TOP SITE LIST --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">REGISTERED TOP SITE FOR VOTING SYSTEM</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>TITLE</th>
					<th>IMAGE</th>
					<th>LINK</th>
					<th>STATUS</th>
					<th>DATE CREATED</th>
					<th>ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				@if($topsites->count())
				@foreach($topsites->cursor() as $ts)
				<tr>
					<td>{{ $ts->id }}</td>
					<td>{{ $ts->title }}</td>
					<td><img src="{{ $ts->image_link }}"></td>
					<td><a href="{{ $ts->link }}" target="_blank">{{ substr($ts->link,0,25) }}...</a></td>
					<td>
						@if($ts->status == 0)
						<span class="label label-danger">NOT VISIBLE</span>
						@else
						<span class="label label-success">VISIBLE</span>
						@endif
					</td>
					<td>{{ date('M d, Y h:i A',strtotime($ts->created_at)) }}</td>
					<td>
						<a href="{{ url('webtool/vote/edit/'.$ts->id) }}" class="btn btn-xs btn-flat btn-primary">EDIT</a>
						<a href="{{ url('webtool/vote/delete/'.$ts->id) }}" class="btn btn-xs btn-flat btn-danger" onclick="return confirm('Are you sure you want to delete this?')">DELETE</a>
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
<script type="text/javascript">
$(document).ready(function(){
	$('select').select2();
	$('table').DataTable({
		'order' : [[ 0,'desc' ]]
	});
});
</script>
@stop