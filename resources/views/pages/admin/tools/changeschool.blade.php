@extends('adminlte::page')

@section('title', 'Change School')

@section('content_header')
    <h1>Change Schools</h1>
@stop

@section('content')
{{-- Change School Currency Setting --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Currency Setting</h3>
	</div>
	<div class="box-body">
		<form action="{{ url('tools/changeschool/currency') }}" method="POST">
			@csrf
			<div class="form-group">
				<label>SELECT DEFAULT CURRENCY :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT A CURRENCY";
				$newlist['VP'] = "VOTE POINTS";
				$newlist['EP'] = "E-POINTS";
				$newlist['GOLD'] = "GOLD";
				@endphp
				{!!Form::select('cs_currency', $newlist, config('app.change_school.currency'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group">
				<label>REQUIRED AMOUNT :</label>
				{!! Form::text('cs_required', config('app.change_school.required_amount'), array('id' => 'cs_required', 'class' => 'form-control', 'placeholder' => 'example : 100')) !!}
			</div>
			<button class="btn btn-success" type="submit">UPDATE</button>
		</form>
	</div>
</div>
{{-- Change School processing --}}
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Character Change School</h3>
	</div>
	<div class="box-body">
		<div class="callout callout-warning">
			<h4>Prerequisites:</h4>
			<p>
				<ul>
					@php
					if(config('app.change_school.currency') == "VP"){
					$msg = number_format(config('app.change_school.required_amount'),2)." VOTE POINTS";
					}else if(config('app.change_school.currency') == "EP"){
					$msg = number_format(config('app.change_school.required_amount'),2)." E-POINTS";
					}else{
					$msg = number_format(config('app.change_school.required_amount'),2)." GOLD POINTS";
					}
					@endphp
					<li>{{ $msg }}</li>
					<li>Remove all your equiped items</li>
				</ul>
			</p>
			<h4>Notice:</h4>
			<p>
				<ul>
					<li>Follow the requirements to avoid item loss.</li>
					<li><img src="{{ url('tools/inventory.png') }}"></li>
				</ul>
			</p>
			
		</div>
		<form action="{{ url('tools/changeschool') }}" method="post">
			@csrf
			<div class="form-group {{ $errors->has('UserNum') ? 'has-error' : '' }}">
				<label>SELECT ACCOUNT : <span class="text-danger errormoto"></span></label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT USER ACCOUNT";
				foreach($users as $user):
					$newlist[$user->UserNum] = $user->UserID;
				endforeach;
				@endphp
				{!!Form::select('UserNum', $newlist, old('UserNum'), ['class' => 'form-control'])!!}
			</div>
			<div class="form-group {{ $errors->has('CharID') ? 'has-error' : '' }}">
				<label>SELECT A CHARACTER :</label>
				<select class="form-control" name="CharID" disabled>
					<option value="">SELECT A CHARACTER</option>
				</select>
			</div>
			<div class="form-group {{ $errors->has('school') ? 'has-error' : '' }}">
				<label>SELECT SCHOOL :</label>
				<select class="form-control" name="school">
					<option value="">SELECT A SCHOOL</option>
					<option value="0">Sacred Gate</option>
					<option value="1">Mystic Peak</option>
					<option value="2">Phoenix</option>
				</select>
			</div>
			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label>PASSWORD :</label>
				<input type="password" name="password" class="form-control" placeholder="Enter your password.">
			</div>
			<button class="btn btn-success" type="submit">CHANGE</button>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
	});
	$('select').select2();
	$('select[name="UserNum"]').change(function(){
		$('span.errormoto').html('Loading...');
		$('select[name="CharID"]').prop('disabled',true).html('<option value="">SELECT A CHARACTER</option>');
        $.ajax({
        	url : '{{ url('tools/reborn/charinfo') }}',
        	type : 'POST',
        	data : { 'UserNum' : $(this).val() },
        	success : function(res){
        		if(res.status !== 0){
					$('select[name="CharID"]').prop('disabled',false).html(res.msg);
					$('span.errormoto').html('');
        		}else{
					$('span.errormoto').html('There is no character that have been made by this user.');
        		}
        	}
        });
	});
});
</script>
@stop