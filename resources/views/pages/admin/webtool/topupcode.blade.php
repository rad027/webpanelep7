@extends('adminlte::page')

@section('title', 'Top Up Codes')

@section('content_header')
    <h1>Top Up Codes</h1>
@stop

@section('content')
<div class="box">
	<div class="box-header">
		<h3 class="box-title">GENERATE NEW TOP UP CODE</h3>
	</div>
	<div class="box-body">
		<form action="{{ url('webtool/topupcodes') }}" method="post">
			@csrf
			<div class="form-group">
				<label>FUNCTION :</label>
				@php
				$list = array();
				$list[''] = "SELECT A FUNCTION";
				$list['votepoints'] = "VOTE POINTS CODE";
				$list['epoints'] = "E-POINTS CODE";
				@endphp
				{!! Form::select('function' ,$list, NULL, ['class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				<label>AMOUNT :</label>
				{!! Form::text('amount', old('amount'), array('id' => 'amount', 'class' => 'form-control', 'placeholder' => 'Enter amount value od generated code.')) !!}
			</div>
			<button class="btn btn-success" type="submit">GENERATE!</button>
		</form>
	</div>
</div>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">TOP UP CODES</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>CODE #</th>
					<th>PIN CODE</th>
					<th>FUNCTION</th>
					<th>AMOUNT</th>
					<th>STATUS</th>
					<th>DATE CREATED</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
				@if($topup->count())
				@foreach($topup->get() as $top)
				<tr>
					<td>{{ $top->id }}</td>
					<td>{{ $top->code }}</td>
					<td>{{ $top->pin_code }}</td>
					<td>
						@if($top->function === "votepoints")
						VOTE POINTS
						@else
						E-POINTS
						@endif
					</td>
					<td>{{ number_format($top->amount,2) }}</td>
					<td>
						@if($top->status == 1)
						<span class="label label-success">ACTIVE</span>
						@elseif($top->status == 2)
						<span class="label label-warning">CLAIMED</span>
						@else
						<span class="label label-danger">REVOKED</span>
						@endif
					</td>
					<td>{{ date('F d, Y h:i A',strtotime($top->created_at)) }}</td>
					<td>
						<a href="{{ url('webtool/topupcodes/revoke/'.$top->id) }}" class="btn btn-xs btn-warning" onclick="return confirm('Are you sure you want to revoke this top up code?')">REVOKE</a>
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
		'order' : [[ 0 , 'desc' ]]
	});
});
</script>
@stop