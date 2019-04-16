@extends('adminlte::page')

@section('title', 'Insert Points')

@section('content_header')
    <h1>Insert Points</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form action="{{ url('webtool/insertpoints') }}" method="POST">
			@csrf
			<div class="form-group {{ $errors->has('points_type') ? 'has-error' : '' }}">
				<label>POINTS TYPE :</label>
				@php
				$newlist = array();
				$newlist[''] = "SELECT TYPE OF POINTS";
				$newlist['vpoints'] = "VOTE POINTS";
				$newlist['epoints'] = "E-POINTS";
				$newlist['premiumpoints'] = "PREMIUM POINTS(per character)";
				$newlist['in-gamepoints'] = "IN-GAME GOLD(per character)";
				$newlist['zgpoints'] = "ZG POINTS(per character)";
				@endphp
				{!! Form::select('points_type', $newlist, old('points_type'), [ 'class' => 'form-control' ]) !!}
			</div>
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
			<div class="form-group {{ $errors->has('CharID') ? 'has-error' : '' }}" id="selectChar" style="display: none">
				<label>SELECT A CHARACTER :</label>
				<select class="form-control" name="CharID" disabled>
					<option value="">SELECT A CHARACTER</option>
				</select>
			</div>
			<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
				<label>AMOUNT :</label>
				{!! Form::text('amount', old('amount'), [ 'class' => 'form-control', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
			</div>
			<button class="btn btn-success" type="submit">INSERT POINTS</button>
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
	$('select[name="points_type"]').change(function(){
		if($(this).val() == "premiumpoints" || $(this).val() == "in-gamepoints" || $(this).val() == "zgpoints"){
			$('div#selectChar').slideDown();
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
		}else{
			$('div#selectChar').slideUp();
		}
	});
});
</script>
@stop